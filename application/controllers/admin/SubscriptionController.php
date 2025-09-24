<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubscriptionController extends CI_Controller {

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
		$this->subscriptionView();
	}

	public function subscriptionView($payment_status_id='1732351802222') 
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('subscription');
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		if ($session_data['user_type_id'] == GlobalModel::CLUB_ADMIN_TYPE)
		{
			$subscriptionData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.subscription s')->join($customerDBSettingRow->database_name.'.payment_history ph', 's.subscription_id=ph.universal_id', 'left')->where('ph.payment_status_id', $payment_status_id)->where('s.active', 1)->get()->result();
			
		}
		elseif ($session_data['user_type_id'] == GlobalModel::MEMBER_TYPE)
		{
			$subscriptionData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.subscription s')->join($customerDBSettingRow->database_name.'.payment_history ph', 's.subscription_id=ph.universal_id', 'left')->where('s.user_id', $session_data['user_id'])->where('ph.payment_status_id', $payment_status_id)->where('s.active', 1)->get()->result();
		}
		
		$data['paymentStatusId'] = $payment_status_id;
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['subscriptionData'] = $subscriptionData ?? [];
		// print_r(json_encode($data['subscriptionData']));
		// exit;

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/subscription_view', $data);
		$this->load->view('admin/templates/footer_view');
	}

	public function addSubscriptionModal($payment_status_id='1732351802222')
	{
		$this->addSubscriptionApproveModal($payment_status_id);
	}

	public function subscriptionApprovalModal($user_id, $membership_type_id, $customer_db_setting_id, $header='all-user')
	{
		$this->addSubscriptionApproveModal('', $user_id, $membership_type_id, $customer_db_setting_id, $header);
	}

	public function addSubscriptionApproveModal($payment_status_id='', $user_id='', $membership_type_id='', $customer_db_setting_id='', $header='all-user')
	{
		$this->common->checkSession(array('dialog'=>1));
		$session_data = $this->common->loadSession();
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', empty($customer_db_setting_id) ? $session_data['customer_db_setting_id'] : $customer_db_setting_id)->get()->row();
		$membershipFeeTypeRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.membership_fee_type')->where('membership_type_id', $membership_type_id)->get()->row();
		$membershipFeeTypeData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.membership_fee_type')->where('active', 1)->get()->result();
		$currencyData = $this->db->select('*')->from('m_currency')->where('active', 1)->get()->result();
		$userData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->get()->result();
		$activeData = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();

		$modal ='<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">';
							if (!empty($payment_status_id)):
								$modal .= '<h5 class="modal-title">Add Subscription</h5>';
							else:
								$modal .= '<h5 class="modal-title">Approve Membership & Add Subscription</h5>';
							endif;
							$modal .= '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('add-subscription').'" method="POST" enctype="multipart/form-data">	
							<input id="subscription_id" name="subscription_id" type="text" value="'.generate_uuid().'" hidden>
							<input id="customer_db_setting_id" name="customer_db_setting_id" type="text" value="'.$customer_db_setting_id.'" hidden>
							<input id="member_id" name="member_id" type="text" value="'.$session_data['user_id'].'" hidden>
							<input id="payment_status_id" name="payment_status_id" type="text" value="'.$payment_status_id.'" hidden>
							<input id="membership_type_id" name="membership_type_id" type="text" value="'.$membership_type_id.'" hidden>
							<input id="header" name="header" type="text" value="'.$header.'" hidden>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Member</label>
											<select id="user_id" name="user_id" class="form-select btn-pill">
												<option selected disabled>Select Member</option>';
												if (isset($userData)): foreach($userData as $data):
													$selected = $data->user_id == $user_id ? 'selected' : '';
													$modal .= '<option value="'.$data->user_id.'" '.$selected.'>'.$data->full_legal_name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Membership Type</label>
											<select id="membership_fee_type_id" name="membership_fee_type_id" class="form-select btn-pill">
												<option selected disabled>Select Membership Type</option>';
												if (isset($membershipFeeTypeData)): foreach($membershipFeeTypeData as $data):
													$selected = $data->membership_fee_type_id == (!empty($membershipFeeTypeRow) ? $membershipFeeTypeRow->membership_fee_type_id : '') ? 'selected' : '';
													$modal .= '<option value="'.$data->membership_fee_type_id.'" '.$selected.'>'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Currency</label>
											<select id="currency_id" name="currency_id" class="form-select btn-pill">
												<option selected disabled>Select Currency</option>';
												if (isset($currencyData)): foreach($currencyData as $data):
													$selected = $data->currency_id == (!empty($membershipFeeTypeRow) ? $membershipFeeTypeRow->currency_id : '') ? 'selected' : '';
													$modal .= '<option value="'.$data->currency_id.'" '.$selected.'>'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="amount" class="form-label">Amount</label>
											<input id="amount" name="amount" type="number" class="form-control btn-pill" value="'.($membershipFeeTypeRow->amount ?? '').'" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="year" class="form-label">Year</label>
											<input id="year" name="year" type="number" class="form-control btn-pill" value="'.($membershipFeeTypeRow->year ?? '').'"  required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="due_at" class="form-label">Start Date</label>
											<input id="start_at" name="start_at" type="date" class="form-control btn-pill" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="due_at" class="form-label">Due Date</label>
											<input id="due_at" name="due_at" type="date" class="form-control btn-pill" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="payment_at" class="form-label">Payment Date</label>
											<input id="payment_at" name="payment_at" type="date" class="form-control btn-pill">
										</div>
									</div>
									<div class="col-lg-12">
									    <div class="mb-3">
									        <label for="payment_at" class="form-label">Notes</label>
									        <textarea id="remark" name="remark" class="form-control" rows="3"></textarea>
									    </div>
									</div>';
									if (empty($payment_status_id)):
										$modal .= '<div class="col-lg-6">
											<div class="mb-3">
												<label class="form-label">Approval</label>
												<select id="active" name="active" class="form-select btn-pill">
													<option selected disabled>Select Approval</option>';
													if (isset($activeData)): foreach($activeData as $data):
														$modal .= '<option value="'.$data->num.'">'.$data->name_two.'</option>';
													endforeach; endif;
												$modal .= '</select>
											</div>
										</div>';
									endif;
								$modal .= '</div>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary " data-bs-dismiss="modal">Cancel</a>
								<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>';
									if (!empty($payment_status_id)):
										$modal .= 'Add Subscription';
									else:
										$modal .= 'Approve Membership & Add Subscription';
									endif;
								$modal .= '</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function addSubscription()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$postData = $this->input->post();
		$customer_db_setting_id = $postData['customer_db_setting_id'];
		$user_id = $postData['user_id'];
		$payment_status_id = $postData['payment_status_id'];
		$membership_type_id = $postData['membership_type_id'];
		$header = $postData['header'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		unset($postData['customer_db_setting_id'], $postData['payment_status_id'], $postData['year'], $postData['membership_type_id'], $postData['header']);
		if ($this->db->insert($customerDBSettingRow->database_name.'.subscription', $postData)) 
		{
			$this->db->insert($customerDBSettingRow->database_name.'.payment_history', array('payment_history_id'=>generate_uuid(), 'user_id'=>$postData['user_id'], 'customer_id'=>$customerDBSettingRow->customer_id, 'bill_amount'=>$postData['amount'], 'currency_id'=>$postData['currency_id'], 'module_id'=>'17072386410', 'universal_id'=>$postData['subscription_id'], 'payment_status_id'=>$payment_status_id));
			if (!empty($user_id) && $postData['active'] == 1) 
			{
				$description = 'Subscription added & approved successfully.';
				$this->db->update($customerDBSettingRow->database_name.'.user', array('active'=>1), array('user_id'=>$postData['user_id']));
				$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();
				$customerRow = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
				$html = $this->load->view('admin/club_member_temp', array('full_legal_name'=>$userRow->full_legal_name, 'club_name'=>$customerRow->full_legal_name, 'url'=>base_url('reset/'.$userRow->user_id.'/'.$customer_db_setting_id)), true);
				$this->common->sendMail($userRow->email, 'Approval Notification', $html);
			}
			else
			{
				$description = 'Subscription added successfully.';
			}
		} else {
			$description = 'Failed to add subscription. Please try again.';
		}
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$description));

		$route = '';
		if ($header == 'subscription') {
			$route = $header.'/'.$payment_status_id;
		} elseif ($header == 'all-user') {
			$route = $header.'/'.$payment_status_id;
		} elseif ($header == 'member') {
			$route = $header.'/'.$membership_type_id.'1';
		} else {
			$route = 'dashboard';
		}
		redirect($route, 'refresh');
	}

	//membership_fee_type_id`, `membership_type_id`, `name`, `amount`, `currency_id`, `year`
	public function addMembershipFeeTypeModal()
	{
		$this->common->checkSession(array('dialog'=>1));
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		$membershipTypeData = $this->db->select('*')->from('m_membership_type')->where('active', 1)->get()->result();
		$currencyData = $this->db->select('*')->from('m_currency')->where('active', 1)->get()->result();

		$modal ='<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add Subscription Fee for Year</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('add-membership-fee-type').'" method="POST" enctype="multipart/form-data">	
							<input id="membership_fee_type_id" name="membership_fee_type_id" type="text" value="'.generate_uuid().'" hidden>
							<input id="customer_db_setting_id" name="customer_db_setting_id" type="text" value="'.$customer_db_setting_id.'" hidden>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Membership Type</label>
											<select id="membership_type_id" name="membership_type_id" class="form-select btn-pill">
												<option selected disabled>Select Membership Type</option>';
												if (isset($membershipTypeData)): foreach($membershipTypeData as $membershipType):
													$modal .= '<option value="'.$membershipType->membership_type_id.'">'.$membershipType->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="name" class="form-label">Name</label>
											<input id="name" name="name" type="text" class="form-control btn-pill" required>
										</div>
									</div>
										<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Currency</label>
											<select id="currency_id" name="currency_id" class="form-select btn-pill">
												<option selected disabled>Select Currency</option>';
												if (isset($currencyData)): foreach($currencyData as $currency):
													$modal .= '<option value="'.$currency->currency_id.'">'.$currency->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="amount" class="form-label">Amount</label>
											<input id="amount" name="amount" type="number" class="form-control btn-pill" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="year" class="form-label">Year</label>
											<input id="year" name="year" type="number" class="form-control btn-pill" required>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary " data-bs-dismiss="modal">Cancel</a>
								<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add Membership Fee Type
								</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function addMembershipFeeType()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$postData = $this->input->post();
		$customer_db_setting_id = $postData['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		unset($postData['customer_db_setting_id']);
		if ($this->db->insert($customerDBSettingRow->database_name.'.membership_fee_type', $postData)) {
			$description = 'Membership Fee Type added successfully.';
		} else {
			$description = 'Failed to add membership fee type. Please try again.';
		}
		
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$description));
		redirect('subscription', 'refresh');
	}

	public function getMembershipFeeType($membership_fee_type_id)
	{
		$membershipFeeType = $this->db->select('*')->from('membership_fee_type')->where('membership_fee_type_id', $membership_fee_type_id)->get()->row();
		print_r(json_encode($membershipFeeType));
	}

	public function approveSubscriptionModal($subscription_id, $payment_history_id)
	{
		$this->common->checkSession(array('dialog'=>1));

		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$subscriptionRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.subscription')->where('subscription_id', $subscription_id)->get()->row();
		$paymentHistoryRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->where('payment_history_id', $payment_history_id)->get()->row();
		$paymentMethodData = $this->db->select('*')->from('m_payment_method')->where('active', 1)->get()->result();
		$paymentStatusData = $this->db->select('*')->from('m_payment_status')->where('active', 1)->get()->result();

		$modal ='<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Approve Subscription</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('approve-subscription').'" method="POST" enctype="multipart/form-data">	
							<input id="subscription_id" name="subscription_id" type="text" value="'.$subscriptionRow->subscription_id.'" hidden>
							<input id="payment_history_id" name="payment_history_id" type="text" value="'.$paymentHistoryRow->payment_history_id.'" hidden>
							<input id="customer_db_setting_id" name="customer_db_setting_id" type="text" value="'.$customer_db_setting_id.'" hidden>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="Amount" class="form-label">Amount</label>
											<input id="paid_amount" name="paid_amount" type="number" class="form-control btn-pill" value="'.$subscriptionRow->amount.'" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="transaction_code" class="form-label">Transaction Code</label>
											<input id="transaction_code" name="transaction_code" type="text" class="form-control btn-pill" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="payment_method_id" class="form-label">Payment Method</label>
											<select id="payment_method_id" name="payment_method_id" class="form-select btn-pill" required>
												<option selected disabled>Select Payment Method</option>';
												if (isset($paymentMethodData)): foreach($paymentMethodData as $data):
													$modal .= '<option value="'.$data->payment_method_id.'">'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="payment_at" class="form-label">Payment Date</label>
											<input id="payment_at" name="payment_at" type="date" class="form-control btn-pill" value="'.date('Y-m-d').'" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="payment_status_id" class="form-label">Payment Status</label>
											<select id="payment_status_id" name="payment_status_id" class="form-select btn-pill" required>
												<option selected disabled>Select Payment Status</option>';
												if (isset($paymentStatusData)): foreach($paymentStatusData as $data):
													$modal .= '<option value="'.$data->payment_status_id.'">'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-12">
									    <div class="mb-3">
									        <label for="payment_at" class="form-label">Notes</label>
									        <textarea id="remark" name="remark" class="form-control" rows="3"></textarea>
									    </div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary " data-bs-dismiss="modal">Cancel</a>
								<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Approve Subscription
								</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function approveSubscription()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$postData = $this->input->post();
		$customer_db_setting_id = $postData['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$subcription_id = $postData['subscription_id'];
		$payment_history_id = $postData['payment_history_id'];
		if ($this->db->update($customerDBSettingRow->database_name.'.payment_history', array('transaction_code'=>$postData['transaction_code'], 'paid_amount'=>$postData['paid_amount'], 'payment_method_id'=>$postData['payment_method_id'], 'payment_status_id'=>$postData['payment_status_id'], 'remark'=>$postData['remark']), array('payment_history_id'=>$payment_history_id))) {
			$this->db->update($customerDBSettingRow->database_name.'.subscription', array('payment_at'=>$postData['payment_at']), array('subscription_id'=>$subcription_id));
			$description = 'Subscription approved successfully.';
		} else {
			$description = 'Failed to approve subscription. Please try again.';
		}
		
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$customer_db_setting_id.' : '.$subcription_id.' : '.$payment_history_id.' - '.$description));
		redirect('subscription', 'refresh');
	}

	public function sendPaymentReminder($subscription_id, $payment_history_id)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$postData = $this->input->post();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$subscriptionRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.subscription')->where('subscription_id', $subscription_id)->get()->row();
		$paymentHistoryRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->where('payment_history_id', $payment_history_id)->get()->row();
		$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $subscriptionRow->user_id)->get()->row();

		// Send Email
		$this->load->library('email');
		$this->email->set_newline("\r\n");
		$this->email->from('no-reply@example.com', 'Club Member');
		$this->email->to($userRow->email);
		$this->email->subject('Payment Reminder');
		$this->email->message('This is a reminder to make your payment for the subscription.');

		if ($this->email->send()) {
			echo 'success';
		} else {
			echo 'error';
		}
		$description = 'Payment reminder sent to '.$userRow->email;
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$customer_db_setting_id.' : '.$subscription_id.' : '.$payment_history_id.' - '.$description));
	}
}
