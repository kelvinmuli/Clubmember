<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SecurityIncidentController extends CI_Controller 
{

    public function __construct() {
        parent::__construct();
    }

    public function securityIncidentView($filter = null) 
	{
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $data = $this->common->loadHeaderData('security-incident');
        $customerDbSettingId = $sessionData['customer_db_setting_id'];

        $customerDbSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();

        $incidentData = $this->db->select('*')->from($customerDbSettingRow->database_name . '.security_incident')->order_by('incident_at', 'DESC')->order_by('created_at', 'DESC')->get()->result();
        $incidentTypeData = $this->db->from('m_incident_type')->where('active', 1)->get()->result();
        $activeData = $this->db->select('*')
            ->from('m_active')
            ->where('active', 1)
            ->order_by('name', 'ASC')
            ->get()
            ->result();

        $incidentTypeIndex = $this->buildIncidentTypeIndex($incidentTypeData);
        $activeIndex = $this->buildActiveIndex($activeData);

        $data['customer_db_setting_id'] = $customerDbSettingId;
        $data['incidentData'] = $incidentData;
        $data['incidentTypeIndex'] = $incidentTypeIndex;
        $data['activeIndex'] = $activeIndex;
        $data['chartData'] = $this->buildChartData($incidentData, $incidentTypeIndex, $activeIndex);
        $data['summary'] = $this->buildSummary($incidentData);

        $this->load->view('admin/templates/header_view', $data);
        $this->load->view('admin/security_incident_view', $data);
        $this->load->view('admin/templates/footer_view', $data);
    }

    public function addSecurityIncidentModal() 
	{
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $customerDbSettingId = $sessionData['customer_db_setting_id'];

        $customerDbSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();

        $data['security_incident_id'] = generate_uuid();
        $data['incidentTypeData'] = $this->db->from('m_incident_type')->where('active', 1)->get()->result();
        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->order_by('name', 'ASC')->get()->result();

        return $this->load->view('admin/add_edit_security_incident_modal', $data);
    }

    public function addSecurityIncident() 
	{
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $customerDbSettingId = $sessionData['customer_db_setting_id'];

        $postData = $this->input->post();
        $securityIncidentId = $postData['security_incident_id'] ?? generate_uuid();
        $postData['security_incident_id'] = $securityIncidentId;
        $postData['incident_at'] = $this->sanitizeDateTime($postData['incident_at'] ?? null);
        $postData['location'] = $this->sanitizeText($postData['location'] ?? '');
        $postData['reported_by'] = $this->sanitizeText($postData['reported_by'] ?? '');
        $postData['incident_type_id'] = !empty($postData['incident_type_id']) ? $postData['incident_type_id'] : null;
        $postData['description'] = $this->sanitizeText($postData['description'] ?? '', false);

		// print_r(json_encode($postData)); exit;
        $customerDbSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();

        if ($this->db->insert($customerDbSettingRow->database_name.'.security_incident', $postData)) {
            $this->session->set_flashdata('success', 'Security incident saved successfully.');
        } else {
            $this->session->set_flashdata('warning', 'Security incident save failed.');
        }

        redirect('security-incident', 'refresh');
    }

    public function viewSecurityIncidentModal($security_incident_id = null)
    {
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $customerDbSettingId = $sessionData['customer_db_setting_id'];

        $data = [
            'incidentRow' => null,
            'security_incident_id' => $security_incident_id,
            'incidentTypeName' => 'Unclassified',
            'statusName' => 'Unknown',
            'statusClass' => 'bg-yellow-lt',
        ];

        $customerDbSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();
		$incidentRow = $this->db->from($customerDbSettingRow->database_name.'.security_incident')
                    ->where('security_incident_id', $security_incident_id)
                    ->get()
                    ->row();
		$incidentTypeRow = $this->db->from('m_incident_type')
					->where('incident_type_id', $incidentRow->incident_type_id ?? '')
					->get()
					->row();
		$activeValue = isset($incidentRow->active) ? (int) $incidentRow->active : -1;
		$data['incidentRow'] = $incidentRow;
		$data['incidentTypeRow'] = $incidentTypeRow;
		$data['statusClass'] = ($activeValue === 1) ? 'bg-green-lt' : (($activeValue === 0) ? 'bg-red-lt' : 'bg-yellow-lt');

        return $this->load->view('admin/view_security_incident_modal', $data);
    }

    public function editSecurityIncidentModal($security_incident_id = null) 
	{
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $customerDbSettingId = $sessionData['customer_db_setting_id'];

        $customerDbSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customerDbSettingId)->get()->row();
        $data['security_incident_id'] = $security_incident_id;
		$data['incidentRow'] = $this->db->select('*')->from($customerDbSettingRow->database_name.'.security_incident')->where('security_incident_id', $security_incident_id)->get()->row();
        $data['incidentTypeData'] = $this->db->select('*')->from('m_incident_type')->where('active', 1)->get()->result();
        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->order_by('name', 'ASC')->get()->result();

        return $this->load->view('admin/add_edit_security_incident_modal', $data);
    }

    public function editSecurityIncident() 
	{
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $customerDbSettingId = $sessionData['customer_db_setting_id'];

        $postData = $this->input->post(null, true);
        $securityIncidentId = $postData['security_incident_id'] ?? '';
        if (empty($securityIncidentId)) {
            $this->session->set_flashdata('warning', 'Security incident update failed.');
            redirect('security-incident', 'refresh');
        }

        $postData['incident_at'] = $this->sanitizeDateTime($postData['incident_at'] ?? null);
        $postData['location'] = $this->sanitizeText($postData['location'] ?? '');
        $postData['reported_by'] = $this->sanitizeText($postData['reported_by'] ?? '');
        $postData['incident_type_id'] = !empty($postData['incident_type_id']) ? $postData['incident_type_id'] : null;
        $postData['description'] = $this->sanitizeText($postData['description'] ?? '', false);
        $postData['active'] = isset($postData['active']) && $postData['active'] !== '' ? (int) $postData['active'] : 1;
        $postData['updated_at'] = date('Y-m-d H:i:s');

        unset($postData['security_incident_id']);

        $customerDbSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();

        $incidentTable = $customerDbSettingRow ? $customerDbSettingRow->database_name . '.security_incident' : null;

        if ($incidentTable && $this->db->table_exists($incidentTable)) {
            $this->db->update(
                $incidentTable,
                $postData,
                array('security_incident_id' => $securityIncidentId)
            );
            $this->session->set_flashdata('success', 'Security incident updated successfully.');
        } else {
            $this->session->set_flashdata('warning', 'Security incident update failed.');
        }

        redirect('security-incident', 'refresh');
    }

    public function removeSecurityIncidentModal($security_incident_id = null)
	{
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $customerDbSettingId = $sessionData['customer_db_setting_id'];

        $customerDbSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();

        $incidentRow = null;
        $incidentTable = $customerDbSettingRow ? $customerDbSettingRow->database_name . '.security_incident' : null;

        if ($incidentTable && $this->db->table_exists($incidentTable) && $security_incident_id) {
            $incidentRow = $this->db->from($incidentTable)
                ->where('security_incident_id', $security_incident_id)
                ->get()
                ->row();
        }

        $data['security_incident_id'] = $security_incident_id;
        $data['incidentRow'] = $incidentRow;

        return $this->load->view('admin/remove_security_incident_modal', $data);
    }

    public function removeSecurityIncident() {
        $this->common->checkSession();
        $sessionData = $this->common->loadSession();
        $customerDbSettingId = $sessionData['customer_db_setting_id'];

        $securityIncidentId = $this->input->post('security_incident_id', true);
        if (empty($securityIncidentId)) {
            $this->session->set_flashdata('warning', 'Security incident removal failed.');
            redirect('security-incident', 'refresh');
        }

        $customerDbSettingRow = $this->db->select('*')
            ->from('customer_db_setting')
            ->where('customer_db_setting_id', $customerDbSettingId)
            ->get()
            ->row();

        $incidentTable = $customerDbSettingRow ? $customerDbSettingRow->database_name . '.security_incident' : null;

        if ($incidentTable && $this->db->table_exists($incidentTable)) {
            $this->db->where('security_incident_id', $securityIncidentId);
            $this->db->delete($incidentTable);
            $this->session->set_flashdata('success', 'Security incident removed successfully.');
        } else {
            $this->session->set_flashdata('warning', 'Security incident removal failed.');
        }

        redirect('security-incident', 'refresh');
    }

    private function sanitizeDateTime($value) {
        if (empty($value)) {
            return null;
        }

        $timestamp = strtotime($value);
        return $timestamp ? date('Y-m-d H:i:s', $timestamp) : null;
    }

    private function sanitizeText($value, $stripTags = true) {
        if ($value === null) {
            return '';
        }

        $value = trim($value);
        return $stripTags ? strip_tags($value) : $value;
    }

    private function buildIncidentTypeIndex(array $incidentTypeData) {
        $index = [];
        foreach ($incidentTypeData as $row) {
            $id = null;
            foreach (array('incident_type_id') as $key) {
                if (isset($row->$key) && $row->$key !== '') {
                    $id = (string) $row->$key;
                    break;
                }
            }

            if ($id === null) {
                continue;
            }

            $label = null;
            foreach (array('name') as $key) {
                if (isset($row->$key) && $row->$key !== '') {
                    $label = $row->$key;
                    break;
                }
            }

            if ($label === null) {
                $label = 'Type ' . $id;
            }

            $index[$id] = $label;
        }

        return $index;
    }

    private function buildActiveIndex(array $activeData) {
        $index = [];
        foreach ($activeData as $row) {
            $id = null;
            foreach (array('num', 'active', 'active_id', 'id') as $key) {
                if (isset($row->$key) && $row->$key !== '') {
                    $id = (string) $row->$key;
                    break;
                }
            }

            if ($id === null) {
                continue;
            }

            $label = null;
            foreach (array('name', 'name_two', 'label', 'title') as $key) {
                if (isset($row->$key) && $row->$key !== '') {
                    $label = $row->$key;
                    break;
                }
            }

            if ($label === null) {
                $label = 'Status ' . $id;
            }

            $index[$id] = $label;
        }

        return $index;
    }

    private function buildChartData(array $incidentData, array $incidentTypeIndex, array $activeIndex) {
        $typeCounts = [];
        $timelineCounts = [];
        $statusCounts = [];

        foreach ($incidentData as $incident) {
            $typeId = isset($incident->incident_type_id) && $incident->incident_type_id !== ''
                ? (string) $incident->incident_type_id
                : 'unknown';
            $typeCounts[$typeId] = ($typeCounts[$typeId] ?? 0) + 1;

            $statusKey = isset($incident->active) && $incident->active !== ''
                ? (string) $incident->active
                : 'unknown';
            $statusCounts[$statusKey] = ($statusCounts[$statusKey] ?? 0) + 1;

            $dateValue = $incident->incident_at ?? $incident->created_at ?? null;
            if (!empty($dateValue)) {
                $timestamp = strtotime($dateValue);
                if ($timestamp !== false) {
                    $ymKey = date('Y-m', $timestamp);
                    $timelineCounts[$ymKey] = ($timelineCounts[$ymKey] ?? 0) + 1;
                }
            }
        }

        // Incident type chart data
        $typeLabels = [];
        $typeSeries = [];
        if (!empty($typeCounts)) {
            foreach ($typeCounts as $typeId => $count) {
                $label = $incidentTypeIndex[$typeId] ?? ($typeId === 'unknown' ? 'Unclassified' : 'Type ' . $typeId);
                $typeLabels[] = $label;
                $typeSeries[] = $count;
            }
        } else {
            $typeLabels = array('No Data');
            $typeSeries = array(0);
        }

        // Timeline chart data
        ksort($timelineCounts);
        $timelineCategories = [];
        $timelineSeriesData = [];
        if (!empty($timelineCounts)) {
            foreach ($timelineCounts as $ym => $count) {
                $timestamp = strtotime($ym . '-01');
                $timelineCategories[] = $timestamp ? date('M Y', $timestamp) : $ym;
                $timelineSeriesData[] = $count;
            }
        }

        if (empty($timelineSeriesData)) {
            $timelineCategories = array('No Data');
            $timelineSeriesData = array(0);
        }

        // Status chart data
        $statusLabels = [];
        $statusSeries = [];
        if (!empty($statusCounts)) {
            foreach ($statusCounts as $statusKey => $count) {
                $label = $activeIndex[$statusKey] ?? ($statusKey === 'unknown' ? 'Unknown' : 'Status ' . $statusKey);
                $statusLabels[] = $label;
                $statusSeries[] = $count;
            }
        } else {
            $statusLabels = array('No Data');
            $statusSeries = array(0);
        }

        return array(
            'type' => array(
                'labels' => $typeLabels,
                'series' => $typeSeries,
            ),
            'timeline' => array(
                'categories' => $timelineCategories,
                'series' => array(
                    array(
                        'name' => 'Incidents',
                        'data' => $timelineSeriesData,
                    ),
                ),
            ),
            'status' => array(
                'labels' => $statusLabels,
                'series' => $statusSeries,
            ),
        );
    }

    private function buildSummary(array $incidentData) {
        $total = count($incidentData);
        $activeCount = 0;
        $inactiveCount = 0;
        $recentTimestamp = null;
        $locations = [];
        $reporters = [];

        foreach ($incidentData as $incident) {
            if (isset($incident->active)) {
                if ((int) $incident->active === 1) {
                    $activeCount++;
                } else {
                    $inactiveCount++;
                }
            }

            if (!empty($incident->incident_at)) {
                $timestamp = strtotime($incident->incident_at);
                if ($timestamp !== false && ($recentTimestamp === null || $timestamp > $recentTimestamp)) {
                    $recentTimestamp = $timestamp;
                }
            }

            if (!empty($incident->location)) {
                $locations[strtolower(trim($incident->location))] = true;
            }

            if (!empty($incident->reported_by)) {
                $reporters[strtolower(trim($incident->reported_by))] = true;
            }
        }

        return array(
            'total' => $total,
            'active' => $activeCount,
            'inactive' => $inactiveCount,
            'recent' => $recentTimestamp ? date('d M Y H:i', $recentTimestamp) : null,
            'location_count' => count($locations),
            'reporter_count' => count($reporters),
        );
    }
}
