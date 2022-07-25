<div class="modal fade" id="add_user_account" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    	<div class="modal-header">
        <h5 class="modal-title" id="tlusermodal">Add User Account</h5>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        		<div class="alert alert-success d-flex align-items-center" role="alert">
						  <i class="fas fa-check-circle mr-ct-10"></i>
						  <div>
						    An example success alert with an icon
						  </div>
						</div>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="accntErr">
        		
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        		<b class="text-center">REMINDER: </b>
        		<p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
        		<hr>
        	</div>
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        		<form action="<?php echo base_url('accounts/save_account') ?>" id="frmaddaccount">
	        		<div class="row">
			        	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="form-group" >
										<label class="text-dark-custom mt-30">Last Name : </label>
										<input type="text" name="user_lname" id="user_lname" class="form-control" autocomplete="off" id="" placeholder="Enter Last Name" >
									</div>
								</div>
			        	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="form-group" >
										<label class="text-dark-custom mt-30">First Name : </label>
										<input type="text" name="user_fname" id="user_fname" class="form-control" autocomplete="off" id="" placeholder="Enter First Name" >
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="form-group" >
										<label class="text-dark-custom mt-30">Middle Name : </label>
										<input type="text" name="user_mname" id="user_mname" class="form-control" autocomplete="off" id="" placeholder="Enter First Name" >
									</div>
								</div>
								<div class="clearfix"></div>
			        	<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
									<div class="form-group" >
										<label class="text-dark-custom mt-30">Email : </label>
										<input type="text" name="user_emp_email" id="user_emp_email" class="form-control" autocomplete="off" id="" placeholder="Enter Email" >
									</div>
			        	</div>
			        	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			        		<div class="form-group" >
										<label class="text-dark-custom mt-30">Status : </label>
									</div>
			        		<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" name="blocked" id="blocked" value="0">
									  <label class="form-check-label">Active</label>
									</div>
									<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" name="blocked" id="blocked" value="1">
									  <label class="form-check-label">Disable</label>
									</div>
			        	</div>
			        	<!--   -->
			        	<div class="clearfix"></div>
			        	<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
			        		<div class="form-group" >
										<label class="text-dark-custom mt-30">College : <small>(Click Ctrl + Select to Select multiple College)</small> </label>
									</div>
									<?php echo form_dropdown('user_department[]', $college, '', "class='form-select select2' multiple id='user_department'"); ?>
								<!-- 	<select class="form-select" multiple aria-label="Default select example">
									  <option value="CCS" class="link-dark rounded">CCS</option>
										<option value="CGPP" class="link-dark rounded">CGPP</option>
										<option value="COAHS" class="link-dark rounded">COAHS</option>
										<option value="CTM" class="link-dark rounded">CTM</option>
										<option value="CHK" class="link-dark rounded">CHK</option>
										<option value="COE" class="link-dark rounded">COE</option>
										<option value="CMLI" class="link-dark rounded">CMLI</option>
										<option value="CCAPS" class="link-dark rounded">CCAPS</option>
										<option value="CCSE" class="link-dark rounded">CCSE</option>
										<option value="CAL" class="link-dark rounded">CAL</option>
										<option value="COS" class="link-dark rounded">COS</option>
										<option value="CBFS" class="link-dark rounded">CBFS</option>
										<option value="CTHM" class="link-dark rounded">CTHM</option>
										<option value="SOL" class="link-dark rounded">SOL</option>
									</select> -->
			        	</div>
			        	<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
			        		<div class="form-group" >
										<label class="text-dark-custom mt-30">Curriculum : <small>(Click Ctrl + Select to Select multiple Curriculum)</small> </label>
									</div>
									<?php echo form_dropdown('user_curriculum_ids[]', $curr, '', "class='form-select select2' multiple id='user_curriculum_ids'"); ?>
									
			        	</div>
								<div class="clearfix"></div>
			        	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label class="text-dark-custom mt-30">Username : </label>
										<input type="text" name="user_name" id="user_name" class="form-control" autocomplete="off" id="" placeholder="Enter Username" >
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label class="text-dark-custom mt-30">Password : </label>
										<input type="password" name="user_passkey" id="user_passkey" class="form-control" autocomplete="off" id="" placeholder="Enter Password" >
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label class="text-dark-custom mt-30">Re-Password : </label>
										<input type="password" name="repassword" id="repassword" class="form-control" autocomplete="off" id="" placeholder="Enter Password" >
									</div>
								</div>
	        		</div>
        		</form>
        	</div>
        </div>
      </div>
      <div class="modal-footer">
      	<center>
		    	<button type="button" id="btnsaveaccount" class="btn btn-success"><i class="fas fa-save"></i> Submit</button>
	        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
      	</center>	
      </div>
    </div>
  </div>
</div>