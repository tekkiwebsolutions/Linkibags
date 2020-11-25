<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Request New Password | Linkibag";
	
	//if(!isset($inc))
	//	exit();
	if($co->is_userlogin()){ 
		echo '<script language="javascript">window.location="index.php?p=dashboard";</script>';
		exit();
	}
	if(isset($_GET['user']) and isset($_GET['pv'])){
		$chk_verfied = $co->query_first("SELECT * FROM `users` WHERE uid=:uid and `reset_code`=:code and reset_request=1", array('uid'=>$_GET['user'], 'code'=>$_GET['pv']));	
		if(!(isset($chk_verfied['uid']) and $chk_verfied['uid']>0)){
			$limit_time = $chk_verfied['reset_time'] + (24 * 60 * 60);
			$present_time = time();
			if($present_time > $limit_time){
				$co->setmessage("error", "Time expired to change your password now. Please send another request");
			}
			echo '<script language="javascript">window.location="index.php";</script>';
			exit();
		}
	}else{
		echo '<script language="javascript">window.location="index.php";</script>';
		exit();
	}
?>



<div class="container">
	<div class="row">
		<div class="login-main">
			<div class="col-md-5 login-page-left">	
				<h1>Welcome to LinkiBag</h1>	
				<p>Trying to keep too many things under <br>control? Drop your links to your LinkiBag<br> and keep them with you wherever you go.</p>	
				<div class="page-btns">		
					<a class="btn orange-bg" href="index.php?p=personal-account">Free Signup</a>	
					<br><small style="color: rgb(255, 127, 39);">Free individual account signup</small>	
				</div>					
				<h3>Learn more about LinkiBag Services</h3>	
				<div class="login-page-links">	
					<a href="index.php?p=business-accounts">Business Accounts</a> - <a href="index.php?p=institutional-accounts">Institutional Accounts</a> - <a href="index.php?p=linki-drops-accounts">Link Drops Accounts</a>	
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
						<span class="forgot-note">Enter the email you used in your LinkiBag profile. A password reset link will be sent to you by email.</span>
						
						<div class="form-group text-right">           
							<input tabindex="1" class="form-control form-control-clean" type="text" required="required" value="<?=(isset($_POST['user_email']) ? $_POST['user_email'] : '')?>" placeholder="Email Address *" name="user_email"/>          
						</div>
						<div class="form-group text-right">           
							<input tabindex="1" class="form-control form-control-clean" type="password" value="" required="required" placeholder="New Password *" name="user_pass"/>          
						</div>
						<div class="form-group text-right">           
							<input tabindex="1" class="form-control form-control-clean" type="password" value="" required="required" placeholder="New Confirm Password *" name="user_cpass"/>          
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