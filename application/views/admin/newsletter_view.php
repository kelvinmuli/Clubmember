<?php
$pageTitle = isset($moduleMenu) && !empty($moduleMenu->name) ? $moduleMenu->name : 'Newsletters';
$modulePath = isset($moduleMenu) && !empty($moduleMenu->path) ? $moduleMenu->path : 'newsletter';
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?=$pageTitle?></h3>
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
					<div class="text-center text-muted py-5">
						<span class="badge bg-red-lt">No newsletters found.</span>
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
