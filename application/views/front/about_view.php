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
          <li><a href="<?=base_url().'about';?>" class="active">About</a></li>
          <li><a href="<?=base_url().'properties';?>">Properties</a></li>
          <li><a href="<?=base_url().'products-services';?>">Product & Services</a></li>
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
            <h2 class="text-center fw-bold">Westminister Tenant Management</h2>
            <p class="text-center">
                At Buy Own House Properties, we understand that buying, selling, or investing in property is a significant decision.
                That's why we are committed to providing exceptional service, personalized attention, and expert guidance to ensure
                your real estate journey is a seamless and rewarding experience. Our agency takes pride in our extensive knowledge
                of the local market. Whether you are looking for a dream home, a lucrative investment opportunity, or seeking to
                sell your property at the best possible price, we have the expertise and resources to meet your goals.
            </p>
            <div class="text-center arrow mt-3">↓</div><br>
        </div>

            <!-- Additional Info -->
            <div class="row">
            <div class="col-md-6">
                <img src="<?=base_url()?>assets/front/images/92c3ea994af9cf2cee3d64bfdf8b098d.png" alt="Property Image" class="property-image-about">

            </div>
            <div class="col-md-6">
                <h2>About Us</h2>
                    <p>
                        At Buy Own House Properties, we understand that buying, selling, or investing in property is a significant decision. That's why we are committed to providing exceptional service, personalized attention, and expert guidance to ensure your real estate journey is a seamless and rewarding experience. Our agency takes pride in our extensive knowledge of the local market. Whether you are looking for a dream home, a lucrative investment opportunity, or seeking to sell your property at the best possible price, we have the expertise and resources to meet your goals.
                    </p>
                    <br>
                    <p>
                       At Buy Own House Properties, we understand that buying, selling, or investing in property is a significant decision. That's why we are committed to providing exceptional service, personalized attention, and expert guidance to ensure your real estate journey is a seamless and rewarding experience. Our agency takes pride in our extensive knowledge of the local market. Whether you are looking for a dream home, a lucrative investment opportunity, or seeking to sell your property at the best possible price, we have the expertise and resources to meet your goals.
                    </p>
            </div>
        </div>
            <div class="row mt-4-about">
                <div class="about-count col-md-3">
                    <div class="stats-box text-center p-4">
                      <br>
                        <h3>500K</h3>
                        <p>Daily Active Users</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <img src="<?=base_url()?>assets/front/images/about2.png" class="img-fluid rounded shadow" alt="Meeting Image">
                </div>
            </div>
        </div>
    </section>



  <div class="container my-5">
        <!-- Stats Section -->
        <div class="row text-center stats-bordered">
            <div class="col-md-3 stats-box">
                <h6>PRODUCT</h6>
                <h4><strong>10,000+</strong></h4>
            </div>
            <div class="col-md-3 stats-box">
                <h6>LIKES</h6>
                <h4><strong>45600</strong></h4>
            </div>
            <div class="col-md-3 stats-box">
                <h6>SALE</h6>
                <h4><strong>576864</strong></h4>
            </div>
            <div class="col-md-3 stats-box">
                <h6>CUSTOMERS</h6>
                <h4><strong>947444</strong></h4>
            </div>
        </div>
<br><br>
        <!-- Our Team Section -->
         <div class="row">
           <div class="col-md-6">
                <h2>Our Team</h2>
                    <p>
                        At Buy Own House Properties, we understand that buying, selling, or investing in property is a significant decision. That's why we are committed to providing exceptional service, personalized attention, and expert guidance to ensure your real estate journey is a seamless and rewarding experience. Our agency takes pride in our extensive knowledge of the local market. Whether you are looking for a dream home, a lucrative investment opportunity, or seeking to sell your property at the best possible price, we have the expertise and resources to meet your goals.
                    </p>
                    <p>
                       At Buy Own House Properties, we understand that buying, selling, or investing in property is a significant decision. That's why we are committed to providing exceptional service, personalized attention, and expert guidance to ensure your real estate journey is a seamless and rewarding e
                    </p>
            </div>
            <div class="col-md-6">
                <div class="row">
                <div class="col-md-6">
                    <img src="<?=base_url()?>assets/front/images/team1.png" class="img-team" alt="Team Image 1">
                </div>
                <div class="col-md-6">
                    <img src="<?=base_url()?>assets/front/images/team2.png" class="img-team" alt="Team Image 2">
                </div>
            </div>

            </div>

        </div>
    </div>


       <div class="container py-5">
      <div class="row">
            <div class="col-md-6">
                <img src="<?=base_url()?>assets/front/images/458cdbe0f99bb75a8403d06035dc73d3.jpg" alt="Property Image" class="property-image-about-section">

            </div>
            <div class="col-md-6">
                <h2>Property Management</h2>
                    <p>
                        BuyOwn House Property offers professional and reliable property management services to help property owners maximize their investments and ensure a hassle-free experience. Whether you own residential, commercial, or mixed-use properties, our dedicated team is here to provide exceptional service and peace of mind.
                    </p>
                    <div class="container mt-4">
                      <ul class="service-list">
                          <li><i class="bi bi-check-circle"></i> Handover</li>
                          <li><i class="bi bi-check-circle"></i> Premium Marketing</li>
                          <li><i class="bi bi-check-circle"></i> Tenant Acquisition & Screening</li>
                          <li><i class="bi bi-check-circle"></i> Rent Collection</li>
                          <li><i class="bi bi-check-circle"></i> Higher Rentals</li>
                          <li><i class="bi bi-check-circle"></i> Optimized Occupancy</li>
                          <li><i class="bi bi-check-circle"></i> Property Inspections</li>
                          <li><i class="bi bi-check-circle"></i> Comprehensive Reporting</li>
                      </ul>
                  </div>

            </div>
        </div>
      </div>



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

