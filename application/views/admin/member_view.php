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
									<tbody>
										<?php if (isset($userData)): foreach ($userData as $key => $user): ?>
											<tr>
												<td><?=$key + 1?></td>
												<td><?=$user->full_legal_name?></td>
												<td><?=$user->phone_number?></td>
												<td><?=$user->email?></td>
												<td><?=$user->membership_no?></td>
												<td><?=$user->residential_address?></td>
												<td><?=$user->created_at?></td>
												<td>
													<span class="dropdown">
														<button class="btn dropdown-toggle align-text-top btn-pill" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="#" onclick="editUserModal('<?=$user->user_id?>')">Edit</a>
															<a class="dropdown-item" href="#" onclick="deleteUserModal('<?=$user->user_id?>')">Delete</a>
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

	<div class="modal modal-blur fade" id="modal-view-edit-print-user" tabindex="-1" role="dialog" aria-hidden="true"></div>

	<script>
		$(document).ready(function() {
			loadDatatable('user-datatable');
		});

		function addUserModal(user_type_id, membership_type_id) {
			$.ajax({
				url: base_url + "add-user-modal/" + user_type_id + "/" + membership_type_id + "/" + $('#customer_db_setting_id').val(),
				success: function(response) {
					document.getElementById('modal-view-edit-print-user').innerHTML = response;
					$('#modal-view-edit-print-user').modal('show');
				}
			});
		}
	</script>
