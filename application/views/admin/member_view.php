<?php $userTypeName = empty($userTypeId) ? 'N/A' : get_table('m_user_type', 'user_type_id', $userTypeId, 'name');?>
<div class="page-wrapper">
	<div class="container-fluid">
		<!-- Page title -->
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col">
					<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						<!-- <li class="breadcrumb-item"><a href="<?=base_url()?>">Website</a></li> -->
						<li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="#"><?=$moduleMenu->name?></a></li>
					</ol>
				</div>

				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">
						<?php if ($inputUserRight && $active == 0): ?>
							<div class="col-lg-5">
								<span class="dropdown">
									<button class="btn btn-success dropdown-toggle align-text-top btn-pill" data-bs-boundary="viewport" data-bs-toggle="dropdown">Add New <?=$userTypeName?></button>
									<div class="dropdown-menu dropdown-menu-end">
										<?php if (isset($membershipTypeData)): foreach ($membershipTypeData as $key => $value): ?>
											<a href="#" class="dropdown-item" onclick="addUserModal('1755383886420', '<?=$value->membership_type_id?>')">
												<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
													<path stroke="none" d="M0 0h24v24H0z" fill="none" />
													<line x1="12" y1="5" x2="12" y2="19" />
													<line x1="5" y1="12" x2="19" y2="12" />
												</svg> Add <?=$value->name?>
											</a>
										<?php endforeach;
										endif;?>
									</div>
								</span>
							</div>
						<?php endif;?>

						<button class="btn btn-primary btn-pill" onclick="importUsersModal('<?=GlobalModel::MEMBER_TYPE?>', '<?=$customerDBSettingId?>', '<?=$membershipTypeId?>')">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M12 5v14" />
								<path d="M5 12h14" />
							</svg>
							Import CSV
						</button>
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
							<h3 class="card-title"><?=isset($userTypeId) ? 'All ' . $userTypeName . 's' : $moduleMenu->name?></h3>
							<div class="col-auto ms-auto d-print-none">
								<div class="btn-list"></div>
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
											<th>Membership Fee Type</th>
											<th>Membership No.</th>
											<th>Residental Address</th>
											<th>Street Address</th>
											<th>LR/No.</th>
											<th>Origin</th>
											<th>Created At</th>
											<?php if ($approveUserRight || $editUserRight || $removeUserRight): ?>
												<th>Actions</th>
											<?php endif;?>
										</tr>
									</thead>
									<tbody>
										<?php if (isset($userData)): foreach ($userData as $key => $user): ?>
											<tr>
												<td><?=$key + 1?></td>
												<td><?=get_table('m_title', 'title_id', $user->title_id, 'name').' '.$user->full_legal_name?></td>
												<td><?=empty($user->phone_number) ? $user->mobile_number : $user->phone_number?></td>
												<td><?=$user->email?></td>
												<td><?=get_table($customerDBSettingRow->database_name . '.membership_fee_type', 'membership_fee_type_id', $user->membership_fee_type_id, 'name')?></td>
												<td><?=$user->membership_no?></td>
												<td><?=$user->residential_address?></td>
												<td><?=$user->street_name?></td>
												<td><?=$user->sub_reference_no?></td>
												<td><?=get_table('m_user_origin', 'user_origin_id', $user->user_origin_id, 'name')?></td>
												<td><?=date_format(date_create($user->created_at), "d M y")?></td>
												<?php if ($approveUserRight || $editUserRight || $removeUserRight): ?>
													<td>
														<span class="dropdown">
															<button class="btn dropdown-toggle align-text-top btn-pill" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
															<div class="dropdown-menu dropdown-menu-end">
																<?php if ($approveUserRight): ?>
																	<?php if ($user->active == 0): ?>
																		<a class="dropdown-item" onclick="subscriptionApprovalModal('<?=$user->user_id?>', '<?=$user->membership_type_id?>', '<?=$customer_db_setting_id?>', 'member')">Approve</a>
																	<?php endif;?>
																	<a class="dropdown-item" href="#" onclick="sendResetPassword('<?=$user->user_id?>', '<?=$customer_db_setting_id?>')">Send Password Reset</a>
																<?php endif; if ($editUserRight): ?>
																	<a class="dropdown-item" href="#" onclick="editUserModal('<?=$user->user_id?>', '<?=($user->membership_type_id == 'N/A' ? '0' : $user->membership_type_id)?>', '<?=$customer_db_setting_id?>', 'member_<?=$membershipTypeId?>_<?=$active?>')">Edit</a>
																<?php endif; if ($removeUserRight): ?>
																	<a class="dropdown-item" href="#" onclick="deleteUserModal('<?=$user->user_id?>', '<?=$customer_db_setting_id?>', 'member')">Delete</a>
																<?php endif;?>
															</div>
														</span>
													</td>
												<?php endif;?>
											</tr>
										<?php endforeach; endif;?>
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
				url: base_url + "add-user-modal/" + user_type_id + "/" + membership_type_id + "/<?=$customerDBSettingId?>/member/<?=$active?>",
				success: function(response) {
					document.getElementById('modal-view-edit-print-user').innerHTML = response;
					$('#modal-view-edit-print-user').modal('show');
				}
			});
		}

		function importUsersModal(user_type_id, customer_db_setting_id, membership_type_id) {
			showModal(base_url + 'import-user-modal/' + user_type_id + '/' + customer_db_setting_id + '/' + (membership_type_id || ''), function() {});
		}
	</script>
