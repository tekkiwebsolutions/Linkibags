<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Request New Password | LinkiBag";
?>

<?php
if($_SERVER['REQUEST_METHOD']=='POST')

{
		
}

?>

<div class="container">
	<div class="row">
		<div class="login-main">
			<div class="col-md-5 login-page-left">	
				<h1>Welcome to LinkiBag</h1>	
				<p>Trying to keep too many things under <br>control? Drop your links to your LinkiBag<br> and keep them with you wherever you go.</p>	
				<div class="page-btns">		
					<a class="btn orange-bg" href="index.php?#free_signup">Free Sign up</a>	
					<br><small style="color: rgb(255, 127, 39);">Free individual account sign up</small>	
				</div>					
				<h3>Learn more about LinkiBag Services</h3>	
				<div class="login-page-links">	
					<a href="index.php?p=business-accounts">Business Accounts</a> - <a href="index.php?p=institutional-accounts">Institutional Accounts</a> - <a href="index.php?p=linki-drops-accounts">Link Drops Accounts</a>	
				</div>	
			</div>
			<div class="col-md-4 col-md-offset-3 login-page-right">
				<div class="login-form"> 
					<form id="login_form" action="" method="post" class="login_frm">
						<h3 class="text-center">Forgot Password</h3>
						<?php if(isset($msg)) { echo $msg; }?>
						<span class="forgot-note">Enter the email you used in your LinkiBag profile. A password reset link will be sent to you shortly.</span>
						<input type="hidden" name="form_id" value="forget_password" />
						<div class="form-group text-right">           
							<input tabindex="1" class="form-control form-control-clean" type="text" required="required" value="<?=(isset($_POST['email_adr']) ? $_POST['email_adr'] : '')?>" placeholder="Email Address" name="email_adr"/>          
						</div>
						<div class="form-group">
							<div class="g-recaptcha" data-sitekey="6LcvQfIUAAAAADmpuC1uXGhW_OPaRyxM_TqKHOVN"></div>
							<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
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