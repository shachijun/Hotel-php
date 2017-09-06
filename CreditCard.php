<script type="text/javascript">
    function onClickMain() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "onClickMain.php", false);
        xmlhttp.send(null);
    }
    function onClickGoBack() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "onClickGoBack.php", false);
        xmlhttp.send(null);
    }

</script>

<?php

session_start();
include "connect.php";

$ridarray = $_SESSION['arrayOfRID'];
$CID = $_SESSION['CID'];



if (!empty($_POST)) {
    if (isset($_POST["not_pay"]) && $_POST['not_pay']) {
        for ($i = 0; $i < sizeof($ridarray); $i++) {
            $sql = "DELETE FROM Reservation WHERE RID='$ridarray[$i]'";
            if (!mysqli_query($con, $sql)) {
                echo "Not deleted";
            }

            $sql = "DELETE FROM NumberBS WHERE RID='$ridarray[$i]'";
            if (!mysqli_query($con, $sql)) {
                echo "Not deleted";
            }
            session_destroy();
            session_start();
            $_SESSION['CID'] = $CID;


            echo "<script>
        alert('you are not going to pay  ');
        window.location.href='test.php';
           </script>";


        }

        header("Location:test.php");
    }
    if ($_POST['pay']) {

        if ($_POST['username'] != "" && $_POST['email'] != "" && $_POST['password_confirm'] != "") {

            $sql = mysqli_query($con, "SELECT MAX(moneyspend) AS oldmoneyspend from Customer where CID = '$CID' ");
            $row = mysqli_fetch_array($sql);
            $oldmoneyspend = $row['oldmoneyspend'];//old money spend

            $newmoneytotal = $oldmoneyspend + $_SESSION['totalamout'];


            $sql = "UPDATE Customer SET moneyspend = '$newmoneytotal' WHERE CID = '$CID';";
            if (!mysqli_query($con, $sql)) {
                echo "Not inserted";
            }
            session_destroy();
            session_start();
            $_SESSION['CID'] = $CID;

            echo "<script>
        alert('successfully booked ');
        window.location.href='test.php';
           </script>";


        }else{
            echo '<script language="javascript">';
            echo 'alert("Not complete input")';
            echo '</script>';
        }

    }
}



?>

<html>
<head>
    <title>CreditCard</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="customer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .submit-button {
            margin-top: 10px;
        }
    </style>
</head>


<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">



<!--            ????-->
            <a class="navbar-brand" name="not_pay" type="submit" href="test.php" onclick="onClickMain()">Hulton</a>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li><a href="SelectBreakFastAndService.php" onclick="onClickGoBack()">Go Back</a></li>';
            <li><a href="logout.php"  onclick="onClickMain()"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>

    </div>
</nav>
<h1>Your total payment due is : <?php echo $_SESSION['totalamout'] ?> </h1>


<div class="container">
    <div class="row-fluid">
        <form action="CreditCard.php" class="form-horizontal" method="post">
            <fieldset>
                <div id="legend">
                    <legend class="">Payment</legend>
                </div>

                <!-- Name -->
                <div class="control-group">
                    <label class="control-label"  for="username">Card Holder's Name</label>
                    <div class="controls">




                        <input  type="text" id="username" name="username" placeholder="" class="input-xlarge">
                    </div>
                </div>

                <!-- Card Number -->
                <div class="control-group">
                    <label class="control-label" for="email">Card Number</label>
                    <div class="controls">
                        <input  type="text" id="email" name="email" placeholder="" class="input-xlarge">
                    </div>
                </div>

                <!-- Expiry-->
                <div class="control-group">
                    <label class="control-label" for="password">Card Expiry Date</label>
                    <div class="controls">
                        <select class="span3" name="expiry_month" id="expiry_month">
                            <option></option>
                            <option value="01">Jan (01)</option>
                            <option value="02">Feb (02)</option>
                            <option value="03">Mar (03)</option>
                            <option value="04">Apr (04)</option>
                            <option value="05">May (05)</option>
                            <option value="06">June (06)</option>
                            <option value="07">July (07)</option>
                            <option value="08">Aug (08)</option>
                            <option value="09">Sep (09)</option>
                            <option value="10">Oct (10)</option>1
                            <option value="11">Nov (11)</option>
                            <option value="12">Dec (12)</option>
                        </select>
                        <select class="span2" name="expiry_year">
                            <option value="18">2018</option>
                            <option value="19">2019</option>
                            <option value="20">2020</option>
                            <option value="21">2021</option>
                            <option value="22">2022</option>
                            <option value="23">2023</option>
                        </select>
                    </div>
                </div>

                <!-- CVV -->
                <div class="control-group">
                    <label class="control-label"  for="password_confirm">Card CVV</label>
                    <div class="controls">
                        <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="span2">
                    </div>
                </div>



                <!-- Submit -->
                <div class="control-group">
                    <div class="controls">
                        <input class="btn btn-lg btn-success btn-block" name="pay" type="submit" value="I am paying ">
                        <input class="btn btn-lg btn-success btn-block" name="not_pay" type="submit" value="I am not paying">

                    </div>
                </div>

            </fieldset>
        </form>
    </div>
</div>
</body>


<script>
    function myFunction() {
        alert("I am an alert box!");
    }
</script>
</html>