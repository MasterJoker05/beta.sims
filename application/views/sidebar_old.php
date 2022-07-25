<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse ">
  <div class="position-sticky pt-3">
  	<div class="profile-ct">
  		<center>
      		<img src="<?php echo base_url()?>assets/images/profile-placeholder.png">
      		<span>MC KEVIN BAUTISTA</span><br>
      		<span class="badge bg-success letter-spacing-ct">REGISTRAR</span>
  		</center>
  	</div>
    <ul class="list-unstyled ps-0">
	      <li class="border-top my-3"></li>
	      <li><button class="btn btn-non-toggle align-items-center rounded" ><i class="fas fa-tachometer-alt"></i>DASHBOARD</button></li>
	      <li class="border-top my-3"></li>
	      <li><button class="btn btn-non-toggle align-items-center rounded" ><i class="fas fa-file-alt"></i>CURRICULUM</button></li>
	      <li class="border-top my-3"></li>
	      <li><button class="btn btn-non-toggle align-items-center rounded" ><i class="fas fa-users"></i>STUDENTS</button></li>
	      <li class="border-top my-3"></li>
	      <li>
	        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#cmat-collapse" aria-expanded="false">
	          <i class="fas fa-file-invoice"></i>CHANGE OF MATRICULATION
	        </button>
	        <div class="collapse" id="cmat-collapse">
	          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
	            <li><a href="#" class="link-dark rounded">AWAITING APPROVAL</a></li>
	            <li><a href="#" class="link-dark rounded">APPROVED APPLICATION</a></li>
	            <li><a href="#" class="link-dark rounded">DISAPPROVED APPLICATION</a></li>
	            <li><a href="#" class="link-dark rounded">AWAITING FOR STUDENT PRINTING</a></li>
	            <li><a href="#" class="link-dark rounded">PRINTED APPLICATION</a></li>
	            <li><a href="#" class="link-dark rounded">ALL TRANSACTIONS</a></li>
	            <li><a href="#" class="link-dark rounded">SENDING OF CMAT</a></li>
	          </ul>
	        </div>
	      </li>
	      <li class="border-top my-3"></li>
	      <li>
	        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#enrollment-collapse" aria-expanded="false">
	          <i class="fas fa-file-invoice"></i>ENROLLMENT
	        </button>
	        <div class="collapse" id="enrollment-collapse">
	          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
	            <li><a href="#" class="link-dark rounded">ENCODED </a></li>
	            <li><a href="#" class="link-dark rounded">SENDING OF COR</a></li>
	          </ul>
	        </div>
	      </li>
	      <li class="border-top my-3"></li>
	      <li>
	        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#s_eval-collapse" aria-expanded="false">
	          <i class="fas fa-user-graduate"></i>STUDENT EVALUATION
	        </button>
	        <div class="collapse" id="s_eval-collapse">
	          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
							<li><a href="<?php echo base_url('student_evaluation') ?>/CCS" class="link-dark rounded">CCS</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/CGPP" class="link-dark rounded">CGPP</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/COAHS" class="link-dark rounded">COAHS</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/CTM" class="link-dark rounded">CTM</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/CHK" class="link-dark rounded">CHK</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/COE" class="link-dark rounded">COE</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/CMLI" class="link-dark rounded">CMLI</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/CCAPS" class="link-dark rounded">CCAPS</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/CCSE" class="link-dark rounded">CCSE</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/CAL" class="link-dark rounded">CAL</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/COS" class="link-dark rounded">COS</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/CBFS" class="link-dark rounded">CBFS</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/CTHM" class="link-dark rounded">CTHM</a></li>
							<li><a href="<?php echo base_url('student_evaluation') ?>/SOL" class="link-dark rounded">SOL</a></li>
	          </ul>
	        </div> 
	      </li>
	      <li class="border-top my-3"></li>
	      <li>
	        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
	          <i class="fas fa-user-graduate"></i>STUDENT RECORDS
	        </button>
	        <div class="collapse" id="orders-collapse">
	          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
	            <li><a href="#" class="link-dark rounded">STUDENT PERMANENT RECORDS</a></li>
	            <li><a href="#" class="link-dark rounded">TRANSCRIPT OF RECORDS</a></li>
	          </ul>
	        </div> 
	      </li>
	      <li class="border-top my-3"></li>
	      <li><a href="<?php echo base_url('accounts') ?>" class="btn btn-non-toggle align-items-center rounded" ><i class="fas fa-user-circle"></i>ACCOUNTS</a></li>
	      <li class="border-top my-3"></li>
	      <li><a href="<?php echo base_url('site/logout') ?>" class="btn btn-non-toggle align-items-center rounded" ><i class="fas fa-sign-out-alt"></i>SIGN OUT</a></li>
	    </ul>
  </div>
</nav>

