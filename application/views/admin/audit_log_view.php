<?php
/** @var array $filters */
/** @var array $statsByDay */
?>

<div class="page-wrapper">
	<div class="page-header d-print-none">
		<div class="container-fluid">
			<div class="row g-2 align-items-center">
				<div class="col">
					<h2 class="page-title">Audit & Logging</h2>
					<div class="text-muted mt-1">Immutable, timestamped events with before/after, correlation IDs, and exports.</div>
				</div>
				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">
						<a class="btn btn-outline-primary" href="<?=base_url('audit-log/export/csv?'.http_build_query(array_filter($filters)))?>">Export CSV</a>
						<a class="btn btn-outline-primary" href="<?=base_url('audit-log/export/json?'.http_build_query(array_filter($filters)))?>">Export JSON</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="page-body">
		<div class="container-fluid">
			<div class="card mb-3">
				<div class="card-body">
					<form method="get" action="<?=base_url('audit-log')?>" class="row g-2">
						<div class="col-md-2">
							<label class="form-label">From</label>
							<input type="date" name="date_from" class="form-control" value="<?=htmlspecialchars($filters['date_from'] ?? '')?>">
						</div>
						<div class="col-md-2">
							<label class="form-label">To</label>
							<input type="date" name="date_to" class="form-control" value="<?=htmlspecialchars($filters['date_to'] ?? '')?>">
						</div>
						<div class="col-md-2">
							<label class="form-label">User ID</label>
							<input type="text" name="actor_user_id" class="form-control" value="<?=htmlspecialchars($filters['actor_user_id'] ?? '')?>" placeholder="actor user id">
						</div>
						<div class="col-md-2">
							<label class="form-label">Module</label>
							<input type="text" name="module" class="form-control" value="<?=htmlspecialchars($filters['module'] ?? '')?>" placeholder="auth, payment, admin">
						</div>
						<div class="col-md-2">
							<label class="form-label">Action</label>
							<input type="text" name="action" class="form-control" value="<?=htmlspecialchars($filters['action'] ?? '')?>" placeholder="login, role_change">
						</div>
						<div class="col-md-2">
							<label class="form-label">Status</label>
							<select class="form-select" name="status">
								<option value="" <?=empty($filters['status']) ? 'selected' : ''?>>Any</option>
								<option value="success" <?=($filters['status'] ?? '') === 'success' ? 'selected' : ''?>>Success</option>
								<option value="fail" <?=($filters['status'] ?? '') === 'fail' ? 'selected' : ''?>>Fail</option>
							</select>
						</div>
						<div class="col-md-3">
							<label class="form-label">Entity Type</label>
							<input type="text" name="entity_type" class="form-control" value="<?=htmlspecialchars($filters['entity_type'] ?? '')?>" placeholder="user, payment">
						</div>
						<div class="col-md-3">
							<label class="form-label">Entity ID</label>
							<input type="text" name="entity_id" class="form-control" value="<?=htmlspecialchars($filters['entity_id'] ?? '')?>" placeholder="id">
						</div>
						<div class="col-md-3">
							<label class="form-label">Correlation ID</label>
							<input type="text" name="correlation_id" class="form-control" value="<?=htmlspecialchars($filters['correlation_id'] ?? '')?>" placeholder="trace across modules">
						</div>
						<div class="col-md-3">
							<label class="form-label">Search</label>
							<input type="text" name="q" class="form-control" value="<?=htmlspecialchars($filters['q'] ?? '')?>" placeholder="text search">
						</div>
						<div class="col-12">
							<button type="submit" class="btn btn-primary">Filter</button>
							<a class="btn btn-outline-secondary" href="<?=base_url('audit-log')?>">Reset</a>
						</div>
					</form>
				</div>
			</div>

			<div class="card mb-3">
				<div class="card-header">
					<h3 class="card-title">Activity (last 14 days)</h3>
				</div>
				<div class="card-body">
					<canvas id="auditChart" height="80"></canvas>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Events (<?=$total ?? 0?>)</h3>
				</div>
				<div class="table-responsive">
					<table id="auditTable" class="table table-vcenter card-table">
						<thead>
							<tr>
								<th>When</th>
								<th>Category</th>
								<th>Actor</th>
								<th>Module</th>
								<th>Action</th>
								<th>Entity</th>
								<th>Status</th>
								<th>Trace</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach (($auditLogData ?? []) as $row): ?>
							<tr>
								<td class="text-nowrap"><?=$row->occurred_at?></td>
								<td><?=$row->category?></td>
								<td>
									<div class="text-muted"><?=$row->actor_user_id?></div>
									<div class="small"><?=htmlspecialchars($row->actor_email ?? '')?></div>
								</td>
								<td><?=$row->module?></td>
								<td><?=$row->action?></td>
								<td>
									<div><?=$row->entity_type?></div>
									<div class="text-muted small"><?=htmlspecialchars($row->entity_id ?? '')?></div>
								</td>
								<td>
									<?php if (($row->status ?? '') === 'success'): ?>
										<span class="badge bg-success">success</span>
									<?php else: ?>
										<span class="badge bg-danger">fail</span>
									<?php endif; ?>
								</td>
								<td>
									<div class="text-muted small">req: <?=htmlspecialchars($row->request_id ?? '')?></div>
									<div class="text-muted small">corr: <?=htmlspecialchars($row->correlation_id ?? '')?></div>
								</td>
								<td class="text-end">
									<a class="btn btn-sm btn-outline-primary" href="<?=base_url('audit-log/details/'.$row->audit_log_id)?>">Details</a>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="card-footer d-flex align-items-center">
					<div class="text-muted">Page <?=$page ?? 1?> • Showing <?=count($auditLogData ?? [])?> of <?=$total ?? 0?></div>
					<ul class="pagination m-0 ms-auto">
						<?php
							$totalPages = (int) ceil(($total ?? 0) / ($limit ?? 100));
							$totalPages = max(1, $totalPages);
							$prev = max(1, ($page ?? 1) - 1);
							$next = min($totalPages, ($page ?? 1) + 1);
							$queryBase = array_filter($filters);
						?>
						<li class="page-item <?=($page ?? 1) <= 1 ? 'disabled' : ''?>">
							<a class="page-link" href="<?=base_url('audit-log?'.http_build_query(array_merge($queryBase, ['page'=>$prev])))?>">Prev</a>
						</li>
						<li class="page-item disabled"><a class="page-link" href="#"><?=$page ?? 1?> / <?=$totalPages?></a></li>
						<li class="page-item <?=($page ?? 1) >= $totalPages ? 'disabled' : ''?>">
							<a class="page-link" href="<?=base_url('audit-log?'.http_build_query(array_merge($queryBase, ['page'=>$next])))?>">Next</a>
						</li>
					</ul>
				</div>
			</div>

		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
	$(document).ready(function() {
		$('#auditTable').DataTable({
			pageLength: 25,
			order: [[0, 'desc']]
		});
	});

	const stats = <?=json_encode($statsByDay ?? [])?>;
	const labels = Object.keys(stats);
	const values = Object.values(stats);

	const ctx = document.getElementById('auditChart');
	new Chart(ctx, {
		type: 'line',
		data: {
			labels: labels,
			datasets: [{
				label: 'Events',
				data: values,
				borderColor: '#206bc4',
				backgroundColor: 'rgba(32,107,196,0.15)',
				fill: true,
				tension: 0.25
			}]
		},
		options: {
			plugins: { legend: { display: true } },
			scales: { y: { beginAtZero: true } }
		}
	});
</script>
