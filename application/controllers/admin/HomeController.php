<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

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
		$headerData = $this->common->loadHeaderData('dashboard');
		
		$customerData = [];
		if ($session_data['customer_db_setting_id'] == GlobalModel::DEFAULT_CORE_DB_SETTING)
		{
			$customerData = $this->db->select('*')->from('customer')->where('active', 1)->get()->result();
		}
		else
		{
			$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
			$customerData = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->where('active', 1)->get()->result();
			$data['userData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where_in('membership_type_id',array('1755813965588','N/A'))->get()->result();
			$data['corporateData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('membership_type_id','1755816508873')->get()->result();
		}
		$data['customerData'] = $customerData;
		$data['total_customers'] = count($customerData);

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/home_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
	}

	public function overviewCard()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$user_type_id = $session_data['user_type_id'];

		$paymentStatusData = $this->db->select('*')->from('m_payment_status')->where('active', 1)->get()->result();

		$modal ='<div class="col-sm-6 col-lg-3">
					<div class="card card-sm">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col-auto">
									<span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/currency-dollar -->
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
											<path d="M20.925 13.163a8.998 8.998 0 0 0 -8.925 -10.163a9 9 0 0 0 0 18"></path>
											<path d="M9 10h.01"></path>
											<path d="M15 10h.01"></path>
											<path d="M9.5 15c.658 .64 1.56 1 2.5 1s1.842 -.36 2.5 -1"></path>
											<path d="M15 19l2 2l4 -4"></path>
										</svg>
									</span>
								</div>
								<div class="col">
									<div class="font-weight-medium">Welcome back '.$session_data['full_legal_name'].'</div>
								</div>
							</div>
						</div>
					</div>
				</div>';
		
		if (!empty(get_user_right($user_type_id, '17872306643', 'view', 1))): foreach ($paymentStatusData as $paymentStatus):
			$modal .='<div class="col-sm-6 col-lg-3">
						<div class="card card-sm">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-auto">
										<span class="bg-x text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
												<path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9z"></path>
												<path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
											</svg>
										</span>
									</div>
									<div class="col">
										<div class="font-weight-medium">0</div>
										<div class="text-secondary">Total '.$paymentStatus->name.' Bookings</div>
									</div>
								</div>
							</div>
						</div>
					</div>';
		endforeach; endif;

		if (!empty(get_user_right($user_type_id, '17072386410', 'view', 1))): foreach ($paymentStatusData as $paymentStatus):
			$modal .='<div class="col-sm-6 col-lg-3">
						<div class="card card-sm">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-auto">
										<span class="bg-x text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
												<path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9z"></path>
												<path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
											</svg>
										</span>
									</div>
									<div class="col">
										<div class="font-weight-medium">0</div>
										<div class="text-secondary">Total '.$paymentStatus->name.' Subscriptions</div>
									</div>
								</div>
							</div>
						</div>
					</div>';
		endforeach; endif;

		if (!empty(get_user_right($user_type_id, '17092385318', 'view', 1))): foreach ($paymentStatusData as $paymentStatus):
			$modal .='<div class="col-sm-6 col-lg-3">
						<div class="card card-sm">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-auto">
										<span class="bg-x text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
												<path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9z"></path>
												<path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
											</svg>
										</span>
									</div>
									<div class="col">
										<div class="font-weight-medium">0</div>
										<div class="text-secondary">Total '.$paymentStatus->name.' Joining Fees</div>
									</div>
								</div>
							</div>
						</div>
					</div>';
		endforeach; endif;

		if (!empty(get_user_right($user_type_id, '17002375931', 'view', 1))): foreach ($paymentStatusData as $paymentStatus):
			$modal .='<div class="col-sm-6 col-lg-3">
						<div class="card card-sm">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-auto">
										<span class="bg-x text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
												<path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9z"></path>
												<path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
											</svg>
										</span>
									</div>
									<div class="col">
										<div class="font-weight-medium">0</div>
										<div class="text-secondary">Total '.$paymentStatus->name.' Products</div>
									</div>
								</div>
							</div>
						</div>
					</div>';
		endforeach; endif;

		print_r($modal);
	}
}
