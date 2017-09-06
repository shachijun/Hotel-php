
<?php
$con = mysqli_connect("107.180.50.176","shixinran","shixinran") or die ('error de conexion'.mysql_error()) ;

if(!$con){
    echo "Not connect to server";
}
if(!mysqli_select_db($con , 'Hulton')){
    echo 'Databas not selected';
}
?>


<?php

$con = mysqli_connect('localhost','root','');
include ('connect.php');




if(!$con){
    echo "Not connect to server";
}
if(!mysqli_select_db($con , 'Pj')){
    echo 'Databas not selected';
}
