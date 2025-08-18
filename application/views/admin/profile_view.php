<div class="page-wrapper">
	<div class="container-fluid">
		<div class="page-header d-print-none">
            <div class="row align-items-center">
				<!-- Page pre-title -->
				<div class="d-flex">
					<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						<li class="breadcrumb-item"><a href="<?=base_url()?>">Website</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url('home')?>">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">User Profile</li>
					</ol>
				</div>
            </div>
        </div>
	</div>

    <div class="page-body">
		<div class="container-fluid">
			<div class="card">
				<div class="row g-0">
					<div class="col-12 col-md-3 border-end" hidden>
						<div class="card-body">
							<h4 class="subheader">Profile settings</h4>
							<div class="list-group list-group-transparent">
								<?php if (isset($userTypeOptionData)): foreach($userTypeOptionData as $userTypeOption): ?>
									<a href="<?=base_url('profile/'.$user_id.'/'.$userTypeOption->user_option_id)?>" class="list-group-item list-group-item-action d-flex align-items-center <?=$user_option_id == $userTypeOption->user_option_id ? 'active' : ''?>"><?=get_table('m_user_option', 'user_option_id', $userTypeOption->user_option_id, 'name')?></a>
								<?php endforeach; endif; ?>
							</div>
						</div>
					</div>

					<?php $userOptionName = get_table('m_user_option', 'user_option_id', $user_option_id, 'name'); if ($user_option_id == '1752581178334'): ?>
						<div class="col-12 col-md-9 d-flex flex-column">
							<div class="card-body">
								<h2 class="mb-4"><?=$userOptionName?></h2>
								<div class="row align-items-center">
									<a class="col-auto" onclick="editUserImageModal('<?=$user_id?>')">
										<span class="avatar avatar-fluid" style="background-image: url(<?=base_url($user_id)?>)"><?=get_initial($full_legal_name)?></span>
									</a>
									<div class="col-auto">
										<a class="btn btn-pill" onclick="editProfileModal('<?=$user_id?>')">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg> Edit Profile
										</a>
									</div>
									<!-- <div class="col-auto"><a href="#" class="btn">Change avatar</a></div> -->
									<!-- <div class="col-auto"><a href="#" class="btn btn-ghost-danger">Delete avatar</a></div> -->
								</div>
								<h3 class="card-title mt-4"></h3>
								<div class="row g-3">
									<div class="col-md">
										<div class="form-label">Full Legal Name</div>
										<input type="text" class="form-control btn-pill" value="<?=$full_legal_name?>" disabled>
									</div>
									<div class="col-md">
										<div class="form-label">Phone Number</div>
										<input type="text" class="form-control btn-pill" value="<?=$phone_number?>" disabled>
									</div>
									<div class="col-md">
										<div class="form-label">Email</div>
										<input type="text" class="form-control btn-pill" value="<?=$email?>" disabled>
									</div>
								</div>

								<h3 class="card-title mt-4"></h3>
								<div class="row g-3">
									<div class="col-md">
										<div class="form-label">ID Number</div>
										<input type="text" class="form-control btn-pill" value="<?=$id_no?>" disabled>
									</div>
									<div class="col-md">
										<div class="form-label">Address</div>
										<input type="text" class="form-control btn-pill" value="<?=$postal_address?>" disabled>
									</div>
									<div class="col-md">
										<div class="form-label">Status</div>
										<input type="text" class="form-control btn-pill" value="Active" disabled>
									</div>
									<div class="col-md" hidden>
										<div class="form-label">Created At</div>
										<input type="text" class="form-control btn-pill" value="<?=$created_at?>" disabled>
									</div>
								</div>

								<!-- <h3 class="card-title mt-4">Email</h3>
								<p class="card-subtitle">This contact will be shown to others publicly, so choose it carefully.</p>
								<div>
									<div class="row g-2">
										<div class="col-auto">
											<input type="text" class="form-control w-auto" value="paweluna@howstuffworks.com">
										</div>
										<div class="col-auto"><a href="#" class="btn">Change</a></div>
									</div>
								</div> -->

								<h3 class="card-title mt-4">Password</h3>
								<p class="card-subtitle">You can set a permanent password if you don't want to use temporary login codes.</p>
								<div>
									<a class="btn btn-pill" data-bs-toggle="modal" data-bs-target="#modal-edit-password">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg> Set new password
									</a>
								</div>

								<!-- <h3 class="card-title mt-4">Public profile</h3>
								<p class="card-subtitle">Making your profile public means that anyone on the Dashkit network will be able to find you.</p>
								<div>
									<label class="form-check form-switch form-switch-lg">
										<input class="form-check-input" type="checkbox" >
										<span class="form-check-label form-check-label-on">You're currently visible</span>
										<span class="form-check-label form-check-label-off">You're currently invisible</span>
									</label>
								</div> -->
							</div>
						</div>
					<?php elseif ($user_option_id == '1752581642279'): ?><!--My Wallet-->
						<div class="col-12 col-md-9 d-flex flex-column">
							<div class="card-body">
								<h2 class="mb-4"><?=$userOptionName?></h2>
								<h1 class="mb-4">0.00 KSH</h1>
							</div>
						</div>
					<?php elseif ($user_option_id == '1752607479677'): ?><!--My Plates-->
						<div class="col-12 col-md-9 d-flex flex-column">
							<div class="card-body">
								<div class="page-header d-print-none">
									<div class="row align-items-center">
										<div class="col-auto ms-auto d-print-none">
											<div class="btn-list">
												<a onclick="addUserVehicleModal('<?=$user_id?>', '<?=$user_option_id?>')" class="btn btn-green d-none d-sm-inline-block btn-pill">
													<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add <?=$userOptionName?>
												</a>
												<a onclick="addUserVehicleModal('<?=$user_id?>', '<?=$user_option_id?>')" class="btn btn-green d-sm-none btn-icon" aria-label="Add <?=$userOptionName?>">
													<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
												</a>
											</div>
										</div>
									</div>
								</div>
								<h2 class="mb-4"><?=$userOptionName?></h2>
								<!-- <h3 class="card-title">Vehicle List</h3> -->
								<table id="user-vehicle-datatable" class="table table-vcenter card-table table-nowrap">
									<thead>
										<tr>
											<th>#</th>
											<th>Plate No.</th>
											<th>Description</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($userVehicleData)): ?>
											<?php $uv = 0; foreach($userVehicleData as $userVehicle): ?>
												<tr>
													<td><?=++$uv?>.</td>
													<td><?=$userVehicle->plate_no?></td>
													<td><?=$userVehicle->description?></td>
													<td class="text-end">
														<span class="dropdown">
															<button class="btn dropdown-toggle align-text-top btn-pill" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
															<div class="dropdown-menu dropdown-menu-end">
																<a class="dropdown-item" onclick="editUserVehicleModal('<?=$userVehicle->user_vehicle_id?>')">Edit</a>
																<a class="dropdown-item" onclick="deleteUserVehicleModal('<?=$userVehicle->user_vehicle_id?>')">Delete</a>
															</div>
														</span>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php else: ?>
											<tr><td colspan="5" class="text-center">No vehicles plates added yet.</td></tr>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

	<div class="modal modal-blur fade" id="modal-view-edit-print-user" tabindex="-1" role="dialog" aria-hidden="true"></div>

	<div class="modal modal-blur fade" id="modal-edit-password" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Password</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<form action="<?=base_url('edit-password')?>" method="POST" enctype="multipart/form-data">
					<input id="user_id" name="user_id" value="<?=$user_id?>" hidden>
					<div class="row">
						<div class="modal-body">
							<div class="mb-3">
								<label class="form-label">Full legal name</label>
								<input id="full_legal_name" name="full_legal_name" type="text" class="form-control" placeholder="Enter your full legal name" value="<?=$full_legal_name?>" disabled>
							</div>							
							<div class="mb-3">
								<label class="form-label">Password</label>
								<input id="password" name="password" type="password" class="form-control" placeholder="Enter your password">
							</div>						
						</div>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
							Cancel
						</a>
						<button href="#" type="submit" class="btn btn-primary ms-auto">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
							Update Password
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>

		$(document).ready(function() {
			loadDatatable('user-document-datatable');
			loadDatatable('user-vehicle-datatable');
			loadDatatable('user-payment-history-datatable');
		});

		function viewUserDocumentImageModal(user_vehicle_id, document_front_back_url) {
			$.ajax({
				url: base_url + "view-user-document-image-modal/" + user_vehicle_id + "/" + document_front_back_url,
				success: function(response) {
					$('#modal-view-edit-print-user').html(response);
					$('#modal-view-edit-print-user').modal('show');
				}
			});
		}

		function addUserVehicleModal(user_id, user_option_id) {
			$.ajax({
				url: base_url + "add-user-vehicle-modal/" + user_id + "/" + user_option_id,
				success: function(response) {
					$('#modal-view-edit-print-user').html(response);
					$('#modal-view-edit-print-user').modal('show');
					loadRichTextEditor('description');
				}
			});
		}

		function editUserVehicleModal(user_vehicle_id, user_option_id) {
			$.ajax({
				url: base_url + "edit-user-vehicle-modal/" + user_vehicle_id,
				success: function(response) {
					$('#modal-view-edit-print-user').html(response);
					$('#modal-view-edit-print-user').modal('show');
					loadRichTextEditor('description');
				}
			});
		}

		function deleteUserVehicleModal(user_vehicle_id, user_option_id) {
			$.ajax({
				url: base_url + "delete-user-vehicle-modal/" + user_vehicle_id + "/" + user_option_id,
				success: function(response) {
					$('#modal-view-edit-print-user').html(response);
					$('#modal-view-edit-print-user').modal('show');
				}
			});
		}
</script>