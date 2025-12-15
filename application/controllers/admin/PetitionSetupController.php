<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PetitionSetupController extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function petitionSetupView()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $data = $this->common->loadHeaderData('petition-setup');
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $tenantDatabase = $customerDBSettingRow->database_name;

        $petitionQuery = $this->db->select('*')
            ->from($tenantDatabase . '.petition_setup')
            ->order_by('created_at', 'DESC')
            ->get();

        $data['petitionSetupData'] = $petitionQuery->result();
        $data['petitionSummary'] = $this->calculatePetitionSummary($tenantDatabase, $data['petitionSetupData']);
        $data['customer_db_setting_id'] = $customer_db_setting_id;

        $this->load->view('admin/templates/header_view', $data);
        $this->load->view('admin/petition_setup_view', $data);
        $this->load->view('admin/templates/footer_view', $data);
    }

    public function addPetitionSetupModal()
    {
        $this->common->checkSession();
        $this->common->loadSession();

        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
        $data['petition_setup_id'] = generate_uuid();

        return $this->load->view('admin/add_edit_petition_setup_modal', $data);
    }

    public function addPetitionSetup()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $postData = $this->input->post();
        $postData['no_of_signature'] = isset($postData['no_of_signature']) && $postData['no_of_signature'] !== '' ? (int) $postData['no_of_signature'] : 0;
        if (isset($postData['closing_at']) && !empty($postData['closing_at'])) {
            $postData['closing_at'] = date('d M Y', strtotime($postData['closing_at']));
        }
        $postData['created_at'] = date('d M Y');

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $this->db->insert($customerDBSettingRow->database_name . '.petition_setup', $postData);
        $this->session->set_flashdata('success', 'Petition setup saved successfully.');
        redirect('petition-setup', 'refresh');
    }

    public function viewPetitionModal($petition_setup_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $data = [
            'petitionRow' => null,
            'petition_setup_id' => $petition_setup_id,
            'signatureCount' => 0,
            'signatureGoal' => 0,
            'signatureProgress' => 0,
        ];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        if ($customerDBSettingRow && !empty($petition_setup_id)) {
            $tenantDatabase = $customerDBSettingRow->database_name;
            $petitionRow = $this->db->from($tenantDatabase . '.petition_setup')
                ->where('petition_setup_id', $petition_setup_id)
                ->get()
                ->row();

            if ($petitionRow) {
                $data['petitionRow'] = $petitionRow;
                $data['signatureGoal'] = isset($petitionRow->no_of_signature) ? (int) $petitionRow->no_of_signature : 0;
                $data['signatureCount'] = $this->db->from($tenantDatabase . '.petition_signature')
                    ->where('petition_setup_id', $petition_setup_id)
                    ->count_all_results();
                $data['signatureProgress'] = $data['signatureGoal'] > 0
                    ? min(100, round(($data['signatureCount'] / $data['signatureGoal']) * 100))
                    : ($data['signatureCount'] > 0 ? 100 : 0);
            }
        }

        return $this->load->view('admin/view_petition_modal', $data);
    }

    public function editPetitionSetupModal($petition_setup_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $petitionSetupRow = $this->db->from($customerDBSettingRow->database_name . '.petition_setup')
            ->where('petition_setup_id', $petition_setup_id)
            ->get()
            ->row();

        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
        $data['petitionSetupRow'] = $petitionSetupRow;
        $data['petition_setup_id'] = $petition_setup_id;

        return $this->load->view('admin/add_edit_petition_setup_modal', $data);
    }

    public function editPetitionSetup()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $postData = $this->input->post();
        $petition_setup_id = $postData['petition_setup_id'];
        unset($postData['petition_setup_id']);

        if (isset($postData['no_of_signature'])) {
            $postData['no_of_signature'] = $postData['no_of_signature'] !== '' ? (int) $postData['no_of_signature'] : 0;
        }
        if (isset($postData['closing_at']) && !empty($postData['closing_at'])) {
            $postData['closing_at'] = date('d M Y', strtotime($postData['closing_at']));
        } else {
            $postData['closing_at'] = null;
        }

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $this->db->update(
            $customerDBSettingRow->database_name . '.petition_setup',
            $postData,
            array('petition_setup_id' => $petition_setup_id)
        );

        $this->session->set_flashdata('success', 'Petition setup updated successfully.');
        redirect('petition-setup', 'refresh');
    }

    public function removePetitionSetupModal($petition_setup_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $petitionSetupRow = $this->db->from($customerDBSettingRow->database_name . '.petition_setup')
            ->where('petition_setup_id', $petition_setup_id)
            ->get()
            ->row();

        $data['table'] = $customerDBSettingRow->database_name . '.petition_setup';
        $data['table_id'] = 'petition_setup_id';
        $data['unique_id'] = $petition_setup_id;
        $data['name'] = isset($petitionSetupRow->name) && !empty($petitionSetupRow->name) ? $petitionSetupRow->name : 'petition setup record';
        $data['route'] = 'petition-setup';

        return $this->load->view('admin/remove_global_modal', $data);
    }

    public function removePetitionSetup()
    {
        redirect('petition-setup', 'refresh');
    }

    private function calculatePetitionSummary($tenantDatabase, $petitionSetupData)
    {
        $summary = [
            'total_petitions' => 0,
            'active_petitions' => 0,
            'open_petitions' => 0,
            'closed_petitions' => 0,
            'target_signatures' => 0,
            'collected_signatures' => 0,
            'progress_percent' => 0,
        ];

        if (empty($petitionSetupData)) {
            return $summary;
        }

        $summary['total_petitions'] = count($petitionSetupData);

        $signatureCounts = $this->db->select('petition_setup_id, COUNT(*) AS signature_count')
            ->from($tenantDatabase . '.petition_signature')
            ->group_by('petition_setup_id')
            ->get()
            ->result();

        $signatureIndex = [];
        foreach ($signatureCounts as $row) {
            $signatureIndex[$row->petition_setup_id] = (int) $row->signature_count;
        }

        $now = time();

        foreach ($petitionSetupData as $petition) {
            $activeValue = isset($petition->active) ? (int) $petition->active : null;
            if ($activeValue === 1) {
                $summary['active_petitions'] += 1;
            }

            $closingAt = isset($petition->closing_at) && !empty($petition->closing_at) ? strtotime($petition->closing_at) : null;
            $isOpen = ($closingAt === null || $closingAt >= $now);
            if ($isOpen) {
                $summary['open_petitions'] += 1;
            } else {
                $summary['closed_petitions'] += 1;
            }

            $targetSignatures = isset($petition->no_of_signature) ? (int) $petition->no_of_signature : 0;
            $summary['target_signatures'] += $targetSignatures;

            $collected = $signatureIndex[$petition->petition_setup_id] ?? 0;
            $summary['collected_signatures'] += $collected;
        }

        if ($summary['target_signatures'] > 0) {
            $summary['progress_percent'] = min(100, round(($summary['collected_signatures'] / $summary['target_signatures']) * 100));
        } else {
            $summary['progress_percent'] = $summary['collected_signatures'] > 0 ? 100 : 0;
        }

        return $summary;
    }

    public function petitionSignatureView($petition_setup_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $data = $this->common->loadHeaderData('petition-setup');
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $petitionSetupRow = $this->db->from($customerDBSettingRow->database_name . '.petition_setup')
            ->where('petition_setup_id', $petition_setup_id)
            ->get()
            ->row();

        $data['petitionSetupRow'] = $petitionSetupRow;
        $data['petition_setup_id'] = $petition_setup_id;
		if (in_array($session_data['user_type_id'], array(GlobalModel::ADMIN_TYPE, GlobalModel::CLUB_ADMIN_TYPE))) {
            $data['petitionSignatureData'] = $this->db->select('*')
                ->from($customerDBSettingRow->database_name . '.petition_signature')
                ->where('petition_setup_id', $petition_setup_id)
                ->order_by('signed_at', 'DESC')
                ->get()
                ->result();
        } else {
			$data['petitionSignatureData'] = $this->db->select('*')
				->from($customerDBSettingRow->database_name . '.petition_signature')
				->where('petition_setup_id', $petition_setup_id)
				->where('user_id', $session_data['user_id'])
				->order_by('signed_at', 'DESC')
				->get()
				->result();
		}
		$data['customerDBSettingRow'] = $customerDBSettingRow;
		$data['signatureMethodData'] = $this->db->select('*')->from('m_signature_method')->where('active', 1)->get()->result();

        $this->load->view('admin/templates/header_view', $data);
        $this->load->view('admin/petition_signature_view', $data);
        $this->load->view('admin/templates/footer_view', $data);
    }

    public function exportPetitionSignatures($petition_setup_id = null, $format = 'csv')
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        if (empty($petition_setup_id)) {
            show_error('Invalid petition id', 400);
            return;
        }

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        if (!$customerDBSettingRow) {
            show_error('Tenant database not found', 500);
            return;
        }

        $tenantDatabase = $customerDBSettingRow->database_name;

        $petitionRow = $this->db->from($tenantDatabase . '.petition_setup')
            ->where('petition_setup_id', $petition_setup_id)
            ->get()
            ->row();

        $signatures = $this->db->select('*')
            ->from($tenantDatabase . '.petition_signature')
            ->where('petition_setup_id', $petition_setup_id)
            ->order_by('signed_at', 'DESC')
            ->get()
            ->result();

        // Prepare filename and headers
        $now = date('Ymd_His');
        $petitionSlug = preg_replace('/[^A-Za-z0-9\-]/', '_', strtolower($petitionRow->name ?? $petition_setup_id));
        $ext = strtolower($format) === 'excel' ? 'xls' : 'csv';
        $filename = "petition_signatures_{$petitionSlug}_{$now}.{$ext}";

        if (strtolower($format) === 'pdf') {
            // Build HTML table for PDF with fixed column widths and basic styles
            $html = '<style>';
            $html .= 'table { border-collapse: collapse; table-layout: fixed; width:100%; font-family: DejaVu Sans, Helvetica, Arial, sans-serif; font-size:10pt; }';
            $html .= 'th, td { border: 1px solid #777; padding: 6px; vertical-align: top; word-wrap: break-word; }';
            $html .= 'th { background: #f5f5f5; font-weight: bold; }';
            $html .= '.col-member{width:20%}.col-phone{width:12%}.col-units{width:6%}.col-method{width:12%}.col-sign{width:18%}.col-consent{width:6%}.col-signed{width:10%}.col-state{width:8%}.col-status{width:4%}.col-created{width:4%}';
            $html .= '</style>';

            $html .= '<h2 style="margin:0 0 6px 0;">' . htmlentities($petitionRow->name ?? 'Petition Signatures') . '</h2>';
            $html .= '<p style="margin:0 0 12px 0;">Created At: ' . (!empty($petitionRow->created_at) ? htmlentities($petitionRow->created_at) : '') . '</p>';

            $html .= '<table cellpadding="4" cellspacing="0">';
            $html .= '<thead><tr>';
            $html .= '<th class="col-member">Member Name</th>';
            $html .= '<th class="col-phone">Phone Number</th>';
            $html .= '<th class="col-units">Units</th>';
            $html .= '<th class="col-method">Signature Method</th>';
            $html .= '<th class="col-sign">Signature URL</th>';
            $html .= '<th class="col-consent">Consent</th>';
            $html .= '<th class="col-signed">Signed At</th>';
            $html .= '<th class="col-state">State</th>';
            $html .= '<th class="col-status">Status</th>';
            $html .= '<th class="col-created">Created At</th>';
            $html .= '</tr></thead><tbody>';

            foreach ($signatures as $s) {
                $memberName = get_table($tenantDatabase . '.user', 'user_id', $s->user_id, 'full_legal_name') ?: '';
                $phone = get_table($tenantDatabase . '.user', 'user_id', $s->user_id, 'phone_number') ?: '';
                $consent = (isset($s->consent) && (int)$s->consent === 1) ? 'Yes' : 'No';
                $statusName = get_table('m_active', 'num', $s->active ?? 0, 'name') ?: '';

                $html .= '<tr>';
                $html .= '<td class="col-member">' . htmlentities($memberName) . '</td>';
                $html .= '<td class="col-phone">' . htmlentities($phone) . '</td>';
                $html .= '<td class="col-units">' . (int) ($s->no_of_unit ?? 0) . '</td>';
                $html .= '<td class="col-method">' . htmlentities($s->signature_method_id ?? '') . '</td>';
                $html .= '<td class="col-sign">' . htmlentities($s->signature_url ?? '') . '</td>';
                $html .= '<td class="col-consent">' . htmlentities($consent) . '</td>';
                $html .= '<td class="col-signed">' . (!empty($s->signed_at) ? htmlentities($s->signed_at) : '') . '</td>';
                $html .= '<td class="col-state">' . htmlentities($s->state ?? '') . '</td>';
                $html .= '<td class="col-status">' . htmlentities($statusName) . '</td>';
                $html .= '<td class="col-created">' . (!empty($s->created_at) ? htmlentities($s->created_at) : '') . '</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody></table>';

            // Try to use TCPDF if available
            if (!class_exists('TCPDF')) {
                if (file_exists(APPPATH . 'libraries/tcpdf/tcpdf.php')) {
                    require_once(APPPATH . 'libraries/tcpdf/tcpdf.php');
                }
            }

            if (class_exists('TCPDF')) {
                $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('Clubmember');
                $pdf->SetTitle($petitionRow->name ?? 'Petition Signatures');

                // Header callback: show petition title and generated datetime
                $pdf->setHeaderCallback(function($pdf) use ($petitionRow) {
                    $pdf->SetFont('dejavusans', 'B', 12);
                    $title = htmlentities($petitionRow->name ?? 'Petition Signatures');
                    $pdf->Cell(0, 6, $title, 0, 1, 'L', 0, '', 0, false, 'T', 'M');
                    $pdf->SetFont('dejavusans', '', 9);
                    $pdf->Cell(0, 6, 'Generated: ' . date('d M Y'), 0, 1, 'L', 0, '', 0, false, 'T', 'M');
                    $pdf->Ln(2);
                });

                // Footer callback: page numbers
                $pdf->setFooterCallback(function($pdf) {
                    $pdf->SetY(-15);
                    $pdf->SetFont('dejavusans', '', 9);
                    $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . ' / ' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                });

                // Margins and auto page break leave room for header/footer
                $pdf->SetMargins(12, 28, 12);
                $pdf->SetAutoPageBreak(true, 18);
                $pdf->setPrintHeader(true);
                $pdf->setPrintFooter(true);

                $pdf->AddPage();
                $pdf->SetFont('dejavusans', '', 10);
                $pdf->writeHTML($html, true, false, true, false, '');
                $pdf->Output($filename, 'D');
                exit;
            }

            show_error('PDF generation library (TCPDF) not found. Please install TCPDF in application/libraries/tcpdf/', 500);
            return;
        }

        if (strtolower($format) === 'excel') {
            header('Content-Type: application/vnd.ms-excel');
        } else {
            header('Content-Type: text/csv; charset=utf-8');
        }
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $out = fopen('php://output', 'w');

        // Header row
        $columns = [
            'Petition Title', 'Petition Created At', 'Member Name', 'Phone Number', 'Units', 'Signature Method', 'Signature URL', 'Consent', 'Signed At', 'State', 'Status', 'Created At'
        ];
        fputcsv($out, $columns);

        foreach ($signatures as $s) {
            $memberName = get_table($tenantDatabase . '.user', 'user_id', $s->user_id, 'full_legal_name') ?: '';
            $phone = get_table($tenantDatabase . '.user', 'user_id', $s->user_id, 'phone_number') ?: '';
            $consent = (isset($s->consent) && (int)$s->consent === 1) ? 'Yes' : 'No';
            $statusName = get_table('m_active', 'num', $s->active ?? 0, 'name') ?: '';

            $row = [
                $petitionRow->name ?? '',
                !empty($petitionRow->created_at) ? $petitionRow->created_at : '',
                $memberName,
                $phone,
                (int) ($s->no_of_unit ?? 0),
                $s->signature_method_id ?? '',
                $s->signature_url ?? '',
                $consent,
                !empty($s->signed_at) ? $s->signed_at : '',
                $s->state ?? '',
                $statusName,
                !empty($s->created_at) ? $s->created_at : '',
            ];

            fputcsv($out, $row);
        }

        fclose($out);
        exit;
    }

    public function exportHtmlModal($petition_setup_id = null)
    {
        $this->common->checkSession(array('dialog' => 1));
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        if (empty($petition_setup_id)) {
            show_error('Invalid petition id', 400);
            return;
        }

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        if (!$customerDBSettingRow) {
            show_error('Tenant database not found', 500);
            return;
        }

        $tenantDatabase = $customerDBSettingRow->database_name;

        $petitionRow = $this->db->from($tenantDatabase . '.petition_setup')
            ->where('petition_setup_id', $petition_setup_id)
            ->get()
            ->row();

        $signatureRows = $this->db->select('s.*, u.full_legal_name, u.phone_number, u.membership_no')
            ->from($tenantDatabase . '.petition_signature s')
            ->join($tenantDatabase . '.user u', 'u.user_id = s.user_id', 'left')
            ->where('s.petition_setup_id', $petition_setup_id)
            ->order_by('s.signed_at', 'DESC')
            ->get()
            ->result();

        $totalSignatures = is_array($signatureRows) ? count($signatureRows) : 0;
        $uniqueMembers = 0;
        $latestSignedAt = '';

        $members = array();
        $seenUsers = array();
        if (!empty($signatureRows)) {
            foreach ($signatureRows as $row) {
                if (empty($latestSignedAt)) {
                    $latestSignedAt = !empty($row->signed_at) ? $row->signed_at : ($row->created_at ?? '');
                }

                if (!empty($row->user_id) && !isset($seenUsers[$row->user_id])) {
                    $seenUsers[$row->user_id] = true;
                    $members[] = array(
                        'user_id' => $row->user_id,
                        'full_legal_name' => $row->full_legal_name ?? (get_table($tenantDatabase . '.user', 'user_id', $row->user_id, 'full_legal_name') ?: ''),
                        'phone_number' => $row->phone_number ?? (get_table($tenantDatabase . '.user', 'user_id', $row->user_id, 'phone_number') ?: ''),
                        'signature_url' => $row->signature_url ?? '',
                        'signed_at' => !empty($row->signed_at) ? $row->signed_at : ($row->created_at ?? ''),
                    );
                }
            }
        }
        $uniqueMembers = count($members);

        $data = array(
            'petitionRow' => $petitionRow,
            'petition_setup_id' => $petition_setup_id,
            'totalSignatures' => $totalSignatures,
            'uniqueMembers' => $uniqueMembers,
            'latestSignedAt' => $latestSignedAt,
            'members' => $members,
            'customerDBSettingRow' => $customerDBSettingRow,
        );

        return $this->load->view('admin/export_petition_signatures_html_modal', $data);
    }

    public function addPetitionSignatureModal($petition_setup_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
		$data = $session_data;
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customer_db_setting_id)
            ->get()
            ->row();

        $petitionSetupRow = $this->db->from($customerDBSettingRow->database_name . '.petition_setup')
            ->where('petition_setup_id', $petition_setup_id)
            ->get()
            ->row();

        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
        $data['signatureMethodData'] = $this->db->select('*')->from('m_signature_method')->where('active', 1)->get()->result();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
        $data['petitionSetupRow'] = $petitionSetupRow;
        $data['petition_setup_id'] = $petition_setup_id;
        $data['petition_signature_id'] = generate_uuid();
        $data['petition_id'] = generate_uuid();

        return $this->load->view('admin/add_edit_petition_signature_modal', $data);
    }

    public function addPetitionSignature()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

		$postData = $this->input->post();
		$petition_setup_id = $postData['petition_setup_id'];
		$petition_signature_id = $postData['petition_signature_id'] ?? generate_uuid();
		$signatureUrlInput = isset($postData['signature_url']) ? trim($postData['signature_url']) : '';
		$signatureDrawData = isset($postData['signature_draw_data']) ? $postData['signature_draw_data'] : '';
		unset($postData['signature_draw_data']);

    	$postData['petition_signature_id'] = $petition_signature_id;
        $postData['petition_id'] = !empty($postData['petition_id']) ? $postData['petition_id'] : generate_uuid();
        $customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        
		$petitionSignatureRow = $this->db->from($customerDBSettingRow->database_name . '.petition_signature')->where('user_id', $postData['user_id'])->get()->row();
		if ($session_data['user_id'] == $petitionSignatureRow->user_id) {
			
			$resolvedSignatureUrl = $this->resolveSignatureAsset($petitionSignatureRow->petition_signature_id, ['signature_url' => $signatureUrlInput], $signatureDrawData);
			if ($resolvedSignatureUrl !== null) {
				$postData['signature_url'] = $resolvedSignatureUrl;
			}
			$this->db->update($customerDBSettingRow->database_name . '.petition_signature', $postData, ['petition_signature_id' => $petitionSignatureRow->petition_signature_id]);
			$this->session->set_flashdata('success', 'Petition signature updated successfully.');
		} else {
			$resolvedSignatureUrl = $this->resolveSignatureAsset($petition_signature_id, ['signature_url' => $signatureUrlInput], $signatureDrawData);
			if ($resolvedSignatureUrl !== null) {
				$postData['signature_url'] = $resolvedSignatureUrl;
			}
            $this->db->insert($customerDBSettingRow->database_name . '.petition_signature', $postData);
        	$this->session->set_flashdata('success', 'Petition signature saved successfully.');
        }
        redirect('petition-signatures/' . $petition_setup_id, 'refresh');
    }

    public function editPetitionSignatureModal($petition_signature_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
		$data = $session_data;
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        $petitionSignatureRow = $this->db->from($customerDBSettingRow->database_name . '.petition_signature')
            ->where('petition_signature_id', $petition_signature_id)
            ->get()
            ->row();

        $petitionSetupRow = null;
        if ($petitionSignatureRow) {
            $petitionSetupRow = $this->db->from($customerDBSettingRow->database_name . '.petition_setup')
                ->where('petition_setup_id', $petitionSignatureRow->petition_setup_id)
                ->get()
                ->row();
        }

        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
        $data['signatureMethodData'] = $this->db->select('*')->from('m_signature_method')->where('active', 1)->get()->result();
		$data['customerDBSettingRow'] = $customerDBSettingRow;
        $data['petitionSignatureRow'] = $petitionSignatureRow;
        $data['petitionSetupRow'] = $petitionSetupRow;
        $data['petition_signature_id'] = $petition_signature_id;
        $data['petition_setup_id'] = $petitionSignatureRow ? $petitionSignatureRow->petition_setup_id : null;

        return $this->load->view('admin/add_edit_petition_signature_modal', $data);
    }

    public function editPetitionSignature()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

    	$postData = $this->input->post();
		// print_r(json_encode($postData)); exit;
        $petition_signature_id = $postData['petition_signature_id'];
        $petition_setup_id = $postData['petition_setup_id'];
		$signatureUrlInput = isset($postData['signature_url']) ? trim($postData['signature_url']) : '';
		$signatureDrawData = isset($postData['signature_draw_data']) ? $postData['signature_draw_data'] : '';
		unset($postData['signature_draw_data']);
		unset($postData['signature_url']);
        unset($postData['petition_signature_id']);

        $postData['petition_id'] = !empty($postData['petition_id']) ? $postData['petition_id'] : generate_uuid();
        $postData['no_of_unit'] = isset($postData['no_of_unit']) && $postData['no_of_unit'] !== '' ? (int) $postData['no_of_unit'] : 0;
        $postData['consent'] = isset($postData['consent']) && in_array($postData['consent'], ['1', 1, true, 'true'], true) ? 1 : 0;
        $postData['signed_at'] = !empty($postData['signed_at']) ? date('d M Y', strtotime($postData['signed_at'])) : null;
        $postData['active'] = isset($postData['active']) && $postData['active'] !== '' ? (int) $postData['active'] : 1;
        $postData['updated_at'] = date('d M Y');

        
        $customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        $existingSignatureRow = $this->db->from($customerDBSettingRow->database_name . '.petition_signature')
            ->where('petition_signature_id', $petition_signature_id)
            ->get()
            ->row();
        $existingSignatureUrl = $existingSignatureRow ? ($existingSignatureRow->signature_url ?? '') : '';

        $resolvedSignatureUrl = $this->resolveSignatureAsset(
            $petition_signature_id,
            ['signature_url' => $signatureUrlInput],
            $signatureDrawData,
            $existingSignatureUrl
        );
        if ($resolvedSignatureUrl !== null) {
            $postData['signature_url'] = $resolvedSignatureUrl;
        }

        $this->db->update($customerDBSettingRow->database_name . '.petition_signature', $postData, array('petition_signature_id' => $petition_signature_id));
        $this->session->set_flashdata('success', 'Petition signature updated successfully.');
        redirect('petition-signatures/' . $petition_setup_id, 'refresh');
    }

    public function removePetitionSignatureModal($petition_signature_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        $petitionSignatureRow = $this->db->from($customerDBSettingRow->database_name . '.petition_signature')
            ->where('petition_signature_id', $petition_signature_id)
            ->get()
            ->row();

        $data['table'] = $customerDBSettingRow->database_name . '.petition_signature';
        $data['table_id'] = 'petition_signature_id';
        $data['unique_id'] = $petition_signature_id;
        $data['name'] = isset($petitionSignatureRow->full_legal_name) && !empty($petitionSignatureRow->full_legal_name)
            ? $petitionSignatureRow->full_legal_name
            : 'petition signature record';
        $data['route'] = $petitionSignatureRow ? 'petition-signatures/' . $petitionSignatureRow->petition_setup_id : 'petition-setup';

        return $this->load->view('admin/remove_global_modal', $data);
    }

    public function removePetitionSignature()
    {
        redirect('petition-setup', 'refresh');
    }

    private function resolveSignatureAsset($recordId, array $postValues, $drawData = '', $existingUrl = null)
    {
        $existingUrl = $existingUrl ?? '';

        if (isset($_FILES['signature_file']) && is_array($_FILES['signature_file']) && !empty($_FILES['signature_file']['name']) && $_FILES['signature_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedPath = file_upload('signature_file', $recordId, 'assets/img/');
            if (!empty($uploadedPath)) {
                return $uploadedPath;
            }
        }

        if (is_string($drawData) && strpos($drawData, 'data:image') === 0) {
            $storedPath = $this->storeDrawnSignature($drawData, $recordId);
            if ($storedPath !== null) {
                return $storedPath;
            }
        }

        $manualUrl = isset($postValues['signature_url']) ? trim($postValues['signature_url']) : '';
        if ($manualUrl !== '') {
            return $manualUrl;
        }

        return $existingUrl !== '' ? $existingUrl : null;
    }

    private function storeDrawnSignature($dataUri, $baseName)
    {
        if (empty($dataUri) || strpos($dataUri, 'data:image') !== 0 || strpos($dataUri, ',') === false) {
            return null;
        }

        list($meta, $content) = explode(',', $dataUri, 2);
        if ($content === null) {
            return null;
        }

        $content = str_replace(' ', '+', $content);
        $binary = base64_decode($content, true);
        if ($binary === false) {
            return null;
        }

        $extension = 'png';
        if (preg_match('/^data:image\/(png|jpg|jpeg)$/i', $meta, $matches)) {
            $extension = strtolower($matches[1]);
            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }
        }

        $relativePath = 'assets/img/';
        $absoluteBase = defined('FCPATH') ? rtrim(FCPATH, '/\\') : rtrim(str_replace('\\', '/', getcwd()), '/');
        $uploadDir = $absoluteBase . '/' . $relativePath;

        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0777, true);
        }

        $safeBaseName = preg_replace('/[^A-Za-z0-9._-]/', '_', $baseName ?: uniqid('signature_', true));
        $filePath = $uploadDir . $safeBaseName . '.' . $extension;

        if (file_put_contents($filePath, $binary) === false) {
            return null;
        }

        return $relativePath . $safeBaseName . '.' . $extension;
    }
}
