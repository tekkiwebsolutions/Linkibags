<?php
if(!isset($include)){
	exit();
}
if($_SERVER['REQUEST_METHOD']=='POST'){
	include('submit-linkibook.php');
	if(isset($_POST['form_id']) and $_POST['form_id']=="create_linkibook"){
		$current = $co->getcurrentuser_profile();
		$success = true;
		if(empty($_POST['book_title'])){
			echo json_encode(array('error'=>'Please enter title'));
			exit();
		}
		if(empty($_POST['book_subtitle'])){
			echo json_encode(array('error'=>'Please enter sub-title'));
			exit();
		}
		if(!isset($_POST['add_url'])){
			echo json_encode(array('error'=>'Please select the link(s) you would like to add to LinkiBook'));
			exit();
		}elseif(count($_POST['add_url'])==0) {
			echo json_encode(array('error'=>'Please select the link(s) you would like to add to LinkiBook'));
			exit();
		}

		$tim = time();
		$new = array('uid'=>$current['uid'], 'book_title'=>$_POST['book_title'], 'book_subtitle'=>$_POST['book_subtitle'], 'created'=>$tim, 'updated'=>$tim);
		$linkibook_id = $co->query_insert('linkibooks', $new);
		unset($new);
		$urls = $_POST['add_url'];
		foreach ($urls as $url) {
			$subtitle_textbox = 'subtitle_'.$url;
			$text_textbox = 'text_'.$url;
			$new = array('linkibook_id'=>$linkibook_id, 'url_id'=>$url, 'url_title'=>$_POST[$text_textbox], 'url_subtitle'=>$_POST[$subtitle_textbox]);
			$co->query_insert('linkibook_urls', $new);
			unset($new);
		}

		$weblink = WEB_ROOT.'links_print/index.php?create_linkibook=1&savefile=1&id='.$linkibook_id;
		/*file_get_contents($weblink);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $weblink);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
		$con1 = curl_exec($ch);
		curl_close($ch);*/

		$_SESSION['dialog_success'] = 'Linkibook created successfully!';
		echo json_encode(array('sucess'=>'1', 'weblink'=>$weblink));
		exit();
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="preview_linkibook"){
		$success = true;
		$weblink = '';
		if(empty($_POST['book_title'])){
			echo json_encode(array('error'=>'Please enter title'));
			exit();
		}
		if(empty($_POST['book_subtitle'])){
			echo json_encode(array('error'=>'Please enter sub-title'));
			exit();
		}
		if(!isset($_POST['add_url'])){
			echo json_encode(array('error'=>'Please select the link(s) you would like to add to LinkiBook'));
			exit();
		}elseif(count($_POST['add_url'])==0) {
			echo json_encode(array('error'=>'Please select the link(s) you would like to add to LinkiBook'));
			exit();
		}

		$weblink = 'book_title='.urlencode($_POST['book_title']).'&book_subtitle='.urlencode($_POST['book_subtitle']);
		foreach ($_POST['add_url'] as $url) {
			$weblink .= '&url[]='.$url;
		}
		$weblink = WEB_ROOT.'links_print/index.php?preview_linkibook=1&'.$weblink;
		echo json_encode(array('sucess'=>'1', 'weblink'=>$weblink));
		exit();
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="delete_linkibook"){
		$success = true;
		$weblink = '';
		if(!isset($_POST['book'])){
			echo 'Please select the link(s) you would like to add to LinkiBook';
			exit();
		}elseif(count($_POST['book'])==0) {
			echo 'Please select the link(s) you would like to add to LinkiBook';
			exit();
		}
		$co->query_delete('linkibooks', array('id'=>implode(',', $_POST['book'])),'id IN (:id)');
		$co->query_delete('linkibook_urls', array('id'=>implode(',', $_POST['book'])),'linkibook_id IN (:id)');
		echo 'success';
		exit();
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="register"){								
		//$_POST['salutation'] = trim($_POST['salutation']);
		//$_POST['salutation'] = strip_tags($_POST['salutation']);
		
		$_POST['email_id'] = trim($_POST['email_id']);
		$_POST['email_id'] = strip_tags($_POST['email_id']);
		
		/*$_POST['email_domain'] = trim($_POST['email_domain']);
		$_POST['email_domain'] = strip_tags($_POST['email_domain']);
		*/
		$_POST['password'] = trim($_POST['password']);
		$_POST['password'] = strip_tags($_POST['password']);
		
		//$_POST['first_name'] = trim($_POST['first_name']);
		//$_POST['first_name'] = strip_tags($_POST['first_name']);
		
		//$_POST['last_name'] = trim($_POST['last_name']);
		//$_POST['last_name'] = strip_tags($_POST['last_name']);
		
		$success=true;
		$msg = '';
		$redirect_to = '';
		/*if($_POST['salutation']==""){
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
		}*/
			
		//check if email_id empty
		if($_POST['email_id']==""){
			/*$co->setmessage("error", "Please enter email");*/
			$msg .= "Please enter email <br/>";
			$success=false;
		}
		if(isset($_POST['email_id']) and $_POST['email_id']!=''){
			$email =  $_POST['email_id'];
			$find = stripos($email, '@');
			$domain_name = substr($_POST['email_id'], $find);
			$domain_name_array = array('@hotmail.com', '@yahoo.com', '@gmail.com', '@Hotmail.com', '@Yahoo.com', '@Gmail.com');
			if($co->is_emailExists($email)){
				$msg .= "If you have an account with us, check your inbox or spam folder to find the email from LinkiBag and follow the confirmation instructions. If you do not have an account you will find our instructions for free account set up. <a href='index.php?p=forget-password'> Click here</a> to receive password reset instructions. <br/>";
				
				//$msg .= "The email address you have entered is already registered. If you've forgotten your password, <a href='index.php?p=forget-password'>Click here</a> to receive an email with password reset instructions. <br/>";
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
			$msg .= "Please enter password <br/>";
			$success=false;
		}
		/*
		if($_POST['reapt_pass']==""){
			$co->setmessage("error", "Please enter Repeat password");
			$success=false;
		} else{
			if($_POST['password']!=$_POST['reapt_pass']){
				$co->setmessage("error", "password and confirm password must be same!");
				$success=false;
			}
		}
		*/
		if(isset($_POST['password']) and $_POST['password']!=''){
			$password =  strlen($_POST['password']);
			if ($password<9){
				$msg .= "password is not a valid at least 9 of the characters";
				$success=false;
			}
			$containsLetter  = preg_match('/[a-zA-Z]/', $_POST['password']);
			$containsDigit   = preg_match('/\d/', $_POST['password']);
			//$containswhitespace = preg_match('/ /', $_POST['password']);

			if (!$containsLetter or !$containsDigit) {
				$msg .= "password must contain at least one letter and one number and no spaces";
				$success=false;
			}	
		}
		 
		if(!isset($_POST['terms_and_conditions']) or (isset($_POST['terms_and_conditions']) and $_POST['terms_and_conditions'] == '')){
			$msg .= "Please selecting terms and conditions agreement";
			$success=false;
		}
		if(!isset($_POST['country']) or (isset($_POST['country']) and $_POST['country'] == '')){
			$msg .= "Please select country";
			$success=false;
		}
		if(!isset($_POST['country']) or (isset($_POST['country']) and $_POST['country'] == '')){
			$msg .= "Please select country";
			$success=false;
		}elseif($_POST['country'] != '1'){
			$msg .= "You are located outside of our service area. Our website and service provided via this website is exclusively for use by those individuals located in the United States.";
			$success=false;
		}
		//check if no error
		if($success==true){			
			$co->create_user($_POST, array());
			if(isset($_POST['request_id']) and $_POST['request_id'] > 0 and $_POST['request_code'] and $_POST['request_code'] != '' and $_POST['accept'] and $_POST['accept'] != ''){
				$redirect_to = 'index.php?p=login&request_id='.$_POST['request_id'].'&request_code='.$_POST['request_code'].'&accept='.$_POST['accept'];
				$redirect_to = "";
			}else{
				$redirect_to = "";

			}	
			/*$msg .= "Congratulations! You are almost done. To complete registration please click on the link that we just sent to your email address.";*/
			$msg .= "Success! In order to complete your registration, please click the confirmation link in the email that we have sent to you.";
		
			/*$redirect_to = "index.php?#free_singup";*/
			/*$redirect_to = "index.php";*/
			
			
			
		}

		echo json_encode(array('msg'=>$msg,'success'=>$success,'redirect_to'=>$redirect_to));
		exit();					
	}
	if(isset($_POST['form_id']) and $_POST['form_id']=="login"){
		$_POST['email_id'] = trim($_POST['email_id']);
		$_POST['email_id'] = strip_tags($_POST['email_id']);
		
		$_POST['password'] = trim($_POST['password']);
		$_POST['password'] = strip_tags($_POST['password']);				
		$remember = 0;		
		if(isset($_POST['remember']))		
		$remember = 1;
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
						$result = $co->query_first("select fr.request_id,u.email_id from friends_request fr, users u where fr.request_to=u.uid and fr.request_id=:id and fr.request_code=:code and fr.status='0' and u.email_id=:email", array('email'=>$_POST['email_id'], 'id'=>$_POST['request_id'], 'code'=>$_POST['request_code']));
						if((isset($result['request_id']) and $result['request_id'] > 0)){
							echo '<script language="javascript">window.location="index.php?p=friend_request&request_id='.$_POST['request_id'].'&request_code='.$_POST['request_code'].'&accept='.$_POST['accept'].'";</script>';
							exit();
						}
						
					}

					echo '<script language="javascript">window.location="index.php?p=dashboard";</script>';

					exit();

			}else{
				$user_login = $co->query_first("SELECT uid,status,verified FROM `users` WHERE `email_id`= :user and `decrypt_pass` = :pass LIMIT 1",array('user'=>$_POST['email_id'],'pass'=>md5($_POST['password'])));
				if(isset($user_login['uid']) and $user_login['uid'] > 0){
					if($user_login['verified'] == '0'){
						$co->setmessage("error", "If you have an account with us, check your inbox or spam folder to find the email from LinkiBag and follow the confirmation instructions. If you do not have an account you will find our instructions for free account set up. <a href='index.php?p=forget-password'> Click here</a> to receive password reset instructions.");
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
		//$_POST['email_id'] = trim($_POST['email_id']);
		//$_POST['email_id'] = strip_tags($_POST['email_id']);
		
		
		$_POST['salutation'] = trim($_POST['salutation']);
		$_POST['salutation'] = strip_tags($_POST['salutation']);
		
		$_POST['password'] = trim($_POST['password']);
		$_POST['password'] = strip_tags($_POST['password']);
		
		$_POST['first_name'] = trim($_POST['first_name']);
		$_POST['first_name'] = strip_tags($_POST['first_name']);
		
		$_POST['last_name'] = trim($_POST['last_name']);
		$_POST['last_name'] = strip_tags($_POST['last_name']);
		
		$success = true;
		if($_POST['first_name']=="" or $_POST['last_name']=="" or $_POST['country']=="" or $_POST['security_question']=="" or $_POST['security_answer']=="" or $_POST['subscribe']==""){
			$co->setmessage("error", "Please include all required information");
			$success=false;
		}
		if(isset($_POST['country']) and $_POST['country'] == 1){
			if($_POST['state']=="" or $_POST['zip_code']==""){
				$co->setmessage("error", "Please include all required information");
				$success=false;
			}
		}	
		
		if(isset($_POST['email_id']) and $_POST['email_id']!=''){
			$email =  $_POST['email_id'];
			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$co->setmessage("error", "Please use user@gmail.com format to update your profile");
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
		
		/*
		if(isset($_POST['password']) and $_POST['password']!=''){
			$password =  strlen($_POST['password']);
			if ($password<9){
				$co->setmessage("error", "password is not a valid at least 9 of the characters");
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
		*/
		if($_POST['password']!=""){
			if($current['pass'] != $_POST['password'] and $current['decrypt_pass'] != md5($_POST['password'])){
				$co->setmessage("error", "Please enter your correct password to update anything");
				$success=false;
			}else{
				if($_POST['password']!=$_POST['reapt_pass']){
					$co->setmessage("error", "Password and Confirm password must be same!");
					$success=false;
				}
			}
		}else{
			$co->setmessage("error", "Please enter your correct password to update anything");
			$success=false;
		}	
			
		
		if($success==true){		
			$up = array();
			//$up['email_id'] = $email;
			if(isset($_POST['password']) and $_POST['password']!=''){	
				$up['pass'] = $_POST['password'];
				$up['decrypt_pass'] = md5($_POST['password']);
			}
			$up['user_timezone'] = $_POST['user_timezone'];
			$up['updated'] = time();
			$co->query_update('users', $up, array('id'=>$current['uid']), 'uid=:id');
			unset($up);
			
			$up = array();
			if(isset($_POST['first_name']) and $_POST['first_name'] != '')
				$up['first_name'] = $_POST['first_name'];
			if(isset($_POST['middle_name']) and $_POST['middle_name'] != '')
				$up['middle_name'] = $_POST['middle_name'];
			if(isset($_POST['last_name']) and $_POST['last_name'] != '')
				$up['last_name'] = $_POST['last_name'];
			if(isset($_POST['salutation']) and $_POST['salutation'] != '')
				$up['salutation'] = $_POST['salutation'];
			if(isset($_POST['company_name']))
				$up['company_name'] = $_POST['company_name'];
			if(isset($_POST['security_question']) and $_POST['security_question'] != '')
				$up['security_question'] = $_POST['security_question'];
			if(isset($_POST['security_answer']) and $_POST['security_answer'] != '')
				$up['security_answer'] = $_POST['security_answer'];	
			if(isset($_POST['subscribe']) and $_POST['subscribe'] != '')
				$up['subscribe'] = $_POST['subscribe'];				
			if(isset($_POST['country']) and $_POST['country'] > 0)
				$up['country'] = $_POST['country'];
			if(isset($_POST['country']) and $_POST['country'] == 1){
				$up['state'] = $_POST['state'];
				$up['zip_code'] = $_POST['zip_code'];
			}else{
				$up['state'] = '';
				$up['zip_code'] = '';
			}
			if(isset($_POST['sign_me_for_email_filter']) and $_POST['sign_me_for_email_filter'] > 0)
				$up['sign_me_for_email_filter'] = $_POST['sign_me_for_email_filter'];
			else
				$up['sign_me_for_email_filter'] = '';

			
			if(isset($_FILES['profile_photo']['tmp_name']) and $_FILES['profile_photo']['tmp_name']!=""){			

				$folder = 'files/profile_photo/';

				$dest_path = $co->chk_filename($folder, $_FILES['profile_photo']['name']);

				$co->uploadimage($_FILES['profile_photo'], $dest_path, 'no', 1921, 287);

				$up['profile_photo'] = substr($dest_path, 0);	
				
			}
			
			
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
			}else{
				if(!preg_match("~^(?:f|ht)tps?://~i", $url)) {
					$temp_url = $url;
					$url = "http://" . $temp_url;
					$url2 = "https://" . $temp_url;
				}
				

				/*
				$url_headers = @get_headers($url);
				$url2_headers = @get_headers($url2);
				if(strpos($url_headers[0],'200')===false and strpos($url2_headers[0],'200')===false) {
				    $co->setmessage("error", "You are saving an invalid URL. This website ".$url." is not accessible. Would you like to revise it?");
					$success=false;
				}*/
				if(!empty($url2) AND !$co->urlExists($url2)){
					$co->setmessage("error", "You are saving an invalid URL. This website ".$url2." is not accessible. Would you like to revise it?");
					$success=false;
				}else if(!$co->urlExists($url)){
					$co->setmessage("error", "You are saving an invalid URL. This website ".$url." is not accessible. Would you like to revise it?");
					$success=false;
				}else{
					//virus total
					$ch = curl_init();

					$timeout = 0; // set to zero for no timeout	
					/*initial testing api key 8e6a84d54bc1d473138d806c2b7946b96f28d82d2b8c489a94c62c690235feda */	
					$myHITurl = "https://www.virustotal.com/vtapi/v2/url/report?apikey=e85cac3f3f8fe3d0dc8163c63a89b1ecfa26231aef16ab8d26f2326b62434ead&resource=".$url;

					curl_setopt ($ch, CURLOPT_URL, $myHITurl);

					curl_setopt ($ch, CURLOPT_HEADER, 0);

					curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

					curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

					$file_contents = curl_exec($ch);

					$curl_error = curl_errno($ch);

					curl_close($ch);

					//dump output of api if you want during test

					//echo "$file_contents";

					// lets extract data from output for display to user and for updating databse

					$file_contents = (json_decode($file_contents, true));
					//end code
					if($file_contents['response_code'] != 1){
						$co->setmessage("error", "This webpage has virus. Please check it and try again");
						$success=false;
					}	
				}
			}	
			/*if(!filter_var($url, FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED) === false) {
				$co->setmessage("error", "Please enter valid url");
				$success=false;
			}*/	
		}

		if($_POST['url_cat'] == ''){
			$co->setmessage("error", "Please select folder");
			$success=false;
		}
		if($_POST['share_type'] == ''){
			$co->setmessage("error", "Please select share type");
			$success=false;
		}
		if($_POST['public_cat'] == ''){
			$co->setmessage("error", "Please select category");
			$success=false;
		}
		$current = $co->getcurrentuser_profile();	
		if($success == true){
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
			$up['share_type'] = $_POST['share_type'];
			$up['public_cat'] = $_POST['public_cat'];
			//for pending approval
			if($_POST['share_type'] == 3 or $_POST['public_cat'] > 8){
				$up['add_to_search_page'] = 1;
				$up['search_page_status'] = 0;
			}
			$up['ip_address'] = 123456;
			
			$video_link_id = '';
			$video_web = '';
			$is_video_link = 0;
			$video_embed_code = '';
			if($youtube_id = $co->video_id_from_url($url, 'youtube')){
				$video_link_id = $youtube_id;		
				$video_web = 'youtube';		
				$is_video_link = 1;
				$video_embed_code = '<iframe width="100%" height="315" src="https://www.youtube.com/embed/'.$youtube_id.'" frameborder="0" allowfullscreen></iframe>';				
			}else if($dailymotion_id = $co->video_id_from_url($url, 'dailymotion')){
				$video_link_id = $dailymotion_id;		
				$video_web = 'dailymotion';		
				$is_video_link = 1;		
				$video_embed_code = '
				<iframe frameborder="0" width="100%" height="315" src="//www.dailymotion.com/embed/video/'.$video_link_id.'" allowfullscreen></iframe>';				
			}
			
			$get_video_web = $co->query_first("SELECT web_id FROM `video_webs` WHERE `web_name`= :name and `status` = :st LIMIT 1",array('name'=>$video_web,'st'=>1));
			if(isset($get_video_web['web_id']) and $get_video_web['web_id'] > 0)
				$video_web = $get_video_web['web_id'];	
			
			$up['is_video_link'] = $is_video_link;
			$up['video_id'] = $video_link_id;
			$up['video_web'] = $video_web;
			$up['video_embed_code'] = $video_embed_code;
			
			
			
			
			if(isset($_POST['update_url']) and $_POST['update_url']=="update-url"){
				$up['updated_time'] = time();
				$up['updated_date'] = date('Y-m-d');
				$co->query_update('user_urls', $up, array('id'=>$current['uid']), 'url_id=:id');				
			}else{
				if($current['uid']>0){
					$up['uid'] = $current['uid'];
					$up['created_time'] = time();
					$up['updated_time'] = time();
					$up['created_date'] = date('Y-m-d');
					$up['updated_date'] = date('Y-m-d');
					$up['permalink'] = $file_contents['permalink'];
					$up['scan_id'] = $file_contents['scan_id'];
					$up['total_scans'] = $file_contents['total'];
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
			$new_val['share_type_change'] = $_POST['share_type'];
			$new_val['public_cat_change'] = $_POST['public_cat'];
			if($_POST['share_type'] == 3 or $_POST['public_cat'] > 8){
				$new_val['add_to_search_page_change'] = 1;
				$new_val['search_page_status_change'] = 0;
			}
			$new_val['like_status'] = 1;
			$co->query_insert('user_shared_urls', $new_val);
			unset($new_val);		
			
			//$co->setmessage("status", "Your information submitted successfully");
			echo '<script type="text/javascript">window.location.href="index.php?p=dashboard"</script>';
			exit();	
		}		
	}

	if(isset($_POST['form_id']) and $_POST['form_id']=="url_submission_update"){
		$_POST['url_desc'] = trim($_POST['url_desc']);
		$_POST['url_desc'] = strip_tags($_POST['url_desc']);
		
		$success = true;
		$current = $co->getcurrentuser_profile();
		$error = '';
		if($success == true){
			$cond = array();
			$sql = "SELECT p.first_name,us.shared_time,us.shared_url_id,c.created_time,c.cname,c.cid,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id FROM `user_urls` ur, users u, user_shared_urls us, user_public_category c, profile p WHERE p.uid=u.uid and us.uid=u.uid and ur.url_id=us.url_id and us.url_cat=ur.url_cat and ur.public_cat=c.cid and ur.status='1' and c.status='1' and us.shared_url_id=:id and us.uid=:uid";
			$cond = array('id'=>$_POST['id'],'uid'=>$current['uid']);
			$cat_info = $co->query_first($sql, $cond);
			if(isset($_POST['id']) and $_POST['id'] > 0 and isset($cat_info['url_id']) and $cat_info['url_id'] > 0){
				$up_val = array();
				$up_val['url_desc'] = $_POST['url_desc'];
				$up_val['updated_time'] = time();				
				$up_val['updated_date'] = date('Y-m-d');				
				$co->query_update('user_urls', $up_val, array('id'=>$cat_info['url_id'], 'uid'=>$current['uid']), 'url_id=:id and uid=:uid');
				unset($up_val);
				$id = $_POST['id'];
			}	
			
			$cat_info = $co->query_first($sql, $cond);
			if(isset($_POST['url_desc']) and $_POST['url_desc'] != ''){
				$j = 1;
				$page_link_option = '';
				
				$option = '';
				if(isset($_POST['id']) and $_POST['id'] > 0){
					$total_url_in_cat = $co->query_first("select COUNT(url_id) as total from user_urls where public_cat=:cat and uid=:uid",array('cat'=>$cat_info['cid'],'uid'=>$current['uid'])); 
					
					$new_row = '
						<div class="web-resources-list-links-single-body">
						  <div class="col-md-12">
							<div class="row web-resources-list-row-2">
								<div class="col-md-4">
									<p class="text-gray"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="'.$cat_info['shared_url_id'].'"></span> &nbsp; <a href="'.$cat_info['url_value'].'" target="_blank">'.$cat_info['url_value'].'</a></p>
								</div>
								<div class="col-md-4">
									<p class="text-blue"><a href="javascript: void(0);" onclick="load_edit_frm('.$cat_info['shared_url_id'].', \'web_resource_list_links\')"><i class="fa fa-pencil"></i></a> '.$cat_info['url_desc'].'</p>
								</div>
								<div class="col-md-3">
									<p><i class="fa fa-pencil"></i> Cool Link</p>
								</div>
								<div class="col-md-1 padding-none">
									<p>'.date('M d, Y', $cat_info['shared_time']).'</p>
								</div>
								
							</div>
						  </div>
						</div>
				  
					';	
					/*$msg = 'Linkibook updated successfully';	*/
					$msg = 'Updated successfully!';	
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


	if(isset($_POST['form_id']) and $_POST['form_id']=="url_submission_comments"){
		$_POST['url_desc'] = trim($_POST['url_desc']);
		$_POST['url_desc'] = strip_tags($_POST['url_desc']);
		
		$success = true;
		$current = $co->getcurrentuser_profile();
		$error = '';
		if($success == true){
			$cond = array();
			$sql = "SELECT p.first_name,us.uid,us.shared_time,us.shared_url_id,c.created_time,c.cname,c.cid,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id FROM `user_urls` ur, users u, user_shared_urls us, user_public_category c, profile p WHERE p.uid=u.uid and us.uid=u.uid and ur.url_id=us.url_id and us.url_cat=ur.url_cat and ur.public_cat=c.cid and ur.status='1' and c.status='1' and us.shared_url_id=:id and us.uid=:uid";
			$cond = array('id'=>$_POST['id'],'uid'=>$current['uid']);
			$cat_info = $co->query_first($sql, $cond);
			if(isset($_POST['id']) and $_POST['id'] > 0 and isset($cat_info['url_id']) and $cat_info['url_id'] > 0){
				$chk_already_comment = $co->query_first("SELECT * from `user_public_category_comments` WHERE uid=:uid and url_id=:id", array('id'=>$cat_info['url_id'], 'uid'=>$current['uid']));

				$up_val = array();
				if(isset($_POST['comment']) and $_POST['comment'] != '')
					$up_val['comment'] = $_POST['comment'];
				if(isset($_POST['notes']) and $_POST['notes'] != '')
					$up_val['notes'] = $_POST['notes'];
				$up_val['updated_time'] = time();				
				$up_val['updated_date'] = date('Y-m-d');
				if(isset($chk_already_comment['comment_id']) and $chk_already_comment['comment_id'] > 0){
					$co->query_update('user_public_category_comments', $up_val, array('comment_id'=>$chk_already_comment['comment_id'], 'id'=>$cat_info['url_id'], 'uid'=>$current['uid']), 'url_id=:id and uid=:uid and comment_id=:comment_id');
					$msg = 'Updated successfully!';					
				}else{
					$up_val['url_id'] = $cat_info['url_id'];
					$up_val['uid'] = $current['uid'];				
					$up_val['created_date'] = date('Y-m-d');
					$up_val['created_time'] = time();
					$co->query_insert('user_public_category_comments', $up_val);
					$msg = 'Added successfully!';
				}	
				unset($up_val);
				$id = $_POST['id'];
			}	
			$chk_already_comment = $co->query_first("SELECT * from `user_public_category_comments` WHERE uid=:uid and url_id=:id", array('id'=>$cat_info['url_id'], 'uid'=>$current['uid']));

			
			$cat_info = $co->query_first($sql, $cond);
			if((isset($_POST['comment']) and $_POST['comment'] != '') OR (isset($_POST['notes']) and $_POST['notes'] != '')){
				$j = 1;
				$page_link_option = '';
				
				$option = '';
				if(isset($_POST['id']) and $_POST['id'] > 0){
					$total_url_in_cat = $co->query_first("select COUNT(url_id) as total from user_urls where public_cat=:cat and uid=:uid",array('cat'=>$cat_info['cid'],'uid'=>$current['uid'])); 
					
					$new_row = '
						<div class="web-resources-list-links-single-body">
						  <div class="col-md-12">
							<div class="row web-resources-list-row-2">
								<div class="col-md-4">
									<p class="text-gray"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="'.$cat_info['shared_url_id'].'"></span> &nbsp; <a href="'.$cat_info['url_value'].'" target="_blank">'.$cat_info['url_value'].'</a></p>
								</div>
								<div class="col-md-4">
									<p class="text-blue">';
									if(isset($current['uid']) and $current['uid'] == $cat_info['uid']){
						$new_row .=			
									'<a href="javascript: void(0);" onclick="load_edit_frm('.$cat_info['shared_url_id'].', \'web_resource_list_links_comment\')"><i class="fa fa-pencil"></i></a> ';
								}	
								if(isset($chk_already_comment['comment']) and $chk_already_comment['comment'] != ''){
									$new_row .= $chk_already_comment['comment'];
								}else{
								 	$new_row .= $cat_info['url_desc'];
								}

						$new_row .=	'</p>
								</div>
								<div class="col-md-3">
									<p>';

								if(isset($current['uid']) and $current['uid'] == $cat_info['uid']){			
								$new_row .=			
									'<a href="javascript: void(0);" onclick="load_edit_frm('.$cat_info['shared_url_id'].', \'web_resource_list_links_notes\')"><i class="fa fa-pencil"></i></a> ';
								}	
								if(isset($chk_already_comment['notes']) and $chk_already_comment['notes'] != ''){
									$new_row .= $chk_already_comment['notes'];
								}	

						$new_row .=	'</p>
								</div>
								<div class="col-md-1 padding-none">
									<p>'.date('M d, Y', $cat_info['shared_time']).'</p>
								</div>
								
							</div>
						  </div>
						</div>
				  
					';	
						
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
				$co->setmessage("error", "Please use user@gmail.com format to contact us");
				$success=false;
			}	
		}	
		if($_POST['phone']==""){
			$co->setmessage("error", "Please enter phone number");
			$success=false;
		}
		/*if($_POST['company_name']==""){
			$co->setmessage("error", "Please enter company/institutional name");
			$success=false;
		}*/
		
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
		if(isset($_POST['type_of_inquiry']) AND $_POST['type_of_inquiry'] == 'Information Security Product Listing'){
			if(!isset($_POST['product_listing_type'])){
				$co->setmessage("error", "Please choose at least one type of product");
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
			
			$up = array();
			$up['first_name'] = $first_name;
			$up['last_name'] = $last_name;
			$up['email_id'] = $email;
			$up['message'] = $message;
			$up['company_name'] = $company_name;
			$up['phone'] = $phone;
			$up['inquiry_about'] = $type_of_inquiry;
			
			if(isset($_POST['type_of_inquiry']) AND $_POST['type_of_inquiry'] == 'General Inquiries')
				$up['general_inquiry_type'] = $_POST['general_enquiry'];
			if(isset($_POST['type_of_inquiry']) AND $_POST['type_of_inquiry'] == 'Existing Account'){
				$up['existing_acc_type'] = $_POST['existing_account'];
				$up['exitsting_acc_no'] = $_POST['exit_acc_no'];
			}
			if(isset($_POST['type_of_inquiry']) AND $_POST['type_of_inquiry'] == 'Information Security Product Listing'){
				$up['product_listing_type'] = $_POST['product_listing_type'];
			}
			
			$up['created'] = time();
			$up['updated'] = time();
			$up['status'] = 1;
			$co->query_insert('contact_info', $up);
			unset($up);
			
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
		if(isset($_POST['security_ans'])){
			if(empty($_POST['security_ans'])){
				$co->setmessage("error", "Please enter security answer");
				$success=false;
			}else{
				if((isset($row['uid']) and $row['uid']>0)){
					$profile = $co->query_first("SELECT * FROM `profile` WHERE uid=:uid", array('uid'=>$row['uid']));
					if($_POST['security_ans'] != $profile['security_answer']){
						$co->setmessage("error", "You entered wrong security answer");
						$success=false;	
					}
				}
				
			}
		}
		if($_POST['user_pass']==""){
			$co->setmessage("error", "Please enter password");
			$success=false;
		}else{
			$password =  strlen($_POST['user_pass']);
			if ($password<9){
				$co->setmessage("error", "password is not a valid at least 9 of the characters");
				$success=false;
			}
			$containsLetter  = preg_match('/[a-zA-Z]/', $_POST['user_pass']);
			$containsDigit   = preg_match('/\d/', $_POST['user_pass']);
			//$containswhitespace = preg_match('/ /', $_POST['user_pass']);

			if (!$containsLetter or !$containsDigit) {
				$co->setmessage("error", "Password must contain at least one letter and one number and no spaces");
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
						$co->setmessage("status", "You have successfully changed your password.");
						// Now you can login using same values
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
			//$co->setmessage("status", "Thanks! Your password has been sent to your email address successfully! If you did not receive an email, check your Spam or Junk email folders.");
			$co->setmessage("status", "Thanks! if you provided a valid email address you will receive a password reset instructions. If you don't receive an email, please check your spam folder.");
			//echo '<script language="javascript">window.location="index.php";</script>';
			//$_POST = array();
		}		
		else 
		{
			$co->setmessage("error", "No account found with that email address. Please check email address below and try again. To create a new account, visit the Free Signup page.");
		}
	}	
	if(isset($_POST['form_id']) and $_POST['form_id']=="reset_email"){
		$current = $co->getcurrentuser_profile();
		$success=true;
		if($_POST['old_user_email']==""){
			$co->setmessage("error", "Please enter old email address");
			$success=false;
		}else{
			if($_POST['code'] == ''){
				$co->setmessage("error", "Something going to wrong");
				$success=false;
			}else{
				$username = trim($_POST['old_user_email']);
				$sql = "SELECT * FROM `users` WHERE uid=:user and `email_unique_path`=:code and verified='1' and status='1' and email_id=:email";
				$row= $co->row($sql, array("user"=>$current['uid'], "code"=>$_POST['code'], "email"=>$username));
				if(!(isset($row['uid']) and $row['uid']>0)){
					$co->setmessage("error", "You are entered invalid email address, please enter the email you used in your LinkiBag profile.");
					$success=false;	
				}
			}		
		}
		if($_POST['new_user_email']==""){
			$co->setmessage("error", "Please enter new email address");
			$success=false;
		}
		if(isset($_POST['new_user_email']) and $_POST['new_user_email']!=''){
			$email =  $_POST['new_user_email'];
			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$co->setmessage("error", "Please use user@gmail.com format to reset your Email Address");
				$success=false;
			}
			//$eamil_exists = $co->is_userExists_edit($email, $current['uid']);
			$eamil_exists = $co->is_userExists($email);
			if(isset($eamil_exists) and $eamil_exists!=''){
				$co->setmessage("error", "$email is already existed");
				$success=false;
			}
			
			if($_POST['new_user_email'] == $_POST['old_user_email']){
				$co->setmessage("error", "New email address does not same with old email address, try to different!");
				$success=false;
			}
		}
		
		if($_POST['old_pass']==""){
			$co->setmessage("error", "Please enter password");
			$success=false;
		}else{
			if(md5($_POST['old_pass'])!=$current['decrypt_pass']){
				$co->setmessage("error", "Please enter valid password");
				$success=false;
			}
		}
		
		
		if($success==true){
			if($_POST['new_user_email'] != '' and $_POST['code']!= '' and $_POST['old_user_email'] != ''){
				if(isset($row['uid']) and $row['uid']>0){
					$limit_time = $row['reset_email_time'] + (2 * 60 * 60);
					$present_time = time();
					if($present_time < $limit_time){
						$up_user = array();
						$up_user['email_id'] = $_POST['new_user_email'];	
						$up_user['reset_email_created'] = time();
						$co->query_update('users', $up_user, array('uid'=>$row['uid']), 'uid=:uid');
						unset($up_user);
						$co->setmessage("status", "You have successfully changed your email id. Now you can login using new email address");
						echo '<script language="javascript">window.location="logout.php";</script>';
						exit();
					}else{
						$co->setmessage("error", "Time expired to change your email address now. Please send another request");
						//echo '<script language="javascript">window.location="index.php";</script>';
						//exit();
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
	if(isset($_POST['form_id']) and $_POST['form_id']=="send_friend_request"){		
		$success = true;
		$current = $co->getcurrentuser_profile();
		
		if(isset($_POST['in_db']) and $_POST['in_db']=='no'){
			if($_POST['email_ids'] == ''){
				$co->setmessage("error", "Please enter email name");
				$success=false;			
			}else{
				$emails_ids = explode(',', $_POST['email_ids']);
				if(isset($emails_ids) and count($emails_ids) > 5){
					$co->setmessage("error", "Sorry, you can send only upto 5 request at a time.");
					$success=false;
				}else{	
					 foreach($emails_ids as $email_ids){
						$result['uid'] = 0;
						$email_ids = trim($email_ids);
						$email_ids = strip_tags($email_ids);
						$result = $co->query_first("SELECT uid,remove_profile FROM `users` WHERE email_id=:id",array('id'=>$email_ids));
						$already_send_request = $co->query_first("SELECT COUNT(request_id) as total FROM `friends_request` WHERE request_by=:uid and request_to=0 and status=0 and request_email=:uid2",array('uid'=>$current['uid'],'uid2'=>$email_ids)); 
						if($result['uid'] > 0){
							$chk_already_your_friend = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:id and fid=:fid and status=1",array('id'=>$current['uid'],'fid'=>$result['uid']));		
						}
						
						if(filter_var($email_ids, FILTER_VALIDATE_EMAIL) === false){
							$co->setmessage("error", "Please use user@gmail.com format to send your invite");
							$success=false;
							break;
						}
						if(isset($already_send_request['total']) and $already_send_request['total'] >= 3){
							$co->setmessage("error", "You extended maximum number of attempts to invite the following user. You send maximum of 3 invites. User name: ".$email_ids);
							$success=false;
							break;
						}
						if(isset($result['uid']) and $result['remove_profile']!=0){
							$co->setmessage("error", "You can not send friend request to $email_ids.");
							$success=false;
							break;
						}
						
						if(isset($result['uid']) and $result['uid'] == $current['uid']){
							$co->setmessage("error", "You can not send friend request yourself");
							$success=false;
							break;
						}
						if(isset($chk_already_your_friend['friend_id']) and $chk_already_your_friend['friend_id'] > 0){
							$co->setmessage("error", "This user is already your friend");
							$success=false;
							break;
						}	

						
					}
				}	
			}
			if(empty($_POST['description'])){
				$_POST['description'] = 'I would like to invite you to join Linkibag.';			
			}
			if($_POST['description'] == ''){
				$co->setmessage("error", "Please enter message");
				$success=false;			
			}
			
		}							
		if($success==true){				
			foreach($emails_ids as $email_ids){
				$result['uid'] = 0;
				$result = $co->query_first("SELECT uid,remove_profile FROM `users` WHERE email_id=:id",array('id'=>$email_ids));
				$uid = $result['uid'];
				$reset_code = $co->generate_path(18);
				$up = array();									
				$up['request_by'] = $current['uid'];									
				$up['request_to'] = (($uid > 0) ? $uid : trim($email_ids));
				$up['request_code'] = $reset_code;
				$up['request_email'] = trim($email_ids);
				// check user is linkibag
				if(isset($result['uid']) and $result['uid'] > 0)
					$_POST['description'] = 'LinkiBag user '.$current['email_id'].' invites you to join LinkiBag. How exciting! You both are members of LinkiBag! Add '.$current['email_id'].' to your friends list today to share your links.';

				$up['description'] = $_POST['description'];
				$up['status'] = 0;
				$up['request_time'] = time();									
				$request_id = $co->query_insert('friends_request', $up);									
				unset($up);	
				$get_email_id = $co->query_first("SELECT request_id FROM `friends_request` WHERE request_email=:mail and status=0",array('mail'=>trim($email_ids)));
				if(isset($get_email_id['request_id']) and $get_email_id['request_id'] > 0){
					$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:uid and fid=:fid and status=0 and request_id=:id",array('uid'=>$current['uid'],'fid'=>$uid,'id'=>$get_email_id['request_id']));
					if(!(isset($already_data_in_user_friends['friend_id']) and $already_data_in_user_friends['friend_id'] > 0)){
						$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:uid and fid=:fid and status=0",array('uid'=>$current['uid'],'fid'=>$uid));	
					}
					if(!(isset($already_data_in_user_friends['friend_id']) and $already_data_in_user_friends['friend_id'] > 0)){
						$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:fid and fid=:uid and status=0",array('uid'=>$current['uid'],'fid'=>$uid));
					}	
					/*if(!(isset($already_data_in_user_friends['friend_id']) and $already_data_in_user_friends['friend_id'] > 0)){*/
						for($incr=0;$incr<=1;$incr++){
							$up = array();									
							$up['request_id'] = $request_id;									
							if($incr == 1){
								$up['uid'] = $uid;
								$up['fid'] = $current['uid'];
							}else{
								$up['uid'] = $current['uid'];
								$up['fid'] = $uid;									
							}
							$up['fgroup'] = 0;
							$up['status'] = 0;
							$up['date'] = date('Y-m-d');
							$up['created'] = time();
							$up['updated'] = time();
							$friend_id = $co->query_insert('user_friends', $up);
							unset($up);	
						}	
					/*}*/
				}	
				if(isset($result['uid']) and $result['uid'] > 0){
					
						$to = trim($email_ids);
						$subject = 'Friend request at Linkibag';
						$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
						//$verified_link = $co->get_bit_ly_link($verified_link);			
						//$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' wants to be your friend on Linkibag. <br /><br/><a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=yes">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=no">Declined</a></p> <br /><br />Cheers<br />Team Linkibag';
						
						$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' '.$_POST['description'].' <br /><br/><a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">Declined</a></p> <br /><br />Cheers<br />Team Linkibag';	
						$from = 'info@linkibag.com';
						$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n".'<html xmlns="http://www.w3.org/1999/xhtml">'."\n".'<head>'."\n".'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n".'<title>Confirm your account</title>'."\n".'<style type="text/css">body{margin:0;padding:0;min-width:100%!important}.content{color:#3e3e3e;font-family:arial;max-width:600px;text-align:center;width:100%}.btn{background:#d76b00 none repeat scroll 0 0;border-radius:55px;color:#fff;display:inline-block;font-size:22px;font-weight:bold;margin:32px 0;padding:12px 43px;text-decoration:none}.btn-decline{background:#ccc none repeat scroll 0 0;border-radius:55px;color:#fff;display:inline-block;font-size:22px;font-weight:bold;margin:32px 0;padding:12px 43px;text-decoration:none}h1{margin:0}.big{color:#3e3e3e;font-size:22px;margin-top:4px}.content p{color:#3e3e3e}.content p a{color:#3e3e3e;text-decoration:none}</style>'."\n".'</head>'."\n".'<body bgcolor="#ffffff">'."\n".'<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">'."\n".'<tr>'."\n".'<td>'."\n".'<table class="content" align="center" cellpadding="0" cellspacing="0" border="0">'."\n".'<tr>'."\n".'<td style="text-align:left;padding:30px 0 40px">'."\n".'<img src="http://linkibag.net/PTest25x/linkibag/images/email-logo/linkibag-logo.png">'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<h1>Friend Rquest At LinkiBag.</h1>'."\n".'<p class="big">Click on link below to Accept Or Decline.</p>'."\n".'<p>'.$_POST['description'].'</p>'."\n".'<a class="btn" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Accept</a> <a class="btn-decline" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">Decline</a>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<p>This message was send to '.$to.'. if you have questions or complaints, please <a href="http://linkibag.net/PTest25x/linkibag/index.php?p=contact-us"><b>contact us.</b></a> We’re here to help.</p>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<p><a href="http://linkibag.net/PTest25x/linkibag/index.php?p=terms-of-use">Terms of Use</a> &nbsp; | &nbsp; <a href="http://linkibag.net/PTest25x/linkibag/index.php?p=terms-of-use">Privacy Policy</a></p>'."\n".'</td>'."\n".'</tr>'."\n".'</table>'."\n".'</td>'."\n".'</tr>'."\n".'</table>'."\n".'</body>'."\n".'</html>';					
						$co->send_email($to, $subject, $message, $from);
						
				}else if(!(isset($result['uid']) and $result['uid'] > 0)){
					$user = $co->getcurrentuser_profile();
					$to = trim($email_ids);
					$subject = 'Friend request at Linkibag';
					$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
					//$verified_link = $co->get_bit_ly_link($verified_link);			
					//$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' wants to be your friend on Linkibag.Please join LinkiBag. <br /><br/></p> <a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=yes">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=no">Declined</a><br /><br />Cheers<br />Team Linkibag';	
					$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' '.$_POST['description'] .'Please join LinkiBag. <br /><br/></p> <a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">Declined</a><br /><br />Cheers<br />Team Linkibag';		
					$from = 'info@linkibag.com';
					$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n".'<title>Linkibag Invitation</title>'."\n".'<style type="text/css">@import url("https://fonts.googleapis.com/css?family=Lora");body{margin:0;padding:0;min-width:100%!important}.content{color:#3e3e3e;font-family:arial;max-width:600px;text-align:center;width:100%}.btn {background: #fff;border-radius: 0;color: gray!important;display: inline-block;font-size: 20px;font-weight: bold;margin: 0;padding: 6px;text-decoration: none;width: 275px;
}.btn-decline{background:#fff none repeat scroll 0 0;border-radius:0;color:gray!important;display:inline-block;font-size:20px;font-weight:bold;margin:16px 0 0;padding:6px;text-decoration:none;width:275px}h1{font-family:arial;margin:0;font-size:26px;line-height:38px;color:#353e4f}.top-line{font-size:14px;margin-top:20px}.big{font-family:"Lora",serif;color:#3e3e3e;font-size:20px;margin:38px 0 22px;line-height:30px;font-weight:bolder}.links{padding:41px 0 5px}.links a{color:#7F7F95!important;font-size:14px}.bottom-text{font-size:14px;line-height:25px;color:#000!important}.bottom-text a{text-decoration:underline!important;font-weight:600}.content p{color:#3e3e3e}.content p a{color:#3e3e3e;text-decoration:none}</style>
		'."\n".'</head>'."\n".'<body bgcolor="#ffffff">'."\n".'<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
		'."\n".'<tr>'."\n".'<td>'."\n".'<table class="content" align="center" cellpadding="0" cellspacing="0" border="0">'."\n".'<tr>'."\n".'<td style="text-align:left;padding:30px 0 40px">'."\n".'<img src="http://linkibag.net/PTest25x/linkibag/images/email-logo/linkibag-logo.png">'."\n".'<br>'."\n".'
		<p class="top-line">This message was sent by user '.$current['email_id'].' via <a target="_blank" href="http://www.linkibag.com" style="text-decoration: underline;">LinkiBag.com</a><p>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<h1>Hello '.$user['email_id'].'<br>'.$user['first_name'].''.$user['last_name'].'<br>invited you to join 
		<span style="color: #9c9696;font-weight: lighter;">LinkiBag.com</span> and to connect!</h1>'."\n".'
		<p class="big">Free. Easy. Why not?</p>'."\n".'
		<a class="btn" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Sign up for a free Account</a>'."\n".
		'<a class="btn-decline" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">I dont know this person</a>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'</td>'."\n".'</tr>'."\n".'
		<tr>'."\n".'<td>'."\n".'<p class="links">'."\n".'<a href="http://linkibag.net/PTest25x/linkibag/index.php?p=about_us">About Linkibag &nbsp; | &nbsp;</a>'."\n".'<a href="http://linkibag.net/PTest25x/linkibag/index.php?p=pages&id=8">Terms of Use &nbsp; | &nbsp; </a>'."\n".' <a href="http://linkibag.net/PTest25x/linkibag/index.php?p=pages&id=9">Privacy Policy</a>'."\n".'</p>'."\n".'
		<p class="bottom-text">'."\n".'<a href="#" style="color: #7F7F95!important;font-weight: normal;text-transform: capitalize !important;margin-right: 8px;text-decoration: none !important;">Unsubscribe</a> from all messages sent via LinkiBag by any LinkiBag users and from LinkiBag Inc. <br> <span style="color: #7F7F95!important;">LinkiBag Inc. 8926 N. Greenwood Ave, #220, Niles, IL 60714<span></p></td>'."\n".'</tr>'."\n".'</table>'."\n".'</td>'."\n".'</tr>'."\n".'</table>'."\n".'</body>'."\n".'</html>';					
				$co->send_email($to, $subject, $message, $from);
						
			}
				
			}
			if(isset($_SESSION['already_user']))
				unset($_SESSION['already_user']);
			echo ' trueQWERTYYRRR '.$request_id;	
			//$co->setmessage("status", "Success! Friend request has been sent.");
			exit();
		}
	}

	if(isset($_POST['form_id']) and $_POST['form_id']=="remove_friend_request"){		
		$success = true;
		$current = $co->getcurrentuser_profile();		
		if(isset($current['uid']) and isset($_POST['email_ids']) and isset($_POST['request_ids']) and $current['uid'] > 0 and $_POST['request_ids'] > 0 and !filter_var($_POST['email_ids'], FILTER_VALIDATE_EMAIL) === false){			
			$chk_friend_req = $co->query_first("SELECT request_id FROM `friends_request` WHERE request_by=:uid and request_id=:id",array('uid'=>$current['uid'],'id'=>$_POST['request_ids']));	
			if(isset($chk_friend_req['request_id']) and $chk_friend_req['request_id'] > 0){
				$co->query_delete('friends_request', array('uid'=>$current['uid'],'id'=>$_POST['request_ids'],'email'=>$_POST['email_ids']), 'request_by=:uid and request_id=:id and request_email=:email');
				$co->query_delete('user_friends', array('id'=>$_POST['request_ids']), 'request_id=:id');
				echo 'true';				
			}else{
				echo 'false';
			}	
		}else{
			echo 'false';
		}
		exit();
	}
	
	if(isset($_POST['form_id']) and $_POST['form_id']=="send_friend_request_bkup"){		
		$success = true;
		$current = $co->getcurrentuser_profile();
		
		if(isset($_POST['in_db']) and $_POST['in_db']=='yes'){
			$_POST['email_id'] = trim($_POST['email_id']);
			$_POST['email_id'] = strip_tags($_POST['email_id']);
			if($_POST['email_id']!=''){
				$result = $co->query_first("SELECT uid, remove_profile FROM `users` WHERE email_id=:id",array('id'=>$_POST['email_id']));	
				if(isset($result['uid']) and $result['uid'] > 0){	
					$already_send_request = $co->query_first("SELECT COUNT(request_id) as total FROM `friends_request` WHERE request_by=:uid and request_to=:uid2 and status=0",array('uid'=>$current['uid'],'uid2'=>$result['uid']));  
					$chk_already_your_friend = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:id and fid=:fid and status=1",array('id'=>$current['uid'],'fid'=>$result['uid']));	
				}else{
					$co->setmessage("error", 'This is not a LinkiBag user, You can invite it click here to <a href="index.php?p=search_friends">Invite</a>');
					$success=false;
								
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
					if(isset($result['uid']) and $result['remove_profile']!=0){
						$co->setmessage("error", "You can not send friend request to this user.");
						$success=false;
					}
					if(!isset($_SESSION['already_user']) OR (isset($_SESSION['already_user']) and $_SESSION['already_user'] != $_POST['email_id'])){
						if(!(isset($result['uid']) and $result['uid'] > 0)){
							if($result['remove_profile']){
								$_SESSION['already_user'] = $_POST['email_id'];
								//$co->setmessage("error", $_POST['email_id']." is not a LinkiBag user");
								//$co->setmessage("error", "already_user");
								$success=false;
								echo 'This is not a LinkiBag user, You can invite it';
								exit();
							}
						}
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
			if($_POST['description'] == ''){
				$co->setmessage("error", "Please enter message");
				$success=false;			
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
			if($_POST['description'] == ''){
				$co->setmessage("error", "Please enter message");
				$success=false;			
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
				$up['description'] = $_POST['description'];
				$up['status'] = 0;
				$up['request_time'] = time();									
				$request_id = $co->query_insert('friends_request', $up);									
				unset($up);	
				$get_email_id = $co->query_first("SELECT request_id FROM `friends_request` WHERE request_email=:mail and status=0",array('mail'=>$email_ids));
				if(isset($get_email_id['request_id']) and $get_email_id['request_id'] > 0){
					$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:uid and fid=:fid and status=0 and request_id=:id",array('uid'=>$current['uid'],'fid'=>$uid,'id'=>$get_email_id['request_id']));
					if(!(isset($already_data_in_user_friends['friend_id']) and $already_data_in_user_friends['friend_id'] > 0)){
						$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:uid and fid=:fid and status=0",array('uid'=>$current['uid'],'fid'=>$uid));	
					}
					if(!(isset($already_data_in_user_friends['friend_id']) and $already_data_in_user_friends['friend_id'] > 0)){
						$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:fid and fid=:uid and status=0",array('uid'=>$current['uid'],'fid'=>$uid));
					}	
					if(!(isset($already_data_in_user_friends['friend_id']) and $already_data_in_user_friends['friend_id'] > 0)){
						for($incr=0;$incr<=1;$incr++){
							$up = array();									
							$up['request_id'] = $request_id;									
							if($incr == 1){
								$up['uid'] = $uid;
								$up['fid'] = $current['uid'];
							}else{
								$up['uid'] = $current['uid'];
								$up['fid'] = $uid;									
							}
							$up['fgroup'] = 0;
							$up['status'] = 0;
							$up['date'] = date('Y-m-d');
							$up['created'] = time();
							$up['updated'] = time();
							$friend_id = $co->query_insert('user_friends', $up);
							unset($up);	
						}	
					}
				}	
				if(isset($_POST['in_db']) and $_POST['in_db']=='yes'){
					if(isset($result['uid']) and $result['uid'] > 0){
						$to = $email_ids;
						$subject = 'Friend request at Linkibag';
						$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
						//$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' wants to be your friend on Linkibag. <br /><br/><a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=yes">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=no">Declined</a></p> <br /><br />Cheers<br />Team Linkibag';
						$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' '.$_POST['description'].' <br /><br/><a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=yes">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=no">Declined</a></p> <br /><br />Cheers<br />Team Linkibag';	
						$from = 'info@linkibag.com';				
						$co->send_email($to, $subject, $message, $from);
					}	
				}else if(isset($_POST['in_db']) and $_POST['in_db']=='no'){
					$to = $email_ids;
					$subject = 'Friend request at Linkibag';
					$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
					//$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' wants to be your friend on Linkibag.Please join LinkiBag. <br /><br/></p> <a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=yes">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=no">Declined</a><br /><br />Cheers<br />Team Linkibag';	
					$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' '.$_POST['description'] .'Please join LinkiBag. <br /><br/></p> <a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=yes">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$verified_link.'&accept=no">Declined</a><br /><br />Cheers<br />Team Linkibag';		
					$from = 'info@linkibag.com';				
					$co->send_email($to, $subject, $message, $from);
						
				}
				
			}
			if(isset($_SESSION['already_user']))
				unset($_SESSION['already_user']);
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
		$group_options_select_list = '';
		/*for edit url message*/
		if(isset($_POST['url_msg_edit_for_share_links']) and $_POST['url_msg_edit_for_share_links'] == 1){
			if(isset($_POST['id']) and $_POST['id'] > 0){
				$urlpost = $co->query_first("SELECT p.first_name,us.shared_time,us.shared_url_id,us.url_msg,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id FROM `user_shared_urls` us INNER JOIN `user_urls` ur ON ur.url_id=us.url_id LEFT JOIN `users` u ON u.uid=us.uid LEFT JOIN `profile` p ON p.uid=us.uid WHERE us.url_cat=ur.url_cat and us.shared_url_id=:id and us.uid IN (:uid,-1) and us.sponsored_link>=0",array('uid'=>$current['uid'],'id'=>$_POST['id']));
					if(isset($urlpost['shared_url_id']) and $urlpost['shared_url_id'] > 0){
						if(empty($_POST['url_msg']) and isset($_POST['confirmempty']) and $_POST['confirmempty']==0){
							echo json_encode(array('sharingemptymsg'=>1));
							exit();
						}
						$up_val = array();
						$up_val['url_msg'] = $_POST['url_msg'];
						$up_val['url_msg_time'] = time();				
						$co->query_update('user_shared_urls', $up_val, array('id'=>$_POST['id'], 'uid'=>$current['uid']), 'shared_url_id=:id and uid IN (:uid,-1)');
						unset($up_val);	
						$urlpost = $co->query_first("SELECT p.first_name,us.shared_time,us.shared_url_id,us.url_msg,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id FROM `user_shared_urls` us INNER JOIN `user_urls` ur ON ur.url_id=us.url_id LEFT JOIN `users` u ON u.uid=us.uid LEFT JOIN `profile` p ON p.uid=us.uid WHERE us.url_cat=ur.url_cat and us.shared_url_id=:id and us.uid IN (:uid,-1) and us.sponsored_link>=0",array('uid'=>$current['uid'],'id'=>$_POST['id']));
						if($urlpost['url_msg'] != '')
							$url_message = $urlpost['url_msg'];
						else		
							$url_message = $urlpost['url_desc'];
						
						$url_message = $urlpost['url_msg'];
						
						$new_row = '
							<td style="width:45%">
								<a href="index.php?p=view_link&id='.$urlpost['shared_url_id'].'" target="_blank">'.$urlpost['url_value'].'</a>
							</td>
							<td style="width:45%; text-decoration: underline;">
								<a href="javascript: void(0);" onclick="load_edit_frm('.$urlpost['shared_url_id'].', \'add_sharing_link_url_msg\');">'.$url_message.'</a>
							</td>
							<td style="width:10%"><a href="javascript: void(0);" onclick="load_edit_frm('.$urlpost['shared_url_id'].', \'add_sharing_link_url_msg\');"><i class="fa fa-pencil" aria-hidden="true"></i></a>	
							</td>
							';	
							/*$msg = 'Message updated successfully';	*/
							$msg = 'Updated successfully!';	
							echo json_encode(array('new_row'=>$new_row,'msg'=>$msg,'id'=>$_POST['id'], 'option'=>'', 'success'=>$success,'page_link_option'=>''));
					}		
					exit();
			}else{
				exit();
			}	
		}	

		/* end code*/
		/*for print pdf urls*/
		if(isset($_POST['mark_as_print']) and $_POST['mark_as_print'] == 1){
			if(isset($_SESSION['urls_for_print_pdf']) and $_SESSION['urls_for_print_pdf']!= ''){
				//echo '<script type="text/javascript">window.location = "links_print/index.php?'.$_SESSION['urls_for_print_pdf'].'="</script>';
				//echo json_encode(array('URL'=>$_SESSION['urls_for_print_pdf']));
				echo $_SESSION['urls_for_print_pdf'];
				//unset($_SESSION['urls_for_print_pdf']);
				exit();	
			}else{
				exit();
			}	
		}	
		/* end code*/
		if(isset($_POST['email_to_friends']) and $_POST['email_to_friends'] == 1){
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
							$errors .= "<li>Please use user@gmail.com format to send your request!</li>";			
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
				
			}/* elseif(!is_array($_POST['shared_user'])){
				$success = false;
			}*/
			if(isset($_POST['group_name']) and $_POST['group_name'] != '' and isset($_POST['save_as_group']) and $_POST['save_as_group'] == 1){
				$already_exit_gp = $co->query_first("select group_id from groups WHERE uid=:id and group_name=:name",array('id'=>$current['uid'],'name'=>$_POST['group_name']));
				if($already_exit_gp['group_id'] > 0){
					$success = false;	
					$errors .= "<li>This group is already existed, create another!</li>";
				}
				if(!(isset($_POST['shared_user']) and count($_POST['shared_user']) > 0)){
					$errors .= "<li>Please enter email name</li>";
					$success=false;			
				}else{
					$emails_ids = $_POST['shared_user'];
					if(isset($emails_ids) and count($emails_ids) > 5){
						$errors .= "<li>Sorry, you can send only upto 5 request at a time.</li>";
						$success=false;
					}else{	
						foreach($emails_ids as $email_ids){
							$chk_already_your_friend = array();
							$result['uid'] = 0;
							$email_ids = trim($email_ids);
							$email_ids = strip_tags($email_ids);
							$result = $co->query_first("SELECT uid,remove_profile FROM `users` WHERE email_id=:id",array('id'=>$email_ids));
							$already_send_request = $co->query_first("SELECT COUNT(request_id) as total FROM `friends_request` WHERE request_by=:uid and request_to=0 and status=0 and request_email=:uid2",array('uid'=>$current['uid'],'uid2'=>$email_ids)); 
							if($result['uid'] > 0){
								$chk_already_your_friend = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:id and fid=:fid and status=1",array('id'=>$current['uid'],'fid'=>$result['uid']));		
							}
							
							if(filter_var($email_ids, FILTER_VALIDATE_EMAIL) === false){
								$errors .= "<li>Please use user@gmail.com format to send your request</li>";
								$success=false;
							}
							if(isset($already_send_request['total']) and $already_send_request['total'] == 5){
								$errors .= "<li>You can share maximum of 5 links with users who are not on your LinkiBag friends list. Connect with your friends today to continue sharing your links.<br /><br />We will not be able to share your link(s) with<br /><span class=\"text-danger\">".$email_ids."</span></li>";
								$success=false;
							}
							if(isset($result['uid']) and $result['remove_profile']!=0){
								$errors .= "<li>You can not send friend request to $email_ids.</li>";
								$success=false;
							}
							
							if(isset($result['uid']) and $result['uid'] == $current['uid']){
								$errors .= "<li>You can not send friend request yourself</li>";
								$success=false;								
							}
							if(isset($chk_already_your_friend['friend_id']) and $chk_already_your_friend['friend_id'] > 0){
								$errors .= "<li>This user ($email_ids) is already your friend</li>";
								$success=false;
							}	

							
						}
					}	
				}
			}else if(isset($_POST['group_name_updated']) and $_POST['group_name_updated'] != '' and isset($_POST['update_as_group']) and $_POST['update_as_group'] == 1){
				$already_exit_gp = $co->query_first("select group_id from groups WHERE uid=:id and group_name=:name and group_id !=:group_id",array('group_id'=>$_POST['friend_group'], 'id'=>$current['uid'],'name'=>$_POST['group_name_updated']));
				if($already_exit_gp['group_id'] > 0){
					$success = false;	
					$errors .= "<li>This group name is already existed, try another name!</li>";
				}
				if(!(isset($_POST['shared_user']) and count($_POST['shared_user']) > 0)){
					$errors .= "<li>Please enter email name</li>";
					$success=false;			
				}else{
					$emails_ids = $_POST['shared_user'];
					if(isset($emails_ids) and count($emails_ids) > 5){
						$errors .= "<li>Sorry, you can send only upto 5 request at a time.</li>";
						$success=false;
					}else{	
						foreach($emails_ids as $email_ids){
							$chk_already_your_friend = array();
							$result['uid'] = 0;
							$email_ids = trim($email_ids);
							$email_ids = strip_tags($email_ids);
							$result = $co->query_first("SELECT uid,remove_profile FROM `users` WHERE email_id=:id",array('id'=>$email_ids));
							$already_send_request = $co->query_first("SELECT COUNT(request_id) as total FROM `friends_request` WHERE request_by=:uid and request_to=0 and status=0 and request_email=:uid2",array('uid'=>$current['uid'],'uid2'=>$email_ids)); 
							if($result['uid'] > 0){
								$chk_already_your_friend = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:id and fid=:fid and status=1",array('id'=>$current['uid'],'fid'=>$result['uid']));		
							}
							
							if(filter_var($email_ids, FILTER_VALIDATE_EMAIL) === false){
								$errors .= "<li>Please use user@gmail.com format to send your request</li>";
								$success=false;
							}
							if(isset($already_send_request['total']) and $already_send_request['total'] == 5){
								$errors .= "<li>sorry you crossed the maxmimum send 5 request to ".$email_ids."</li>";
								$success=false;
							}
							if(isset($result['uid']) and $result['remove_profile']!=0){
								$errors .= "<li>You can not send friend request to $email_ids.</li>";
								$success=false;
							}
							
							if(isset($result['uid']) and $result['uid'] == $current['uid']){
								$errors .= "<li>You can not send friend request yourself</li>";
								$success=false;								
							}
							if(isset($chk_already_your_friend['friend_id']) and $chk_already_your_friend['friend_id'] > 0){
								$errors .= "<li>This user ($email_ids) is already your friend</li>";
								$success=false;
							}	

							
						}
					}	
				}
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
				$shared_nonusers = array();
				$shared_allusers = array();
				//$_POST['shared_user'] = explode(',', $_POST['shared_user']);
				// $_POST['shared_user'] = trim($_POST['shared_user']);
				$shared_users = $_POST['shared_user'];
                $tim = time();	
                $_SESSION['urls_for_print_pdf'] = '';	
                $show_url_val_list_in_msg = '';
                $show_url_val_list_in_msg_maximum = '';
				$show_url_desc_in_msg = '';
				$show_url_desc_in_msg_maximum = '';
				$count_shared_urls = 0;						
				$count_shared_urls_maximum = 0;						
				foreach($_POST['urls'] as $urls_id){					
					$count_shared_urls++;
					$url_info = $co->query_first("select us.sponsored_link,us.url_msg,us.share_type_change,us.public_cat_change,us.url_msg_time,ur.url_id,ur.url_cat,ur.url_value,ur.url_desc from user_urls ur, user_shared_urls us where us.url_id=ur.url_id and us.shared_url_id=:urls",array('urls'=>$urls_id));
					if($count_shared_urls <= 3){ // display maximum three records on popup dialog messages
						$count_shared_urls_maximum++;
						$show_url_val_list_in_msg_maximum .= $url_info['url_value'].'<br/>';
						$show_url_desc_in_msg_maximum .= substr($url_info['url_desc'], 0, 80).'...<br/>';
					}
					$show_url_val_list_in_msg .= $url_info['url_value'].'<br/>';
					$show_url_desc_in_msg .= substr($url_info['url_desc'], 0, 80).'...<br/>';	
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
							
							$exist_user = $co->query_first("select uid from users where email_id=:user",array('user'=>$shared_user));
							
							$up = array();
							$up['uid'] = $current['uid'];
							
							if(isset($exist_user['uid']) and $exist_user['uid'] != ''){
								$up['shared_to'] = $exist_user['uid'];
								$send_to = $exist_user['uid'];
							}else{
								$up['shared_to'] = $shared_user;
								$send_to = $shared_user;
							
								/*if(!(in_array($shared_user,$shared_nonusers))){	
									 $shared_nonusers[] = $shared_user;
								}*/
							
							}
							if(!(in_array($shared_user,$shared_nonusers))){
								$shared_nonusers[] = $shared_user;
								$shared_allusers[] = array('email_to'=>$shared_user,'share_to'=>$send_to);
							}
							
							$up['url_cat'] = $url_info['url_cat'];
							$up['url_id'] = $url_info['url_id'];
							$up['share_number'] = $_SESSION['share_number'];
							if(isset($_POST['disable_share_id']) and $_POST['disable_share_id'] == 1)
								$up['activate_share_id'] = 0;
							else
								$up['activate_share_id'] = 1;

							$up['shared_time'] = $tim;
							/* for edit url msg */
							if($url_info['url_msg'] != ''){
								$up['url_msg'] = $url_info['url_msg'];
								$up['url_msg_time'] = $url_info['url_msg_time'];
							}
							$up['share_type_change'] = $url_info['share_type_change'];
							$up['public_cat_change'] = $url_info['public_cat_change'];
							$up['sponsored_link'] = $url_info['sponsored_link'];
							if($url_info['share_type_change'] == 3 or $url_info['public_cat_change'] > 8){
								$up['add_to_search_page_change'] = 1;
								$up['search_page_status_change'] = 0;
							}


							/* end code */	

							$share_url_id = $co->query_insert('user_shared_urls', $up);
							unset($up);	

							$_SESSION['urls_for_print_pdf'] .= 'url[]='.$share_url_id.'&';
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
				//send invite code
				if(isset($_POST['group_name']) and $_POST['group_name'] != '' and isset($_POST['save_as_group']) and $_POST['save_as_group'] == 1){
					$description = 'Join Linkibag';				
					foreach($emails_ids as $email_ids){
						$result['uid'] = 0;
						$result = $co->query_first("SELECT uid,remove_profile FROM `users` WHERE email_id=:id",array('id'=>$email_ids));
						$uid = $result['uid'];
						$reset_code = $co->generate_path(18);
						$up = array();									
						$up['request_by'] = $current['uid'];									
						$up['request_to'] = (($uid > 0) ? $uid : trim($email_ids));
						$up['request_code'] = $reset_code;
						$up['request_email'] = trim($email_ids);
						$up['description'] = $description;
						$up['status'] = 0;
						$up['request_time'] = time();									
						$request_id = $co->query_insert('friends_request', $up);									
						unset($up);	
						$get_email_id = $co->query_first("SELECT request_id FROM `friends_request` WHERE request_email=:mail and status=0",array('mail'=>trim($email_ids)));
						if(isset($get_email_id['request_id']) and $get_email_id['request_id'] > 0){
							$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:uid and fid=:fid and status=0 and request_id=:id",array('uid'=>$current['uid'],'fid'=>$uid,'id'=>$get_email_id['request_id']));
							if(!(isset($already_data_in_user_friends['friend_id']) and $already_data_in_user_friends['friend_id'] > 0)){
								$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:uid and fid=:fid and status=0",array('uid'=>$current['uid'],'fid'=>$uid));	
							}
							if(!(isset($already_data_in_user_friends['friend_id']) and $already_data_in_user_friends['friend_id'] > 0)){
								$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:fid and fid=:uid and status=0",array('uid'=>$current['uid'],'fid'=>$uid));
							}	
							for($incr=0;$incr<=1;$incr++){
								$up = array();									
								$up['request_id'] = $request_id;									
								if($incr == 1){
									$up['uid'] = $uid;
									$up['fid'] = $current['uid'];
								}else{
									$up['uid'] = $current['uid'];
									$up['fid'] = $uid;									
								}
								$up['fgroup'] = 0;
								$up['status'] = 0;
								$up['date'] = date('Y-m-d');
								$up['created'] = time();
								$up['updated'] = time();
								$friend_id = $co->query_insert('user_friends', $up);
								unset($up);	
							}	
							
						}	
						if(isset($result['uid']) and $result['uid'] > 0){
								$to = trim($email_ids);
								$subject = 'Friend request at Linkibag';
								$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
								$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' '.$description.' <br /><br/><a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">Declined</a></p> <br /><br />Cheers<br />Team Linkibag';	
								$from = 'info@linkibag.com';
								$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n".'<html xmlns="http://www.w3.org/1999/xhtml">'."\n".'<head>'."\n".'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n".'<title>Confirm your account</title>'."\n".'<style type="text/css">body{margin:0;padding:0;min-width:100%!important}.content{color:#3e3e3e;font-family:arial;max-width:600px;text-align:center;width:100%}.btn{background:#d76b00 none repeat scroll 0 0;border-radius:55px;color:#fff;display:inline-block;font-size:22px;font-weight:bold;margin:32px 0;padding:12px 43px;text-decoration:none}.btn-decline{background:#ccc none repeat scroll 0 0;border-radius:55px;color:#fff;display:inline-block;font-size:22px;font-weight:bold;margin:32px 0;padding:12px 43px;text-decoration:none}h1{margin:0}.big{color:#3e3e3e;font-size:22px;margin-top:4px}.content p{color:#3e3e3e}.content p a{color:#3e3e3e;text-decoration:none}</style>'."\n".'</head>'."\n".'<body bgcolor="#ffffff">'."\n".'<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">'."\n".'<tr>'."\n".'<td>'."\n".'<table class="content" align="center" cellpadding="0" cellspacing="0" border="0">'."\n".'<tr>'."\n".'<td style="text-align:left;padding:30px 0 40px">'."\n".'<img src="http://linkibag.net/PTest25x/linkibag/images/email-logo/linkibag-logo.png">'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<h1>Friend Rquest At LinkiBag.</h1>'."\n".'<p class="big">Click on link below to Accept Or Decline.</p>'."\n".'<p>'.$description.'</p>'."\n".'<a class="btn" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Accept</a> <a class="btn-decline" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">Decline</a>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<p>This message was send to '.$to.'. if you have questions or complaints, please <a href="http://linkibag.net/PTest25x/linkibag/index.php?p=contact-us"><b>contact us.</b></a> We’re here to help.</p>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<p><a href="http://linkibag.net/PTest25x/linkibag/index.php?p=terms-of-use">Terms of Use</a> &nbsp; | &nbsp; <a href="http://linkibag.net/PTest25x/linkibag/index.php?p=terms-of-use">Privacy Policy</a></p>'."\n".'</td>'."\n".'</tr>'."\n".'</table>'."\n".'</td>'."\n".'</tr>'."\n".'</table>'."\n".'</body>'."\n".'</html>';					
								$co->send_email($to, $subject, $message, $from);
								
						}else if(!(isset($result['uid']) and $result['uid'] > 0)){
							$to = trim($email_ids);
							$user = $co->getcurrentuser_profile();
							$subject = 'Friend request at Linkibag';
							$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
							$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' '.$description .'Please join LinkiBag. <br /><br/></p> <a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">Declined</a><br /><br />Cheers<br />Team Linkibag';		
							$from = 'info@linkibag.com';
							$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Linkibag Invitation</title>
						<style type="text/css">@import url("https://fonts.googleapis.com/css?family=Lora");body{margin:0;padding:0;min-width:100%!important}.content{color:#3e3e3e;font-family:arial;max-width:600px;text-align:center;width:100%}.btn{background:#408080 none repeat scroll 0 0;border-radius:0;color:#fff!important;display:inline-block;font-size:20px;font-weight:bold;margin:0;padding:6px 31px;text-decoration:none;width:275px}.btn-decline{background:#c3c3c3 none repeat scroll 0 0;border-radius:0;color:#7A7A7A!important;display:inline-block;font-size:20px;font-weight:bold;margin:16px 0 0;padding:6px 31px;text-decoration:none;width:275px}h1{font-family:"Lora",serif;margin:0;font-size:26px;line-height:38px;color:#353e4f !important}.top-line{font-size:14px;margin-top:20px}.big{font-family:"Lora",serif;color:#3e3e3e;font-size:20px;margin:38px 0 22px;line-height:30px;font-weight:bolder}.links{padding:41px 0 5px}.links a{color:#7F7F95!important;font-size:14px}.bottom-text{font-size:14px;line-height:25px;color:#000!important}.bottom-text a{text-decoration:underline!important;font-weight:600}.content p{color:#3e3e3e}.content p a{color:#3e3e3e;text-decoration:none}</style>
						</head>
						<body bgcolor="#ffffff">
						<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
						<tr><td>
						<table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
						<tr><td style="text-align:left;padding:30px 0 40px"><img src="http://linkibag.net/PTest25x/linkibag/images/email-logo/linkibag-logo.png"><br><p class="top-line">This message was sent by user '.$current['email_id'].' via Linkibag.com<p></td></tr>
						<tr><td><h1> '.$user['first_name'].' '.$user['last_name'].'<br>invited you to join LinkiBag and to connect!</h1>
						<p class="big">What is LinkiBag? <a href="http://linkibag.net/PTest25x/linkibag/index.php" target="_blank">Click here</a> to learn more.<br>Free. Easy. Why not?</p>
						<a class="btn" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Sign up for a free Account</a> 
						<a class="btn-decline" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">I do not know this person</a>
						</td></tr>
						<tr><td></td></tr>
						<tr>
						<td>
						<p class="links"><a href="'.$co->get_bit_ly_link(WEB_ROOT.'index.php?p=about_us').'">About Linkibag &nbsp; | &nbsp;</a>  <a href="'.$co->get_bit_ly_link(WEB_ROOT.'index.php?p=pages&id=8').'">Terms of Use &nbsp; | &nbsp; </a> <a href="'.$co->get_bit_ly_link(WEB_ROOT.'index.php?p=pages&id=9').'">Privacy Policy</a></p>
						<p class="bottom-text"><a href="'.$co->get_bit_ly_link(WEB_ROOT.'index.php?p=unsubscribe&email='.$to).'">UNSUBSCRIBE</a> from all messages sent vis LinkiBag by any Linkibag users and from LinkiBag invitations LinkiBag Inc. 8926 N. Greenwood Ave, #220, Niles, IL 60714</p>
						</td>
						</tr>
						</table>
						</td></tr>
						</table>
						</body>
						</html>';					
							$co->send_email($to, $subject, $message, $from);
								
						}
						
					}
					if(isset($_SESSION['already_user']))
						unset($_SESSION['already_user']);
				}else if(isset($_POST['group_name_updated']) and $_POST['group_name_updated'] != '' and isset($_POST['update_as_group']) and $_POST['update_as_group'] == 1){
					$description = 'Join Linkibag';				
					foreach($emails_ids as $email_ids){
						$result['uid'] = 0;
						$result = $co->query_first("SELECT uid,remove_profile FROM `users` WHERE email_id=:id",array('id'=>$email_ids));
						$uid = $result['uid'];
						$reset_code = $co->generate_path(18);
						$up = array();									
						$up['request_by'] = $current['uid'];									
						$up['request_to'] = (($uid > 0) ? $uid : trim($email_ids));
						$up['request_code'] = $reset_code;
						$up['request_email'] = trim($email_ids);
						$up['description'] = $description;
						$up['status'] = 0;
						$up['request_time'] = time();									
						$request_id = $co->query_insert('friends_request', $up);									
						unset($up);	
						$get_email_id = $co->query_first("SELECT request_id FROM `friends_request` WHERE request_email=:mail and status=0",array('mail'=>trim($email_ids)));
						if(isset($get_email_id['request_id']) and $get_email_id['request_id'] > 0){
							$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:uid and fid=:fid and status=0 and request_id=:id",array('uid'=>$current['uid'],'fid'=>$uid,'id'=>$get_email_id['request_id']));
							if(!(isset($already_data_in_user_friends['friend_id']) and $already_data_in_user_friends['friend_id'] > 0)){
								$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:uid and fid=:fid and status=0",array('uid'=>$current['uid'],'fid'=>$uid));	
							}
							if(!(isset($already_data_in_user_friends['friend_id']) and $already_data_in_user_friends['friend_id'] > 0)){
								$already_data_in_user_friends = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:fid and fid=:uid and status=0",array('uid'=>$current['uid'],'fid'=>$uid));
							}	
							for($incr=0;$incr<=1;$incr++){
								$up = array();									
								$up['request_id'] = $request_id;									
								if($incr == 1){
									$up['uid'] = $uid;
									$up['fid'] = $current['uid'];
								}else{
									$up['uid'] = $current['uid'];
									$up['fid'] = $uid;									
								}
								$up['fgroup'] = 0;
								$up['status'] = 0;
								$up['date'] = date('Y-m-d');
								$up['created'] = time();
								$up['updated'] = time();
								$friend_id = $co->query_insert('user_friends', $up);
								unset($up);	
							}	
							
						}	
						if(isset($result['uid']) and $result['uid'] > 0){
								$to = trim($email_ids);
								$subject = 'Friend request at Linkibag';
								$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
								$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' '.$description.' <br /><br/><a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">Declined</a></p> <br /><br />Cheers<br />Team Linkibag';	
								$from = 'info@linkibag.com';
								$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n".'<html xmlns="http://www.w3.org/1999/xhtml">'."\n".'<head>'."\n".'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n".'<title>Confirm your account</title>'."\n".'<style type="text/css">body{margin:0;padding:0;min-width:100%!important}.content{color:#3e3e3e;font-family:arial;max-width:600px;text-align:center;width:100%}.btn{background:#d76b00 none repeat scroll 0 0;border-radius:55px;color:#fff;display:inline-block;font-size:22px;font-weight:bold;margin:32px 0;padding:12px 43px;text-decoration:none}.btn-decline{background:#ccc none repeat scroll 0 0;border-radius:55px;color:#fff;display:inline-block;font-size:22px;font-weight:bold;margin:32px 0;padding:12px 43px;text-decoration:none}h1{margin:0}.big{color:#3e3e3e;font-size:22px;margin-top:4px}.content p{color:#3e3e3e}.content p a{color:#3e3e3e;text-decoration:none}</style>'."\n".'</head>'."\n".'<body bgcolor="#ffffff">'."\n".'<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">'."\n".'<tr>'."\n".'<td>'."\n".'<table class="content" align="center" cellpadding="0" cellspacing="0" border="0">'."\n".'<tr>'."\n".'<td style="text-align:left;padding:30px 0 40px">'."\n".'<img src="http://linkibag.net/PTest25x/linkibag/images/email-logo/linkibag-logo.png">'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<h1>Friend Rquest At LinkiBag.</h1>'."\n".'<p class="big">Click on link below to Accept Or Decline.</p>'."\n".'<p>'.$description.'</p>'."\n".'<a class="btn" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Accept</a> <a class="btn-decline" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">Decline</a>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<p>This message was send to '.$to.'. if you have questions or complaints, please <a href="http://linkibag.net/PTest25x/linkibag/index.php?p=contact-us"><b>contact us.</b></a> We’re here to help.</p>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<p><a href="http://linkibag.net/PTest25x/linkibag/index.php?p=terms-of-use">Terms of Use</a> &nbsp; | &nbsp; <a href="http://linkibag.net/PTest25x/linkibag/index.php?p=terms-of-use">Privacy Policy</a></p>'."\n".'</td>'."\n".'</tr>'."\n".'</table>'."\n".'</td>'."\n".'</tr>'."\n".'</table>'."\n".'</body>'."\n".'</html>';					
								$co->send_email($to, $subject, $message, $from);
								
						}else if(!(isset($result['uid']) and $result['uid'] > 0)){
							$to = trim($email_ids);
							$user = $co->getcurrentuser_profile();
							$subject = 'Friend request at Linkibag';
							$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
							$message = 'Dear<br /><br /><p>Hello, '.$current['first_name'].$current['last_name'].' '.$description .'Please join LinkiBag. <br /><br/></p> <a style="border:none; padding: 5px; background: green; color:#fff; text-decoration: none;" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Accept</a>&nbsp;&nbsp;&nbsp;<a style="border:none; padding: 5px; background: red; color:#fff; text-decoration: none;" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">Declined</a><br /><br />Cheers<br />Team Linkibag';		
							$from = 'info@linkibag.com';
							$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Linkibag Invitation</title>
						<style type="text/css">@import url("https://fonts.googleapis.com/css?family=Lora");body{margin:0;padding:0;min-width:100%!important}.content{color:#3e3e3e;font-family:arial;max-width:600px;text-align:center;width:100%}.btn{background:#408080 none repeat scroll 0 0;border-radius:0;color:#fff!important;display:inline-block;font-size:20px;font-weight:bold;margin:0;padding:6px 31px;text-decoration:none;width:275px}.btn-decline{background:#c3c3c3 none repeat scroll 0 0;border-radius:0;color:#7A7A7A!important;display:inline-block;font-size:20px;font-weight:bold;margin:16px 0 0;padding:6px 31px;text-decoration:none;width:275px}h1{font-family:"Lora",serif;margin:0;font-size:26px;line-height:38px;color:#353e4f !important}.top-line{font-size:14px;margin-top:20px}.big{font-family:"Lora",serif;color:#3e3e3e;font-size:20px;margin:38px 0 22px;line-height:30px;font-weight:bolder}.links{padding:41px 0 5px}.links a{color:#7F7F95!important;font-size:14px}.bottom-text{font-size:14px;line-height:25px;color:#000!important}.bottom-text a{text-decoration:underline!important;font-weight:600}.content p{color:#3e3e3e}.content p a{color:#3e3e3e;text-decoration:none}</style>
						</head>
						<body bgcolor="#ffffff">
						<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
						<tr><td>
						<table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
						<tr><td style="text-align:left;padding:30px 0 40px"><img src="http://linkibag.net/PTest25x/linkibag/images/email-logo/linkibag-logo.png"><br><p class="top-line">This message was sent by user '.$current['email_id'].' via Linkibag.com<p></td></tr>
						<tr><td><h1> '.$user['first_name'].' '.$user['last_name'].'<br>invited you to join LinkiBag and to connect!</h1>
						<p class="big">What is LinkiBag? <a href="http://linkibag.net/PTest25x/linkibag/index.php" target="_blank">Click here</a> to learn more.<br>Free. Easy. Why not?</p>
						<a class="btn" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Sign up for a free Account</a> 
						<a class="btn-decline" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">I do not know this person</a>
						</td></tr>
						<tr><td></td></tr>
						<tr>
						<td>
						<p class="links"><a href="'.$co->get_bit_ly_link(WEB_ROOT.'index.php?p=about_us').'">About Linkibag &nbsp; | &nbsp;</a>  <a href="'.$co->get_bit_ly_link(WEB_ROOT.'index.php?p=pages&id=8').'">Terms of Use &nbsp; | &nbsp; </a> <a href="'.$co->get_bit_ly_link(WEB_ROOT.'index.php?p=pages&id=9').'">Privacy Policy</a></p>
						<p class="bottom-text"><a href="'.$co->get_bit_ly_link(WEB_ROOT.'index.php?p=unsubscribe&email='.$to).'">UNSUBSCRIBE</a> from all messages sent vis LinkiBag by any Linkibag users and from LinkiBag invitations LinkiBag Inc. 8926 N. Greenwood Ave, #220, Niles, IL 60714</p>
						</td>
						</tr>
						</table>
						</td></tr>
						</table>
						</body>
						</html>';					
							$co->send_email($to, $subject, $message, $from);
								
						}
						
					}
					if(isset($_SESSION['already_user']))
						unset($_SESSION['already_user']);
				}	
					//end invite code

				/* print_r ($shared_allusers);*/

				/* start code of save as new group */
				if(isset($_POST['group_name']) and $_POST['group_name'] != '' and isset($_POST['save_as_group']) and $_POST['save_as_group'] == 1){
					$up_val = array();
					$up_val['uid'] = $current['uid'];
					$up_val['group_name'] = $_POST['group_name'];
					$up_val['created'] = time();
					$up_val['updated'] = time();				
					$up_val['status'] = 1;					
					$group_id = $co->query_insert('groups', $up_val);
					unset($up_val);
					$groups_user_all = $co->fetch_all_array("select * from groups where uid IN (:id) ORDER BY group_id DESC",array('id'=>$current['uid']));
					$group_options_select_list = '<option value="">Select Group</option>';
					foreach($groups_user_all as $listgrp){
						$group_options_select_list .= '<option value="'.$listgrp['group_id'].'">'.$listgrp['group_name'].'</option>';
					}
				}
				/* end code of save as new group */
				/* start code of update as existing group */
				else if(isset($_POST['group_name_updated']) and $_POST['group_name_updated'] != '' and isset($_POST['update_as_group']) and $_POST['update_as_group'] == 1){
					$up_val = array();
					$up_val['group_name'] = $_POST['group_name_updated'];
					$up_val['updated'] = time();				
					$co->query_update('groups', $up_val, array('id'=>$_POST['friend_group'], 'uid'=>$current['uid']), 'group_id=:id and uid=:uid');
					unset($up_val);
					$group_id = $_POST['friend_group'];
					$groups_user_all = $co->fetch_all_array("select * from groups where uid IN (:id) ORDER BY group_id DESC",array('id'=>$current['uid']));
					$group_options_select_list = '<option value="">Select Group</option>';
					foreach($groups_user_all as $listgrp){
						$sel = '';
						if($listgrp['group_id'] == $group_id)
							$sel = ' selected="selected"';
						$group_options_select_list .= '<option value="'.$listgrp['group_id'].'"'.$sel.'>'.$listgrp['group_name'].'</option>';
					}
				}
				/* end code of update as existing group */

				$show_email_list_in_msg = '';
				$show_email_list_in_msg_maximum = '';
				$count_shared_to_users = 0;						
				$count_shared_to_users_maximum = 0;
				if(isset($shared_allusers) and count($shared_allusers) > 0){
					foreach($shared_allusers as $shared_user){
						$count_shared_to_users++;
						//echo $shared_user['email_to'];						
						if($count_shared_to_users <= 3){ // display maximum three records on popup dialog messages
							$count_shared_to_users_maximum++;
							$show_email_list_in_msg_maximum .= $shared_user['email_to'].'<br/>';

						}	
						$to = $shared_user['email_to'];

						$show_email_list_in_msg .= $to.'<br/>';

						$subject = 'New links shared by '.$current['first_name'].$current['last_name'].' on Linkibag';
						
						$verified_links = WEB_ROOT.'/index.php?p=view-share&share_to='.urlencode($shared_user['share_to']).'&share_no='.$_SESSION['share_number'];

						$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
						
						$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n".'<title>Linkibag Invitation</title>'."\n".'
<style type="text/css">
@import url("https://fonts.googleapis.com/css?family=Lora");body{margin:0;padding:0;min-width:100%!important}
.content p{color:#3e3e3e}
.content p a{color:#3e3e3e;text-decoration:none}
</style>
'."\n".'</head>'."\n".'<body bgcolor="#ffffff">'."\n".'<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
'."\n".'<tr>'."\n".'<td>'."\n".'<table style="margin: auto !important; color:#3e3e3e; font-family:arial; max-width:600px; text-align:center !important; width:100%" align="center" cellpadding="0" cellspacing="0" border="0">'."\n".'<tr>'."\n".'<td style="text-align:left;padding:30px 0 40px">'."\n".'<img src="http://linkibag.net/PTest25x/linkibag/images/email-logo/linkibag-logo.png">'."\n".'<br>'."\n".'<p style="font-size:14px;margin-top:20px">This message was sent by user '.$current['email_id'].' via <a target="_blank" href="http://www.linkibag.com" style="text-decoration: underline;">LinkiBag.com</a><p>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<h1 style="font-family:arial;margin:0;font-size:26px;line-height:38px;color:#353e4f">Hello '.$to.'<br>'.$current['first_name'].''.$current['last_name'].'<br>shared some links with you using Linkibag.com </h1>'."\n".'<p style="text-align:center !important;color:#3e3e3e;font-size:20px;margin:38px 0 22px;line-height:30px;font-weight:bolder;"><a style="color: #3e3e3e; text-decoration: underline;" href="'.$verified_links.'">Click Here</a> to view shared links.<br/><span style="font-size: 11px;font-weight: normal;">* You will be required to enter the code provided by sender to open shared links.</span></p>'."\n".'<a style="background: #fff;border-radius: 0;color: gray;display: inline-block;font-size: 20px;font-weight: bold;margin: 0;padding: 6px;text-decoration: none;width: 275px;" href="'.$co->get_bit_ly_link($verified_link.'&accept=yes').'">Sign up for a free Account</a>'."\n".'<a style="background:#fff none repeat scroll 0 0;border-radius:0;color:gray;display:inline-block;font-size:20px;font-weight:bold;margin:16px 0 0;padding:6px;text-decoration:none;width:275px" href="'.$co->get_bit_ly_link($verified_link.'&accept=no').'">I dont know this person</a>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<p style="padding:41px 0 5px;">'."\n".'<a style="color:#7F7F95!important;font-size:14px;text-decoration: none;" href="http://linkibag.net/PTest25x/linkibag/index.php?p=about_us">About Linkibag &nbsp; | &nbsp;</a>'."\n".'<a style="color:#7F7F95!important;font-size:14px;text-decoration: none" href="http://linkibag.net/PTest25x/linkibag/index.php?p=pages&id=8">Terms of Use &nbsp; | &nbsp; </a>'."\n".' <a style="color:#7F7F95!important;font-size:14px;text-decoration: none;" href="http://linkibag.net/PTest25x/linkibag/index.php?p=pages&id=9">Privacy Policy</a>'."\n".'</p>'."\n".'<p style="font-size:14px;line-height:25px;color:#000!important">'."\n".'<a href="#" style="color: #7F7F95!important;font-weight: normal;text-transform: capitalize !important;margin-right: 8px;text-decoration: none !important;">Unsubscribe</a> from all messages sent via LinkiBag by any LinkiBag users and from LinkiBag Inc. <br> <span style="color: #7F7F95!important;">LinkiBag Inc. 8926 N. Greenwood Ave, #220, Niles, IL 60714<span></p></td>'."\n".'</tr>'."\n".'</table>'."\n".'</td>'."\n".'</tr>'."\n".'</table>'."\n".'</body>'."\n".'</html>
';				
						
						$from = 'info@linkibag.com';				
						$co->send_email($to, $subject, $message, $from);
						
						//start code add member to group
						if(isset($_POST['group_name']) and $_POST['group_name'] != '' and isset($_POST['save_as_group']) and $_POST['save_as_group'] == 1){
							$already_exit_gp_friends = array();
							$already_exit_gp_friends = $co->query_first("select groups_friends_id from groups_friends WHERE groups=:groups and uid=:uid and email_id=:email_id",array('groups'=>$group_id, 'uid'=>$current['uid'], 'email_id'=>$shared_user['share_to']));
							if(!(isset($already_exit_gp_friends['groups_friends_id']) and $already_exit_gp_friends['groups_friends_id'] > 0)){
								$up_val = array();
								$up_val['uid'] = $current['uid'];
								$up_val['groups'] = $group_id;
								$up_val['email_id'] = $shared_user['share_to'];
								$up_val['created'] = time();
								$up_val['updated'] = time();				
								$up_val['status'] = 1;					
								$groups_members_id = $co->query_insert('groups_friends', $up_val);
								unset($up_val);
							}
							
						}else if(isset($_POST['group_name_updated']) and $_POST['group_name_updated'] != '' and isset($_POST['update_as_group']) and $_POST['update_as_group'] == 1){
							$already_exit_gp_friends = array();
							$already_exit_gp_friends = $co->query_first("select groups_friends_id from groups_friends WHERE groups=:groups and uid=:uid and email_id=:email_id",array('groups'=>$group_id, 'uid'=>$current['uid'], 'email_id'=>$shared_user['share_to']));
							if(!(isset($already_exit_gp_friends['groups_friends_id']) and $already_exit_gp_friends['groups_friends_id'] > 0)){
								$up_val = array();
								$up_val['uid'] = $current['uid'];
								$up_val['groups'] = $group_id;
								$up_val['email_id'] = $shared_user['share_to'];
								$up_val['created'] = time();
								$up_val['updated'] = time();				
								$up_val['status'] = 1;					
								$groups_members_id = $co->query_insert('groups_friends', $up_val);
								unset($up_val);
							}
							
						}
						//end add member groups code	
					}
				}
				
				
				/*$msg ='Link successfully shared with selected friends';*/
				/*
				$msg = '<div id="print_msg"></div>
				<div class="sharing-links-success-panel">							
		<div class="sharing-panel-body">
			<h4>Success! Your link was emailed to the following users:</h4><br>
			'.$show_email_list_in_msg.'
			<br>';
			if(!(isset($_POST['disable_share_id']) and $_POST['disable_share_id'] == 1)){
				$msg .= '<h4>Your link also available to web users via Share ID '.$_SESSION['share_number'].' during next 30 minutes.</h4>';
			}
			$msg .= '
			<h6><small>'.date("m/d/Y h:ia T", $tim).'</small>
			<button type="button" id="print_link" onclick="print_pdf_urls()" class="btn orang-bg">Save</button>
			<button type="button" id="print_link" onclick="printPageArea(\'all_records\')" class="btn orang-bg">Print</button>
			<button type="button" class="btn orang-bg" role="button" aria-disabled="false" title="close" style="display: none;">Close</button>
			</h6>
	</div>
</div>';
	*/
	$msg = '<div id="print_msg"></div><div class="sharing-links-success-panel"><div class="sharing-panel-body">
	<h4 style="color: red;font-weight: 400;">Link(s) and message below were shared successfully.</h4>

<div style="overflow: hidden; margin: 13px 0px;">
  <div style="float: left; width: 30%;"><h4>Link(s):</h4></div>
  <div style="float: right; width: 70%;"><h4>'.$show_url_val_list_in_msg_maximum.'</h4></div>
</div>';
if($count_shared_urls > 3){
	$msg .= '<div style="overflow: hidden; margin: 13px 0px;">
	  <div style="float: left; width: 30%;"><h4></h4></div>
	  <div style="float: right; width: 70%;"><h4>Total of '.$count_shared_urls.'</h4></div>
	</div>';
}
$msg .= '
<div style="overflow: hidden; margin: 13px 0px; display: none;">
  <div style="float: left; width: 30%;"><h4>Message:</h4></div>
  <div style="float: right; width: 70%;"><h4>'.$show_url_desc_in_msg_maximum.'</h4></div>
</div><div style="overflow: hidden; margin: 13px 0px;">
  <div style="float: left; width: 30%;"><h4>Shared with:</h4></div>
  <div style="float: right; width: 70%;"><h4>'.$show_email_list_in_msg_maximum.'</h4></div>
</div>';
if($count_shared_to_users > 3){
	$msg .= '<div style="overflow: hidden; margin: 13px 0px;">
	  <div style="float: left; width: 30%;"><h4></h4></div>
	  <div style="float: right; width: 70%;"><h4>Total of '.$count_shared_to_users.'</h4></div>
	</div>';
}
if(!(isset($_POST['disable_share_id']) and $_POST['disable_share_id'] == 1)){
	$msg .= '<div style="overflow: hidden; margin: 13px 0px;">
  <div style="float: left; width: 30%;"><h4>Share ID:</h4></div>
  <div style="float: right; width: 70%;"><h4>'.$_SESSION['share_number'].'</h4></div>
</div>';
}
$msg .= '
<div style="overflow: hidden; margin: 13px 0px;">
  <div style="float: left; width: 30%;"><h4>Share date/time:</h4></div>
  <div style="float: right; width: 70%;"><h4>'.date("M d, Y h:ia T", $tim).'</h4></div>
  </div>
  <div style="float: left; width: 100%; font-size: 11px; font-weight: 500; display:none;">
  	<span>'.$count_shared_urls_maximum.' of total '.$count_shared_urls.' links</span><br>
  	<span>'.$count_shared_to_users_maximum.' of total '.$count_shared_to_users.' users</span>
  </div>

  <h6>
			<button type="button" class="btn orang-bg" onclick="dialog_close(\'#dialog_success\');" role="button" aria-disabled="false" title="close">Close</button>
			<button type="button" id="print_links" onclick="printPageArea(\'all_records_serialize\')" class="btn orang-bg" style="display: none;">Print</button>
			<button type="button" id="print_link" onclick="print_pdf_urls()" class="btn orang-bg">Receipt</button>
			
			</h6></div></div>

	<script>
		function dialog_close(id){
			$(id).dialog("close");
		}
	</script>		
  ';




			}

				$table_serialize_for_print = '<table id="all_records_serialize">
								<tr>
									<td>
										Date/time:
									</td>
									<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									<td>
										'.date("m/d/Y h:ia T", $tim).'			
									</td>			
								</tr>
								<tr>
									<td>
										Link(s):
									</td>
									<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									<td>
										'.$show_url_val_list_in_msg.'			
									</td>			
								</tr>
								<tr>
									<td>
										Message:
									</td>
									<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									<td>
										'.$show_url_desc_in_msg.'			
									</td>			
								</tr>
								<tr>
									<td>
										Share ID:
									</td>
									<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									<td>
										'.$_SESSION['share_number'].'			
									</td>			
								</tr>
								<tr>
									<td>
										Expiring:
									</td>
									<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									<td>
										'.date('M d, Y h:ia T', ($tim + 1800)).'			
									</td>			
								</tr>			
								<tr>
									<td>
										Shared By:
									</td>
									<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									<td>
										'.$current['email_id'].'			
									</td>			
								</tr>
							</table>';

			echo json_encode(array('msg'=>$msg,'success'=>$success,'group_options_update'=>$group_options_select_list,'shared_urls_serialize'=>$_SESSION['urls_for_print_pdf'],'table_serialize_for_print'=>$table_serialize_for_print));
			exit();
		}else{
			$msg ='<div class="alert alert-danger">
						<ul>
							'.$errors.'
							
						</ul>
				</div>';
			echo json_encode(array('msg'=>$msg,'success'=>$success,'group_options_update'=>$group_options_select_list));
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
			$co->setmessage("error", "Please select the links");
			$success = false;	
		}
		if(isset($_POST['share_url']) and count($_POST['share_url']) > 0){
			foreach($_POST['share_url'] as $url){
				$link_urls .= 'url[]='.$url.'&';
				if(isset($_POST['share']) and $_POST['share'] == 1){
					$arr .= '<input type="hidden" name="urls[]" value="'.$url.'"/>' ; 
					$success = true;
				}else if(isset($_POST['mark_as_unread']) and $_POST['mark_as_unread'] == 1){
					$up_val = array();
					$up_val['read_status'] = 0;
					$up_val['num_of_visits'] = 0;	
					$co->query_update('user_shared_urls', $up_val, array('id'=>$url, 'uid'=>$current['uid']), 'shared_url_id=:id and shared_to=:uid');
					unset($up_val);
					$success = true;
				}else if(isset($_POST['mark_as_like']) and $_POST['mark_as_like'] == 1){
					$up_val = array();
					$up_val['like_status'] = 1;
					$up_val['like_unlike_time'] = time();
					$co->query_update('user_shared_urls', $up_val, array('id'=>$url, 'uid'=>$current['uid']), 'shared_url_id=:id and shared_to=:uid');
					unset($up_val);
					$success = true;
				}else if(isset($_POST['mark_as_unlike']) and $_POST['mark_as_unlike'] == 1){
					$up_val = array();
					$up_val['like_status'] = 2;
					$up_val['like_unlike_time'] = time();
					$co->query_update('user_shared_urls', $up_val, array('id'=>$url, 'uid'=>$current['uid']), 'shared_url_id=:id and shared_to=:uid');
					unset($up_val);
					$success = true;
				}else if(isset($_POST['mark_as_recommend']) and $_POST['mark_as_recommend'] == 1){
					$up_val = array();
					$up_val['recommend_link'] = 1;
					$up_val['recommend_link_time'] = time();
					$co->query_update('user_shared_urls', $up_val, array('id'=>$url, 'uid'=>$current['uid']), 'shared_url_id=:id and shared_to=:uid');
					unset($up_val);
					$success = true;
				}else if(isset($_POST['mark_as_unrecommend']) and $_POST['mark_as_unrecommend'] == 1){
					$up_val = array();
					$up_val['recommend_link'] = 2;
					$up_val['recommend_link_time'] = time();
					$co->query_update('user_shared_urls', $up_val, array('id'=>$url, 'uid'=>$current['uid']), 'shared_url_id=:id and shared_to=:uid');
					unset($up_val);
					$success = true;
				}else if(isset($_POST['mark_as_del']) and $_POST['mark_as_del'] == 1){
					$co->query_delete('user_shared_urls', array('id'=>$url, 'uid'=>$current['uid']), 'shared_url_id=:id and shared_to=:uid');
					$success = true;
					$check_url = $co->query_first("SELECT * FROM `user_shared_urls` WHERE shared_url_id=:id", array('id'=>$url));
					if($check_url['shared_to']=='-1'){
						if(isset($_SESSION['hidesponsor'])){
							$_SESSION['hidesponsor']++;
							$_SESSION['hidesponsorurl'][] = $url;
						}
						else{
							$_SESSION['hidesponsor']=1;
							$_SESSION['hidesponsorurl'] = array($url);
						}
					}
				}		
			}	
		}	
		if($success == true){				
			if(isset($_POST['share']) and $_POST['share'] == 1){
				//<a href="index.php?p=share_links&'.$link_urls.'=" onclick="show_block(\'#friends_and_users\', \'#email_to_friends\');" class="btn btn-primary btn-block btn-lg">Share with LinkiBag Friends</a>
					
					echo '<script type="text/javascript">window.location = "index.php?p=shared-links-new&'.$link_urls.'="</script>';
					 exit();

				$share_link_body = '
					<div class="share-btns">
						<div class="col-md-6">
							<a href="index.php?p=share_links&'.$link_urls.'=" class="btn btn-primary btn-block btn-lg">Share with LinkiBag Friends</a>
						</div>
						<div class="col-md-6">
							<a href="javascript: void(0);" onclick="show_block(\'#email_to_friends\', \'#friends_and_users\');" class="btn btn-default btn-block btn-lg">Email to Your Friends</a>
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
																<li>								<div class="person_name">
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
				exit();
			}elseif(isset($_POST['mark_as_unread']) and $_POST['mark_as_unread'] == 1){
				$total_friends_url = $co->users_count_shared_url($current['uid'],'read_status',$_POST['cid']);  
				echo json_encode(array('share_url'=>$_POST['share_url'], 'total_unread'=>$total_friends_url));			
			}elseif(isset($_POST['mark_as_like']) and $_POST['mark_as_like'] == 1){
				$total_like_url = $co->users_count_shared_url($current['uid'],'like',$_POST['cid']);  
				$total_unlike_url = $co->users_count_shared_url($current['uid'],'unlike',$_POST['cid']);  
				echo json_encode(array('share_url'=>$_POST['share_url'], 'total_like'=>$total_like_url, 'total_unlike'=>$total_unlike_url));
			}elseif(isset($_POST['mark_as_unlike']) and $_POST['mark_as_unlike'] == 1){
				$total_like_url = $co->users_count_shared_url($current['uid'],'like',$_POST['cid']);  
				$total_unlike_url = $co->users_count_shared_url($current['uid'],'unlike',$_POST['cid']);  
				echo json_encode(array('share_url'=>$_POST['share_url'], 'total_like'=>$total_like_url, 'total_unlike'=>$total_unlike_url));
			}elseif(isset($_POST['mark_as_recommend']) and $_POST['mark_as_recommend'] == 1){
				$total_recommend_url = $co->users_count_shared_url($current['uid'],'recommend',$_POST['cid']);  
				$total_unrecommend_url = $co->users_count_shared_url($current['uid'],'unrecommend',$_POST['cid']);  
				echo json_encode(array('share_url'=>$_POST['share_url'], 'total_recommend'=>$total_recommend_url, 'total_unrecommend'=>$total_unrecommend_url));
			}elseif(isset($_POST['mark_as_unrecommend']) and $_POST['mark_as_unrecommend'] == 1){
				$total_recommend_url = $co->users_count_shared_url($current['uid'],'recommend',$_POST['cid']);  
				$total_unrecommend_url = $co->users_count_shared_url($current['uid'],'unrecommend',$_POST['cid']);  
				echo json_encode(array('share_url'=>$_POST['share_url'], 'total_recommend'=>$total_recommend_url, 'total_unrecommend'=>$total_unrecommend_url));
			}elseif(isset($_POST['mark_as_del']) and $_POST['mark_as_del'] == 1){
				
				/*if(isset($_POST['p']) and $_POST['p'] == 'shared-links'){
					$sql = "SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.* FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id and us.uid=:id2 and us.url_cat='-2' and us.num_of_visits=0";
					$sql2 = "SELECT COUNT(us.shared_url_id) as total FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id and us.uid=:id2 and us.url_cat='-2' and us.num_of_visits=0";
				}else if(isset($_POST['p']) and $_POST['p'] == 'dashboard'){
					$sql = "SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.* FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id and ur.status='1'";
					$sql2 = "SELECT COUNT(us.shared_url_id) as total FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id and ur.status='1'";
				}
				
				
				if($_POST['this_page'] =='p=dashboard' and isset($_POST['trash']) and $_POST['trash'] == 1){
					$sql .= " and us.url_cat=:cid";
					$sql2 .= " and us.url_cat=:cid";
				}elseif(($_POST['this_page'] =='p=dashboard' or $_POST['this_page'] =='p=shared-links') and $_POST['cid'] > 0){
					$sql .= " and us.url_cat=:cid";
					$sql2 .= " and us.url_cat=:cid";
				}elseif(($_POST['this_page'] =='p=dashboard' or $_POST['this_page'] =='p=shared-links') and $_POST['cid'] == -2){
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
					if(isset($_POST['p']) and $_POST['p'] == 'shared-links'){
						$cond['id2'] = $current['uid'];
					}if($_POST['this_page'] =='p=dashboard' and isset($_POST['trash']) and $_POST['trash'] == 1){
						$cond['cid'] = $_POST['cid'];
					}elseif(($_POST['this_page'] =='p=dashboard' or $_POST['this_page'] =='p=shared-links') and $_POST['cid'] > 0){
						$cond['cid'] = $_POST['cid'];
					}elseif(($_POST['this_page'] =='p=dashboard' or $_POST['this_page'] =='p=shared-links') and $_POST['cid'] == -2){
						$cond['cid'] = $_POST['cid'];
					}
				
				$result = $co->query_first($sql2,$cond);
				$offset = ($_POST['page'] - 1) * $_POST['item_per_page'];
				$sql .= " LIMIT ".$offset.",".$_POST['item_per_page'];
				
				$records = $co->fetch_all_array($sql,$cond);*/
				//echo count($records);
				/*if(isset($records) and count($records) > 0);
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
							<td style="width:30%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="'.$urlpost['shared_url_id'].'"></span> &nbsp; <a href="index.php?p=view_link&id='.$urlpost['shared_url_id'].'">'.((strlen($urlpost['url_value']) > 100) ? substr($urlpost['url_value'], 0, 10).'...' : $urlpost['url_value']).'</a></td>
							<td style="width:20%">'.$urlpost['email_id'].'</td>
							<td style="width:20%">'.((strlen($urlpost['url_desc']) > 10) ? substr($urlpost['url_desc'], 0, 10).'...' : $urlpost['url_desc']).'</td>
							<td style="width:20%">'.date('d/m/Y', $urlpost['shared_time']).'   '.date('h:i a', $urlpost['shared_time']).'</td>
						</tr>
						';	
					
				}	*/
				$page_link_option = '';
				/*$remainder = $result['total'] % $_POST['item_per_page'];
				if($remainder == 0){
					$page_link_option = 1;	
				}*/
				echo json_encode(array('page_link_option'=>$page_link_option, 'del_row'=>$_POST['share_url'], 'total_new_row'=>$result['total']));	
				//echo json_encode($_POST['share_url']);			
			}else if(isset($_POST['mark_as_print']) and $_POST['mark_as_print'] == 1){
				echo '<script type="text/javascript">window.location = "links_print/index.php?'.$link_urls.'="</script>';
				exit();	
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
			$sql = "select g.*, (SELECT COUNT(gf.groups_friends_id) FROM groups_friends gf, user_friends uf WHERE g.uid=uf.uid and uf.uid=gf.uid and gf.email_id=uf.fid and gf.groups=g.group_id and uf.status=1) as confirmed, (SELECT COUNT(gf2.groups_friends_id) FROM groups_friends gf2 WHERE g.uid=gf2.uid and gf2.groups=g.group_id) as total_friend from groups g WHERE g.group_id=:id";
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
					$group_info = $co->query_first($sql, $cond);
					$page = '';

					$empty_link = 'empty_links('.$_POST['id'].',0,\'group\');';	
					if($group_info['confirmed'] == 0)
						$empty_link= "error_dialogues('There is no friends in this group')";

					$new_row = '
						<td style="width:50%"><span><input type="checkbox" class="grouping" value="'.$group_info['group_id'].'" name="groups[]"></span> &nbsp; <a href="javascript: void(0);">'.$group_info['group_name'].'</a> <span>&nbsp; <a href="javascript: void(0);" onclick="load_edit_frm('.$group_info['group_id'].', \'group\')"><i class="fa fa-pencil"></i></a></span></td>
						<td style="width:20%"><a class="btn btn-sm" href="javascript: void(0);" onclick="'.$empty_link.'">Empty</a></td>
						<td class="text-center" style="width:15%">'.$group_info['confirmed'].'</td>
						<td class="text-center" style="width:15%">'.$group_info['total_friend'].'</td>
					
					';
					/*$msg = 'Folder updated successfully</div>';	*/
					$msg = 'Updated successfully!';	
		
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
					
					
					/* insert new group */
					$new_row = '';
					$groups_retrun = $co->get_all_groups_of_current_user($current['uid'],$_POST['item_per_page'], $_POST['this_page']);     
					$groups = $groups_retrun['row'];      		
					if(isset($groups) and count($groups) > 0){
						$j = 1;
						foreach($groups as $group_info){
							if($j == 1){
								$class_name = 'first_row';
								$j++;
							}else{
								$class_name = 'second_row text-bold';
								$j = 1;
							}														
							$new_row .= '
								<tr class="'.$class_name.'" id="record_'.$group_info['group_id'].'">
									<td style="width:50%"><span><input type="checkbox" class="grouping" value="'.$group_info['group_id'].'" name="groups[]"></span> &nbsp; <a href="javascript: void(0);">'.$group_info['group_name'].'</a> <span>&nbsp; <a href="javascript: void(0);" onclick="load_edit_frm('.$group_info['group_id'].', \'group\')"><i class="fa fa-pencil"></i></a></span></td>
									<td style="width:20%"><a class="btn btn-sm" href="javascript: void(0);" onclick="error_dialogues(\'There is no friends in this group\')">Empty</a></td>
									<td class="text-center" style="width:15%">0</td>
									<td class="text-center" style="width:15%">0</td>
							</tr>
							';
						}
					}
					/*end code*/
					/*$msg = 'Folder was added successfully.</div>';	*/
					$msg = 'Added successfully!';	
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
		if(isset($_POST['groups']) and count($_POST['groups']) > 0){
			foreach($_POST['groups'] as $group_id){
				/*$check_grp = $co->query_first("select group_id from `groups` WHERE uid=:uid and group_id=:id and defaults='0'",array('id'=>$group_id,'uid'=>$current['uid']));
				if(!(isset($check_grp['group_id']) and $check_grp['group_id'] > 0)){
					$error .= "The group which you are selected is not deleted.";
					$success = false;
					break;
				}*/
			}
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
				if(isset($records) and count($records) > 0){
					$j = 1;
					$new_row = '';
					foreach($records as $list){
						$sql = "select g.*, (SELECT COUNT(gf.groups_friends_id) FROM groups_friends gf, user_friends uf WHERE g.uid=uf.uid and uf.uid=gf.uid and gf.email_id=uf.fid and gf.groups=g.group_id and uf.status=1) as confirmed, (SELECT COUNT(gf2.groups_friends_id) FROM groups_friends gf2 WHERE g.uid=gf2.uid and gf2.groups=g.group_id) as total_friend from groups g WHERE g.group_id=:id";
						$group_info = $co->query_first($sql, array('id'=>$list['group_id']));
						$empty_link = '';
						//$total_url_in_cat = $co->query_first("select COUNT(url_id) as total from user_shared_urls where url_cat=:cat",array('cat'=>$list['cid'])); 
						//$empty_link = 'empty_links('.$list['cid'].');';	
						//	if($total_url_in_cat['total'] == 0)
						//		$empty_link= "error_dialogues('There is no links in this folder')";

						$empty_link = 'empty_links('.$list['group_id'].',0,\'group\');';	
						if($group_info['confirmed'] == 0)
							$empty_link= "error_dialogues('There is no friends in this group')";
					
						if($j == 1){									
							$class_name = 'first_row';
							$j++;	
						}else{
							$class_name = 'second_row';
							$j = 1;
						}
						
															
						$new_row .= '<tr class="'.$class_name.'" id="record_'.$list['group_id'].'">
							<td style="width:50%"><span><input type="checkbox" class="grouping" value="'.$list['group_id'].'" name="groups[]"></span> &nbsp; <a href="javascript: void(0);">'.$list['group_name'].'</a> <span>&nbsp; <a href="javascript: void(0);" onclick="load_edit_frm('.$list['group_id'].', \'group\')"><i class="fa fa-pencil"></i></a></span></td>
							<td style="width:20%"><a class="btn btn-sm" href="javascript: void(0);" onclick="'.$empty_link.'">Empty</a></td>
							<td class="text-center" style="width:15%">'.$group_info['confirmed'].'</td>
							<td class="text-center" style="width:15%">'.$group_info['total_friend'].'</td>
							</tr>
						';
							
							
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
				echo json_encode(array('del_row'=>$del_row,'page_link_option'=>$page_link_option,'new_row'=>$new_row,'msg'=>'Deleted successfully.','success'=>$success));
			}		
			
		}else{
			echo json_encode(array('msg'=>$error,'success'=>$success));
		}
		exit();	
	}
	
	if(isset($_POST['form_id']) and $_POST['form_id']=="invite_friend_again"){
		$current = $co->getcurrentuser_profile();
		if(!isset($_POST['share_url'])){
			echo json_encode(array('error'=>'Please select the request(s) you would like to invite'));
			exit();	
		}else{
			$invite_users = implode(',', $_POST['share_url']);
			$check_invitees = $co->query_first("SELECT COUNT(uf.friend_id) as total FROM `user_friends` uf, `friends_request` fr WHERE fr.request_id=uf.request_id and fr.request_time2>0 and uf.friend_id IN (".$invite_users.")", array());
			if(isset($check_invitees['total']) and $check_invitees['total']>0){
				echo json_encode(array('error'=>'You can not select those Requests which you already sent 3 times.'));
				exit();
			}

			$check_invitees = $co->query_first("SELECT COUNT(uf.friend_id) as total FROM `user_friends` uf, `friends_request` fr WHERE fr.request_id=uf.request_id and uf.status=1 and uf.friend_id IN (".$invite_users.")", array());
			if(isset($check_invitees['total']) and $check_invitees['total']>0){
				echo json_encode(array('error'=>'You can not invite those friend which are already confirmed.'));
				exit();
			}
		}

		$invitees = $co->fetch_all_array("SELECT fr.* FROM `user_friends` uf, `friends_request` fr WHERE fr.request_id=uf.request_id and uf.status!=1 and uf.friend_id IN (".$invite_users.")", array());
		$thisrequests = '';
		foreach ($invitees as $invitee) {
			$tim = time();
			if($invitee['request_time1']==0){
				$co->query_update('friends_request', array('request_time1'=>$tim), array('id'=>$invitee['request_id']), 'request_id=:id');	
			}elseif($invitee['request_time2']==0){
				$co->query_update('friends_request', array('request_time2'=>$tim), array('id'=>$invitee['request_id']), 'request_id=:id');	
			}
			$to = trim($invitee['request_email']);
			$subject = 'Friend request at Linkibag';
			$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$invitee['request_id'].'&request_code='.$invitee['request_code'];
			$from = 'info@linkibag.com';
			$message = $co->invite_mail_content($invitee['description'], $verified_link, $to);
			$co->send_email($to, $subject, $message, $from);
			$thisrequests .= ', '.$invitee['request_id'];
		}
		$_SESSION['dialog_success'] = 'Invited successfully!';
		echo json_encode(array('success'=>'1'));
		exit();
	}

	if(isset($_POST['form_id']) and $_POST['form_id']=="delete_pending_request"){
		$current = $co->getcurrentuser_profile();
		if(!isset($_POST['share_url'])){
			echo json_encode(array('error'=>'Please select the request(s) you would like to delete'));
			exit();	
		}
		$delete_invites = implode(',', $_POST['share_url']);

		$invitees = $co->fetch_all_array("SELECT fr.* FROM `user_friends` uf, `friends_request` fr WHERE fr.request_id=uf.request_id and uf.status!=1 and uf.friend_id IN (".$delete_invites.")", array());
		foreach ($invitees as $invitee) {
			$co->query_delete('friends_request', array('id'=>$invitee['request_id']), 'request_id=:id');	
			$co->query_delete('user_friends', array('id'=>$invitee['request_id']), 'request_id=:id');
		}
		echo json_encode(array('success'=>'1', 'del_row'=>$_POST['share_url'], 'del_row_count'=>count($_POST['share_url'])));
		exit();
	}

	if(isset($_POST['form_id']) and $_POST['form_id']=="move_to_cat_multiple"){
		$success = true;
		$current = $co->getcurrentuser_profile();
		$error = '';
		$total_friends = 0;
		$fgroup = 'no';
		if(isset($_POST['gid']))
			$fgroup = $_POST['gid'];

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
			$reloadme = 0;
			if(isset($_POST['share_url']) and count($_POST['share_url']) > 0){
				
				foreach($_POST['share_url'] as $share_url){
					$cond = array();
					if(isset($_POST['type']) and  $_POST['type'] == 'category'){
						$sql = "SELECT shared_url_id as ids FROM user_shared_urls WHERE shared_to=:uid and shared_url_id=:id";	
						$cond['uid'] = $current['uid'];
						$cond['id'] = $share_url;
					}else if(isset($_POST['type']) and  $_POST['type'] == 'group'){
						$sql = "select friend_id as ids,fid,request_id from user_friends where uid=:uid and friend_id=:id";	
						$cond['uid'] = $current['uid'];
						$cond['id'] = $share_url;
					}
					$result = $co->query_first($sql,$cond);
					if(isset($result['ids']) and $result['ids'] > 0){
						
						if(isset($_POST['type']) and  $_POST['type'] == 'category'){
							$co->query_update('user_shared_urls', array('url_cat'=>$_POST['cat']), array('id'=>$result['ids'],'id2'=>$current['uid']), 'shared_url_id=:id and shared_to=:id2');	
							$msg = 1;
							$get_folder = $co->query_first("select cname from category where cid=:id",array('id'=>$_POST['cat']));
							/*$msg_content = 'Link successfully moved !';	*/
							$msg_content = 'Item was moved to '.$get_folder['cname'].' successfully!';	
						}else if(isset($_POST['type']) and  $_POST['type'] == 'group'){
							/* check friend id is existed yes ya no code by jimmy on 18/09/18 */
							if(empty($result['fid'])){
								$chk_friend_request = $co->query_first("select request_email from `friends_request` WHERE request_by=:uid and request_id=:request_id",array('uid'=>$current['uid'], 'request_id'=>$result['request_id']));
								$result['fid'] = (isset($chk_friend_request['request_email']) and !empty($chk_friend_request['request_email'])) ? $chk_friend_request['request_email'] : '0';
							}
							// new code by jimmy on 24/07/18  for friend delete from groups when user click on delete button
							if(isset($_POST['group_delete']) and  $_POST['group_delete'] == 1){
								if($fgroup != 'no' and $fgroup != '0'){
									$co->query_delete('groups_friends', array('id'=>$result['fid'],'id2'=>$current['uid'],'gp'=>$fgroup), 'email_id=:id and uid=:id2 and groups=:gp');	
								}else{
									$co->query_delete('groups_friends', array('id'=>$result['fid'],'id2'=>$current['uid']), 'email_id=:id and uid=:id2');	
								}
								
								$msg = 1;
								$reloadme = 1;
								/* $msg_content = 'Friend successfully moved !';	*/
								/*$msg_content = 'Moved successfully!';	*/
								/*$msg_content = 'Success! Email was successfully deleted.';*/
								$msg_content = 'NOT_SHOW';
								
							}else if(isset($_POST['unfriend']) and  $_POST['unfriend'] == 0){
								$co->query_update('user_friends', array('fgroup'=>$_POST['cat']), array('id'=>$result['ids'],'id2'=>$current['uid']), 'friend_id=:id and uid=:id2');
								// new code	
								$already_exit_gp = $co->query_first("select group_id from groups WHERE uid=:uid and group_id=:id",array('uid'=>$current['uid'],'id'=>$_POST['cat']));
								if(!(isset($already_exit_gp['group_id']) and $already_exit_gp['group_id'] > 0))
									$already_exit_gp['group_id'] = $_POST['cat'];
									
								if(isset($already_exit_gp['group_id']) and $already_exit_gp['group_id'] != ''){
									$group_id = $already_exit_gp['group_id'];
									$gpms = $result['fid'];
									$already_exit_gp_friends = $co->query_first("select groups_friends_id from groups_friends WHERE groups=:groups and uid=:uid and email_id=:email_id",array('groups'=>$already_exit_gp['group_id'], 'uid'=>$current['uid'], 'email_id'=>$gpms));
									if(!(isset($already_exit_gp_friends['groups_friends_id']) and $already_exit_gp_friends['groups_friends_id'] > 0) and !empty($gpms)){
										$up_val = array();
										$up_val['uid'] = $current['uid'];
										$up_val['groups'] = $group_id;
										$up_val['email_id'] = $gpms;
										$up_val['created'] = time();
										$up_val['updated'] = time();				
										$up_val['status'] = 1;					
										$groups_members_id = $co->query_insert('groups_friends', $up_val);
										unset($up_val);
									}	
								}	
								
								// end code
								
								$msg = 1;
								/* $msg_content = 'Friend successfully moved !';	*/
								/*$msg_content = 'Moved successfully!';	*/
								/*$msg_content = 'Success! Email was successfully deleted.';*/
								$reloadme = 1;	
								$msg_content = 'NOT_SHOW';	
							}else if(isset($_POST['unfriend']) and  $_POST['unfriend'] == 1){
								$co->query_delete('groups_friends', array('id'=>$result['fid'],'id2'=>$current['uid']), 'email_id=:id and uid=:id2');
								$up_val = array();
								$up_val['uid'] = $current['uid'];
								$up_val['groups'] = -1;
								$up_val['email_id'] = $result['fid'];
								$up_val['created'] = time();
								$up_val['updated'] = time();				
								$up_val['status'] = 1;	
								$co->query_insert('groups_friends', $up_val);	
								unset($up_val);							
								/*
								for($i=0;$i<=1;$i++){
									//$co->query_delete('user_friends', array('id2'=>$current['uid'],'id3'=>$result['fid']), 'uid=:id2 and fid=:id3');
									$uid = $current['uid'];
									$current['uid'] = $result['fid'];
									$result['fid'] = $uid;
								}*/
								$msg = 1;
								/*$msg_content = 'Friend successfully unfriended !';	 */
								$msg_content = 'Unfriended successfully!';	
							}else if(isset($_POST['mark_as_unread']) and $_POST['mark_as_unread'] == 1){
								$result = $co->query_first("select request_id from friends_request WHERE request_to=:id and request_id=:request_id and status<'1'",array('id'=>$current['uid'], 'request_id'=>$result['request_id']));
								if(isset($result['request_id']) and $result['request_id'] > 0)
									$unread_requests[] = $share_url;
								
								$up_val = array();
								$up_val['read_status'] = 0;
								//$up_val['num_of_visits'] = 0;	
								$co->query_update('user_friends', $up_val, array('id'=>$share_url, 'uid'=>$current['uid']), 'friend_id=:id and uid=:uid');
								unset($up_val);
								$msg = 1;
								/*$msg_content = 'Successfully Requests unread';	 */
								$msg_content = 'Unread successfully!';	
							}
						}	
					}
				}
				if(isset($_POST['mark_as_unread']) and $_POST['mark_as_unread'] == 1){
					$total_friends = $co->users_count_friend($current['uid']); 
				}
				/*
				if(isset($unread_requests) and count($unread_requests) > 0){
					$_POST['share_url'] = array();
					foreach($unread_requests as $req){
						$_POST['share_url'][] = $req;	
					}
				}
				*/
				
				if(isset($_POST['mark_as_unread']) and $_POST['mark_as_unread'] == 1){
					$_POST['share_url'] = array();
					if(isset($unread_requests) and count($unread_requests) > 0){
						/*$msg_content = 'Successfully Requests unread';		*/
						$msg_content = 'Unread successfully!';		
						foreach($unread_requests as $req){
							$_POST['share_url'][] = $req;	
						}
					}else{
						$msg_content = 'No, Requests are yet.';	
					}
				}
				
				//new code by jimmy
				$i=1;                                
				$new_row = '';

				/*$new_row .= '	
							<td style="width:20%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="'.$list['friend_id'].'"></span> &nbsp; '.($list['first_name'] == '' ? 'N/A' : $list['first_name']).'</td>
							<td style="width:20%">'.$list['last_name'].'</td>*/


				/*if(isset($_POST['type']) and  $_POST['type'] == 'group'){	
					$fstatus = 1;
					if(isset($_POST['fstatus']))
						$fstatus = $_POST['fstatus'];
									
					$fgroup = 'no';
					if(isset($_POST['gid']))
						$fgroup = $_POST['gid'];
					$lists_of_all_friend = $co->list_all_friends_of_current_user($current['uid'], $fstatus, $_POST['item_per_page'], $_POST['this_page']);
					$lists_of_all_friends = $lists_of_all_friend['row']; 
					$j = 1;
					foreach($lists_of_all_friends as $list){	
						$cond = array();
						$sql = "SELECT g.group_name FROM `groups` g, `groups_friends` gf WHERE gf.uid=:uid and g.group_id=gf.groups and (gf.email_id=:email OR gf.email_id=:request_email)";
						$cond['uid'] = $current['uid'];
						$cond['email'] = $list['fid'];
						$cond['request_email'] = $list['request_email'];
						if($fgroup != 'no'){
							if($fgroup != 0){
                        		$sql .= " and gf.groups=:gid";
                        		$cond['gid'] = $fgroup;
                           }else{
                             // for ungrouped group
                              $sql .= " and gf.groups!=:gid";
                              $cond['gid'] = 0;
                           }
						}	
						$groups = $co->fetch_all_array($sql,$cond);


						$group_names =  array('Ungrouped');
						if(isset($groups) and count($groups) > 0){
							$group_names = '';
							foreach($groups as $gp){
								$group_names[] = $gp['group_name'];

							}
						}

						if($fgroup != 0){
                        	if(in_array('Ungrouped', $group_names) and $fgroup != 'no')
                              continue;
                        }else{
                           // for ungrouped group
                           if(!in_array('Ungrouped', $group_names) and $fgroup != 'no')
                              continue;
                        }

						
						$request_link = '#';
						if(($list['status'] > 0)){																	
							$read_status = ' read';																	
						}else{
							if(($list['request_to'] == $current['uid']))
								$request_link = 'index.php?p=request_response&id='.$list['request_id'];

							if(($list['read_status'] == 1))
								$read_status = ' read';																	
							else	
								$read_status = ' unread';																	
						}


						if($j == 1){	
							$new_row .= '
								<tr class="first_row'.$read_status.'" id="url_'.$list['friend_id'].'">';
							$j++;
						}else{
							$new_row .= '
								<tr class="second_row'.$read_status.'" id="url_'.$list['friend_id'].'">';

							$j = 1;
						}

						
							$new_row .= '
							<td style="width:25%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="'.$list['friend_id'].'"></span> &nbsp; '.date('m/d/Y', $list['date_time_created']).date('h:i a', $list['date_time_created']).'</td>
							<td style="width:25%"><a href="'.$request_link.'">';
							if(($list['request_to']>0)){
							 	$new_row .= $list['email_id'];
							}else{
								$new_row .= $list['request_email'];
							}
						$new_row .= '		
							</a></td>
							<td style="width:25%"><a href="javascript: void(0);">'.(implode(",", $group_names)).'</a></td>
							<td style="width:25%">';

							if(($list['status'] == 0)){
								$status = 'Pending'; 
							}else if(($list['status'] == 1)){
                           		$status = 'Confirmed'; 
                           	}else if(($list['status'] == 2)){
								$status = 'Declined'; 
							}else{
								$status = date('M d, Y', strtotime($list['date']));
							}
						

						$new_row .= (($status == 'Confirmed') ? 'Linki Friend' : '').'</td></tr>';
						$i++; 	
					}
					if($i == 1)   
                    	$new_row .= '<tr><td colspan="4">No, record found</td></tr>';	
				}*/	

				//end code by jimmy

				echo json_encode(array('msg'=>$msg,'new_row'=>$new_row,'msg_content'=>$msg_content,'share_url'=>$_POST['share_url'], 'total_unread'=>$total_friends, 'reloadme'=>$reloadme));
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
			$already_exit_cat = $co->query_first("select cid from category WHERE uid=:id and cname=:name and cid!=:cid",array('id'=>$current['uid'],'name'=>$_POST['cname'],'cid'=>$_POST['id']));
			if($already_exit_cat['cid'] > 0){
				$error .= "This folder is already existed, try another <br/>";
				$success = false;	
			}
		}else{	
			$already_exit_cat = $co->query_first("select cid from category WHERE uid=:id and cname=:name",array('id'=>$current['uid'],'name'=>$_POST['cname']));
			if($already_exit_cat['cid'] > 0){
				$error .= "This folder is already existed, try another <br/>";
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
							$empty_link= "error_dialogues('There is no links in this folder')";
					$new_row = '
						<td style="width:62%"><span><input type="checkbox" class="grouping" value="'.$cat_info['cid'].'" name="categories[]"></span> &nbsp; <a href="index.php?p=mylinks&cid='.$cat_info['cid'].'">'.$cat_info['cname'].'</a> <span>&nbsp; <a href="javascript: void(0);" onclick="load_edit_frm('.$cat_info['cid'].', \'category\')"><i class="fa fa-pencil"></i></a></span></td>
						<td style="width:10%"><a class="btn btn-sm" href="javascript: void(0);" onclick="'.$empty_link.'">Empty</a></td>						
						<td class="text-center" style="width:20%">'.$total_url_in_cat['total'].'</td>
					';	
					/*$msg = 'Folder updated successfully';	*/
					$msg = 'Updated successfully!';
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
						$categories_post = $co->fetch_all_array("select * from category where uid IN (:id) ORDER BY cid DESC",array('id'=>$current['uid']));    
						$option .= '<option value="">Select Folder</option>
									<option value="-2">Inbag</option>';
						foreach($categories_post as $catpost){
							$sel = '';
							if($cat_info['cid'] == $catpost['cid'])
								$sel = ' selected="selected"';
							$option .= '<option value="'.$catpost['cid'].'"'.$sel.'>'.$catpost['cname'].'</option>';
						}	

					}	
					
					$new_row = '';
					$j = 1;
					/* insert new row*/
					$categories_list = $co->show_all_category_of_current_user($current['uid'],$_POST['item_per_page'],$_POST['this_page']);      	
					$categories = $categories_list['row'];

					if(isset($categories) and count($categories) > 0){
						foreach($categories as $cat_info){ 								
							if($j == 1){
								$class_name = 'first_row';
								$j++;
							}else{
								$class_name = 'second_row text-bold';
								$j = 1;
							}


					/* end code */
					$new_row .='
						<tr class="'.$class_name.'" id="record_'.$cat_info['cid'].'">	
							<td style="width:62%"><span><input type="checkbox" class="grouping" value="'.$cat_info['cid'].'" name="categories[]"></span> &nbsp; <a href="index.php?p=mylinks&cid='.$cat_info['cid'].'">'.$cat_info['cname'].'</a> <span>&nbsp; <a href="javascript: void(0);" onclick="load_edit_frm('.$cat_info['cid'].', \'category\')"><i class="fa fa-pencil"></i></a></span></td>
							<td style="width:10%"><a class="btn btn-sm" href="javascript: void(0);" onclick="error_dialogues(\'There is no links in this folder\')">Empty</a></td>						
							<td class="text-center" style="width:20%">0</td>
						</tr>
					';
						}
					}
					/*$msg = 'Folder was added successfully.';	*/
					$msg = 'Added successfully!';
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
	
	if(isset($_POST['form_id']) and $_POST['form_id']=="add_public_category"){
		$success = true;
		$current = $co->getcurrentuser_profile();
		$error = '';
		if(isset($_POST['id']) and $_POST['id'] > 0){
			$already_exit_cat = $co->query_first("select cid from user_public_category WHERE uid=:id and cname=:name and cid!=:cid",array('id'=>$current['uid'],'name'=>$_POST['cname'],'cid'=>$_POST['id']));
			if($already_exit_cat['cid'] > 0){
				$error .= "This folder is already existed, try another <br/>";
				$success = false;	
			}
		}else{	
			$already_exit_cat = $co->query_first("select cid from user_public_category WHERE uid=:id and cname=:name",array('id'=>$current['uid'],'name'=>$_POST['cname']));
			if($already_exit_cat['cid'] > 0){
				$error .= "This folder is already existed, try another <br/>";
				$success = false;	
			}
		}	
		if($success == true){
			$cond = array();
			$sql = "select * from user_public_category WHERE cid=:id";
			if(isset($_POST['id']) and $_POST['id'] > 0){
				$up_val = array();
				$up_val['cname'] = $_POST['cname'];
				$up_val['updated_time'] = time();				
				$up_val['status'] = 0;				
				$co->query_update('user_public_category', $up_val, array('id'=>$_POST['id'], 'uid'=>$current['uid']), 'cid=:id and uid=:uid');
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
				$category_id = $co->query_insert('user_public_category', $up_val);
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
							$empty_link= "error_dialogues('There is no links in this folder')";
					$new_row = '
						<td style="width:62%"><span><input type="checkbox" class="grouping" value="'.$cat_info['cid'].'" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid='.$cat_info['cid'].'">'.$cat_info['cname'].'</a> <span>&nbsp; <a href="javascript: void(0);" onclick="load_edit_frm('.$cat_info['cid'].', \'category\')"><i class="fa fa-pencil"></i></a></span></td>
						<td style="width:10%"><a class="btn btn-sm" href="javascript: void(0);" onclick="'.$empty_link.'">Empty</a></td>						
						<td class="text-center" style="width:20%">'.$total_url_in_cat['total'].'</td>
					';	
					/*$msg = 'Category updated successfully';	*/
					$msg = 'Updated successfully!';
				}else{
					$result = $co->query_first("select COUNT(cid) as total from user_public_category where uid=:uid",array('uid'=>$current['uid']));
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
						$user_public_categories_post = $co->fetch_all_array("select * from user_public_category WHERE status='1'",array()); 
						foreach($user_public_categories_post as $catpost){
							$sel = '';
							if($cat_info['cid'] == $catpost['cid'])
								$sel = ' selected="selected"';
							$option .= '<option value="'.$catpost['cid'].'"'.$sel.'>'.$catpost['cname'].'</option>';
						}

					}	
					if(isset($_SESSION['num_of_times']) and $_SESSION['num_of_times'] == 2){
						unset($_SESSION['num_of_times']);
						$new_row = '<tr class="first_row" id="record_'.$cat_info['cid'].'">';
					}else{
						$new_row = '<tr class="second_row text-bold" id="record_'.$cat_info['cid'].'">';
					}
					
					$new_row .='	
						<td style="width:62%"><span><input type="checkbox" class="grouping" value="'.$cat_info['cid'].'" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid='.$cat_info['cid'].'">'.$cat_info['cname'].'</a> <span>&nbsp; <a href="javascript: void(0);" onclick="load_edit_frm('.$cat_info['cid'].', \'category\')"><i class="fa fa-pencil"></i></a></span></td>
						<td style="width:10%"><a class="btn btn-sm" href="javascript: void(0);" onclick="error_dialogues(\'There is no links in this category\')">Empty</a></td>						
						<td class="text-center" style="width:20%">0</td>
					</tr>
					';
					/*$msg = 'Category was added successfully.';	*/
					$msg = 'Added successfully!';	
				}		
				echo json_encode(array('new_row'=>$new_row,'msg'=>$msg,'id'=>$id, 'public_cat_option'=>$option, 'success'=>$success,'page_link_option'=>$page_link_option));
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
			$error .= "Please select atleast one folder";
			$success = false;	
		}
		if(isset($_POST['categories']) and count($_POST['categories']) > 0){
			foreach($_POST['categories'] as $category_id){
				$check_cat = $co->query_first("select cid from `category` WHERE uid=:uid and cid=:id",array('id'=>$category_id,'uid'=>$current['uid']));
				if(!(isset($check_cat['cid']) and $check_cat['cid'] > 0)){
					$error .= "The folder which you are selected is not deleted.";
					$success = false;
					break;
				}
			}
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
							$empty_link= "error_dialogues('There is no links in this folder')";

					if($j == 1){									
						$class_name = 'first_row';
						$j++;	
					}else{
						$class_name = 'second_row';
						$j = 1;
					}
																			
					$new_row .= '<tr class="'.$class_name.'" id="record_'.$list['cid'].'">
						<td style="width:62%"><span><input type="checkbox" class="grouping" value="'.$list['cid'].'" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid='.$list['cid'].'">'.$list['cname'].'</a> <span>&nbsp; <a href="javascript: void(0);" onclick="load_edit_frm('.$list['cid'].', \'category\')"><i class="fa fa-pencil"></i></a></span></td>
						<td style="width:10%"><a class="btn btn-sm" href="javascript: void(0);" onclick="'.$empty_link.'">Empty</a></td>						
						<td class="text-center" style="width:20%">'.$total_url_in_cat['total'].'</td>
						</tr>
					';
				
					
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
				echo json_encode(array('del_row'=>$del_row,'page_link_option'=>$page_link_option,'new_row'=>$new_row,'msg'=>'Deleted successfully.','success'=>$success));
			}		
		}else{
			echo json_encode(array('msg'=>$error,'success'=>$success));
		}
		exit();	
	}
	
	if(isset($_POST['form_id']) and $_POST['form_id']=="add_subscription"){
		$success=true;
		if(!isset($_POST['subs_account_type'])){
			$co->setmessage("error", "Please choose account type");
			$success=false;
		}else if(isset($_POST['subs_account_type']) and $_POST['subs_account_type'] == ''){
			$co->setmessage("error", "Please choose account type");
			$success=false;
		}else if(isset($_POST['subs_account_type']) and $_POST['subs_account_type'] == 1){
			$co->setmessage("error", "Invalid account type");
			$success=false;
		}
		if(!(isset($_POST['subs_account_type']) and $_POST['subs_account_type'] == 1)){
			if(!isset($_POST['paygate'])){
				$co->setmessage("error", "Please choose payment type");
				$success=false;
			}
		}
		
		if(!isset($_POST['terms'])){
			$co->setmessage("error", "Please choose terms and conditions");
			$success=false;
		}
		
		if($success==true){
			$item_name = array('','', 'Business Account', 'Institutional Account');
			$item_price = array('','', 97.49, 47.99);
			$current = $co->getcurrentuser_profile();
			$up = array();
			$up['subs_package'] = $_POST['subs_account_type'];
			$up['subs_uid'] = $current['uid'];
			$result = $co->query_first("select * from subscription where subscription_id=:id",array('id'=>$_POST['subs_account_type']));
			$up['subs_amt'] = $result['price'];
			$up['subs_start_date'] = date('Y-m-d');
			$up['subs_end_date'] = $oneYearOn = date('Y-m-d',strtotime(date("Y-m-d", time()) . " + 365 day"));
			$up['subs_created'] = time();
			$up['subs_updated'] = time();
			$up['subs_status'] =0;
			$order_id = $co->query_insert('user_subscriptions', $up);
			unset($up);
			
			if(isset($_SESSION['coupon_discount']) and $_SESSION['coupon_discount']>0)
				$item_price[$_POST['subs_account_type']] = (($item_price[$_POST['subs_account_type']] * (100 - $_SESSION['coupon_discount']))/100);
			
			$item_price[$_POST['subs_account_type']] = ceil($item_price[$_POST['subs_account_type']]);
			if($_POST['paygate']=="paypal_basic"){
				/*$form_name = $co->query_first("SELECT * FROM form_submitted WHERE form_id=:id", array('id'=>$cart_item_form_id));
				
				$application_name = 'ILFT Software Package Fee<br />';
				if($form_name['form_name']=="i90")
					$application_name .= 'Form - I90<br />';
				if($form_name['form_name']=="n400")
					$application_name .= 'Form - N400<br />';
				*/
				//$pay_id = $co->insert_payment_information($current, "", "", $total_cost, $_POST, $cart_items, 0);
				
				require_once('paypal.class.php');  // include the class file
				$pay_object = new paypal_class();             // initiate an instance of the class
				$pay_object->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
				//$pay_object->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
				//$pay_object->add_field('business', 'jimmyrana786@gmail.com');
				$pay_object->add_field('business', 'info@wishmatcher.com');
				$pay_object->add_field('return', WEB_ROOT.'/paypal.php?action=success');
				$pay_object->add_field('cancel_return', WEB_ROOT.'/paypal.php?action=cancel');
				$pay_object->add_field('notify_url', WEB_ROOT.'/paypal.php?action=ipn');
				$pay_object->add_field('item_name', $item_name[$_POST['subs_account_type']]);
				$pay_object->add_field('invoice', $order_id);
				$pay_object->add_field('amount', $item_price[$_POST['subs_account_type']]);

				$pay_object->submit_paypal_post(); // submit the fields to paypal
				
			}
			exit();
			$co->setmessage("status", "Your information submitted successfully");
			//echo '<script type="text/javascript">window.location.href="index.php?p=url-detail&id='.$_POST['id'].'"</script>';
			//exit();	
		}		
	}
	
	if(isset($_POST['form_id']) and $_POST['form_id']=="interested_cats"){		
		$success=true;
		$current = $co->getcurrentuser_profile();
		$_SESSION['MSG'] = '';	
		if(!isset($_POST['cats'])){
			//$co->setmessage("error", "Please choose at least 3 categories");
			$_SESSION['MSG'] .= '<div style="color: red;">Please choose at least 3 categories</div>';	
			$success=false;
		}else if(isset($_POST['cats']) and count($_POST['cats']) < 3){
			//$co->setmessage("error", "Please choose at least 3 categories");
			$success=false;
			$_SESSION['MSG'] .= '<div style="color: red;">Please choose at least 3 categories</div>';	
		}
		
		if($success==true){
			if(isset($_POST['cats']) and count($_POST['cats']) >0){
				foreach($_POST['cats'] as $list){
					if($list != ''){
						$up = array();
						$up['cat'] = $list;
						$up['uid'] = $current['uid'];
						$up['created'] = time();
						$up['updated'] = time();
						$up['status'] = 1;
						$co->query_insert('interested_category', $up);
						unset($up);	
					}
				}
			}
			//$co->setmessage("status", "Success! thank you for your submission.");
			$_SESSION['MSG'] .= '<div style="color: #e6bc81;">Success! thank you for your submission.</div>';
			//echo '<script type="text/javascript">window.location.href="index.php?p=categories-list"</script>';
			//exit();	
		}		
	}
	

	if(isset($_POST['form_id']) and $_POST['form_id']=="update_cats"){		
		$success=true;
		$current = $co->getcurrentuser_profile();
		$_SESSION['MSG'] = '';	
		if(!isset($_POST['cats'])){
			//$co->setmessage("error", "Please choose at least 3 categories");
			$_SESSION['MSG'] .= '<div style="color: red;">Please choose at least 3 categories</div>';	
			$success=false;
		}else if(isset($_POST['cats']) and count($_POST['cats']) < 3){
			//$co->setmessage("error", "Please choose at least 3 categories");
			$success=false;
			$_SESSION['MSG'] .= '<div style="color: red;">Please choose at least 3 categories</div>';	
		}
		
		if($success==true){
			$co->query_delete('interested_category', array('id'=>$current['uid']),'uid=:id');
			if(isset($_POST['cats']) and count($_POST['cats']) >0){
				foreach($_POST['cats'] as $list){
					if($list != ''){
						$up = array();
						$up['cat'] = $list;
						$up['uid'] = $current['uid'];
						$up['created'] = time();
						$up['updated'] = time();
						$up['status'] = 1;
						
						
						$co->query_insert('interested_category', $up);
						unset($up);
						
					}
				}
			}
			//$co->setmessage("status", "Success! thank you for your submission.");
			$_SESSION['MSG'] .= '<div style="color: #e6bc81;">Success! thank you for your submission.</div>';
			//echo '<script type="text/javascript">window.location.href="index.php?p=categories-list"</script>';
			//exit();	
		}		
	}
	
	
	
	if(isset($_POST['form_id']) and $_POST['form_id']=="get_coupon_discount"){		
		$success=true;		
		if($_POST['coupon_code'] == ''){
			$co->setmessage("error", "Please enter coupon code");
			$success=false;
		}
		
		if($success==true){
			$get_coupon_code = $co->query_first("SELECT * FROM coupon_disount WHERE coupon_code=:coupon", array('coupon'=>$_POST['coupon_code']));
			
			if(isset($get_coupon_code['discount_id']) and $get_coupon_code['discount_id'] >0){
				$_SESSION['coupon_code'] = $get_coupon_code['coupon_code'];
				$_SESSION['coupon_discount'] = $get_coupon_code['coupon_discount'];
				$co->setmessage("status", "Your coupon discount is ". $get_coupon_code['coupon_discount'] ." %");
				echo '<script type="text/javascript">window.location.href="index.php?p=renew"</script>';
				exit();	
			}else{
				$co->setmessage("error", "Coupon code is invalid");
			}
			
		}		
	}

	if(isset($_POST['form_id']) and $_POST['form_id']=="newsletter_us"){
		$_POST['email_id'] = trim($_POST['email_id']);
		$_POST['email_id'] = strip_tags($_POST['email_id']);
		
		
		$success=true;
		$msg = '';
		if($_POST['email_id']==""){
			$msg .= "Please enter email address";
			$success=false;
		}else{
			$result = $co->query_first("SELECT * FROM newsletters WHERE email_id=:email", array('email'=>$_POST['email_id']));
			
			$email = $_POST['email_id'];
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$msg .= "Please use user@gmail.com format to send your message";
				$success=false;
			}else if(isset($result['email_id']) and $result['email_id'] != ''){
				$msg .= "Email address is already exist, try another";
				$success=false;
			}
		}	
		
		
		if($success==true){
			$email = @trim(stripslashes($_POST['email_id'])); 
			$subject = 'Newsletter at Linkibag'; 
			$message = @trim(stripslashes('Dear sir '.$email.' wants to connect you.')); 
			
			$up = array();
			$up['email_id'] = $email;
			$up['subject'] = $subject;
			$up['message'] = $message;
			
			
			$up['created'] = time();
			$up['updated'] = time();
			$up['status'] = 1;
			$co->query_insert('newsletters', $up);
			unset($up);
			
			$email_from = $_POST['email_id'];
			
				$email_to = 'info@linkibag.com,jimmyrana786@gmail.com';//replace with your email
			//$email_from = 'info@linkibag.com';
			
			//	$email_to = $_POST['email_id'];//replace with your email
			
			$body = 'Email: ' . $email . "\n\n"  . 'Message: ' . $message . "\n\n"  ;
			
			//@mail($email_to, $subject, $body, 'From: <'.$email_from.'>');

			$message = @trim(stripslashes('Dear '.$email.' welcome to LinkiBag, you have created newletter at LinkiBag portal.')); 

			$body = 'Email: ' . $email . "\n\n"  . 'Message: ' . $message . "\n\n"  ;

			//@mail($email_from, $subject, $body, 'From: <'.$email_to.'>');


			$curl = curl_init(); 
			curl_setopt_array($curl, array( 
				CURLOPT_URL => "https://api.sendinblue.com/v3/contacts", 
				CURLOPT_RETURNTRANSFER => true, 
				CURLOPT_ENCODING => "", 
				CURLOPT_MAXREDIRS => 10, 
				CURLOPT_TIMEOUT => 30, 
				CURLOPT_HTTP_VERSION => 
				CURL_HTTP_VERSION_1_1, 
				CURLOPT_CUSTOMREQUEST => "POST", 
				CURLOPT_POSTFIELDS => '{"email": "'.$email.'", "emailBlacklisted":false,"smsBlacklisted":false,"updateEnabled":false}', 
				CURLOPT_HTTPHEADER => array( "accept: application/json", "api-key: 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", "content-type: application/json" ), 
			)); 
			$response = curl_exec($curl); 
			$err = curl_error($curl); 
			curl_close($curl); 
			//if ($err) { echo "cURL Error #:" . $err; } 
			//else { echo $response; }


			$msg .= "Success. Thank you for subscribing!";	
		}

		echo json_encode(array('msg'=>$msg,'success'=>$success));
		exit();		
	}

	if(isset($_POST['form_id']) and $_POST['form_id']=="url_submission_multiple"){
		$current = $co->getcurrentuser_profile();	
		$success = true;
		$urls=$_POST['url_value'];
		$ups_arr = array();
		$msg = '';
		$redirect_to = '';
		
		if(!(isset($current['uid']) and $current['uid'] > 0)){
			$redirect_to = "index.php?#free_singup";
			$_SESSION['selected_urls_from_view_share_page'] = $urls;
			if(isset($_SESSION['selected_urls_from_view_share_page']) and count($_SESSION['selected_urls_from_view_share_page']) > 0)
				$msg .= "We have saved selected URLs, it will added to you inbag after registration process completed. <br/>";

			echo json_encode(array('msg'=>$msg,'success'=>$success,'redirect_to'=>$redirect_to));
			exit();	
		}	
		if(!isset($urls) OR count($urls)==0){
			$msg .= "Please select URLs";
			$success=false;
		}else{
			$pattern_1 = "/(?:http|https)?(?:\:\/\/)?(?:www.)?(([A-Za-z0-9-]+\.)*[A-Za-z0-9-]+\.[A-Za-z]+)(?:\/.*)?/im";
			foreach($urls as $val){
				$get_url = $co->query_first("SELECT us.*,ur.* FROM `user_shared_urls` us INNER JOIN `user_urls` ur ON ur.url_id=us.url_id WHERE us.shared_url_id=:id",array('id'=>$val));
				$url = $get_url['url_value'];
				if(!preg_match($pattern_1, $url)){			
					$msg .= "Please enter valid url <br/>";
					$success=false;
				}else{
					if(!preg_match("~^(?:f|ht)tps?://~i", $url)) {
						$url = "http://" . $url;
					}
					
					/*
					$url_headers = @get_headers($url);
					if(strpos($url_headers[0],'200')===false) {
					    $msg .= "This webpage is not available. Please check it and try again <br/>";
						$success=false;
					}*/
					if(!$co->urlExists($url)){
						$msg .= "You are saving an invalid URL. This website ".$url." is not accessible. Would you like to revise it? <br/>";
						$success=false;
					}else{
						//virus total
						$ch = curl_init();

						$timeout = 0; // set to zero for no timeout	
						/*initial testing api key 8e6a84d54bc1d473138d806c2b7946b96f28d82d2b8c489a94c62c690235feda */	
						$myHITurl = "https://www.virustotal.com/vtapi/v2/url/report?apikey=e85cac3f3f8fe3d0dc8163c63a89b1ecfa26231aef16ab8d26f2326b62434ead&resource=".$url;

						curl_setopt ($ch, CURLOPT_URL, $myHITurl);

						curl_setopt ($ch, CURLOPT_HEADER, 0);

						curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

						curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

						$file_contents = curl_exec($ch);

						$curl_error = curl_errno($ch);

						curl_close($ch);

						//dump output of api if you want during test

						//echo "$file_contents";

						// lets extract data from output for display to user and for updating databse

						$file_contents = (json_decode($file_contents, true));
						//end code
						if($file_contents['response_code'] != 1){
							$msg .= "This webpage has virus. Please check it and try again <br/>";
							$success=false;
						}else{
							$up = array();
							$up['url_title'] = 'test';
							$up['url_value'] = $url;
							
							//$up['url_cat'] = serialize($category_id);
							//$up['url_cat'] = $get_url['url_cat'];
							$up['url_cat'] = -2;
							$up['url_desc'] = $get_url['url_desc'];
							//$up['status'] = $get_url['status'];
							$up['status'] = 1;
							//$up['share_type'] = $get_url['share_type'];
							//$up['public_cat'] = $get_url['public_cat'];
							//for pending approval
							//$up['add_to_search_page'] = $get_url['add_to_search_page'];
							//$up['search_page_status'] = $get_url['search_page_status'];
						
							$up['ip_address'] = $get_url['ip_address'];
										
							//$up['is_video_link'] = $get_url['is_video_link'];
							//$up['video_id'] = $get_url['video_id'];
							//$up['video_web'] = $get_url['video_web'];
							//$up['video_embed_code'] = $get_url['video_embed_code'];
							
							$up['uid'] = $current['uid'];
							$up['created_time'] = time();
							$up['updated_time'] = time();
							$up['created_date'] = date('Y-m-d');
							$up['updated_date'] = date('Y-m-d');
							//$up['permalink'] = $get_url['permalink'];
							//$up['scan_id'] = $get_url['scan_id'];
							//$up['total_scans'] = $get_url['total_scans'];
							$ups_arr[] = $up;		
							unset($up);
						}	
					}
				}							
			}
		}	
		
		
		if($success==true){
			foreach($ups_arr as $new_vals){
				$inserted_url = $co->query_insert('user_urls', $new_vals);
				$new_val = array();
				$new_val['uid'] = $current['uid'];
				$new_val['shared_to'] = $current['uid'];
				$new_val['url_id'] = $inserted_url;
				$new_val['url_cat'] = -2;
				//$new_val['url_cat'] = $new_vals['url_cat'];
				$new_val['shared_time'] = time();
				$co->query_insert('user_shared_urls', $new_val);
				unset($new_val);		
			}
			
			
			//$msg .= "Selected URLs are added your inbag successfully <br/>";
			$redirect_to = "index.php?p=dashboard";
				
		}

		echo json_encode(array('msg'=>$msg,'success'=>$success,'redirect_to'=>$redirect_to));
		exit();				
	}

	if(isset($_POST['form_id']) and $_POST['form_id']=="scan_results"){							
		if($_POST['shared_url_id'] > 0){						
			$current = $co->getcurrentuser_profile();  	
			$url_info = $co->query_first("select us.shared_url_id from `user_urls` ur, `user_shared_urls` us where us.url_id=ur.url_id and us.shared_url_id=:urls and us.shared_to=:uid",array('uid'=>$current['uid'],'urls'=>$_POST['shared_url_id']));
			if(isset($url_info['shared_url_id']) and $url_info['shared_url_id'] > 0){
				$up = array();
				$up['scan_result_show'] = $_POST['scan_result_show'];
				$up['scan_result_show_time'] = time();
				$co->query_update('user_shared_urls', $up, array('id'=>$url_info['shared_url_id']), 'shared_url_id=:id');
				unset($up);
				echo 'success';
					
			}

		}	
		
	}

	if(isset($_POST['form_id']) and $_POST['form_id']=="register_other_country"){								
		$_POST['email_id'] = trim($_POST['email_id']);
		$_POST['email_id'] = strip_tags($_POST['email_id']);
		
		
		$success=true;
		$msg = '';
		$redirect_to = '';
		
			
		//check if email_id empty
		if($_POST['email_id']==""){
			/*$co->setmessage("error", "Please enter email");*/
			$msg .= "Please enter email <br/>";
			$success=false;
		}
		
		
		
		if(!isset($_POST['country']) or (isset($_POST['country']) and $_POST['country'] == '')){
			$msg .= "Please select country";
			$success=false;
		}
		
		//check if no error
		if($success==true){			
			$new_val = array();
			$new_val['email'] = $_POST['email_id'];
			$new_val['country'] = $_POST['country'];
			$new_val['created'] = time();
			$new_val['updated'] = time();
			$new_val['status'] = 1;
			$co->query_insert('outside_linkibag_service_area', $new_val);
			unset($new_val);

			$msg .= "Thank you! Your message has been sent.";
			
		}

		echo json_encode(array('msg'=>$msg,'success'=>$success,'redirect_to'=>$redirect_to));
		exit();					
	}

	if(isset($_POST['form_id']) and $_POST['form_id']=="url_submission_update_only_share_type"){		
		$current = $co->getcurrentuser_profile();  					
		$success=true;
		$msg = '';
		$redirect_to = '';
		$row = $co->query_first("SELECT ur.share_type,ur.public_cat,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,us.shared_url_id,us.shared_time,us.shared_to,us.url_cat FROM user_urls ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:uid and us.shared_url_id=:id ORDER BY us.shared_url_id DESC", array('uid'=>$current['uid'], 'id'=>$_POST['id']));
			
		//check if email_id empty
		if(!(isset($row['shared_url_id']) and $row['shared_url_id'] > 0)){
			$msg .= "Wrong value submitted <br/>";
			$success=false;
		}
		if($_POST['share_type']==""){
			$msg .= "Please select share type <br/>";
			$success=false;
		}
		
		
		
		//check if no error
		if($success==true){			
			$new_val = array();
			$new_val['share_type_change'] = $_POST['share_type'];
			$new_val['public_cat_change'] = $_POST['public_cat'];
			if($_POST['share_type'] == 3 or $_POST['public_cat'] > 8){
				$new_val['add_to_search_page_change'] = 1;
				$new_val['search_page_status_change'] = 0;
			}
			
			$co->query_update('user_shared_urls', $new_val, array('id'=>$row['shared_url_id'], 'uid'=>$current['uid']), 'shared_url_id=:id and shared_to=:uid');
			unset($new_val);

			$msg .= "Share type was updated successfully.";
			
		}

		echo json_encode(array('msg'=>$msg,'success'=>$success,'redirect_to'=>$redirect_to));
		exit();					
	}

	if(isset($_POST['form_id']) and $_POST['form_id']=="add_multiple_users"){	
		$current = $co->getcurrentuser_profile();
		if(!isset($_FILES['userfile']['tmp_name'])){
			echo json_encode(array('res'=>'error','msg'=>'<div class="alert alert-danger">File upload is required</div>'));
			exit();
		}
		$allowedExts = array("doc", "docx", "txt", "rtf");
		/*, "xls", "xlsx"*/
		$explode_name = explode(".", $_FILES["userfile"]["name"]);
	    $extension = end($explode_name);
	    if(!in_array($extension, $allowedExts)){
	    	echo json_encode(array('res'=>'error','msg'=>'<div class="alert alert-danger">Only txt, rtf, xls. xlsx, doc, docx format files are accepted</div>'));
	    	exit();
	    }
	    $destination = 'files/additional_users/file'.$current['uid'].'_'.time().'.'.$extension;
	    move_uploaded_file($_FILES['userfile']['tmp_name'], $destination);
	    if($extension=='doc' or $extension=='docx'){
	    	$file_texts = $co->kv_read_word($destination);
	    }elseif($extension=='xls' or $extension=='xlsx'){
	    	//$file_texts = $co->getexcel_content($destination);
	    }elseif($extension=='rtf'){
	    	$file_texts = $co->rtftotext($destination);
	    }elseif($extension=='txt'){
	    	$file_texts = $co->get_txt_content($destination);
	    }
	    
		if($file_texts !== false) {


			$emails_ids = explode(',', $file_texts);

			foreach($emails_ids as $email_ids){
				$email_ids = trim($email_ids);
				$email_ids = strip_tags($email_ids);
				$result = $co->query_first("SELECT uid,remove_profile FROM `users` WHERE email_id=:id",array('id'=>$email_ids));
				$already_send_request = $co->query_first("SELECT * FROM `friends_request` WHERE request_by=:uid and request_to=0 and status=0 and request_email=:uid2",array('uid'=>$current['uid'],'uid2'=>$email_ids)); 
				if($result['uid'] > 0){
					$chk_already_your_friend = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:id and fid=:fid and status=1",array('id'=>$current['uid'],'fid'=>$result['uid']));		
				}
				
				if(filter_var($email_ids, FILTER_VALIDATE_EMAIL) === false){
					echo json_encode(array('res'=>'error','msg'=>'<div class="alert alert-danger">Please use user@gmail.com format to send your invite</div>'));
	    			exit();
				}
				if(isset($already_send_request['request_time2']) and $already_send_request['request_time2'] > 0){
					echo json_encode(array('res'=>'error','msg'=>'<div class="alert alert-danger">You extended maximum number of attempts to invite the following user. You send maximum of 3 invites. User name: '.$email_ids.'</div>'));
	    			exit();
				}
				if(isset($result['uid']) and $result['remove_profile']!=0){
					echo json_encode(array('res'=>'error','msg'=>'<div class="alert alert-danger">You can not send friend request to '.$email_ids.'</div>'));
	    			exit();
				}
				
				if(isset($result['uid']) and $result['uid'] == $current['uid']){
					echo json_encode(array('res'=>'error','msg'=>'<div class="alert alert-danger">You can not send friend request yourself</div>'));
	    			exit();
				}
				if(isset($chk_already_your_friend['friend_id']) and $chk_already_your_friend['friend_id'] > 0){
					echo json_encode(array('res'=>'error','msg'=>'<div class="alert alert-danger">'.'.$email_ids.'.' This user is already in your friend list</div>'));
	    			exit();
				}	
			}


			foreach($emails_ids as $email_ids){
				$result = $co->query_first("SELECT uid,remove_profile FROM `users` WHERE email_id=:id",array('id'=>$email_ids));
				$check_already_request = $co->query_first("SELECT * FROM `friends_request` WHERE request_email=:email_id and request_by=:request_by",array('email_id'=>$email_ids, 'request_by'=>$current['uid']));
				$description = 'LinkiBag user '.$current['email_id'].' invites you to join LinkiBag. How exciting! You both are members of LinkiBag! Add '.$current['email_id'].' to your friends list today to share your links.';

				if(isset($check_already_request['request_id']) and $check_already_request['request_id']>0){
					$tim = time();
					if($check_already_request['request_time1']==0){
						$co->query_update('friends_request', array('request_time1'=>$tim), array('id'=>$check_already_request['request_id']), 'request_id=:id');
					}elseif($check_already_request['request_time2']==0){
						$co->query_update('friends_request', array('request_time2'=>$tim), array('id'=>$check_already_request['request_id']), 'request_id=:id');
					}
				}else{
					$request_code = $co->generate_path(18);
					$fid = 0;
					if(isset($result['uid']))
						$fid = $result['uid'];

					$request_id = $co->add_friend_request($current['uid'], (($fid > 0) ? $fid : trim($email_ids)), $request_code, trim($email_ids), $description);
					$friend_id = $co->add_user_friend($request_id, $current['uid'], $fid, 0, 0);
					$friend_id = $co->add_user_friend($request_id, $fid, $current['uid'], 0, 0);
				}

				if(isset($result['uid']) and $result['uid'] > 0){
					$to = trim($email_ids);
					$subject = 'Friend request at Linkibag';
					$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
					$from = 'info@linkibag.com';
					$message = $co->addfriend_mail_content($description, $verified_link, $to);					
					//$co->send_email($to, $subject, $message, $from);	
				}else if(!(isset($result['uid']) and $result['uid'] > 0)){
					$to = trim($email_ids);
					$subject = 'Friend request at Linkibag';
					$verified_link = WEB_ROOT.'/index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
					$from = 'info@linkibag.com';
					$message = $co->invite_mail_content($description, $verified_link, $to);
					//$co->send_email($to, $subject, $message, $from);
				}
				
			}

			$lists_of_all_friends = $co->fetch_all_array("SELECT DISTINCT(IFNULL(u.email_id, r.request_email)) as email_id FROM user_friends uf INNER JOIN friends_request r ON r.request_id=uf.request_id LEFT JOIN users u ON u.uid=uf.fid WHERE uf.uid=:uid",array('uid'=>$current['uid']));
			$email_selection = '';
			foreach($lists_of_all_friends as $list){
				$email_selection .= '<option value="'.$list['email_id'].'">'.$list['email_id'].'</option>';
			}
			echo json_encode(array('res'=>'success','emails'=>$email_selection, 'msg'=>count($emails_ids).' request has been sent'));
	    	exit();
		}else{
			echo json_encode(array('res'=>'error','msg'=>'<div class="alert alert-danger">Error in reading file</div>'));
	    	exit();
		}
	}
	
}
?>