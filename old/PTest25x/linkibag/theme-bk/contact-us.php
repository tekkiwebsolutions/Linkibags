<?php
   function page_content(){
   	global $co, $msg;
   	$co->page_title = "Contact us | Linkibag";
   $current = $co->getcurrentuser_profile(); 
   ?>
   
	<section class="light-bg">
		<div class="container">
			<div class="col-md-offset-4 col-md-4">
			<p></p>
				<div class="light-panel">
					<div class="light-panel-header text-center">
						<h1>GET IN TOUCH</h1>
					</div>
					<div class="light-panel-body">
						
						<?=isset($msg) ? $msg : ''?>
         <form method="post" id="contact_us_form" action="index.php?p=contact-us&ajax=ajax_submit" onsubmit="javascript: return contact_us();">
            <input type="hidden" name="form_id" value="contact-us"/>
            <div id="messages-out"></div>
            <div>
               <div>
					
					<div>
						<div class="form-group">
							<label class="mylabel1">First Name: <span class="required-field">*</span></label>
							<input type="text" placeholder="First Name" name="first_name" class="form-control" value="<?=isset($current['first_name']) ? $current['first_name'] : ''?>" />
						</div>
						<div class="form-group">	
								<label class="mylabel1">Last Name: <span class="required-field">*</span></label>
								<input type="text" placeholder="Last Name" name="last_name" class="form-control" id="pwd" value="<?=isset($current['last_name']) ? $current['last_name'] : ''?>" />
								
						</div>
						<div class="form-group">
							<label class="mylabel1">Email: <span class="required-field">*</span></label>
								<input type="email" placeholder="Your-email@mail.com" name="email_id" class="form-control" value="<?=isset($current['email_id']) ? $current['email_id'] : ''?>" />
						
						</div>
<div class="form-group">						
							<label class="mylabel1">Phone Number: <span class="required-field">*</span></label>
								<input type="text" placeholder="(123) 456-7890" name="phone" class="form-control onlynumbers" value="" maxlength="25" />
							
						</div>
						<div class="form-group">
							<label class="mylabel1">Company or Institution Name:</label>
								<input type="text" placeholder="Company or Institution Name" name="company_name" class="form-control" value="" />
							</div>
						
						<div class="form-group">
						<label class="mylabel1">What is your inquiry about? <span class="required-field">*</span></label>	
									<span class="error" for="type_of_inquiry"></span>	
									<div class="radio-button">
										<?php /* 
										<div class="radio-list">				
											<label class="mylabel1">
												<input type="radio" name="type_of_inquiry" value="Account Upgrades" onclick="type_of_inquiery('#existing_acc','#new_acc','#general_enquiry','#product_listing_type')"<?=((isset($_GET['type_of_inquiry']) and $_GET['type_of_inquiry'] == 'send_feedback') ? 'checked="checked"' : '')?>/>	Website feedback
											</label>				
										</div>
										
										<div class="radio-list">				
											<label class="mylabel1">
												<input type="radio" name="type_of_inquiry" value="Existing Account" onclick="type_of_inquiery('#product_listing_type','#existing_acc','#general_enquiry' );"/>	Existing Account
											</label>				
										</div>
										<div class="radio-list">				
											<label class="mylabel1">
												<input type="radio" name="type_of_inquiry" value="Information Security Product Listing" onclick="type_of_inquiery('#general_enquiry','#product_listing_type','#existing_acc');"<?=((isset($_GET['type_of_inquiry']) and ($_GET['type_of_inquiry'] == 'free_products' OR $_GET['type_of_inquiry'] == 'free_trial_products')) ? ' checked="checked"' : '')?>/> Information Security Product Listing
											</label>				
										</div>
										*/ ?>
										
										<select name="type_of_inquiry" class="form-control" onchange="change_enquiries(this.value);">
											<?php
											$type_of_inquiry = array();
											$type_of_inquiry['New Account'] = 'LinkiBag Account';
											$type_of_inquiry['Account Upgrades'] = 'LinkiDrops Account (advertise with LinkiBag)';
											$type_of_inquiry['Partnerships'] = 'Partnerships';
											$type_of_inquiry['General Inquiries'] = 'General Inquiries / Other';


											foreach($type_of_inquiry as $key=>$value){
												$sel = '';
												//$sel = ' selected="selected"';
												echo '<option value="'.$key.'"'.$sel.'>'.$value.'</option>';
											}
											?>

										</select>
										
										
										<?php /*
										<div class="radio-list">				
											<label class="mylabel1">
												<input type="radio" name="type_of_inquiry" value="New Account" onclick="type_of_inquiery('#general_enquiry','#new_acc','#existing_acc','#product_listing_type');"/>	LinkiBag Account
											</label>	
										</div>
										<div class="radio-list">				
											<label class="mylabel1">
												<input type="radio" name="type_of_inquiry" value="Account Upgrades" onclick="type_of_inquiery('#general_enquiry','#new_acc','#existing_acc','#product_listing_type');"<?=((isset($_GET['type_of_inquiry']) and $_GET['type_of_inquiry'] == 'account_upgrades') ? 'checked="checked"' : '')?>/>	LinkiDrops Account (advertise with LinkiBag)
											</label>				
										</div>
										<div class="radio-list">				
											<label class="mylabel1">
												<input type="radio" name="type_of_inquiry" value="Partnerships" onclick="type_of_inquiery('#existing_acc','#new_acc','#general_enquiry','#product_listing_type')"/>	Partnerships
											</label>				
										</div>
										<div class="radio-list">				
											<label class="mylabel1">
												<input type="radio" name="type_of_inquiry" value="General Inquiries" onclick="type_of_inquiery('#product_listing_type','#general_enquiry','#existing_acc');"/>	General Inquiries / Other
											</label>				
										</div>

									*/ ?>
								   </div>
						</div>
						
						
						
						
						<div class="form-group" id="product_listing_type"<?=((isset($_GET['type_of_inquiry']) and ($_GET['type_of_inquiry'] == 'free_products' OR $_GET['type_of_inquiry'] == 'free_trial_products')) ? '' : ' style="display:none;"')?> >
									
										
											<label class="mylabel1">Product Type<span class="required-field">*</span></label>
											<div class="radio-button"><br/>
											<select name="product_listing_type" class="form-control">
												<?php
												$type_of_inquiry = array();
												$type_of_inquiry[] = array('Free Products','Products','free_products');
												$type_of_inquiry[] = array('Products with free trial versions','Products with free trial versions','free_trial_products');
												

												foreach($type_of_inquiry as $value){
													$sel = '';
													if(isset($_GET['type_of_inquiry']) and $_GET['type_of_inquiry'] == $value[2])
														$sel = ' selected="selected"';
													echo '<option value="'.$value[0].'"'.$sel.'>'.$value[1].'</option>';
												}
												?>

											</select>
											

												<?php /*
												<div class="radio-list">				
													<label class="mylabel1">
														<input type="radio" name="product_listing_type" value="Free Products"<?=((isset($_GET['type_of_inquiry']) and $_GET['type_of_inquiry'] == 'free_products') ? ' checked="checked"' : '')?> />	Free Products 
													</label>				
												</div>
												<div class="radio-list">				
													<label class="mylabel1">
														<input type="radio" name="product_listing_type" value="Products with free trial versions"<?=((isset($_GET['type_of_inquiry']) and $_GET['type_of_inquiry'] == 'free_trial_products') ? ' checked="checked"' : '')?> />	Products with free trial versions 
													</label>				
												</div>
												*/ ?>
											</div>
									
						</div>
						
							
						
					<div class="form-group margin-top-bottom" id="general_enquiry" style="display:none;">
										
												<label class="mylabel1">General Inquiries <span class="required-field">*</span></label>		
												<div class="radio-button">
													<select name="general_enquiry" class="form-control">
														<?php
														$type_of_inquiry = array();
														$type_of_inquiry[] = array('Partnership','Partnership Inquiry');
														$type_of_inquiry[] = array('Other','Other');
														

														foreach($type_of_inquiry as $value){
															$sel = '';
															//$sel = ' selected="selected"';
															echo '<option value="'.$value[0].'"'.$sel.'>'.$value[1].'</option>';
														}
														?>

												</select>
											

													<?php /*
													<div class="radio-list">				
														<label class="mylabel1">
															<input type="radio" name="general_enquiry" value="Partnership Inquiry" />	Partnership Inquiry
														</label>				
													</div>
													<div class="radio-list">				
														<label class="mylabel1">
															<input type="radio" name="general_enquiry" value="Other" />	Other
														</label>				
													</div>
													*/ ?>
												</div>
										
									</div>
									
									<div id="existing_acc" style="display: none;">
										<div class="form-group margin-top-bottom">
											
													<label class="mylabel1">Existing Account <span class="required-field">*</span></label>	
													<div class="radio-button"><br/>
														<select name="existing_account" class="form-control">
															<?php
															$type_of_inquiry = array();
															$type_of_inquiry[] = array('Techical Support','Techical Support');
															$type_of_inquiry[] = array('Billing','Billing');
															$type_of_inquiry[] = array('Other','Other');
															

															foreach($type_of_inquiry as $value){
																$sel = '';
																//$sel = ' selected="selected"';
																echo '<option value="'.$value[0].'"'.$sel.'>'.$value[1].'</option>';
															}
															?>

													</select>
												

														<?php /*
														<div class="radio-list">					
															<label class="mylabel1">
																<input type="radio" name="existing_account" value="Techical Support" />	Techical Support
															</label>					
														</div>
														<div class="radio-list">					
															<label class="mylabel1">
																<input type="radio" name="existing_account" value="Billing" />	Billing
															</label>					
														</div>
														<div class="radio-list">					
															<label class="mylabel1">
																<input type="radio" name="existing_account" value="Other" />	Other
															</label>	
														</div>
														*/ ?>
													</div>
												
										</div>
										<div class="form-group">
										
													<label class="mylabel1">Existing Account# <span class="required-field">*</span></label>	
													<div class="radio-button">					
														<input class="form-control" type="text" value="" name="exit_acc_no">				
													</div>
											   </div>
											
									</div>	
									<div class="form-group">
									<label class="mylabel1">Message: <span class="required-field">*</span></label>
									<textarea name="your_msg" placeholder="Message" class="form-control form-control-msg"></textarea>
								</div>
								<div class="form-group">  
									<label class="mylabel1 required-fields"><span class="required-field">*</span> Required Fields</label>
									<div class="aptcha-block">
										<input type="hidden" title="Please verify this" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
										<div class="g-recaptcha" data-sitekey="6LfW_ScTAAAAAO2MRn6I180IrAb0HJa9cpaN3mI2"></div>
									</div>
								</div>
								
								<div class="form-group">	
										<button type="sumit" class="orange-btn btn-block" id="send_contact_us" style="width: 100%;">Submit</button>
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

	
   


<script type="text/javascript">
	function change_enquiries(val){
		if(val == 'New Account'){
			type_of_inquiery('#general_enquiry','#new_acc','#existing_acc','#product_listing_type');
		}else if(val == 'Account Upgrades'){
			type_of_inquiery('#general_enquiry','#new_acc','#existing_acc','#product_listing_type');
		}else if(val == 'Partnerships'){
			type_of_inquiery('#existing_acc','#new_acc','#general_enquiry','#product_listing_type');
		}else if(val == 'General Inquiries'){
			type_of_inquiery('#product_listing_type','#general_enquiry','#existing_acc');
		}
	}

</script>

<?php
   }
   ?>

