<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('UsersModel');
        $this->load->library('session');
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
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('front/signup_view');
		$this->load->view('front/templates/footer_view');
	}

	 public function authenticate() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->UsersModel->get_user_by_email($email);

        if ($user) {
            if ($user->is_active != 1) {
                $this->session->set_flashdata('error', 'Account not activated.');
                redirect('add-property');
                return;
            }

            if (password_verify($password, $user->password)) {
                // Set session data
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'logged_in' => true
                ]);
                redirect('dashboard'); // Change this to your target page
            } else {
                $this->session->set_flashdata('error', 'Invalid password.');
                redirect('add-property');
            }
        } else {
            $this->session->set_flashdata('error', 'User not found.');
            redirect('add-property');
        }
    }

      public function logout() {
        $this->session->sess_destroy();
        redirect('control');
    }

}
