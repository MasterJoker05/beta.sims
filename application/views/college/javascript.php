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
				url: "<?php echo base_url('college/form') ?>/" + $id,
				type: 'get',
				success: function (data) {
							$('#form .ajax-body').empty().append(data.html);
						},
				cache: false,
			});
	});


	$(document).on('click', 'button[name=btnSubmit]', function() {
		$form_data = $('#frmCollege').serialize();
		console.log($form_data);
		$.ajax({
			url: $('#frmCollege').attr('action'),
			data: $form_data,
			type: 'post',
			success: function (data) {
						console.log(data);
						$('#form .ajax-body').empty().append(data.html);
					},
			cache: false,
		});
	});

})
</script>