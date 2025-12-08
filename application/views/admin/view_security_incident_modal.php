<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">View Security Incident</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<?php if (!empty($incidentRow)): ?>
			<?php
				$location = isset($incidentRow->location) && $incidentRow->location !== '' ? $incidentRow->location : 'Unknown location';
				$reportedBy = isset($incidentRow->reported_by) && $incidentRow->reported_by !== '' ? $incidentRow->reported_by : 'Unknown reporter';
				$incidentAt = !empty($incidentRow->incident_at) ? date('d M Y H:i', strtotime($incidentRow->incident_at)) : 'Not recorded';
				$createdAt = !empty($incidentRow->created_at) ? date('d M Y H:i', strtotime($incidentRow->created_at)) : 'Not recorded';
				$updatedAt = !empty($incidentRow->updated_at) ? date('d M Y H:i', strtotime($incidentRow->updated_at)) : 'Never updated';
				$typeName = !empty($incidentTypeName) ? get_table('m_incident_type', 'incident_type_id', $incidentRow->incident_type_id, 'name') : 'Unclassified';
				$statusName = !empty($incidentRow->incident_status_id) ? get_table('m_incident_status', 'incident_status_id', $incidentRow->incident_status_id, 'name') : 'Unknown';
				$statusClass = !empty($statusClass) ? $statusClass : 'bg-yellow-lt';
			?>
			<div class="modal-body">
				<div class="row g-4">
					<div class="col-md-8">
						<h3 class="mb-1"><?=$location?></h3>
						<div class="text-muted small mb-2">Reported by <?=$reportedBy?> on <?=$incidentAt?></div>
						<span class="badge bg-blue-lt me-2">Type: <?=$typeName?></span>
						<span class="badge <?=$statusClass?>">Status: <?=$statusName?></span>
					</div>
					<div class="col-md-4">
						<div class="border rounded p-3 bg-light">
							<h6 class="text-secondary text-uppercase fs-11 mb-2">Timeline</h6>
							<div class="text-muted small">Incident: <?=$incidentAt?></div>
							<div class="text-muted small">Created: <?=$createdAt?></div>
							<div class="text-muted small">Updated: <?=$updatedAt?></div>
						</div>
					</div>
				</div>

				<?php if (!empty($incidentRow->description)): ?>
					<div class="mt-4">
						<h6 class="text-secondary text-uppercase fs-11">Description</h6>
						<p class="mb-0 text-muted"><?=nl2br($incidentRow->description)?></p>
					</div>
				<?php endif; ?>

				<?php if (isset($incidentRow->impact_assessment) && $incidentRow->impact_assessment !== ''): ?>
					<div class="mt-3">
						<h6 class="text-secondary text-uppercase fs-11">Impact Assessment</h6>
						<p class="mb-0 text-muted"><?=nl2br($incidentRow->impact_assessment)?></p>
					</div>
				<?php endif; ?>

				<?php if (isset($incidentRow->actions_taken) && $incidentRow->actions_taken !== ''): ?>
					<div class="mt-3">
						<h6 class="text-secondary text-uppercase fs-11">Actions Taken</h6>
						<p class="mb-0 text-muted"><?=nl2br($incidentRow->actions_taken)?></p>
					</div>
				<?php endif; ?>

				<?php if (isset($incidentRow->follow_up_actions) && $incidentRow->follow_up_actions !== ''): ?>
					<div class="mt-3">
						<h6 class="text-secondary text-uppercase fs-11">Follow-up Actions</h6>
						<p class="mb-0 text-muted"><?=nl2br($incidentRow->follow_up_actions)?></p>
					</div>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<div class="modal-body">
				<p class="text-secondary mb-0">The requested security incident could not be found.</p>
			</div>
		<?php endif; ?>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
	</div>
</div>
