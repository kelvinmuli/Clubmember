<?php 
	$incidentData = $incidentData ?? [];
	$incidentTypeIndex = $incidentTypeIndex ?? [];
	$incidentStatusIndex = $incidentStatusIndex ?? [];
	$activeIndex = $activeIndex ?? [];
	$summaryDefaults = array(
		'total' => 0,
		'recent' => null,
		'location_count' => 0,
		'reporter_count' => 0,
		'statuses' => array(),
	);
	$summary = array_merge($summaryDefaults, $summary ?? []);
	$statusSummary = $summary['statuses'] ?? [];
	$statusCards = !empty($statusSummary) ? array_slice($statusSummary, 0, 2) : [];
	if (empty($statusCards)) {
		$statusCards[] = array(
			'id' => 'no-status',
			'label' => 'Status',
			'count' => 0,
			'text_class' => 'text-primary',
			'description' => 'No status data available',
		);
	}
	$chartData = $chartData ?? array(
		'type' => array('labels' => array(), 'series' => array()),
		'timeline' => array('categories' => array(), 'series' => array(array('name' => 'Incidents', 'data' => array()))),
		'status' => array('labels' => array(), 'series' => array()),
	);
	$approvedMembersMonthly = $approvedMembersMonthly ?? array(
		'categories' => array(),
		'series' => array(array('name' => 'Approved Members', 'data' => array())),
		'total_year' => 0,
	);
	$paidSubscriptionsMonthly = $paidSubscriptionsMonthly ?? array(
		'categories' => array(),
		'series' => array(array('name' => 'Paid Subscriptions', 'data' => array())),
		'total_year' => 0,
	);

	$getTypeLabel = function ($typeId) use ($incidentTypeIndex) {
		if ($typeId === null || $typeId === '') {
			return 'Unclassified';
		}

		$key = (string) $typeId;
		return isset($incidentTypeIndex[$key]) ? $incidentTypeIndex[$key] : 'Type ' . $key;
	};

	$getStatusLabel = function ($statusKey) use ($incidentStatusIndex) {
		if ($statusKey === null || $statusKey === '') {
			return 'Unknown';
		}

		$key = (string) $statusKey;
		if (isset($incidentStatusIndex[$key])) {
			$meta = $incidentStatusIndex[$key];
			if (is_array($meta)) {
				return $meta['label'] ?? ('Status ' . $key);
			}
			if (is_string($meta) && $meta !== '') {
				return $meta;
			}
		}

		return $key === 'unknown' ? 'Unknown' : 'Status ' . $key;
	};

	$chartDataJson = json_encode($chartData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
	$approvedMembersMonthlyJson = json_encode($approvedMembersMonthly, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
	$paidSubscriptionsMonthlyJson = json_encode($paidSubscriptionsMonthly, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
?>
<div class="page-wrapper">
	<!-- BEGIN PAGE HEADER -->
	<div class="page-header d-print-none" aria-label="Page header">
		<div class="container-fluid">
			<div class="row g-2 align-items-center">
				<div class="col">
					<!-- Page pre-title -->
					<div class="page-pretitle">Overview</div>
					<h2 class="page-title">Dashboard</h2>
				</div>

				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE HEADER -->
	<!-- BEGIN PAGE BODY -->
	<div class="page-body">
		<div class="container-fluid">
			<div id="overview-card" class="row row-cards py-3"></div>
			<div class="row row-deck row-cards">
			<?php if (in_array($user_type_id, array(GlobalModel::MEMBER_TYPE))): ?>
				<div class="col-12">
					<div class="card">
						<div class="card-table">
							<div class="card-header">
								<div class="row w-full">
									<div class="col">
										<?php if (in_array($user_type_id, array(GlobalModel::ADMIN_TYPE))): ?>
											<h3 class="card-title mb-0">Newly Added Customers</h3>
											<p class="text-secondary m-0">Listing all Newly Added Customers.</p>
										<?php else: ?>
											<h3 class="card-title mb-0">My Subscriptions</h3>
											<p class="text-secondary m-0">Listing all My Subscriptions.</p>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="card-body border-bottom py-3">
								<table id="subscription-datatable" class="table card-table table-vcenter text-wrap datatable" style="width: 100%;">
									<thead>
										<tr>
											<th class="w-1">#</th>											
											<th>Full Legal Name</th>
											<th>Membership Fee Type</th>
											<th>Due Date</th>
											<th>Payment Date</th>
											<th>Currency</th>
											<th>Amount</th>
											<th>Status</th>
											<th>Created At</th>
											<?php if ($viewUserRight || $approveUserRight): ?>
												<th>Actions</th>
											<?php endif; ?>
										</tr>
									</thead>
									<tbody class="table-tbody">
										<?php $s = 0; if (isset($subscriptionData)): foreach($subscriptionData as $data): ?>
											<tr>
												<td class="w-1"><?=++$s?>.</td>
												<td><?= get_table($customerDBSettingRow->database_name.'.user', 'user_id', $data->user_id, 'full_legal_name')?></td>
												<td><?= get_table($customerDBSettingRow->database_name.'.membership_fee_type', 'membership_fee_type_id', $data->membership_fee_type_id, 'name')?></td>	
												<td><?=in_array($data->end_at, array('', '0000-00-00')) ? '-' : date('d M Y', strtotime($data->end_at))?></td>
												<td><?=in_array($data->payment_at, array('', '0000-00-00')) ? '-' : date('d M Y', strtotime($data->payment_at))?></td>
												<td><?= get_table('m_currency', 'currency_id', $data->currency_id, 'sign')?></td>
												<td><?= $data->amount ?></td>
												<td><?= get_table('m_payment_status', 'payment_status_id', $data->payment_status_id, 'name')?></td>
												<td><?= date('d M Y', strtotime($data->created_at)) ?></td>
												<?php if ($viewUserRight || $approveUserRight): ?>
													<td>
														<?php if ($data->payment_status_id != '1732371146921'): ?>
															<button class="btn btn-danger btn-pill" onclick="paymentInfoModal('<?=$data->user_id?>', '<?=$data->payment_history_id?>')">
																<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg> Pay
															</button>
														<?php else: ?>
															<span class="dropdown">
																<button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
																<div class="dropdown-menu dropdown-menu-end">
																	<a class="dropdown-item" onclick="viewSubscriptionModal('<?=$data->subscription_id?>', '<?=$data->payment_history_id?>')">View Subscription</a>
																	<?php if ($data->active == 0): ?>
																		<a href="#" class="dropdown-item" onclick="approveSubscriptionModal('<?=$data->subscription_id?>', '<?=$data->payment_history_id?>')">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg> Approve/View
																		</a>
																	<?php endif; if ($data->payment_status_id == '1732371146921'): ?>
																		<a class="dropdown-item" onclick="paymentReceiptModal('<?=$data->user_id?>', '<?=$data->payment_history_id?>')">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 4v16m8 -8H4" /></svg> Payment Receipt
																		</a>
																	<?php endif; ?>
																</div>
															</span>
														<?php endif; ?>
													</td>
												<?php endif; ?>
											</tr>
										<?php endforeach; endif; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

				<div class="col-12">
					<div class="row row-cards">
						<?php if (in_array($user_type_id, array(GlobalModel::ADMIN_TYPE, GlobalModel::CLUB_ADMIN_TYPE))): ?>
							<div class="col-sm-6 col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="d-flex align-items-center">
											<div class="subheader">Total Members</div>
										</div>
										<div class="d-flex align-items-baseline">
											<div class="h1 mb-3 me-2"><?=$totalMembers ?? 0?></div>
											<div class="ms-auto text-secondary small">
												Approved this year: <strong><?=$approvedMembersThisYear ?? 0?></strong>
											</div>
										</div>
										<p class="text-secondary mb-2">Monthly approvals for <?=date('Y')?>.</p>
										<div id="chart-new-clients" class="chart-sm"></div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="subheader">Active Users</div>
										<div class="d-flex align-items-baseline mb-2">
											<div class="h1 mb-0 me-2"><?=$totalApprovedMembers ?? 0?></div>
											<div class="ms-auto text-secondary small">Approved members overall</div>
										</div>
										<p class="text-secondary mb-2">Approvals trend this year.</p>
										<div id="chart-active-users-3" class="position-relative chart-sm"></div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="subheader">Active Subscriptions</div>
										<div class="d-flex align-items-baseline mb-2">
											<div class="h1 mb-0 me-2"><?=$paidSubscriptionsThisYear ?? 0?></div>
											<div class="ms-auto text-secondary small">Paid this year</div>
										</div>
										<p class="text-secondary mb-2">Total approved members: <strong><?=$totalApprovedMembers ?? 0?></strong></p>
										<div id="chart-active-users" class="position-relative chart-sm"></div>
									</div>
								</div>
							</div>
						<?php endif; if (in_array($user_type_id, array(GlobalModel::CLUB_ADMIN_TYPE, GlobalModel::MEMBER_TYPE))): ?>
							<div class="col-sm-6 col-lg-3">
								<div class="card card-sm">
									<div class="card-body">
										<div class="d-flex align-items-center">
											<div class="subheader">Total Security Incidents</div>
										</div>
										<div class="h1 mb-0"><?=$summary['total']?></div>
										<div class="text-secondary">Recorded across <?=$summary['location_count']?> locations</div>
									</div>
								</div>
							</div>
							<?php foreach ($statusCards as $statusCard): ?>
								<?php
									$statusLabel = isset($statusCard['label']) ? $statusCard['label'] : 'Status';
									$statusCount = isset($statusCard['count']) ? (int) $statusCard['count'] : 0;
									$statusTextClass = !empty($statusCard['text_class']) ? $statusCard['text_class'] : 'text-primary';
									$statusDescription = isset($statusCard['description']) && $statusCard['description'] !== ''
										? $statusCard['description']
										: 'Incidents labeled ' . $statusLabel;
								?>
								<div class="col-sm-6 col-lg-3">
									<div class="card card-sm">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="subheader"><?=htmlspecialchars($statusLabel, ENT_QUOTES, 'UTF-8')?></div>
											</div>
											<div class="h1 mb-0 <?=htmlspecialchars($statusTextClass, ENT_QUOTES, 'UTF-8')?>"><?=(int) $statusCount?></div>
											<div class="text-secondary"><?=htmlspecialchars($statusDescription, ENT_QUOTES, 'UTF-8')?></div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
							<div class="col-sm-6 col-lg-3">
								<div class="card card-sm">
									<div class="card-body">
										<div class="d-flex align-items-center">
											<div class="subheader">Most Recent</div>
										</div>
										<div class="h1 mb-0" style="font-size: 14px;"><?=$summary['recent'] ? $summary['recent'] : 'N/A'?></div>
										<div class="text-secondary">Unique reporters: <?=$summary['reporter_count']?></div>
									</div>
								</div>
							</div>
							<div class="col-sm-4 col-lg-4">
								<div class="card h-100">
									<div class="card-header">
										<h3 class="card-title mb-0">Security Incidents by Type</h3>
									</div>
									<div class="card-body">
										<div id="security-incident-type-chart" style="min-height: 320px;"></div>
									</div>
								</div>
							</div>
							<div class="col-sm-4 col-lg-4">
								<div class="card h-100">
									<div class="card-header">
										<h3 class="card-title mb-0">Security Incident Trend</h3>
									</div>
									<div class="card-body">
										<div id="security-incident-timeline-chart" style="min-height: 320px;"></div>
									</div>
								</div>
							</div>
							<div class="col-sm-4 col-lg-4">
								<div class="card h-100">
									<div class="card-header">
										<h3 class="card-title mb-0">Security Incidents by Status</h3>
									</div>
									<div class="card-body">
										<div id="security-incident-status-chart" style="min-height: 320px;"></div>
									</div>
								</div>
							</div>	
						<?php else: ?>
							<?php if (!empty(get_user_right($user_type_id, '17872306643', 'view', 1))): ?>
								<div class="col-sm-6 col-lg-3">
									<div class="card card-sm">
										<div class="card-body">
											<div class="row align-items-center">
												<div class="col-auto">
												<span class="bg-x text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
														<path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9z"></path>
														<path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
													</svg>
												</span>
												</div>
												<div class="col">
													<div class="font-weight-medium"><?=count($bookingData ?? [])?> My Bookings</div>
													<div class="text-secondary">Total Bookings</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endif; if (!empty(get_user_right($user_type_id, '17002375931', 'view', 1))): ?>
								<div class="col-sm-6 col-lg-3">
									<div class="card card-sm">
										<div class="card-body">
											<div class="row align-items-center">
												<div class="col-auto">
													<span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/shopping-cart -->
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
														<path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
														<path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
														<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
														<path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
														</svg>
													</span>
												</div>
												<div class="col">
													<div class="font-weight-medium"><?=count($productData ?? [])?> Shops</div>
													<div class="text-secondary">Total Registered Customers</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endif; if (!empty(get_user_right($user_type_id, '17092385318', 'view', 1))): ?>
								<div class="col-sm-6 col-lg-3">
									<div class="card card-sm">
										<div class="card-body">
											<div class="row align-items-center">
												<div class="col-auto">
													<span class="bg-facebook text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/brand-facebook -->
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
														<path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
														<path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
														<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
														<path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
														</svg>
													</span>
												</div>
												<div class="col">
													<div class="font-weight-medium"><?=count($joiningFeeData ?? [])?> Joining Fees</div>
													<div class="text-secondary">Total Joining Fees</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>

				<!-- <div class="col-12">
					<div class="card">
						<div class="card-header">
							<div class="row w-full">
                             <p>Test</p>
							</div>
						</div>
					</div>
				</div> -->

				

			<?php if (!empty($activeProjects)): ?>
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<div class="row w-full">
								<div class="col">
									<h3 class="card-title mb-0">Active Projects</h3>
									<p class="text-secondary m-0">Showing latest active projects</p>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<?php foreach ($activeProjects as $project): ?>
									<?php $thumbnail = trim($project->thumbnail_url ?? ''); $thumbnailSrc = $thumbnail ? (filter_var($thumbnail, FILTER_VALIDATE_URL) ? $thumbnail : base_url($thumbnail)) : ''; ?>
									<div class="col-12 col-md-4">
										<div class="card">
											<div class="card-body d-flex">
												<div class="me-3">
													<?php if ($thumbnailSrc): ?>
														<span class="avatar avatar-lg" style="background-image: url('<?=$thumbnailSrc?>')"></span>
													<?php else: ?>
														<span class="avatar avatar-lg bg-muted text-white"><?=strtoupper(substr(trim($project->name ?? 'P'), 0, 1))?></span>
													<?php endif; ?>
												</div>
												<div class="flex-fill">
													<h4 class="mb-1"><?=$project->name ?? 'Untitled'?></h4>
													<div class="text-muted small only-so-big"><?=$project->description ?? ''?></div>
													<div class="mt-2">
														<span class="badge <?= (isset($project->active) && (int)$project->active === 1) ? 'bg-green-lt' : 'bg-red-lt' ?>"><?= (isset($project->active) && (int)$project->active === 1) ? 'Active' : 'Inactive' ?></span>
														<small class="text-muted ms-2">Created <?= !empty($project->created_at) ? date('d M Y', strtotime($project->created_at)) : 'N/A' ?></small>
														<a href="javascript:void(0);" class="btn float-end" onclick="viewProjectModal('<?= $project->project_id ?>')">View</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if (!empty($activePetitions)): ?>
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<div class="row w-full">
								<div class="col">
									<h3 class="card-title mb-0">Recent Petitions</h3>
									<p class="text-secondary m-0">Latest active petitions</p>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<?php foreach ($activePetitions as $petition): ?>
									<div class="col-12 col-md-4">
										<div class="card">
											<div class="card-body d-flex">
												<div class="me-3">
													<span class="avatar avatar-lg bg-muted text-white"><?=strtoupper(substr(trim($petition->name ?? 'Pet'), 0, 1))?></span>
												</div>
												<div class="flex-fill">
													<h4 class="mb-1"><?=$petition->name ?? 'Untitled'?></h4>
													<div class="text-muted small only-so-big"><?=$petition->description ?? ''?></div>
													<div class="mt-2">
														<span class="badge <?= (isset($petition->active) && (int)$petition->active === 1) ? 'bg-green-lt' : 'bg-red-lt' ?>"><?= (isset($petition->active) && (int)$petition->active === 1) ? 'Active' : 'Inactive' ?></span>
														<small class="text-muted ms-2">Created <?= !empty($petition->created_at) ? date('d M Y', strtotime($petition->created_at)) : 'N/A' ?></small>
														<span class="dropdown">
															<button class="btn dropdown-toggle float-end" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
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
															</div>
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if (!empty($noticeBoardItems)): ?>
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<div class="row w-full">
								<div class="col">
									<h3 class="card-title mb-0">Notice Board</h3>
									<p class="text-secondary m-0">Latest notices</p>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<?php foreach ($noticeBoardItems as $notice): ?>
									<div class="col-12 col-md-4">
										<div class="card">
											<div class="card-body d-flex">
												<div class="me-3">
													<?php $thumb = trim($notice->thumbnail_url ?? ''); $thumbSrc = $thumb ? (filter_var($thumb, FILTER_VALIDATE_URL) ? $thumb : base_url($thumb)) : ''; ?>
													<?php if ($thumbSrc): ?>
														<span class="avatar avatar-lg" style="background-image: url('<?=$thumbSrc?>')"></span>
													<?php else: ?>
														<span class="avatar avatar-lg bg-muted text-white"><?=strtoupper(substr(trim($notice->name ?? 'N'), 0, 1))?></span>
													<?php endif; ?>
												</div>
												<div class="flex-fill">
													<h4 class="mb-1"><?=$notice->name ?? 'Untitled'?></h4>
													<div class="text-muted small only-so-big"><?=$notice->description ?? ''?></div>
													<div class="mt-2">
														<small class="text-muted">Posted <?= !empty($notice->created_at) ? date('d M Y', strtotime($notice->created_at)) : 'N/A' ?></small>
														<a href="javascript:void(0);" class="btn float-end" onclick="viewNoticeBoardModal('<?= $notice->notice_board_id ?? $notice->id ?? '' ?>')">View</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

				
			
			<div class="col-12" hidden>
				<div class="card">
					<div class="card-table">
						<div class="card-header">
							<div class="row w-full">
								<div class="col">
									<?php if (in_array($user_type_id, array(GlobalModel::ADMIN_TYPE))): ?>
										<h3 class="card-title mb-0">Newly Added Customers</h3>
										<p class="text-secondary m-0">Listing all Newly Added Customers.</p>
									<?php else: ?>
										<h3 class="card-title mb-0">Club</h3>
										<p class="text-secondary m-0">Listing</p>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="card-body border-bottom py-3">
							<table id="added-customer-datatable" class="table card-table table-vcenter text-wrap datatable" style="width: 100%;">
								<thead>
									<tr>
										<th class="w-1">#</th>
										<th>Logo</th>
										<th>Customer Name</th>
										<th>Reg. No.</th>
										<th>Email Address</th>
										<th>Tel No.</th>
										<th>Country</th>
										<th>Agreement</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody class="table-tbody">
									<?php $c = 0; if (isset($customerData)): foreach ($customerData as $customer): ?>
										<tr>
											<td><?=++$c?>.</td>
											<td><span class="avatar avatar-xs me-2" style="background-image: url('<?=base_url($customer->logo)?>')"></span></td>
											<td><?=$customer->full_legal_name?></td>
											<td><?=$customer->reg_no?></td>
											<td><?=$customer->email?></td>
											<td><?=$customer->phone_number?></td>
											<td><?=get_table('m_country', 'country_id', $customer->country_id, 'name')?></td>
											<td><a href="<?=base_url($customer->agreement)?>" target="_blank">Download</a></td>
											<td><?=get_table('m_customer_status', 'customer_status_id', $customer->customer_status_id, 'name')?></td>
										</tr>
									<?php endforeach; endif; ?> 
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<?php $c = 0; if (isset($membershipTypeData)): foreach ($membershipTypeData as $membership): if (in_array($user_type_id, array(GlobalModel::ADMIN_TYPE))): ?>
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<div class="row w-full">
								<div class="col">
									<?php if (in_array($user_type_id, array(GlobalModel::ADMIN_TYPE))): ?>
										<h3 class="card-title mb-0">Newly Added Customers</h3>
										<p class="text-secondary m-0">Listing all Newly Added Customers.</p>
									<?php else: ?>
										<h3 class="card-title mb-0">Pending Member - <?=$membership->name?></h3>
										<p class="text-secondary m-0">Listing</p>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="card-body border-bottom py-3">
							<div class="table-responsive">
								<table id="user-<?=$membership->membership_type_id?>-datatable" class="table table-vcenter text-wrap" >
									<thead>
										<tr>
											<th class="w-1">#</th>											
											<th>Full Legal Name</th>
											<th>Phone Number</th>
											<th>Email</th>
											<th>Membership Fee Type</th>
											<th>Membership No.</th>
											<th>Residental Address</th>	
											<th>LR/No.</th>
											<th>Origin</th>
											<th>Status</th>
											<th>Created At</th>
											<?php if ($viewUserRight || $approveUserRight || $editUserRight || $removeUserRight): ?>
												<th>Actions</th>	
											<?php endif; ?>
										</tr>
									</thead>
									<tbody class="table-tbody">
										<?php $u = 0; if (isset($userArrayData[$membership->membership_type_id])): foreach ($userArrayData[$membership->membership_type_id] as $user): $paymentHistoryRow = get_table($customerDBSettingRow->database_name.'.payment_history', 'user_id', $user->user_id); ?>
											<tr>
												<td><?=++$u?>.</td>
												<td><?=$user->full_legal_name?></td>
												<td><?=$user->phone_number?></td>
												<td><?=$user->email?></td>
												<td><?=get_table($customerDBSettingRow->database_name.'.membership_fee_type', 'membership_fee_type_id', $user->membership_fee_type_id, 'name')?></td>
												<td><?=$user->membership_no?></td>
												<td><?=$user->residential_address?></td>
												<td><?=$user->sub_reference_no?></td>
												<td><?=get_table('m_user_origin', 'user_origin_id', $user->user_origin_id, 'name')?></td>
												<td><?=get_table('m_active', 'num', $user->active, 'name_two')?></td>
												<td><?=date_format(date_create($user->created_at),"d M Y")?></td>
												<?php if ($viewUserRight || $approveUserRight || $editUserRight || $removeUserRight): ?>
													<?php if ($data->payment_status_id != '1732371146921'): ?>
														<button class="btn btn-pill" onclick="paymentInfoModal('<?=$data->user_id?>', '<?=$data->payment_history_id?>')">
															<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 4v16m8 -8H4" /></svg> Payment Info
														</button>
													<?php else: ?>
														<td class="text-end">
															<span class="dropdown">
																<button class="btn dropdown-toggle align-text-top btn-pill" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="true">Actions</button>
																<div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 38px);">
																	<?php if ($approveUserRight && $user->active == 0): ?>
																		<a class="dropdown-item" onclick="subscriptionApprovalModal('<?=$user->user_id?>', '<?=$membership->membership_type_id?>', '<?=$customer_db_setting_id?>', 'dashboard')">Approve</a>
																	<?php endif; if ($editUserRight): ?>
																		<a class="dropdown-item" onclick="editUserModal('<?=$user->user_id?>')">Update</a>
																	<?php endif; if ($removeUserRight): ?>
																		<a class="dropdown-item" onclick="removeUserModal('<?=$user->user_id?>')">Delete</a>
																	<?php endif; ?>
																</div>
															</span>
														</td>
													<?php endif; ?>
												<?php endif; ?>
											</tr>
										<?php endforeach; endif; ?> 
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
			<?php endif; endforeach; endif; if (!empty(get_user_right($user_type_id, '17743087640', 'view', 1))): ?>
				<div class="col-12">
					<div class="card">
						<div class="card-table">
							<div class="card-header">
								<div class="row w-full">
									<div class="col">
										<h3 class="card-title mb-0">Newly Added AGM Minutes</h3>
										<p class="text-secondary m-0">Listing Newly Added AGM Minutes.</p>
									</div>
								</div>
							</div>

							<div class="card-body border-bottom py-3">
								<table id="agm-minutes-datatable" class="table card-table table-vcenter text-wrap datatable" style="width: 100%; min-height: 100px;">
									<thead>
										<tr>
											<th class="w-1">#</th>
											<th>Title</th>
											<th>Description</th>
											<th>Document</th>
											<th>Status</th>
											<th>Created At</th>
											<?php if ($editUserRight || $removeUserRight): ?>
												<th>Actions</th>
											<?php endif; ?>
										</tr>
									</thead>
									<tbody class="table-tbody">
										<?php $agmm = 0; if (isset($agmMinutesData)): foreach($agmMinutesData as $minute): ?>
											<tr>
												<td class="w-1"><?=++$agmm?>.</td>
												<td><?=$minute->name?></td>
												<td><div class="only-so-big"><?=$minute->description?></div></td>
												<td>
													<?php if (!empty($minute->doc_url) && check_file_exists(base_url($minute->doc_url))): ?>
														<a href="<?=base_url($minute->doc_url)?>" target="_blank">View Document</a>
													<?php else: ?>
														No Document Found
													<?php endif; ?>
												</td>
												<td><?=($minute->active) ? 'Active' : 'Inactive'?></td>
												<td><?=date('d M Y', strtotime($minute->created_at))?></td>
												<?php if ($editUserRight || $removeUserRight): ?>
													<td>
														<span class="dropdown">
															<button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
															<div class="dropdown-menu dropdown-menu-end">
																<a href="#" class="dropdown-item" onclick="viewAgmMinutesModal('<?=$minute->agm_minutes_id?>')">
																	<!-- Download SVG icon from http://tabler.io/icons/icon/view -->
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7z" /></svg> View
																</a>
																<?php if ($editUserRight): ?>
																	<a href="javascript:void(0);" class="dropdown-item" onclick="editAgmMinutesModal('<?=$minute->agm_minutes_id?>')">
																		<!-- Download SVG icon from http://tabler.io/icons/icon/edit -->
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v3m0 4v3a2 2 0 0 0 2 2h3m4 -12l6.5 6.5a2.121 2.121 0 0 1 0 3l-6.5 6.5a2.121 2.121 0 0 1 -3 0l-6.5 -6.5a2.121 2.121 0 0 1 0 -3l6.5 -6.5a2.121 2.121 0 0 1 3 0z" /></svg> Edit
																	</a>
																<?php endif; ?>
															</div>
														</span>
													</td>
												<?php endif; ?>
											</tr>
										<?php endforeach; endif; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			<?php endif; if (!empty(get_user_right($user_type_id, '17848086429', 'view', 1))): ?>
				<div class="col-12">
					<div class="card">
						<div class="card-table">
							<div class="card-header">
								<div class="row w-full">
									<div class="col">
										<h3 class="card-title mb-0">Newly Added Newsletter</h3>
										<p class="text-secondary m-0">Listing all Newly Added Newsletter.</p>
									</div>
								</div>
							</div>

							<div class="card-body border-bottom py-3">
								<table id="newsletter-datatable" class="table card-table table-vcenter text-wrap datatable" style="width: 100%; min-height: 100px;">
									<thead>
										<tr>
											<th class="w-1">#</th>
											<th>Thumbnail</th>
											<th>Title</th>
											<th>Description</th>
											<th>Document</th>
											<th>Status</th>
											<th>Created At</th>
										</tr>
									</thead>
									<tbody class="table-tbody">
										<?php $nl = 0; if (isset($newsletterData)): foreach($newsletterData as $newsletter): ?>
											<tr>
												<td class="w-1"><?=++$nl?>.</td>
												<td>
													<?php
														$thumbnailPath = !empty($newsletter->thumbnail_url) ? FCPATH . ltrim($newsletter->thumbnail_url, '/') : '';
														$hasThumbnail = !empty($thumbnailPath) && file_exists($thumbnailPath);
														$thumbnailSrc = $hasThumbnail ? base_url($newsletter->thumbnail_url) : base_url('assets/admin/images/no-image.png');
													?>
													<span class="avatar avatar-xs me-2" style="background-image: url('<?=$thumbnailSrc?>')"></span>
												</td>
												<td><?=$newsletter->name?></td>
												<td><div class="only-so-big text-muted"><?=$newsletter->description?></div></td>
												<td>
													<?php if (!empty($newsletter->file_url) && check_file_exists(base_url($newsletter->file_url))): ?>
														<a href="<?=base_url($newsletter->file_url)?>" target="_blank">View Document</a>
													<?php else: ?>
														No Document Found
													<?php endif; ?>
												</td>
												<td><span class="badge <?=($newsletter->active === 1) ? 'bg-green-lt' : (($newsletter->active === 0) ? 'bg-red-lt' : 'bg-yellow-lt')?>"><?=get_table('m_active', 'num', $newsletter->active, 'name')?></span></td>
												<td><?=!empty($newsletter->created_at) ? date('d M Y', strtotime($newsletter->created_at)) : 'N/A'?></td>
											</tr>
										<?php endforeach; endif; ?>
									</tbody>
								</table>
							</div>

							<div class="card-body border-bottom py-3" hidden>
								<div class="row">
									<?php $nl = 0; if (!empty($newsletterData)): ?>
										<?php foreach ($newsletterData as $newsletter): ?>		
											<div class="col-sm-6 col-lg-4">
												<?php
													$thumbnailPath = !empty($newsletter->thumbnail_url) ? FCPATH . ltrim($newsletter->thumbnail_url, '/') : '';
													$hasThumbnail = !empty($thumbnailPath) && file_exists($thumbnailPath);
													$thumbnailSrc = $hasThumbnail ? base_url($newsletter->thumbnail_url) : base_url('assets/admin/images/no-image.png');
													$statusClass = ($newsletter->active === 1) ? 'bg-green-lt' : (($newsletter->active === 0) ? 'bg-red-lt' : 'bg-yellow-lt');
												?>
												<div class="row align-items-center g-4">
													<div class="col-auto">
														<span class="avatar" style="background-image: url('<?=$thumbnailSrc?>')"></span>
													</div>
													<div class="col">
														<div class="d-flex justify-content-between align-items-start">
															<div class="pe-3">
																<div class="text-secondary small">#<?=++$nl?></div>
																<div class="text-reset text-wrap fw-medium mb-1"><?=$newsletter->name?></div>
																<div class="text-secondary text-wrap only-so-big"><?=$newsletter->description?></div>
															</div>
															<div class="text-end" hidden>
																<span class="badge <?=$statusClass?>"><?=get_table('m_active', 'num', $newsletter->active, 'name')?></span>
																<div class="text-secondary small mt-1">
																	<?=!empty($newsletter->created_at) ? date('d M Y', strtotime($newsletter->created_at)) : 'N/A'?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										<?php endforeach; ?>
									<?php else: ?>
										<div class="text-center text-muted">
											No Newsletters Found.
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			overviewCard();
			loadDataTable('subscription-datatable');
			loadDataTable('customer-datatable');
			loadDataTable('agm-minutes-datatable');
			loadDataTable('newsletter-datatable');
			<?php if (isset($membershipTypeData)): foreach ($membershipTypeData as $membership): ?>
				loadDataTable('user-<?=$membership->membership_type_id?>-datatable');
			<?php endforeach; endif; ?>
		});

		function overviewCard() {
			$.ajax({
				url: base_url + "overview-card",
				success: function(response) {
					document.getElementById('overview-card').innerHTML = response;
				}
			});
		}

		const securityIncidentChartData = <?=$chartDataJson?>;
		const approvedMembersMonthly = <?=$approvedMembersMonthlyJson?>;
		const paidSubscriptionsMonthly = <?=$paidSubscriptionsMonthlyJson?>;

		document.addEventListener('DOMContentLoaded', function () {
			if (typeof window.ApexCharts === 'undefined') {
				return;
			}

			const buildKpiAreaChart = function (elementId, dataset, color) {
				if (!dataset || !Array.isArray(dataset.series) || dataset.series.length === 0) {
					return;
				}

				const element = document.getElementById(elementId);
				if (!element) {
					return;
				}

				const series = dataset.series.map(function (serie) {
					const points = Array.isArray(serie.data) ? serie.data.slice() : [];
					return {
						name: serie.name,
						data: points
					};
				});

				const categories = Array.isArray(dataset.categories) ? dataset.categories.slice() : [];

				const options = {
					chart: {
						type: 'area',
						height: 160,
						toolbar: { show: false }
					},
					series: series,
					dataLabels: { enabled: false },
					stroke: { curve: 'smooth', width: 2 },
					xaxis: { categories: categories },
					colors: [color],
					fill: {
						type: 'gradient',
						gradient: { shadeIntensity: 0.3, opacityFrom: 0.7, opacityTo: 0.2 }
					},
					grid: { strokeDashArray: 4 },
					legend: { show: false }
				};

				new ApexCharts(element, options).render();
			};

			buildKpiAreaChart('chart-new-clients', approvedMembersMonthly, '#206bc4');
			buildKpiAreaChart('chart-active-users-3', approvedMembersMonthly, '#12b886');
			buildKpiAreaChart('chart-active-users', paidSubscriptionsMonthly, '#f76707');

			const palette = ['#206bc4', '#f76707', '#4263eb', '#12b886', '#d6336c', '#7048e8', '#f59f00', '#0ca678'];

			const typeChartElement = document.getElementById('security-incident-type-chart');
			if (typeChartElement) {
				const typeChart = new ApexCharts(typeChartElement, {
					chart: {
						type: 'donut',
						height: 320,
						toolbar: { show: false }
					},
					dataLabels: { enabled: false },
					series: securityIncidentChartData.type.series,
					labels: securityIncidentChartData.type.labels,
					legend: { position: 'bottom' },
					colors: palette
				});
				typeChart.render();
			}

			const timelineChartElement = document.getElementById('security-incident-timeline-chart');
			if (timelineChartElement) {
				const timelineChart = new ApexCharts(timelineChartElement, {
					chart: {
						type: 'area',
						height: 320,
						toolbar: { show: false }
					},
					dataLabels: { enabled: false },
					stroke: { curve: 'smooth', width: 2 },
					series: securityIncidentChartData.timeline.series,
					xaxis: { categories: securityIncidentChartData.timeline.categories },
					colors: ['#206bc4'],
					fill: {
						type: 'gradient',
						gradient: { shadeIntensity: 0.3, opacityFrom: 0.7, opacityTo: 0.2 }
					}
				});
				timelineChart.render();
			}

			const statusChartElement = document.getElementById('security-incident-status-chart');
			if (statusChartElement) {
				const statusChart = new ApexCharts(statusChartElement, {
					chart: {
						type: 'bar',
						height: 320,
						toolbar: { show: false }
					},
					plotOptions: {
						bar: {
							horizontal: true,
							borderRadius: 4
						}
					},
					dataLabels: { enabled: false },
					series: [
						{
							name: 'Incidents',
							data: securityIncidentChartData.status.series
						}
					],
					xaxis: {
						categories: securityIncidentChartData.status.labels
					},
					colors: ['#12b886']
				});
				statusChart.render();
			}
		});

	</script>
