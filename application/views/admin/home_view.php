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
				<div class="col-12">
					<div class="row row-cards">
						<?php if (in_array($user_type_id, array(GlobalModel::ADMIN_TYPE, GlobalModel::CLUB_ADMIN_TYPE))): ?>
							<div class="col-sm-6 col-lg-3">
								<div class="card">
									<div class="card-body">
										<div class="d-flex align-items-center">
											<div class="subheader">Total Members</div>
										</div>
										<div class="d-flex align-items-baseline">
											<div class="h1 mb-3 me-2"><?=$totalMembers ?? 0?></div>
											<div class="me-auto">
												<span class="text-yellow d-inline-flex align-items-center lh-1">
												0% <!-- Download SVG icon from http://tabler-icons.io/i/minus -->
												<svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /></svg>
												</span>
											</div>
										</div>
										<p><?=$totalMembersThisYear ?? 0?> new members this year.</p>
										<div id="chart-new-clients" class="chart-sm"></div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-lg-3">
								<div class="card">
									<div class="card-body">
										<div class="subheader">Active Users</div>
										<div class="d-flex align-items-baseline mb-2">
											<div class="h1 mb-0 me-2"><?=$totalActiveUsers ?? 0?></div>
											<div class="me-auto">
												<span class="text-red d-inline-flex align-items-center lh-1">
													-1%
													<!-- Download SVG icon from http://tabler.io/icons/icon/trending-down -->
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon ms-1 icon-2">
														<path d="M3 7l6 6l4 -4l8 8"></path>
														<path d="M21 10l0 7l-7 0"></path>
													</svg>
												</span>
											</div>
										</div>
										<p>Increased by 60% in last 30 days.</p>
										<div id="chart-active-users-3" class="position-relative"></div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-lg-3">
								<div class="card">
									<div class="card-body">
										<div class="subheader">Active Subscriptions</div>
										<div class="d-flex align-items-baseline mb-2">
											<div class="h1 mb-0 me-2"><?=$totalSubscription ?? 0?></div>
											<div class="me-auto">
												<span class="text-red d-inline-flex align-items-center lh-1">
													<?=$totalSubscription ?? 0?>%
													<!-- Download SVG icon from http://tabler.io/icons/icon/trending-down -->
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon ms-1 icon-2">
														<path d="M3 7l6 6l4 -4l8 8"></path>
														<path d="M21 10l0 7l-7 0"></path>
													</svg>
												</span>
											</div>
										</div>
										<p>Increased by 60% in last 30 days.</p>
										<div id="chart-active-users" class="position-relative chart-sm"></div>
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
										<?php $s = 0; if (isset($subscriptionData)): foreach($subscriptionData as $data): $paymentHistoryRow = get_table($customerDBSettingRow->database_name.'.payment_history', 'universal_id', $data->subscription_id); ?>
											<tr>
												<td class="w-1"><?=++$s?>.</td>
												<td><?= get_table($customerDBSettingRow->database_name.'.user', 'user_id', $data->user_id, 'full_legal_name')?></td>
												<td><?= get_table($customerDBSettingRow->database_name.'.membership_fee_type', 'membership_fee_type_id', $data->membership_fee_type_id, 'name')?></td>
												<td><?= date('d M Y', strtotime($data->due_at)) ?></td>
												<td><?= date('d M Y', strtotime($data->payment_at)) ?></td>
												<td><?= get_table('m_currency', 'currency_id', $data->currency_id, 'sign')?></td>
												<td><?= $data->amount ?></td>
												<td><?= get_table('m_payment_status', 'payment_status_id', $data->payment_status_id, 'name')?></td>
												<td><?= date('d M Y', strtotime($data->created_at)) ?></td>
												<?php if ($viewUserRight || $approveUserRight): ?>
													<td>
														<span class="dropdown">
															<button class="btn dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
															<div class="dropdown-menu dropdown-menu-end">
																<a class="dropdown-item" onclick="viewSubscriptionModal('<?=$data->subscription_id?>', '<?=$data->payment_history_id?>')">View Subscription</a>
																<?php if ($data->active == 0): ?>
																	<a href="#" class="dropdown-item" onclick="approveSubscriptionModal('<?=$data->subscription_id?>', '<?=$data->payment_history_id?>')">
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg> Approve/View
																	</a>
																<?php endif; if ($data->payment_status_id != '1732371146921'): ?>
																	<a class="dropdown-item" onclick="paymentInfoModal('<?=$data->user_id?>', '<?=$data->subscription_id?>')">Pay</a>
																<?php endif; if ($data->payment_status_id == '1732371146921'): ?>
																	<a class="dropdown-item" onclick="paymentReceiptModal('<?=$data->user_id?>', '<?=$data->payment_history_id?>')">
																		<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 4v16m8 -8H4" /></svg> Payment Receipt
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
			<?php else: ?>	
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
													<td><?=date_format(date_create($user->created_at),"y M d H:i:s")?></td>
													<?php if ($viewUserRight || $approveUserRight || $editUserRight || $removeUserRight): ?>
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
																	<?php endif; if ($paymentHistoryRow->payment_status_id != '1732371146921'): ?>
																		<a class="dropdown-item" onclick="paymentInfoModal('<?=$user->user_id ?? ''?>', '<?=$paymentHistoryRow->universal_id ?? ''?>')">Pay</a>
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
			
				<?php if (!empty(get_user_right($user_type_id, '17743087640', 'view', 1))): ?>
					<div class="col-6">
						<div class="card">
							<div class="card-table">
								<div class="card-header">
									<div class="row w-full">
										<div class="col">
											<h3 class="card-title mb-0">Newly Added AGM Minutes</h3>
											<p class="text-secondary m-0">Listing all Newly Added AGM Minutes.</p>
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
														<?php if (!empty($minute->doc_url) && file_exists(base_url($minute->doc_url))): ?>
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
				<?php endif; ?>
				<?php if (!empty(get_user_right($user_type_id, '17848086429', 'view', 1))): ?>
					<div class="col-6">
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

								<div class="card-body border-bottom py-3" hidden>
									<table id="newsletter-datatable" class="table card-table table-vcenter text-wrap datatable" style="width: 100%; min-height: 100px;">
										<thead>
											<tr>
												<th class="w-1">#</th>
												<th>Thumbnail</th>
												<th>Title</th>
												<th>Description</th>
												<th>Status</th>
												<th>Created At</th>
											</tr>
										</thead>
										<tbody class="table-tbody">
											<?php $nl = 0; if (isset($newsletterData)): foreach($newsletterData as $newsletter): ?>
												<tr>
													<td class="w-1"><?=++$nl?>.</td>
													<td>
														<?php if (file_exists(base_url($newsletter->thumbnail_url))): ?>
															<span class="avatar avatar-xs me-2" style="background-image: url('<?=base_url($newsletter->thumbnail_url)?>')"></span>
														<?php else: ?>
															<span class="avatar avatar-xs me-2" style="background-image: url('<?=base_url('assets/admin/images/no-image.png')?>')"></span>
														<?php endif; ?>
													</td>
													<td><?=$newsletter->name?></td>
													<td><span class="only-so-big text-muted"><?=$newsletter->description?></span></td>
													<td><span class="badge <?=($newsletter->active === 1) ? 'bg-green-lt' : (($newsletter->active === 0) ? 'bg-red-lt' : 'bg-yellow-lt')?>"><?=get_table('m_active', 'num', $newsletter->active, 'name')?></span></td>
													<td><?=!empty($newsletter->created_at) ? date('d M Y H:i', strtotime($newsletter->created_at)) : 'N/A'?></td>
												</tr>
											<?php endforeach; endif; ?>
										</tbody>
									</table>
								</div>

								<div class="card-body border-bottom py-3">
									<div class="row">
										<?php $nl = 0; if (!empty($newsletterData)): ?>
											<?php foreach ($newsletterData as $newsletter): ?>		
												<div class="col-sm-6 col-lg-3">
													<?php
														$thumbnailPath = !empty($newsletter->thumbnail_url) ? FCPATH . ltrim($newsletter->thumbnail_url, '/') : '';
														$hasThumbnail = !empty($thumbnailPath) && file_exists($thumbnailPath);
														$thumbnailSrc = $hasThumbnail ? base_url($newsletter->thumbnail_url) : base_url('assets/admin/images/no-image.png');
														$statusClass = ($newsletter->active === 1) ? 'bg-green-lt' : (($newsletter->active === 0) ? 'bg-red-lt' : 'bg-yellow-lt');
													?>
													<div class="row align-items-center g-3">
														<div class="col-auto">
															<span class="avatar" style="background-image: url('<?=$thumbnailSrc?>')"></span>
														</div>
														<div class="col">
															<div class="d-flex justify-content-between align-items-start">
																<div class="pe-3">
																	<div class="text-secondary small">#<?=++$nl?></div>
																	<div class="text-reset fw-medium mb-1"><?=$newsletter->name?></div>
																	<div class="text-secondary text-wrap only-so-big"><?=$newsletter->description?></div>
																</div>
																<div class="text-end" hidden>
																	<span class="badge <?=$statusClass?>"><?=get_table('m_active', 'num', $newsletter->active, 'name')?></span>
																	<div class="text-secondary small mt-1">
																		<?=!empty($newsletter->created_at) ? date('d M Y H:i', strtotime($newsletter->created_at)) : 'N/A'?>
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
	</script>
