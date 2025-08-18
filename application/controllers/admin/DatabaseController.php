<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DatabaseController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function index() 
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('customer-db-config');
		$data = $headerData;

		$data['customerData'] = $this->db->select('*')->from('customer')->where('active', 1)->get()->result();
		$data['customerDBSettingData'] = $this->db->select('*')->from('customer_db_setting')->where('active', 1)->get()->result();
		$data['databaseStatusData'] = $this->db->select('*')->from('m_database_status')->where('active', 1)->get()->result();

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/customer_db_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
    }

	public function createCustomerDatabase()
	{
		$postData = $this->input->post();
		$newDatabaseName = GlobalModel::EXTENSION_DB.'ccm_'.$postData['database_name'];
		$postData['customer_db_setting_id'] = generate_uuid();
		$postData['database_name'] = $newDatabaseName;
		$this->db->insert('customer_db_setting', $postData);

		$this->db->query("CREATE DATABASE `$newDatabaseName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
		$oldDatabaseName = GlobalModel::EXTENSION_DB.GlobalModel::CUSTOMER_DB_COPY;
		$tables = $this->db->query("SHOW TABLES FROM ".$oldDatabaseName)->result_array();

		foreach ($tables as $table) 
		{
			$tableName = array_values($table)[0];
			$this->db->query("CREATE TABLE `$newDatabaseName`.`$tableName` LIKE `$oldDatabaseName`.`$tableName`");
			$this->db->query("INSERT INTO `$newDatabaseName`.`$tableName` SELECT * FROM `$oldDatabaseName`.`$tableName`");
		}

		$this->session->set_flashdata('Database configuration saved successfully. DB Name: '.$newDatabaseName);
    	redirect('customer-db-config');
	}
}
