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
		$data['customerRow'] = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
        $paymentHistoryRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->where('payment_history_id', $payment_history_id)->get()->row();
		$subscriptionRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.subscription')->where('subscription_id', $paymentHistoryRow->universal_id)->get()->row();
		$data['userRow'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $paymentHistoryRow->user_id)->get()->row();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['paymentHistoryRow'] = $paymentHistoryRow;
		$data['subscriptionRow'] = $subscriptionRow;
		$data['membershipFeeTypeRow'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.membership_fee_type')->where('membership_fee_type_id', $subscriptionRow->membership_fee_type_id)->get()->row();

        return $this->load->view('admin/subscription_receipt_modal', $data);
    }

	public function subscriptionReceiptContent($user_id, $payment_history_id)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$data['customerRow'] = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
		$paymentHistoryRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->where('payment_history_id', $payment_history_id)->get()->row();
		$subscriptionRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.subscription')->where('subscription_id', $paymentHistoryRow->universal_id)->get()->row();
		$data['userRow'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $paymentHistoryRow->user_id)->get()->row();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['paymentHistoryRow'] = $paymentHistoryRow;
		$data['subscriptionRow'] = $subscriptionRow;
		$data['membershipFeeTypeRow'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.membership_fee_type')->where('membership_fee_type_id', $subscriptionRow->membership_fee_type_id)->get()->row();
		$data['showReceiptActions'] = true;

		return $this->load->view('admin/subscription_receipt_content', $data);
	}

	public function subscriptionReceiptPdf($user_id, $payment_history_id)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$data['customerRow'] = $this->db->select('*')->from('customer')->where('customer_id', $customerDBSettingRow->customer_id)->get()->row();
		$paymentHistoryRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.payment_history')->where('payment_history_id', $payment_history_id)->get()->row();
		if (!$paymentHistoryRow) {
			show_error('Receipt not found.', 404);
			return;
		}
		$subscriptionRow = $this->db->select('*')->from($customerDBSettingRow->database_name.'.subscription')->where('subscription_id', $paymentHistoryRow->universal_id)->get()->row();
		$data['userRow'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.user')->where('user_id', $paymentHistoryRow->user_id)->get()->row();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['paymentHistoryRow'] = $paymentHistoryRow;
		$data['subscriptionRow'] = $subscriptionRow;
		$data['membershipFeeTypeRow'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.membership_fee_type')->where('membership_fee_type_id', $subscriptionRow->membership_fee_type_id)->get()->row();
		$data['showReceiptActions'] = false;

		if (!class_exists('TCPDF')) {
			if (file_exists(APPPATH . 'libraries/tcpdf/tcpdf.php')) {
				require_once(APPPATH . 'libraries/tcpdf/tcpdf.php');
			}
		}

		if (!class_exists('TCPDF')) {
			show_error('PDF generation library (TCPDF) not found. Please install TCPDF in application/libraries/tcpdf/', 500);
			return;
		}

		$html = $this->load->view('admin/subscription_receipt_content', $data, true);
		$bodyHtml = $html;
		if (preg_match('/<body[^>]*>.*<\/body>/is', $html, $matches)) {
			$bodyHtml = $matches[0];
		}
		$pdfCss = '<style>'
			. 'body{font-family:dejavusans;font-size:10pt;color:#111827;}'
			. 'table{border-collapse:collapse;}'
			. 'h2{font-size:16pt;margin:0;}'
			. '</style>';
		$filenameBase = 'subscription_receipt_' . preg_replace('/[^A-Za-z0-9\-_]/', '_', (string) $payment_history_id);
		$timestamp = date('Ymd_His');
		$filename = $filenameBase . '_' . $timestamp . '.pdf';

		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Clubmember');
		$pdf->SetTitle('Subscription Receipt');
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetAutoPageBreak(false, 0);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->SetFont('dejavusans', '', 10);
		$pdf->writeHTML($pdfCss . $bodyHtml, true, false, true, false, '');

		$pdfOutput = $pdf->Output($filename, 'S');
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-Length: ' . strlen($pdfOutput));
		echo $pdfOutput;
		exit;
	}

	public function downloadReceiptPdf()
	{
		$this->common->checkSession();
		$imageData = $this->input->post('imageData', false);
		$html = $this->input->post('html', false);
		$title = $this->input->post('title', true);
		if (empty($imageData) && empty($html)) {
			show_error('Receipt content is required.', 400);
			return;
		}

		if (!class_exists('TCPDF')) {
			if (file_exists(APPPATH . 'libraries/tcpdf/tcpdf.php')) {
				require_once(APPPATH . 'libraries/tcpdf/tcpdf.php');
			}
		}

		if (!class_exists('TCPDF')) {
			show_error('PDF generation library (TCPDF) not found. Please install TCPDF in application/libraries/tcpdf/', 500);
			return;
		}

		$filenameBase = !empty($title) ? preg_replace('/[^A-Za-z0-9\-_]/', '_', $title) : 'subscription_receipt';
		$timestamp = date('Ymd_His');
		$filename = $filenameBase . '_' . $timestamp . '.pdf';

		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Clubmember');
		$pdf->SetTitle($title ?: 'Subscription Receipt');
		if (!empty($imageData)) {
			$pdf->SetMargins(0, 0, 0);
			$pdf->SetAutoPageBreak(false, 0);
		} else {
			$pdf->SetMargins(10, 10, 10);
			$pdf->SetAutoPageBreak(false, 0);
		}
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->SetFont('dejavusans', '', 10);
		if (!empty($imageData)) {
			$imageType = 'PNG';
			if (preg_match('/^data:image\/(\w+);base64,/i', $imageData, $typeMatch)) {
				$mimeType = strtolower($typeMatch[1]);
				if ($mimeType === 'jpeg' || $mimeType === 'jpg') {
					$imageType = 'JPG';
				} elseif ($mimeType === 'png') {
					$imageType = 'PNG';
				}
			}
			$base64 = preg_replace('/^data:image\/\w+;base64,/i', '', $imageData);
			$imageBinary = base64_decode($base64);
			if ($imageBinary === false) {
				show_error('Invalid receipt image data.', 400);
				return;
			}

			$size = @getimagesizefromstring($imageBinary);
			if ($size === false) {
				show_error('Invalid receipt image data.', 400);
				return;
			}

			$pageWidth = $pdf->getPageWidth();
			$pageHeight = $pdf->getPageHeight();
			$imgWidth = $size[0];
			$imgHeight = $size[1];
			$scale = min($pageWidth / $imgWidth, $pageHeight / $imgHeight);
			$drawWidth = $imgWidth * $scale;
			$drawHeight = $imgHeight * $scale;

			$pdf->Image('@' . $imageBinary, 0, 0, $drawWidth, $drawHeight, $imageType);
		} else {
			$pdf->writeHTML($html, true, false, true, false, '');
		}

		$pdfOutput = $pdf->Output($filename, 'S');
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-Length: ' . strlen($pdfOutput));
		echo $pdfOutput;
		exit;
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

	public function checkMpesaPaymentStatus($checkoutRequestId='', $user_id='', $payment_history_id='', $phone_no='', $amount='')
	{
		$this->common->checkSession();
		$sessionData = $this->common->loadSession();
		$customerDbSettingId = $sessionData['customer_db_setting_id'];
		$customerDBSettingRow = $this->db->select('*')
			->from('customer_db_setting')
			->where('customer_db_setting_id', $customerDbSettingId)
			->get()
			->row();

		// Call the method to check MPESA payment status
		$paymentHistoryRow = $this->db->from($customerDBSettingRow->database_name.'.payment_history')
			->where('payment_history_id', $payment_history_id)
			->get()
			->row();

		// Return the result as JSON
		// header('Content-Type: application/json');
		// print_r(json_encode($paymentHistoryRow));
		echo $paymentHistoryRow->payment_status_id == '1732371146921' ? 'success' : 'pending';
	}

}
