<?php
session_start();

if (isset($_GET['email'])) {
	$temail = $_GET['email'];
	$_SESSION['temail'] = $temail;
} else {
	$temail = $_SESSION['temail'];
}


$id = $_SESSION['id'];
$errors = array();
include_once('connect.php');


$query = "SELECT * from teacher WHERE email='$temail'";
$res = mysqli_query($con, $query);
$teacher = mysqli_fetch_array($res);

$query5 = "SELECT * from login WHERE id='$id'";
$res5 = mysqli_query($con, $query5);
$loginStudent = mysqli_fetch_array($res5);
$email = $loginStudent['email'];

$query2 = "SELECT * from student WHERE email='$email'";
$res2 = mysqli_query($con, $query2);
$student = mysqli_fetch_array($res2);

$today = date('Y-m-d');

$temail = $teacher['email'];

$sch = "SELECT * from schedule WHERE email='$temail' AND date='$today'";
$sche = mysqli_query($con, $sch);
$schedule = mysqli_fetch_array($sche);

?>


<!DOCTYPE html>
<html>

<head>
	<title>Make An Appoinment For <?php echo $teacher['name']; ?></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<style>
		.ib5 {
			display: inline-block;
			width: 48%;
		}
	</style>
</head>

<body>
	<div class="header">
		<h2>Make An Appoinment For <?php echo $teacher['name']; ?> </h2>
	</div>
	<div class="error success" style=" width: 35%; ">
		<h3>
			Go Back To <a href="student.php">Previous Page</a>
		</h3>
	</div>

	<div class="container" style=" width: 45%;">
		<?php include('errors.php'); ?>
	</div>

	<form method="post" action="makeAppointment.php" style=" width: 70%;">
		<div class="input-group ib5">
			<label>Date</label>
			<input type="date" name="date" value="<?php echo $today; ?>">
		</div>
		<div class="input-group ib5" style="margin-left: 3%;">
			<label>Preferable Start Time</label>
			<input type="time" name="stime" placeholder="12:00" value="<?php echo $schedule['stime']; ?>">
		</div>
		<div class="input-group ib5">
			<label>Description</label>
			<input type="text" name="description">
		</div>

		<div class="input-group ib5" style="margin-left: 3%;">
			<label>Preferable End Time</label>
			<input type="time" name="etime" placeholder="13:00" value="<?php echo $schedule['etime']; ?>">
		</div>
		<div class="input-group" style=" width: 100%;">
			<button type="submit" class="btn" name="makeAppointment">Make Appointment</button>
		</div>

	</form>

	<?php

	//Make Appointment 
	if (isset($_POST['makeAppointment'])) {

		$date =  mysqli_real_escape_string($con, $_POST['date']);
		$description =  mysqli_real_escape_string($con, $_POST['description']);
		$stime =  mysqli_real_escape_string($con, $_POST['stime']);
		$etime =  mysqli_real_escape_string($con, $_POST['etime']);

		$teemail = $teacher['email'];
		$tname = $teacher['name'];
		$nam = $student['name'];
		$rol = $student['roll'];
		if (empty($date)) {
			array_push($errors, "Date is required");
		}
		if (empty($stime)) {
			array_push($errors, "Preferable Start Time is required");
		}
		if (empty($etime)) {
			array_push($errors, "Preferable End Time is required");
		}
		if (empty($description)) {
			array_push($errors, "Description is required");
		}

		if (count($errors) == 0) {

			$sql2 =  "INSERT INTO request (temail ,tname , name ,roll ,description ,date ,stime,etime ) VALUES ('$teemail' ,'$tname', '$nam' , '$rol' , '$description' , '$date','$stime' ,'$etime')";
			$resa = mysqli_query($con, $sql2);

			// App password
			//   Send Request Mail To Teacher
			// creates object
			$email      = $teemail;
			$subjec    = "Appointment Request";
			$message  = "Assalamualaikum " . $tname . ". You have an appointment request from " . $nam . " on " . $date . " from " . $stime . " to " . $etime . ".";



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
			header('Location:appointmentDone.php');

		}
	}

	?>

</body>

</html>