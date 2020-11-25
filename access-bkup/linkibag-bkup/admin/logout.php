<?php

session_start(); //Start the current session

if(isset($_SESSION['admin_website'])){

	unset($_SESSION['admin_website']);

	unset($_SESSION['admin_uid']);

}

header("location:index.php");

?>

