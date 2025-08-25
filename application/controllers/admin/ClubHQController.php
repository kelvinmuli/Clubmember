<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ClubHQController extends CI_Controller {

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


		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/500_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
    }

	public function importantDocumentView() 
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('important-document');
		$data = $headerData;

		$data['customerData'] = $this->db->select('*')->from('customer')->where('active', 1)->get()->result();
		$data['databaseStatusData'] = $this->db->select('*')->from('m_database_status')->where('active', 1)->get()->result();

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/important_document_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
    }

	public function noticeBoardView() 
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('notice-board');
		$data = $headerData;


		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/notice_board_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
    }

	public function addCustomerModal()
	{
		$this->common->checkSession(array('dialog'=>1));
		
		$customerTypeData = $this->db->select('*')->from('m_customer_type')->where('active', 1)->get()->result();
		$countryData = $this->db->select('*')->from('m_country')->where('active', 1)->get()->result();
		$customerStatusData = $this->db->select('*')->from('m_customer_status')->where('active', 1)->get()->result();
		$countyData = $this->db->select('*')->from('m_county')->where('active', 1)->get()->result();

		$modal ='<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">New Customer</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('add-customer').'" method="post" enctype="multipart/form-data" class="modal-content">
							<input id="customer_id" name="customer_id" type="text" value="'.generate_uuid().'" hidden>
							<div class="modal-body">
								<div class="row">					
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="edit-logo" class="form-label">Logo (optional)</label>
											<input type="file" name="logo" id="edit-logo" class="form-control btn-pill">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="full_legal_name" class="form-label">Name</label>
											<input id="full_legal_name" name="full_legal_name" type="text" class="form-control btn-pill" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="edit-short_name" class="form-label">Short Name</label>
											<input id="short_name" name="short_name" type="text" class="form-control btn-pill" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="edit-email" class="form-label">Email Address</label>
											<input type="email" class="form-control btn-pill" name="email" id="edit-email" required>
										</div>
									</div>
								</div>	
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="id="customer_type_id" class="form-label">Customer Type</label>
											<select id="customer_type_id" name="customer_type_id" class="form-select btn-pill">
												<option selected disabled>Select Customer Type</option>';
												if (isset($customerTypeData)): foreach($customerTypeData as $data):
													$modal .= '<option value="'.$data->customer_type_id.'">'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="phone_number" class="form-label">Telephone Number</label>
											<input id="phone_number" name="phone_number" type="text" class="form-control btn-pill">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="physical_address" class="form-label">Physical Address</label>
											<input id="physical_address" name="physical_address" type="text" class="form-control btn-pill">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="postal_address" class="form-label">Postal Address</label>
											<input id="postal_address" name="postal_address" type="text" class="form-control btn-pill">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="town_id" class="form-label">Town</label>
											<input id="town_id" name="town_id" type="text" class="form-control btn-pill">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="edit-regno" class="form-label">Registration Number</label>
											<input id="reg_no" name="reg_no" type="text" class="form-control btn-pill">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Country</label>
											<select id="country_id" name="country_id" class="form-select btn-pill">
												<option selected disabled>Select Country</option>';
												if (isset($countryData)): foreach($countryData as $data):
													$modal .= '<option value="'.$data->country_id.'">'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">County</label>
											<select id="county_id" name="county_id" class="form-select btn-pill">
												<option selected disabled>Select County</option>';
												if (isset($countyData)): foreach($countyData as $data):
													$modal .= '<option value="'.$data->county_id.'">'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
								</div>	
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="edit-agreement" class="form-label">Agreement (optional)</label>
											<input type="file" name="agreement" id="edit-agreement" class="form-control btn-pill">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="edit-status" class="form-label">Customer Status</label>
											<select id="customer_status_id" name="customer_status_id" class="form-select btn-pill">
												<option selected disabled>Select Customer Status</option>';
												if (isset($customerStatusData)): foreach($customerStatusData as $data):
													$modal .= '<option value="'.$data->customer_status_id.'">'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary " data-bs-dismiss="modal">Cancel</a>
								<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
									Add Customer
								</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
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
		$customerTypeData = $this->db->select('*')->from('m_customer_type')->where('active', 1)->get()->result();
		$countryData = $this->db->select('*')->from('m_country')->where('active', 1)->get()->result();
		$customerStatusData = $this->db->select('*')->from('m_customer_status')->where('active', 1)->get()->result();

		$modal ='<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit '.$customerRow->full_legal_name.'</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('edit-customer').'" method="post" enctype="multipart/form-data" class="modal-content">
							<input id="customer_id" name="customer_id" type="text" value="'.$customerRow->customer_id.'" hidden>
							<div class="modal-body">
								<div class="row">					
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="edit-logo" class="form-label">Logo (optional)</label>
											<input type="file" name="logo" id="edit-logo" class="form-control btn-pill">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="full_legal_name" class="form-label">Name</label>
											<input id="full_legal_name" name="full_legal_name" type="text" class="form-control btn-pill" value="'.$customerRow->full_legal_name.'" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="edit-short_name" class="form-label">Short Name</label>
											<input id="short_name" name="short_name" type="text" class="form-control btn-pill" value="'.$customerRow->short_name.'" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="edit-email" class="form-label">Email Address</label>
											<input type="email" class="form-control btn-pill" name="email" id="edit-email" value="'.$customerRow->email.'" required>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="id="customer_type_id" class="form-label">Customer Type</label>
											<select id="customer_type_id" name="customer_type_id" class="form-select btn-pill">
												<option selected disabled>Select Customer Type</option>';
												if (isset($customerTypeData)): foreach($customerTypeData as $data):
													$modal .= '<option value="'.$data->customer_type_id.'" '.($data->customer_type_id == $customerRow->customer_type_id ? 'selected' : '').'>'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="phone_number" class="form-label">Telephone Number</label>
											<input id="phone_number" name="phone_number" type="text" class="form-control btn-pill" value="'.$customerRow->phone_number.'">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="physical_address" class="form-label">Physical Address</label>
											<input id="physical_address" name="physical_address" type="text" class="form-control btn-pill" value="'.$customerRow->physical_address.'">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="postal_address" class="form-label">Postal Address</label>
											<input id="postal_address" name="postal_address" type="text" class="form-control btn-pill" value="'.$customerRow->postal_address.'">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="edit-regno" class="form-label">Registration Number</label>
											<input id="reg_no" name="reg_no" type="text" class="form-control btn-pill" value="'.$customerRow->postal_address.'">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Country</label>
											<select id="country_id" name="country_id" class="form-select btn-pill">
												<option selected disabled>Select Country</option>';
												if (isset($countryData)): foreach($countryData as $data):
													$modal .= '<option value="'.$data->country_id.'" '.($data->country_id == $customerRow->country_id ? 'selected' : '').'>'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
								</div>	
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="edit-agreement" class="form-label">Agreement (optional)</label>
											<input type="file" name="agreement" id="edit-agreement" class="form-control btn-pill">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="edit-status" class="form-label">Customer Status</label>
											<select id="customer_status_id" name="customer_status_id" class="form-select btn-pill">
												<option selected disabled>Select Customer Status</option>';
												if (isset($customerStatusData)): foreach($customerStatusData as $data):
													$modal .= '<option value="'.$data->customer_status_id.'" '.($data->customer_status_id == $customerRow->customer_status_id ? 'selected' : '').'>'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary " data-bs-dismiss="modal">Cancel</a>
								<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
									Update
								</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
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
								<input name="customer_id" value="'.$customerRow->customer_id.'" hidden>
								Are you sure you want to delete <strong id="deleteCustomerName"></strong>?
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
		$this->db->delete('customer', array('customer_id'=>$customer_id));
		$description = $full_legal_name.' deleted successfully. ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$customer_id.' : Customer for '.$description));
		redirect('customer', 'refresh');
	}
}
