<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AuditLogger
{
	private $ci;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->model('AuditLogModel');
	}

	public function logUserAction(string $module, string $action, string $entityType = '', string $entityId = '', $before = null, $after = null, array $metadata = [], string $status = 'success', string $message = ''): void
	{
		$this->write('user', $module, $action, $entityType, $entityId, $before, $after, $metadata, $status, $message);
	}

	public function logAdminAction(string $module, string $action, string $entityType = '', string $entityId = '', $before = null, $after = null, array $metadata = [], string $status = 'success', string $message = ''): void
	{
		$this->write('admin', $module, $action, $entityType, $entityId, $before, $after, $metadata, $status, $message);
	}

	public function logSystemEvent(string $module, string $action, string $entityType = '', string $entityId = '', array $metadata = [], string $status = 'success', string $message = ''): void
	{
		$this->write('system', $module, $action, $entityType, $entityId, null, null, $metadata, $status, $message);
	}

	public function logSystemEventWithState(string $module, string $action, string $entityType = '', string $entityId = '', $before = null, $after = null, array $metadata = [], string $status = 'success', string $message = ''): void
	{
		$this->write('system', $module, $action, $entityType, $entityId, $before, $after, $metadata, $status, $message);
	}

	public function logSecurityEvent(string $module, string $action, array $metadata = [], string $status = 'fail', string $message = ''): void
	{
		$this->write('security', $module, $action, 'security_event', '', null, null, $metadata, $status, $message);
	}

	private function write(string $category, string $module, string $action, string $entityType, string $entityId, $before, $after, array $metadata, string $status, string $message): void
	{
		try {
			$session = $this->ci->session->userdata(GlobalModel::SESSION);

			$customerDbSettingId = $session['customer_db_setting_id'] ?? ($metadata['customer_db_setting_id'] ?? null);
			$actorUserId = $session['user_id'] ?? null;
			$actorUserTypeId = $session['user_type_id'] ?? null;
			$actorEmail = $session['email'] ?? ($metadata['email'] ?? null);

			$requestId = $this->getOrCreateRequestId();
			$correlationId = $metadata['correlation_id'] ?? $requestId;

			$beforeSanitized = $this->sanitize($before);
			$afterSanitized = $this->sanitize($after);
			$metadataSanitized = $this->sanitize($metadata);

			$occurredAt = date('Y-m-d H:i:s');
			$payloadForHash = [
				'occurred_at' => $occurredAt,
				'category' => $category,
				'customer_db_setting_id' => $customerDbSettingId,
				'actor_user_id' => $actorUserId,
				'actor_user_type_id' => $actorUserTypeId,
				'actor_email' => $actorEmail,
				'module' => $module,
				'action' => $action,
				'entity_type' => $entityType,
				'entity_id' => $entityId,
				'status' => $status,
				'message' => $message,
				'before' => $beforeSanitized,
				'after' => $afterSanitized,
				'metadata' => $metadataSanitized,
				'request_id' => $requestId,
				'correlation_id' => $correlationId,
			];

			$integrityHash = $this->hmac(json_encode($payloadForHash));

			$data = [
				'audit_log_id' => function_exists('generate_uuid') ? generate_uuid() : uniqid('AUD-', true),
				'occurred_at' => $occurredAt,
				'category' => $category,
				'customer_db_setting_id' => $customerDbSettingId,
				'actor_user_id' => $actorUserId,
				'actor_user_type_id' => $actorUserTypeId,
				'actor_email' => $actorEmail,
				'ip_address' => $this->ci->input->ip_address(),
				'user_agent' => substr((string) $this->ci->input->user_agent(), 0, 1024),
				'module' => $module,
				'action' => $action,
				'entity_type' => $entityType,
				'entity_id' => $entityId,
				'status' => $status,
				'message' => $message,
				'before_json' => $beforeSanitized === null ? null : json_encode($beforeSanitized),
				'after_json' => $afterSanitized === null ? null : json_encode($afterSanitized),
				'metadata_json' => empty($metadataSanitized) ? null : json_encode($metadataSanitized),
				'request_id' => $requestId,
				'correlation_id' => $correlationId,
				'integrity_hash' => $integrityHash,
				'created_at' => $occurredAt,
			];

			$this->ci->AuditLogModel->insert($data);
		} catch (Throwable $e) {
			// Never break the primary user flow because audit logging failed.
		}
	}

	private function getOrCreateRequestId(): string
	{
		$existing = $this->ci->config->item('audit_request_id');
		if (!empty($existing)) {
			return (string) $existing;
		}

		$incoming = (string) $this->ci->input->server('HTTP_X_REQUEST_ID');
		$requestId = !empty($incoming) ? $incoming : $this->uuidLike();
		$this->ci->config->set_item('audit_request_id', $requestId);
		return $requestId;
	}

	private function uuidLike(): string
	{
		if (function_exists('random_bytes')) {
			$bytes = random_bytes(16);
			$bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x40);
			$bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);
			$hex = bin2hex($bytes);
			return substr($hex, 0, 8).'-'.substr($hex, 8, 4).'-'.substr($hex, 12, 4).'-'.substr($hex, 16, 4).'-'.substr($hex, 20);
		}
		return uniqid('req-', true);
	}

	private function hmac(string $payload): string
	{
		$key = (string) getenv('AUDIT_LOG_HMAC_KEY');
		if (empty($key)) {
			$key = (string) $this->ci->config->item('encryption_key');
		}
		if (empty($key)) {
			$key = 'audit-log-default-key';
		}
		return hash_hmac('sha256', $payload, $key);
	}

	private function sanitize($value)
	{
		if ($value === null) {
			return null;
		}
		if (is_string($value) || is_numeric($value) || is_bool($value)) {
			return $value;
		}
		if ($value instanceof stdClass) {
			$value = (array) $value;
		}
		if (is_object($value)) {
			// Best effort
			$value = json_decode(json_encode($value), true);
		}
		if (!is_array($value)) {
			return (string) $value;
		}

		$redactKeys = ['password', 'pass', 'pwd', 'token', 'secret', 'api_key', 'apikey', 'authorization', 'auth', 'session', 'cookie'];
		$out = [];
		foreach ($value as $k => $v) {
			$key = is_string($k) ? strtolower($k) : (string) $k;
			if (in_array($key, $redactKeys, true)) {
				$out[$k] = '[REDACTED]';
				continue;
			}
			$out[$k] = $this->sanitize($v);
		}
		return $out;
	}
}
