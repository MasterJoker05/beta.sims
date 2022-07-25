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
  <link rel="stylesheet" href="<?php echo base_url()?>assets/fontawesome/css/all.css">
    <!-- Bootstrap -->
    <!-- Custom Theme Style -->
     <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- JS -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
   
</head>
<body>
    <div class="container login-body">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 login-left-ct" >
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 login-ct">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 login-logo-ct">
                  <center>
                    <img src="<?php echo  base_url().'/assets/images/umak_logo.png' ?>" width ='100px'>
                    <h1 class="font-lemon text-dark-custom">UMAK Student Information Management System </h1>
                  </center>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 login-logo-ct">
                  
                  <?php if (validation_errors()): ?>
                    <div class="alert alert-danger">
                      <strong>Warning</strong>
                      <strong><?php echo validation_errors(); ?></strong>
                    </div>
                  <?php endif ?>
                  <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                      <strong>Warning</strong>
                      <strong><?php echo $this->session->flashdata('error'); ?></strong>
                    </div>
                  <?php endif ?>
                  <center>
                    <h1 class="text-dark-custom ">Forgot Password</h1>
                  </center>
                  <!-- <hr> -->
                </div>
                <?php echo $form_url; ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 login-logo-ct">
                  <div class="form-group">
                      <label class="text-dark-custom">NEW PASSWORD : </label>
                      <input type="password" name="password" class="form-control text-center" autocomplete="off" id="" placeholder="Enter Password" >
                  </div>
                  <div class="form-group" style="margin-top: 30px;">
                      <label class="text-dark-custom">CONFIRM PASSWORD : </label>
                      <input type="password" name="password" class="form-control text-center" autocomplete="off" id="" placeholder="Enter Password">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 login-logo-ct">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <center>
                          <button type="submit" class="btn btn-lg btn-custom" style="margin-top:20px; width: 50%;"><b>SUBMIT</b></button>
                      </center>
                    </div>
                  </div>
                </div>
                <?php echo form_close(); ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 login-footer-ct" style="margin-top: 5%; margin-bottom: 5%;">
                  <center>
                      <img src="<?php echo  base_url().'/assets/images/itc_logo.png' ?>" width='50px'>
                      <p >UMak - Information Technology Center</p>
                  </center>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 login-right-ct" >
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 login-note-ct">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="backimg text-center">
                <img src="<?php echo  base_url().'/assets/images/login-img.jpg' ?> " width="100%">
              </div>
            </div>
          </div>
        </div>
      </div>
	 </div> <!-- /container -->

  <?php 
    $this->load->view('modals/forgot_password',TRUE);
   ?>
</body>

</html>

