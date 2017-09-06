
<?php
session_start();
include ('connect.php');
$CID=$_SESSION['CID'];
$ridarray = $_SESSION['arrayOfRID'];
for ($i = 0; $i < sizeof($ridarray); $i++) {
    $sql = "DELETE FROM Reservation WHERE RID='$ridarray[$i]'";
    if (!mysqli_query($con, $sql)) {
        echo "Not deleted";
    }

    $sql = "DELETE FROM NumberBS WHERE RID='$ridarray[$i]'";
    if (!mysqli_query($con, $sql)) {
        echo "Not deleted";
    }
    session_destroy();
    session_start();
    $_SESSION['CID'] = $CID;




    echo "<script>
        alert('you are not going to pay  ');
        window.location.href='test.php';
           </script>";


}

?>
