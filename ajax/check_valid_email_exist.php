<?php
include('../config/web-config.php');
include('../config/DB.class.php');
include('../classes/common.class.php');
include('../classes/user.class.php');
$co = new userClass();
$co->__construct();

	if(isset($_POST['email_id']) and $_POST['email_id']!=''){
		$email =  $_POST['email_id'];
		if($co->is_emailExists($email)){
			echo 'false';
		}else{
			echo 'true';
		}
			
	}
?>
