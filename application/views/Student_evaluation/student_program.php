<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title_reminder-ct mt-3">
	<div class="alert alert-info text-center" style="margin-top: ;">
		<strong>
			REMINDER: PLEASE BE REMINDED THAT BEFORE EVALUATING MAKE SURE THAT THE COR CHECKING IS DONE.
		</strong>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<form class="search-form-ct row g-3">
	  <div class="col-auto">
    	<label for="input" class="by-ct"><b>Search Student:</b></label>
	  </div>
	  <div class="col-auto">
	  	<select class="form-select" aria-label="Default select example">
		  <option value="1">Student No.</option>
		  <option value="2">Last Name</option>
		  <option value="3">Fisrt Name</option>
		</select>
	  </div>

	  <div class="col-auto">
	  	<input type="text" name="" id="input" class="form-control" value="" placeholder="Search here..">
	  </div>
	  <div class="col-auto">
	    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Search</button>
	  </div>
	</form>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h4 class="letter-spacing-ct"><i class="fas fa-tasks"></i> LIST OF STUDENT/S</h4>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-hover table-bordered table-condensed">
					<thead>
						<tr>
							<th >#</th>
							<th >Student No</th>
							<th >Name</th>
							<th >Year Level</th>
							<th >Status</th>
							<th >Action</th>
						</tr>
					</thead>
					<tbody>
						<?php //dump($student_list) ?>
						<?php
							$cnt = 0;
						 foreach ($student_list as $key => $studentInfo):?>
							<tr>
								<td><?php echo $cnt+=1 ?></td>
								<td><?php echo $studentInfo->StudNo; ?></td>
								<td><?php echo $studentInfo->Lname.', '.$studentInfo->Fname.' '.substr($studentInfo->Mname,0,1); ?></td>
								<td><?php echo $this->m_enroll->get_year_level($studentInfo->CurriculumId,$studentInfo->CollegeId,$studentInfo->LengthOfStayBySem) ?></td>
								<td>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<span class="badge alert-dark legend-ct status-ct"><b>FOR EVALUATION</b></span>
										</div>
										<!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<span class="badge alert-warning legend-ct status-ct"><b>ON-HOLD</b></span>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<span class="badge alert-danger legend-ct status-ct"><b>DEFICIENCY</b></span>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<span class="badge alert-success legend-ct status-ct"><b>EVALUATED</b></span>
										</div> -->
									</div>
								</td>
								<td><a href="<?php echo base_url('student_evaluation/student').'/'.$studentInfo->StudNo;?>" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</a></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<nav aria-label="Page navigation example">
			  <ul class="pagination justify-content-center">
			    <li class="page-item disabled">
			      <a class="page-link">Previous</a>
			    </li>
			    <li class="page-item"><a class="page-link" href="#">1</a></li>
			    <li class="page-item"><a class="page-link" href="#">2</a></li>
			    <li class="page-item"><a class="page-link" href="#">3</a></li>
			    <li class="page-item">
			      <a class="page-link" href="#">Next</a>
			    </li>
			  </ul>
			</nav>
		</div>
	</div>
</div>
