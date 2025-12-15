<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Common $common
 */
class PaymentHistoryController extends CI_Controller 
{

    public function __construct() {
        parent::__construct();
    }

	public function paymentHistoryView($payment_status_id)
    {
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$data = $this->common->loadHeaderData('payment-history');
		$customer_db_setting_id = $session_data['customer_db_setting_id'];

		$paymentHistoryData = $this->db->select('*')
			->from('payment_history as ph')
			->join('m_payment_status as mps', 'ph.payment_status_id = mps.payment_status_id', 'left')
			->where('ph.payment_status_id', $payment_status_id)
			->order_by('ph.created_at', 'DESC')
			->get()
			->result();

		$data['paymentHistoryData'] = $paymentHistoryData;
		$data['customer_db_setting_id'] = $customer_db_setting_id;
		$data['payment_status_id'] = $payment_status_id;

		$this->load->view('admin/templates/header_view', $data);
		$this->load->view('admin/payment_history_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
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

	public function addFundraisingPaymentHistoryModal($fundraisingId)
	{
		$this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $customerDbSettingId = $sessionData['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();

		$data['fundraising_id'] = $fundraisingId;
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['userRow'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $sessionData['user_id'])->get()->row();
		$data['user_type_id'] = $sessionData['user_type_id'];
		$data['user_id'] = $sessionData['user_id'];
		$data['paymentMethodData'] = $this->db->select('*')->from('m_payment_method')->order_by('name', 'ASC')->get()->result();
		$data['paymentStatusData'] = $this->db->select('*')->from('m_payment_status')->order_by('name', 'ASC')->get()->result();
		$data['memberData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_type_id', GlobalModel::MEMBER_TYPE)->order_by('full_legal_name', 'ASC')->get()->result();

		return $this->load->view('admin/add_edit_fundraising_payment_history_modal', $data);
	}

	public function viewFundraisingPaymentHistoryModal($fundraisingId)
	{
		$this->common->checkSession();
		$sessionData = $this->common->loadSession();
		$customerDbSettingId = $sessionData['customer_db_setting_id'] ?? null;

		$customerDBSettingRow = $this->db->select('*')
			->from('customer_db_setting')
			->where('customer_db_setting_id', $customerDbSettingId)
			->get()
			->row();

		$payments = [];
		$totalPaid = 0.0;
		$payments = $this->db->select('ph.*, mps.name AS status_name, mps.name AS status_code, mpm.name AS method_name, mc.sign AS currency_sign, mc.name AS currency_name')
				->from($customerDBSettingRow->database_name . '.payment_history' . ' ph')
				->join('m_payment_status mps', 'ph.payment_status_id = mps.payment_status_id', 'left')
				->join('m_payment_method mpm', 'ph.payment_method_id = mpm.payment_method_id', 'left')
				->join('m_currency mc', 'ph.currency_id = mc.currency_id', 'left')
				->where('ph.universal_id', $fundraisingId)
				->order_by('ph.created_at', 'DESC')
				->get()
				->result();
		
		foreach ($payments as $row) {
			$amount = null;
			if (isset($row->paid_amount) && $row->paid_amount !== '' && $row->paid_amount !== null) {
				$amount = (float) $row->paid_amount;
			} elseif (isset($row->bill_amount) && $row->bill_amount !== '' && $row->bill_amount !== null) {
				$amount = (float) $row->bill_amount;
			}

			if ($amount !== null) {
				$totalPaid += $amount;
			}
		}

		$data = [
			'fundraising_id' => $fundraisingId,
			'customerDBSettingRow' => $customerDBSettingRow,
			'payments' => $payments,
			'totalPaid' => $totalPaid,
		];
		$data['fundraisingRow'] = $this->db->select('*')
			->from($customerDBSettingRow->database_name . '.fundraising')
			->where('fundraising_id', $fundraisingId)
			->get()
			->row();

		return $this->load->view('admin/view_fundraising_payment_history_modal', $data);
	}

	public function addFundraisingPaymentHistory()
	{
		$this->common->checkSession();
		$sessionData = $this->common->loadSession();
		$customerDbSettingId = $sessionData['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')
			->from('customer_db_setting')
			->where('customer_db_setting_id', $customerDbSettingId)
			->get()
			->row();

		$postData = $this->input->post();

		$this->db->insert($customerDBSettingRow->database_name.'.payment_history', $postData);
		$this->session->set_flashdata('message', 'Fundraising payment history added successfully.');
		redirect('fundraising', 'refresh');
	}

}
