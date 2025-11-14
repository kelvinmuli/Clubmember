<?php
$pageTitle = isset($moduleMenu) && !empty($moduleMenu->name) ? $moduleMenu->name : 'Projects';
$modulePath = isset($moduleMenu) && !empty($moduleMenu->path) ? $moduleMenu->path : 'projects';
$projectData = $projectData ?? [];
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
						<?php if (!empty($inputUserRight)): ?>
							<a class="btn btn-primary btn-pill" href="javascript:void(0);" onclick="addProjectModal()">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add <?=$pageTitle?>
							</a>

							<a class="btn btn-primary btn-pill" href="javascript:void(0);" onclick="addMaintenanceModal('1754878838526', 'm_project_category')">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add Project Category
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
					<div class="card mb-3">
						<div class="card-header">
							<h3 class="card-title mb-0"><?=$pageTitle?></h3>
						</div>
					</div>
				</div>

				<?php if (!empty($projectData)): ?>
					<?php foreach ($projectData as $project): ?>
						<?php
							$projectId = $project->project_id ?? '';
							$projectName = $project->name ?? 'Untitled Project';
							$projectDescription = $project->description ?? '';
							$notes = $project->notes ?? '';
							$thumbnailUrl = $project->thumbnail_url ?? '';
							$thumbnailSrc = '';
							if (!empty($thumbnailUrl)) {
								$thumbnailSrc = filter_var($thumbnailUrl, FILTER_VALIDATE_URL) ? $thumbnailUrl : base_url($thumbnailUrl);
							}
							$startAt = !empty($project->start_at) ? date('d M Y H:i', strtotime($project->start_at)) : 'Not Set';
							$dueAt = !empty($project->due_at) ? date('d M Y H:i', strtotime($project->due_at)) : 'Not Set';
							$statusId = $project->project_status_id ?? null;
							$statusName = $statusId ? (get_table('m_project_status', 'project_status_id', $statusId, 'name') ?: 'Status Pending') : 'Status Pending';
							$activeValue = $project->active ?? null;
							$activeBadge = $activeValue !== null ? (get_table('m_active', 'num', $activeValue, 'name') ?: 'Unknown') : 'Unknown';
							$activeClass = ($activeValue === 1) ? 'bg-green-lt' : (($activeValue === 0) ? 'bg-red-lt' : 'bg-yellow-lt');
							$budgetAllocated = isset($project->budget_allocated) ? (float) $project->budget_allocated : 0.0;
							$budgetUsed = isset($project->budget_used) ? (float) $project->budget_used : 0.0;
							$budgetBalance = $budgetAllocated - $budgetUsed;
							$dependence = $project->dependence ?? '';
						?>
						<div class="col-12 col-md-6 col-xl-4">
							<div class="card h-100">
								<div class="card-body">
									<div class="d-flex align-items-start">
										<div class="me-3 flex-shrink-0">
											<?php if (!empty($thumbnailSrc) && check_file_exists($thumbnailUrl, true)): ?>
												<img src="<?=$thumbnailSrc?>" alt="<?=$projectName?>" class="avatar avatar-xl object-cover">
											<?php else: ?>
												<span class="avatar avatar-xl bg-azure-lt text-uppercase fw-bold">
													<?=htmlspecialchars(strtoupper(substr(trim($projectName), 0, 1)), ENT_QUOTES, 'UTF-8')?>
												</span>
											<?php endif; ?>
										</div>
										<div class="flex-grow-1">
											<div class="d-flex justify-content-between align-items-start">
												<div>
													<h4 class="card-title mb-1"><?=htmlspecialchars($projectName, ENT_QUOTES, 'UTF-8')?></h4>
													<div class="text-muted small">Created <?=!empty($project->created_at) ? date('d M Y H:i', strtotime($project->created_at)) : 'N/A'?></div>
												</div>
												<div class="text-end">
													<span class="badge bg-purple-lt mb-1"><?=htmlspecialchars($statusName, ENT_QUOTES, 'UTF-8')?></span>
													<div><span class="badge <?=$activeClass?>"><?=htmlspecialchars($activeBadge, ENT_QUOTES, 'UTF-8')?></span></div>
												</div>
											</div>
											<p class="text-muted only-so-big mt-2 mb-3"><?=htmlspecialchars($projectDescription, ENT_QUOTES, 'UTF-8')?></p>
											<?php if (!empty($dependence)): ?>
												<div class="mb-3">
													<span class="badge bg-blue-lt">Dependencies</span>
													<div class="text-muted small mt-1"><?=htmlspecialchars($dependence, ENT_QUOTES, 'UTF-8')?></div>
												</div>
											<?php endif; ?>
											<div class="row g-2 mb-3">
												<div class="col-6">
													<div class="small text-muted">Start</div>
													<div class="fw-semibold"><?=$startAt?></div>
												</div>
												<div class="col-6 text-end">
													<div class="small text-muted">Due</div>
													<div class="fw-semibold"><?=$dueAt?></div>
												</div>
											</div>
											<div class="row g-2 mb-3">
												<div class="col-4">
													<div class="small text-muted">Allocated</div>
													<div class="fw-semibold"><?=number_format($budgetAllocated, 2)?></div>
												</div>
												<div class="col-4 text-center">
													<div class="small text-muted">Used</div>
													<div class="fw-semibold text-orange"><?=number_format($budgetUsed, 2)?></div>
												</div>
												<div class="col-4 text-end">
													<div class="small text-muted">Balance</div>
													<div class="fw-semibold <?=($budgetBalance < 0) ? 'text-red' : 'text-green'?>"><?=number_format($budgetBalance, 2)?></div>
												</div>
											</div>
											<?php if (!empty($notes)): ?>
												<div class="border rounded p-2 bg-light-lt mb-3">
													<div class="small text-muted">Notes</div>
													<div><?=htmlspecialchars($notes, ENT_QUOTES, 'UTF-8')?></div>
												</div>
											<?php endif; ?>
											<div class="d-flex justify-content-between align-items-center">
												<div class="text-muted small">Updated <?=!empty($project->updated_at) ? date('d M Y H:i', strtotime($project->updated_at)) : 'Never'?></div>
												<?php if ($viewUserRight || $editUserRight || $removeUserRight): ?>
													<span class="dropdown">
														<button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="javascript:void(0);" onclick="viewProjectModal('<?=$projectId?>');">
																<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7z" /></svg> View
															</a>
															<?php if ($editUserRight): ?>
																<a class="dropdown-item" href="javascript:void(0);" onclick="editProjectModal('<?=$projectId?>');">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg> Edit
																</a>
															<?php endif; if ($removeUserRight): ?>
																<a class="dropdown-item" href="javascript:void(0);" onclick="removeProjectModal('<?=$projectId?>');">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
																</a>
															<?php endif; ?>
														</div>
													</span>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php else: ?>
					<div class="col-12">
						<div class="card">
							<div class="card-body text-center py-5">
								<span class="badge bg-red-lt">No projects found.</span>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<script>
	addProjectModal = function () {
		showModal(base_url + 'add-project-modal', function () {});
	};

		viewProjectModal = function (projectId) {
			showModal(base_url + 'view-project-modal/' + projectId, function () {});
		};

	editProjectModal = function (projectId) {
		showModal(base_url + 'edit-project-modal/' + projectId, function () {});
	};

	removeProjectModal = function (projectId) {
		showModal(base_url + 'remove-project-modal/' + projectId, function () {});
	};
</script>
