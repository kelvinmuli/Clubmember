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
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('subscription');
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$subscriptionData = [];
		if ($session_data['user_type_id'] == GlobalModel::CLUB_ADMIN_TYPE)
		{
			$subscriptionData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.subscription')->where('active', 1)->get()->result();
		}
		elseif ($session_data['user_type_id'] == GlobalModel::MEMBER_TYPE)
		{
			$subscriptionData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.subscription')->where('user_id', $session_data['user_id'])->where('active', 1)->get()->result();
		}
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['subscriptionData'] = $subscriptionData;


		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/subscription_view', $data);
		$this->load->view('admin/templates/footer_view');
	}

	public function addSubscriptionModal()
	{
		$this->common->checkSession(array('dialog'=>1));
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$membershipFeeTypeData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.membership_fee_type')->where('active', 1)->get()->result();
		$currencyData = $this->db->select('*')->from('m_currency')->where('active', 1)->get()->result();
		$userData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('active', 1)->get()->result();
		// subscription_id`, `user_id`, `member_id`, `membership_fee_type_id`, `due_at`, `payment_at`, `currency_id`, `amount

		$modal ='<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add Subscription</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('add-subscription').'" method="POST" enctype="multipart/form-data">	
							<input id="subscription_id" name="subscription_id" type="text" value="'.generate_uuid().'" hidden>
							<input id="customer_db_setting_id" name="customer_db_setting_id" type="text" value="'.$customer_db_setting_id.'" hidden>
							<input id="member_id" name="member_id" type="text" value="'.$session_data['user_id'].'" hidden>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Membership Fee Type</label>
											<select id="membership_fee_type_id" name="membership_fee_type_id" class="form-select btn-pill">
												<option selected disabled>Select Membership Fee Type</option>';
												if (isset($membershipFeeTypeData)): foreach($membershipFeeTypeData as $data):
													$modal .= '<option value="'.$data->membership_fee_type_id.'">'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
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
											<input id="payment_at" name="payment_at" type="date" class="form-control btn-pill" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Currency</label>
											<select id="currency_id" name="currency_id" class="form-select btn-pill">
												<option selected disabled>Select Currency</option>';
												if (isset($currencyData)): foreach($currencyData as $data):
													$modal .= '<option value="'.$data->currency_id.'">'.$data->name.'</option>';
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
											<label class="form-label">Member</label>
											<select id="user_id" name="user_id" class="form-select btn-pill">
												<option selected disabled>Select Member</option>';
												if (isset($userData)): foreach($userData as $data):
													$modal .= '<option value="'.$data->user_id.'">'.$data->full_legal_name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary " data-bs-dismiss="modal">Cancel</a>
								<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add Subscription
								</button>
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
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		unset($postData['customer_db_setting_id']);
		if ($this->db->insert($customerDBSettingRow->database_name.'.subscription', $postData)) {
			$description = 'Subscription added successfully.';
		} else {
			$description = 'Failed to add subscription. Please try again.';
		}
		
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$description));
		redirect('subscription', 'refresh');
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
							<h5 class="modal-title">Add Membership Fee Type</h5>
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
}