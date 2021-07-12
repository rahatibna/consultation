<?php
include('server.php');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Add New Teacher</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
	<div class="header">
		<h2>Add New Teacher</h2>
	</div>
	<div class="error success" style=" width: 35%; ">
		<h3>
			Go Back To <a href="index.php">Home</a>
		</h3>
	</div>
	<div class="content" style=" width: 100%;">
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success">
				<h3>
					<?php
					echo $_SESSION['success'];
					unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		<!-- logged in user information -->
		<?php if (isset($_SESSION['email'])) : ?>
			<p>Add A New Teacher , <strong><?php echo $_SESSION['name']; ?></strong>.</p>
			<p> <a href="admin.php?logout='0'" style="color: red;">logout</a> </p>
		<?php endif ?>
	</div>



	<div class="container">

		<a href="admin.php" class="btn btn-primary">Admin DashBoard</a>

		<a href="create.php" class="btn btn-primary"><b>Add New Teacher</b></a>
		<a href="verify.php" class="btn btn-primary">Verification of Students</a>
		<a href="students.php" class="btn btn-primary">All Students</a>
		<table class="table table-bordered">
			<a href="users.php" class="btn btn-primary">All Users</a>

	</div>
	<br>
	<br>
	<div class="container" style=" width: 45%;">
		<?php include('errors.php'); ?>
	</div>

		<form method="post" action="create.php" style=" width: 50%;">
			<div class="input-group" style=" width: 50%;">
				<label>Name</label>
				<input type="text" name="name">
			</div>
			<div class="input-group" style=" width: 50%;">
				<label>Email</label>
				<input type="text" name="email">
			</div>
			<div class="input-group" style=" width: 50%;">
				<label>Password</label>
				<input type="password" name="pass">
			</div>
			<div class="input-group" style=" width: 50%;">
				<label>Room </label >
				<input type="number" name="room">
			</div>
			<div class="input-group" style=" width: 50%;">
				<button type="submit" class="btn" name="create">Add New Teacher</button>
			</div>

		</form>
	





</body>

</html>