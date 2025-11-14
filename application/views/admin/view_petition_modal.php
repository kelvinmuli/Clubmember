<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">View Petition</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<?php if (!empty($petitionRow)): ?>
			<?php
				$activeValue = isset($petitionRow->active) ? (int) $petitionRow->active : -1;
				$statusName = get_table('m_active', 'num', $activeValue, 'name');
				$statusClass = ($activeValue === 1) ? 'bg-green-lt' : (($activeValue === 0) ? 'bg-red-lt' : 'bg-yellow-lt');
				$createdAt = !empty($petitionRow->created_at) ? date('d M Y H:i', strtotime($petitionRow->created_at)) : 'N/A';
				$closingAt = !empty($petitionRow->closing_at) ? date('d M Y H:i', strtotime($petitionRow->closing_at)) : 'Open';
				$goal = $signatureGoal ?? 0;
				$count = $signatureCount ?? 0;
				$progress = $signatureProgress ?? 0;
			?>
			<div class="modal-body">
				<div class="row g-4">
					<div class="col-md-8">
						<h3 class="mb-1"><?=$petitionRow->name ?? 'Petition'?></h3>
						<div class="text-muted small mb-3">Created <?=$createdAt?></div>
						<?php if (!empty($petitionRow->description)): ?>
							<div class="mb-3">
								<h6 class="text-secondary text-uppercase fs-11">Description</h6>
								<p class="mb-0 text-muted"><?=$petitionRow->description?></p>
							</div>
						<?php endif; ?>
						<span class="badge <?=$statusClass?>">Status: <?=$statusName ?: 'N/A'?></span>
						<?php if (!empty($petitionRow->call_to_action)): ?>
							<div class="mb-3">
								<h6 class="text-secondary text-uppercase fs-11">Call to Action</h6>
								<p class="mb-0 text-muted"><?=$petitionRow->call_to_action?></p>
							</div>
						<?php endif; ?>
					</div>
					<div class="col-md-4">
						<div class="border rounded p-3 bg-light">
							<h6 class="text-secondary text-uppercase fs-11">Timeline</h6>
							<ul class="list-unstyled mb-0">
								<li><span class="text-muted small">Closing:</span> <?=$closingAt?></li>
							</ul>
							<hr>
							<h6 class="text-secondary text-uppercase fs-11">Signatures</h6>
							<div class="d-flex justify-content-between">
								<span class="text-muted small">Collected</span>
								<span class="fw-semibold"><?=number_format($count)?></span>
							</div>
							<div class="d-flex justify-content-between">
								<span class="text-muted small">Target</span>
								<span class="fw-semibold"><?=number_format($goal)?></span>
							</div>
							<div class="progress progress-sm mt-2">
								<div class="progress-bar" role="progressbar" style="width: <?=$progress?>%;" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<div class="text-muted small mt-1">Progress: <?=$progress?>%</div>
						</div>
					</div>
				</div>

				<?php if (!empty($petitionRow->requirements)): ?>
					<div class="mt-4">
						<h6 class="text-secondary text-uppercase fs-11">Requirements</h6>
						<p class="mb-0 text-muted"><?=$petitionRow->requirements?></p>
					</div>
				<?php endif; ?>

				<?php if (!empty($petitionRow->additional_information)): ?>
					<div class="mt-3">
						<h6 class="text-secondary text-uppercase fs-11">Additional Information</h6>
						<p class="mb-0 text-muted"><?=$petitionRow->additional_information?></p>
					</div>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<div class="modal-body">
				<p class="text-secondary mb-0">The requested petition setup could not be found.</p>
			</div>
		<?php endif; ?>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
	</div>
</div>
