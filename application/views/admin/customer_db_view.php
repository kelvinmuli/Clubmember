      <div class="page-wrapper">
        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
          <div class="container-fluid">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Overview</div>
                <h2 class="page-title">Database Listing</h2>
              </div>


              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="#" class="btn btn-primary btn-5 d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      class="icon icon-2"
                    >
                      <path d="M12 5l0 14" />
                      <path d="M5 12l14 0" />
                    </svg>
                    Add New Database
                  </a>
                  <a
                    href="#"
                    class="btn btn-primary btn-6 d-sm-none btn-icon"
                    data-bs-toggle="modal"
                    data-bs-target="#modal-report"
                    aria-label="Create new report"
                  >
                    <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      class="icon icon-2"
                    >
                      <path d="M12 5l0 14" />
                      <path d="M5 12l14 0" />
                    </svg>
                  </a>
                </div>
                <!-- BEGIN MODAL -->
                <!-- END MODAL -->
              </div>
            </div>
          </div>
        </div>
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE BODY -->
        <div class="page-body">
          <div class="container-fluid">
            <div class="row row-deck row-cards">

              

              <div class="card">
                  <div class="card-table">
                    <div class="card-header">

                      <div class="row w-full">
                        <div class="col">
                          <h3 class="card-title mb-0">Customer Database Listing</h3>
                          <p class="text-secondary m-0">Listing all customer Databases.</p>
                        </div>
                        <div class="col-md-auto col-sm-12">
                          <div class="ms-auto d-flex flex-wrap btn-list">
                            <div class="input-group input-group-flat w-auto">
                              <span class="input-group-text">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/search -->
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  width="24"
                                  height="24"
                                  viewBox="0 0 24 24"
                                  fill="none"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  class="icon icon-1"
                                >
                                  <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                  <path d="M21 21l-6 -6" />
                                </svg>
                              </span>
                              <input id="advanced-table-search" type="text" class="form-control" autocomplete="off" />
                              <span class="input-group-text">
                                <kbd>ctrl + K</kbd>
                              </span>
                            </div>
                           
                            <div class="dropdown">
                              <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown">Download</a>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Third action</a>
                              </div>
                            </div>
                            <!-- <a href="#" class="btn btn-0"> Button </a> -->
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="advanced-table">
                      <div class="table-responsive">
                        <table class="table table-vcenter table-selectable">
                          <thead>
                            <tr>
                              <th class="w-1">#</th>
                              <th><button class="table-sort d-flex justify-content-between" data-sort="sort-name">Customer Name</button></th>
                              <th><button class="table-sort d-flex justify-content-between" data-sort="sort-category">Subdomain</button></th>
                              <th><button class="table-sort d-flex justify-content-between" data-sort="sort-status">Database Name</button></th>
															<th>Actions</th>
                            </tr>
                          </thead>
                          <tbody class="table-tbody">
                            <?php $c = 0; if (isset($customerDBSettingData)): foreach ($customerDBSettingData as $customerDBSetting): ?>
															<tr>
																<td><?=++$c?></td>
																<td><?=get_table('customer', 'customer_id', $customerDBSetting->customer_id, 'full_legal_name')?></td>
																<td><?=$customerDBSetting->sub_domain ?></td>
																<td><?=$customerDBSetting->database_name?></td>
																<td></td>
															</tr>
														<?php endforeach; endif; ?>
                          </tbody>
                        </table>
                      </div>
                      <div class="card-footer d-flex align-items-center">
                        <div class="dropdown">
                          <a class="btn dropdown-toggle" data-bs-toggle="dropdown">
                            <span id="page-count" class="me-1">20</span>
                            <span>records</span>
                          </a>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" onclick="setPageListItems(event)" data-value="10">10 records</a>
                            <a class="dropdown-item" onclick="setPageListItems(event)" data-value="20">20 records</a>
                            <a class="dropdown-item" onclick="setPageListItems(event)" data-value="50">50 records</a>
                            <a class="dropdown-item" onclick="setPageListItems(event)" data-value="100">100 records</a>
                          </div>
                        </div>
                        <ul class="pagination m-0 ms-auto">
                          <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                              <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-1"
                              >
                                <path d="M15 6l-6 6l6 6" />
                              </svg>
                            </a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="#">1</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="#">2</a>
                          </li>
                          <li class="page-item active">
                            <a class="page-link" href="#">3</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="#">4</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="#">5</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="#">6</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="#">7</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="#">8</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="#">9</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="#">10</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="#">
                              <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-right -->
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-1"
                              >
                                <path d="M9 6l6 6l-6 6" />
                              </svg>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <script>
                  const advancedTable = {
                    headers: [
                      { "data-sort": "sort-name", name: "Name" },
                      { "data-sort": "sort-city", name: "City" },
                      { "data-sort": "sort-status", name: "Status" },
                      { "data-sort": "sort-date", name: "Start date" },
                      { "data-sort": "sort-tags", name: "Tags" },
                      { "data-sort": "sort-category", name: "Category" },
                    ],
                  };
                  const setPageListItems = (e) => {
                    window.tabler_list["advanced-table"].page = parseInt(e.target.dataset.value);
                    window.tabler_list["advanced-table"].update();
                    document.querySelector("#page-count").innerHTML = e.target.dataset.value;
                  };
                  window.tabler_list = window.tabler_list || {};
                  document.addEventListener("DOMContentLoaded", function () {
                    const list = (window.tabler_list["advanced-table"] = new List("advanced-table", {
                      sortClass: "table-sort",
                      listClass: "table-tbody",
                      page: parseInt("20"),
                      pagination: {
                        item: (value) => {
                          return `<li class="page-item"><a class="page-link cursor-pointer">${value.page}</a></li>`;
                        },
                        innerWindow: 1,
                        outerWindow: 1,
                        left: 0,
                        right: 0,
                      },
                      valueNames: advancedTable.headers.map((header) => header["data-sort"]),
                    }));
                    const searchInput = document.querySelector("#advanced-table-search");
                    if (searchInput) {
                      searchInput.addEventListener("input", () => {
                        list.search(searchInput.value);
                      });
                    }
                  });
                </script>
            </div>
          </div>
        </div>
        <!-- END PAGE BODY -->
      </div>
    </div>

    <!-- BEGIN PAGE MODALS -->
    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add New Database</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form action="<?=base_url('create-customer-database')?>" method="post" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label">Customer Name <span style="color: red;">*</span></label>
										<select class="form-select" name="customer_id" required>
											<option value="" selected disabled>-- Select Customer --</option>
											<?php if (isset($customerData)): foreach ($customerData as $customer): ?>
												<option value="<?=$customer->customer_id?>"><?=$customer->full_legal_name?></option>
											<?php endforeach; endif; ?>
										</select>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label">Sub domain </label>
										<input type="text" class="form-control" name="sub_domain" placeholder="Enter Subdomain" />
									</div>
								</div>
							</div>				
						</div>

						<div class="modal-body">
							<div class="row">
								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label">Database Name </label>
										<input type="text" class="form-control" name="database_name" placeholder="Enter Database Name" />
									</div>
								</div>

								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label">Status <span style="color: red;">*</span></label>
										<select name="database_status_id" class="form-select" required>
											<option value="" selected disabled>-- Select Database Status --</option>
											<?php if (isset($databaseStatusData)): foreach ($databaseStatusData as $databaseStatus): ?>
												<option value="<?=$databaseStatus->database_status_id?>"><?=$databaseStatus->name?></option>
											<?php endforeach; endif; ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					
						<div class="modal-footer">
							<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
							<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
								<svg xmlns="http://www.w3.org/200/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="10" y1="14" x2="21" y2="3" /><path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
								Add Database
							</button>
						</div>
      		</form>
        </div>
      </div>
    </div>
    <!-- END PAGE MODALS -->



<!-- Edit modal -->
    <div class="modal modal-blur fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form id="editForm" action="<?= base_url('customers-update') ?>" method="post" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="customer_id" id="edit-customer-id">

         <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label for="edit-name" class="form-label">Name</label>
                  <input type="text" class="form-control" name="name" id="edit-name" required>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="mb-3">
                  <label for="edit-short_name" class="form-label">Short Name</label>
                  <input type="text" class="form-control" name="short_name" id="edit-short_name" required>
                </div>
            </div>
        </div>

            <div class="row">

            <div class="col-lg-4">
                <div class="mb-3">
                  <label for="edit-type" class="form-label">Type</label>
                  <select name="type" id="edit-type" class="form-select">
                    <option value="Club">Club</option>
                    <option value="Association">Association</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="mb-3">
                  <label for="edit-email" class="form-label">Email Address</label>
                  <input type="email" class="form-control" name="email" id="edit-email" required>
                </div>
            </div>

             <div class="col-lg-4">
                <div class="mb-3">
                  <label for="edit-telno" class="form-label">Telephone Number</label>
                  <input type="text" class="form-control" name="tel_no" id="edit-telno">
                </div>
            </div>
               
        </div>

        <div class="row">
        <div class="col-lg-6">
                <div class="mb-3">
                  <label for="edit-physical_address" class="form-label">Physical Address</label>
                  <input type="text" class="form-control" name="physical_address" id="edit-physical_address">
                </div>
            </div>

             <div class="col-lg-6">
                <div class="mb-3">
                  <label for="edit-regno" class="form-label">Postal Address</label>
                  <input type="text" class="form-control" name="postal_address" id="edit-postal_address">
                </div>
            </div>

        </div>


     <div class="row">
        <div class="col-lg-6">
                <div class="mb-3">
                  <label for="edit-regno" class="form-label">Registration Number</label>
                  <input type="text" class="form-control" name="reg_no" id="edit-regno">
                </div>
            </div>

        <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Country</label>
                  <select class="form-select" name="country" id="edit-country">
                    <option value="Kenya">Kenya</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div>


    <div class="col-lg-6">
        <div class="mb-3">
          <label for="edit-logo" class="form-label">Logo (optional)</label>
          <input type="file" name="logo" id="edit-logo" class="form-control">
        </div>
    </div>

   <div class="col-lg-6">
        <div class="mb-3">
          <label for="edit-agreement" class="form-label">Agreement (optional)</label>
          <input type="file" name="agreement" id="edit-agreement" class="form-control">
        </div>
    </div>
</div>


<div class="row">

        <div class="col-lg-12">
        <div class="mb-3">
          <label for="edit-status" class="form-label">Status</label>
          <select name="status" id="edit-status" class="form-select">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            <option value="Trial">Trial</option>
            <option value="Suspended">Suspended</option>
          </select>
        </div>
      </div>
  </div>
</div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>
<!-- End of edit modal -->

<div class="modal modal-blur fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form method="POST" action="<?= base_url('customers-delete') ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete <strong id="deleteCustomerName"></strong>?
          <input type="hidden" name="customer_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
        </div>
      </div>
    </form>
  </div>
</div>




    <div class="settings">
      <a
        href="#"
        class="btn btn-floating btn-icon btn-primary"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasSettings"
        aria-controls="offcanvasSettings"
        aria-label="Theme Builder"
      >
        <!-- Download SVG icon from http://tabler.io/icons/icon/brush -->
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="icon icon-1"
        >
          <path d="M3 21v-4a4 4 0 1 1 4 4h-4" />
          <path d="M21 3a16 16 0 0 0 -12.8 10.2" />
          <path d="M21 3a16 16 0 0 1 -10.2 12.8" />
          <path d="M10.6 9a9 9 0 0 1 4.4 4.4" />
        </svg>
      </a>
      <form class="offcanvas offcanvas-start offcanvas-narrow" tabindex="-1" id="offcanvasSettings">
        <div class="offcanvas-header">
          <h2 class="offcanvas-title">Theme Builder</h2>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
          <div>
            <div class="mb-4">
              <label class="form-label">Color mode</label>
              <p class="form-hint">Choose the color mode for your app.</p>
              <label class="form-check">
                <div class="form-selectgroup-item">
                  <input type="radio" name="theme" value="light" class="form-check-input" checked />
                  <div class="form-check-label">Light</div>
                </div>
              </label>
              <label class="form-check">
                <div class="form-selectgroup-item">
                  <input type="radio" name="theme" value="dark" class="form-check-input" />
                  <div class="form-check-label">Dark</div>
                </div>
              </label>
            </div>
            <div class="mb-4">
              <label class="form-label">Color scheme</label>
              <p class="form-hint">The perfect color mode for your app.</p>
              <div class="row g-2">
                <div class="col-auto">
                  <label class="form-colorinput">
                    <input name="theme-primary" type="radio" value="blue" class="form-colorinput-input" />
                    <span class="form-colorinput-color bg-blue"></span>
                  </label>
                </div>
                <div class="col-auto">
                  <label class="form-colorinput">
                    <input name="theme-primary" type="radio" value="azure" class="form-colorinput-input" />
                    <span class="form-colorinput-color bg-azure"></span>
                  </label>
                </div>
                <div class="col-auto">
                  <label class="form-colorinput">
                    <input name="theme-primary" type="radio" value="indigo" class="form-colorinput-input" />
                    <span class="form-colorinput-color bg-indigo"></span>
                  </label>
                </div>
                <div class="col-auto">
                  <label class="form-colorinput">
                    <input name="theme-primary" type="radio" value="purple" class="form-colorinput-input" />
                    <span class="form-colorinput-color bg-purple"></span>
                  </label>
                </div>
                <div class="col-auto">
                  <label class="form-colorinput">
                    <input name="theme-primary" type="radio" value="pink" class="form-colorinput-input" />
                    <span class="form-colorinput-color bg-pink"></span>
                  </label>
                </div>
                <div class="col-auto">
                  <label class="form-colorinput">
                    <input name="theme-primary" type="radio" value="red" class="form-colorinput-input" />
                    <span class="form-colorinput-color bg-red"></span>
                  </label>
                </div>
                <div class="col-auto">
                  <label class="form-colorinput">
                    <input name="theme-primary" type="radio" value="orange" class="form-colorinput-input" />
                    <span class="form-colorinput-color bg-orange"></span>
                  </label>
                </div>
                <div class="col-auto">
                  <label class="form-colorinput">
                    <input name="theme-primary" type="radio" value="yellow" class="form-colorinput-input" />
                    <span class="form-colorinput-color bg-yellow"></span>
                  </label>
                </div>
                <div class="col-auto">
                  <label class="form-colorinput">
                    <input name="theme-primary" type="radio" value="lime" class="form-colorinput-input" />
                    <span class="form-colorinput-color bg-lime"></span>
                  </label>
                </div>
                <div class="col-auto">
                  <label class="form-colorinput">
                    <input name="theme-primary" type="radio" value="green" class="form-colorinput-input" />
                    <span class="form-colorinput-color bg-green"></span>
                  </label>
                </div>
                <div class="col-auto">
                  <label class="form-colorinput">
                    <input name="theme-primary" type="radio" value="teal" class="form-colorinput-input" />
                    <span class="form-colorinput-color bg-teal"></span>
                  </label>
                </div>
                <div class="col-auto">
                  <label class="form-colorinput">
                    <input name="theme-primary" type="radio" value="cyan" class="form-colorinput-input" />
                    <span class="form-colorinput-color bg-cyan"></span>
                  </label>
                </div>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label">Font family</label>
              <p class="form-hint">Choose the font family that fits your app.</p>
              <div>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-font" value="sans-serif" class="form-check-input" checked />
                    <div class="form-check-label">Sans-serif</div>
                  </div>
                </label>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-font" value="serif" class="form-check-input" />
                    <div class="form-check-label">Serif</div>
                  </div>
                </label>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-font" value="monospace" class="form-check-input" />
                    <div class="form-check-label">Monospace</div>
                  </div>
                </label>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-font" value="comic" class="form-check-input" />
                    <div class="form-check-label">Comic</div>
                  </div>
                </label>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label">Theme base</label>
              <p class="form-hint">Choose the gray shade for your app.</p>
              <div>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-base" value="slate" class="form-check-input" />
                    <div class="form-check-label">Slate</div>
                  </div>
                </label>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-base" value="gray" class="form-check-input" checked />
                    <div class="form-check-label">Gray</div>
                  </div>
                </label>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-base" value="zinc" class="form-check-input" />
                    <div class="form-check-label">Zinc</div>
                  </div>
                </label>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-base" value="neutral" class="form-check-input" />
                    <div class="form-check-label">Neutral</div>
                  </div>
                </label>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-base" value="stone" class="form-check-input" />
                    <div class="form-check-label">Stone</div>
                  </div>
                </label>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label">Corner Radius</label>
              <p class="form-hint">Choose the border radius factor for your app.</p>
              <div>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-radius" value="0" class="form-check-input" />
                    <div class="form-check-label">0</div>
                  </div>
                </label>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-radius" value="0.5" class="form-check-input" />
                    <div class="form-check-label">0.5</div>
                  </div>
                </label>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-radius" value="1" class="form-check-input" checked />
                    <div class="form-check-label">1</div>
                  </div>
                </label>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-radius" value="1.5" class="form-check-input" />
                    <div class="form-check-label">1.5</div>
                  </div>
                </label>
                <label class="form-check">
                  <div class="form-selectgroup-item">
                    <input type="radio" name="theme-radius" value="2" class="form-check-input" />
                    <div class="form-check-label">2</div>
                  </div>
                </label>
              </div>
            </div>
          </div>
          <div class="mt-auto space-y">
            <button type="button" class="btn w-100" id="reset-changes">
              <!-- Download SVG icon from http://tabler.io/icons/icon/rotate -->
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="icon icon-1"
              >
                <path d="M19.95 11a8 8 0 1 0 -.5 4m.5 5v-5h-5" />
              </svg>
              Reset changes
            </button>
            <a href="#" class="btn btn-primary w-100" data-bs-dismiss="offcanvas">
              <!-- Download SVG icon from http://tabler.io/icons/icon/settings -->
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="icon icon-1"
              >
                <path
                  d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"
                />
                <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
              </svg>
              Save settings
            </a>
          </div>
        </div>
      </form>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        var themeConfig = {
          theme: "light",
          "theme-base": "gray",
          "theme-font": "sans-serif",
          "theme-primary": "blue",
          "theme-radius": "1",
        };
        var url = new URL(window.location);
        var form = document.getElementById("offcanvasSettings");
        var resetButton = document.getElementById("reset-changes");
        var checkItems = function () {
          for (var key in themeConfig) {
            var value = window.localStorage["tabler-" + key] || themeConfig[key];
            if (!!value) {
              var radios = form.querySelectorAll(`[name="${key}"]`);
              if (!!radios) {
                radios.forEach((radio) => {
                  radio.checked = radio.value === value;
                });
              }
            }
          }
        };
        form.addEventListener("change", function (event) {
          var target = event.target,
            name = target.name,
            value = target.value;
          for (var key in themeConfig) {
            if (name === key) {
              document.documentElement.setAttribute("data-bs-" + key, value);
              window.localStorage.setItem("tabler-" + key, value);
              url.searchParams.set(key, value);
            }
          }
          window.history.pushState({}, "", url);
        });
        resetButton.addEventListener("click", function () {
          for (var key in themeConfig) {
            var value = themeConfig[key];
            document.documentElement.removeAttribute("data-bs-" + key);
            window.localStorage.removeItem("tabler-" + key);
            url.searchParams.delete(key);
          }
          checkItems();
          window.history.pushState({}, "", url);
        });
        checkItems();
      });
    </script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('editModal');

  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const form = document.getElementById('editForm');

    form.querySelector('#edit-customer-id').value = button.getAttribute('data-customer_id') || '';
    form.querySelector('#edit-name').value = button.getAttribute('data-name') || '';
    form.querySelector('#edit-short_name').value = button.getAttribute('data-short_name') || '';
    form.querySelector('#edit-email').value = button.getAttribute('data-email') || '';
    form.querySelector('#edit-type').value = button.getAttribute('data-type') || '';
    form.querySelector('#edit-physical_address').value = button.getAttribute('data-physical_address') || '';
    form.querySelector('#edit-postal_address').value = button.getAttribute('data-postal_address') || '';
    form.querySelector('#edit-regno').value = button.getAttribute('data-reg_no') || '';
    form.querySelector('#edit-telno').value = button.getAttribute('data-tel_no') || '';
    form.querySelector('#edit-country').value = button.getAttribute('data-country') || '';
    form.querySelector('#edit-status').value = button.getAttribute('data-status') || '';
  });
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
  const deleteModal = document.getElementById('deleteModal');

  deleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const customerId = button.getAttribute('data-customer-id');
    const name = button.getAttribute('data-name');

    // Set form hidden input value
    document.querySelector('#deleteModal input[name="customer_id"]').value = customerId;

    // Optional: Show the name in confirmation text
    document.getElementById('deleteCustomerName').textContent = name;
  });
});
</script>




    <!-- END PAGE SCRIPTS -->
  </body>
</html>
