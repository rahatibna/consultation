<?php
session_start();
include_once('connect.php');

$email = $_SESSION['email'];

$date =   $_POST['date'];
$stm =    $_POST['stime'];
$etm =    $_POST['etime'];



$sql =  "UPDATE schedule SET date='$date' ,stime='$stm',etime='$etm' WHERE date='$date' AND email='$email'";
$resa = mysqli_query($con, $sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify User</title>
</head>

<body>
    <?php
    echo $date;
    header('Location: schedule.php?selectdate='.$date);
    ?>

</body>

</html>