<?php
session_start();
include ('connect.php');

if (!empty($_POST))//check is any post has been made
{
    if(strtotime($_POST['fromDate']) > strtotime($_POST['toDate']) ){
        echo '<script language="javascript">';
        echo 'alert("Sorry, the second date you enter must larger than the first date.")';
        echo '</script>';
    }else{
        $_SESSION['fromDate'] = $_POST['fromDate'];
        $_SESSION['toDate'] = $_POST['toDate'];
        $fromDate = $_SESSION['fromDate'];
        $toDate = $_SESSION['toDate'];
        header("Location:AdminDisplay.php");
    }
}
?>

<!--  jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

<!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<html>
<head>
    <title>CustomerInfo</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="Admin.css">
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
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="test.php">Hulton</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <?php
            if (!isset($_SESSION['CID'])) {
            echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
            }
            if (isset($_SESSION['CID'])) {
            echo '<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Welcome Admin! </a></li>' ;
            }

            ?>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

        </ul>
    </div>
</nav>

<div id="outPopUp">
    <div class="container">
        <div class="row vertical-offset-100">
            <div class="col-md-4 col-md-offset-150">

                <!-- Form code begins -->
                <form action="AdminUse.php" accept-charset="UTF-8" role="form" method="POST">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Select Date</h3>
                        </div>
                        <div class="panel-body">
                    <table>
                        <label for="shootdate">From Date</label>
                        <input required type="date" name="fromDate" id="shootdate1"
                               <?php echo date('Y-m-d'); ?>/>
                    </table>

                    <table>

                        <label for="shootdate">To Date</label>
                        <input required type="date" name="toDate" id="shootdate2"
                               <?php echo date('Y-m-d'); ?>/>
                    </table>

                    <div class="form-group"> <!-- Submit button -->
                        <button class="btn btn-primary " name="submit" type="submit">Submit</button>
                    </div>
                    </div>
                    </div>
                </form>
                <!-- Form code ends -->

            </div>
        </div>
    </div>
</div>


</body>
</html>