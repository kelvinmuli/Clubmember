<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<?php
			$isPaid = ($paymentHistoryRow->payment_status_id ?? '') === '1732371146921';
			$statusLabel = $isPaid ? 'Paid' : 'Unpaid';
			$statusClass = $isPaid ? 'bg-success text-white' : 'bg-warning text-dark';
		?>
		<div class="modal-header">
			<h5 class="modal-title">Invoice Receipt</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		
		<iframe id="subscription-receipt-frame" src="<?= site_url('subscription-receipt-content/' . $userRow->user_id . '/' . $paymentHistoryRow->payment_history_id) ?>" class="w-100 border-0" style="min-height: 700px;" title="Subscription Receipt"></iframe>
	</div>
</div>
