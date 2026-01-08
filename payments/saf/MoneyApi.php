<?php
    $code = "404";
    $state = "";
    $results = "";
    $error = "";

    class MoneyApi 
    {
    
        public function __construct()
        {  
        }

        public function generateMpesaToken() 
        {
            $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            $credentials = base64_encode($this->keySecret());
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
            // curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $curl_response = curl_exec($curl);

            $json_decode = json_decode($curl_response);
            $access_token = $json_decode->access_token;
            curl_close($curl);
            return $access_token;
        }

        public function generateMpesaTokenB2c() 
        {
            $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            $credentials = base64_encode($this->keySecretB2c());
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
            // curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $curl_response = curl_exec($curl);

            $json_decode = json_decode($curl_response);
            $access_token = $json_decode->access_token;
            curl_close($curl);
            return $access_token;
        }

        public function registerUrl() 
        {
            $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateMpesaToken())); //setting custom header

            $curl_post_data = array(
              //Fill in the request parameters with valid values
              'ShortCode' => $this->shortCode(),
              'ResponseType' => 'Completed',
              'ConfirmationURL' => 'https://mlezie.com/backend/payments/saf/confirmation.php',
              'ValidationURL' => 'https://mlezie.com/backend/payments/saf/validation.php'
            );

            $data_string = json_encode($curl_post_data);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

            $curl_response = curl_exec($curl);
            curl_close($curl);
            return $curl_response;
        }

        public function mpesaC2B($phoneNumber, $amount, $accountNumber) 
        {
            $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateMpesaToken())); //setting custom header

            $curl_post_data = array(
                      //Fill in the request parameters with valid values
                     'ShortCode' => $this->shortCode(),
                     'CommandID' => 'CustomerPayBillOnline',
                     'Amount' => $amount,
                     'Msisdn' => $phoneNumber,
                     'BillRefNumber' => $accountNumber
            );

            $data_string = json_encode($curl_post_data);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            $curl_response = curl_exec($curl);
            curl_close($curl);
            return $curl_response;
        } 

        public function mpesaExpress($accountNumber, $phoneNumber, $billAmount)
        {
            $callBackUrl = 'https://mlezie.com/backend/payments/saf/confirmation.php';
            return $this->mpesaGlobalExpress($callBackUrl, $accountNumber, $phoneNumber, $billAmount);
        }

        public function mpesaGlobalExpress($callBackUrl, $accountNumber, $phoneNumber, $billAmount) 
        {
            $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $curl = curl_init();
            date_default_timezone_set('Africa/Nairobi');
            $curl_post_data = array(
                    'BusinessShortCode' => $this->shortCode(),
                    'Password' => base64_encode($this->combinedData()),
                    'Timestamp' => $this->getDateTime(),
                    'TransactionType' => 'CustomerPayBillOnline',
                    'Amount' => $billAmount,
                    'PartyA' => $phoneNumber,
                    'PartyB' => $this->shortCode(),
                    'PhoneNumber' => $phoneNumber,
                    'CallBackURL' => $callBackUrl,
                    'AccountReference' => $accountNumber,        
                    'TransactionDesc' => 'CustomerPayBillOnline'
            );

            $data_string = json_encode($curl_post_data);
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $data_string,
				CURLOPT_HTTPHEADER => array(
				  'Authorization: Bearer '.$this->generateMpesaToken(),
				  'Content-Type: application/json'
				),
			  ));
			  
			$curl_response = curl_exec($curl);
			curl_close($curl);
            return $curl_response;
        }

        public function mpesaB2c($codePhoneNumber, $billAmount) 
        {
            $callBackUrl = 'https://mlezie.com/backend/payments/saf/confirmation.php';
            $phoneNumber = $codePhoneNumber[0] == '+' ? substr($codePhoneNumber, 1) : $codePhoneNumber;
            return json_encode($this->mpesaB2cGlobal($callBackUrl, $phoneNumber, $billAmount));
        }

        public function triggerMpesaB2c($callBackUrl, $codePhoneNumber, $billAmount) 
        {
            $phoneNumber = $codePhoneNumber[0] == '+' ? substr($codePhoneNumber, 1) : $codePhoneNumber;
            return $this->mpesaB2cGlobal($callBackUrl, $phoneNumber, $billAmount);
        }

        public function mpesaB2cGlobal($callBackUrl, $phoneNumber, $billAmount) 
        {
            $username = 'mlezie.finance';
            $password = 'Qf#Dab#YVfq3';
            $plaintext = $password;            
            $url = 'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateMpesaTokenB2c())); //setting custom header
            date_default_timezone_set('Africa/Nairobi');
            $curl_post_data = array(
                    'InitiatorName' => $username,
                    'SecurityCredential' => $this->mpesaSecurityCredential($plaintext),
                    'CommandID' => 'SalaryPayment',
                    'Amount' => $billAmount,
                    'PartyA' => $this->shortCodeB2c(),
                    'PartyB' => $phoneNumber,
                    'Remarks' => $phoneNumber.' disbursement payment @ '.$billAmount,
                    'QueueTimeOutURL' => $callBackUrl,
                    'ResultURL' => $callBackUrl,   
                    'Occassion' => $phoneNumber.' payload @ '.$billAmount
            );

            $data_string = json_encode($curl_post_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            $curl_response = curl_exec($curl);
            curl_close($curl);
            $jsonPostedString = json_decode($curl_response, true);
            $errorCode = $jsonPostedString['errorCode'];
            if ($errorCode == '500.002.1001' || $errorCode == '401.002.01')
            {
                $code = 401;
                $state = 'failed';
                $info = $jsonPostedString['errorMessage'];
            }
            elseif ($jsonPostedString['Envelope'] != null)
            {
                $code = 404;
                $state = 'failed';
                $envelope = $jsonPostedString['Envelope'];
                $body = $envelope['Body'];
                $fault = $body['Fault'];
                $info = $fault['faultstring'];
            }
            else
            {
                $responseCode = $jsonPostedString['ResponseCode'];
                $code = $responseCode == 0 ? 200 : 401;
                $state = $responseCode == 0 ? 'success' : 'failed';
                $customerMessage = $jsonPostedString['CustomerMessage'];
                $info = $customerMessage == null ? $jsonPostedString['ResponseDescription'] : $customerMessage;
            }
            return array('code' => $code, 'state' => $state, 'error'=> '', 'info' => $info, 'json' => $jsonPostedString, 'user' => array('phone_number'=>$phoneNumber, 'amount'=>$billAmount));
        }

        public function mpesaSecurityCredential($plaintext) 
        {
			$certUrl = "./cert.cer";
        	$keyData = openssl_pkey_get_details(openssl_pkey_get_public(file_get_contents($certUrl)));
            $publicKey = $keyData['key'];
            openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING); 
            return base64_encode($encrypted);
        }

        public function mpesaB2b($accountNumber, $billAmount, $paybill) 
        {
            $commandIdArray = ['BusinessPayBill', 'BusinessBuyGoods', 'DisburseFundsToBusiness', 'BusinessToBusinessTransfer', 'MerchantToMerchantTransfer'];
            $selectCommandId = 4; $commandID = $commandIdArray[0];
			$username = 'mlezie.finance';
            $password = 'Qf#Dab#YVfq3';
            $url = 'https://api.safaricom.co.ke/mpesa/b2b/v1/paymentrequest';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateMpesaTokenB2c())); //setting custom header
            date_default_timezone_set('Africa/Nairobi');
            $curl_post_data = array(
                'Initiator' => $username,
                'SecurityCredential' => $this->mpesaSecurityCredential($password),
                'CommandID' => 'BusinessPayBill',
                'Amount' => $billAmount,
                'PartyA' => $this->shortCodeB2c(),
                'PartyB' => $paybill,
                'SenderIdentifierType' => $selectCommandId,
                'RecieverIdentifierType' => $selectCommandId,       
                'AccountReference' => $accountNumber,
                'Remarks' => $accountNumber.' Business PayBill @ '.$billAmount,
                'QueueTimeOutURL' => 'https://mlezie.com/backend/payments/saf/queue_time_out_url.php',
                'ResultURL' => 'https://mlezie.com/backend/payments/saf/confirmation.php'
            );

            $data_string = json_encode($curl_post_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            $curl_response = curl_exec($curl);
            curl_close($curl);
            return $curl_response;
        }

        public function transactionLog($log)
        {
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://mlezie.com/backend/api/logs',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => $log,
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json',
			    'Cookie: ci_session=4uvptbvq7mk77ejfqed6l3bdlpuu6410'
			  ),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			echo $response;
        } 

        public function depositTransaction($log)
        {
        	$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://mlezie.com/backend/mpesa/log/update/',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => $log,
			  CURLOPT_HTTPHEADER => array(
			    'Cookie: ci_session=1sg6vvi9ll5qbili2a85gf51bj5dgous'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			echo $response;
        }

        public function transactionUpdate($billAmount, $phoneNumber, $transactionId)
        {
        	$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://mlezie.com/backend/mpesa/transaction/update',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => array('amount' => $billAmount,'phone_number' => $phoneNumber,'txn_number' => $transactionId),
			  CURLOPT_HTTPHEADER => array(
			    'Cookie: ci_session=1sg6vvi9ll5qbili2a85gf51bj5dgous'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			echo $response;
        }

        public function shortCode()
        {
            return '4081963';
        }

        public function shortCodeB2c()
        {
            return '3030863';
        }

        public function combinedData()
        {
            return $this->shortCode().$this->passKey().$this->getDateTime();
        }

        public function sandboxCombinedData()
        {
            return $this->sandboxShortCode().$this->sandboxPassKey().$this->getDateTime();
        }

        public function getDateTime()
        {
            $timestamp = time();
            $timezone = 'Africa/Nairobi';
            $dt = new DateTime();
            $dt->setTimezone(new DateTimeZone($timezone));
            $dt->setTimestamp($timestamp);
            return $dt->format('YmdHis');
        }

        public function sandboxShortCode()
        {
            return '174379';//'603079';
        }

        public function shortcodeAndSecurityCredential()
        {
            return base64_decode($this->shortCode().$this->securityCredential());
        }

        public function securityCredential()
        {
            return 'oat6CXS9B4rWEbrr8MJQazCpzG+06BTIRlN7OTOiEsQ9gOdK/QBkurUIAQfebcRPJNp11UWngwszBaEzVlBhVvUHOmCRFn03JpCpoRcYi8eItmxGCNWt6hsv+aYmamV8uaJb9P+o9XBJwte5pl5bcFXs5aUGn97wQFgY+SMmt8SlCMHbhgk0Op3COM6QUeT0C8FtFeybqNojeT8jXlOnkb81z5IPlUzRo+e1DeUNSRiSXHu1n5V3/nsnko3mwO+4muuf7COwHciK9rwZOU4on+nAbpRvlfEIi+eldba1swd7R/Xuwqm8dFve59uQZn4LYbzyTDzCJp94PPPA+ia3MQ==';
        }

        public function securityCredentialB2c()
        {
            return "oat6CXS9B4rWEbrr8MJQazCpzG+06BTIRlN7OTOiEsQ9gOdK/QBkurUIAQfebcRPJNp11UWngwszBaEzVlBhVvUHOmCRFn03JpCpoRcYi8eItmxGCNWt6hsv+aYmamV8uaJb9P+o9XBJwte5pl5bcFXs5aUGn97wQFgY+SMmt8SlCMHbhgk0Op3COM6QUeT0C8FtFeybqNojeT8jXlOnkb81z5IPlUzRo+e1DeUNSRiSXHu1n5V3/nsnko3mwO+4muuf7COwHciK9rwZOU4on+nAbpRvlfEIi+eldba1swd7R/Xuwqm8dFve59uQZn4LYbzyTDzCJp94PPPA+ia3MQ==";
        }

        public function passKey()
        {
            return "cd631038e7ba8b0e958eda981c1ce8257a9be54ddb50262a9e486bd7a5ced6e2";
        }

        public function passKeyB2c()
        {
            return "fe54f073b84c116e4a229901a29ee15e5692ce0443ad9efcf8baf2e62a90e5fe";
        }

        public function sandboxPassKey()
        {
            return "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        }

        public function keySecret()
        {
            return "jHZFyTGGeej9UIqizreDoTfPNN7wdVub:mUH2z2WihpdbaQts";
        }

        public function keySecretB2c()
        {
            return "KF0pLovZwJziW4J4G28wc8ge2NPxKtrc:OMB8xAimIPzWaKYl";
        }

        public function sandboxKeySecret()
        {
            return "gwBGJAFXCWsVY08DcFU2PEyHkPo3AjvJ:ie2Jc7Lsq6UG7lWw";
        }
    };

    $moneyApi = new MoneyApi();
?>
