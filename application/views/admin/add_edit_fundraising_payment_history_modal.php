<?php
    $isEdit = isset($fundraisingRow) && is_object($fundraisingRow);
    $existingPaymentHistoryRow = $isEdit ? $fundraisingRow : null;
    $existingName = ($existingPaymentHistoryRow && isset($existingPaymentHistoryRow->name)) ? $existingPaymentHistoryRow->name : '';
    $modalTitle = $isEdit ? 'Edit ' . (!empty($existingName) ? $existingName : 'Fundraising Campaign') : 'Add Fundraising Campaign';
    $fundraisingId = !empty($fundraising_id) ? $fundraising_id : (($existingPaymentHistoryRow && isset($existingPaymentHistoryRow->fundraising_id)) ? $existingPaymentHistoryRow->fundraising_id : generate_uuid());
    $billAmount = ($existingPaymentHistoryRow && isset($existingPaymentHistoryRow->bill_amount)) ? (float) $existingPaymentHistoryRow->bill_amount : 0;
?>

<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?=$modalTitle?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

		<?php if ($user_type_id != GlobalModel::MEMBER_TYPE): ?>
        	<form action="<?=base_url('add-fundraising-payment-history')?>" method="POST">
		<?php endif; ?>
            <div class="modal-body">
                <input type="hidden" name="universal_id" value="<?=$fundraisingId?>">
				<input type="hidden" name="customer_id" value="<?=$customerDBSettingRow->customer_id?>">
				<input type="hidden" name="module_id" value="17602075390">
				<input type="hidden" name="currency_id" value="1543602048">
				<input type="hidden" id="payment_history_id" name="payment_history_id" value="<?=generate_uuid()?>">
				<?php if ($user_type_id == GlobalModel::MEMBER_TYPE): ?>
                	<input type="hidden" name="user_id" value="<?=$user_id?>">
				<?php else: ?>
               		<select class="form-select mb-3" id="user_id" name="user_id">
						<option value="" disabled selected>Select Member</option>
						<?php if (isset($memberData)): foreach ($memberData as $member): ?>
							<option value="<?=$member->user_id ?? ''?>"><?=$member->full_legal_name ?? ''?> (<?=$member->email ?? ''?>)</option>
						<?php endforeach; endif; ?>
					</select>
				<?php endif; ?>

                <div class="row g-3 mt-1">
                    <div class="col-md-12">
                        <label class="form-label" for="fundraising_bill_amount">Amounts</label>
                        <input class="form-control" id="fundraising_bill_amount" name="bill_amount" type="number" step="0.01" min="0" placeholder="<?=number_format($billAmount, 2, '.', '')?>">
                    </div>
                </div>
				<?php if (in_array($user_type_id, array(GlobalModel::ADMIN_TYPE, GlobalModel::CLUB_ADMIN_TYPE))): ?>
					<div class="row g-3 mt-1">
						<div class="col-md-6">
							<label class="form-label" for="payment_method_id">Payment Method</label>
							<select class="form-select" id="payment_method_id" name="payment_method_id" required>
								<option value="" disabled selected>Select Payment Method</option>
								<?php if (isset($paymentMethodData)): foreach ($paymentMethodData as $paymentMethod): ?>
									<option value="<?=$paymentMethod->payment_method_id ?? ''?>"><?=$paymentMethod->name ?? ''?></option>
								<?php endforeach; endif; ?>
							</select>
						</div>
						<div class="col-md-6">
							<label class="form-label" for="payment_status_id">Payment Status</label>
							<select class="form-select" id="payment_status_id" name="payment_status_id" required>
								<option value="" disabled selected>Select Payment Status</option>
								<?php if (isset($paymentStatusData)): foreach ($paymentStatusData as $paymentStatus): ?>
									<option value="<?=$paymentStatus->payment_status_id ?? ''?>"><?=$paymentStatus->name ?? ''?></option>
								<?php endforeach; endif; ?>
							</select>
						</div>
					</div>
				<?php endif; ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<?php if (in_array($user_type_id, array(GlobalModel::MEMBER_TYPE))): ?>
                	<button type="submit" class="btn btn-primary" onclick="payModal('<?=$userRow->user_id?>', (document.getElementById('payment_history_id').value), '<?=$userRow->phone_number?>', '<?=$fundraisingId?>-' + (document.getElementById('fundraising_bill_amount').value) + '-17602075390')" hidden>Make payment now</button>
					<button id="pay_via_mpesa_button" type="button" class="btn btn-primary" onclick="payViaMpesaModal('<?=$user_id?>', (document.getElementById('payment_history_id').value), '<?=$userRow->phone_number?>', document.getElementById('fundraising_bill_amount').value, '<?=$fundraisingId?>')">Pay Via M-Pesa</button>
				<?php else: ?>
               		<button type="submit" class="btn btn-primary">Add Payment</button>
				<?php endif; ?>
            </div>
		<?php if ($user_type_id != GlobalModel::MEMBER_TYPE): ?>
        	</form>
		<?php endif; ?>
    </div>
</div>
