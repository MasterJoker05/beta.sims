<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 stud_info-ct">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h4 class="letter-spacing-ct"><i class="fas fa-info-circle"></i> STUDENT INFORMATION</h4>
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 stud-img">
			<center>
	      		<?php 
				$img_path = $_SERVER["DOCUMENT_ROOT"].'/olfe/student_img/PICTURES/';
				$stud_image = get_key($student_info,'StudNo');
				if ( file_exists( $img_path.$stud_image. ".JPG")) : ?>
				<img src="<?php echo 'https://umak.edu.ph/olfe/student_img/PICTURES/'.$stud_image.'.JPG' ?>" class="img-responsive img-thumbnail" width="90%">
				<?php else: ?>
				<img src="<?php echo base_url()?>assets/images/profile-placeholder.png" class="img-responsive img-thumbnail" width="90%"> 
				<?php endif ?>
    		</center>
    	</div>
    	<div class="col-xs-8 col-sm-8 col-md-4 col-lg-3">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-text-ct">
				<small><b>STUDENT NO</b></small>
				<p><?php echo get_key($student_info,'StudNo') ?></p>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-text-ct">
				<small><b>LAST NAME</b></small>
				<p><?php echo get_key($student_info,'Lname') ?></p>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-text-ct">
				<small><b>FIRST NAME</b></small>
				<p><?php echo get_key($student_info,'Fname') ?></p>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-text-ct">
				<small><b>MIDDLE NAME</b></small>
				<p><?php echo get_key($student_info,'Mname') ?></p>
			</div>
    	</div>
    	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-7">
    		<div class="row">
    			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-text-ct">
	    				<small><b>BIRTHDATE</b></small>
	    				<p><?php echo date_convert_to_mysql(get_key($student_info,'BirthDay'),'F d, Y') ?></p>
	    			</div>
    			</div>
    			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-text-ct">
	    				<small><b>PLACE OF BIRTH</b></small>
	    				<p>NO FIELD IN DATABASE</p>
	    			</div>
	    		</div>
    		</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-text-ct">
				<small><b>ADDRESS</b></small>
				<p><?php echo get_key($student_info,'AddressStreet').' '.get_key($student_info,'AddressBarangay').' '.get_key($student_info,'AddressCity') ?></p>
			</div>
			<div class="row">
    			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-text-ct">
	    				<small><b>NATIONALITY</b></small>
	    				<p>NO FIELD IN DATABASE</p>
	    			</div>
    			</div>
    			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-text-ct">
	    				<small><b>GUARDIAN</b></small>
						<p><?php echo get_key($student_info,'Guardian') ?></p>
	    			</div>
	    		</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-text-ct">
						<small><b>COLLEGE</b></small>
						<p><?php echo get_key($student_info,'CollegeDesc').' - '.get_key($student_info,'CollegeCode') ?></p>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-text-ct">
						<small><b>CURRICULLUM</b></small>
						<p><?php echo get_key($student_info,'CurriculumDesc') ?></p>
					</div>
				</div>
    		</div>
    	</div>
	</div>
	
</div>