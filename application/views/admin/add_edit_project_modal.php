<?php
	$isEdit = isset($projectRow);
	$modalTitle = $isEdit ? 'Edit ' . htmlspecialchars($projectRow->name ?? 'Project', ENT_QUOTES, 'UTF-8') : 'Add Project';
	$projectId = $isEdit ? ($projectRow->project_id ?? '') : ($project_id ?? generate_uuid());
	$projectCategoryData = $projectCategoryData ?? [];
	$projectStatusData = $projectStatusData ?? [];
	$activeData = $activeData ?? [];
	$allocatedValue = $isEdit ? (float) ($projectRow->budget_allocated ?? 0) : 0;
	$usedValue = $isEdit ? (float) ($projectRow->budget_used ?? 0) : 0;
	$startAtValue = $isEdit && !empty($projectRow->start_at) ? date('Y-m-d\TH:i', strtotime($projectRow->start_at)) : '';
	$dueAtValue = $isEdit && !empty($projectRow->due_at) ? date('Y-m-d\TH:i', strtotime($projectRow->due_at)) : '';
	$existingThumbnailUrl = $isEdit ? ($projectRow->thumbnail_url ?? '') : '';
	$thumbnailPreviewUrl = '';
	if (!empty($existingThumbnailUrl)) {
		$thumbnailPreviewUrl = filter_var($existingThumbnailUrl, FILTER_VALIDATE_URL) ? $existingThumbnailUrl : base_url($existingThumbnailUrl);
	}
?>

<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?=$modalTitle?></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<form action="<?=base_url($isEdit ? 'edit-project' : 'add-project')?>" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
				<input type="hidden" name="project_id" value="<?=htmlspecialchars($projectId, ENT_QUOTES, 'UTF-8')?>">
				<div class="row g-3">
					<div class="col-md-6">
						<label class="form-label" for="project_name">Project Name</label>
						<input type="text" class="form-control" id="project_name" name="name" value="<?=htmlspecialchars($isEdit ? ($projectRow->name ?? '') : '', ENT_QUOTES, 'UTF-8')?>" required>
					</div>
					<div class="col-md-6">
						<label class="form-label" for="project_category_id">Category</label>
						<select class="form-select" id="project_category_id" name="project_category_id">
							<option value="" selected disabled>Select Category</option>
							<?php foreach ($projectCategoryData as $category): ?>
								<option value="<?=$category->project_category_id ?? ''?>" <?=($isEdit && isset($projectRow->project_category_id) && $projectRow->project_category_id == ($category->project_category_id ?? '')) ? 'selected' : ''?>><?=htmlspecialchars($category->name ?? '', ENT_QUOTES, 'UTF-8')?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-6">
						<label class="form-label" for="project_start_at">Start Date</label>
						<input type="datetime-local" class="form-control" id="project_start_at" name="start_at" value="<?=$startAtValue?>">
					</div>
					<div class="col-md-6">
						<label class="form-label" for="project_due_at">Due Date</label>
						<input type="datetime-local" class="form-control" id="project_due_at" name="due_at" value="<?=$dueAtValue?>">
					</div>
					<div class="col-md-6">
						<label class="form-label" for="project_lead_id">Project Lead</label>
						<select class="form-select" id="project_lead_id" name="lead_id">
							<option value="" selected disabled>Select Project Lead</option>
							<?php foreach ($projectLeadData as $lead): ?>
								<option value="<?=$lead->user_id ?? ''?>" <?=($isEdit && isset($projectRow->project_lead_id) && $projectRow->project_lead_id == ($lead->user_id ?? '')) ? 'selected' : ''?>><?=htmlspecialchars($lead->full_legal_name ?? '', ENT_QUOTES, 'UTF-8')?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="mb-3 mt-3">
					<label class="form-label" for="project_description">Description</label>
					<textarea class="form-control" id="project_description" name="description" rows="4" placeholder="Project details..."><?=htmlspecialchars($isEdit ? ($projectRow->description ?? '') : '', ENT_QUOTES, 'UTF-8')?></textarea>
				</div>
				<div class="mb-3">
					<label class="form-label" for="project_dependence">Dependencies</label>
					<input type="text" class="form-control" id="project_dependence" name="dependence" value="<?=htmlspecialchars($isEdit ? ($projectRow->dependence ?? '') : '', ENT_QUOTES, 'UTF-8')?>" placeholder="Comma separated references">
				</div>
				<div class="mb-3">
					<label class="form-label" for="project_stakeholders">Stakeholders</label>
					<input type="text" class="form-control" id="project_stakeholders" name="stakeholder" value="<?=htmlspecialchars($isEdit ? ($projectRow->stakeholder ?? '') : '', ENT_QUOTES, 'UTF-8')?>" placeholder="Comma separated stakeholders">
				</div>
				<div class="row g-3">
					<div class="col-md-4">
						<label class="form-label" for="project_budget_allocated">Budget Allocated</label>
						<input type="number" step="0.01" class="form-control" id="project_budget_allocated" name="budget_allocated" value="<?=number_format($allocatedValue, 2, '.', '')?>" min="0">
					</div>
					<div class="col-md-4">
						<label class="form-label" for="project_budget_used">Budget Used</label>
						<input type="number" step="0.01" class="form-control" id="project_budget_used" name="budget_used" value="<?=number_format($usedValue, 2, '.', '')?>" min="0">
					</div>
					<div class="col-md-4">
						<label class="form-label" for="project_status_id">Progress</label>
						<select class="form-select" id="project_status_id" name="project_status_id">
							<option value="">Select Progress</option>
							<?php foreach ($projectStatusData as $status): ?>
								<option value="<?=$status->project_status_id ?? ''?>" <?=($isEdit && isset($projectRow->project_status_id) && $projectRow->project_status_id == ($status->project_status_id ?? '')) ? 'selected' : ''?>><?=htmlspecialchars($status->name ?? '', ENT_QUOTES, 'UTF-8')?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="row g-3 mt-3">
					<div class="col-md-6">
						<label class="form-label" for="project_thumbnail_file">Thumbnail Image</label>
						<input type="file" class="form-control" id="project_thumbnail_file" name="project_thumbnail_file" accept="image/png,image/jpeg,image/jpg">
						<small class="form-text text-muted">Upload a project thumbnail (PNG or JPG).</small>
					</div>
					<div class="col-md-6">
						<label class="form-label" for="project_thumbnail_url">Thumbnail URL</label>
						<input type="url" class="form-control" id="project_thumbnail_url" name="thumbnail_url" placeholder="https://example.com/image.png" value="<?=htmlspecialchars($isEdit ? ($projectRow->thumbnail_url ?? '') : '', ENT_QUOTES, 'UTF-8')?>">
						<small class="form-text text-muted">Provide a direct image URL if hosted externally.</small>
					</div>
				</div>

				<?php if (!empty($thumbnailPreviewUrl)): ?>
					<div class="mt-3">
						<label class="form-label">Current Thumbnail</label>
						<div class="border rounded p-2 bg-light text-center">
							<img src="<?=$thumbnailPreviewUrl?>" alt="Current thumbnail" class="img-fluid" style="max-height: 200px;">
						</div>
					</div>
				<?php endif; ?>

				<div class="mb-3 mt-3">
					<label class="form-label" for="project_notes">Notes</label>
					<textarea class="form-control" id="project_notes" name="notes" rows="3" placeholder="Additional notes..."><?=htmlspecialchars($isEdit ? ($projectRow->notes ?? '') : '', ENT_QUOTES, 'UTF-8')?></textarea>
				</div>

				<div class="mb-3">
					<label class="form-label" for="project_active">Status</label>
					<select class="form-select" id="project_active" name="active" required>
						<option value="" disabled <?=(!$isEdit || !isset($projectRow->active)) ? 'selected' : ''?>>Select Status</option>
						<?php foreach ($activeData as $active): ?>
							<option value="<?=$active->num ?? ''?>" <?=($isEdit && isset($projectRow->active) && $projectRow->active == ($active->num ?? '')) ? 'selected' : ''?>><?=htmlspecialchars($active->name ?? '', ENT_QUOTES, 'UTF-8')?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</form>
	</div>
</div>
