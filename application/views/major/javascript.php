<script type="text/javascript">
$(function(){
	
 	$('#form').on('show.bs.modal', function (e) {
		
	});

	$(document).on('click', 'a.btnEdit,#btnAdd', function(e) {
		$id = $(this).attr('data-id');
		
		$('#form').data('id', $id)
		$id = $(this).attr('data-id');
		if ($id == '0')
		$id = '/';

		$.ajax({
				url: "<?php echo base_url('major/form') ?>/" + $id,
				type: 'post',
				success: function (data) {
							$('#form .ajax-body').empty().append(data.html);
						},
				cache: false,
			});
	});

	$(document).on('click', 'button[name=btnSubmit]', function() {
		$form_data = $('#frmMajor').serialize();
		console.log($form_data);
		$.ajax({
			url: $('#frmMajor').attr('action'),
			data: $form_data,
			type: 'post',
			success: function (data) {
						// console.log(data);
 						$('#form .ajax-body').empty().append(data.html);
					},
			cache: false,
		});
	});

})
</script>







<!-- <script type="text/javascript">

	$(document).ready(function(){
	
	$(document).on('click', 'button[name=btnAdd]', function() {
		
		$('#form .ajax-body').empty();

		$('#form input[name=MajorId]').val('');
		$.ajax({
				url: "<?php #echo base_url('major/form') ?>",
				type: 'get',
				success: function (data) {
							$('#form .ajax-body').append(data.html);
						},
				cache: false,
			});
	});


	$(document).on('click', 'button[name=btnSubmit]', function() {
	// $form_data = $('#frmmajor').serialize();
	// console.log(1);
	// console.log($form_data);
	 // $form_data = document.post($('#form input[name=MajorId]').val());  	 
	// document.write($('#form input[name=MajorId]').val());
	  
	  	$form_data = {

						'MajorId': $('#form input[name=MajorId]').val(),

					 };
document.write($form_data);
// $form_data = $('#form input[name=MajorCode]').val();  
		$.ajax({
			url: "<?php #echo base_url('major/confirm') ?>",
			data: $form_data,
			type: 'post',
			success: function (data) {
						console.log(data);
						// $('#form .ajax-body').empty();
						$('#form .ajax-body').append(data.html);

					},
			cache: false,
		});
		$('#form .ajax-body').empty();
	});

})
</script> -->