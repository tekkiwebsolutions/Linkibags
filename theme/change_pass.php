<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Request New Password | LinkiBag";
	
	//if(!isset($inc))
	//	exit();
	if($co->is_userlogin()){ 
		echo '<script language="javascript">window.location="index.php?p=dashboard";</script>';
		exit();
	}
	
	$email_show = '';
	if(isset($_GET['user']) and isset($_GET['pv'])){
		$chk_verfied = $co->query_first("SELECT * FROM `users` WHERE uid=:uid and `reset_code`=:code and reset_request=1", array('uid'=>$_GET['user'], 'code'=>$_GET['pv']));	
		if((isset($chk_verfied['uid']) and $chk_verfied['uid']>0)){
		    if(isset($chk_verfied['email_id'])) {
        	    $email_show = $chk_verfied['email_id'];
        	}
			$limit_time = $chk_verfied['reset_time'] + (24 * 60 * 60);
			$present_time = time();
			if($present_time > $limit_time){
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

	$profile = $co->query_first("SELECT * FROM `profile` WHERE uid=:uid", array('uid'=>$chk_verfied['uid']));
	if(isset($profile['security_question']) and $profile['security_question']>0){
	$security_question=$profile['security_question'];
	}
	if(isset($profile['security_question2']) and $profile['security_question2']>0){
		$security_question2=$profile['security_question2'];
		}
		if(isset($profile['security_question3']) and $profile['security_question3']>0){
			$security_question3=$profile['security_question3'];
			}
			$questionId =$security_question.','.$security_question2.','.$security_question3;

	if(isset($_POST['user_email'])) {
	    $email_show = $_POST['user_email'];
	}
?>



<div class="container">
	<div class="row">
		<div class="login-main">
			<div class="col-md-5 login-page-left">	
				<h1>Welcome to LinkiBag</h1>	
				Trying to keep too many things under <br>control? Drop your links into your LinkiBag<br> and keep them with you wherever you go.	
				<div class="page-btns">		
					<a class="btn orange-bg" href="sign-up">Free Sign Up</a>
					<br><span style="color:#ff7f27;float: left;width: 100%;margin: 6px 0px 7px;">Free individual account</span>	
				</div>					
				<h3>Learn more about LinkiBag Services</h3>	
				<div class="login-page-links">
					<a href="index.php?p=free-personal-accounts">Free Accounts</a> - <a href="index.php?p=contact-us">Advertise with LinkiBag</a>	
					<!--<a href="index.php?p=business-accounts">Business Accounts</a> - <a href="index.php?p=institutional-accounts">Institutional Accounts</a> - <a href="index.php?p=linki-drops-accounts">LinkiDrops Accounts</a>-->	
				</div>	
			</div> 
			<div class="col-md-4 col-md-offset-3 login-page-right">
				<div class="login-form"> 
					<form id="login_form" action="" method="post" class="login_frm">
						<input type="hidden" name="form_id" value="reset_password" />
						<input type="hidden" name="user_id" value="<?=$_GET['user']?>" />
						<input type="hidden" name="code" value="<?=$_GET['pv']?>" />
							<h3 class="text-center">Reset Password</h3>
						<?php if(isset($msg)) { echo $msg; }?>
						<span class="forgot-note">Your password must contain at least 8 characters, include both lower and uppercase characters and at least one number or symbol.<!--Enter the email you used in your LinkiBag profile. A password reset link will be sent to you by email.--></span>
						<!-- $email_show -->
						<div class="form-group text-right">           
							<input tabindex="1" class="form-control form-control-clean" type="hidden" required="required" autocomplete="off" value="<?php echo $email_show;  ?>" placeholder="Profile Email Address *" name="user_email"/>          
						</div>
						<?php if(isset($profile['security_question']) and $profile['security_question']>0){
							//$qus = $co->query_first("SELECT * FROM `securiy_questions` WHERE id=:security_question", array('security_question'=>$profile['security_question']));
							$states = explode(',', ($questionId));
							shuffle($states);
							$questionId = implode(',', ($states));
							$qus = $co->query_first("SELECT * FROM securiy_questions WHERE id IN (:security_question)", array('security_question'=>$questionId));
						
						 ?>
							<!--<span class="forgot-note">Security Question</span>-->
							<!--<a style="" class="linkexchange" data-toggle="tooltip" title="Change security question" onClick="window.location.reload();" href="javascript:void(0)"><img title="Change security question" style="color:#fff;margin-right: 50px; margin-top: 15px;" src="<?=WEB_ROOT?>images/icon-refresh.png" ></a>-->
							<!--<div class="form-group">-->
							<!--	<span style="color: #4f4f4f"><?=$qus['security_question']?></span>-->
							<!--	<input  type="hidden" value="<?=(isset($qus['id']) ? $qus['id'] : '')?>"  name="security_ques"/>          -->
							
							<!--	<input tabindex="1" class="form-control form-control-clean" type="text" value="<?=(isset($_POST['security_ans']) ? $_POST['security_ans'] : '')?>" required="required" name="security_ans"/>          -->
							<!--</div>-->
						<?php } ?>
						<span class="forgot-note">Create New Password</span>
						<div class="form-group text-right">           
							<input tabindex="1" class="form-control form-control-clean" type="password" value="" required="required" placeholder="New Password *" name="user_pass"/>          
						</div>
						<div class="form-group text-right">           
							<input tabindex="1" class="form-control form-control-clean" type="password" value="" required="required" placeholder="Confirm New Password *" name="user_cpass"/>          
						</div>	
						<div class="text-right">
							<a href="index.php?p=login" class="btn btn-custom btn-blue-bg">Back to Login</a>
							<input tabindex="2" class="btn btn-custom btn-blue-bg" type="submit" id="" name="login" value="Submit">
						</div>       
					</form>
				</div> 
			</div>
		</div>
	</div>
</div>
<?php } ?>