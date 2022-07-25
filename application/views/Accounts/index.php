<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-4">
		<h4 class="letter-spacing-ct"><i class="fas fa-tasks"></i> LIST OF ACCOUNTS</h4>
	</div>
		<?php echo form_open('accounts', 'class="search-form-ct row g-3"'); ?>
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
		    	'name' => 'submit',
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
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-4">
	    	<button data-bs-toggle="modal" data-bs-target="#add_user_account" onclick="$('#tlusermodal').html('Add User Account')" class="btn btn-secondary btn-sm letter-spacing-ct pull-right-add"><i class="fas fa-plus"></i> Add User</button>
		</div>
		<?php
		$segments = $this->uri->segment_array();
		$ctr = intval(end($segments))+1;
		 ?>
		<?php if (count($users)): ?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-hover table-bordered table-condensed">
					<thead>
						<tr>
							<th >#</th>
							<th >Username</th>
							<th >Last Name</th>
							<th >First Name</th>
							<th >Middle Name</th>
							<th >Email</th>
							<th >Status</th>
							<th >Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($users as $key => $userVal): ?>
							<tr>
								<td><?php echo $userVal->user_id ?></td>
								<td><?php echo $userVal->user_name ?></td>
								<td><?php echo $userVal->user_lname ?></td>
								<td><?php echo $userVal->user_fname ?></td>
								<td><?php echo $userVal->user_mname ?></td>
								<td><?php echo $userVal->user_emp_email ?></td>
								<td class="text-center">
									<span class="alert-success legend-ct status-ct"><b>Active</b></span></span>
								</td>
								<td class="text-center"><a data-bs-toggle="modal" id="btn_edit_user_account" data-bs-target="#add_user_account" data-id="<?php echo $userVal->user_id  ?>" class="btn btn-success" data-url="<?php echo base_url('accounts/save_account').'/'.$userVal->user_id ?>"><i class="fas fa-edit"></i> Edit</a>
								<!-- <a href="" class="btn btn-danger"><i class="fas fa-times"></i> Disable</a></td> -->
							</tr>
						<?php endforeach ?>
						
					</tbody>
				</table>
			</div>
		</div>
		<?php else: ?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-condensed">
						<thead>
							<tr>
								<th >#</th>
								<th >Username</th>
								<th >Last Name</th>
								<th >First Name</th>
								<th >Middle Name</th>
								<th >Email</th>
								<th >Status</th>
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

<script type="text/javascript">
	$(document).ready(function(){
		var success = new bootstrap.Modal(document.getElementById('modal_success'), {
		  keyboard: false
		})

		var loading = $('#loading')
		
		$(document).on('click','#btnsaveaccount',function(){
			console.log("asdasdas");

			// loading.show();

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
					
					$("#add_user_account").modal('hide');
					// loading.modal('hide');
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
					loading.hide();

		        }
		    });
		})

		$(document).on('click','#btn_edit_user_account',function(){

			$("#tlusermodal").html("Edit User Account");
			url = "<?php echo base_url('accounts/get_account_information') ?>";
			id = $(this).data('id')
			link = $(this).data('url')
			// loading.show();

			console.log(url)
			console.log(id)

			$.ajax({
		        url: url,
		        type: "POST",
		        dataType  : 'json',
		        data: {id:id} ,
		        success: function (response) {
		        	console.log(link);

		        	var department_ids = response.user_department.split(',')
		        	var curriculum_ids = response.user_curriculum_ids.split(',')
		        	console.log(department_ids);
		        	console.log(curriculum_ids);

		        	$('#user_fname').val(response.user_fname);
		        	$('#user_lname').val(response.user_lname);
		        	$('#user_mname').val(response.user_mname);
		        	$('#user_emp_email').val(response.user_emp_email);
		        	$('#user_passkey').val(response.user_passkey);
		        	$('#repassword').val(response.user_passkey);
		        	$('#user_fname').val(response.user_fname);
		        	$('#user_name').val(response.user_name);

		        	$("input[name=blocked][value=" + response.blocked + "]").prop('checked', true)
		        	$("#user_curriculum_ids").val(department_ids).trigger("change");
		        	$("#user_department").val(curriculum_ids).trigger("change");
		        	$('#frmaddaccount').attr('action',link)
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		          	console.log(textStatus, errorThrown);
					// loading.hide();

		        }
		    });
		})
	})
</script>