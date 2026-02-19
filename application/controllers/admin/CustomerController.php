<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerController extends CI_Controller {

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
		$headerData = $this->common->loadHeaderData('customer');
		$data = $headerData;

		$data['customerData'] = $this->db->select('*')->from('customer')->where('active', 1)->get()->result();
		$data['databaseStatusData'] = $this->db->select('*')->from('m_database_status')->where('active', 1)->get()->result();

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/customer_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
    }

	public function addCustomerModal()
	{
		$this->common->checkSession(array('dialog'=>1));
		print_r($this->addEditCustomerModal());
	}

	protected function addEditCustomerModal($customerRow = null)
	{
		$customerTypeData = $this->db->select('*')->from('m_customer_type')->where('active', 1)->get()->result();
		$countryData = $this->db->select('*')->from('m_country')->where('active', 1)->get()->result();
		$customerStatusData = $this->db->select('*')->from('m_customer_status')->where('active', 1)->get()->result();
		$countyData = $this->db->select('*')->from('m_county')->where('active', 1)->get()->result();
		$timePeriodData = $this->db->select('*')->from('m_time_period')->where('active', 1)->get()->result();

		$timePeriodDataArray = [];
		foreach ($timePeriodData as $data)
		{
			$timePeriodDataArray[$data->period_id][] = $data;
		}

		$isEdit = $customerRow ? true : false;
		$customerId = $isEdit ? $customerRow->customer_id : generate_uuid();
		$actionUrl = $isEdit ? base_url('edit-customer') : base_url('add-customer');
		$modalTitle = $isEdit ? ('Edit '.$customerRow->full_legal_name) : 'New Customer';
		$submitLabel = $isEdit ? 'Update' : 'Add Customer';

		$data = array(
			'isEdit' => $isEdit,
			'actionUrl' => $actionUrl,
			'modalTitle' => $modalTitle,
			'submitLabel' => $submitLabel,
			'customerId' => $customerId,
			'customerRow' => $customerRow,
			'customerTypeData' => $customerTypeData,
			'countryData' => $countryData,
			'customerStatusData' => $customerStatusData,
			'countyData' => $countyData,
			'timePeriodDataArray' => $timePeriodDataArray,
		);

		return $this->load->view('admin/add_edit_customer_modal', $data, true);
	}

	public function addCustomer()
	{
		$postData = $this->input->post();
		$customer_id = $postData['customer_id'];
		$full_legal_name = $postData['full_legal_name'];

		
		if (isset($_FILES['logo']['name']))
		{
			$path = "assets/img/";
			$image = do_file_upload('logo', $path);
			$postData['logo'] = $path.$image['file']['file_name'];
		}

		if (isset($_FILES['agreement']['name']))
		{
			$path = "assets/doc/";
			$image = do_file_upload('agreement', $path);
			$postData['agreement'] = $path.$image['file']['file_name'];
		}
		
		$this->db->insert('customer', $postData);
		$description = $full_legal_name.' added successfully. ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$customer_id.' : Customer for '.$description));
		redirect('customer', 'refresh');
	}

	public function editCustomerModal($customer_id)
	{
		$this->common->checkSession(array('dialog'=>1));

		$customerRow = $this->db->select('*')->from('customer')->where('customer_id', $customer_id)->get()->row();
		print_r($this->addEditCustomerModal($customerRow));
	}

	public function editCustomer()
	{
		$postData = $this->input->post();
		$customer_id = $postData['customer_id'];
		$full_legal_name = $postData['full_legal_name'];

		
		if (isset($_FILES['logo']['name']))
		{
			$path = "assets/img/";
			$image = do_file_upload('logo', $path);
			$postData['logo'] = $path.$image['file']['file_name'];
		}

		if (isset($_FILES['agreement']['name']))
		{
			$path = "assets/doc/";
			$image = do_file_upload('agreement', $path);
			$postData['agreement'] = $path.$image['file']['file_name'];
		}
		unset($postData['customer_id']);
		$this->db->update('customer', $postData, array('customer_id'=>$customer_id));
		$description = $full_legal_name.' updated successfully. ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$customer_id.' : Customer for '.$description));
		redirect('customer', 'refresh');
	}

	public function removeCustomerModal($customer_id)
	{
		$this->common->checkSession(array('dialog'=>1));

		$customerRow = $this->db->select('*')->from('customer')->where('customer_id', $customer_id)->get()->row();

		$modal ='<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Confirm Deletion</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>
							
						<form method="POST" action="'.base_url('remove-customer').'">
							<div class="modal-body">
								<input name="customer_id" value="'.$customer_id.'" hidden>
								<input name="full_legal_name" value="'.$customerRow->full_legal_name.'" hidden>
								Are you sure you want to delete '.$customerRow->full_legal_name.'?
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-danger">Yes, Delete</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function removeCustomer()
	{
		$postData = $this->input->post();
		$customer_id = $postData['customer_id'];
		$full_legal_name = $postData['full_legal_name'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_id', $customer_id)->get()->row();
		$this->db->query("DROP DATABASE `$customerDBSettingRow->database_name`");
		$this->db->delete('customer', array('customer_id'=>$customer_id));
		$this->db->delete('customer_db_setting', array('customer_id'=>$customer_id));
		$description = $full_legal_name.' deleted successfully. ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$customer_id.' : Customer for '.$description));
		redirect('customer', 'refresh');
	}
}
