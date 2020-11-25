<?php
class userClass extends commonClass
{
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
			$this->query_update('users', $up_user, array('uid'=>$row['uid']), 'uid=:uid');						unset($up_user);						return true;					}else{					return false;					}
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
				$message = 'Dear<br /><br /><p>We received a request to reset the password associated with this e-mail address. If you made this request, please follow the instructions below.<br /> Click the link below to reset your password: <br/>'.$verified_link.'<br />If you did not request to have your password reset you can safely ignore this email. Rest assured your account is safe.<br/>If clicking the link doesn\'t seem to work, you can copy and paste the link into your browser\'s address window, or retype it there.</p><br />Cheers<br />Team Linkibag';				
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
		$to = $postdata['email_id'];			
		$postdata['verified_link'] = WEB_ROOT.'index.php?p=verify&user='.$user_id.'&v='.$verify_code;			
		$mail_content = $this->mail_format('new_register', $postdata);
		$this->send_email($to, $mail_content['subject'], $mail_content['matter']);			
		$this->setmessage("status", "Congratulations! You are almost done. To complete registration please click on the link that we just sent to your email address. Thank you again.");			
		return $user_id;
		
	}				
	
}
?>