<?php


function page_access(){


	global $co, $msg;


	$user_login = $co->is_userlogin();


	if(!$user_login){


		echo '<script language="javascript">window.location="index.php";</script>';


		exit();


	}





}


function page_content(){


	global $co, $msg;


	$co->page_title = "Edit Profile | Linkibag";


	$current = $co->getcurrentuser_profile();
	$row = $co->query_first("SELECT p.*, u.* FROM users u, profile p WHERE u.uid=:id AND u.uid=p.uid",array('id'=>$current['uid']));
	//print_r($row);
	$countries = $co->fetch_all_array("select id,country_name from countries ORDER BY id ASC", array());
	$states = $co->fetch_all_array("select id,state_name from states ORDER BY id ASC", array());


?>

<section class="sign_up_main_page" id="public-bag">
   <div class="container bread-crumb top-line" style="margin: auto;">
      <div class="col-md-12">
         <p><a href="index.php">Home</a> > Edit Profile </p>
      </div>
   </div>
   <div class="containt-area">
      <div class="container">
		<div class="row">
			<div class="col-md-offset-3  col-md-6">
            <form class="sign_up_page_form" method="post" id="edit_profile_form" action="index.php?p=edit_profile&ajax=ajax_submit" onsubmit="javascript: return submit_edit_profile();">
               <div id="messagesout"></div>  
				<?php if(isset($msg)) { echo $msg; }?>
               <input type="hidden" name="form_id" value="edit_profile"/>                 
               <div class="col-md-12 text-left wow fadeInUp templatemo-box">
                  <div class="row">
                     <div class="personal_account_register">
						<div class="form-group">
							<div class="col-md-2 pad-sm"><label class="mylabel">Name<span class="required-field">*</span></label></div>
							<div style="padding-right: 6px; display:none;" class="col-md-2">
								<select class="form-control linkibox_select" name="salutation">
								<option value="mr"<?=((isset($row['salutation']) and $row['salutation']=='mr') ? ' selected="selected"' : '')?>>Mr.</option>
								<option value="ms"<?=((isset($row['salutation']) and $row['salutation']=='ms') ? ' selected="selected"' : '')?>>Ms.</option>
								<option value="mrs"<?=((isset($row['salutation']) and $row['salutation']=='mrs') ? ' selected="selected"' : '')?>>Mrs.</option>
								<option value="dr"<?=((isset($row['salutation']) and $row['salutation']=='dr') ? ' selected="selected"' : '')?>>Dr.</option>
								</select>
							</div>
							<div style="padding-right: 7px;" class="col-md-4">
								<input type="text" name="first_name" class="form-control" maxlength="50" id="pwd" value="<?=((isset($row['first_name']) and $row['first_name']!='') ? $row['first_name'] : '')?>" />  
							</div>
							<div style="padding: 0px 7px;" class="col-md-4">
								<input type="text" name="last_name" class="form-control" maxlength="50" value="<?=((isset($row['last_name']) and $row['last_name']!='') ? $row['last_name'] : '')?>" />   
							</div>
                        </div>
                        <div class="form-group">
							<div class="col-md-2 pad-sm"><label class="mylabel">Login<span class="required-field">*</span></label></div>
							<div class="col-md-7">
							<input type="text" name="email_id" aria-describedby="basic-addon1" placeholder="" class="form-control" value="<?=((isset($row['email_id']) and $row['email_id']!='') ? substr($row['email_id'],0,35) : '')?>" />			
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
							<div class="col-md-2 pad-sm"><label class="mylabel">Password</label></div>
							<div style="padding-right: 5px;" class="col-md-4">              
								<input placeholder="password" type="Password" name="password" class="form-control" >             
							</div>
							<div style="padding: 0px 7px;" class="col-md-4">              
								<input placeholder="Confirm Password" type="password" name="reapt_pass" class="form-control" id="pwd">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-2"></div>
							<div class="col-md-10"><small style="color: #7f7f7f;">Min 8 characters with one number and one uppercase character</small></div>
						</div>
						
                        <div class="form-group">
							<div class="col-md-2 pad-sm"><label class="mylabel">Location<span class="required-field">*</span></label></div>
							<div class="col-md-7">		
							<select class="form-control linkibox_select" name="country" onchange="show_states(this.value)">
								<option value="">Select Country</option>
								<?php
								foreach($countries as $country){
									$sel = '';
									if(isset($row['country']) and $row['country'] == $country['id'])
										$sel = ' selected="selected"';	
									echo '<option value="'.$country['id'].'"'.$sel.'>'.$country['country_name'].'</option>';
								}	
								?>
							</select>
							</div>
                        </div>
                        <div class="row" id="state_block" style="display: none;">
							<div class="col-md-2"></div>
							<div style="padding-right: 0px;" class="col-md-4">
                              <div class="form-group">
                                 <label class="mylabel">State</label>							
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
                           </div>
                           <div class="col-md-6">
								<div class="form-group">							
									<label class="mylabel">Zip Code</label>							
									<input type="text" name="zip_code" class="form-control">						
								</div>
                           </div>
                        </div>
						
						
						<div class="form-group">
							<div class="col-md-2"></div>
							<div class="col-md-8">
								
								<div style="margin-top: 0px;" class="checkbox linki-chckboxbox ">            
									<input id="checkbox3" type="checkbox" name="sign_me_for_email_filter" value="1"<?=((isset($row['sign_me_for_email_filter']) and $row['sign_me_for_email_filter'] == '1') ? ' checked="checked"' : '')?>>            
									<label for="checkbox3">
										Sign me up for email fliers with LinkiBag promotions and discounts  
									</label>            
								</div>
								<label for="sign_me_for_email_filter" class="error"></label>
							</div>
						</div>
					 </div>
                     <div class="submit_btn row text-right">
						<div class="col-md-12">            
							<button type="submit" class="orange-btn" id="send_register">Update ></button>		
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
