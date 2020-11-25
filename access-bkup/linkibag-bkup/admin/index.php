<?php
include('../config/DB.class.php');
include('classes/common.class.php');
$co = new commonClass();
$co->__construct();
if($co->is_adminlogin()){ header("location:main.php"); }

else{ header("location:login.php"); } 

?>
