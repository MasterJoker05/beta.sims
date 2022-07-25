<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<form class="search-form-ct row g-3">
		  <div class="col-auto">
	    	<label for="input" class="by-ct"><b>SEARCH BY:</b></label>
		  </div>
		  <div class="col-auto">
    		<select name="" id="input" class="form-control" required="required">
    			<option value="">Please Select.</option>
    			<option value="">Curriculum ID</option>
    			<option value="">Curriculum</option>
    		</select>
		  </div>
		  <div class="col-auto">
		  	<input type="text" name="" id="input" class="form-control" value="" placeholder="Search here..">
		  </div>
		  <div class="col-auto">
		    <button type="submit" class="btn btn-primary letter-spacing-ct"><i class="fas fa-search"></i> <b>SEARCH</b></button>
		  </div>
		</form>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-ct-55">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h4 class="letter-spacing-ct"><b><i class="fas fa-tasks"></i> LIST OF CURRICULUM</b></h4>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<table class="table table-hover table-bordered table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th>Curr ID</th>
						<th>Curriculum</th>
						<th>Year Level</th>
						<th>Number of Students</th>
						<th>Stats</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$cnt = 0;
					 foreach ($curriculum_list as $key => $currInfo):?>
						<tr>
							<td><?php echo $cnt+=1 ?></td>
							<td><?php echo $currInfo->CurriculumId ?></td>
							<td><?php echo $currInfo->CurriculumDesc ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td><a href="<?php echo base_url('student_evaluation/student_program');?>" class="btn btn-primary"><i class="fas fa-eye"></i> View</a></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
