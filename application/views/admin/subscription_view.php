<?php $paymentStatusName = empty($paymentStatusId) ? 'N/A' : get_table('m_payment_status', 'payment_status_id', $paymentStatusId, 'name'); ?>
<div class="page-wrapper">
    <div class="container-fluid">			
		<!-- Page title -->
		<div class="page-header d-print-none">
            <div class="row align-items-center">
				<div class="col">
					<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						<li class="breadcrumb-item"><a href="<?=base_url()?>">Website</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url('home')?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#"><?=$moduleMenu->name?></a></li>
						<li class="breadcrumb-item"><a href="#"><?=$paymentStatusName?></a></li>
					</ol>
              	</div>

				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">
						<?php if ($inputUserRight): ?>
							<a class="btn btn-success d-none d-sm-inline-block btn-pill" onclick="addSubscriptionModal()">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add <?=$moduleMenu->name?>
							</a>
							<a class="btn btn-success d-sm-none btn-icon btn-pill" onclick="addSubscriptionModal()" aria-label="Add <?=$moduleMenu->name?>">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
							</a>

							<a class="btn btn-success d-none d-sm-inline-block btn-pill" onclick="addMembershipFeeType()">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add Subscription Fee for Year
							</a>
							<a class="btn btn-success d-sm-none btn-icon btn-pill" onclick="addMembershipFeeType()" aria-label="Add Membership Fee Type">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
							</a>
						<?php endif; ?>
					</div>
              	</div>
            </div>
        </div>
    </div>

	<div class="page-body">
		<div class="container-fluid">
			<div class="row row-deck row-cards">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?=$paymentStatusName.' '.$moduleMenu->name?></h3>
							<div class="col-auto ms-auto d-print-none">
								<div class="btn-list">		
										
								</div>
							</div>
						</div>

						<div class="card-body border-bottom py-3">
							<div class="table-responsive">
								<table id="subscription-datatable" class="table table-vcenter text-nowrap">
									<thead>
										<tr>
											<th class="w-1">#</th>											
											<th>Full Legal Name</th>
											<th>Membership Fee Type</th>
											<th>Due Date</th>
											<th>Payment Date</th>
											<th>Currency</th>
											<th>Amount</th>
											<th>Status</th>
											<th>Created At</th>	
											<?php if ($approveUserRight): ?>
												<th>Actions</th>
											<?php endif; ?>
										</tr>
									</thead>
									<tbody>
										<?php $s = 0; if (isset($subscriptionData)): foreach($subscriptionData as $data): $paymentHistoryRow = get_table($customerDBSettingRow->database_name.'.payment_history', 'universal_id', $data->subscription_id); ?>
											<tr>
												<td class="w-1"><?=++$s?>.</td>
												<td><?= get_table($customerDBSettingRow->database_name.'.user', 'user_id', $data->user_id, 'full_legal_name')?></td>
												<td><?= get_table($customerDBSettingRow->database_name.'.membership_fee_type', 'membership_fee_type_id', $data->membership_fee_type_id, 'name')?></td>
												<td><?= date('d M Y', strtotime($data->due_at)) ?></td>
												<td><?= date('d M Y', strtotime($data->payment_at)) ?></td>
												<td><?= get_table('m_currency', 'currency_id', $data->currency_id, 'sign')?></td>
												<td><?= $data->amount ?></td>
												<td><?= get_table('m_payment_status', 'payment_status_id', $data->payment_status_id, 'name')?></td>
												<td><?= date('d M Y', strtotime($data->created_at)) ?></td>
												<?php if ($approveUserRight): ?>
													<td>
														<span class="dropdown">
															<button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
															<div class="dropdown-menu dropdown-menu-end">
																<a href="#" class="dropdown-item" onclick="sendPaymentReminder('<?=$data->subscription_id?>', '<?=$data->payment_history_id?>')">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Send Payment Reminder
																</a>
																<?php if ($data->payment_status_id == '1732351802222'): ?>
																	<a href="#" class="dropdown-item" onclick="approveSubscriptionModal('<?=$data->subscription_id?>', '<?=$data->payment_history_id?>')">
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg> Approve/View
																	</a>
																<?php endif; ?>
															</div>
														</span>
													</td>
												<?php endif; ?>
											</tr>
										<?php endforeach; endif; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			loadDatatable('subscription-datatable');
		});

		function addMembershipFeeType() {
			$.ajax({
				url: base_url + "add-membership-fee-type-modal",
				success: function(response) {
					document.getElementById('modal-view-add-edit-remove-print').innerHTML = response;
					$('#modal-view-add-edit-remove-print').modal('show');
				}
			});
		}

		function approveSubscriptionModal(subscription_id, payment_history_id) {
			$.ajax({
				url: base_url + "approve-subscription-modal/" + subscription_id + '/' + payment_history_id,
				success: function(response) {
					document.getElementById('modal-view-add-edit-remove-print').innerHTML = response;
					$('#modal-view-add-edit-remove-print').modal('show');
				}
			});
		}

		function sendPaymentReminder(subscription_id, payment_history_id) {
			$.ajax({
				url: base_url + "send-payment-reminder/" + subscription_id + '/' + payment_history_id,
				success: function(response) {
					if (response == 'success') {
						alert('Payment reminder sent successfully.');
					} else {
						alert('Failed to send payment reminder. Please try again.');
					}
				}
			});
		}
	</script>
