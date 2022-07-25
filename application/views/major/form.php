<?php echo form_open('major/confirm', 'class="form-horizontal" role="form" id="frmMajor"'); ?>
	<?php if (validation_errors()): ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="alert alert-danger">
			<strong><?php echo validation_errors() ?></strong>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php endif ?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group mb-3">
			<label><b>PROGRAM : </b></label>
	  		<?php echo form_dropdown('ProgramId', $program_options, set_value('ProgramId', NULL), 'id="ProgramId" class="form-select"'); ?>
		</div>
		<div class="form-group mb-3">
			<label><b>MAJOR CODE : </b></label>
			<input type="text-center" class="form-control" name="MajorCode" placeholder="Enter Major Code Here">

		</div>
		<div class="form-group mb-3">
			<label><b>MAJOR DESCRIPTION : </b></label>
			<input type="text-center" class="form-control" name="MajorDesc" placeholder="Enter Major Name Here">
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
		<hr>
		<div class="form-button">
			<?php 
				echo form_hidden('MajorId', '');
				echo form_button([
					'name' => 'btnSubmit',
					// 'name' => 'btnAdd',
					'value' => 'submit',
					'type' => 'button',
					'class' => 'btn btn-primary btn-sm letter-spacing-ct',
					'content' => '<i class="fas fa-save"></i> Save',
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