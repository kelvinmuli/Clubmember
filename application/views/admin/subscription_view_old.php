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
							<div id="subscription-card-list" class="row g-3">
								<?php if (!empty($subscriptionData)): ?>
									<?php foreach ($subscriptionData as $data): ?>
										<?php
										$fullLegalName = get_table($customerDBSettingRow->database_name . '.user', 'user_id', $data->user_id, 'full_legal_name');
										$membershipFeeTypeName = get_table($customerDBSettingRow->database_name . '.membership_fee_type', 'membership_fee_type_id', $data->membership_fee_type_id, 'name');
										$currencySign = get_table('m_currency', 'currency_id', $data->currency_id, 'sign');
										$paymentStatusNameRow = get_table('m_payment_status', 'payment_status_id', $data->payment_status_id, 'name');
										$dueDate = in_array($data->due_at, array('', '0000-00-00')) ? '-' : date('d M Y', strtotime($data->due_at));
										$paymentDate = in_array($data->payment_at, array('', '0000-00-00')) ? '-' : date('d M Y', strtotime($data->payment_at));
										$createdDate = empty($data->created_at) ? '-' : date('d M Y', strtotime($data->created_at));
										?>
										<div class="col-12 col-md-6 col-lg-4 subscription-card-item" data-subscription-card>
											<div class="card h-100">
												<div class="card-body">
													<div class="d-flex align-items-start justify-content-between">
														<div>
															<div class="text-secondary">Subscription</div>
															<div class="h3 mb-1"><?= htmlspecialchars((string) $fullLegalName, ENT_QUOTES, 'UTF-8') ?></div>
															<div class="text-secondary"><?= htmlspecialchars((string) $membershipFeeTypeName, ENT_QUOTES, 'UTF-8') ?></div>
														</div>
														<span class="badge bg-blue-lt"><?= htmlspecialchars((string) $paymentStatusNameRow, ENT_QUOTES, 'UTF-8') ?></span>
													</div>

													<div class="mt-3">
														<div class="row g-2">
															<div class="col-6">
																<div class="text-secondary">Due Date</div>
																<div class="fw-semibold"><?= htmlspecialchars((string) $dueDate, ENT_QUOTES, 'UTF-8') ?></div>
															</div>
															<div class="col-6">
																<div class="text-secondary">Payment Date</div>
																<div class="fw-semibold"><?= htmlspecialchars((string) $paymentDate, ENT_QUOTES, 'UTF-8') ?></div>
															</div>
															<div class="col-6">
																<div class="text-secondary">Amount</div>
																<div class="fw-semibold"><?= htmlspecialchars((string) $currencySign, ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars((string) $data->amount, ENT_QUOTES, 'UTF-8') ?></div>
															</div>
															<div class="col-6">
																<div class="text-secondary">Created</div>
																<div class="fw-semibold"><?= htmlspecialchars((string) $createdDate, ENT_QUOTES, 'UTF-8') ?></div>
															</div>
														</div>
													</div>

													<?php if ($viewUserRight || $approveUserRight): ?>
														<div class="mt-3 d-flex gap-2 flex-wrap justify-content-end">
															<?php if ($data->payment_status_id != '1732371146921'): ?>
																<button class="btn btn-pill" onclick="paymentInfoModal('<?= $data->user_id ?>', '<?= $data->payment_history_id ?>')">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																		<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																		<path d="M12 4v16m8 -8H4" />
																	</svg> Payment Info
																</button>
															<?php else: ?>
																<span class="dropdown">
																	<button class="btn dropdown-toggle btn-pill" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
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
																		<?php endif; ?>
																	</div>
																</span>
															<?php endif; ?>
														</div>
													<?php endif; ?>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								<?php else: ?>
									<div class="col-12">
										<span class="badge bg-red-lt">No Subscription Records</span>
									</div>
								<?php endif; ?>
							</div>
							<div class="d-flex align-items-center justify-content-between mt-3">
								<div class="text-secondary" id="subscription-card-page-info"></div>
								<nav aria-label="Subscription pagination">
									<ul class="pagination mb-0" id="subscription-card-pager"></ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		(function() {
			function paginateCards(listId, pagerId, infoId, perPage) {
				var listEl = document.getElementById(listId);
				var pagerEl = document.getElementById(pagerId);
				var infoEl = document.getElementById(infoId);
				if (!listEl || !pagerEl) return;

				var items = Array.prototype.slice.call(listEl.querySelectorAll('[data-subscription-card]'));
				if (!items.length) {
					pagerEl.innerHTML = '';
					if (infoEl) infoEl.textContent = '';
					return;

				}

				var currentPage = 1;
				var totalPages = Math.max(1, Math.ceil(items.length / perPage));

				function render() {
					var start = (currentPage - 1) * perPage;
					var end = start + perPage;

					items.forEach(function(item, idx) {
						item.style.display = (idx >= start && idx < end) ? '' : 'none';
					});

					if (infoEl) {
						infoEl.textContent = 'Page ' + currentPage + ' of ' + totalPages;
					}

					pagerEl.innerHTML = '';

					function addPageItem(label, page, disabled, active) {
						var li = document.createElement('li');
						li.className = 'page-item' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
						var a = document.createElement('a');
						a.className = 'page-link';
						a.href = '#';
						a.textContent = label;
						a.addEventListener('click', function(e) {
							e.preventDefault();
							if (disabled) return;
							currentPage = page;
							render();
						});
						li.appendChild(a);
						pagerEl.appendChild(li);
					}

					addPageItem('Prev', Math.max(1, currentPage - 1), currentPage === 1, false);

					var windowSize = 7;
					var startPage = Math.max(1, currentPage - Math.floor(windowSize / 2));
					var endPage = Math.min(totalPages, startPage + windowSize - 1);
					startPage = Math.max(1, endPage - windowSize + 1);

					for (var p = startPage; p <= endPage; p++) {
						addPageItem(String(p), p, false, p === currentPage);
					}

					addPageItem('Next', Math.min(totalPages, currentPage + 1), currentPage === totalPages, false);
				}

				render();
			}

			document.addEventListener('DOMContentLoaded', function() {
				paginateCards('subscription-card-list', 'subscription-card-pager', 'subscription-card-page-info', 9);
			});
		})();

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
