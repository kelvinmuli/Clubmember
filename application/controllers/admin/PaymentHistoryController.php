<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentHistoryController extends CI_Controller 
{

    public function __construct() {
        parent::__construct();
    }

    public function paymentReceiptModal($user_id, $payment_history_id)
    {
         $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
        $data['paymentHistoryRow'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->where('payment_history_id', $payment_history_id)->get()->row();

        return $this->load->view('admin/subscription_receipt_modal', $data);
    }


}
