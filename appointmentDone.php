<?php
session_start();
if (!isset($_SESSION['email'])) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
}
include_once('connect.php'); 
$id = $_SESSION['id'];
$query = "SELECT * from login where id='$id' ";
mysqli_select_db($con, 'consult');
$res1 = mysqli_query($con, $query);
$result1 = mysqli_fetch_assoc($res1);

$query1 = "select * from teacher";
$res=mysqli_query($con,$query1);


if ($result1['identity']==1) {
  header('Location:user.php');
}

if (isset($_SESSION['editname']) == 0) {
  $namu = $_SESSION['name'];
} else {
  $namu = $_SESSION['editname'];
  $_SESSION['name'] = $namu;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Appointment Done</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
  <div class="header" style=" width: 100%;">
    <h2>Appointment Done</h2>
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
  <div class="error success" style=" width: 50%; ">
		<h3>
			Go Back To <a href="student.php">Previous Page</a>
		</h3>
	</div>
  <div class="content" style=" width: 100%;">
        <div class="error success">
            <h3>
                Your Request For An Appointment Is Being Placed.
                Please Wait For The Confirmation Of The Teacher. 
            </h3>
        </div>
    </div>





</body>

</html>