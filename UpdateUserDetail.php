
<?php
include "connect.php";
session_start();
$CID = $_SESSION['CID'];

if(!empty($_POST)) {
    $res = mysqli_query($con, "SELECT Email, Address, Phone_no, Name, Password  FROM Customer WHERE CID = '$CID'");
    $row = mysqli_fetch_array($res);
    $Email = $row["Email"];
    $Address = $row['Address'];
    $Phone_no = $row['Phone_no'];
    $Name = $row['Name'];
    $Password = $row['Password'];
    $need=0;
    if ($_POST['Email']!=""){
        $Email = $_POST['Email'];
        $need=1;
    }
    if ($_POST['Address']!=""){
        $Address = $_POST['Address'];
        $need=1;
    }
    if ($_POST['Phone_no']!=""){
        $Phone_no = $_POST['Phone_no'];
        $need=1;
    }
    if ($_POST['Name']!=""){
        $Name = $_POST['Name'];
        $need=1;
    }
    if ($_POST['Password']!=""){
        $Password = $_POST['Password'];
        $need=1;
    }

    if ($need==0) {
            echo '<script language="javascript">';
            echo 'alert("Nothing need update")';
            echo '</script>';
        }else{
        $sql = "UPDATE Customer
        SET Email = '$Email', Address = '$Address',Phone_no = '$Phone_no',Name = '$Name' , Password = '$Password'
        WHERE CID='$CID'";
        mysqli_query($con, $sql);
        header( "Location:test.php" );
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
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Log out</a></li>
        </ul>
    </div>
</nav>






<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please change your detail</h3>
                </div>
                <div class="panel-body">
                    <form action="UpdateUserDetail.php" method="post">
                        <fieldset>

                            <?php
                            $res = mysqli_query($con, "SELECT Email, Address, Phone_no, Name, Password  FROM Customer WHERE CID = '$CID'");
                            $row = mysqli_fetch_array($res)
                            ?>
                            <div class="form-group">Email
                                <input class="form-control" placeholder="<?php echo $row["Email"]?>" name="Email" type="email" value="">
                            </div>

                            <div class="form-group">Address
                                <input class="form-control" placeholder="<?php echo $row["Address"]?>" name="Address" type="text" value="">
                            </div>
                            <div class="form-group">Phone_no
                                <input class="form-control" pattern="^\d{3}\d{3}\d{4}$" placeholder="<?php  if ($row["Phone_no"]==0){
                                    echo "No phone number";
                                }else{
                                    echo $row["Phone_no"];
                                }?>" name="Phone_no" type="tel" value="">
                            </div>
                            <div class="form-group">Name
                                <input class="form-control" placeholder="<?php echo $row["Name"]?>" name="Name" type="text" value="">
                            </div>
                            <div class="form-group">Password
                                <input class="form-control" placeholder="<?php echo $row["Password"]?>" name="Password" type="password" value="">
                            </div>



                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Update">
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



