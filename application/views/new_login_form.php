<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <title>UMak Student Information Management System</title>

  <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/sidebar.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/font_custom.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/login.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/all_color.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/all_custom.css" rel="stylesheet">
    <!-- Bootstrap -->
    <!-- Custom Theme Style -->
     <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- JS -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
   
</head>
<body class="body-ct">
  <div class="container-fluid">
    <div class="row justify-content-center mt-5 pt-5">
      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 login-col minh500px">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5 mb-5">
          <h1 class="f-pop mt-5 login-title">
            LOG-IN
            <hr>
          </h1>
        </div>
          <!-- <h3 class="f-pop mt-4 mb-3">LOG-IN</h3> -->
        <!-- <form> -->
        <div class="row">
          <?php if ($this->session->flashdata('error')): ?>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
            <div class="alert alert-danger">
                <strong>WARNING</strong>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
          </div>
          <?php endif ?>
          <?php if ( ! empty($errors)): ?>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
            <div class="alert alert-danger">
              <?php if (is_array($errors)): ?>
                <?php foreach ($errors as $error): ?>
                  <?php echo $errors; ?>
                <?php endforeach ?>
              <?php else: ?>
                <?php echo $errors; ?>
              <?php endif ?>
            </div>
          </div>
          <?php endif ?>
          <?php echo $form_url; ?>
          
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
            <label for="exampleDataList" class="form-label">Username:</label>
            <input class="form-control" type="text" name="username"  placeholder="Type your Username">
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
            <label for="exampleDataList" class="form-label">Password:</label>
            <input class="form-control" type="password" name="password" placeholder="Type your Password">
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
            <a data-bs-toggle="modal" data-bs-target="#forgot_password" class="pointer">Forgot Password?</a>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5 mb-5 text-center">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> SUBMIT</button>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 logo-img mt-5 justify-content-end text-center">
            <img src="<?php echo base_url().'/assets/images/itc_logo.png' ?>" width="60px">
            <p class="mb-0"><small>DELEVELOPED BY: INFORMATION TECHNOLOGY CENTER</small></p>
          </div>
        </div>  
         <?php echo form_close(); ?>

        <!-- </form> -->
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 logo-col minh500px">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 logo-img mt-5 mb-5 justify-content-end text-center"">
            <img  src="<?php echo base_url().'/assets/images/umak_logo.png' ?>" width="150px">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5 mb-5">
          <h1 class="text-center mt-5 mb-5">
          STUDENT INFORMATION MANAGEMENT SYSTEM
          </h1>
        </div>  
      </div>
    </div>
  </div>

  <?php 
    $this->load->view('modals/forgot_password');
   ?>
</body>

</html>
