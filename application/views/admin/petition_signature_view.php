<?php
$petitionName = isset($petitionSetupRow->name) && !empty($petitionSetupRow->name) ? $petitionSetupRow->name : 'Petition';
$pageTitle = $petitionName . ' Signatures';
$modulePath = isset($moduleMenu->path) && !empty($moduleMenu->path) ? $moduleMenu->path : 'petition-setup';
$hasActions = !empty($editUserRight) || !empty($removeUserRight);
$columnCount = $hasActions ? 11 : 10;
?>

<div class="page-wrapper">
	<div class="container-fluid">
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col">
					<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?= base_url($modulePath) ?>">Petition Setups</a></li>
						<li class="breadcrumb-item active" aria-current="page"><?= $petitionName ?> Signatures</li>
					</ol>
				</div>
				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">
						<a class="btn btn-outline-secondary btn-pill" href="<?= base_url($modulePath) ?>">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M15 6l-6 6l6 6" />
							</svg>
							Back to Petitions
						</a>
						<?php if (!empty($inputUserRight)): ?>
							<a class="btn btn-primary btn-pill" href="javascript:void(0);" onclick="addPetitionSignatureModal('<?= $petition_setup_id ?>');">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<line x1="12" y1="5" x2="12" y2="19" />
									<line x1="5" y1="12" x2="19" y2="12" />
								</svg> Add Signature
							</a>
						<?php endif; ?>
						<div class="btn-group">
							<button class="btn btn-outline-secondary dropdown-toggle btn-pill" data-bs-toggle="dropdown">Download report</button>
							<ul class="dropdown-menu dropdown-menu-end">
								<li><a class="dropdown-item" href="<?= base_url('petition-signatures-export/' . $petition_setup_id . '/csv') ?>">CSV</a></li>
								<li><a class="dropdown-item" href="<?= base_url('petition-signatures-export/' . $petition_setup_id . '/excel') ?>">Excel</a></li>
								<li><a class="dropdown-item" href="<?= base_url('petition-signatures-export/' . $petition_setup_id . '/pdf') ?>">PDF</a></li>
							</ul>
						</div>
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
							<h3 class="card-title"><?= $pageTitle ?></h3>
						</div>
						<div class="card-body border-bottom py-3">
							<div class="table-responsive">
								<table id="petition-signature-datatable" class="table table-vcenter text-nowrap" style="width: 100%;">
									<thead>
										<tr>
											<th class="w-1">#</th>
											<th>Full Name</th>
											<th>Phone Number</th>
											<!-- <th>Units</th> -->
											<th>Signature Method</th>
											<th>Signature</th>
											<th>Consent</th>
											<th>Signed At</th>
											<th>State</th>
											<th>Status</th>
											<th>Created At</th>
											<?php if ($hasActions): ?>
												<th>Actions</th>
											<?php endif; ?>
										</tr>
									</thead>
									<tbody>
										<?php $index = 0;
										if (!empty($petitionSignatureData)): foreach ($petitionSignatureData as $signature): ?>
												<tr>
													<td><?= ++$index ?>.</td>
													<td><?= get_table($customerDBSettingRow->database_name . '.user', 'user_id', $signature->user_id, 'full_legal_name') ?? '' ?></td>
													<td><?= get_table($customerDBSettingRow->database_name . '.user', 'user_id', $signature->user_id, 'phone_number') ?? '' ?></td>
													<!-- <td><?= number_format((int) ($signature->no_of_unit ?? 0)) ?></td> -->
													<td><?= get_table('m_signature_method', 'signature_method_id', $signature->signature_method_id ?? '', 'name') ?? '' ?></td>
													<td>
														<?php if (!empty($signature->signature_url)): ?>
															<a href="<?= base_url($signature->signature_url) ?>" target="_blank" rel="noopener">View</a>
														<?php else: ?>
															<span class="text-muted">N/A</span>
														<?php endif; ?>
													</td>
													<td>
														<?php if (isset($signature->consent) && (int) $signature->consent === 1): ?>
															<span class="badge bg-green-lt">Yes</span>
														<?php else: ?>
															<span class="badge bg-red-lt">No</span>
														<?php endif; ?>
													</td>
													<td><?= !empty($signature->signed_at) ? date('d M Y H:i', strtotime($signature->signed_at)) : date('d M Y H:i', strtotime($signature->created_at)) ?></td>
													<td><?= $signature->state ?? 'N/A' ?></td>
													<td>
														<?php
														$statusName = get_table('m_active', 'num', $signature->active ?? 0, 'name');
														$badgeClass = (isset($signature->active) && (int) $signature->active === 1) ? 'bg-green-lt' : ((isset($signature->active) && (int) $signature->active === 0) ? 'bg-red-lt' : 'bg-yellow-lt');
														?>
														<span class="badge <?= $badgeClass ?>"><?= $statusName ?: 'N/A' ?></span>
													</td>
													<td><?= !empty($signature->created_at) ? date('d M Y H:i', strtotime($signature->created_at)) : 'N/A' ?></td>
													<?php if ($hasActions): ?>
														<td>
															<span class="dropdown">
																<button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
																<div class="dropdown-menu dropdown-menu-end">
																	<?php if ($editUserRight): ?>
																		<a href="javascript:void(0);" class="dropdown-item" onclick="editPetitionSignatureModal('<?= $signature->petition_signature_id ?>')">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																				<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																				<path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
																				<path d="M13.5 6.5l4 4" />
																			</svg> Edit
																		</a>
																	<?php endif; ?>
																	<?php if ($removeUserRight): ?>
																		<a href="javascript:void(0);" class="dropdown-item" onclick="removePetitionSignatureModal('<?= $signature->petition_signature_id ?>')">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																				<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																				<line x1="4" y1="7" x2="20" y2="7" />
																				<line x1="10" y1="11" x2="10" y2="17" />
																				<line x1="14" y1="11" x2="14" y2="17" />
																				<path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
																				<path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
																			</svg> Delete
																		</a>
																	<?php endif; ?>
																</div>
															</span>
														</td>
													<?php endif; ?>
												</tr>
											<?php endforeach;
										else: ?>
											<tr>
												<td colspan="<?= $columnCount ?>" class="text-center">No petition signatures found.</td>
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
	$(function() {
		loadDatatable('petition-signature-datatable', <?= json_encode($pageTitle) ?>);
	});

	editPetitionSignatureModal = function(petitionSignatureId) {
		showModal(base_url + 'edit-petition-signature-modal/' + petitionSignatureId, window.initPetitionSignatureModal);
	};

	removePetitionSignatureModal = function(petitionSignatureId) {
		showModal(base_url + 'remove-petition-signature-modal/' + petitionSignatureId, function() {});
	};
</script>
