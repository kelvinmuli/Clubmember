<?php
	$isPaid = ($paymentHistoryRow->payment_status_id ?? '') === '1732371146921';
	$statusLabel = $isPaid ? 'Paid' : 'Unpaid';
	$statusStyle = $isPaid ? 'background-color:#198754;color:#ffffff;' : 'background-color:#ffc107;color:#212529;';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Subscription Receipt</title>
	</head>
	<body style="margin:0;padding:0;background-color:#f5f6f8;">
		<center>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f5f6f8;">
				<tr>
					<td align="center" style="padding:24px 16px;">
						<table width="680" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:680px;">
							<?php if (!empty($showReceiptActions)) : ?>
							<tr>
								<td align="right" style="padding:0 0 12px 0;" id="receipt-action-bar">
									<table cellpadding="0" cellspacing="0" border="0" style="margin-left:auto;">
										<tr>
											<td style="padding-right:8px;">
												<a href="javascript:void(0)" onclick="return downloadWholeBodyPdf(this);" style="display:inline-block;padding:8px 12px;border:1px solid #ced4da;border-radius:4px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#4b5563;text-decoration:none;">Download PDF</a>
											</td>
											<td>
												<a href="javascript:void(0)" onclick="window.print()" style="display:inline-block;padding:8px 12px;border:1px solid #2563eb;border-radius:4px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#2563eb;text-decoration:none;">Print</a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<?php endif; ?>
							<tr>
								<td>
									<table width="680" cellpadding="0" cellspacing="0" border="0" id="subscription-receipt-content" style="width:100%;max-width:680px;background-color:#ffffff;border:1px solid #e6e8eb;border-radius:6px;">
							<tr>
								<td style="padding:24px 24px 8px 24px;">
									<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td align="left" style="vertical-align:middle;">
												<img src="<?= base_url($customerRow->logo)?>" alt="Logo" width="120" style="display:block;border:0;max-width:120px;height:auto;">
											</td>
											<td align="right" style="vertical-align:middle;">
												<span style="display:inline-block;padding:6px 12px;border-radius:999px;font-size:12px;letter-spacing:0.4px;text-transform:uppercase;<?=$statusStyle?>"><?=$statusLabel?></span>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding:0 24px 16px 24px;">
									<h2 style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:20px;font-weight:600;color:#111827;">Invoice Receipt</h2>
									<p style="margin:6px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#6b7280;">Invoice INV/<?=substr($paymentHistoryRow->user_id, -4)?></p>
								</td>
							</tr>
							<tr>
								<td style="padding:0 24px 16px 24px;">
									<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td width="50%" style="vertical-align:top;padding-right:12px;">
												<p style="margin:0 0 8px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:600;color:#111827;">Organisation</p>
												<p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:1.6;color:#374151;">
													<?=$customerRow->full_legal_name?><br />
													<?=$customerRow->email?>
												</p>
											</td>
											<td width="50%" style="vertical-align:top;padding-left:12px;">
												<p style="margin:0 0 8px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:600;color:#111827;">Member Details</p>
												<p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:1.6;color:#374151;">
													<strong>Name:</strong> <?=$userRow->full_legal_name?><br />
													<strong>Email:</strong> <?=$userRow->email?><br />
													<strong>Membership No:</strong> <?=$userRow->membership_no?><br />
													<strong>Street Name:</strong> <?=$userRow->street_name?><br />
												</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding:0 24px 16px 24px;">
									<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td width="50%" style="vertical-align:top;padding-right:12px;">
												<p style="margin:0 0 8px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:600;color:#111827;">Subscription Details</p>
												<p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:1.6;color:#374151;">
													<strong>Year:</strong> <?=!empty($membershipFeeTypeRow->year) ? $membershipFeeTypeRow->year : 'Not set'?><br />
													<strong>Start Date:</strong> <?=!empty($subscriptionRow->start_at) ? date('d M Y', strtotime($subscriptionRow->start_at)) : 'Not set'?><br />
													<strong>End Date:</strong> <?=!empty($subscriptionRow->due_at) ? date('d M Y', strtotime($subscriptionRow->due_at)) : 'Not set'?><br />
												</p>
											</td>
											<td width="50%" style="vertical-align:top;padding-left:12px;">
												<p style="margin:0 0 8px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:600;color:#111827;">Receipt Summary</p>
												<p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:1.6;color:#374151;">
													<strong>Product:</strong> <?=$membershipFeeTypeRow->name?><br />
													<strong>Quantity:</strong> 1<br />
													<strong>Amount:</strong> <?='KES ' . number_format($paymentHistoryRow->paid_amount, 2)?><br />
												</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding:0 24px 24px 24px;">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #e5e7eb;">
										<tr style="background-color:#f9fafb;">
											<td style="padding:10px;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;color:#111827;">Product</td>
											<td style="padding:10px;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;color:#111827;" align="center">Qnt</td>
											<td style="padding:10px;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;color:#111827;" align="right">Unit</td>
											<td style="padding:10px;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;color:#111827;" align="right">Amount (KES)</td>
										</tr>
										<tr>
											<td style="padding:10px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#374151;"><?=$membershipFeeTypeRow->name?></td>
											<td style="padding:10px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#374151;" align="center">1</td>
											<td style="padding:10px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#374151;" align="right"><?='KES ' . number_format($paymentHistoryRow->paid_amount, 2)?></td>
											<td style="padding:10px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#374151;" align="right"><?='KES ' . number_format($paymentHistoryRow->paid_amount, 2)?></td>
										</tr>
										<tr>
											<td colspan="3" style="padding:10px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#111827;" align="right">Subtotal (KES)</td>
											<td style="padding:10px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#111827;" align="right"><?='KES ' . number_format($paymentHistoryRow->paid_amount, 2)?></td>
										</tr>
										<tr>
											<td colspan="3" style="padding:10px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:700;color:#111827;" align="right">Total Due (KES)</td>
											<td style="padding:10px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:700;color:#111827;" align="right"><?='KES ' . number_format($paymentHistoryRow->paid_amount, 2)?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding:0 24px 24px 24px;">
									<p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#6b7280;text-align:center;">Thank you very much for doing business with us. We look forward to working with you again!</p>
								</td>
							</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</center>
		<?php if (!empty($showReceiptActions)) : ?>
		<script>
			(function () {
				function ensureHtml2Canvas() {
					if (window.html2canvas) {
						return Promise.resolve();
					}
					return new Promise(function (resolve, reject) {
						var script = document.createElement('script');
						script.src = 'https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js';
						script.onload = resolve;
						script.onerror = reject;
						document.head.appendChild(script);
					});
				}

				window.downloadWholeBodyPdf = function (anchorEl) {
					var originalLabel = anchorEl ? anchorEl.innerHTML : '';
					if (anchorEl) {
						anchorEl.innerHTML = 'Preparing PDF...';
						anchorEl.style.pointerEvents = 'none';
					}

					var actionBar = document.getElementById('receipt-action-bar');
					var previousDisplay = actionBar ? actionBar.style.display : '';
					if (actionBar) {
						actionBar.style.display = 'none';
					}

					ensureHtml2Canvas()
						.then(function () {
							return window.html2canvas(document.body, {
								scale: 2,
								useCORS: true,
								backgroundColor: '#f5f6f8'
							});
						})
						.then(function (canvas) {
							var form = document.createElement('form');
							form.method = 'POST';
							form.action = '<?= site_url('payment-receipt-pdf') ?>';
							form.style.display = 'none';

							var imageInput = document.createElement('input');
							imageInput.type = 'hidden';
							imageInput.name = 'imageData';
							imageInput.value = canvas.toDataURL('image/jpeg', 0.95);
							form.appendChild(imageInput);

							var titleInput = document.createElement('input');
							titleInput.type = 'hidden';
							titleInput.name = 'title';
							titleInput.value = 'Subscription Receipt';
							form.appendChild(titleInput);

							document.body.appendChild(form);
							form.submit();
							form.remove();
						})
						.catch(function () {
							alert('Could not generate PDF. Please try again.');
						})
						.finally(function () {
							if (actionBar) {
								actionBar.style.display = previousDisplay;
							}
							if (anchorEl) {
								anchorEl.innerHTML = originalLabel;
								anchorEl.style.pointerEvents = '';
							}
						});

					return false;
				};
			})();
		</script>
		<?php endif; ?>
	</body>
</html>
