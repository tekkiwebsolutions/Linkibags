<?php
include('../config/web-config.php');
include('../config/DB.class.php');
include('../classes/common.class.php');
include('../classes/user.class.php');
$co = new userClass();
$co->__construct();

	$include = 'yes';	$user_login = $co->is_userlogin(); 	$msg = '';	$del = '';	if($user_login){			$current = $co->getcurrentuser_profile();		if(!isset($_POST['id']) and !isset($_POST['user_id']))				exit();		if($current['uid'] == $_POST['user_id']){			if(isset($_POST['type']) and $_POST['type'] == 'move_cat'){
				$co->query_update('user_shared_urls', array('url_cat'=>$_POST['cat']), array('id'=>$_POST['id'],'id2'=>$_POST['user_id']), 'shared_url_id=:id and shared_to=:id2');						$msg = 1;						}else if(isset($_POST['type']) and $_POST['type'] == 'del'){				$co->query_delete('user_shared_urls', array('id'=>$_POST['id'],'id2'=>$_POST['user_id']), 'shared_url_id=:id and shared_to=:id2');						$del = 1;						}		}			echo json_encode(array('msg'=>$msg,'del'=>$del));		exit();		}
?>
