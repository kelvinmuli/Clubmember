<?php
/**
 * Expected variables:
 * - bool $isEdit
 * - string $actionUrl
 * - string $modalTitle
 * - string $submitLabel
 * - string $customerId
 * - object|null $customerRow
 * - array $customerTypeData
 * - array $countryData
 * - array $customerStatusData
 * - array $countyData
 * - array $timePeriodDataArray
 */

$customerRow = $customerRow ?? null;

$val = function (string $field, string $default = '') use ($customerRow): string {
	if (!$customerRow) {
		return $default;
	}
	return isset($customerRow->{$field}) && $customerRow->{$field} !== null ? (string)$customerRow->{$field} : $default;
};

$selected = function (string $field, $optionValue) use ($customerRow): string {
	if (!$customerRow || !isset($customerRow->{$field})) {
		return '';
	}
	return ((string)$customerRow->{$field} === (string)$optionValue) ? 'selected' : '';
};
?>

<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?= htmlspecialchars($modalTitle, ENT_QUOTES, 'UTF-8') ?></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<form action="<?= htmlspecialchars($actionUrl, ENT_QUOTES, 'UTF-8') ?>" method="post" enctype="multipart/form-data" class="modal-content">
			<input id="customer_id" name="customer_id" type="text" value="<?= htmlspecialchars($customerId, ENT_QUOTES, 'UTF-8') ?>" hidden>

			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="mb-3">
							<label for="edit-logo" class="form-label">Logo (optional)</label>
							<input type="file" name="logo" id="edit-logo" class="form-control btn-pill">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mb-3">
							<label for="full_legal_name" class="form-label">Name</label>
							<input id="full_legal_name" name="full_legal_name" type="text" class="form-control btn-pill" value="<?= htmlspecialchars($val('full_legal_name'), ENT_QUOTES, 'UTF-8') ?>" required>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mb-3">
							<label for="short_name" class="form-label">Short Name</label>
							<input id="short_name" name="short_name" type="text" class="form-control btn-pill" value="<?= htmlspecialchars($val('short_name'), ENT_QUOTES, 'UTF-8') ?>" required>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mb-3">
							<label for="edit-email" class="form-label">Email Address</label>
							<input type="email" class="form-control btn-pill" name="email" id="edit-email" value="<?= htmlspecialchars($val('email'), ENT_QUOTES, 'UTF-8') ?>" required>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="mb-3">
							<label for="customer_type_id" class="form-label">Customer Type</label>
							<select id="customer_type_id" name="customer_type_id" class="form-select btn-pill">
								<option selected disabled>Select Customer Type</option>
								<?php if (isset($customerTypeData)) : foreach ($customerTypeData as $data) : ?>
									<option value="<?= htmlspecialchars($data->customer_type_id, ENT_QUOTES, 'UTF-8') ?>" <?= $selected('customer_type_id', $data->customer_type_id) ?>><?= htmlspecialchars($data->name, ENT_QUOTES, 'UTF-8') ?></option>
								<?php endforeach; endif; ?>
							</select>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="mb-3">
							<label for="time_period_id" class="form-label">Subscription Period</label>
							<select id="time_period_id" name="time_period_id" class="form-select btn-pill">
								<option selected disabled>Select Subscription Period</option>
								<?php if (isset($timePeriodDataArray)) : foreach ($timePeriodDataArray as $period_id => $dataArray) : ?>
									<optgroup label="<?= htmlspecialchars(get_table('m_period', 'period_id', $period_id, 'name'), ENT_QUOTES, 'UTF-8') ?>">
										<?php foreach ($dataArray as $data) : ?>
											<option value="<?= htmlspecialchars($data->time_period_id, ENT_QUOTES, 'UTF-8') ?>" <?= $selected('time_period_id', $data->time_period_id) ?>><?= htmlspecialchars($data->name, ENT_QUOTES, 'UTF-8') ?></option>
										<?php endforeach; ?>
									</optgroup>
								<?php endforeach; endif; ?>
							</select>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="mb-3">
							<label for="phone_number" class="form-label">Telephone Number</label>
							<input id="phone_number" name="phone_number" type="text" class="form-control btn-pill" value="<?= htmlspecialchars($val('phone_number'), ENT_QUOTES, 'UTF-8') ?>">
						</div>
					</div>

					<div class="col-lg-6">
						<div class="mb-3">
							<label for="physical_address" class="form-label">Physical Address</label>
							<input id="physical_address" name="physical_address" type="text" class="form-control btn-pill" value="<?= htmlspecialchars($val('physical_address'), ENT_QUOTES, 'UTF-8') ?>">
						</div>
					</div>

					<div class="col-lg-6">
						<div class="mb-3">
							<label for="postal_address" class="form-label">Postal Address</label>
							<input id="postal_address" name="postal_address" type="text" class="form-control btn-pill" value="<?= htmlspecialchars($val('postal_address'), ENT_QUOTES, 'UTF-8') ?>">
						</div>
					</div>

					<div class="col-lg-6">
						<div class="mb-3">
							<label for="town_id" class="form-label">Town</label>
							<input id="town_id" name="town_id" type="text" class="form-control btn-pill" value="<?= htmlspecialchars($val('town_id'), ENT_QUOTES, 'UTF-8') ?>">
						</div>
					</div>

					<div class="col-lg-6">
						<div class="mb-3">
							<label for="reg_no" class="form-label">Registration Number</label>
							<input id="reg_no" name="reg_no" type="text" class="form-control btn-pill" value="<?= htmlspecialchars($val('reg_no'), ENT_QUOTES, 'UTF-8') ?>">
						</div>
					</div>

					<div class="col-lg-6">
						<div class="mb-3">
							<label for="country_id" class="form-label">Country</label>
							<select id="country_id" name="country_id" class="form-select btn-pill">
								<option selected disabled>Select Country</option>
								<?php if (isset($countryData)) : foreach ($countryData as $data) : ?>
									<option value="<?= htmlspecialchars($data->country_id, ENT_QUOTES, 'UTF-8') ?>" <?= $selected('country_id', $data->country_id) ?>><?= htmlspecialchars($data->name, ENT_QUOTES, 'UTF-8') ?></option>
								<?php endforeach; endif; ?>
							</select>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="mb-3">
							<label for="county_id" class="form-label">County</label>
							<select id="county_id" name="county_id" class="form-select btn-pill">
								<option selected disabled>Select County</option>
								<?php if (isset($countyData)) : foreach ($countyData as $data) : ?>
									<option value="<?= htmlspecialchars($data->county_id, ENT_QUOTES, 'UTF-8') ?>" <?= $selected('county_id', $data->county_id) ?>><?= htmlspecialchars($data->name, ENT_QUOTES, 'UTF-8') ?></option>
								<?php endforeach; endif; ?>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="mb-3">
							<label for="edit-agreement" class="form-label">Agreement (optional)</label>
							<input type="file" name="agreement" id="edit-agreement" class="form-control btn-pill">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mb-3">
							<label for="customer_status_id" class="form-label">Customer Status</label>
							<select id="customer_status_id" name="customer_status_id" class="form-select btn-pill">
								<option selected disabled>Select Customer Status</option>
								<?php if (isset($customerStatusData)) : foreach ($customerStatusData as $data) : ?>
									<option value="<?= htmlspecialchars($data->customer_status_id, ENT_QUOTES, 'UTF-8') ?>" <?= $selected('customer_status_id', $data->customer_status_id) ?>><?= htmlspecialchars($data->name, ENT_QUOTES, 'UTF-8') ?></option>
								<?php endforeach; endif; ?>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
				<button type="submit" class="btn btn-primary ms-auto btn-pill">
					<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
					<?= htmlspecialchars($submitLabel, ENT_QUOTES, 'UTF-8') ?>
				</button>
			</div>
		</form>
	</div>
</div>
