<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-4">
		<h4 class="letter-spacing-ct"><i class="fas fa-tasks"></i> LIST OF CURRICULUM/S</h4>
	</div>
	<?php echo form_open('curriculum', 'class="search-form-ct row g-3"'); ?>
	  <div class="col-auto">
    	<label for="input" class="by-ct"><b>Search By:</b></label>
	  </div>
	  <div class="col-auto">

	  	<?php echo form_dropdown('by', $options, set_value('by', $by), 'id="by" class="form-select"'); ?>

	  </div>
	  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

	  	<?php echo form_input('Search', set_value('search', $search), ['id' => 'Search', 'class' => 'form-control', 'placeholder'=>"Search here.."]); ?>

	  </div>
	  <div class="col-auto">
	    <?php 
		    echo form_button([
		    	'name' => 'submit',
		    	'value' => 'submit',
		    	'type' => 'submit',
		    	'class' => 'btn btn-primary btn-sm letter-spacing-ct',
		    	'content' => '<i class="fas fa-search"></i> Search',
		    ]); 

		    echo form_button([
		    	'name' => 'reset_button',
		    	'value' => 'reset',
		    	'type' => 'submit',
		    	'class' => 'btn btn-secondary btn-sm letter-spacing-ct',
		    	'content' => 'Reset',
		    ]); 


	    ?>
	  </div>
	<?php echo form_close(); ?>
</div>
		
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5">
	<div class="row">
		<?php //dump($curriculums); ?>
		<?php
		$segments = $this->uri->segment_array();
		$ctr = intval(end($segments))+1;
		 ?>
		<?php if (count($curriculums)): ?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				

				<div class="table-responsive">
					<table class="table table-hover table-bordered table-condensed">
						<thead>
							<tr>
								<th >#</th>
								<th >College Code</th>
								<th >Curriculum Id</th>
								<th >Curriculum</th>
								<th >Program Id</th>
								<th >Major Id</th>
								<th >No. of Sem.</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($curriculums as $curriculum): ?>
							<tr>
								<td><?php echo $ctr++; ?></td>
								<td><?php echo $curriculum->CollegeCode ?></td>
								<td><?php echo $curriculum->CurriculumId ?></td>
								<td><?php echo $curriculum->CurriculumDesc ?></td>
								<td><?php echo $curriculum->ProgramId ?></td>
								<td><?php echo $curriculum->MajorId ?></td>
								<td><?php echo $curriculum->NoOfSem ?></td>
								<td class="text-center"><a data-bs-toggle="modal" data-bs-target="#edit_college" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
								<!-- <a href="" class="btn btn-danger"><i class="fas fa-times"></i> Disable</a>
								-->
								</td>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>

				<?php echo $pagination; ?>
				
			</div>
		<?php else: ?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-condensed">
						<thead>
							<tr>
								<th >#</th>
								<th >College Code</th>
								<th >Curriculum Id</th>
								<th >Curriculum</th>
								<th >Program Id</th>
								<th >Major Id</th>
								<th >No. of Sem.</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="8">
									<div class="alert alert-danger text-center">
										<strong>No record found!</strong>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		<?php endif ?>

	</div>
</div>

<?php // $this->load->view('college/add_college'); ?>
<?php // $this->load->view('college/edit_college'); ?>

<!-- <script type="text/javascript">
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
 -->