<?php
	$isEdit = isset($petitionSignatureRow);
	$modalTitle = $isEdit ? 'Edit ' . ($petitionSignatureRow->full_legal_name ?? 'Petition Signature') : 'Add Petition Signature';
	$signedAtValue = '';
	if ($isEdit && !empty($petitionSignatureRow->signed_at)) {
		$signedAtValue = date('Y-m-d\TH:i', strtotime($petitionSignatureRow->signed_at));
	}
	$consentValue = $isEdit ? (int) ($petitionSignatureRow->consent ?? 0) : 1;
	$noOfUnitValue = $isEdit ? (int) ($petitionSignatureRow->no_of_unit ?? 0) : 0;
	$petitionSignatureId = $isEdit ? $petitionSignatureRow->petition_signature_id : $petition_signature_id;
	$petitionSetupId = $isEdit ? $petitionSignatureRow->petition_setup_id : $petition_setup_id;
	$petitionId = $isEdit ? ($petitionSignatureRow->petition_id ?? $petition_id) : $petition_id;
	$signatureMethodData = $signatureMethodData ?? [];
	$activeData = $activeData ?? [];
	$existingSignatureUrl = $isEdit ? ($petitionSignatureRow->signature_url ?? '') : '';
	$signaturePreviewUrl = '';
	if (!empty($existingSignatureUrl)) {
		$signaturePreviewUrl = filter_var($existingSignatureUrl, FILTER_VALIDATE_URL)
			? $existingSignatureUrl
			: base_url($existingSignatureUrl);
	}
	$uploadMethodId = '';
	$drawMethodId = '';
	foreach ($signatureMethodData as $signatureMethod) {
		$methodName = strtolower($signatureMethod->name ?? '');
		if ($uploadMethodId === '' && (strpos($methodName, 'upload') !== false || strpos($methodName, 'file') !== false)) {
			$uploadMethodId = (string) $signatureMethod->signature_method_id;
		}
		if ($drawMethodId === '' && (strpos($methodName, 'draw') !== false || strpos($methodName, 'pad') !== false || strpos($methodName, 'digital') !== false)) {
			$drawMethodId = (string) $signatureMethod->signature_method_id;
		}
	}
	if ($uploadMethodId === '') {
		$uploadMethodId = '1761598225657';
	}
	if ($drawMethodId === '') {
		$drawMethodId = '1761598307304';
	}
	
?>

<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?=$modalTitle?></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<form action="<?=$isEdit ? 'edit-petition-signature' : 'add-petition-signature'?>" method="POST" enctype="multipart/form-data" id="petition-signature-form">
			<div class="modal-body">
				<input type="hidden" name="petition_signature_id" value="<?=$petitionSignatureId?>">
				<input type="hidden" name="petition_setup_id" value="<?=$petitionSetupId?>">
				<input type="hidden" name="petition_id" value="<?=$petitionId?>">
				<input type="hidden" name="signature_draw_data" id="petition_signature_draw_data" value="">
				<input type="hidden" id="petition_signature_upload_method_id" value="<?=$uploadMethodId?>">
				<input type="hidden" id="petition_signature_draw_method_id" value="<?=$drawMethodId?>">
				<input type="hidden" id="user_id" name="user_id" value="<?=$isEdit ? $petitionSignatureRow->user_id : $user_id?>">
				<input type="hidden" id="active" name="active" value="1">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="petition_full_legal_name" class="form-label">Full Legal Name</label>
							<input type="text" class="form-control" id="petition_full_legal_name" value="<?=$isEdit ? (get_table($customerDBSettingRow->database_name.'.user', 'user_id', $petitionSignatureRow->user_id, 'full_legal_name') ?? '') : $full_legal_name?>" disabled required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="petition_phone_number" class="form-label">Phone Number</label>
							<input type="text" class="form-control" id="petition_phone_number" value="<?=$isEdit ? (get_table($customerDBSettingRow->database_name.'.user', 'user_id', $petitionSignatureRow->user_id, 'phone_number') ?? '') : $phone_number?>" disabled required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="petition_email" class="form-label">Email</label>
							<input type="text" class="form-control" id="petition_email" value="<?=$isEdit ? (get_table($customerDBSettingRow->database_name.'.user', 'user_id', $petitionSignatureRow->user_id, 'email') ?? '') : $email?>" disabled required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="petition_street_name" class="form-label">Street Name</label>
							<input type="text" class="form-control" id="petition_street_name" value="<?=$isEdit ? (get_table($customerDBSettingRow->database_name.'.user', 'user_id', $petitionSignatureRow->user_id, 'street_name') ?? '') : $street_name?>" required>
						</div>
					</div>
				</div>
				<div class="row" hidden>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="petition_no_of_unit" class="form-label">Number of Units</label>
							<input type="number" class="form-control" id="petition_no_of_unit" name="no_of_unit" min="0" value="<?=$noOfUnitValue ?? 0?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="petition_signed_at" class="form-label">Signed At</label>
							<input type="datetime-local" class="form-control" id="petition_signed_at" name="signed_at" value="<?=$signedAtValue ?? '0000-00-00'?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="petition_signature_method_id" class="form-label">Signature Method</label>
							<select class="form-select" id="petition_signature_method_id" name="signature_method_id">
								<option value="" disabled <?=(!$isEdit || empty($petitionSignatureRow->signature_method_id)) ? 'selected' : ''?>>Select Signature Method</option>
								<!-- 1761598225657 -> Upload Signature -->
								<!-- 1761598307304 -> Draw Signature -->
								<?php foreach ($signatureMethodData as $signatureMethod): ?>
									<option value="<?=$signatureMethod->signature_method_id?>" <?=($isEdit && isset($petitionSignatureRow->signature_method_id) && $petitionSignatureRow->signature_method_id == $signatureMethod->signature_method_id) ? 'selected' : ''?>><?=$signatureMethod->name?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3 method-field" id="petition_signature_upload_section">
							<label for="petition_signature_file" class="form-label">Upload Signature</label>
							<input type="file" class="form-control" id="petition_signature_file" name="signature_file" accept="image/png,image/jpeg">
							<small class="form-text text-muted">Upload a clear image of the signature (PNG or JPG).</small>
						</div>
					</div>
				</div>
				<div class="mb-3 method-field" id="petition_signature_draw_section">
					<label class="form-label">Draw Signature</label>
					<canvas id="petition_signature_canvas" class="border border-secondary rounded w-100" style="height:200px; touch-action: none;"></canvas>
					<div class="pt-2 d-flex gap-2">
						<button type="button" class="btn btn-outline-secondary btn-sm" id="petition_signature_clear_canvas">Clear</button>
					</div>
					<small class="form-text text-muted">Sign inside the box using your mouse or finger.</small>
				</div>
				<div class="mb-3 method-field" id="petition_signature_url_section" hidden>
					<label for="petition_signature_url" class="form-label">Signature URL</label>
					<input type="url" class="form-control" id="petition_signature_url" value="<?=$existingSignatureUrl?>" placeholder="https://example.com/signature.png">
					<small class="form-text text-muted">Paste a publicly accessible URL if the signature is stored elsewhere.</small>
				</div>
				<?php if (!empty($signaturePreviewUrl)): ?>
					<div class="mb-3" id="petition_signature_preview_wrapper">
						<label class="form-label">Current Signature</label>
						<div class="border rounded p-2 bg-light text-center">
							<img src="<?=$signaturePreviewUrl?>" alt="Existing signature" class="img-fluid" style="max-height:200px;">
						</div>
					</div>
				<?php endif; ?>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="petition_consent" class="form-label">Consent</label>
							<select class="form-select" id="petition_consent" name="consent">
								<option value="N/A" selected disabled>Select Consent</option>
								<option value="1" <?=$consentValue === 1 ? 'selected' : ''?>>Yes</option>
								<option value="0" <?=$consentValue !== 1 ? 'selected' : ''?>>No</option>
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
