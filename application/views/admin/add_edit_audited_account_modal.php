<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?=isset($auditedAccountRow->name) ? 'Edit '.$auditedAccountRow->name : 'Add Audited Account'?></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<form action="<?=isset($auditedAccountRow->name) ? 'edit-audited-account' : 'add-audited-account'?>" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
				<input type="hidden" name="audited_account_id" id="audited_account_id" value="<?=$audited_account_id?>">
				<input type="hidden" name="user_id" id="user_id" value="<?=isset($auditedAccountRow->user_id) ? $auditedAccountRow->user_id : ($user_id ?? '')?>">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="name" class="form-label">Title</label>
							<input type="text" class="form-control" id="name" name="name" value="<?=isset($auditedAccountRow->name) ? $auditedAccountRow->name : ''?>" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="dated_at" class="form-label">Date</label>
							<input type="date" class="form-control" id="dated_at" name="dated_at" value="<?=isset($auditedAccountRow->dated_at) ? $auditedAccountRow->dated_at : ''?>" required>
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label for="description" class="form-label">Description</label>
					<textarea class="form-control" id="add_edit_description" name="description" rows="3" required><?=isset($auditedAccountRow->description) ? $auditedAccountRow->description : ''?></textarea>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="file_url" class="form-label">Document</label>
							<input type="file" class="form-control" id="file_url" name="file_url">
							<?php if (isset($auditedAccountRow->file_url) && !empty($auditedAccountRow->file_url)): ?>
								<p class="mt-2">
									Current Document: <a href="<?=base_url($auditedAccountRow->file_url)?>" target="_blank" rel="noopener"><?=basename($auditedAccountRow->file_url)?></a>
								</p>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="active" class="form-label">Status</label>
							<select class="form-select" id="active" name="active" required>
								<option value="N/A" selected disabled>Select Status</option>
								<?php if (isset($activeData)): foreach ($activeData as $active): ?>
									<option value="<?=$active->num?>" <?=isset($auditedAccountRow) && $auditedAccountRow->active == $active->num ? 'selected' : ''?>><?=$active->name?></option>
								<?php endforeach; endif; ?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</form>
	</div>
</div>
