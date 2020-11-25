<?php  
function page_access(){	
	global $co, $msg;      	
	$user_login = $co->is_userlogin(); 
	$co->page_title = "Friend Request | Linkibag";     
 	//$current = $co->getcurrentuser_profile();
	$up = array();	
	if(isset($_GET['request_id']) and $_GET['request_id'] > 0 and isset($_GET['request_code']) and isset($_GET['accept'])){
		$result = $co->query_first("select * from friends_request where request_id=:id and request_code=:code and status='0'", array('id'=>$_GET['request_id'], 'code'=>$_GET['request_code']));
		//print_r($result);
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
				//if(isset($result['request_id']) and $result['request_id'] > 0){
				$co->query_update('friends_request', $up, array('id'=>$result['request_id']), 'request_id=:id');
				echo '<script language="javascript">window.location="index.php?p=dashboard";</script>'; 
					
				//for($i=0;$i<=1;$i++){
					//$rpl_uid = $uid['uid'];
					//$uid['uid'] = $chk_already_member['uid'];
					//$chk_already_member['uid'] = $rpl_uid;
				if($status == 1){
					$no_times = 0;
					$chk_friend_id = $co->query_first("select request_id from user_friends where request_id=:id", array('id'=>$result['request_id']));
					if(!(isset($chk_friend_id['request_id']) and $chk_friend_id['request_id'] > 0))
						$no_times = 1;	
					for($i=0;$i<=$no_times;$i++){		
						$up = array();									
						$up['request_id'] = $result['request_id'];									
						$up['uid'] = $chk_already_member['uid'];
						$up['fid'] = $uid['uid'];
						$up['fgroup'] = 0;
						$up['status'] = 1;
						$up['date'] = date('Y-m-d');
						$up['created'] = time();
						$up['updated'] = time();	
						$friend_id = $co->query_insert('user_friends', $up);
						if(!(isset($chk_friend_id['request_id']) and $chk_friend_id['request_id'] > 0)){						
							$rpl_uid = $uid['uid'];
							$uid['uid'] = $chk_already_member['uid'];
							$chk_already_member['uid'] = $rpl_uid;
						
						}
					}
					if($no_times == '0'){
						$co->query_update('user_friends', array('status'=>1,'fid'=>$chk_already_member['uid']), array('uid'=>$uid['uid'],'request_id'=>$result['request_id']), 'uid=:uid and request_id=:request_id');
					}	
					unset($up);
					$co->setmessage("status", "Congratulation ! You accepted friend request of ".$uid['email_id']." .You are now friend with ".$uid['email_id']." .You can now share links with ".$uid['email_id'].".");
				}else if($status == 2){	
					$co->query_delete('user_friends', array('uid'=>$uid['uid'],'fid'=>$chk_already_member['uid']), 'uid=:uid and fid=:fid');
					$co->setmessage("status", "You declined friend request of ".$uid['email_id']." .You can send friend request him to add your friend.");
				}	
				//}
				
				exit();	
			}else{
				//echo '<script language="javascript">window.location="index.php";</script>';      		
				echo '<script language="javascript">window.location="index.php?p=personal-account&request_id='.$_GET['request_id'].'&request_code='.$_GET['request_code'].'&accept='.$_GET['accept'].'";</script>';
			}
					
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

