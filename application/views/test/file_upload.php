<!DOCTYPE html5>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/plugins/jQuery/jquery-2.2.3.min.js"></script>
</head>
<body>
<form id="file-test" action="<?php echo base_url(); ?>welcome/test" method="post" enctype="multipart/form-data">
	<input id="files" type="file" name="file[]" multiple />
	<input type="submit" value="submit" />
</form>
<script type="text/javascript">
 var files;
 var newFiles=[];
$('input[type=file]').on('change', prepareUpload);
// Grab the files and set them to our variable
function prepareUpload(event)
{
  files = event.target.files;
  for(var i=0;i<files.length;i++){
  	var reader = new FileReader();

	 reader.onloadend = function() {

	   // console.log(;

	  newFiles[i]=reader.result;//
	  }
	  reader.readAsDataURL(files[i]);
  };
  console.log(newFiles);
}
$(document).on('submit','#file-test',function(e){
	e.preventDefault();
	//var formData = new FormData($(this).get(0));
	 /*$.each(files, function(key, value){
        formData.append(key, value);
    	});*/
    	var formData = new FormData();
	//formData.append('name',"Aunj");
	 formData.append('files',newFiles);
	console.log(formData);
	$.ajax({
		url:$(this).attr('action'),
		method:$(this).attr('method'),
		enctype:$(this).attr('enctype'),
		contentType:false,
		data:formData,
		cache : false,
    		processData: false,
		success:function(response){
			console.log(response);
		},
		error:function(error){
			console.log(error);
		}
	});


});
</script>
</body>
</html>