<?php
include('../config/web-config.php');
include('../config/DB.class.php');
include('../classes/common.class.php');
include('../classes/user.class.php');
$co = new userClass();
$co->__construct();

$user_login = $co->is_userlogin(); 	
if($user_login){			
	$current = $co->getcurrentuser_profile();		
	$co->query_update('users', array('hide_scan_fulldetail'=>($current['hide_scan_fulldetail']==0 ? '1' : '0')), array('id'=>$current['uid']), 'uid=:id');
	echo json_encode(array('success'=>1));		
	exit();		
}
?>
