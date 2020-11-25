<?php
class userClass extends commonClass
{
	public function __construct() {
		$user_login = $this->is_userlogin();
		$current = $this->getcurrentuser_profile();
		if(!empty($current['user_timezone'])){
			date_default_timezone_set($current['user_timezone']);
		}else{
			date_default_timezone_set('America/Cancun');
		}
	}
	
	function register_verifycode_mobile($length = 8, $id){
	  	$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
				'0123456789()_[]{}|';
	
	  	$str = '';
	  	$max = strlen($chars) - 1;
	
	  	for ($i=0; $i < $length; $i++)
			$str .= $chars[rand(0, $max)];
		$str .= $id;
	  	$max = strlen($chars) - 1;
	
	  	for ($i=0; $i < $length; $i++)
			$str .= $chars[rand(0, $max)];
			
		$check_path = $this->query_first("SELECT * FROM `register_sms` WHERE valid_path='$str'", array());
		if(isset($check_path['register_id']) and $check_path['register_id']>0)
			$this->register_verifycode_mobile(8, $id);
	
	  	return $str;
	}
	function get_all_roles(){
		$sql = "SELECT * FROM `user_roles`";
		$row = $this->fetch_all_array($sql, array());
		return $row;
	}
	function get_roleinfo($role){
		if($role>1 and $role<5){
			$sql = "SELECT * FROM `user_roles` WHERE `role_id`= :role";				
			$row= $this->row($sql, array("role"=>$role));
			return $row;
		}
	}
	function is_userlogin()
	{
		if(isset($_COOKIE['uid']) && isset($_COOKIE['website']) && $_COOKIE['website']=="Linkibag")
		{
			return true;
		}
		elseif(isset($_SESSION['uid']) && isset($_SESSION['website']) && $_SESSION['website']=="Linkibag")
		{			
			return true;
		}
		else
		{
			return false;
		}
	}
	function user_logout()
	{
		if(isset($_COOKIE['uid']) && isset($_COOKIE['website']) && $_COOKIE['website']=="Linkibag")
		{
			setcookie('uid', $row['uid'], strtotime('-1 days'));			
			setcookie('website', 'Linkibag', strtotime('-1 days'));		
		}
		elseif(isset($_SESSION['uid']) && isset($_SESSION['website']) && $_SESSION['website']=="Linkibag")
		{			
			unset($_SESSION['uid']);
			unset($_SESSION['last_login_time']);
			unset($_SESSION['website']);
		}
	}
	function userlogin($username, $pwd, $remember=0)
	{
		$pwd = md5($pwd);
		//check login with username
		$sql = "SELECT * FROM `users` WHERE `email_id`= :user and `decrypt_pass` = :pass and status=:status and verified=:verified LIMIT 1";				
		$row= $this->row($sql, array("user"=>$username, "pass"=>$pwd, "status"=>1, "verified"=>1));
		//check login with email address
		if(!(isset($row['uid']) and $row['uid']>0)){
			$sql = "SELECT * FROM `users` WHERE `email_id`= :user and `decrypt_pass` = :pass and status=:status and verified=:verified LIMIT 1";
			$row= $this->row($sql, array("user"=>$username, "pass"=>$pwd, "status"=>1, "verified"=>1));
		}
		if(!(isset($row['uid']) and $row['uid']>0)){
			$sql = "SELECT * FROM `users` WHERE `mobile`= :user and `decrypt_pass` = :pass and status=:status and verified=:verified LIMIT 1";				
			$row= $this->row($sql, array("user"=>$username, "pass"=>$pwd, "status"=>1, "verified"=>1));
		}
		
		if(isset($row['uid']) and $row['uid']>0)
		{
			$chk_all_friend_request = $this->fetch_all_array("SELECT * FROM `friends_request` fr WHERE fr.request_email= :user and fr.status!=:status and fr.request_to= :user2", array("user"=>$row['email_id'], "user2"=>$row['email_id'], "status"=>1));
			if(isset($chk_all_friend_request) and count($chk_all_friend_request) > 0){
				foreach($chk_all_friend_request as $req){
					$up = array();
					$up['request_to'] = $row['uid'];
					$this->query_update('friends_request', $up, array('id'=>$req['request_id']), 'request_id=:id');			
					unset($up);
					$chk_record_friends_table = $this->fetch_all_array("SELECT * FROM `user_friends` ur WHERE ur.request_id= :id", array("id"=>$req['request_id']));									
					if(isset($chk_record_friends_table) and count($chk_record_friends_table) > 0){
						foreach($chk_record_friends_table as $chk_rec){
							$up = array();
							if($chk_rec['uid'] == 0){
								$up['uid'] = $row['uid'];	
							}else if($chk_rec['fid'] == 0){
								$up['fid'] = $row['uid'];	
							}							
							$this->query_update('user_friends', $up, array('id'=>$chk_rec['friend_id']), 'friend_id=:id');			
							unset($up);

						}
					}
				}
				
			}

			/*start code for default my first group */
			$chk_groups = $this->query_first("SELECT group_id FROM `groups` WHERE uid=:uid and defaults='1'",array('uid'=>$row['uid']));
			if(!(isset($chk_groups['group_id']) and $chk_groups['group_id'] > 0)){
				$up_val = array();
				$up_val['uid'] = $row['uid'];
				$up_val['group_name'] = 'My First Group';
				$up_val['created'] = time();
				$up_val['updated'] = time();				
				$up_val['status'] = 1;						
				$up_val['defaults'] = 1;						
				$group_id = $this->query_insert('groups', $up_val);
				unset($up_val);
			}	
			/*end code */
			
			if($remember==1){
				setcookie('uid', $row['uid'], strtotime('+1 days'));			
				setcookie('website', 'Linkibag', strtotime('+1 days'));				
			}else{
				$_SESSION['uid'] = $row['uid'];
				$_SESSION['last_login_time'] = $row['last_login_time']; 
				$_SESSION['website'] = 'Linkibag';
			}
			$up_user['last_login_time'] = time();
			$up_user['is_user_login'] = 1;
			$this->query_update('users', $up_user, array('uid'=>$row['uid']), 'uid=:uid');						
			unset($up_user);						
			return true;					
		}else{					
			return false;					}
		}
	
	function user_reset_password($username){
		$sql = "SELECT * FROM `users` WHERE email_id=:user AND `status`=:status AND `verified`=:verified LIMIT 1";
		$row= $this->row($sql, array("user"=>$username, "status"=>1, "verified"=>1));
		if(!(isset($row['uid']) and $row['uid']>0)){			
			$sql = "SELECT * FROM `users` WHERE mobile=:user AND `status`=:status AND `verified`=:verified LIMIT 1";
			$row= $this->row($sql, array("user"=>$username, "status"=>1, "verified"=>1));		
		}						
		if(isset($row['uid']) and $row['uid']>0){
			$up_user = array();
			$reset_code = $this->generate_path(35);
			$up_user['reset_code'] = $reset_code;
			$up_user['reset_request'] = 1;
			$up_user['reset_time'] = time();
			$this->query_update('users', $up_user, array('uid'=>$row['uid']), 'uid=:uid');
			unset($up_user);
			if(isset($row['email_id'])){
				$to = $row['email_id'];
				$subject = 'Password request at Linkibag';
				$verified_link = WEB_ROOT.'index.php?p=change_pass&user='.$row['uid'].'&pv='.$reset_code;
				//$verified_link = '<a href="http://linkibag.com/linkibag/index.php?p=login">http://linkibag.com/linkibag/index.php?p=login</a>';
				//$message = 'Dear<br /><br /><p>We received a request to reset the password associated with this e-mail address. If you made this request, please follow the instructions below.<br /> Click the link below to reset your password: <br/>'.$verified_link.'<br />If you did not request to have your password reset you can safely ignore this email. Rest assured your account is safe.<br/>If clicking the link doesn\'t seem to work, you can copy and paste the link into your browser\'s address window, or retype it there.</p><br />Cheers<br />Team Linkibag';
				$verified_link = $this->get_bit_ly_link($verified_link);
				$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Confirm your account</title>
        <style type="text/css">
			body{margin: 0; padding: 0; min-width: 100%!important;}
			.content{color: #626262;font-family: arial;max-width: 600px;text-align: center;width: 100%;}  
			.btn{background: #d76b00 none repeat scroll 0 0;border-radius: 55px;color: #ffffff;display: inline-block;font-size: 22px;font-weight: bold;margin: 32px 0;padding: 12px 43px;text-decoration: none;}
			h1{margin: 0 0 27px 0;}
			.big{color: #7f7f7f !important;font-size: 22px;margin-top: 4px;}
			.content p{color: #7f7f7f; font-size: 12px;}
			.content p a{color: #7f7f7f;text-decoration: none;}
        </style>
    </head>
    <body bgcolor="#ffffff">
        <table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="text-align: left; padding: 30px 0px 40px;">
                                <img src="http://linkibag.net/PTest25x/linkibag/images/email-logo/white-linkibag-logo.png">
                            </td>
                        </tr>
						<tr>
                            <td>
                                <h1>Did you forget your password?</h1>
								<p class="big">Not a problem. Click on the link below to confirm to finish password reset.</p>
								<a class="btn" href="'.$verified_link.'">Reset your password</a>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <p>This message was send to '.$to.'. if you have questions, please <a href="'.$this->get_bit_ly_link('http://www.linkibag.net/PTest25x/linkibag/index.php?p=contact-us').'"><b>contact us.</b></a> We’re here to help.</p>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <p><a href="'.$this->get_bit_ly_link(WEB_ROOT.'index.php?p=about_us').'">About Linkibag</a> &nbsp; | &nbsp; <a href="'.$this->get_bit_ly_link(WEB_ROOT.'index.php?p=terms-of-use').'">Terms of Use</a> &nbsp; | &nbsp; <a href="'.$this->get_bit_ly_link(WEB_ROOT.'index.php?p=terms-of-use').'">Privacy Policy</a></p>
                            </td>
                        </tr>
                        <tr>
                            <td><p><strong><a href="'.$this->get_bit_ly_link(WEB_ROOT.'index.php?p=unsubscribe&email='.$row['email_id']).'">UNSUBSCRIBE</a> from all messages sent via LinkiBag by any LinkiBag users and from LinkiBag invitations</strong></p>
                                <p><strong>LinkiBag Inc. 8926 N. Greenwood Ave, #220, Niles, IL 60714</strong></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>';				

				$from = 'info@linkibag.com';				
				$this->send_email($to, $subject, $message, $from);				
				return true;			
			}else{				
				return false;			
			}		
		}else{			
			return false;		
		}	
	}
	
	function is_emailExists($em)
	{
		$sql = "SELECT * FROM `users` WHERE `email_id`= :user";
		$row= $this->row($sql, array("user"=>$em));
		
		if(isset($row['uid']) and $row['uid']>0){
			return true;
		}else{
			return false;
		}
	}
	function is_userExists($u)
	{
		$sql = "SELECT * FROM `users` WHERE `email_id`= :user";
		$row= $this->row($sql, array("user"=>$u));
		
		if(isset($row['uid']) and $row['uid']>0){
			return true;
		}else{
			return false;
		}
	}
	function is_mobileExists($m)
	{
		$sql = "SELECT * FROM `users` WHERE `mobile`= :mob";
		$row= $this->row($sql, array("mob"=>$m));
		if(isset($row['uid']) and $row['uid']>0){
			return true;
		}else{
			return false;
		}
	}
	function is_emailExists_edit($em, $id)
	{
		$sql = "SELECT * FROM `users` WHERE `email_id`= :user AND uid != :uid";
		$row= $this->row($sql, array("user"=>$em, "uid"=>$id));
		
		if(isset($row['uid']) and $row['uid']>0){
			return true;
		}else{
			return false;
		}
	}
	function is_userExists_edit($u, $id)
	{
		$sql = "SELECT * FROM `users` WHERE `email_id`= :user AND uid != :uid";
		$row= $this->row($sql, array("user"=>$u, "uid"=>$id));
		
		if(isset($row['uid']) and $row['uid']>0){
			return true;
		}else{
			return false;
		}
	}
	function is_mobileExists_edit($u, $id)
	{
		$sql = "SELECT * FROM `users` WHERE `mobile`= :user AND uid != :uid";
		$row= $this->row($sql, array("user"=>$u, "uid"=>$id));
		
		if(isset($row['uid']) and $row['uid']>0){
			return true;
		}else{
			return false;
		}
	}
	function getcurrentuser_profile()
	{
		if(isset($_COOKIE['uid']) && isset($_COOKIE['website']) && $_COOKIE['website']=="Linkibag")
		{
			$row= $this->load_user($_COOKIE['uid']);
			return $row;
		}
		elseif(isset($_SESSION['uid']) && isset($_SESSION['website']) && $_SESSION['website']=="Linkibag")
		{			
			$row= $this->load_user($_SESSION['uid']);
			return $row;
		}
		else
		{
			return false;
		}
	}
	function load_user($uid){
		$sql = "SELECT * FROM `users` u, profile p WHERE u.uid=p.uid and u.uid= :user";
		$row= $this->row($sql, array("user"=>$uid));
		return $row;		
	}
	
	function create_user($postdata, $files){
		$new_val = array();
		$email_id=$postdata['email_id'];
		$new_val['email_id'] = $email_id;
		//$new_val['mobile'] = $postdata['mobile'];
		$new_val['pass'] = $postdata['password'];
		$new_val['decrypt_pass'] = md5($postdata['password']);
		if($postdata['role']=='business'){
			$new_val['role'] = '2';
		}elseif($postdata['role']=='education'){
			$new_val['role'] = '3';
		}elseif($postdata['role']=='personal'){
			$new_val['role'] = '1';
		}
		$new_val['created'] = time();	
		$new_val['status'] = 0;
		$new_val['verified'] = 0;
		$user_id = $this->query_insert('users', $new_val);						
		unset($new_val);
		$up_user = array();
		$verify_code = $this->generate_verifycode(8, $user_id);
		$up_user['verify_code'] = $verify_code;
		$this->query_update('users', $up_user, array('uid'=>$user_id), 'uid=:uid');						
		unset($up_user);	
		$new_val = array();
		$new_val['uid'] = $user_id;					
		$profile_fields = array( 'salutation','first_name','last_name','account', 'country', 'state', 'zip_code','terms_and_conditions','sign_me_for_email_filter');
		foreach($profile_fields as $profile_field){
			if(isset($postdata[$profile_field]))
				$new_val[$profile_field] = $postdata[$profile_field];
		}
		$this->query_insert('profile', $new_val);						
		unset($new_val);
		//$this->setmessage("status", "Thanks for registering with us. ");
		$row['email_id'] = $email_id;
		$row['uid'] = $user_id;
		$chk_all_friend_request = $this->fetch_all_array("SELECT * FROM `friends_request` fr WHERE fr.request_email= :user and fr.status!=:status and fr.request_to= :user2", array("user"=>$row['email_id'], "user2"=>$row['email_id'], "status"=>1));
		if(isset($chk_all_friend_request) and count($chk_all_friend_request) > 0){
			foreach($chk_all_friend_request as $req){
				$up = array();
				$up['request_to'] = $row['uid'];
				$this->query_update('friends_request', $up, array('id'=>$req['request_id']), 'request_id=:id');			
				unset($up);
				$chk_record_friends_table = $this->fetch_all_array("SELECT * FROM `user_friends` ur WHERE ur.request_id= :id", array("id"=>$req['request_id']));									
				if(isset($chk_record_friends_table) and count($chk_record_friends_table) > 0){
					foreach($chk_record_friends_table as $chk_rec){
						$up = array();
						if($chk_rec['uid'] == 0){
							$up['uid'] = $row['uid'];	
						}else if($chk_rec['fid'] == 0){
							$up['fid'] = $row['uid'];	
						}							
						$this->query_update('user_friends', $up, array('id'=>$chk_rec['friend_id']), 'friend_id=:id');			
						unset($up);

					}
				}
			}
			
		}

		//new code for group friends
		$chk_all_groups_friends = $this->fetch_all_array("SELECT * FROM `groups_friends` gf WHERE gf.email_id= :user", array("user"=>$row['email_id']));
		if(isset($chk_all_groups_friends) and count($chk_all_groups_friends) > 0){
			foreach($chk_all_groups_friends as $grpfreind){
				$up = array();
				$up['email_id'] = $row['uid'];
				$this->query_update('groups_friends', $up, array('id'=>$grpfreind['	groups_friends_id']), 'groups_friends_id=:id');			
				unset($up);

			}
		}		
		
		//end code for group friends 

		$to = $postdata['email_id'];
		if(isset($_POST['request_id']) and $_POST['request_id'] > 0 and $_POST['request_code'] and $_POST['request_code'] != '' and $_POST['accept'] and $_POST['accept'] != ''){
			$email_link = WEB_ROOT.'index.php?p=verify&user='.$user_id.'&v='.$verify_code.'&request_id='.$_POST['request_id'].'&request_code='.$_POST['request_code'].'&accept='.$_POST['accept'];
			
		}else{
			$email_link = WEB_ROOT.'index.php?p=verify&user='.$user_id.'&v='.$verify_code;

		}			
		$postdata['verified_link'] = $this->get_bit_ly_link($email_link);			
		$mail_content = $this->mail_format('new_register', $postdata);
		$this->send_email($to, $mail_content['subject'], $mail_content['matter']);			
		/*$this->setmessage("status", "Congratulations! You are almost done. To complete registration please click on the link that we just sent to your email address. Thank you again.");			*/
		return $user_id;
		
	}

	function get_bit_ly_link($bitly_link){
		/*
		$bitly_link = urlencode($bitly_link);
        $ch = curl_init();
		$myHITurl = "https://api-ssl.bitly.com/v3/shorten?access_token=e2da7602da1190a66a337d0003b85b7a0b655133&longUrl=".$bitly_link;
		curl_setopt ($ch, CURLOPT_URL, $myHITurl);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		$curl_error = curl_errno($ch);
		curl_close($ch);
		$file_contents = json_decode($file_contents);
		if($file_contents->data->url != ''){
			return $file_contents->data->url;
		}else{
			return $bitly_link;
		}
		*/
		return $bitly_link;

	}				
	
}
?>