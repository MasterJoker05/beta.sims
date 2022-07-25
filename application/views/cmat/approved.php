<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5">
	<form action="<?php echo base_url('Cmat/approved') ?>" method="post" class="row g-3" role="form">	

		<div class="col-auto">
			<select class="form-select" aria-label="Default select example" name = "options">
			  <option value="a.StudNo">Student Number</option>
			  <option value="Lastname">Lastname</option>
			  <option value="Firstname">Firstname</option>
			  <!-- <option value="3">Three</option> -->
			</select>
		</div>

		<div class="col-auto">
			<label for="inputPassword2" class="visually-hidden"></label>
			<input type="text" class="form-control" name="search" placeholder="Search">
		</div>
		<div class="col-auto">
			<button type="submit" class="btn btn-primary mb-2">Search</button>
		</div>
	</form>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5">
	<div class="row">
		<?php
			$segments = $this->uri->segment_array();
			$ctr = intval(end($segments))+1;
		?>
	<?php if (count($approved)): ?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-hover table-bordered table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>DATE AND TIME</th>
							<th>LAST NAME</th>
							<th>FIRST NAME</th>
							<th>MIDDLE NAME</th>
							<th>STUDENT ID</th>
							<th>CURRICULUM</th>
							<th>STATUS</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($approved as $key => $approved_cmat): ?>
						<tr>
							<td><?php echo $ctr++; ?></td>
							<td><?php echo $approved_cmat->confirm_at ?></td>
							<td><?php echo $approved_cmat->Lname ?></td>
							<td><?php echo $approved_cmat->Fname ?></td>
							<td><?php echo $approved_cmat->Mname ?></td>
							<td><?php echo $approved_cmat->StudNo ?></td>
							<td><?php echo $approved_cmat->CurriculumDesc ?></td>
							<td>
								<?php if ($approved_cmat->approved_at > 0 && $approved_cmat->no_penalty = 1 ):?>
									APPROVED AND NO PENALTY
								<?php elseif ($approved_cmat->approved_at > 0 && $approved_cmat->no_penalty = 0 ):?>
									APPROVED AND WAITING FOR PAYMENT
								<?php elseif (!empty($approved_cmat->disapproved_note)):?>
									DISAPPROVED
								<?php elseif ($approved_cmat->printed_at > 0 ):?>
									CMAT ALREADY SENT 
								<?php elseif ($approved_cmat->is_regis_print > 0 ):?>
									CMAT PRINTED BY REGISTRAR
								<?php else: ?>
									WAITING FOR APPROVAL
								<?php endif ?></td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>	
	</div>

	<?php else: ?>
		<div class="alert alert-danger text-center">
			<strong>No record found!</strong>
		</div>
	<?php endif ?>
</div>