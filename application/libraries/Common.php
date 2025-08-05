<?php defined('BASEPATH') or exit('No direct script access allowed');
// ini_set('display_errors', 0);
class Common
{
     protected $ci; 
   
    public function __construct()
    {
        $this->ci = &get_instance();
    }


    public function loadSession()
    {
        return $this->ci->session->userdata('XmR2qDXOJu4ey6vZurlDpncDDDUbINQNffpopp');
    }

    public function loadHeaderData($Menue)
    {
	  //Load session	
        $session_data = $this->loadSession();

	 
	  //get data from the database
        $headerData['user_name'] = $session_data['user_name'];
        $headerData['user_id'] = $session_data['user_id'];
        $headerData['email'] = $session_data['email'];
        $headerData['user_type'] = $session_data['user_type'];
        $headerData['name'] = $session_data['name'];
        $headerData['middle_name'] = $session_data['middle_name'];
        $headerData['last_name'] = $session_data['last_name'];
        $headerData['phone_number'] = $session_data['phone_number'];
        // $headerData['id_no'] = $session_data['id_no'];
        // $headerData['designation'] = $session_data['designation'];
        // $headerData['staff_number'] = $session_data['staff_number'];
        // $headerData['gross_pay'] = $session_data['gross_pay'];
        $headerData['membership_no'] = $session_data['membership_no'];
        $headerData['club_id'] = $session_data['club_id'];

        $headerData["module"] = $Menue;
        $headerData['Module'] = $this->ci->Maintenance_model->getModule();
        $headerData['UserRights'] = $this->ci->Maintenance_model->getUserRights();

        return $headerData;
    }

    public function checkSession()
    {
     //check Session
		$session_data = $this->loadSession();
		if (empty($session_data)) {
		    redirect('home', 'refresh');
		}
        

        $session_data = $this->loadSession();
        if ($session_data['reset']==0) {
         $this->ci->session->set_flashdata('err',"Oops! Your account has been deactivated please reset your Password"); 
            redirect('auth/Reset', 'refresh');
		}

		// if ($session_data['activation_status']==0) {
		// 	$this->ci->session->set_flashdata('err',"Oops! you have not verified your email please check your inbox or spam"); 
		// 	   redirect('auth/Login', 'refresh');
		// }
		
	}
	
   
    // unique ids
    function uniqidReal($lenght = 13)
    {
    // uniqid gives 13 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
    
	
	// function sendMail($to,$subject,$message){
    //     $this->ci->load->library('phpmailer_lib');
    //     $mail = $this->ci->phpmailer_lib->load();

    //     // SMTP configuration
    //     $mail->isSMTP();
    //     $mail->Host     = 'ssl://smtp.googlemail.com';
    //     $mail->SMTPAuth = true;
    //     $mail->Username = 'zidii.info@gmail.com';
    //     $mail->Password = 'imhejvzsffysxguc';
    //     $mail->SMTPSecure = 'ssl';
    //     $mail->Port     = 465;

    //     $mail->setFrom('zidii.info@gmail.com', 'Zidii Club Manager');
    //     $mail->addReplyTo('zidii.info@gmail.com', 'Zidii Club Manager');

    //     // Add a recipient
    //     $mail->addAddress($to);

    //     // Add cc or bcc 
    //     // $mail->addCC('cc@example.com');
    //     $mail->addBCC('zidii.info@gmail.com');

    //     // Email subject
    //     $mail->Subject = $subject;

    //     // Set email format to HTML
    //     $mail->isHTML(true);

    //     // Email body content
    //     $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
    //         <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
    //     $mail->Body = $message;

    //     // Send email
    //     if(!$mail->send()){
    //         echo 'Message could not be sent.';
    //         echo 'Mailer Error: ' . $mail->ErrorInfo;
    //     }else{
    //         echo 'Message has been sent';
    //     }
    // }

    function sendMail($to,$subject,$message){

        $smtpConfig = $this->ci->ClubModel->getSmtp();

        $this->ci->load->library('phpmailer_lib');

        $mail = $this->ci->phpmailer_lib->load();

        $mail->isSMTP();
        $mail->Host     = $smtpConfig[0]->host;
        $mail->SMTPAuth = $smtpConfig[0]->smtpauth;
        $mail->Username = $smtpConfig[0]->username;
        $mail->Password = $smtpConfig[0]->password;
        $mail->SMTPSecure = $smtpConfig[0]->smtpsecure;
        // $mail->SMTPAutoTLS = $smtpConfig[0]->smtp_auto_tls;
        $mail->Port     = $smtpConfig[0]->port;

        $mail->setFrom($smtpConfig[0]->email_from, 'ClubMemberApp');
        $mail->addReplyTo($smtpConfig[0]->reply_to_email, 'ClubMemberApp');

        // Add a recipient
        $mail->addAddress($to);

        // Add cc or bcc 
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('updates@clubmember.app');
        $mail->addBCC($smtpConfig[0]->bcc_email);
        $mail->addBCC($smtpConfig[0]->bcc_email_1);
        $mail->addBCC($smtpConfig[0]->bcc_email_2);
        // Email subject
        $mail->Subject = $subject;

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
            <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
        $mail->Body = $message;

        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            // echo 'Message has been sent';
        }
    }


    function sendMailDynamic($to,$subject,$message,$club_id){

        // $smtpConfig = $this->ci->ClubModel->getSmtp();
        
        $smtpConfig = $this->ci->db->select('*')->from('zidii_smtp_settings')->where('club_id', $club_id)->get()->row();

        if (empty($smtpConfig)) {
            $smtpConfig = $this->ci->db->select('*')->from('zidii_smtp_settings')->where('id', '1')->get()->row();
        }

        $this->ci->load->library('phpmailer_lib');

        $mail = $this->ci->phpmailer_lib->load();

        $mail->isSMTP();
        $mail->Host     = $smtpConfig->host;
        $mail->SMTPAuth = $smtpConfig->smtpauth;
        $mail->Username = $smtpConfig->username;
        $mail->Password = $smtpConfig->password;
        $mail->SMTPSecure = $smtpConfig->smtpsecure;
        // $mail->SMTPAutoTLS = $smtpConfig[0]->smtp_auto_tls;
        $mail->Port     = $smtpConfig->port;

        $mail->setFrom($smtpConfig->email_from, 'ClubMemberApp');
        $mail->addReplyTo($smtpConfig->reply_to_email, 'ClubMemberApp');

        // Add a recipient
        $mail->addAddress($to);

        // Add cc or bcc 
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('updates@clubmember.app');
        $mail->addBCC($smtpConfig->bcc_email);
        $mail->addBCC($smtpConfig->bcc_email_1);
        // $mail->addBCC($smtpConfig->bcc_email_2);
        // Email subject
        $mail->Subject = $subject;

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
            <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
        $mail->Body = $message;

        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            // echo 'Message has been sent';
        }
    }



}

/* End of file Common.php */
/* Location: ./application/libraries/Common.php */
