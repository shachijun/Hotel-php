<?php
session_start();
include ('connect.php');
$CID=$_SESSION['CID'];
session_destroy();
session_start();
$_SESSION['CID'] = $CID;
?>