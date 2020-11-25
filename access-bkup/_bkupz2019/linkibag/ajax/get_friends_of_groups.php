<?php
include('../config/web-config.php');
include('../config/DB.class.php');
include('../classes/common.class.php');
include('../classes/user.class.php');
$co = new userClass();
$co->__construct();

	$include = 'yes';	$user_login = $co->is_userlogin(); 	$msg = '';	$del = '';	if($user_login){			$current = $co->getcurrentuser_profile();		if(!isset($_POST['group']))				exit();		$result = $co->fetch_all_array("select u.email_id from user_friends uf, users u where uf.uid=:uid and uf.fgroup=:fgroup and uf.status='1' and uf.fid=u.uid ORDER BY uf.friend_id DESC",array('uid'=>$current['uid'], 'fgroup'=>$_POST['group']));
		$data = array();
		foreach($result as $list){
			$data[] = $list['email_id'];
		}
		echo json_encode(array('select_val'=>$data));		exit();		}
?>
