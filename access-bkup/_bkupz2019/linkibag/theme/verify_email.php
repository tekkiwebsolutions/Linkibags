<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Confirm Email | Linkibag";
	
	//if(!isset($inc))
	//	exit();
	if($co->is_userlogin()){
		$current = $co->getcurrentuser_profile();
		if(isset($_GET['email_unique_path'])){
			$chk_verfied = $co->query_first("SELECT email_id,uid FROM `users` WHERE email_unique_path=:path and `uid`=:uid and status=1", array('uid'=>$current['uid'], 'path'=>$_GET['email_unique_path']));	
			if(!(isset($chk_verfied['uid']) and $chk_verfied['uid']>0)){
				echo '<script language="javascript">window.location="index.php";</script>';
				exit();	
			}else{
				$up_user = array();
				$up_user['reset_email_time'] = time();
				$co->query_update('users', $up_user, array('uid'=>$chk_verfied['uid']), 'uid=:uid');
			
			}
		}else{
			echo '<script language="javascript">window.location="index.php";</script>';
			exit();
		}	
		
	}
	
	
?>



<div class="container">
	<div class="row">
		<div class="login-main">
			<div class="col-md-5 login-page-left">	
				<h1>Welcome to LinkiBag</h1>	
				<p>Trying to keep too many things under <br>control? Drop your links to your LinkiBag<br> and keep them with you wherever you go.</p>	
									
				<h3>Learn more about LinkiBag Services</h3>	
				<div class="login-page-links">	
					<a href="index.php?p=business-accounts">Business Accounts</a> - <a href="index.php?p=institutional-accounts">Institutional Accounts</a> - <a href="index.php?p=linki-drops-accounts">Link Drops Accounts</a>	
				</div>	
			</div>
			<div class="col-md-4 col-md-offset-3 login-page-right">
				<div class="login-form"> 
					<form id="login_form" action="" method="post" class="login_frm">
						<input type="hidden" name="form_id" value="reset_email" />
						<input type="hidden" name="code" value="<?=$_GET['email_unique_path']?>" />
							<h3 class="text-center">Reset Email</h3>
						<?php if(isset($msg)) { echo $msg; }?>
						<span class="forgot-note">Enter the email you used in your LinkiBag profile.</span>
						
						<div class="form-group text-right">           
							<input tabindex="1" class="form-control form-control-clean" type="text" required="required" value="<?=(isset($_POST['old_user_email']) ? $_POST['old_user_email'] : '')?>" placeholder="Current Email Address *" name="old_user_email"/>          
						</div>
						<div class="form-group text-right">           
							<input tabindex="1" class="form-control form-control-clean" type="text" required="required" value="<?=(isset($_POST['new_user_email']) ? $_POST['new_user_email'] : '')?>" placeholder="New Email Address *" name="new_user_email"/>          
						</div>	
						<div class="form-group text-right">           
							<input tabindex="1" class="form-control form-control-clean" type="password" required="required" value="<?=(isset($_POST['old_pass']) ? $_POST['old_pass'] : '')?>" placeholder="Current Password *" name="old_pass"/>          
						</div>	
						<div class="text-right">
							
							<input tabindex="2" class="btn btn-custom btn-blue-bg" type="submit" id="" name="login" value="Submit">
						</div>       
					</form>
				</div> 
			</div>
		</div>
	</div>
</div>
<?php } ?>