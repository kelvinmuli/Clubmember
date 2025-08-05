<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Roodito</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?=base_url()?>assets/admin/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?=base_url()?>assets/admin/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?=base_url()?>assets/admin/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?=base_url()?>assets/admin/assets/css/style.css" rel="stylesheet">
</head>

<body class="login-page" style="background-image:url(<?=base_url()?>assets/front/img/survices.png); background-repeat: no-repeat; background-size: auto;">
    <div class="login-box" style="opacity: 0.8;">
        <div class="card">
            <div class="body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-logo">
                            <img src="<?=base_url()?>assets/admin/assets/images/logo_circle.png" alt="" class="img-responsive align-center" width="30%">
                            <p>Roodito</p>
                        </div>
                    </div>
                </div>

                <?php if ($this->session->flashdata()) { ?>
                        <div class="alert alert-warning" style="color: #35a01a;">
                            <?= $this->session->flashdata('msg'); ?>
                        </div>
                      <?php } ?>

                <form id="log_in" action="#" method="POST">
                     <input type="hidden" name="user_type" id="user_type" value="5c8786df7c161">
                     <div class="input-group addon-line">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" required autofocus>
                        </div>
                    </div>

                     <div class="input-group addon-line">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" required autofocus>
                        </div>
                    </div>

                     <div class="input-group addon-line">
                        <span class="input-group-addon">
                            <i class="material-icons">phone</i>
                        </span>
                        <div class="form-line">
                            <input type="number" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number" required autofocus>
                        </div>
                    </div>
                    <div class="input-group addon-line">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email address" required autofocus>
                        </div>
                    </div>
                    <div class="input-group addon-line">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" id="pwd" placeholder="Password" required>
                        </div>
                    </div>
                   

                    <button class="btn btn-block btn-primary waves-effect" type="submit">SIGN UP</button>

                   <p class="text-muted text-center p-t-20">
                        <small>Have an account?</small>
                    </p>

                    <a class="btn btn-sm btn-default btn-block" href="<?= base_url() . 'login'; ?>">LOG IN</a>

                </form>
            </div>
        </div>
    </div>

    <!-- CORE PLUGIN JS -->
    <script src="<?=base_url()?>assets/admin/plugins/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/admin/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="<?=base_url()?>assets/admin/plugins/node-waves/waves.js"></script>
    <script src="<?=base_url()?>assets/admin/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!--THIS PAGE LEVEL JS-->
    <script src="<?=base_url()?>assets/admin/plugins/jquery-validation/jquery.validate.js"></script>
    <script src="<?=base_url()?>assets/admin/assets/js/pages/examples/login.js"></script>

    <!-- LAYOUT JS -->
    <script src="<?=base_url()?>assets/admin/assets/js/demo.js"></script>

</body>

</html>