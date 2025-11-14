<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?=isset($petitionSetupRow->name) ? 'Edit ' . $petitionSetupRow->name : 'Create Petition Setup'?></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

    	<form action="<?=isset($petitionSetupRow->name) ? 'edit-petition-setup' : 'add-petition-setup'?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="petition_setup_id" id="petition_setup_id" value="<?=$petition_setup_id?>">
				<div class="mb-3">
					<label for="petition_setup_name" class="form-label">Title</label>
					<input type="text" class="form-control" id="petition_setup_name" name="name" value="<?=isset($petitionSetupRow->name) ? $petitionSetupRow->name : ''?>" required>
				</div>
				<div class="mb-3">
					<label for="petition_setup_description" class="form-label">Description</label>
					<textarea class="form-control" id="petition_setup_description" name="description" rows="3" required><?=isset($petitionSetupRow->description) ? $petitionSetupRow->description : ''?></textarea>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="no_of_signature" class="form-label">Target Signatures</label>
							<input type="number" class="form-control" id="no_of_signature" name="no_of_signature" min="0" value="<?=isset($petitionSetupRow->no_of_signature) ? (int) $petitionSetupRow->no_of_signature : 0?>" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="closing_at" class="form-label">Closing Date</label>
							<?php
								$closingAtValue = '';
								if (isset($petitionSetupRow->closing_at) && !empty($petitionSetupRow->closing_at)) {
									$closingAtValue = date('Y-m-d\\TH:i', strtotime($petitionSetupRow->closing_at));
								}
							?>
							<input type="datetime-local" class="form-control" id="closing_at" name="closing_at" value="<?=$closingAtValue?>">
						</div>
					</div>
				</div>
				<div class="mb-3">
					<label for="petition_setup_active" class="form-label">Status</label>
					<select class="form-select" id="petition_setup_active" name="active" required>
						<option value="N/A" selected disabled>Select Status</option>
						<?php if (isset($activeData)): foreach ($activeData as $active): ?>
							<option value="<?=$active->num?>" <?=isset($petitionSetupRow) && (int) $petitionSetupRow->active === (int) $active->num ? 'selected' : ''?>><?=$active->name?></option>
						<?php endforeach; endif; ?>
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
