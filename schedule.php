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
$id = $_SESSION['id'];
include_once('connect.php');
$logquery = "SELECT * from login where id='$id' ";
$logres = mysqli_query($con, $logquery);
$login = mysqli_fetch_array($logres);

if (isset($_GET['selectdate'])) {
    $date = $_GET['selectdate'];
} else {
    $date = date('Y-m-d');
}

$la = date('t');
$last = (int)$la;
$date1  = date('Y-m-01');
$firstweekday = date('l', strtotime($date1));
$firstdayweek = date('w',  strtotime($date1));

if ($login['identity'] == 2) {
    header('Location:student.php');
}

$namu = $login['name'];
$email = $login['email'];

$query = "SELECT * from teacher WHERE email='$email'";
$res = mysqli_query($con, $query);
$result = mysqli_fetch_array($res);
$email = $result['email'];
$tId = $result['id'];


$sche = "SELECT * from schedule where date='$date' AND email='$email'";
$sch = mysqli_query($con, $sche);
$schedule = mysqli_fetch_array($sch);


?>


<!DOCTYPE html>
<html>

<head>
    <title>Edit <?php echo $namu ?>'s Schedule</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="calendar.css" type="text/css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .calendar {
            position: relative;
            border: 2px solid ghostwhite;
            padding: auto;
            margin: 0% 1%;
        }

        .monthrow {
            display: inline-block;
            width: 64%;
            position: relative;
            top: 100%;
            margin: auto;
        }


        .weekrow {
            display: inline-block;
            position: relative;
            width: 100%;
            margin: auto;
        }

        .weekday {
            margin: 2px 0px;
            display: inline-block;
            background-color: ghostwhite;
            text-align: center;
            width: 13.9%;
        }

        .functionfrom {
            display: inline-block;
            width: 35%;
            position: absolute;
        }
    </style>

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
        <a href="editUser.php" class="btn btn-primary">Edit Your Basic Profile</a>

        <a href="schedule.php" class="btn btn-primary"><b>Schedule Free Time</b></a>
        <a href="requests.php" class="btn btn-primary">Appointment Requests</a>
    </div>
    <br><br>
    <div class="calendar">
        <div class="monthrow">
            <div class="weekrow">
                <div class="weekday">
                    <h4>Sat</h4>
                </div>
                <div class="weekday">
                    <h4>Sun</h4>
                </div>
                <div class="weekday">
                    <h4>Mon</h4>
                </div>
                <div class="weekday">
                    <h4>Tue</h4>
                </div>
                <div class="weekday">
                    <h4>Wed</h4>
                </div>
                <div class="weekday">
                    <h4>Thu</h4>
                </div>
                <div class="weekday">
                    <h4>Fri</h4>
                </div>
            </div>
            <div class="weekrow">
                <?php
                if ($firstdayweek == 6) {
                    $start = 0;
                } else {
                    $start = $firstdayweek + 1;
                }
                for ($i = 0; $i < $start; $i++) {
                ?>
                    <div class="weekday">
                        <h4><?php echo '-'; ?></h4>
                    </div>
                <?php }
                for ($i = 1; $i <= $last; $i++) {
                    if ($i < 10) {
                        $dat = date('Y-m-') . '0' . $i;
                    } else {
                        $dat = date('Y-m-') . $i;
                    }
                ?>
                    <div class="weekday">
                        <h4><a href="schedule.php?selectdate=<?php echo $dat; ?>"><?php if ($dat === $date) { ?> <b> <?php } ?> <?php echo $i; ?> <?php if ($dat === $date) { ?> </b> <?php } ?></a></h4>
                    </div>
                <?php }
                if (($last + $start) > 34) {
                    $a = 42;
                } else {
                    $a = 35;
                }
                for ($i = 0; $i < ($a - $start - $last); $i++) {
                ?>
                    <div class="weekday">
                        <h4><?php echo '-'; ?></h4>
                    </div>
                <?php } ?>
            </div>
        </div>


        <div class="functionfrom">
            <form method="post" action='scheduleupdate.php' style="width: 100%;">
                <h3>Set Time For <?php echo $date; ?></h3>
                <div class="form-group">
                    <label for="exampleInputPassword1">Date</label>
                    <input type="date" class="form-control" id="exampleInputPassword1" placeholder="" name="date" value="<?php echo $date; ?>">
                </div>
                <div class="form-group">

                    <label for="exampleInputStartTime">Start Time</label>
                    <input type="time" class="form-control" id="exampleInputStartTime" placeholder="StartTime" name="stime" value="<?php echo $schedule['stime'] ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEndTime">End Time</label>
                    <input type="time" class="form-control" id="exampleInputEndTime" placeholder="EndTime" name="etime" value="<?php echo $schedule['etime'] ?>">
                </div>



                <div class="col-md-4 col-lg-4"></div>
                <div class="col-md-4 col-lg-4">
                    <button name="submit" type="submit" class="btn btn-success btn-block">Set Time</button>
                </div>
            </form>
        </div>

    </div>


    <br><br>
    <div class="container">
        <form method="post" action="schedulemonthupdate.php" style="width: 100%;">
            <h2>Set Time for Whole Month</h2>

            <div class="form-group">
                <label for="exampleInputStartTime">Start Time</label>
                <input type="time" class="form-control" id="exampleInputStartTime" placeholder="StartTime" name="stime" value="<?php echo $result['stime'] ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEndTime">End Time</label>
                <input type="time" class="form-control" id="exampleInputEndTime" placeholder="EndTime" name="etime" value="<?php echo $result['etime'] ?>">
            </div>



            <div class="col-md-4 col-lg-4"></div>
            <div class="col-md-4 col-lg-4">
                <button name="submit2" type="submit" class="btn btn-success btn-block">Set Time</button>
            </div>
        </form>
    </div>
    <br><br>

</body>

</html>