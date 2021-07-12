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
$eml = $_SESSION['email'];
$query = "SELECT * from login where email='$eml' ";

$res = mysqli_query($con, $query);
$result = mysqli_fetch_array($res);

if ($result['identity'] == 2) {
    header('Location:student.php');
}


$query1 = "SELECT * from teacher where email='$eml' ";
$res1 = mysqli_query($con, $query1);
$result1 = mysqli_fetch_array($res1);







$namu = $_SESSION['name'];



$requestId = $_GET['id'];
$errors = array();


$query1 = "SELECT * from request WHERE id='$requestId'";
$res1 = mysqli_query($con, $query1);
$request = mysqli_fetch_array($res1);
$tnam = $request['tname'];
$emal = $request['temail'];
$name = $request['name'];
$roll = $request['roll'];
$description = $request['description'];
$date = $request['date'];
$stime = $request['stime'];
$etime = $request['etime'];






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
        <h2>Accept Appointment</h2>
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
        <a href="schedule.php" class="btn btn-primary">Schedule Free Time</a>
        <a href="requests.php" class="btn btn-primary">Appointment Requests</a>
    </div>
    <br><br>

    <div class="container" style=" width: 45%;">
        <?php include('errors.php'); ?>
    </div>

    <form method="post" action="acceptApointment.php" style=" width: 50%;">
        <div class="form-group" style=" width: 100%;">
            <label for=" exampleInputName">Your Name</label>
            <input type="text" class="form-control" id="exampleInputName" placeholder="Name" name="tname" value="<?php echo $tnam; ?>">
        </div>
        <div class="form-group" style=" width: 100%;">
            <label for=" exampleInputName">Student's Name</label>
            <input type="text" class="form-control" id="exampleInputName" placeholder="Name" name="name" value="<?php echo $name; ?>">
        </div>
        <div class="form-group" style=" width: 100%;">
            <label for=" exampleInputName">Roll</label>
            <input type="number" class="form-control" id="exampleInputName" placeholder="160101" name="roll" value="<?php echo $roll ?>">
        </div>
        <div class="form-group" style=" width: 100%;">
            <label for=" exampleInputName">Description</label>
            <input type="text" class="form-control" id="exampleInputName" placeholder="Name" name="description" value="<?php echo $description ?>">
        </div>
        <div class="form-group" style=" width: 100%;">
            <label for=" exampleInputName">Date</label>
            <input type="date" class="form-control" id="exampleInputName" placeholder="Name" name="date" value="<?php echo $date ?>">
        </div>
        <div class="form-group" style=" width: 100%;">
            <label for=" exampleInputName">Start Time</label>
            <input type="time" class="form-control" id="exampleInputName" placeholder="Name" name="stime" value="<?php echo $stime ?>">
        </div>
        <div class="form-group" style=" width: 100%;">
            <label for=" exampleInputName">End Time</label>
            <input type="time" class="form-control" id="exampleInputName" placeholder="Name" name="etime" value="<?php echo $etime ?>">
        </div>

        <div class="input-group" style=" width: 100%;">
            <button type="submit" class="btn" name="acceptAppointment">Confirm Appointment</button>
        </div>

    </form>

    <?php
    //Make Appointment 

    if (isset($_POST['acceptAppointment'])) {



        session_start();

        $date =  mysqli_real_escape_string($con, $_POST['date']);
        $stime =  mysqli_real_escape_string($con, $_POST['stime']);
        $etime =  mysqli_real_escape_string($con, $_POST['etime']);

        $teemail = $_SESSION['email'];
        $tname = mysqli_real_escape_string($con, $_POST['tname']);
        $nam = mysqli_real_escape_string($con, $_POST['name']);
        $rol = mysqli_real_escape_string($con, $_POST['roll']);
        $description = mysqli_real_escape_string($con, $_POST['description']);

        if (empty($date)) {
            array_push($errors, "Date is required");
        }
        if (empty($tname)) {
            array_push($errors, "Your Name is required");
        }
        if (empty($stime)) {
            array_push($errors, "Start Time is required");
        }
        if (empty($etime)) {
            array_push($errors, "End Time is required");
        }
        if (empty($nam)) {
            array_push($errors, "Student's Name is required");
        }
        if (empty($rol)) {
            array_push($errors, "Roll is required");
        }
        if (empty($description)) {
            array_push($errors, "Description is required");
        }

        if (count($errors) == 0) {


            $sql123 = "INSERT INTO appointment (name ,tname, temail ,date,roll , stime , etime , description) VALUES ('$nam' ,'$tname','$teemail' , '$date','$rol','$stime' , '$etime','$description')";
            $resa1 = mysqli_query($con, $sql123);


            $query = "DELETE from request WHERE name='$nam' and temail='$teemail'and roll='$rol' and description='$description' and date='$date' limit 1 ";
            $res = mysqli_query($con, $query);


            $query12 = "SELECT * from student where roll='$rol' ";
            $res12 = mysqli_query($con, $query12);
            $result12 = mysqli_fetch_array($res12);



            $email      = $result12['email'];
            $subjec    = "Appointment Request Confirmed";
            $message  = "Assalamualaikum " . $nam . ". Your request have been confirmed by " . $tname . " on " . $date . " from " . $stime . " to " . $etime . ".";



            include('smtp/PHPMailerAutoload.php');
            $html = $message;
            function smtp_mailer($to, $subject, $msg)
            {
                $mail = new PHPMailer();
                // $mail->SMTPDebug  = 3;
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 587;
                $mail->IsHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Username = "consultation.just@gmail.com";
                $mail->Password = "password";
                $mail->SetFrom("consultation.just@gmail.com");
                $mail->Subject = $subject;
                $mail->Body = $msg;
                $mail->AddAddress($to);
                $mail->SMTPOptions = array('ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => false
                ));
                if (!$mail->Send()) {
                    $mail->ErrorInfo;
                } else {
                    return 'Sent';
                }
            }
            smtp_mailer($email, $subjec, $html);
        }





        header('Location:appointmentAccept.php');
    }


    ?>






</body>

</html>