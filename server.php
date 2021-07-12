<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$id = "";
$errors = array();

// connect to the database

include_once('connect.php');

// ... // ... 





//Teacher Registration
if (isset($_POST['create'])) {

  $nam =  mysqli_real_escape_string($con, $_POST['name']);
  $emal =  mysqli_real_escape_string($con, $_POST['email']);
  $pas =  mysqli_real_escape_string($con, $_POST['pass']);
  $stm =  '10:00:00';
  $etm =  '11:00:00';
  $rom =  mysqli_real_escape_string($con, $_POST['room']);

  if (empty($nam)) {
    array_push($errors, "Name is required");
  }
  if (empty($emal)) {
    array_push($errors, "Email is required");
  }
  if (empty($pas)) {
    array_push($errors, "Password is required");
  }
  if (empty($stm)) {
    array_push($errors, "Start Time is required");
  }
  if (empty($etm)) {
    array_push($errors, "End Time is required");
  }
  if (empty($rom)) {
    array_push($errors, "Room is required");
  }



  $user_check_query = "SELECT * from login where email='$emal' limit 1";
  $ck  = mysqli_query($con, $user_check_query);
  $user = mysqli_fetch_assoc($ck);
  if ($user) {
    if ($user['email'] == $emal) {
      array_push($errors, "Email Already Exist");
    }
  }

  if (count($errors) == 0) {

    $sql2 =  "INSERT INTO teacher (name , email ,pass ,stime ,etime ,room ) VALUES ('$nam' , '$emal' , '$pas' , '$stm' , '$etm' , '$rom' )";
    $resa = mysqli_query($con, $sql2);

    $sql3 =  "INSERT INTO login (name , email ,pass,identity) VALUES ('$nam' , '$emal' , '$pas',1)";
    $resa2 = mysqli_query($con, $sql3);

    $today = date('Y-m-d');
    $m = date('t');
    $last = (int)$m;


    for ($i = 1; $i <= $last; $i++) {
      if ($i < 10) {
        $dat = date('Y-m-') . '0' . $i;
      } else {
        $dat = date('Y-m-') . $i;
      }

      $sql2 =  "INSERT INTO schedule (name  ,date, email ,stime ,etime ,room ) VALUES ('$nam' ,'$dat', '$emal'  , '$stm' , '$etm' , '$rom' )";
      $resa = mysqli_query($con, $sql2);
    }





    header('Location:admin.php');
  }
}


//Student Reegistration
if (isset($_POST['registration'])) {

  $nam =  mysqli_real_escape_string($con, $_POST['name']);
  $emal =  mysqli_real_escape_string($con, $_POST['email']);
  $pas =  mysqli_real_escape_string($con, $_POST['pass']);
  $roll =  mysqli_real_escape_string($con, $_POST['roll']);

  if (empty($nam)) {
    array_push($errors, "Name is required");
  }
  if (empty($emal)) {
    array_push($errors, "Email is required");
  }
  if (empty($pas)) {
    array_push($errors, "Password is required");
  }
  if (empty($roll)) {
    array_push($errors, "Roll Number is required");
  }



  $user_check_query = "SELECT * from login where email='$emal' limit 1";
  $ck  = mysqli_query($con, $user_check_query);
  $user = mysqli_fetch_assoc($ck);
  if ($user) {
    if ($user['email'] == $emal) {
      array_push($errors, "Email Already Exist");
    }
  }

  $user_check_query1 = "SELECT * from student where roll='$roll' limit 1";
  $ck1  = mysqli_query($con, $user_check_query1);
  $user1 = mysqli_fetch_assoc($ck1);
  if ($user1) {
    if ($user1['roll'] == $roll) {
      array_push($errors, "Roll Number Already Registered. Contact Department Office.");
    }
  }

  if (count($errors) == 0) {

    $sql2 =  "INSERT INTO verify (name , email ,pass ,roll) VALUES ('$nam' , '$emal' , '$pas' , '$roll')";
    $resa = mysqli_query($con, $sql2);
    header('Location:verification.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $password = mysqli_real_escape_string($con, $_POST['password']);

  if (empty($email)) {
    array_push($errors, "Email is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }


  if (count($errors) == 0) {
    /* $password = md5($password); */
    $query = "SELECT * FROM login WHERE email='$email' AND pass='$password'";


    $resu = mysqli_query($con, $query);
    $nm = mysqli_fetch_assoc($resu);

    if (mysqli_num_rows($resu) == 1) {
      $_SESSION['id'] = $nm["id"];
      $_SESSION['name'] = $nm["name"];

      $_SESSION['email'] = $email;

      $_SESSION['success'] = "You are now logged in";

      header('location: admin.php');
    }
  } else {
    array_push($errors, "Wrong username/password combination");
  }
  array_push($errors, "Wrong username/password combination");
}
