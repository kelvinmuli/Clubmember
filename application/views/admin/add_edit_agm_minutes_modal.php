<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?=isset($agmMinutesRow->name) ? 'Edit '.$agmMinutesRow->name : 'Add AGM Minutes'?></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
		<form action="<?=isset($agmMinutesRow->name) ? 'edit-agm-minutes' : 'add-agm-minutes'?>" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
				<input type="hidden" name="agm_minutes_id" id="agm_minutes_id" value="<?=$agm_minutes_id?>">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="name" class="form-label">Title</label>
							<input type="text" class="form-control" id="name" name="name" value="<?=isset($agmMinutesRow->name) ? $agmMinutesRow->name : ''?>" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="date" class="form-label">Date</label>
							<input type="date" class="form-control" id="date_at" name="date_at" value="<?=isset($agmMinutesRow->date_at) ? $agmMinutesRow->date_at : ''?>" required>
						</div>
					</div>
				</div>
				<div class="mb-3">
					<label for="description" class="form-label">Description</label>
					<textarea class="form-control" id="add_edit_description" name="description" rows="3" required><?=isset($agmMinutesRow->description) ? $agmMinutesRow->description : ''?></textarea>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="doc_url" class="form-label">Document</label>
							<input type="file" class="form-control" id="doc_url" name="doc_url">
							<?php if (isset($agmMinutesRow->doc_url) && !empty($agmMinutesRow->doc_url)): ?>
								<p class="mt-2">
									Current Document: <a href="<?=base_url($agmMinutesRow->doc_url)?>" target="_blank" rel="noopener"><?=basename($agmMinutesRow->doc_url)?></a>
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
									<option value="<?=$active->num?>" <?=isset($agmMinutesRow) && $agmMinutesRow->active == $active->num ? 'selected' : ''?>><?=$active->name?></option>
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
