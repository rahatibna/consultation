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
$thisMonth = date("Y-m-d");

$lastMonth = date("Y-m-t");


$query1 = "SELECT * from teacher where email='$eml' ";
$res1 = mysqli_query($con, $query1);
$result1 = mysqli_fetch_array($res1);

$query4 = "SELECT * from appointment where temail='$eml' AND date BETWEEN '$thisMonth' AND '$lastMonth' ORDER BY date";
$res4 = mysqli_query($con, $query4);


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
    <!-- logged in user information -->
    <?php if (isset($_SESSION['email'])) : ?>
      <p>Welcome <strong><?php echo  $namu; ?></strong></p>
      <p> <a href="admin.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
  </div>

  <div class="container">

    <a href="user.php" class="btn btn-primary">DashBoard</a>
    <a href="todaysappointment.php" class="btn btn-primary">Today's Appointment</a>
    <a href="month.php" class="btn btn-primary"><b>Monthly Appointment</b></a>
    <a href="editUser.php" class="btn btn-primary">Edit Your Basic Profile</a>
    <a href="schedule.php" class="btn btn-primary">Schedule Free Time</a>
    <a href="requests.php" class="btn btn-primary">Appointment Requests</a>
  </div>

  <br><br>

  <div class="container">
    <?php
    if (mysqli_num_rows($res4) > 0) {
    ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th colspan="5">
              <h2>Monthly Appointment</h2>
            </th>
          </tr>

          <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Roll</th>
            <th>Time</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($today = mysqli_fetch_array($res4)) {
            $nstart = date('h:i A', strtotime($today['stime']));
            $nend = date('h:i A', strtotime($today['etime']));
          ?>

            <tr>
              <td><?php echo $today['date'] ?></td>
              <td><?php echo $today['name'] ?></td>
              <td><?php echo $today['roll'] ?></td>
              <td><?php echo $nstart ?> - <?php echo $nend ?></td>
              <td><?php echo $today['description'] ?></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    <?php
    } else {
    ?>
      <div class="error success" style="width: 100%;">
        <p>
          <?php
          echo 'No Appointments In This Month.';
          ?>
        </p>
      </div>

  </div>
<?php
    }
?>

</div>






</body>

</html>