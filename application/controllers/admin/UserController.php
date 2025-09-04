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
		$data['customerDBSettingId'] = empty($customer_db_setting_id) ? GlobalModel::DEFAULT_CORE_DB_SETTING : $customer_db_setting_id;
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$data['userData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_type_id', $userTypeId)->get()->result();
		$data['userTypeData'] = $this->db->select('*')->from('m_user_type')->where('active', 1)->get()->result();
		$data['membershipTypeData'] = $this->db->select('*')->from('m_membership_type')->where('active', 1)->get()->result();
		if (in_array($session_data['user_type_id'], array(GlobalModel::ADMIN_TYPE)))
			$customerDBSettingData = $this->db->select('*')->from('customer_db_setting')->where('active', 1)->get()->result();
		else
			$customerDBSettingData = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->where('active', 1)->get()->result();
		$data['customerDBSettingData'] = $customerDBSettingData;

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
			$userDataArray[] = array(++$u.'.', $user->full_legal_name, $user->phone_number, $user->email, ($user->membership_no ?? '-'), $user->residential_address, $user->created_at, $actions);
		}

		print_r(json_encode(array("draw"=>1, "recordsTotal"=>count($userDataArray), "recordsFiltered"=>count($userDataArray), "data"=>$userDataArray)));
	}

	public function addUserModal($user_type_id, $membership_type_id, $customer_db_setting_id)
	{
		$this->common->checkSession(array('dialog'=>1));

		$membershipTypeRow = $this->db->select('*')->from('m_membership_type')->where('membership_type_id', $membership_type_id)->get()->row();
		$userTypeRow = $this->db->select('*')->from('m_user_type')->where('user_type_id', $user_type_id)->get()->row();
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$customerDBSettingData = $this->db->select('*')->from('customer_db_setting')->where('active', 1)->get()->result();
		$genderData = $this->db->select('*')->from('m_gender')->where('active', 1)->get()->result();
		$countryData = $this->db->select('*')->from('m_country')->where('active', 1)->get()->result();
		$titleData = $this->db->select('*')->from('m_title')->where('active', 1)->get()->result();
		if ($customer_db_setting_id != GlobalModel::DEFAULT_CORE_DB_SETTING) {
			$memberTypeData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.m_member_type')->where('active', 1)->get()->result();
		}
		

		$modal ='<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add New '.$membershipTypeRow->name.' '.$userTypeRow->name.' To '.get_table('customer', 'customer_id', $customerDBSettingRow->customer_id, 'full_legal_name').'</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('add-user').'" method="POST" enctype="multipart/form-data">	
							<input id="customer_db_setting_id" name="customer_db_setting_id" type="text" value="'.$customer_db_setting_id.'" hidden>
							<input id="user_id" name="user_id" type="text" value="'.generate_uuid().'" hidden>		
							<input id="user_type_id" name="user_type_id" type="text" value="'.$user_type_id.'" hidden>	
							<input id="membership_type_id" name="membership_type_id" type="text" value="'.$membership_type_id.'" hidden>
							<input id="customer_db_setting_id" name="customer_db_setting_id" type="text" value="'.$customer_db_setting_id.'" hidden>	
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">	
										<div class="mb-3">
											<label class="form-label">Photo</label>
											<input id="url" name="url" type="file" class="form-control btn-pill" placeholder="Upload Your Photo">
										</div>	
									</div>
									<div class="col-lg-6" '.($membership_type_id == '1755816508873' ? 'hidden' : '').'>
										<div class="mb-3">
											<label class="form-label">Title</label>
											<select id="title_id" name="title_id" class="form-select btn-pill" '.($membership_type_id == '1755816508873' ? '' : 'required').'>
												<option selected disabled>Select Title</option>';
												if (isset($titleData)): foreach($titleData as $data):
													$modal .= '<option value="'.$data->title_id.'">'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
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
									<div class="col-lg-6" '.($membership_type_id == '1755816508873' ? 'hidden' : '').'>
										<div class="mb-3">
											<label class="form-label">Gender</label>
											<select id="gender_id" name="gender_id" class="form-select btn-pill" '.($membership_type_id == '1755816508873' ? '' : 'required').'>
												<option selected disabled>Select Gender</option>';
												if (isset($genderData)): foreach($genderData as $data):
													$modal .= '<option value="'.$data->gender_id.'">'.$data->name.'</option>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-6" '.($membership_type_id == '1755816508873' ? 'hidden' : '').'>							
										<div class="mb-3">
											<label class="form-label">Date of Birth</label>
											<input id="birth" name="birth" type="date" class="form-control btn-pill" '.($membership_type_id == '1755816508873' ? '' : 'required').'>
										</div>
									</div>
									<div class="col-lg-6">							
										<div class="mb-3">
											<label class="form-label">Email Address</label>
											<input id="email" name="email" type="email" class="form-control btn-pill" placeholder="Enter your email address">
										</div>	
									</div>
									<div class="col-lg-6" '.($membership_type_id == '1755816508873' ? 'hidden' : '').'>	
										<div class="mb-3">
											<label class="form-label">ID Number / Passport Number</label>
											<input id="id_no" name="id_no" type="number" class="form-control btn-pill" placeholder="Enter your id number">
										</div>	
									</div>';
									if (!in_array($user_type_id, array('4734656482', '4534654653'))):
										$modal .= '<div class="col-lg-6">							
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
										<div class="col-lg-6" '.($membership_type_id == '1755816508873' ? 'hidden' : '').'>							
											<div class="mb-3">
												<label class="form-label">Town</label>
												<input id="town_id" name="town_id" type="text" class="form-control btn-pill" placeholder="Enter Town">
											</div>	
										</div>
										<div class="col-lg-6" '.($membership_type_id == '1755816508873' ? 'hidden' : '').'>							
											<div class="mb-3">
												<label class="form-label">Joining Date</label>
												<input id="joining_at" name="joining_at" type="date" class="form-control btn-pill" placeholder="Enter Joining Date">
											</div>	
										</div>
										<div class="col-lg-6" '.($membership_type_id == '1755816508873' ? 'hidden' : '').'>
											<div class="mb-3">
												<label class="form-label">Member Type</label>
												<select id="member_type_id" name="member_type_id" class="form-select btn-pill" '.($membership_type_id == '1755816508873' ? '' : 'required').'>
													<option selected disabled>Select Member Type</option>';
													if (isset($memberTypeData)): foreach($memberTypeData as $data):
														$modal .= '<option value="'.$data->member_type_id.'">'.$data->name.'</option>';
													endforeach; endif;
												$modal .= '</select>
											</div>
										</div>';
									endif;
								$modal .='</div>
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
							if (!in_array($user_type_id, array('4734656482', '4534654653'))):
								$modal .='<div class="modal-body" '.($membership_type_id == '1755816508873' ? 'hidden' : '').'>
									<div class="row">
										<div class="col-lg-6">							
											<div class="mb-3">
												<label class="form-label">Membership No.</label>
												<input id="membership_no" name="membership_no" type="text" class="form-control btn-pill" placeholder="Enter Membership No.">
											</div>	
										</div>
										<div class="col-lg-6" '.($membership_type_id == '1755816508873' ? 'hidden' : '').'>							
											<div class="mb-3">
												<label class="form-label">Sub Reference No.</label>
												<input id="sub_reference_no" name="sub_reference_no" type="text" class="form-control btn-pill" placeholder="Enter Sub Reference No.">
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
												<input id="contact_phone_no" name="contact_phone_no" type="number" class="form-control btn-pill" placeholder="Enter Contact No.">
											</div>	
										</div>
									</div>
								</div>
								<div class="modal-body">
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

	public function addUserMuthaiga()
	{
		// 'title' => $title,
		// 'fulllegalname' => $fulllegalname,
		// 'email' => $email,
		// 'mobile_no' => $mobile_no,
		// 'member_type' => $member_type,
		// 'membership_no' => $membership_no,
		// 'id_passport_no' => $id_passport_no,
		// 'regular_lr_no' => $regular_lr_no,
		// 'proffesionbussiness' => $proffesionbussiness,
		// 'physical_address' => $physical_address,
		// 'postal_code' => $postal_code,
		// 'postal_address' => $postal_address,
		// 'notes' => $notes

		//'email'=>$postData['proffesionbussiness']

		// $postData = $this->input->post();

		    $phpInput = file_get_contents("php://input");
			$phpPost = $this->input->post();
			$phpStream = $this->input->raw_input_stream;
			$postedString = '';
			if ($phpInput != null) {
				$postedString = $phpInput;
			} elseif ($phpPost != null) {
				$postedString = $phpPost;
			} elseif ($phpStream != null) {
				$postedString = $phpStream;
			}

			$postData = json_decode($postedString, true);

		// print_r($postData);
		// exit;

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', '1705386384290')->get()->row();
		$titleRow = $this->db->select('*')->from('m_title')->where('name', $postData['title'])->get()->row();
		$res = $this->db->insert($customerDBSettingRow->database_name.'.user', array('user_id'=>generate_uuid(),'user_type_id'=>'1755383886420','title_id'=>$titleRow->title_id ?? $postData['title'], 'full_legal_name'=>$postData['fulllegalname'], 'email'=>$postData['email'], 'phone_number'=>$postData['mobile_no'], 'membership_type_id'=>$postData['member_type'], 'membership_no'=>$postData['membership_no'], 'id_no'=>$postData['id_passport_no'], 'sub_reference_no'=>$postData['regular_lr_no'], 'residential_address'=>$postData['physical_address'], 'postal_code'=>$postData['postal_code'], 'postal_address'=>$postData['postal_address'], 'remark'=>$postData['notes'] ));
		if ($res)
		{
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(array(
					'code'=>200,
					'state'=>'success'
				)));
		}
		else
		{
			return $this->output
				->set_content_type('application/json')
				->set_status_header(401)
				->set_output(json_encode(array(
					'code'=>401,
					'state'=>'failed',
					'error'=>$res
				)));
		}
	}

	public function approveUserModal($user_id, $membership_type_id, $customer_db_setting_id, $header='all-user')
	{
		$this->common->checkSession(array('dialog'=>1));

		$membershipTypeRow = $this->db->select('*')->from('m_membership_type')->where('membership_type_id', $membership_type_id)->get()->row();
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();
		$userTypeRow = $this->db->select('*')->from('m_user_type')->where('user_type_id', $userRow->user_type_id)->get()->row();
		$activeData = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();

		$modal ='<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Approve '.$membershipTypeRow->name.' '.$userTypeRow->name.' To '.get_table('customer', 'customer_id', $customerDBSettingRow->customer_id, 'full_legal_name').'</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('approve-user').'" method="POST" enctype="multipart/form-data">	
							<input id="user_id" name="user_id" type="text" value="'.$user_id.'" hidden>
							<input id="customer_db_setting_id" name="customer_db_setting_id" type="text" value="'.$customer_db_setting_id.'" hidden>
							<input id="header" name="header" type="text" value="'.$header.'" hidden>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Approval</label>
											<select id="active" name="active" class="form-select btn-pill">
												<option selected disabled>Select Approval</option>';
												if (isset($activeData)): foreach($activeData as $data):
													$modal .= '<option value="'.$data->num.'">'.$data->name_two.'</option>';
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
									Approve '.$userRow->full_legal_name.'
								</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function approveUser()
	{
		$postData = $this->input->post();
		$header = $postData['header'];
		$customer_db_setting_id = $postData['customer_db_setting_id'];
		$user_id = $postData['user_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$customerRow = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
		$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();

		$html = $this->load->view('admin/club_member_temp', array('full_legal_name'=>$userRow->full_legal_name, 'club_name'=>$customerRow->full_legal_name, 'url'=>base_url('reset/'.$userRow->user_id.'/'.$customer_db_setting_id)), true);
        $this->common->sendMail($userRow->email, 'Approval Notification', $html);

		unset($postData['customer_db_setting_id'], $postData['header']);
		$this->db->update($customerDBSettingRow->database_name.'.user', $postData, array('user_id'=>$postData['user_id']));
		$description = $userRow->full_legal_name.' Approved Successfully. ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$user_id.' : User for '.$description));
		redirect($header == 'dashboard' ? $header : $header.'/'.$userRow->user_type_id.'/'.$customer_db_setting_id, 'refresh');
	}
}
