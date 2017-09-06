<?php
session_start();
include "connect.php";
$hotel = $_SESSION['HotelName'];
$checkin = strtotime($_SESSION['check_in_date']);
$checkout = strtotime($_SESSION['check_out_date']);
$diff = $checkout - $checkin;
$diff= floor($diff / (60 * 60 * 24));

//echo $_SESSION['check_in_date'];


//echo $diff ;
$CID = $_SESSION['CID'];


$rowSQL = mysqli_query($con, "SELECT MAX(HotelID) AS hotel_ID FROM HotelRoom WHERE HotelName = '$hotel'");
$row = mysqli_fetch_array($rowSQL);
$HID_delected = $row['hotel_ID'];



$arrayofRID = array();



function discountGet($con , $check_out_date , $check_in_date, $roomID){

    $discount = 100 ;
    $dist = mysqli_query($con, "SELECT discount,Start_date,End_date FROM discount WHERE ROOMID = '$roomID'");
    while ($dis = mysqli_fetch_array($dist)) {


        $Start = strtotime($dis["Start_date"]);
        $End = strtotime($dis["End_date"]);
        if (($Start > strtotime($check_out_date)) || ($End < strtotime($check_in_date))) {
            //echo "jkghhj";
            continue;
        } else {
            $discount = $dis["discount"];
            break;
        }
    }
    return $discount;


}



if (!empty($_POST)){

if (isset($_POST['ok_to_pay'])) {
    $moneyTotal = 0 ;
    $resour = mysqli_query($con, "SELECT DISTINCT RoomType FROM HotelRoom WHERE HotelName = '$hotel'");
    while ($row = mysqli_fetch_array($resour)) {//循环有多少种房型的次数

        $roomType = $row["RoomType"];//$roomtype 是roomtype的名字

        if (isset($_SESSION[$roomType])) {


            //先把这种类型房子的roomid搞出来
            $sql = mysqli_query($con, "SELECT MAX(RoomID) AS roomid from HotelRoom where RoomType = '$roomType' AND HotelID = '$HID_delected'");
            $row = mysqli_fetch_array($sql);
            $RoomID = $row['roomid'];//可以在这里加上价钱

            $Num_Of_Certain_rooms = $_SESSION[$roomType];
            for ($i = 0; $i < $Num_Of_Certain_rooms; $i++) {
                $total_for_single_room = 0;

                $sql = mysqli_query($con, "SELECT MAX(Price) AS roomprice from HotelRoom where RoomID = '$RoomID'");
                $row = mysqli_fetch_array($sql);
                $roomprice = $row['roomprice'];

                $discount = discountGet($con ,$_SESSION["check_out_date"] , $_SESSION["check_in_date"] , $RoomID );

                $total_for_single_room = $total_for_single_room + $roomprice * $discount / 100;

                $moneyTotal = $moneyTotal + $roomprice * $discount / 100;


                //插到reservation表里面， 然后找出最大的RID ， 然后再用最大的RID 往Numberbs里面塞
                $sql = "INSERT INTO Reservation (RID , CID , RoomID , CheckInDate,CheckOutDate , Payment )   VALUES ('' , '$CID' ,  '$RoomID' , '$_SESSION[check_in_date]' , '$_SESSION[check_out_date]' , '' )";
                if (!mysqli_query($con, $sql)) {
                    echo "Not inserted";
                }
                $rowSQL = mysqli_query($con, "SELECT MAX(RID) AS biggest FROM Reservation");
                $row = mysqli_fetch_array($rowSQL);
                $largestNumber = $row['biggest'];//现在开始搞早餐
                array_push($arrayofRID , $largestNumber);



                for ($j = 0; $j < 3; $j++) {


                    $bnum = ($HID_delected - 1) * 3 + $j + 1;

                    //Pz_number0breakfast0

                    $sql = mysqli_query($con, "SELECT MAX(BPrice) AS bprice from Breakfast where BID = '$bnum'");
                    $row = mysqli_fetch_array($sql);
                    $roomprice = $row['bprice'];





                    $amount = "$roomType" . "_number" . "$i" . "breakfast" . "$j";
                    if ($_POST[$amount] == 0) {
                        continue;
                    } else {
                        for ($k = 0; $k < $_POST[$amount]; $k++) {
                            $moneyTotal = $moneyTotal + $roomprice;
                            $total_for_single_room = $total_for_single_room + $roomprice;

                            $sql = "INSERT INTO NumberBS (RID , BID , SID  )   VALUES ('$largestNumber' , '$bnum' ,  '' )";
                            if (!mysqli_query($con, $sql)) {
                                echo "Not inserted";
                            }
                        }
                    }


                }


                for ($j = 0; $j < 3; $j++) {
                    $bnum = ($HID_delected - 1) * 3 + $j + 1;

                    $sql = mysqli_query($con, "SELECT MAX(SPrice) AS sprice from Service where SID = '$bnum'");
                    $row = mysqli_fetch_array($sql);
                    $roomprice = $row['sprice'];



                    $amount = "$roomType" . "_number" . "$i" . "service" . "$j";
                    if ($_POST[$amount] == 0) {
                        continue;
                    } else {
                        for ($k = 0; $k < $_POST[$amount]; $k++) {
                            $moneyTotal = $moneyTotal + $roomprice;
                            $total_for_single_room = $total_for_single_room + $roomprice;
                            $sql = "INSERT INTO NumberBS (RID , BID , SID  )   VALUES ('$largestNumber' , '' ,  '$bnum' )";
                            if (!mysqli_query($con, $sql)) {
                                echo "Not inserted";
                            }
                        }
                    }


                }
                //insert for every rid

                /*
                 * $sql = "UPDATE Customer SET moneyspend = '$newmoneytotal' WHERE CID = '$CID';";
        if (!mysqli_query($con, $sql)) {
            echo "Not inserted";
        }
                 * */

                $sql = "UPDATE Reservation SET Payment = '$total_for_single_room' WHERE RID = '$largestNumber' ";
                if (!mysqli_query($con, $sql)) {
                    echo "Not inserted";
                }

            }
        }
    }


    $_SESSION['totalamout'] = $moneyTotal * $diff;
    $_SESSION['arrayOfRID']=$arrayofRID;


    header("Location:CreditCard.php");


}

}

?>


<!DOCTYPE html>
<html>
<head>
    <title>SelectBreakFastAndService</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<table>
    <body>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="test.php">Hulton</a>
            </div>

            <ul class="nav navbar-nav navbar-right">

                <?php
                if (!isset($_SESSION['CID'])) {
                    echo '<li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>';
                }


                if (!isset($_SESSION['CID'])) {
                    echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
                }
                if (isset($_SESSION['CID'])) {
                    echo '<li><a href="SelectRoom.php">Go Back</a></li>';
                    echo '<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> welcome ' . $_SESSION['CID'] . '! </a></li>';
                    echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';
                }

                ?>

            </ul>
        </div>
    </nav>
    <form name="form2" action="SelectBreakFastAndService.php" method="post">


        <table style="width:100%" border="5px">
            <tbody>
            <?php

            $resour = mysqli_query($con, "SELECT DISTINCT RoomType FROM HotelRoom WHERE HotelName = '$hotel'");
            while ($row = mysqli_fetch_array($resour)) {//循环有多少种房型的次数

                $roomType = $row["RoomType"];//$roomtype 是roomtype的名字

                if (isset($_SESSION[$roomType])) {
                //先把这种类型房子的roomid搞出来
                $sql = mysqli_query($con, "SELECT MAX(RoomID) AS roomid from HotelRoom where RoomType = '$roomType' AND HotelID = '$HID_delected'");
                $row = mysqli_fetch_array($sql);
                $RoomID = $row['roomid'];//可以在这里加上价钱

                    //we get what is the discount

                $Num_Of_Certain_rooms = $_SESSION[$roomType];
                for ($i = 0; $i < $Num_Of_Certain_rooms; $i++) {

                    echo "<tr>";
                    echo "<td>" . "$roomType" . $xplus = $i + 1 . "</td>";

                    echo "<td>";

                    echo "<table border='5px'>";
                    $sql1 = mysqli_query($con, "SELECT BType from Breakfast  WHERE BHid = '$HID_delected' ORDER BY BID ASC");
                    $counter = 0;
                    while ($row = mysqli_fetch_array($sql1)) {
                        echo "<tr>";

                        echo "<td>";
                        echo $row["BType"];

                        echo "</td>";

                        echo "<td>";

                        echo '<input type="number" name=' . "$roomType" . '_number' . "$i" . "breakfast" . "$counter" . ' min="0" value = 0 max="5">';


                        $counter++;

                        echo "</td>";
                        echo "</tr>";
                    }


                    echo "</table>";

                    echo "</td>";

                    //0--------------0

                    echo "<td>";

                    echo "<table border='5px'>";
                    $sql1 = mysqli_query($con, "SELECT SType from Service  WHERE SHid = '$HID_delected' ORDER BY SID ASC");
                    $counter = 0;
                    while ($row = mysqli_fetch_array($sql1)) {
                        echo "<tr>";

                        echo "<td>";
                        echo $row["SType"];

                        echo "</td>";

                        echo "<td>";
                        echo '<input type="number" name=' . "$roomType" . '_number' . "$i" . "service" . "$counter" . ' min="0" value = 0 max="5">';
                        $counter++;

                        echo "</td>";
                        echo "</tr>";
                    }


                    echo "</table>";

                    echo "</td>";


                    echo "</tr>";


                }


            }
            }
            ?>
        </table>





        <input class="btn btn-lg btn-success btn-block" name="ok_to_pay" type="submit" value="Confirm">


    </form>






    </body>
</html>