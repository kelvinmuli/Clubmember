<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Tenant Management</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="<?=base_url()?>assets/front/img/favicon.png" rel="icon">
  <link href="<?=base_url()?>assets/front/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->

  <!-- Vendor CSS Files -->
  <link href="<?=base_url()?>assets/front/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/front/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/front/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/front/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/front/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/front/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">


  <link href="<?=base_url()?>assets/front/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

 <div class="top-bar">
        <div class="contact-info">

        </div>
        <div class="user-options">
            <span><i class="fa fa-phone"></i>&nbsp; +254-214-2298</span> &nbsp;&nbsp;
            <span><i class="fa fa-envelope"></i>&nbsp; support@wtm.com</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fa fa-user"></i>&nbsp; Login</a> |
            <a href="<?=base_url().'sign-up';?>">Sign Up</a> &nbsp;&nbsp;
        <span>
            Currency:
            <select>
                <option>Dollar</option>
                <option>Euro</option>
            </select>
        </span>
        </div>
    </div>

  <header id="header" class="header d-flex align-items-center fixed-top header-main">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="<?=base_url().'';?>" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="<?=base_url()?>assets/front/img/logo.png" alt="">
        <!-- <h1 class="sitename">Logis</h1> -->
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="<?=base_url().'';?>">Home<br></a></li>
          <li><a href="<?=base_url().'about';?>">About</a></li>
          <li><a href="<?=base_url().'properties';?>">Properties</a></li>
          <li><a href="<?=base_url().'products-services';?>" class="active">Product & Services</a></li>
          <li><a href="<?=base_url().'pricing';?>">Pricing</a></li>
          <li><a href="<?=base_url().'blog';?>">Blog</a></li>
          <li><a href="<?=base_url().'book-a-demo';?>">Book a Demo</a></li>

          <!-- <div class="toggle-container">
    <div class="toggle-button">
        <input type="radio" id="customer" name="toggle" checked>
        <label for="customer" class="toggle-option">Customer</label>

        <input type="radio" id="owner" name="toggle">
        <label for="owner" class="toggle-option">Owner</label>

        <div class="toggle-slider"></div>
    </div>
</div> -->
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">



     <!-- About Us Section -->
    <section class="about-us py-5">
        <div class="container">
            <div class="container">
            <h2 class="text-center fw-bold">Product & Services</h2>
            <p class="text-center">
                Elevate your property management experience with a cutting-edge, AI-powered system designed to transform daily operations into a streamlined, intelligent workflow. Our platform harnesses the latest in artificial intelligence to empower your team, reduce manual tasks, and deliver actionable insights that drive success.
            </p>
            <div class="text-center arrow mt-3">↓</div><br>
        </div>

            <!-- Additional Info -->
           <!--  <div class="row">
            <div class="col-md-6">
                <img src="<?=base_url()?>assets/front/images/90f71be182d.png" alt="Property Image" class="property-image-product">

            </div>
            <div class="col-md-6">
                <h2>Features</h2>
                    <p>
                        BuyOwn House Property offers professional and reliable property management services to help property owners maximize their investments and ensure a hassle-free experience. Whether you own residential, commercial, or mixed-use properties, our dedicated team is here to provide exceptional service and peace of mind.
                    </p>
                    <div class="container mt-4">
                      <ul class="service-list">
                          <li><i class="bi bi-check-circle"></i> Self service portal</li>
                          <li><i class="bi bi-check-circle"></i> Automated workflows</li>
                          <li><i class="bi bi-check-circle"></i> Property Management</li>
                          <li><i class="bi bi-check-circle"></i> Maintenance request processing</li>
                          <li><i class="bi bi-check-circle"></i> Lease & Contract Management</li>
                          <li><i class="bi bi-check-circle"></i> Vendor management</li>
                          <li><i class="bi bi-check-circle"></i> Document Management</li>
                          <li><i class="bi bi-check-circle"></i> Be an agent</li>
                          <li><i class="bi bi-check-circle"></i> Team Finance</li>
                          <li><i class="bi bi-check-circle"></i> Legal and compliance management</li>
                          <li><i class="bi bi-check-circle"></i> User Management</li>
                      </ul>
                  </div>
            </div>
        </div> -->

        </div>
    </section>

    <!-- <section>
      <div class="container">
    <div class="row justify-content-center align-items-center text-center" style="flex-wrap: nowrap;">
      <div class="col-6 col-md-3">
        <div class="stat-wrapper">
          <div class="stat-number">108</div>
          <div class="stat-label">Projects</div>
        </div>
      </div>

      <div class="col-auto d-none d-md-block">
        <div class="divider"></div>
      </div>

      <div class="col-6 col-md-3">
        <div class="stat-wrapper">
          <div class="stat-number">165</div>
          <div class="stat-label">People</div>
        </div>
      </div>

      <div class="col-auto d-none d-md-block">
        <div class="divider"></div>
      </div>

      <div class="col-6 col-md-3 mt-4 mt-md-0">
        <div class="stat-wrapper">
          <div class="stat-number">10</div>
          <div class="stat-label">Years</div>
        </div>
      </div>

      <div class="col-auto d-none d-md-block">
        <div class="divider"></div>
      </div>

      <div class="col-6 col-md-3 mt-4 mt-md-0">
        <div class="stat-wrapper">
          <div class="stat-number">15</div>
          <div class="stat-label">Offices</div>
        </div>
      </div>
    </div>
  </div>
    </section> -->



<section class="features-container text-center" style="background-color: #0D263B;">
    <div class="container">
      <p class="mb-1 text-white">Westminister Tenant Management</p>
      <h2 class="section-title text-white">Our Key Features</h2>
      <p class="mx-auto mb-5 text-center" style="max-width: 750px; color: #fff !important;">
        Elevate your property management experience with a cutting-edge, AI-powered system designed to transform daily operations into a streamlined, intelligent workflow. Our platform harnesses the latest in artificial intelligence to empower your team, reduce manual tasks, and deliver actionable insights that drive success.
      </p>

      <div class="row justify-content-center">
        <div class="col-md-3 col-6 feature-item">
          <div class="feature-icon"><i class="bi bi-person"></i></div>
          <div class="feature-title">Title here</div>
          <div class="feature-desc">
            Elevate your property management experience with a cutting-edge, AI-powered system designed to transform daily operations into a streamlined, in
          </div>
        </div>

        <div class="col-md-3 col-6 feature-item">
          <div class="feature-icon"><i class="bi bi-chat-dots"></i></div>
          <div class="feature-title">Title here</div>
          <div class="feature-desc">
            Elevate your property management experience with a cutting-edge, AI-powered system designed to transform daily operations into a streamlined, in
          </div>
        </div>

        <div class="col-md-3 col-6 feature-item mt-4 mt-md-0">
          <div class="feature-icon"><i class="bi bi-graph-up"></i></div>
          <div class="feature-title">Title here</div>
          <div class="feature-desc">
            Elevate your property management experience with a cutting-edge, AI-powered system designed to transform daily operations into a streamlined, in
          </div>
        </div>

        <div class="col-md-3 col-6 feature-item mt-4 mt-md-0">
          <div class="feature-icon"><i class="bi bi-briefcase"></i></div>
          <div class="feature-title">Title here</div>
          <div class="feature-desc">
            Elevate your property management experience with a cutting-edge, AI-powered system designed to transform daily operations into a streamlined, in
          </div>
        </div>
      </div>

     <div class="container">
      <div class="row">
        <div class="col-md-6 mb-3">
                <div class="product-services-card p-3">
                   <h2 class="text-left color-yellow color-yellow-size">Tenant & Lease Management</h2>
                   <p class="text-left text-white"><strong>Manages lease agreements, tenant records, renewals, and occupancy status.</strong></p>
                   <ul class="text-left text-white">
                      <li>Tenants: View lease terms, request renewals, update personal info.</li>
                      <li>Property Managers: Track lease expirations, renewals, and tenant records.</li>
                      <li>Leasing Agents: Handle new lease agreements and tenant onboarding.</li>
                      <li>Landlords: Monitor lease statuses and property occupancy.</li>
                      <li>Legal & Compliance Officers: Ensure lease agreements meet legal standards.</li>
                   </ul>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="product-services-card p-3">
                   <h2 class="text-left color-yellow color-yellow-size">Tenant & Lease Management</h2>
                   <p class="text-left text-white"><strong>Manages lease agreements, tenant records, renewals, and occupancy status.</strong></p>
                   <ul class="text-left text-white">
                      <li>Tenants: View lease terms, request renewals, update personal info.</li>
                      <li>Property Managers: Track lease expirations, renewals, and tenant records.</li>
                      <li>Leasing Agents: Handle new lease agreements and tenant onboarding.</li>
                      <li>Landlords: Monitor lease statuses and property occupancy.</li>
                      <li>Legal & Compliance Officers: Ensure lease agreements meet legal standards.</li>
                   </ul>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="product-services-card p-3">
                   <h2 class="text-left color-yellow color-yellow-size">Tenant & Lease Management</h2>
                   <p class="text-left text-white"><strong>Manages lease agreements, tenant records, renewals, and occupancy status.</strong></p>
                   <ul class="text-left text-white">
                      <li>Tenants: View lease terms, request renewals, update personal info.</li>
                      <li>Property Managers: Track lease expirations, renewals, and tenant records.</li>
                      <li>Leasing Agents: Handle new lease agreements and tenant onboarding.</li>
                      <li>Landlords: Monitor lease statuses and property occupancy.</li>
                      <li>Legal & Compliance Officers: Ensure lease agreements meet legal standards.</li>
                   </ul>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="product-services-card p-3">
                   <h2 class="text-left color-yellow color-yellow-size">Tenant & Lease Management</h2>
                   <p class="text-left text-white"><strong>Manages lease agreements, tenant records, renewals, and occupancy status.</strong></p>
                   <ul class="text-left text-white">
                      <li>Tenants: View lease terms, request renewals, update personal info.</li>
                      <li>Property Managers: Track lease expirations, renewals, and tenant records.</li>
                      <li>Leasing Agents: Handle new lease agreements and tenant onboarding.</li>
                      <li>Landlords: Monitor lease statuses and property occupancy.</li>
                      <li>Legal & Compliance Officers: Ensure lease agreements meet legal standards.</li>
                   </ul>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="product-services-card p-3">
                   <h2 class="text-left color-yellow color-yellow-size">Tenant & Lease Management</h2>
                   <p class="text-left text-white"><strong>Manages lease agreements, tenant records, renewals, and occupancy status.</strong></p>
                   <ul class="text-left text-white">
                      <li>Tenants: View lease terms, request renewals, update personal info.</li>
                      <li>Property Managers: Track lease expirations, renewals, and tenant records.</li>
                      <li>Leasing Agents: Handle new lease agreements and tenant onboarding.</li>
                      <li>Landlords: Monitor lease statuses and property occupancy.</li>
                      <li>Legal & Compliance Officers: Ensure lease agreements meet legal standards.</li>
                   </ul>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="product-services-card p-3">
                   <h2 class="text-left color-yellow color-yellow-size">Tenant & Lease Management</h2>
                   <p class="text-left text-white"><strong>Manages lease agreements, tenant records, renewals, and occupancy status.</strong></p>
                   <ul class="text-left text-white">
                      <li>Tenants: View lease terms, request renewals, update personal info.</li>
                      <li>Property Managers: Track lease expirations, renewals, and tenant records.</li>
                      <li>Leasing Agents: Handle new lease agreements and tenant onboarding.</li>
                      <li>Landlords: Monitor lease statuses and property occupancy.</li>
                      <li>Legal & Compliance Officers: Ensure lease agreements meet legal standards.</li>
                   </ul>
                </div>
            </div>

      </div>
    </div>


    </div>
  </section>


<section>
  <div class="container">
    <div class="section-title mb-4">
      <h2 class="text-center text-muted">Explore Our Complete Features</h2>
    </div>

    <div class="accordion" id="featuresAccordion">

      <!-- Self service portal -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
            Self service portal
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show body-style-acc" data-bs-parent="#featuresAccordion">
          <div class="container mt-4">
            <h2 class="text-white body-style-title">Self service portal</h2>
            <ul class="service-list">
              <li><i class="bi bi-check-circle"></i> Personalized dashboards with analytics for performance monitoring (Customizable)</li>
              <li><i class="bi bi-check-circle"></i> Detailed view of lease details, payment history, and community announcements</li>
              <li><i class="bi bi-check-circle"></i> Easy-to-update personal and contact information</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Other sections -->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
            Automated workflows
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#featuresAccordion">
          <div class="accordion-body">
            <p>Details about Automated workflows.</p>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
            Property Management
          </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#featuresAccordion">
          <div class="accordion-body">
            <p>Details about Property Management.</p>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
            Maintenance request processing
          </button>
        </h2>
        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#featuresAccordion">
          <div class="accordion-body">
            <p>Details about Maintenance request processing.</p>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
            Lease & Contract Management
          </button>
        </h2>
        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#featuresAccordion">
          <div class="accordion-body">
            <p>Details about Lease & Contract Management.</p>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
            Vendor management
          </button>
        </h2>
        <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#featuresAccordion">
          <div class="accordion-body">
            <p>Details about Vendor management.</p>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven">
            Document Management
          </button>
        </h2>
        <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#featuresAccordion">
          <div class="accordion-body">
            <p>Details about Document Management.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="newsletter-section">
        <div class="container">
            <div class="row align-items-center">
                 <div class="col-md-2">
                 </div>
                <div class="col-md-4">
                    <h2 class="newsletter-title">Join Our Newsletter Now</h2>
                    <p>Register now to get updates on promotions.</p>
                </div>
                <div class="col-md-4">
                    <form class="newsletter-form">
                        <input type="email" class="form-control newsletter-input" placeholder="Enter Your Email To Subscribe." required>
                        <button type="submit" class="newsletter-button">SUBSCRIBE</button>
                    </form>
                </div>
                <div class="col-md-2">
                 </div>
            </div>
        </div>
    </section>


          <!--Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Log In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="abc@gmail.com">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password">
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <input type="checkbox" id="rememberMe">
                                <label for="rememberMe">Remember me</label>
                            </div>
                            <a href="#">Forgot Password?</a>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-warning w-100">Log In</button>
                        </div>
                        <p class="text-center">or</p>
                        <div class="mt-3 d-flex gap-2">
                            <button class="btn w-50 border bg-white d-flex align-items-center justify-content-center">
                                <i class="fab fa-facebook-f text-primary me-2"></i> Sign in with Facebook
                            </button>
                            <button class="btn w-50 border bg-white d-flex align-items-center justify-content-center">
                                <i class="fab fa-google text-danger me-2"></i> Sign in with Google
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Login Modal -->


         <!-- Sign Up Modal -->
    <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName" placeholder="Enter your full name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phoneNumber" placeholder="Enter your phone number">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Enter your address">
                        </div>
                        <div class="mb-3">
                            <label for="preferredContact" class="form-label">Preferred Contact Method</label>
                            <input type="text" class="form-control" id="preferredContact" placeholder="Enter preferred contact method">
                        </div>
                        <div class="mb-3">
                            <label for="userName" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="userName" placeholder="Enter your username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your password">
                        </div>
                        <div class="mb-3">
                            <label for="userType" class="form-label">Type Of User</label>
                            <input type="text" class="form-control" id="userType" placeholder="Enter user type">
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of sign up modal -->




  </main>

