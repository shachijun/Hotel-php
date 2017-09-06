<?php

for ($i = 0; $i < sizeof($ridarray); $i++) {
    $sql = "DELETE FROM Reservation WHERE RID='$ridarray[$i]'";
    if (!mysqli_query($con, $sql)) {
        echo "Not deleted";
    }

    $sql = "DELETE FROM NumberBS WHERE RID='$ridarray[$i]'";
    if (!mysqli_query($con, $sql)) {
        echo "Not deleted";
    }

}
?>