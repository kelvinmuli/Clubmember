<?php
$pageTitle = isset($moduleMenu->name) && !empty($moduleMenu->name) ? $moduleMenu->name : 'Petition Setups';
$modulePath = isset($moduleMenu->path) && !empty($moduleMenu->path) ? $moduleMenu->path : 'petition-setup';
$hasActions = $viewUserRight || $editUserRight || $removeUserRight;
$columnCount = $hasActions ? 8 : 7;
?>

<div class="page-wrapper">
	<div class="container-fluid">
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col">
					<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						<li class="breadcrumb-item"><a href="<?=base_url()?>">Website</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url('home')?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url($modulePath)?>"><?=$pageTitle?></a></li>
					</ol>
				</div>
				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">
						<?php if ($inputUserRight): ?>
							<a class="btn btn-primary btn-pill" href="javascript:void(0);" onclick="addPetitionSetupModal();">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add <?=$pageTitle?>
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
							<h3 class="card-title"><?=$pageTitle?></h3>
						</div>
						<div class="card-body border-bottom py-3">
							<div class="table-responsive">
								<table id="petition-setup-datatable" class="table table-vcenter text-wrap" style="width: 100%;">
									<thead>
										<tr>
											<th class="w-1">#</th>
											<th>Title</th>
											<th>Description</th>
											<th>Target Signatures</th>
											<th>Closing Date</th>
											<th>Status</th>
											<th>Created At</th>
											<?php if ($hasActions): ?>
												<th>Actions</th>
											<?php endif; ?>
										</tr>
									</thead>
									<tbody>
										<?php $ps = 0; if (!empty($petitionSetupData)): foreach ($petitionSetupData as $petition): ?>
											<tr>
												<td><?=++$ps?>.</td>
												<td><?=$petition->name ?? ''?></td>
												<td><div class="only-so-big text-muted"><?=$petition->description ?? ''?></div></td>
												<td><?=number_format((int) ($petition->no_of_signature ?? 0))?></td>
												<td>
													<?php if (!empty($petition->closing_at)): ?>
														<?=date('d M Y H:i', strtotime($petition->closing_at))?>
													<?php else: ?>
														<span class="badge bg-blue-lt">Open</span>
													<?php endif; ?>
												</td>
												<td>
													<?php
														$statusName = get_table('m_active', 'num', $petition->active ?? 0, 'name');
														$badgeClass = (isset($petition->active) && (int) $petition->active === 1) ? 'bg-green-lt' : ((isset($petition->active) && (int) $petition->active === 0) ? 'bg-red-lt' : 'bg-yellow-lt');
													?>
													<span class="badge <?=$badgeClass?>"><?=$statusName ?: 'N/A'?></span>
												</td>
												<td><?=!empty($petition->created_at) ? date('d M Y H:i', strtotime($petition->created_at)) : 'N/A'?></td>
												<?php if ($hasActions): ?>
													<td>
														<span class="dropdown">
															<button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
															<div class="dropdown-menu dropdown-menu-end">
																<a href="javascript:void(0);" class="dropdown-item" onclick="viewPetition('<?=$petition->petition_setup_id?>')">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7z" /></svg> View Petition
																</a>
																<?php if (in_array($user_type_id, array(GlobalModel::ADMIN_TYPE, GlobalModel::CLUB_ADMIN_TYPE))): ?>
																	<a href="javascript:void(0);" class="dropdown-item" onclick="viewPetitionSignatures('<?=$petition->petition_setup_id?>')">
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7z" /></svg> View Signatures
																	</a>
																<?php endif; ?>
																<a href="javascript:void(0);" class="dropdown-item" onclick="addPetitionSignatureModal('<?=$petition->petition_setup_id?>')">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add Signature
																</a>
																<?php if ($editUserRight): ?>
																	<a href="javascript:void(0);" class="dropdown-item" onclick="editPetitionSetupModal('<?=$petition->petition_setup_id?>')">
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg> Edit
																	</a>
																<?php endif; if ($removeUserRight): ?>
																	<a href="javascript:void(0);" class="dropdown-item" onclick="removePetitionSetupModal('<?=$petition->petition_setup_id?>')">
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
																	</a>
																<?php endif; ?>
															</div>
														</span>
													</td>
												<?php endif; ?>
											</tr>
										<?php endforeach; else: ?>
											<tr>
												<td colspan="<?=$columnCount?>" class="text-center">No petition setups found.</td>
											</tr>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(function () {
		loadDatatable('petition-setup-datatable', <?=json_encode($pageTitle)?>);
	});

	addPetitionSetupModal = function () {
		showModal(base_url + 'add-petition-setup-modal', function () {});
	};

	viewPetitionSignatures = function (petitionSetupId) {
		window.location.href = base_url + 'petition-signatures/' + petitionSetupId;
	};

	viewPetition = function (petitionSetupId) {
		showModal(base_url + 'view-petition-modal/' + petitionSetupId, function () {});
	};

	addPetitionSignatureModal = function (petitionSetupId) {
		showModal(base_url + 'add-petition-signature-modal/' + petitionSetupId, window.initPetitionSignatureModal);
	};

	editPetitionSetupModal = function (petitionSetupId) {
		showModal(base_url + 'edit-petition-setup-modal/' + petitionSetupId, function () {});
	};

	removePetitionSetupModal = function (petitionSetupId) {
		showModal(base_url + 'remove-petition-setup-modal/' + petitionSetupId, function () {});
	};

</script>
