<?php echo form_open($formUrl, 'class="form-horizontal" role="form"' ); ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h4>Please confirm the following data before saving.</h4>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group mt-3">
			<label><b>PROGRAM : </b></label>
		    <label class="form-control" disabled>
		    	<?php 
		    		echo $program_options[$this->input->post('ProgramId', TRUE)]; 
		    		echo form_hidden('ProgramId', $this->input->post('ProgramId', TRUE));
		    	?>
		    </label>
			</div>
		</div>
		<div class="form-group mt-3">
			<label><b>MAJOR CODE : </b></label>

		    <label class="form-control" disabled>
		    	<?php 
		    		echo $this->input->post('MajorCode', TRUE); 
		    		echo form_hidden('MajorCode', $this->input->post('MajorCode', TRUE));
		    	?>
		    </label>

		</div>
		<div class="form-group mt-3">
			<label><b>MAJOR DESCRIPTION : </b></label>
		    <label class="form-control" disabled>
		    	<?php 
		    		echo $this->input->post('MajorDesc', TRUE); 
		    		echo form_hidden('MajorDesc', $this->input->post('MajorDesc', TRUE));
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