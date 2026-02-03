		<div class="modal modal-blur fade" id="modal-view-add-edit-remove-print" tabindex="-1" role="dialog" aria-hidden="true"></div>
		<div class="modal modal-blur fade" id="modal-view-edit-print-user" name="modal-view-edit-print-user" tabindex="-1" role="dialog" aria-hidden="true"></div>
		<div class="modal modal-blur fade" id="modal-view-edit-print-maintenance" name="modal-view-edit-print-maintenance" tabindex="-1" role="dialog" aria-hidden="true"></div>

		<!-- END PAGE BODY -->
		<!--  BEGIN FOOTER  -->
		<footer class="footer footer-transparent d-print-none">
			<div class="container-fluid">
				<?php if ($user_type_id == GlobalModel::MEMBER_TYPE && !$isSubscriptionPaid) { ?>
					<p class="text-center">Welcome to your NMRA Member's Dashboard where you will have access to a wealth of information including neighbourhood security incident tracker, projects been worked on by the association, including live updates and progress, newsletters, petitions, fundraising for projects and more. Simply pay your annual subscription by clicking on the pay button and paying via mpesa and this will all be unlocked.</p>
				<?php } ?>
				<div class="row text-center align-items-center flex-row-reverse">
					<div class="col-lg-auto ms-lg-auto">
						<ul class="list-inline list-inline-dots mb-0">
							<!-- <li class="list-inline-item"><a href="https://docs.tabler.io" target="_blank" class="link-secondary" rel="noopener"><?= $systemRow->name ?> is powered by <?= $systemRow->company ?></a>
							</li> -->
						</ul>
					</div>
					<div class="col-12 col-lg-auto mt-3 mt-lg-0">
						<ul class="list-inline list-inline-dots mb-0">
							<!-- <li class="list-inline-item">
									Copyright &copy; 2025
									<a href="." class="link-secondary"><?= $systemRow->name ?></a>. All rights reserved.
								</li> -->
							<!-- <li class="list-inline-item">
									<a href="./changelog.html" class="link-secondary" rel="noopener"> <?= $systemRow->version ?> </a>
								</li> -->
						</ul>
					</div>
				</div>
			</div>
		</footer>
		<!--  END FOOTER  -->
		</div>
		</div>

		<!-- BEGIN PAGE LIBRARIES -->
		<script src="<?= base_url() ?>assets/admin/dist/libs/apexcharts/dist/apexcharts.min.js?1747674014" defer></script>
		<script src="<?= base_url() ?>assets/admin/dist/libs/jsvectormap/dist/jsvectormap.min.js?1747674014" defer></script>
		<script src="<?= base_url() ?>assets/admin/dist/libs/jsvectormap/dist/maps/world.js?1747674014" defer></script>
		<script src="<?= base_url() ?>assets/admin/dist/libs/jsvectormap/dist/maps/world-merc.js?1747674014" defer></script>
		<!-- END PAGE LIBRARIES -->
		<script src="<?= base_url() ?>assets/admin/dist/libs/list.js/dist/list.min.js?1747674014" defer></script>
		<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
		<script src="<?= base_url() ?>assets/admin/dist/js/tabler.min.js?1747674014" defer></script>
		<!-- END GLOBAL MANDATORY SCRIPTS -->
		<!-- BEGIN DEMO SCRIPTS -->
		<script src="<?= base_url() ?>assets/admin/preview/js/demo.min.js?1747674014" defer></script>
		<!-- END DEMO SCRIPTS -->
		<!-- BEGIN PAGE SCRIPTS -->

		<script>
			function showModal(url, callback) {
				$.ajax({
					url: url,
					success: function(response) {
						document.getElementById('modal-view-add-edit-remove-print').innerHTML = response;
						$('#modal-view-add-edit-remove-print').modal('show');
						if (typeof callback === 'function') {
							callback(response);
						}
					}
				});
			}

			function approveUserModal(user_id, membership_type_id, customer_db_setting_id, header = 'all-user') {
				$.ajax({
					url: base_url + "approve-user-modal/" + user_id + "/" + membership_type_id + "/" + customer_db_setting_id + "/" + header,
					success: function(response) {
						document.getElementById('modal-view-edit-print-user').innerHTML = response;
						$('#modal-view-edit-print-user').modal('show');
					}
				});
			}

			function subscriptionApprovalModal(user_id, membership_type_id, customer_db_setting_id, header = 'all-user') {
				$.ajax({
					url: base_url + "subscription-approval-modal/" + user_id + "/" + membership_type_id + "/" + customer_db_setting_id + "/" + header,
					success: function(response) {
						document.getElementById('modal-view-edit-print-user').innerHTML = response;
						$('#modal-view-edit-print-user').modal('show');
					}
				});
			}

			function editUserModal(user_id, membership_type_id = '', customer_db_setting_id = '', header = 'all-user') {
				$.ajax({
					url: base_url + "edit-user-modal/" + user_id + "/" + membership_type_id + "/" + customer_db_setting_id + "/" + header,
					success: function(response) {
						document.getElementById('modal-view-edit-print-user').innerHTML = response;
						$('#modal-view-edit-print-user').modal('show');
					}
				});
			}

			function removeUserModal(user_id) {
				$.ajax({
					url: base_url + "remove-user-modal/" + user_id,
					success: function(response) {
						document.getElementById('modal-view-edit-print-user').innerHTML = response;
						$('#modal-view-edit-print-user').modal('show');
					}
				});
			}

			function deleteUserModal(user_id, customer_db_setting_id, header = 'all-user') {
				$.ajax({
					url: base_url + "delete-user-modal/" + user_id + "/" + customer_db_setting_id + "/" + header,
					success: function(response) {
						document.getElementById('modal-view-edit-print-user').innerHTML = response;
						$('#modal-view-edit-print-user').modal('show');
					}
				});
			}

			function editUserImageModal(user_id) {
				$.ajax({
					url: base_url + "edit-user-image-modal/" + user_id,
					success: function(response) {
						document.getElementById('modal-view-edit-print-user').innerHTML = response;
						$('#modal-view-edit-print-user').modal('show');
					}
				});
			}

			viewProjectModal = function(projectId) {
				showModal(base_url + 'view-project-modal/' + projectId, function() {});
			};

			addProjectUpdateModal = function(projectId) {
				showModal(base_url + 'add-project-update-modal/' + projectId, function() {});
			};

			editProjectUpdateModal = function(projectUpdateId) {
				showModal(base_url + 'edit-project-update-modal/' + projectUpdateId, function() {});
			};

			deleteProjectUpdateModal = function(projectUpdateId) {
				showModal(base_url + 'delete-project-update-modal/' + projectUpdateId, function() {});
			};

			function addSubscriptionModal(payment_status_id = '1732351802222') {
				$.ajax({
					url: base_url + "add-subscription-modal/" + payment_status_id,
					success: function(response) {
						document.getElementById('modal-view-add-edit-remove-print').innerHTML = response;
						$('#modal-view-add-edit-remove-print').modal('show');
						$("#membership_fee_type_id").change(function() {
							$.ajax({
								url: base_url + "get-membership-fee-type/" + $(this).val(),
								success: function(response) {
									const object = JSON.parse(response);
									document.getElementById("amount").value = object.amount;
								}
							});
						});
					}
				});
			}

			function sendSubscriptionUnPaid(user_id, subscription_id) {
				$.ajax({
					url: base_url + "send-subscription-unpaid/" + user_id + '/' + subscription_id,
					success: function(response) {
						alert('Unpaid Subscription invoice sent successfully.');
					}
				});
			}

			function sendSubscriptionPaid(subscription_id, payment_history_id) {
				$.ajax({
					url: base_url + "send-subscription-paid/" + subscription_id + '/' + payment_history_id,
					success: function(response) {
						alert('Subscription invoice sent successfully.');
					}
				});
			}

			function sendResetPassword(user_id, customer_db_setting_id) {
				$.ajax({
					url: base_url + "send-reset-password/" + user_id + "/" + customer_db_setting_id,
					success: function(response) {
						alert('Password reset email sent successfully.');
					}
				});
			}

			viewPetition = function(petitionSetupId) {
				showModal(base_url + 'view-petition-modal/' + petitionSetupId, function() {});
			};

			addPetitionSignatureModal = function(petitionSetupId) {
				showModal(base_url + 'add-petition-signature-modal/' + petitionSetupId, window.initPetitionSignatureModal);
			};

			viewPetitionSignatures = function(petitionSetupId) {
				window.location.href = base_url + 'petition-signatures/' + petitionSetupId;
			};

			viewNoticeBoardModal = function(noticeId) {
				showModal(base_url + 'view-notice-board-modal' + (noticeId ? '/' + noticeId : ''), function() {
					// optional init after modal shown
				});
			};

			addAGMMinutesModal = function() {
				showModal(base_url + 'add-agm-minutes-modal', function (response) {
					loadDescription('add_edit_description');
				});
			};

			viewAgmMinutesModal = function(agmMinutesId) {
				showModal(base_url + 'view-agm-minutes-modal/' + agmMinutesId, function () {});
			};

			editAgmMinutesModal = function(agmMinutesId) {
				showModal(base_url + 'edit-agm-minutes-modal/' + agmMinutesId, function (response) {
					// Callback function after modal is shown
					loadDescription('add_edit_description');
				});
			};

			removeAgmMinutesModal = function(agmMinutesId) {
				showModal(base_url + 'remove-agm-minutes-modal/' + agmMinutesId, function (response) {
					// Callback function after modal is shown
				});
			};

			addAuditedAccountModal = function() {
				showModal(base_url + 'add-audited-account-modal', function () {
					loadDescription('add_edit_description');
				});
			};

			viewAuditedAccountModal = function(auditedAccountId) {
				showModal(base_url + 'view-audited-account-modal/' + auditedAccountId, function () {});
			};

			editAuditedAccountModal = function(auditedAccountId) {
				showModal(base_url + 'edit-audited-account-modal/' + auditedAccountId, function () {
					loadDescription('add_edit_description');
				});
			};

			removeAuditedAccountModal = function(auditedAccountId) {
				showModal(base_url + 'remove-audited-account-modal/' + auditedAccountId, function () {});
			};

			addNewsletterModal = function() {
				showModal(base_url + 'add-newsletter-modal', function () {
					loadDescription('add_edit_description');
				});
			};

			viewNewsletterModal = function(newsletterId) {
				showModal(base_url + 'view-newsletter-modal/' + newsletterId, function () {
				});
			};

			editNewsletterModal = function(newsletterId) {
				showModal(base_url + 'edit-newsletter-modal/' + newsletterId, function () {
					loadDescription('add_edit_description');
				});
			};

			removeNewsletterModal = function(newsletterId) {
				showModal(base_url + 'remove-newsletter-modal/' + newsletterId, function () {});
			};

			function paymentInfoModal(user_id, payment_history_id = '') {
				$.ajax({
					url: base_url + "payment-info-modal/" + user_id + "/" + payment_history_id,
					success: function(response) {
						document.getElementById('modal-view-add-edit-remove-print').innerHTML = response;
						$('#modal-view-add-edit-remove-print').modal('show');
					}
				});
			}

			function payModal(user_id, payment_history_id = '', phone_no = '', $data = '') {
				$.ajax({
					url: base_url + "pay-modal/" + user_id + "/" + payment_history_id + "/" + phone_no + '/' + $data,
					success: function(response) {
						document.getElementById('modal-view-add-edit-remove-print').innerHTML = response;
						$('#modal-view-add-edit-remove-print').modal('show');
					}
				});
			}

			function payViaMpesaModal(user_id, payment_history_id = '', phone_no = '', amount = '', universal_id = '') {
				var btn = document.getElementById('pay_via_mpesa_button');
				var originalHtml = btn ? btn.innerHTML : null;
				if (btn) {
					btn.disabled = true;
					btn.innerHTML = 'Processing...';
				}

				var modalUrl = base_url + "pay-via-mpesa-modal/" + user_id + "/" + payment_history_id + "/" + encodeURIComponent(phone_no) + (amount ? "/" + encodeURIComponent(amount) : "") + (universal_id ? "/" + encodeURIComponent(universal_id) : "");
				$.ajax({
					url: modalUrl,
					success: function(response) {
						document.getElementById('modal-view-add-edit-remove-print').innerHTML = response;
						$('#modal-view-add-edit-remove-print').modal('show');

						var requestUrl = base_url + "pay-via-mpesa-request/" + user_id + "/" + payment_history_id + "/" + encodeURIComponent(phone_no) + (amount ? "/" + encodeURIComponent(amount) : "");
						$.ajax({
							url: requestUrl,
							dataType: 'json',
							complete: function() {
								var b = document.getElementById('pay_via_mpesa_button');
								if (b) {
									b.disabled = false;
									if (originalHtml !== null) b.innerHTML = originalHtml;
								}
							},
							success: function(res) {
								if (res && res.checkoutRequestId) {
									var idEl = document.getElementById('mpesa-merchant-request-id');
									if (idEl) idEl.textContent = 'Request sent to ' + phone_no; //res.checkoutRequestId;
								}
								var statusEl = document.getElementById('mpesa-request-status');
								if (statusEl) {
									var msg = (res && res.info) ? res.info : 'Request sent.';
									statusEl.textContent = statusEl.textContent.replace('Please wait...', msg);
								}

								//Auto refresh payment status every 10 seconds
								setInterval(function() {
									$.ajax({
										url: base_url + "check-mpesa-payment-status/" + res.checkoutRequestId + "/" + user_id + "/" + payment_history_id + "/" + encodeURIComponent(phone_no) + (amount ? "/" + encodeURIComponent(amount) : ""),
										success: function(statusRes) {
											console.log('Mpesa payment status:', statusRes);
											if (statusRes == 'success') {
												var idEl = document.getElementById('mpesa-merchant-request-id');
												if (idEl)
													idEl.textContent = 'Paid ' + statusRes;

												var statusEl = document.getElementById('mpesa-request-status');
												if (statusEl)
													statusEl.textContent = 'Paid ' + statusRes;

												//redirect to subscription page after 3 seconds
												// window.location.href = base_url + 'subscription/1732371146921';
												window.location.href = base_url + 'dashboard';
											}
										}
									});
								}, 10000);

								// var paymentStatusInterval = setInterval(function() {
								// 	$.ajax({
								// 		url: base_url + "check-mpesa-payment-status/" + res.checkoutRequestId + "/" + user_id + "/" + payment_history_id + "/" + encodeURIComponent(phone_no) + (amount ? "/" + encodeURIComponent(amount) : ""),
								// 		success: function(statusRes) {
								// 			if (statusRes == 'success') {
								// 				var idEl = document.getElementById('mpesa-merchant-request-id');
								// 				if (idEl) 
								// 					idEl.textContent = 'Paid ' + statusRes;

								// 				var statusEl = document.getElementById('mpesa-request-status');
								// 				if (statusEl)
								// 					statusEl.textContent = 'Paid ' + statusRes;

								// 				//redirect to subscription page after 3 seconds
								// 				window.location.href = base_url + 'subscription/1732371146921';
								// 				clearInterval(paymentStatusInterval);
								// 			}
								// 		}
								// 	});
								// }, 10000);
							},
							error: function() {
								var statusEl = document.getElementById('mpesa-request-status');
								if (statusEl) {
									statusEl.textContent = 'Failed to send M-PESA request. Please try again.';
								}
							}
						});
					},
					error: function() {
						if (btn) {
							btn.disabled = false;
							if (originalHtml !== null) btn.innerHTML = originalHtml;
						}
					}
				});
			}



			function printReceipt(title, contentId) {
				var content = document.getElementById(contentId);
				if (!content) {
					console.warn('printReceipt: content not found for id', contentId);
					window.print();
					return;
				}

				var printWindow = window.open('', 'print-' + Date.now(), 'height=600,width=800');
				if (!printWindow) {
					console.error('printReceipt: popup blocked');
					return;
				}

				var clonedContent = content.cloneNode(true);
				var styles = Array.prototype.slice.call(document.querySelectorAll('link[rel="stylesheet"], style'));

				printWindow.document.open();
				printWindow.document.write('<!DOCTYPE html><html><head><title>' + (title || document.title) + '</title>');
				styles.forEach(function(node) {
					printWindow.document.write(node.outerHTML);
				});
				printWindow.document.write('</head><body>');
				printWindow.document.write(clonedContent.outerHTML);
				printWindow.document.write('</body></html>');
				printWindow.document.close();

				var finalizePrint = function() {
					printWindow.focus();
					printWindow.print();
					printWindow.onafterprint = function() {
						printWindow.close();
					};
				};

				if (printWindow.document.readyState === 'complete') {
					finalizePrint();
				} else {
					printWindow.onload = finalizePrint;
				}
			}


			window.initPetitionSignatureModal = function() {
				const methodSelect = document.getElementById('petition_signature_method_id');
				if (!methodSelect) {
					return;
				}

				const uploadSection = document.getElementById('petition_signature_upload_section');
				const drawSection = document.getElementById('petition_signature_draw_section');
				const urlSection = document.getElementById('petition_signature_url_section');
				const signatureFileInput = document.getElementById('petition_signature_file');
				const signatureUrlInput = document.getElementById('petition_signature_url');
				const drawDataInput = document.getElementById('petition_signature_draw_data');
				const form = document.getElementById('petition-signature-form');
				const canvas = document.getElementById('petition_signature_canvas');
				const clearBtn = document.getElementById('petition_signature_clear_canvas');
				const hasCanvas = !!canvas && !!canvas.getContext;
				const signaturePreviewWrapper = document.getElementById('petition_signature_preview_wrapper');
				const hasExistingSignature = !!signaturePreviewWrapper;
				const uploadMethodInput = document.getElementById('petition_signature_upload_method_id');
				const drawMethodInput = document.getElementById('petition_signature_draw_method_id');

				let uploadMethodId = uploadMethodInput ? uploadMethodInput.value.trim() : '';
				let drawMethodId = drawMethodInput ? drawMethodInput.value.trim() : '';
				const methodOptions = Array.from(methodSelect.options || []);
				let requestCanvasResize = function() {};

				const findMethodId = (keywords) => {
					for (const option of methodOptions) {
						if (!option.value) {
							continue;
						}
						const label = (option.textContent || option.innerText || '').toLowerCase();
						for (const keyword of keywords) {
							if (label.includes(keyword)) {
								return option.value;
							}
						}
					}
					return '';
				};

				if (!uploadMethodId) {
					uploadMethodId = findMethodId(['upload', 'file']);
				}
				if (!drawMethodId) {
					drawMethodId = findMethodId(['draw', 'pad', 'digital']);
				}
				uploadMethodId = uploadMethodId || null;
				drawMethodId = drawMethodId || null;

				const toggleSections = () => {
					const selected = methodSelect.value;
					[uploadSection, drawSection, urlSection].forEach(section => {
						if (section) {
							section.classList.add('d-none');
						}
					});
					if (signatureFileInput) {
						signatureFileInput.required = false;
					}
					if (drawDataInput) {
						drawDataInput.required = false;
					}
					if (signatureUrlInput) {
						signatureUrlInput.required = false;
					}

					if (uploadMethodId && selected === uploadMethodId && uploadSection) {
						uploadSection.classList.remove('d-none');
						if (signatureFileInput && !hasExistingSignature) {
							signatureFileInput.required = true;
						}
					} else if (drawMethodId && selected === drawMethodId && drawSection) {
						drawSection.classList.remove('d-none');
						if (drawDataInput && !hasExistingSignature) {
							drawDataInput.required = true;
						}
						requestCanvasResize(true);
					} else if (urlSection) {
						urlSection.classList.remove('d-none');
						if (signatureUrlInput && !hasExistingSignature) {
							signatureUrlInput.required = true;
						}
					}
				};

				methodSelect.addEventListener('change', toggleSections);
				toggleSections();

				if (hasCanvas) {
					const ctx = canvas.getContext('2d');
					let drawing = false;
					let lastX = 0;
					let lastY = 0;
					let resizeTimer = null;

					const resizeCanvas = (force) => {
						const rect = canvas.getBoundingClientRect();
						if (rect.width === 0 && !force) {
							return;
						}
						if (rect.width === 0 && force) {
							if (resizeTimer) {
								clearTimeout(resizeTimer);
							}
							resizeTimer = setTimeout(() => resizeCanvas(false), 80);
							return;
						}
						const ratio = window.devicePixelRatio || 1;
						canvas.width = rect.width * ratio;
						canvas.height = rect.height * ratio;
						ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
						ctx.lineJoin = 'round';
						ctx.lineCap = 'round';
						ctx.lineWidth = 2.5;
						ctx.strokeStyle = '#000';
					};

					requestCanvasResize = function(force) {
						if (resizeTimer) {
							clearTimeout(resizeTimer);
						}
						resizeTimer = setTimeout(() => resizeCanvas(force === true), force ? 10 : 100);
					};

					const startDrawing = (x, y) => {
						drawing = true;
						lastX = x;
						lastY = y;
					};

					const drawLine = (x, y) => {
						if (!drawing) {
							return;
						}
						ctx.beginPath();
						ctx.moveTo(lastX, lastY);
						ctx.lineTo(x, y);
						ctx.stroke();
						lastX = x;
						lastY = y;
					};

					const endDrawing = () => {
						drawing = false;
					};

					const getPoint = (event) => {
						const rect = canvas.getBoundingClientRect();
						if (event.touches && event.touches.length > 0) {
							return {
								x: event.touches[0].clientX - rect.left,
								y: event.touches[0].clientY - rect.top
							};
						}
						return {
							x: event.clientX - rect.left,
							y: event.clientY - rect.top
						};
					};

					const clearCanvas = () => {
						ctx.clearRect(0, 0, canvas.width, canvas.height);
						if (drawDataInput) {
							drawDataInput.value = '';
						}
					};

					requestCanvasResize(true);
					window.addEventListener('resize', () => requestCanvasResize(false));

					canvas.addEventListener('mousedown', (event) => {
						const point = getPoint(event);
						startDrawing(point.x, point.y);
					});
					canvas.addEventListener('mousemove', (event) => {
						const point = getPoint(event);
						drawLine(point.x, point.y);
					});
					canvas.addEventListener('mouseup', endDrawing);
					canvas.addEventListener('mouseleave', endDrawing);

					canvas.addEventListener('touchstart', (event) => {
						event.preventDefault();
						const point = getPoint(event);
						startDrawing(point.x, point.y);
					});
					canvas.addEventListener('touchmove', (event) => {
						event.preventDefault();
						const point = getPoint(event);
						drawLine(point.x, point.y);
					});
					canvas.addEventListener('touchend', endDrawing);
					canvas.addEventListener('touchcancel', endDrawing);

					if (clearBtn) {
						clearBtn.addEventListener('click', (event) => {
							event.preventDefault();
							clearCanvas();
						});
					}

					if (form) {
						form.addEventListener('submit', () => {
							if (drawMethodId && methodSelect.value === drawMethodId && drawDataInput) {
								drawDataInput.value = canvas.toDataURL('image/png');
							}
						});
					}
				}
			};

			addPetitionSignatureModal = function(petitionSetupId) {
				showModal(base_url + 'add-petition-signature-modal/' + petitionSetupId, window.initPetitionSignatureModal);
			};

			viewSubscriptionModal = function(subscription_id, payment_history_id) {
				var modalUrl = base_url + 'view-subscription-modal/' + subscription_id;
				if (payment_history_id) {
					modalUrl += '/' + payment_history_id;
				}
				showModal(modalUrl, function() {});
			};

			paymentReceiptModal = function(userId, paymentHistoryId) {
				$.ajax({
					url: base_url + 'payment-receipt-modal/' + userId + '/' + paymentHistoryId,
					success: function(response) {
						document.getElementById('modal-view-add-edit-remove-print').innerHTML = response;
						$('#modal-view-add-edit-remove-print').modal('show');
					}
				});
				// showModal('payment-receipt-modal/' + userId + '/' + paymentHistoryId, function() {
				// 	alert('here');
				// });
			}

			function addMaintenanceModal(module_type_id, maintenance) {
				$.ajax({
					url: base_url + "add-maintenance-modal/<?= $moduleMenu->module_id ?>/" + module_type_id + "/" + maintenance,
					success: function(response) {
						document.getElementById('modal-view-edit-print-maintenance').innerHTML = response;
						$('#modal-view-edit-print-maintenance').modal('show');

						$('#input_' + maintenance + '_multi_table').select2({
							dropdownParent: $('#modal-view-edit-print-maintenance')
						});

						const maintenanceFieldData = <?= json_encode($maintenanceFieldData ?? []) ?>;
						const maintenanceFieldValueData = <?= json_encode($maintenanceFieldValueData ?? []) ?>;

						$("#input_m_maintenance_column_maintenance_id").change(function() {
							$.ajax({
								type: 'POST',
								url: base_url + "get-table-data/maintenance/maintenance_id/" + $(this).val() + '/name',
								success: function(result) {
									$.ajax({
										type: 'POST',
										url: base_url + "get-maintenance-column-html/" + result + '/0',
										success: function(data) {
											$('#input_m_maintenance_column_column_id').html(data);
										}
									});
								}
							});
						});

						if (maintenanceFieldValueData[maintenance]) {
							const fieldValues = maintenanceFieldValueData[maintenance];
							const fieldData = maintenanceFieldData[maintenance];

							if (fieldData && fieldData.length > 1) {
								fieldData.forEach((maintenanceField, pos) => {
									const name = maintenanceField.name;
									if (!<?= json_encode(explode(',', get_table('m_column_define', 'column_define_id', '1753658383444', 'multi_column'))) ?>.includes(name) && pos != 1) {
										if (<?= json_encode(explode(',', get_table('m_column_define', 'column_define_id', '1753528816500', 'multi_column'))) ?>.includes(name)) {
											CKEDITOR.replace('input_' + maintenance + '_' + name, {
												versionCheck: false,
												height: (['icon', ''].includes(name)) ? 80 : 320,
												allowedContent: true
											});
										}
									}
								});
							}
						}


					}
				});
			}

			function editMaintenanceModal(module_type_id, maintenance, unique_id) {
				$.ajax({
					url: base_url + "edit-maintenance-modal/<?= $moduleMenu->module_id ?>/" + module_type_id + "/" + maintenance + "/" + unique_id,
					success: function(response) {
						document.getElementById('modal-view-edit-print-maintenance').innerHTML = response;
						$('#modal-view-edit-print-maintenance').modal('show');

						$('#edit_' + maintenance + '_multi_table').select2({
							dropdownParent: $('#modal-view-edit-print-maintenance')
						});

						const maintenanceFieldData = <?= json_encode($maintenanceFieldData ?? []) ?>;
						const maintenanceFieldValueData = <?= json_encode($maintenanceFieldValueData ?? []) ?>;

						$("#input_m_maintenance_column_maintenance_id").change(function() {
							$.ajax({
								type: 'POST',
								url: base_url + "get-table-data/maintenance/maintenance_id/" + $(this).val() + '/name',
								success: function(result) {
									$.ajax({
										type: 'POST',
										url: base_url + "get-maintenance-column-html/" + result + '/0',
										success: function(data) {
											$('#input_m_maintenance_column_column_id').html(data);
										}
									});
								}
							});
						});

						if (maintenanceFieldValueData[maintenance]) {
							const fieldValues = maintenanceFieldValueData[maintenance];
							const fieldData = maintenanceFieldData[maintenance];

							if (fieldData && fieldData.length > 1) {
								const column = fieldData[1].name;
								fieldData.forEach((maintenanceField, pos) => {
									const name = maintenanceField.name;
									if (!<?= json_encode(explode(',', get_table('m_column_define', 'column_define_id', '1753658383444', 'multi_column'))) ?>.includes(name) && pos != 1) {
										if (<?= json_encode(explode(',', get_table('m_column_define', 'column_define_id', '1753528816500', 'multi_column'))) ?>.includes(name)) {
											CKEDITOR.replace('edit_' + maintenance + '_' + name + '_' + unique_id, {
												versionCheck: false,
												height: (['icon', ''].includes(name)) ? 80 : 320,
												allowedContent: true
											});
										}
									}
								});
							}
						}
					}
				});
			}

			function editMaintenanceImageModal(module_type_id, maintenance, unique_id, name = '') {
				$.ajax({
					url: base_url + "edit-maintenance-image-modal/<?= $moduleMenu->module_id ?>/" + module_type_id + "/" + maintenance + "/" + unique_id + "/" + name,
					success: function(response) {
						document.getElementById('modal-view-edit-print-maintenance').innerHTML = response;
						$('#modal-view-edit-print-maintenance').modal('show');
					}
				});
			}

			function removeMaintenanceModal(module_type_id, maintenance, unique_id) {
				$.ajax({
					url: base_url + "remove-maintenance-modal/<?= $moduleMenu->module_id ?>/" + module_type_id + "/" + maintenance + "/" + unique_id,
					success: function(response) {
						document.getElementById('modal-view-edit-print-maintenance').innerHTML = response;
						$('#modal-view-edit-print-maintenance').modal('show');
					}
				});
			}

			function loadDescription(description) {
				CKEDITOR.replace(description, {
					removePluginsremovePlugins: 'filetools,uploadimage,uploadwidget,uploadfile,filebrowser,easyimage,image,source',
					height: 200,
					allowedContent: true,
					versionCheck: false
				});
			}

			function loadRichTextEditor(elementId) {
				tinymce.init({
					selector: '#' + elementId,
					plugins: 'lists link image preview',
					toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
					images_upload_url: base_url + 'upload_image',
					automatic_uploads: true,
					file_picker_types: 'image',
					init_instance_callback: function(editor) {
						editor.on('change', function() {
							editor.save();
						});
					}
				});
			}

			function loadMultipleSelect(elementId) {
				new TomSelect(document.getElementById(elementId), {
					copyClassesToDropdown: false,
					dropdownParent: "body",
					controlInput: "<input>",
					render: {
						item: function(data, escape) {
							if (data.customProperties) {
								return '<div><span class="dropdown-item-indicator">' + data.customProperties + "</span>" + escape(data.text) + "</div>";
							}
							return "<div>" + escape(data.text) + "</div>";
						},
						option: function(data, escape) {
							if (data.customProperties) {
								return '<div><span class="dropdown-item-indicator">' + data.customProperties + "</span>" + escape(data.text) + "</div>";
							}
							return "<div>" + escape(data.text) + "</div>";
						},
					},
				});
			}

			function loadDatatable(datatable, name = '') {
				$('#' + datatable).DataTable({
					processing: true,
					displayLength: <?= isset($numericSelectData[0]) ? $numericSelectData[0]->num : GlobalModel::NUMERIC_SELECT_HUNDRED ?>,
					paging: true,
					searching: true,
					info: true,
					columnDefs: [{
						orderable: false,
						targets: 'no-search',
						searchable: false
					}],
					// order: [[ 2, 'ASC' ]],
					language: {
						emptyTable: '<span class="badge bg-red-lt">No ' + name + ' Records</span>',
						zeroRecords: '<span class="badge bg-red-lt">Nothing found. Please change your search term</span>',
						paginate: {
							previous: '<ul class="pagination">' +
								'<li class="page-item disabled">' +
								'<a class="page-link" href="#" tabindex="-1" aria-disabled="true">' +
								'<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>' +
								'Prev </a>' +
								'</li>' +
								'</ul>',

							next: '<ul class="pagination">' +
								'<li class="page-item">' +
								'<a class="page-link" href="#"> Next' +
								'<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg>' +
								'</a>' +
								'</li>' +
								'</ul>',
						},
						lengthMenu: '<div class="text-muted py-2">Show<div class="mx-2 d-inline-block ">' +
							'<select class="form-select form-control-rounded">' +
							'<?php if (isset($numericSelectData)): foreach ($numericSelectData as $data): ?>' +
							'<option value="<?= $data->num ?>"><?= $data->name ?></option>' +
							'<?php endforeach;
								endif; ?>' +
							'<option value="-1">All</option>' +
							'</select>' +
							'</div>entries</div>'

					},
					buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
				});
			}

			// @formatter:off
			document.addEventListener("DOMContentLoaded", function() {
				window.ApexCharts && (new ApexCharts(document.getElementById('chart-revenue-bg'), {
					chart: {
						type: "area",
						fontFamily: 'inherit',
						height: 40.0,
						sparkline: {
							enabled: true
						},
						animations: {
							enabled: false
						},
					},
					dataLabels: {
						enabled: false,
					},
					fill: {
						opacity: .16,
						type: 'solid'
					},
					stroke: {
						width: 2,
						lineCap: "round",
						curve: "smooth",
					},
					series: [{
						name: "Profits",
						data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67]
					}],
					grid: {
						strokeDashArray: 4,
					},
					xaxis: {
						labels: {
							padding: 0
						},
						tooltip: {
							enabled: false
						},
						axisBorder: {
							show: false,
						},
						type: 'datetime',
					},
					yaxis: {
						labels: {
							padding: 4
						},
					},
					labels: [
						'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
					],
					colors: ["#206bc4"],
					legend: {
						show: false,
					},
				})).render();
			});
			// @formatter:on
			document.addEventListener("DOMContentLoaded", function() {
				var el;
				window.Choices && (new Choices(el = document.getElementById('user_id'), {
					classNames: {
						containerInner: el.className,
						input: 'form-control',
						inputCloned: 'form-control-sm',
						listDropdown: 'dropdown-menu',
						itemChoice: 'dropdown-item',
						activeState: 'show',
						selectedState: 'active',
					},
					shouldSort: false,
					searchEnabled: false,
					callbackOnCreateTemplates: function(template) {
						var classNames = this.config.className,
							itemSelectText = this.config.itemSelectText;
						return {
							item: function(classNames, data) {
								return template('<div class="' + String(classNames.item) + ' ' + String(data.highlighted ? classNames.highlightedState : classNames.itemSelectable) + '" data-item data-id="' + String(data.id) + '" data-value="' + String(data.value) + '"' + String(data.active ? 'aria-selected="true"' : '') + '' + String(data.disabled ? 'aria-disabled="true"' : '') + '><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + String(data.label) + '</div>');
							},
							choice: function(classNames, data) {
								console.log('data', data);
								return template('<div class="' + String(classNames.item) + ' ' + String(classNames.itemChoice) + ' ' + String(data.disabled ? classNames.itemDisabled : classNames.itemSelectable) + '" data-select-text="' + String(itemSelectText) + '" data-choice  ' + String(data.disabled ? 'data-choice-disabled aria-disabled="true"' : 'data-choice-selectable') + ' data-id="' + String(data.id) + '" data-value="' + String(data.value) + '" ' + String(data.groupId > 0 ? 'role="treeitem"' : 'role="option"') + ' ><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + String(data.label) + '</div>');
							},
						};
					},
				}));
			});
		</script>
		<script>
			// @formatter:off
			document.addEventListener("DOMContentLoaded", function() {
				window.ApexCharts && (new ApexCharts(document.getElementById('chart-mentions'), {
					chart: {
						type: "bar",
						fontFamily: 'inherit',
						height: 240,
						parentHeightOffset: 0,
						toolbar: {
							show: false,
						},
						animations: {
							enabled: false
						},
						stacked: true,
					},
					plotOptions: {
						bar: {
							columnWidth: '50%',
						}
					},
					dataLabels: {
						enabled: false,
					},
					fill: {
						opacity: 1,
					},
					series: [{
						name: "Web",
						data: [1, 0, 0, 0, 0, 1, 1, 0, 0, 0, 2, 12, 5, 8, 22, 6, 8, 6, 4, 1, 8, 24, 29, 51, 40, 47, 23, 26, 50, 26, 41, 22, 46, 47, 81, 46, 6]
					}, {
						name: "Social",
						data: [2, 5, 4, 3, 3, 1, 4, 7, 5, 1, 2, 5, 3, 2, 6, 7, 7, 1, 5, 5, 2, 12, 4, 6, 18, 3, 5, 2, 13, 15, 20, 47, 18, 15, 11, 10, 0]
					}, {
						name: "Other",
						data: [2, 9, 1, 7, 8, 3, 6, 5, 5, 4, 6, 4, 1, 9, 3, 6, 7, 5, 2, 8, 4, 9, 1, 2, 6, 7, 5, 1, 8, 3, 2, 3, 4, 9, 7, 1, 6]
					}],
					grid: {
						padding: {
							top: -20,
							right: 0,
							left: -4,
							bottom: -4
						},
						strokeDashArray: 4,
						xaxis: {
							lines: {
								show: true
							}
						},
					},
					xaxis: {
						labels: {
							padding: 0
						},
						tooltip: {
							enabled: false
						},
						axisBorder: {
							show: false,
						},
						type: 'datetime',
					},
					yaxis: {
						labels: {
							padding: 4
						},
					},
					labels: [
						'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19', '2020-07-20', '2020-07-21', '2020-07-22', '2020-07-23', '2020-07-24', '2020-07-25', '2020-07-26'
					],
					colors: ["#206bc4", "#79a6dc", "#bfe399"],
					legend: {
						show: true,
						position: 'bottom',
						height: 32,
						offsetY: 8,
						markers: {
							width: 8,
							height: 8,
							radius: 100,
						},
						itemMargin: {
							horizontal: 8,
						},
					},
				})).render();
			});
			// @formatter:on
		</script>
		<script>
			// @formatter:off
			document.addEventListener("DOMContentLoaded", function() {
				window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-activity'), {
					chart: {
						type: "radialBar",
						fontFamily: 'inherit',
						height: 40,
						width: 40,
						animations: {
							enabled: false
						},
						sparkline: {
							enabled: true
						},
					},
					tooltip: {
						enabled: false,
					},
					plotOptions: {
						radialBar: {
							hollow: {
								margin: 0,
								size: '75%'
							},
							track: {
								margin: 0
							},
							dataLabels: {
								show: false
							}
						}
					},
					colors: ["#206bc4"],
					series: [35],
				})).render();
			});
			// @formatter:on
		</script>
		<script>
			// @formatter:off
			document.addEventListener("DOMContentLoaded", function() {
				window.ApexCharts && (new ApexCharts(document.getElementById('chart-development-activity'), {
					chart: {
						type: "area",
						fontFamily: 'inherit',
						height: 192,
						sparkline: {
							enabled: true
						},
						animations: {
							enabled: false
						},
					},
					dataLabels: {
						enabled: false,
					},
					fill: {
						opacity: .16,
						type: 'solid'
					},
					stroke: {
						width: 2,
						lineCap: "round",
						curve: "smooth",
					},
					series: [{
						name: "Purchases",
						data: [3, 5, 4, 6, 7, 5, 6, 8, 24, 7, 12, 5, 6, 3, 8, 4, 14, 30, 17, 19, 15, 14, 25, 32, 40, 55, 60, 48, 52, 70]
					}],
					grid: {
						strokeDashArray: 4,
					},
					xaxis: {
						labels: {
							padding: 0
						},
						tooltip: {
							enabled: false
						},
						axisBorder: {
							show: false,
						},
						type: 'datetime',
					},
					yaxis: {
						labels: {
							padding: 4
						},
					},
					labels: [
						'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
					],
					colors: ["#206bc4"],
					legend: {
						show: false,
					},
					point: {
						show: false
					},
				})).render();
			});
			// @formatter:on
		</script>
		<script>
			// @formatter:off
			document.addEventListener("DOMContentLoaded", function() {
				window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-1'), {
					chart: {
						type: "line",
						fontFamily: 'inherit',
						height: 24,
						animations: {
							enabled: false
						},
						sparkline: {
							enabled: true
						},
					},
					tooltip: {
						enabled: false,
					},
					stroke: {
						width: 2,
						lineCap: "round",
					},
					series: [{
						color: "#206bc4",
						data: [17, 24, 20, 10, 5, 1, 4, 18, 13]
					}],
				})).render();
			});
			// @formatter:on
		</script>
		<script>
			// @formatter:off
			document.addEventListener("DOMContentLoaded", function() {
				window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-2'), {
					chart: {
						type: "line",
						fontFamily: 'inherit',
						height: 24,
						animations: {
							enabled: false
						},
						sparkline: {
							enabled: true
						},
					},
					tooltip: {
						enabled: false,
					},
					stroke: {
						width: 2,
						lineCap: "round",
					},
					series: [{
						color: "#206bc4",
						data: [13, 11, 19, 22, 12, 7, 14, 3, 21]
					}],
				})).render();
			});
			// @formatter:on
		</script>
		<script>
			// @formatter:off
			document.addEventListener("DOMContentLoaded", function() {
				window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-3'), {
					chart: {
						type: "line",
						fontFamily: 'inherit',
						height: 24,
						animations: {
							enabled: false
						},
						sparkline: {
							enabled: true
						},
					},
					tooltip: {
						enabled: false,
					},
					stroke: {
						width: 2,
						lineCap: "round",
					},
					series: [{
						color: "#206bc4",
						data: [10, 13, 10, 4, 17, 3, 23, 22, 19]
					}],
				})).render();
			});
			// @formatter:on
		</script>
		<script>
			// @formatter:off
			document.addEventListener("DOMContentLoaded", function() {
				window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-4'), {
					chart: {
						type: "line",
						fontFamily: 'inherit',
						height: 24,
						animations: {
							enabled: false
						},
						sparkline: {
							enabled: true
						},
					},
					tooltip: {
						enabled: false,
					},
					stroke: {
						width: 2,
						lineCap: "round",
					},
					series: [{
						color: "#206bc4",
						data: [6, 15, 13, 13, 5, 7, 17, 20, 19]
					}],
				})).render();
			});
			// @formatter:on
		</script>
		<script>
			// @formatter:off
			document.addEventListener("DOMContentLoaded", function() {
				window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-5'), {
					chart: {
						type: "line",
						fontFamily: 'inherit',
						height: 24,
						animations: {
							enabled: false
						},
						sparkline: {
							enabled: true
						},
					},
					tooltip: {
						enabled: false,
					},
					stroke: {
						width: 2,
						lineCap: "round",
					},
					series: [{
						color: "#206bc4",
						data: [2, 11, 15, 14, 21, 20, 8, 23, 18, 14]
					}],
				})).render();
			});
			// @formatter:on
		</script>
		<script>
			// @formatter:off
			document.addEventListener("DOMContentLoaded", function() {
				window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-6'), {
					chart: {
						type: "line",
						fontFamily: 'inherit',
						height: 24,
						animations: {
							enabled: false
						},
						sparkline: {
							enabled: true
						},
					},
					tooltip: {
						enabled: false,
					},
					stroke: {
						width: 2,
						lineCap: "round",
					},
					series: [{
						color: "#206bc4",
						data: [22, 12, 7, 14, 3, 21, 8, 23, 18, 14]
					}],
				})).render();
			});
			// @formatter:on
		</script>
		<style>
			*,
			*:before,
			*:after {
				box-sizing: border-box;
			}

			html,

			.only-so-big p {
				padding: 0;
				margin: 0;
			}

			.only-so-big {
				/* background: rgba(178, 252, 255, .3); */
				height: 100%;
				width: auto;
				max-height: 45px;
				max-width: 200px;
				overflow: hidden;
				-webkit-transition: max-height .75s;
				transition: max-height .75s;
			}

			.read-more {
				background: none;
				border: none;
				color: #1199f9;
				cursor: pointer;
				font-size: 1em;
				outline: none;
			}

			.read-more:hover {
				text-decoration: underline;
			}

			.read-more:focus {
				outline: none;
			}

			.read-more::-moz-focus-inner {
				border: 0;
			}

			.hid {
				display: none;
			}
		</style>
		</body>

		</html>
