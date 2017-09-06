<script type="text/javascript">
    function onClickMain() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "onClick.php", false);
        xmlhttp.send(null);
    }


</script>

<?php
session_start();
include ('connect.php');
$CID = $_SESSION['CID'];
$RID=0;
$q      = "Select * From Reservation Where CID = '$CID' ";
$result = mysqli_query($con, $q);
while ($row = mysqli_fetch_assoc($result)) {
    if (isset($_SESSION["review" . $row["RID"]])) {
        $RID = $_SESSION["review" . $row["RID"]];
        break;
    }

}

$submit = false;
$reserve_r = true;
$reserve_b = 0;
$reserve_s = 0;

$select_reviewRID = "SELECT * FROM Review WHERE RID = '$RID'";
$result_reviewRID = mysqli_query($con, $select_reviewRID);
if (mysqli_num_rows($result_reviewRID) >= 1)  {
        echo '<script language="javascript">';
        echo 'alert("Sorry, you already make review for this reservation.")';
        echo '</script>';
        $submit = false;
    header( "refresh:0.01; url=CheckReservation.php" );
    session_destroy();
    session_start();
    $_SESSION['CID'] = $CID;
}


if(!empty($_POST)) {
    $select_b = "SELECT DISTINCT BID FROM NumberBS WHERE RID = '$RID'";
    $result_b = mysqli_query($con, $select_b);

    $select_s = "SELECT DISTINCT SID FROM NumberBS WHERE RID = '$RID'";
    $result_s = mysqli_query($con, $select_s);
    if (!empty($_POST['serviceReview'])) {
        if (($_POST['serviceReview']) > 0 && ($_POST['serviceReview']) <= 10) {
            $reserve_s = $_POST['serviceReview'];
            $submit = true;
        } else {
            echo '<script language="javascript">';
            echo 'alert("Sorry, you can only submit int review between 1-10. Please try again.")';
            echo '</script>';
            $submit = false;
        }
    } else {
            $_POST['serviceReview'] = 0;
            echo '<script language="javascript">';
            echo 'alert("Sorry, you did not make any service review. Your other reviews are saved")';
            echo '</script>';
            $submit = false;
    }
    if (!empty($_POST['breakfastReview'])) {
        if (($_POST['breakfastReview']) > 0 && ($_POST['breakfastReview']) <= 10) {
            $reserve_b = $_POST['breakfastReview'];
            $submit = true;
        } else {
            echo '<script language="javascript">';
            echo 'alert("Sorry, you can only submit int review between 1-10. Please try again.")';
            echo '</script>';
            $submit = false;
        }
    } else {
        $_POST['breakfastReview'] = 0;
        echo '<script language="javascript">';
        echo 'alert("You did not make any breakfast review. Your other reviews are saved")';
        echo '</script>';
        $submit = false;
    }

    //no breakfast reservation
    if (mysqli_num_rows($result_b) < 1) {
        echo '<script language="javascript">';
        echo 'alert("Sorry, you did not make any Breakfast Reservation to review. Your other reviews are saved.")';
        echo '</script>';
        $reserve_b = 0;
    } else {
        while($row = $result_b->fetch_assoc()) {
            $BID = $row["BID"];
        }
    }

    //no service reservation
    if (mysqli_num_rows($result_s) < 1) {
        echo '<script language="javascript">';
        echo 'alert("Sorry, you did not make any Service Reservation to review. Your other reviews are saved.")';
        echo '</script>';
        $reserve_s = 0;
    } else {
        while($row = $result_s->fetch_assoc()) {
            $SID = $row["SID"];
        }
    }

    //get the input value
    if (!empty($_POST['roomReview'])){
        if (($_POST['roomReview']) > 0 && ($_POST['roomReview']) <= 10) {
            $RoomReview = $_POST['roomReview'];
            $submit = true;
        } else {
            echo '<script language="javascript">';
            echo 'alert("Sorry, you can only submit int review between 1-10. Please try again.")';
            echo '</script>';
            $submit = false;
        }

    } else { //didn't input any value
        $_POST['roomReview'] = 0;
        echo '<script language="javascript">';
        echo 'alert("Sorry, you can only submit int review between 1-10. Please try again.")';
        echo '</script>';
        $submit = false;
    }

}

?>

<html>
<head>
    <title>CustomerInfo</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="customer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>


<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" name="not_pay" type="submit" href="test.php" onclick="onClickMain()">Hulton</a>
        </div>
        <ul class="nav navbar-nav navbar-right">


            <?php
            if (!isset($_SESSION['CID'])) {
                echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
            }
            if (isset($_SESSION['CID'])) {
                echo '<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> welcome '.$_SESSION['CID'].'! </a></li>' ;
            }

            ?>
            <li><a href="CheckReservation.php" onclick="onClickMain()">Go Back</a></li>';
            <li><a href="logout.php"  onclick="onClickMain()"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>


        </ul>
    </div>
</nav>


<script src="http://mymaplist.com/js/vendor/TweenLite.min.js"></script>
<!-- This is a very simple parallax effect achieved by simple CSS 3 multiple backgrounds, made by http://twitter.com/msurguy -->

<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h3 class="panel-title">Create Reviews</h3>
                </div>

                <div class="panel-body">

                    <form action="Reviews.php" accept-charset="UTF-8" role="form" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="roomReview" name="roomReview" type="text" value="">
                            </div>

                            <div class="form-group">
                                <input class="form-control" placeholder="serviceReview" name="serviceReview" type="text" value="">
                            </div>

                            <div class="form-group">
                                <input class="form-control" placeholder="breakfastReview" name="breakfastReview" type="text" value="">
                            </div>

                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Submit Review"
                                <?php
                                if ($reserve_r == true) {
                                    echo ' onclick="Submit Review" ';
                                } else {
                                    echo ' disabled=disabled ';
                                }
                                ?>
                            />

                            <?php
                            if ($submit == true) {

                                echo '<script language="javascript">';
                                echo 'alert("Review Submitted! Thank you!")';
                                echo '</script>';
                                header( "refresh:0.01; url=CheckReservation.php" );
                                session_destroy();
                                session_start();
                                $_SESSION['CID'] = $CID;

                                        $insert_sql = "INSERT INTO Review (CID , RoomReview , BReview , SReview, RID)   VALUES ('$CID' , '$RoomReview' , '$reserve_b' , '$reserve_s' , '$RID')";
                                        if (!mysqli_query($con, $insert_sql)) {
                                            echo "Not inserted";
                                        }


                            }


                            ?>

                        </fieldset>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>