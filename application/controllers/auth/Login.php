<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
	public function index($host='')
	{
		$checkHost = false;
		$customerDBSettingRow = [];
		$host = $_SERVER['HTTP_HOST'];
		$customerDBSettingData = $this->db->select('*')->from('customer_db_setting')->get()->result();
		foreach ($customerDBSettingData as $customerDBSetting) 
		{
			if (strpos($host, $customerDBSetting->host.'.') === 0) 
			{
				$checkHost = true;
				$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customerDBSetting->customer_db_setting_id)->get()->row();
			}
		}
		
		if (!$checkHost)
		{
			$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $host)->or_where('host', $host)->get()->row();
		}
		
		$data['customerRow'] = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id ?? '')->get()->row();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['host'] = $host;
		$this->load->view('auth/login_view', $data);
	}

	public function nmra()
	{
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->like('sub_domain', 'muthaiga')->get()->row();
		$data['customerRow'] = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$this->load->view('auth/login_view', $data);
	}

	 public function VerifyLogin()
	 {
		$postData = $this->input->post();
		$email = isset($postData['email']) ? $postData['email'] : '';
		$password = isset($postData['password']) ? $postData['password'] : '';

		$systemRow = $this->db->select('*')->from('m_system')->where('id', 1)->get()->row();
		$customerDBSettingData = $this->db->select('*')->from('customer_db_setting')->where('active', 1)->get()->result();
		$userRow = $this->db->select('*')->from('user')->where('email', $email)->get()->row();

		// Check tenant databases first
		foreach ($customerDBSettingData as $customerDBSetting) 
		{
			if ($customerDBSetting->customer_db_setting_id != '1755387775468')
			{
				$userInnerRow = $this->db->select('*')->from($customerDBSetting->database_name.'.user')->where('email', $email)->get()->row();
				if ($userInnerRow && !empty($userInnerRow->password) && password_verify($password, $userInnerRow->password))
				{
					$user = json_decode(json_encode($userInnerRow), true);
					$user['customer_db_setting_id'] = $customerDBSetting->customer_db_setting_id;
					$this->session->set_userdata(GlobalModel::SESSION, $user);
					$this->auditlogger->logUserAction(
						'auth',
						'login',
						'user',
						(string) ($userInnerRow->user_id ?? ''),
						null,
						null,
						['email' => $email, 'customer_db_setting_id' => $customerDBSetting->customer_db_setting_id],
						'success',
						'User logged in'
					);
					$description = 'Welcome back ' . ($userInnerRow->full_legal_name ?? $email) . '. ✔️';
					$this->session->set_flashdata('message', $description);
					$userRightData = $this->db->select('*')->from('user_right')->where('user_type_id', $userInnerRow->user_type_id)->get()->row();
					$moduleData = $this->db->select('*')->from('m_module')->where('module_id', $userRightData->module_id)->get()->row();
					redirect('dashboard', 'reload');
					return;
				}
			}
		}

		// Check main user table
		if ($userRow && !empty($userRow->password) && password_verify($password, $userRow->password))
		{
			$user = json_decode(json_encode($userRow), true);
			$user['customer_db_setting_id'] = '1755387775468';
			$this->session->set_userdata(GlobalModel::SESSION, $user);
			$this->auditlogger->logUserAction(
				'auth',
				'login',
				'user',
				(string) ($userRow->user_id ?? ''),
				null,
				null,
				['email' => $email, 'customer_db_setting_id' => '1755387775468'],
				'success',
				'User logged in'
			);
			$description = 'Welcome back ' . ($userRow->full_legal_name ?? $email) . '. ✔️';
			$this->session->set_flashdata('message', $description);
			$userRightData = $this->db->select('*')->from('user_right')->where('user_type_id', $userRow->user_type_id)->get()->row();
			$moduleData = $this->db->select('*')->from('m_module')->where('module_id', $userRightData->module_id)->get()->row();
			redirect('dashboard', 'reload');
			return;
		}

		// If we reached here, login failed — show error on login page
		$this->auditlogger->logSecurityEvent('auth', 'login_failed', [
			'email' => $email,
			'customer_db_setting_id' => null,
			'reason' => 'invalid_credentials'
		], 'fail', 'Invalid credentials');
		$this->session->set_flashdata('err', 'Invalid credentials.');
		redirect('login', 'reload');
	}
	
	public function verifyLoginFront(){
	    //Field validation succeeded.  Validate against database
	    $email = $this->input->post('email');
        $password = sha1($this->input->post('password'));
        $companyName = $this->input->post('company_name');

	    //query the database
	    $result = $this->LoginModel->login($email, $password);
		// $admin=0;	
	
	    if ($result) {
		 $sess_array = array();


		 // if (check_user_companies($result[0]->user_id,$companyName)!= "X") {

		 // 	 $this->session->set_flashdata('err', 'You are not allowed to login to this company. Please choose your correct company and login.');
		// 	 redirect(base_url().'Home');
		 // }
		 
	    foreach ($result as $row) {

			$sess_array = array(
				'user_id' => $row->user_id,
				'user_name' => $row->name,
				'email' => $row->email,
				'reset' =>$row->reset,
				'user_type'  =>$row->user_type,
				'activation_status' =>$row->activation_status,
				'name' =>$row->name,
				'middle_name' =>$row->middle_name,
				'last_name' =>$row->last_name,
				'email' =>$row->email,
				'membership_no' => $row->membership_no,
                'club_id' => $row->club_id,
				'phone_number' =>$row->phone_number,
				'id_no' =>$row->id_no,
				'designation' =>$row->designation,
				'staff_number' =>$row->staff_number,
				'gross_pay' =>$row->gross_pay,
				'net_pay' =>$row->net_pay,
				'basic_pay' =>$row->basic_pay

			);
	        $this->session->set_userdata(GlobalModel::SESSION, $sess_array);
	    }
	    
		//  print_r($sess_array);
	    // exit();
		redirect(base_url().'user_dashboard');
	    
	        
	    } else {

			 $this->session->set_flashdata('err', 'invalid user name or password ');
			 redirect(base_url().'accounts');
			 
	    // return false;
	    }

    }

	public function resetPassword($user_id='N/A', $customer_db_setting_id='1755387775468')
	{
		$checkHost = false;
		$customerDBSettingRow = [];
		$host = $_SERVER['HTTP_HOST'];
		$customerDBSettingData = $this->db->select('*')->from('customer_db_setting')->get()->result();
		foreach ($customerDBSettingData as $customerDBSetting) 
		{
			if (strpos($host, $customerDBSetting->host.'.') === 0) 
			{
				$checkHost = true;
				$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customerDBSetting->customer_db_setting_id)->get()->row();
			}
		}
		
		if (!$checkHost)
		{
			$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $host)->or_where('host', $host)->or_where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		}
		$data['customerRow'] = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id ?? $customer_db_setting_id)->get()->row();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		// $customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$data['userRow'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $user_id)->get()->row();
		$data['customer_db_setting_id'] = $customer_db_setting_id;
		$this->load->view('auth/reset_password_view', $data);
	}

	public function resetNowPassword()
	{
		$user_id = $this->input->post('user_id');
		$new_password = $this->input->post('new_password');
		$confirm_new_password = $this->input->post('confirm_new_password');
		$customer_db_setting_id = $this->input->post('customer_db_setting_id');
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();

		if ($new_password === $confirm_new_password) {
			// Update the user's password in the database
			$this->db->set('password', password_hash($new_password, PASSWORD_DEFAULT));
			$this->db->where('user_id', $user_id);
			$this->db->update($customerDBSettingRow->database_name.'.user');
			$this->session->set_flashdata('message', 'Password reset successfully.');
			redirect('login', 'refresh');
		} else {
			$this->session->set_flashdata('err', 'Passwords do not match.');
			redirect('reset/'.$user_id.'/'.$customer_db_setting_id, 'refresh');
		}
	}

	public function Logout()
	{
        // $this->common->checkSession();
		$session_data = $this->common->loadSession();
		if (!empty($session_data)) {
			$this->auditlogger->logUserAction(
				'auth',
				'logout',
				'user',
				(string) ($session_data['user_id'] ?? ''),
				null,
				null,
				['customer_db_setting_id' => $session_data['customer_db_setting_id'] ?? null],
				'success',
				'User logged out'
			);
		}

		$user_type = $session_data['user_type'];

        // $session_data = 'de8786ddf7c161';  48414324554

        $this->session->unset_userdata(GlobalModel::SESSION);
        session_destroy();

        if ($user_type=="de8786ddf7c161") {
        	redirect('control', 'refresh');
        }
        if ($user_type=="4841432455478878") {
        	redirect('control', 'refresh');

        }if ($user_type=="48414324554") {
        	redirect('control', 'refresh');
        	
        } else {
        	redirect('accounts', 'refresh');
        }
        
        }
}
