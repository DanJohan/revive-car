<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		.error{
			color:red;
		}
		.flex-container {
		  display: flex;
		  height: 100%;
		  justify-content: center;
		  align-items: center;
		}

	</style>
</head>
<body>
<div class="form-top">
	<div class="container-fluid">
		<div class="row flex-container ">
			<div id="form-container" class="col-xs-6 col-sm-6 col-md-4 well">
				<form id="password_reset" action="/action_page.php">
					<input type="hidden" id="email" name="email" value="<?php echo $email; ?>">
					<input type="hidden" id="hash" name="hash" value="<?php echo $hash; ?>">
					<div class="form-group">
						<label for="pwd">Password:</label>
						<input type="password" name="pwd" class="form-control" id="pwd">
						<p id="pwd-error" class="error"></p>
					</div>
					<div class="form-group">
						<label for="confirm_pwd">Confirm password:</label>
						<input type="password" class="form-control" id="confirm_pwd">
						<p id="confirm-pwd-error" class="error"></p>
					</div>
					<button type="submit" class="btn btn-danger">Submit</button>
				</form>
			</div>
		</div>
	</div>
	</div>
	<script>
		$(document).on('submit','#password_reset',function(e){
			e.preventDefault();
			var pwd = $('#pwd').val();
			var confirm_pwd = $("#confirm_pwd").val();
			var email = $('#email').val();
			var hash = $("#hash").val();
			var error =false;
			$("#pwd-error").text('');
			$('#confirm_pwd').text('');

			if(pwd.length>6 || pwd.length<6){
				$("#pwd-error").text("Password should be 6 characters long");
				error = true;
			}

			if(confirm_pwd.length<=0){
				$("#confirm-pwd-error").text("Confirm password is required");
				error = true;
			}

			if(pwd != confirm_pwd){
				$("#confirm-pwd-error").text("Password doesn\'t match");
				$('#confirm_pwd').val('');
				error = true;
			}
			if(error){
				return false;
			}else{
				$.ajax({
					url:'<?php echo base_url();?>api/user/changePasswordByEmail',
					method:'post',
					data:{'email':email,'hash':hash,'pwd':pwd},
					success:function(response){
						if(response){
							if(response.status){
								$("#form-container").prepend('<div class="alert alert-success alert-dismissible">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.message+'</div>');
								$('#pwd').val('');
								$('#confirm_pwd').val('');
							}else{
								$("#form-container").prepend('<div class="alert alert-danger alert-dismissible">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.message+'</div>');
								$('#pwd').val('');
								$('#confirm_pwd').val('');
							}
						}
					}
				});
			}

		});
	</script>
</body>
</html>