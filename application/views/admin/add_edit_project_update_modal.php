<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?=isset($projectUpdateRow->project_update_id) ? 'Edit Project Update' : 'Add Project Update'?></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<form action="<?=isset($projectUpdateRow->project_update_id) ? 'edit-project-update' : 'add-project-update'?>" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
				<input type="hidden" name="project_update_id" id="project_update_id" value="<?=htmlspecialchars($project_update_id ?? '', ENT_QUOTES, 'UTF-8')?>">
				<input type="hidden" name="project_id" id="project_id" value="<?=htmlspecialchars($project_id ?? '', ENT_QUOTES, 'UTF-8')?>">

				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="name" class="form-label">Title</label>
							<input type="text" class="form-control" id="name" name="name" value="<?=isset($projectUpdateRow->name) ? htmlspecialchars($projectUpdateRow->name, ENT_QUOTES, 'UTF-8') : ''?>" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="project_update_at" class="form-label">Date &amp; Time</label>
							<?php
								$projectUpdateAtValue = '';
								if (isset($projectUpdateRow->project_update_at) && !empty($projectUpdateRow->project_update_at)) {
									$ts = strtotime($projectUpdateRow->project_update_at);
									$projectUpdateAtValue = $ts ? date('Y-m-d\TH:i', $ts) : '';
								}
							?>
							<input type="datetime-local" class="form-control" id="project_update_at" name="project_update_at" value="<?=htmlspecialchars($projectUpdateAtValue, ENT_QUOTES, 'UTF-8')?>">
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label for="description" class="form-label">Description</label>
					<textarea class="form-control" id="description" name="description" rows="4" required><?=isset($projectUpdateRow->description) ? htmlspecialchars($projectUpdateRow->description, ENT_QUOTES, 'UTF-8') : ''?></textarea>
				</div>

				<div class="mb-3">
					<label for="file_url" class="form-label">Attachment (optional)</label>
					<input type="file" class="form-control" id="file_url" name="file_url">
					<?php if (isset($projectUpdateRow->file_url) && !empty($projectUpdateRow->file_url)): ?>
						<p class="mt-2">
							Current File: <a href="<?=base_url($projectUpdateRow->file_url)?>" target="_blank" rel="noopener"><?=basename($projectUpdateRow->file_url)?></a>
						</p>
					<?php endif; ?>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</form>
	</div>
</div>
