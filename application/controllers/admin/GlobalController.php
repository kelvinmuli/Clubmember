<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GlobalController extends CI_Controller {

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

	}


	public function removeGlobalData() 
	{
		$postData = $this->input->post();
		$table = $postData['table'];
		$table_id = $postData['table_id'];
		$unique_id = $postData['unique_id'];
		if ($unique_id)
		{
			if (explode('.', $table)[1] == 'payment_history')
			{
				$database_name = explode('.', $table)[0];
				$paymentHistoryRow = $this->db->select('*')->from($table)->where($table_id, $unique_id)->get()->row();
				$this->db->delete($database_name.'.subscription', array('subscription_id'=>$paymentHistoryRow->universal_id));
			}
			if (explode('.', $table)[1] == 'subscription')
			{
				$database_name = explode('.', $table)[0];
				$subscriptionRow = $this->db->select('*')->from($table)->where($table_id, $unique_id)->get()->row();
				$this->db->delete($database_name.'.payment_history', array('universal_id'=>$subscriptionRow->subscription_id));
			}
			$this->db->delete($table, array($table_id=>$unique_id));
			$this->session->set_flashdata('success', 'Data removed successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Invalid request.');
		}

		redirect($_SERVER['HTTP_REFERER'], 'refresh');
	}

}
