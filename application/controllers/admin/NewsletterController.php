<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NewsletterController extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
	**/
    public function newsletterView() 
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $data = $this->common->loadHeaderData('newsletter');
        $customer_db_setting_id = $session_data['customer_db_setting_id'];
        $page = max(1, (int) $this->input->get('page'));
        $perPageInput = (int) $this->input->get('per_page');
        $perPage = $perPageInput > 0 ? $perPageInput : 9;
        $perPage = min(50, max(6, $perPage));

		$customerDBSettingRow = $this->db->select('*')
			->from('customer_db_setting')
			->where('customer_db_setting_id', $customer_db_setting_id)
			->get()
			->row();

        if ($customerDBSettingRow) {
            $tenantTable = $customerDBSettingRow->database_name . '.newsletter';

            $totalCount = (int) $this->db->select('COUNT(*) AS total_count')
                ->from($tenantTable)
                ->get()
                ->row('total_count');

            $offset = ($page - 1) * $perPage;

            $newsletterQuery = $this->db->select('*')
                ->from($tenantTable)
                ->order_by('created_at', 'DESC')
                ->limit($perPage, $offset)
                ->get();

            $data['newsletterData'] = $newsletterQuery->result();
            $data['newsletterSummary'] = $this->calculateNewsletterSummary($tenantTable);
            $data['pagination'] = [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $totalCount,
                'pages' => $perPage > 0 ? (int) ceil($totalCount / $perPage) : 1,
            ];
        } else {
            $data['newsletterData'] = [];
            $data['newsletterSummary'] = $this->calculateNewsletterSummary('');
            $data['pagination'] = [
                'page' => 1,
                'per_page' => $perPage,
                'total' => 0,
                'pages' => 1,
            ];
        }

		$data['user_type_id'] = $session_data['user_type_id'];
        $data['customer_db_setting_id'] = $customer_db_setting_id;

        $this->load->view('admin/templates/header_view', $data);
        $this->load->view('admin/newsletter_view', $data);
        $this->load->view('admin/templates/footer_view', $data);
    }

    private function calculateNewsletterSummary($tenantTable)
    {
        $summary = [
            'total_newsletters' => 0,
            'active_newsletters' => 0,
            'inactive_newsletters' => 0,
            'recent_newsletters' => 0,
            'with_thumbnails' => 0,
            'latest_newsletter_at' => null,
        ];

        if (empty($tenantTable)) {
            return $summary;
        }

        $aggregateRow = $this->db->select("
                COUNT(*) AS total_newsletters,
                SUM(CASE WHEN active = 1 THEN 1 ELSE 0 END) AS active_newsletters,
                SUM(CASE WHEN active = 0 THEN 1 ELSE 0 END) AS inactive_newsletters,
                SUM(CASE WHEN thumbnail_url IS NOT NULL AND thumbnail_url <> '' THEN 1 ELSE 0 END) AS with_thumbnails,
                MAX(created_at) AS latest_newsletter_at
            ")
            ->from($tenantTable)
            ->get()
            ->row();

        if ($aggregateRow) {
            $summary['total_newsletters'] = (int) ($aggregateRow->total_newsletters ?? 0);
            $summary['active_newsletters'] = (int) ($aggregateRow->active_newsletters ?? 0);
            $summary['inactive_newsletters'] = (int) ($aggregateRow->inactive_newsletters ?? 0);
            $summary['with_thumbnails'] = (int) ($aggregateRow->with_thumbnails ?? 0);
            $summary['latest_newsletter_at'] = $aggregateRow->latest_newsletter_at ?? null;
        }

        if ($summary['total_newsletters'] > 0) {
            $recentThreshold = date('Y-m-d H:i:s', strtotime('-30 days'));
            $recentCount = $this->db->from($tenantTable)
                ->where('created_at >=', $recentThreshold)
                ->count_all_results();
            $summary['recent_newsletters'] = (int) $recentCount;
        }

        return $summary;
    }

    public function addNewsletterModal()
    {
        $this->common->checkSession();
        $this->common->loadSession();

        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
        $data['newsletter_id'] = generate_uuid();

        return $this->load->view('admin/add_edit_newsletter_modal', $data);
    }

    public function addNewsletter()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $postData = $this->input->post();
		if (isset($_FILES['thumbnail_url']['name'])) {
			$postData['thumbnail_url'] = file_upload('thumbnail_url', $postData['newsletter_id']);
		}
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        $this->db->insert($customerDBSettingRow->database_name.'.newsletter', $postData);
        $this->session->set_flashdata('success', 'Newsletter saved successfully.');
        redirect('newsletter', 'refresh');
    }

	public function viewNewsletterModal($newsletter_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        $newsletterRow = $this->db->from($customerDBSettingRow->database_name.'.newsletter')->where('newsletter_id', $newsletter_id)->get()->row();
        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
        $data['newsletterRow'] = $newsletterRow;
		$data['newsletter_id'] = $newsletter_id;

        return $this->load->view('admin/view_newsletter_modal', $data);
    }

    public function editNewsletterModal($newsletter_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        $newsletterRow = $this->db->from($customerDBSettingRow->database_name.'.newsletter')->where('newsletter_id', $newsletter_id)->get()->row();
        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
        $data['newsletterRow'] = $newsletterRow;
		$data['newsletter_id'] = $newsletter_id;

        return $this->load->view('admin/add_edit_newsletter_modal', $data);
    }

    public function editNewsletter()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $postData = $this->input->post();
		$newsletter_id = $postData['newsletter_id'];
		if (isset($_FILES['thumbnail_url']['name'])) {
			$postData['thumbnail_url'] = file_upload('thumbnail_url', $newsletter_id);
		}
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        $this->db->update($customerDBSettingRow->database_name.'.newsletter', $postData, array('newsletter_id'=>$newsletter_id));

        $this->session->set_flashdata('success', 'Newsletter updated successfully.');
        redirect('newsletter', 'refresh');
    }

    public function removeNewsletterModal($newsletter_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$newsletterRow = $this->db->from($customerDBSettingRow->database_name.'.newsletter')->where('newsletter_id', $newsletter_id)->get()->row();
        $data['table'] = $customerDBSettingRow->database_name.'.newsletter';
        $data['table_id'] = 'newsletter_id';
        $data['unique_id'] = $newsletter_id;
        $data['name'] = isset($newsletterRow->name) ? $newsletterRow->name : 'newsletter';
        $data['route'] = 'newsletter';

        return $this->load->view('admin/remove_global_modal', $data);
    }

	public function sendNewsletter($newsletter_id = null)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$newsletterRow = $this->db->from($customerDBSettingRow->database_name.'.newsletter')->where('newsletter_id', $newsletter_id)->get()->row();

		if ($newsletterRow) {
			$userEmails = $this->db->select('email, full_legal_name')
				->from($customerDBSettingRow->database_name.'.user')
				->where('active', 1)
				->get()
				->result();

			foreach ($userEmails as $user) {
				$data['userRow'] = $user;
				$data['newsletterRow'] = $newsletterRow;
				$data['customerRow'] = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
				$htmlContent = $this->load->view('admin/newsletter_email_temp', $data, true);
				$this->common->sendMail($user->email, $newsletterRow->name, $htmlContent);
			}

			$this->session->set_flashdata('success', 'Newsletter sent successfully to all active users.');
		} else {
			$this->session->set_flashdata('error', 'Newsletter not found.');
		}

		redirect('newsletter', 'refresh');
	}

}
