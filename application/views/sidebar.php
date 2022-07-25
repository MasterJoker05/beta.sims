<div class="sidebar print_hide">
  <div class="logo-details">
    <img src="<?php echo base_url()?>assets/images/umak_logo.png" width="50px">
    <span class="logo_name show-ct">UMak SIMS</span>
    <span class="logo_name hide-ct">UMak</span>
  </div>
  <ul class="nav-links">
    <li>
      <a href="<?php echo base_url('dashboard') ?>">
        <i _fa_box_1 class='fa fa-tachometer-alt' ></i>
        <span class="link_name">Dashboard</span>
      </a>
      <ul class="sub-menu blank">
        <li><a class="link_name" href="<?php echo base_url('dashboard') ?>">Dashboard</a></li>
      </ul>
    </li>
    <li>
      <a href="<?php echo base_url('student') ?>">
        <i class='fa fa-certificate' ></i>
        <span class="link_name">Students</span>
      </a>
      <ul class="sub-menu blank">
        <li><a class="link_name" href="<?php echo base_url('student') ?>">Students</a></li>
      </ul>
    </li>
    <li>
      <div class="iocn-link arrow2">
        <a href="#" class="arrow1">
          <i class='fa fa-file-archive' ></i>
          <span class="link_name">Change of Matriculation</span>
        </a>
        <i class='fa fa-chevron-down arrow' ></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="#">Change of <br>Matriculation</a></li>
        <li><a href="<?php echo base_url('cmat/awaiting_approval') ?>">Awaiting Approval</a></li>
				<li><a href="<?php echo base_url('cmat/approved') ?>">Approved Application</a></li>
				<li><a href="<?php echo base_url('cmat/disapproved') ?>">Disapproved Application</a></li>
				<li><a href="<?php echo base_url('cmat/printed') ?>">Printed Application</a></li>
				<li><a href="<?php echo base_url('cmat/all') ?>">All Transactions</a></li>
				<li><a href="<?php echo base_url('cmat/sending_cmat') ?>">Sending of Cmat</a></li>
				<!-- <li><a href="<?php //echo base_url('cmat/') ?>">Awaiting for student Printing</a></li> -->
      </ul>
    </li>
    <li>
      <div class="iocn-link arrow2">
        <a href="#" class="arrow1">
          <i class='fa fa-file-archive' ></i>
          <span class="link_name">Enrollment</span>
        </a>
        <i class='fa fa-chevron-down arrow' ></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="#">Enrollment</a></li>
        <li><a href="#<?php //echo base_url('') ?>">Encoded</a></li>
        <li><a href="#<?php //echo base_url('') ?>">Sending of Cor</a></li>
      </ul>
    </li>
    <li>
      <div class="iocn-link arrow2">
        <a href="#" class="arrow1">
          <i class='fa fa-file-archive' ></i>
          <span class="link_name">Student Evaluation</span>
        </a>
        <i class='fa fa-chevron-down arrow' ></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="#">Student <br>Evaluation</a></li>
        <?php 
          $colleges = $this->session->userdata('college');
          foreach ($colleges as $key => $code):
        ?>
  				<li><a href="<?php echo base_url('student_evaluation/').$code->CollegeCode?>"><?php echo $code->CollegeCode ?></a></li>
        <?php endforeach ?>
      </ul>
    </li>
    
    <li>
      <div class="iocn-link arrow2">
        <a href="#" class="arrow1">
          <i class='fa fa-cog' ></i>
          <span class="link_name">Masterdata</span>
        </a>
        <i class='fa fa-chevron-down arrow' ></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="#">Masterdata</a></li>
        <li><a href="<?php echo base_url('curriculum') ?>">List Curriculum</a></li>
        <li><a href="<?php echo base_url('college') ?>">List College</a></li>
        <li><a href="<?php echo base_url('program') ?>">List Program</a></li>
        <li><a href="<?php echo base_url('major') ?>">List Major</a></li>
        <li><a href="<?php echo base_url('course') ?>">List Courses/Subjects</a></li>
      </ul>
    </li>
    <li>
      <div class="profile-details">
        <div class="profile-content">
          <img src="<?php echo base_url()?>assets/images/profile-placeholder.png" alt="profileImg">
        </div>
        <div class="name-job">
          <div class="profile_name"><?php echo  $this->session->userdata('firstname'); ?></div>
          <div class="job">Staff</div>
        </div>
        <a href="<?php echo base_url('site/logout') ?>"><i class='fas fa-power-off text-danger' ></i></a>
      </div>
    </li>
  </ul>
</div>
