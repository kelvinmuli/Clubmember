<?php
$pageTitle = isset($moduleMenu) && !empty($moduleMenu->name) ? $moduleMenu->name : 'Projects';
$modulePath = isset($moduleMenu) && !empty($moduleMenu->path) ? $moduleMenu->path : 'projects';
$projectData = $projectData ?? [];
$projectSummary = $projectSummary ?? [
	'total_projects' => 0,
	'active_projects' => 0,
	'completed_projects' => 0,
	'budget_allocated' => 0.0,
	'budget_used' => 0.0,
];
$pagination = $pagination ?? ['page' => 1, 'per_page' => 12, 'total' => 0, 'pages' => 1];
$basePageUrl = base_url($modulePath);
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
						
						<div class="card-body">
							<div class="row g-3 g-md-4">
								<div class="col-6 col-md-3">
									<div class="d-flex align-items-center">
										<span class="avatar bg-blue-lt text-blue me-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-briefcase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7l1.664 -3.327a1 1 0 0 1 .894 -.547h12.884a1 1 0 0 1 .894 .547l1.664 3.327" /><path d="M21 7v11a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11" /><path d="M8 7v-4h8v4" /><path d="M12 12h.01" /><path d="M3 13a20 20 0 0 0 18 0" /></svg></span>
										<div>
											<div class="text-secondary text-uppercase fs-11">Total Projects</div>
											<div class="h3 mb-0"><?=number_format($projectSummary['total_projects'])?></div>
										</div>
									</div>
								</div>
								<div class="col-6 col-md-3">
									<div class="d-flex align-items-center">
										<span class="avatar bg-green-lt text-green me-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rocket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4.5 21l5.5 -5.5" /><path d="M5 21l-1 -4l4 1" /><path d="M10 14l11 -11" /><path d="M16 4l4 4" /><path d="M15 9l-1 1" /><path d="M3 12a6 6 0 0 1 6 6" /></svg></span>
										<div>
											<div class="text-secondary text-uppercase fs-11">Active</div>
											<div class="h3 mb-0"><?=number_format($projectSummary['active_projects'])?></div>
										</div>
									</div>
								</div>
								<div class="col-6 col-md-3">
									<div class="d-flex align-items-center">
										<span class="avatar bg-purple-lt text-purple me-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg></span>
										<div>
											<div class="text-secondary text-uppercase fs-11">Completed</div>
											<div class="h3 mb-0"><?=number_format($projectSummary['completed_projects'])?></div>
										</div>
									</div>
								</div>
								<div class="col-6 col-md-3">
									<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center">
										<span class="avatar bg-orange-lt text-orange me-3 mb-2 mb-md-0"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-currency-dollar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3a4 4 0 0 1 4 4c0 3 -4 5 -4 8" /><path d="M12 17v4" /><path d="M8 8a4 4 0 0 1 4 -4" /><path d="M8 12c0 3 4 5 4 8" /></svg></span>
										<div class="w-100">
											<div class="text-secondary text-uppercase fs-11">Budget (Alloc / Used)</div>
											<div class="fw-semibold"><?=number_format($projectSummary['budget_allocated'], 2)?> / <span class="text-orange"><?=number_format($projectSummary['budget_used'], 2)?></span></div>
										</div>
									</div>
								</div>
							</div>
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
							$startAt = !empty($project->start_at) ? date('d M Y', strtotime($project->start_at)) : 'Not Set';
							$dueAt = !empty($project->due_at) ? date('d M Y', strtotime($project->due_at)) : 'Not Set';
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
													<?=strtoupper(substr(trim($projectName), 0, 1))?>
												</span>
											<?php endif; ?>
										</div>
										<div class="flex-grow-1">
											<div class="d-flex justify-content-between align-items-start">
												<div>
													<h4 class="card-title mb-1"><?=$projectName?></h4>
													<div class="text-muted small">Created <?=!empty($project->created_at) ? date('d M Y', strtotime($project->created_at)) : 'N/A'?></div>
												</div>
												<div class="text-end">
													<span class="badge bg-purple-lt mb-1"><?=$statusName?></span>
													<div><span class="badge <?=$activeClass?>"><?=$activeBadge?></span></div>
												</div>
											</div>
											<p class="text-muted only-so-big mt-2 mb-3"><?=$projectDescription?></p>
											<?php if (!empty($dependence)): ?>
												<div class="mb-3">
													<span class="badge bg-blue-lt">Dependencies</span>
													<div class="text-muted small mt-1"><?=$dependence?></div>
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
													<div><?=$notes?></div>
												</div>
											<?php endif; ?>
											<div class="d-flex justify-content-between align-items-center">
												<div class="text-muted small">Updated <?=!empty($project->updated_at) ? date('d M Y', strtotime($project->updated_at)) : 'Never'?></div>
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

				<?php if (!empty($projectData)): ?>
					<div class="col-12">
						<nav aria-label="Project pagination">
							<ul class="pagination justify-content-center mt-4">
								<?php
									$currentPage = (int) $pagination['page'];
									$totalPages = (int) $pagination['pages'];
									$perPage = (int) $pagination['per_page'];
									$queryParams = $_GET;
									$queryParams['per_page'] = $perPage;
									$buildUrl = function($page) use ($basePageUrl, $queryParams) {
										$queryParams['page'] = $page;
										return $basePageUrl . '?' . http_build_query($queryParams);
									};
								?>
								<li class="page-item <?=$currentPage <= 1 ? 'disabled' : ''?>">
									<a class="page-link" href="<?=$currentPage > 1 ? $buildUrl($currentPage - 1) : '#'?>" tabindex="-1" aria-disabled="<?=$currentPage <= 1 ? 'true' : 'false'?>">Prev</a>
								</li>
								<?php
									$start = max(1, $currentPage - 2);
									$end = min($totalPages, $currentPage + 2);
									if ($start > 1) {
										echo '<li class="page-item"><a class="page-link" href="' . $buildUrl(1) . '">1</a></li>';
										if ($start > 2) {
											echo '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>';
										}
									}

									for ($page = $start; $page <= $end; $page++) {
										echo '<li class="page-item ' . ($page == $currentPage ? 'active' : '') . '"><a class="page-link" href="' . $buildUrl($page) . '">' . $page . '</a></li>';
									}

									if ($end < $totalPages) {
										if ($end < $totalPages - 1) {
											echo '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>';
										}
										echo '<li class="page-item"><a class="page-link" href="' . $buildUrl($totalPages) . '">' . $totalPages . '</a></li>';
									}
								?>
								<li class="page-item <?=$currentPage >= $totalPages ? 'disabled' : ''?>">
									<a class="page-link" href="<?=$currentPage < $totalPages ? $buildUrl($currentPage + 1) : '#'?>" aria-disabled="<?=$currentPage >= $totalPages ? 'true' : 'false'?>">Next</a>
								</li>
							</ul>
						</nav>
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

	editProjectModal = function (projectId) {
		showModal(base_url + 'edit-project-modal/' + projectId, function () {});
	};

	removeProjectModal = function (projectId) {
		showModal(base_url + 'remove-project-modal/' + projectId, function () {});
	};
</script>
