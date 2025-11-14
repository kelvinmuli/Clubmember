<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Subscription Receipt</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
		<div class="card-lg" id="subscription-receipt-content">
			<div class="card-body">
				<div class="d-flex justify-content-end mb-3">
					<button type="button" class="btn btn-outline-primary" onclick="printReceipt('Subscription Receipt', 'subscription-receipt-content')">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M7 9v-4a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg> Print
					</button>
				</div>

				<div class="row">
					<div class="col-6">
					<p class="h3">Customer</p>
					<address>
						<?php $customer = get_table('customer', 'customer_id', $customerDBSettingRow->customer_id); ?>
						<?= $customer->full_legal_name ?><br />
						<?= $customer->email ?>
					</address>
					</div>
					<div class="col-6 text-end">
					<p class="h3">Client</p>
					<address>
						<?php $user = get_table($customerDBSettingRow->database_name.'.user', 'user_id', $paymentHistoryRow->user_id); ?>
						<?= $user->full_legal_name ?><br />
						<?= $user->email ?>
					</address>
					</div>
					<div class="col-12 my-5">
					<h1>Invoice INV/<?=substr($paymentHistoryRow->user_id, 0, 3)?>/1</h1>
					</div>
				</div>
				<table class="table table-transparent table-responsive">
					<thead>
					<tr>
						<th class="text-center" style="width: 1%"></th>
						<th>Product</th>
						<th class="text-center" style="width: 1%">Qnt</th>
						<th class="text-end" style="width: 1%">Unit</th>
						<th class="text-end" style="width: 1%">Amount (KES)</th>
					</tr>
					</thead>
					<tr>
					<td class="text-center">1</td>
					<td>
						<div class="text-secondary strong">Corporate Subscription</div>
					</td>
					<td class="text-center">1</td>
					<td class="text-end"><?='KES ' . number_format($paymentHistoryRow->paid_amount, 2)?></td>
					<td class="text-end"><?='KES ' . number_format($paymentHistoryRow->paid_amount, 2)?></td>
					</tr>
					<tr>
					<td colspan="4" class="strong text-end">Subtotal (KES)</td>
					<td class="text-end"><?='KES ' . number_format($paymentHistoryRow->paid_amount, 2)?></td>
					</tr>
					<tr>
					<td colspan="4" class="font-weight-bold text-uppercase text-end">Total Due (KES)</td>
					<td class="font-weight-bold text-end"><?='KES ' . number_format($paymentHistoryRow->paid_amount, 2)?></td>
					</tr>
				</table>
				<p class="text-secondary text-center mt-5">Thank you very much for doing business with us. We look forward to working with you again!</p>
			</div>
		</div>
	</div>
</div>
