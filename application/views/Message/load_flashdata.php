<?php foreach ($this->session->flashdata() as $key => $flashdata): ?>
<!-- alert-message -->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert-ct">
		    <div class="alert alert-info">
		      <p class="mb-0">
		        <?php echo $flashdata; ?>
		      </p>    
		    </div>
	    </div>
    </div>
</div>
<!-- alert-message-end -->  
<?php endforeach ?>