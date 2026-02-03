<?php $paymentStatusName = empty($paymentStatusId) ? 'N/A' : get_table('m_payment_status', 'payment_status_id', $paymentStatusId, 'name'); ?>
<div class="page-wrapper">
	<div class="container-fluid">
		<!-- Page title -->
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col">
					<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="#"><?= $moduleMenu->name ?></a></li>
						<li class="breadcrumb-item"><a href="#"><?= $paymentStatusName ?></a></li>
					</ol>
				</div>

				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">
						<?php if ($inputUserRight): ?>
							<a class="btn btn-success d-none d-sm-inline-block btn-pill" onclick="addSubscriptionModal()">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<line x1="12" y1="5" x2="12" y2="19" />
									<line x1="5" y1="12" x2="19" y2="12" />
								</svg> Add <?= $moduleMenu->name ?>
							</a>
							<a class="btn btn-success d-sm-none btn-icon btn-pill" onclick="addSubscriptionModal()" aria-label="Add <?= $moduleMenu->name ?>">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<line x1="12" y1="5" x2="12" y2="19" />
									<line x1="5" y1="12" x2="19" y2="12" />
								</svg>
							</a>

							<a class="btn btn-success d-none d-sm-inline-block btn-pill" onclick="addMembershipFeeType()">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<line x1="12" y1="5" x2="12" y2="19" />
									<line x1="5" y1="12" x2="19" y2="12" />
								</svg> Add Subscription Fee for Year
							</a>
							<a class="btn btn-success d-sm-none btn-icon btn-pill" onclick="addMembershipFeeType()" aria-label="Add Membership Fee Type">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<line x1="12" y1="5" x2="12" y2="19" />
									<line x1="5" y1="12" x2="19" y2="12" />
								</svg>
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
							<h3 class="card-title"><?= $paymentStatusName . ' ' . $moduleMenu->name ?></h3>
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
											<?php if ($viewUserRight || $approveUserRight): ?>
												<th>Actions</th>
											<?php endif; ?>
										</tr>
									</thead>
									<tbody>
										<?php $s = 0; if (isset($subscriptionData)): foreach ($subscriptionData as $data): ?>
											<tr>
												<td class="w-1"><?= ++$s ?>.</td>
												<td><?= get_table($customerDBSettingRow->database_name . '.user', 'user_id', $data->user_id, 'full_legal_name') ?></td>
												<td><?= get_table($customerDBSettingRow->database_name . '.membership_fee_type', 'membership_fee_type_id', $data->membership_fee_type_id, 'name') ?></td>
												<td><?= in_array($data->due_at, array('', '0000-00-00')) ? '-' : date('d M Y', strtotime($data->due_at)) ?></td>
												<td><?= in_array($data->payment_at, array('', '0000-00-00')) ? '-' : date('d M Y', strtotime($data->payment_at)) ?></td>
												<td><?= get_table('m_currency', 'currency_id', $data->currency_id, 'sign') ?></td>
												<td><?= $data->amount ?></td>
												<td><?= get_table('m_payment_status', 'payment_status_id', $data->payment_status_id, 'name') ?></td>
												<td><?= date('d M Y', strtotime($data->created_at)) ?></td>
												<?php if ($viewUserRight || $approveUserRight || $editUserRight || $removeUserRight): ?>
													<td>
														<?php if ($data->payment_status_id != '1732371146921'): ?>
															<?php if ($userTypeId == GlobalModel::MEMBER_TYPE): ?>
																<button class="btn btn-pill" onclick="paymentInfoModal('<?= $data->user_id ?>', '<?= $data->payment_history_id ?>')">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																		<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																		<path d="M12 4v16m8 -8H4" />
																	</svg> Payment Info
																</button>
															<?php else: ?>
																<span class="dropdown">
																	<button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
																	<div class="dropdown-menu dropdown-menu-end">
																		<?php if ($editUserRight): ?>
																			<a class="dropdown-item" onclick="editSubscriptionApproveModal('<?=$data->subscription_id?>', '<?=$data->payment_history_id?>')">
																				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																					<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																					<path d="M12 20h9" />
																					<path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1l1-4z" />
																				</svg> Edit Subscription
																			</a>
																		<?php endif; if ($removeUserRight): ?>
																			<a class="dropdown-item text-danger" onclick="removeSubscriptionApproveModal('<?=$data->subscription_id?>', '<?=$data->payment_history_id?>')">
																				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																					<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																					<line x1="4" y1="7" x2="20" y2="7" />
																					<line x1="10" y1="11" x2="10" y2="17" />
																					<line x1="14" y1="11" x2="14" y2="17" />
																					<path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
																					<path d="M9 7V4a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
																				</svg> Remove Subscription
																			</a>
																		<?php endif; if ($approveUserRight): ?>
																			<a class="dropdown-item" onclick="sendSubscriptionUnPaid('<?=$data->user_id?>', '<?=$data->subscription_id?>')">
																				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																					<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																					<line x1="12" y1="5" x2="12" y2="19" />
																					<line x1="5" y1="12" x2="19" y2="12" />
																				</svg> Send Subscription Invoice
																			</a>
																		<?php endif; if (!$approveUserRight && !$editUserRight && !$removeUserRight): ?>
																			<div class="dropdown-item text-muted">
																				No Actions Available
																			</div>
																		<?php endif; ?>
																	</div>
																</span>
															<?php endif; ?>
														<?php else: ?>
															<span class="dropdown">
																<button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
																<div class="dropdown-menu dropdown-menu-end">
																	<a class="dropdown-item" onclick="viewSubscriptionModal('<?= $data->subscription_id ?>', '<?= $data->payment_history_id ?>')">
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																			<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																			<circle cx="12" cy="12" r="9" />
																			<line x1="12" y1="8" x2="12" y2="12" />
																			<line x1="12" y1="16" x2="12.01" y2="16" />
																		</svg> View Details
																	</a>
																	<a href="#" class="dropdown-item" onclick="sendPaymentReminder('<?= $data->subscription_id ?>', '<?= $data->payment_history_id ?>')" hidden>
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																			<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																			<line x1="12" y1="5" x2="12" y2="19" />
																			<line x1="5" y1="12" x2="19" y2="12" />
																		</svg> Send Payment Reminder
																	</a>
																	<?php if ($data->active == '0'): ?>
																		<a href="#" class="dropdown-item" onclick="approveSubscriptionModal('<?= $data->subscription_id ?>', '<?= $data->payment_history_id ?>')">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																				<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																				<circle cx="12" cy="12" r="9" />
																				<line x1="12" y1="8" x2="12" y2="12" />
																				<line x1="12" y1="16" x2="12.01" y2="16" />
																			</svg> Approve/View
																		</a>
																	<?php endif;
																	if ($data->payment_status_id == '1732371146921'): ?>
																		<a class="dropdown-item" onclick="paymentReceiptModal('<?= $data->user_id ?>', '<?= $data->payment_history_id ?>')">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																				<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																				<path d="M12 4v16m8 -8H4" />
																			</svg> Payment Receipt
																		</a>
																		<?php if ($approveUserRight): ?>
																			<a class="dropdown-item" onclick="sendSubscriptionPaid('<?=$data->subscription_id?>', '<?=$data->payment_history_id?>')">
																				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																					<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																					<line x1="12" y1="5" x2="12" y2="19" />
																					<line x1="5" y1="12" x2="19" y2="12" />
																				</svg> Send Subscription Receipt
																			</a>
																		<?php endif; ?>
																	<?php endif; ?>
																</div>
															</span>
														<?php endif; ?>
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

		function editSubscriptionApproveModal(subscription_id, payment_history_id) {
			$.ajax({
				url: base_url + "edit-subscription-approve-modal/" + subscription_id + '/' + payment_history_id,
				success: function(response) {
					document.getElementById('modal-view-add-edit-remove-print').innerHTML = response;
					$('#modal-view-add-edit-remove-print').modal('show');
				}
			});
		}

		function removeSubscriptionApproveModal(subscription_id, payment_history_id) {
			$.ajax({
				url: base_url + "remove-subscription-approve-modal/" + subscription_id + '/' + payment_history_id,
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
