<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-4">
		<h4 class="letter-spacing-ct"><i class="fas fa-tasks"></i> LIST OF COURSES/SUCJECTS</h4>
	</div>
	<form class="search-form-ct row g-3" method="post" action="<?php echo base_url('course/index') ?>">
		<div class="col-auto">
    	<label for="input" class="by-ct"><b>Search By:</b></label>
	</div>

	<div class="col-auto">
	  	<select	class="form-select" name="option">
	  		<option value="CourseCode">Course Code</option>
	  		<option value="CourseDesc">Course Description</option>.
	  		<option value="Units">Units</option>
		</select>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-md-6 col-lg-6">
	  	<input class="form-control"  type="" name="Search">
	 </div>

	<div class="col-auto">
	  	<button type="submit" class="btn btn-primary btn-sm letter-spacing-ct">
	  		<i class="fas fa-search">
	  			
	  		</i>
	  		Search
	  	</button>
	  	<button type="submit" value="reset" class="btn btn-secondary btn-sm letter-spacing-ct">Reset
	  	</button>
	</div>
	</form>
	
	
	
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5">
	<div class="row">
	  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-4">
	  		<button data-bs-toggle="modal"  data-bs-target="course_modal" class="btn btn-primary btn-sm letter-spacing-ct pull-right-add">
	  			<i class="fas fa-plus"></i>
	  			Add Course
	  		</button>
	  		
	  	</div>
	  


	


	  <!-- <?php

	  		dump($course); 
	  	 ?>  -->

	  <?php if (count($course)):  ?>
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-condensed">
						<thead>

							<tr>
								<th>#</th>
								<th>Course Code</th>
								<th>Course Description</th>
								<th>Units</th>
								<th>Lab Units</th>
								<th>Status</th>
								<th>Remarks</th>
								<th>Equivalent</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<!-- Each Course -->

							<?php foreach ($course as $key => $courselist): ?>
							<tr>
								<td> <?php echo $courselist->CourseId ?> </td>
								<!-- Course Code -->
								<td> <?php echo $courselist->CourseCode ?> </td> 
								<td> <?php echo $courselist->CourseDesc ?> </td> 
								<!-- Units -->
								<td><?php echo $courselist->Units ?></td>
								<!-- Lab Units --> 
								<td>
									<?php echo $courselist->WithComputerSubject == '1' ? "<code>w/ Comp. Lab Fee</code>" : ""; ?>
									<?php echo  $courselist->RleHrs > 0 ? "<code>RleHrs: $courselist->RleHrs</code>" : ""; ?>
									<?php echo $courselist->LabUnits > 0 ? "<code> Lab Units: $courselist->LabUnits</code>" : ""; ?>
									<?php  ?>
										
								</td> 
								<!-- Status -->
								<td>Active</td> 
								<!-- Remarks -->
								<td>Remarks</td> 
								<!-- Equivalent -->
								<td>
									 <?php echo $courselist->EquivalentCourse ?> 
									 </td> 
								<td class="text-center">
									<a data-bs-toggle="modal"data-bs-target="#form" class="btn btnEdit btn-success btn-sm"data-id=""><i class="fas fa-edit"></i> Edit</a>
								 	<!-- <a href="" class="btn btn-danger btn-sm">
								 	<i class="fas fa-times"></i> Disable</a> -->
								</td>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>

				<?php echo $pagination; ?>



		

		<?php  else: ?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-condensed">
						<thead>
							<tr>
								<th>#</th>
								<th>Course Code</th>
								<th>Course Description</th>
								<th>Units</th>
								<th>Lab Units</th>
								<th>Status</th>
								<th>Remarks</th>
								<th>Equivalent</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							
							<td colspan="9">
								<div class="alert alert-danger text-center">
									<strong>No Record Found!</strong>
								</div>
							</td>

						</tbody>
					</table>
				</div>

			</div>
		<?php endif ?>
	</div>
</div>
