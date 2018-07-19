<html>
	<head>
		<title>Change Password</title>
	</head>
	<body>
		<p> Hi <?php echo $user['name']; ?>,</p>
		 <p>
        You have requested a password reset, please follow the link below to reset your password.
    	</p>
	    <p>
	        Please ignore this email if you did not request a password change.
	    </p>

    	<p>
	        <a href="<?php echo $link; ?>">
	            Follow this link to reset your password.
	        </a>
    	</p>
	</body>
</html>