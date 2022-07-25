<?php //dump($_POST) ?>
<?php echo form_open($formUrl, 'class="form-horizontal" role="form"'); ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h4>Please confirm the following data before saving.</h4>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group mt-3">
			<label><b>COLLEGE CODE :</b></label>
			<label class="form-control" disabled>
		    	<?php 
		    		echo $this->input->post('CollegeCode', TRUE); 
		    		echo form_hidden('CollegeCode', $this->input->post('CollegeCode', TRUE));
		    	?>
		    </label>
		</div>
		<div class="form-group mt-3">
			<label><b>COLLEGE NAME :</b></label>
			<label class="form-control" disabled>
		    	<?php 
		    		echo $this->input->post('CollegeDesc', TRUE); 
		    		echo form_hidden('CollegeDesc', $this->input->post('CollegeDesc', TRUE));
		    	?>
		    </label>
		</div>
	</div>

	<!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

		<h3>Please confirm the following data before saving</h3>
		<div class="form-group">
			<div class="col-auto">
			    <label class="col-form-label">College Code</label>
			</div>
			<div class="col-auto">
			    <label class="form-control" disabled>
			    	<?php 
			    		// echo $this->input->post('CollegeCode', TRUE); 
			    		// echo form_hidden('CollegeCode', $this->input->post('CollegeCode', TRUE));
			    	?>
			    </label>
			</div>
		</div>
		<div class="form-group">
			<label>College Name : </label>
			<div class="col-auto">
			    <label class="form-control" disabled>
			    	<?php 
			    		// echo $this->input->post('CollegeDesc', TRUE); 
			    		// echo form_hidden('CollegeDesc', $this->input->post('CollegeDesc', TRUE));
			    	?>
			    </label>
			</div>
		</div>
	</div >
	-->
	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
		<hr>
		<div class="form-button">
			<?php 
				echo form_button([
					'name' => 'btnConfirm',
					'value' => 'confirm',
					'type' => 'submit',
					'class' => 'btn btn-primary btn-sm letter-spacing-ct',
					'content' => '<i class="fas fa-check"></i> Confirm',
				]);
				echo form_button([
					'name' => 'btnClose',
					'value' => 'close',
					'type' => 'button',
					'class' => 'btn btn-secondary btn-sm letter-spacing-ct',
					'data-bs-dismiss' => 'modal',
					'content' => '<i class="fas fa-times"></i> Close',
				]);
			 ?>
		</div>
	</div>
<?php echo form_close(); ?>