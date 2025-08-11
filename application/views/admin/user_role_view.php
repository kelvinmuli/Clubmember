<style>
	th, td {
		background-color: white;
		padding: 8px 16px;
		/* border: 1px solid #ddd; */
		white-space: nowrap;
		background: white;
	}

	thead th {
		position: -webkit-sticky;
		position: sticky;
		top: 0;
		background-color: white;
		z-index: 1;
	}

	.fixed-column {
		position: -webkit-sticky;
		position: sticky;
		left: 0;
		background-color: aqua;
		z-index: 2; 
	}
</style>

<div class="page-wrapper">
    <div class="container-fluid">			
		<!-- Page title -->
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col py-3">
					<ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
						<li class="breadcrumb-item"><a href="<?=base_url()?>"><?=$systemRow->title?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?=$moduleMenu->name?></li>
					</ol>
				</div>
				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
				<div class="btn-list">
					<!-- <span class="d-none d-sm-inline">
					<a href="#" class="btn btn-white">
						New view
					</a>
					</span> -->
					<?php if ($inputUserRight): $selectedModuleTypeId = get_table('maintenance', 'name', 'm_user_type', 'module_type_id');?>
						<a href="<?=base_url('all-maintenance/'.$selectedModuleTypeId.'?selected=m_user_type')?>" class="btn btn-success btn-pill">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
							Add User Type
						</a>
						<a href="<?=base_url('all-maintenance/'.$selectedModuleTypeId.'?selected=m_user_type')?>" class="btn btn-success d-sm-none btn-icon btn-pill" aria-label="Add User Type">
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
			<div class="card">
				<div class="card-header">
					<h3 class="card-title"><?=$moduleMenu->name?></h3>
				</div>				

				<div class="card-body">
					<div class="accordion accordion-tabs" id="accordion-example">
						<?php $selected = $this->input->get()!=NULL ? $this->input->get()['selected'] : NULL; if (isset($userTypeData)): foreach($userTypeData as $key => $userType): ?>
							<div class="accordion-item">
								<h2 class="accordion-header" id="heading-<?=$key?>">
									<button class="accordion-button collapsed show" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?=$key?>" aria-expanded="true">
										<?=($key + 1).'. '.$userType->name?>
									</button>
								</h2>

								<div id="collapse-<?=$key?>" class="accordion-collapse collapse <?php if ($selected == $userType->user_type_id) echo('show'); elseif (!isset($selected) && $key==0) echo('show'); else echo('hide');?>" data-bs-parent="#accordion-example">
									<div class="accordion-body pt-0">
										<div class="card-table table-responsive">
											<table class="table card-table table-vcenter text-nowrap datatable">
												<thead>
													<tr>
														<th class="fixed-column">#</th>
														<th class="fixed-column">Name</th>
														<th>Module</th>
														<th>Approve</th>
														<th>Add</th>
														<th>Edit</th>
														<th>Delete</th>
														<th>status</th>
													</tr>
												</thead>
												<tbody>
													<?php $m = 0; if (isset($moduleData)): foreach($moduleData as $module): if ($module->active == 1): ?>
														<tr>
															<td class="fixed-column"><?=++$m?>.</td>
															<td class="fixed-column"><?=$module->icon.' '.$module->name?></td>
															<td>
																<label class="form-check form-switch">
																	<input id="user-role-checkbox-<?=$userType->user_type_id.'-'.$module->module_id?>" type="checkbox" class="form-check-input" onchange="userRoleCheckboxView('<?=$userType->user_type_id.'-'.$module->module_id?>', this.checked)" <?php if (!empty(get_user_right($userType->user_type_id, $module->module_id, 'view', 1))) echo('checked') ?>>
																	<span id="user-role-textbox-<?=$userType->user_type_id.'-'.$module->module_id?>" class="form-check-label"><?=!empty(get_user_right($userType->user_type_id, $module->module_id, 'view', 1)) ? 'On' : 'Off' ?></span>
																</label>
															</td>
															<td>
																<label class="form-check form-switch">
																	<input id="user-role-checkbox-approve-<?=$userType->user_type_id.'-'.$module->module_id?>" type="checkbox" class="form-check-input" onchange="userRoleCheckboxApprove('<?=$userType->user_type_id.'-'.$module->module_id?>', this.checked)" <?php if (!empty(get_user_right($userType->user_type_id, $module->module_id, 'approve', 1))) echo('checked') ?>>
																	<span id="user-role-textbox-approve-<?=$userType->user_type_id.'-'.$module->module_id?>" class="form-check-label"><?=!empty(get_user_right($userType->user_type_id, $module->module_id, 'approve', 1)) ? 'On' : 'Off' ?></span>
																</label>
															</td>														
															<td>
																<label class="form-check form-switch">
																	<input id="user-role-checkbox-add-<?=$userType->user_type_id.'-'.$module->module_id?>" type="checkbox" class="form-check-input" onchange="userRoleCheckboxInput('<?=$userType->user_type_id.'-'.$module->module_id?>', this.checked)" <?php if (!empty(get_user_right($userType->user_type_id, $module->module_id, 'input', 1))) echo('checked') ?>>
																	<span id="user-role-textbox-input-<?=$userType->user_type_id.'-'.$module->module_id?>" class="form-check-label"><?=!empty(get_user_right($userType->user_type_id, $module->module_id, 'input', 1)) ? 'On' : 'Off' ?></span>
																</label>
															</td>														
															<td>
																<label class="form-check form-switch">
																	<input id="user-role-checkbox-edit-<?=$userType->user_type_id.'-'.$module->module_id?>" type="checkbox" class="form-check-input" onchange="userRoleCheckboxEdit('<?=$userType->user_type_id.'-'.$module->module_id?>', this.checked)" <?php if (!empty(get_user_right($userType->user_type_id, $module->module_id, 'edit', 1))) echo('checked') ?>>
																	<span id="user-role-textbox-edit-<?=$userType->user_type_id.'-'.$module->module_id?>" class="form-check-label"><?=!empty(get_user_right($userType->user_type_id, $module->module_id, 'edit', 1)) ? 'On' : 'Off' ?></span>
																</label>
															</td>
															<td>
																<label class="form-check form-switch">
																	<input id="user-role-checkbox-delete-<?=$userType->user_type_id.'-'.$module->module_id?>" type="checkbox" class="form-check-input" onchange="userRoleCheckboxRemove('<?=$userType->user_type_id.'-'.$module->module_id?>', this.checked)" <?php if (!empty(get_user_right($userType->user_type_id, $module->module_id, 'remove', 1))) echo('checked') ?>>
																	<span id="user-role-textbox-delete-<?=$userType->user_type_id.'-'.$module->module_id?>" class="form-check-label"><?=!empty(get_user_right($userType->user_type_id, $module->module_id, 'remove', 1)) ? 'On' : 'Off' ?></span>
																</label>
															</td>
															<td><span class="badge bg-<?=$module->active == 1 ? 'green' : 'red'?>-lt"><?=$activeDataArray[$module->active]->name?></span></td>																											
														</tr>
													<?php endif; endforeach; endif; ?> 
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	function userRoleCheckboxView(value, checked)
	{
		var user_type_id = value.split('-')[0];
		$.ajax({
			type: "POST",
			url: base_url + 'user-role-add-edit/' + value + '-view_' + (checked ? '1' : '0'),
			success: function (response) {
				window.location.href = 'user-role?selected=' + user_type_id
			}
		});
		$('#user-role-textbox-' + value).text(this.checked ? 'On' : 'Off');
	}

	function userRoleCheckboxApprove(value, checked)
	{
		var user_type_id = value.split('-')[0];
		$.ajax({
			type: "POST",
			url: base_url + 'user-role-add-edit/' + value + '-approve_' + (checked ? '1' : '0'),
			success: function (response) {
				window.location.href = 'user-role?selected=' + user_type_id
			}
		});
		$('#user-role-textbox-approve-' + value).text(this.checked ? 'On' : 'Off');
	}

	function userRoleCheckboxInput(value, checked)
	{
		var user_type_id = value.split('-')[0];
		$.ajax({
			type: "POST",
			url: base_url + 'user-role-add-edit/' + value + '-input_' + (checked ? '1' : '0'),
			success: function (response) {
				window.location.href = 'user-role?selected=' + user_type_id
			}
		});
		$('#user-role-textbox-input-' + value).text(this.checked ? 'On' : 'Off');
	}

	function userRoleCheckboxEdit(value, checked)
	{
		var user_type_id = value.split('-')[0];
		$.ajax({
			type: "POST",
			url: base_url + 'user-role-add-edit/' + value + '-edit_' + (checked ? '1' : '0'),
			success: function (response) {
				window.location.href = 'user-role?selected=' + user_type_id
			}
		});
		$('#user-role-textbox-edit-' + value).text(this.checked ? 'On' : 'Off');
	}

	function userRoleCheckboxRemove(value, checked)
	{
		var user_type_id = value.split('-')[0];
		$.ajax({
			type: "POST",
			url: base_url + 'user-role-add-edit/' + value + '-remove_' + (checked ? '1' : '0'),
			success: function (response) {
				window.location.href = 'user-role?selected=' + user_type_id
			}
		});
		$('#user-role-textbox-delete-' + value).text(this.checked ? 'On' : 'Off');
	}

</script>
