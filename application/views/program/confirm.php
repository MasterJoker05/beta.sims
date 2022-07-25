<?php //dump($_POST) ?>
<?php echo form_open($formUrl, 'class="form-horizontal" role="form"'); ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h4>Please confirm the following data before saving.</h4>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group mt-3">
			<label><b>COLLEGE CODE : </b></label>
		    <label class="form-control" disabled>
		    	<?php 
		    		echo $college_options[$this->input->post('CollegeId', TRUE)]; 
		    		echo form_hidden('CollegeId', $this->input->post('CollegeId', TRUE));
		    	?>
		    </label>
			</div>
		</div>
		<div class="form-group mt-3">
			<label><b>PROGRAM CODE : </b></label>

		    <label class="form-control" disabled>
		    	<?php 
		    		echo $this->input->post('ProgramCode', TRUE); 
		    		echo form_hidden('ProgramCode', $this->input->post('ProgramCode', TRUE));
		    	?>
		    </label>

		</div>
		<div class="form-group mt-3">
			<label><b>PROGRAM DESCRIPTION : </b></label>
		    <label class="form-control" disabled>
		    	<?php 
		    		echo $this->input->post('ProgramDesc', TRUE); 
		    		echo form_hidden('ProgramDesc', $this->input->post('ProgramDesc', TRUE));
		    	?>
		    </label>
		</div>
	</div>
	
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