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


	public function paymentInfoModal($user_id, $payment_history_id='')
	{
		$this->common->checkSession(array('dialog'=>1));
		$session_data = $this->common->loadSession();

		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$customerRow = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
		$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();
		$subscriptionRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.subscription')->where('user_id', $user_id)->get()->row();
		$membershipFeeTypeRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.membership_fee_type')->where('membership_fee_type_id', $subscriptionRow->membership_fee_type_id)->get()->row();
		$paymentHistoryRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->where('payment_history_id', $payment_history_id)->get()->row();

		$modal ='<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Pay</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						<div class="modal-body">
							<input type="hidden" name="user_id" value="'.$user_id.'">
							<input type="hidden" name="universal_id" value="'.$paymentHistoryRow->universal_id.'">
							<div class="col-sm-8 col-xs-6">
								<h4 class="widget-title">Subscription Details</h4>
								<p><strong>Club Name:</strong> '.$customerRow->full_legal_name.'</p>
								<p><strong>Member Name:</strong> '.$userRow->full_legal_name.'</p>
								<p><strong>Membership Type:</strong> '.($membershipFeeTypeRow->name ?? '').'</p>
								<p><strong>Start Date:</strong> '.date('jS M Y', strtotime($subscriptionRow->start_at ?? '')).'</p>
								<p></p><strong>Due Date:</strong> '.date('jS M Y', strtotime($subscriptionRow->due_at)).'</p>
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
										<input type="text" class="form-control remove-sharp" name="phone_no" id="phone_no" value="'.(empty($userRow->phone_number) ? $userRow->mobile_number : $userRow->phone_number).'">
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
							<button type="submit" class="btn btn-primary" onclick="payModal(\''.$user_id.'\', \''.$payment_history_id.'\', document.getElementById(\'phone_no\').value)">Make payment now</button>
						</div>
					</div>
				</div>';
		print_r($modal);
	}

	public function payModal($user_id, $payment_history_id='1760556915749', $phone_no = '', $data='')
	{
		$this->common->checkSession(array('dialog'=>1));
		$session_data = $this->common->loadSession();

		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		// $customerRow = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
		$paymentHistoryRow = null;
		if (!empty($data)) {
			$payment_history_id = generate_uuid();
			$dataExplode = explode('-', $data);
			$universal_id = $dataExplode[0] ?? '';
			$bill_amount = $dataExplode[1] ?? '0';
			$module_id = $dataExplode[2] ?? '';
			$paymentHistoryRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->where('universal_id', $universal_id)->get()->row();
			if (empty($paymentHistoryRow)) {
				$this->db->insert($customerDBSettingRow->database_name.'.payment_history', array(
					'payment_history_id' => $payment_history_id,
					'universal_id' => $universal_id,
					'module_id' => $module_id,
					'customer_id' => $customerDBSettingRow->customer_id,
					'user_id' => $user_id,
					'bill_amount' => $bill_amount,
					'currency_id' => '1700743959986', // KES
					'payment_method_id' => '1700743964240', // M-PESA
					'payment_status_id' => '1700743972533', // Pending
				));
			} else {
				$payment_history_id = $paymentHistoryRow->payment_history_id ?? 'N/A';
				$this->db->where('payment_history_id', $payment_history_id)->update($customerDBSettingRow->database_name.'.payment_history', array(
					'universal_id' => $universal_id,
					'module_id' => $module_id,
					'customer_id' => $customerDBSettingRow->customer_id,
					'user_id' => $user_id,
					'bill_amount' => $bill_amount
				));
			}
		} else {
			$paymentHistoryRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->where('payment_history_id', $payment_history_id)->get()->row();
		}
		$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();
		$customerDBSettingIdPaymentHistoryId = substr($customer_db_setting_id, -7).'C'.substr($payment_history_id, -7);
		$phoneToUse = !empty($phone_no) ? $phone_no : (empty($userRow->phone_number) ? $userRow->mobile_number : $userRow->phone_number);
		$ipayRow = $this->ipayPost($phoneToUse, $userRow->email, $paymentHistoryRow->bill_amount, $customerDBSettingIdPaymentHistoryId);
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
								<section class="panel-form-wrapper" hidden>
									<div class="panel-sing-in">
										<div class="row">
											<div class="clear">
												<h4 class="Titillium-Regular  capital  left " style="color: green;"> <i class="fa fa-check-circle" aria-hidden="true" style="font-size: 18px; color:green"></i> Your payment has been submitted successfully!</h4>
												<br>
												<label> You will receive a payment receipt on email for confirmation with details of your payment and a link to track the progress. For any question you may have for us. Please use the support link at the bottom of the page. </label>
												<h4 class="Titillium-Regular  capital  left " style="color: #43ac6a;">Thank You.</h4><br>     
											</div> 
										</div>
									</div>
								</section>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
								<a href="'.base_url('subscription/1732371146921').'" class="btn btn-primary">Back to subscription</a>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function ipayPost($phone_no, $email, $amount, $customerDBSettingIdPaymentHistoryId = "") 
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
                    "p4"=> $customerDBSettingIdPaymentHistoryId,
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
		// $request  = '{"status":"aei7p7yrx4ae34","txncd":"TJLBX7YV29","msisdn_id":"KELVIN KELVIN","msisdn_idnum":"254726542690","p1":"airtel","p2":"020102292999","p3":"177038753942","p4":"6384290C1421760","uyt":"772938402","agt":"488511650","qwh":"2035065686","ifd":"1052563480","afd":"2107564989","poi":"248393003","id":"1760996212","ivm":"1760996212","mc":"1","channel":"MPESA","vat":"0.0032","commission":"0.020"}';
		// $stringRequest = json_encode($request);
		// $obj = json_decode($request);
		$stringRequest = json_encode($_REQUEST);
		$obj = json_decode($stringRequest);
		$paymentMethodId = '1700743964240'; // Default to M-PESA
		$this->db->insert("payment_log", array('payment_log_id'=>generate_uuid(), 'log' =>$stringRequest));
		$customerDBSettingIdPaymentHistoryId = explode('C', $obj->p4);
		$customerDbSettingId = $customerDBSettingIdPaymentHistoryId[0];
		$paymentHistoryId = $customerDBSettingIdPaymentHistoryId[1];
		$this->db->insert("payment_log", array('payment_log_id'=>generate_uuid(), 'log' =>json_encode($customerDBSettingIdPaymentHistoryId)));
		$this->db->insert("payment_log", array('payment_log_id'=>generate_uuid(), 'log' =>$customerDbSettingId));
		$this->db->insert("payment_log", array('payment_log_id'=>generate_uuid(), 'log' =>$paymentHistoryId));
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->like('customer_db_setting_id', $customerDbSettingId)->get()->row();	
		$paymentHistoryRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->like('payment_history_id', $paymentHistoryId)->get()->row();
		$moduleRow = $this->db->select('*')->from('m_module')->where('module_id', $paymentHistoryRow->module_id)->get()->row();
		$module = 0;
		if ($paymentHistoryRow->module_id == '17072386410') {// Subscription module
			$module = $this->db->update($customerDBSettingRow->database_name.'.subscription', array('payment_at'=>date('d M Y')), array('subscription_id'=>$paymentHistoryRow->universal_id));
		} elseif ($paymentHistoryRow->module_id == '17602075390') {// Fundraising module
			$module = 1;//$this->db->update($customerDBSettingRow->database_name.'.fundraising', array('payment_at'=>date('d M Y')), array('fundraising_id'=>$paymentHistoryRow->universal_id));
		} elseif ($paymentHistoryRow->module_id == '17872306643') {// Booking module
			$module = $this->db->update($customerDBSettingRow->database_name.'.booking', array('payment_at'=>date('d M Y')), array('booking_id'=>$paymentHistoryRow->universal_id));
		}
		
		$payment_history = $this->db->update($customerDBSettingRow->database_name.'.payment_history', array('payment_status_id'=>'1732371146921', 'payment_method_id'=>$paymentMethodId, 'transaction_code'=>$obj->txncd, 'paid_amount'=>$obj->mc), array('payment_history_id'=>$paymentHistoryRow->payment_history_id));
		$this->db->insert("payment_log", array('payment_log_id'=>generate_uuid(), 'log' =>'paymentHistoryRow -> '.json_encode($paymentHistoryRow)));
		$this->db->insert("payment_log", array('payment_log_id'=>generate_uuid(), 'log' =>($moduleRow->name ?? 'Module').' -> '.$module));
		$this->db->insert("payment_log", array('payment_log_id'=>generate_uuid(), 'log' =>'payment_history -> '.$payment_history));
		// $subscriptionData = $this->db->select('*')->from('club_subscription')->where('subscription_id', $obj->p4)->get()->row();
		// $memberData = $this->db->select('*')->from('users')->where('user_id', $subscriptionData->member_userid)->get()->row();
		// $this->send_mail($memberData->email,$memberData->name,$subscriptionData->member,$subscriptionData->subscription_id,$subscriptionData->amount,$subscriptionData->membership_fee_type,$subscriptionData->payment_method,$subscriptionData->txncd);
	}
}
