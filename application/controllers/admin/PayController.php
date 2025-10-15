<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PayController extends CI_Controller {

    public function __construct() {
        parent::__construct();
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
     * @see https://codeigniter.com/userguide3/general/urls.html
     */
    public function index() 
	{
		
	}


	public function paymentInfoModal($user_id, $universal_id='')
	{
		$this->common->checkSession(array('dialog'=>1));
		$session_data = $this->common->loadSession();

		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$customerRow = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
		$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();
		$membershipFeeTypeRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.membership_fee_type')->where('membership_fee_type_id', $userRow->membership_fee_type_id)->get()->row();
		$paymentHistoryRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->where('user_id', $user_id)->get()->row();//->where('universal_id', $universal_id)

		$modal ='<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Pay</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						
							<div class="modal-body">
								<input type="hidden" name="user_id" value="'.$user_id.'">
								<input type="hidden" name="universal_id" value="'.$universal_id.'">
								<div class="col-sm-8 col-xs-6">
									<h4 class="widget-title">Subscription Details</h4>
									<p><strong>Club Name:</strong> '.$customerRow->full_legal_name.'</p>
									<p><strong>Member Name:</strong> '.$userRow->full_legal_name.'</p>
									<p><strong>Membership Type:</strong> '.$membershipFeeTypeRow->name.'</p>
								</div>
							</div>
							<div class="modal-body">
								<div class="col-sm-4 col-xs-6">
									<h4 class="widget-title">Payment Details:</h4>
									<div class="clearfix">
										<p class="pull-left">Total Due:</p>
										<p class="pull-right">'.get_table('m_currency', 'currency_id', $paymentHistoryRow->currency_id, 'sign').'  '.$paymentHistoryRow->bill_amount.'  </p>
									</div>
								</div>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="category_name">Phone Number: Eg.(254700000000)</label>
											<input type="text" class="form-control remove-sharp" name="phone_no" id="phone_no" value="'.$userRow->phone_number.'">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="category_name">Email Address</label>
											<input type="email" class="form-control" name="email" id="email" value="'.$userRow->email.'">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="category_name">Amount to Pay (Ksh)</label>
											<input class="form-control" name="amount" id="amount" value="'.$paymentHistoryRow->bill_amount.'">
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary" onclick="payModal(\''.$user_id.'\', \''.$paymentHistoryRow->payment_history_id.'\')">Make payment now</button>
							</div>
					</div>
				</div>';
		print_r($modal);
	}

	public function payModal($user_id, $payment_history_id='1760556915749')
	{
		$this->common->checkSession(array('dialog'=>1));
		$session_data = $this->common->loadSession();

		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		// $customerRow = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
		$paymentHistoryRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->where('payment_history_id', $payment_history_id)->get()->row();
		$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();
		$ipayRow = $this->ipayPost($userRow->phone_number,$userRow->email,$paymentHistoryRow->bill_amount, $payment_history_id);
		// $ipayRow = $this->ipayPost('072738079','ivickinya@gmail.com','10', generate_uuid());
		$modal ='<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Pay</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form id="pay-form" method="post" action="'.base_url('pay').'">
							<div class="modal-body">
								<iframe width="100%" height="550" src="https://payments.ipayafrica.com/v3/ke?live='.$ipayRow['live'].'&oid='.$ipayRow['oid'].'&inv='.$ipayRow['inv'].'&ttl='.$ipayRow['ttl'].'&tel='.$ipayRow['tel'].'&eml='.$ipayRow['eml'].'&vid='.$ipayRow['vid'].'&curr='.$ipayRow['curr'].'&p1='.$ipayRow['p1'].'&p2='.$ipayRow['p2'].'&p3='.$ipayRow['p3'].'&p4='.$ipayRow['p4'].'&cbk='.$ipayRow['cbk'].'&cst='.$ipayRow['cst'].'&crl='.$ipayRow['crl'].'&hsh='.$ipayRow['hsh'].'"  allowfullscreen></iframe>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
								<!-- <button type="submit" class="btn btn-primary">Make payment now</button> -->
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function ipayPost($phone_no, $email, $amount, $payment_history_id = "") 
	{
        $session_data = $this->common->loadSession();
       	$fields = array("live"=> "1",
                    "oid"=> time(),
                    "inv"=> "112020102292999",
                    "ttl"=> "1",
                    // "ttl"=> $amount,
                    "tel"=> $phone_no,
                    "eml"=> $email,
                    "vid"=> "kffc",
                    "curr"=> "KES",
                    "p1"=> "airtel",
                    "p2"=> "020102292999",
                    "p3"=>  $session_data['user_id'],
                    "p4"=> $payment_history_id,
                    "cbk"=> base_url('callback'),
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
                $hashkey ="!D#5&@QRBDbvEtk*4JFVrsZXXZRQ7gP4";//use "demo" for testing where vid also is set to "demo"
                $generated_hash = hash_hmac('sha1',$datastring , $hashkey);
                $fields['hsh'] = $generated_hash;
       return $fields;       
    }

	public function insertIpay()
    {
		$stringRequest = json_encode($_REQUEST);
		$obj = json_decode($stringRequest);
        if ($obj->channel == 'Credit_Card') {
			$paymentMethodId = '';
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
        }
		else
		{
			$paymentMethodId = '1700743964240';
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

    $this->db->insert("payment_log", array('payment_log_id'=>generate_uuid(), 'log' =>$stringRequest));
	$paymentHistoryRow = $this->db->select('*')->from("payment_history")->where('payment_history_id', $obj->p4)->get()->row();
    $this->db->update("payment_history", array('payment_state_id'=>'1732371146921', 'payment_method_id'=>$paymentMethodId, 'transaction_code'=>$obj->txncd, 'paid_amount'=>$paymentHistoryRow->bill_amount), array('payment_history_id'=>$obj->p4));

    // redirect('payment-successful');

        // print '<section class="panel-form-wrapper">
		// 			<div class="panel-sing-in">
		// 				<div class="row">

		// 				<div class="clear">
		// 						<h4 class="Titillium-Regular  capital  left " style="color: green;"> <i class="fa fa-check-circle" aria-hidden="true" style="font-size: 18px; color:green"></i> Your payment has been submitted successfully!
		// 						</h4><br>
									
		// 							<label>
		// 							You will receive a payment receipt on email for confirmation with details of your payment and a link to track the progress. For any question you may have for us. Please use the support link at the bottom of the page. 
		// 							</label>

		// 					<h4 class="Titillium-Regular  capital  left " style="color: #43ac6a;">Thank You.</h4><br>     
		// 					</div>     
					
		// 				</div>
		// 			</div>
		// 		</section>';

		// $subscriptionData = $this->db->select('*')->from('club_subscription')->where('subscription_id', $obj->p4)->get()->row();
		//  $memberData = $this->db->select('*')->from('users')->where('user_id', $subscriptionData->member_userid)->get()->row();
		// $this->send_mail($memberData->email,$memberData->name,$subscriptionData->member,$subscriptionData->subscription_id,$subscriptionData->amount,$subscriptionData->membership_fee_type,$subscriptionData->payment_method,$subscriptionData->txncd);
		
	}
}
