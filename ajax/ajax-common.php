<?php 
include('../config/web-config.php');
include('../config/DB.class.php');
include('../classes/common.class.php');
include('../classes/user.class.php');
$co = new userClass();
$co->__construct();
$response = array();
if (isset($_POST['action']) && $_POST['action']=='getState') { 
    
    if($_POST['country_id'] > 0){
       
		$html='<option value="">Select</option>';
	    $states = $co->fetch_all_array("select id,state_name,code from states WHERE country_id=:countryId ORDER BY id ASC", array('countryId'=>$_POST['country_id']));
	   
		foreach($states as $state){ 
			$html .= '<option value="'.$state['id'].'" >'.$state['code'].'</option>';
		}
		$response['html']=$html;
		$response['success']=1; 
	} else{
		$response['success']=0;
	} 
	die(json_encode($response)); 
}

if (isset($_POST['action']) && $_POST['action']=='resendConfirmMail') { 
    $uid = $_POST['uid'];
    if($uid > 0){
		$userData = $co->fetch_all_array("SELECT * FROM users WHERE uid= :uid", array("uid"=>$uid));
		$verify_code = $userData[0]['verify_code'];
		$to = $postdata['email_id'] = $userData[0]['email_id'];
		 
		$email_link = WEB_ROOT.'index.php?p=verify&user='.$uid.'&v='.$verify_code;
		$postdata['verified_link'] = $co->get_bit_ly_link($email_link);			
		$mail_content = $co->mail_format('new_register', $postdata);
		$co->send_email($to, $mail_content['subject'], $mail_content['matter']);
		
		$response['success']=1; 
	} else{
		$response['success']=0;
	} 
	die(json_encode($response)); 
}

die(json_encode($response));	
?>