<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta
* @link https://tabler.io
* Copyright 2018-2021 The Tabler Authors
* Copyright 2018-2021 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
		<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
		<title><?=$systemRow->name?> - <?=$moduleMenu->name?></title>
		<!-- Favicon icon -->
		<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('assets/img/favicon.png')?>">
		<!-- CSS files -->
		<link href="<?=base_url('assets/admin/dist/libs/dropzone/dist/dropzone.css?1692870487')?>" rel="stylesheet"/>
		<link href="<?=base_url('assets/admin/dist/css/tabler.min.css?1692870487')?>" rel="stylesheet"/>
		<link href="<?=base_url('assets/admin/dist/css/tabler-flags.min.css?1692870487')?>" rel="stylesheet"/>
		<link href="<?=base_url('assets/admin/dist/css/tabler-payments.min.css?1692870487')?>" rel="stylesheet"/>
		<link href="<?=base_url('assets/admin/dist/css/tabler-vendors.min.css?1692870487')?>" rel="stylesheet"/>
		<link href="<?=base_url('assets/admin/dist/css/demo.min.css?1692870487')?>" rel="stylesheet"/>
		<link href="<?=base_url('assets/admin/dist/css/tabler-themes.css?1747674014')?>" rel="stylesheet"/>
		<link href="<?=base_url('assets/admin/dist/css/demo-menu-bar.css')?>" rel="stylesheet"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
		<script src="<?=base_url('assets/admin/dist/js/demo-theme.min.js?1692870487')?>"></script>
		<script src="<?=base_url('assets/admin/dist/js/tabler-theme.min.js?1747674014')?>"></script>

		<!-- Datatable CSS -->
		<link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<!-- <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script> -->
		<!-- basic, standard, standard-all, full, full-all -->
		<script src="https://cdn.ckeditor.com/4.22.1/standard-all/ckeditor.js"></script>
		<!-- <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script> -->
		<!-- <script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script> -->
		<!-- <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script> -->
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
		<style>
			@import url('https://rsms.me/inter/inter.css');
			:root {
				--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
			}
			body {
				font-feature-settings: "cv03", "cv04", "cv11";
			}

		</style>
		<script>
			var base_url = '<?=base_url()?>';
			$(document).ready(function() {
				<?php if ($this->session->has_userdata('message') || $this->session->has_userdata('err')) { ?>
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 5000,
						timerProgressBar: false,
						didOpen: (toast) => {
							toast.addEventListener('mouseenter', Swal.stopTimer)
							toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					});

					Toast.fire({
						icon: "<?=empty($this->session->flashdata('err')) ? 'success' : 'danger'?>",
						title: "<?=$this->session->flashdata('message'); $this->session->flashdata('err'); ?>"
					});   
				<?php } $this->session->unset_userdata('message');  $this->session->unset_userdata('err');?> 
			});
		</script>
	</head>

	<body class="antialiased">
		<!--  BEGIN SIDEBAR  -->
		<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
			<div class="container-fluid">
			<!-- BEGIN NAVBAR TOGGLER -->
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<!-- END NAVBAR TOGGLER -->
			<!-- BEGIN NAVBAR LOGO -->
			<div class="navbar-brand navbar-brand-autodark">
				<a href="<?=base_url('home')?>">
					<img src="<?=base_url('assets/static/logo.png')?>" width="110" height="50" alt="<?=$systemRow->name?>" class="navbar-brand-image">
				</a>
			</div>

				<!-- END NAVBAR LOGO -->
				<div class="navbar-nav flex-row d-lg-none">
					<div class="nav-item d-none d-lg-flex me-3">
					<div class="btn-list">
						<a href="https://github.com/tabler/tabler" class="btn btn-5" target="_blank" rel="noreferrer">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
							<path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5"/>
						</svg>
						Source code
						</a>
						<a href="https://github.com/sponsors/codecalm" class="btn btn-6" target="_blank" rel="noreferrer">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-pink icon-2">
							<path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
						</svg>
						Sponsor
						</a>
					</div>
					</div>

					<div class="d-none d-lg-flex">
					<div class="nav-item">
						<a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1" >
							<path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
						</svg>
						</a>
						<a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" -linejoin="round" class="icon icon-1">
							<path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
							<path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
						</svg>
						</a>
					</div>

					<div class="nav-item dropdown d-none d-md-flex">
						<a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications" data-bs-auto-close="outside" aria-expanded="false" >
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
							<path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
							<path d="M9 17v1a3 3 0 0 0 6 0v-1" />
						</svg>
						<span class="badge bg-red"></span>
						</a>
					</div>
					<div class="nav-item dropdown d-none d-md-flex me-3">
						<a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show app menu" data-bs-auto-close="outside" aria-expanded="false" >
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
							<path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
							<path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
							<path d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
							<path d="M14 7l6 0" />
							<path d="M17 4l0 6" />
						</svg>
						</a>
						<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
						<div class="card">
							<div class="card-header">
							<div class="card-title">My Apps</div>
							<div class="card-actions btn-actions">
								<a href="#" class="btn-action">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
									<path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"/>
									<path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
								</svg>
								</a>
							</div>
							</div>

						</div>
						</div>
					</div>
					</div>
				</div>

				<div class="collapse navbar-collapse" id="sidebar-menu">
					<ul class="navbar-nav pt-lg-3">
						<?php if (isset($moduleData)): foreach($moduleData as $module): if ($module->state == 1 && $module->sub == 0): if (empty(get_user_right($user_type_id, $module->module_id, 'view', 1))) { continue; } ?>
							<li class="nav-item <?=($module->path == $moduleMenu->path ? 'active' : '').' '.($module->withsub == 1 ? 'dropdown' : '')?>">
								<a class="nav-link <?=($module->withsub == 1 ? ($module->path == $moduleMenu->path ? 'dropdown-toggle show' : 'dropdown-toggle') : '')?>" href="<?=$module->withsub == 1 ? '#navbar-extra' : base_url($module->path)?>" <?=($module->withsub == 1 ? 'data-bs-toggle="dropdown"  data-bs-auto-close="false" role="button" aria-expanded="false"' : '')?>>
									<span class="nav-link-icon d-md-none d-lg-inline-block"><?=$module->icon?></span>
									<span class="nav-link-title"><?=$module->name?></span> 
								</a>

								<?php if ($module->withsub == 1) { ?>
									<div class="dropdown-menu <?=($module->path == $moduleMenu->path ? 'show' : '')?>" <?=($module->path == $moduleMenu->path ? 'data-bs-popper="none"' : '')?>>
										<?php $subCount = 0; if (isset($subModuleData)): foreach($subModuleData as $subModule): if ($module->module_id == $subModule->main_id && $subModule->state == 1 && $subModule->sub == 1): if (empty(get_user_right($user_type_id, $subModule->module_id, 'view', 1))) { continue; } ?>
											<?php if ($module->module_id == '73833067810') { ?>
												<?php $ps = 0; if (isset($paymentStatusData)): foreach($paymentStatusData as $paymentStatus): ?>
													<a class="dropdown-item <?=($paymentStatus->payment_status_id == $paymentStatusId ? 'active' : '')?>" href="<?=base_url($subModule->path).'/'.$paymentStatus->payment_status_id?>"><?=++$ps.'. '.$paymentStatus->name?></a>	
												<?php endforeach; endif; ?>
											<?php } elseif ($subModule->module_id == '1744206515594') { ?>
												<?php $pt = 0;  if (isset($propertyTypeData)): foreach($propertyTypeData as $propertyType): ?>
													<a class="dropdown-item <?=($propertyType->property_type_id == $propertyTypeId ? 'active' : '')?>" href="<?=base_url($module->path).'/'.$propertyType->property_type_id?>"><?=++$pt.'. '.$propertyType->name?></a>	
												<?php endforeach; endif; ?>
											<?php } elseif ($subModule->module_id == '1750063183458') { ?>
												<div class="dropend">
													<a class="dropdown-item dropdown-toggle <?=empty($marketingCampaignId) ? '' : 'show'?>" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="<?=empty($marketingCampaignId) ? 'false' : 'true'?>"><?=++$subCount.'. '.$subModule->name?></a>
													<div class="dropdown-menu <?=empty($marketingCampaignId) ? '' : 'show'?>" <?=empty($marketingCampaignId) ? '' : 'data-bs-popper="static"'?>>
														<?php $mc = 0; if (isset($marketingCampaignData)): foreach($marketingCampaignData as $marketingCampaign): ?>
															<a class="dropdown-item <?=($marketingCampaign->marketing_campaign_id == $marketingCampaignId ? 'active' : '')?>" href="<?=base_url($subModule->path).'/'.$marketingCampaign->marketing_campaign_id?>"><?=++$mc.'. '.$marketingCampaign->name?></a>	
														<?php endforeach; endif; ?>	
													</div>
												</div>
											<?php } elseif ($subModule->module_id == '1750071901669') { ?>
												<div class="dropend">
													<a class="dropdown-item dropdown-toggle <?=empty($campaignStateId) ? '' : 'show'?>" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="<?=empty($campaignStateId) ? 'false' : 'true'?>"><?=++$subCount.'. '.$subModule->name?></a>
													<div class="dropdown-menu <?=empty($campaignStateId) ? '' : 'show'?>" <?=empty($campaignStateId) ? '' : 'data-bs-popper="static"'?>>
														<?php $cs = 0; if (isset($campaignStateData)): foreach($campaignStateData as $campaignState): ?>
															<a class="dropdown-item <?=($campaignState->campaign_state_id == $campaignStateId ? 'active' : '')?>" href="<?=base_url($subModule->path).'/'.$campaignState->campaign_state_id?>"><?=++$cs.'. '.$campaignState->name?></a>	
														<?php endforeach; endif; ?>	
													</div>
												</div>									
											<?php } elseif ($subModule->module_id == '62306723120') { ?>
												<!-- <div class="hr-text"><?=$subModule->name?></div> -->
												<?php $ut = 0; if (isset($userTypeData)): foreach($userTypeData as $userType): ?>
													<a class="dropdown-item <?=($userType->user_type_id == $userTypeId ? 'active' : '')?>" href="<?=base_url($subModule->path).'/'.$userType->user_type_id?>"><?=++$ut.'. '.$userType->name.str_repeat('&nbsp;', 5)?><span class="badge badge-pill bg-primary text-primary-fg ms-auto"><?=(isset($userCount[$userType->user_type_id]) ? $userCount[$userType->user_type_id] : 0)?></span></a>
												<?php endforeach; endif; ?>
											<?php } elseif (in_array($subModule->module_id, array('1666345984110'))) { ?>
												<div class="hr-text"><?=$subModule->name?></div>
												<?php if (isset($platformData)): foreach($platformData as $platform): ?>
													<div class="hr-text hr-text-left"><?=str_repeat('&nbsp;', 5).$platform->name?></div>
													<?php $mt = 0; if (isset($moduleTypeData)): foreach($moduleTypeData as $moduleType): if ($platform->platform_id == $moduleType->platform_id): ?>
														<a class="dropdown-item <?=($moduleType->module_type_id == $moduleTypeId ? 'active' : '')?>" href="<?=base_url('all-maintenance/').$moduleType->module_type_id?>"><?=++$mt.'. '.$moduleType->name?></a>	
													<?php endif; endforeach; endif; ?>	
												<?php endforeach; endif; ?>
											<?php } else { ?>
												<a class="dropdown-item <?=(uri_string() == $subModule->path ? 'active' : '')?>" href="<?=base_url($subModule->path)?>">
													<span class="nav-link-title"><?=++$subCount.'. '.$subModule->name?></span>
												</a>
											<?php } ?>
										<?php endif; endforeach; endif; ?>
									</div>
								<?php } ?>
							</li>									
						<?php endif; endforeach; endif; ?>
					</ul>
				</div>
			</div>
		</aside>
			
		<header class="navbar navbar-expand-md navbar-light sticky-top d-print-none">
			<div class="container-fluid">
				<!-- BEGIN NAVBAR TOGGLER -->
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<!-- END NAVBAR TOGGLER -->
				<!-- BEGIN NAVBAR LOGO -->
				<div class="navbar-brand navbar-brand-autodark">
					<h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3"><?=$systemRow->name?></h1>
				</div>

				
				<div class="navbar-nav flex-row order-md-last">	
					<div class="nav-item d-none d-md-flex me-3">
						<div class="btn-list">
							
						</div>
					</div>

					<div class="navbar-nav flex-row order-md-last">
						<div class="nav-item">
							<a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
									<path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
								</svg>
							</a>
							<a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
									<path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
									<path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
								</svg>
							</a>
						</div>
						
						<div class="nav-item dropdown d-none d-md-flex me-3">
							<a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24admin4H0z" fill="none"/><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
								<!-- <span class="badge bg-red"></span> -->
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
								<div class="card">
									<div class="card-body">No new messages..</div>
								</div>
							</div>
						</div>

					<div class="nav-item dropdown">
						<a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="<?=$first_name?>">
							<!-- <span class="avatar avatar-sm" style="adminground-image: url(<?=base_url()?>assets/static/avatars/000m.jpg)"></span> -->
							<span class="avatar"><?=get_initial($first_name)?></span>
							<div class="d-none d-xl-block ps-2">
								<div><?=$first_name?></div>
								<div class="mt-1 small text-muted"><?=get_table('m_user_type', 'user_type_id', $user_type_id, 'name')?></div>
							</div>
						</a>

						<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
							<!-- <a href="#" class="dropdown-item">Set status</a> -->
							<a href="<?=base_url('profile')?>" class="dropdown-item">Profile & account</a>
							<div class="dropdown-divider"></div>
							<!-- <a href="#" class="dropdown-item">Feedadmin</a> -->
							<!-- <a href="#" class="dropdown-item">Settings</a> -->
							<a href="<?=base_url('logout')?>" class="dropdown-item">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24admin4H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M7 12h14l-3 -3m0 6l3 -3" /></svg>
								Logout
							</a>
						</div>
					</div>
				</div>
			</div>
		</header>
