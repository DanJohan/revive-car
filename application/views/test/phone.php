<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>

<form autocomplete="off">
<input type="text" id="country_code" style="width:30px;border-right:0px;display:none;" value="+91"><input type="text" id="phone" />
</form>
<script>
$(document).on('keyup','#phone',function(e){
	var phone = $(this).val();

    if(phone.match(/^\d+$/)&&phone.length>2) {
      $('#country_code').show();
	}
    if(phone.match(/^\d+$/)&&phone.length<3) {
      $('#country_code').hide();
	}
	if(!phone.match(/^\d+$/)) {
      $('#country_code').hide();
	}
    
});

$(document).on('keydown','#phone',function(e){
	var phone = $(this).val();
	console.log(e.keyCode);

    if(phone.match(/^\d+$/)&&(phone.length>=10)) {
    		if((e.keyCode == 8) || (e.keyCode ==37) || (e.keyCode == 39) || (e.keyCode ==46) ) {
 			return true;
 		}else{
 			return false;
 		}
	}

    
});
</script>
</body>
</html>
