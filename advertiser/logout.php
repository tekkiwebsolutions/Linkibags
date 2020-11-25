<?php

session_start(); //Start the current session

if(isset($_SESSION['advertiser_website'])){

	unset($_SESSION['advertiser_website']);

	unset($_SESSION['advertiser_uid']);

}

header("location:index.php");

?>

