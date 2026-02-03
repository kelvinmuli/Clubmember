<?php
/**
 * Expected variables:
 * - $mode ('add'|'edit')
 * - $userRow
 * - $userTypeRow
 * - $customerDBSettingRow
 * - $active
 * - $customer_db_setting_id
 * - $membership_type_id
 * - $header
 * - $genderData
 * - $countryData
 * - $titleData
 * - $membershipTypeRow
 * - $memberFeeTypeData
 */

$mode = isset($mode) ? $mode : 'edit';
$isAdd = $mode === 'add';
$userTypeName = isset($userTypeRow) && isset($userTypeRow->name) ? $userTypeRow->name : 'User';
$membershipTypeName = isset($membershipTypeRow) && isset($membershipTypeRow->name) ? $membershipTypeRow->name : '';
$customerName = isset($customerDBSettingRow) && isset($customerDBSettingRow->customer_id) ? get_table('customer', 'customer_id', $customerDBSettingRow->customer_id, 'full_legal_name') : '';
$formAction = $isAdd ? base_url('add-user') : base_url('edit-user');

if (!isset($userRow) || empty($userRow)) {
	$userRow = (object) array(
		'user_id' => '',
		'user_type_id' => '',
		'user_option_id' => '1752581178334',
		'title_id' => '',
		'full_legal_name' => '',
		'phone_number' => '',
		'mobile_number' => '',
		'gender_id' => '',
		'birth' => '',
		'email' => '',
		'id_no' => '',
		'residential_address' => '',
		'postal_address' => '',
		'postal_code' => '',
		'street_name' => '',
		'country_id' => '',
		'town_id' => '',
		'joining_at' => '',
		'membership_fee_type_id' => '',
		'profession' => '',
		'membership_no' => '',
		'sub_reference_no' => '',
		'contact_name' => '',
		'contact_phone_no' => '',
		'remark' => '',
	);
}
?>
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">
				<?php if ($isAdd): ?>
					Add New <?=$membershipTypeName?> <?=$userTypeName?> To <?=$customerName?>
				<?php else: ?>
					Edit User Profile
				<?php endif; ?>
			</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<form action="<?=$formAction?>" method="POST" enctype="multipart/form-data">
			<input id="user_id" name="user_id" type="text" value="<?=$userRow->user_id?>" hidden>
			<input id="user_type_id" name="user_type_id" type="text" value="<?=$userRow->user_type_id ?? ''?>" hidden>
			<input id="user_option_id" name="user_option_id" type="text" value="<?=$userRow->user_option_id ?? '1752581178334'?>" hidden>
			<?php if ($isAdd): ?>
				<input id="membership_type_id" name="membership_type_id" type="text" value="<?=$membership_type_id?>" hidden>
				<input id="active" name="active" type="text" value="<?=isset($active) ? $active : 1?>" hidden>
			<?php  endif; ?>
			<input id="customer_db_setting_id" name="customer_db_setting_id" type="text" value="<?=$customer_db_setting_id?>" hidden>
			<input id="header" name="header" type="text" value="<?=$header?>" hidden>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="mb-3">
							<label class="form-label">Photo</label>
							<input id="url" name="url" type="file" class="form-control btn-pill" placeholder="Upload Your Photo">
						</div>
					</div>
					<div class="col-lg-6" <?=$membership_type_id == '1755816508873' ? 'hidden' : ''?>>
						<div class="mb-3">
							<label class="form-label">Title</label>
							<select id="title_id" name="title_id" class="form-select btn-pill" <?=$membership_type_id == '1755816508873' ? '' : 'required'?>>
								<option selected disabled>Select Title</option>
								<?php if (isset($titleData)): foreach ($titleData as $data): ?>
									<option value="<?=$data->title_id?>" <?=$userRow->title_id == $data->title_id ? 'selected' : ''?>><?=$data->name?></option>
								<?php endforeach; endif; ?>
							</select>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mb-3">
							<label class="form-label"><?=$membership_type_id == '1755816508873' ? $membershipTypeName : 'Full Legal'?> Name*</label>
							<input id="full_legal_name" name="full_legal_name" type="text" class="form-control btn-pill" placeholder="Your <?=$membership_type_id == '1755816508873' ? $membershipTypeName : 'Full Legal'?> Name" value="<?=$userRow->full_legal_name?>" required>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mb-3">
							<label class="form-label"><?=$isAdd ? 'Phone Number' : 'Phone Number'?>*</label>
							<input id="phone_number" name="phone_number" type="number" class="form-control btn-pill" placeholder="Enter your phone number" value="<?=$userRow->phone_number?>" <?=$isAdd ? 'required' : ''?>>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mb-3">
							<label class="form-label">Mobile Number*</label>
							<input id="mobile_number" name="mobile_number" type="number" class="form-control btn-pill" placeholder="Enter your mobile number" value="<?=$userRow->mobile_number?>" required>
						</div>
					</div>
					<div class="col-lg-6" <?=$membership_type_id == '1755816508873' ? 'hidden' : ''?>>
						<div class="mb-3">
							<label class="form-label">Gender</label>
							<select id="gender_id" name="gender_id" class="form-select btn-pill" <?=$membership_type_id == '1755816508873' ? '' : 'required'?>>
								<option selected disabled>Select Gender</option>
								<?php if (isset($genderData)): foreach ($genderData as $data): ?>
									<option value="<?=$data->gender_id?>" <?=$userRow->gender_id == $data->gender_id ? 'selected' : ''?>><?=$data->name?></option>
								<?php endforeach; endif; ?>
							</select>
						</div>
					</div>
					<div class="col-lg-6" <?=$membership_type_id == '1755816508873' ? 'hidden' : ''?>>
						<div class="mb-3">
							<label class="form-label">Date of Birth</label>
							<input id="birth" name="birth" type="date" class="form-control btn-pill" value="<?=$userRow->birth?>" <?=$isAdd && $membership_type_id != '1755816508873' ? 'required' : ''?>>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mb-3">
							<label class="form-label">Email Address</label>
							<input id="email" name="email" type="email" class="form-control btn-pill" placeholder="Enter your email address" value="<?=$userRow->email?>">
						</div>
					</div>
					<div class="col-lg-6" <?=$membership_type_id == '1755816508873' ? 'hidden' : ''?>>
						<div class="mb-3">
							<label class="form-label">ID Number / Passport Number</label>
							<input id="id_no" name="id_no" type="number" class="form-control btn-pill" placeholder="Enter your id number" value="<?=$userRow->id_no?>">
						</div>
					</div>

					<?php if (!in_array($userRow->user_type_id, array('4734656482', '4534654653'))): ?>
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="form-label">Residential Address</label>
								<input id="residential_address" name="residential_address" type="text" class="form-control btn-pill" placeholder="Enter Residential Address" value="<?=$userRow->residential_address?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="form-label">Postal Address</label>
								<input id="postal_address" name="postal_address" type="text" class="form-control btn-pill" placeholder="Enter Postal Address" value="<?=$userRow->postal_address?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="form-label">Postal Code</label>
								<input id="postal_code" name="postal_code" type="text" class="form-control btn-pill" placeholder="Enter Postal Code" value="<?=$userRow->postal_code?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="form-label">Street Name</label>
								<input id="street_name" name="street_name" type="text" class="form-control btn-pill" placeholder="Enter Street Name" value="<?=$userRow->street_name?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="form-label">Country</label>
								<select id="country_id" name="country_id" class="form-select btn-pill" required>
									<option selected disabled>Select Country</option>
									<?php if (isset($countryData)): foreach ($countryData as $data): ?>
										<option value="<?=$data->country_id?>" <?=$data->country_id == $userRow->country_id ? 'selected' : ''?>><?=$data->name?></option>
									<?php endforeach; endif; ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6" <?=$membership_type_id == '1755816508873' ? 'hidden' : ''?>>
							<div class="mb-3">
								<label class="form-label">Town</label>
								<input id="town_id" name="town_id" type="text" class="form-control btn-pill" placeholder="Enter Town" value="<?=$userRow->town_id?>">
							</div>
						</div>
						<div class="col-lg-6" <?=$membership_type_id == '1755816508873' ? 'hidden' : ''?>>
							<div class="mb-3">
								<label class="form-label">Joining Date</label>
								<input id="joining_at" name="joining_at" type="date" class="form-control btn-pill" placeholder="Enter Joining Date" value="<?=$userRow->joining_at?>">
							</div>
						</div>
						<div class="col-lg-6" <?=$membership_type_id == '1755816508873' ? 'hidden' : ''?>>
							<div class="mb-3">
								<label class="form-label">Membership Type <?=$membershipTypeRow->name ?? ''?></label>
								<select id="membership_fee_type_id" name="membership_fee_type_id" class="form-select btn-pill" <?=$membership_type_id == '1755816508873' ? '' : 'required'?>>
									<option selected disabled>Select Membership Type <?=$membershipTypeRow->name ?? ''?></option>
									<?php if (isset($memberFeeTypeData)): foreach ($memberFeeTypeData as $data): ?>
										<option value="<?=$data->membership_fee_type_id?>" <?=$data->membership_fee_type_id == $userRow->membership_fee_type_id ? 'selected' : ''?>><?=$data->name?>-<?=$data->year?>-<?=$data->amount?></option>
									<?php endforeach; endif; ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="form-label"><?=$membership_type_id == '1755816508873' ? 'Type Of Business' : 'Profession'?></label>
								<input id="profession" name="profession" type="text" class="form-control btn-pill" placeholder="Enter <?=$membership_type_id == '1755816508873' ? 'Type Of Business' : 'Profession'?>" value="<?=$userRow->profession?>">
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if (in_array($userRow->user_type_id, array('4734656482', '4534654653'))): ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="mb-3">
								<label class="form-label">Password</label>
								<input id="password" name="password" type="password" class="form-control btn-pill" placeholder="Enter Password">
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if (!in_array($userRow->user_type_id, array('4734656482', '4534654653'))): ?>
				<div class="modal-body" <?=$membership_type_id == '1755816508873' ? 'hidden' : ''?>>
					<div class="row">
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="form-label">Membership No.</label>
								<input id="membership_no" name="membership_no" type="text" class="form-control btn-pill" placeholder="Enter Membership No." value="<?=$userRow->membership_no?>">
							</div>
						</div>
						<div class="col-lg-6" <?=$membership_type_id == '1755816508873' ? 'hidden' : ''?>>
							<div class="mb-3">
								<label class="form-label">LR. No.</label>
								<input id="sub_reference_no" name="sub_reference_no" type="text" class="form-control btn-pill" placeholder="Enter LR. No." value="<?=$userRow->sub_reference_no?>">
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="mb-3">
							<label class="form-label">Contact Name</label>
							<input id="contact_name" name="contact_name" type="text" class="form-control btn-pill" placeholder="Enter Contact Name" value="<?=$userRow->contact_name?>">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mb-3">
							<label class="form-label">Contact No.</label>
							<input id="contact_phone_no" name="contact_phone_no" type="number" class="form-control btn-pill" placeholder="Enter Contact No." value="<?=$userRow->contact_phone_no?>">
						</div>
					</div>
				</div>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea id="remark" name="remark" type="text" class="form-control" placeholder="Enter Notes"><?=$userRow->remark?></textarea>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<a href="#" class="btn btn-link link-secondary " data-bs-dismiss="modal">Cancel</a>
				<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
					<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
					<?=$isAdd ? 'Add '.$userTypeName : 'Save Changes'?>
				</button>
			</div>
		</form>
	</div>
</div>
