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

$query = "SELECT * from verify";

if ($_SESSION['id'] != '0') {
    header('Location:user.php');
}





$res = mysqli_query($con, $query);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Verification of Students</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

    <div class="header" style=" width: 100%;">
        <h2>Verification of Students</h2>
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
            <p>You Can Verify Students Identity , <strong><?php echo $_SESSION['name']; ?></strong></p>
            <p> <a href="admin.php?logout='0'" style="color: red;">logout</a> </p>
        <?php endif ?>
    </div>


    <div class="container">

        <a href="admin.php" class="btn btn-primary">Admin DashBoard</a>
        <a href="create.php" class="btn btn-primary">Add New Teacher</a>
        <a href="verify.php" class="btn btn-primary"><b>Verification of Students</b></a>
        <a href="students.php" class="btn btn-primary">All Students</a>
        <table class="table table-bordered">
            <a href="users.php" class="btn btn-primary">All Users</a>

<br><br>
            <?php
            if (mysqli_num_rows($res) > 0) {
            ?>

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Roll</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($result = mysqli_fetch_assoc($res)) {

                        ?>
                            <tr>
                                <th scope="row"><?php echo $result['id'] ?></th>
                                <td><?php echo $result['name'] ?></td>
                                <td><?php echo $result['roll'] ?></td>

                                <td><?php echo $result['email'] ?></td>
                                <td>
                                    <a href="verifyi.php?id=<?php echo $result['id'] ?>" class="btn btn-info">Verify</a>

                                    <a href="rejected.php?id=<?php echo $result['id'] ?>" class="btn btn-danger">Reject</a>


                                </td>
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
                        echo 'No Students To Verify';
                        ?>
                    </p>
                </div>

            <?php
            }
            ?>

    </div>
</body>

</html>