<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 completion-ct mt-3">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
			<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#apply_hd"><i class="fas fa-hand-point-up"></i> Apply Honorable Dismissal </a>
			<h4 class="letter-spacing-ct mt-3"><i class="fas fa-list-ul"></i> HISTORY OF FILING</h4>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th class="align-middle text-center" width="">Date of Filing</th>
							<th class="align-middle text-center" width="">Academic Year</th>
							<th class="align-middle text-center" width="">Semester</th>
							<th class="align-middle text-center" width="">Staff</th>
							<th class="align-middle text-center" width="">Name of School</th>
							<th class="align-middle text-center" width="">School Address</th>
							<th class="align-middle text-center" width="">College of</th>
							<th class="align-middle text-center" width="">Status</th>
							<th class="align-middle text-center" width="">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo 'April 05, 2022'; ?></td>
							<td><?php echo '2021-2022'; ?></td>
							<td><?php echo '2nd Sem.'; ?></td>
							<td><?php echo 'Sample Test'; ?></td>
							<td><?php echo ''; ?></td>
							<td><?php echo ''; ?></td>
							<td><?php echo ''; ?></td>
							<td><?php echo 'Pending'; ?></td>
							<td>
								<center>
									<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_hd"><i class="fas fa-edit"></i> Edit</a>
									<a href="#" class="btn btn-secondary btn-sm" ><i class="fas fa-print"></i> Print</a>
								</center>
							</td>
						</tr>
					</tbody>
				</table>
				<?php dump($stud_hd) ?>
			</div>
		</div>
	</div>
</div>



<!--Apply LOA Modal -->
<div class="modal fade" id="apply_hd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">APPLYING HONORABLE DISMISSAL</h5>
      </div>
      <div class="modal-body">
        <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-2">
						<div class="form-floating">
							<input type="date" class="form-control" id="floatingInputValue" value="">
							<label for="floatingInputValue">DATE OF APPLICATION:</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-2">
						<div class="form-floating">
							<input type="text" class="form-control" id="floatingInputValue" value="">
							<label for="floatingInputValue">CONTACT NUMBER:</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
						<label for="reason" class="form-label mb-0"><b>NAME OF SCHOOL:</b></label>
						<input type="text" class="form-control" id="floatingInputValue" value="">
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
						<label for="reason" class="form-label mb-0"><b>SCHOOL ADDRESS:</b></label>
						<input type="text" class="form-control" id="floatingInputValue" value="">
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
						<label for="reason" class="form-label mb-0"><b>COLLEGE OF:</b></label>
						<input type="text" class="form-control" id="floatingInputValue" value="">
					</div>
					<div class="clearfix"></div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" 
        				style="text-transform: capitalize;"
        			  class="btn btn-primary btn-sm" 
        			 	data-bs-target="#confirmation_modal" 
        			  data-bs-toggle="modal" >
        	Save
        </button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--Edit LOA Modal -->
<div class="modal fade" id="edit_hd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">APPLYING HONORABLE DISMISSAL</h5>
      </div>
      <div class="modal-body">
        <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-2">
						<div class="form-floating">
							<input type="date" class="form-control" id="floatingInputValue" value="">
							<label for="floatingInputValue">DATE OF APPLICATION:</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-2">
						<div class="form-floating">
							<input type="text" class="form-control" id="floatingInputValue" value="">
							<label for="floatingInputValue">CONTACT NUMBER:</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
						<label for="reason" class="form-label mb-0"><b>NAME OF SCHOOL:</b></label>
						<input type="text" class="form-control" id="floatingInputValue" value="">
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
						<label for="reason" class="form-label mb-0"><b>SCHOOL ADDRESS:</b></label>
						<input type="text" class="form-control" id="floatingInputValue" value="">
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
						<label for="reason" class="form-label mb-0"><b>COLLEGE OF:</b></label>
						<input type="text" class="form-control" id="floatingInputValue" value="">
					</div>
					<div class="clearfix"></div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
					<h5>STATUS</h5>

					<div class="form-check">
					  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
					  <label class="form-check-label" for="exampleRadios1">
					    Pending
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
					  <label class="form-check-label" for="exampleRadios2">
					    Cancel
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
					  <label class="form-check-label" for="exampleRadios2">
					    Done
					  </label>
					</div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" 
        				style="text-transform: capitalize;"
        			  class="btn btn-primary btn-sm" 
        			 	data-bs-target="#confirmation_modal" 
        			  data-bs-toggle="modal" >
        	Save
        </button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
		


<!--Success Modal -->
<div class="modal fade" id="success_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">SUCCESS</h5>
      </div> -->
      <div class="modal-body">
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        		<h2 class="text-center text-success">SUCCESS</h2>
        		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
        	</div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!--Revert Completion Modal -->
<div class="modal fade" id="revert_completion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">REVERT COMPLETION</h5>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mt-2">
        		<div class="form-floating">
				  <input type="text" class="form-control" id="floatingInputValue" value="A12345678" readonly>
				  <label for="floatingInputValue">CFN</label>
				</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mt-2">
        		<div class="form-floating">
				  <input type="text" class="form-control" id="floatingInputValue" value="FILIPINO 101" readonly>
				  <label for="floatingInputValue">COURSE CODE</label>
				</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        		<div class="form-floating">
				  <input type="text" class="form-control" id="floatingInputValue" value="" readonly>
				  <label for="floatingInputValue">COURSE TITLE</label>
				</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        		<div class="row">
        			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-2">
        				<div class="form-floating">
						  <input type="text" class="form-control" id="floatingInputValue" value="1.00" readonly>
						  <label for="floatingInputValue">LECTURE</label>
						</div>
        			</div>
        			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-2">
        				<div class="form-floating">
						  <input type="text" class="form-control" id="floatingInputValue" value="" readonly>
						  <label for="floatingInputValue">LABORATORY</label>
						</div>
        			</div>
        			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        				<div class="form-floating">
						  <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
						  <label for="floatingTextarea2">REVERT REASON</label>
						</div>
        			</div>
        		</div>
        	</div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-primary btn-sm" data-bs-target="#revert_confirmation" data-bs-toggle="modal">Submit</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--Revert Confirmation Modal -->
<div class="modal fade" id="revert_confirmation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">REVERT CONFIRMATION</h5>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        		<p class="text-center"><b>ARE YOU SURE YOU WANT TO REVERT THIS COMPLETION ?</b></p>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mt-2">
        		<div class="form-floating">
				  <input type="text" class="form-control" id="floatingInputValue" value="A12345678" readonly>
				  <label for="floatingInputValue">CFN</label>
				</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mt-2">
        		<div class="form-floating">
				  <input type="text" class="form-control" id="floatingInputValue" value="FILIPINO 101" readonly>
				  <label for="floatingInputValue">COURSE CODE</label>
				</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        		<div class="form-floating">
				  <input type="text" class="form-control" id="floatingInputValue" value="" readonly>
				  <label for="floatingInputValue">COURSE TITLE</label>
				</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        		<div class="row">
        			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-2">
        				<div class="form-floating">
						  <input type="text" class="form-control" id="floatingInputValue" value="1.00" readonly>
						  <label for="floatingInputValue">LECTURE</label>
						</div>
        			</div>
        			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-2">
        				<div class="form-floating">
						  <input type="text" class="form-control" id="floatingInputValue" value="" readonly>
						  <label for="floatingInputValue">LABORATORY</label>
						</div>
        			</div>
        			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
        				<div class="form-floating">
						  <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" readonly>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</textarea>
						  <label for="floatingTextarea2">REVERT REASON</label>
						</div>
        			</div>
        		</div>
        	</div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-primary btn-sm" data-bs-target="#success_modal" data-bs-toggle="modal">Yes</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-target="#revert_completion" data-bs-toggle="modal">No</button>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".ot-div").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".ot-div").hide();
            }
        });
    }).change();
});
</script>