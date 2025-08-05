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
          <li><a href="<?=base_url().'blog';?>" class="active">Blog</a></li>
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

<section class="py-5">
  <div class="container text-center">
    <h4 class="mb-3">Blog</h4>

    <!-- Category Nav -->
    <div class="blog-nav mb-4">
      <button class="btn btn-light active">Home</button>
      <button class="btn btn-light">Popular</button>
      <button class="btn btn-light">Recent</button>
      <button class="btn btn-light">Top Picks</button>
      <button class="btn btn-light">Career</button>
      <button class="btn btn-light">Productivity</button>
      <button class="btn btn-light">Job Market</button>
      <button class="btn btn-light">Inspiration</button>
      <button class="btn btn-light">Entrepreneurship</button>
      <button class="btn btn-light">RA Introduction</button>
    </div>

    <!-- Blog Title -->
    <h5 class="fw-medium mb-2">Recruiters Africa platform and we’ll connect you with</h5>
    <h5 class="fw-medium mb-3">employers looking for your specific talents.</h5>
    <p class="text-muted mb-5 text-center">100% guaranteed complete satisfaction with our proven process</p>

    <!-- Search Bar -->
    <div class="search-bar mb-5">
      <div class="row">
        <div class="col-md-6">
          <input type="text" class="form-control" placeholder="Keyword">
        </div>
        <div class="col-md-5">
          <input type="text" class="form-control" placeholder="Category">
        </div>
        <div class="col-md-1">
          <button class="btn btn-warning"><i class="bi bi-search"></i></button>
        </div>
      </div>
    </div>



    <!-- Blog Cards -->
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card card-custom custom-card h-100">
          <div class="card-body">
            <h6 class="fw-bold text-left">Why Should Jobseekers<br> Choose Recruiters Africa?</h6>
            <p class="text-muted">On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons. On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons.</p>
            <a href="#" class="read-more">Read All <i class="bi bi-arrow-up-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card card-custom custom-card h-100">
          <div class="card-body">
            <h6 class="fw-bold text-left">Why Should Jobseekers<br> Choose Recruiters Africa?</h6>
            <p class="text-muted">On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons. On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons.</p>
            <a href="#" class="read-more">Read All <i class="bi bi-arrow-up-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card card-custom custom-card h-100">
          <div class="card-body">
            <h6 class="fw-bold text-left">Why Should Jobseekers<br> Choose Recruiters Africa?</h6>
            <p class="text-muted">On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons. On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons.</p>
            <a href="#" class="read-more">Read All <i class="bi bi-arrow-up-right"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card card-custom custom-card h-100">
          <div class="card-body">
            <h6 class="fw-bold text-left">Why Should Jobseekers<br> Choose Recruiters Africa?</h6>
            <p class="text-muted">On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons. On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons.</p>
            <a href="#" class="read-more">Read All <i class="bi bi-arrow-up-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card card-custom custom-card h-100">
          <div class="card-body">
            <h6 class="fw-bold text-left">Why Should Jobseekers<br> Choose Recruiters Africa?</h6>
            <p class="text-muted">On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons. On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons.</p>
            <a href="#" class="read-more">Read All <i class="bi bi-arrow-up-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card card-custom custom-card h-100">
          <div class="card-body">
            <h6 class="fw-bold text-left">Why Should Jobseekers<br> Choose Recruiters Africa?</h6>
            <p class="text-muted">On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons. On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons.</p>
            <a href="#" class="read-more">Read All <i class="bi bi-arrow-up-right"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card card-custom custom-card h-100">
          <div class="card-body">
            <h6 class="fw-bold text-left">Why Should Jobseekers<br> Choose Recruiters Africa?</h6>
            <p class="text-muted">On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons. On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons.</p>
            <a href="#" class="read-more">Read All <i class="bi bi-arrow-up-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card card-custom custom-card h-100">
          <div class="card-body">
            <h6 class="fw-bold text-left">Why Should Jobseekers<br> Choose Recruiters Africa?</h6>
            <p class="text-muted">On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons. On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons.</p>
            <a href="#" class="read-more">Read All <i class="bi bi-arrow-up-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card card-custom custom-card h-100">
          <div class="card-body">
            <h6 class="fw-bold text-left">Why Should Jobseekers<br> Choose Recruiters Africa?</h6>
            <p class="text-muted">On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons. On your PC or a mobile device, watch video lectures whenever you choose. Learn your preferred material through in-depth lessons.</p>
            <a href="#" class="read-more">Read All <i class="bi bi-arrow-up-right"></i></a>
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

