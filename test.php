<?php
session_start();
include ('connect.php');


?>
<!DOCTYPE html>
<html>
<head>
    <title>CustomerInfo</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>


<body>





<nav class="navbar navbar-inverse" style="
    margin-bottom: 0px;
">

        <div class="navbar-header">
            <a class="navbar-brand" href="test.php">Hulton</a>
        </div>
        <ul class="nav navbar-nav">

            <?php
            if (isset($_SESSION['CID'])) {
                echo '<li><a href="MakeReservation.php">Make a reservation</a></li>';
            }
            if (isset($_SESSION['CID'])) {
                echo '<li><a href="CheckReservation.php">check reservation</a></li>';
            }
            if (isset($_SESSION['CID'])) {
                echo '<li><a href="UpdateUserDetail.php">update user detail</a></li>';
            }
            ?>


        </ul>
        <ul class="nav navbar-nav navbar-right">

            <?php
            if (!isset($_SESSION['CID'])) {
                echo '<li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>';
            }


            if (!isset($_SESSION['CID'])) {
                echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
            }
            if(isset($_SESSION['CID'])){
                echo '<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> welcome '.$_SESSION['CID'].'! </a></li>' ;
                echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';
            }

            ?>

        </ul>

</nav>


<?php

if (isset($_SESSION['CID'])) {

    $CID = $_SESSION['CID'];




}
?>


<section class="mbr-slider mbr-section mbr-section--no-padding carousel slide" data-ride="carousel" data-wrap="true" data-interval="5000" id="slider-5" style="background-color: #4c6972;">
    <div class="mbr-section__container">
        <div>
            <ol class="carousel-indicators">
                <li data-app-prevent-settings="" data-target="#slider-5" data-slide-to="0" class="active"></li><li data-app-prevent-settings="" data-target="#slider-5" data-slide-to="1"></li><li data-app-prevent-settings="" data-target="#slider-5" class="" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="mbr-box mbr-section mbr-section--relative mbr-section--fixed-size mbr-section--bg-adapted item dark center mbr-section--full-height active" style="background-image: url(http://www.dusit.com/dusitthani/dubai/wp-content/blogs.dir/31/files/home/dtdu_home_hero_gracious-thai-hospitality-in-the-heart-of-dubai.jpg);">
                    <div class="mbr-box__magnet mbr-box__magnet--center-right mbr-box__magnet--sm-padding">

                        <div class=" container">

                            <div class="row">
                                <div class=" col-md-6 col-md-offset-5">

                                    <div class="mbr-hero">
                                        <h1 class="mbr-hero__text">Best Rooms Ever </h1>

                                        <p class="mbr-hero__subtext">You will love it</p>
                                    </div>
                                    <div class="mbr-buttons btn-inverse mbr-buttons--left mbr-buttons--right"><a class="mbr-buttons__btn btn btn-lg btn-danger" href="#">Room Description</a> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><div class="mbr-box mbr-section mbr-section--relative mbr-section--fixed-size mbr-section--bg-adapted item dark center mbr-section--full-height" style="background-image: url(http://starcitytoursuae.com/wp-content/uploads/2015/08/burj-al-arab-exterior1-hero1.jpg);">
                    <div class="mbr-box__magnet mbr-box__magnet--center-center mbr-box__magnet--sm-padding">

                        <div class=" container">

                            <div class="row">
                                <div class=" col-md-8 col-md-offset-2">

                                    <div class="mbr-hero">
                                        <h1 class="mbr-hero__text">Our Food Are Delicious</h1>

                                        <p class="mbr-hero__subtext">Taste it now</p>
                                    </div>
                                    <div class="mbr-buttons btn-inverse mbr-buttons--center"><a class="mbr-buttons__btn btn btn-lg btn-danger" href="Menu.php">Food Menu</a> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><div class="mbr-box mbr-section mbr-section--relative mbr-section--fixed-size mbr-section--bg-adapted item dark center mbr-section--full-height" style="background-image: url(http://dl.booloor.com/pictures/02/burj-al-arab/Burj_Al_Arab_2025.jpg);">
                    <div class="mbr-box__magnet mbr-box__magnet--center-left mbr-box__magnet--sm-padding">

                        <div class=" container">

                            <div class="row">
                                <div class=" col-md-6 col-md-offset-1">

                                    <div class="mbr-hero">
                                        <h1 class="mbr-hero__text">Our Services Are Brilliant</h1>

                                        <p class="mbr-hero__subtext">Try them out </p>
                                    </div>
                                    <div class="mbr-buttons btn-inverse mbr-buttons--left"><a class="mbr-buttons__btn btn btn-lg btn-danger" href="#">See Services Menu</a> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a data-app-prevent-settings="" class="left carousel-control" role="button" data-slide="prev" href="#slider-5">
                <span aria-hidden="true"><</span>
                <span class="sr-only">Previous</span>
            </a>
            <a data-app-prevent-settings="" class="right carousel-control" role="button" data-slide="next" href="#slider-5">
                <span aria-hidden="true">></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</section>






</body>
</html>