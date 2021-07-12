<?php
$id = $_GET['id'];

include_once('connect.php');

$query1 = "SELECT * from verify WHERE id='$id'";
$res1 = mysqli_query($con, $query1);
$result1 = mysqli_fetch_array($res1);

$eml = $result1['email'];
$pas = $result1['pass'];
$nam = $result1['name'];
$rol = $result1['roll'];

$user_check_query = "SELECT * from login where email='$eml' limit 1";
$ck  = mysqli_query($con, $user_check_query);
$user = mysqli_fetch_assoc($ck);
if ($user) {
  if ($user['email'] == $eml) {
    array_push($errors, "Email Already Exist");
  }
}

if (count($errors) == 0) {

  $sql123 =  "INSERT INTO student (name , email ,pass,roll) VALUES ('$nam' ,'$eml' , '$pas','$rol')";
  $resa1 = mysqli_query($con, $sql123);

  $sql12 =  "INSERT INTO login (name , email ,pass,identity) VALUES ('$nam' ,'$eml' , '$pas',2)";
  $resa1 = mysqli_query($con, $sql12);


  $query = "DELETE from verify WHERE id='$id'";
  $res = mysqli_query($con, $query);
}





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
  header('Location: verify.php');
  ?>

</body>

</html>