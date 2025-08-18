<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		$this->profileView();
	}

	public function profileView($user_id='', $customer_db_setting_id='', $user_option_id='1752581178334')
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('all-user');

		$localUserId = $user_id == NULL ? $session_data['user_id'] : $user_id;  
		$localCustomerDBSettingId = $customer_db_setting_id == NULL ? $session_data['customer_db_setting_id'] : $customer_db_setting_id; 
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $localCustomerDBSettingId)->get()->row();
		$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $localUserId)->get()->row();
		$data = json_decode(json_encode($userRow), true);
		$data['user_option_id'] = $user_option_id;

		// $data['userTypeOptionData'] = $this->db->select('*')->from('m_user_type_option')->where('user_type_id', $userRow->user_type_id)->get()->result();

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/profile_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
	}

	public function userView($userTypeId='', $customer_db_setting_id='')
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('all-user');
		
		$data['userTypeId'] = $userTypeId;
		$data['customerDBSettingId'] = $customer_db_setting_id ?? GlobalModel::DEFAULT_CORE_DB_SETTING;
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$data['userData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_type_id', $userTypeId)->get()->result();
		$data['userTypeData'] = $this->db->select('*')->from('m_user_type')->where('active', 1)->get()->result();
		$data['customerDBSettingData'] = $this->db->select('*')->from('customer_db_setting')->where('active', 1)->get()->result();
		

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/user_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
	}

	public function getUserList($user_type_id, $customer_db_setting_id)
	{
		$this->common->checkSession();
		$headerData = $this->common->loadHeaderData('all-user');
		$approveUserRight = $headerData['approveUserRight'];
		$editUserRight = $headerData['editUserRight'];
		$removeUserRight = $headerData['removeUserRight'];

		$userTypeRow = $this->db->select('*')->from('m_user_type')->where('user_type_id', $user_type_id)->get()->row();
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$userData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_type_id', $user_type_id)->get()->result();
		
		$u = 0;
		$userDataArray = [];
		foreach ($userData as $user) 
		{	
			$actions = '';
			if ($approveUserRight || $editUserRight || $removeUserRight):
				$actions .= '<td>
								<span class="dropdown">
									<button class="btn dropdown-toggle align-text-top btn-pill" data-bs-boundary="viewport" data-bs-toggle="dropdown">View & Edit</button>
									<div class="dropdown-menu dropdown-menu-end">
										<a class="dropdown-item" href="'.base_url('profile/'.$user->user_id.'/'.$customer_db_setting_id).'">View</a>';
										if ($editUserRight):
											$actions .= '<a class="dropdown-item" onclick="editUserModal(\''.$user->user_id.'\', \''.$customer_db_setting_id.'\')">Edit</a>';
										endif;
										if ($removeUserRight):
											$actions .= '<a class="dropdown-item" onclick="deleteUserModal(\''.$user->user_id.'\', \''.$customer_db_setting_id.'\')"><span style="color: red;">Delete</span></a>';
										endif;
									$actions .= '</div>
								</span>	
							</td>';
			endif;
			$userDataArray[] = array(++$u.'.', $user->full_legal_name, $user->phone_number, $user->email, $user->created_at, $actions);
		}

		print_r(json_encode(array("draw"=>1, "recordsTotal"=>count($userDataArray), "recordsFiltered"=>count($userDataArray), "data"=>$userDataArray)));
	}

	public function addUserModal($user_type_id, $customer_db_setting_id)
	{
		$this->common->checkSession(array('dialog'=>1));

		$userTypeRow = $this->db->select('*')->from('m_user_type')->where('user_type_id', $user_type_id)->get()->row();
		$customerDBSettingData = $this->db->select('*')->from('customer_db_setting')->where('active', 1)->get()->result();
		$genderData = $this->db->select('*')->from('m_gender')->where('active', 1)->get()->result();
		$countryData = $this->db->select('*')->from('m_country')->where('active', 1)->get()->result();

		$modal ='<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add New '.$userTypeRow->name.'</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('add-user').'" method="POST" enctype="multipart/form-data">	
							<input id="customer_db_setting_id" name="customer_db_setting_id" type="text" value="'.$customer_db_setting_id.'" hidden>
							<input id="user_id" name="user_id" type="text" value="'.generate_uuid().'" hidden>		
							<input id="user_type_id" name="user_type_id" type="text" value="'.$user_type_id.'" hidden>		
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Customer</label>
											<select id="customer_db_setting_id" name="gender_id" class="form-select btn-pill" required>
												<option selected disabled>Select Customer</option>';
												if (isset($customerDBSettingData)): foreach($customerDBSettingData as $customerDBSetting):
													$modal .= '<option value="'.$customerDBSetting->customer_db_setting_id.'" '.($customerDBSetting->customer_db_setting_id == $customer_db_setting_id ? 'selected' : '').'>'.get_table('customer', 'customer_id', $customerDBSetting->customer_id, 'full_legal_name').'</option>';
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
											<label class="form-label">Photo</label>
											<input id="url" name="url" type="file" class="form-control btn-pill" placeholder="Upload Your Photo">
										</div>	
									</div>
									<div class="col-lg-6">	
										<div class="mb-3">
											<label class="form-label">Full Legal Name*</label>
											<input id="full_legal_name" name="full_legal_name" type="text" class="form-control btn-pill" placeholder="Your Full Legal Name" required>
										</div>	
									</div>	
									<div class="col-lg-6">	
										<div class="mb-3">
											<label class="form-label">Phone Number*</label>
											<input id="phone_number" name="phone_number" type="number" class="form-control btn-pill" placeholder="Enter your phone number" required>
										</div>	
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Gender</label>
											<select id="gender_id" name="gender_id" class="form-select btn-pill" required>
												<option selected disabled>Select Gender</option>';
												if (isset($genderData)): foreach($genderData as $data):
													$modal .= '<option value="'.$data->gender_id.'">'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-6">							
										<div class="mb-3">
											<label class="form-label">Date of Birth</label>
											<input id="birth" name="birth" type="date" class="form-control btn-pill" required>
										</div>
									</div>
									<div class="col-lg-6">							
										<div class="mb-3">
											<label class="form-label">Email Address</label>
											<input id="email" name="email" type="email" class="form-control btn-pill" placeholder="Enter your email address">
										</div>	
									</div>
									<div class="col-lg-6">	
										<div class="mb-3">
											<label class="form-label">ID Number / Passport Number</label>
											<input id="id_no" name="id_no" type="number" class="form-control btn-pill" placeholder="Enter your id number">
										</div>	
									</div>
									<div class="col-lg-6">							
										<div class="mb-3">
											<label class="form-label">Residential Address</label>
											<input id="residential_address" name="residential_address" type="text" class="form-control btn-pill" placeholder="Enter Residential Address">
										</div>	
									</div>
									<div class="col-lg-6">							
										<div class="mb-3">
											<label class="form-label">Postal Address</label>
											<input id="postal_address" name="postal_address" type="text" class="form-control btn-pill" placeholder="Enter Postal Address">
										</div>	
									</div>
									<div class="col-lg-6">							
										<div class="mb-3">
											<label class="form-label">Postal Code</label>
											<input id="postal_code" name="postal_code" type="text" class="form-control btn-pill" placeholder="Enter Postal Code">
										</div>	
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Country</label>
											<select id="country_id" name="country_id" class="form-select btn-pill" required>
												<option selected disabled>Select Country</option>';
												if (isset($countryData)): foreach($countryData as $data):
													$modal .= '<option value="'.$data->country_id.'">'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
								</div>
							</div>';
							if (in_array($user_type_id, array('4734656482', '4534654653'))):
								$modal .='<div class="modal-body">
									<div class="row">
										<div class="col-lg-12">							
											<div class="mb-3">
												<label class="form-label">Password</label>
												<input id="password" name="password" type="password" class="form-control btn-pill" placeholder="Enter Password">
											</div>	
										</div>
									</div>
								</div>';
							endif;
							$modal .='<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">							
										<div class="mb-3">
											<label class="form-label">Contact Name</label>
											<input id="contact_name" name="contact_name" type="text" class="form-control btn-pill" placeholder="Enter Contact Name">
										</div>	
									</div>
									<div class="col-lg-6">							
										<div class="mb-3">
											<label class="form-label">Contact No.</label>
											<input id="contact_phone_no" name="contact_phone_no" type="text" class="form-control btn-pill" placeholder="Enter Contact No.">
										</div>	
									</div>
								</div>
							</div>';
							$modal .='<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">							
										<div class="mb-3">
											<label class="form-label">Sub Reference No.</label>
											<input id="sub_reference_no" name="sub_reference_no" type="text" class="form-control btn-pill" placeholder="Enter Sub Reference No.">
										</div>	
									</div>
								</div>
							</div>';
							$modal .='<div class="modal-body">
								<div class="row">
									<div class="col-lg-12">							
										<div class="mb-3">
											<label class="form-label">Notes</label>
											<textarea id="remark" name="remark" type="text" class="form-control" placeholder="Enter Notes"></textarea>
										</div>	
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary " data-bs-dismiss="modal">Cancel</a>
								<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
									Add '.$userTypeRow->name.'
								</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function addUser()
	{
		$postData = $this->input->post();
		$customer_db_setting_id = $postData['customer_db_setting_id'];
		$user_type_id = $postData['user_type_id'];
		$full_legal_name = $postData['full_legal_name'];
		$email = $postData['email'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();

		$path = "assets/img/";
		if (isset($_FILES['url']['name']))
		{
			$image = do_file_upload('url', $path);
			$postData['url'] = $path.$image['file']['file_name'];
		}
		else
		{
			unset($postData['url']);
		}

		if (empty($postData['password'])) 
		{
			$postData['password'] = password_hash(explode('@', $postData['email'])[0], PASSWORD_DEFAULT);
		} else {
			$postData['password'] = password_hash($postData['password'], PASSWORD_DEFAULT);
		}
		unset($postData['customer_db_setting_id']);
		$this->db->insert($customerDBSettingRow->database_name.'.user', $postData);
		$description = $full_legal_name.' added successfully. ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$email.' : User for '.$description));
		redirect('all-user/'.$user_type_id.'/'.$customer_db_setting_id, 'refresh');
	}
}