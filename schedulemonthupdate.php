<?php
session_start();
include_once('connect.php');

$email = $_SESSION['email'];

$m = date('t');
$last = (int)$m;

$stm =    $_POST['stime'];
$etm =    $_POST['etime'];

$sql3 =  "UPDATE teacher SET  stime='$stm',etime='$etm' WHERE  email='$email'";
$resa3 = mysqli_query($con, $sql3);

for ($i = 1; $i <= $last; $i++) {
    if ($i < 10) {
        $dat = date('Y-m-') . '0' . $i;
    } else {
        $dat = date('Y-m-') . $i;
    }


    $sql =  "UPDATE schedule SET  stime='$stm',etime='$etm' WHERE date='$dat' AND email='$email'";
    $resa = mysqli_query($con, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Schedule Month Update</title>
</head>

<body>
    <?php
    header('Location: schedule.php');
    ?>

</body>

</html>