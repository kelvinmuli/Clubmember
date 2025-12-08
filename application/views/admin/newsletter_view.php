<?php
$pageTitle = isset($moduleMenu) && !empty($moduleMenu->name) ? $moduleMenu->name : 'Newsletters';
$modulePath = isset($moduleMenu) && !empty($moduleMenu->path) ? $moduleMenu->path : 'newsletter';
$newsletterData = $newsletterData ?? [];
$newsletterSummary = $newsletterSummary ?? [
	'total_newsletters' => 0,
	'active_newsletters' => 0,
	'inactive_newsletters' => 0,
	'recent_newsletters' => 0,
	'with_thumbnails' => 0,
	'latest_newsletter_at' => null,
];
$pagination = $pagination ?? ['page' => 1, 'per_page' => 12, 'total' => 0, 'pages' => 1];
$basePageUrl = base_url($modulePath);

$totalNewsletters = max(0, (int) ($newsletterSummary['total_newsletters'] ?? 0));
$activeNewsletters = max(0, (int) ($newsletterSummary['active_newsletters'] ?? 0));
$inactiveNewsletters = max(0, (int) ($newsletterSummary['inactive_newsletters'] ?? 0));
$recentNewsletters = max(0, (int) ($newsletterSummary['recent_newsletters'] ?? 0));
$withThumbnails = max(0, (int) ($newsletterSummary['with_thumbnails'] ?? 0));
$latestNewsletterLabel = !empty($newsletterSummary['latest_newsletter_at']) ? date('d M Y H:i', strtotime($newsletterSummary['latest_newsletter_at'])) : 'Not yet created';
$denominator = max(1, $totalNewsletters);
$activePercent = $totalNewsletters > 0 ? round(($activeNewsletters / $denominator) * 100) : 0;
$inactivePercent = $totalNewsletters > 0 ? round(($inactiveNewsletters / $denominator) * 100) : 0;
$thumbnailPercent = $totalNewsletters > 0 ? round(($withThumbnails / $denominator) * 100) : 0;
?>

<div class="page-wrapper">
    <div class="container-fluid">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>">Website</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('home')?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url($modulePath)?>"><?=$pageTitle?></a></li>
                    </ol>
                </div>

                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <?php if (!empty($inputUserRight)): ?>
                            <a class="btn btn-primary btn-pill" onclick="addNewsletterModal();" href="javascript:void(0);">
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
					<div class="card mb-3">
						<div class="card-header">
							<h3 class="card-title mb-0"><?=$pageTitle?></h3>
						</div>
						<div class="card-body">
							<div class="row g-3 g-md-4">
								<div class="col-6 col-md-3">
									<div class="d-flex align-items-center">
										<span class="avatar bg-blue-lt text-blue me-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="5" width="18" height="14" rx="2" /><polyline points="3 7 12 13 21 7" /></svg></span>
										<div>
											<div class="text-secondary text-uppercase fs-11">Total Newsletters</div>
											<div class="h3 mb-0"><?=number_format($totalNewsletters)?></div>
											<div class="small text-muted mt-1">
												<?=number_format($withThumbnails)?> with thumbnails
												<span class="badge bg-blue-lt ms-1"><?=$thumbnailPercent?>%</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-6 col-md-3">
									<div class="d-flex align-items-center">
										<span class="avatar bg-green-lt text-green me-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="10" y1="14" x2="21" y2="3" /><path d="M21 3l-6 18a0.55 .55 0 0 1 -1 0l-3.5 -7.5l-7.5 -3.5a0.55 .55 0 0 1 0 -1l18 -6" /></svg></span>
										<div>
											<div class="text-secondary text-uppercase fs-11">Active</div>
											<div class="h3 mb-0"><?=number_format($activeNewsletters)?></div>
											<div class="small text-muted mt-1">
												<span class="badge bg-green-lt text-green me-1"><?=$activePercent?>%</span>of total
											</div>
										</div>
									</div>
								</div>
								<div class="col-6 col-md-3">
									<div class="d-flex align-items-center">
										<span class="avatar bg-red-lt text-red me-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-archive" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="4" rx="2" /><path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" /><line x1="10" y1="12" x2="14" y2="12" /></svg></span>
										<div>
											<div class="text-secondary text-uppercase fs-11">Inactive</div>
											<div class="h3 mb-0"><?=number_format($inactiveNewsletters)?></div>
											<div class="small text-muted mt-1"><span class="badge bg-red-lt text-red me-1"><?=$inactivePercent?>%</span>of catalog</div>
										</div>
									</div>
								</div>
								<div class="col-6 col-md-3">
									<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center">
										<span class="avatar bg-cyan-lt text-cyan me-3 mb-2 mb-md-0"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><polyline points="12 7 12 12 15 15" /></svg></span>
										<div class="w-100">
											<div class="text-secondary text-uppercase fs-11">Recent (30 days)</div>
											<div class="h3 mb-0"><?=number_format($recentNewsletters)?></div>
											<div class="small text-muted mt-1">Latest: <?=$latestNewsletterLabel?></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php if (!empty($newsletterData)): ?>
					<?php foreach ($newsletterData as $newsletter): ?>
						<div class="col-md-6 col-xl-4">
							<div class="card h-100">
								<div class="card-body">
									<div class="d-flex align-items-start">
										<div class="me-3 flex-shrink-0">
											<?php if (check_file_exists($newsletter->thumbnail_url)): ?>
												<img src="<?=base_url($newsletter->thumbnail_url)?>" alt="Thumbnail" class="avatar avatar-xl">
											<?php else: ?>
												<span class="avatar avatar-xl bg-blue-lt text-uppercase fw-bold"><?=strtoupper(substr(trim($newsletter->name ?? 'N'), 0, 1))?></span>
											<?php endif; ?>
										</div>
										<div class="flex-grow-1">
											<div class="d-flex justify-content-between align-items-start">
												<div>
													<h4 class="card-title mb-1"><?=$newsletter->name?></h4>
													<div class="text-muted small">Created <?=!empty($newsletter->created_at) ? date('d M Y H:i', strtotime($newsletter->created_at)) : 'N/A'?></div>
												</div>
												<span class="badge <?=($newsletter->active === 1) ? 'bg-green-lt' : (($newsletter->active === 0) ? 'bg-red-lt' : 'bg-yellow-lt')?>"><?=get_table('m_active', 'num', $newsletter->active, 'name')?></span>
											</div>
											<div class="text-muted only-so-big mt-2 mb-3"><?=$newsletter->description ?? ''?></div>
											<div class="d-flex align-items-center justify-content-between">
												<?php if (check_file_exists($newsletter->thumbnail_url)): ?>
													<a class="btn btn-sm btn-outline-secondary" href="<?=base_url($newsletter->thumbnail_url)?>" target="_blank" rel="noopener">View Thumbnail</a>
												<?php else: ?>
													<span class="text-muted small">No thumbnail</span>
												<?php endif; if ($viewUserRight || $editUserRight || $removeUserRight): ?>
													<span class="dropdown">
														<button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
														<div class="dropdown-menu dropdown-menu-end">
															<a href="javascript:void(0);" class="dropdown-item" onclick="viewNewsletterModal('<?=$newsletter->newsletter_id?>')">
																<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7z" /></svg> View
															</a>
															<?php if ($editUserRight): ?>
																<a href="javascript:void(0);" class="dropdown-item" onclick="editNewsletterModal('<?=$newsletter->newsletter_id?>')">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg> Edit
																</a>
															<?php endif; if ($removeUserRight): ?>
																<a href="javascript:void(0);" class="dropdown-item" onclick="removeNewsletterModal('<?=$newsletter->newsletter_id?>')">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
																</a>
															<?php endif; if (in_array($user_type_id, [GlobalModel::ADMIN_TYPE, GlobalModel::CLUB_ADMIN_TYPE])): ?>
																<a href="<?=base_url('send-newsletter/'.$newsletter->newsletter_id)?>" class="dropdown-item">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h16v16H4z" /><path d="M4 4l8 8m0 0l8 -8m-8 8v8" /></svg> Send Newsletter
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
								<span class="badge bg-red-lt">No newsletters found.</span>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php if (!empty($newsletterData) && ($pagination['pages'] ?? 1) > 1): ?>
					<div class="col-12">
						<nav aria-label="Newsletter pagination">
							<ul class="pagination justify-content-center mt-4">
								<?php
									$currentPage = (int) ($pagination['page'] ?? 1);
									$totalPages = (int) ($pagination['pages'] ?? 1);
									$perPage = (int) ($pagination['per_page'] ?? 12);
									$queryParams = $_GET;
									$queryParams['per_page'] = $perPage;
									$basePaginationUrl = $basePageUrl;
									$buildUrl = function ($page) use ($basePaginationUrl, $queryParams) {
										$queryParams['page'] = $page;
										return $basePaginationUrl . '?' . http_build_query($queryParams);
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
    addNewsletterModal = function() {
        showModal(base_url + 'add-newsletter-modal', function () {
			loadDescription('add_edit_description');
		});
    };

	viewNewsletterModal = function(newsletterId) {
        showModal(base_url + 'view-newsletter-modal/' + newsletterId, function () {
		});
    };

    editNewsletterModal = function(newsletterId) {
        showModal(base_url + 'edit-newsletter-modal/' + newsletterId, function () {
			loadDescription('add_edit_description');
		});
    };

    removeNewsletterModal = function(newsletterId) {
        showModal(base_url + 'remove-newsletter-modal/' + newsletterId, function () {});
    };
</script>
