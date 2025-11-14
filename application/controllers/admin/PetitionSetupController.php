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

        $data['petitionSetupData'] = $this->db->select('*')
            ->from($customerDBSettingRow->database_name . '.petition_setup')
            ->order_by('created_at', 'DESC')
            ->get()
            ->result();
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
            $postData['closing_at'] = date('Y-m-d H:i:s', strtotime($postData['closing_at']));
        }
        $postData['created_at'] = date('Y-m-d H:i:s');

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
            $postData['closing_at'] = date('Y-m-d H:i:s', strtotime($postData['closing_at']));
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
        $postData['signed_at'] = !empty($postData['signed_at']) ? date('Y-m-d H:i:s', strtotime($postData['signed_at'])) : null;
        $postData['active'] = isset($postData['active']) && $postData['active'] !== '' ? (int) $postData['active'] : 1;
        $postData['updated_at'] = date('Y-m-d H:i:s');

        
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
