<?php
	$projectRow = $projectRow ?? null;
	$projectName = $projectRow ? ($projectRow->name ?? 'this project') : 'this project';
	$projectId = $projectRow ? ($projectRow->project_id ?? '') : ($project_id ?? '');
?>
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Remove Project</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form action="<?=base_url('remove-project')?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="project_id" value="<?=htmlspecialchars($projectId, ENT_QUOTES, 'UTF-8')?>">
				<p>Are you sure you want to remove <strong><?=htmlspecialchars($projectName, ENT_QUOTES, 'UTF-8')?></strong>? This action cannot be undone.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-danger">Remove</button>
			</div>
		</form>
	</div>
</div>
