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
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/font_custom.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/all_custom.css">
  	<!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.bundle.js"></script>

    <script src="<?php echo base_url()?>assets/select2/dist/js/select2.min.js"></script>

      
    <?php if (ENVIRONMENT !== 'production'): ?>
    <style type="text/css">
      .sidebar {
        position: initial !important;
      }
    </style>
    <?php endif ?>
    <style type="text/css">
      .form-button {
        display: flex;
        flex-wrap: wrap;
        flex-shrink: 0;
        align-items: center;
        justify-content: flex-end;
        padding: 0.75rem;
      }
    </style>
  </head>
<body>
	<?php $this->load->view('header'); ?>
	<div class="container-fluid mt-ct-55 sidebar-ct">
	  <div class="row">
	    <?php $this->load->view('sidebar'); ?>
	    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 minH-700">

        <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="row">
              
            <?php //if (!empty($page_title)): ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title-ct">
                <h3><?php //echo $page_title; ?></h3>
                <hr>
            </div>
            <?php //endif ?>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
              <nav aria-label="breadcrumb" class="pull-right">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><?php// echo ucwords($this->router->class) ;?></a></li>
                    <li class="breadcrumb-item active"><?php// echo ucwords( $this->router->method) ?></li>
                  </ol>
                </nav>
            </div>
          </div>
        </div> -->

        <?php foreach ($this->session->flashdata() as $key => $flashdata): ?>
          <!-- alert-message -->
          <div class="row">
            <div class="alert alert-info" style="font-size: 15px;">
              <p>
                <?php echo $flashdata; ?>
              </p>    
            </div>
          </div>
          <!-- alert-message-end -->  
        <?php endforeach ?>

        <div class="row">
	    		<?php $this->load->view($content); ?>
	    	</div>	
	    </div>
			<?php $this->load->view('footer'); ?>
	  </div>
	</div>  
<style type="text/css">
  #btn-back-to-top {
  position: fixed;
  bottom: 20px;
  right: 20px;
  display: none;
}
</style>

<button
        type="button"
        class="btn btn-danger-ct btn-floating btn-lg"
        id="btn-back-to-top"
        >
  <i class="fas fa-arrow-up"></i>
</button>


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
    $('.select2').select2({
        dropdownParent: $('#special_type')
    });
</script>

<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>

</body>
</html>
