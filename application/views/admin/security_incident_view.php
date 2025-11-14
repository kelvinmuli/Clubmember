<?php
	$pageTitle = isset($moduleMenu) && !empty($moduleMenu->name) ? $moduleMenu->name : 'Security Incidents';
	$modulePath = isset($moduleMenu) && !empty($moduleMenu->path) ? $moduleMenu->path : 'security-incident';
	$incidentData = $incidentData ?? [];
	$incidentTypeIndex = $incidentTypeIndex ?? [];
	$activeIndex = $activeIndex ?? [];
	$summaryDefaults = array(
		'total' => 0,
		'active' => 0,
		'inactive' => 0,
		'recent' => null,
		'location_count' => 0,
		'reporter_count' => 0,
	);
	$summary = array_merge($summaryDefaults, $summary ?? []);
	$chartData = $chartData ?? array(
		'type' => array('labels' => array(), 'series' => array()),
		'timeline' => array('categories' => array(), 'series' => array(array('name' => 'Incidents', 'data' => array()))),
		'status' => array('labels' => array(), 'series' => array()),
	);

	$getTypeLabel = function ($typeId) use ($incidentTypeIndex) {
		if ($typeId === null || $typeId === '') {
			return 'Unclassified';
		}

		$key = (string) $typeId;
		return isset($incidentTypeIndex[$key]) ? $incidentTypeIndex[$key] : 'Type ' . $key;
	};

	$getStatusLabel = function ($statusKey) use ($activeIndex) {
		if ($statusKey === null || $statusKey === '') {
			return 'Unknown';
		}

		$key = (string) $statusKey;
		return isset($activeIndex[$key]) ? $activeIndex[$key] : ($key === 'unknown' ? 'Unknown' : 'Status ' . $key);
	};

	$chartDataJson = json_encode($chartData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
?>

<div class="page-wrapper">
	<div class="container-fluid">
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col">
					<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						<li class="breadcrumb-item"><a href="<?=base_url()?>">Website</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url('home')?>">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page"><?=$pageTitle?></li>
					</ol>
				</div>
				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">
						<?php if (!empty($inputUserRight)): ?>
							<a class="btn btn-primary btn-pill" href="javascript:void(0);" onclick="addSecurityIncidentModal();">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add Incident
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="page-body">
		<div class="container-fluid">
			<div class="row row-deck row-cards mb-3">
				<div class="col-sm-6 col-lg-3">
					<div class="card card-sm">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div class="subheader">Total Incidents</div>
							</div>
							<div class="h1 mb-0"><?=$summary['total']?></div>
							<div class="text-secondary">Recorded across <?=$summary['location_count']?> locations</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-lg-3">
					<div class="card card-sm">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div class="subheader">Active</div>
							</div>
							<div class="h1 mb-0 text-green"><?=$summary['active']?></div>
							<div class="text-secondary">Open investigations</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-lg-3">
					<div class="card card-sm">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div class="subheader">Inactive</div>
							</div>
							<div class="h1 mb-0 text-orange"><?=$summary['inactive']?></div>
							<div class="text-secondary">Closed or resolved incidents</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-lg-3">
					<div class="card card-sm">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div class="subheader">Most Recent</div>
							</div>
							<div class="h1 mb-0"><?=$summary['recent'] ? $summary['recent'] : 'N/A'?></div>
							<div class="text-secondary">Unique reporters: <?=$summary['reporter_count']?></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-deck row-cards mb-4">
				<div class="col-xl-4 col-lg-6">
					<div class="card h-100">
						<div class="card-header">
							<h3 class="card-title mb-0">Incidents by Type</h3>
						</div>
						<div class="card-body">
							<div id="security-incident-type-chart" style="min-height: 320px;"></div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-6">
					<div class="card h-100">
						<div class="card-header">
							<h3 class="card-title mb-0">Incident Trend</h3>
						</div>
						<div class="card-body">
							<div id="security-incident-timeline-chart" style="min-height: 320px;"></div>
						</div>
					</div>
				</div>
				<div class="col-xl-4">
					<div class="card h-100">
						<div class="card-header">
							<h3 class="card-title mb-0">Incidents by Status</h3>
						</div>
						<div class="card-body">
							<div id="security-incident-status-chart" style="min-height: 320px;"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-cards">
				<div class="col-12">
					<div class="card">
						<div class="card-body border-bottom py-3">
							<div class="table-responsive">
								<table id="security-incident-datatable" class="table card-table table-vcenter text-wrap" style="width: 100%;">
									<thead>
										<tr>
											<th class="w-1">#</th>
											<th>Incident At</th>
											<th>Location</th>
											<th>Type</th>
											<th>Reported By</th>
											<th>Status</th>
											<th>Created</th>
											<th>Description</th>
											<?php if ($viewUserRight || $editUserRight || $removeUserRight): ?>
												<th class="w-1">Actions</th>
											<?php endif; ?>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($incidentData)): ?>
											<?php $i = 0; foreach ($incidentData as $incident): ?>
												<?php
													$incidentId = $incident->security_incident_id ?? '';
													$location = !empty($incident->location) ? $incident->location : 'Unknown location';
													$reportedBy = !empty($incident->reported_by) ? $incident->reported_by : 'Unknown reporter';
													$incidentAt = !empty($incident->incident_at) ? date('d M Y H:i', strtotime($incident->incident_at)) : 'Not recorded';
													$createdAt = !empty($incident->created_at) ? date('d M Y H:i', strtotime($incident->created_at)) : 'Not recorded';
													$typeLabel = $getTypeLabel($incident->incident_type_id ?? '');
													$description = !empty($incident->description) ? $incident->description : 'No description provided.';
													$statusKey = isset($incident->active) ? (string) $incident->active : 'unknown';
													$statusLabel = $getStatusLabel($statusKey);
												?>
												<tr>
													<td class="text-muted"><?=++$i?>.</td>
													<td><?=$incidentAt?></td>
													<td><?=$location?></td>
													<td><?=$typeLabel?></td>
													<td><?=$reportedBy?></td>
													<td><?=$statusLabel?></td>
													<td><?=$createdAt?></td>
													<td><div class="only-so-big text-muted"><?=$description?></div></td>
													<?php if ($viewUserRight || $editUserRight || $removeUserRight): ?>
														<td class="text-end">
															<span class="dropdown">
																<button class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
																<div class="dropdown-menu dropdown-menu-end">
																	<a class="dropdown-item" href="javascript:void(0);" onclick="viewSecurityIncidentModal('<?=$incidentId?>');">
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7z" /></svg> View
																	</a>
																	<?php if ($editUserRight): ?>
																		<a class="dropdown-item" href="javascript:void(0);" onclick="editSecurityIncidentModal('<?=$incidentId?>');">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg> Edit
																		</a>
																	<?php endif; if ($removeUserRight): ?>
																		<a class="dropdown-item" href="javascript:void(0);" onclick="removeSecurityIncidentModal('<?=$incidentId?>');">
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
																		</a>
																	<?php endif; ?>
																</div>
															</span>
														</td>
													<?php endif; ?>
												</tr>
											<?php endforeach; ?>
										<?php else: ?>
											<tr>
												<td colspan="<?=($editUserRight || $removeUserRight) ? '10' : '9'?>" class="text-center">
													<span class="badge bg-red-lt">No security incidents recorded yet.</span>
													<?php if (!empty($inputUserRight)): ?>
														<p class="text-muted m-0 mt-2">Start by registering your first incident using the Add Incident button.</p>
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
		loadDatatable('security-incident-datatable', <?=json_encode($pageTitle)?>);
	});

	const securityIncidentChartData = <?=$chartDataJson?>;

	document.addEventListener('DOMContentLoaded', function () {
		if (typeof window.ApexCharts === 'undefined') {
			return;
		}

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

	function addSecurityIncidentModal() {
		showModal(base_url + 'add-security-incident-modal', function () {});
	}

	function viewSecurityIncidentModal(incidentId) {
		showModal(base_url + 'view-security-incident-modal/' + incidentId, function () {});
	}

	function editSecurityIncidentModal(incidentId) {
		showModal(base_url + 'edit-security-incident-modal/' + incidentId, function () {});
	}

	function removeSecurityIncidentModal(incidentId) {
		showModal(base_url + 'remove-security-incident-modal/' + incidentId, function () {});
	}
</script>