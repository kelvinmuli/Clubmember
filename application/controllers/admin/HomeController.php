<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 * @property CI_Session $session
 * @property Common $common
 */
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
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		// print_r($customerDBSettingRow); exit;
		if ($session_data['customer_db_setting_id'] == GlobalModel::DEFAULT_CORE_DB_SETTING)
		{
			$customerData = $this->db->select('*')->from('customer')->where('active', 1)->get()->result();
			$memberData = $this->db->select('*')->from('user')->where('user_type_id', '1755383886420')->where('active', 1)->get()->result();
			//This year new members
			$memberDataThisYear = $this->db->select('*')->from('user')->where('user_type_id', '1755383886420')->where('active', 1)->where('created_at >=', date('d M Y', strtotime('first day of this year')))->get()->result();
			$userActiveData = $this->db->select('*')->from('user')->where('active', 1)->order_by('created_at', 'DESC')->get()->result();
			$userInactiveData = $this->db->select('*')->from('user')->where('active', 1)->order_by('created_at', 'DESC')->get()->result();
		}
		else
		{
			$customerData = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->where('active', 1)->get()->result();
			$data['membershipTypeData'] = $this->db->select('*')->from('m_membership_type')->where('active',1)->get()->result();
			$userActiveData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('active', 1)->order_by('created_at', 'DESC')->get()->result();
			$userInactiveData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('active', 0)->limit(5)->order_by('created_at', 'DESC')->get()->result();
			$userData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('active', 0)->limit(5)->order_by('created_at', 'DESC')->get()->result();
			$memberData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_type_id', '1755383886420')->where('active', 1)->get()->result();
			//This year new members
			$memberDataThisYear = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_type_id', '1755383886420')->where('active', 1)->where('created_at >=', date('d M Y', strtotime('first day of this year')))->get()->result();
			foreach ($userData as $value) {
				$userArrayData[$value->membership_type_id == 'N/A' ? '1755813965588' : $value->membership_type_id][] = $value;
			}
		}


		$userTableName = ($session_data['customer_db_setting_id'] == GlobalModel::DEFAULT_CORE_DB_SETTING) ? 'user' : $customerDBSettingRow->database_name . '.user';
		$approvedMembersMonthly = $this->buildApprovedMembersMonthlySeries($userTableName);
		if ($session_data['user_type_id'] == GlobalModel::CLUB_ADMIN_TYPE)
		{
			$subscriptionData = $this->db->select('*')
				->from($customerDBSettingRow->database_name.'.subscription s')
				->join($customerDBSettingRow->database_name.'.payment_history ph', 's.subscription_id=ph.universal_id', 'left')
				->where('s.active', 1)
				->limit(3)
				->order_by('s.created_at', 'DESC')
				->order_by('ph.created_at', 'DESC')
				->get()
				->result();
		}
		elseif ($session_data['user_type_id'] == GlobalModel::MEMBER_TYPE)
		{
			$subscriptionData = $this->db->select('*')
				->from($customerDBSettingRow->database_name.'.subscription s')
				->join($customerDBSettingRow->database_name.'.payment_history ph', 's.subscription_id=ph.universal_id', 'left')
				->where('s.user_id', $session_data['user_id'])
				->where('s.active', 1)
				->limit(3)
				->order_by('s.created_at', 'DESC')
				->order_by('ph.created_at', 'DESC')
				->get()
				->result();
		}

		$paidStatusId = $this->getPaidPaymentStatusId();
		$unpaidSubscriptionsMonthly = $this->buildPaidSubscriptionsMonthlySeries($customerDBSettingRow->database_name.'.subscription', $customerDBSettingRow->database_name.'.payment_history', $paidStatusId);
		$paidSubscriptionsMonthly = $this->buildUnpaidSubscriptionsMonthlySeries($customerDBSettingRow->database_name.'.subscription', $customerDBSettingRow->database_name.'.payment_history', $paidStatusId);

		$incidentStatusData = $this->db->from('m_incident_status')->where('active', 1)->get()->result();
		$data['incidentStatusData'] = $incidentStatusData;

		$data['agmMinutesData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.agm_minutes')->where('active', 1)->limit(3)->order_by('created_at', 'DESC')->get()->result();
		$data['auditedAccountData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.audited_account')->where('active', 1)->limit(3)->order_by('created_at', 'DESC')->get()->result();
		$data['newsletterData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.newsletter')->where('active', 1)->limit(3)->order_by('created_at', 'DESC')->get()->result();
		$data['subscriptionData'] = $subscriptionData ?? [];

		$data['activeProjects'] = $this->db->select('*')
				->from($customerDBSettingRow->database_name . '.project')
				->where('active', 1)
				->order_by('created_at', 'DESC')
				->limit(3)
				->get()
				->result();

			// Fetch up to 3 recent active petitions for dashboard
			$data['activePetitions'] = $this->db->select('*')
				->from($customerDBSettingRow->database_name . '.petition_setup')
				->where('active', 1)
				->order_by('created_at', 'DESC')
				->limit(3)
				->get()
				->result();

			// Fetch up to 3 recent notice board items for dashboard
			$data['noticeBoardItems'] = $this->db->select('*')
				->from($customerDBSettingRow->database_name . '.notice_board')
				->where('active', 1)
				->order_by('created_at', 'DESC')
				->limit(3)
				->get()
				->result();
		$incidentData = $this->db->select('*')->from($customerDBSettingRow->database_name . '.security_incident')->order_by('incident_at', 'DESC')->order_by('created_at', 'DESC')->get()->result();
        $incidentTypeData = $this->db->from('m_incident_type')->where('active', 1)->get()->result();
		$incidentStatusIndex = $this->buildIncidentStatusIndex($incidentStatusData);
        $activeData = $this->db->select('*')
            ->from('m_active')
            ->where('active', 1)
            ->order_by('name', 'ASC')
            ->get()
            ->result();

        $incidentTypeIndex = $this->buildIncidentTypeIndex($incidentTypeData);
		$activeIndex = $this->buildActiveIndex($activeData);

        $data['incidentData'] = $incidentData;
        $data['incidentTypeIndex'] = $incidentTypeIndex;
		$data['incidentStatusIndex'] = $incidentStatusIndex;
		$data['activeIndex'] = $activeIndex;
		$data['chartData'] = $this->buildChartData($incidentData, $incidentTypeIndex, $incidentStatusIndex);
		$data['summary'] = $this->buildSummary($incidentData, $incidentStatusIndex);
		
		$data['customer_db_setting_id'] = $session_data['customer_db_setting_id'];
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['customerData'] = $customerData ?? [];
		$data['userArrayData'] = $userArrayData ?? [];
		$data['total_customers'] = count($customerData);
		$data['totalMembers'] = count($memberData);
		$data['totalMembersThisYear'] = count($memberDataThisYear);
		$data['totalApprovedMembers'] = $data['totalMembers'];
		$data['approvedMembersThisYear'] = isset($approvedMembersMonthly['total_year']) ? (int) $approvedMembersMonthly['total_year'] : count($memberDataThisYear);
		$data['approvedMembersMonthly'] = $approvedMembersMonthly;
		$data['paidSubscriptionsMonthly'] = $paidSubscriptionsMonthly;
		$data['unpaidSubscriptionsMonthly'] = $unpaidSubscriptionsMonthly;
		$data['unpaidSubscriptionsThisYear'] = isset($unpaidSubscriptionsMonthly['total_year']) ? (int) $unpaidSubscriptionsMonthly['total_year'] : 0;
		$data['paidSubscriptionsThisYear'] = isset($paidSubscriptionsMonthly['total_year']) ? (int) $paidSubscriptionsMonthly['total_year'] : 0;
		$data['unpaidSubscriptionsTotal'] = isset($unpaidSubscriptionsMonthly['total']) ? (int) $unpaidSubscriptionsMonthly['total'] : 0;
		$data['paidSubscriptionsTotal'] = isset($paidSubscriptionsMonthly['total']) ? (int) $paidSubscriptionsMonthly['total'] : 0;
		$data['totalSubscription'] = count($subscriptionData ?? []);
		$data['totalActiveUsers'] = $data['totalApprovedMembers'];
		$data['totalInactiveUsers'] = count($userInactiveData ?? []);


		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/home_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
	}

	public function overviewCard()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$user_type_id = $session_data['user_type_id'];

		$currentYear = (int) date('Y');
		$startDate = sprintf('%d-01-01 00:00:00', $currentYear);
		$endDate = sprintf('%d-12-31 23:59:59', $currentYear);

		$paymentStatusData = $this->db->select('*')->from('m_payment_status')->where('active', 1)->get()->result();
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();

		$modal ='<div class="col-sm-6 col-lg-3">
					<div class="card card-sm">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col-auto">
									<span class="bg-primary text-white avatar">
										<!-- Download SVG icon from http://tabler.io/icons/icon/currency-dollar -->
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
										<span class="bg-x text-white avatar">
											<!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
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
		$allSubscription = 0;
		if (!empty(get_user_right($user_type_id, '17072386410', 'view', 1))): foreach ($paymentStatusData as $paymentStatus):
			$subscriptionData = []; $subscriptionPaymentHistoryData = [];
			if ($session_data['user_type_id'] == GlobalModel::CLUB_ADMIN_TYPE)
			{
				$subscriptionData = $this->db->select('*')
					->from($customerDBSettingRow->database_name.'.subscription s')
					->join($customerDBSettingRow->database_name.'.payment_history ph', 's.subscription_id=ph.universal_id', 'left')
					->where('ph.payment_status_id', $paymentStatus->payment_status_id)
					->where('s.active', 1)
					->where('ph.created_at >=', $startDate)
					->where('ph.created_at <=', $endDate)
					->get()
					->result();
				$allSubscription += count($subscriptionData);
			}
			elseif ($session_data['user_type_id'] == GlobalModel::MEMBER_TYPE)
			{
				$subscriptionData = $this->db->select('*')
					->from($customerDBSettingRow->database_name.'.subscription s')
					->join($customerDBSettingRow->database_name.'.payment_history ph', 's.subscription_id=ph.universal_id', 'left')
					->where('ph.payment_status_id', $paymentStatus->payment_status_id)
					->where('s.user_id', $session_data['user_id'])
					->where('s.active', 1)
					->where('ph.created_at >=', $startDate)
					->where('ph.created_at <=', $endDate)
					->get()
					->result();
				$allSubscription += count($subscriptionData);
			}
			// foreach ($subscriptionData as $value) {
			// 	$subscriptionPaymentHistoryData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->where('module_id', '17072386410')->where('universal_id', $value->subscription_id)->where('payment_status_id', $paymentStatus->payment_status_id)->get()->result();
			// }
			$modal .='<div class="col-sm-6 col-lg-3">
						<div class="card card-sm">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-auto">
										<span class="bg-x text-white avatar">
											<!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
												<path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9z"></path>
												<path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
											</svg>
										</span>
									</div>
									<div class="col">
										<div class="font-weight-medium">'.count($subscriptionData ?? []).'</div>
										<div class="text-secondary">Total '.$paymentStatus->name.' Subscriptions</div>
									</div>
								</div>
							</div>
						</div>
					</div>';
		endforeach; 
		$modal .='<div class="col-sm-6 col-lg-3">
					<div class="card card-sm">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col-auto">
									<span class="bg-x text-white avatar">
										<!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
											<path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9z"></path>
											<path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
										</svg>
									</span>
								</div>
								<div class="col">
									<div class="font-weight-medium">'.$allSubscription.' Subscriptions</div>
									<div class="text-secondary">Total Subscriptions</div>
								</div>
							</div>
						</div>
					</div>
				</div>';
		endif;

		if (!empty(get_user_right($user_type_id, '17092385318', 'view', 1))): foreach ($paymentStatusData as $paymentStatus):
			$modal .='<div class="col-sm-6 col-lg-3">
						<div class="card card-sm">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-auto">
										<span class="bg-x text-white avatar">
											<!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
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
										<span class="bg-x text-white avatar">
										<!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
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

	private function buildApprovedMembersMonthlySeries($tableName)
	{
		$currentYear = (int) date('Y');
		$startDate = $currentYear . '-01-01 00:00:00';
		$endDate = $currentYear . '-12-31 23:59:59';

		$results = $this->db->select("DATE_FORMAT(created_at, '%Y-%m') AS month_key", false)
			->select('COUNT(*) AS total', false)
			->from($tableName)
			->where('user_type_id', GlobalModel::MEMBER_TYPE)
			->where('active', 1)
			->where('created_at >=', $startDate)
			->where('created_at <=', $endDate)
			->group_by('month_key')
			->order_by('month_key', 'ASC')
			->get()
			->result();

		$counts = [];
		foreach ($results as $row) {
			$monthKey = isset($row->month_key) ? (string) $row->month_key : '';
			if ($monthKey === '') {
				continue;
			}
			$counts[$monthKey] = (int) ($row->total ?? 0);
		}

		$categories = [];
		$seriesData = [];
		$totalYear = 0;
		for ($month = 1; $month <= 12; $month++) {
			$monthKey = sprintf('%d-%02d', $currentYear, $month);
			$count = $counts[$monthKey] ?? 0;
			$categories[] = date('M', strtotime($monthKey . '-01'));
			$seriesData[] = $count;
			$totalYear += $count;
		}

		return [
			'categories' => $categories,
			'series' => [
				[
					'name' => 'Approved Members',
					'data' => $seriesData,
				],
			],
			'total_year' => $totalYear,
		];
	}

	private function buildPaidSubscriptionsMonthlySeries($subscriptionTable, $paymentHistoryTable, $paidStatusId)
	{
		$currentYear = (int) date('Y');
		$startDate = sprintf('%d-01-01 00:00:00', $currentYear);
		$endDate = sprintf('%d-12-31 23:59:59', $currentYear);

		$categories = [];
		$seriesData = [];
		for ($month = 1; $month <= 12; $month++) {
			$monthKey = sprintf('%d-%02d-01', $currentYear, $month);
			$categories[] = date('M', strtotime($monthKey));
			$seriesData[] = 0;
		}

		$result = [
			'categories' => $categories,
			'series' => [
				[
					'name' => 'Paid Subscriptions',
					'data' => $seriesData,
				],
			],
			'total_year' => 0,
		];

		if (empty($subscriptionTable) || empty($paymentHistoryTable) || empty($paidStatusId)) {
			return $result;
		}

		$records = $this->db->select('s.subscription_id, ph.payment_history_id, ph.created_at, ph.created_at')
			->from($paymentHistoryTable . ' ph')
			->join($subscriptionTable . ' s', 's.subscription_id = ph.universal_id', 'inner')
			->where('ph.payment_status_id', $paidStatusId)
			->where('s.active', 1)
			->where('ph.created_at >=', $startDate)
			->where('ph.created_at <=', $endDate)
			->get()
			->result();

		$monthBuckets = [];
		foreach ($records as $row) 
		{
			$effectiveDate = $this->sanitizeDateTime($row->created_at);
			if ($effectiveDate === null) {
				continue;
			}

			$timestamp = strtotime($effectiveDate);
			if ($timestamp === false) {
				continue;
			}

			$monthKey = date('Y-m', $timestamp);
			$subscriptionId = isset($row->subscription_id) ? (string) $row->subscription_id : '';
			if ($subscriptionId === '' && isset($row->payment_history_id)) {
				$subscriptionId = (string) $row->payment_history_id;
			}
			if ($subscriptionId === '') {
				continue;
			}

			if (!isset($monthBuckets[$monthKey])) {
				$monthBuckets[$monthKey] = [];
			}

			$monthBuckets[$monthKey][$subscriptionId] = true;
		}

		$totalYear = 0;
		foreach ($categories as $index => $label) {
			$monthKey = sprintf('%d-%02d', $currentYear, $index + 1);
			$count = isset($monthBuckets[$monthKey]) ? count($monthBuckets[$monthKey]) : 0;
			$result['series'][0]['data'][$index] = $count;
			$totalYear += $count;
		}

		$result['total_year'] = $totalYear;
		$result['total'] = $totalYear;

		return $result;
	}

	private function buildUnpaidSubscriptionsMonthlySeries($subscriptionTable, $paymentHistoryTable, $paidStatusId)
	{
		$currentYear = (int) date('Y');
		$startDate = sprintf('%d-01-01 00:00:00', $currentYear);
		$endDate = sprintf('%d-12-31 23:59:59', $currentYear);

		$categories = [];
		$seriesData = [];
		for ($month = 1; $month <= 12; $month++) {
			$monthKey = sprintf('%d-%02d-01', $currentYear, $month);
			$categories[] = date('M', strtotime($monthKey));
			$seriesData[] = 0;
		}

		$result = [
			'categories' => $categories,
			'series' => [
				[
					'name' => 'Unpaid Subscriptions',
					'data' => $seriesData,
				],
			],
			'total_year' => 0,
		];

		if (empty($subscriptionTable) || empty($paymentHistoryTable) || empty($paidStatusId)) {
			return $result;
		}

		$records = $this->db->select('s.subscription_id, ph.payment_history_id, ph.created_at')
			->from($paymentHistoryTable . ' ph')
			->join($subscriptionTable . ' s', 's.subscription_id = ph.universal_id', 'inner')
			->where('s.active', 1)
			->where('ph.payment_status_id IS NOT NULL', null, false)
			->where('ph.payment_status_id !=', $paidStatusId)
			->where('ph.created_at >=', $startDate)
			->where('ph.created_at <=', $endDate)
			->get()
			->result();

			$allRecords = $this->db->select('s.subscription_id, ph.payment_history_id, ph.created_at')
				->from($paymentHistoryTable . ' ph')
				->join($subscriptionTable . ' s', 's.subscription_id = ph.universal_id', 'inner')
				->where('s.active', 1)
				->where('ph.payment_status_id IS NOT NULL', null, false)
				->where('ph.payment_status_id !=', $paidStatusId)
				->get()
				->result();

		$monthBuckets = [];
		foreach ($records as $row)
		{
			$effectiveDate = $this->sanitizeDateTime($row->created_at);
			if ($effectiveDate === null) {
				continue;
			}

			$timestamp = strtotime($effectiveDate);
			if ($timestamp === false) {
				continue;
			}

			$monthKey = date('Y-m', $timestamp);
			$subscriptionId = isset($row->subscription_id) ? (string) $row->subscription_id : '';
			if ($subscriptionId === '' && isset($row->payment_history_id)) {
				$subscriptionId = (string) $row->payment_history_id;
			}
			if ($subscriptionId === '') {
				continue;
			}

			if (!isset($monthBuckets[$monthKey])) {
				$monthBuckets[$monthKey] = [];
			}

			$monthBuckets[$monthKey][$subscriptionId] = true;
		}

		$totalYear = 0;
		foreach ($categories as $index => $label) {
			$monthKey = sprintf('%d-%02d', $currentYear, $index + 1);
			$count = isset($monthBuckets[$monthKey]) ? count($monthBuckets[$monthKey]) : 0;
			$result['series'][0]['data'][$index] = $count;
			$totalYear += $count;
		}

		$result['total_year'] = $totalYear;
		$result['total'] = count($allRecords);
		return $result;
	}

	private function getPaidPaymentStatusId()
	{
		$rows = $this->db->select('payment_status_id, name')
			->from('m_payment_status')
			->where('active', 1)
			->get()
			->result();

		foreach ($rows as $row) {
			$labels = array($row->name ?? '', $row->name_two ?? '');
			foreach ($labels as $label) {
				if (!is_string($label) || $label === '') {
					continue;
				}
				if (stripos($label, 'paid') !== false) {
					return (string) $row->payment_status_id;
				}
			}
		}

		return null;
	}

	private function sanitizeDateTime($value) {
        if (empty($value)) {
            return null;
        }

        $timestamp = strtotime($value);
        return $timestamp ? date('d M Y', $timestamp) : null;
    }

    private function sanitizeText($value, $stripTags = true) {
        if ($value === null) {
            return '';
        }

        $value = trim($value);
        return $stripTags ? strip_tags($value) : $value;
    }

    private function buildIncidentTypeIndex(array $incidentTypeData) {
        $index = [];
        foreach ($incidentTypeData as $row) {
            $id = null;
            foreach (array('incident_type_id') as $key) {
                if (isset($row->$key) && $row->$key !== '') {
                    $id = (string) $row->$key;
                    break;
                }
            }

            if ($id === null) {
                continue;
            }

            $label = null;
            foreach (array('name') as $key) {
                if (isset($row->$key) && $row->$key !== '') {
                    $label = $row->$key;
                    break;
                }
            }

            if ($label === null) {
                $label = 'Type ' . $id;
            }

            $index[$id] = $label;
        }

        return $index;
    }

	private function buildIncidentStatusIndex(array $incidentStatusData) {
		$index = [];
		foreach ($incidentStatusData as $row) {
			if (!isset($row->incident_status_id) || $row->incident_status_id === '') {
				continue;
			}

			$id = (string) $row->incident_status_id;
			$label = isset($row->name) && $row->name !== '' ? $row->name : 'Status ' . $id;

			$index[$id] = array('label' => $label);

			if (isset($row->text_class) && $row->text_class !== '') {
				$index[$id]['text_class'] = $row->text_class;
			}

			if (isset($row->description) && $row->description !== '') {
				$index[$id]['description'] = $row->description;
			}
		}

		return $index;
	}

    private function buildActiveIndex(array $activeData) {
        $index = [];
        foreach ($activeData as $row) {
            $id = null;
            foreach (array('num', 'active', 'active_id', 'id') as $key) {
                if (isset($row->$key) && $row->$key !== '') {
                    $id = (string) $row->$key;
                    break;
                }
            }

            if ($id === null) {
                continue;
            }

            $label = null;
            foreach (array('name', 'name_two', 'label', 'title') as $key) {
                if (isset($row->$key) && $row->$key !== '') {
                    $label = $row->$key;
                    break;
                }
            }

            if ($label === null) {
                $label = 'Status ' . $id;
            }

            $index[$id] = $label;
        }

        return $index;
    }

	private function buildChartData(array $incidentData, array $incidentTypeIndex, array $incidentStatusIndex) {
        $typeCounts = [];
        $timelineCounts = [];
        $statusCounts = [];

        foreach ($incidentData as $incident) {
            $typeId = isset($incident->incident_type_id) && $incident->incident_type_id !== ''
                ? (string) $incident->incident_type_id
                : 'unknown';
            $typeCounts[$typeId] = ($typeCounts[$typeId] ?? 0) + 1;

			$statusKey = isset($incident->incident_status_id) && $incident->incident_status_id !== ''
				? (string) $incident->incident_status_id
				: 'unknown';
            $statusCounts[$statusKey] = ($statusCounts[$statusKey] ?? 0) + 1;

            $dateValue = $incident->incident_at ?? $incident->created_at ?? null;
            if (!empty($dateValue)) {
                $timestamp = strtotime($dateValue);
                if ($timestamp !== false) {
                    $ymKey = date('Y-m', $timestamp);
                    $timelineCounts[$ymKey] = ($timelineCounts[$ymKey] ?? 0) + 1;
                }
            }
        }

        // Incident type chart data
        $typeLabels = [];
        $typeSeries = [];
        if (!empty($typeCounts)) {
            foreach ($typeCounts as $typeId => $count) {
                $label = $incidentTypeIndex[$typeId] ?? ($typeId === 'unknown' ? 'Unclassified' : 'Type ' . $typeId);
                $typeLabels[] = $label;
                $typeSeries[] = $count;
            }
        } else {
            $typeLabels = array('No Data');
            $typeSeries = array(0);
        }

        // Timeline chart data
        ksort($timelineCounts);
        $timelineCategories = [];
        $timelineSeriesData = [];
        if (!empty($timelineCounts)) {
            foreach ($timelineCounts as $ym => $count) {
                $timestamp = strtotime($ym . '-01');
                $timelineCategories[] = $timestamp ? date('M Y', $timestamp) : $ym;
                $timelineSeriesData[] = $count;
            }
        }

        if (empty($timelineSeriesData)) {
            $timelineCategories = array('No Data');
            $timelineSeriesData = array(0);
        }

        // Status chart data
        $statusLabels = [];
        $statusSeries = [];
        if (!empty($statusCounts)) {
            foreach ($statusCounts as $statusKey => $count) {
				$label = 'Status ' . $statusKey;
				if ($statusKey === 'unknown') {
					$label = 'Unknown';
				}

				if ($statusKey !== 'unknown' && isset($incidentStatusIndex[$statusKey])) {
					$statusMeta = $incidentStatusIndex[$statusKey];
					if (is_array($statusMeta)) {
						$label = $statusMeta['label'] ?? $label;
					} elseif (is_string($statusMeta)) {
						$label = $statusMeta;
					}
				}

                $statusLabels[] = $label;
                $statusSeries[] = $count;
            }
        } else {
            $statusLabels = array('No Data');
            $statusSeries = array(0);
        }

        return array(
            'type' => array(
                'labels' => $typeLabels,
                'series' => $typeSeries,
            ),
            'timeline' => array(
                'categories' => $timelineCategories,
                'series' => array(
                    array(
                        'name' => 'Incidents',
                        'data' => $timelineSeriesData,
                    ),
                ),
            ),
            'status' => array(
                'labels' => $statusLabels,
                'series' => $statusSeries,
            ),
        );
    }

	private function buildSummary(array $incidentData, array $incidentStatusIndex = array()) {
		$total = count($incidentData);
		$recentTimestamp = null;
		$locations = [];
		$reporters = [];
		$statusCounts = [];
		$unknownStatusCount = 0;

		foreach ($incidentStatusIndex as $statusId => $meta) {
			$statusCounts[(string) $statusId] = 0;
		}

		foreach ($incidentData as $incident) {
			if (isset($incident->incident_status_id) && $incident->incident_status_id !== '') {
				$statusId = (string) $incident->incident_status_id;
				if (!array_key_exists($statusId, $statusCounts)) {
					$statusCounts[$statusId] = 0;
				}

				$statusCounts[$statusId]++;
			} else {
				$unknownStatusCount++;
			}

			if (!empty($incident->incident_at)) {
				$timestamp = strtotime($incident->incident_at);
				if ($timestamp !== false && ($recentTimestamp === null || $timestamp > $recentTimestamp)) {
					$recentTimestamp = $timestamp;
				}
			}

			if (!empty($incident->location)) {
				$locations[strtolower(trim($incident->location))] = true;
			}

			if (!empty($incident->reported_by)) {
				$reporters[strtolower(trim($incident->reported_by))] = true;
			}
		}

		$statusSummary = [];
		foreach ($statusCounts as $statusId => $count) {
			$meta = $incidentStatusIndex[$statusId] ?? null;
			$label = 'Status ' . $statusId;
			$textClass = null;
			$description = null;

			if (is_array($meta)) {
				$label = $meta['label'] ?? $label;
				$textClass = $meta['text_class'] ?? null;
				$description = $meta['description'] ?? null;
			} elseif (is_string($meta)) {
				$label = $meta;
			}

			$statusSummary[] = array(
				'id' => (string) $statusId,
				'label' => $label,
				'count' => $count,
				'text_class' => $textClass,
				'description' => $description,
			);
		}

		if ($unknownStatusCount > 0) {
			$statusSummary[] = array(
				'id' => 'unknown',
				'label' => 'Unknown',
				'count' => $unknownStatusCount,
				'text_class' => null,
				'description' => 'Incidents without a recorded status',
			);
		}

		return array(
			'total' => $total,
			'statuses' => $statusSummary,
			'recent' => $recentTimestamp ? date('d M Y', $recentTimestamp) : null,
			'location_count' => count($locations),
			'reporter_count' => count($reporters),
		);
    }
}
