<?php
include ('connect.php');
session_start();
$hotel=$_SESSION['HotelName'];

$check_in_date=strtotime($_SESSION['check_in_date']);
$check_out_date=strtotime($_SESSION['check_out_date']);



if(!empty($_POST)) {
    $resour = mysqli_query($con, "SELECT DISTINCT RoomType FROM HotelRoom WHERE HotelName = '$hotel'");
    $check=0;
while ($row = mysqli_fetch_array($resour)) {
    if(isset($_POST[$row["RoomType"]])){
        $_SESSION[$row["RoomType"]]=$_POST[$row["RoomType"]];
        if ($_POST[$row["RoomType"]]!=0){
            $check=1;
        }
    }
}
if ($check==0) {
    echo '<script language="javascript">';
    echo 'alert("Please select a Room")';
    echo '</script>';
}else{
    header("Location:SelectBreakFastAndService.php");
}
}
?>
<html>
<head>
    <title>CustomerInfo</title>
    <link rel="stylesheet" type="text/css" href="SelectRoom.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .center {
            left: 60%;
            margin: 0 auto;
            background-color: aqua;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid" id="wrapper">
        <div class="navbar-header">
            <a class="navbar-brand" href="test.php">Hulton</a>
        </div>
        <ul class="nav navbar-nav">
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php
            if (!isset($_SESSION['CID'])) {
                echo '<li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>';
            }
            if (isset($_SESSION['CID'])) {
                echo '<li><a href="MakeReservation.php">Go Back</a></li>';

                echo '<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> welcome '.$_SESSION['CID'].'! </a></li>' ;
            }
            ?>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
</nav>
</body>
<form method="post" action="SelectRoom.php" id="outPopUp">
    <div class="container">
        <div class="row vertical-offset-100">
            <div class="col-md-4 col-md-offset-150">
                <div class="panel panel-default" style="width: 150%;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Select Room Type</h3>
                    </div>
                    <div class="panel-body">
<table width="500px">
    <tr>
        <td>Select Room Type:</td>
    </tr>
    <tr>
        <th>Room Type:</th>
        <th>Your selection</th>
    </tr>
    <?php
    if ($hotel!="") {
        $res = mysqli_query($con, "SELECT DISTINCT RoomType,RoomID,NumberOfRoom FROM HotelRoom WHERE HotelName = '$hotel'");
        while ($row = mysqli_fetch_array($res)) {
            $result = mysqli_query($con, "SELECT RID,CheckInDate,CheckOutDate FROM Reservation WHERE RoomID = '$row[RoomID]'");
            $count = 0;
            while ($rowO = mysqli_fetch_array($result)) {
                $Rcheckin = strtotime($rowO["CheckInDate"]);
                $Rcheckout = strtotime($rowO["CheckOutDate"]);
                if (($Rcheckout > $check_in_date) && ($Rcheckin < $check_out_date)) {
                    $count++;
                }
            }
            if ($count < $row["NumberOfRoom"]) {
                ?><tr>
                <td width="900">
                    <?php echo $row["RoomType"];
                    $dist = mysqli_query($con, "SELECT discount,Start_date,End_date FROM discount WHERE ROOMID = '$row[RoomID]'");


                    while ($dis = mysqli_fetch_array($dist)) {
                        $Start = strtotime($dis["Start_date"]);
                        $End = strtotime($dis["End_date"]);
                        if (($Start > $check_out_date) || ($End < $check_in_date)) {
                            continue;
                        } else {
                            echo '<span style="color:#f97352;text-align:center;"> (reserve now to get </span>';
                             $discount = $dis["discount"];
                            echo "<span style = 'color: #f97352;'>$discount </span>";
                            echo '<span style="color:#f97352;text-align:center;"> % discount!)</span>';
                            break;
                        }
                    }
                    ?>

                </td>
                <td>
                    <select name="<?php
                    echo $row["RoomType"]; ?>">
                        <?php
                        echo $row["RoomType"];
                        echo "<option selected='selected' value='0'>";
                        echo "Select";
                        echo "</option> ";
                        $a = 0;
                        while ($a < ($row["NumberOfRoom"] - $count)) {
                            $a++;
                            ?>
                            <option value="<?php echo "$a" ?>"><?php echo "$a" ?> </option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <?php
            }

            ?></tr><?php
        }
    }
?>
    </tr>
</table>
    <input type="submit" value="Submit the form"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</>
</html>
