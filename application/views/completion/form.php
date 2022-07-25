<?php 
	$form_attr = [
		'class' => 'form-control',
		'readonly' => 'readonly',
	];
	$date_attr = array_merge($form_attr, ['type' => 'date']);
 ?>
<div class="modal-header">
  <h5 class="modal-title" id="staticBackdropLabel">CONFIRM THE FOLLOWING DATA ARE CORRECT</h5>
</div>
<div class="modal-body">
  <div class="row">
  	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-2">
  		<div class="form-floating">
			  <!-- <input type="text" class="form-control" id="cfn" value="" readonly> -->
			  <?php echo form_input('inc_cfn', set_value('inc_cfn', $this->input->post('cfn')), $form_attr); ?>
			  <label for="cfn">CFN</label>
			</div>
  	</div>
  	<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 mt-2">
  		<div class="form-floating">
			  <!-- <input type="text" class="form-control" id="CourseCode" value="" readonly> -->
			  <?php echo form_input('inc_code', set_value('inc_code', $this->input->post('CourseCode')), $form_attr); ?>
			  <label for="CourseCode">COURSE CODE</label>
			</div>
  	</div>
  	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-2">
  		<div class="form-floating">
			  <!-- <input type="text" class="form-control" id="units" value="" readonly> -->
			  <?php echo form_input('inc_units', set_value('inc_units', $this->input->post('units')), $form_attr); ?>
			  <label for="units">UNITS</label>
			</div>
  	</div>
  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
  		<div class="form-floating">
			  <!-- <input type="text" class="form-control" id="CourseDesc" value="" readonly> -->
			  <?php echo form_input('inc_title', set_value('inc_title', $this->input->post('CourseDesc')), $form_attr); ?>
			  <label for="CourseDesc">COURSE TITLE</label>
			</div>
  	</div>
  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
			  <label for="floatingTextarea2"><b>TERM WHEN THE INCOMPLETE GRADE WAS INCURRED:</b></label>
  	</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		  <label for="" class="form-label mb-0"><b>ACADEMIC YEAR</b></label>
			<!-- <input type="text" name="acadyear" id="acadyear" class="form-control" value=""> -->
			<?php echo form_input('inc_acadyear', set_value('inc_acadyear', $this->input->post('acadyear')), $form_attr); ?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		  <label for="" class="form-label mb-0"><b>SEMESTER</b></label>
		  <?php 
		  		echo form_dropdown('inc_semester', 
		  												[
												  			'1st Sem.' => '1st Semester',
												  			'2nd Sem.' => '2nd Semester',
												  			'Summer' => 'Summer'], 
												  		set_value('inc_semester', $this->input->post('semester'))
												  	); 
		  	?>
		</div>
  	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3">
  		<div class="row">
    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    			<label for="" class="form-label mb-0"><b>COMPLETION REQUIREMENT:</b></label>
    		</div>
      	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
      		<div class="form-check">
			      <label class="form-check-label">
			      <!-- <input class="form-check-input" type="checkbox" name="inc_requirements[]" value="examination"> -->
			      <?php echo form_checkbox('inc_requirements', 'EXAMINATION - RATING', in_array($this->input->post('inc_requirements[]'), 'EXAMINATION - RATING'), 'class="form-check-input"'); ?>
			        EXAMINATION - RATING
			      </label>
			    </div>
      	</div>
      	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
      		<div class="form-check">
			      <!-- <input class="form-check-input" type="checkbox" name="inc_requirements[]" value="report_title"> -->
			      <label class="form-check-label">
			      <?php echo form_checkbox('inc_requirements', 'REPORT - TITLE', in_array($this->input->post('inc_requirements[]'), 'REPORT - TITLE'), 'class="form-check-input"'); ?>
			        REPORT - TITLE
			      </label>
			    </div>
      	</div>
      	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
      		<div class="form-check">
			      <!-- <input class="form-check-input" type="checkbox" name="inc_requirements[]" value="project_title"> -->
			      <label class="form-check-label">
			      <?php echo form_checkbox('inc_requirements', 'PROJECT - TITLE', in_array($this->input->post('inc_requirements[]'), 'PROJECT - TITLE'), 'class="form-check-input"'); ?>
			        PROJECT - TITLE
			      </label>
			    </div>
      	</div>
      	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
      		<div class="form-check">
			      <!-- <input class="form-check-input" type="checkbox" name="inc_requirements[]" value="proof_of_attendance"> -->
			      <label class="form-check-label">
			      <?php echo form_checkbox('inc_requirements', 'PROOF OF ATTENDANCE AND COPY OF CLASS RECORD', in_array($this->input->post('inc_requirements[]'), 'PROOF OF ATTENDANCE AND COPY OF CLASS RECORD'), 'class="form-check-input"'); ?>
			        PROOF OF ATTENDANCE AND COPY OF CLASS RECORD
			      </label>
			    </div>
      	</div>
  		</div>
  	</div>
  	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3">
  		<div class="row">
    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				  <label for="" class="form-label mb-0"><b>PROFESSOR NAME</b></label>
				  <!-- <input type="text" name="inc_professor_name" id="inc_professor_name" class="form-control" value="" > -->
				  <?php echo form_input('inc_professor_name', set_value('inc_professor_name', $this->input->post('inc_professor_name')), $form_attr); ?>
  			</div>
  			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
				  <label for="" class="form-label mb-0"><b>COMPLETION DATE:</b></label>
      		<!-- <input type="date" name="inc_date" id="inc_date" class="form-control" value="" required="required" title=""> -->
      		<?php echo form_input('inc_date', set_value('inc_date', $this->input->post('inc_date')), $date_attr); ?>
      	</div>
  		</div>
  	</div>
  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
  		<div class="row">
    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    			<label for="" class="form-label mb-0"><b>GRADING SYSTEM:</b></label>
    		</div>
      	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 mt-2">
      		<div class="form-check">
			      <label class="form-check-label">
			      <!-- <input class="form-check-input" type="radio" name="inc_grading_sys" value="OLD"> -->
			      <?php echo form_radio('inc_grading_sys', 'OLD', $this->input->post('inc_grading_sys') == 'OLD' ? TRUE : FALSE, 'class="form-check-input"'); ?>
			        OLD
			      </label>
			    </div>
      	</div>
      	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 mt-2">
      		<div class="form-check">
			      <label class="form-check-label">
			      <?php echo form_radio('inc_grading_sys', 'NEW', $this->input->post('inc_grading_sys') == 'NEW' ? TRUE : FALSE, 'class="form-check-input"'); ?>
			        NEW
			      </label>
			    </div>
      	</div>
      	<div class="col-xs-4 col-sm-4 col-md-6 col-lg-6 mt-2">
      		<div class="form-check">
			      <label class="form-check-label">
			      <!-- <input class="form-check-input" type="radio" name="inc_grading_sys" value="CHARACTER"> -->
			      <?php echo form_radio('inc_grading_sys', 'CHARACTER', $this->input->post('inc_grading_sys') == 'CHARACTER' ? TRUE : FALSE, 'class="form-check-input"'); ?>
			        CHARACTER
			      </label>
			    </div>
      	</div>
  		</div>
  	</div>
  	
  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
  		<div class="row">
  			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    			<label for="" class="form-label mb-0"><b>GRADE:</b></label>
    		</div>
  			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-2">
  				<div class="form-floating">
					  <!-- <input type="text" class="form-control" id="inc_grade" value=""> -->
					  <?php echo form_input('inc_grade', set_value('inc_grade', $this->input->post('inc_grade')), $form_attr); ?>
					  <label for="inc_grade">LECTURE</label>
					</div>
  			</div>
  			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-2">
  				<div class="form-floating">
					  <!-- <input type="text" class="form-control" id="inc_labgrade" value=""> -->
					  <?php echo form_input('inc_labgrade', set_value('inc_labgrade', $this->input->post('inc_labgrade')), $form_attr); ?>
					  <label for="inc_labgrade">LABORATORY</label>
					</div>
  			</div>
  		</div>
  	</div>
  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
  		<div class="row">
  			
  			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 mt-3">
				  <label for="" class="form-label mb-0"><b>VALIDATED BY</b></label>
				  <!-- <input type="text" name="inc_validated_by" id="validated_by" class="form-control" value="" > -->
				  <?php echo form_input('validated_by', set_value('validated_by', $this->input->post('validated_by')), $form_attr); ?>
  			</div>
  			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 mt-3">
				  <label for="" class="form-label mb-0"><b>DATE VALIDATED:</b></label>
      		<!-- <input type="date" name="inc_validation_date" id="inc_validation_date" class="form-control" value="" required="required" title=""> -->
      		<?php echo form_input('inc_validation_date', set_value('inc_validation_date', $this->input->post('inc_validation_date')), $form_attr); ?>
      	</div>
      	<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 mt-3">
				  <label for="" class="form-label mb-0"><b>OR NUMBER:</b></label>
      		<!-- <input type="text" name="inc_recept_no" id="inc_recept_no" class="form-control" value="" required="required" title=""> -->
      		<?php echo form_input('inc_receipt_no', set_value('inc_receipt_no', $this->input->post('inc_receipt_no')), $form_attr); ?>
      	</div>
  		</div>
  	</div>
  </div>
</div>
<div class="modal-footer d-flex justify-content-center">
  <button type="button" class="btn btn-primary btn-sm" data-bs-target="#confirmation_modal" data-bs-toggle="modal">Submit</button>
  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
</div>