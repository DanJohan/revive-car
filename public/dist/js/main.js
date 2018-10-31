$(".flash-msg").fadeTo(2000, 500).slideUp(500, function(){
	$(".flash-msg").slideUp(500);
});

/*$.ajax({
	'url':"<?php echo base_url(); ?>admin/enquiry/get_notifications",
	'method':"POST",
	'async':false,
	success:function(response){
		if(response.status){
			$('#notification-list').html(response.template);
			$('#notification-count').text(response.total);
		}
	}
});*/


