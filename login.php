
<?php
// new commit
session_start();

include "connect.php";

if(!empty($_POST)) {

    $CID = $_POST['CID'];
    $Password = $_POST['password'];
    $loginsql = "SELECT * FROM Customer WHERE CID = '$CID' AND Password = '$Password'";

    $result = $con->query($loginsql);

    if (!$row = $result->fetch_assoc()) {
        echo '<script language="javascript">';
        echo 'alert("not logedin , your username or password is wrong")';
        echo '</script>';
    } else {
        $_SESSION['CID']=$CID;

        if ($CID == "0") {
            echo "admin login";
            header("Location:AdminUse.php");
        } else {
            echo "logined";
            header("Location:test.php");
        }

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
            <a class="navbar-brand" href="test.php">Hulton</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
          
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>

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
                    <h3 class="panel-title">Please log in</h3>
                </div>
                <div class="panel-body">
                    <form action="login.php" accept-charset="UTF-8" role="form" method="POST">
                        <fieldset>
                            <div class="form-group">Username
                                <input class="form-control" placeholder="please input your username" name="CID" type="text">
                            </div>
                            <div class="form-group">Password
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <div class="checkbox">

                            </div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(document).mousemove(function(e){
            TweenLite.to($('body'),
                .5,
                { css:
                    {
                        backgroundPosition: ""+ parseInt(event.pageX/8) + "px "+parseInt(event.pageY/'12')+"px, "+parseInt(event.pageX/'15')+"px "+parseInt(event.pageY/'15')+"px, "+parseInt(event.pageX/'30')+"px "+parseInt(event.pageY/'30')+"px"
                    }
                });
        });
    });


</script>
</body>
</html>