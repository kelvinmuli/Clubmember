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
            return $this->mpesaTillGlobalExpress($callBackUrl, $accountNumber, $phoneNumber, $billAmount);
        }

        public function mpesaPaybillExpress($accountNumber, $phoneNumber, $billAmount)
        {
            $callBackUrl = 'https://mlezie.com/backend/payments/saf/confirmation.php';
            return $this->mpesaPaybillGlobalExpress($callBackUrl, $accountNumber, $phoneNumber, $billAmount);
        }

        public function mpesaTillExpress($reference, $phoneNumber, $amount)
        {
            $callBackUrl = 'https://mlezie.com/backend/payments/saf/confirmation.php';
            return $this->mpesaTillGlobalExpress($callBackUrl, $reference, $phoneNumber, $amount);
        }

        public function mpesaGlobalExpress($callBackUrl, $accountNumber, $phoneNumber, $billAmount) 
        {
            return $this->mpesaPaybillGlobalExpress($callBackUrl, $accountNumber, $phoneNumber, $billAmount);
        }

        public function mpesaPaybillGlobalExpress($callBackUrl, $accountNumber, $phoneNumber, $billAmount)
        {
            return $this->mpesaStkPush(
                $this->paybillNumber(),
                $this->paybillPassKey(),
                'CustomerPayBillOnline',
                $callBackUrl,
                $accountNumber,
                $phoneNumber,
                $billAmount,
                $this->paybillNumber(),
                'CustomerPayBillOnline'
            );
        }

        public function mpesaTillGlobalExpress($callBackUrl, $reference, $phoneNumber, $amount)
        {
            return $this->mpesaStkPush(
                $this->tillNumber(),
                $this->tillPassKey(),
                'CustomerPayBillOnline',
                $callBackUrl,
                $reference,
                $phoneNumber,
                $amount,
                $this->tillNumber(),
                'CustomerPayBillOnline'
            );
        }

        private function mpesaStkPush($businessShortCode, $passKey, $transactionType, $callBackUrl, $accountReference, $phoneNumber, $amount, $partyB, $transactionDesc)
        {
            $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $curl = curl_init();
            date_default_timezone_set('Africa/Nairobi');
			// {
			// 	"BusinessShortCode": "123456",
			// 	"Password": "BASE64_ENCODED_PASSWORD",
			// 	"Timestamp": "YYYYMMDDHHMMSS",
			// 	"TransactionType": "CustomerBuyGoodsOnline",
			// 	"Amount": 1000,
			// 	"PartyA": "2547XXXXXXXX",
			// 	"PartyB": "123456",
			// 	"PhoneNumber": "2547XXXXXXXX",
			// 	"CallBackURL": "https://example.com/mpesa/callback",
			// 	"AccountReference": "ORDER123",
			// 	"TransactionDesc": "Payment for Order"
			// }
            $timestamp = $this->getDateTime();
            $msisdn = $this->normalizeMsisdn($phoneNumber);
            $amount = $this->normalizeAmount($amount);
            $password = base64_encode($businessShortCode.$passKey.$timestamp);
            $curl_post_data = array(
                'BusinessShortCode' => $businessShortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => $transactionType,
                'Amount' => $amount,
                'PartyA' => $msisdn,
                'PartyB' => $partyB,
                'PhoneNumber' => $msisdn,
                'CallBackURL' => $callBackUrl,
                'AccountReference' => $accountReference,
                'TransactionDesc' => $transactionDesc
            );

            $data_string = json_encode($curl_post_data);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_TIMEOUT => 60,
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

            if ($curl_response === false) {
                $curlErrNo = curl_errno($curl);
                $curlErr = curl_error($curl);
                curl_close($curl);
                return json_encode(array(
                    'errorCode' => $curlErrNo ?: 'CURL_ERROR',
                    'errorMessage' => $curlErr ?: 'cURL request failed'
                ));
            }
            curl_close($curl);
            return $curl_response;
        }

        public function mpesaStkQuery($checkoutRequestId, $businessShortCode = null, $passKey = null)
        {
            $url = 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query';
            $curl = curl_init();
            date_default_timezone_set('Africa/Nairobi');

            $businessShortCode = $businessShortCode ?? $this->shortCode();
            $passKey = $passKey ?? $this->passKey();
            $timestamp = $this->getDateTime();
            $password = base64_encode($businessShortCode.$passKey.$timestamp);

            $curl_post_data = array(
                'BusinessShortCode' => $businessShortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $checkoutRequestId
            );

            $data_string = json_encode($curl_post_data);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_TIMEOUT => 60,
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
            if ($curl_response === false) {
                $curlErrNo = curl_errno($curl);
                $curlErr = curl_error($curl);
                curl_close($curl);
                return json_encode(array(
                    'errorCode' => $curlErrNo ?: 'CURL_ERROR',
                    'errorMessage' => $curlErr ?: 'cURL request failed'
                ));
            }
            curl_close($curl);
            return $curl_response;
        }

        private function normalizeMsisdn($phoneNumber)
        {
            if ($phoneNumber === null) {
                return '';
            }

            $phoneNumber = trim((string)$phoneNumber);
            if ($phoneNumber === '') {
                return '';
            }

            // Keep digits only (strip spaces, +, etc.)
            $digits = preg_replace('/\D+/', '', $phoneNumber);
            if ($digits === null) {
                $digits = '';
            }

            // Convert common KE formats to 2547XXXXXXXX
            if (strpos($digits, '0') === 0 && strlen($digits) === 10) {
                // 07XXXXXXXX -> 2547XXXXXXXX
                return '254'.substr($digits, 1);
            }

            if (strpos($digits, '7') === 0 && strlen($digits) === 9) {
                // 7XXXXXXXX -> 2547XXXXXXXX
                return '254'.$digits;
            }

            if (strpos($digits, '2540') === 0 && strlen($digits) === 13) {
                // 25407XXXXXXXX -> 2547XXXXXXXX
                return '254'.substr($digits, 4);
            }

            return $digits;
        }

        private function normalizeAmount($amount)
        {
            if (is_string($amount)) {
                $amount = trim($amount);
            }
            $normalized = (int)$amount;
            return $normalized > 0 ? $normalized : 1;
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
            return '3020813';
        }

        public function tillNumber()
        {
            return $this->shortCode();
        }

        public function paybillNumber()
        {
            return $this->shortCode();
        }

        public function shortCodeB2c()
        {
            return '3030863';
        }

        public function combinedData()
        {
            return $this->shortCode().$this->passKey().$this->getDateTime();
        }

        public function tillPassKey()
        {
            return $this->passKey();
        }

        public function paybillPassKey()
        {
            return $this->passKey();
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
            return "a93c024a01f1e9805bc8311ac228571760c16fe814512f823c8cd7dc0d9b91f6";
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
            return "JAfp9HUdLrbR7mcs7r4j2QKOQxfSsDRVPiclYWBBAtNKlQ5p:sMEkAMNzXkAGKDiQThoDw4jG6ZTrGjj7SWGQCOsQ6MMuh7BKVvEGY8SVOg6BA5KN";
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
