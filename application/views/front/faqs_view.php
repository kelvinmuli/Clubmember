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
          <li><a href="<?=base_url().'products-services';?>">Product & Services</a></li>
          <li><a href="<?=base_url().'pricing';?>">Pricing</a></li>
          <li><a href="<?=base_url().'blog';?>">Blog</a></li>
          <li><a href="<?=base_url().'book-a-demo';?>">Book a Demo</a></li>

         <!--  <div class="toggle-container">
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


 <section class="container my-5">
        <h2 class="fw-bold">FAQ</h2>
        <p class="text-left">Whether you're selling, renting, buying, or seeking property valuation services, we are here to assist you every step of the way.<br> Contact us today for exceptional real estate solutions.</p>
    </section>

    <div class="faq-container text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="accordion" id="faqAccordion1">

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">Questions</button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion1">
                                <div class="accordion-body">Answer goes here.</div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">Questions</button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion1">
                                <div class="accordion-body">Answer goes here.</div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">Questions</button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion1">
                                <div class="accordion-body">Answer goes here.</div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">Questions</button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion1">
                                <div class="accordion-body">Answer goes here.</div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">Questions</button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion1">
                                <div class="accordion-body">Answer goes here.</div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="accordion" id="faqAccordion2">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">Questions</button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion2">
                                <div class="accordion-body">Answer goes here.</div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">Questions</button>
                            </h2>
                            <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion2">
                                <div class="accordion-body">Answer goes here.</div>
                            </div>
                        </div>

                         <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">Questions</button>
                            </h2>
                            <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion2">
                                <div class="accordion-body">Answer goes here.</div>
                            </div>
                        </div>

                         <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">Questions</button>
                            </h2>
                            <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion2">
                                <div class="accordion-body">Answer goes here.</div>
                            </div>
                        </div>

                         <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq10">Questions</button>
                            </h2>
                            <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion2">
                                <div class="accordion-body">Answer goes here.</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="container my-5">
        <div class="row">

            <div class="col-md-4 mb-4">
                <div class="property-card-sub">
                    <img src="<?=base_url()?>assets/front/images/3209c69.png" alt="Property Image" class="property-img">
                    <div class="property-details">
                        <p><b>2-Bedroom | Vacant | City View | Chiller on DEWA</b></p>
                        <p><strong>$4,200,000</strong></p>
                        <p><i class="bi bi-geo-alt"></i> <b>Atlantis The Royal Residences, South Africa</b></p>
                        <p>Buy Own House Properties is delighted to present this large 7-bedroom villa plus</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>🛏 2</span>
                            <span>🛁 2</span>
                            <span><i class="bi bi-arrow-down-left-square-fill"></i> 2</span>
                            <button class="btn book-now">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Duplicate property cards as needed -->

            <div class="col-md-4 mb-4">
                <div class="property-card-sub">
                    <img src="<?=base_url()?>assets/front/images/06f5f6.jpg" alt="Property Image" class="property-img">
                    <div class="property-details">
                        <p><b>2-Bedroom | Vacant | City View | Chiller on DEWA</b></p>
                        <p><strong>$4,200,000</strong></p>
                        <p><i class="bi bi-geo-alt"></i> <b>Atlantis The Royal Residences, South Africa</b></p>
                        <p>Buy Own House Properties is delighted to present this large 7-bedroom villa plus</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>🛏 2</span>
                            <span>🛁 2</span>
                            <span><i class="bi bi-arrow-down-left-square-fill"></i> 2</span>
                            <button class="btn book-now">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>

             <div class="col-md-4 mb-4">
                <div class="property-card-sub">
                    <img src="<?=base_url()?>assets/front/images/cd001400.png" alt="Property Image" class="property-img">
                    <div class="property-details">
                        <p><b>2-Bedroom | Vacant | City View | Chiller on DEWA</b></p>
                        <p><strong>$4,200,000</strong></p>
                        <p><i class="bi bi-geo-alt"></i> <b>Atlantis The Royal Residences, South Africa</b></p>
                        <p>Buy Own House Properties is delighted to present this large 7-bedroom villa plus</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>🛏 2</span>
                            <span>🛁 2</span>
                            <span><i class="bi bi-arrow-down-left-square-fill"></i> 2</span>
                            <button class="btn book-now">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

<div class="row">
            <!-- Property Card Start -->
            <div class="col-md-4 mb-4">
                <div class="property-card-sub">
                    <img src="<?=base_url()?>assets/front/images/c59144984d4414.png" alt="Property Image" class="property-img">
                    <div class="property-details">
                        <p><b>2-Bedroom | Vacant | City View | Chiller on DEWA</b></p>
                        <p><strong>$4,200,000</strong></p>
                        <p><i class="bi bi-geo-alt"></i> <b>Atlantis The Royal Residences, South Africa</b></p>
                        <p>Buy Own House Properties is delighted to present this large 7-bedroom villa plus</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>🛏 2</span>
                            <span>🛁 2</span>
                            <span><i class="bi bi-arrow-down-left-square-fill"></i> 2</span>
                            <button class="btn book-now">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Duplicate property cards as needed -->

            <div class="col-md-4 mb-4">
                <div class="property-card-sub">
                    <img src="<?=base_url()?>assets/front/images/900c75ec2.png" alt="Property Image" class="property-img">
                    <div class="property-details">
                        <p><b>2-Bedroom | Vacant | City View | Chiller on DEWA</b></p>
                        <p><strong>$4,200,000</strong></p>
                        <p><i class="bi bi-geo-alt"></i> <b>Atlantis The Royal Residences, South Africa</b></p>
                        <p>Buy Own House Properties is delighted to present this large 7-bedroom villa plus</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>🛏 2</span>
                            <span>🛁 2</span>
                            <span><i class="bi bi-arrow-down-left-square-fill"></i> 2</span>
                            <button class="btn book-now">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>

             <div class="col-md-4 mb-4">
                <div class="property-card-sub">
                    <img src="<?=base_url()?>assets/front/images/1f47054777105.jpg" alt="Property Image" class="property-img">
                    <div class="property-details">
                        <p><b>2-Bedroom | Vacant | City View | Chiller on DEWA</b></p>
                        <p><strong>$4,200,000</strong></p>
                        <p><i class="bi bi-geo-alt"></i> <b>Atlantis The Royal Residences, South Africa</b></p>
                        <p>Buy Own House Properties is delighted to present this large 7-bedroom villa plus</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>🛏 2</span>
                            <span>🛁 2</span>
                            <span><i class="bi bi-arrow-down-left-square-fill"></i> 2</span>
                            <button class="btn book-now">Book Now</button>
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

