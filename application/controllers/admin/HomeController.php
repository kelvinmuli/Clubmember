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
		}
		$data['customerData'] = $customerData;
		$data['total_customers'] = count($customerData);

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/home_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
	}
}