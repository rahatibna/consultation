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
$res1 = mysqli_query($con, $query);
$result1 = mysqli_fetch_assoc($res1);

$email = $result1['email'];

$query5 = "SELECT * from student where email='$email' ";
$res5 = mysqli_query($con, $query5);
$result5 = mysqli_fetch_assoc($res5);

$roll = $result5['roll'];


$today = date('Y-m-d');
$query1 = "SELECT DISTINCT email,name,stime,etime,room FROM schedule WHERE date='$today'
";
$res = mysqli_query($con, $query1);


if ($result1['identity'] == 1) {
  header('Location:user.php');
}

if (isset($_SESSION['editname']) == 0) {
  $namu = $_SESSION['name'];
} else {
  $namu = $_SESSION['editname'];
  $_SESSION['name'] = $namu;
}


$thisMonth = date("Y-m-d");


$month = date("m");
if ($month === '04' | $month === '06' | $month === '09' | $month === '11') {
  $lastDay = '30';
} elseif ($month == '02') {
  $lastDay = '28';
} else {
  $lastDay = '31';
}
$lastMonth = date("Y-m") . '-' . $lastDay;



$query4 = "SELECT * from appointment where roll='$roll' AND date BETWEEN '$thisMonth' AND '$lastMonth' ORDER BY date";
$res4 = mysqli_query($con, $query4);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo  $namu; ?>'s Profile</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div class="header" style=" width: 100%;">
    <h2><?php echo  $namu; ?>'s Profile</h2>
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

    <a href="editStudent.php?id=<?php echo $result1['id'] ?>">Edit Information</a>
    <!-- logged in user information -->
    <?php if (isset($_SESSION['email'])) : ?>
      <p>Welcome <strong><?php echo  $namu; ?></strong></p>
      <p> <a href="admin.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
  </div>

  <div class="container">

    <div class="container">
      <?php
      if (mysqli_num_rows($res4) > 0) {
      ?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="4">
                <h2>Your Appoinments</h2>
              </th>
            </tr>
            <tr>
              <th>Date</th>
              <th>Teachers Name</th>
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
                <td><?php echo $today['tname'] ?></td>
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




  <br><br>
  <div class="container">
    <?php
    if (mysqli_num_rows($res) > 0) {
    ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th colspan="3">
              <h2>Book Your Appointment</h2>
            </th>
          </tr>
          <tr>
            <th>Name</th>
            <th>Time</th>
            <th>Room</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($rows = mysqli_fetch_assoc($res)) {
            $nstart = date('h:i A', strtotime($rows['stime']));
            $nend = date('h:i A', strtotime($rows['etime']));
          ?>


            <tr>
              <td><a href="makeAppointment.php?email=<?php echo $rows['email'] ?>"><?php echo strtoupper($rows['name']) ?></a></td>
              <td><?php echo  $nstart ?> - <?php echo $nend ?></td>
              <td><?php echo $rows['room'] ?></td>
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
          echo 'No Teacher Is Available In This Month.';
          ?>
        </p>
      </div>

  </div>
  <?php
    }
  ?>

  </div>
<br><br>
</body>

</html>