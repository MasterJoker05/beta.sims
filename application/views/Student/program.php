<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="row">
			
		<?php if (!empty($page_title)): ?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title-ct">
    		<h3><?php echo $page_title; ?></h3>
    		<hr>
		</div>
		<?php endif ?>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
			<nav aria-label="breadcrumb" class="pull-right">
				  <ol class="breadcrumb">
				    <li class="breadcrumb-item"><a href="#"><?php echo ucwords($this->router->class) ;?></a></li>
				    <li class="breadcrumb-item active"><?php echo ucwords( $this->router->method) ?></li>
				  </ol>
				</nav>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo form_open('program', 'class="search-form-ct row g-3"'); ?>
	  <div class="col-auto">
    	<label for="input" class="by-ct"><b>Search By:</b></label>
	  </div>
	  <div class="col-auto">

	  	<?php echo form_dropdown('by', $options, set_value('by', $by), 'id="by" class="form-select"'); ?>

	  </div>
	  <div class="col-auto">

	  	<?php echo form_input('Search', set_value('search', $search), ['id' => 'Search', 'class' => 'form-control', 'placeholder'=>"Search here.."]); ?>

	  </div>
	  <div class="col-auto">
	    <?php 
		    echo form_button([
		    	'name' => 'submit',
		    	'value' => 'submit',
		    	'type' => 'submit',
		    	'class' => 'btn btn-primary letter-spacing-ct',
		    	'content' => '<i class="fas fa-search"></i> Search',
		    ]); 

		    echo form_button([
		    	'name' => 'reset_button',
		    	'value' => 'reset',
		    	'type' => 'submit',
		    	'class' => 'btn btn-secondary letter-spacing-ct',
		    	'content' => 'Reset',
		    ]); 


	    ?>
	  </div>
	<?php echo form_close(); ?>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-ct-55">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h4 class="letter-spacing-ct"><b><i class="fas fa-tasks"></i> LIST OF Program/S</b></h4>
	    	<button data-bs-toggle="modal" data-bs-target="#add_program" class="btn btn-secondary letter-spacing-ct pull-right-add"><i class="fas fa-plus"></i> Add Program</button>
		</div>

		<?php
		$segments = $this->uri->segment_array();
		$ctr = intval(end($segments))+1;
		 ?>
		<?php if (count($programs)): ?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
				<?php echo $pagination; ?>

				<div class="table-responsive">
					<table class="table table-hover table-bordered table-condensed">
						<thead>
							<tr>
								<th >#</th>
								<th >Program Code</th>
								<th >Program Name</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($programs as $program): ?>
							<tr>
								<td><?php echo $ctr++; ?></td>
								<td><?php echo $program->ProgramCode ?></td>
								<td><?php echo $program->ProgramDesc ?></td>
								<td class="text-center"><a data-bs-toggle="modal" data-bs-target="#edit_program" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
								<!-- <a href="" class="btn btn-danger"><i class="fas fa-times"></i> Disable</a>
								-->
								</td>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>

				<ul class="pagination">
					<li><a href="#">&laquo;</a></li>
					<li><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#">&raquo;</a></li>
				</ul>

			</div>
		<?php else: ?>
			<div class="alert alert-info">
				<strong>No record found</strong>
			</div>
		<?php endif ?>

	</div>
</div>

<?php $this->load->view('program/add_program'); ?>
<?php $this->load->view('program/edit_program'); ?>

<script type="text/javascript">
	$(document).ready(function(){

		$(document).on('click','#btnsaveaccount',function(){
			console.log("asdasdas");
			url = $('#frmaddaccount').attr('action');
			data = $('#frmaddaccount').serialize();

			console.log(url);
			console.log(data);

			$.ajax({
		        url: url,
		        type: "POST",
		        dataType  : 'json',
		        data: data ,
		        success: function (response) {
		        	console.log(response);

		        	if (response.Error) 
		        	{
		        		$("#accntErr").html(
		        							`
		        							<div class="alert alert-danger alert-dismissible fade show" role="alert">
		        							  <i class="fas fa-exclamation-triangle mr-ct-10"></i>
											  ${response.Msg}
											  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
		        							`
		        							)
		        	}
		           // You will get response from your PHP page (what you echo or print)
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }
		    });
		})
	})
</script>