<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MoneyApi extends CI_Controller {

    /* ============================
       CONFIG (EDIT THESE)
       ============================ */
    private $env            = 'production'; // sandbox | production
    private $consumerKey    = 'JAfp9HUdLrbR7mcs7r4j2QKOQxfSsDRVPiclYWBBAtNKlQ5p';
    private $consumerSecret = 'sMEkAMNzXkAGKDiQThoDw4jG6ZTrGjj7SWGQCOsQ6MMuh7BKVvEGY8SVOg6BA5KN';
    private $shortCode      = '3020813';   // TILL / PAYBILL-backed shortcode
    private $passKey        = 'a93c024a01f1e9805bc8311ac228571760c16fe814512f823c8cd7dc0d9b91f6';
    private $callbackUrl    = 'https://nmra.clubmember.app/v1/nmra-confirmation-url';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Africa/Nairobi');
    }

    /* ============================
       BASE URL
       ============================ */
    private function baseUrl()
    {
        return ($this->env === 'production')
            ? 'https://api.safaricom.co.ke'
            : 'https://sandbox.safaricom.co.ke';
    }

    /* ============================
       ACCESS TOKEN
       ============================ */
    public function getToken()
    {
        $url = $this->baseUrl().'/oauth/v1/generate?grant_type=client_credentials';
        $credentials = base64_encode($this->consumerKey.':'.$this->consumerSecret);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => ['Authorization: Basic '.$credentials],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $response['access_token'] ?? null;
    }

    /* ============================
       STK PUSH (TILL)
       ============================ */
    public function stk_push()
    {
        // $phone  = $this->input->post('phone');   // 2547XXXXXXXX
        // $amount = (int)$this->input->post('amount');
        $phone  = '0726542690';   // 2547XXXXXXXX
        $amount = '1';

        if (!$phone || !$amount) {
            show_error('Phone and amount required');
        }

        $timestamp = date('YmdHis');
        $password  = base64_encode(
            $this->shortCode .
            $this->passKey .
            $timestamp
        );

        $payload = [
            'BusinessShortCode' => $this->shortCode,
            'Password'          => $password,
            'Timestamp'         => $timestamp,
            'TransactionType'   => 'CustomerBuyGoodsOnline',
            'Amount'            => "$amount",
            'PartyA'            => $phone,
            'PartyB'            => $this->shortCode,
            'PhoneNumber'       => $phone,
            'CallBackURL'       => $this->callbackUrl,
            'AccountReference'  => 'ACC'.time(),
            'TransactionDesc'   => 'Till Payment'
        ];

        $url = $this->baseUrl().'/mpesa/stkpush/v1/processrequest';

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', 'STK ERROR: '.$error);
            show_error($error);
        }

        $res = json_decode($response, true);
        
        $this->db->insert('payment_log', array('log' => $res, 'payment_log_id' => time()));
        // Log initial request
        // if (isset($res['CheckoutRequestID'])) {
        //     $this->db->insert('payment_log', [
        //         'merchant_request_id' => $res['MerchantRequestID'],
        //         'checkout_request_id' => $res['CheckoutRequestID'],
        //         'phone'               => $phone,
        //         'amount'              => $amount,
        //         'status'              => 'PENDING'
        //     ]);
        // }

        echo $response;
    }

    /* ============================
       CALLBACK
       ============================ */
    public function callback()
    {
        $raw = file_get_contents('php://input');
        $this->db->insert('payment_log', array('log' => $raw, 'payment_log_id' => time()));

    }
}
