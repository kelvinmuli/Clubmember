<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuditedAccountController extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
	}

	public function auditedAccountView()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$data = $this->common->loadHeaderData('audited-account');
		$customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$data['auditedAccountData'] = [];
		$tableName = 'audited_account';
		$table = $customerDBSettingRow->database_name . '.' . $tableName;
		$tableExists = $this->db->query(
			"SELECT 1 FROM information_schema.tables WHERE table_schema = ? AND table_name = ? LIMIT 1",
			[$customerDBSettingRow->database_name, $tableName]
		)->row();

		if (!empty($tableExists)) {
			$data['auditedAccountData'] = $this->db
				->select('*')
				->from($table)
				->where('active', 1)
				->order_by('created_at', 'DESC')
				->get()
				->result();
		}

		$this->load->view('admin/templates/header_view', $data);
		$this->load->view('admin/audited_account_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
	}

	public function addAuditedAccountModal()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$tableName = 'audited_account';
		$tableExists = $this->db->query(
			"SELECT 1 FROM information_schema.tables WHERE table_schema = ? AND table_name = ? LIMIT 1",
			[$customerDBSettingRow->database_name, $tableName]
		)->row();
		if (empty($tableExists)) {
			show_error('Audited accounts table not found for this customer database.', 500);
			return;
		}

		$data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
		$data['stateData'] = $this->db->select('*')->from('m_state')->where('active', 1)->get()->result();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['audited_account_id'] = generate_uuid();
		$data['user_id'] = $session_data['user_id'] ?? null;

		return $this->load->view('admin/add_edit_audited_account_modal', $data);
	}

	public function addAuditedAccount()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$tableName = 'audited_account';
		$tableExists = $this->db->query(
			"SELECT 1 FROM information_schema.tables WHERE table_schema = ? AND table_name = ? LIMIT 1",
			[$customerDBSettingRow->database_name, $tableName]
		)->row();
		if (empty($tableExists)) {
			show_error('Audited accounts table not found for this customer database.', 500);
			return;
		}

		$postData = $this->input->post(NULL, TRUE);
		$audited_account_id = $postData['audited_account_id'];
		if (empty($postData['user_id']) && !empty($session_data['user_id'])) {
			$postData['user_id'] = $session_data['user_id'];
		}

		if (isset($_FILES['file_url']) && $_FILES['file_url']['error'] == UPLOAD_ERR_OK) {
			$postData['file_url'] = file_upload('file_url', $audited_account_id, 'assets/doc/');
		}

		$table = $customerDBSettingRow->database_name . '.' . $tableName;
		$this->db->insert($table, $postData);
		redirect('audited-account', 'refresh');
	}

	public function viewAuditedAccountModal($audited_account_id = null)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];

		$data = [
			'auditedAccountRow' => null,
			'audited_account_id' => $audited_account_id,
		];

		$customerDBSettingRow = $this->db
			->select('*')
			->from('customer_db_setting')
			->where('customer_db_setting_id', $customer_db_setting_id)
			->get()
			->row();

		if (!empty($customerDBSettingRow) && !empty($audited_account_id)) {
			$tableName = 'audited_account';
			$tableExists = $this->db->query(
				"SELECT 1 FROM information_schema.tables WHERE table_schema = ? AND table_name = ? LIMIT 1",
				[$customerDBSettingRow->database_name, $tableName]
			)->row();
			if (empty($tableExists)) {
				return $this->load->view('admin/view_audited_account_modal', $data);
			}

			$table = $customerDBSettingRow->database_name . '.' . $tableName;
			$data['auditedAccountRow'] = $this->db
				->select('*')
				->from($table)
				->where('audited_account_id', $audited_account_id)
				->get()
				->row();
		}

		return $this->load->view('admin/view_audited_account_modal', $data);
	}

	public function editAuditedAccountModal($audited_account_id)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$tableName = 'audited_account';
		$tableExists = $this->db->query(
			"SELECT 1 FROM information_schema.tables WHERE table_schema = ? AND table_name = ? LIMIT 1",
			[$customerDBSettingRow->database_name, $tableName]
		)->row();
		if (empty($tableExists)) {
			show_error('Audited accounts table not found for this customer database.', 500);
			return;
		}

		$data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
		$data['stateData'] = $this->db->select('*')->from('m_state')->where('active', 1)->get()->result();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['audited_account_id'] = $audited_account_id;
		$table = $customerDBSettingRow->database_name . '.' . $tableName;
		$data['auditedAccountRow'] = $this->db->select('*')->from($table)->where('audited_account_id', $audited_account_id)->get()->row();

		return $this->load->view('admin/add_edit_audited_account_modal', $data);
	}

	public function editAuditedAccount()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$tableName = 'audited_account';
		$tableExists = $this->db->query(
			"SELECT 1 FROM information_schema.tables WHERE table_schema = ? AND table_name = ? LIMIT 1",
			[$customerDBSettingRow->database_name, $tableName]
		)->row();
		if (empty($tableExists)) {
			show_error('Audited accounts table not found for this customer database.', 500);
			return;
		}

		$postData = $this->input->post(NULL, TRUE);
		$audited_account_id = $postData['audited_account_id'];
		if (empty($postData['user_id']) && !empty($session_data['user_id'])) {
			$postData['user_id'] = $session_data['user_id'];
		}

		if (isset($_FILES['file_url']) && $_FILES['file_url']['error'] == UPLOAD_ERR_OK) {
			$postData['file_url'] = file_upload('file_url', $audited_account_id, 'assets/doc/');
		}

		$table = $customerDBSettingRow->database_name . '.' . $tableName;
		$this->db->update($table, $postData, array('audited_account_id' => $audited_account_id));
		redirect('audited-account', 'refresh');
	}

	public function removeAuditedAccountModal($audited_account_id)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$tableName = 'audited_account';
		$tableExists = $this->db->query(
			"SELECT 1 FROM information_schema.tables WHERE table_schema = ? AND table_name = ? LIMIT 1",
			[$customerDBSettingRow->database_name, $tableName]
		)->row();
		if (empty($tableExists)) {
			show_error('Audited accounts table not found for this customer database.', 500);
			return;
		}

		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$table = $customerDBSettingRow->database_name . '.' . $tableName;
		$auditedAccountRow = $this->db->select('*')->from($table)->where('audited_account_id', $audited_account_id)->get()->row();
		$data['table'] = $table;
		$data['table_id'] = 'audited_account_id';
		$data['unique_id'] = $audited_account_id;
		$data['name'] = isset($auditedAccountRow->name) ? $auditedAccountRow->name : '';
		$data['route'] = 'audited-account';
		return $this->load->view('admin/remove_global_modal', $data);
	}
}
