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
		$data['customer_db_setting_id'] = $customer_db_setting_id == NULL ? $session_data['customer_db_setting_id'] : $customer_db_setting_id;

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

	public function importUserModal($user_type_id = '', $customer_db_setting_id = '', $membership_type_id = '')
	{
		$this->common->checkSession(array('dialog' => 1));
		$session_data = $this->common->loadSession();

		$data = array(
			'user_type_id' => !empty($user_type_id) ? $user_type_id : GlobalModel::MEMBER_TYPE,
			'customer_db_setting_id' => !empty($customer_db_setting_id) ? $customer_db_setting_id : $session_data['customer_db_setting_id'],
			'membership_type_id' => $membership_type_id,
			'template_url' => base_url('download-user-import-template'),
		);

		return $this->load->view('admin/import_users_modal', $data);
	}

	public function downloadUserImportTemplate()
	{
		$this->common->checkSession();

		$headers = array('user_id','full_legal_name','phone_number','street_name','email','birth','id_no','residential_address','postal_address','postal_code','town_id','city_id','password','membership_no','contact_name','contact_phone_no','sub_reference_no');
		$sample = array(generate_uuid(),'John Doe','254700000000','Main Street','john@example.com','1990-01-15','12345678','123 Baker St','P.O. Box 123','00100','1','1','Secret123','M-0001','Jane Doe','254701234567','LR-001');

		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="user_import_template.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');

		$output = fopen('php://output', 'w');
		fputcsv($output, $headers);
		fputcsv($output, $sample);
		fclose($output);
		exit;
	}

	public function importUsers()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$userTypeId = $this->input->post('user_type_id', true) ?: GlobalModel::MEMBER_TYPE;
		$customerDbSettingId = $this->input->post('customer_db_setting_id', true) ?: $session_data['customer_db_setting_id'];
		$membershipTypeId = $this->input->post('membership_type_id', true) ?: 'N/A';

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customerDbSettingId)->get()->row();
		if (empty($customerDBSettingRow)) {
			$this->session->set_flashdata('warning', 'Customer database not found.');
			return redirect($_SERVER['HTTP_REFERER'] ?? 'home', 'refresh');
		}

		if (empty($_FILES['import_file']['tmp_name'])) {
			$this->session->set_flashdata('warning', 'Please choose a CSV file to import.');
			return redirect($_SERVER['HTTP_REFERER'] ?? 'home', 'refresh');
		}

		$handle = fopen($_FILES['import_file']['tmp_name'], 'r');
		if (!$handle) {
			$this->session->set_flashdata('warning', 'Unable to read the uploaded file.');
			return redirect($_SERVER['HTTP_REFERER'] ?? 'home', 'refresh');
		}

		$userTable = $customerDBSettingRow->database_name . '.user';
		$inserted = 0;
		$updated = 0;
		$rowNumber = 0;

		while (($row = fgetcsv($handle)) !== false) {
			$rowNumber++;
			if ($rowNumber === 1 && isset($row[0]) && strtolower(trim($row[0])) === 'user_id') {
				continue; // skip header
			}

			$row = array_map(function ($value) {
				return trim((string) $value);
			}, $row);

			list($csvUserId, $fullName, $phoneNumber, $streetName, $email, $birth, $idNo, $residentialAddress, $postalAddress, $postalCode, $townId, $cityId, $plainPassword, $membershipNo, $contactName, $contactPhone, $subReference) = array_pad($row, 17, '');

			if ($fullName === '' && $email === '' && $phoneNumber === '') {
				continue; // skip empty row
			}

			// $userId = $csvUserId !== '' ? $csvUserId : generate_uuid();
			$userId = generate_uuid();
			$passwordValue = $plainPassword !== '' ? $plainPassword : ($email !== '' ? explode('@', $email)[0] : generate_uuid());
			$birthDate = null;
			if ($birth !== '') {
				$timestamp = strtotime($birth);
				$birthDate = $timestamp ? date('Y-m-d', $timestamp) : null;
			}

			$userData = array(
				'user_id' => $userId,
				'user_type_id' => $userTypeId,
				'membership_type_id' => $membershipTypeId,
				'full_legal_name' => $fullName,
				'phone_number' => $phoneNumber,
				'street_name' => $streetName,
				'email' => $email,
				'birth' => $birthDate,
				'id_no' => $idNo,
				'residential_address' => $residentialAddress,
				'postal_address' => $postalAddress,
				'postal_code' => $postalCode,
				'town_id' => $townId,
				'city_id' => $cityId,
				'password' => password_hash($passwordValue, PASSWORD_DEFAULT),
				'membership_no' => $membershipNo,
				'contact_name' => $contactName,
				'contact_phone_no' => $contactPhone,
				'sub_reference_no' => $subReference,
				'active' => 1,
				'created_at' => date('Y-m-d H:i:s'),
			);

			$existing = $this->db->from($userTable)->where('user_id', $userId)->get()->row();
			if ($existing) {
				$this->db->where('user_id', $userId)->update($userTable, $userData);
				$updated++;
			} else {
				$this->db->insert($userTable, $userData);
				$inserted++;
			}
		}

		fclose($handle);
		$this->session->set_flashdata('success', "Import complete. Added {$inserted}, updated {$updated}.");
		return redirect($_SERVER['HTTP_REFERER'] ?? 'home', 'refresh');
	}

	public function memberView($membership_type_id, $active=0)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('member');

		$data['active'] = $active;
		$data['userTypeId'] = GlobalModel::MEMBER_TYPE;
		$data['membershipTypeId'] = $membership_type_id;
		$data['customerDBSettingId'] = $session_data['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$data['userData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('membership_type_id', $membership_type_id)->where('active', $active)->order_by('created_at', 'DESC')->get()->result();
		$data['userTypeData'] = $this->db->select('*')->from('m_user_type')->where('active', 1)->get()->result();
		$data['membershipTypeData'] = $this->db->select('*')->from('m_membership_type')->where('active', 1)->get()->result();
		if (in_array($session_data['user_type_id'], array(GlobalModel::ADMIN_TYPE)))
			$customerDBSettingData = $this->db->select('*')->from('customer_db_setting')->where('active', 1)->get()->result();
		else
			$customerDBSettingData = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->where('active', 1)->get()->result();
		$data['customerDBSettingData'] = $customerDBSettingData;
		$data['customerDBSettingRow'] = $customerDBSettingRow;

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/member_view', $data); 
		$this->load->view('admin/templates/footer_view', $data);
	}

	public function getUserList($user_type_id, $customer_db_setting_id='1755387775468')
	{
		$this->common->checkSession();
		$headerData = $this->common->loadHeaderData('all-user');
		$approveUserRight = $headerData['approveUserRight'];
		$editUserRight = $headerData['editUserRight'];
		$removeUserRight = $headerData['removeUserRight'];

		// $userTypeRow = $this->db->select('*')->from('m_user_type')->where('user_type_id', $user_type_id)->get()->row();
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$userData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_type_id', $user_type_id)->order_by('created_at', 'DESC')->get()->result();
		
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
										if ($approveUserRight):
											$actions .= '<a class="dropdown-item" onclick="approveUserModal(\''.$user->user_id.'\', \''.($user->membership_type_id == 'N/A' ? '0' : $user->membership_type_id).'\', \''.$customer_db_setting_id.'\', \'all-user\')">Approve</a>';
										endif;
										if ($editUserRight):
											$actions .= '<a class="dropdown-item" onclick="editUserModal(\''.$user->user_id.'\', \''.($user->membership_type_id == 'N/A' ? '0' : $user->membership_type_id).'\', \''.$customer_db_setting_id.'\')">Edit</a>';
										endif;
										if ($removeUserRight):
											$actions .= '<a class="dropdown-item" onclick="deleteUserModal(\''.$user->user_id.'\', \''.$customer_db_setting_id.'\')"><span style="color: red;">Delete</span></a>';
										endif;
									$actions .= '</div>
								</span>	
							</td>';
			endif;
			$title = get_table('m_title', 'title_id', $user->title_id, 'name');
			$membershipFeeType = get_table($customerDBSettingRow->database_name.'.membership_fee_type', 'membership_fee_type_id', $user->membership_fee_type_id, 'name');
			$origin = get_table('m_user_origin', 'user_origin_id', $user->user_origin_id, 'name');
			$status = get_table('m_active', 'num', $user->active, 'name_two');
			$createdAt = date_format(date_create($user->created_at),"d M Y");
			$userDataArray[] = array(++$u.'.', $title.' '.$user->full_legal_name, $user->phone_number, $user->email, $membershipFeeType, ($user->membership_no ?? '-'), $user->residential_address, $user->sub_reference_no, $origin, $user->street_name, $status, $createdAt, $actions);
		}

		print_r(json_encode(array("draw"=>1, "recordsTotal"=>count($userDataArray), "recordsFiltered"=>count($userDataArray), "data"=>$userDataArray)));
	}

	public function addUserModal($user_type_id, $membership_type_id, $customer_db_setting_id, $header='all-user', $active=1)
	{
		return $this->addEditUserModal('add', $user_type_id, $membership_type_id, $customer_db_setting_id, $header, $active);
	}

	public function editUserModal($user_id, $membership_type_id, $customer_db_setting_id, $header='all-user')
	{
		return $this->addEditUserModal('edit', $user_id, $membership_type_id, $customer_db_setting_id, $header, 1);
	}

	public function addEditUserModal($mode, $id, $membership_type_id, $customer_db_setting_id, $header='all-user', $active=1)
	{
		// $this->common->checkSession(array('dialog'=>1));

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$membershipTypeRow = $this->db->select('*')->from('m_membership_type')->where('membership_type_id', $membership_type_id)->get()->row();

		$genderData = $this->db->select('*')->from('m_gender')->where('active', 1)->get()->result();
		$countryData = $this->db->select('*')->from('m_country')->where('active', 1)->get()->result();
		$titleData = $this->db->select('*')->from('m_title')->where('active', 1)->get()->result();

		$userRow = null;
		$userTypeRow = null;
		$user_type_id = null;
		$user_id = null;

		if ($mode === 'add') {
			$user_type_id = $id;
			$user_id = generate_uuid();
			$userTypeRow = $this->db->select('*')->from('m_user_type')->where('user_type_id', $user_type_id)->get()->row();
			$userRow = (object) array(
				'user_id' => $user_id,
				'user_type_id' => $user_type_id,
				'user_option_id' => '1752581178334',
				'title_id' => '',
				'full_legal_name' => '',
				'phone_number' => '',
				'mobile_number' => '',
				'gender_id' => '',
				'birth' => '',
				'email' => '',
				'id_no' => '',
				'residential_address' => '',
				'postal_address' => '',
				'postal_code' => '',
				'street_name' => '',
				'country_id' => '',
				'town_id' => '',
				'joining_at' => '',
				'membership_fee_type_id' => '',
				'profession' => '',
				'membership_no' => '',
				'sub_reference_no' => '',
				'contact_name' => '',
				'contact_phone_no' => '',
				'remark' => '',
			);
		} else {
			$user_id = $id;
			$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();
			$user_type_id = $userRow->user_type_id ?? null;
			if (!empty($user_type_id)) {
				$userTypeRow = $this->db->select('*')->from('m_user_type')->where('user_type_id', $user_type_id)->get()->row();
			}
		}

		$memberFeeTypeData = [];
		if ($customer_db_setting_id != GlobalModel::DEFAULT_CORE_DB_SETTING) {
			$memberFeeTypeData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.membership_fee_type')->where('active', 1)->get()->result();
		}

		$data = array(
			'mode' => $mode,
			'userRow' => $userRow,
			'userTypeRow' => $userTypeRow,
			'user_type_id' => $user_type_id,
			'customerDBSettingRow' => $customerDBSettingRow,
			'customer_db_setting_id' => $customer_db_setting_id,
			'membership_type_id' => $membership_type_id,
			'header' => $header,
			'active' => $active,
			'genderData' => $genderData,
			'countryData' => $countryData,
			'titleData' => $titleData,
			'membershipTypeRow' => $membershipTypeRow,
			'memberFeeTypeData' => $memberFeeTypeData,
		);

		print_r($this->load->view('admin/add_edit_user_modal', $data, true));
	}

	public function addUser()
	{
		$postData = $this->input->post();
		$customer_db_setting_id = $postData['customer_db_setting_id'];
		$user_type_id = $postData['user_type_id'];
		$header = $postData['header'];
		$full_legal_name = $postData['full_legal_name'];
		$membership_type_id = $postData['membership_type_id'];
		$email = $postData['email'];
		$active = $postData['active'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('email', $email)->get()->row();
		if (isset($userRow) && $userRow->email == $email) {
			$description = 'User with email '.$email.' already exists. ❌';
			if (isset($this->auditlogger)) {
				$this->auditlogger->logAdminAction(
					'user',
					'create_duplicate',
					'user',
					(string) ($userRow->user_id ?? $email),
					null,
					$userRow,
					array(
						'customer_db_setting_id' => $customer_db_setting_id,
						'email' => $email,
						'user_type_id' => $user_type_id,
						'membership_type_id' => $membership_type_id,
						'header' => $header,
						'active' => $active,
					),
					'fail',
					$description
				);
			}
			$this->session->set_flashdata('err', $description);
			$redirect = $header == 'all-user' ? $header.'/'.$user_type_id.'/'.$customer_db_setting_id : ($header == 'member' ? 'member/'.$membership_type_id.'/'.$active : 'profile/'.$userRow->user_id.'/'.$customer_db_setting_id.'/'.$userRow->user_option_id);
			redirect($redirect, 'refresh');
		}

		if (isset($_FILES['url']['name']) && !empty($_FILES['url']['name'])) {
            $postData['url'] = file_upload('url');
        } else {
            unset($postData['url']);
        }

		if (empty($postData['password'])) {
			$postData['password'] = password_hash(explode('@', $postData['email'])[0], PASSWORD_DEFAULT);
		} else {
			$postData['password'] = password_hash($postData['password'], PASSWORD_DEFAULT);
		}
		unset($postData['user_option_id'], $postData['customer_db_setting_id'], $postData['header'], $postData['active']);
		$this->db->insert($customerDBSettingRow->database_name.'.user', $postData);
		$createdUserRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('email', $email)->get()->row();
		$description = $full_legal_name.' added successfully. ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$email.' : User for '.$description));
		if (isset($this->auditlogger)) {
			$this->auditlogger->logAdminAction(
				'user',
				'create',
				'user',
				(string) ($createdUserRow->user_id ?? $email),
				null,
				$createdUserRow,
				array(
					'customer_db_setting_id' => $customer_db_setting_id,
					'email' => $email,
					'user_type_id' => $user_type_id,
					'membership_type_id' => $membership_type_id,
					'header' => $header,
					'active' => $active,
				),
				'success',
				$description
			);
		}
		if (count(explode('_', $header)) > 1) {
			$redirect = str_replace('_', '/', $header);
		} else {
			$redirect = $header == 'all-user' ? $header.'/'.$user_type_id.'/'.$customer_db_setting_id : ($header == 'member' ? 'member/'.$membership_type_id.'/'.$active : 'profile/'.$postData['user_id'].'/'.$customer_db_setting_id.'/'.$postData['user_option_id']);
		}
		redirect($redirect, 'refresh');
	}
	
	public function editUser()
	{
		$postData = $this->input->post();
		$customer_db_setting_id = $postData['customer_db_setting_id'];
		$header = $postData['header'];
		$user_id = $postData['user_id'];
		$user_option_id = $postData['user_option_id'];
		unset($postData['customer_db_setting_id'], $postData['header'], $postData['user_id'], $postData['user_option_id']);

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$beforeUserRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();

		if (isset($_FILES['url']['name']) && !empty($_FILES['url']['name'])) {
            $postData['url'] = file_upload('url');
        } else {
            unset($postData['url']);
        }

		if (!empty($postData['password'])) {
			$postData['password'] = password_hash($postData['password'], PASSWORD_DEFAULT);
		} else {
			unset($postData['password']);
		}

		$ok = $this->db->update($customerDBSettingRow->database_name.'.user', $postData, array('user_id'=>$user_id));
		$afterUserRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();
		$description = 'User profile updated successfully. ✔️';
		$this->session->set_flashdata('message', $description);
		if (isset($this->auditlogger)) {
			$this->auditlogger->logAdminAction(
				'user',
				'update',
				'user',
				(string) $user_id,
				$beforeUserRow,
				$afterUserRow,
				array(
					'customer_db_setting_id' => $customer_db_setting_id,
					'header' => $header,
					'updated_fields' => array_keys($postData),
				),
				$ok ? 'success' : 'fail',
				$description
			);
		}
		if (count(explode('_', $header)) > 1) {
			$redirect = str_replace('_', '/', $header);
		} else {
			$redirect = $header == 'all-user' ? $header.'/'.$postData['user_type_id'].'/'.$customer_db_setting_id : 'profile/'.$user_id.'/'.$customer_db_setting_id.'/'.$user_option_id;
		}
		redirect($redirect, 'refresh');
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
		$titleRow = $this->db->select('*')->from('m_title')->like('name', $postData['title'])->get()->row();
		$genderRow = $this->db->select('*')->from('m_gender')->like('name', $postData['gender'])->get()->row();
		if (!isset($titleRow)) {
			$this->db->insert('m_title', array('title_id'=>generate_uuid(), 'name'=>$postData['title'], 'active'=>1));
			$titleRow = $this->db->select('*')->from('m_title')->like('name', $postData['title'])->get()->row();
		}
		if (!isset($genderRow)) {
			$this->db->insert('m_gender', array('gender_id'=>generate_uuid(), 'name'=>$postData['gender'], 'active'=>1));
			$genderRow = $this->db->select('*')->from('m_gender')->like('name', $postData['gender'])->get()->row();
		}
		$res = $this->db->insert($customerDBSettingRow->database_name.'.user', array('user_id'=>generate_uuid(),'user_type_id'=>'1755383886420','title_id'=>$titleRow->title_id ?? $postData['title'], 'full_legal_name'=>$postData['fulllegalname'], 'email'=>$postData['email'], 'phone_number'=>$postData['phone_no'], 'mobile_number'=>$postData['mobile_no'], 'gender_id'=>$genderRow->gender_id ?? $postData['gender'], 'membership_type_id'=>$postData['member_type'], 'membership_no'=>$postData['membership_no'], 'id_no'=>$postData['id_passport_no'], 'sub_reference_no'=>$postData['regular_lr_no'], 'residential_address'=>$postData['physical_address'], 'postal_code'=>$postData['postal_code'], 'postal_address'=>$postData['postal_address'], 'street_name'=>$postData['street_name'], 'remark'=>$postData['notes'], 'user_origin_id'=>'176874226539'));
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
		$beforeUserRow = $userRow;


		$html = $this->load->view('admin/club_member_temp', array('full_legal_name'=>$userRow->full_legal_name, 'club_name'=>$customerRow->full_legal_name, 'url'=>base_url('reset/'.$userRow->user_id.'/'.$customer_db_setting_id), 'userRow'=>$userRow, 'customerRow'=>$customerRow, 'customerDBSettingRow'=>$customerDBSettingRow), true);
        $this->common->sendMail($userRow->email, 'Approval Notification', $html);

		unset($postData['customer_db_setting_id'], $postData['header']);
		$ok = $this->db->update($customerDBSettingRow->database_name.'.user', $postData, array('user_id'=>$postData['user_id']));
		$afterUserRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();
		$description = $userRow->full_legal_name.' Approved Successfully. ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$user_id.' : User for '.$description));
		if (isset($this->auditlogger)) {
			$this->auditlogger->logAdminAction(
				'user',
				'approve',
				'user',
				(string) $user_id,
				$beforeUserRow,
				$afterUserRow,
				array(
					'customer_db_setting_id' => $customer_db_setting_id,
					'header' => $header,
					'approved_active' => $postData['active'] ?? null,
				),
				$ok ? 'success' : 'fail',
				$description
			);
		}
		redirect($header == 'dashboard' ? $header : $header.'/'.$userRow->user_type_id.'/'.$customer_db_setting_id, 'refresh');
	}

	public function deleteUserModal($user_id, $customer_db_setting_id, $header='all-user')
	{
		$this->common->checkSession(array('dialog'=>1));

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();

		$modal ='<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Delete User</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('delete-user').'" method="POST" enctype="multipart/form-data">	
							<input id="user_id" name="user_id" type="text" value="'.$user_id.'" hidden>
							<input id="customer_db_setting_id" name="customer_db_setting_id" type="text" value="'.$customer_db_setting_id.'" hidden>
							<input id="header" name="header" type="text" value="'.$header.'" hidden>
							<div class="modal-body">
								<p>Are you sure you want to delete <strong>'.$userRow->full_legal_name.'</strong> ?</p>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary " data-bs-dismiss="modal">
									Cancel
								</a>
								<button href="#" type="submit" class="btn btn-danger ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
										<line x1="4" y1="7" x2="20" y2="7" />
										<line x1="10" y1="11" x2="10" y2="17" />
										<line x1="14" y1="11" x2="14" y2="17" />
										<path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
										<path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
									</svg>
									Delete User
								</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function deleteUser()
	{
		$postData = $this->input->post();
		$customer_db_setting_id = $postData['customer_db_setting_id'];
		$user_id = $postData['user_id'];
		$header = $postData['header'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();
		$beforeUserRow = $userRow;
		$beforeCounts = array(
			'subscriptions' => (int) $this->db->from($customerDBSettingRow->database_name.'.subscription')->where('user_id', $user_id)->count_all_results(),
			'payment_history' => (int) $this->db->from($customerDBSettingRow->database_name.'.payment_history')->where('user_id', $user_id)->count_all_results(),
		);

		$this->db->delete($customerDBSettingRow->database_name.'.user', array('user_id'=>$user_id));
		$this->db->delete($customerDBSettingRow->database_name.'.subscription', array('user_id'=>$user_id));
		$this->db->delete($customerDBSettingRow->database_name.'.payment_history', array('user_id'=>$user_id));
		$description = $userRow->full_legal_name.' Deleted Successfully. ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$user_id.' : User for '.$description));
		if (isset($this->auditlogger)) {
			$this->auditlogger->logAdminAction(
				'user',
				'delete',
				'user',
				(string) $user_id,
				array('user' => $beforeUserRow, 'related_counts' => $beforeCounts),
				null,
				array(
					'customer_db_setting_id' => $customer_db_setting_id,
					'header' => $header,
				),
				'success',
				$description
			);
		}
		redirect($header.'/'.$userRow->user_type_id.'/'.$customer_db_setting_id, 'refresh');
	}
}
