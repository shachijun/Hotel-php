<?php
//echo $_SESSION['selectedState'];
session_start();
include ('connect.php');

if (!empty($_POST))//check is any post has been made
{

    if($_POST['countrydd'] == 'Select' || $_POST['selectedState'] == 'Select'|| $_POST['HotelName'] == 'Select'){
        echo '<script language="javascript">';
        echo "you have to select a Country and state and hotel";
        echo '</script>';
    }else if(strtotime($_POST['check_in_date']) >= strtotime($_POST['check_out_date']) ){
        echo '<script language="javascript">';
        echo 'alert("check in should be earlier than check out")';
        echo '</script>';
    }else if(((strtotime($_POST['check_out_date'])-strtotime($_POST['check_in_date']))/(60*60*24))>30){
        echo '<script language="javascript">';
        echo 'alert("Sorry, reservations for more than 30 nights are not possible.")';
        echo '</script>';
    }else{

        $_SESSION['HotelName'] = $_POST['HotelName'];
        $_SESSION['check_in_date'] = $_POST['check_in_date'];
        $_SESSION['check_out_date'] = $_POST['check_out_date'];
        header("Location:SelectRoom.php");

    }


}



?>


<script type="text/javascript">
    function Change_country() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "SelectState.php?country=" + document.getElementById("countrydd").value, false);
        xmlhttp.send(null);
        document.getElementById("state").innerHTML = xmlhttp.responseText;

        if (document.getElementById("countrydd").value=="Select"){
            document.getElementById("hotel").innerHTML="<select></select>"
        }
        if (document.getElementById("statedd").value=="Select"){
            document.getElementById("hotel").innerHTML="<select>         <option>Select</option></select>"
        }

    }
    function Change_state() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "SelectState.php?state=" + document.getElementById("statedd").value, false);
        xmlhttp.send(null);
        document.getElementById("hotel").innerHTML = xmlhttp.responseText;


    }

</script>


<html>
<head>
    <title>CustomerInfo</title>
    <link rel="stylesheet" type="text/css" href="SelectRoom.css">
    <meta charset="utf-8">

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
                echo '<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> welcome '.$_SESSION['CID'].'! </a></li>' ;
            }

            ?>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
</nav>







<form name="form1" action="MakeReservation.php" method="post" id="outPopUp">
    <div class="container">
        <div class="row vertical-offset-100">
            <div class="col-md-4 col-md-offset-150">
                <div class="panel panel-default">
                   <div class="panel-heading">
                            <h3 class="panel-title">Please Select date and location</h3>
                        </div>
                        <div class="panel-body">

    <table>
        <label for="shootdate">Check in date</label>
    <input required type="date" name="check_in_date" id="shootdate1" title="Choose your check in date"
           min="<?php echo date('Y-m-d'); ?>"/>
    </table>
    <table>

    <label for="shootdate">Check out date</label>
    <input required type="date" name="check_out_date" id="shootdate2" title="Choose your check out date"
           min="<?php echo date('Y-m-d'); ?>"/>
    </table>



    <table>
        <tr>
            <td>Select Country</td>
            <td>


                <select name="countrydd" id="countrydd" onchange="Change_country()">
                    <option>Select</option>
                    <?php
                    $res = mysqli_query($con, "SELECT distinct Country from HotelRoom ");
                    while ($row = mysqli_fetch_array($res)) {
                        ?>
                        <option value="<?php echo $row["Country"]; ?>"><?php echo $row["Country"]; ?> </option>
                        <?php
                    }
                    ?>


                </select>


            </td>
        </tr>


        <tr>
            <td>Select State</td>
            <td>
                <div id="state" >
                    <select >
                        <option>Select</option>
                    </select>
                </div>

            </td>

        </tr>

        <tr>
            <td>Select hotel</td>
            <td>
                <div id="hotel" >
                    <select >
                        <option>Select</option>
                    </select>
                </div>

            </td>

        </tr>






</table>
    <input type="submit" value="Submit the form"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</body>
</html>
