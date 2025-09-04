<?php $userTypeName = empty($userTypeId) ? 'N/A' : get_table('m_user_type', 'user_type_id', $userTypeId, 'name'); ?>
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
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add Membership Fee Type
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
							<h3 class="card-title"><?=$moduleMenu->name?></h3>
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
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php $s = 0; if (isset($subscriptionData) && !empty($subscriptionData)): foreach($subscriptionData as $data): ?>
											<tr>
												<td class="w-1"><?=++$s?>.</td>
												<td><?= get_table($customerDBSettingRow->database_name.'.user', 'user_id', $data->user_id, 'full_legal_name')?></td>
												<td><?= get_table($customerDBSettingRow->database_name.'.membership_fee_type', 'membership_fee_type_id', $data->membership_fee_type_id, 'name')?></td>
												<td><?= $data->due_at ?></td>
												<td><?= $data->payment_at ?></td>
												<td><?= get_table('m_currency', 'currency_id', $data->currency_id, 'sign')?></td>
												<td><?= $data->amount ?></td>
												<td>Unpaid</td>
												<td><?= $data->created_at ?></td>
												<td></td>
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

	<div class="modal modal-blur fade" id="modal-view-edit-print-subscription" tabindex="-1" role="dialog" aria-hidden="true"></div>

	<script>
		$(document).ready(function() {
			loadDatatable('subscription-datatable');
		});

		function addSubscriptionModal() {
			$.ajax({
				url: base_url + "add-subscription-modal",
				success: function(response) {
					document.getElementById('modal-view-edit-print-subscription').innerHTML = response;
					$('#modal-view-edit-print-subscription').modal('show');
					$("#membership_fee_type_id").change(function() {
						$.ajax({
							url: base_url + "get-membership-fee-type/" + $(this).val(),
							success: function(response) {
								alert(response);	
								const object = JSON.parse(response);
								document.getElementById("amount").value = object.amount;
							}
						});
					});
				}
			});
		}

		function addMembershipFeeType() {
			$.ajax({
				url: base_url + "add-membership-fee-type-modal",
				success: function(response) {
					document.getElementById('modal-view-edit-print-subscription').innerHTML = response;
					$('#modal-view-edit-print-subscription').modal('show');
				}
			});
		}
	</script>
