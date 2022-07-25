<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="card card_min618">
			<div class="card-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h5 class="card-title">
							<?php echo $page_title; ?>
					<!-- 	<?php //if ($this->uri->segment(1) =='completion'): ?>

						<?php //elseif($this->uri->segment(2) =='student_program'): ?>
							(<?php //echo $curriculum_list[0]->CollegeCode?>)
							<br>
							<small><?php echo $curriculum_list[0]->CurriculumDesc?></small>
						<?php //else: ?>
							(<?php //echo isset($student_info[0]->CollegeCode)?>)
						<?php //endif ?> -->
						</h5>
			    		<small style="font-weight: bold;"><?php echo $sysem['SemDesc'].' A.Y.'.$sysem['SyDesc'] ?></small>
						<hr>
			    		<?php //dump($curriculum_list[0]) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
						<nav aria-label="breadcrumb" class="float-end">
						  <ol class="breadcrumb">
						  <!-- 	<?php //if ($this->uri->segment(1) =='completion'): ?>
								<li class="breadcrumb-item"><a href="<?php //echo base_url('student_evaluation/'.$student_info[0]->CollegeCode)?>"><?php //echo $student_info[0]->CollegeCode?></a></li>
							    <li class="breadcrumb-item"><a href="<?php //echo base_url('student_evaluation/student_program/'.$student_info[0]->CollegeCode.'/'.$student_info[0]->CurriculumId)?>"><?php //echo $student_info[0]->CurriculumDesc?></a></li>
							    <li class="breadcrumb-item active">COMPLETION</li>

							<?php //else: ?>
							    <li class="breadcrumb-item"><a href="<?php //echo base_url('student_evaluation/'.$student_info[0]->CollegeCode)?>"><?php //echo $student_info[0]->CollegeCode?></a></li>
							    <li class="breadcrumb-item"><a href="<?php //echo base_url('student_evaluation/student_program/'.$student_info[0]->CollegeCode.'/'.$student_info[0]->CurriculumId)?>"><?php //echo $student_info[0]->CurriculumDesc?></a></li>
							    <li class="breadcrumb-item active">LIST OF STUDENTS</li>
						  	<?php //endif ?> -->
						  </ol>
						</nav>
					</div>
					<?php $this->load->view('Message/load_flashdata'); ?>
					<?php $this->load->view('Student/student_information'); ?>
					<?php $this->load->view($content); ?> 
				</div>
			</div>
		</div>
	</div>
</div>