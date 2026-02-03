<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AuditLogController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('AuditLogModel');
	}

	public function auditLogView()
	{
		$this->common->checkSession();
		$session = $this->common->loadSession();

		// Reuse System Logs permissioning for now.
		$headerData = $this->common->loadHeaderData('audit-log');
		if (empty($headerData['viewUserRight'])) {
			show_error('Forbidden', 403);
			return;
		}

		$filters = [
			// 'customer_db_setting_id' => $session['customer_db_setting_id'] ?? null,
			'actor_user_id' => $this->input->get('actor_user_id', true) ?: null,
			'module' => $this->input->get('module', true) ?: null,
			'action' => $this->input->get('action', true) ?: null,
			'entity_type' => $this->input->get('entity_type', true) ?: null,
			'entity_id' => $this->input->get('entity_id', true) ?: null,
			'status' => $this->input->get('status', true) ?: null,
			'correlation_id' => $this->input->get('correlation_id', true) ?: null,
			'request_id' => $this->input->get('request_id', true) ?: null,
			'date_from' => $this->input->get('date_from', true) ?: null,
			'date_to' => $this->input->get('date_to', true) ?: null,
			'q' => $this->input->get('q', true) ?: null,
		];

		$page = (int) ($this->input->get('page') ?: 1);
		$page = max(1, $page);
		$limit = 100;
		$offset = ($page - 1) * $limit;

		$data = $headerData;
		$data['filters'] = $filters;
		$data['auditLogData'] = $this->AuditLogModel->search($filters, $limit, $offset);
		$data['total'] = $this->AuditLogModel->count($filters);
		$data['page'] = $page;
		$data['limit'] = $limit;
		$data['statsByDay'] = $this->AuditLogModel->statsByDay($filters, 14);

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/audit_log_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
	}

	public function details($audit_log_id)
	{
		$this->common->checkSession();
		$headerData = $this->common->loadHeaderData('audit-log');
		if (empty($headerData['viewUserRight'])) {
			show_error('Forbidden', 403);
			return;
		}

		$row = $this->AuditLogModel->findById($audit_log_id);
		if (!$row) {
			show_404();
			return;
		}

		$data = $headerData;
		$data['auditRow'] = $row;

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/audit_log_details_view', $data);
		$this->load->view('admin/templates/footer_view', $data);
	}

	public function exportCsv()
	{
		$this->common->checkSession();
		$session = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('audit-log');
		if (empty($headerData['viewUserRight'])) {
			show_error('Forbidden', 403);
			return;
		}

		$filters = [
			'customer_db_setting_id' => $session['customer_db_setting_id'] ?? null,
			'actor_user_id' => $this->input->get('actor_user_id', true) ?: null,
			'module' => $this->input->get('module', true) ?: null,
			'action' => $this->input->get('action', true) ?: null,
			'entity_type' => $this->input->get('entity_type', true) ?: null,
			'entity_id' => $this->input->get('entity_id', true) ?: null,
			'status' => $this->input->get('status', true) ?: null,
			'correlation_id' => $this->input->get('correlation_id', true) ?: null,
			'request_id' => $this->input->get('request_id', true) ?: null,
			'date_from' => $this->input->get('date_from', true) ?: null,
			'date_to' => $this->input->get('date_to', true) ?: null,
			'q' => $this->input->get('q', true) ?: null,
		];

		$rows = $this->AuditLogModel->search($filters, 5000, 0);

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=audit_log_export.csv');

		$out = fopen('php://output', 'w');
		fputcsv($out, [
			'occurred_at','category','actor_user_id','actor_email','module','action','entity_type','entity_id','status','message','request_id','correlation_id','ip_address'
		]);
		foreach ($rows as $r) {
			fputcsv($out, [
				$r->occurred_at,
				$r->category,
				$r->actor_user_id,
				$r->actor_email,
				$r->module,
				$r->action,
				$r->entity_type,
				$r->entity_id,
				$r->status,
				$r->message,
				$r->request_id,
				$r->correlation_id,
				$r->ip_address,
			]);
		}
		fclose($out);
	}

	public function exportJson()
	{
		$this->common->checkSession();
		$session = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('audit-log');
		if (empty($headerData['viewUserRight'])) {
			show_error('Forbidden', 403);
			return;
		}

		$filters = [
			'customer_db_setting_id' => $session['customer_db_setting_id'] ?? null,
			'actor_user_id' => $this->input->get('actor_user_id', true) ?: null,
			'module' => $this->input->get('module', true) ?: null,
			'action' => $this->input->get('action', true) ?: null,
			'entity_type' => $this->input->get('entity_type', true) ?: null,
			'entity_id' => $this->input->get('entity_id', true) ?: null,
			'status' => $this->input->get('status', true) ?: null,
			'correlation_id' => $this->input->get('correlation_id', true) ?: null,
			'request_id' => $this->input->get('request_id', true) ?: null,
			'date_from' => $this->input->get('date_from', true) ?: null,
			'date_to' => $this->input->get('date_to', true) ?: null,
			'q' => $this->input->get('q', true) ?: null,
		];

		$rows = $this->AuditLogModel->search($filters, 5000, 0);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rows);
	}
}
