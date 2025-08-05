<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Membership extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Regular_member_model');
        $this->load->model('Corporate_member_model');
    }



   public function submit_regular()
{
	$recaptchaToken = $this->input->post('g-recaptcha-response');
$secretKey = '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';
$remoteIp = $this->input->ip_address();

// Validate reCAPTCHA
$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaToken}&remoteip={$remoteIp}");
$response = json_decode($verify);

if (!($response->success && $response->score >= 0.5)) {
    // Block or show error
    $this->session->set_flashdata('error', 'reCAPTCHA failed. Please try again.');
    redirect('https://newmuthaigaresidentsassociation.com/');
    return;
}
   
	   
    // Get form data
    $postData = $this->input->post();

    // Generate unique IDs
    $postData['user_id'] = 'USER-' . strtoupper(uniqid());
    $postData['membership_no'] = 'REG-' . strtoupper(uniqid());

    // Save to database
    $this->Regular_member_model->insert($postData);

    // Email content setup
    $siteUrl = base_url() . '/login/';
    $subject = 'New Muthaiga Residents Association - New Regular Registration';

    // Prepare data for the email template
    $data['siteUrl'] = $siteUrl;
    $data['title'] = $postData['title'];
    $data['first_name'] = $postData['first_name'];
    $data['last_name'] = $postData['last_name'];
    $data['email_address'] = $postData['email_address'];
    $data['mobile_no'] = $postData['mobile_no'];
    $data['phone_no'] = $postData['phone_no'];
    $data['member_type'] = $postData['member_type'];
    $data['membership_no'] = $postData['membership_no'];
    $data['id_passport_no'] = $postData['id_passport_no'];
    $data['regular_lr_no'] = $postData['regular_lr_no'];
    $data['profession'] = $postData['profession'];
    $data['postal_code'] = $postData['postal_code'];
    $data['postal_address'] = $postData['postal_address'];
    $data['notes'] = $postData['notes'];

    // Load HTML email template
    $html = $this->load->view('front/templates/regular_member_registration', $data, true);

    // Send email to admin, not the user
    $this->sendMail('committee@newmuthaigaresidentsassociation.com', $subject, $html);
    // $this->sendMail('kelvin.muli@zilojo.com', $subject, $html);
    // Flash message and redirect
    $this->session->set_flashdata('success', 'Regular member application form submitted successfully!');
    redirect('regular-payment/' . $postData['user_id']);
}



function sendMail($to, $subject, $message)
{
    // Load PHPMailer library
    $this->load->library('phpmailer_lib');

    // PHPMailer object
    $mail = $this->phpmailer_lib->load();

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host       = 'ssl://smtp.googlemail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'zidii.info@gmail.com';
    $mail->Password   = 'imhejvzsffysxguc'; // Consider moving this to a config/env file
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->setFrom('zidii.info@gmail.com', 'New Muthaiga Residents Association');
    $mail->addReplyTo('zidii.info@gmail.com', 'New Muthaiga Residents Association');

    // Add recipient
    $mail->addAddress($to);

    // Add BCC
    $mail->addBCC('web@zilojo.com');
    $mail->addBCC('kelvin.muli@zilojo.com');
    // Email subject & content
    $mail->Subject = $subject;
    $mail->isHTML(true);
    $mail->Body = $message;

    // Send email
    if (!$mail->send()) {
        echo 'Message could not be sent.<br>';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
}




    public function submit_corporate()
{
		
		$recaptchaToken = $this->input->post('g-recaptcha-response');
$secretKey = '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';
$remoteIp = $this->input->ip_address();

// Validate reCAPTCHA
$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaToken}&remoteip={$remoteIp}");
$response = json_decode($verify);

if (!($response->success && $response->score >= 0.5)) {
    // Block or show error
    $this->session->set_flashdata('error', 'reCAPTCHA failed. Please try again.');
    redirect('https://newmuthaigaresidentsassociation.com/');
    return;
}
   
    // Get form data
    $postData = $this->input->post();

    // Generate unique IDs
    $postData['user_id'] = 'USER-' . strtoupper(uniqid());
    $postData['corporate_membership_no'] = 'CORP-' . strtoupper(uniqid());
    //$corporate_membership_no = '';
    // Save to database
    $this->Corporate_member_model->insert($postData);
    
    // Email content setup
    $siteUrl = base_url() . '/login/';
    $subject = 'New Muthaiga Residents Association - Corporate Registration';

    // Prepare data for the email template
    $data['siteUrl'] = $siteUrl;
    //$data['corporate_membership_no'] = $corporate_membership_no;  
    $data['company_name'] = $postData['company_name'];
    $data['member_type'] = $postData['member_type'];
    $data['email_address'] = $postData['email_address'];
    $data['mobile_no'] = $postData['mobile_no'];
    $data['type_of_business'] = $postData['type_of_business'];
    $data['physical_address'] = $postData['physical_address'];
    $data['postal_address'] = $postData['postal_address'];
    $data['postal_code'] = $postData['postal_code'];
    $data['company_contact_name'] = $postData['company_contact_name'];
    $data['company_contact_no'] = $postData['company_contact_no'];
    $data['company_contact_email'] = $postData['company_contact_email'];
    $data['notes'] = $postData['notes'];

    // Load HTML email template
    $html = $this->load->view('front/templates/corporate_member_registration', $data, true);

    // Send email to admin
    $this->sendMail('committee@newmuthaigaresidentsassociation.com', $subject, $html);

    // Flash message and redirect
    $this->session->set_flashdata('success', 'Corporate member application form submitted successfully!');
    redirect('corporate-payment/' . $postData['user_id']);
}



    public function regular_payments($user_id)
    {
        $data['regularpaymentslisting'] = $this->Regular_member_model->get_by_id($user_id);
         // print_r($data);
         // exit;

        $this->load->view('regular_member_payment', $data);
    }

    public function corporate_payments($user_id)
    {
        $data['corporatepaymentslisting'] = $this->Corporate_member_model->get_by_id($user_id);
         // print_r($data);
         // exit;

        $this->load->view('corporate_payment', $data);
    }
}

