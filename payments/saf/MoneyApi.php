<?php

// ini_set('display_errors', 1);

    $code = "404";
    $state = "";
    $results = "";
    $error = "";

    class MoneyApi 
    {
    
        function __construct()
        {  
        }

        function sandboxGenerateMpesaToken() 
        {
            $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            $credentials = base64_encode($this->sandboxKeySecret());
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

        function generateMpesaToken() 
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

        function generateMpesaTokenB2c() 
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

        function sandboxRegisterUrl() 
        {
            $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->sandboxGenerateMpesaToken())); //setting custom header

            $curl_post_data = array(
              //Fill in the request parameters with valid values
              'ShortCode' => $this->sandboxShortCode(),
              'ResponseType' => 'Completed',
              'ConfirmationURL' => 'https://zidiitradefinance.nationalbank.co.ke/saf/confirmation.php',
              'ValidationURL' => 'https://zidiitradefinance.nationalbank.co.ke/saf/validation.php'
            );

            $data_string = json_encode($curl_post_data);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

            $curl_response = curl_exec($curl);
            curl_close($curl);
            return $curl_response;
        }

        function registerUrl() 
        {
            $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer '.$this->generateMpesaToken())); //setting custom header


            $curl_post_data = array(
              'ShortCode' => $this->shortCode(),
              'ResponseType' => 'Completed',
              'ConfirmationURL' => 'https://nmra.clubmember.app/v1/confirmationurl',
              'ValidationURL' => 'https://nmra.clubmember.app/v1/validationurl'
            );

            $data_string = json_encode($curl_post_data);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

            $curl_response = curl_exec($curl);
            curl_close($curl);
            return $curl_response;
        }

        function mpesaC2B($phoneNumber, $amount, $accountNumber) 
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

        function mpesaExpress($accountNumber, $phoneNumber, $billAmount)
        {
            $callBackUrl = 'https://nmra.clubmember.app/v1/nmra-confirmation-url';
            return $this->mpesaGlobalExpress($callBackUrl, $accountNumber, $phoneNumber, $billAmount);
        }

        function mpesaGlobalExpress($callBackUrl, $accountNumber, $phoneNumber, $billAmount) 
        {
           	$url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $curl = curl_init();
            date_default_timezone_set('Africa/Nairobi');
            $curl_post_data = array(
				'BusinessShortCode' => $this->shortCode(),
				'Password' => base64_encode($this->combinedData()),
				'Timestamp' => $this->getDateTime(),
				//'TransactionType' => 'CustomerPayBillOnline',
				'TransactionType' => 'CustomerBuyGoodsOnline',
				'Amount' => $billAmount,
				'PartyA' => $phoneNumber,
				// 'PartyB' => $this->shortCode(),
                'PartyB' => '7677895',
				'PhoneNumber' => $phoneNumber,
				'CallBackURL' => $callBackUrl,
				// 'AccountReference' => 'INV'.time(),  
				'TransactionDesc' => $phoneNumber.' payload @ '.$billAmount
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
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => array(
                  'Authorization: Bearer '.$this->generateMpesaToken(),
                  'Content-Type: application/json'
                ),
              ));
              
            $curl_response = curl_exec($curl);
            curl_close($curl);
            return $curl_response;
        }

        function sandboxMpesaB2c($phoneNumber, $billAmount) 
        {
            $url = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->sandboxGenerateMpesaToken())); //setting custom header
            date_default_timezone_set('Africa/Nairobi');
            $curl_post_data = array(
                    'InitiatorName' => 'safaricom.j',
                    'SecurityCredential' => $this->securityCredential(),//$this->sandboxPassKey()
                    'CommandID' => 'SalaryPayment',
                    'Amount' => $billAmount,
                    'PartyA' => $this->sandboxShortCode(),
                    'PartyB' => $phoneNumber,
                    'Remarks' => $phoneNumber.' salary payment @ '.$billAmount,
                    'QueueTimeOutURL' => 'https://tradefinance.zidii.app/saf/queue_time_out_url.php',
                    'ResultURL' => 'https://tradefinance.zidii.app/saf/confirmation.php',        
                    'Occassion' => $phoneNumber.' payload @ '.$billAmount
            );

            $data_string = json_encode($curl_post_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            $curl_response = curl_exec($curl);
            curl_close($curl);
            return $curl_response;
        }

        function mpesaB2c($codePhoneNumber, $billAmount) 
        {
            $callBackUrl = 'https://zidiitradefinance.nationalbank.co.ke/saf/confirmation.php';
            $phoneNumber = $codePhoneNumber[0] == '+' ? substr($codePhoneNumber, 1) : $codePhoneNumber;
            return json_encode($this->mpesaB2cGlobal($callBackUrl, $phoneNumber, $billAmount));
        }

        function triggerMpesaB2c($callBackUrl, $codePhoneNumber, $billAmount) 
        {
            $phoneNumber = $codePhoneNumber[0] == '+' ? substr($codePhoneNumber, 1) : $codePhoneNumber;
            return $this->mpesaB2cGlobal($callBackUrl, $phoneNumber, $billAmount);
        }

        function mpesaB2cGlobal($callBackUrl, $phoneNumber, $billAmount) 
        {
            $username = 'kelvin';
            $password = '0123456789RD';//0123456789CL
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

        function mpesaSecurityCredential($plaintext) 
        {
            $keyData = openssl_pkey_get_details(openssl_pkey_get_public(file_get_contents("./cert.cer")));
            $publicKey = $keyData['key'];
            openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING); 
            return base64_encode($encrypted);
        }

        function sandboxMpesaB2b($accountNumber, $billAmount, $paybill) 
        {
            $url = 'https://sandbox.safaricom.co.ke/mpesa/b2b/v1/paymentrequest';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->sandboxGenerateMpesaToken())); //setting custom header
            date_default_timezone_set('Africa/Nairobi');
            $curl_post_data = array(
                    'Initiator' => 'mychama',
                    'SecurityCredential' => $this->sandboxPassKey(),
                    'CommandID' => 'BusinessPayBill',
                    'Amount' => $billAmount,
                    'PartyA' => $this->sandboxShortCode(),
                    'SenderIdentifier' => $accountNumber,
                    'PartyB' => $paybill,
                    'RecieverIdentifierType' => $paybill,
                    'Remarks' => $phoneNumber.' salary payment @ '.$billAmount,
                    'QueueTimeOutURL' => 'https://tradefinance.zidii.app/saf/queue_time_out_url.php',
                    'ResultURL' => 'https://tradefinance.zidii.app/saf/confirmation.php',        
                    'AccountReference' => $accountNumber
            );

            $data_string = json_encode($curl_post_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            $curl_response = curl_exec($curl);
            curl_close($curl);
            return $curl_response;
        }

        function mpesaB2b($accountNumber, $billAmount, $paybill) 
        {
            $url = 'https://api.safaricom.co.ke/mpesa/b2b/v1/paymentrequest';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateMpesaToken())); //setting custom header
            date_default_timezone_set('Africa/Nairobi');
            $curl_post_data = array(
                    'Initiator' => 'finance',
                    'SecurityCredential' => $this->securityCredential(),
                    'CommandID' => 'BusinessPayBill',
                    'Amount' => $billAmount,
                    'PartyA' => $this->shortCode(),
                    'SenderIdentifier' => $accountNumber,
                    'PartyB' => $paybill,
                    'RecieverIdentifierType' => $paybill,
                    'Remarks' => $phoneNumber.' salary payment @ '.$billAmount,
                    'QueueTimeOutURL' => 'https://zidiitradefinance.nationalbank.co.ke/saf/queue_time_out_url.php',
                    'ResultURL' => 'https://zidiitradefinance.nationalbank.co.ke/saf/confirmation.php',        
                    'AccountReference' => $accountNumber
            );

            $data_string = json_encode($curl_post_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            $curl_response = curl_exec($curl);
            curl_close($curl);
            return $curl_response;
        }

        function transactionLog($log)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://roodito.com/api/logs',
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

        function depositTransaction($log)
        {
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //   CURLOPT_URL => 'https://zidiitradefinance.nationalbank.co.ke/callback',
            //   CURLOPT_RETURNTRANSFER => true,
            //   CURLOPT_ENCODING => '',
            //   CURLOPT_MAXREDIRS => 10,
            //   CURLOPT_TIMEOUT => 0,
            //   CURLOPT_FOLLOWLOCATION => true,
            //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //   CURLOPT_CUSTOMREQUEST => 'POST',
            //   CURLOPT_POSTFIELDS => $log,
            //   CURLOPT_HTTPHEADER => array(
            //     // 'Cookie: ci_session=1sg6vvi9ll5qbili2a85gf51bj5dgous'
            //     'Content-Type: application/json',
            //     'Cookie: ci_session=4uvptbvq7mk77ejfqed6l3bdlpuu6410'
            //   ),
            // ));

            // $response = curl_exec($curl);

            // curl_close($curl);
            // echo $response;



                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://zidiitradefinance.nationalbank.co.ke/callback',
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'POST',
                      CURLOPT_POSTFIELDS => $log,
                      CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                      ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    echo $response."test";

        }



        function transactionUpdate($billAmount, $phoneNumber, $transactionId)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://roodito.com/mpesa/transaction/update',
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

        function shortCode()
        {
            return '3020813';
        }

        function shortCodeB2c()
        {
            return '';
        }

        function combinedData()
        {
            return $this->shortCode().$this->passKey().$this->getDateTime();
        }

        function sandboxCombinedData()
        {
            return $this->sandboxShortCode().$this->sandboxPassKey().$this->getDateTime();
        }

        function getDateTime()
        {
            $timestamp = time();
            $timezone = 'Africa/Nairobi';
            $dt = new DateTime();
            $dt->setTimezone(new DateTimeZone($timezone));
            $dt->setTimestamp($timestamp);
            return $dt->format('Ymdhis');
        }

        function sandboxShortCode()
        {
            return '174379';//'603079';
        }

        function shortcodeAndSecurityCredential()
        {
            return base64_decode($this->shortCode().$this->securityCredential());
        }

        function securityCredential()
        {
            return 'LFCULHSDVK0ozGGICuqrjAKYVxa3XY9/DusTknseJx9mt8EwbTy7rFVEfw86FhWdBLQu6sdkGASevChTdLz0crS863iPDiuRMh/OII8TyssubgaU8QzPsqK4mXeFuYdnuajBbiW02oYR2qMh44bBMgM65bCGY4DwxtVW56rWRyd0RLi8k0le/rtsmYP04mWrtUdC16my/QE18SjF2ltixc1LN6C7f8NsOUY4GbtL+0hpGWUAvB97yTzhJelnR3cufg4D3jw31jMB2p1xX0L8CKpBP/vOQnuPPqsHHVrNu2opS3xI+QS+CDhUXlE/xa168aA7wwgkBQ7ujGbK61LZdw==';
        }

        function securityCredentialB2c()
        {
            return "j4639nM/8CfSKvyWp1GQzC/c98JlE1uZGuakCIIdow2YzXWis5PoMsBMQtUCTbR/sz2DGu0SHpSh9i96JHHOcVsh2CsyjynxAjp7s1aJmcBAL8kXkUiupSPmZyFrxpgqA9zs7erOPwNW0KAmBRKBfJCcXIECT/zPt+r7A3rCDhr1ijNpjpNqGdSJmIWWHXj3I56FisywWhoWhWgh2WsRZ+LG3DAverWNj9Hz/zR0a4p0lRgRATUMsuQ/qpmeSNt7N+Yrbj27RqFcE0CFfnmCfm43IRlbLMrRcaEJ/8x7bRfE35t7bKlaJG36ux65bmDWbW5yoaTqdsn9koMcDpzASQ==";
        }

        function passKey()
        {
            return "a93c024a01f1e9805bc8311ac228571760c16fe814512f823c8cd7dc0d9b91f6";
        }

        function passKeyB2c()
        {
            return "fe54f073b84c116e4a229901a29ee15e5692ce0443ad9efcf8baf2e62a90e5fe";
        }

        function sandboxPassKey()
        {
            return "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        }

        function keySecret()
        {

            return "JAfp9HUdLrbR7mcs7r4j2QKOQxfSsDRVPiclYWBBAtNKlQ5p:sMEkAMNzXkAGKDiQThoDw4jG6ZTrGjj7SWGQCOsQ6MMuh7BKVvEGY8SVOg6BA5KN";

        }

        function keySecretB2c()
        {
            return "tlH3IUIq8zeir3hsvR9Brrg3kyj6NPYA:3GRX1uBq6wesGB77";
        }

        function sandboxKeySecret()
        {
            return "gwBGJAFXCWsVY08DcFU2PEyHkPo3AjvJ:ie2Jc7Lsq6UG7lWw";
        }


    };

    $moneyApi = new MoneyApi();
?>
