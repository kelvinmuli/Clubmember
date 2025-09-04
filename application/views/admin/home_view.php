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
			<div class="row row-deck row-cards">
				<div class="col-12">
				<div class="row row-cards">
					<?php if (in_array($user_type_id, array(GlobalModel::ADMIN_TYPE, GlobalModel::CLUB_ADMIN_TYPE))): ?>
						<div id="overview-card" class="row row-cards"></div>
					<?php else: ?>
						<div class="col-sm-6 col-lg-3">
							<div class="card card-sm">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col-auto">
											<span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/currency-dollar -->
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
													<path d="M20.925 13.163a8.998 8.998 0 0 0 -8.925 -10.163a9 9 0 0 0 0 18"></path>
													<path d="M9 10h.01"></path>
													<path d="M15 10h.01"></path>
													<path d="M9.5 15c.658 .64 1.56 1 2.5 1s1.842 -.36 2.5 -1"></path>
													<path d="M15 19l2 2l4 -4"></path>
												</svg>
											</span>
										</div>
										<div class="col">
											<div class="font-weight-medium">Welcome back <?=$full_legal_name?></div>
										</div>
									</div>
								</div>
							</div>
						</div>
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
						<?php endif; if (!empty(get_user_right($user_type_id, '17072386410', 'view', 1))): ?>
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
												<div class="font-weight-medium"><?=count($subscriptionData ?? [])?> Subscriptions</div>
												<div class="text-secondary">Total Subscriptions</div>
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

			<?php if (!in_array($user_type_id, array(GlobalModel::MEMBER_TYPE))): ?>
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
											<h3 class="card-title mb-0">Club</h3>
											<p class="text-secondary m-0">Listing</p>
										<?php endif; ?>
									</div>
								</div>
							</div>

							<div class="card-body border-bottom py-3">
								<table id="customer-datatable" class="table card-table table-vcenter text-nowrap datatable" style="width: 100%;">
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

				<?php $c = 0; if (isset($membershipTypeData)): foreach ($membershipTypeData as $membership): ?>
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<div class="row w-full">
									<div class="col">
										<?php if (in_array($user_type_id, array(GlobalModel::ADMIN_TYPE))): ?>
											<h3 class="card-title mb-0">Newly Added Customers</h3>
											<p class="text-secondary m-0">Listing all Newly Added Customers.</p>
										<?php else: ?>
											<h3 class="card-title mb-0">Club <?=$membership->name?></h3>
											<p class="text-secondary m-0">Listing</p>
										<?php endif; ?>
									</div>
								</div>
							</div>

							<div class="card-body border-bottom py-3">
								<div class="table-responsive">
									<table id="user-datatable" class="table table-vcenter text-nowrap">
										<thead>
											<tr>
												<th class="w-1">#</th>											
												<th>Full Legal Name</th>
												<th>Phone Number</th>
												<th>Email</th>
												<th>Membership No.</th>
												<th>Residental Address</th>
												<th>Created At</th>	
												<?php if ($approveUserRight || $editUserRight || $removeUserRight): ?>
													<th>Actions</th>	
												<?php endif; ?>
											</tr>
										</thead>
										<tbody class="table-tbody">
											<?php $u = 0; if (isset($userArrayData[$membership->membership_type_id])): foreach ($userArrayData[$membership->membership_type_id] as $user): ?>
												<tr>
													<td><?=++$u?>.</td>
													<td><?=$user->full_legal_name?></td>
													<td><?=$user->phone_number?></td>
													<td><?=$user->email?></td>
													<td><?=$user->membership_no?></td>
													<td><?=$user->residential_address?></td>
													<td><?=$user->created_at?></td>
													<?php if ($approveUserRight || $editUserRight || $removeUserRight): ?>
														<td class="text-end">
															<span class="dropdown">
																<button class="btn dropdown-toggle align-text-top btn-pill" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="true">Actions</button>
																<div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 38px);">
																	<?php if ($approveUserRight): ?>
																		<a class="dropdown-item" onclick="approveUserModal('<?=$user->user_id?>', '<?=$membership->membership_type_id?>', '<?=$customer_db_setting_id?>', 'home')">Approve</a>
																	<?php endif; if ($editUserRight): ?>
																		<a class="dropdown-item" onclick="editUserModal('<?=$user->user_id?>')">Update</a>
																	<?php endif; if ($removeUserRight): ?>
																		<a class="dropdown-item" onclick="removeUserModal('<?=$user->user_id?>')">Delete</a>
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
				<?php endforeach; endif; ?> 
			<?php endif; ?>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			overviewCard();
		});

		function overviewCard() {
			$.ajax({
				url: base_url + "overview-card",
				success: function(response) {
					document.getElementById('overview-card').innerHTML = response;
				}
			});
		}
	</script>
