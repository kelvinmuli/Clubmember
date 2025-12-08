<?php
$pageTitle = isset($moduleMenu) && !empty($moduleMenu->name) ? $moduleMenu->name : 'Fundraising';
$modulePath = isset($moduleMenu) && !empty($moduleMenu->path) ? $moduleMenu->path : 'fundraising';
$fundraisingData = $fundraisingData ?? [];
$contributionIndex = $contributionIndex ?? [];
$summary = $fundraisingSummary ?? [
    'total_campaigns' => 0,
    'total_goal' => 0.0,
    'total_received' => 0.0,
    'total_contributors' => 0,
    'average_completion' => 0.0,
    'top_campaign' => null,
];
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
                            <a class="btn btn-primary btn-pill" href="javascript:void(0);" onclick="addFundraisingModal()">
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
                            <h3 class="card-title mb-0">Fundraising Overview</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 g-md-4">
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar bg-blue-lt text-blue me-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-nurse" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="5" y="4" width="14" height="6" rx="1" /><path d="M10 9v3" /><path d="M14 9v3" /><path d="M12 9v6" /><path d="M6 18a6 6 0 0 1 12 0" /></svg></span>
                                        <div>
                                            <div class="text-secondary text-uppercase fs-11">Total Campaigns</div>
                                            <div class="h3 mb-0"><?=number_format($summary['total_campaigns'])?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar bg-green-lt text-green me-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-currency-dollar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3a4 4 0 0 1 4 4c0 3 -4 5 -4 8" /><path d="M12 17v4" /><path d="M8 8a4 4 0 0 1 4 -4" /><path d="M8 12c0 3 4 5 4 8" /></svg></span>
                                        <div>
                                            <div class="text-secondary text-uppercase fs-11">Raised / Goal</div>
                                            <div class="fw-semibold"><?=number_format($summary['total_received'], 2)?> / <span class="text-muted"><?=number_format($summary['total_goal'], 2)?></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar bg-orange-lt text-orange me-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-donut" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M12 3v4" /><path d="M12 12l2 -2" /></svg></span>
                                        <div>
                                            <div class="text-secondary text-uppercase fs-11">Avg Completion</div>
                                            <div class="h3 mb-0"><?=number_format($summary['average_completion'], 1)?>%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center">
                                        <span class="avatar bg-purple-lt text-purple me-3 mb-2 mb-md-0"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M17 11v-2a4 4 0 0 0 -4 -4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4" /><path d="M16 19h6" /><path d="M19 16v6" /></svg></span>
                                        <div class="w-100">
                                            <div class="text-secondary text-uppercase fs-11">Contributors</div>
                                            <div class="h3 mb-0"><?=number_format($summary['total_contributors'])?></div>
                                            <div class="text-muted small">Top: <?=$summary['top_campaign'] ? $summary['top_campaign'] : 'N/A'?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Campaigns</h3>
                        </div>
						<div class="card-body border-bottom py-3">
							<div class="table-responsive">
								<table class="table table-vcenter card-table" id="fundraising-datatable">
									<thead>
										<tr>
											<th>Name</th>
											<th>Description</th>
											<th class="w-1">Goal</th>
											<th class="w-1">Raised</th>
											<th class="w-25">Progress</th>
											<th>Contributors</th>
											<th>Period</th>
											<th>Top Contributor</th>
											<?php if ($viewUserRight || $editUserRight || $removeUserRight): ?>
												<th class="w-1">Actions</th>
											<?php endif; ?>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($fundraisingData)): ?>
											<?php foreach ($fundraisingData as $campaign): ?>
												<?php
													$fundraisingId = $campaign->fundraising_id ?? '';
													$name = $campaign->name ?? 'Untitled';
													$reason = $campaign->reason ?? '';
													$description = $campaign->description ?? '';
													$goalAmount = isset($campaign->total_amount) ? (float) $campaign->total_amount : 0.0;
													$recordedReceived = isset($campaign->total_received) ? (float) $campaign->total_received : 0.0;
													$contributionStats = $fundraisingId && isset($contributionIndex[$fundraisingId]) ? $contributionIndex[$fundraisingId] : ['contribution_count' => 0, 'total_paid' => 0.0, 'max_paid_amount' => 0.0];
													$receivedAmount = $contributionStats['total_paid'] > 0 ? $contributionStats['total_paid'] : $recordedReceived;
													$contributorsCount = !empty($campaign->number_of_contributor) ? (int) $campaign->number_of_contributor : (int) $contributionStats['contribution_count'];
													$progressPercent = ($goalAmount > 0) ? min(100, round(($receivedAmount / max($goalAmount, 1)) * 100, 1)) : 0;
													$startDate = !empty($campaign->start_date) ? date('d M Y', strtotime($campaign->start_date)) : 'Not Set';
													$endDate = !empty($campaign->end_date) ? date('d M Y', strtotime($campaign->end_date)) : 'Not Set';
													$leadContributor = $campaign->top_contributor ?? '';
												?>
												<tr>
													<td>
														<div class="fw-semibold"><?=$name?></div>
														<?php if (!empty($reason)): ?>
															<div class="text-muted small">Reason: <?=$reason?></div>
														<?php endif; ?>
													</td>
													<td>	
														<?php if (!empty($description)): ?>
															<div class="text-muted small only-so-big"><?=$description?></div>
														<?php endif; ?>
													</td>
													<td><?=number_format($goalAmount, 2)?></td>
													<td>
														<div><?=number_format($receivedAmount, 2)?></div>
														<?php if ($contributionStats['max_paid_amount'] > 0): ?>
															<div class="text-muted small">Max: <?=number_format($contributionStats['max_paid_amount'], 2)?></div>
														<?php endif; ?>
													</td>
													<td>
														<div class="progress progress-sm">
															<div class="progress-bar bg-green" style="width: <?=$progressPercent?>%" role="progressbar" aria-valuenow="<?=$progressPercent?>" aria-valuemin="0" aria-valuemax="100"></div>
														</div>
														<div class="small text-muted mt-1"><?=$progressPercent?>%</div>
													</td>
													<td>
														<div><?=number_format($contributorsCount)?></div>
														<div class="text-muted small">Transactions: <?=number_format($contributionStats['contribution_count'])?></div>
													</td>
													<td>
														<div><?=$startDate?></div>
														<div class="text-muted small">to <?=$endDate?></div>
													</td>
													<td><?=!empty($leadContributor) ? $leadContributor : 'N/A'?></td>
													<?php if ($viewUserRight || $editUserRight || $removeUserRight): ?>
														<td>
															<span class="dropdown">
																<button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
																<div class="dropdown-menu dropdown-menu-end">
																	<a class="dropdown-item" href="javascript:void(0);" onclick="viewFundraisingPaymentHistoryModal('<?=$fundraisingId?>');">
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7h14" /><path d="M5 12h14" /><path d="M5 17h14" /></svg> View Contributions
																	</a>
																	<?php if ($editUserRight): ?>
																		<a class="dropdown-item" href="javascript:void(0);" onclick="editFundraisingModal('<?=$fundraisingId?>');">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg> Edit
																		</a>
																	<?php endif; if ($removeUserRight): ?>
																		<a class="dropdown-item" href="javascript:void(0);" onclick="deleteFundraisingModal('<?=$fundraisingId?>');">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
																		</a>
																	<?php endif; ?>
																	<a class="dropdown-item" href="javascript:void(0);" onclick="addFundraisingPaymentHistoryModal('<?=$fundraisingId?>');">
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c2.21 0 4 1.79 4 4v1h-8v-1c0 -2.21 1.79 -4 4 -4z" /><path d="M6 8h12v5a6 6 0 1 1 -12 0v-5z" /><line x1="3" y1="21" x2="21" y2="21" /></svg> Add Contribution
																	</a>
																</div>
															</span>
														</td>
													<?php endif; ?>
												</tr>
											<?php endforeach; ?>
										<?php else: ?>
											<tr>
												<td colspan="<?=($editUserRight || $removeUserRight) ? '8' : '7'?>" class="text-center">
													<span class="badge bg-red-lt">No fundraising campaigns found.</span>
													<?php if (!empty($inputUserRight)): ?>
														<p class="text-muted m-0 mt-2">Click the Add Fundraising button to start your first campaign.</p>
													<?php endif; ?>
												</td>
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
    $(document).ready(function () {
        loadDatatable('fundraising-datatable', <?=json_encode($pageTitle)?>);
    });

    addFundraisingModal = function () {
        showModal(base_url + 'add-fundraising-modal', function () {});
    };

    editFundraisingModal = function (fundraisingId) {
        showModal(base_url + 'edit-fundraising-modal/' + fundraisingId, function () {});
    };

    deleteFundraisingModal = function (fundraisingId) {
        showModal(base_url + 'delete-fundraising-modal/' + fundraisingId, function () {});
    };

	addFundraisingPaymentHistoryModal = function (fundraisingId) {
		showModal(base_url + 'add-fundraising-payment-history-modal/' + fundraisingId, function () {});
	}

	viewFundraisingPaymentHistoryModal = function (fundraisingId) {
		showModal(base_url + 'view-fundraising-payment-history-modal/' + fundraisingId, function () {});
	}
</script>
