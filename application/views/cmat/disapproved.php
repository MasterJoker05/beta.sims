<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5">
	<form action="<?php echo base_url('Cmat/disapproved') ?>" method="post" class="row g-3" role="form">	

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
			// dump($cmat);
		?>
	<?php if (count($cmat)): ?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-hover table-bordered table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>DATE AND  TIME</th>
							<th>LAST NAME</th>
							<th>FIRST NAME</th>
							<th>MIDDLE NAME</th>
							<th>STUDENT NO</th>
							<th>CURRICULUM</th>
							<th>STATUS</th>
							<th>ACTION</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($cmat as $key => $cmat_list): ?>
						<tr>
							<td><?php echo $ctr++; ?></td>
							<td><?php echo $cmat_list->confirm_at ?></td>
							<td><?php echo $cmat_list->Lname ?></td>
							<td><?php echo $cmat_list->Fname ?></td>
							<td><?php echo $cmat_list->Mname ?></td>
							<td><?php echo $cmat_list->StudNo ?></td>
							<td><?php echo $cmat_list->CurriculumDesc ?></td>
							<td>
								<?php if (!empty($cmat_list->disapproved_note)):?>
									DISAPPROVED
								<?php elseif ($cmat_list->approved_at > 0 && $cmat_list->no_penalty = 1 ):?>
									APPROVED AND NO PENALTY
								<?php elseif ($cmat_list->approved_at > 0 && $cmat_list->no_penalty = 0 ):?>
									APPROVED AND WAITING FOR PAYMENT
								<?php elseif ($cmat_list->printed_at > 0 ):?>
									CMAT ALREADY SENT 
								<?php elseif ($cmat_list->is_regis_print > 0 ):?>
									CMAT PRINTED BY REGISTRAR
								<?php else: ?>
									WAITING FOR APPROVAL
								<?php endif ?></td>
							<td><button type="button" class="btn btn-success btn-sm">View</button></td>
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