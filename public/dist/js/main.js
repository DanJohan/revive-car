$(".flash-msg").fadeTo(2000, 500).slideUp(500, function(){
	$(".flash-msg").slideUp(500);
});

$(document).on('change','.upload-input',function(e){
	var path = $(this).val();
	var path_array= path.split('\\');
	$('.upload-file-name').text(path_array.pop());
});



