<?php
include('../config/web-config.php');
include('../config/DB.class.php');
include('../classes/common.class.php');
include('../classes/user.class.php');
$co = new userClass();
$co->__construct();

	if(isset($_POST['password']) and $_POST['password']!=''){
		$password =  strlen($_POST['password']);
		$containsLetter  = preg_match('/[a-zA-Z]/', $_POST['password']);
		$containsDigit   = preg_match('/\d/', $_POST['password']);
		//$containswhitespace = preg_match('/ /', $_POST['password']);
		if ($password < 8){
			echo 'false';
		}else if (!$containsLetter or !$containsDigit) {
			echo 'false';
		}else{
			echo 'true';	
		}	
	
	}
?>
