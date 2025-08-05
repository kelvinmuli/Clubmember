<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpesa extends CI_Controller {


     public function __construct() {
        parent::__construct();

         $this->load->model('ClubModel');
         $this->load->model('LogModel');
         $this->load->model('TransactionModel');


    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {

        // print_r($session_data);
        // exit();

        $postData = $this->input->post();

        $ipayData['jose'] = $this->ipayPost($postData['mobile_no'],$postData['email_address'],$postData['user_id'],$postData['amount']);

        // $headerData['countnewmessages'] = $this->ClubModel->countClubMessages($club_id);

        // print_r($ipayData);
        // exit();

        // $this->load->view('front/templates/header_view',$headerData);
        $this->load->view('mpesa_view', $ipayData);
        // $this->load->view('front/templates/footer_view');

  }

  public function corporate()
    {

        // print_r($session_data);
        // exit();

        $postData = $this->input->post();

        $ipayData['jose'] = $this->ipayPost($postData['mobile_no'],$postData['email_address'],$postData['user_id'],$postData['amount']);

        // $headerData['countnewmessages'] = $this->ClubModel->countClubMessages($club_id);

        // print_r($ipayData);
        // exit();

        // $this->load->view('front/templates/header_view',$headerData);
        $this->load->view('corporate_mpesa_view', $ipayData);
        // $this->load->view('front/templates/footer_view');

  }


    public function ipayPost($mobile_no,$email_address,$user_id="",$amount) {

         $session_data = $this->common->loadSession();

       $fields = array("live"=> "1",
                    "oid"=> time(),
                    "inv"=> "112020102292999",
                    // "ttl"=> "1",
                    "ttl"=> $amount,
                    "tel"=> $mobile_no,
                    "eml"=> $email_address,
                    "vid"=> "zilojo",
                    "curr"=> "KES",
                    "p1"=> "airtel",
                    "p2"=> "020102292999",
                    "p3"=>  $user_id,
                    "p4"=> $user_id,
                    // "cbk"=> $_SERVER["HTTP_HOST"].$_SERVER["other_director"],
                    // "cbk"=> "http://34.66.180.35/nbk_tradefinance/log",
                    "cbk"=> base_url()."/callback",
                    // "lbk"=> "http://dev.zilojo.com/2020/zidii/other_director",
                    "cst"=> "1",
                    "crl"=> "0",
                    "mpesa"=>"1",
                    "airtel"=>"1",
                    "creditcard"=>"1",
                    "equity"=>"1",
                    "pesalink"=>"1",
                    "debitcard"=>"1"
                    );
                $datastring =  $fields['live'].$fields['oid'].$fields['inv'].$fields['ttl'].$fields['tel'].$fields['eml'].$fields['vid'].$fields['curr'].$fields['p1'].$fields['p2'].$fields['p3'].$fields['p4'].$fields['cbk'].$fields['cst'].$fields['crl'];
                $hashkey ="GFDMkKRqK7TVuwWTg22Cv#&u7KdW7X8?";//use "demo" for testing where vid also is set to "demo"
                $generated_hash = hash_hmac('sha1',$datastring , $hashkey);
                $fields['hsh'] = $generated_hash;

       return $fields;


    }


    public function insertIpay()
     {


    $session_data = $this->common->loadSession();
    $stringRequest = json_encode($_REQUEST);

      if (empty($_REQUEST)) {

          $stringRequest = file_get_contents('php://input');
          // $stringRequest = json_decode($json, true);
      }

    $logInsert = array('log' =>$stringRequest);



        $obj = json_decode($stringRequest);

        // print_r($obj);
        // exit();

        if ($obj->channel == 'Credit_Card') {

            $postArr = array(
                'txncd' => $obj->txncd,
                'qwh' => $obj->qwh,
                'afd' => $obj->afd,
                'poi' => $obj->poi,
                'uyt' => $obj->uyt,
                'ifd' => $obj->ifd,
                'agt' => $obj->agt,
                'id' => $obj->id,
                'status' => $obj->status,
                'ivm' => $obj->ivm,
                'mc' => $obj->mc,
                'p1' => $obj->p1,
                'p2' => $obj->p2,
                'p3' => $obj->p3,
                'p4' => $obj->p4,
                'msisdn_id' => $obj->msisdn_id,
                'msisdn_idnum' => $obj->msisdn_idnum,
                'channel' => $obj->channel,
                'tokenid' => $obj->tokenid,
                'tokenemail' => $obj->tokenemail,
                'card_mask' => $obj->card_mask
                );
        }else{

        $postArr = array(
                'txncd' => $obj->txncd,
                'qwh' => $obj->qwh,
                'afd' => $obj->afd,
                'poi' => $obj->poi,
                'uyt' => $obj->uyt,
                'ifd' => $obj->ifd,
                'agt' => $obj->agt,
                'id' => $obj->id,
                'status' => $obj->status,
                'ivm' => $obj->ivm,
                'mc' => $obj->mc,
                'p1' => $obj->p1,
                'p2' => $obj->p2,
                'p3' => $obj->p3,
                'p4' => $obj->p4,
                'msisdn_id' => $obj->msisdn_id,
                'msisdn_idnum' => $obj->msisdn_idnum,
                'channel' => $obj->channel,
                'hsh' => $obj->hsh,
        );


     }



    $this->LogModel->insert($logInsert);
    $this->TransactionModel->insert($postArr);

    // $this->db->update("club_shop_details", array('status' =>'Paid','payment_method' => $obj->channel,'txncd' => $obj->txncd, 'payment_date' => date('Y-m-d H:i:s')),array('item_id' => $obj->p4));

    // redirect('payment-successful');

        print '<section class="panel-form-wrapper">
<div class="panel-sing-in">
    <div class="row">

    <div class="clear">
               <h4 class="Titillium-Regular  capital  left " style="color: green;"> <i class="fa fa-check-circle" aria-hidden="true" style="font-size: 18px; color:green"></i> Your payment has been submitted successfully!
               </h4><br>

                 <label>
                 You will receive a payment receipt on email for confirmation with details of your payment and a link to track the progress. For any question you may have for us. Please use the support link at the bottom of the page.
                 </label>

          <h4 class="Titillium-Regular  capital  left " style="color: #43ac6a;">Thank You.</h4><br>
          </div>

    </div>
  </div>
</section>';

    // $shopData = $this->db->select('*')->from('club_shop_details')->where('item_id', $obj->p4)->get()->row();

    //  $memberData = $this->db->select('*')->from('users')->where('user_id', $shopData->member_userid)->get()->row();

    // $this->send_mail($memberData->email,$memberData->name,$shopData->member,$shopData->shop_id,$shopData->amount,$shopData->payment_method,$shopData->txncd,$shopData->event_name,$shopData->category);
      redirect('welcome');
  }




}

