<?php echo form_open($formUrl, 'class="form-horizontal" role="form" id="frmCollege"'); ?>

	<?php //dump($formUrl); ?>

	<?php if (validation_errors()): ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="alert alert-danger">
			<strong><?php echo validation_errors() ?></strong>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php endif ?>

	<?php //dump($college) ?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group mt-3">
			<label><b>COLLEGE CODE :</b></label>
			<input type="text-center" class="form-control " id="CollegeCode" placeholder="College Code" name="CollegeCode" value="<?php echo set_value('CollegeCode', $college->CollegeCode) ?>">
		</div>
		<div class="form-group mt-3">
			<label><b>COLLEGE NAME :</b></label>
			<input type="text-center" class="form-control " id="CollegeDesc" placeholder="College Name" name="CollegeDesc" value="<?php echo set_value('CollegeDesc', $college->CollegeDesc) ?>">
		</div>
	</div>
	
	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
		<hr>
		<div class="form-button">
			<?php 
				echo form_hidden('CollegeId', '');
				echo form_button([
					'name' => 'btnSubmit',
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