<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Sign Up | LinkiBag";
	$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>14));
	$current = $co->getcurrentuser_profile();
	$countries = $co->fetch_all_array("select id,country_name from countries ORDER BY id ASC", array());
	$states = $co->fetch_all_array("select id,state_name,code from states ORDER BY id ASC", array());
	$service_country = $co->query_first("SELECT * from linkibag_service_countries WHERE service_id=:id",array('id'=>1));
?>
<link href="https://fonts.googleapis.com/css2?family=Nothing+You+Could+Do&display=swap" rel="stylesheet">
<div class="container_cover" style="padding: 0px;">
<div class="container">
	<div class="row">
	<section id="free_signup" class="light-bg">
		<div id="free_singup_main" class="container" style="padding: 0px;">
			<div class="col-md-offset-3 col-md-6 form_layout">
			<p></p>
				<div class="light-panel">
					<div class="light-panel-header text-center">
						<h1><div style="margin-bottom: 5px;">LET’S GET STARTED</div><span class="text-orange">Sign Up for a Free Account</span></h1>
					</div>				
					<div class="light-panel-body">
						<span id="registerSubmitd" style="color:#009e55"></span>
						<form method="post" id="register_form" action="index.php?ajax=ajax_submit"  onsubmit="javascript: return submit_register();" novalidate="novalidate">
							<input type="hidden" name="form_id" value="register">
							<input type="hidden" name="role" value="personal">
							<?php
								if(isset($row['country']))
									$post_country = $row['country'];
								else if(isset($_GET['country']))
									$post_country = $_GET['country'];
								else
									$post_country = '';
							?>
							<div class="text-left wow fadeInUp templatemo-box">
								<div class="homepage-login-form">
									<div>
										<div id="messagesout"></div>
										<div id="uname_response"></div>
										<div class="row">
											<div class="col-md-8 col-md-offset-4">
												<a id="singup_forget_link" class="pull-right" href="javascript: void(0)" style="display: none; color: #960404" onclick="forget_password_submit('signup_email_id', 'singup_forget_link')">Forgot my password</a>
												<span id="forget_password_msg"></span>
											</div>
										</div>
										<div class="row" style="margin-bottom: 10px;">
											<label class="mylabel col-md-4">Email: <span class="required-field"> *</span></label>
											<div class="col-md-8">
											<input placeholder="you@mail.com" type="email" name="email_id" aria-describedby="basic-addon1" id="signup_email_id" class="form-control" value="" onblur="check_signupemail_message()">
											</div>
										</div>
										<div class="row">
											<div class="show_pass col-md-12 text-right">
												<input id="checkboxshow" type="checkbox" name="show_password" value="1">
												<label for="checkboxshow" class="question" id="show_password"> Show password</label>
											</div>
										</div>
										<div class="form-group row">
											<label class="mylabel col-md-4">Password: <span class="required-field">*</span></label>
											<div class="col-md-8">
												<input placeholder="Create Password" type="password" name="password" id="password" class="form-control">
												<ul id="d1" class="list-group">
													<li class="list-group-item" id="d12"><i class="fa fa-check" style="color: #999999"></i> Include one  uppercase letter</li>
													<li class="list-group-item" id="d13"><i class="fa fa-check" style="color: #999999"></i> Include a lowercase letter</li>
													<li class="list-group-item" id="d15"><i class="fa fa-check" style="color: #999999"></i> Include a number</li>
													<li class="list-group-item" id="d16"><i class="fa fa-check" style="color: #999999"></i> Include at least 8 characters</li>
												</ul>
												<div class="tooltip-none">
													<span style="color: #fff !important; position: absolute; right: 0; top: 6px;">
													<a tabindex="-1"  data-toggle="tooltip" title="Minimum of 8 characters with one number, one lowercase letter and one uppercase letter." href="javascript: void();" style="#444 ! important;">?</a></span>
												</div>
											</div>
											
										</div>
										<div class="form-group row">
											<label class="mylabel col-md-4">Confirm Password: <span class="required-field">*</span></label>
											<div class="col-md-8">
												<input placeholder="Confirm Password" type="password" name="reapt_pass" class="form-control">
											</div>
										</div>
										<div class="form-group row">
											<label class="mylabel col-md-4">Country: <span class="required-field">*</span></label>
											<div class="col-md-8">
											<select class="form-control linkibox_select" name="country" onchange="country_change(this.value);">
												<option value="">Select Country</option>
												<?php
												$countries = $co->fetch_all_array("select id,country_name from countries ORDER BY id ASC", array());
												foreach($countries as $country){
													$sel = '';
													if($country['id'] == $post_country)
														$sel = ' selected="selected"';	

													echo '<option value="'.$country['id'].'"'.$sel.'>'.$country['country_name'].'</option>';
												}	
												?>
											</select>
											</div>
										</div>
										<div class="form-group row" id="state_zipcode_block"<?=($post_country==1 ? '' : ' style="display: none"')?>>
											<label class="mylabel col-md-4">State: <span class="required-field">*</span></label>
											<div class="col-md-3">
												<select name="state" class="form-control linkibox_select" id="state" >
													<option value="">Select</option>
													<?php
													foreach($states as $state){
														$sel = '';
														if(isset($_POST['state']) and $_POST['state'] == $state['id'])
															$sel = ' selected="selected"';
														echo '<option value="'.$state['id'].'"'.$sel.'>'.$state['code'].'</option>';
													}
													?>
												</select>
											</div>
											<label class="mylabel col-md-2" style="padding-right: 0;">Zip Code: <span class="required-field">*</span></label>
											<div class="col-md-3">
												<input type="text" name="zip_code" class="form-control" maxlength="5" onkeydown="onlyNumber(event)">
											</div>
										</div>
										<!--<div class="form-group row">
											<label class="mylabel col-md-4">Date Of Birth: <span class="required-field">*</span></label>
											<div class="col-md-8">
												<input type="text" class="form-control" placeholder="Select DOB" name="dob" id="user_birthday" readonly />
											</div>
										</div>-->
										<div class="form-group row">
											<div class="col-md-8 col-md-offset-4">
												<div class="g-recaptcha" data-sitekey="6LcvQfIUAAAAADmpuC1uXGhW_OPaRyxM_TqKHOVN"></div>
												<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
											</div>
											
											<!--<div class="col-md-8 col-md-offset-4">
												<div class="g-recaptcha" data-sitekey="6LcvQfIUAAAAADmpuC1uXGhW_OPaRyxM_TqKHOVN"><div style="width: 304px; height: 78px;"><div><iframe src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LcvQfIUAAAAADmpuC1uXGhW_OPaRyxM_TqKHOVN&amp;co=aHR0cHM6Ly93d3cubGlua2liYWcuY29tOjQ0Mw..&amp;hl=en&amp;v=T9w1ROdplctW2nVKvNJYXH8o&amp;size=normal&amp;cb=47za0z3xpcl2" width="304" height="78" role="presentation" name="a-ykotxxxnjlls" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe></div><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div>
												<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
											</div>-->
										<!--<div id="captcha">
											<div class="controls">											                  
											  <input type="text" name="captcha_val" class="user-text btn-common" id="captcha_val" placeholder="Type here" />
												<button class="validate btn-common" type="button" id="validate_captcha_btn">
													<img src="images/enter_icon.png" alt="submit icon">
												</button>
												<button class="refresh btn-common" type="button" id="refresh_captch_btn">
													<img src="images/refresh_icon.png" alt="refresh icon">
												</button>
											</div>
										</div>
										<label class="error" for="captcha_val"></label>-->	
										</div>	
									<div style="padding: 0 0 0 19px;" class="row">
										<div class="col-md-8 col-md-offset-4">
										<span style="margin: 0px; padding: 0px;" class="errordiv">
											<div style="margin-top: 0px;" class=" linki-chckboxbox ">												
												<label for="checkbox1" class="question" style="color: #414141 !important; font-weight:300!important">
													<input id="checkbox1" type="checkbox" name="terms_and_conditions" value="1">	
													<!--<span class="required-field">*</span>-->
													&nbsp;&nbsp;	I have read, understand and agree to the <a href="https://www.linkibag.com/page/policy" style="font-weight: 600" target="_blank">Privacy Policy</a> and <a href="https://www.linkibag.com/page/terms" style="font-weight: 600" target="_blank"> Terms of Use.</a>
												</label>
											</div>
											<label class="error" for="terms_and_conditions" style="display:block;" ></label>
										</span>										
										<div style="margin-top: 0px; " class=" linki-chckboxbox ">
											<input id="checkbox3" type="checkbox" name="sign_me_for_email_filter" value="1">
											<label for="checkbox3" style="color: #414141 !important;font-weight:300!important">
											&nbsp;&nbsp;	Sign me up for LinkiBag newsletter.
											</label>
										</div>
										<label for="sign_me_for_email_filter" class="error"></label>
										</div>
									</div>	
									
									<div class="form-group col-sm-5 col-sm-offset-4">
										<button type="submit" class="orange-btn btn-block" id="send_register">Create Account</button>
									</div>										
									
								</div>
							  </div>
						   </div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
	</div>
</div>      
</div>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script> 


<script>
	function country_change(countryval){
		$("input[name='zip_code']").val('');
		if(countryval == 1 || countryval == 2) {			
			if(countryval == 1) {
				$('#state_zipcode_block').show();
				$('.USA').show();
				$('.CAN').hide();
				$("input[name='zip_code']").attr('onkeydown','onlyNumber(event)');
				$("input[name='zip_code']").attr('minlength',5);
				$("input[name='zip_code']").attr('maxlength',5);
			} else if(countryval == 2) {
				$('.USA').hide();
				$('.CAN').show();
				$('#state_zipcode_block').show();
				$("input[name='zip_code']").removeAttr('onkeydown');
				$("input[name='zip_code']").removeAttr('minlength');
				$("input[name='zip_code']").removeAttr('maxlength');
			}
			$.ajax({
				type: "POST", 
				url: 'ajax/ajax-common.php',
				data: {action: 'getState', country_id: countryval},
				success: function(res) {
					res = JSON.parse(res);
					$('#state').html(res['html']);
				}
			});
		} else {
			$('#state_zipcode_block').hide();			
		}
		
		
		
		if (countryval != "") {
			<?php 
			$service_countries = unserialize($service_country['allowed_counties']);
			$country_cond = '';
			foreach($service_countries as $servicecountry) {
				if($country_cond != '')
					$country_cond .= ' && ';
				$country_cond .= 'countryval != '.$servicecountry;
			} ?>
			if(<?=$country_cond?>) {
				var email = $('#signup_email_id').val();
				window.location.href='index.php?p=outside-linkibag-service-area&email='+email+'&country='+countryval;
			}
		}
	}
	
	function onlyNumber(e){
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
			 // Allow: Ctrl+A
			(e.keyCode == 65 && e.ctrlKey === true) ||
			 // Allow: Ctrl+C
			(e.keyCode == 67 && e.ctrlKey === true) ||
			 // Allow: Ctrl+X
			(e.keyCode == 88 && e.ctrlKey === true) ||
			 // Allow: home, end, left, right
			(e.keyCode >= 35 && e.keyCode <= 39)) {
				 // let it happen, don't do anything
				 return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			e.preventDefault();
		}
	} 
</script>
<?php } ?>	
