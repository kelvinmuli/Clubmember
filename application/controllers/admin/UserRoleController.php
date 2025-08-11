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

	public function userRoleView()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('user-role');
		$data = $headerData;

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/user_role_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
	}	

	public function userRoleAddEdit($postData)
	{
        $postDataExplode = explode('-', $postData);
        $sqlDataExplode = explode('_', $postDataExplode[2]);
        $userRightData = $this->db->select('*')->from('user_right')->where('user_type_id', $postDataExplode[0])->where('module_id', $postDataExplode[1])->get()->row();
        if ($userRightData) 
		{
			$this->db->update('user_right', array($sqlDataExplode[0]=>$sqlDataExplode[1]), array('user_right_id'=>$userRightData->user_right_id));
			$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$postDataExplode[0].' : '.$postDataExplode[1].' : User role updated successful'));
        } 
		else 
		{
			$this->db->insert('user_right', array('user_right_id'=>generate_uuid(), 'user_type_id'=>$postDataExplode[0], 'module_id'=>$postDataExplode[1]));  
			$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$postDataExplode[0].' : '.$postDataExplode[1].' : User role added successful'));
        }
		print_r($postDataExplode[0]);
    }
	
	public function userRoleAdd($postData)
	{
		$postDataExplode = explode('-', $postData);
		$this->db->insert('user_right', array('user_right_id'=>generate_uuid(), 'user_type_id'=>$postDataExplode[0], 'module_id'=>$postDataExplode[1]));
		print_r($postDataExplode[0]);
	}

	public function userRoleDelete($postData)
	{
		$postDataExplode = explode('-', $postData);
		$result = $this->db->delete('user_right', array('user_type_id'=>$postDataExplode[0], 'module_id'=>$postDataExplode[1]));
		print_r($postDataExplode[0]);
	}

	public function userTypeRoleAddEdit($postData)
	{
        $postDataExplode = explode('-', $postData);
        $sqlDataExplode = explode('_', $postDataExplode[2]);
        $userTypeRightData = $this->db->select('*')->from('user_type_right')->where('user_type_id', $postDataExplode[0])->where('ware_house_id', $postDataExplode[1])->get()->row();
        if ($userTypeRightData) 
		{
			$this->db->update('user_type_right', array($sqlDataExplode[0]=>$sqlDataExplode[1]), array('user_type_right_id'=>$userTypeRightData->user_type_right_id));
			$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$postDataExplode[0].' : '.$postDataExplode[1].' : User type role updated successful'));
        } 
		else 
		{
			$this->db->insert('user_type_right', array('user_type_right_id'=>generate_uuid(), 'user_type_id'=>$postDataExplode[0], 'ware_house_id'=>$postDataExplode[1]));  
			$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$postDataExplode[0].' : '.$postDataExplode[1].' : User type role added successful'));
        }
		print_r($postDataExplode[0]);
    }
	
	public function userTypeRoleAdd($postData)
	{
		$postDataExplode = explode('-', $postData);
		$this->db->insert('user_type_right', array('user_type_right_id'=>generate_uuid(), 'user_type_id'=>$postDataExplode[0], 'ware_house_id'=>$postDataExplode[1]));
		print_r($postDataExplode[0]);
	}

	public function userTypeRoleDelete($postData)
	{
		$postDataExplode = explode('-', $postData);
		$result = $this->db->delete('user_type_right', array('user_type_id'=>$postDataExplode[0], 'ware_house_id'=>$postDataExplode[1]));
		print_r($postDataExplode[0]);
	}

	public function userSubMenuRoleAddEdit($postData)
	{
        $postDataExplode = explode('-', $postData);
        $sqlDataExplode = explode('_', $postDataExplode[3]);
        $userRightData = $this->db->select('*')->from('user_sub_menu_right')->where('user_type_id', $postDataExplode[0])->where('module_id', $postDataExplode[1])->where('record_management_id', $postDataExplode[2])->get()->row();
        if ($userRightData) 
		{
			$this->db->update('user_sub_menu_right', array($sqlDataExplode[0]=>$sqlDataExplode[1]), array('user_sub_menu_right_id'=>$userRightData->user_sub_menu_right_id));
			$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$postDataExplode[0].' : '.$postDataExplode[1].' : User sub menu role updated successful'));
        } 
		else 
		{
			$this->db->insert('user_sub_menu_right', array('user_sub_menu_right_id'=>generate_uuid(), 'user_type_id'=>$postDataExplode[0], 'module_id'=>$postDataExplode[1], 'record_management_id'=>$postDataExplode[2]));  
			$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$postDataExplode[0].' : '.$postDataExplode[1].' : User sub menu role added successful'));
        }
		print_r($postDataExplode[0]);
    }

	public function userModuleTypeRoleAddEdit($postData)
	{
        $postDataExplode = explode('-', $postData);
        $sqlDataExplode = explode('_', $postDataExplode[3]);
        $userRightData = $this->db->select('*')->from('user_module_type_right')->where('user_type_id', $postDataExplode[0])->where('module_id', $postDataExplode[1])->where('module_type_id', $postDataExplode[2])->get()->row();
        if ($userRightData) 
		{
			$this->db->update('user_module_type_right', array($sqlDataExplode[0]=>$sqlDataExplode[1]), array('user_module_type_right_id'=>$userRightData->user_module_type_right_id));
			$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$postDataExplode[0].' : '.$postDataExplode[1].' : User module type role updated successful'));
        } 
		else 
		{
			$this->db->insert('user_module_type_right', array('user_module_type_right_id'=>generate_uuid(), 'user_type_id'=>$postDataExplode[0], 'module_id'=>$postDataExplode[1], 'module_type_id'=>$postDataExplode[2]));  
			$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$postDataExplode[0].' : '.$postDataExplode[1].' : User module type role added successful'));
        }
		print_r($postDataExplode[0]);
    }
}
