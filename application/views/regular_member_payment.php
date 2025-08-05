<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
				<!-- Favicon -->
		<link rel="apple-touch-icon" sizes="180x180" href="https://zilojolabs.com/muthaiga/wp-content/uploads/2025/04/logo.webp">
		<link rel="icon" type="image/png" href="https://zilojolabs.com/muthaiga/wp-content/uploads/2025/04/logo.webp" sizes="32x32">
		<link rel="icon" type="image/png" href="https://zilojolabs.com/muthaiga/wp-content/uploads/2025/04/logo.webp" sizes="16x16">
	
  <title>Payment Details - New Muthaiga Residents Association</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/front/css/style.css" />
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

	<header class="nmra-header">
  <div class="header-inner">
    <a href="/" class="logo">
      <img src="<?=base_url()?>assets/front/images/nmra-logo.png" alt="New Muthaiga Logo" />
    </a>

    <button class="menu-toggle" id="menu-toggle" aria-label="Toggle menu">
      <i class="fa-solid fa-bars"></i>
    </button>

    <nav class="main-nav" id="main-nav">
      <ul class="menu">
        <li><a href="https://newmuthaigaresidentsassociation.com/">Home</a></li>
  
		   <li class="dropdown">
          <div class="dropdown-trigger">
            <a href="#">About</a>
            <button class="dropdown-toggle" aria-label="Toggle submenu">
              <i class="fa-solid fa-chevron-down"></i>
            </button>
          </div>
          <ul class="dropdown-menu">
            <li><a href="https://newmuthaigaresidentsassociation.com/about-nmra">About NMRA</a></li>
            <li><a href="https://newmuthaigaresidentsassociation.com/our-team">Our Team</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <div class="dropdown-trigger">
            <a href="#">News & Events</a>
            <button class="dropdown-toggle" aria-label="Toggle submenu">
              <i class="fa-solid fa-chevron-down"></i>
            </button>
          </div>
          <ul class="dropdown-menu">
            <li><a href="https://newmuthaigaresidentsassociation.com/news">News</a></li>
            <li><a href="https://newmuthaigaresidentsassociation.com/notices">Notices</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <div class="dropdown-trigger">
            <a href="#">Business Listings</a>
            <button class="dropdown-toggle" aria-label="Toggle submenu">
              <i class="fa-solid fa-chevron-down"></i>
            </button>
          </div>
          <ul class="dropdown-menu">
            <li><a href="#">Why Sign Up?</a></li>
            <li><a href="https://newmuthaigaresidentsassociation.com/business-listings">View Listings</a></li>
          </ul>
        </li>

        <li><a href="https://newmuthaigaresidentsassociation.com/environment">Environment</a></li>
        <li><a href="https://newmuthaigaresidentsassociation.com/volunteer">Volunteers</a></li>
        <li><a href="https://newmuthaigaresidentsassociation.com/northern-block">Northern Block</a></li>
        <li><a href="https://newmuthaigaresidentsassociation.com/contact-us">Contact</a></li>
      </ul>
    </nav>

    <div class="header-actions">
     <a href="https://newmuthaigaresidentsassociation.com/register" class="join-btn">
JOIN US
</a>

    </div>
  </div>
</header>
	
<div class="container my-5">

<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success">
    <?= $this->session->flashdata('success'); ?>
  </div>
<?php endif; ?>


  <!-- Back Button -->
  <div class="row mt-3">
    <div class="col-12">
      <button class="btn btn-secondary" onclick="window.history.back();">Back to Previous Step</button>
    </div>
  </div>

</div>
	<footer class="nmra-footer">
  <div class="footer-logo">
    <img src="<?=base_url()?>assets/front/images/nmra-logo-2.png" alt="New Muthaiga Logo" />
  </div>

  <hr class="footer-divider" />

  <div class="footer-container">
    <div class="footer-col about">
      <h4>About</h4>
      <p>
        The New Muthaiga Residents Association is dedicated to maintaining the integrity and beauty
        of the New Muthaiga Estate in Nairobi. We strive to foster a strong sense of community
        among residents, ensuring a safe and vibrant environment for all.
      </p>
    </div>

    <div class="footer-col links">
      <h4>Quick Link</h4>
     <ul>
        <li><a href="https://newmuthaigaresidentsassociation.com/about-nmra">About Us</a></li>
        <li><a href="https://newmuthaigaresidentsassociation.com/our-team">Our Team</a></li>
        <li><a href="https://newmuthaigaresidentsassociation.com/business-listings">Business Listings</a></li>
        <li><a href="https://newmuthaigaresidentsassociation.com/northern-block">Northern Block</a></li>
        <li><a href="https://newmuthaigaresidentsassociation.com/contact-us">Contact Us</a></li>
      </ul>
    </div>

    <div class="footer-col contact">
      <h4>Contact</h4>
      <ul>
        <li><i class="fas fa-map-marker-alt"></i> New Muthaiga</li>
        <li><i class="fas fa-envelope"></i>
          committee@newmuthaigaresidentsassociation.com
        </li>
      </ul>
    </div>
  </div>

  <hr class="footer-divider" />

  <div class="footer-bottom">
    <p>Copyright © 2025 New Muthaiga Residents Association – All Rights Reserved.</p>
  </div>
</footer>

<!-- Font Awesome (for icons) -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


<script>
  const toggles = document.querySelectorAll('.dropdown-toggle');

  toggles.forEach(toggle => {
    toggle.addEventListener('click', e => {
      e.preventDefault();
      const dropdown = toggle.closest('.dropdown');
      dropdown.classList.toggle('open');
    });
  });

  document.getElementById('menu-toggle').addEventListener('click', () => {
    document.getElementById('main-nav').classList.toggle('active');
  });
</script>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
