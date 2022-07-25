<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 completion-ct mt-3">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
			<h4 class="letter-spacing-ct mt-3"><i class="fas fa-list-ul"></i> ADDED SUBJECT</h4>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th class="align-middle text-center" width="">CFN</th>
							<th class="align-middle text-center" width="">COURSE CODE</th>
							<th class="align-middle text-center" width="">COURSE DESCRIPTION</th>
							<th class="align-middle text-center" width="">SECTION</th>
							<th class="align-middle text-center" width="">UNITS</th>
							<th class="align-middle text-center" width="">TIME</th>
							<th class="align-middle text-center" width="">DAYS</th>
							<th class="align-middle text-center" width="">ROOM</th>
						</tr>
					</thead>
					<?php // dump($cmat) ?>
					<tbody>
						<?php foreach ($cmat as $key => $row): ?>
							<tr>
								<td><?php echo ($row->cfn) ?></td>
								<td><?php echo ($row->CourseCode) ?></td>
								<td><?php echo ($row->CourseDesc) ?></td>
								<td><?php echo ($row->year_section) ?></td>
								<td><?php echo ($row->Units) ?></td>

								<?php $time = array() ?>
								<?php $days = array() ?>
								<?php $room = array() ?>

								<td>
								<?php foreach ($day as $key => $day): ?>
									<?php if ($row->{'time_start_'.$day} != "00:00:00" && $row->{'time_end_'.$day} != "00:00:00"): ?>
										<?php 
											if (isset($time[$row->{'time_start_'.$day}.":".$row->{'time_end_'.$day}])) 
											{
												$time[$row->{'time_start_'.$day}.":".$row->{'time_end_'.$day}]['days'] .= " ".$day;
												$time[$row->{'time_start_'.$day}.":".$row->{'time_end_'.$day}]['room'] .= " ".$row->{'room_id_'.$day} ;
											}
											else
											{
												$time[$row->{'time_start_'.$day}.":".$row->{'time_end_'.$day}]['days'] = $day;
												$time[$row->{'time_start_'.$day}.":".$row->{'time_end_'.$day}]['room'] = $row->{'room_id_'.$day} ;
												echo date('h:i A', strtotime($row->{'time_start_'.$day}))  . '-' .  date('h:i A', strtotime($row->{'time_end_'.$day}))."<br>";
											}
										?>
									<?php endif ?>
								<?php endforeach ?>
								</td>
									
								<td>
									<?php foreach ($time as $key => $days): ?>
										<?php echo $days['days'] ?><br>
									<?php endforeach ?>
								</td>
								<td></td>
								</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				<?php //dump($cmat) ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
			<h4 class="letter-spacing-ct mt-3"><i class="fas fa-list-ul"></i> FINAL LOAD</h4>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th class="align-middle text-center" width="">CFN</th>
							<th class="align-middle text-center" width="">COURSE CODE</th>
							<th class="align-middle text-center" width="">COURSE DESCRIPTION</th>
							<th class="align-middle text-center" width="">SECTION</th>
							<th class="align-middle text-center" width="">UNITS</th>
							<th class="align-middle text-center" width="">TIME</th>
							<th class="align-middle text-center" width="">DAYS</th>
							<th class="align-middle text-center" width="">ROOM</th>
						</tr>
					</thead>
					<?php // dump($cmat) ?>
					<tbody>
						<?php foreach ($cmat_final as $key => $row): ?>
							<tr>
								<td><?php echo ($row->cfn) ?></td>
								<td><?php echo ($row->CourseCode) ?></td>
								<td><?php echo ($row->CourseDesc) ?></td>
								<td><?php echo ($row->year_section) ?></td>
								<td><?php echo ($row->Units) ?></td>

								<?php $time = array() ?>
								<?php $days = array() ?>
								<?php $room = array() ?>

								<td>
								<?php foreach ($day2 as $key => $day): ?>
									<?php if ($row->{'time_start_'.$day} != "00:00:00" && $row->{'time_end_'.$day} != "00:00:00"): ?>
										<?php 
											if (isset($time[$row->{'time_start_'.$day}.":".$row->{'time_end_'.$day}])) 
											{
												$time[$row->{'time_start_'.$day}.":".$row->{'time_end_'.$day}]['days'] .= " ".$day;
												$time[$row->{'time_start_'.$day}.":".$row->{'time_end_'.$day}]['room'] .= " ".$row->{'room_id_'.$day} ;
											}
											else
											{
												$time[$row->{'time_start_'.$day}.":".$row->{'time_end_'.$day}]['days'] = $day;
												$time[$row->{'time_start_'.$day}.":".$row->{'time_end_'.$day}]['room'] = $row->{'room_id_'.$day} ;
												echo date('h:i A', strtotime($row->{'time_start_'.$day}))  . '-' .  date('h:i A', strtotime($row->{'time_end_'.$day}))."<br>";
											}
										?>
									<?php endif ?>
								<?php endforeach ?>
								</td>
									
								<td>
									<?php foreach ($time as $key => $days): ?>
										<?php echo $days['days'] ?><br>
									<?php endforeach ?>
								</td>
								<td></td>
								</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				<?php // dump($cmat_final) ?>
			</div>
		</div>
	</div>
</div>
