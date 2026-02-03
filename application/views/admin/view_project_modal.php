<div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
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
						<img src="<?= $thumbnailSrc ?>" alt="Project thumbnail" class="img-fluid rounded border" style="max-height: 220px;">
						<div class="mt-2">

						</div>
					</div>
					<div class="col-md-8">
						<dl class="row mb-0">
							<dt class="col-sm-4 text-secondary">Project Name</dt>
							<dd class="col-sm-8 fw-medium"><?= $projectRow->name ?? 'Untitled Project' ?></dd>

							<dt class="col-sm-4 text-secondary">Category</dt>
							<dd class="col-sm-8"><?= $categoryName ?></dd>

							<dt class="col-sm-4 text-secondary">Progress</dt>
							<dd class="col-sm-8"><?= $statusName ?></dd>

							<dt class="col-sm-4 text-secondary">Project Lead</dt>
							<dd class="col-sm-8"><?= $leadName ?></dd>

							<dt class="col-sm-4 text-secondary">Schedule</dt>
							<dd class="col-sm-8">
								<div><span class="text-muted small">Start:</span> <?= $startAt ?></div>
								<div><span class="text-muted small">Due:</span> <?= $dueAt ?></div>
							</dd>

							<dt class="col-sm-4 text-secondary">Budget</dt>
							<dd class="col-sm-8">
								<div><span class="text-muted small">Allocated:</span> <?= number_format($budgetAllocated, 2) ?></div>
								<div><span class="text-muted small">Used:</span> <?= number_format($budgetUsed, 2) ?></div>
								<div><span class="text-muted small">Balance:</span> <span class="<?= ($budgetBalance < 0) ? 'text-red' : 'text-green' ?>"><?= number_format($budgetBalance, 2) ?></span></div>
							</dd>

							<dt class="col-sm-4 text-secondary">Created</dt>
							<dd class="col-sm-8"><?= $createdAt ?></dd>

							<dt class="col-sm-4 text-secondary">Status</dt>
							<dd class="col-sm-8"><span class="badge <?= $activeClass ?>"><?= $activeName ?></span></dd>
						</dl>
					</div>
				</div>

				<?php if (!empty($description)): ?>
					<div class="mt-4">
						<h6 class="text-secondary text-uppercase fs-11">Description</h6>
						<p class="mb-0"><?= nl2br($description) ?></p>
					</div>
				<?php endif; ?>

				<?php if (!empty($dependence)): ?>
					<div class="mt-3">
						<h6 class="text-secondary text-uppercase fs-11">Dependencies</h6>
						<p class="mb-0"><?= nl2br($dependence) ?></p>
					</div>
				<?php endif; ?>

				<?php if (!empty($stakeholder)): ?>
					<div class="mt-3">
						<h6 class="text-secondary text-uppercase fs-11">Stakeholders</h6>
						<p class="mb-0"><?= nl2br($stakeholder) ?></p>
					</div>
				<?php endif; ?>

				<?php if (!empty($notes)): ?>
					<div class="mt-3">
						<h6 class="text-secondary text-uppercase fs-11">Notes</h6>
						<p class="mb-0"><?= nl2br($notes) ?></p>
					</div>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<div class="modal-body">
				<p class="text-secondary mb-0">The requested project could not be found.</p>
			</div>
		<?php endif; ?>
		<div class="card-body border-bottom py-3">
			<h3 class="mb-3">&nbsp;&nbsp;&nbsp;&nbsp; Project Updates</h3>
			<table id="project-update-datatable" class="table card-table table-vcenter text-wrap datatable" style="width: 100%;">
				<thead>
					<tr>
						<th class="w-1">#</th>
						<!-- <th>Project ID</th> -->
						<th>Title of Update</th>
						<th>Update Description</th>
						<th>DateTime</th>
						<th>Attachment</th>
						<?php if ($inputUserRight || $editUserRight || $removeUserRight): ?>
							<th>Actions</th>
						<?php endif; ?>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($projectUpdateData)): ?>
						<?php foreach ($projectUpdateData as $index => $update): ?>
							<tr>
								<td><?= ($index + 1) ?></td>
								<!-- <td><? //= $update->project_id ?? 'N/A' 
											?></td> -->
								<td><?= $update->name ?? 'N/A' ?></td>
								<td><?= nl2br($update->description ?? 'N/A') ?></td>
								<td><?= !empty($update->project_update_at) ? date('d M Y H:i', strtotime($update->project_update_at)) : 'N/A' ?></td>
								<td>
									<?php if (!empty($update->file_url) && check_file_exists($update->file_url, true)): ?>
										<a href="<?= base_url($update->file_url) ?>" target="_blank" rel="noopener">View</a>
									<?php else: ?>
										<span class="text-secondary">N/A</span>
									<?php endif; ?>
								</td>
								<td>
									<?php if ($editUserRight): ?>
									    <button type="button" class="btn btn-sm btn-primary" onclick="editProjectUpdateModal('<?=$update->project_update_id ?>')">Edit</button>
									<?php endif; if ($removeUserRight): ?>
									    <button type="button" class="btn btn-sm btn-danger" onclick="deleteProjectUpdateModal('<?=$update->project_update_id ?>')">Delete</button>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="7" class="text-center text-secondary">No project updates found.</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<?php if (in_array($user_type_id, [GlobalModel::ADMIN_TYPE, GlobalModel::CLUB_ADMIN_TYPE])): ?>
				<button type="button" class="btn btn-primary" onclick="addProjectUpdateModal('<?= $projectRow->project_id ?>')">Add Project Update</button>
			<?php endif; ?>
		</div>
	</div>
</div>
