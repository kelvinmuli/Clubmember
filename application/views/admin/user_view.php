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
						<?php if (isset($userTypeId)): ?>
							<li class="breadcrumb-item active" aria-current="page"><?=$userTypeName?></li>
						<?php endif; ?>
					</ol>
              	</div>

				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">
						<?php if ($inputUserRight): ?>
							<div class="col-lg-5">
								<span class="dropdown">
									<button class="btn btn-success dropdown-toggle align-text-top btn-pill" data-bs-boundary="viewport" data-bs-toggle="dropdown">Add New <?=$userTypeName?></button>
									<div class="dropdown-menu dropdown-menu-end">
										<?php if (isset($membershipTypeData)): foreach ($membershipTypeData as $key => $value): ?>
											<a href="#" class="dropdown-item" onclick="addUserModal('<?=$userTypeId?>', '<?=$value->membership_type_id?>')">
												<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add <?=$value->name?>
											</a>
										<?php endforeach; endif; ?>
									</div>
								</span>
							</div>
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
							<h3 class="card-title"><?=isset($userTypeId) ? 'All '.$userTypeName.'s' : $moduleMenu->name?></h3>
							<div class="col-auto ms-auto d-print-none">
								<div class="btn-list">		
										<select id="customer_db_setting_id" name="customer_db_setting_id" class="form-select btn-pill">
											<option selected disabled>Select Customer</option>
											<?php if (isset($customerDBSettingData)): foreach($customerDBSettingData as $customerDBSetting): ?>
												<option value="<?=$customerDBSetting->customer_db_setting_id?>" <?=($customerDBSetting->customer_db_setting_id == $customerDBSettingId) ? 'selected' : ''?>><?=get_table('customer', 'customer_id', $customerDBSetting->customer_id, 'full_legal_name')?></option>
											<?php  endforeach; endif; ?>
										</select>
								</div>
							</div>
						</div>

						<div class="card-body border-bottom py-3">
							<div class="table-responsive">
								<table id="user-datatable" class="table table-vcenter text-nowrap">
									<thead>
										<tr>
											<th class="w-1">#</th>											
											<th>Full Legal Name</th>
											<th>Phone Number</th>
											<th>Email</th>
											<th>Membership No.</th>
											<th>Residental Address</th>
											<th>Created At</th>									
											<th>Actions</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal modal-blur fade" id="modal-view-edit-print-user" tabindex="-1" role="dialog" aria-hidden="true"></div>

	<script>
		$(document).ready(function() {
			loadUserDatatable('<?=$customerDBSettingId?>');
			$("#customer_db_setting_id").change(function() {
				loadUserDatatable($(this).val());
			});
		});

		function loadUserDatatable(customer_db_setting_id) {
			$('#user-datatable').DataTable({
				displayLength: <?=isset($numericSelectData[0]) ? $numericSelectData[0]->num : GlobalModel::NUMERIC_SELECT_HUNDRED?>,
				paging: true,
				searching: true,
				info: true,
				// columnDefs: [{ orderable: false, targets: 'no-search', searchable: false }],
				// order: [[ 2, 'ASC' ]],
				language: 
				{
					emptyTable: 	'<span class="badge bg-red-lt">No Records</span>',
					zeroRecords: 	'<span class="badge bg-red-lt">Nothing found. Please change your search term</span>',
					paginate: 
					{
						previous: 	'<ul class="pagination">'+
										'<li class="page-item disabled">'+
											'<a class="page-link" href="#" tabindex="-1" aria-disabled="true">'+
												'<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>'+
											'Prev </a>'+
										'</li>'+
									'</ul>',

							next: 	'<ul class="pagination">'+
										'<li class="page-item">'+
											'<a class="page-link" href="#"> Next'+
												'<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg>'+
											'</a>'+
										'</li>'+
									'</ul>',
					},
					sLengthMenu: 	'<div class="text-muted py-2">Show<div class="mx-2 d-inline-block ">'+
										'<select class="form-select form-control-rounded">'+
											'<?php if (isset($numericSelectData)): foreach($numericSelectData as $data): ?>'+
												'<option value="<?=$data->num?>"><?=$data->name?></option>'+
											'<?php endforeach; endif; ?>'+
											'<option value="-1">All</option>'+
										'</select>'+
									'</div>entries</div>'

				},
				destroy: true,
				ajax: {
					url: base_url + 'get-user-list/<?=$userTypeId?>/' + customer_db_setting_id,
					type: 'GET'
				}
			});
		}

		function addUserModal(user_type_id, membership_type_id) {
			$.ajax({
				url: base_url + "add-user-modal/" + user_type_id + "/" + membership_type_id + "/" + $('#customer_db_setting_id').val(),
				success: function(response) {
					document.getElementById('modal-view-edit-print-user').innerHTML = response;
					$('#modal-view-edit-print-user').modal('show');
				}
			});
		}

		function deleteUserModal(user_id) {
			$.ajax({
				url: base_url + "delete-user-modal/" + user_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-user').innerHTML = response;
					$('#modal-view-edit-print-user').modal('show');
				}
			});
		}

		function addUserPaymentDepositModal(user_id, property_id) {
			$.ajax({
				url: base_url + "add-user-payment-deposit-modal/" + user_id + "/" + property_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-user').innerHTML = response;
					$('#modal-view-edit-print-user').modal('show');
					loadRichTextEditor('remark');
				}
			});
		}

		function addUserPaymentInstallmentModal(user_id, property_id) {
			$.ajax({
				url: base_url + "add-user-payment-installment-modal/" + user_id + "/" + property_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-user').innerHTML = response;
					$('#modal-view-edit-print-user').modal('show');
					loadRichTextEditor('remark');
				}
			});
		}

		function editUserPaymentDepositInstallmentModal(payment_history_id) {
			$.ajax({
				url: base_url + "edit-user-payment-deposit-installment-modal/" + payment_history_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-user').innerHTML = response;
					$('#modal-view-edit-print-user').modal('show');
					loadRichTextEditor('remark');
				}
			});
		}

		function editUserPropertyPlotPaymentStatusModal(user_property_plot_id) {
			$.ajax({
				url: base_url + "edit-user-property-plot-payment-status-modal/" + user_property_plot_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-user').innerHTML = response;
					$('#modal-view-edit-print-user').modal('show');
				}
			});
		}

		function viewUserOfferLetterModal(user_id, user_property_plot_id) {
			$.ajax({
				url: base_url + "view-user-offer-letter-modal/" + user_id + "/" + user_property_plot_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-user').innerHTML = response;
					$('#modal-view-edit-print-user').modal('show');
				}
			});
		}

		function ViewUserPropertyPaymentHistoryModal(user_id, property_id='') {
			$.ajax({
				url: base_url + "view-user-property-payment-history-modal/" + user_id + "/" + property_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-user').innerHTML = response;
					$('#modal-view-edit-print-user').modal('show');
					loadDatatable('user-property-payment-history-datatable', '<?=$userTypeName?>');
				}
			});
		}
	</script>
