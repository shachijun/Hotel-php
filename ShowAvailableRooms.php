<?php
session_start();
$con = mysqli_connect('localhost','root','');

if(!$con){
    echo "Not connect to server";
}
if(!mysqli_select_db($con , 'Pj')){
    echo 'Databas not selected';
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>CustomerInfo</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        .center {
            left: 60%;
            margin: 0 auto;


        }

    </style>


</head>


<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
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


            if (!isset($_SESSION['CID'])) {
                echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
            }
            if(isset($_SESSION['CID'])){
                echo '<li><a href="Account.php"><span class="glyphicon glyphicon-log-in"></span> '.$_SESSION['CID'].' \'s Account</a></li>' ;
            }

            ?>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
</nav>

<form action="/action_page.php">
    <select name="cars" multiple>
        <option value="volvo">Volvo</option>
        <option value="saab">Saab</option>
        <option value="opel">Opel</option>
        <option value="audi">Audi</option>
    </select>
    <input type="submit">
</form>




