		<div class="modal modal-blur fade" id="modal-view-edit-print-maintenance" name="modal-view-edit-print-maintenance" tabindex="-1" role="dialog" aria-hidden="true"></div>
		
			<!-- END PAGE BODY -->
			<!--  BEGIN FOOTER  -->
			<footer class="footer footer-transparent d-print-none">
				<div class="container-fluid">
					<div class="row text-center align-items-center flex-row-reverse">
						<div class="col-lg-auto ms-lg-auto">
							<ul class="list-inline list-inline-dots mb-0">
							<li class="list-inline-item"><a href="https://docs.tabler.io" target="_blank" class="link-secondary" rel="noopener"><?=$systemRow->name?> is powered by <?=$systemRow->company?></a></li>
							</ul>
						</div>
						<div class="col-12 col-lg-auto mt-3 mt-lg-0">
							<ul class="list-inline list-inline-dots mb-0">
								<li class="list-inline-item">
									Copyright &copy; 2025
									<a href="." class="link-secondary"><?=$systemRow->name?></a>. All rights reserved.
								</li>
								<li class="list-inline-item">
									<a href="./changelog.html" class="link-secondary" rel="noopener"> <?=$systemRow->version?> </a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
			<!--  END FOOTER  -->
		</div>
    </div>

	 <!-- BEGIN PAGE LIBRARIES -->
    <script src="<?=base_url()?>assets/admin/dist/libs/apexcharts/dist/apexcharts.min.js?1747674014" defer></script>
    <script src="<?=base_url()?>assets/admin/dist/libs/jsvectormap/dist/jsvectormap.min.js?1747674014" defer></script>
    <script src="<?=base_url()?>assets/admin/dist/libs/jsvectormap/dist/maps/world.js?1747674014" defer></script>
    <script src="<?=base_url()?>assets/admin/dist/libs/jsvectormap/dist/maps/world-merc.js?1747674014" defer></script>
    <!-- END PAGE LIBRARIES -->
    <script src="<?=base_url()?>assets/admin/dist/libs/list.js/dist/list.min.js?1747674014" defer></script>
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?=base_url()?>assets/admin/dist/js/tabler.min.js?1747674014" defer></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN DEMO SCRIPTS -->
    <script src="<?=base_url()?>assets/admin/preview/js/demo.min.js?1747674014" defer></script>
    <!-- END DEMO SCRIPTS -->
    <!-- BEGIN PAGE SCRIPTS -->

    <script>
		function editUserModal(user_id) {
			$.ajax({
				url: base_url + "edit-user-modal/" + user_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-user').innerHTML = response;
					$('#modal-view-edit-print-user').modal('show');
				}
			});
		}

		function editUserImageModal(user_id) {
			$.ajax({
				url: base_url + "edit-user-image-modal/" + user_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-user').innerHTML = response;
					$('#modal-view-edit-print-user').modal('show');
				}
			});
		}

		function viewPropertyModal(property_id) {
			$.ajax({
				url: base_url + "view-property-modal/" + property_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-property').innerHTML = response;
					$('#modal-view-edit-print-property').modal('show');
					loadDatatable('property-plot-datatable', 'Projects Plots');
				}
			});
		}
		
		function viewPropertyImageModal(property_id) {
			$.ajax({
				url: base_url + "view-property-image-modal/" + property_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-property').innerHTML = response;
					$('#modal-view-edit-print-property').modal('show');
				}
			});
		}

		function viewPropertyPlotModal(property_id) {
			$.ajax({
				url: base_url + "view-property-plot-modal/" + property_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-property').innerHTML = response;
					$('#modal-view-edit-print-property').modal('show');
					loadDatatable('property-plot-datatable', 'Projects Plots');
				}
			});
		}

		function addMaintenanceModal(module_type_id, maintenance) {
			$.ajax({
				url: base_url + "add-maintenance-modal/<?=$moduleMenu->module_id?>/" + module_type_id + "/" + maintenance,
				success: function(response) {
					document.getElementById('modal-view-edit-print-maintenance').innerHTML = response;
					$('#modal-view-edit-print-maintenance').modal('show');

					$('#input_' + maintenance + '_multi_table').select2({
						dropdownParent: $('#modal-view-edit-print-maintenance')
					});

					const maintenanceFieldData = <?=json_encode($maintenanceFieldData ?? []) ?>;
					const maintenanceFieldValueData = <?=json_encode($maintenanceFieldValueData ?? []) ?>;

					$("#input_m_maintenance_column_maintenance_id").change(function() {
						$.ajax({
							type: 'POST',
							url: base_url + "get-table-data/maintenance/maintenance_id/" + $(this).val() + '/name',
							success:function(result) {
								$.ajax({
									type: 'POST',
									url: base_url + "get-maintenance-column-html/" + result + '/0',
									success:function(data) {
										$('#input_m_maintenance_column_column_id').html(data);
									}
								});
							}
						});
					});

					if (maintenanceFieldValueData[maintenance]) {
						const fieldValues = maintenanceFieldValueData[maintenance];
						const fieldData = maintenanceFieldData[maintenance];

						if (fieldData && fieldData.length > 1) {
							fieldData.forEach((maintenanceField, pos) => {
								const name = maintenanceField.name;
								if (![<?=json_encode(explode(',', get_table('m_column_define', 'column_define_id', '1753658383444', 'multi_column')))?>].includes(name) && pos != 1) {
									if ([<?=json_encode(explode(',', get_table('m_column_define', 'column_define_id', '1753528816500', 'multi_column')))?>].includes(name)) {
										CKEDITOR.replace('input_' + maintenance + '_' + name, {
											versionCheck : false,
											height: (['icon', ''].includes(name)) ? 80 : 320,
											allowedContent: true
										});
									}
								}
							});
						}
					}


				}
			});
		}

		function editMaintenanceModal(module_type_id, maintenance, unique_id) {
			$.ajax({
				url: base_url + "edit-maintenance-modal/<?=$moduleMenu->module_id?>/" + module_type_id + "/" + maintenance + "/" + unique_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-maintenance').innerHTML = response;
					$('#modal-view-edit-print-maintenance').modal('show');

					$('#edit_' + maintenance + '_multi_table').select2({
						dropdownParent: $('#modal-view-edit-print-maintenance')
					});

					const maintenanceFieldData = <?=json_encode($maintenanceFieldData ?? []) ?>;
					const maintenanceFieldValueData = <?=json_encode($maintenanceFieldValueData ?? []) ?>;

					$("#input_m_maintenance_column_maintenance_id").change(function() {
						$.ajax({
							type: 'POST',
							url: base_url + "get-table-data/maintenance/maintenance_id/" + $(this).val() + '/name',
							success:function(result) {
								$.ajax({
									type: 'POST',
									url: base_url + "get-maintenance-column-html/" + result + '/0',
									success:function(data) {
										$('#input_m_maintenance_column_column_id').html(data);
									}
								});
							}
						});
					});

					if (maintenanceFieldValueData[maintenance]) {
						const fieldValues = maintenanceFieldValueData[maintenance];
						const fieldData = maintenanceFieldData[maintenance];

						if (fieldData && fieldData.length > 1) {
							const column = fieldData[1].name;
							fieldData.forEach((maintenanceField, pos) => {
								const name = maintenanceField.name;
								if (![<?=json_encode(explode(',', get_table('m_column_define', 'column_define_id', '1753658383444', 'multi_column')))?>].includes(name) && pos != 1) {
									if ([<?=json_encode(explode(',', get_table('m_column_define', 'column_define_id', '1753528816500', 'multi_column')))?>].includes(name)) {
										CKEDITOR.replace('edit_' + maintenance + '_' + name + '_' + unique_id, {
											versionCheck : false,
											height: (['icon', ''].includes(name)) ? 80 : 320,
											allowedContent: true
										});
									}
								}
							});
						}
					}
				}
			});
		}

		function editMaintenanceImageModal(module_type_id, maintenance, unique_id, name='') {
			$.ajax({
				url: base_url + "edit-maintenance-image-modal/<?=$moduleMenu->module_id?>/" + module_type_id + "/" + maintenance + "/" + unique_id + "/" + name,
				success: function(response) {
					document.getElementById('modal-view-edit-print-maintenance').innerHTML = response;
					$('#modal-view-edit-print-maintenance').modal('show');
				}
			});
		}

		function removeMaintenanceModal(module_type_id, maintenance, unique_id) {
			$.ajax({
				url: base_url + "remove-maintenance-modal/<?=$moduleMenu->module_id?>/" + module_type_id + "/" + maintenance + "/" + unique_id,
				success: function(response) {
					document.getElementById('modal-view-edit-print-maintenance').innerHTML = response;
					$('#modal-view-edit-print-maintenance').modal('show');
				}
			});
		}

		function loadRichTextEditor(elementId) {
			tinymce.init({
				selector: '#' + elementId,
				plugins: 'lists link image preview',
				toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
				images_upload_url: base_url + 'upload_image',
				automatic_uploads: true,
				file_picker_types: 'image',
				init_instance_callback: function (editor) {
					editor.on('change', function () {
						editor.save();
					});
				}
			});
		}

		function loadMultipleSelect(elementId) {
			new TomSelect(document.getElementById(elementId), {
				copyClassesToDropdown: false,
				dropdownParent: "body",
				controlInput: "<input>",
				render: {
					item: function (data, escape) {
						if (data.customProperties) {
						return '<div><span class="dropdown-item-indicator">' + data.customProperties + "</span>" + escape(data.text) + "</div>";
						}
						return "<div>" + escape(data.text) + "</div>";
					},
					option: function (data, escape) {
						if (data.customProperties) {
						return '<div><span class="dropdown-item-indicator">' + data.customProperties + "</span>" + escape(data.text) + "</div>";
						}
						return "<div>" + escape(data.text) + "</div>";
					},
				},
			});
		}

		function loadDatatable(datatable, name='') {
			$('#' + datatable).DataTable({
				processing: true,
				displayLength: <?=isset($numericSelectData[0]) ? $numericSelectData[0]->num : GlobalModel::NUMERIC_SELECT_HUNDRED?>,
				paging: true,
				searching: true,
				info: true,
				columnDefs: [{ orderable: false, targets: 'no-search', searchable: false }],
				// order: [[ 2, 'ASC' ]],
				language: 
				{
					emptyTable: '<span class="badge bg-red-lt">No ' + name + ' Records</span>',
					zeroRecords: '<span class="badge bg-red-lt">Nothing found. Please change your search term</span>',
					paginate: 
					{
						previous: 	'<ul class="pagination">'+
										'<li class="page-item disabled">'+
											'<a class="page-link" href="#" tabindex="-1" aria-disabled="true">'+
												'<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>'+
											'Prev </a>'+
										'</li>'+
									'</ul>',

							next: 	'<ul class="pagination">'+
										'<li class="page-item">'+
											'<a class="page-link" href="#"> Next'+
												'<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg>'+
											'</a>'+
										'</li>'+
									'</ul>',
					},
					lengthMenu: 	'<div class="text-muted py-2">Show<div class="mx-2 d-inline-block ">' +
										'<select class="form-select form-control-rounded">' +
											'<?php if (isset($numericSelectData)): foreach($numericSelectData as $data): ?>' +
												'<option value="<?=$data->num?>"><?=$data->name?></option>' + 
											'<?php endforeach; endif; ?>' +
											'<option value="-1">All</option>' +
										'</select>' +
									'</div>entries</div>'

				},
				buttons : [ 'copy', 'csv', 'excel', 'pdf', 'print' ]
			});
		}
		
		// Create Variables
		var allOSB = [];
		var mxh = '';

		window.onload = function() {
			// Set Variables
			allOSB = document.getElementsByClassName("only-so-big");
			
			if (allOSB.length > 0) {
				mxh = window.getComputedStyle(allOSB[0]).getPropertyValue('max-height');
				mxh = parseInt(mxh.replace('px', ''));
				
				// Add read-more button to each OSB section
				for (var i = 0; i < allOSB.length; i++) {
					var el = document.createElement("button");
					el.innerHTML = "Read More";
					el.setAttribute("type", "button");
					el.setAttribute("class", "read-more hid");
					insertAfter(allOSB[i], el);
				}
			}

			// Add click function to buttons
			var readMoreButtons = document.getElementsByClassName("read-more");
			for (var i = 0; i < readMoreButtons.length; i++) {
				readMoreButtons[i].addEventListener("click", function() { 
					revealThis(this);
				}, false);
			}
			
			// Update buttons so only the needed ones show
			updateReadMore();
		}
		// Update on resize
		window.onresize = function() {
			updateReadMore();
		}

		// show only the necessary read-more buttons
		function updateReadMore() {
			if (allOSB.length > 0) {
				for (var i = 0; i < allOSB.length; i++) {
					if (allOSB[i].scrollHeight > mxh) {
						if (allOSB[i].hasAttribute("style")) {
							updateHeight(allOSB[i]);
						}
						allOSB[i].nextElementSibling.className = "read-more";
					} else {
						allOSB[i].nextElementSibling.className = "read-more hid";
					}
				}
			}
		}

		function revealThis(current) {
			var el = current.previousElementSibling;
			if (el.hasAttribute("style")) {
				current.innerHTML = "Read More";
				el.removeAttribute("style");
			} else {
				updateHeight(el);
				current.innerHTML = "Show Less";
			}
		}

		function updateHeight(el) {
			el.style.maxHeight = el.scrollHeight + "px";
		}

		// thanks to karim79 for this function
		// http://stackoverflow.com/a/4793630/5667951
		function insertAfter(referenceNode, newNode) {
			referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
		}

      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('chart-revenue-bg'), {
      		chart: {
      			type: "area",
      			fontFamily: 'inherit',
      			height: 40.0,
      			sparkline: {
      				enabled: true
      			},
      			animations: {
      				enabled: false
      			},
      		},
      		dataLabels: {
      			enabled: false,
      		},
      		fill: {
      			opacity: .16,
      			type: 'solid'
      		},
      		stroke: {
      			width: 2,
      			lineCap: "round",
      			curve: "smooth",
      		},
      		series: [{
      			name: "Profits",
      			data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67]
      		}],
      		grid: {
      			strokeDashArray: 4,
      		},
      		xaxis: {
      			labels: {
      				padding: 0
      			},
      			tooltip: {
      				enabled: false
      			},
      			axisBorder: {
      				show: false,
      			},
      			type: 'datetime',
      		},
      		yaxis: {
      			labels: {
      				padding: 4
      			},
      		},
      		labels: [
      			'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
      		],
      		colors: ["#206bc4"],
      		legend: {
      			show: false,
      		},
      	})).render();
      });
      // @formatter:on
	  document.addEventListener("DOMContentLoaded", function () {
    	var el;
    	window.Choices && (new Choices(el = document.getElementById('user_id'), {
    		classNames: {
    			containerInner: el.className,
    			input: 'form-control',
    			inputCloned: 'form-control-sm',
    			listDropdown: 'dropdown-menu',
    			itemChoice: 'dropdown-item',
    			activeState: 'show',
    			selectedState: 'active',
    		},
    		shouldSort: false,
    		searchEnabled: false,
    		callbackOnCreateTemplates: function(template) {
    			var classNames = this.config.className,
    					itemSelectText = this.config.itemSelectText;
    			return {
    				item: function(classNames, data) {
    					return template('<div class="' + String(classNames.item) + ' ' + String( data.highlighted ? classNames.highlightedState : classNames.itemSelectable ) + '" data-item data-id="' + String(data.id) + '" data-value="' + String(data.value) + '"' + String(data.active ? 'aria-selected="true"' : '') + '' + String(data.disabled ? 'aria-disabled="true"' : '') + '><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + String(data.label) + '</div>');
    				},
    				choice: function(classNames, data) {
    					console.log('data', data);
    					return template('<div class="' + String(classNames.item) + ' ' + String(classNames.itemChoice) + ' ' + String( data.disabled ? classNames.itemDisabled : classNames.itemSelectable ) + '" data-select-text="' + String(itemSelectText) + '" data-choice  ' + String( data.disabled ? 'data-choice-disabled aria-disabled="true"' : 'data-choice-selectable' ) + ' data-id="' + String(data.id) + '" data-value="' + String(data.value) + '" ' + String( data.groupId > 0 ? 'role="treeitem"' : 'role="option"' ) + ' ><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + String(data.label) + '</div>');
    				},
    			};
    		},
    	}));
    });
    </script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('chart-new-clients'), {
      		chart: {
      			type: "line",
      			fontFamily: 'inherit',
      			height: 40.0,
      			sparkline: {
      				enabled: true
      			},
      			animations: {
      				enabled: false
      			},
      		},
      		fill: {
      			opacity: 1,
      		},
      		stroke: {
      			width: [2, 1],
      			dashArray: [0, 3],
      			lineCap: "round",
      			curve: "smooth",
      		},
      		series: [
			// 	  {
      		// 	name: "May",
      		// 	data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 4, 46, 39, 62, 51, 35, 41, 67]
      		// },
			  {
      			name: "April",
      			data: [93, 54, 51, 24, 35, 35, 31, 67, 19, 43, 28, 36, 62, 61, 27, 39, 35, 41, 27, 35, 51, 46, 62, 37, 44, 53, 41, 65, 39, 37]
      		}
			],
      		grid: {
      			strokeDashArray: 4,
      		},
      		xaxis: {
      			labels: {
      				padding: 0
      			},
      			tooltip: {
      				enabled: false
      			},
      			type: 'datetime',
      		},
      		yaxis: {
      			labels: {
      				padding: 4
      			},
      		},
      		labels: [
      			'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
      		],
      		colors: ["#206bc4", "#a8aeb7"],
      		legend: {
      			show: false,
      		},
      	})).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('chart-active-users'), {
      		chart: {
      			type: "bar",
      			fontFamily: 'inherit',
      			height: 40.0,
      			sparkline: {
      				enabled: true
      			},
      			animations: {
      				enabled: false
      			},
      		},
      		plotOptions: {
      			bar: {
      				columnWidth: '50%',
      			}
      		},
      		dataLabels: {
      			enabled: false,
      		},
      		fill: {
      			opacity: 1,
      		},
      		series: [{
      			name: "Profits",
      			data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67]
      		}],
      		grid: {
      			strokeDashArray: 4,
      		},
      		xaxis: {
      			labels: {
      				padding: 0
      			},
      			tooltip: {
      				enabled: false
      			},
      			axisBorder: {
      				show: false,
      			},
      			type: 'datetime',
      		},
      		yaxis: {
      			labels: {
      				padding: 4
      			},
      		},
      		labels: [
      			'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
      		],
      		colors: ["#206bc4"],
      		legend: {
      			show: false,
      		},
      	})).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('chart-mentions'), {
      		chart: {
      			type: "bar",
      			fontFamily: 'inherit',
      			height: 240,
      			parentHeightOffset: 0,
      			toolbar: {
      				show: false,
      			},
      			animations: {
      				enabled: false
      			},
      			stacked: true,
      		},
      		plotOptions: {
      			bar: {
      				columnWidth: '50%',
      			}
      		},
      		dataLabels: {
      			enabled: false,
      		},
      		fill: {
      			opacity: 1,
      		},
      		series: [{
      			name: "Web",
      			data: [1, 0, 0, 0, 0, 1, 1, 0, 0, 0, 2, 12, 5, 8, 22, 6, 8, 6, 4, 1, 8, 24, 29, 51, 40, 47, 23, 26, 50, 26, 41, 22, 46, 47, 81, 46, 6]
      		},{
      			name: "Social",
      			data: [2, 5, 4, 3, 3, 1, 4, 7, 5, 1, 2, 5, 3, 2, 6, 7, 7, 1, 5, 5, 2, 12, 4, 6, 18, 3, 5, 2, 13, 15, 20, 47, 18, 15, 11, 10, 0]
      		},{
      			name: "Other",
      			data: [2, 9, 1, 7, 8, 3, 6, 5, 5, 4, 6, 4, 1, 9, 3, 6, 7, 5, 2, 8, 4, 9, 1, 2, 6, 7, 5, 1, 8, 3, 2, 3, 4, 9, 7, 1, 6]
      		}],
      		grid: {
      			padding: {
      				top: -20,
      				right: 0,
      				left: -4,
      				bottom: -4
      			},
      			strokeDashArray: 4,
      			xaxis: {
      				lines: {
      					show: true
      				}
      			},
      		},
      		xaxis: {
      			labels: {
      				padding: 0
      			},
      			tooltip: {
      				enabled: false
      			},
      			axisBorder: {
      				show: false,
      			},
      			type: 'datetime',
      		},
      		yaxis: {
      			labels: {
      				padding: 4
      			},
      		},
      		labels: [
      			'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19', '2020-07-20', '2020-07-21', '2020-07-22', '2020-07-23', '2020-07-24', '2020-07-25', '2020-07-26'
      		],
      		colors: ["#206bc4", "#79a6dc", "#bfe399"],
      		legend: {
      			show: true,
      			position: 'bottom',
      			height: 32,
      			offsetY: 8,
      			markers: {
      				width: 8,
      				height: 8,
      				radius: 100,
      			},
      			itemMargin: {
      				horizontal: 8,
      			},
      		},
      	})).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-activity'), {
      		chart: {
      			type: "radialBar",
      			fontFamily: 'inherit',
      			height: 40,
      			width: 40,
      			animations: {
      				enabled: false
      			},
      			sparkline: {
      				enabled: true
      			},
      		},
      		tooltip: {
      			enabled: false,
      		},
      		plotOptions: {
      			radialBar: {
      				hollow: {
      					margin: 0,
      					size: '75%'
      				},
      				track: {
      					margin: 0
      				},
      				dataLabels: {
      					show: false
      				}
      			}
      		},
      		colors: ["#206bc4"],
      		series: [35],
      	})).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('chart-development-activity'), {
      		chart: {
      			type: "area",
      			fontFamily: 'inherit',
      			height: 192,
      			sparkline: {
      				enabled: true
      			},
      			animations: {
      				enabled: false
      			},
      		},
      		dataLabels: {
      			enabled: false,
      		},
      		fill: {
      			opacity: .16,
      			type: 'solid'
      		},
      		stroke: {
      			width: 2,
      			lineCap: "round",
      			curve: "smooth",
      		},
      		series: [{
      			name: "Purchases",
      			data: [3, 5, 4, 6, 7, 5, 6, 8, 24, 7, 12, 5, 6, 3, 8, 4, 14, 30, 17, 19, 15, 14, 25, 32, 40, 55, 60, 48, 52, 70]
      		}],
      		grid: {
      			strokeDashArray: 4,
      		},
      		xaxis: {
      			labels: {
      				padding: 0
      			},
      			tooltip: {
      				enabled: false
      			},
      			axisBorder: {
      				show: false,
      			},
      			type: 'datetime',
      		},
      		yaxis: {
      			labels: {
      				padding: 4
      			},
      		},
      		labels: [
      			'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
      		],
      		colors: ["#206bc4"],
      		legend: {
      			show: false,
      		},
      		point: {
      			show: false
      		},
      	})).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-1'), {
      		chart: {
      			type: "line",
      			fontFamily: 'inherit',
      			height: 24,
      			animations: {
      				enabled: false
      			},
      			sparkline: {
      				enabled: true
      			},
      		},
      		tooltip: {
      			enabled: false,
      		},
      		stroke: {
      			width: 2,
      			lineCap: "round",
      		},
      		series: [{
      			color: "#206bc4",
      			data: [17, 24, 20, 10, 5, 1, 4, 18, 13]
      		}],
      	})).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-2'), {
      		chart: {
      			type: "line",
      			fontFamily: 'inherit',
      			height: 24,
      			animations: {
      				enabled: false
      			},
      			sparkline: {
      				enabled: true
      			},
      		},
      		tooltip: {
      			enabled: false,
      		},
      		stroke: {
      			width: 2,
      			lineCap: "round",
      		},
      		series: [{
      			color: "#206bc4",
      			data: [13, 11, 19, 22, 12, 7, 14, 3, 21]
      		}],
      	})).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-3'), {
      		chart: {
      			type: "line",
      			fontFamily: 'inherit',
      			height: 24,
      			animations: {
      				enabled: false
      			},
      			sparkline: {
      				enabled: true
      			},
      		},
      		tooltip: {
      			enabled: false,
      		},
      		stroke: {
      			width: 2,
      			lineCap: "round",
      		},
      		series: [{
      			color: "#206bc4",
      			data: [10, 13, 10, 4, 17, 3, 23, 22, 19]
      		}],
      	})).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-4'), {
      		chart: {
      			type: "line",
      			fontFamily: 'inherit',
      			height: 24,
      			animations: {
      				enabled: false
      			},
      			sparkline: {
      				enabled: true
      			},
      		},
      		tooltip: {
      			enabled: false,
      		},
      		stroke: {
      			width: 2,
      			lineCap: "round",
      		},
      		series: [{
      			color: "#206bc4",
      			data: [6, 15, 13, 13, 5, 7, 17, 20, 19]
      		}],
      	})).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-5'), {
      		chart: {
      			type: "line",
      			fontFamily: 'inherit',
      			height: 24,
      			animations: {
      				enabled: false
      			},
      			sparkline: {
      				enabled: true
      			},
      		},
      		tooltip: {
      			enabled: false,
      		},
      		stroke: {
      			width: 2,
      			lineCap: "round",
      		},
      		series: [{
      			color: "#206bc4",
      			data: [2, 11, 15, 14, 21, 20, 8, 23, 18, 14]
      		}],
      	})).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-6'), {
      		chart: {
      			type: "line",
      			fontFamily: 'inherit',
      			height: 24,
      			animations: {
      				enabled: false
      			},
      			sparkline: {
      				enabled: true
      			},
      		},
      		tooltip: {
      			enabled: false,
      		},
      		stroke: {
      			width: 2,
      			lineCap: "round",
      		},
      		series: [{
      			color: "#206bc4",
      			data: [22, 12, 7, 14, 3, 21, 8, 23, 18, 14]
      		}],
      	})).render();
      });
      // @formatter:on
    </script>
	<style>
		*,
		*:before,
		*:after {
			box-sizing: border-box;
		}
		html,

		.only-so-big p {
			padding: 0;
			margin: 0;
		}
		.only-so-big {
			/* background: rgba(178, 252, 255, .3); */
			height: 100%;
			width: auto;
			max-height: 45px;
			max-width: 200px;
			overflow: hidden;
			-webkit-transition: max-height .75s;
			transition: max-height .75s;
		}

		.read-more {
			background: none;
			border: none;
			color: #1199f9;
			cursor: pointer;
			font-size: 1em;
			outline: none; 
		}
		.read-more:hover {
			text-decoration: underline;
		}
		.read-more:focus {
			outline: none;
		}
		.read-more::-moz-focus-inner {
			border: 0;
		}
		.hid {
			display: none;
		}
	</style>
  </body>
</html>
