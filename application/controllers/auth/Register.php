<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {


	 public function __construct() {
        parent::__construct();
        
        //load the required helpers and libraries  

        // $this->load->model('RegisterModel');
       
    }

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
	public function index()
	{

		$data['subjectData'] = $this->SubjectModel->get();

		// $this->load->view('front/templates/header_view');
		$this->load->view('admin/sign_up_view',$data);
		
	}


	public function put()
	{
		$postData = $this->input->post();
		$postData['user_id'] = uniqid();
		$postData['password'] = sha1($this->input->post('password'));
		$subjectData = $this->SubjectModel->get();
		// $userSubjects = array();
		foreach($subjectData as $subject){

			if($this->input->post($subject->subject_id)){

				$userSubjects = array('user_id'=>$postData['user_id'],'subject_id'=>$subject->subject_id);
				$this->SubjectModel->insertUserSubject($userSubjects);

			}

			unset($postData[$subject->subject_id]);
		}
		
		if($this->LoginModel->insert($postData)){

			$emailData['email'] = $this->input->post('email');
			$emailData['name'] = $this->input->post('name');
			$emailData['user_id'] = $postData['user_id'];
			$message = $this->load->view('admin/templates/email/email_verify',$emailData,true);

			$this->common->sendMail($emailData['email'],'Roodito Confirmation Email',$message);

		}

		$this->session->set_flashdata('message', 'Thank you for registering, a confirmation email was sent to your inbox please confirm your email to proceed');
		redirect('login', 'refresh');
	}


	public function verify($user_id)
	{
		// activation_status
	
		if($this->LoginModel->updateUser(array('activation_status'=>1,'email_verified_at'=>date("Y-m-d H:i:s")),$user_id)){
			$this->session->set_flashdata('message', 'Thank you for Verifying your email, please login to proceed');
			redirect('login', 'refresh');
		}
	}

}
