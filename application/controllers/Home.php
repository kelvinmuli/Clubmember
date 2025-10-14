<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$checkHost = false;
		$host = $_SERVER['HTTP_HOST'];
		$customerDBSettingData = $this->db->select('*')->from('customer_db_setting')->get()->result();
		foreach ($customerDBSettingData as $customerDBSetting) 
		{
			if (strpos($host, $customerDBSetting->host.'.') === 0) 
			{
				$checkHost = true;
				redirect('logon/'.$customerDBSetting->customer_db_setting_id, 'refresh');
			}
		}

        if (!$checkHost) 
		{
            $this->load->view('home_view');
			// $this->load->view('front/templates/footer_view');
        }
	}
}
