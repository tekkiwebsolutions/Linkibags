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
	if(trim($_POST['recommend_category_msg']) != ''){
		$up_val = array();
		$up_val['uid'] = $current['uid'];
		$up_val['recommend_category_msg'] = trim($_POST['recommend_category_msg']);
		$up_val['recommend_category_msg_created'] = time();
		$up_val['recommend_category_msg_updated'] = time();
		$co->query_insert('recommend_user_category_msgs', $up_val);
		unset($up_val);		
		echo '<div style="color: #e6bc81;">Success! thank you for your submission.</div>';	
		exit();		

	}	
}
?>
