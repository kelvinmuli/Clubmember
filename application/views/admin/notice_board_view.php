<?php
$pageTitle = isset($moduleMenu) && !empty($moduleMenu->name) ? $moduleMenu->name : 'Notice Board';
$modulePath = isset($moduleMenu) && !empty($moduleMenu->path) ? $moduleMenu->path : 'notice-board';
$noticeBoardData = $noticeBoardData ?? [];
$noticeSummary = $noticeSummary ?? [
    'total_notices' => 0,
    'with_attachments' => 0,
    'with_thumbnails' => 0,
    'recent_notices' => 0,
    'latest_notice_at' => null,
];
$pagination = $pagination ?? ['page' => 1, 'per_page' => 9, 'total' => 0, 'pages' => 1];
$basePageUrl = base_url($modulePath);
?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">

                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url($modulePath) ?>"><?= $pageTitle ?></a></li>
                    </ol>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <?php if (!empty($inputUserRight)): ?>
                            <a class="btn btn-primary btn-pill" href="javascript:void(0);" onclick="addNoticeBoardModal();">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg> Add Notice
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
                            <h3 class="card-title mb-0"><?= $pageTitle ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 g-md-4">
                                <?php
                                $totalNotices = max(0, (int) ($noticeSummary['total_notices'] ?? 0));
                                $withAttachments = max(0, (int) ($noticeSummary['with_attachments'] ?? 0));
                                $withThumbnails = max(0, (int) ($noticeSummary['with_thumbnails'] ?? 0));
                                $recentNotices = max(0, (int) ($noticeSummary['recent_notices'] ?? 0));
                                $latestLabel = !empty($noticeSummary['latest_notice_at']) ? date('d M Y', strtotime($noticeSummary['latest_notice_at'])) : 'Not yet created';
                                $den = max(1, $totalNotices);
                                $attachPct = $totalNotices > 0 ? round(($withAttachments / $den) * 100) : 0;
                                $thumbPct = $totalNotices > 0 ? round(($withThumbnails / $den) * 100) : 0;
                                ?>
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar bg-blue-lt text-blue me-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                                <polyline points="3 7 12 13 21 7" />
                                            </svg></span>
                                        <div>
                                            <div class="text-secondary text-uppercase fs-11">Total Notices</div>
                                            <div class="h3 mb-0"><?= number_format($totalNotices) ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar bg-green-lt text-green me-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paperclip" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M21.44 11.05l-8.48 8.49a5 5 0 0 1 -7.07 0a5 5 0 0 1 0 -7.07l8.48 -8.49a3 3 0 1 1 4.24 4.24l-8.48 8.49a1 1 0 0 1 -1.41 0a1 1 0 0 1 0 -1.41l7.07 -7.07" />
                                            </svg></span>
                                        <div>
                                            <div class="text-secondary text-uppercase fs-11">Attachments</div>
                                            <div class="h3 mb-0"><?= number_format($withAttachments) ?></div>
                                            <div class="small text-muted mt-1"><span class="badge bg-green-lt me-1"><?= $attachPct ?>%</span>have attachments</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar bg-cyan-lt text-cyan me-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-image" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                                <circle cx="9" cy="9" r="2" />
                                                <path d="M21 15l-5 -5l-4 4l-3 -3l-5 5" />
                                            </svg></span>
                                        <div>
                                            <div class="text-secondary text-uppercase fs-11">Thumbnails</div>
                                            <div class="h3 mb-0"><?= number_format($withThumbnails) ?></div>
                                            <div class="small text-muted mt-1"><span class="badge bg-cyan-lt me-1"><?= $thumbPct ?>%</span>have images</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center">
                                        <span class="avatar bg-purple-lt text-purple me-3 mb-2 mb-md-0"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <circle cx="12" cy="12" r="9" />
                                                <polyline points="12 7 12 12 15 15" />
                                            </svg></span>
                                        <div class="w-100">
                                            <div class="text-secondary text-uppercase fs-11">Recent (30 days)</div>
                                            <div class="h3 mb-0"><?= number_format($recentNotices) ?></div>
                                            <div class="small text-muted mt-1">Latest: <?= $latestLabel ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($noticeBoardData)): ?>
                    <?php foreach ($noticeBoardData as $notice): ?>
                        <?php
                        $noticeId = $notice->notice_board_id ?? '';
                        $name = $notice->name ?? 'Untitled';
                        $description = $notice->description ?? '';
                        $thumbnail = trim($notice->thumbnail_url ?? '');
                        $attachment = trim($notice->attachment_url ?? '');
                        $createdAt = !empty($notice->created_at) ? date('d M Y', strtotime($notice->created_at)) : 'N/A';
                        $thumbnailSrc = '';
                        if (!empty($thumbnail)) {
                            $thumbnailSrc = filter_var($thumbnail, FILTER_VALIDATE_URL) ? $thumbnail : base_url($thumbnail);
                        }
                        ?>
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="me-3 flex-shrink-0">
                                            <?php if (!empty($thumbnailSrc) && check_file_exists($thumbnail, true)): ?>
                                                <img src="<?= $thumbnailSrc ?>" alt="<?= $name ?>" class="avatar avatar-xl object-cover">
                                            <?php else: ?>
                                                <span class="avatar avatar-xl bg-azure-lt text-uppercase fw-bold"><?= strtoupper(substr(trim($name), 0, 1)) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="card-title mb-1"><?= $name ?></h4>
                                                    <div class="text-muted small">Posted <?= $createdAt ?></div>
                                                </div>
                                                <?php if (!empty($viewUserRight) || !empty($editUserRight) || !empty($removeUserRight)): ?>
                                                    <div class="text-end">
                                                        <span class="dropdown">
                                                            <button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a href="javascript:void(0);" class="dropdown-item" onclick="viewNoticeBoardModal('<?= $noticeId ?>')">View</a>
                                                                <?php if (!empty($editUserRight)): ?>
                                                                    <a href="javascript:void(0);" class="dropdown-item" onclick="editNoticeBoardModal('<?= $noticeId ?>')">Edit</a>
                                                                <?php endif;
                                                                if (!empty($removeUserRight)): ?>
                                                                    <a href="javascript:void(0);" class="dropdown-item" onclick="removeNoticeBoardModal('<?= $noticeId ?>')">Delete</a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <p class="text-muted only-so-big mt-2 mb-3"><?= $description ?></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="text-muted small">&nbsp;</div>
                                                <div>
                                                    <?php if (!empty($attachment)): ?>
                                                        <?php $attachmentSrc = filter_var($attachment, FILTER_VALIDATE_URL) ? $attachment : base_url($attachment); ?>
                                                        <a class="btn btn-sm btn-outline-secondary" href="<?= $attachmentSrc ?>" target="_blank" rel="noopener">Download</a>
                                                    <?php else: ?>
                                                        <span class="text-muted small">No attachment</span>
                                                    <?php endif; ?>
                                                </div>
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
                                <span class="badge bg-red-lt">No notices found.</span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($noticeBoardData) && ($pagination['pages'] ?? 1) > 1): ?>
                    <div class="col-12">
                        <nav aria-label="Notice pagination">
                            <ul class="pagination justify-content-center mt-4">
                                <?php
                                $currentPage = (int) ($pagination['page'] ?? 1);
                                $totalPages = (int) ($pagination['pages'] ?? 1);
                                $perPage = (int) ($pagination['per_page'] ?? 9);
                                $queryParams = $_GET;
                                $queryParams['per_page'] = $perPage;
                                $basePaginationUrl = $basePageUrl;
                                $buildUrl = function ($page) use ($basePaginationUrl, $queryParams) {
                                    $queryParams['page'] = $page;
                                    return $basePaginationUrl . '?' . http_build_query($queryParams);
                                };
                                ?>
                                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= $currentPage > 1 ? $buildUrl($currentPage - 1) : '#' ?>" tabindex="-1" aria-disabled="<?= $currentPage <= 1 ? 'true' : 'false' ?>">Prev</a>
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
                                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= $currentPage < $totalPages ? $buildUrl($currentPage + 1) : '#' ?>" aria-disabled="<?= $currentPage >= $totalPages ? 'true' : 'false' ?>">Next</a>
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
    addNoticeBoardModal = function() {
        showModal(base_url + 'add-notice-board-modal', function() {
            loadTextEditer('description');
        });
    };

    editNoticeBoardModal = function(noticeId) {
        showModal(base_url + 'edit-notice-board-modal' + (noticeId ? '/' + noticeId : ''), function() {
            loadTextEditer('description');
        });
    };

    removeNoticeBoardModal = function(noticeId) {
        showModal(base_url + 'remove-notice-board-modal/' + noticeId, function() {});
    };
</script>
