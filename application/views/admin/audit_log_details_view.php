<?php
/** @var object $auditRow */
$before = !empty($auditRow->before_json) ? json_decode($auditRow->before_json, true) : null;
$after = !empty($auditRow->after_json) ? json_decode($auditRow->after_json, true) : null;
$meta = !empty($auditRow->metadata_json) ? json_decode($auditRow->metadata_json, true) : null;
?>

<div class="page-wrapper">
	<div class="page-header d-print-none">
		<div class="container-xl">
			<div class="row g-2 align-items-center">
				<div class="col">
					<h2 class="page-title">Audit Event Details</h2>
					<div class="text-muted mt-1"><?=htmlspecialchars($auditRow->module.' • '.$auditRow->action)?></div>
				</div>
				<div class="col-auto ms-auto d-print-none">
					<a class="btn btn-outline-secondary" href="<?=base_url('audit-log')?>">Back</a>
				</div>
			</div>
		</div>
	</div>

	<div class="page-body">
		<div class="container-xl">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<div class="mb-2"><strong>Occurred</strong>: <?=$auditRow->occurred_at?></div>
							<div class="mb-2"><strong>Category</strong>: <?=htmlspecialchars($auditRow->category)?></div>
							<div class="mb-2"><strong>Status</strong>: <?=htmlspecialchars($auditRow->status)?></div>
							<div class="mb-2"><strong>Actor</strong>: <?=htmlspecialchars(($auditRow->actor_user_id ?? '').' '.($auditRow->actor_email ?? ''))?></div>
							<div class="mb-2"><strong>IP</strong>: <?=htmlspecialchars($auditRow->ip_address ?? '')?></div>
							<div class="mb-2"><strong>Request</strong>: <?=htmlspecialchars($auditRow->request_id ?? '')?></div>
							<div class="mb-2"><strong>Correlation</strong>: <a href="<?=base_url('audit-log?'.http_build_query(['correlation_id'=>$auditRow->correlation_id]))?>"><?=htmlspecialchars($auditRow->correlation_id ?? '')?></a></div>
							<div class="mb-2"><strong>Entity</strong>: <?=htmlspecialchars($auditRow->entity_type ?? '').' '.htmlspecialchars($auditRow->entity_id ?? '')?></div>
							<div class="mb-2"><strong>Integrity hash</strong>: <span class="text-muted"><?=htmlspecialchars($auditRow->integrity_hash ?? '')?></span></div>
						</div>
						<div class="col-md-8">
							<div class="mb-3">
								<label class="form-label">Message</label>
								<div class="form-control" style="min-height:40px"><?=nl2br(htmlspecialchars($auditRow->message ?? ''))?></div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<label class="form-label">Before</label>
									<pre class="form-control" style="min-height:280px"><?=htmlspecialchars(json_encode($before, JSON_PRETTY_PRINT))?></pre>
								</div>
								<div class="col-md-6">
									<label class="form-label">After</label>
									<pre class="form-control" style="min-height:280px"><?=htmlspecialchars(json_encode($after, JSON_PRETTY_PRINT))?></pre>
								</div>
							</div>

							<div class="mt-3">
								<label class="form-label">Metadata</label>
								<pre class="form-control" style="min-height:180px"><?=htmlspecialchars(json_encode($meta, JSON_PRETTY_PRINT))?></pre>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
