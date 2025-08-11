<div class="page-wrapper">
    <div class="container-xl">			
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
				<div class="col py-3">
					<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						<li class="breadcrumb-item"><a href="<?=base_url()?>">Website</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">Backend</a></li>
						<li class="breadcrumb-item"><?=$moduleMenu->name?></li>
						<li class="breadcrumb-item active" aria-current="page"><?=$subModuleMenu->name?></li>
					</ol>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-success d-none d-sm-inline-block btn-pill" onclick="addMaintenanceColumnNamingModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Add <?=$subModuleMenu->name?>
                        </a>
                        <a href="#" class="btn btn-success d-sm-none btn-icon btn-pill" onclick="addMaintenanceColumnNamingModal()" aria-label="Naming Structure">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">			
                <div class="col-12">	
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?=$subModuleMenu->name?></h3>
                        </div>

                        <div class="card-body border-bottom py-3">
                            <div class="table-responsive">
                                <table id="maintenance-column-naming-datatable" class="table card-table table-vcenter text-nowrap datatable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>		
                                            <th>Maintenance Name</th>
                                            <th>Column Name</th>	
                                            <th>Real Name</th>
                                            <th>Status</th>
                                            <th>Created At</th>	
                                            <th>Actions</th>	
                                        </tr>
                                    </thead>
                                    <tbody>											
                                        <?php $mcn = 0; if (isset($maintenanceColumnNamingData)): foreach($maintenanceColumnNamingData as $maintenanceColumnNaming): ?>
                                            <tr>
                                                <td><?=++$mcn?>.</td>
                                                <td><?=get_maintenance_naming($maintenanceColumnNaming->maintenance, 'name', get_broken_name($maintenanceColumnNaming->maintenance, '_', 1))?></td>
												<td><?=get_broken_name($maintenanceColumnNaming->column_name, '_')?></td>
                                                <td><?=$maintenanceColumnNaming->name?></td>
                                                <td><span class="badge badge-outline text-<?=$maintenanceColumnNaming->active == 1 ? 'success' : 'danger'?>"><?=get_table('m_active', 'num', $maintenanceColumnNaming->active, 'name')?></span></td>
                                                <td><?=$maintenanceColumnNaming->created_at?></td>
                                                <td>
													<span class="dropdown">
														<button class="btn dropdown-toggle align-text-top btn-pill" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
														<div class="dropdown-menu dropdown-menu-end">
                                                            <?php if ($editUserRight): ?>
																<a class="dropdown-item" onclick="editMaintenanceColumnNamingModal('<?=$maintenanceColumnNaming->maintenance_column_naming_id?>')">Edit <?=get_maintenance_naming($maintenanceColumnNaming->maintenance, 'name', get_broken_name($maintenanceColumnNaming->maintenance, '_', 1))?></a>
															<?php endif; ?>
														</div>
													</span>
												</td>
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
			loadDatatable('maintenance-column-naming-datatable');

		});

		function addMaintenanceColumnNamingModal() {	
			$.ajax({
				url: base_url + "add-maintenance-column-naming-modal/",
				success: function(response) {
					document.getElementById('modal-view-edit-print-maintenance').innerHTML = response;
					$('#modal-view-edit-print-maintenance').modal('show');
					$('#add_maintenance').on('change', function() {
						$.ajax({
							url: base_url + "get-maintenance-column-html/" + $(this).val(),
							success: function(leadPlotHtml) {
								document.getElementById('column_name_container').innerHTML = leadPlotHtml;
							}
						});
					});
				}
			});
		}

		function editMaintenanceColumnNamingModal(maintenance_column_naming_id) {	
			$.ajax({
				url: base_url + "edit-maintenance-column-naming-modal/" + maintenance_column_naming_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-maintenance').innerHTML = response;
					$('#modal-view-edit-print-maintenance').modal('show');
				}
			});
		}
	</script>
