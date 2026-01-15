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

      $getParam = function ($key, $default = null) use ($jsonPostedString) {
         if (is_array($jsonPostedString) && array_key_exists($key, $jsonPostedString)) {
            return $jsonPostedString[$key];
         }
         return $_REQUEST[$key] ?? $default;
      };

      $accessType = $getParam('accessType');
      $username = $getParam('username');
      $phoneNumber = $getParam('phoneNumber');
      $jsonOrArray = $getParam('jsonOrArray', true);
      $message = $getParam('message');
      $billAmount = $getParam('billAmount');
      $accountNumber = $getParam('accountNumber');
      $checkoutRequestId = $getParam('checkoutRequestId');

      include_once('MoneyApi.php');
      $moneyApi = new MoneyApi();
      $paybill = $getParam('paybill');
      $transactionId = $getParam('transactionId');
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
            $responseCode = $jsonDecodeString['ResponseCode'] ?? null;
            if ($responseCode == null)
            {
               $responseCode = $jsonDecodeString['errorCode'] ?? null;
               $code = $responseCode == 0 ? 200 : 401;
               $state = $responseCode == 0 ? 'success' : 'failed';
               $info = $jsonDecodeString['errorMessage'] ?? null;
            }
            else
            {
               $code = $responseCode == 0 ? 200 : 401;
               $state = $responseCode == 0 ? 'success' : 'failed';
               $info = $jsonDecodeString['CustomerMessage'] ?? null;
            }
            print_r(json_encode(array('code' => $code, 'state' => $state, 'error'=> '', 'info' => $info, 'other' => $jsonDecodeString)));
            break;

         case 'express_till':
            $mpesaExpressed = $moneyApi->mpesaTillExpress($accountNumber, $phoneNumber, $billAmount);
            $jsonDecodeString = json_decode($mpesaExpressed, true);
            $responseCode = $jsonDecodeString['ResponseCode'] ?? null;
            if ($responseCode == null)
            {
               $responseCode = $jsonDecodeString['errorCode'] ?? null;
               $code = $responseCode == 0 ? 200 : 401;
               $state = $responseCode == 0 ? 'success' : 'failed';
               $info = $jsonDecodeString['errorMessage'] ?? null;
            }
            else
            {
               $code = $responseCode == 0 ? 200 : 401;
               $state = $responseCode == 0 ? 'success' : 'failed';
               $info = $jsonDecodeString['CustomerMessage'] ?? null;
            }
            print_r(json_encode(array('code' => $code, 'state' => $state, 'error'=> '', 'info' => $info, 'other' => $jsonDecodeString)));
            break;

         case 'express_paybill':
            $mpesaExpressed = $moneyApi->mpesaPaybillExpress($accountNumber, $phoneNumber, $billAmount);
            $jsonDecodeString = json_decode($mpesaExpressed, true);
            $responseCode = $jsonDecodeString['ResponseCode'] ?? null;
            if ($responseCode == null)
            {
               $responseCode = $jsonDecodeString['errorCode'] ?? null;
               $code = $responseCode == 0 ? 200 : 401;
               $state = $responseCode == 0 ? 'success' : 'failed';
               $info = $jsonDecodeString['errorMessage'] ?? null;
            }
            else
            {
               $code = $responseCode == 0 ? 200 : 401;
               $state = $responseCode == 0 ? 'success' : 'failed';
               $info = $jsonDecodeString['CustomerMessage'] ?? null;
            }
            print_r(json_encode(array('code' => $code, 'state' => $state, 'error'=> '', 'info' => $info, 'other' => $jsonDecodeString)));
            break;

         case 'express_query':
            if ($checkoutRequestId == null || $checkoutRequestId === '') {
               $code = 400;
               $state = 'failed';
               print_r(json_encode(array('code' => $code, 'state' => $state, 'error'=> 'missing checkoutRequestId', 'info' => '')));
               break;
            }
            $queryResponse = $moneyApi->mpesaStkQuery($checkoutRequestId);
            $jsonDecodeString = json_decode($queryResponse, true);
            $responseCode = $jsonDecodeString['ResponseCode'] ?? null;
            $code = $responseCode === '0' ? 200 : 401;
            $state = $responseCode === '0' ? 'success' : 'failed';
            $info = $jsonDecodeString['ResultDesc'] ?? ($jsonDecodeString['errorMessage'] ?? null);
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
            $callBack = $getParam('callBackUrl', $callBackUrl);
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
