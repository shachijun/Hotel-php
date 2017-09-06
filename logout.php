<?php
include ('connect.php');

session_start();


//unset($_SESSION['CID']);
session_destroy();

header("Location:test.php");
?>