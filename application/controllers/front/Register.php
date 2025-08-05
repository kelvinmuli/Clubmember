<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct() {
        parent::__construct();

        $this->load->model('User_model');
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
		$this->load->view('front/register_view');
		$this->load->view('front/templates/footer_view');
	}

	public function register_user() {
    $email = $this->input->post('email');
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $confirm_password = $this->input->post('confirm_password');

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        return;
    }

    $token = bin2hex(random_bytes(32));
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $user_data = [
        'email' => $email,
        'username' => $username,
        'password' => $hashed_password,
        'activation_token' => $token,
        'is_active' => 0
    ];

    if ($this->User_model->insert_user($user_data)) {
        // $this->send_activation_email($email, $token);
        echo "Registration successful! Please check your email to activate your account.";
    } else {
        echo "Registration failed.";
    }
}

}
