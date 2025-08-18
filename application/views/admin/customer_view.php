<div class="page-wrapper">
    <div class="container-fluid">			
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
				<div class="col">
					<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						<li class="breadcrumb-item"><a href="<?=base_url()?>">Website</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url('home')?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url('customer')?>"><?=$moduleMenu->name?></a></li>
					</ol>
              	</div>

                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
						<?php if ($inputUserRight): ?>
							<a class="btn btn-success d-none d-sm-inline-block btn-pill" onclick="addCustomerModal()">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add <?=$moduleMenu->name?>
							</a>
							<a class="btn btn-success d-sm-none btn-icon btn-pill" onclick="addCustomerModal()" aria-label="Add <?=$moduleMenu->name?>">
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
                        </div>

                        <div class="card-body border-bottom py-3">
                            <div class="table-responsive">
                                <table id="customer-datatable" class="table card-table table-vcenter text-nowrap datatable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="w-1">#</th>
											<th>Logo</th>
											<th>Customer Name</th>
											<th>Reg. No.</th>
											<th>Email Address</th>
											<th>Tel No.</th>
											<th>Country</th>
											<th>Agreement</th>
											<th>Status</th>
											<?php if ($editUserRight || $removeUserRight): ?>
												<th>Actions</th>	
											<?php endif; ?>
                                        </tr>
                                    </thead>
                                   <tbody class="table-tbody">
										<?php $c = 0; if (isset($customerData)): foreach ($customerData as $customer): ?>
											<tr>
												<td><?=++$c?></td>
												<td><span class="avatar avatar-xs me-2" style="background-image: url('<?=base_url($customer->logo)?>')"></span></td>
												<td><?=$customer->full_legal_name?></td>
												<td><?=$customer->reg_no?></td>
												<td><?=$customer->email?></td>
												<td><?=$customer->phone_number?></td>
												<td><?=get_table('m_country', 'country_id', $customer->country_id, 'name')?></td>
												<td><a href="<?=base_url($customer->agreement)?>" target="_blank">Download</a></td>
												<td><?=get_table('m_customer_status', 'customer_status_id', $customer->customer_status_id, 'name')?></td>
												<?php if ($editUserRight || $removeUserRight): ?>
													<td class="text-end">
														<span class="dropdown">
															<button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="true">Actions</button>
															<div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 38px);">
																<?php if ($editUserRight): ?>
																	<a class="dropdown-item" onclick="editCustomerModal('<?=$customer->customer_id?>')">Update</a>
																<?php endif; if ($removeUserRight): ?>
																	<a class="dropdown-item" onclick="removeCustomerModal('<?=$customer->customer_id?>')">Delete</a>
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

	<div class="modal modal-blur fade" id="modal-view-edit-print-customer" tabindex="-1" role="dialog" aria-hidden="true"></div>

	<script>
		$(document).ready(function() {
			loadDatatable('customer-datatable');
		});

		function addCustomerModal() {
			$.ajax({
				url: base_url + "add-customer-modal",
				success: function(response) {
					document.getElementById('modal-view-edit-print-customer').innerHTML = response;
					$('#modal-view-edit-print-customer').modal('show');
				}
			});
		}

		function editCustomerModal(customer_id) {
			$.ajax({
				url: base_url + "edit-customer-modal/" + customer_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-customer').innerHTML = response;
					$('#modal-view-edit-print-customer').modal('show');
				}
			});
		}

		function removeCustomerModal(customer_id) {
			$.ajax({
				url: base_url + "remove-customer-modal/" + customer_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-customer').innerHTML = response;
					$('#modal-view-edit-print-customer').modal('show');
				}
			});
		}
	</script>
