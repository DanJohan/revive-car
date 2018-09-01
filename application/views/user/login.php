<!doctype html>
<html> 
<head>

<title>Login-form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url();?>public/userlogin/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


  <link href="<?php echo base_url();?>public/userlogin/css/style.css" rel="stylesheet">
</head>
 
<body>
<section class="login">
<div class="container">

<div class="row">
<div class="col-md-6 offset-md-3">
<?php 
          if(isset($msg) && !empty($msg)) {
        ?>
          <div class="alert alert-danger">
            <?php echo $msg; ?>
          </div>
        <?php
          }
        ?>
<form class="login-wrapper" method="post" action="<?php echo base_url(); ?>user/login">
  <div class="form-group">
    <label >
    <i class="fas fa-user"></i>


    
    Username</label>
    <input type="text" name="username" class="form-control" placeholder="Type your username">
  </div>
  <div class="form-group">
    <label>
    <i class="fas fa-unlock-alt"></i>
    
    Password</label>
    <input type="password" name="password" class="form-control" placeholder="Type your Password">
  </div>
<!--   <div class="wthree-text">
				<ul>
					<li>
						<label class="anim">
							<input type="checkbox" class="checkbox" >
							<span>Stay Signed In</span>
						</label>
					</li>
					<li>
						<a href="#">Forgot Password?</a>
					</li>
				</ul>
			</div> -->
 
    <input type="submit" name="submit" value="Login" class="btn btn-primary">
<!--   <div class="social icon">
  <span></span>
  <button class="loginBtn loginBtn--facebook">
  Login with Facebook
</button>

<button class="loginBtn loginBtn--google">
  Login with Google
</button></div> -->
</form>
</div>
</div>
</div>
</section>

 <script src="<?php echo base_url();?>public/userlogin/js/jquery.min.js"></script>
 
  <script src="<?php echo base_url();?>public/userlogin/js/bootstrap.min.js"></script>
</body>
</html>
