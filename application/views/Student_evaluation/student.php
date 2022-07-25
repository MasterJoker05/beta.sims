<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 stud_curr_history-ct mt-3">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">

			<h5 class="letter-spacing-ct">CURRICULUM HISTORY:</h5>
			<div class="table-responsive">
				<table class="table table-bordered table-condensed table-striped table-hover">
					<thead>
						<tr>
							<th>Curriculum</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $student_info->CurriculumDesc ?></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
			<h5 class="letter-spacing-ct">ENROLLMENT HISTORY:</h5>
			<?php echo $enrollment_trans; ?>

		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 stud_applied-ct">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
			<div class="alert alert-secondary" role="alert">
				<h5 class="letter-spacing-ct">STUDENT APPLIED FOR:</h5>
				<div class="badge rounded-pill bg-light text-dark">LEAVE OF ABSENCE</div>
				<div class="badge rounded-pill bg-light text-dark">HONORABLE DISMISSAL</div>
				<div class="badge rounded-pill bg-light text-dark">WITHDRAW CREDENTIALS</div>
			</div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 stud_adm_requirements-ct">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
			<div class="alert alert-secondary" role="alert">
				<h5 class="letter-spacing-ct">ADMISSION REQUIREMENTS:</h5>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
					<label class="form-check-label" for="inlineCheckbox1">FORM 137</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
					<label class="form-check-label" for="inlineCheckbox1">BIRTH CERTIFICATE</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
					<label class="form-check-label" for="inlineCheckbox1">HONORABLE DISMISSAL FROM OTHER SCHOOL</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
					<label class="form-check-label" for="inlineCheckbox1">TOR (TRANSFEREE ONLY)</label>
				</div>
			 </div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 stud_category-ct">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
			<div class="table-responsive">
				<table class="table table-bordered table-condensed table-striped table-hover">
					<thead>
						<tr>
							<th width="50%">Categories</th>
							<th width="50%">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>MULTIPLE GRADES (DO NOT SHOW IF EMPTY)</td>
							<td class="text-center"><a href="#" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>DEFICIENCIES (NEGATIVE GRADES)</td>
							<td class="text-center"><a href="#" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>AMMENDMENT</td>
							<td class="text-center"><a href="#" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>COMPLETION</td>
							<td class="text-center"><a href="<?php echo base_url('completion/').get_key($student_info,'StudNo') ?>" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>CREDIT OR ADD SUBJECTS FROM OTHER SCHOOL</td>
							<td class="text-center"><a href="#" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>CURRENTLY ENROLLED SUBJECT/S</td>
							<td class="text-center"><a href="#" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>CURRICULUM</td>
							<td class="text-center"><a href="<?php echo base_url('student_curriculum/student/').get_key($student_info,'StudNo') ?>" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>ACCOUNTABILITIES</td>
							<td class="text-center"><a href="#" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>LEAVE OF ABSENCE</td>
							<td class="text-center"><a href="<?php echo base_url('leave_of_absence/').get_key($student_info,'StudNo') ?>" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>HONORABLE DISMISSAL</td>
							<td class="text-center"><a href="<?php echo base_url('honorable_dismissal/').get_key($student_info,'StudNo') ?>" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>WITHDRAW CREDENTIALS</td>
							<td class="text-center"><a href="<?php echo base_url('withdraw_credentials/').get_key($student_info,'StudNo') ?>" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>GWA COMPUTATION</td>
							<td class="text-center"><a href="#" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>PERMANENT RECORDS</td>
							<td class="text-center"><a href="<?php echo base_url('permanent_record/').get_key($student_info,'StudNo') ?>" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
						<tr>
							<td>TRANSCRIPT OF RECORDS</td>
							<td class="text-center"><a href="<?php echo base_url('tor/').get_key($student_info,'StudNo') ?>" class="btn btn-primary btn-sm letter-spacing-ct"><i class="fas fa-eye"></i> View</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 stud_category-ct">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
			<div class="table-responsive">
				<table class="table table-bordered table-condensed table-striped table-hover">
					<thead>
						<tr>
							<th width="50%">Action Logs</th>
							<th width="50%">Date and Time</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>TEST SAMPLE</td>
							<td>OCTOBER 12, 2021 10:10 AM</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 stud_category-ct">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
			<center>
				<a href="#" class="btn btn-success btn-lg letter-spacing-ct"><i class="fas fa-save"></i> Save</a>
			</center>
		</div>
	</div>
</div>
