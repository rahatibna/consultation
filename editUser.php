





<?php
session_start();
$id = $_SESSION['id'];
include_once('connect.php');
$query5 = "SELECT * from login WHERE id='$id'";
$res5 = mysqli_query($con, $query5);
$result5 = mysqli_fetch_array($res5);
$loginID = $result5['id'];
$email = $result5['email'];


$query = "SELECT * from teacher WHERE email='$email'";
$res = mysqli_query($con, $query);
$result = mysqli_fetch_array($res);
$namu = $result['name'];
$tid = $result['id'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Edit <?php echo $namu ?>'s Basic Information</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
	<div class="header" style=" width: 100%;">
		<h2><?php echo $namu ?>'s Profile</h2>
	</div>

	<div class="error success" style=" width: 30%; ">
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
			<p>Welcome <strong><?php echo  $namu; ?></strong></p>
			<p> <a href="admin.php?logout='1'" style="color: red;">logout</a> </p>
		<?php endif ?>
	</div>

	<div class="container">

		<a href="user.php" class="btn btn-primary">DashBoard</a>
		<a href="todaysappointment.php" class="btn btn-primary">Today's Appointment</a>
		<a href="month.php" class="btn btn-primary">Monthly Appointment</a>
		<a href="editUser.php" class="btn btn-primary"><b>Edit Your Basic Profile</b></a>
		<a href="schedule.php" class="btn btn-primary">Schedule Free Time</a>
		<a href="requests.php" class="btn btn-primary">Appointment Requests</a>
	</div>

	<br><br>
	<div class="container">

		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"></h3>
			</div>
			<div class="panel-body">
				<form method="post">
					<div class="form-group">
						<label for="exampleInputName">Name</label>
						<input type="text" class="form-control" id="exampleInputName" placeholder="Name" name="name" value="<?php echo $result['name'] ?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail">Email</label>
						<input type="text" class="form-control" id="exampleInputEmail" placeholder="Email" name="email" value="<?php echo $result['email'] ?>" disabled="disabled">
					</div>
					<div class="form-group">
						<label for="exampleInputPassword">Password</label>
						<input type="text" class="form-control" id="exampleInputPassword" placeholder="Password" name="pass" value="<?php echo $result['pass'] ?>">
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Room</label>
						<input type="number" class="form-control" id="exampleInputPassword1" placeholder="Room" name="room" value="<?php echo $result['room'] ?>">
					</div>
					<div class="col-md-4 col-lg-4"></div>
					<div class="col-md-4 col-lg-4">
						<button name="update" type="submit" class="btn btn-success btn-block">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	if (isset($_POST['update'])) {

		$nam =	$_POST['name'];
		$rom =	$_POST['room'];
		$pas =	$_POST['pass'];




		$sql =  "UPDATE teacher SET name='$nam' , room='$rom'  ,pass= '$pas' WHERE id='$tid'";
		$resa = mysqli_query($con, $sql);

		$sql2 =  "UPDATE login SET name='$nam' ,pass= '$pas' WHERE id='$id'  ";
		$resa2 = mysqli_query($con, $sql2);


		if ($resa) {

			$result['name'] = $nam;
			$result['room'] = $rom;
			$result['pass'] = $pas;


			$_SESSION['editname'] = $nam;

			header("Refresh:0");
		}
	?>

		<div class="alert alert-success text-center" role="alert" style="display: <?php echo $display ?>;">Successfully Edited.</div>

	<?php


	}


	?>


</body>

</html>