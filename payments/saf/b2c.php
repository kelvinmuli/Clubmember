<?php
$url = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer T9NLjcDpj2CUSgfJrAIWzSwPtaZCE00I')); //setting custom header


$curl_post_data = array(
  //Fill in the request parameters with valid values
  'InitiatorName' => 'ivickinya',
  'SecurityCredential' => ' ',
  'CommandID' => ' ',
  'Amount' => '10',
  'PartyA' => '000000000',
  'PartyB' => '0727380799',
  'Remarks' => 'Testing',
  'QueueTimeOutURL' => 'http://your_timeout_url',
  'ResultURL' => 'http://your_result_url',
  'Occasion' => ' '
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

echo $curl_response;
?>