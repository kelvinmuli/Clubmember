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
          <li><a href="<?=base_url().'properties';?>" class="active">Properties</a></li>
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


 <section>
      <div class="container mt-4">
        <h2><strong>Exclusive</strong> | <strong>high floor</strong> | <strong>city view</strong> | near metro</h2>
        <p>Whether you're selling, renting, buying, or seeking property valuation services, we are here to assist you every step of the way. Contact us today for exceptional real estate solutions.</p>

        <div class="row">
            <div class="col-md-8">
                <img src="<?=base_url()?>assets/front/images/80ac9.png" alt="Property Image" class="property-image">
                <div class="d-flex mt-2">
                    <img src="<?=base_url()?>assets/front/images/80ac9.png" class="me-2" width="80" height="50">
                    <img src="<?=base_url()?>assets/front/images/a215cc021b7a138d2507c8909a432e51.png" class="me-2" width="80" height="50">
                    <img src="<?=base_url()?>assets/front/images/02bd6eaded6f15ecf88b8186aab9a80d.png" class="me-2" width="80" height="50">
                    <img src="<?=base_url()?>assets/front/images/80ac9.png" width="80" height="50">
                    <img src="<?=base_url()?>assets/front/images/80ac9.png" class="me-2" width="80" height="50">
                    <img src="<?=base_url()?>assets/front/images/a215cc021b7a138d2507c8909a432e51.png" class="me-2" width="80" height="50">
                    <img src="<?=base_url()?>assets/front/images/02bd6eaded6f15ecf88b8186aab9a80d.png" class="me-2" width="80" height="50">
                    <img src="<?=base_url()?>assets/front/images/80ac9.png" width="80" height="50">
                </div>
            </div>
            <div class="col-md-4">
                <div class="agent-card mb-3">
                    <div class="d-flex align-items-center">
                        <img src="<?=base_url()?>assets/front/images/4017f604d965879cd4907df8f7fab3c1.png" alt="Agent" class="agent-image me-2">
                        <div>
                            <h6 class="mb-0">Dilshod Madaminov</h6>
                            <small>+2670 539 4892</small>
                        </div>
                    </div>
                    <div class="mt-2 d-flex">
                        <button class="btn btn-primary btn-sm me-2">Email</button>
                        <button class="btn btn-warning btn-sm">WhatsApp</button>
                    </div>
                </div>

                <div class="contact-form">
                    <label class="form-label">Label</label>
                    <input type="text" class="form-control" placeholder="John Doe">

                    <label class="form-label">Label</label>
                    <select class="form-select">
                        <option>John Doe</option>
                    </select>

                    <label class="form-label">Label</label>
                    <textarea class="form-control" placeholder="John Doe"></textarea>

                    <button class="btn btn-warning w-100 mt-2">Send Message</button>
                </div>
            </div>
        </div>
    </div>



    <div class="container mt-4">
        <h4>Exclusive | high floor | city view | near metro</h4>
        <p class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734; 4.5</p>
        <h3 class="text-primary">$150 <span class="text-strikethrough">$180</span></h3>
        <p>BuyOwn House Properties is pleased to present this 2-Bedroom Apartment in Al Furjan, Jebal Ali Village, Equiti Residence...</p>

        <div class="mt-4">
            <h5>Details</h5>
            <div class="row details-section">
                <div class="col-md-6">
                    <h6>Property type</h6>
                    <p>Condominium</p>
                    <h6>Furnishing</h6>
                    <p>Fully furnished</p>
                    <h6>Cost per square foot</h6>
                    <p>S$1,429 psf</p>
                    <h6>Developer</h6>
                    <p>United Property Holdings Pte Ltd</p>
                    <h6>Total units</h6>
                    <p>300</p>
                    <h6>Listing date</h6>
                    <p>16 Sept 2024</p>
                </div>
                <div class="col-md-6">
                    <h6>Floor Size</h6>
                    <p>1,119 sqft</p>
                    <h6>Floor Level</h6>
                    <p>19th Floor</p>
                    <h6>Tenant</h6>
                    <p>Until 27 Nov 2024</p>
                    <h6>TOP</h6>
                    <p>Dec 2022</p>
                    <h6>Tenure</h6>
                    <p>99 year leasehold</p>
                    <h6>Listing ID</h6>
                    <p>210271231</p>
                </div>
            </div>
        </div>

        <div class="mt-4 p-3 border rounded">
            <h6>Project reviews</h6>
            <p class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734; 4 stars</p>
            <button class="btn btn-outline-primary">View 16 reviews</button>
        </div>
    </div>

     <div class="container mt-5">
        <h3>Amenities</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="amenities-box">
                    <h5>Unit features</h5>
                   <ul class="service-list mt-4">
                          <li><i class="bi bi-check-circle"></i> 3 Bedrooms</li>
                          <li><i class="bi bi-check-circle"></i> Balcony</li>
                          <li><i class="bi bi-check-circle"></i> Store room</li>
                          <li><i class="bi bi-check-circle"></i> 2 Baths</li>
                          <li><i class="bi bi-check-circle"></i> Air-conditioning</li>
                          <li><i class="bi bi-check-circle"></i> Fully equipped Kitchen</li>
                      </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="amenities-box">
                    <h5>Facilities</h5>
                   <ul class="service-list mt-4">
                          <li><i class="bi bi-check-circle"></i> Carpark</li>
                          <li><i class="bi bi-check-circle"></i> Swimming Pool</li>
                          <li><i class="bi bi-check-circle"></i> BBQ Pits</li>
                          <li><i class="bi bi-check-circle"></i> Kid’s Pool</li>
                          <li><i class="bi bi-check-circle"></i> Gym</li>
                          <li><i class="bi bi-check-circle"></i> Function rooms</li>
                      </ul>
                </div>
            </div>
        </div>

        <h3 class="mt-5">Location</h3>
        <ul class="nav nav-tabs location-tabs">
            <li class="nav-item"><a class="nav-link active" href="#">Commute</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Schools</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Supermarkets</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Parks</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Clinics</a></li>
        </ul>
        <div class="input-group my-3">
            <input type="text" class="form-control" placeholder="Search address to calculate travel time">
            <button class="btn btn-dark" type="button">&#128269;</button>
        </div>

        <img src="<?=base_url()?>assets/front/images/179cb746f55a807991590cbb5e1260e4.png" class="img-fluid property-image-about-section property-image-about-map-section" alt="Map">

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="amenities-box">
                    <h6>Nearby MRT</h6>
                    <p><span class="badge bg-success">EW23</span> Clementi MRT</p>
                    <p>1.3 km | 10 mins walk</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="amenities-box">
                    <h6>Bus Interchange</h6>
                    <p>Clementi Bus Interchange</p>
                    <p>1.3 km | 10 mins walk</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h2>Mortgage</h2>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Property Price</label>
                <input type="text" class="form-control" value="S$ 1,600,000.00">
            </div>
            <div class="col-md-6">
                <label class="form-label">Loan amount</label>
                <input type="text" class="form-control" value="S$ 1,200,000.00">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Interest rate</label>
                <div class="input-group">
                    <input type="text" class="form-control" value="4.00%">
                    <a href="#" class="input-group-text text-primary">Apply today’s best rate</a>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Loan Tenure</label>
                <input type="text" class="form-control" value="20 Years">
            </div>
        </div>
        <button class="btn btn-dark w-100">Calculate mortgage costs</button><br>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card p-3">
                    <h5>Mortgage breakdown</h5>
                    <p><strong>Estimated monthly repayment</strong></p>
                    <h4>S$7,271.76/month</h4>
                    <div class="progress mt-3">
                        <div class="progress-bar progress-bar-principal" style="width: 45%">45%</div>
                        <div class="progress-bar progress-bar-interest" style="width: 55%">55%</div>
                    </div>
                    <p class="mt-2">• Principal: S$3,271.76 &nbsp; • Interest: S$3,271.76</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3">
                    <h5>Upfront costs</h5>
                    <p><strong>Total downpayment</strong></p>
                    <h4>S$400,000.00</h4>
                    <div class="progress mt-3">
                        <div class="progress-bar progress-bar-principal" style="width: 25%">25%</div>
                        <div class="progress-bar progress-bar-interest" style="width: 75%">75%</div>
                    </div>
                    <p class="mt-2">• Downpayment &nbsp; • S$1,200,000 Loan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Similar listings</h4>
            <a href="#" class="text-decoration-none">View more →</a>
        </div>
       <div class="row">
            <!-- Property Card Start -->
            <div class="col-md-4 mb-4">
                <div class="property-card-sub">
                    <img src="<?=base_url()?>assets/front/images/cc5938265f508c06f5f6.jpg" alt="Property Image" class="property-img">
                    <div class="property-details">
                        <p><b>2-Bedroom | Vacant | City View | Chiller on DEWA</b></p>
                        <p><strong>$4,200,000</strong></p>
                        <p><i class="bi bi-geo-alt"></i> <b>Atlantis The Royal Residences, South Africa</b></p>
                        <p>Buy Own House Properties is delighted to present this large 7-bedroom villa plus</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>🛏 2</span>
                            <span>🛁 2</span>
                            <span><i class="bi bi-arrow-down-left-square-fill"></i> 2</span>
                             <button class="btn book-now"><a href="{{url('/single-property')}}"> Book Now</a></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Duplicate property cards as needed -->

            <div class="col-md-4 mb-4">
                <div class="property-card-sub">
                    <img src="<?=base_url()?>assets/front/images/00c75ec2.png" alt="Property Image" class="property-img">
                    <div class="property-details">
                        <p><b>2-Bedroom | Vacant | City View | Chiller on DEWA</b></p>
                        <p><strong>$4,200,000</strong></p>
                        <p><i class="bi bi-geo-alt"></i> <b>Atlantis The Royal Residences, South Africa</b></p>
                        <p>Buy Own House Properties is delighted to present this large 7-bedroom villa plus</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>🛏 2</span>
                            <span>🛁 2</span>
                            <span><i class="bi bi-arrow-down-left-square-fill"></i> 2</span>
                             <button class="btn book-now"><a href="{{url('/single-property')}}"> Book Now</a></button>
                        </div>
                    </div>
                </div>
            </div>

             <div class="col-md-4 mb-4">
                <div class="property-card-sub">
                    <img src="<?=base_url()?>assets/front/images/f03209c69.png" alt="Property Image" class="property-img">
                    <div class="property-details">
                        <p><b>2-Bedroom | Vacant | City View | Chiller on DEWA</b></p>
                        <p><strong>$4,200,000</strong></p>
                        <p><i class="bi bi-geo-alt"></i> <b>Atlantis The Royal Residences, South Africa</b></p>
                        <p>Buy Own House Properties is delighted to present this large 7-bedroom villa plus</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>🛏 2</span>
                            <span>🛁 2</span>
                            <span><i class="bi bi-arrow-down-left-square-fill"></i> 2</span>
                             <button class="btn book-now"><a href="{{url('/single-property')}}"> Book Now</a></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



 </section>


   </main>

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

