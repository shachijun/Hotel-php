<?php
session_start();
include ('connect.php');
$country = isset($_GET['country']) ? $_GET['country'] : '';

$state = isset($_GET['state']) ? $_GET['state'] : '';
$hotel=isset($_GET['hotel']) ? $_GET['hotel'] : '';


if ($country!=""){
    $res=mysqli_query($con,"SELECT DISTINCT State FROM `HotelRoom` WHERE Country = '$country'");

    echo "<select name = 'selectedState' id='statedd' onchange='Change_state()'>";
    echo "<option selected='selected'>"; echo "Select"; echo"</option> ";


    while ($row=mysqli_fetch_array($res)){
        echo "<option value='$row[State]' >"; echo $row["State"]; echo "</option>";
    }
    echo "</select>";


}

if ($state!=""){
    $res=mysqli_query($con,"SELECT DISTINCT HotelName FROM `HotelRoom` WHERE State = '$state'");
    echo "<select name = 'HotelName' id='hoteldd' onchange='Change_hotel()'>";
    echo "<option selected='selected'>"; echo "Select"; echo"</option> ";

    while ($row=mysqli_fetch_array($res)){
        echo "<option value='$row[HotelName]'>"; echo $row["HotelName"]; echo "</option>";
    }
    echo "</select>";


}








?>
