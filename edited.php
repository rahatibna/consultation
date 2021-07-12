<?php
session_start();
$id = $_GET['id'];
include_once('connect.php'); 

$query = "SELECT * from teacher WHERE id='$id'";
$res = mysqli_query($con, $query);
$result = mysqli_fetch_array($res);
$email = $result['email'];

$query5 = "SELECT * from login WHERE email='$email'";
$res5 = mysqli_query($con, $query5);
$result5 = mysqli_fetch_array($res5);
$loginID = $result5['id'];

?>


<!DOCTYPE html>
<html>

<head>
	<title>Edit Information</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
	<div class="header">
		<h2>Edit</h2>
	</div>
	<div class="error success" style=" width: 35%; ">
		<h3>
			Go Back To <a href="admin.php">Previous Page</a>
		</h3>
	</div>

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




		$sql =  "UPDATE teacher SET name='$nam' , room='$rom'  ,pass= '$pas' WHERE id='$id'";
		$resa = mysqli_query($con, $sql);

		$sql2 =  "UPDATE login SET name='$nam' ,pass= '$pas' WHERE id='$loginID'  ";
		$resa2 = mysqli_query($con, $sql2);


		if ($resa) {

			$result['name'] = $nam;
			$result['room'] = $rom;
			$result['pass'] = $pas;


			header("Refresh:0");
		}
	?>

		<div class="alert alert-success text-center" role="alert" style="display: <?php echo $display ?>;">Successfully Edited.</div>

	<?php


	}


	?>


</body>

</html>