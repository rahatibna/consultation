<?php
$id = $_GET['id'];
include_once('connect.php'); 
$query = "DELETE from request WHERE id='$id'";
$res = mysqli_query($con, $query);
$result = mysqli_fetch_array($res);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete Request</title>
</head>
<body>
<?php
header('Location: user.php');
?>
    
</body>
</html>
