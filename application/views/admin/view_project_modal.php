<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">View Project</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<?php if (!empty($projectRow)): ?>
			<?php
				$thumbnailUrl = trim($projectRow->thumbnail_url ?? '');
				$hasThumbnail = !empty($thumbnailUrl) && check_file_exists($thumbnailUrl, true);
				$thumbnailSrc = $hasThumbnail ? (filter_var($thumbnailUrl, FILTER_VALIDATE_URL) ? $thumbnailUrl : base_url($thumbnailUrl)) : base_url('assets/admin/images/no-image.png');
				$description = $projectRow->description ?? '';
				$dependence = $projectRow->dependence ?? '';
				$stakeholder = $projectRow->stakeholder ?? '';
				$notes = $projectRow->notes ?? '';
				$startAt = !empty($projectRow->start_at) ? date('d M Y H:i', strtotime($projectRow->start_at)) : 'Not set';
				$dueAt = !empty($projectRow->due_at) ? date('d M Y H:i', strtotime($projectRow->due_at)) : 'Not set';
				$createdAt = !empty($projectRow->created_at) ? date('d M Y H:i', strtotime($projectRow->created_at)) : 'N/A';
				$updatedAt = !empty($projectRow->updated_at) ? date('d M Y H:i', strtotime($projectRow->updated_at)) : 'N/A';
				$budgetAllocated = (float) ($projectRow->budget_allocated ?? 0);
				$budgetUsed = (float) ($projectRow->budget_used ?? 0);
				$budgetBalance = $budgetAllocated - $budgetUsed;
				$leadName = !empty($projectLeadName) ? $projectLeadName : 'Not assigned';
				$statusName = !empty($projectStatusName) ? $projectStatusName : 'Not set';
				$categoryName = !empty($projectCategoryName) ? $projectCategoryName : 'Not set';
				$activeName = !empty($activeName) ? $activeName : 'Unknown';
				$activeClass = !empty($activeClass) ? $activeClass : 'bg-yellow-lt';
			?>
			<div class="modal-body">
				<div class="row g-4">
					<div class="col-md-4 text-center">
						<img src="<?=$thumbnailSrc?>" alt="Project thumbnail" class="img-fluid rounded border" style="max-height: 220px;">
						<div class="mt-2">
							
						</div>
					</div>
					<div class="col-md-8">
						<dl class="row mb-0">
							<dt class="col-sm-4 text-secondary">Project Name</dt>
							<dd class="col-sm-8 fw-medium"><?=$projectRow->name ?? 'Untitled Project'?></dd>

							<dt class="col-sm-4 text-secondary">Category</dt>
							<dd class="col-sm-8"><?=$categoryName?></dd>

							<dt class="col-sm-4 text-secondary">Progress</dt>
							<dd class="col-sm-8"><?=$statusName?></dd>

							<dt class="col-sm-4 text-secondary">Project Lead</dt>
							<dd class="col-sm-8"><?=$leadName?></dd>

							<dt class="col-sm-4 text-secondary">Schedule</dt>
							<dd class="col-sm-8">
								<div><span class="text-muted small">Start:</span> <?=$startAt?></div>
								<div><span class="text-muted small">Due:</span> <?=$dueAt?></div>
							</dd>

							<dt class="col-sm-4 text-secondary">Budget</dt>
							<dd class="col-sm-8">
								<div><span class="text-muted small">Allocated:</span> <?=number_format($budgetAllocated, 2)?></div>
								<div><span class="text-muted small">Used:</span> <?=number_format($budgetUsed, 2)?></div>
								<div><span class="text-muted small">Balance:</span> <span class="<?=($budgetBalance < 0) ? 'text-red' : 'text-green'?>"><?=number_format($budgetBalance, 2)?></span></div>
							</dd>

							<dt class="col-sm-4 text-secondary">Created</dt>
							<dd class="col-sm-8"><?=$createdAt?></dd>

							<dt class="col-sm-4 text-secondary">Status</dt>
							<dd class="col-sm-8"><span class="badge <?=$activeClass?>"><?=$activeName?></span></dd>
						</dl>
					</div>
				</div>

				<?php if (!empty($description)): ?>
					<div class="mt-4">
						<h6 class="text-secondary text-uppercase fs-11">Description</h6>
						<p class="mb-0"><?=nl2br($description)?></p>
					</div>
				<?php endif; ?>

				<?php if (!empty($dependence)): ?>
					<div class="mt-3">
						<h6 class="text-secondary text-uppercase fs-11">Dependencies</h6>
						<p class="mb-0"><?=nl2br($dependence)?></p>
					</div>
				<?php endif; ?>

				<?php if (!empty($stakeholder)): ?>
					<div class="mt-3">
						<h6 class="text-secondary text-uppercase fs-11">Stakeholders</h6>
						<p class="mb-0"><?=nl2br($stakeholder)?></p>
					</div>
				<?php endif; ?>

				<?php if (!empty($notes)): ?>
					<div class="mt-3">
						<h6 class="text-secondary text-uppercase fs-11">Notes</h6>
						<p class="mb-0"><?=nl2br($notes)?></p>
					</div>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<div class="modal-body">
				<p class="text-secondary mb-0">The requested project could not be found.</p>
			</div>
		<?php endif; ?>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
	</div>
</div>
