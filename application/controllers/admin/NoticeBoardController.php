<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NoticeBoardController extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function noticeBoardView()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $data = $this->common->loadHeaderData('notice-board');
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
            $tenantTable = $customerDBSettingRow->database_name . '.notice_board';

            $totalCount = (int) $this->db->select('COUNT(*) AS total_count')
                ->from($tenantTable)
                ->get()
                ->row('total_count');

            $offset = ($page - 1) * $perPage;

            $noticeQuery = $this->db->select('*')
                ->from($tenantTable)
                ->order_by('created_at', 'DESC')
                ->limit($perPage, $offset)
                ->get();

            $data['noticeBoardData'] = $noticeQuery->result();
            $data['noticeSummary'] = $this->calculateNoticeSummary($tenantTable);
            $data['pagination'] = [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $totalCount,
                'pages' => $perPage > 0 ? (int) ceil($totalCount / $perPage) : 1,
            ];
        } else {
            $data['noticeBoardData'] = [];
            $data['noticeSummary'] = $this->calculateNoticeSummary('');
            $data['pagination'] = [
                'page' => 1,
                'per_page' => $perPage,
                'total' => 0,
                'pages' => 1,
            ];
        }

        $data['customer_db_setting_id'] = $customer_db_setting_id;

        $this->load->view('admin/templates/header_view', $data);
        $this->load->view('admin/notice_board_view', $data);
        $this->load->view('admin/templates/footer_view', $data);
    }

    public function addEditNoticeBoardModal($notice_board_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $data = [];
        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();

        if (!empty($notice_board_id) && $customerDBSettingRow) {
            $noticeRow = $this->db->from($customerDBSettingRow->database_name . '.notice_board')
                ->where('notice_board_id', $notice_board_id)
                ->get()
                ->row();
            $data['noticeRow'] = $noticeRow;
            $data['notice_board_id'] = $notice_board_id;
        } else {
            $data['notice_board_id'] = generate_uuid();
            $data['noticeRow'] = null;
        }

        return $this->load->view('admin/add_edit_notice_board_modal', $data);
    }

    public function addNoticeBoard()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $postData = $this->input->post();
        $notice_board_id = $postData['notice_board_id'] ?? generate_uuid();

        if (isset($_FILES['thumbnail_url']['name']) && !empty($_FILES['thumbnail_url']['name'])) {
            $postData['thumbnail_url'] = file_upload('thumbnail_url', $notice_board_id);
        }
        if (isset($_FILES['attachment_url']['name']) && !empty($_FILES['attachment_url']['name'])) {
            $postData['attachment_url'] = file_upload('attachment_url', $notice_board_id);
        }

        $postData['created_at'] = date('d M Y');

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        if ($customerDBSettingRow) {
            $this->db->insert($customerDBSettingRow->database_name . '.notice_board', $postData);
            $this->session->set_flashdata('success', 'Notice saved successfully.');
        }

        redirect('notice-board', 'refresh');
    }

    public function editNoticeBoard()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $postData = $this->input->post();
        $notice_board_id = $postData['notice_board_id'] ?? '';

        if (isset($_FILES['thumbnail_url']['name']) && !empty($_FILES['thumbnail_url']['name'])) {
            $postData['thumbnail_url'] = file_upload('thumbnail_url', $notice_board_id);
        }
        if (isset($_FILES['attachment_url']['name']) && !empty($_FILES['attachment_url']['name'])) {
            $postData['attachment_url'] = file_upload('attachment_url', $notice_board_id);
        }

        $postData['updated_at'] = date('d M Y');

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        if ($customerDBSettingRow && !empty($notice_board_id)) {
            $this->db->update($customerDBSettingRow->database_name . '.notice_board', $postData, ['notice_board_id' => $notice_board_id]);
            $this->session->set_flashdata('success', 'Notice updated successfully.');
        }

        redirect('notice-board', 'refresh');
    }

    public function removeNoticeBoardModal($notice_board_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $data = [];
        $data['table'] = $customerDBSettingRow ? $customerDBSettingRow->database_name . '.notice_board' : 'notice_board';
        $data['table_id'] = 'notice_board_id';
        $data['unique_id'] = $notice_board_id;
        $data['name'] = 'notice';
        $data['route'] = 'notice-board';

        return $this->load->view('admin/remove_global_modal', $data);
    }

    public function viewNoticeBoardModal($notice_board_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $data = [];
        $data['notice_board_id'] = $notice_board_id;
        $data['noticeRow'] = null;

        if (!empty($notice_board_id) && $customerDBSettingRow) {
            $noticeRow = $this->db->from($customerDBSettingRow->database_name . '.notice_board')
                ->where('notice_board_id', $notice_board_id)
                ->get()
                ->row();
            $data['noticeRow'] = $noticeRow;
        }

        return $this->load->view('admin/view_notice_board_modal', $data);
    }

    public function removeNoticeBoard()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $notice_board_id = $this->input->post('unique_id', true) ?? $this->input->post('notice_board_id', true);

        if (empty($notice_board_id)) {
            $this->session->set_flashdata('warning', 'Notice removal failed.');
            redirect('notice-board', 'refresh');
        }

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        if ($customerDBSettingRow) {
            $this->db->where('notice_board_id', $notice_board_id);
            $this->db->delete($customerDBSettingRow->database_name . '.notice_board');
            $this->session->set_flashdata('success', 'Notice removed successfully.');
        } else {
            $this->session->set_flashdata('warning', 'Notice removal failed.');
        }

        redirect('notice-board', 'refresh');
    }

    private function calculateNoticeSummary($tenantTable)
    {
        $summary = [
            'total_notices' => 0,
            'with_attachments' => 0,
            'with_thumbnails' => 0,
            'recent_notices' => 0,
            'latest_notice_at' => null,
        ];

        if (empty($tenantTable)) {
            return $summary;
        }

        $aggregateRow = $this->db->select("
                COUNT(*) AS total_notices,
                SUM(CASE WHEN attachment_url IS NOT NULL AND attachment_url <> '' THEN 1 ELSE 0 END) AS with_attachments,
                SUM(CASE WHEN thumbnail_url IS NOT NULL AND thumbnail_url <> '' THEN 1 ELSE 0 END) AS with_thumbnails,
                MAX(created_at) AS latest_notice_at
            ")
            ->from($tenantTable)
            ->get()
            ->row();

        if ($aggregateRow) {
            $summary['total_notices'] = (int) ($aggregateRow->total_notices ?? 0);
            $summary['with_attachments'] = (int) ($aggregateRow->with_attachments ?? 0);
            $summary['with_thumbnails'] = (int) ($aggregateRow->with_thumbnails ?? 0);
            $summary['latest_notice_at'] = $aggregateRow->latest_notice_at ?? null;
        }

        if ($summary['total_notices'] > 0) {
            $recentThreshold = date('d M Y', strtotime('-30 days'));
            $recentCount = $this->db->from($tenantTable)
                ->where('created_at >=', $recentThreshold)
                ->count_all_results();
            $summary['recent_notices'] = (int) $recentCount;
        }

        return $summary;
    }

}
