<?php
if(!isset($include)){
	exit();
}
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['form_id']) and $_POST['form_id']=="register"){								
		$_POST['salutation'] = trim($_POST['salutation']);
		$_POST['salutation'] = strip_tags($_POST['salutation']);
		
		$_POST['email_id'] = trim($_POST['email_id']);
		$_POST['email_id'] = strip_tags($_POST['email_id']);
		
		/*$_POST['email_domain'] = trim($_POST['email_domain']);
		$_POST['email_domain'] = strip_tags($_POST['email_domain']);
		*/
		$_POST['password'] = trim($_POST['password']);
		$_POST['password'] = strip_tags($_POST['password']);
		
		$_POST['first_name'] = trim($_POST['first_name']);
		$_POST['first_name'] = strip_tags($_POST['first_name']);
		
		$_POST['last_name'] = trim($_POST['last_name']);
		$_POST['last_name'] = strip_tags($_POST['last_name']);
		
		$success=true;
		
		if($_POST['salutation']==""){
			$co->setmessage("error", "Please enter salutation");
			$success=false;
		}
		if($_POST['first_name']==""){
			$co->setmessage("error", "Please enter first name");
			$success=false;
		}
		if($_POST['last_name']==""){
			$co->setmessage("error", "Please enter last name");
			$success=false;
		}
		if(!isset($_POST['country']) or (isset($_POST['country']) and $_POST['country'] == '')){
			$co->setmessage("error", "Please choose country");
			$success=false;
		}
		if(isset($_POST['country']) and $_POST['country'] == 1){
			if(!isset($_POST['state']) or (isset($_POST['state']) and $_POST['state'] == '')){
				$co->setmessage("error", "Please choose state");
				$success=false;
			}
			if($_POST['zip_code'] == ''){
				$co->setmessage("error", "Please enter zip code");
				$success=false;
			}
		}	
		//check if email_id empty
		if($_POST['email_id']==""){
			$co->setmessage("error", "Please enter email");
			$success=false;
		}
		/*
		if($_POST['confirm_email']==""){
			$co->setmessage("error", "Please enter confirm email");
			$success=false;
		}
		if($_POST['email_domain']==""){
			$co->setmessage("error", "Please enter corporate domain");
			$success=false;
		}
		/*if($_POST['confirm_email_domain']==""){
			$co->setmessage("error", "Please enter confirm corporate domain");
			$success=false;
		}*/
		if(isset($_POST['email_id']) and $_POST['email_id']!=''){
			$email =  $_POST['email_id'];
			$find = stripos($email, '@');
			$domain_name = substr($_POST['email_id'], $find);
			$domain_name_array = array('@hotmail.com', '@yahoo.com', '@gmail.com', '@Hotmail.com', '@Yahoo.com', '@Gmail.com');
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$co->setmessage("error", "$email is not a valid email address");
				$success=false;
			}elseif(!in_array($domain_name, $domain_name_array)){
				$co->setmessage("error", " LinkiBag did not recognize your email vendor as a public email provider from our list");
				$success=false;
			}elseif($co->is_emailExists($email)){
				$co->setmessage("error", "The email address you have entered is already registered. If you've forgotten your password, <a href='index.php?p=forget-password'>Click here</a> to receive an emailed link to reset it");
				$success=false;
			}
			
		}
		/*	
		if(isset($_POST['confirm_email']) and $_POST['confirm_email']!=''){
			$confirm_email =  $_POST['confirm_email'].'@'.$_POST['confirm_email_domain'];
			if($confirm_email!=$email){
				$co->setmessage("error", "Email and confirm email must be same!");
				$success=false;
			}
		}*/
		if($_POST['password']==""){
			$co->setmessage("error", "Please enter password");
			$success=false;
		}
		if($_POST['reapt_pass']==""){
			$co->setmessage("error", "Please enter Repeat password");
			$success=false;
		} else{
			if($_POST['password']!=$_POST['reapt_pass']){
				$co->setmessage("error", "password and confirm password must be same!");
				$success=false;
			}
		}
		
		if(isset($_POST['password']) and $_POST['password']!=''){
			$password =  strlen($_POST['password']);
			if ($password<8){
				$co->setmessage("error", "password is not a valid at least 8 of the characters");
				$success=false;
			}
			$containsLetter  = preg_match('/[a-zA-Z]/', $_POST['password']);
			$containsDigit   = preg_match('/\d/', $_POST['password']);
			//$containswhitespace = preg_match('/ /', $_POST['password']);

			if (!$containsLetter or !$containsDigit) {
				$co->setmessage("error", "password must contain at least one letter and one number and no spaces");
				$success=false;
			}	
		}
		 
		if(!isset($_POST['terms_and_conditions']) or (isset($_POST['terms_and_conditions']) and $_POST['terms_and_conditions'] == '')){
			$co->setmessage("error", "Please selecting terms and conditions agreement");
			$success=false;
		}
		
	
		//check if no error
		if($success==true){			
			$co->create_user($_POST, array());
			if(isset($_POST['request_id']) and $_POST['request_id'] > 0 and $_POST['request_code'] and $_POST['request_code'] != '' and $_POST['accept'] and $_POST['accept'] != ''){
				echo '<script language="javascript">window.location="index.php?p=login&request_id='.$_POST['request_id'].'&request_code='.$_POST['request_code'].'&accept='.$_POST['accept'].'";</script>';
				exit();
			}
			echo '<script language="javascript">window.location="index.php?p=personal-account";</script>';
			exit();
		}	
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="login"){
		$_POST['email_id'] = trim($_POST['email_id']);
		$_POST['email_id'] = strip_tags($_POST['email_id']);
		
		$_POST['password'] = trim($_POST['password']);
		$_POST['password'] = strip_tags($_POST['password']);				$remember = 0;		if(isset($_POST['remember']))			$remember = 1;
		$success=true;
		//check if email_id empty
		if($_POST['email_id']=="" AND $_POST['password']!=""){
			$co->setmessage("error", "Email is required");
			$success=false;
		}
		if($_POST['password']=="" AND $_POST['email_id']!=""){
			$co->setmessage("error", "Password is required");
			$success=false;
		}
		if($_POST['password']=="" AND $_POST['email_id']==""){
			$co->setmessage("error", "Email & Password is required");
			$success=false;
		}
		//check if no error
		if($success==true){	
			if($co->userlogin($_POST['email_id'],$_POST['password'],$remember)){
					if(isset($_POST['request_id']) and $_POST['request_id'] > 0 and $_POST['request_code'] and $_POST['request_code'] != '' and $_POST['accept'] and $_POST['accept'] != ''){
						echo '<script language="javascript">window.location="index.php?p=friend_request&request_id='.$_POST['request_id'].'&request_code='.$_POST['request_code'].'&accept='.$_POST['accept'].'";</script>';
						exit();
					}
				
					
					echo '<script language="javascript">window.location="index.php?p=dashboard";</script>';

					exit();

			}else{
				$user_login = $co->query_first("SELECT uid,status,verified FROM `users` WHERE `email_id`= :user and `decrypt_pass` = :pass LIMIT 1",array('user'=>$_POST['email_id'],'pass'=>md5($_POST['password'])));
				if(isset($user_login['uid']) and $user_login['uid'] > 0){
					if($user_login['status'] == '0' and $user_login['verified'] == '0'){
						$co->setmessage("error", "Your email address is not verified yet. Please check your inbox or spam and follow the instruction in mail for verifying your email address to continue.");
					}else if($user_login['status'] == '0'){
						$co->setmessage("error", "Your account is blocked by administrator.");
					}else if($user_login['status'] == '1' and $user_login['verified'] == '1'){
						echo '<script language="javascript">window.location="index.php?p=dashboard";</script>';
						exit();
					}
		
				}else{
		
					$co->setmessage("error", "You have entered invalid login detail");
					
				}

			}
		}	
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="edit_profile"){
		$current = $co->getcurrentuser_profile();
		$_POST['email_id'] = trim($_POST['email_id']);
		$_POST['email_id'] = strip_tags($_POST['email_id']);
		
		
		$_POST['salutation'] = trim($_POST['salutation']);
		$_POST['salutation'] = strip_tags($_POST['salutation']);
		
		$_POST['password'] = trim($_POST['password']);
		$_POST['password'] = strip_tags($_POST['password']);
		
		$_POST['first_name'] = trim($_POST['first_name']);
		$_POST['first_name'] = strip_tags($_POST['first_name']);
		
		$_POST['last_name'] = trim($_POST['last_name']);
		$_POST['last_name'] = strip_tags($_POST['last_name']);
		
		$success = true;
		if($_POST['first_name']=="" or $_POST['last_name']=="" or $_POST['country']=="" or $_POST['email_id']==""){
			$co->setmessage("error", "All * fields are required");
			$success=false;
		}
		
		
		if(isset($_POST['email_id']) and $_POST['email_id']!=''){
			$email =  $_POST['email_id'];
			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$co->setmessage("error", "$email is not a valid email address");
				$success=false;
			}
			$eamil_exists = $co->is_userExists_edit($email, $current['uid']);
			if(isset($eamil_exists) and $eamil_exists!=''){
				$co->setmessage("error", "$email is already existed");
				$success=false;
			}
			
		}
		
		/*if($_POST['salutation']==""){
			$co->setmessage("error", "Please enter salutation");
			$success=false;
		}
		
		if($_POST['email_domain']==""){
			$co->setmessage("error", "Please enter corporate domain");
			$success=false;
		}
		if($_POST['first_name']==""){
			$co->setmessage("error", "Please enter first name");
			$success=false;
		}
		if($_POST['last_name']==""){
			$co->setmessage("error", "Please enter last name");
			$success=false;
		}
		if($_POST['account']==""){
			$co->setmessage("error", "Please enter account");
			$success=false;
		}*/
		
		if(isset($_POST['password']) and $_POST['password']!=''){
			$password =  strlen($_POST['password']);
			if ($password<8){
				$co->setmessage("error", "password is not a valid at least 8 of the characters");
				$success=false;
			}
			$containsLetter  = preg_match('/[a-zA-Z]/', $_POST['password']);
			$containsDigit   = preg_match('/\d/', $_POST['password']);
			//$containswhitespace = preg_match('/ /', $_POST['password']);

			if (!$containsLetter or !$containsDigit) {
				$co->setmessage("error", "password must contain at least one letter and one number and no spaces");
				$success=false;
			}	
		}
		if($_POST['reapt_pass']!=""){
			if($_POST['password']!=$_POST['reapt_pass']){
				$co->setmessage("error", "password and confirm password must be same!");
				$success=false;
			}
		}	
		if($success==true){		
			$up = array();
			$up['email_id'] = $email;
			if(isset($_POST['password']) and $_POST['password']!=''){	
				$up['pass'] = $_POST['password'];
				$up['decrypt_pass'] = md5($_POST['password']);
			}
			$up['updated'] = time();
			$co->query_update('users', $up, array('id'=>$current['uid']), 'uid=:id');
			unset($up);
			
			$up = array();
			if(isset($_POST['first_name']) and $_POST['first_name'] != '')
				$up['first_name'] = $_POST['first_name'];
			if(isset($_POST['last_name']) and $_POST['last_name'] != '')
				$up['last_name'] = $_POST['last_name'];
			if(isset($_POST['salutation']) and $_POST['salutation'] != '')
				$up['salutation'] = $_POST['salutation'];
			if(isset($_POST['country']) and $_POST['country'] > 0)
				$up['country'] = $_POST['country'];
			if(isset($_POST['sign_me_for_email_filter']) and $_POST['sign_me_for_email_filter'] > 0)
				$up['sign_me_for_email_filter'] = $_POST['sign_me_for_email_filter'];
			else
				$up['sign_me_for_email_filter'] = '';
			
			$co->query_update('profile', $up, array('id'=>$current['uid']), 'uid=:id');
			unset($up);
			$co->setmessage("status", "Your information updated successfully");
			echo 'success';
			exit();
			//echo '<script type="text/javascript">window.location.href="index.php?p=edit-profile"</script>';
			//exit();
		}		
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="url_submission"){
		//$_POST['url_title'] = trim($_POST['url_title']);
		//$_POST['url_title'] = strip_tags($_POST['url_title']);
		
		$_POST['url_value'] = trim($_POST['url_value']);
		$_POST['url_value'] = strip_tags($_POST['url_value']);
		
		$_POST['url_desc'] = trim($_POST['url_desc']);
		$_POST['url_desc'] = strip_tags($_POST['url_desc']);
		
		$success = true;
		$url=$_POST['url_value'];
		/*
		if($_POST['url_title']==""){
			$co->setmessage("error", "Please enter url title");
			$success=false;
		}
		*/
		//check if email_id empty
		    
			//$regex = "((https?|ftp)://)?"; // SCHEME
			//$regex .= "([a-z0-9+!*(),;?&=$_.-]+(:[a-z0-9+!*(),;?&=$_.-]+)?@)?"; // User and Pass
			//$regex .= "([a-z0-9-.]*)\.([a-z]{2,4})"; // Host or IP
			//$regex .= "(:[0-9]{2,5})?"; // Port
			//$regex .= "(/([a-z0-9+$_%-]\.?)+)*/?"; // Path
			//$regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+/$_.-]*)?"; // GET Query
			//$regex .= "(#[a-z_.-][a-z0-9+$%_.-]*)?"; // Anchor
		
		
		if($url==""){
			$co->setmessage("error", "Please enter url value");
			$success=false;
		}else{	
			//$pattern_1 = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
			//$pattern_1 = "/^(http|https|ftp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+.(com|org|net|dk|at|us|tv|info|uk|co.uk|biz|se)$)(:(\d+))?\/?/i";
			//$pattern_1 = "/(((http|ftp|https):\/{2})+(([0-9a-z_-]+\.)+(aero|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cu|cv|cx|cy|cz|cz|de|dj|dk|dm|do|dz|ec|ee|eg|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mn|mn|mo|mp|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|nom|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ra|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw|arpa)(:[0-9]+)?((\/([~0-9a-zA-Z\#\+\%@\.\/_-]+))?(\?[0-9a-zA-Z\+\%@\/&\[\];=_-]+)?)?))\b/imuS";
			$pattern_1 = "/(?:http|https)?(?:\:\/\/)?(?:www.)?(([A-Za-z0-9-]+\.)*[A-Za-z0-9-]+\.[A-Za-z]+)(?:\/.*)?/im";
			if(!preg_match($pattern_1, $url)){			
				$co->setmessage("error", "Please enter valid url");
				$success=false;
			}	
			/*if(!filter_var($url, FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED) === false) {
				$co->setmessage("error", "Please enter valid url");
				$success=false;
			}*/	
		}

		if($_POST['url_cat'] == ''){
			$co->setmessage("error", "Please select category");
			$success=false;
		}
		$current = $co->getcurrentuser_profile();	
		if($success==true){
			$up = array();
			$up['url_title'] = 'test';
			$up['url_value'] = $url;
			/*$category_id = array();
			if(isset($_POST['url_cat']) and count($_POST['url_cat']) > 0){
				foreach($_POST['url_cat'] as $cat_val){
					$new_val = array();
					$category= $co->query_first("SELECT `cid`,`cname` FROM category WHERE cid=:id", array('id'=>$cat_val));
					if(isset($category['cid']) and $category['cid'] > 0){
						$category_id[] = $category['cid'];
					}else{
						$new_val = array();
						$new_val['cname'] = $cat_val;
						$new_val['uid'] = $current['uid'];
						$new_val['status'] = 0;
						$new_val['in_list'] = 1;
						$new_val['created_time'] = time();
						$new_val['updated_time'] = time();
						$category_id[] = $co->query_insert('category', $new_val);
						unset($new_val); 
						
						
					}
				}	
			}*/	
			
			
			//$up['url_cat'] = serialize($category_id);
			$up['url_cat'] = $_POST['url_cat'];
			
			$up['url_desc'] = $_POST['url_desc'];
			$up['status'] = 1;
			$up['ip_address'] = 123456;
			if(isset($_POST['update_url']) and $_POST['update_url']=="update-url"){
				$up['updated_time'] = time();
				$up['updated_date'] = date('Y-m-d');
				$co->query_update('user_urls', $up, array('id'=>$_POST['id']), 'url_id=:id');				
			}else{
				if($current['uid']==$_POST['id']){
					$up['uid'] = $_POST['id'];
					$up['created_time'] = time();
					$up['updated_time'] = time();
					$up['created_date'] = date('Y-m-d');
					$up['updated_date'] = date('Y-m-d');
					$inserted_url = $co->query_insert('user_urls', $up);
				}	
			}	
			unset($up);
			$new_val = array();
			$new_val['uid'] = $current['uid'];
			$new_val['shared_to'] = $current['uid'];
			$new_val['url_id'] = $inserted_url;
			$new_val['url_cat'] = $_POST['url_cat'];
			$new_val['shared_time'] = time();
			$co->query_insert('user_shared_urls', $new_val);
			unset($new_val);		
			
			$co->setmessage("status", "Your information submitted successfully");
			echo '<script type="text/javascript">window.location.href="index.php?p=dashboard"</script>';
			exit();	
		}		
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="add_url_comment"){
		$_POST['url_comment'] = trim($_POST['url_comment']);
		$_POST['url_comment'] = strip_tags($_POST['url_comment']);
		
		$success=true;
		if($_POST['url_comment']==""){
			$co->setmessage("error", "Please give comment");
			$success=false;
		}
		
		if($success==true){
			$up = array();
			$up['comment'] = $_POST['url_comment'];
			$up['uid'] = $_POST['uid'];
			$up['url_id'] = $_POST['id'];
			$up['comment_created'] = time();
			$co->query_insert('comments', $up);
			unset($up);
			$co->setmessage("status", "Your information submitted successfully");
			echo '<script type="text/javascript">window.location.href="index.php?p=url-detail&id='.$_POST['id'].'"</script>';
			exit();	
		}		
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="contact-us"){
		$_POST['first_name'] = trim($_POST['first_name']);
		$_POST['first_name'] = strip_tags($_POST['first_name']);
		
		$_POST['last_name'] = trim($_POST['last_name']);
		$_POST['last_name'] = strip_tags($_POST['last_name']);
		
		$_POST['email_id'] = trim($_POST['email_id']);
		$_POST['email_id'] = strip_tags($_POST['email_id']);
		
		$_POST['phone'] = trim($_POST['phone']);
		$_POST['phone'] = strip_tags($_POST['phone']);
		
		$_POST['company_name'] = trim($_POST['company_name']);
		$_POST['company_name'] = strip_tags($_POST['company_name']);
		
		$_POST['your_msg'] = trim($_POST['your_msg']);
		$_POST['your_msg'] = strip_tags($_POST['your_msg']);
		
		$success=true;
		if($_POST['first_name']==""){
			$co->setmessage("error", "Please enter first name");
			$success=false;
		}
		if($_POST['last_name']==""){
			$co->setmessage("error", "Please enter last name");
			$success=false;
		}
		if($_POST['email_id']==""){
			$co->setmessage("error", "Please enter email address");
			$success=false;
		}else{
			$email = $_POST['email_id'];
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$co->setmessage("error", "$email is not a valid email address");
				$success=false;
			}	
		}	
		if($_POST['phone']==""){
			$co->setmessage("error", "Please enter phone number");
			$success=false;
		}
		if($_POST['company_name']==""){
			$co->setmessage("error", "Please enter company/institutional name");
			$success=false;
		}
		
		if(!isset($_POST['type_of_inquiry'])){
			$co->setmessage("error", "Please choose at least one type of inquiry");
			$success=false;
		}
		if(isset($_POST['type_of_inquiry']) AND $_POST['type_of_inquiry'] == 'Existing Account'){
			if(!isset($_POST['existing_account'])){
				$co->setmessage("error", "Please choose at least one type of existing account");
				$success=false;
			}
			if($_POST['exit_acc_no']==""){
				$co->setmessage("error", "Please enter existing account number");
				$success=false;
			}
		}
		if(isset($_POST['type_of_inquiry']) AND $_POST['type_of_inquiry'] == 'General Inquiries'){
			if(!isset($_POST['general_enquiry'])){
				$co->setmessage("error", "Please choose at least one type of general inquiry");
				$success=false;
			}
		}
		if(isset($_POST['your_msg']) and $_POST['your_msg'] == ""){
			$co->setmessage("error", "Please enter your message");
			$success=false;
		}
		
		if($success==true){
			$first_name = @trim(stripslashes($_POST['first_name'])); 
			$last_name = @trim(stripslashes($_POST['last_name'])); 
			$name = $first_name.' '.$last_name; 
			$email = @trim(stripslashes($_POST['email_id'])); 
			$subject = 'Contact at Linkibag'; 
			$message = @trim(stripslashes($_POST['your_msg'])); 
			$company_name = @trim(stripslashes($_POST['company_name'])); 
			$phone = @trim(stripslashes($_POST['phone'])); 
			$type_of_inquiry = @trim(stripslashes($_POST['type_of_inquiry'])); 
			
			
			/*$email_addr = @trim(stripslashes($_POST['email_addr'])); 
			$billing = @trim(stripslashes($_POST['billing'])); 
			$new_acc_inquiry = @trim(stripslashes($_POST['new_acc_inquiry'])); 
			$promo_and_specials = @trim(stripslashes($_POST['promo_and_specials'])); 
			$others = @trim(stripslashes($_POST['others'])); 
			*/
			$email_from = $_POST['email_id'];
			
				$email_to = 'info@linkibag.com';//replace with your email
			//$email_from = 'info@linkibag.com';
			
			//	$email_to = $_POST['email_id'];//replace with your email
			
			$body = 'Name: ' . $name . "\n\n" . 'Email: ' . $email . "\n\n"  . 'Message: ' . $message . "\n\n" . 'Phone: ' . $phone . "\n\n" . 'Company-Name: ' . $company_name . "\n\n" . 'Enqury Type: ' . $type_of_inquiry . "\n\n" ;
			if($type_of_inquiry == 'General Inquiries'){
				$general_enquiry = @trim(stripslashes($_POST['general_enquiry'])); 				
				$body .= 'General Inquiries: ' . $general_enquiry . "\n\n";				
			}else if($type_of_inquiry == 'Existing Account'){
				$existing_account = @trim(stripslashes($_POST['existing_account'])); 
				$exit_acc_no = @trim(stripslashes($_POST['exit_acc_no'])); 
				$body .= 'Existing Account: ' . $existing_account . "\n\n";	
				$body .= 'Existing Account#: ' . $exit_acc_no . "\n\n";	
				
			}
			$success = @mail($email_to, $subject, $body, 'From: <'.$email_from.'>');
			$co->setmessage("status", "Your information submitted successfully. Linkibag team will contact you shortly.");
			echo '<script type="text/javascript">window.location.href="index.php?p=contact-us"</script>';
			exit();	
		}		
	}
	
	if(isset($_POST['form_id']) and $_POST['form_id']=="delete_url_post"){
		//$current = $co->getcurrentuser_profile();
		if(isset($current['uid']) and $current['uid'] != ''){
			$co->query_delete('user_urls', array('id'=>$_POST['delid']),'url_id=:id');

			$co->setmessage("error", "URL post has been successfully deleted");
			echo '<script type="text/javascript">window.location.href="index.php?p=dashboard"</script>';
			exit();
		}		
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="reset_password"){
		$success=true;
		if($_POST['user_email']==""){
			$co->setmessage("error", "Please enter email address");
			$success=false;
		}else{
			if(isset($_POST['user_id']) and isset($_POST['code']) and isset($_POST['user_email'])){
				$username = trim($_POST['user_email']);
				$sql = "SELECT * FROM `users` WHERE uid=:user and `reset_code`=:code and reset_request=:request and email_id=:email";
				$row= $co->row($sql, array("user"=>$_POST['user_id'], "code"=>$_POST['code'], "request"=>1, "email"=>$username));
				if(!(isset($row['uid']) and $row['uid']>0)){
					$co->setmessage("error", "You are entered invalid email address, please enter the email you used in your LinkiBag profile.");
					$success=false;	
				}
			}		
		}
		if($_POST['user_pass']==""){
			$co->setmessage("error", "Please enter password");
			$success=false;
		}else{
			$password =  strlen($_POST['user_pass']);
			if ($password<8){
				$co->setmessage("error", "password is not a valid at least 8 of the characters");
				$success=false;
			}
			$containsLetter  = preg_match('/[a-zA-Z]/', $_POST['user_pass']);
			$containsDigit   = preg_match('/\d/', $_POST['user_pass']);
			//$containswhitespace = preg_match('/ /', $_POST['user_pass']);

			if (!$containsLetter or !$containsDigit) {
				$co->setmessage("error", "password must contain at least one letter and one number and no spaces");
				$success=false;
			}	
		
			
		}
		if($_POST['user_cpass']==""){
			$co->setmessage("error", "Please enter confirm password");
			$success=false;
		}else{
			if($_POST['user_pass']!=$_POST['user_cpass']){
				$co->setmessage("error", "Confirm password must be same with password");
				$success=false;
			}	
		}
		
		if($success==true){
			if(isset($_POST['user_id']) and isset($_POST['code']) and isset($_POST['user_email'])){
				if(isset($row['uid']) and $row['uid']>0){
					$limit_time = $row['reset_time'] + (24 * 60 * 60);
					$present_time = time();
					if($present_time < $limit_time){
						$up_user = array();
						$up_user['pass'] = $_POST['user_pass'];	
						$up_user['decrypt_pass'] = md5($_POST['user_pass']);
						$up_user['reset_code'] = '';
						$up_user['reset_request'] = 0;
						$co->query_update('users', $up_user, array('uid'=>$row['uid']), 'uid=:uid');
						unset($up_user);
						$co->setmessage("status", "You have successfully changed your password. Now you can login using same values");
						echo '<script language="javascript">window.location="index.php?p=login";</script>';
						exit();
					}else{
						$co->setmessage("error", "Time expired to change your password now. Please send another request");
						echo '<script language="javascript">window.location="index.php";</script>';
						exit();
					}
				}else{
					echo '<script language="javascript">window.location="index.php";</script>';
					exit();
				}
			}else{
				echo '<script language="javascript">window.location="index.php";</script>';
				exit();
			}
		}	
	}	
	if(isset($_POST['form_id']) and $_POST['form_id']=="forget_password"){
		$username = trim($_POST['email_adr']);
		if($username=='')
		{
			$co->setmessage("error", "Please enter email address!");
		}
		else if($co->user_reset_password($username))
		{	
			$co->setmessage("status", "Success! A password reset link was emailed to : ".$username.". If you did not receive massage in your inbox than kindly check your spam once.");
			//echo '<script language="javascript">window.location="index.php";</script>';
			//$_POST = array();
		}		
		else 
		{
			$co->setmessage("error", "This email not found in the system.please Enter the email you used in your LinkiBag profile.");
		}
	}	
	
	if(isset($_POST['form_id']) and $_POST['form_id']=="send_friend_request"){		
		$success = true;
		$current = $co->getcurrentuser_profile();
		
		if(isset($_POST['in_db']) and $_POST['in_db']=='yes'){
			$_POST['email_id'] = trim($_POST['email_id']);
			$_POST['email_id'] = strip_tags($_POST['email_id']);
			if($_POST['email_id']!=''){
				$result = $co->query_first("SELECT uid FROM `users` WHERE email_id=:id",array('id'=>$_POST['email_id']));	
				if(isset($result['uid']) and $result['uid'] > 0){	
					$already_send_request = $co->query_first("SELECT COUNT(request_id) as total FROM `friends_request` WHERE request_by=:uid and request_to=:uid2 and status=0",array('uid'=>$current['uid'],'uid2'=>$result['uid']));  
					$chk_already_your_friend = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:id and fid=:fid and status=1",array('id'=>$current['uid'],'fid'=>$result['uid']));	
				}	
			}
			if($_POST['email_id']==''){
				$co->setmessage("error", "Please enter email name");
				$success=false;			
			}else{
				if(filter_var($_POST['email_id'], FILTER_VALIDATE_EMAIL) === false) {
					$co->setmessage("error", $_POST['email_id']." is not a valid email address");
					$success=false;
				}else{
					if(!(isset($result['uid']) and $result['uid'] > 0)){
						$co->setmessage("error", $_POST['email_id']." is not a LinkiBag user");
						$success=false;
					}
					if(isset($result['uid']) and $result['uid'] == $current['uid']){
						$co->setmessage("error", "You can not send friend request yourself");
						$success=false;
					}
					if(isset($result['uid']) and $result['uid'] == $current['uid']){
						$co->setmessage("error", "You can not send friend request yourself");
						$success=false;
					}
					if(isset($chk_already_your_friend['friend_id']) and $chk_already_your_friend['friend_id'] > 0){
						$co->setmessage("error", "This user is already your friend");
						$success=false;
					}	
					if(isset($already_send_request['total']) and $already_send_request['total'] == 5){
						$co->setmessage("error", "sorry you crossed the maxmimum send 5 request to one user");
						$success=false;
					}
				}	
				
			}	
		}elseif(isset($_POST['in_db']) and $_POST['in_db']=='no'){
			if($_POST['email_ids'] == ''){
				$co->setmessage("error", "Please enter email name");
				$success=false;			
			}else{
				$emails_ids = explode(',', $_POST['email_ids']);
				if(isset($emails_ids) and count($emails_ids) > 5){
					$co->setmessage("error", "sorry you can send at a time 5 requests");
					$success=false;
				}else{	
					foreach($emails_ids as $email_ids){
						$email_ids = trim($email_ids);
						$email_ids = strip_tags($email_ids);
						$result = $co->query_first("SELECT uid FROM `users` WHERE email_id=:id",array('id'=>$email_ids));
						$already_send_request = $co->query_first("SELECT COUNT(request_id) as total FROM `friends_request` WHERE request_by=:uid and request_to=0 and status=0 and request_email=:uid2",array('uid'=>$current['uid'],'uid2'=>$email_ids)); 
						if(filter_var($email_ids, FILTER_VALIDATE_EMAIL) === false){
							$co->setmessage("error", $email_ids." is not a valid email address");
							$success=false;
							break;
						}
						if(isset($already_send_request['total']) and $already_send_request['total'] == 5){
							$co->setmessage("error", "sorry you crossed the maxmimum send 5 request to ".$email_ids);
							$success=false;
							break;
						}
						if(isset($result['uid']) and $result['uid'] > 0){
							$co->setmessage("error", $email_ids." is already LinkiBag user, you can send friend request from member search");
							$success=false;
							break;
						}
					}
				}	
			}	
		}							
		if($success==true){	
			if(isset($_POST['in_db']) and $_POST['in_db']=='yes'){
				$uid = $result['uid'];
				$email_ids = $_POST['email_id'];
				$emails_ids = array($_POST['email_id']);	
			}else if(isset($_POST['in_db']) and $_POST['in_db']=='no'){
				$uid = 0;	
			}
			foreach($emails_ids as $email_ids){
				$reset_code = $co->generate_path(18);
				$up = array();									
				$up['request_by'] = $current['uid'];									
				$up['request_to'] = $uid;
				$up['request_code'] = $reset_code;
				$up['request_email'] = $email_ids;
				$up['status'] = 0;
				$up['request_time'] = time();									
				$request_id = $co->query_insert('friends_request', $up);									
				unset($up);	
				$get_email_id = $co->query_first("SELECT request_id FROM `friends_request` WHERE request_email=:mail and status=0",array('mail'=>$email_ids));
				if(isset($get_email_id['request_id']) and $get_email_id['request_id'] > 0){
					$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:uid and fid=:fid and status=0 and request_id=:id",array('uid'=>$current['uid'],'fid'=>$uid,'id'=>$get_email_id['request_id']));	
					if(!(isset($already_data_in_user_friends['friend_id']) and $already_data_in_user_friends['friend_id'] > 0)){				
						$up = array();									
						$up['request_id'] = $request_id;									
						$up['uid'] = $current['uid'];
						$up['fid'] = $uid;
						$up['fgroup'] = 0;
						$up['status'] = 0;
						$up['date'] = date('Y-m-d');
						$up['created'] = time();
						$up['updated'] = time();
						$friend_id = $co->query_insert('user_friends', $up);
						unset($up);	
					}
				}	
				if(isset($_POST['in_db']) and $_POST['in_db']=='yes'){
					if(isset($result['uid']) and $result['uid'] > 0){
						$to = $email_ids;
						$subject = 'Friend request at Linkibag';
						$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
						$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' wants to be your friend on Linkibag. <br /><br/><a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=yes">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=no">Declined</a></p> <br /><br />Cheers<br />Team Linkibag';				
						$from = 'info@linkibag.com';				
						$co->send_email($to, $subject, $message, $from);
					}	
				}else if(isset($_POST['in_db']) and $_POST['in_db']=='no'){
					$to = $email_ids;
					$subject = 'Friend request at Linkibag';
					$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
					$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' wants to be your friend on Linkibag.Please join LinkiBag. <br /><br/></p> <a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=yes">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=no">Declined</a><br /><br />Cheers<br />Team Linkibag';				
					$from = 'info@linkibag.com';				
					$co->send_email($to, $subject, $message, $from);
						
				}
				
			}	
			echo 'true';	
			//$co->setmessage("status", "Success! Friend request has been sent.");
			exit();
		}
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="act_on_friend_request"){
		$success=true;
		if($success==true){
			$current = $co->getcurrentuser_profile();
			if(isset($current['uid']) and $current['uid']==$_POST['id']){
				$get_status = $co->get_status_when_user_accept_request($_POST['id'], $_POST['user_id'],0);
				if(isset($get_status['request_id'])){
					if(isset($_POST['decline']) and $_POST['decline']=='yes'){
						$co->query_delete('friends_request', array('id'=>$get_status['request_id']), 'request_id=:id');
						$total_waiting = $co->total_waiting_request($current['uid']);
						$total_friend = $co->users_count_friend($current['uid']);
						echo json_encode(array('total_waiting'=>$total_waiting, 'total_friend'=>$total_friend));
					}else{
						$up = array();
						$up['status'] = 1;
						$up['request_time'] = time();
						$co->query_update('friends_request', $up, array('id'=>$get_status['request_id']), 'request_id=:id');
						$total_waiting = $co->total_waiting_request($current['uid']);						$total_friend = $co->users_count_friend($current['uid']);
						echo json_encode(array('total_waiting'=>$total_waiting, 'total_friend'=>$total_friend));
					}
				}
			}
		}
		exit();
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="cancel_friend_request"){
		$success=true;
		if($success==true){
			$current = $co->getcurrentuser_profile();
			if(isset($current['uid'])){
				$get_status = $co->is_user_request($current['uid'], $_POST['id'], 0);
				if(isset($get_status['request_id'])){
					$co->query_delete('friends_request', array('id'=>$get_status['request_id']), 'request_id=:id');
					$total_pending = $co->total_pending_request($current['uid']);
					echo json_encode(array('total_pending'=>$total_pending));
				}
			}
		}
		exit();
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="share_links"){
		$success=true;
		$errors = '';
		$current = $co->getcurrentuser_profile();
		if(isset($_POST['email_to_friends']) and $_POST['email_to_friends'] == 1){
			/*if($_POST['email_id'] == ''){
				$errors .= "<li>Please enter email address!</li>";
				$success = false;
			}
			*/
			$_POST['email_id'] = trim($_POST['email_id']);
			$_POST['email_id'] = strip_tags($_POST['email_id']);
			
			
			if($_POST['email_id']==''){
				$errors .= "<li>Please enter Email Address!</li>";
				$success=false;			
			}else{
				$emails_ids = explode(',', $_POST['email_id']);
				if(isset($emails_ids) and count($emails_ids) > 5){
					$errors .= "<li>sorry you can send at a time 5 requests!</li>";
					$success=false;
				}else{	
					foreach($emails_ids as $email_ids){
						$email_ids = trim($email_ids);
						$email_ids = strip_tags($email_ids);
						$result = $co->query_first("SELECT uid FROM `users` WHERE email_id=:id",array('id'=>$email_ids));
						$already_send_request = $co->query_first("SELECT COUNT(request_id) as total FROM `friends_request` WHERE request_by=:uid and request_to=0 and status=0 and request_email=:uid2",array('uid'=>$current['uid'],'uid2'=>$email_ids)); 
						if(filter_var($email_ids, FILTER_VALIDATE_EMAIL) === false){
							$errors .= "<li>".$email_ids." is not a valid Email Address!</li>";			
							$success=false;
							break;
						}
						if(isset($already_send_request['total']) and $already_send_request['total'] == 5){
							$errors .= "<li>sorry you crossed the maxmimum send 5 request to ".$email_ids." !</li>";			
							$success=false;
							break;
						}
						if(isset($result['uid']) and $result['uid'] > 0){
							$errors .= "<li>".$email_ids." is already LinkiBag user, you can send friend request from member search!</li>";		
							$success=false;
							break;
						}
					}
				}
				
				
			}
			
		}else{	
			if(!isset($_POST['shared_user'])){
				$success = false;
				$errors .= "<li>Please select one or more friend to share links!</li>";
				
			}elseif(!is_array($_POST['shared_user'])){
				$success = false;
			}
		}	
		if($success==true){
			$current = $co->getcurrentuser_profile();
			if(isset($_POST['email_to_friends']) and $_POST['email_to_friends'] == 1){
				foreach($emails_ids as $email_ids){	
					$reset_code = $co->generate_path(18);
					$up = array();									
					$up['request_by'] = $current['uid'];									
					$up['request_to'] = 0;
					$up['request_code'] = $reset_code;
					$up['request_email'] = $email_ids;
					$up['status'] = 0;
					$up['request_time'] = time();									
					$request_id = $co->query_insert('friends_request', $up);									
					unset($up);	
					$get_email_id = $co->query_first("SELECT request_id FROM `friends_request` WHERE request_email=:mail and status=0",array('mail'=>$email_ids));
					if(isset($get_email_id['request_id']) and $get_email_id['request_id'] > 0){
						$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:uid and fid=:fid and status=0 and request_id=:id",array('uid'=>$current['uid'],'fid'=>0,'id'=>$get_email_id['request_id']));	
						if(!(isset($already_data_in_user_friends['friend_id']) and $already_data_in_user_friends['friend_id'] > 0)){				
							$up = array();									
							$up['request_id'] = $request_id;									
							$up['uid'] = $current['uid'];
							$up['fid'] = 0;
							$up['fgroup'] = 0;
							$up['status'] = 0;
							$up['date'] = date('Y-m-d');
							$up['created'] = time();
							$up['updated'] = time();
							$friend_id = $co->query_insert('user_friends', $up);
							unset($up);	
						}
					}
					
					$to = $email_ids;
					$subject = 'Friend request at Linkibag';
					$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
					$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' wants to be your friend on Linkibag.Please join LinkiBag. <br /><br/></p> <a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=yes">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=no">Declined</a><br /><br />Cheers<br />Team Linkibag';				
					$from = 'info@linkibag.com';				
					$co->send_email($to, $subject, $message, $from);
						
				}	
			
				$msg = 'Success! Friend request has been sent to given Email address.';	
				
			}else{	
				$shared_users = $_POST['shared_user'];			
				foreach($_POST['urls'] as $urls_id){				
					if(isset($shared_users) and count($shared_users) > 0){
						foreach($shared_users as $shared_user){
							/*$check_share_by_status = $co->query_first("select uid from user_urls where uid=:id and url_id=:urls",array('id'=>$shared_user, 'urls'=>$urls_id));
							if(isset($check_share_by_status['uid']) and $check_share_by_status['uid'] > 0){	
								//echo $check_share_by_status['uid'].'<br>';
								//$co->query_update('user_urls', array('shared_to_status'=>1), array('id'=>$check_share_by_status['uid'],'url_ids'=>$urls_id), 'uid=:id and url_id=:url_ids');
							}
							$check_share_to_status = $co->query_first("select uid from user_urls where uid=:id and url_id=:urls",array('id'=>$current['uid'], 'urls'=>$urls_id));
							//echo $check_share_to_status['uid'];
							if(isset($check_share_to_status['uid']) and $check_share_to_status['uid'] > 0){	
							//echo $urls_id;
								//$co->query_update('user_urls', array('shared_by_status'=>1), array('id'=>$check_share_to_status['uid'],'url_ids'=>$urls_id), 'uid=:id and url_id=:url_ids');
							}*/	
							$url_info = $co->query_first("select ur.url_id,ur.url_cat from user_urls ur, user_shared_urls us where us.url_id=ur.url_id and us.shared_url_id=:urls",array('urls'=>$urls_id));
							$up = array();
							$up['uid'] = $current['uid'];
							$up['shared_to'] = $shared_user;
							$up['url_cat'] = $url_info['url_cat'];
							$up['url_id'] = $url_info['url_id'];
							$up['shared_time'] = time();
							$co->query_insert('user_shared_urls', $up);
							unset($up);					
						}	
					}/*else{	
						$up = array();
						$up['uid'] = $current['uid'];
						$up['shared_to'] = $shared_user;
						$up['url_id'] = $_POST['url'];
						$up['shared_time'] = time();
						$co->query_insert('user_shared_urls', $up);
						unset($up);
					}	*/
				}
				$msg ='Link successfully shared with selected friends';
			}	
			echo json_encode(array('msg'=>$msg,'success'=>$success));
			exit();
		}else{
			$msg ='<div class="alert alert-danger">
						<ul>
							'.$errors.'
							
						</ul>
				</div>';
			echo json_encode(array('msg'=>$msg,'success'=>$success));
			exit();
		}
	}

	if(isset($_POST['form_id']) and $_POST['form_id']=="multiple_shared"){
		$success = true;
		$current = $co->getcurrentuser_profile();	
		$lists_of_all_friends = $co->fetch_all_array("SELECT * FROM friends_request ur, profile p, users u WHERE (ur.request_by=:id or ur.request_to=:id2) and ur.status='1' and ((ur.request_to=:id3 and p.uid=ur.request_by and p.uid=u.uid) OR (ur.request_by=:id4 and p.uid=ur.request_to and p.uid=u.uid))", array('id'=>$current['uid'],'id2'=>$current['uid'],'id3'=>$current['uid'],'id4'=>$current['uid']));
		$groups = $co->fetch_all_array("SELECT * FROM `groups` WHERE uid=:uid",array('uid'=>$current['uid']));      			 
		$all_urls = $co->fetch_all_array("select url_id from user_urls", array());
		$arr = '';
		$link_urls = '';
		if(!isset($_POST['share_url'])){
			$co->setmessage("error", "Please select atleast one url");
			$success = false;	
		}
		if(isset($_POST['share_url']) and count($_POST['share_url']) > 0){
			foreach($_POST['share_url'] as $url){
				if(isset($_POST['share']) and $_POST['share'] == 1){
					$arr .= '<input type="hidden" name="urls[]" value="'.$url.'"/>' ; 
					$link_urls .= 'url[]='.$url.'&';
					$success = true;
				}else if(isset($_POST['mark_as_unread']) and $_POST['mark_as_unread'] == 1){
					$up_val = array();
					$up_val['read_status'] = 0;
					$up_val['num_of_visits'] = 0;	
					$co->query_update('user_shared_urls', $up_val, array('id'=>$url, 'uid'=>$current['uid']), 'shared_url_id=:id and shared_to=:uid');
					unset($up_val);
					$success = true;
				}else if(isset($_POST['mark_as_del']) and $_POST['mark_as_del'] == 1){
					$co->query_delete('user_shared_urls', array('id'=>$url, 'uid'=>$current['uid']), 'shared_url_id=:id and shared_to=:uid');
					$success = true;
				}
				
				
					
						
			}	

		}	
		if($success == true){
			if(isset($_POST['share']) and $_POST['share'] == 1){	
				//<a href="index.php?p=share_links&'.$link_urls.'=" onclick="show_block(\'#friends_and_users\', \'#email_to_friends\');" class="btn btn-primary btn-block btn-lg">Share with LinkiBag Friends</a>
				$share_link_body = '
				
					<div class="share-btns">
						<div class="col-md-6">
							<a href="index.php?p=share_links&'.$link_urls.'=" class="btn btn-primary btn-block btn-lg">Share with LinkiBag Friends</a>
						</div>
						<div class="col-md-6">
							<a href="#" onclick="show_block(\'#email_to_friends\', \'#friends_and_users\');" class="btn btn-default btn-block btn-lg">Email to Your Friends</a>
						</div>
					</div>	
				
					<div style="display:block;">
						<div class="col-md-12">
							<div class="tab-nav-friends panel-default" id="friends_and_users" style="display: none;">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab1default" data-toggle="tab">Send To Friends</a></li>
									<li><a href="#tab2default" data-toggle="tab">Send To Users</a></li>
								</ul>
								<div class="panel-body">
									<div class="tab-content">
										<div class="tab-pane fade in active" id="tab1default">
											<form method="post" class="form-horizontal edit_url_form-design" id="share_form_3" action="index.php?p=dashboard&ajax=ajax_submit" onsubmit="javascript: return share_links(3);">
												<div id="url-shared-messages-out_3"></div>
												<input type="hidden" name="form_id" value="share_links"/>
												'.$arr.'
												
											
												<div class="row profile_search_list" style="padding: 0px;">									
													<ul class="tvc-lists url-GET-comment" style="display: block;">
														<div>';
														foreach($groups as $list){
															$share_link_body .= '		
																		<li>										
																			<div class="person_name">
																			<label>
																				<input type="checkbox" name="shared_user[]" value="'.$list['group_id'].'"/> '.$list['group_name'].'</label>								
																			</div>													
																		</li>';
														}
															$share_link_body .= '																
															</div>
														</ul>
												</div>
												
												<div style="padding-right: 0px;" class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<button type="submit" class="btn btn-primary" id="send_share_link_3">Save changes</button>
												</div>
											</form>
										
										
										</div>
										<div class="tab-pane fade" id="tab2default">
											<form method="post" class="form-horizontal edit_url_form-design" id="share_form_1" action="index.php?p=dashboard&ajax=ajax_submit" onsubmit="javascript: return share_links(1);">
												<div id="url-shared-messages-out_1"></div>
												<input type="hidden" name="form_id" value="share_links"/>
												
												'.$arr.'
												
											
												<div class="row profile_search_list" style="padding: 0px;">									
													<ul class="tvc-lists url-GET-comment" style="display: block;">
														<div>';
														foreach($lists_of_all_friends as $lists_of_all_friend){
															$share_link_body .= '		
																		<li>										
																			<div class="person_name">
																			<label>
																				<input type="checkbox" name="shared_user[]" value="'.$lists_of_all_friend['uid'].'"/> '.$lists_of_all_friend['first_name'].' '.$lists_of_all_friend['last_name'].'</label>								
																			</div>													
																		</li>';
														}
															$share_link_body .= '																
															</div>
														</ul>
												</div>
												<div style="padding-right: 0px;" class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<button type="submit" class="btn btn-primary" id="send_share_link_1">Save changes</button>
												</div>
												
											</form>
										</div>
									</div>
								</div>
							</div>
							<div id="email_to_friends" style="display:none;">
								<form method="post" class="form-horizontal edit_url_form-design" id="share_form_2" action="index.php?p=dashboard&ajax=ajax_submit" onsubmit="javascript: return share_links(2);">
									<div id="url-shared-messages-out_2"></div>
										<input type="hidden" name="form_id" value="share_links"/>
										<input type="hidden" name="email_to_friends" value="1"/>
										<div class="form-group" style="margin: 20px 0px;">
											<div class="col-md-4 text-right"><label class="mylabel">Email<span class="required-field">*</span></label></div>
											<div class="col-md-8">
												<textarea required="" name="email_id" aria-describedby="basic-addon1" placeholder="Email Address. You can type up to five email addresses separated by commas." class="form-control"></textarea>			
											</div>

										</div>
										<div style="padding-right: 0px;" class="modal-footer">';
											//<button type="button" onclick="show_block(\'#friends_and_users\', \'#email_to_friends\');" class="btn btn-default" >Back</button>
										$share_link_body .= '
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary" id="send_share_link_2">Save changes</button>
										</div>	
								</form>	
							</div>		
						</div>
					</div>';
			
				echo $share_link_body;
			}elseif(isset($_POST['mark_as_unread']) and $_POST['mark_as_unread'] == 1){		
				echo json_encode($_POST['share_url']);			
			}elseif(isset($_POST['mark_as_del']) and $_POST['mark_as_del'] == 1){
				if(isset($_POST['p']) and $_POST['p'] == 'shared-links'){
					$sql = "SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.* FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id and us.uid!=:id2";
					$sql2 = "SELECT COUNT(us.shared_url_id) as total FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id and us.uid!=:id2";
				}else if(isset($_POST['p']) and $_POST['p'] == 'dashboard'){
					$sql = "SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.* FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id";
					$sql2 = "SELECT COUNT(us.shared_url_id) as total FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id";
				}	
				if($_POST['this_page'] =='p=dashboard' and isset($_POST['trash']) and $_POST['trash'] == 1){
					$sql .= " and us.url_cat=:cid";
					$sql2 .= " and us.url_cat=:cid";
				}else if($_POST['this_page'] =='p=dashboard' and $_POST['cid'] > 0){
					$sql .= " and us.url_cat=:cid";
					$sql2 .= " and us.url_cat=:cid";
				}else{
					$sql .= " and us.url_cat !='0'";
					$sql2 .= " and us.url_cat !='0'";
				}	
					$cond = array();	
					if($_POST['only_current']==1){
						$sql .= " and us.uid=:id2";
						$sql2 .= " and us.uid=:id2";
						$cond['id2'] = $current['uid'];
					}
					if(isset($_POST['shared_by']) and $_POST['shared_by'] == 'asc'){
						$sql .= " ORDER BY u.email_id ASC";			
						$sql2 .= " ORDER BY u.email_id ASC";			
					}elseif(isset($_POST['shared_by']) and $_POST['shared_by'] == 'desc'){			
						$sql .= " ORDER BY u.email_id DESC";			
						$sql2 .= " ORDER BY u.email_id DESC";			
					}elseif(isset($_POST['msg_by']) and $_POST['msg_by'] == 'asc'){			
						$sql .= " ORDER BY ur.url_desc ASC";			
						$sql2 .= " ORDER BY ur.url_desc ASC";			
					}elseif(isset($_POST['msg_by']) and $_POST['msg_by'] == 'desc'){			
						$sql .= " ORDER BY ur.url_desc DESC";		
						$sql2 .= " ORDER BY ur.url_desc DESC";		
					}elseif(isset($_POST['url_by']) and $_POST['url_by'] == 'asc'){			
						$sql .= " ORDER BY ur.url_value ASC";		
						$sql2 .= " ORDER BY ur.url_value ASC";		
					}elseif(isset($_POST['url_by']) and $_POST['url_by'] == 'desc'){			
						$sql .= " ORDER BY ur.url_value DESC";		
						$sql2 .= " ORDER BY ur.url_value DESC";		
					}elseif(isset($_POST['date_by']) and $_POST['date_by'] == 'asc'){			
						$sql .= " ORDER BY ur.created_date ASC";		
						$sql2 .= " ORDER BY ur.created_date ASC";		
					}elseif(isset($_POST['date_by']) and $_POST['date_by'] == 'desc'){			
						$sql .= " ORDER BY ur.created_date DESC";		
						$sql2 .= " ORDER BY ur.created_date DESC";		
					}elseif(isset($_POST['visit_by']) and $_POST['visit_by'] == 'asc'){			
						$sql .= " ORDER BY us.num_of_visits ASC";		
						$sql2 .= " ORDER BY us.num_of_visits ASC";		
					}elseif(isset($_POST['visit_by']) and $_POST['visit_by'] == 'desc'){			
						$sql .= " ORDER BY us.num_of_visits DESC";				
						$sql2 .= " ORDER BY us.num_of_visits DESC";				
					}else{					
						$sql .= " ORDER BY us.shared_url_id DESC";
						$sql2 .= " ORDER BY us.shared_url_id DESC";
					}	
					$cond['id'] = $current['uid'];
					if(isset($_POST['p']) and $_POST['p'] == 'shared-links')
						$cond['id2'] = $current['uid'];
					if($_POST['this_page'] =='p=dashboard' and isset($_POST['trash']) and $_POST['trash'] == 1)
						$cond['cid'] = $_POST['cid'];
					else if($_POST['this_page'] =='p=dashboard' and $_POST['cid'] > 0)
						$cond['cid'] = $_POST['cid'];		
				
				$result = $co->query_first($sql2,$cond);
				$offset = ($_POST['page'] - 1) * $_POST['item_per_page'];
				$sql .= " LIMIT ".$offset.",".$_POST['item_per_page'];
				
				$records = $co->fetch_all_array($sql,$cond);
				//echo count($records);
				if(isset($records) and count($records) > 0);
				$j = 1;
				$i=1; 
				$new_row = '';
				foreach($records as $urlpost){
					$i++; 	
					if($j == 1){									
						$class_name = 'first_row';
					$j++;	
					}else{
						$class_name = 'second_row';
						$j = 1;
					}
					$new_row .= '<tr class="'.$class_name.($urlpost['num_of_visits'] > 0 ? ' read' : ' unread').'" id="url_'.$urlpost['shared_url_id'].'">
							<td style="width:30%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="'.$urlpost['shared_url_id'].'"></span> &nbsp; <a href="index.php?p=view_link&id='.$urlpost['shared_url_id'].'">'.((strlen($urlpost['url_value']) > 10) ? substr($urlpost['url_value'], 0, 10).'...' : $urlpost['url_value']).'</a></td>
							<td style="width:20%">'.$urlpost['email_id'].'</td>
							<td style="width:20%">'.((strlen($urlpost['url_desc']) > 10) ? substr($urlpost['url_desc'], 0, 10).'...' : $urlpost['url_desc']).'</td>
							<td style="width:20%">'.date('d/m/Y', $urlpost['shared_time']).'   '.date('h:i a', $urlpost['shared_time']).'</td>
						</tr>
						';	
					
				}	
				$page_link_option = '';
				$remainder = $result['total'] % $_POST['item_per_page'];
				if($remainder == 0){
					$page_link_option = 1;	
				}
				
				echo json_encode(array('page_link_option'=>$page_link_option,'new_row'=>$new_row));	


			
				//echo json_encode($_POST['share_url']);			
			}
		}	
	}
	
	if(isset($_POST['form_id']) and $_POST['form_id']=="add_groups"){
		$success = true;
		$error = '';
		$current = $co->getcurrentuser_profile();
		//echo $_POST['id'];
		if(isset($_POST['id']) and $_POST['id'] > 0){
			
		}else{
			$already_exit_gp = $co->query_first("select group_id from groups WHERE uid=:id and group_name=:name",array('id'=>$current['uid'],'name'=>$_POST['group_name']));
			if($already_exit_gp['group_id'] > 0){
				$error .= "This group is already existed, create another <br/>";
				$success = false;	
			}	
		}	
		if($success == true){
			$cond = array();
			$sql = "select * from groups WHERE group_id=:id";
			if(isset($_POST['id']) and $_POST['id'] > 0){
				$up_val = array();
				$up_val['group_name'] = $_POST['group_name'];
				$up_val['updated'] = time();				
				$up_val['status'] = 1;				
				$co->query_update('groups', $up_val, array('id'=>$_POST['id'], 'uid'=>$current['uid']), 'group_id=:id and uid=:uid');
				unset($up_val);
				$cond = array('id'=>$_POST['id']);
				$id = $_POST['id'];
			}else{				
				$up_val = array();
				$up_val['uid'] = $current['uid'];
				$up_val['group_name'] = $_POST['group_name'];
				$up_val['created'] = time();
				$up_val['updated'] = time();				
				$up_val['status'] = 1;				
				/*if(isset($_POST['shared_user']) and count($_POST['shared_user']) > 0){
					if(@serialize($_POST['shared_user']))
						$up_val['friends'] = serialize($_POST['shared_user']);			
				}*/		
				$group_id = $co->query_insert('groups', $up_val);
				unset($up_val);
				$cond = array('id'=>$group_id);
				$id = '';
			}
			
			$group_info = $co->query_first($sql, $cond);
			
			if(isset($_POST['group_name']) and $_POST['group_name'] != ''){	
				$page_link_option = '';
				if(isset($_POST['id']) and $_POST['id'] > 0){
					$page = '';
					$new_row = '
						<td style="width:50%"><span><input type="checkbox" class="grouping" value="'.$group_info['group_id'].'" name="group_name[]"></span> &nbsp; <a href="#">'.$group_info['group_name'].'</a> <span>&nbsp; <a href="#" onclick="load_edit_frm('.$group_info['group_id'].', \'group\')"><i class="fa fa-pencil"></i></a></span></td>
						<td style="width:20%"><a class="btn btn-sm" heaf="#">Empty</a></td>
						<td class="text-center" style="width:15%">1</td>
						<td class="text-center" style="width:15%">3</td>
					
					';
					$msg = 'Folder updated successfully</div>';	
		
				}else{
					$result = $co->query_first("select COUNT(group_id) as total from groups where uid=:uid",array('uid'=>$current['uid']));
					$no_of_pages = $result['total'] % $_POST['item_per_page'];
					if($no_of_pages == 1){
						$no_of_pages = $result['total'] / $_POST['item_per_page'];
						$no_of_pages = intval($no_of_pages);
						$no_of_pages = $no_of_pages + 1;
						$page_link_option = '<li><a href="index.php?page='.$no_of_pages.'&amp;'.$_POST['this_page'].'">'.$no_of_pages.'</a></li>';	
					}	
					
					if(isset($_SESSION['num_of_times_group']))
						$_SESSION['num_of_times_group']++;
					else	
					$_SESSION['num_of_times_group'] = 1;
					
					if(isset($_SESSION['num_of_times_group']) and $_SESSION['num_of_times_group'] == 2){
						unset($_SESSION['num_of_times_group']);
						$new_row = '<tr class="first_row" id="record_'.$group_info['group_id'].'">';
					}else{
						$new_row = '<tr class="second_row text-bold" id="record_'.$group_info['group_id'].'">';
					}
					
					$new_row .= '
						<td style="width:50%"><span><input type="checkbox" class="grouping" value="'.$group_info['group_id'].'" name="group_name[]"></span> &nbsp; <a href="#">'.$group_info['group_name'].'</a> <span>&nbsp; <a href="#" onclick="load_edit_frm('.$group_info['group_id'].', \'group\')"><i class="fa fa-pencil"></i></a></span></td>
						<td style="width:20%"><a class="btn btn-sm" heaf="#">Empty</a></td>
						<td class="text-center" style="width:15%">1</td>
						<td class="text-center" style="width:15%">3</td>
					</tr>
					';
					$msg = 'Folder added successfully</div>';	
					$page = $_POST['this_page'];
				}	
				
				echo json_encode(array('new_row'=>$new_row,'msg'=>$msg,'id'=>$id,'success'=>$success,'page_link_option'=>$page_link_option,'this_page'=>$page));
			}		
			exit();	
		}else{
			$msg = $error.
			$new_row = '';		
			echo json_encode(array('new_row'=>$new_row,'msg'=>$msg,'success'=>$success));		
			exit();
		}	
		
				
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="del_group"){
		$success = true;
		$current = $co->getcurrentuser_profile();
		$error = '';	
		if(!isset($_POST['groups'])){
			$error .= "Please select atleast one group";
			$success = false;	
		}
		if($success == true){
			if(isset($_POST['groups']) and count($_POST['groups']) > 0){
				foreach($_POST['groups'] as $group_id){
					$co->query_delete('groups', array('id'=>$group_id), 'group_id=:id');
				}
				$offset = ($_POST['page'] - 1) * $_POST['item_per_page'];
				$sql = "select * from groups WHERE uid=:id ORDER BY group_id DESC LIMIT ".$offset.",".$_POST['item_per_page'];
				$records = $co->fetch_all_array($sql,array('id'=>$current['uid']));
				//echo count($records);
				if(isset($records) and count($records) > 0);
				$j = 1;
				$new_row = '';
				foreach($records as $list){
					$empty_link = '';
					//$total_url_in_cat = $co->query_first("select COUNT(url_id) as total from user_shared_urls where url_cat=:cat",array('cat'=>$list['cid'])); 
					//$empty_link = 'empty_links('.$list['cid'].');';	
					//	if($total_url_in_cat['total'] == 0)
					//		$empty_link= "error_dialogues('There is no links in this category')";
					if($j == 1){									
						$new_row .= '<tr class="first_row" id="record_'.$list['group_id'].'">
							<td style="width:50%"><span><input type="checkbox" class="grouping" value="'.$list['group_id'].'" name="group_name[]"></span> &nbsp; <a href="#">'.$list['group_name'].'</a> <span>&nbsp; <a href="#" onclick="load_edit_frm('.$list['group_id'].', \'group\')"><i class="fa fa-pencil"></i></a></span></td>
							<td style="width:20%"><a class="btn btn-sm" heaf="#">Empty</a></td>
							<td class="text-center" style="width:15%">1</td>
							<td class="text-center" style="width:15%">3</td>
							</tr>
						';
					$j++;	
					}else{
						$new_row .= '<tr class="second_row text-bold" id="record_'.$list['group_id'].'">
							<td style="width:50%"><span><input type="checkbox" class="grouping" value="'.$list['group_id'].'" name="group_name[]"></span> &nbsp; <a href="#">'.$list['group_name'].'</a> <span>&nbsp; <a href="#" onclick="load_edit_frm('.$list['group_id'].', \'group\')"><i class="fa fa-pencil"></i></a></span></td>
							<td style="width:20%"><a class="btn btn-sm" heaf="#">Empty</a></td>
							<td class="text-center" style="width:15%">1</td>
							<td class="text-center" style="width:15%">3</td>
							</tr>
						';
						$j = 1;
					}	
					
				}
				
				
				$del_row = $_POST['groups'];
				$page_link_option = '';
				$result = $co->query_first("select COUNT(group_id) as total from groups where uid=:uid",array('uid'=>$current['uid']));
				$remainder = $result['total'] % $_POST['item_per_page'];
				if($remainder == $_POST['item_per_page'] - 1){
					$page_link_option = 1;	
				}	
				//print_r($del_row);
				//echo json_encode($del_row);
				echo json_encode(array('del_row'=>$del_row,'page_link_option'=>$page_link_option,'new_row'=>$new_row));
			}		
			exit();	
		}
	
	}
	
	if(isset($_POST['form_id']) and $_POST['form_id']=="move_to_cat_multiple"){
		$success = true;
		$current = $co->getcurrentuser_profile();
		$error = '';
		if(isset($_POST['type']) and  $_POST['type'] == 'category'){
			$url_error = " URL";	
			$cat_error = " category";	
		}elseif(isset($_POST['type']) and  $_POST['type'] == 'group'){
			$url_error = " GROUP";	
			$cat_error = " friend";	
		}	
		if(!isset($_POST['share_url'])){
			$error .= "Please select atleast one".$url_error;
			$success = false;	
		}
		if(isset($_POST['unfriend']) and  $_POST['unfriend'] == 0){
			if($_POST['cat'] == ''){
				$error .= "Please select".$cat_error;
				$success = false;	
			}
		}	
		if($success == true){
			if(isset($_POST['share_url']) and count($_POST['share_url']) > 0){					
				foreach($_POST['share_url'] as $share_url){
					$cond = array();
					if(isset($_POST['type']) and  $_POST['type'] == 'category'){
						$sql = "SELECT shared_url_id as ids FROM user_shared_urls WHERE shared_to=:uid and shared_url_id=:id";	
						$cond['uid'] = $current['uid'];
						$cond['id'] = $share_url;
					}else if(isset($_POST['type']) and  $_POST['type'] == 'group'){
						$sql = "select friend_id as ids,fid from user_friends where uid=:uid and friend_id=:id";	
						$cond['uid'] = $current['uid'];
						$cond['id'] = $share_url;
					}
					
					$result = $co->query_first($sql,$cond);
					if(isset($result['ids']) and $result['ids'] > 0){
						if(isset($_POST['type']) and  $_POST['type'] == 'category'){
							$co->query_update('user_shared_urls', array('url_cat'=>$_POST['cat']), array('id'=>$result['ids'],'id2'=>$current['uid']), 'shared_url_id=:id and shared_to=:id2');	
							$msg = 1;
							$msg_content = 'Link successfully moved !';	
						}else if(isset($_POST['type']) and  $_POST['type'] == 'group'){
							if(isset($_POST['unfriend']) and  $_POST['unfriend'] == 0){
								$co->query_update('user_friends', array('fgroup'=>$_POST['cat']), array('id'=>$result['ids'],'id2'=>$current['uid']), 'friend_id=:id and uid=:id2');
								$msg = 1;
								$msg_content = 'Friend successfully moved !';	
							}else if(isset($_POST['unfriend']) and  $_POST['unfriend'] == 1){
								for($i=0;$i<=1;$i++){
									$co->query_delete('user_friends', array('id2'=>$current['uid'],'id3'=>$result['fid']), 'uid=:id2 and fid=:id3');
									$uid = $current['uid'];
									$current['uid'] = $result['fid'];
									$result['fid'] = $uid;
								}
								$msg = 1;
								$msg_content = 'Friend successfully unfriended !';	
							}	
							
						}	
					}
				}			
				echo json_encode(array('msg'=>$msg,'msg_content'=>$msg_content));
			}		
			exit();	
		}else{
			echo json_encode(array('error'=>$error));
			exit();
		}	
	
	}
	
	
	if(isset($_POST['form_id']) and $_POST['form_id']=="link_friend_with_group"){
		$success = true;
		$current = $co->getcurrentuser_profile();
		
		if($success == true){
			if(isset($_POST['users']) and count($_POST['users']) > 0){
				foreach($_POST['users'] as $users_id){
					if(isset($_POST['groups']) and count($_POST['groups']) > 0){
						echo count($_POST['groups']);
						foreach($_POST['groups'] as $group_id){
							$up_val = array();
							$up_val['members'] = $users_id;
							$up_val['groups'] = $group_id;
							$up_val['created'] = time();
							$up_val['updated'] = time();				
							$up_val['status'] = 1;
							$group_user_id = $co->query_insert('groups_member', $up_val);
							unset($up_val);	
						}	
					}	
				}
			}
			echo 'friends added in group successfully and email sent to users';
		}
	
	}
	
	if(isset($_POST['form_id']) and $_POST['form_id']=="add_category"){
		$success = true;
		$current = $co->getcurrentuser_profile();
		$error = '';
		if(isset($_POST['id']) and $_POST['id'] > 0){
			
		}else{	
			$already_exit_cat = $co->query_first("select cid from category WHERE uid=:id and cname=:name",array('id'=>$current['uid'],'name'=>$_POST['cname']));
			if($already_exit_cat['cid'] > 0){
				$error .= "This category is already existed, create another <br/>";
				$success = false;	
			}
		}	
		if($success == true){
			$cond = array();
			$sql = "select * from category WHERE cid=:id";
			if(isset($_POST['id']) and $_POST['id'] > 0){
				$up_val = array();
				$up_val['cname'] = $_POST['cname'];
				$up_val['updated_time'] = time();				
				$up_val['status'] = 0;				
				$co->query_update('category', $up_val, array('id'=>$_POST['id'], 'uid'=>$current['uid']), 'cid=:id and uid=:uid');
				unset($up_val);
				$cond = array('id'=>$_POST['id']);
				$id = $_POST['id'];
			}else{
				$up_val = array();
				$up_val['uid'] = $current['uid'];
				$up_val['cname'] = $_POST['cname'];
				$up_val['created_time'] = time();
				$up_val['updated_time'] = time();				
				$up_val['status'] = 0;				
				
				$category_id = $co->query_insert('category', $up_val);
				unset($up_val);
				$cond = array('id'=>$category_id);
				$id = '';
			}	
			$cat_info = $co->query_first($sql, $cond);
			if(isset($_POST['cname']) and $_POST['cname'] != ''){
				$j = 1;
				$page_link_option = '';
				
				$option = '';
				if(isset($_POST['id']) and $_POST['id'] > 0){
					$total_url_in_cat = $co->query_first("select COUNT(url_id) as total from user_shared_urls where url_cat=:cat and shared_to=:uid",array('cat'=>$cat_info['cid'],'uid'=>$current['uid'])); 
					$empty_link = 'empty_links('.$cat_info['cid'].');';	
						if($total_url_in_cat['total'] == 0)
							$empty_link= "error_dialogues('There is no links in this category')";
					$new_row = '
						<td style="width:62%"><span><input type="checkbox" class="grouping" value="'.$cat_info['cid'].'" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid='.$cat_info['cid'].'">'.$cat_info['cname'].'</a> <span>&nbsp; <a href="#" onclick="load_edit_frm('.$cat_info['cid'].', \'category\')"><i class="fa fa-pencil"></i></a></span></td>
						<td style="width:10%"><a class="btn btn-sm" href="#" onclick="'.$empty_link.'">Empty</a></td>						
						<td class="text-center" style="width:20%">'.$total_url_in_cat['total'].'</td>
					';	
					$msg = 'Folder updated successfully';	
				}else{
					$result = $co->query_first("select COUNT(cid) as total from category where uid=:uid",array('uid'=>$current['uid']));
					if($_POST['item_per_page'] > 0){
						$no_of_pages = $result['total'] % $_POST['item_per_page'];
					}	
					if(isset($no_of_pages) and $no_of_pages == 1){
						if($_POST['item_per_page'] > 0){
							$no_of_pages = $result['total'] / $_POST['item_per_page'];
							$no_of_pages = intval($no_of_pages);
							$no_of_pages = $no_of_pages + 1;
							$page_link_option = '<li><a href="index.php?page='.$no_of_pages.'&amp;'.$_POST['this_page'].'">'.$no_of_pages.'</a></li>';	
						}	
					}	
					/*$estimated_records = ($_POST['item_per_page'] * $_POST['total_pages']) + 1; 	
					if($estimated_records == $result['total']){
						$_POST['total_pages'] = $_POST['total_pages'] + 1;
						$page_link_option = '<li><a href="index.php?page='.$no_of_pages.'&amp;'.$_POST['this_page'].'">'.$_POST['no_of_pages'].'</a></li>';	
					}	
					*/
					if(isset($_SESSION['num_of_times']))
						$_SESSION['num_of_times']++;
					else	
					$_SESSION['num_of_times'] = 1;
				
					if(isset($_POST['view_link']) and $_POST['view_link'] == 1){
						$option  = '<option value="'.$cat_info['cid'].'" selected="selected">'.$cat_info['cname'].'</option>';

					}	
					if(isset($_SESSION['num_of_times']) and $_SESSION['num_of_times'] == 2){
						unset($_SESSION['num_of_times']);
						$new_row = '<tr class="first_row" id="record_'.$cat_info['cid'].'">';
					}else{
						$new_row = '<tr class="second_row text-bold" id="record_'.$cat_info['cid'].'">';
					}
					
					$new_row .='	
						<td style="width:62%"><span><input type="checkbox" class="grouping" value="'.$cat_info['cid'].'" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid='.$cat_info['cid'].'">'.$cat_info['cname'].'</a> <span>&nbsp; <a href="#" onclick="load_edit_frm('.$cat_info['cid'].', \'category\')"><i class="fa fa-pencil"></i></a></span></td>
						<td style="width:10%"><a class="btn btn-sm" href="#" onclick="error_dialogues(\'There is no links in this category\')">Empty</a></td>						
						<td class="text-center" style="width:20%">0</td>
					</tr>
					';
					$msg = 'Folder added successfully';	
				}	
				
					
				echo json_encode(array('new_row'=>$new_row,'msg'=>$msg,'id'=>$id, 'option'=>$option, 'success'=>$success,'page_link_option'=>$page_link_option));
			}		
			exit();	
		}else{
			$msg = $error;
				
			$new_row = '';
			echo json_encode(array('new_row'=>$new_row,'msg'=>$msg,'success'=>$success));	
			exit();	
		}	
		
		
	
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="del_category"){
		$success = true;
		$current = $co->getcurrentuser_profile();
		$error = '';	
		if(!isset($_POST['categories'])){
			$error .= "Please select atleast one category";
			$success = false;	
		}
		if($success == true){
			if(isset($_POST['categories']) and count($_POST['categories']) > 0){
				foreach($_POST['categories'] as $category_id){
					$co->query_delete('category', array('id'=>$category_id), 'cid=:id');
				}
				$offset = ($_POST['page'] - 1) * $_POST['item_per_page'];
				$sql = "select * from category WHERE uid=:id ORDER BY cid DESC LIMIT ".$offset.",".$_POST['item_per_page'];
				$records = $co->fetch_all_array($sql,array('id'=>$current['uid']));
				//echo count($records);
				if(isset($records) and count($records) > 0);
				$j = 1;
				$new_row = '';
				foreach($records as $list){
					$total_url_in_cat = $co->query_first("select COUNT(url_id) as total from user_shared_urls where url_cat=:cat and shared_to=:uid",array('cat'=>$list['cid'],'uid'=>$current['uid'])); 
					$empty_link = 'empty_links('.$list['cid'].');';	
						if($total_url_in_cat['total'] == 0)
							$empty_link= "error_dialogues('There is no links in this category')";
					if($j == 1){									
						$new_row .= '<tr class="first_row" id="record_'.$list['cid'].'">
							<td style="width:62%"><span><input type="checkbox" class="grouping" value="'.$list['cid'].'" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid='.$list['cid'].'">'.$list['cname'].'</a> <span>&nbsp; <a href="#" onclick="load_edit_frm('.$list['cid'].', \'category\')"><i class="fa fa-pencil"></i></a></span></td>
							<td style="width:10%"><a class="btn btn-sm" href="#" onclick="'.$empty_link.'">Empty</a></td>						
							<td class="text-center" style="width:20%">'.$total_url_in_cat['total'].'</td>
							</tr>
						';
					$j++;	
					}else{
						$new_row .= '<tr class="second_row text-bold" id="record_'.$list['cid'].'">
							<td style="width:62%"><span><input class="grouping" type="checkbox" value="'.$list['cid'].'" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid='.$list['cid'].'">'.$list['cname'].'</a> <span>&nbsp; <a href="#" onclick="load_edit_frm('.$list['cid'].', \'category\')"><i class="fa fa-pencil"></i></a></span></td>
							<td style="width:10%"><a class="btn btn-sm" href="#" onclick="'.$empty_link.'">Empty</a></td>						
							<td class="text-center" style="width:20%">'.$total_url_in_cat['total'].'</td>
							</tr>
						';
						$j = 1;
					}	
					
				}	
				$page_link_option = '';
				$result = $co->query_first("select COUNT(cid) as total from category where uid=:uid",array('uid'=>$current['uid']));
				$remainder = $result['total'] % $_POST['item_per_page'];
				if($remainder == $_POST['item_per_page'] - 1){
					$page_link_option = 1;	
				}
				$del_row = $_POST['categories'];	
				//print_r($del_row);
				//echo json_encode($del_row);
				echo json_encode(array('del_row'=>$del_row,'page_link_option'=>$page_link_option,'new_row'=>$new_row));
			}		
			exit();	
		}
	
	}
	
	
	
}

?>