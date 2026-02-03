<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AuditLogModel extends CI_Model
{
	private const TABLE = 'audit_log';

	public function insert(array $data): bool
	{
		if (empty($data['audit_log_id'])) {
			$data['audit_log_id'] = function_exists('generate_uuid') ? generate_uuid() : uniqid('AUD-', true);
		}

		return (bool) $this->db->insert(self::TABLE, $data);
	}

	public function findById(string $auditLogId)
	{
		return $this->db->select('*')
			->from(self::TABLE)
			->where('audit_log_id', $auditLogId)
			->get()
			->row();
	}

	public function search(array $filters, int $limit = 100, int $offset = 0): array
	{
		$query = $this->applyFilters($this->db->select('*')->from(self::TABLE), $filters)
			->order_by('occurred_at', 'DESC')
			->limit($limit, $offset)
			->get();

		return $query->result();
	}

	public function count(array $filters): int
	{
		$query = $this->applyFilters($this->db->select('COUNT(*) AS cnt')->from(self::TABLE), $filters)->get();
		$row = $query->row();
		return (int) ($row->cnt ?? 0);
	}

	public function statsByDay(array $filters, int $days = 30): array
	{
		$days = max(1, min($days, 365));
		$from = (new DateTime('now'))->modify('-'.($days - 1).' days')->format('Y-m-d 00:00:00');

		$builder = $this->db->select('DATE(occurred_at) AS day, COUNT(*) AS cnt')
			->from(self::TABLE)
			->where('occurred_at >=', $from)
			->group_by('DATE(occurred_at)')
			->order_by('day', 'ASC');

		$builder = $this->applyFilters($builder, $filters, ['date_from', 'date_to']);
		$rows = $builder->get()->result();

		$out = [];
		foreach ($rows as $r) {
			$out[$r->day] = (int) $r->cnt;
		}
		return $out;
	}

	private function applyFilters($builder, array $filters, array $skipKeys = [])
	{
		$skip = array_fill_keys($skipKeys, true);

		if (empty($skip['customer_db_setting_id']) && !empty($filters['customer_db_setting_id'])) {
			$builder->where('customer_db_setting_id', $filters['customer_db_setting_id']);
		}
		if (empty($skip['actor_user_id']) && !empty($filters['actor_user_id'])) {
			$builder->where('actor_user_id', $filters['actor_user_id']);
		}
		if (empty($skip['module']) && !empty($filters['module'])) {
			$builder->where('module', $filters['module']);
		}
		if (empty($skip['action']) && !empty($filters['action'])) {
			$builder->where('action', $filters['action']);
		}
		if (empty($skip['entity_type']) && !empty($filters['entity_type'])) {
			$builder->where('entity_type', $filters['entity_type']);
		}
		if (empty($skip['entity_id']) && !empty($filters['entity_id'])) {
			$builder->where('entity_id', $filters['entity_id']);
		}
		if (empty($skip['status']) && !empty($filters['status'])) {
			$builder->where('status', $filters['status']);
		}
		if (empty($skip['correlation_id']) && !empty($filters['correlation_id'])) {
			$builder->where('correlation_id', $filters['correlation_id']);
		}
		if (empty($skip['request_id']) && !empty($filters['request_id'])) {
			$builder->where('request_id', $filters['request_id']);
		}
		if (empty($skip['date_from']) && !empty($filters['date_from'])) {
			$builder->where('occurred_at >=', $filters['date_from'].' 00:00:00');
		}
		if (empty($skip['date_to']) && !empty($filters['date_to'])) {
			$builder->where('occurred_at <=', $filters['date_to'].' 23:59:59');
		}
		if (empty($skip['q']) && !empty($filters['q'])) {
			$q = $filters['q'];
			$builder->group_start()
				->like('message', $q)
				->or_like('module', $q)
				->or_like('action', $q)
				->or_like('entity_type', $q)
				->or_like('entity_id', $q)
				->or_like('actor_email', $q)
				->group_end();
		}

		return $builder;
	}
}
