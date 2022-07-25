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
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/sidebar.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/css/font_custom.css"> -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/all_custom.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/all_color.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/filing_print.css">

    <!-- JS -->
    <script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
    <script src="<?php echo base_url()?>assets/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/bootstrap/js/popper.min.js"></script>

    <script>
        $('.select2').select2({
            dropdownParent: $('#special_type')
        });
    </script>
    <style type="text/css">
      pre{
        margin-left: 280px !important;
      }
      fieldset{
        margin-left: 280px !important;
      }
    </style>
  </head>
<body>
  <div class="main print_hide">

    <?php $this->load->view('header'); ?>

    <?php $this->load->view('sidebar'); ?>
    
    <section class="home-section print_hide">
      
      <div class="home-content print_hide">
        <i class='fa fa-bars  print_hide' ></i>
        <span class="text  print_hide show-ct">Student Information Management System</span>
        <span class="text  print_hide hide-ct">SIMS</span>
      </div>

      <div class="container-fluid print_hide">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-3">
            <div class="card">
              <div class="card-body">
                
                <!-- page title -->
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h5 class="card-title">
                      <?php echo $page_title; 
                        if (!empty($CollegeCode)) {
                          echo  ' : '.$CollegeCode ;
                        }
                      ?>
                    </h5>
                    <small style="font-weight: bold;">
                      <?php echo $this->SemDesc.' A.Y.'.$this->SyDesc ?>
                    </small>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <nav aria-label="breadcrumb" class="float-end">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('student_evaluation') ?>">Student Evaluation Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Home</li>
                      </ol>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
                <!-- end page title -->

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card card_min618">
              <div class="card-body">  
                <div class="row">
                  <?php $this->load->view('message/load_flashdata'); ?>
                  
                  <?php 
                    if ($student_info_active == TRUE) : 
                      $this->load->view('student/student_information'); 
                    endif;
                  ?>

                  <!-- content -->
                  <?php $this->load->view($content); ?> 
                  <!-- end content -->

                </div>


              </div>
            </div>
          </div>
        </div>
        <?php $this->load->view('footer'); ?>
      </div>
    </section>
  </div>
<?php ! empty($print) && $this->load->view($print); ?>

<div class="print_hide">
  <button
      type="button"
      class="btn btn-custom btn-floating btn-lg"
      id="btn-back-to-top"
      >
      <i class="fas fa-arrow-up"></i>
  </button>
</div>


<?php $this->load->view('modals/add_user_account'); ?>
<?php $this->load->view('modals/error'); ?>
<?php $this->load->view('modals/success'); ?>
<?php $this->load->view('modals/loading'); ?>
<?php $this->load->view('modals/edit_student_information'); ?>
<?php $this->load->view('modals/send_email_student'); ?>

<?php ! empty($javascript) && $this->load->view($javascript); ?>


<script type="text/javascript">
  //Get the button
  let mybutton = document.getElementById("btn-back-to-top");

  // When the user scrolls down 20px from the top of the document, show the button
  window.onscroll = function () {
    scrollFunction();
  };

  function scrollFunction() {
    if (
      document.body.scrollTop > 20 ||
      document.documentElement.scrollTop > 20
    ) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  }
  // When the user clicks on the button, scroll to the top of the document
  mybutton.addEventListener("click", backToTop);

  function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  }

  $(document).ready(function(){
    $(document).on('click','#btnsuccess',function(){
      location.reload();
    })
  })


</script>



<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  });


  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
  });

  var popover = new bootstrap.Popover(document.querySelector('.popover-dismiss'), {
    trigger: 'focus'
  })
</script>



    <script src="<?php echo base_url()?>assets/js/sidebar.js"></script>
</body>
</html>
