<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 completion-ct mt-3">
	<div class="row">
		<hr>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-check te">
			  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
			  <label class="form-check-label" for="flexCheckDefault">
			    <b>Please check to print with student details.</b>
			  </label>
			</div>
			<a href="<?php echo base_url('permanent_record/print_all/'.$student_info->StudNo.'/ALL') ?>" class="btn btn-secondary btn-sm">
			 <i class="fas fa-print"></i> Print All
			</a>

		</div>
		<?php //dump($student_grades);
			$sems = 0
		 ?>
		<?php foreach ($student_grades as $key => $sgAy): ?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 acadyr-ct">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
				<h6 class="letter-spacing-ct"><b>ACADEMIC YEAR : <?php echo $key ?></b></h6>
			</div>
			<div class="row">
				<?php
					$sems = count($sgAy);
					$cnt = 0;
					$syKey = $key;
					$SemesterList = ['First Semester','Second Semester','Summer']
				?>

				<?php foreach ($SemesterList  as $cSem => $Sem): ?>
					<?php if (isset($sgAy[$Sem])): ?>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 semester-ct" id="<?php echo $syKey.'-'.$cSem;?>">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th class="align-middle" colspan="6"><h6 class="letter-spacing-ct mb-0"><?php echo $Sem ?><a href="<?php echo base_url('permanent_record/print_all/').$student_info->StudNo.'/'.$syKey.'-'.$cSem;?> " data-bs-toggle="tooltip" data-bs-placement="top" class="float-end" title="Print"><i class="fas fa-print  text-light"></i></a></h6></th>
										</tr>
										<tr>
											<th class="align-middle text-center" width="">Course Code</th>
											<th class="align-middle text-center" width="">Final</th>
											<th class="align-middle text-center" width="">R'Val</th>
											<th class="align-middle text-center" width="">Lab</th>
											<th class="align-middle text-center" width="">R'Val</th>
											<th class="align-middle text-center" width="">Unit/s</th>
										</tr>
									</thead>
									<tbody>
										<?php $td = 14 - count($sgAy[$Sem]) ?>
										<?php foreach ($sgAy[$Sem] as $details => $sgDetails): ?>
											<tr>
												<td>

													<a tabindex="0" class="" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="top" title="<?php echo $sgDetails['CourseCode']  ?>" data-bs-content="<?php echo $sgDetails['Cfn'].' - '.$sgDetails['CourseDesc']   ?>"><b><?php echo $sgDetails['CourseCode']  ?></b></a></td>
												<td><?php echo $sgDetails['StrGrade'] ?></td>
												<td><?php echo $sgDetails['RVal'] ?></td>
												<td><?php echo $sgDetails['StrLab'] ?></td>
												<td><?php echo $sgDetails['RValLab'] ?></td>
												<td><?php echo $sgDetails['units'] ?></td>
											</tr>
										<?php endforeach ?>
										<?php if ($td): ?>
											<?php for ($i=1; $i <=$td ; $i++) : ?>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<?php endfor ?>
										<?php endif ?>
									</tbody>
								</table>
							</div>
						</div>
					<?php else: ?>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 semester-ct" id="<?php echo $syKey.'-'.$cSem;?>">
						</div>
					<?php endif ?>
				<?php endforeach ?>

			</div>
		</div>
		<?php endforeach ?>
		
	</div>
</div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">PRINT SETTINGS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<div class="row text-center">
      		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      			<h4>FRONT PAGE</h4>
      		</div>
      		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
      			<button type="button" class="btn btn-info btn-xl text-center"><i class="fas fa-print fa-xl"></i><br>ALL RECORDS</button>
      		</div>
      		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
      			<button type="button" class="btn btn-info btn-xl text-center"><i class="fas fa-print fa-xl"></i><br>TOP CENTER</button>
      		</div>
      		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
      			<button type="button" class="btn btn-info btn-xl text-center"><i class="fas fa-print fa-xl"></i><br>TOP RIGHT</button>
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>


