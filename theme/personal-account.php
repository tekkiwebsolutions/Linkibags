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
		$co->page_title = "Sign up | LinkiBag";    
		$countries = $co->fetch_all_array("select id,country_name from countries ORDER BY id ASC", array());
		$states = $co->fetch_all_array("select id,state_name from states ORDER BY id ASC", array());
?>
<section class="sign_up_main_page" id="public-bag">
   <div class="container bread-crumb top-line" style="margin: auto;">
      <div class="col-md-12">
         <p><a href="index.php">Home</a> > Signup </p>
      </div>
   </div>
   <div class="containt-area">
	<div class="container">
		<div class="col-md-4">
		 <div class="sign_up_heading">
			<h3>FREE Personal Account Signup</h3>
			<p>Sign up and start using your FREE LinkiBag account now.</p>
		 </div>
		</div>
		<div class="col-md-6">
         <div class="row">
			<?=isset($msg) ? $msg : '' ?>
            <form class="sign_up_page_form" method="post" id="register_form" action="index.php?p=personal-account&ajax=ajax_submit" onsubmit="javascript: return submit_register();">
				<div id="messagesout"></div>   
				<input type="hidden" name="form_id" value="register"/>          
				<input type="hidden" name="role" value="personal"/>  
				<?php
				if(isset($_GET['request_id']) and $_GET['request_id'] > 0 and isset($_GET['request_code']) and $_GET['request_code'] != '' and isset($_GET['accept']) and $_GET['accept'] != ''){
					echo '<input type="hidden" name="request_id" value="'.$_GET['request_id'].'"/>
						<input type="hidden" name="request_code" value="'.$_GET['request_code'].'"/>
						<input type="hidden" name="accept" value="'.$_GET['accept'].'"/>
						
						';	
				}	
				?>
				
               <div class="col-md-12 text-left wow fadeInUp templatemo-box">
                  <div class="row">
                     <div class="personal_account_register">
                        <div class="form-group">
							<div class="col-md-2 pad-sm"><label class="mylabel">Name<span class="required-field">*</span></label></div>
						   <div style="display: none; padding-right: 6px;" class="col-md-2">
                           <select class="form-control linkibox_select" name="salutation" >
                              <option value="mr">Mr.</option>
                              <option value="ms">Ms.</option>
                              <option value="mrs">Mrs.</option>
                              <option value="dr">Dr.</option>
                           </select>
						   </div>
							<div style="padding-right: 5px;" class="col-md-4"><input placeholder="First Name" type="text" name="first_name" class="form-control" id="pwd" value="<?=((isset($_POST['first_name']) and $_POST['first_name']!='') ? $_POST['first_name'] : '')?>" /></div>
							<div style="padding: 0px 7px;" class="col-md-4"><input placeholder="Last Name" type="text" name="last_name" class="form-control" value="<?=((isset($_POST['last_name']) and $_POST['last_name']!='') ? $_POST['last_name'] : '')?>" /></div>
						</div>
						<div class="form-group">
							<div class="col-md-2 pad-sm"><label class="mylabel">Login<span class="required-field">*</span></label></div>
							<div class="col-md-7">
								<input placeholder="your-email@mail.com" type="text" name="email_id" aria-describedby="basic-addon1" placeholder="" class="form-control" value="<?=((isset($_POST['email_id']) and $_POST['email_id']!='') ? $_POST['email_id'] : '')?>" />				
							</div>
							<?php /*<div class="col-md-3">
								<label class="mylabel"></label>					
								<select name="email_domain" class="form-control linkibox_select">
								   <option value=0>Select</option>
								   <option value="gmail.com">gmail.com</option>
								   <option value="yahoo.com">yahoo.com</option>
								   <option value="hotmail.com">hotmail.com</option>
								</select>
								<!--<input type="text" name="email_domain" class="form-control" value="<?=((isset($_POST['email_domain']) and $_POST['email_domain']!='') ? $_POST['email_domain'] : '')?>" />-->					
								<span class="bootom-info"><a href="index.php?p=contact-us"><small>Suggest more</small></a></span>				
							</div> */ ?>
						</div>
						<div style="margin-bottom: 0px;" class="form-group">
							 <div class="col-md-2 pad-sm"><label class="mylabel">Password<span class="required-field">*</span></label></div>
							 <div style="padding-right: 5px;" class="col-md-4">               
								<input placeholder="create" type="password" name="password" class="form-control" id="password" >              
							 </div>
							 <div style="padding: 0px 7px;" class="col-md-4">                
								<input placeholder="confirm" type="password" name="reapt_pass" class="form-control" id="reapt_pass">
							 </div>
						</div>
						<div class="form-group">
							<div class="col-md-2"></div>
							<div class="col-md-10"><small style="color: #7f7f7f;">Min 8 characters with one number and one uppercase character</small></div>
						</div>
                        <div class="form-group">
							 <div class="col-md-2 pad-sm"><label class="mylabel">Country<span class="required-field">*</span></label></div>
							 <div class="col-md-7">
							 <select class="form-control linkibox_select" name="country" onchange="show_states(this.value)">
								<option value="">Select Country</option>
								<?php
								foreach($countries as $country){
									$sel = '';
									if(isset($_POST['country']) and $_POST['country'] == $country['id'])
										$sel = ' selected="selected"';	
									echo '<option value="'.$country['id'].'"'.$sel.'>'.$country['country_name'].'</option>';
								}	
								?>
							</select>
							</div>
                        </div>
						
						<div id="state_block">
						<div class="form-group">
							 <div class="col-md-2 pad-sm"></div>
							 <div style="padding-right: 5px;" class="col-md-4">
								<label class="mylabel">State<span class="required-field">*</span></label>
								<select name="state" class="form-control linkibox_select">
                                    <option value="">Select</option>
									<?php
									foreach($states as $state){
										$sel = '';
										if(isset($_POST['state']) and $_POST['state'] == $state['id'])
											$sel = ' selected="selected"';	
										echo '<option value="'.$state['id'].'"'.$sel.'>'.$state['state_name'].'</option>';
									}	
									?>
                                 </select>              
							 </div>
							 <div style="padding: 0px 7px;" class="col-md-4">                
								<label class="mylabel">Zip Code<span class="required-field">*</span></label><input type="text" name="zip_code" class="form-control">	
							 </div>
						</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-2"></div>
							<div class="col-md-8">
								<span class="required-field pull-right">*</span>
								<input type="hidden" title="Please verify this" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
								<div class="g-recaptcha" data-sitekey="6LfW_ScTAAAAAO2MRn6I180IrAb0HJa9cpaN3mI2"></div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-2"></div>
							<div class="col-md-8">
								<span style="margin: 0px; padding: 0px;" class="errordiv" style="overflow: hidden;">
									<div class="checkbox linki-chckboxbox ">
										<input id="checkbox1" type="checkbox" name="terms_and_conditions" value="1">              
										<label for="checkbox1" class="question">
											<span class="required-field">*</span>                
											I have read and understand this agreement and I accept and agree to all of its terms and conditions.
									</div>
									<label class="error" for="terms_and_conditions"></label>
								</span>
								<div style="margin-top: 0px;" class="checkbox linki-chckboxbox ">            
									<input id="checkbox3" type="checkbox" name="sign_me_for_email_filter" value="1">            
									<label for="checkbox3">
										Sign me up for email fliers with LinkiBag promotions and discounts.           
									</label>            
								</div>
								<label for="sign_me_for_email_filter" class="error"></label>
							</div>
						</div>
					</div>
					<div class="submit_btn row text-right">
						<div class="col-md-12">            
							<button type="submit" class="orange-btn" id="send_register">Signup ></button>			
						</div>
					</div>	
                  </div>
               </div>
            </form>
         </div>
		 </div>
	  </div>
      <div class="blue-border"></div>
   </div>
</section>	
<?php  }    ?>
