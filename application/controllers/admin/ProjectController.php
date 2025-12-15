<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProjectController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'form', 'common'));
        $this->load->library(array('session', 'common'));
        $this->load->database();
    }

    public function projectView() 
	{
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $data = $this->common->loadHeaderData('project');
        $customer_db_setting_id = $session_data['customer_db_setting_id'];
        $page = max(1, (int) $this->input->get('page'));
        $perPage = min(50, max(6, (int) $this->input->get('per_page')));

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        if ($customerDBSettingRow) {
            $tenantTable = $customerDBSettingRow->database_name . '.project';

            $totalCount = $this->db->select('COUNT(*) AS total_count')
                ->from($tenantTable)
                ->get()
                ->row('total_count');

            $offset = ($page - 1) * $perPage;

            $projectQuery = $this->db->select('*')
                ->from($tenantTable)
                ->order_by('created_at', 'DESC')
                ->limit($perPage, $offset)
                ->get();

            $data['projectData'] = $projectQuery->result();
            $data['projectSummary'] = $this->calculateProjectSummary($data['projectData']);
            $data['pagination'] = [
                'page' => $page,
                'per_page' => $perPage,
                'total' => (int) $totalCount,
                'pages' => $perPage > 0 ? (int) ceil($totalCount / $perPage) : 1,
            ];
        } else {
            $data['projectData'] = [];
            $data['projectSummary'] = $this->calculateProjectSummary([]);
            $data['pagination'] = [
                'page' => 1,
                'per_page' => $perPage,
                'total' => 0,
                'pages' => 1,
            ];
        }

        $this->load->view('admin/templates/header_view', $data);
        $this->load->view('admin/project_view', $data);
        $this->load->view('admin/templates/footer_view', $data);
    }

    private function calculateProjectSummary($projects)
    {
        $summary = [
            'total_projects' => 0,
            'active_projects' => 0,
            'completed_projects' => 0,
            'budget_allocated' => 0.0,
            'budget_used' => 0.0,
        ];

        if (empty($projects)) {
            return $summary;
        }

        $summary['total_projects'] = count($projects);

        foreach ($projects as $project) {
            $statusId = $project->project_status_id ?? null;
            $activeValue = isset($project->active) ? (int) $project->active : null;

            if ($activeValue === 1) {
                $summary['active_projects'] += 1;
            }

            $statusName = $statusId ? strtolower((string) get_table('m_project_status', 'project_status_id', $statusId, 'name')) : '';
            if (!empty($statusName) && (strpos($statusName, 'complete') !== false || strpos($statusName, 'done') !== false || strpos($statusName, 'finished') !== false)) {
                $summary['completed_projects'] += 1;
            }

            $summary['budget_allocated'] += isset($project->budget_allocated) ? (float) $project->budget_allocated : 0.0;
            $summary['budget_used'] += isset($project->budget_used) ? (float) $project->budget_used : 0.0;
        }

        return $summary;
    }

    public function addProjectModal() 
	{
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $data['project_id'] = generate_uuid();
		$data['projectLeadData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('active', 1)->get()->result();
        $data['projectStatusData'] = $this->getProjectStatusData($customerDBSettingRow ? $customerDBSettingRow->database_name : '');
        $data['projectCategoryData'] = $this->getProjectCategoryData($customerDBSettingRow ? $customerDBSettingRow->database_name : '');
        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->order_by('name', 'ASC')->get()->result();

        return $this->load->view('admin/add_edit_project_modal', $data);
    }

    public function addProject() 
	{
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $postData = $this->input->post();
        $project_id = $postData['project_id'] ?? generate_uuid();
        $postData['project_id'] = $project_id;
        $postData['budget_allocated'] = $this->sanitizeCurrency($postData['budget_allocated'] ?? null);
        $postData['budget_used'] = $this->sanitizeCurrency($postData['budget_used'] ?? null);
        $postData['start_at'] = $this->sanitizeDateTime($postData['start_at'] ?? null);
        $postData['due_at'] = $this->sanitizeDateTime($postData['due_at'] ?? null);
        $postData['active'] = isset($postData['active']) && $postData['active'] !== '' ? (int) $postData['active'] : 1;
        $postData['created_at'] = date('d M Y');
        $postData['updated_at'] = date('d M Y');

        $thumbnailUrlInput = trim($postData['thumbnail_url'] ?? '');
        unset($postData['thumbnail_url']);

        $thumbnailPath = $this->resolveProjectThumbnail($project_id, $thumbnailUrlInput);
        if ($thumbnailPath !== null) {
            $postData['thumbnail_url'] = $thumbnailPath;
        }

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        if ($customerDBSettingRow) {
            $this->db->insert($customerDBSettingRow->database_name . '.project', $postData);
            $this->session->set_flashdata('success', 'Project saved successfully.');
        }

        redirect('projects', 'refresh');
    }

    public function viewProjectModal($project_id = null)
	{
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $data = [
            'projectRow' => null,
            'project_id' => $project_id,
            'projectLeadName' => '',
            'projectStatusName' => '',
            'projectCategoryName' => '',
            'activeName' => '',
            'activeClass' => 'bg-yellow-lt',
            'thumbnailSrc' => '',
        ];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        if ($customerDBSettingRow && !empty($project_id)) {
            $tenantDatabase = $customerDBSettingRow->database_name;
            $projectRow = $this->db->from($tenantDatabase . '.project')
                ->where('project_id', $project_id)
                ->get()
                ->row();

            if ($projectRow) {
                $data['projectRow'] = $projectRow;

                $leadId = $projectRow->project_lead_id ?? null;
                if (!empty($leadId)) {
                    $data['projectLeadName'] = get_table($tenantDatabase . '.user', 'user_id', $leadId, 'full_legal_name');
                }

                $statusId = $projectRow->project_status_id ?? null;
                if (!empty($statusId)) {
                    $data['projectStatusName'] = get_table('m_project_status', 'project_status_id', $statusId, 'name');
                }

                $categoryId = $projectRow->project_category_id ?? null;
                if (!empty($categoryId)) {
                    $categoryTable = $this->db->table_exists('m_project_category') ? 'm_project_category' : $tenantDatabase . '.m_project_category';
                    $data['projectCategoryName'] = get_table($categoryTable, 'project_category_id', $categoryId, 'name');
                }

                $activeValue = isset($projectRow->active) ? (int) $projectRow->active : -1;
                $data['activeName'] = get_table('m_active', 'num', $activeValue, 'name');
                $data['activeClass'] = ($activeValue === 1) ? 'bg-green-lt' : (($activeValue === 0) ? 'bg-red-lt' : 'bg-yellow-lt');

                $thumbnailUrl = trim($projectRow->thumbnail_url ?? '');
                if (!empty($thumbnailUrl)) {
                    $data['thumbnailSrc'] = filter_var($thumbnailUrl, FILTER_VALIDATE_URL) ? $thumbnailUrl : base_url($thumbnailUrl);
                }
            }
        }

        return $this->load->view('admin/view_project_modal', $data);
    }

    public function editProjectModal($project_id = null) 
	{
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $projectRow = null;
        if ($customerDBSettingRow && $project_id) {
            $projectRow = $this->db->from($customerDBSettingRow->database_name . '.project')
                ->where('project_id', $project_id)
                ->get()
                ->row();
        }

        $data['projectRow'] = $projectRow;
        $data['project_id'] = $project_id;
		$data['projectLeadData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('active', 1)->get()->result();
        $data['projectStatusData'] = $this->getProjectStatusData($customerDBSettingRow ? $customerDBSettingRow->database_name : '');
        $data['projectCategoryData'] = $this->getProjectCategoryData($customerDBSettingRow ? $customerDBSettingRow->database_name : '');
        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->order_by('name', 'ASC')->get()->result();

        return $this->load->view('admin/add_edit_project_modal', $data);
    }

    public function editProject() 
	{
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $postData = $this->input->post();
        $project_id = $postData['project_id'] ?? '';
        $thumbnailUrlInput = trim($postData['thumbnail_url'] ?? '');
        unset($postData['thumbnail_url']);

        $postData['budget_allocated'] = $this->sanitizeCurrency($postData['budget_allocated'] ?? null);
        $postData['budget_used'] = $this->sanitizeCurrency($postData['budget_used'] ?? null);
        $postData['start_at'] = $this->sanitizeDateTime($postData['start_at'] ?? null);
        $postData['due_at'] = $this->sanitizeDateTime($postData['due_at'] ?? null);
        $postData['active'] = isset($postData['active']) && $postData['active'] !== '' ? (int) $postData['active'] : 1;
        $postData['updated_at'] = date('d M Y');

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        if ($customerDBSettingRow && $project_id) {
            $existingProjectRow = $this->db->from($customerDBSettingRow->database_name . '.project')
                ->where('project_id', $project_id)
                ->get()
                ->row();

            $existingThumbnail = $existingProjectRow ? ($existingProjectRow->thumbnail_url ?? '') : '';
            $thumbnailPath = $this->resolveProjectThumbnail($project_id, $thumbnailUrlInput, $existingThumbnail);
            if ($thumbnailPath !== null) {
                $postData['thumbnail_url'] = $thumbnailPath;
            }

            $this->db->update(
                $customerDBSettingRow->database_name . '.project',
                $postData,
                array('project_id' => $project_id)
            );

            $this->session->set_flashdata('success', 'Project updated successfully.');
            redirect('projects', 'refresh');
        }

        $this->session->set_flashdata('warning', 'Project update failed.');
        redirect('projects', 'refresh');
    }

    public function removeProjectModal($project_id = null) {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $projectRow = null;
        if ($customerDBSettingRow && $project_id) {
            $projectRow = $this->db->from($customerDBSettingRow->database_name . '.project')
                ->where('project_id', $project_id)
                ->get()
                ->row();
        }

        $data['project_id'] = $project_id;
        $data['projectRow'] = $projectRow;

        return $this->load->view('admin/remove_project_modal', $data);
    }

    public function removeProject() {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $project_id = $this->input->post('project_id', true);

        if (empty($project_id)) {
            $this->session->set_flashdata('warning', 'Project removal failed.');
            redirect('projects', 'refresh');
        }

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        if ($customerDBSettingRow) {
            $this->db->where('project_id', $project_id);
            $this->db->delete($customerDBSettingRow->database_name . '.project');
            $this->session->set_flashdata('success', 'Project removed successfully.');
        } else {
            $this->session->set_flashdata('warning', 'Project removal failed.');
        }

        redirect('projects', 'refresh');
    }

    private function sanitizeCurrency($value) {
        if ($value === null || $value === '') {
            return 0.0;
        }
        return (float) str_replace(',', '', $value);
    }

    private function sanitizeDateTime($value) {
        if (empty($value)) {
            return null;
        }
        $timestamp = strtotime($value);
        return $timestamp ? date('d M Y', $timestamp) : null;
    }

    private function resolveProjectThumbnail($project_id, $thumbnailUrlInput = '', $existingThumbnail = '') {
        if (isset($_FILES['project_thumbnail_file']) && is_array($_FILES['project_thumbnail_file']) && !empty($_FILES['project_thumbnail_file']['name']) && $_FILES['project_thumbnail_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedPath = file_upload('project_thumbnail_file', $project_id, 'assets/img/');
            if (!empty($uploadedPath) && $uploadedPath !== 'assets/img/') {
                return $uploadedPath;
            }
        }

        if (!empty($thumbnailUrlInput)) {
            return $thumbnailUrlInput;
        }

        if (!empty($existingThumbnail)) {
            return $existingThumbnail;
        }

        return null;
    }

    private function getProjectStatusData($databaseName) {
        if ($this->db->table_exists('m_project_status')) {
            return $this->db->select('*')->from('m_project_status')->where('active', 1)->order_by('name', 'ASC')->get()->result();
        }

        if ($databaseName) {
            $qualifiedTable = $databaseName . '.m_project_status';
            if ($this->db->table_exists($qualifiedTable)) {
                return $this->db->select('*')->from($qualifiedTable)->where('active', 1)->order_by('name', 'ASC')->get()->result();
            }
        }

        return [];
    }

    private function getProjectCategoryData($databaseName) {
        if (empty($databaseName)) {
            return [];
        }

        $qualifiedTable = $databaseName . '.m_project_category';
        if ($this->db->table_exists('m_project_category')) {
            return $this->db->select('*')->from('m_project_category')->order_by('name', 'ASC')->get()->result();
        }

        if ($this->db->table_exists($qualifiedTable)) {
            return $this->db->select('*')->from($qualifiedTable)->order_by('name', 'ASC')->get()->result();
        }

        return [];
    }
}
