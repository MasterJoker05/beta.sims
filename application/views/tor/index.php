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
		<?php // dump($student_grades);?>
		<div class="table-responsive">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th class="text-center" colspan="2">COURSE</th>
						<th class="text-center">GRADE</th>
						<th class="text-center">COMPLETION</th>
						<th class="text-center">CREDITS</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($student_grades as $key => $sgAy): ?>
						<?php foreach ($sgAy as $sgSemKey => $sgSem): ?>
							<tr>
								<td colspan="5"><?php echo $sgSemKey ?>.,Academic Year <?php echo $key ?></td>
							</tr>
							<?php foreach ($sgSem as $details => $sgDetails): ?>
								<tr>
									<td><?php echo $sgDetails['CourseCode']  ?></td>
									<td><?php echo $sgDetails['CourseDesc']  ?></td>
									<td><?php echo $sgDetails['StrGrade']  ?></td>
									<td><?php echo $sgDetails['RVal']  ?></td>
									<td><?php echo $sgDetails['units']  ?></td>
								</tr>
							<?php endforeach ?>
						<?php endforeach ?>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
		
	</div>
</div>
