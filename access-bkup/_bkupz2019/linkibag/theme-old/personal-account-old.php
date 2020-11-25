<?php
function page_access(){
	global $co, $msg;
	$user_login = $co->is_userlogin();
	if($user_login){
		echo '<script language="javascript">window.location="index.php?p=dashboard";</script>';
		exit();
	}
}
function page_content(){
	global $co, $msg;
	$co->page_title = "Register as personal account | LinkiBag";
?>
<section id="public-bag">
	<div class="container-fluid bread-crumb top-line">
		<div class="col-md-7">
			<p><a href="index.php">Home</a> > Personal Account signup </p>
		</div>
		<div class="col-md-4">
			<span class="other-acc-type">Other Account Types</span>
		</div>
	</div>
	<div class="containt-area">	
		<div class="main-heading container">			
			<img src="images/Logo_Personal_HIGH RES (1).png" class="img-responsive linki-logo">
			<h1 class="page-title">FREE Personal Account Sign up</h1>
			<p class="page-subtitle">
				Sign up and start using your FREE LinkiBag Account
			</p>
			<div class="form-title">
				<h2>Grab your free Personal LinkiBag Account today </h2>
			</div>			
		</div>
			<br>
		<div class="container">
			<div class="row">
				<form method="post" id="register_form" action="index.php?p=personal-account&ajax=ajax_submit" onsubmit="javascript: return submit_register();">
				<div id="messagesout"></div>
				<input type="hidden" name="form_id" value="register"/>
				<input type="hidden" name="role" value="personal"/>
				<div class="col-md-4 text-left wow fadeInUp templatemo-box  " data-wow-delay="0.3s">
					
					<h5 class="form-title"><strong>Personal Information</strong></h5>
					
						  <div class="form-group">
							<label class="mylabel">Salutation<span class="required-field">*</span></label>
							<input type="text" name="salutation" class="form-control" value="<?=((isset($_POST['salutation']) and $_POST['salutation']!='') ? $_POST['salutation'] : '')?>" />
						  </div>
						  <div class="form-group">
							<label class="mylabel">First Name<span class="required-field">*</span></label>
							<input type="text" name="first_name" class="form-control" id="pwd" value="<?=((isset($_POST['first_name']) and $_POST['first_name']!='') ? $_POST['first_name'] : '')?>" />
						  </div>						 
						   <div class="form-group">
							<label class="mylabel">Last Name<span class="required-field">*</span></label>
							<input type="text" name="last_name" class="form-control" value="<?=((isset($_POST['last_name']) and $_POST['last_name']!='') ? $_POST['last_name'] : '')?>" />
						  </div>	 
						 <label class="mylabel"> <span class="required-field">*</span> - Required Fields</label>
				</div>
				<div class="col-md-6  login-info col-md-offset-1 wow fadeInUp templatemo-box  " data-wow-delay="0.3s">
					<h5 class="form-title"><strong>Login Information</strong></h5>
					
						<div class="form-group">
							<label class="mylabel">Enter your email<span class="required-field">*</span></label>
							<div class="col-md-6 ">
								<div class="input-group">
									<input type="text" name="email_id" aria-describedby="basic-addon1" placeholder="" class="form-control" value="<?=((isset($_POST['email_id']) and $_POST['email_id']!='') ? $_POST['email_id'] : '')?>" />
									<span id="basic-addon1" class="input-group-addon">@</span>
								</div>
								<span class="bootom-info info-emil ">Max 26 characters</span>
							</div>
							<div class="col-md-4">
							<select name="email_domain" class="form-control linkibox_select ">
								<option value=0>Select</option>
								<option value="gmail.com">gmail.com</option>
								<option value="yahoo.com">yahoo.com</option>
								<option value="hotmail.com">hotmail.com</option>
							</select>
								<!--<input type="text" name="email_domain" class="form-control" value="<?=((isset($_POST['email_domain']) and $_POST['email_domain']!='') ? $_POST['email_domain'] : '')?>" />-->
								<span class="bootom-info"><a href="index.php?p=contact-us">Suggest more</a></span>
							</div>						
						</div>
						<div class="form-group">
							<label class="mylabel">Confirm your email<span class="required-field">*</span></label>
							<div class="col-md-6 ">
								<div class="input-group">
								
									<input type="text" name="confirm_email" aria-describedby="basic-addon1" placeholder="" class="form-control" value="<?=((isset($_POST['confirm_email']) and $_POST['confirm_email']!='') ? $_POST['confirm_email'] : '')?>" />
									<span id="basic-addon1" class="input-group-addon">@</span>
								</div>
							</div>
							<div class="col-md-4">
							<select name="confirm_email_domain" class="form-control linkibox_select ">
								<option value=0>Select</option>
								<option value="gmail.com">gmail.com</option>
								<option value="yahoo.com">yahoo.com</option>
								<option value="hotmail.com">hotmail.com</option>
							</select>
								<!--<input type="text" name="confirm_email_domain"  class="form-control" value="<?=((isset($_POST['confirm_email_domain']) and $_POST['confirm_email_domain']!='') ? $_POST['confirm_email_domain'] : '')?>" />-->
								<span class="bootom-info-corporate-domain"></span>
							</div>
						</div>
						<div class="form-group ">
							<label class="mylabel email-block">Choose a password<span class="required-field">*</span></label>
							<div class="col-md-9">
								<input type="password" name="password" class="form-control" >
								<span class="bootom-info">Min 8 characters</span>
							</div>
					
						</div>
						<div class="form-group">
							<label class="mylabel">Confirm  a password<span class="required-field">*</span></label>
							<div class="col-md-9">
								<input type="password" name="reapt_pass" class="form-control" id="pwd">			
							</div>
						</div>
						<div class="col-md-10 row">
							<span class="bootom-info">Your password must be 8-20 characters in length, contain at least one letter and at least one number, and contain no spaces. </span>
					  </div>
						<button type="submit" class="btn btn-default linki-btn" id="send_register">Sign up ></button>
					
					<div class="checkbox linki-chckboxbox ">
                        <input id="checkbox1" type="checkbox" name="terms_and_conditions">
                        <label for="checkbox1">						<span class="required-field">*</span>
                           I have read and understand the terms and Conditions agreement<br /> and I accept and agree to all of its terms and conditions.
					</div>
					<div class="checkbox linki-chckboxbox ">
                        <input id="checkbox3" type="checkbox" name="abc">
                        <label for="checkbox3">						<span class="required-field">*</span>
                            Sign me up for email flyers with LinkiBag promotions and dissounts
                        </label>
                    </div>	
				
				</div>
				
			</form>
			</div>
		</div>
		<div class="blue-border"></div>
	</div>
</section>
<?php
}
?>
