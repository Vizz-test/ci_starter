<?php

    $this->load->helper('cookie');
    $email = get_cookie('iv_email');
    $password = get_cookie('iv_pass');

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login | Vizz</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 mb-4 text-dark font-weight-bold">MSG VIZZ</h1>
                                    </div>
                                    <?php
                                        if($this->session->flashdata("error")){
                                            echo '<div class="alert alert-danger text-center">'.$this->session->flashdata("error").'</div>';
                                        }else if($this->session->flashdata("success")){
                                            echo '<div class="alert alert-success text-center">'.$this->session->flashdata("success").'</div>';
                                        }
                                    ?>

                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" name="email" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." value="<?= ($email ? $email : '')?>">
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" name="password" placeholder="Password" value="<?= ($password ? $password : '') ?>">
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck" name="iv_remember" value="1">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>

                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Login">
                                    </form>
                                    <hr>
                                    <div class="text-center d-flex justify-content-center align-items-center">
                                        <a class="small" href="<?= base_url().'user/forgot_password'?>">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->

    <script src="<?= base_url();?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

</body>
</html>