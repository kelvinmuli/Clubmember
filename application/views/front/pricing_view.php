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
          <li><a href="<?=base_url().'pricing';?>" class="active">Pricing</a></li>
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

<section>
  <div class="container">
            <div class="container">
            <h2 class="text-center fw-bold">Westminister Tenant Management</h2>
            <p class="text-center">
                At Buy Own House Properties, we understand that buying, selling, or investing in property is a significant decision. That's why we are committed to providing exceptional service, personalized attention, and expert guidance to ensure your real estate journey is a seamless and rewarding experience. Our agency takes pride in our extensive knowledge of the local market. Whether you are looking for a dream home, a lucrative investment opportunity, or seeking to sell your property at the best possible price, we have the expertise and resources to meet your goals.
            </p>
            <div class="text-center arrow mt-3">↓</div><br>
        </div>

  <div class="container-fluid px-0">
  <div class="row">
  <!-- Features Column -->
  <div class="col-md-3 feature-list">
    <h5 class="text-center feature-pricing">Features</h5>
    <div class="feature-item">Dashboard and analytics</div>
    <div class="feature-item">Internal communication</div>
    <div class="feature-item">User & role management</div>
    <div class="feature-item">Client leads</div>
    <div class="feature-item">Online payments</div>
    <div class="feature-item">e-Signature</div>
    <div class="feature-item">Reports</div>
    <div class="feature-item">Lease management</div>
    <div class="feature-item">Requests</div>
    <div class="feature-item">Accounting</div>
    <div class="feature-item">Service tracking</div>
    <div class="feature-item">Documents</div>
  </div>

  <!-- Plans Columns -->
  <div class="col-md-9">
    <div class="row row-cols-1 row-cols-md-3 g-0 row-bordered" id="plan-container">
      <!-- Plan 1 -->
      <div class="col">
        <div class="plan">
          <h6 class="text-left">Free</h6>
          <div class="price text-left">$0</div>
          <p class="small text-left">Lorem ipsum is a dummy or placeholder text commonly used in graphic design, publishing,</p>
          <button class="btn btn-dark-pricing btn-sm">Get Started</button>
        </div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-times cross-icon"></i></div>
        <div class="compare-row"><i class="fa fa-times cross-icon"></i></div>
        <div class="compare-row"><i class="fa fa-times cross-icon"></i></div>
      </div>

      <!-- Plan 2 -->
      <div class="col">
        <div class="plan">
          <h6 class="text-left">Starter Basic Plan</h6>
          <div class="price text-left">$50</div>
          <p class="small text-left">Lorem ipsum is a dummy or placeholder text commonly used in graphic design, publishing,</p>
          <button class="btn btn-dark-pricing btn-sm">Get Started</button>
        </div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-times cross-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
      </div>

      <!-- Plan 3 -->
      <div class="col">
        <div class="plan">
          <h6 class="text-left">Starter Pro Plan</h6>
          <div class="price text-left">$80</div>
          <p class="small text-left">Lorem ipsum is a dummy or placeholder text commonly used in graphic design, publishing,</p>
          <button class="btn btn-dark-pricing btn-sm">Get Started</button>
        </div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
      </div>

      <!-- Plan 4 -->
      <div class="col">
        <div class="plan">
          <h6 class="text-left">Premium Plan</h6>
          <div class="price text-left">$120</div>
          <p class="small text-left">Lorem ipsum is a dummy or placeholder text commonly used in graphic design, publishing,</p>
          <button class="btn btn-dark-pricing btn-sm">Get Started</button>
        </div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
      </div>

      <!-- Plan 5 -->
      <div class="col">
        <div class="plan">
          <h6 class="text-left">Enterprise Plan</h6>
          <div class="price text-left">$200</div>
          <p class="small text-left">Lorem ipsum is a dummy or placeholder text commonly used in graphic design, publishing,</p>
          <button class="btn btn-dark-pricing btn-sm">Get Started</button>
        </div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
        <div class="compare-row"><i class="fa fa-check check-icon"></i></div>
      </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="text-center my-3">
      <button id="prevBtn" class="btn btn-secondary btn-sm">&laquo; Prev</button>
      <button id="nextBtn" class="btn btn-secondary btn-sm">Next &raquo;</button>
    </div>
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

