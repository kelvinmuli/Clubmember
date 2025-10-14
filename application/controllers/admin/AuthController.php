<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		
	}

	public function forgotPassword($customer_db_setting_id='')
	{
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->like('sub_domain', 'muthaiga')->or_where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$data['customerRow'] = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$this->load->view('admin/forgot_password_view', $data);
	}	

	public function resetPasswordNow()
	{
		$postData = $this->input->post();
		$customer_db_setting_id = $postData['customer_db_setting_id'];
		$email = $postData['email'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$userRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('email', $email)->get()->row();
		if (empty($email) && empty($userRow))
		{
			$this->session->set_flashdata('err', 'Please enter your email address!');
			redirect('forgot-password/'.$customer_db_setting_id, 'reload');
		}

		$customerRow = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
		$htmlPasswordReset = $this->load->view('admin/password_reset_temp', array('full_legal_name'=>$userRow->full_legal_name, 'club_name'=>$customerRow->full_legal_name, 'url'=>base_url('reset/'.$userRow->user_id.'/'.$customer_db_setting_id)), true);
		$this->common->sendMail($userRow->email, 'Password Reset', $htmlPasswordReset);
		$this->session->set_flashdata('message', 'We have e-mailed your password reset link!');
		redirect($customer_db_setting_id == '1705386384290' ? 'nmra' : 'login', 'reload');
	}

}
