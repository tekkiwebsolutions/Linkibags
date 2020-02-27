<?php  
function page_access(){	
	global $co, $msg;      	
	$user_login = $co->is_userlogin(); 
	$co->page_title = "Friend Request | Linkibag";     
 	//$current = $co->getcurrentuser_profile();
	$up = array();	
	if(isset($_GET['request_id']) and $_GET['request_id'] > 0 and isset($_GET['request_code']) and isset($_GET['accept'])){
		$result = $co->query_first("select * from friends_request where request_id=:id and request_code=:code and status='0'", array('id'=>$_GET['request_id'], 'code'=>$_GET['request_code']));
		if(isset($result['request_id']) and $result['request_id'] > 0){
			$chk_already_member = $co->query_first("select uid from users where email_id=:email", array('email'=>$result['request_email']));
			$uid = $co->query_first("select uid,email_id from users where uid=:by", array('by'=>$result['request_by']));
			
			if(isset($chk_already_member['uid']) and $chk_already_member['uid'] > 0){
				if(!$user_login){   
					echo '<script language="javascript">window.location="index.php?p=login&request_id='.$_GET['request_id'].'&request_code='.$_GET['request_code'].'&accept='.$_GET['accept'].'";</script>';      		
					exit();      
				}	
				$up['request_to'] = $chk_already_member['uid'];
				
				if($_GET['accept'] == 'yes')
					$status = 1;
				elseif($_GET['accept'] == 'no')
					$status = 2;
				
				$up['status'] = $status;
				$co->query_update('friends_request', $up, array('id'=>$result['request_id']), 'request_id=:id');
				$chk_register = $co->query_first("select * from user_friends where request_id=:id and uid=:uid", array('id'=>$_GET['request_id'], 'uid'=>$result['request_by']));
				if($chk_register['fid']!=$chk_already_member['uid']){
					$co->query_update('user_friends', array('fid'=>$chk_already_member['uid']), array('id'=>$_GET['request_id'], 'uid'=>$result['request_by']), 'request_id=:id and uid=:uid');
					$co->query_update('user_friends', array('uid'=>$chk_already_member['uid']), array('id'=>$_GET['request_id'], 'fid'=>$result['request_by']), 'request_id=:id and fid=:fid');
				}
				
				if($status == 1){
					$co->query_update('user_friends', array('status'=>1), array('id'=>$result['request_id']), 'request_id=:id');
					$co->setmessage("status", "Congratulation ! You accepted a friend request of ".$uid['email_id']);
				}else if($status == 2){	
					$co->query_update('user_friends', array('status'=>2), array('id'=>$result['request_id']), 'request_id=:id');
					$co->setmessage("status", "You declined friend request of ".$uid['email_id']." .You can send friend request him to add your friend.");
				}
				echo '<script language="javascript">window.location="index.php?p=dashboard";</script>';
				exit();	
			}else{  		
				echo '<script language="javascript">window.location="index.php?request_id='.$_GET['request_id'].'&request_code='.$_GET['request_code'].'&accept='.$_GET['accept'].'#free_singup";</script>';
			}
					
		}else{
			echo '<script language="javascript">window.location="index.php;</script>'; 
			exit();	
		}	
		
	}else{
		echo '<script language="javascript">window.location="index.php;</script>'; 
		exit();	
	}	
	//$co->nnn = "Yes";
	/*if(!$user_login){   
		echo '<script language="javascript">window.location="index.php?p=login&request_id='.$_GET['request_id'].'&request_code='.$_GET['request_code'].'&accept='.$_GET['accept'].((isset($_GET['register']) and $_GET['register'] != '') ? '&register='.$_GET['register'].'' : '').'";</script>';      		
		exit();      
	} 

	*/		
}
function page_content(){      
	global $co, $msg;   
		
}      

