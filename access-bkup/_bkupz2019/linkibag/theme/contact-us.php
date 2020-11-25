<?php
   function page_content(){
   	global $co, $msg;
   	$co->page_title = "Contact us | Linkibag";
   $current = $co->getcurrentuser_profile(); 
   ?>
<section id="free_singup">
   <div class="container bread-crumb top-line about-top" style="margin: auto;">
      <div class="col-md-7">
         <p><a href="index.php">Home </a>> Contact Us</p>
      </div>
   </div>
   <div style="padding: 15px;" class="container" id="contact-us">
         <?=isset($msg) ? $msg : ''?>
         <form method="post" id="contact_us_form" action="index.php?p=contact-us&ajax=ajax_submit" onsubmit="javascript: return contact_us();">
            <input type="hidden" name="form_id" value="contact-us"/>
            <div id="messages-out"></div>
            <div class="row">
               <div class="personal_account_register">
					<div class="form-title">
						<h2>Contact Us</h2>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-md-6">				
								<div class="col-md-5 pad-sm"><label class="mylabel">First Name: <span class="required-field">*</span></label></div>
								<div class="col-md-7"><input type="text" placeholder="First Name" name="first_name" class="form-control"  /></div>
							</div>
							<div class="col-md-6">					
								<div class="col-md-5 pad-sm"><label class="mylabel">Last Name: <span class="required-field">*</span></label></div>
								<div class="col-md-7"><input type="text" placeholder="Last Name" name="last_name" class="form-control" id="pwd"  /></div>
							</div>	
						</div>
					</div>	
					<div class="row">
						<div class="form-group">
							<div class="col-md-6">				
								<div class="col-md-5 pad-sm"><label class="mylabel">Email: <span class="required-field">*</span></label></div>
								<div class="col-md-7"><input type="email" placeholder="Your-email@mail.com" name="email_id" class="form-control" value="<?=isset($current['email_id']) ? $current['email_id'] : ''?>" /></div>
							</div>
							<div class="col-md-6">					
								<div class="col-md-5 pad-sm"><label class="mylabel">Phone Number: <span class="required-field">*</span></label></div>
								<div class="col-md-7"><input type="text" placeholder="(123) 456-7890" name="phone" class="form-control onlynumbers" value="" maxlength="25" /></div>
							</div>	
						</div>
					</div> 
					<div class="row">	
						<div class="form-group">
							<div class="col-md-6">	
								<div class="col-md-5 pad-sm"><label class="mylabel">Company or Institution Name:</label></div>
								<div class="col-md-7"><input type="text" placeholder="Company or Institution Name" name="company_name" class="form-control" value="" /></div>
							</div>	
						</div>
					</div>	
					<div class="row">
						<div class="form-group">  
							<div class="col-md-6">	
								<div class="col-md-5 pad-sm">		
									<label class="mylabel">What is your inquiry about? <span class="required-field">*</span></label>	
									<label class="error" for="type_of_inquiry"></label>	
								</div>
								<div class="col-md-7">
								   <div class="radio-button">
										<div class="radio-list">				
											<label class="mylabel">
												<input type="radio" name="type_of_inquiry" value="Account Upgrades" onclick="type_of_inquiery('#existing_acc','#new_acc','#general_enquiry','#product_listing_type')"<?=((isset($_GET['type_of_inquiry']) and $_GET['type_of_inquiry'] == 'send_feedback') ? 'checked="checked"' : '')?>/>	Website feedback
											</label>				
										</div>
										<div class="radio-list">				
											<label class="mylabel">
												<input type="radio" name="type_of_inquiry" value="Account Upgrades" onclick="type_of_inquiery('#general_enquiry','#new_acc','#existing_acc','#product_listing_type');"<?=((isset($_GET['type_of_inquiry']) and $_GET['type_of_inquiry'] == 'account_upgrades') ? 'checked="checked"' : '')?>/>	Account Upgrades
											</label>				
										</div>
										<div class="radio-list">				
											<label class="mylabel">
												<input type="radio" name="type_of_inquiry" value="New Account" onclick="type_of_inquiery('#general_enquiry','#new_acc','#existing_acc','#product_listing_type');"/>	New Account
											</label>	
										</div>
										<div class="radio-list">				
											<label class="mylabel">
												<input type="radio" name="type_of_inquiry" value="Existing Account" onclick="type_of_inquiery('#product_listing_type','#existing_acc','#general_enquiry' );"/>	Existing Account
											</label>				
										</div>
										<div class="radio-list">				
											<label class="mylabel">
												<input type="radio" name="type_of_inquiry" value="Partnerships" onclick="type_of_inquiery('#existing_acc','#new_acc','#general_enquiry','#product_listing_type')"/>	Partnerships
											</label>				
										</div>
										<div class="radio-list">				
											<label class="mylabel">
												<input type="radio" name="type_of_inquiry" value="Information Security Product Listing" onclick="type_of_inquiery('#general_enquiry','#product_listing_type','#existing_acc');"<?=((isset($_GET['type_of_inquiry']) and ($_GET['type_of_inquiry'] == 'free_products' OR $_GET['type_of_inquiry'] == 'free_trial_products')) ? ' checked="checked"' : '')?>/> Information Security Product Listing
											</label>				
										</div>
										<div class="radio-list">				
											<label class="mylabel">
												<input type="radio" name="type_of_inquiry" value="General Inquiries" onclick="type_of_inquiery('#product_listing_type','#general_enquiry','#existing_acc');"/>	General Inquiries
											</label>				
										</div>
								   </div>
								</div>
								
								<div class="form-group margin-top-bottom" id="product_listing_type"<?=((isset($_GET['type_of_inquiry']) and ($_GET['type_of_inquiry'] == 'free_products' OR $_GET['type_of_inquiry'] == 'free_trial_products')) ? '' : ' style="display:none;"')?> >
									 <div class="row">
										<div class="col-md-5">		
											<label class="mylabel">Product Type<span class="required-field">*</span></label>		
										</div>
										<div class="col-md-7">
											<div class="radio-button">
												<div class="radio-list">				
													<label class="mylabel">
														<input type="radio" name="product_listing_type" value="Free Products"<?=((isset($_GET['type_of_inquiry']) and $_GET['type_of_inquiry'] == 'free_products') ? ' checked="checked"' : '')?> />	Free Products 
													</label>				
												</div>
												<div class="radio-list">				
													<label class="mylabel">
														<input type="radio" name="product_listing_type" value="Products with free trial versions"<?=((isset($_GET['type_of_inquiry']) and $_GET['type_of_inquiry'] == 'free_trial_products') ? ' checked="checked"' : '')?> />	Products with free trial versions 
													</label>				
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-5 pad-sm block-req">		
									<label class="mylabel required-fields"><span class="required-field">*</span> Required Fields</label>
								</div>
								<div class="col-md-7 pad-sm">
									<div class="captcha-block">
										<span class="required-field pull-right">*</span>
										<input type="hidden" title="Please verify this" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
										<div class="g-recaptcha" data-sitekey="6LfW_ScTAAAAAO2MRn6I180IrAb0HJa9cpaN3mI2"></div>
									</div>
								</div>
								<div class="form-group margin-top-bottom" id="general_enquiry" style="display:none;">
										 <div class="row">
											<div class="col-md-5">		
												<label class="mylabel">General Inquiries <span class="required-field">*</span></label>		
											</div>
											<div class="col-md-7">
												<div class="radio-button">
													<div class="radio-list">				
														<label class="mylabel">
															<input type="radio" name="general_enquiry" value="Partnership Inquiry" />	Partnership Inquiry
														</label>				
													</div>
													<div class="radio-list">				
														<label class="mylabel">
															<input type="radio" name="general_enquiry" value="Other" />	Other
														</label>				
													</div>
												</div>
											</div>
										</div>
									</div>
									<div id="existing_acc" style="display: none;">
										<div class="form-group margin-top-bottom">
											<div class="row">
											   <div class="col-md-5">			
													<label class="mylabel">Existing Account <span class="required-field">*</span>
													</label>			
												</div>
												<div class="col-md-7">
													<div class="radio-button">
														<div class="radio-list">					
															<label class="mylabel">
																<input type="radio" name="existing_account" value="Techical Support" />	Techical Support
															</label>					
														</div>
														<div class="radio-list">					
															<label class="mylabel">
																<input type="radio" name="existing_account" value="Billing" />	Billing
															</label>					
														</div>
														<div class="radio-list">					
															<label class="mylabel">
																<input type="radio" name="existing_account" value="Other" />	Other
															</label>	
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
											   <div class="col-md-5">			
													<label class="mylabel">Existing Account# <span class="required-field">*</span></label>			
												</div>
											   <div class="col-md-7">
													<div class="radio-button">					
														<input class="form-control" type="text" value="" name="exit_acc_no">				
													</div>
											   </div>
											</div>
										</div>
									</div>	
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="col-md-12 padding_less"><label class="mylabel">Message: <span class="required-field">*</span></label></div>
									<div class="col-md-12 padding_less"><textarea name="your_msg" placeholder="Message" class="form-control form-control-msg"></textarea></div>
								</div>
								<div class="form-group">	
									<div class="col-md-4 padding_less">	
										<button type="sumit" class="orange-btn" id="send_contact_us" style="width: 100%;">Submit</button>
									</div>
								</div>	
							</div>	
						</div>
					</div>		
                  
               </div>
            </div>
           
         </form>

   </div>
</section>
<?php
   }
   ?>

