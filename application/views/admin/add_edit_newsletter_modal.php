<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?=isset($newsletterRow->name) ? 'Edit '.$newsletterRow->name : 'Create Newsletter'?></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

    	<form action="<?=isset($newsletterRow->name) ? 'edit-newsletter' : 'add-newsletter'?>" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
				<input type="hidden" name="newsletter_id" id="newsletter_id" value="<?=$newsletter_id?>">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="name" class="form-label">Title</label>
							<input type="text" class="form-control" id="name" name="name" value="<?=isset($newsletterRow->name) ? $newsletterRow->name : ''?>" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="thumbnail_url" class="form-label">Thumbnail</label>
							<input type="file" class="form-control" id="thumbnail_url" name="thumbnail_url">
							<?php if (isset($newsletterRow->thumbnail_url) && !empty($newsletterRow->thumbnail_url)): ?>
								<p class="mt-2">
									Current Thumbnail: <a href="<?=base_url($newsletterRow->thumbnail_url)?>" target="_blank" rel="noopener"><?=basename($newsletterRow->thumbnail_url)?></a>
								</p>
							<?php endif; ?>
					</div>
				</div>
				<div class="mb-3">
					<label for="description" class="form-label">Description</label>
					<textarea class="form-control" id="add_edit_description" name="description" rows="3" required><?=isset($newsletterRow->description) ? $newsletterRow->description : ''?></textarea>
				</div>
				<div class="col-md-6">
					<div class="mb-3">
						<label for="file_url" class="form-label">File</label>
						<input type="file" class="form-control" id="file_url" name="file_url">
						<?php if (isset($newsletterRow->file_url) && !empty($newsletterRow->file_url)): ?>
							<p class="mt-2">
								Current File: <a href="<?=base_url($newsletterRow->file_url)?>" target="_blank" rel="noopener"><?=basename($newsletterRow->file_url)?></a>
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
								<option value="<?=$active->num?>" <?=isset($newsletterRow) && $newsletterRow->active == $active->num ? 'selected' : ''?>><?=$active->name?></option>
							<?php endforeach; endif; ?>
						</select>
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
