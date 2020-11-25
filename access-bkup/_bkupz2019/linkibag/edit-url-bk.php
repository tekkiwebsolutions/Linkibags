<?php
include('config/web-config.php');
include('config/DB.class.php');
include('classes/common.class.php');
include('classes/user.class.php');
$co = new userClass();
$co->__construct();

$include = 'yes';
if(!isset($_POST['id']))
	exit();
	
$co->edit_url($_POST['id']);
?>
