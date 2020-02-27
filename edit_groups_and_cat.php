<?php
include('config/web-config.php');
include('config/DB.class.php');
include('classes/common.class.php');
include('classes/user.class.php');
$co = new userClass();
$co->__construct();

$include = 'yes';$user_login = $co->is_userlogin();  	if($user_login){		$current = $co->getcurrentuser_profile();			if(!isset($_POST['id']) and !isset($_POST['type']))			exit();	}	

	
$co->edit_groups_and_cat($current['uid'], $_POST['id'], $_POST['type'], 'edit','0');
?>
