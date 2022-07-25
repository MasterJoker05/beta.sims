<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title-ct">
			<!-- <?php //dump($_SESSION); ?> -->
    		<h3><?php echo $page_title; ?></h3>
    		<hr>
    		<small style="font-weight: bold;"><?php echo $sysem->SemDesc.' A.Y.'.$sysem->SyDesc ?></small>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
			<nav aria-label="breadcrumb" class="pull-right">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="#"><?php echo $page_title;?></a></li>
			    <li class="breadcrumb-item active">List of Curriculum</li>
			  </ol>
			</nav>
		</div>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title_reminder-ct">
	<div class="alert alert-info text-center" style="margin-top: ;">
		<strong>
			REMINDER: PLEASE BE REMINDED THAT BEFORE EVALUATING MAKE SURE THAT THE COR CHECKING IS DONE.
		</strong>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="alert alert-secondary text-center">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<i class="fas fa-users stat-icon"></i>
								<h4>10000</h4>
								<b>TOTAL STUDENTS ENROLLED</b>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="alert alert-danger text-center">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<i class="fas fa-exclamation-triangle stat-icon"></i>
								<h4>10000</h4>
								<b>DEFICIENCY</b>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="alert alert-warning text-center">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<i class="fas fa-pause-circle stat-icon"></i>
								<h4>10000</h4>
								<b>ON-HOLD</b>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="alert alert-dark text-center">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<i class="fas fa-users stat-icon"></i>
								<h4>10000</h4>
								<b>FOR EVALUATION</b>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="alert alert-success text-center">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<i class="fas fa-check-circle stat-icon"></i>
								<h4>10000</h4>
								<b>EVALUATED</b>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h3>LEGEND</h3>
	<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>CODE</th>
					<th>STATUS</th>
					<th>DESCRIPTION</th>
				</tr>
			</thead>
			<tbody>
				<tr>

					<td class="text-center"><span class="alert-danger legend-ct"><b>DF</b></span></td>
					<td class="text-center"><span class="alert-danger legend-ct"><b>DEFICIENCY</b></span></td>
					<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</td>
				</tr>
				<tr>
					<td class="text-center"><span class="alert-warning legend-ct"><b>OH</b></span></td>
					<td class="text-center"><span class="alert-warning legend-ct"><b>ON-HOLD</b></span></td>
					<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</td>
				</tr>
				<tr>
					<td class="text-center"><span class="alert-dark legend-ct"><b>FE</b></span></td>
					<td class="text-center"><span class="alert-dark legend-ct"><b>FOR EVALUATION</b></span></td>
					<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</td>
				</tr>
				<tr>
					<td class="text-center"><span class="alert-success legend-ct"><b>EV</b></span></td>
					<td class="text-center"><span class="alert-success legend-ct"><b>EVALUATED</b></span></td>
					<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<form class="search-form-ct row g-3">
	  <div class="col-auto">
    	<label for="input" class="by-ct"><b>Search Curriculum:</b></label>
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
			<h4 class="letter-spacing-ct"><b><i class="fas fa-tasks"></i> LIST OF CURRICULUM/S</b></h4>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-hover table-bordered table-condensed">
					<thead>
						<tr>
							<th >#</th>
							<th >Curriculum</th>
							<!-- <th >Year Level</th> -->
							<th >Number of
								<br> Students</th>
							<th >Status</th>
							<th >Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$cnt = 0;
						 foreach ($curriculum_list as $key => $currInfo):?>
							<tr>
								<td><?php echo $cnt+=1 ?></td>
								<td><?php echo $currInfo->CurriculumDesc ?></td>
								<!-- <td><?php //echo $this->m_enroll->get_year_level($currInfo->CurriculumId,$currInfo->CollegeId,$currInfo->LengthOfStayBySem) ?></td> -->
								<td><?php echo $currInfo->cnt ?></td>
								<td>
									<span class="alert-dark legend-ct status-ct"><b>DF - </b><span class="stat-num"><b>10004</b></span></span>
									<span class="alert-warning legend-ct status-ct"><b>OH - </b><span class="stat-num"><b>10004</b></span></span>
									<span class="alert-success legend-ct status-ct"><b>FE - </b><span class="stat-num"><b>10004</b></span></span>
									<span class="alert-danger legend-ct status-ct"><b>EV - </b><span class="stat-num"><b>10004</b></span></span>
								</td>
								<td><a href="<?php echo base_url('student_evaluation/student_program').'/'.$currInfo->CurriculumId;?>" class="btn btn-primary"><i class="fas fa-eye"></i> <b>EVALUATION</b></a></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
