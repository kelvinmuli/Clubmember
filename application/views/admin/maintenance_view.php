<div class="page-wrapper">
    <div class="container-fluid">			
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row align-items-center">
				<div class="col">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
							<li class="breadcrumb-item"><a href="<?=base_url()?>">Website</a></li>
							<li class="breadcrumb-item"><a href="<?=base_url('home')?>">Home</a></li>
							<li class="breadcrumb-item"><?=$moduleMenu->name?></li>
							<li class="breadcrumb-item active" aria-current="page"><?=get_table('m_module_type', 'module_type_id', $module_type_id, 'name')?></li>
						</ol>
					</nav>
              	</div>
				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">
						<!-- <span class="d-none d-sm-inline">
							<a href="#" class="btn btn-white">
							New view
							</a>
						</span> -->
						<button class="btn btn-success d-none d-sm-inline-block btn-pill" onclick="addModuleSetupModal('<?=$module_type_id?>')">
                            <svg xmlns="http://www.w3.org/200/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add <?=get_table('m_module_type', 'module_type_id', $module_type_id, 'name')?> Setup
						</button>
                        <button class="btn btn-success d-sm-none btn-icon btn-pill" onclick="addModuleSetupModal('<?=$module_type_id?>')" aria-label="Add Module Setup">
                            <svg xmlns="http://www.w3.org/200/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                        </button>
					</div>
				</div>
            </div>
        </div>
    </div>

        <div class="page-body">
			<div class="container-fluid">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title"><?=get_table('m_module_type', 'module_type_id', $module_type_id, 'name')?></h3>
					</div>			

					<div class="card-body">
						<?php if ($systemRow->maintenance_layout_id == '1754841678707'): ?>
							<div class="card-header">
								<ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
									<?php if (isset($sustenanceData)): foreach($sustenanceData as $key => $maintenance):  $tableName = get_broken_name($maintenance, '_', 1);?>
										<li class="nav-item">
											<a href="#tabs-<?=$key?>" class="nav-link <?=$selected == $maintenance || empty($selected) && $key == 0 ? 'active' : ''?>" data-bs-toggle="tab"><?=get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1))?></a>
										</li>
									<?php endforeach; endif; ?> 
								</ul>
							</div>
							<div class="tab-content">
								<?php if (isset($sustenanceData)): foreach($sustenanceData as $key => $maintenance):  $tableName = get_broken_name($maintenance, '_', 1);?>
									<div id="tabs-<?=$key?>" class="tab-pane fade <?=$selected == $maintenance || empty($selected) && $key == 0 ? 'active show' : ''?>">
										<h4 hidden><?=get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1))?></h4>
										<div>
											<div class="row align-items-center">
												<div class="col-auto ms-auto d-print-none py-2">
													<div class="btn-list">
														<?php if ($inputUserRight && !get_sys_control(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), 'input', 1)): ?>
															<a class="btn btn-success d-none d-sm-inline-block btn-pill" onclick="addMaintenanceModal('<?=$module_type_id?>', '<?=$maintenance?>')">
																<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
																Add <?=get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1))?>
															</a>
															<a class="btn btn-warning d-sm-none btn-icon" onclick="addMaintenanceModal('<?=$module_type_id?>', '<?=$maintenance?>')" aria-label="Add <?=get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1))?>">
																<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
															</a>
														<?php endif ?>

														<?php if ($maintenance == 'm_country'): ?>
															<a href="https://timezonedb.com/time-zones" target="_blank" class="btn btn-secondary d-none d-sm-inline-block btn-pill">
																<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
																Time Zones
															</a>
															<a href="https://timezonedb.com/time-zones" target="_blank" class="btn btn-secondary d-sm-none btn-icon btn-pill" aria-label="Time Zones">
																<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
															</a>
														<?php endif ?>
													</div>
												</div>
											</div>			

											<div class="card-table table-responsive py-2">
												<table id="maintenance-<?=$maintenance?>-datatable" class="table card-table table-vcenter text-wrap datatable">
													<thead>
														<tr>
															<?php if (isset($maintenanceFieldData[$maintenance])): foreach($maintenanceFieldData[$maintenance] as $maintenanceField): $editSysControl = !get_sys_control(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), 'edit', 1); $removeSysControl = !get_sys_control(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), 'remove', 1); ?>
																<th><?=$maintenanceField->name == 'id' ? '#' : get_maintenance_column_naming($maintenance, $maintenanceField->name, 'name', get_broken_name($maintenanceField->name, '_'))?></th>
															<?php endforeach; endif; if ($editUserRight && $editSysControl || $removeUserRight && $removeSysControl): ?> 
																<th>Action</th>
															<?php endif; ?>
														</tr>
													</thead>
													<?php $pos = 0; if (isset($maintenanceFieldValueData[$maintenance])): foreach($maintenanceFieldValueData[$maintenance] as $maintenanceFieldValue): ?>
														<tr>
															<?php if (isset($maintenanceFieldData[$maintenance])): foreach($maintenanceFieldData[$maintenance] as $maintenanceField): $column = $maintenanceFieldData[$maintenance][1]->name;?>
																<td <?php $name = $maintenanceField->name; $combineColumnToTable = get_combine_column_to_table($name); ?>>
																	<?php if (in_array($name, array('state', 'active'))) { ?>
																		<span class="badge badge-outline text-<?=$maintenanceFieldValue->$name == 1 ? 'green' : 'red'?>"><?=$name == 'state' ? $stateDataArray[$maintenanceFieldValue->$name]->name : $activeDataArray[$maintenanceFieldValue->$name]->name?></span>
																	<?php } elseif (substr($name, -3) == '_id' && !in_array($maintenance, array('m_'.substr($name, 0, -3), 's_'.substr($name, 0, -3))) && !in_array($name, array('column_id'))) { ?>
																		<?=$maintenanceFieldValue->$name != null && isset($maintenanceFinalData[$combineColumnToTable.'Data'][$maintenanceFieldValue->$name]) ? $maintenanceFinalData[$combineColumnToTable.'Data'][$maintenanceFieldValue->$name]->name : (in_array($name, array('maintenance_id')) ? get_table('maintenance', 'maintenance_id', $maintenanceFieldValue->$name, 'name') : 'N/A')?>
																	<?php } elseif (in_array($name, array('main_id'))) { ?>
																		<?=$maintenanceFieldValue->$name != null && isset($maintenanceFinalData['moduleData'][$maintenanceFieldValue->$name]) ? $maintenanceFinalData['moduleData'][$maintenanceFieldValue->$name]->name : 'N/A'?>	
																	<?php } elseif (in_array($name, array('sold_color_id')) && 'm_color' != $maintenance) { ?>
																		<?=$maintenanceFieldValue->$name != null && isset($maintenanceFinalData['colorData'][$maintenanceFieldValue->$name]) ? $maintenanceFinalData['colorData'][$maintenanceFieldValue->$name]->name : 'N/A'?>
																	<?php } elseif (in_array($name, explode(',', get_table('m_column_define', 'column_define_id', '1753528719052', 'multi_column'))) && 'm_choice' != $maintenance) { foreach ($maintenanceFinalData['choiceData'] as $key => $value) { ?>
																		<?=($value->num == $maintenanceFieldValue->$name) ? $value->name : ''; } ?>
																	<?php } elseif (in_array($name, explode(',', get_table('m_column_define', 'column_define_id', '1753524572547', 'multi_column')))) { ?>
																		<a onclick="editMaintenanceImageModal('<?=$module_type_id?>', '<?=$maintenance?>', '<?=$maintenanceFieldValue->$column?>', '<?=$name?>')">
																			<span class="avatar" style="background-image: url(<?=base_url($maintenanceFieldValue->$name)?>)"></span>
																		</a>
																	<?php } elseif (in_array($name, array('user_id'))) { ?>
																		<?=$userData[$maintenanceFieldValue->$name]->full_legal_name ?? 'N/A'?>	
																	<?php } elseif (in_array($name, array('id'))) { ?>	
																		<?=$maintenanceFieldValue->$name.'.'?>																																																										
																	<?php } elseif (in_array($name, explode(',', get_table('m_column_define', 'column_define_id', '1753528816500', 'multi_column')))) { ?>
																		<div class="only-so-big"><?php echo($maintenanceFieldValue->$name); ?></div>
																	<?php } else { echo($maintenanceFieldValue->$name); } ?>
																</td>
															<?php endforeach; endif; $editSysControl = !get_sys_control(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), 'edit', 1); $removeSysControl = !get_sys_control(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), 'remove', 1); if ($editUserRight && $editSysControl || $removeUserRight && $removeSysControl): ?> 
																<td>
																	<?php if ($editUserRight && $editSysControl): ?>
																		<a class="btn btn-blue d-none d-sm-inline-block btn-pill" onclick="editMaintenanceModal('<?=$module_type_id?>', '<?=$maintenance?>', '<?=$maintenanceFieldValue->$column?>')">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z" /><path d="M16 5l3 3" /><path d="M9 7.07a7.002 7.002 0 0 0 1 13.93a7.002 7.002 0 0 0 6.929 -5.999" /></svg> Edit
																		</a>
																		<a class="btn btn-blue d-sm-none btn-icon" onclick="editMaintenanceModal('<?=$module_type_id?>', '<?=$maintenance?>', '<?=$maintenanceFieldValue->$column?>')" aria-label="Edit">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z" /><path d="M16 5l3 3" /><path d="M9 7.07a7.002 7.002 0 0 0 1 13.93a7.002 7.002 0 0 0 6.929 -5.999" /></svg>
																		</a>
																	<?php endif; if ($removeUserRight && $removeSysControl): ?>
																		<a class="btn btn-red d-none d-sm-inline-block btn-pill" onclick="removeMaintenanceModal('<?=$module_type_id?>', '<?=$maintenance?>', '<?=$maintenanceFieldValue->$column?>')">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
																		</a>
																		<a class="btn btn-red d-sm-none btn-icon" onclick="removeMaintenanceModal('<?=$module_type_id?>', '<?=$maintenance?>', '<?=$maintenanceFieldValue->$column?>')" aria-label="Delete">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
																		</a>
																	<?php endif; ?>
																</td>
															<?php endif; ?>
														</tr>
													<?php endforeach; endif; ?> 
												</table>
											</div>
										</div>
									</div>
								<?php endforeach; endif; ?>
							</div>
						<?php else: ?> 
							<div class="accordion accordion-tabs" id="accordion-example">
								<?php $count=1; if (isset($sustenanceData)): foreach($sustenanceData as $key => $maintenance):  $tableName = get_broken_name($maintenance, '_', 1);?>
									<div class="accordion-item">
										<h3 class="accordion-header" id="heading-1">
											<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?=$key?>" aria-expanded="<?=$key==1 ? 'true' : 'false'?>">
												<?=($key+1).'. '.get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1))?>
												<div class="accordion-button-toggle">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M6 9l6 6l6 -6" /></svg>
												</div>
											</button>
										</h3>

										<div id="collapse-<?=$key?>" class="accordion-collapse collapse <?=($selected == $maintenance || !isset($selected) && $key == 0 ? 'show' : 'hide')?>" data-bs-parent="#accordion-example">
											<div class="accordion-body pt-0">
												<div class="row align-items-center">
													<div class="col-auto ms-auto d-print-none py-2">
														<div class="btn-list">
															<?php if ($inputUserRight && !get_sys_control(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), 'input', 1)): ?>
																<a class="btn btn-success d-none d-sm-inline-block btn-pill" onclick="addMaintenanceModal('<?=$module_type_id?>', '<?=$maintenance?>')">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
																	Add <?=get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1))?>
																</a>
																<a class="btn btn-warning d-sm-none btn-icon" onclick="addMaintenanceModal('<?=$module_type_id?>', '<?=$maintenance?>')" aria-label="Add <?=get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1))?>">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
																</a>
															<?php endif ?>

															<?php if ($maintenance == 'm_country'): ?>
																<a href="https://timezonedb.com/time-zones" target="_blank" class="btn btn-secondary d-none d-sm-inline-block btn-pill">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
																	Time Zones
																</a>
																<a href="https://timezonedb.com/time-zones" target="_blank" class="btn btn-secondary d-sm-none btn-icon btn-pill" aria-label="Time Zones">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
																</a>
															<?php endif ?>
														</div>
													</div>
												</div>			

												<div class="card-table table-responsive py-2">
													<table id="maintenance-<?=$maintenance?>-datatable" class="table card-table table-vcenter text-wrap datatable">
														<thead>
															<tr>
																<?php if (isset($maintenanceFieldData[$maintenance])): foreach($maintenanceFieldData[$maintenance] as $maintenanceField): $editSysControl = !get_sys_control(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), 'edit', 1); $removeSysControl = !get_sys_control(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), 'remove', 1); ?>
																	<th><?=$maintenanceField->name == 'id' ? '#' : get_maintenance_column_naming($maintenance, $maintenanceField->name, 'name', get_broken_name($maintenanceField->name, '_'))?></th>
																<?php endforeach; endif; if ($editUserRight && $editSysControl || $removeUserRight && $removeSysControl): ?> 
																	<th>Action</th>
																<?php endif; ?>
															</tr>
														</thead>
														<?php $pos = 0; if (isset($maintenanceFieldValueData[$maintenance])): foreach($maintenanceFieldValueData[$maintenance] as $maintenanceFieldValue): ?>
															<tr>
																<?php if (isset($maintenanceFieldData[$maintenance])): foreach($maintenanceFieldData[$maintenance] as $maintenanceField): $column = $maintenanceFieldData[$maintenance][1]->name;?>
																	<td <?php $name = $maintenanceField->name; $combineColumnToTable = get_combine_column_to_table($name); ?>>
																		<?php if (in_array($name, array('state', 'active'))) { ?>
																			<span class="badge badge-outline text-<?=$maintenanceFieldValue->$name == 1 ? 'green' : 'red'?>"><?=$name == 'state' ? $stateDataArray[$maintenanceFieldValue->$name]->name : $activeDataArray[$maintenanceFieldValue->$name]->name?></span>
																		<?php } elseif (substr($name, -3) == '_id' && !in_array($maintenance, array('m_'.substr($name, 0, -3), 's_'.substr($name, 0, -3))) && !in_array($name, array('column_id'))) { ?>
																			<?=$maintenanceFieldValue->$name != null && isset($maintenanceFinalData[$combineColumnToTable.'Data'][$maintenanceFieldValue->$name]) ? $maintenanceFinalData[$combineColumnToTable.'Data'][$maintenanceFieldValue->$name]->name : (in_array($name, array('maintenance_id')) ? get_table('maintenance', 'maintenance_id', $maintenanceFieldValue->$name, 'name') : 'N/A')?>
																		<?php } elseif (in_array($name, array('main_id'))) { ?>
																			<?=$maintenanceFieldValue->$name != null && isset($maintenanceFinalData['moduleData'][$maintenanceFieldValue->$name]) ? $maintenanceFinalData['moduleData'][$maintenanceFieldValue->$name]->name : 'N/A'?>	
																		<?php } elseif (in_array($name, array('sold_color_id')) && 'm_color' != $maintenance) { ?>
																			<?=$maintenanceFieldValue->$name != null && isset($maintenanceFinalData['colorData'][$maintenanceFieldValue->$name]) ? $maintenanceFinalData['colorData'][$maintenanceFieldValue->$name]->name : 'N/A'?>
																		<?php } elseif (in_array($name, explode(',', get_table('m_column_define', 'column_define_id', '1753528719052', 'multi_column'))) && 'm_choice' != $maintenance) { foreach ($maintenanceFinalData['choiceData'] as $key => $value) { ?>
																			<?=($value->num == $maintenanceFieldValue->$name) ? $value->name : ''; } ?>
																		<?php } elseif (in_array($name, explode(',', get_table('m_column_define', 'column_define_id', '1753524572547', 'multi_column')))) { ?>
																			<a onclick="editMaintenanceImageModal('<?=$module_type_id?>', '<?=$maintenance?>', '<?=$maintenanceFieldValue->$column?>', '<?=$name?>')">
																				<span class="avatar" style="background-image: url(<?=base_url($maintenanceFieldValue->$name)?>)"></span>
																			</a>
																		<?php } elseif (in_array($name, array('user_id'))) { ?>
																			<?=$userData[$maintenanceFieldValue->$name]->full_legal_name ?? 'N/A'?>	
																		<?php } elseif (in_array($name, array('id'))) { ?>	
																			<?=$maintenanceFieldValue->$name.'.'?>																																																										
																		<?php } elseif (in_array($name, explode(',', get_table('m_column_define', 'column_define_id', '1753528816500', 'multi_column')))) { ?>
																			<div class="only-so-big"><?php echo($maintenanceFieldValue->$name); ?></div>
																		<?php } else { echo($maintenanceFieldValue->$name); } ?>
																	</td>
																<?php endforeach; endif; $editSysControl = !get_sys_control(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), 'edit', 1); $removeSysControl = !get_sys_control(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), 'remove', 1); if ($editUserRight && $editSysControl || $removeUserRight && $removeSysControl): ?> 
																	<td>
																		<?php if ($editUserRight && $editSysControl): ?>
																			<a class="btn btn-blue d-none d-sm-inline-block btn-pill" onclick="editMaintenanceModal('<?=$module_type_id?>', '<?=$maintenance?>', '<?=$maintenanceFieldValue->$column?>')">
																				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z" /><path d="M16 5l3 3" /><path d="M9 7.07a7.002 7.002 0 0 0 1 13.93a7.002 7.002 0 0 0 6.929 -5.999" /></svg> Edit
																			</a>
																			<a class="btn btn-blue d-sm-none btn-icon" onclick="editMaintenanceModal('<?=$module_type_id?>', '<?=$maintenance?>', '<?=$maintenanceFieldValue->$column?>')" aria-label="Edit">
																				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z" /><path d="M16 5l3 3" /><path d="M9 7.07a7.002 7.002 0 0 0 1 13.93a7.002 7.002 0 0 0 6.929 -5.999" /></svg>
																			</a>
																		<?php endif; if ($removeUserRight && $removeSysControl): ?>
																			<a class="btn btn-red d-none d-sm-inline-block btn-pill" onclick="removeMaintenanceModal('<?=$module_type_id?>', '<?=$maintenance?>', '<?=$maintenanceFieldValue->$column?>')">
																				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
																			</a>
																			<a class="btn btn-red d-sm-none btn-icon" onclick="removeMaintenanceModal('<?=$module_type_id?>', '<?=$maintenance?>', '<?=$maintenanceFieldValue->$column?>')" aria-label="Delete">
																				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
																			</a>
																		<?php endif; ?>
																	</td>
																<?php endif; ?>
															</tr>
														<?php endforeach; endif; ?> 
													</table>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach; endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function() {
		<?php if (isset($sustenanceData)): foreach($sustenanceData as $maintenance): ?>
			loadDatatable('maintenance-<?=$maintenance?>-datatable', '<?=get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1))?>');
		<?php endforeach; endif; ?>
	});

	function addModuleSetupModal(module_type_id) {	
		
		$.ajax({
			url: base_url + "add-module-setup-modal/" + module_type_id,
			success: function(response) {
				document.getElementById('modal-view-edit-print-maintenance').innerHTML = response;
				$('#modal-view-edit-print-maintenance').modal('show');
			}
		});
	}

	const togglePassword = document.querySelector('#togglePassword');
	const password = document.querySelector('#password');

	togglePassword.addEventListener('click', function (e) {
		// toggle the type attribute
		const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
		password.setAttribute('type', type);
		// toggle the eye / eye slash icon
		// this.classList.toggle('bi-eye');
	});
</script>
