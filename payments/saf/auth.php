<?php
   $requestMethod = $_SERVER['REQUEST_METHOD'];
   if($requestMethod != "POST") 
   {
      $code = 401;
      $state = 'forbidden';
      http_response_code($code);
      header('Accept: application/json');      
      header('Content-Type: HTTP/1.1 '.$code.' '.$state);
      print_r(json_encode(array('code' => $code, 'state' => $state, 'error'=> 'forbidden to use '.$requestMethod, 'info' => '')));
      exit();
   }
   else
   {  
      header('Content-Type: application/json');
      $fileGetContents = file_get_contents("php://input");
      $jsonPostedString = json_decode($fileGetContents, true);
      $accessType = $jsonPostedString == null ? $_REQUEST['accessType'] : $jsonPostedString['accessType'];
      $username = $jsonPostedString == null ? $_REQUEST['username'] : $jsonPostedString['username'];
      $phoneNumber = $jsonPostedString == null ? $_REQUEST['phoneNumber'] : $jsonPostedString['phoneNumber'];
      $jsonOrArray = $jsonPostedString['jsonOrArray'] == null ? true : $jsonPostedString['jsonOrArray'];      
      $message = $jsonPostedString == null ? $_REQUEST['message'] : $jsonPostedString['message'];
      $billAmount = $jsonPostedString == null ? $_REQUEST['billAmount'] : $jsonPostedString['billAmount'];
      $accountNumber = $jsonPostedString['accountNumber'] == null ? $_REQUEST['accountNumber'] : $jsonPostedString['accountNumber'];

      include_once('MoneyApi.php');
      $moneyApi = new MoneyApi();
      $paybill = $jsonPostedString == null ? $_REQUEST['paybill'] : $jsonPostedString['paybill'];
      $transactionId = $jsonPostedString['transactionId'];
      switch ($accessType) 
      {
         case 'token':
            // print_r($moneyApi->sandboxGenerateMpesaToken());
            print_r($moneyApi->generateMpesaToken());
            break;

         case 'token_b2c':
            print_r($moneyApi->generateMpesaTokenB2c());
            break;

         case 'url':
            print_r($moneyApi->registerUrl());
            break;

         case 'express':
            $mpesaExpressed = $moneyApi->mpesaExpress($accountNumber, $phoneNumber, $billAmount);
            $jsonDecodeString = json_decode($mpesaExpressed, true);
            $responseCode = $jsonDecodeString['ResponseCode'];
            if ($responseCode == null)
            {
               $responseCode = $jsonDecodeString['errorCode'];
               $code = $responseCode == 0 ? 200 : 401;
               $state = $responseCode == 0 ? 'success' : 'failed';
               $info = $jsonDecodeString['errorMessage'];
            }
            else
            {
               $code = $responseCode == 0 ? 200 : 401;
               $state = $responseCode == 0 ? 'success' : 'failed';
               $info = $jsonDecodeString['CustomerMessage'];
            }
            print_r(json_encode(array('code' => $code, 'state' => $state, 'error'=> '', 'info' => $info, 'other' => $jsonDecodeString)));
            break;

         case 'c2b':
            print_r($moneyApi->sandboxMpesaC2b());
            break;

         case 'b2c':
            print_r($moneyApi->mpesaB2c($phoneNumber, $billAmount));//($phoneNumber, $billAmount));
            break;

         case 'b2c_global':
            $callBackUrl = 'https://mlezie.com/backend/payments/saf/confirmation.php';
            $callBack = $jsonPostedString['callBackUrl'] == null ? $callBackUrl : $jsonPostedString['callBackUrl'];
            print_r($moneyApi->mpesaB2cGlobal($callBack, $phoneNumber, $billAmount));
            break;

         case 'msc':
            print_r($moneyApi->mpesaSecurityCredential($username));
            break;

         case 'reverse':
            print_r($moneyApi->mpesaReverseTransaction($transactionId, $billAmount));
            break;

         case 'b2b':
            print_r($moneyApi->mpesaB2b($accountNumber, $billAmount, $paybill));
            break;

         default:
            $code = 401;
            $state = 'failed';
            http_response_code($code);
            header('Content-Type: HTTP/1.1 '.$code.' '.$state);
            print_r(json_encode(array('code' => $code, 'state' => $state, 'error'=> 'accessType is missing', 'info' => '')));
            break;
      }
   }
?>
