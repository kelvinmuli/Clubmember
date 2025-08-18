<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UserRoleController extends CI_Controller {

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
	public function __construct() {
		parent::__construct();
	}

	public function userRoleView($selected='')
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('user-role');
		$data = $headerData;

		// $data['selected'] = $selected;
		$data['customerDBSettingRow'] = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		if ($session_data['customer_db_setting_id'] != '1755387775468')
			$data['userTypeData'] = $this->db->select('*')->from('m_user_type')->where_in('user_type_id', array('4534654653', '1755383886420'))->where('active', 1)->get()->result();

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/user_role_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
	}	

	public function userRoleAddEdit($postData)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
        $postDataExplode = explode('-', $postData);
        $sqlDataExplode = explode('_', $postDataExplode[2]);
        $userRightData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user_right')->where('user_type_id', $postDataExplode[0])->where('module_id', $postDataExplode[1])->get()->row();
        if ($userRightData) 
		{
			$this->db->update($customerDBSettingRow->database_name.'.user_right', array($sqlDataExplode[0]=>$sqlDataExplode[1]), array('user_right_id'=>$userRightData->user_right_id));
			$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$postDataExplode[0].' : '.$postDataExplode[1].' : User role updated successful'));
        } 
		else 
		{
			$this->db->insert($customerDBSettingRow->database_name.'.user_right', array('user_right_id'=>generate_uuid(), 'user_type_id'=>$postDataExplode[0], 'module_id'=>$postDataExplode[1]));  
			$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$postDataExplode[0].' : '.$postDataExplode[1].' : User role added successful'));
        }
		print_r($postDataExplode[0]);
    }
	
	public function userRoleAdd($postData)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$postDataExplode = explode('-', $postData);
		$result = $this->db->insert($customerDBSettingRow->database_name.'.user_right', array('user_right_id'=>generate_uuid(), 'user_type_id'=>$postDataExplode[0], 'module_id'=>$postDataExplode[1]));
		print_r($result);
	}

	public function userRoleDelete($postData)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$postDataExplode = explode('-', $postData);
		$result = $this->db->delete($customerDBSettingRow->database_name.'.user_right', array('user_type_id'=>$postDataExplode[0], 'module_id'=>$postDataExplode[1]));
		print_r($result);
	}
	
}
