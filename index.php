<?php include_once('connect.php');

$teacher1 = "select * from teacher";
$teacher2 = mysqli_query($con, $teacher1);
$teacher = mysqli_fetch_array($teacher2);




$today = date('Y-m-d');
$query = "SELECT DISTINCT email,name,stime,etime,room FROM schedule WHERE date='$today'
";
$res = mysqli_query($con, $query);
$res2 = mysqli_query($con, $query);

$m = date('t');
$last = (int)$m;
$sche = "select * from schedule WHERE date='$today'";
$sch = mysqli_query($con, $sche);
$schedule = mysqli_fetch_array($sch);


if (mysqli_num_rows($sch) == 0) {
    
    $scheqwer = "DELETE  from schedule";
    $schasdf = mysqli_query($con, $scheqwer);
  
    $schwer = "DELETE  from request";
    $schdf = mysqli_query($con, $schwer);
    
    $schwe = "DELETE  from appointment";
    $schd = mysqli_query($con, $schwe);
    
    
    
    
    
    while ($rows2 = mysqli_fetch_assoc($teacher2)) {
        $nam = $rows2['name'];
        $emal = $rows2['email'];
        $rom = $rows2['room'];
        $stm = $rows2['stime'];
        $etm = $rows2['etime'];

        for ($i = 1; $i <= $last; $i++) {
            if ($i < 10) {
                $dat = date('Y-m-') . '0' . $i;
            } else {
                $dat = date('Y-m-') . $i;
            }

            $sql2 =  "INSERT INTO schedule (name  ,date, email ,stime ,etime ,room ) VALUES ('$nam' ,'$dat', '$emal'  , '$stm' , '$etm' , '$rom' )";
            $resa = mysqli_query($con, $sql2);
            header("Refresh:0");

        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Time</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .one {
            margin: 40px 35%;
        }

        .content-table {
            margin: 25px 5% 0 5%;
            min-width: 90%;
            border-radius: 5px 5px 0 0;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15)
        }

        .content-table thead tr {
            font-size: 1.2em;

            background-color: #009879;
            color: #ffffff;
            text-align: left;
            font-weight: bold;

        }

        .content-table td,
        th {
            padding: 12px 15px;
        }

        .content-table tbody tr {
            font-size: .9em;

            border-bottom: 1px solid #dddddd
        }

        tr:nth-child(2n+1) {
            background-color: f3f3f3;
        }
    </style>
</head>

<body>


    <div class="container" style="width: 100%;">
        <h1 class='one'>Consultation Time</h1>
        <table class="content-table">

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Room</th>
                </tr>
            </thead>
            <?php
            while ($rows = mysqli_fetch_assoc($res)) {


                $nstart = date('h:i A', strtotime($rows['stime']));
                $nend = date('h:i A', strtotime($rows['etime']));

            ?>
                <tbody>
                    <tr>
                        <td><?php echo strtoupper($rows['name']); ?></td>
                        <td><?php echo  $nstart ?> - <?php echo $nend ?></td>
                        <td><?php echo $rows['room'] ?></td>
                    </tr>
                </tbody>

            <?php
            }
            ?>
        </table>


        <div class="content-table">
            <a href="admin.php" class="btn-lg btn btn-secondary  btn-block">Login</a>
        </div>
    </div>



</body>

</html>