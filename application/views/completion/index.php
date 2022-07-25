<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 completion-ct mt-3">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
			<h4 class="letter-spacing-ct"><i class="fas fa-list-ul"></i> LIST OF INCOMPLETE SUBJECTS</h4>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th class="align-middle text-center" width="">CFN</th>
							<th class="align-middle text-center" width="">Course code</th>
							<th class="align-middle text-center" width="">Course Title</th>
							<th class="align-middle text-center" width="">Unit/s</th>
							<th class="align-middle text-center" width="">Lecture</th>
							<th class="align-middle text-center" width="">Laboratory</th>
							<!-- <th class="align-middle text-center" width="">Remarks</th> -->
							<th class="align-middle text-center" width="">Action</th>
						</tr>
					</thead>
					<tbody>

						<?php foreach ($inc_grades as $subject): ?>
						<tr>
							<td><?php echo $subject->nametable; ?></td>
							<td><?php echo $subject->CourseCode; ?></td>
							<td><?php echo $subject->CourseDesc; ?></td>
							<td><?php echo $subject->units ?></td>
							<td><?php echo $subject->StrGrade; ?></td>
							<td><?php echo $subject->StrLab; ?></td>
							<!-- <td><?php echo $subject->Remarks; ?></td> -->
							<td class="text-center">
								<!-- <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#apply_completion"><i class="fas fa-hand-point-up"></i> Apply Completion
								</a> -->
								<?php 
										$apply_completion = [
											'name' => 'apply_completion',
											// 'id'	 => 'apply_completion',
											'value'=> 'apply completion',
											'type' => 'button',
											'class' => 'btn btn-primary btn-sm',
											'data-bs-toggle' => 'modal',
											'data-bs-target' => '#apply_completion',
											'content' => 'Apply Completion',
											'data-bs-sgid' => $subject->studgrade_id,
											'data-bs-studno' => $this->uri->segment(2),
											'data-bs-nametable' => $subject->nametable,
											'data-bs-leclab' => $subject->leclab,
											'data-bs-course_code' => $subject->CourseCode,
											'data-bs-course_desc' => $subject->CourseDesc,
											'data-bs-course_unit' => $subject->units,
											'data-bs-studno' => $subject->StudNo,
											'data-bs-profname' => $subject->profname,
										];
										echo form_button($apply_completion);  
									?>
							</td>
						</tr>							
						<?php endforeach ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

	
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 completion-ct mt-3">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
			<h4 class="letter-spacing-ct"><i class="fas fa-list-ul"></i> OLDER INCOMPLETE SUBJECTS</h4>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<!-- <th class="align-middle text-center" width="" rowspan="2">CFN</th> -->
							<th class="align-middle text-center" width="" rowspan="2">Course Code</th>
							<th class="align-middle text-center" width="" rowspan="2">Course Title</th>
							<th class="align-middle text-center" width="" rowspan="2">Unit/s</th>
							<th class="align-middle text-center" width="" colspan="2">Lecture</th>
							<th class="align-middle text-center" width="" colspan="2">Laboratory</th>
							<!-- <th class="align-middle text-center" width="" rowspan="2">Remarks</th> -->
							<th class="align-middle text-center" width="" rowspan="2">Action</th>
						</tr>
						<tr>
							<th class="align-middle text-center">From</th>
							<th class="align-middle text-center">To</th>
							<th class="align-middle text-center">From</th>
							<th class="align-middle text-center">To</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($inc_grades_old as $old_subject): ?>
						<tr>
							<!-- <td>A12345678</td> -->
							<td><?php echo $old_subject->inc_code; ?></td>
							<td><?php echo $old_subject->inc_title; ?></td>
							<td><?php echo $old_subject->inc_units; ?></td>
							<td><?php echo $old_subject->inc_grade; ?></td>
							<td><?php echo $old_subject->inc_labgrade; ?></td>
							<!-- <td></td> -->
							<!-- <td></td> -->
							<!-- <td>PASSED</td> -->
							<td class="text-center"><a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#revert_completion"><i class="fas fa-times"></i> Revert</a></td>
						</tr>
						<?php endforeach ?>
					</tbody>
					<?php if ( ! count($inc_grades_old)): ?>
						<tr>
							<tfoot>
							<td colspan="8" class="text-center"><strong>No Record Found</strong></td>
							</tfoot>
						</tr>
					<?php endif ?>
				</table>
			</div>
		</div>
	</div>
</div>


<!--Apply Completion Modal -->
<div class="modal fade" id="apply_completion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">COMPLETION</h5>
      </div>
      <div class="modal-body">
      	<?php echo form_open('#', 'id="frmCompletionAddNew"'); ?>
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-2">
        		<div class="form-floating">
						  <input type="text" class="form-control" id="inc_studno" name="inc_studno" placeholder="Student ID" value="" readonly>
						  <label for="inc_studno">Student ID</label>
						  <div id="v-inc_studno" class="invalid-feedback">
						  	test invalid feedback for cfn
				      </div>
						</div>
        	</div>
        	
        	<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 mt-2">
        		<div class="form-floating">
						  <input type="text" class="form-control" id="inc_code" name="inc_code" placeholder="Course Code" value="" readonly>
						  <label for="inc_code">COURSE CODE</label>
						  <div id="v-inc_code" class="invalid-feedback">
						  	test invalid feedback for CourseCode
				      </div>
						</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-2">
        		<div class="form-floating">
						  <input type="text" class="form-control" id="inc_units" name="inc_units" placeholder="Units" value="" readonly>
						  <label for="inc_units">UNITS</label>
						  <div id="v-inc_units" class="invalid-feedback">
						  	test invalid feedback for units
				      </div>
						</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-2">
        		<div class="form-floating">
						  <input type="text" class="form-control" id="inc_cfn" name="inc_cfn" placeholder="Course Filename" value="" readonly>
						  <label for="inc_cfn">CFN</label>
						  <div id="v-inc_cfn" class="invalid-feedback">
						  	test invalid feedback for cfn
				      </div>
						</div>
        	</div>
        	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 mt-2">
        		<div class="form-floating">
						  <input type="text" class="form-control" id="inc_title" name="inc_title" placeholder="Title" value="" readonly>
						  <label for="inc_title">COURSE TITLE</label>
						  <div id="v-inc_title" class="invalid-feedback">
						  	test invalid feedback for CourseDesc
				      </div>
						</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
						  <label for="floatingTextarea2"><b>TERM WHEN THE INCOMPLETE GRADE WAS INCURRED:</b></label>
        	</div>
    			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					  <label for="inc_acadyear" class="form-label mb-0"><b>ACADEMIC YEAR</b></label>
						<input type="text" id="inc_acadyear" name="inc_acadyear" placeholder="Academic Year i.e. 2020-2021" class="form-control" value="">
						<div id="v-inc_acadyear" class="invalid-feedback">
						  	test invalid feedback for acadyear
				    </div>
    			</div>
    			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					  <label for="inc_semester" class="form-label mb-0"><b>SEMESTER</b></label>
					  <select class="form-select" name="inc_semester" id="inc_semester" aria-label="Default select example">
						  <option value="" selected>Open this select menu</option>
						  <option value="1st Sem.">1ST SEMESTER</option>
						  <option value="2nd Sem.">2ND SEMESTER</option>
						  <option value="Summer">SUMMER</option>
						</select>
						<div id="v-inc_semester" class="invalid-feedback">
						  	test invalid feedback for semester
				    </div>
    			</div>
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3">
        		<div class="row">
	        		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	        			<label for="" class="form-label mb-0"><b>COMPLETION REQUIREMENT:</b></label>
	        		</div>
	        		<div class="form-check">
	        		
			        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
			        		<div class="form-check">
							      <label class="form-check-label">
							      <input class="form-check-input" type="checkbox" name="inc_requirements[]" value="examination">
							        EXAMINATION - RATING
							      </label>
							    </div>
			        	</div>
			        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
			        		<div class="form-check">
							      <label class="form-check-label">
							      <input class="form-check-input" type="checkbox" name="inc_requirements[]" value="report_title">
							        REPORT
							      </label>
							    </div>
			        	</div>
			        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
			        		<div class="form-check">
							      <label class="form-check-label">
							      <input class="form-check-input" type="checkbox" name="inc_requirements[]" value="project_title">
							        PROJECT
							      </label>
							    </div>
			        	</div>
			        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
			        		<div class="form-check">
							      <label class="form-check-label">
							      <input class="form-check-input" type="checkbox" name="inc_requirements[]" value="proof_of_attendance">
							        PROOF OF ATTENDANCE AND COPY OF CLASS RECORD
						        	<div id="v-inc_requirements" class="invalid-feedback">
										  	test invalid feedback for inc_requirements
								      </div>
							      </label>
							    </div>
			        	</div>
		        	</div>
        		</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3">
        		<div class="row">
	        		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							  <label for="" class="form-label mb-0"><b>PROFESSOR NAME</b></label>
							  <input type="text" name="inc_professor_name" id="inc_professor_name" class="form-control" value="" >
							  <div id="v-inc_professor_name" class="invalid-feedback">
						  		test invalid feedback for inc_professor_name
				      	</div>
	      			</div>
	      			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
							  <label for="" class="form-label mb-0"><b>COMPLETION DATE:</b></label>
		        		<input type="date" name="inc_date" id="inc_date" class="form-control" value="" required="required" title="">
		        		<div id="v-inc_date" class="invalid-feedback">
						  	test invalid feedback for inc_date
					      </div>
		        	</div>
        		</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
        		<div class="row">
	        		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	        			<b>GRADING SYSTEM:</b>
	        			<label for="" class="form-label mb-0">
	        			<input class="form-radio-input" id="inc_leclab" type="checkbox" name="leclab" value="1">
	        			  With Laboratory Grade
	        			</label>
	        		</div>
		        	<div class="form-radio col-xs-4 col-sm-4 col-md-3 col-lg-3 mt-2">
						      <label class="form-radio-label">
						      <input class="form-radio-input" type="radio" name="inc_grading_sys" value="OLD">
						        OLD
						      </label>
		        	</div>
		        	<div class="form-radio col-xs-4 col-sm-4 col-md-3 col-lg-3 mt-2">
						      <label class="form-radio-label">
						      <input class="form-radio-input" type="radio" name="inc_grading_sys" value="NEW">
						        NEW
						      </label>
		        	</div>
		        	<div class="form-radio col-xs-4 col-sm-4 col-md-6 col-lg-6 mt-2">
						      <label class="form-radio-label">
						      <input class="form-radio-input" type="radio" name="inc_grading_sys" value="CHARACTER">
						        CHARACTER
				        	<div id="v-inc_grading_sys" class="invalid-feedback">
								  	test invalid feedback for inc_grading_sys
						      </div>
						      </label>
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
								  <input type="text" class="form-control" name="inc_grade" id="inc_grade" value="">
								  <label for="inc_grade">LECTURE</label>
					  		  <div id="v-inc_grade" class="invalid-feedback">
					  		  	test invalid feedback for inc_grade
					        </div>
								</div>
        			</div>
        			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-2">
        				<div class="form-floating">
								  <input type="text" class="form-control" name="inc_labgrade" id="inc_labgrade" value="">
								  <label for="inc_labgrade">LABORATORY</label>
								  <div id="v-inc_labgrade" class="invalid-feedback">
								  	test invalid feedback for inc_labgrade
						      </div>
								</div>
        			</div>
        		</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
        		<div class="row">
        			
        			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 mt-3">
							  <label for="" class="form-label mb-0"><b>VALIDATED BY</b></label>
							  <input type="text" name="inc_validated_by" id="validated_by" class="form-control" value="" >
				  		  <div id="v-inc_validated_by" class="invalid-feedback">
				  		  	test invalid feedback for inc_validated_by
				        </div>
        			</div>
        			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 mt-3">
							  <label for="" class="form-label mb-0"><b>DATE VALIDATED:</b></label>
		        		<input type="date" name="inc_validation_date" id="inc_validation_date" class="form-control" value="" required="required" title="">
      				  <div id="v-inc_validation_date" class="invalid-feedback">
      				  	test invalid feedback for inc_validateion_date
      		      </div>
		        	</div>
		        	<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 mt-3">
							  <label for="" class="form-label mb-0"><b>OR NUMBER:</b></label>
		        		<input type="text" name="inc_receipt_no" id="inc_receipt_no" class="form-control" value="" required="required" title="">
		        		<div id="v-inc_receipt_no" class="invalid-feedback">
							  	test invalid feedback for inc_receipt_no
					      </div>
		        	</div>
        		</div>
        	</div>
        </div>
        <?php echo form_close(); ?>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" 
        			  class="btn btn-primary btn-sm" 
        			  id="btnSave"
        			  onclick="save()"
        			  <?php /* ?>data-bs-target="#confirmation_modal" 
        			  data-bs-toggle="modal" <?php */?>>
        	Submit
        </button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Confirmation Applying Completion Modal -->
<div class="modal fade" id="confirmation_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<?php /* ?>
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">CONFIRMATION</h5>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        	</div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-primary btn-sm" data-bs-target="#success_modal" data-bs-toggle="modal">Confirm</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-target="#apply_completion" data-bs-toggle="modal">Back</button>
      </div>
      <?php */ ?>
    </div>
  </div>
</div>

<!--Success Modal -->
<div class="modal fade" id="success_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">SUCCESS</h5>
      </div> -->
      <div class="modal-body">
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        		<h2 class="text-center text-success">SUCCESS</h2>
        		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
        	</div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!--Revert Completion Modal -->
<div class="modal fade" id="revert_completion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">REVERT COMPLETION</h5>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mt-2">
        		<div class="form-floating">
				  <input type="text" class="form-control" id="floatingInputValue" value="A12345678" readonly>
				  <label for="floatingInputValue">CFN</label>
				</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mt-2">
        		<div class="form-floating">
				  <input type="text" class="form-control" id="floatingInputValue" value="FILIPINO 101" readonly>
				  <label for="floatingInputValue">COURSE CODE</label>
				</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        		<div class="form-floating">
				  <input type="text" class="form-control" id="floatingInputValue" value="" readonly>
				  <label for="floatingInputValue">COURSE TITLE</label>
				</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        		<div class="row">
        			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-2">
        				<div class="form-floating">
						  <input type="text" class="form-control" id="floatingInputValue" value="1.00" readonly>
						  <label for="floatingInputValue">LECTURE</label>
						</div>
        			</div>
        			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-2">
        				<div class="form-floating">
						  <input type="text" class="form-control" id="floatingInputValue" value="" readonly>
						  <label for="floatingInputValue">LABORATORY</label>
						</div>
        			</div>
        			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        				<div class="form-floating">
						  <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
						  <label for="floatingTextarea2">REVERT REASON</label>
						</div>
        			</div>
        		</div>
        	</div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-primary btn-sm" data-bs-target="#revert_confirmation" data-bs-toggle="modal">Submit</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--Revert Confirmation Modal -->
<div class="modal fade" id="revert_confirmation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">REVERT CONFIRMATION</h5>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        		<p class="text-center"><b>ARE YOU SURE YOU WANT TO REVERT THIS COMPLETION ?</b></p>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mt-2">
        		<div class="form-floating">
				  <input type="text" class="form-control" id="floatingInputValue" value="A12345678" readonly>
				  <label for="floatingInputValue">CFN</label>
				</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mt-2">
        		<div class="form-floating">
				  <input type="text" class="form-control" id="floatingInputValue" value="FILIPINO 101" readonly>
				  <label for="floatingInputValue">COURSE CODE</label>
				</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        		<div class="form-floating">
				  <input type="text" class="form-control" id="floatingInputValue" value="" readonly>
				  <label for="floatingInputValue">COURSE TITLE</label>
				</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        		<div class="row">
        			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-2">
        				<div class="form-floating">
						  <input type="text" class="form-control" id="floatingInputValue" value="1.00" readonly>
						  <label for="floatingInputValue">LECTURE</label>
						</div>
        			</div>
        			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-2">
        				<div class="form-floating">
						  <input type="text" class="form-control" id="floatingInputValue" value="" readonly>
						  <label for="floatingInputValue">LABORATORY</label>
						</div>
        			</div>
        			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        				<div class="form-floating">
						  <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" readonly>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</textarea>
						  <label for="floatingTextarea2">REVERT REASON</label>
						</div>
        			</div>
        		</div>
        	</div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-primary btn-sm" data-bs-target="#success_modal" data-bs-toggle="modal">Yes</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-target="#revert_completion" data-bs-toggle="modal">No</button>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
$(document).ready(function(){

    $(document).on('click',"#btnadd_edu_details",function() {
        var rowCount = $('#tr_edu_details').find('tr').length + 1
        console.log(rowCount)
        var append_emp_details = `test`; //New input field html 
        $('#tr_edu_details').append(append_emp_details);
    })

    $(document).on('click',"#btnremove_edu_details",function() {
        $(this).parent().parent().remove();
    })

    // $(document).on('show.bs.modal', "#confirmation_modal", function(event) {

    // });

		//set input/textarea/select event when change value, remove class error and remove text help block 
		$("input").change(function(){
		   $(this).parent().parent().removeClass('is-invalid');
		   $(this).next().empty();
		});

		$("textarea").change(function(){
		   $(this).parent().parent().removeClass('is-invalid');
		   $(this).next().empty();
		});

		$("select").change(function(){
		   $(this).parent().parent().removeClass('is-invalid');
		   $(this).next().empty();
		});

});

var apply_completion = document.getElementById('apply_completion');


	

apply_completion.addEventListener('show.bs.modal', function(event) {
	
	// button that triggered the modal
	var button = event.relatedTarget;

	var studno =  button.getAttribute('data-bs-studno');
	var leclab =  button.getAttribute('data-bs-leclab');
	var course_code =  button.getAttribute('data-bs-course_code');
	var course_desc =  button.getAttribute('data-bs-course_desc');
	var course_unit =  button.getAttribute('data-bs-course_unit');
	var nametable =  button.getAttribute('data-bs-nametable');
	var sgid =  button.getAttribute('data-bs-sgid');
	var profname =  button.getAttribute('data-bs-profname');

	// update the modal's content
	document.getElementById('inc_studno').value = studno;
	document.getElementById('inc_leclab').value = leclab;
	document.getElementById('inc_code').value = course_code;
	document.getElementById('inc_title').value = course_desc;
	document.getElementById('inc_cfn').value = nametable;
	document.getElementById('inc_units').value = course_unit;
	document.getElementById('inc_professor_name').value = profname;

	console.log(studno)
	console.log(course_code)
	console.log(course_desc)
	console.log(course_unit)
	console.log(nametable)
	console.log(profname)

	$('.is-invalid').removeClass('is-invalid'); //remove class
	$(':checked').prop('checked', false);

});

function save() {

	$('#btnSave').text('saving...'); //change button text
	$('#btnSave').attr('disabled',true); //set button disable 
	$('.is-invalid').removeClass('is-invalid'); //remove class
	
	var url;

  url = "<?php echo site_url('completion/validate')?>";
	
	// ajax adding data to database
	$.ajax({
	   url : url,
	   type: "POST",
	   data: $('#frmCompletionAddNew').serialize(),
	   dataType: "JSON",
	   success: function(data)
	   {

	       if(data.status) //if success close modal and reload ajax table
	       {
	           $('#apply_completion').modal('hide');
	           // reload_table();
	       }
	       else
	       {
	         	 $.each(data.errors, function(field, error) {
	         	 	
	         	 		if (field == 'inc_requirements[]')
	         	 		{
		         	 		// $('[name="inc_requirements[]"]').addClass('is-invalid'); //select and add is-invalid class
		         	 		$('#v-inc_requirements').text(error); //select span help-block class set text error string
	         	 		}
	         	 		else
	         	 		{
		         	 		$('#v-'+field).text(error); //select span help-block class set text error string
	         	 		}
		         	 		$('[name="'+field+'"]').addClass('is-invalid'); //select and add is-invalid class
	         	 });
	       }

     		 console.log(data);

	       $('#btnSave').text('save'); //change button text
	       $('#btnSave').attr('disabled',false); //set button enable 


	   },
	   error: function (jqXHR, textStatus, errorThrown)
	   {
	       alert('Error adding / update data');
	       console.log(errorThrown);
	       console.log(jqXHR.responseText);

	       $('#btnSave').text('save'); //change button text
	       $('#btnSave').attr('disabled',false); //set button enable 

	   }
	});

}




</script>