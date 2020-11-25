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
	if($_POST['like_url'] == 1 and $_POST['shared_url_id'] > 0){
		$result = $co->query_first("select * from `user_shared_urls` where shared_url_id=:id and shared_to=:uid",array('id'=>$_POST['shared_url_id'],'uid'=>$current['uid'])); 
		if(isset($result['shared_url_id']) and $result['shared_url_id'] > 0){
			$up_val = array();
			if($result['like_status'] == 1)
				$up_val['like_status'] = 2;
			else
				$up_val['like_status'] = 1;

			$up_val['like_unlike_time'] = time();
			$co->query_update('user_shared_urls', $up_val, array('id'=>$result['shared_url_id'], 'uid'=>$current['uid']), 'shared_url_id=:id and shared_to=:uid');
			echo $up_val['like_status'];
			unset($up_val);		
			exit();		
		}	
	}	
}
?>
