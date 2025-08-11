 <footer id="footer" class="footer dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-12 footer-about">
          <!-- <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Logis</span>
          </a> -->
           <a href="<?=base_url().'';?>" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="<?=base_url()?>assets/front/img/logo.png" alt="">
        <!-- <h1 class="sitename">Logis</h1> -->
      </a>
          <p>Lorem Ipsum is simply dummy text of the and typesetting industry. Lorem Ipsum is dummy text of the printing.</p>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="<?=base_url().'';?>">Home</a></li>
            <li><a href="<?=base_url().'about';?>">About us</a></li>
            <li><a href="<?=base_url().'blog';?>">Blog</a></li>
            <li><a href="<?=base_url().'faqs';?>">FAQ</a></li>
            <li><a href="<?=base_url().'pricing';?>">Pricing</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <!-- <h4>Our Services</h4> -->
          <br><br>
          <ul>
            <li><a href="<?=base_url().'products-services';?>">Product & Service</a></li>
            <li><a href="<?=base_url().'book-a-demo';?>">Book A Demo</a></li>
            <li><a href="#">Affiliate program </a></li>
            <li><a href="#">Sitemap</a></li>
          </ul>
        </div>


        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
          <h4>Contact Us</h4>
          <p><i class="bi bi-geo-alt"></i>  124 Brooklyn, Kenya</p>
          <p class="mt-4"><i class="bi bi-phone"></i> <strong> Phone:</strong> <span>+254 3456 7890</span></p>
          <p><i class="bi bi-envelope"></i> <strong> Email:</strong> <span>info@wtm.com</span></p>
        </div>

      </div>
    </div>

    <div class="container copyright mt-4">
      <p>© Copyright Medih 2025 All Right Reserved. <span style="float: right;"><a href="{{ url('/term-and-conditions') }}" class="text-white">Terms of use</a> | Privacy policy</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="<?=base_url()?>assets/front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=base_url()?>assets/front/vendor/php-email-form/validate.js"></script>
  <script src="<?=base_url()?>assets/front/vendor/aos/aos.js"></script>
  <script src="<?=base_url()?>assets/front/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="<?=base_url()?>assets/front/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?=base_url()?>assets/front/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="<?=base_url()?>assets/front/js/main.js"></script>


  <script>
  const plans = document.querySelectorAll('#plan-container .col');
  const total = plans.length;
  const perPage = 3;
  let start = 0;

  function updateVisiblePlans() {
    plans.forEach((plan, index) => {
      plan.style.display = (index >= start && index < start + perPage) ? 'block' : 'none';
    });
  }

  document.getElementById('prevBtn').addEventListener('click', () => {
    if (start - perPage >= 0) {
      start -= perPage;
      updateVisiblePlans();
    }
  });

  document.getElementById('nextBtn').addEventListener('click', () => {
    if (start + perPage < total) {
      start += perPage;
      updateVisiblePlans();
    }
  });

  // Initialize on page load
  updateVisiblePlans();
</script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
window.onload = function () {
    <?php if ($this->session->flashdata('swal_success')): ?>
    const successMsg = <?= json_encode($this->session->flashdata('swal_success')) ?>;

    if (typeof Swal !== "undefined") {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            html: successMsg,
            confirmButtonColor: '#3085d6'
        });
    } else {
        alert(successMsg);
    }
    <?php endif; ?>

    <?php if ($this->session->flashdata('swal_error')): ?>
    const errorMsg = '<ul><?= $this->session->flashdata('swal_error') ?></ul>';

    if (typeof Swal !== "undefined") {
        Swal.fire({
            icon: 'error',
            title: 'Please fix the following:',
            html: errorMsg,
            confirmButtonColor: '#d33'
        });
    } else {
        alert("Please fix the following errors:\n\n" + <?= json_encode(strip_tags($this->session->flashdata('swal_error'))) ?>);
    }
    <?php endif; ?>
};
</script>


</body>

</html>
