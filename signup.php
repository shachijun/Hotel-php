
<?php

include ('connect.php');




if(!empty($_POST)) {
    $CID = $_POST['CID'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $Phone_no = $_POST['Phone_no'];
    $Name = $_POST['Name'];
    $Password = $_POST['Password'];

    $if_user_already_exist = $con->query("SELECT * FROM Customer WHERE '$CID'=CID");

    $numofrows = $if_user_already_exist->num_rows;


    if($numofrows> 0 ){
        echo '<script language="javascript">';
        echo 'alert("User already exists")';
        echo '</script>';

    }else if ($CID =="" || $Name =="" ||$Password== "") {
        echo '<script language="javascript">';
        echo 'alert("CID Name and Password is required")';
        echo '</script>';
    }else{


        $sql = "INSERT INTO Customer (CID , Email , Address , Phone_no,Name , Password)   VALUES ('$CID' , '$Email' , '$Address' , '$Phone_no' , '$Name' , '$Password' )";
        if (!mysqli_query($con, $sql)) {
            echo '<script language="javascript">';
            echo 'alert("Not inserted")';
            echo '</script>';
        }

        header("Location:login.php");
    }
}
?>
<head>
    <title>Signin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="customer.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">

        #loginform{

            display: block;
            text-align: center;
            opacity: 0.8;

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
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        </ul>
    </div>
</nav>











<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please sign up</h3>
                </div>
                <div class="panel-body">
                    <form action="signup.php" method="post">
                        <fieldset>
                            <div class="form-group">Username
                                <input class="form-control" placeholder="please input your user name" name="CID" type="text">
                            </div>
                            <div class="form-group">Email
                                <input class="form-control" placeholder="Email" name="Email" type="email" value="">
                            </div>

                            <div class="form-group">Address
                                <input class="form-control" placeholder="Address" name="Address" type="text" value="">
                            </div>
                            <div class="form-group">Phone Number
                                <input class="form-control" pattern="^\d{3}\d{3}\d{4}$" placeholder="Phone_no" name="Phone_no" type="tel" value="">
                            </div>
                            <div class="form-group">Name
                                <input class="form-control" placeholder="Name" name="Name" type="text" value="">
                            </div>
                            <div class="form-group">Password
                                <input class="form-control" placeholder="Password" name="Password" type="password" value="">
                            </div>



                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Sign up">
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





<script type="text/javascript" src="assets/js/bootstrap.js"></script>
</body>



