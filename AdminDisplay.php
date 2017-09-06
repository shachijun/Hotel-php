<?php
session_start();
include ('connect.php');

$fromDate = $_SESSION['fromDate'];
$toDate = $_SESSION['toDate'];

$check_in_date=strtotime($fromDate);
$check_out_date=strtotime($toDate);

$rooId=mysqli_query($con, "SELECT DISTINCT RoomID  FROM HotelRoom");
$HotId=mysqli_query($con, "SELECT DISTINCT HotelID FROM HotelRoom");
$breakId = mysqli_query($con, "SELECT DISTINCT BID FROM Breakfast");
$servId = mysqli_query($con, "SELECT DISTINCT SID FROM Service");

$HotelCount=mysqli_num_rows ($HotId);
$RoomCount=mysqli_num_rows ($rooId);
$breakfastCount = mysqli_num_rows($breakId);
$serviceCount = mysqli_num_rows($servId);


//Highest Rated Room Type Part
$HotelId=1;
$array=array("Volvo");
while ($HotelId<=$HotelCount) {
    $highestRoom=0;
    $result_Room = mysqli_query($con, "SELECT RoomID FROM HotelRoom WHERE HotelID='$HotelId'");
    while ($rowRoom = mysqli_fetch_array($result_Room)) {
        $ROOMID=$rowRoom["RoomID"];
        $result_Reservation = mysqli_query($con, "SELECT RID, CheckOutDate, CheckInDate FROM Reservation WHERE RoomId='$ROOMID'");

        //get all the RID for one RoomId
        while ($row = mysqli_fetch_array($result_Reservation)) {
            //select only the reservation between the selected dates
            if (($check_out_date > strtotime($row["CheckOutDate"])) && ($check_in_date < strtotime($row["CheckInDate"]))) {
                $RID = $row["RID"];

                //part1 - get all room reviews.
                $result_Review = mysqli_query($con, "SELECT RoomReview FROM Review WHERE RID = '$RID'");
                $save1 = 0;
                $save2 = 0;
                $count = 0;

                //get all the reviews for one reservation
                while ($row_Review = mysqli_fetch_array($result_Review)) {
                    $RoomReview = $row_Review["RoomReview"];
                    $save2 += $RoomReview;
                    $count++;
                }
                if ($count != 0) {
                    $save2 /= $count;
                }
                if ($save1 < $save2) {
                    $save1 = $save2;
                    $highestRoom=$ROOMID;
                }
            }
        }
    }
    array_push($array, "$highestRoom");
    $HotelId++;


}
$arrlength = count($array);

//Highest Rated Breakfast Type Part
$breakfastId = 1;
$highestB = 0;
while ($breakfastId < $breakfastCount) {

    $result_bRID = mysqli_query($con, "SELECT RID, CheckOutDate, CheckInDate FROM Reservation WHERE RID IN 
                                                  (SELECT RID FROM NumberBS WHERE BID='$breakfastId')");

    while ($row = mysqli_fetch_array($result_bRID)) {
        //select only the reservation between the selected dates
        if (($check_out_date > strtotime($row["CheckOutDate"])) && ($check_in_date < strtotime($row["CheckInDate"]))) {
            $bRID = $row["RID"];
            $saveB1 = 0;
            $saveB2 = 0;
            $countB = 0;

            $result_bReview = mysqli_query($con, "SELECT BReview FROM Review WHERE RID = '$bRID'");

            //get all the reviews for one reservation
            while ($row_bReview = mysqli_fetch_array($result_bReview)) {
                $BReview = $row_bReview['BReview'];
                $saveB2 += $BReview;
                $countB++;
            }
            if ($countB != 0) {
                $saveB2 /= $countB; //the review for each breakfast
            }
            if ($saveB1 < $saveB2) {
                $saveB1 = $saveB2;
                $highestB = $breakfastId;
            }
        }
    }
    $breakfastId++;
}

//Highest Rated Service Type Part
$serviceId = 1;
$highestS = 0;
while ($serviceId < $serviceCount) {

    $result_sRID = mysqli_query($con, "SELECT RID, CheckOutDate, CheckInDate FROM Reservation WHERE RID IN 
                                                  (SELECT RID FROM NumberBS WHERE SID='$serviceId')");

    while ($row = mysqli_fetch_array($result_sRID)) {
        //select only the reservation between the selected dates
        if (($check_out_date > strtotime($row["CheckOutDate"])) && ($check_in_date < strtotime($row["CheckInDate"]))) {
            $sRID = $row["RID"];
            $saveS1 = 0;
            $saveS2 = 0;
            $countS = 0;

            $result_sReview = mysqli_query($con, "SELECT SReview FROM Review WHERE RID = '$sRID'");

            //get all the reviews for one reservation
            while ($row_sReview = mysqli_fetch_array($result_sReview)) {
                $SReview = $row_sReview['SReview'];
                $saveS2 += $SReview;
                $countS++;
            }
            if ($countS != 0) {
                $saveS2 /= $countS; //the review for each breakfast
            }
            if ($saveS1 < $saveS2) {
                $saveS1 = $saveS2;
                $highestS = $serviceId;
            }
        }
    }
    $serviceId++;
}

//Find Top 5 Customers Part
$CID = "";
$arrayM=array("Customer");

$HotelCount=mysqli_num_rows ($HotId);

$result_CID = mysqli_query($con, "SELECT DISTINCT CID, moneyspend FROM Customer");
while ($row = mysqli_fetch_array($result_CID)) {
    $CID=$row["CID"];
    //select only the reservation between the selected dates
    $result_money = mysqli_query($con, "SELECT CheckInDate,CheckOutDate FROM Reservation WHERE CID = '$CID'");
    while ($row_money = mysqli_fetch_array($result_money)) {

        if (($check_out_date > strtotime($row_money["CheckOutDate"])) && ($check_in_date < strtotime($row_money["CheckInDate"]))) {
            $CID = $row["CID"];
            if ($CID != '0') {
                $money = $row['moneyspend'];
                array_push($arrayM, "$money");
                break;
            }


        }
    }
}

rsort($arrayM); //sort the array in descending order
$final_cArray = array_unique($arrayM); //remove duplicates
$arrayMLength = count($final_cArray);

?>

<html>
<head>
    <title>Admin Display</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="Admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>


<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="test.php">Hulton</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="AdminUse.php">Go Back</a></li>';
            <?php
            if (!isset($_SESSION['CID'])) {
                echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
            }
            if (isset($_SESSION['CID'])) {
                echo '<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Welcome Admin! </a></li>' ;
            }

            ?>

            <a href="AdminUse.php"?toDate = <?php echo $toDate ?></span></a>
            <a href="AdminUse.php"?fromDate = <?php echo $fromDate ?></span></a>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

        </ul>

    </div>
</nav>

<!-- Form code begins -->
<form action="AdminDisplay.php" accept-charset="UTF-8" role="form" method="POST">

<div class="container">
    <div class="page-header">
    <h2>Admin User</h2>
    <h4>You can find the highest rated room type, customer, breakfast and service type here.</h4>
    </div>

    <div class="panel panel-primary">
    <table class="table">
        <thead>
        <tr>
            <th>HotelID</th>
            <th>RoomType</th>
        </tr>
        </thead>
        <tbody>
        <?php

        for($x = 1; $x < $arrlength; $x++) {
            $currRoomID = $array[$x];
            if($currRoomID==0){

                ?>

            <tr class="info">
                <td><?php echo $x; ?></td>
                <td><?php echo "Review not made for this hotel"; ?></td>
            </tr>

            <?php

            } else{
            $reas = "SELECT RoomType, HotelID, HotelName FROM HotelRoom WHERE RoomID = $currRoomID";
            $result_roomType = mysqli_query($con, $reas);

            if (mysqli_num_rows($result_roomType) < 1) { //the total num of breakfast
                $RoomType = "No Highest Rated Room Type Currently";
            } else {
                while ($row_roomType = mysqli_fetch_array($result_roomType)) {
                    ?>

                    <tr class="info">
                        <td><?php echo $row_roomType['HotelID']; ?></td>
                        <td><?php echo $row_roomType['RoomType']; ?></td>
                    </tr>

                    <?php
                }
            }
            }
        }
        ?>


        </tbody>
    </table>
    </div>

    <div class="panel panel-success">
    <table class="table">
        <thead>
        <tr>
            <th>Best Customers</th>
            <th>Customer ID</th>
        </tr>
        </thead>
        <tbody>
        <?php

        for($i = 1; $i < $arrayMLength; $i++) {
            if ($i < 6) {
                $currMoney = $final_cArray[$i];
                $currMoneyFloat = $currMoney + 0.001;
                $currMoney = $currMoney - 0.001;
                $result_customer = mysqli_query($con, "SELECT CID FROM Customer WHERE moneyspend BETWEEN '$currMoney' AND '$currMoneyFloat'");

                if (mysqli_num_rows($result_customer) < 1) { //the total num of breakfast
                    ?>
                    <tr class="success">
                        <td><?php echo $i; ?></td>
                        <td><?php echo "No Best Customers Currently" ?></td>
                    </tr>
                    <?php

                } else {
                    while ($row_customer = mysqli_fetch_array($result_customer)) {
                        ?>

                        <tr class="success">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row_customer['CID']; ?></td>
                        </tr>

                        <?php
                    }
                }
            }

        }
        ?>

        </tbody>
    </table>
    </div>

    <div class="panel panel-success">
    <table class="table">
        <thead>
        <tr>
            <th>Highest Rated Breakfast Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($highestB==0){

            ?>

            <tr class="warning">
                <td><?php echo "No Highest Rated Breakfast Type Currently"; ?></td>
            </tr>

            <?php

        } else {
            $BType = "SELECT BType FROM Breakfast WHERE BID = $highestB";
            $result_BType = mysqli_query($con, $BType);

            if (mysqli_num_rows($result_BType) < 1) { //the total num of breakfast
                $BType = "No Highest Rated Breakfast Type Currently";
            } else {
                while ($row_BType = mysqli_fetch_array($result_BType)) {
                    ?>

                    <tr class="warning">
                    <td><?php echo $row_BType['BType']; ?></td>

                                <?php
                            }
            }
        }
        ?>

        </tbody>
    </table>
    </div>


    <div class="panel panel-success">
    <table class="table">
        <thead>
        <tr>
            <th>Highest Rated Service Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if($highestS==0){

                        ?>

                        <tr class="info">
                            <td><?php echo "No Highest Rated Service Type Currently"; ?></td>
                        </tr>

                        <?php

            } else {
                        $SType = "SELECT SType FROM Service WHERE SID = $highestS";
                        $result_SType = mysqli_query($con, $SType);

                        if (mysqli_num_rows($result_SType) < 1) { //the total num of breakfast
                            $SType = "No Highest Rated Service Type Currently";
                        } else {
                            while ($row_SType = mysqli_fetch_array($result_SType)) {
                                ?>
                                <tr class="warning">
                                    <td><?php echo $row_SType['SType']; ?></td>
                                </tr>

                                <?php
                            }
                        }
            }
        ?>

        </tbody>
    </table>
    </div>
    </div>
</form>

</body>
</html>

