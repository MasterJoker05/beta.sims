<!--Apply LOA Modal -->
<div class="modal fade" id="apply_loa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">APPLYING LEAVE OF ABSENCE</h5>
      </div>
      <div class="modal-body">
      	<form action="<?php echo base_url('leave_of_absence/'.$student_info->StudNo) ?>" method="POST" role="form">
        <div class="row">
        	<input type="hidden" name="StudNo" id="inputStudNo" class="form-control" value="<?php echo $student_info->StudNo ?>">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-2">
						<div class="form-floating">
							<input type="date" class="form-control" id="floatingInputValue" name="date_filed" min="<?php echo date('Y-m-d') ?>" required>
							<label for="floatingInputValue">DATE OF APPLICATION:</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-2">
						<div class="form-floating">
							<input type="text" class="form-control" id="floatingInputValue" name="contact" required>
							<label for="floatingInputValue">CONTACT NUMBER:</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
						<div class="form-floating">
						  <input type="text" class="form-control" id="floatingInput" name="guardian" required>
						  <label for="floatingInput">GUARDIAN</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
						<div class="form-floating">
						  <textarea class="form-control" name="reason" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
						  <label for="floatingTextarea2">REASON:</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<hr>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-2">
						<h5>LOA FROM</h5>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-floating">
	  		  				<?php echo form_dropdown('LoaStartSemId', $sem, set_value('LoaStartSemId', NULL), 'id="LoaStartSemId" class="form-select" required'); ?>
								  <label for="floatingSelect">SEMESTER FROM:</label>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-floating">
	  		  					<?php echo form_dropdown('LoaStartSyId', $sy, set_value('LoaStartSyId', NULL), 'id="LoaStartSyId" class="form-select" required'); ?>
									  <label for="floatingSelect">ACADEMIC YEAR FROM:</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-2">
						<h5>LOA TO</h5>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-floating">
	  		  				<?php echo form_dropdown('LoaEndSemId', $sem, set_value('LoaEndSemId', NULL), 'id="LoaEndSemId" class="form-select" required'); ?>
								  <label for="floatingSelect">SEMESTER TO:</label>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
								<div class="form-floating">
	  		  				<?php echo form_dropdown('LoaEndSyId', $sy, set_value('LoaEndSyId', NULL), 'id="LoaEndSyId" class="form-select" required'); ?>
								  <label for="floatingSelect">ACADEMIC YEAR TO:</label>
								</div>
							</div>
						</div>
					</div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="submit" name="btn_apply_loa" value="apply_loa" 
        				style="text-transform: capitalize;"
        			  class="btn btn-primary btn-sm">
        	<i class="fas fa-save"></i> Save
        </button>
        <button type="reset" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
        	<i class="fas fa-times"></i> Close
        </button>
      	</form>
      </div>
    </div>
  </div>
</div>