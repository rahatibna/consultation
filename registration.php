<?php
include('server.php');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
	<div class="header">
		<h2>Registration</h2>
	</div>
	<div class="error success" style=" width: 35%; ">
		<h3>
			Go Back To <a href="index.php">Home</a>
		</h3>
		<h3>
			Go Back To <a href="login.php">Login Page</a>
		</h3>
	</div>



	<form method="post" action="registration.php" style=" width: 45%;">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>Name</label>
			<input type="text" name="name">
		</div>
		<div class="input-group">
			<label>Roll Number</label>
			<input type="Number" name="roll">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="text" name="email">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="pass">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="registration">Register</button>
		</div>

	</form>





</body>

</html>