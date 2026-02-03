<?php
$pageTitle = isset($moduleMenu) && !empty($moduleMenu->name) ? $moduleMenu->name : 'N/A';
?>

<div class="page-wrapper">
	<div class="container-fluid">
		<!-- Page title -->
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col">
					<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?= base_url($moduleMenu->path) ?>"><?= $pageTitle ?></a></li>
					</ol>
				</div>

				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">
						<?php if ($inputUserRight): ?>
							<a class="btn btn-primary btn-pill" onclick="addAuditedAccountModal();" href="javascript:void(0);">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<line x1="12" y1="5" x2="12" y2="19" />
									<line x1="5" y1="12" x2="19" y2="12" />
								</svg> Add <?= $pageTitle ?>
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
							<h3 class="card-title"><?= $pageTitle ?></h3>
						</div>

						<div class="card-body border-bottom py-3">
							<div class="table-responsive">
								<table id="audited-accounts-datatable" class="table table-vcenter text-wrap" style="width: 100%;">
									<thead>
										<tr>
											<th class="w-1">#</th>
											<th>Title</th>
											<th>Dated At</th>
											<th>Document</th>
											<th>Status</th>
											<th>Created At</th>
											<?php if ($viewUserRight || $editUserRight || $removeUserRight): ?>
												<th>Actions</th>
											<?php endif; ?>
										</tr>
									</thead>
									<tbody>
										<?php $aa = 0;
										if (isset($auditedAccountData)): foreach ($auditedAccountData as $account): ?>
												<tr>
													<td><?= ++$aa ?></td>
													<td><?= $account->name ?></td>
													<td><?= !empty($account->dated_at) ? date('d M Y', strtotime($account->dated_at)) : 'N/A' ?></td>
													<td>
														<?php if (check_file_exists($account->file_url ?? '')): ?>
															<a href="<?= base_url($account->file_url) ?>" class="btn btn-outline-primary btn-sm btn-pill" target="_blank" rel="noopener">
																<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																	<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																	<path d="M14 3v4a1 1 0 0 0 1 1h4" />
																	<path d="M5 9v-2a2 2 0 0 1 2 -2h7l5 5v9a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-11" />
																	<path d="M9 17l6 -6" />
																	<path d="M15 17h-6v-6" />
																</svg> View
															</a>
														<?php else: ?>
															<span class="text-muted">Not uploaded</span>
														<?php endif; ?>
													</td>
													<td>
														<span class="badge <?= $account->active === 1 ? 'bg-green-lt' : ($account->active === 0 ? 'bg-red-lt' : 'bg-yellow-lt') ?>"><?= get_table('m_active', 'num', $account->active, 'name') ?></span>
													</td>
													<td><?= !empty($account->created_at) ? date('d M Y', strtotime($account->created_at)) : 'N/A' ?></td>
													<?php if ($viewUserRight || $editUserRight || $removeUserRight): ?>
														<td>
															<span class="dropdown">
																<button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
																<div class="dropdown-menu dropdown-menu-end">
																	<a href="#" class="dropdown-item" onclick="viewAuditedAccountModal('<?= $account->audited_account_id ?>')">
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																			<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																			<circle cx="12" cy="12" r="2" />
																			<path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7z" />
																		</svg> View
																	</a>
																	<?php if ($editUserRight): ?>
																		<a href="javascript:void(0);" class="dropdown-item" onclick="editAuditedAccountModal('<?= $account->audited_account_id ?>')">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																				<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																				<path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
																				<path d="M13.5 6.5l4 4" />
																			</svg> Edit
																		</a>
																	<?php endif;
																	if ($removeUserRight): ?>
																		<a href="javascript:void(0);" class="dropdown-item" onclick="removeAuditedAccountModal('<?= $account->audited_account_id ?>')">
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
										endif; ?>
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
		loadDatatable('audited-accounts-datatable', <?= json_encode($pageTitle) ?>);
	});
</script>
