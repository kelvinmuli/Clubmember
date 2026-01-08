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
      $accessType = $jsonPostedString == NULL ? $_REQUEST['accessType'] : $jsonPostedString['accessType'];
      $username = $jsonPostedString == NULL ? $_REQUEST['username'] : $jsonPostedString['username'];
      $phoneNumber = $jsonPostedString == NULL ? $_REQUEST['phoneNumber'] : $jsonPostedString['phoneNumber'];
      $jsonOrArray = $jsonPostedString['jsonOrArray'] == NULL ? true : $jsonPostedString['jsonOrArray'];      
      $message = $jsonPostedString == NULL ? $_REQUEST['message'] : $jsonPostedString['message'];
      $billAmount = $jsonPostedString == NULL ? $_REQUEST['billAmount'] : $jsonPostedString['billAmount'];
      $accountNumber = $jsonPostedString['accountNumber'] == NULL ? $_REQUEST['accountNumber'] : $jsonPostedString['accountNumber'];
      $paybill = $jsonPostedString == NULL ? $_REQUEST['paybill'] : $jsonPostedString['paybill'];
      $transactionId = $jsonPostedString['transactionId'];
		// Be sure to include the file you've just downloaded
		require_once('AfricasTalkingGateway.php');
		// Specify your login credentials
		// $username   = "Chamacom";
		// $apikey     = "2124428b296975b757cd7c9fdfa410c458177da9582ab3a8edbaf68d30e28c32";
		$username   = "mlezie";
		$apikey     = "389a440504debda939d70ba1be596ffedcbff55892cccbbf0b7d4d45ed71ed65";
		// NOTE: If connecting to the sandbox, please use your sandbox login credentials
		// Specify the numbers that you want to send to in a comma-separated list
		// Please ensure you include the country code (+254 for Kenya in this case)
		// $recipients = "+254711XXXYYY,+254733YYYZZZ";
		// And of course we want our recipients to know what we really do

		// Create a new instance of our awesome gateway class
		$gateway = new AfricasTalkingGateway($username, $apikey);
		switch ($accessType) 
		{
			case 'send':
				// NOTE: If connecting to the sandbox, please add the sandbox flag to the constructor:
				/*************************************************************************************
									 ****SANDBOX****
				//$gateway    = new AfricasTalkingGateway($username, $apiKey, "sandbox");
				**************************************************************************************/
				// Any gateway error will be captured by our custom Exception class below, 
				// so wrap the call in a try-catch block
				$code = '404'; $state = ''; $error= '';
				$row = array();
				$phoneNumber = $_REQUEST['phoneNumber'];
				$message = $_REQUEST['message'];

				try
				{ 
					// Thats it, hit send and we'll take care of the rest. 
					$smsResults = $gateway->sendMessage($phoneNumber, $message);
					foreach($smsResults as $sms) 
					{
						// status is either "Success" or "error message"
						$row[] = $sms;
						// echo " Number: " .$sms->number;
						// echo " Status: " .$sms->status;
						// echo " MessageId: ".$sms->messageId;
						// echo " Cost: "   .$sms->cost."\n";
					}
					$code = "200";
				}
				catch (AfricasTalkingGatewayException $e)
				{
					$error = $e->getMessage();
				}
				print_r(json_encode(array('code' => $code, 'state' => $state, 'error'=> $error, 'sms' => $row)));
				break;
			
			default:
				$code = 401;
				$state = 'failed';
				http_response_code($code);
				header('Content-Type: HTTP/1.1 '.$code.' '.$state);
				print_r(json_encode(array('code' => $code, 'state' => $state, 'error'=> 'apiType is missing', 'info' => '')));
				break;
		}
   }
?>
