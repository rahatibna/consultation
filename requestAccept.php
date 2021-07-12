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

$res = mysqli_query($con, $query);
$result = mysqli_fetch_array($res);

if ($result['identity'] == 2) {
  header('Location:student.php');
}

$eml = $result['email'];

$query1 = "SELECT * from teacher where email='$eml' ";
$res1 = mysqli_query($con, $query1);
$result1 = mysqli_fetch_array($res1);


$queryRequest = "SELECT * from request where temail='$eml' ";
$res2 = mysqli_query($con, $queryRequest);
$request = mysqli_fetch_array($res2);




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
  <title><?php echo $namu ?>'s Profile</title>
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

    <a href="edit.php?id=<?php echo $result1['id'] ?>">Edit Information</a>
    <!-- logged in user information -->
    <?php if (isset($_SESSION['email'])) : ?>
      <p>Welcome <strong><?php echo  $namu; ?></strong></p>
      <p> <a href="admin.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
  </div>

  <div class="container">

    <a href="user.php" class="btn btn-primary"><b>Today's Appointment</b></a>
    <a href="month.php" class="btn btn-primary">Monthly Appointment</a>
    <a href="editUser.php?id=<?php echo $result1['id'] ?>" class="btn btn-primary">Edit Your Basic Profile</a>
    <a href="requests.php" class="btn btn-primary">Appointment Requests</a>
  </div>

  <table class="table table-bordered">
            <a href="users.php" class="btn btn-primary">All Users</a>



</body>

</html>