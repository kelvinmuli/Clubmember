<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AgmMinutesController extends CI_Controller {

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

	public function agmMinutesView() 
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$data = $this->common->loadHeaderData('agm-minutes');
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$data['agmMinutesData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.agm_minutes')->where('active', 1)->order_by('created_at', 'DESC')->get()->result();

		$this->load->view('admin/templates/header_view', $data);
		$this->load->view('admin/agm_minutes_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
	}

	public function addAgmMinutesModal() 
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['agm_minutes_id'] = generate_uuid();

		return $this->load->view('admin/add_edit_agm_minutes_modal', $data);
	}

	public function addAgmMinutes() 
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$postData = $this->input->post();
		$agm_minutes_id = $postData['agm_minutes_id'];
		if (isset($_FILES['doc_url']) && $_FILES['doc_url']['error'] == UPLOAD_ERR_OK) {
			$postData['doc_url'] = file_upload('doc_url', $agm_minutes_id, 'assets/doc/');
		}

		$this->db->insert($customerDBSettingRow->database_name.'.agm_minutes', $postData);

		// echo json_encode(array('state'=>'success', 'message'=>'AGM Minutes saved successfully.'));
		redirect('agm-minutes', 'refresh');
	}

	public function viewAgmMinutesModal($agm_minutes_id = null)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];

		$data = [
			'agmMinutesRow' => null,
			'agm_minutes_id' => $agm_minutes_id,
		];

		$customerDBSettingRow = $this->db
			->select('*')
			->from('customer_db_setting')
			->where('customer_db_setting_id', $customer_db_setting_id)
			->get()
			->row();

		if (!empty($customerDBSettingRow) && !empty($agm_minutes_id)) {
			$data['agmMinutesRow'] = $this->db
				->select('*')
				->from($customerDBSettingRow->database_name . '.agm_minutes')
				->where('agm_minutes_id', $agm_minutes_id)
				->get()
				->row();
		}

		return $this->load->view('admin/view_agm_minutes_modal', $data);
	}


	public function editAgmMinutesModal($agm_minutes_id) 
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['agm_minutes_id'] = $agm_minutes_id;
		$data['agmMinutesRow'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.agm_minutes')->where('agm_minutes_id', $agm_minutes_id)->get()->row();

		return $this->load->view('admin/add_edit_agm_minutes_modal', $data);
	}

	public function editAgmMinutes() 
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$postData = $this->input->post();
		$agm_minutes_id = $postData['agm_minutes_id'];
		if (isset($_FILES['doc_url']) && $_FILES['doc_url']['error'] == UPLOAD_ERR_OK) {
			$postData['doc_url'] = file_upload('doc_url', $agm_minutes_id, 'assets/doc/');
		}

		$this->db->update($customerDBSettingRow->database_name.'.agm_minutes', $postData, array('agm_minutes_id'=>$agm_minutes_id));
		// echo json_encode(array('state'=>'success', 'message'=>'AGM Minutes updated successfully.'));
		redirect('agm-minutes', 'refresh');
	}

	public function removeAgmMinutesModal($agm_minutes_id) 
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$agmMinutesRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.agm_minutes')->where('agm_minutes_id', $agm_minutes_id)->get()->row();
		$data['table'] = $customerDBSettingRow->database_name.'.agm_minutes';
		$data['table_id'] = 'agm_minutes_id';
		$data['unique_id'] = $agm_minutes_id;
		$data['name'] = isset($agmMinutesRow->name) ? $agmMinutesRow->name : '';
		$data['route'] = 'agm-minutes';
		return $this->load->view('admin/remove_global_modal', $data);
	}

}
