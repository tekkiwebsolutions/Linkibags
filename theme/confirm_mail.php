<?php  
function page_access(){	
	global $co, $msg;      	
	
	$co->page_title = "Change Email | LinkiBag";     
 	//$current = $co->getcurrentuser_profile();
	$up = array();	
	//print_r($_GET); die();
	if(isset($_GET['request_id']) and $_GET['request_id'] > 0 and isset($_GET['request_code']) and isset($_GET['accept'])){
		$result = $co->query_first("select * from users where uid=:id and email_unique_path=:code and reset_confirm=0 ", array('id'=>$_GET['request_id'], 'code'=>$_GET['request_code']));
		if(isset($result['uid']) and $result['uid'] > 0){
			$chk_already_member = $co->query_first("select uid from users where email_id=:email", array('email'=>$result['request_email']));
			$uid = $co->query_first("select uid,email_id from users where uid=:by", array('by'=>$result['uid']));
			
				
		
				
                if($_GET['accept'] == 'yes')
                {
					$reset_confirm = 1;
					$up['email_id'] = $result['reset_old_email'];
					$up['reset_confirm'] = $reset_confirm;
                    $co->query_update('users', $up, array('id'=>$result['uid']), 'uid=:id');
                    
                }
				
                else if($_GET['accept'] == 'no')
                {
                    
                    $reset_confirm = 2;
                    $up['reset_confirm'] = $reset_confirm;
                    $up['reset_old_email'] = '';
                    $co->query_update('users', $up, array('id'=>$result['uid']), 'uid=:id');
                   
                }
					
				
			
				
				if($reset_confirm == 1){
					$co->setmessage("status", "Congratulation ! Your email has been successfully changed.");
				}else if($reset_confirm == 2){	
					$co->setmessage("status", "You requested has been processed to cancel email changes.");
				}
				echo '<script language="javascript">window.location="index.php?p=login";</script>';
				exit();	
					
		}else{
		    	$co->setmessage("status", "Invalid confirmation code or your code has been expired. Please try again.");
            	echo '<script language="javascript">window.location="index.php?p=login";</script>';
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

