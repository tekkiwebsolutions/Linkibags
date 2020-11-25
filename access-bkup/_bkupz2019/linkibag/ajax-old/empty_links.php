<?php
if(isset($_POST['id']) and isset($_POST['ajax']) and isset($_POST['trash'])){		
	include('../config/web-config.php');
	include('../config/DB.class.php');
	include('../classes/common.class.php');
	include('../classes/user.class.php');
	$co = new userClass();
	$co->__construct();

		$include = 'yes';		
		$user_login = $co->is_userlogin(); 		
		if($user_login){				
			$current = $co->getcurrentuser_profile();			
			$cond = array();
			if(isset($_POST['type']) and  $_POST['type'] == 'category'){
				$sql = "select COUNT(shared_url_id) as total from user_shared_urls where url_cat=:cat and shared_to=:to";	
				$cond['cat'] = $_POST['id'];
				$cond['to'] = $current['uid'];
			}else if(isset($_POST['type']) and  $_POST['type'] == 'group'){
				$sql = "select COUNT(friend_id) as total from user_friends where uid=:uid and fgroup=:group";	
				$cond['group'] = $_POST['id'];
				$cond['uid'] = $current['uid'];
			}
			
			$info = $co->query_first($sql,$cond);			
			if(isset($info['total']) and $info['total'] > 0){
				//if($_POST['trash'] == 1)
				//	$co->query_delete('user_shared_urls', array('id'=>$_POST['id'],'id2'=>$current['uid'],'cat'=>0), 'url_cat=:id and shared_to=:id2 and url_cat=:cat');			
					if(isset($_POST['type']) and  $_POST['type'] == 'category'){
						if($_POST['trash'] == 0 or $_POST['trash'] == 1)
							$co->query_update('user_shared_urls', array('url_cat'=>-1), array('id'=>$_POST['id'],'id2'=>$current['uid']), 'url_cat=:id and shared_to=:id2');			
						echo 'category';
					}else if(isset($_POST['type']) and  $_POST['type'] == 'group'){
						if($_POST['trash'] == 0)
							$co->query_update('user_friends', array('fgroup'=>0), array('id'=>$_POST['id'],'id2'=>$current['uid']), 'fgroup=:id and uid=:id2');
						echo 'group';
					}	
										
			}								
			exit();			
		}
}		
?>
