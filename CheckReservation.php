<?php
session_start();

include "connect.php";

if (isset($_SESSION['CID'])) {
    $CID = $_SESSION['CID'];
}
$q      = "Select * From Reservation Where CID = '$CID' ";
$result = mysqli_query($con, $q);
while ($row = mysqli_fetch_assoc($result)) {
    $CheckInDate = strtotime($row["CheckInDate"]);
    $CheckOutDate = strtotime($row["CheckOutDate"]);
    $dat = ($CheckOutDate-$CheckInDate)/(60*24*60);
    $roomcost = $row["Payment"]* $dat;
    if (isset($_POST[$row["RID"]])) {



        $test = $_POST[$row["RID"]];
        $sql = "DELETE FROM Reservation Where RID = $test";
        $delB = "DELETE FROM NumberBS Where RID = $test";
        $delR = "DELETE FROM Review Where RID = $test";
        if (($con->query($sql) === TRUE) and ($con->query($delB)) === TRUE and ($con->query($delR) === TRUE)) {
            $c = "Select * From Customer Where CID = '$CID'";
            $res_c = mysqli_query($con, $c);
            while ($row_c = mysqli_fetch_assoc($res_c)){
                $total = $row_c["moneyspend"];
                $money = $total - $roomcost;
                $update_c = "UPDATE Customer SET moneyspend='$money' Where CID = '$CID'";
            }
            if (mysqli_query($con, $update_c)) {
                echo '<script language="javascript">';
                echo "Successfully cancelled the reservation";
                echo '</script>';
            } else {
                echo "Error deleting recorded: " . $con->error;
            }
        }
    }else if(isset($_POST["review".$row["RID"]])){
        $_SESSION["review".$row["RID"]]=$_POST["review".$row["RID"]];
        $reviewRID = $_SESSION["review".$row["RID"]];
        $result_review = mysqli_query($con, "SELECT * FROM Review WHERE RID = '$reviewRID'");
        while ($row = mysqli_fetch_assoc($result_review)) {
            $make_review = false;
        }
        header("Location:Reviews.php");

    }
}




?>

    <html><head>

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
                    echo '<li><a href="test.php">Go Back</a></li>';

                    echo '<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> welcome ' . $_SESSION['CID'] . '! </a></li>';
                }


                ?>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </div>
    </nav>
        <title>Check Reservation</title>
        <form action="" name="form" method="post">
    <style>
            body, html{
                height: 100%;
                background-repeat: repeat;
                background-color: white;
                font-family: 'Oxygen', sans-serif;
                background-image: url("http://copicola.com/images/background-image/background-image-16.jpg");
                background-color: #cccccc;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }

            form {
                margin: 0 auto;
                width:280px;
            }
        </style>
    <div class="w3-black" id="tour">
        <div class="w3-container w3-content w3-padding-64" style="max-width:800px">
            <h4 class="w3-wide w3-center">Here is your reservation</h4>
            <?php
            $q      = "Select * From Reservation Where CID = '$CID' ";
            $result = mysqli_query($con, $q);

            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                    <p class="w3-opacity w3-center"><i>-------------------------------------------</i></p><br>
                    <?php
                    $CurrentRID = $row["RID"];
                    echo "<br>Reservation number: " . $CurrentRID . "</br>
                            <br>Check in date: " . $row["CheckInDate"] . "</br>
                                <br>Check out date :  " . $row["CheckOutDate"] . "</br>";
                    $rt = "Select * From HotelRoom AS H, Reservation As R Where H.RoomID = R.RoomID AND R.CID = '$CID' AND R.RID = '$CurrentRID'";
                    $res_rt = mysqli_query($con, $rt);
                    while ($row_rt = mysqli_fetch_assoc($res_rt)) {
                        echo "  <br>Room: " . $row_rt["RoomType"] . " </br>";
                    }
                    $b     = "Select * From Breakfast AS B,NumberBS AS N Where N.RID = $CurrentRID AND B.BID = N.BID";
                    $res_b = mysqli_query($con, $b);
                    while ($row_b = mysqli_fetch_assoc($res_b)) {
                        echo "  <br>Breakfast : " . $row_b["BType"] . " </br>";
                    }
                    $s     = "Select * From Service AS S,NumberBS AS N Where N.RID = $CurrentRID AND S.SID = N.SID";
                    $res_s = mysqli_query($con, $s);
                    while ($row_s = mysqli_fetch_assoc($res_s)) {
                        echo "  <br>Service : " . $row_s["SType"] . " </br>";
                    }
                    settype($CurrentRID, "String");
                    ?>
                    <form name="form1" method="post" action="CheckReservation.php">
                        <button class="button" type="submit" name="<?php
                        echo $row["RID"]; ?>" value="<?php echo $CurrentRID?>" >Cancel this reservation</button>

                        <button class="button" type="submit" name="<?php
                        echo "review".$row["RID"]; ?>" value="<?php echo $CurrentRID?>">Make review</button>

                    </form>
                    <?php
                }
                ?>

                <?php
            } else {
                echo '<script language="javascript">';
                echo 'alert("Sorry, you did not make any Reservation to cancel")';
                echo '</script>';
                echo '<button><a href="MakeReservation.php">Make a reservation</a></button>';

            }
            ?>
            </form>

    </body>

    </html>
