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
	public function index()
	{
		$this->load->view('auth/login_view');
        // $this->load->view('front/templates/footer_view');
	}



	 public function VerifyLogin(){
	    //Field validation succeeded.  Validate against database
	    $email = $this->input->post('email');
        $password = sha1($this->input->post('password'));

	    //query the database
	    $result = $this->LoginModel->login($email, $password);
		// $admin=0;	
	
	    if ($result) {
		 $sess_array = array();
		 
	    foreach ($result as $row) {

			$sess_array = array(
				'user_id' => $row->user_id,
				'user_name' => $row->name,
				'middle_name' => $row->middle_name,
				'last_name' => $row->last_name,
				'email' => $row->email, 
				'reset' =>$row->reset,
				'user_type'  =>$row->user_type,
				'activation_status' =>$row->activation_status,
				'membership_no' => $row->membership_no,
                'club_id' => $row->club_id
			);

	        $this->session->set_userdata('XmR2qDXOJu4ey6vZurlDpncDDDUbINQNffpopp', $sess_array);

	    }
	}
        
        if ($sess_array['user_type']=="5c8786cdf7c16") {
	    	$this->session->set_flashdata('err', 'User not allowed to login here ');
        	redirect('control', 'refresh');
         }
         
        // print_r($sess_array);
	    // exit();
	        
	    // if ($sess_array['user_type']=="5c8786cdf7c16") {
	    // 	$this->session->set_flashdata('err', 'User not allowed to login here ');
        // 	redirect('control', 'refresh');
        	
        // }

        redirect(base_url().'dashboard');

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
	        $this->session->set_userdata('XmR2qDXOJu4ey6vZurlDpncDDDUbINQNffpopp', $sess_array);
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


        public function Logout()
        {
        // $this->common->checkSession();
		$session_data = $this->common->loadSession();

		$user_type = $session_data['user_type'];

        // $session_data = 'de8786ddf7c161';  48414324554

        $this->session->unset_userdata('XmR2qDXOJu4ey6vZurlDpncDDDUbINQNffpopp');
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
