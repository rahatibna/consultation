<?php
$id = $_GET['id'];
include_once('connect.php'); 
$query1 = "SELECT * from teacher WHERE id='$id'";
$res1 = mysqli_query($con, $query1);
$result1 = mysqli_fetch_array($res1);

$eml = $result1['email'];
$pas = $result1['pass'];

$query2 = "DELETE from login WHERE email='$eml' and pass='$pas'";
$res2 = mysqli_query($con, $query2);
$result2 = mysqli_fetch_array($res2);

$query = "DELETE from teacher WHERE id='$id'";
$res = mysqli_query($con, $query);
$result = mysqli_fetch_array($res);


$scheqwer = "DELETE  from schedule where email='$eml'";
$schasdf = mysqli_query($con, $scheqwer);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete User</title>
</head>

<body>
    <?php
    header('Location: admin.php');
    ?>

</body>

</html>