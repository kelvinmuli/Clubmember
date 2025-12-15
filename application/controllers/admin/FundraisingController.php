<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class FundraisingController
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Common $common
 */
class FundraisingController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function fundraisingView($filter = null)
    {
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $data = $this->common->loadHeaderData('fundraising');
        $customerDbSettingId = $sessionData['customer_db_setting_id'];

        $customerDbSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();

        $fundraisingData = [];
        $contributionIndex = [];
        $summary = [
            'total_campaigns' => 0,
            'total_goal' => 0.0,
            'total_received' => 0.0,
            'total_contributors' => 0,
            'average_completion' => 0.0,
            'top_campaign' => null,
        ];

		$fundraisingTable = $customerDbSettingRow->database_name . '.fundraising';
		$paymentHistoryTable = $customerDbSettingRow->database_name . '.payment_history';

		$fundraisingData = $this->db->select('*')
				->from($fundraisingTable)
				->order_by('created_at', 'DESC')
				->get()
				->result();

		$fundraisingIds = [];
		foreach ($fundraisingData as $row) {
			if (!empty($row->fundraising_id)) {
				$fundraisingIds[] = $row->fundraising_id;
			}
		}

        $contributionRows = [];
        if (!empty($fundraisingIds)) {
            $contributionRows = $this->db->select(
                    'universal_id, COUNT(*) AS contribution_count, ' .
                    'SUM(CASE WHEN (paid_amount IS NOT NULL AND paid_amount != \'\') THEN paid_amount ELSE COALESCE(bill_amount, 0) END) AS total_paid, ' .
                    'MAX(CASE WHEN (paid_amount IS NOT NULL AND paid_amount != \'\') THEN paid_amount ELSE COALESCE(bill_amount, 0) END) AS max_paid_amount',
                    false
                )
                ->from($paymentHistoryTable)
                ->where_in('universal_id', $fundraisingIds)
                // ->where('payment_status_id', '1732371146921')
                ->group_by('universal_id')
                ->get()
                ->result();
        }

		foreach ($contributionRows as $row) {
			$contributionIndex[$row->universal_id] = [
				'contribution_count' => (int) $row->contribution_count,
				'total_paid' => (float) $row->total_paid,
				'max_paid_amount' => (float) $row->max_paid_amount,
			];
		}

        $completionAccumulator = 0.0;
        $topCampaign = null;
        $topCampaignRatio = -1.0;

        foreach ($fundraisingData as $campaign) {
            $summary['total_campaigns'] += 1;

            $fundraisingId = $campaign->fundraising_id ?? '';
            $goalAmount = $this->toFloat($campaign->total_amount ?? 0);
            $recordedReceived = $this->toFloat($campaign->total_received ?? 0);

            $contributionStats = ($fundraisingId && isset($contributionIndex[$fundraisingId]))
                ? $contributionIndex[$fundraisingId]
                : ['contribution_count' => 0, 'total_paid' => 0.0, 'max_paid_amount' => 0.0];

            $computedReceived = $contributionStats['total_paid'] > 0 ? $contributionStats['total_paid'] : $recordedReceived;
            $contributors = (int) ($campaign->number_of_contributor ?? 0);
            if ($contributors <= 0) {
                $contributors = $contributionStats['contribution_count'];
            }

            $summary['total_goal'] += $goalAmount;
            $summary['total_received'] += $computedReceived;
            $summary['total_contributors'] += $contributors;

            if ($goalAmount > 0) {
                $completion = min(100.0, ($computedReceived / max($goalAmount, 1)) * 100.0);
                $completionAccumulator += $completion;

                if ($completion > $topCampaignRatio) {
                    $topCampaignRatio = $completion;
                    $topCampaign = $campaign->name ?? null;
                }
            }
        }

        if ($summary['total_campaigns'] > 0) {
            $summary['average_completion'] = round($completionAccumulator / $summary['total_campaigns'], 2);
        }
        $summary['total_goal'] = round($summary['total_goal'], 2);
        $summary['total_received'] = round($summary['total_received'], 2);
        $summary['top_campaign'] = $topCampaign;

        $data['fundraisingData'] = $fundraisingData;
        $data['contributionIndex'] = $contributionIndex;
        $data['fundraisingSummary'] = $summary;

        $this->load->view('admin/templates/header_view', $data);
        $this->load->view('admin/fundraising_view', $data);
        $this->load->view('admin/templates/footer_view', $data);
    }

    public function addEditFundraisingModal($fundraisingId='')
    {
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $customerDbSettingId = $sessionData['customer_db_setting_id'] ?? null;

        $customerDbSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();

		$fundraisingTable = $customerDbSettingRow->database_name . '.fundraising';
		$fundraisingRow = $this->db->from($fundraisingTable)
				->where('fundraising_id', $fundraisingId)
				->get()
				->row();

        $data = [
            'fundraising_id' => $fundraisingRow->fundraising_id ?? ($fundraisingId ?: generate_uuid()),
            'fundraisingRow' => $fundraisingRow,
        ];

        return $this->load->view('admin/add_edit_fundraising_modal', $data);
    }

    public function addFundraising()
    {
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $customerDbSettingId = $sessionData['customer_db_setting_id'] ?? null;

        $postData = $this->input->post(null, true);
        $fundraisingId = $postData['fundraising_id'] ?? generate_uuid();

        $customerDbSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();

        if (!$customerDbSettingRow) {
            $this->session->set_flashdata('err', 'Unable to locate customer fundraising records.');
            redirect('fundraising', 'refresh');
        }

        $fundraisingTable = $customerDbSettingRow->database_name . '.fundraising';
        // if (!$this->db->table_exists($fundraisingTable)) {
        //     $this->session->set_flashdata('err', 'Fundraising table is not configured for this tenant.');
        //     redirect('fundraising', 'refresh');
        // }

        $payload = [
            'fundraising_id' => $fundraisingId,
            'name' => $this->sanitizeText($postData['name'] ?? ''),
            'reason' => $this->sanitizeText($postData['reason'] ?? '', false),
            'description' => $this->sanitizeText($postData['description'] ?? '', false),
            'total_amount' => $this->sanitizeCurrency($postData['total_amount'] ?? null),
            'start_date' => $this->sanitizeDate($postData['start_date'] ?? null),
            'end_date' => $this->sanitizeDate($postData['end_date'] ?? null),
            'total_received' => $this->sanitizeCurrency($postData['total_received'] ?? null),
            'number_of_contributor' => $this->sanitizeInteger($postData['number_of_contributor'] ?? null),
            'top_contributor' => $this->sanitizeText($postData['top_contributor'] ?? '')
        ];

        $existingRow = $this->db->from($fundraisingTable)
            ->where('fundraising_id', $fundraisingId)
            ->get()
            ->row();

        if ($existingRow) {
            unset($payload['fundraising_id']);
            $this->db->update($fundraisingTable, $payload, ['fundraising_id' => $fundraisingId]);
            $this->session->set_flashdata('success', 'Fundraising campaign updated successfully.');
        } else {
            $payload['fundraising_id'] = $fundraisingId;
            $this->db->insert($fundraisingTable, $payload);
            $this->session->set_flashdata('success', 'Fundraising campaign created successfully.');
        }

        redirect('fundraising', 'refresh');
    }

    public function deleteFundraisingModal($fundraisingId = null)
    {
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $customerDbSettingId = $sessionData['customer_db_setting_id'] ?? null;

        $customerDbSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();

        $fundraisingRow = null;
        if ($customerDbSettingRow && !empty($fundraisingId)) {
            $fundraisingTable = $customerDbSettingRow->database_name . '.fundraising';
            if ($this->db->table_exists($fundraisingTable)) {
                $fundraisingRow = $this->db->from($fundraisingTable)
                    ->where('fundraising_id', $fundraisingId)
                    ->get()
                    ->row();
            }
        }

        $data = [
            'fundraising_id' => $fundraisingId,
            'fundraisingRow' => $fundraisingRow,
        ];

        return $this->load->view('admin/delete_fundraising_modal', $data);
    }

    public function deleteFundraising()
    {
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $customerDbSettingId = $sessionData['customer_db_setting_id'] ?? null;

		$postData = $this->input->post();
		$fundraisingId = $postData['fundraising_id'];
        $customerDbSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();

        $this->db->delete($customerDbSettingRow->database_name . '.fundraising', ['fundraising_id' => $fundraisingId]);
		$this->db->delete($customerDbSettingRow->database_name . '.payment_history', ['universal_id' => $fundraisingId]);
        $this->session->set_flashdata('success', 'Fundraising campaign deleted successfully.');

        redirect('fundraising', 'refresh');
    }

    private function sanitizeText($value, $stripTags = true)
    {
        if ($value === null) {
            return '';
        }

        $value = trim($value);
        return $stripTags ? strip_tags($value) : $value;
    }

    private function sanitizeCurrency($value)
    {
        if ($value === null || $value === '') {
            return 0.0;
        }

        $filtered = preg_replace('/[^0-9.\-]/', '', (string) $value);
        return is_numeric($filtered) ? (float) $filtered : 0.0;
    }

    private function sanitizeInteger($value)
    {
        if ($value === null || $value === '') {
            return 0;
        }

        return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    private function sanitizeDate($value)
    {
        if (empty($value)) {
            return null;
        }

        $timestamp = strtotime($value);
        return $timestamp ? date('d M Y', $timestamp) : null;
    }

    private function toFloat($value)
    {
        if ($value === null) {
            return 0.0;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        $filtered = preg_replace('/[^0-9.\-]/', '', (string) $value);
        return is_numeric($filtered) ? (float) $filtered : 0.0;
    }
}
