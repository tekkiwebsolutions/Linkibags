<?php
include('../config/web-config.php');
include('../config/DB.class.php');
include('../classes/common.class.php');
include('../classes/user.class.php');
$co = new userClass();
$co->__construct();

	$include = 'yes';	
	$user_login = $co->is_userlogin(); 	
	$msg = '';	
	$del = '';	
	if($user_login){			
		$current = $co->getcurrentuser_profile();		
		if(!isset($_POST['group']))				
			exit();		
		/*$result = $co->fetch_all_array("select email_id from user_friends uf, users u, groups_friends gf where uf.uid=:uid and gf.groups=:fgroup and gf.email_id=uf.fid and u.uid=uf.fid ORDER BY uf.friend_id DESC",array('uid'=>$current['uid'], 'fgroup'=>$_POST['group']));*/
		$result = $co->fetch_all_array("SELECT DISTINCT(IFNULL(u.email_id, gf.email_id)) as email FROM groups_friends gf LEFT JOIN users u ON u.uid=gf.email_id WHERE gf.uid=:uid and gf.groups=:fgroup",array('uid'=>$current['uid'], 'fgroup'=>$_POST['group']));
		$data = array();
		foreach($result as $list){
			$data[] = $list['email'];
		}
		echo json_encode(array('select_val'=>$data));		
		exit();		
	}
?>
