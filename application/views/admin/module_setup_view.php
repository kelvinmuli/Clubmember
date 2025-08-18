<div class="page-wrapper">
    <div class="container-fluid">			
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
				<div class="col">
					<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						<li class="breadcrumb-item"><a href="<?=base_url()?>">Website</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url('home')?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url('all-maintenance')?>"><?=$moduleMenu->name?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?=$subModuleMenu->name?></li>
					</ol>
              	</div>

                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-success d-none d-sm-inline-block btn-pill" data-bs-toggle="modal" data-bs-target="#modal-module-setup">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add <?=$subModuleMenu->name?>
                        </a>
                        <a href="#" class="btn btn-success d-sm-none btn-icon btn-pill" data-bs-toggle="modal" data-bs-target="#modal-module-setup" aria-label="Add <?=$subModuleMenu->name?>">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                        </a>
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
                            <h3 class="card-title"><?=$subModuleMenu->name?></h3>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="table-responsive">
                                <table id="module-setup-datatable" class="table card-table table-vcenter text-nowrap datatable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>			
                                            <th>Module Type</th>				
                                            <th>Maintenance</th>
                                            <th>Status</th>
                                            <th>Created At</th>	
                                            <th>Actions</th>	
                                        </tr>
                                    </thead>
                                    <tbody>											
                                        <?php $count=1; if(!empty($maintenanceData)): foreach($maintenanceData as $maintenance): ?>
                                            <tr>
                                                <td><?=$count++.'.'?></td>
                                                <td><?=get_table('m_module_type', 'module_type_id', $maintenance->module_type_id, 'name')?></td>
                                                <td><?=get_broken_name($maintenance->name, '_', 1)?></td>
                                                <td><span class="badge badge-outline text-<?=$maintenance->active == 1 ? 'success' : 'danger'?> me-1"><?=get_table('m_active', 'num', $maintenance->active, 'name')?></span></td>
                                                <td><?=$maintenance->created_at?></td>
                                                <td>
													<span class="dropdown">
														<button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
														<div class="dropdown-menu dropdown-menu-end">
                                                            <?php if ($editUserRight): ?>
																<a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-edit-institution-<?=$maintenance->maintenance_id?>">Edit</a>
															<?php endif; ?>
                                                            <?php if ($removeUserRight): ?>
																<a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-user-delete-<?=$maintenance->maintenance_id?>"><span style="color: red;">Delete</span></a>
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

    <div class="modal modal-blur fade" id="modal-module-setup" name="modal-module-setup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?=$subModuleMenu->name?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?=base_url('add-module-setup');?>" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="modal-body">								
                            <div class="row">
                                <input id="maintenance_id" name="maintenance_id" value="<?=generate_uuid()?>" hidden>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Module Type</label>
                                        <select class="form-select" id="module_type_id" name="module_type_id" required>
                                            <option value="0" selected disabled>Select Module Type</option>
                                            <?php if(isset($moduleTypeData)): foreach($moduleTypeData as $key => $data): ?>
                                                <option value="<?=$data->module_type_id?>"><?=$data->name?></option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Maintenance</label>
                                        <select id="name" name="name[]" class="form-select" style="width: 100%;" multiple required>
											<!-- <option value="" selected disabled>Select Maintenance</option> -->
                                            <?php if (isset($maintenanceGroupTableData)): foreach($maintenanceGroupTableData as $key => $maintenanceGroup): ?>
												<optgroup label="<?=get_table('m_module_type', 'module_type_id', $key, 'name')?>">
													<?php if (isset($maintenanceGroup)): foreach($maintenanceGroup as $maintenance): ?>
														<option value="<?=$maintenance?>" required><?=get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1))?></option>
													<?php endforeach; endif; ?>
												</optgroup>
											<?php endforeach; endif; ?>
                                        </select>
                                    </div>										
                                </div>	
                            </div>						
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="10" y1="14" x2="21" y2="3" /><path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
                            Add <?=$subModuleMenu->name?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

	<script>
		$(document).ready(function() {
			$('#name').select2({
				dropdownParent: $("#modal-module-setup")
			});
			loadDatatable('module-setup-datatable');
		});
	</script>
