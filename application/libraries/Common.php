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
        return $this->ci->session->userdata(GlobalModel::SESSION);
    }

    public function loadHeaderData($toolBarMenu, $subToolBarMenu='')
    {	
        $session_data = $this->loadSession();
		$user_type_id = $session_data['user_type_id'];
		$customer_db_setting_id = $session_data['customer_db_setting_id'];
		$headerData = $session_data;

		$moduleMenu = $this->ci->MaintenanceModel->getTableRow('m_module', 'module_id', array('path'=>$toolBarMenu));
		$headerData["moduleMenu"] = $moduleMenu;
		if ($subToolBarMenu != NULL)
		{
			$subModuleMenu = $this->ci->MaintenanceModel->getTable('m_module', 'module_id', array('path'=>$subToolBarMenu, 'main_id'=>$headerData["moduleMenu"]->module_id))[0];
			$headerData["subModuleMenu"] = $subModuleMenu;
			$headerData['viewSubUserRight'] = !empty(get_user_right($user_type_id, $subModuleMenu->module_id, 'view', 1)); 
		}
        $headerData['moduleData'] = $this->ci->MaintenanceModel->getTable('m_module', 'module_id', array('platform_id'=>'1662835632755'), 'ASC');
		$headerData['subModuleData'] = $this->ci->MaintenanceModel->getTable('m_module', 'module_id', array('platform_id'=>'1662835632755', 'sub'=>1));
		$headerData['numericSelectData'] = $this->ci->MaintenanceModel->getTable('m_numeric_select', 'numeric_select_id', array('active'=>1));
		if (in_array($user_type_id, array(GlobalModel::CLUB_ADMIN_TYPE)))
			$headerData['userTypeData'] = $this->ci->MaintenanceModel->getTableResult('m_user_type', NULL, array('user_type_id'=>array(GlobalModel::CLUB_ADMIN_TYPE, GlobalModel::MEMBER_TYPE)));
		elseif (in_array($user_type_id, array(GlobalModel::MEMBER_TYPE)))
			$headerData['userTypeData'] = $this->ci->MaintenanceModel->getTableResult('m_user_type', array('user_type_id'=>GlobalModel::MEMBER_TYPE));
		else
			$headerData['userTypeData'] = $this->ci->MaintenanceModel->getTable('m_user_type', 'user_type_id', array('active'=>1));
		$headerData['paymentStatusData'] = $this->ci->MaintenanceModel->getTable('m_payment_status', 'payment_status_id', array('active'=>1));
		$headerData['moduleTypeData'] = $this->ci->MaintenanceModel->getTable('m_module_type', 'module_type_id', array('active'=>1));
		$headerData['platformData'] = $this->ci->MaintenanceModel->getTable('m_platform', 'platform_id', array('active'=>1));
		$headerData['systemRow'] =$this->ci->MaintenanceModel->getTableRow('m_system', 'system_id', '1670861690788');
		$stateData = $this->ci->MaintenanceModel->getTable('m_state', 'state_id', array('active'=>1));
		$activeData = $this->ci->MaintenanceModel->getTable('m_active', 'active_id', array('active'=>1));
		$userRightData = $this->ci->MaintenanceModel->getTable('user_right');

		$headerData['viewUserRight'] = !empty(get_user_right($user_type_id, $moduleMenu->module_id, 'view', 1)); 
		// $headerData['figureUserRight'] = !empty(get_user_right($user_type_id, $moduleMenu->module_id, 'figure', 1)); 
		$headerData['inputUserRight'] = !empty(get_user_right($user_type_id, $moduleMenu->module_id, 'input', 1)); 
		$headerData['editUserRight'] = !empty(get_user_right($user_type_id, $moduleMenu->module_id, 'edit', 1)); 
		$headerData['approveUserRight'] = !empty(get_user_right($user_type_id, $moduleMenu->module_id, 'approve', 1)); 
		$headerData['removeUserRight'] = !empty(get_user_right($user_type_id, $moduleMenu->module_id, 'remove', 1));

		$userRightDataArray = []; $stateDataArray = []; $activeDataArray = [];
		foreach ($userRightData as $value) {
			$userRightDataArray[$value->user_type_id][] = $value;
			$userRightDataArray[$value->user_type_id.'_'.$value->module_id][] = $value;
		}

		foreach ($activeData as $value) {
			$activeDataArray[$value->num] = $value;
		}
		
		foreach ($stateData as $value) {
			$stateDataArray[$value->num] = $value;
		}
		$headerData['stateData'] = $stateData;
		$headerData['stateDataArray'] = $stateDataArray;
		$headerData['activeData'] = $activeData;
		$headerData['activeDataArray'] = $activeDataArray;
		$headerData['paymentStatusId'] = '';
		$headerData['userTypeId'] = '';
		$headerData['moduleTypeId'] = '';
		$headerData['customerDBSettingId'] = $customer_db_setting_id;
        return $headerData;
    }

    public function checkSession()
    {
     //check Session
		$session_data = $this->loadSession();
		if (empty($session_data)) 
		{
			if (isset($params) && $params['dialog'] == 1) 
			{
				$modal ='<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
								<div class="modal-body">
									<div class="modal-title">Session Expired</div>
									<div>Your session has expired. Please logout and login again.</div>
								</div>

								<form action="'.base_url('logout').'" method="POST" enctype="multipart/form-data">
									<div class="modal-footer">
										<button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Logout</button>
									</div>
								</form>
                            </div>
                        </div>';
				print_r($modal);
			} 
			else 
			{
		    	redirect('home', 'refresh');
			}
		}
        
        // if ($session_data['reset']==0) {
        //  $this->ci->session->set_flashdata('err',"Oops! Your account has been deactivated please reset your Password"); 
        //     redirect('auth/Reset', 'refresh');
		// }

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
    
	
	function sendMail($to,$subject,$message){
        $this->ci->load->library('phpmailer_lib');
        $mail = $this->ci->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'ssl://smtp.googlemail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'zidii.info@gmail.com';
        $mail->Password = 'imhejvzsffysxguc';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->setFrom('zidii.info@gmail.com', 'Zidii Club Manager');
        $mail->addReplyTo('zidii.info@gmail.com', 'Zidii Club Manager');

        // Add a recipient
        $mail->addAddress($to);

        // Add cc or bcc 
        // $mail->addCC('cc@example.com');
        $mail->addBCC('mulikelvin17@gmail.com');

        // Email subject
        $mail->Subject = $subject;

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
            <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
        $mail->Body = $message;
        // Send email
        // if(!$mail->send()){
        //     echo 'Message could not be sent.';
        //     echo 'Mailer Error: ' . $mail->ErrorInfo;
        // }else{
        //     echo 'Message has been sent';
        // }
    }

	// ---------------------------------------------------------------------------------------------------------
	//     $mail->isSMTP();
	//     $mail->Host       = 'smtp.postmarkapp.com';
	//     $mail->SMTPAuth   = true;
	//     $mail->Username   = 'your-postmark-server-token'; // Replace with your Postmark Server API Token
	//     $mail->Password   = 'your-postmark-server-token'; // Same token is used as password
	//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
	//     $mail->Port       = 587;
	// -----------------------------------------------------------------------------------------------------------

    // function sendMail($to,$subject,$message){

    //     $smtpConfig = $this->ci->ClubModel->getSmtp();

    //     $this->ci->load->library('phpmailer_lib');

    //     $mail = $this->ci->phpmailer_lib->load();

    //     $mail->isSMTP();
    //     $mail->Host     = $smtpConfig[0]->host;
    //     $mail->SMTPAuth = $smtpConfig[0]->smtpauth;
    //     $mail->Username = $smtpConfig[0]->username;
    //     $mail->Password = $smtpConfig[0]->password;
    //     $mail->SMTPSecure = $smtpConfig[0]->smtpsecure;
    //     // $mail->SMTPAutoTLS = $smtpConfig[0]->smtp_auto_tls;
    //     $mail->Port     = $smtpConfig[0]->port;

    //     $mail->setFrom($smtpConfig[0]->email_from, 'ClubMemberApp');
    //     $mail->addReplyTo($smtpConfig[0]->reply_to_email, 'ClubMemberApp');

    //     // Add a recipient
    //     $mail->addAddress($to);

    //     // Add cc or bcc 
    //     // $mail->addCC('cc@example.com');
    //     // $mail->addBCC('updates@clubmember.app');
    //     $mail->addBCC($smtpConfig[0]->bcc_email);
    //     $mail->addBCC($smtpConfig[0]->bcc_email_1);
    //     $mail->addBCC($smtpConfig[0]->bcc_email_2);
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
    //         // echo 'Message has been sent';
    //     }
    //}


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
