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
	$securiy_questions = $co->fetch_all_array("select * from securiy_questions ORDER BY id ASC", array());
	$reset_code = $co->generate_path(18);
	$reset_code = $reset_code.time();
	
	$up_user = array();
	$up_user['email_unique_path'] = $reset_code;	
	$co->query_update('users', $up_user, array('uid'=>$current['uid']), 'uid=:uid');
	unset($up_user);

	?>



	<section class="sign_up_main_page" id="public-bag">		

	 <div class="container bread-crumb top-line">
      <div class="col-md-12">
         <p><a href="index.php">Home</a> &gt; Edit Profile </p>
      </div>
   </div>
	
		<div class="containt-area">
			<div class="container">
					<?php
					include('account_setting_sidebar.php');
					?>		

					<div class="col-md-9">
					<div class="row">
						<div class="col-md-12">
							<p class="green-title" style="margin-top: 0px;">Edit Profile</p>
						</div>
						<form class="sign_up_page_form" method="post" id="edit_profile_form" action="index.php?p=edit_profile&ajax=ajax_submit" onsubmit="javascript: return submit_edit_profile();" enctype="multipart/form-data">
							<div id="messagesout"></div>  
							<?php if(isset($msg)) { echo $msg; }?>
							<input type="hidden" name="form_id" value="edit_profile"/>  
							<div class="col-md-2 col-xs-12">
								<div class="edit-user-widget">
									<img id="show_upload_photo" class="img-responsive" alt="logo" src="<?=((isset($current['profile_photo']) and $current['profile_photo']!='') ? $current['profile_photo'] : 'images/user-pic.png')?>">
									<?php if($current['role'] == 2 OR $current['role'] == 3){ ?>
									<div class="upload-btn-wrapper">
									  <button class="file-btn">Upload</button>
									  <input type="file" name="profile_photo" id="upload_photo"/>
									</div>
									<?php }else{ ?>
									<!--<a href="javascript:void(0);" data-toggle="tooltip" title="Available for Business and Institutional Accounts">Upload</a>-->
									<div class="upload-btn-wrapper">
									  <button class="file-btn">Upload</button>
									  <input type="file" name="profile_photo" id="upload_photo"/>
									</div>
									<?php } ?>
									
									<style>
										.upload-btn-wrapper {
											position: relative;
											overflow: hidden;
											display: inline-block;
										}

										.file-btn {
											background: transparent none repeat scroll 0 0;
											border: medium none;
											color: #7f7f7f;
											font-size: 13px;
											font-weight: bold;
											padding: 0;
											text-decoration: underline;
										}
										.upload-btn-wrapper input[type=file] {
											font-size: 100px;
											position: absolute;
											left: 0;
											top: 0;
											opacity: 0;
										}
									</style>

								</div>
							</div>
							<div class="col-md-8 col-xs-12">							               
									<div class="col-md-12 text-left wow fadeInUp templatemo-box">
										<div class="row">
											<div class="personal_account_register">
												<div class="fst">
													<div class="form-group">
														<div class="col-md-3 pad-sm"><label class="mylabel">Name<span class="required-field">*</span></label></div>
														<div style="padding-right: 6px; display:none;" class="col-md-2">
															<select class="form-control linkibox_select" name="salutation">
																<option value="mr"<?=((isset($row['salutation']) and $row['salutation']=='mr') ? ' selected="selected"' : '')?>>Mr.</option>
																<option value="ms"<?=((isset($row['salutation']) and $row['salutation']=='ms') ? ' selected="selected"' : '')?>>Ms.</option>
																<option value="mrs"<?=((isset($row['salutation']) and $row['salutation']=='mrs') ? ' selected="selected"' : '')?>>Mrs.</option>
																<option value="dr"<?=((isset($row['salutation']) and $row['salutation']=='dr') ? ' selected="selected"' : '')?>>Dr.</option>
															</select>
														</div>
														<div style="padding: 0 7px;" class="col-md-3 form-size">
															<input type="text" name="first_name" class="form-control" maxlength="50" id="pwd" value="<?=((isset($row['first_name']) and $row['first_name']!='') ? $row['first_name'] : '')?>" />  
														</div>
														<div style="padding: 0px 7px;" class="col-md-3 form-size">
															<input type="text" name="middle_name" class="form-control" maxlength="50" id="pwd" value="<?=((isset($row['middle_name']) and $row['middle_name']!='') ? $row['middle_name'] : '')?>" />  
														</div>
														<div style="padding: 0px 7px;" class="col-md-3 form-size">
															<input type="text" name="last_name" class="form-control" maxlength="50" value="<?=((isset($row['last_name']) and $row['last_name']!='') ? $row['last_name'] : '')?>" />   
														</div>
													</div>
													<div class="form-group">
														<div class="col-md-3 pad-sm"><label class="mylabel">Company</label></div>
														<div style="padding: 0px 7px;" class="col-md-6 form-size">
															<input type="text" name="company_name" class="form-control" maxlength="50" value="<?=((isset($row['company_name']) and $row['company_name']!='') ? $row['company_name'] : '')?>" />   
														</div>
													</div>
													<div class="form-group">
														<div class="col-md-3 pad-sm"><label class="mylabel">Login</label></div>
														<div style="padding: 0px 7px;" class="col-md-6 form-size">
															<input type="text" name="email_id" aria-describedby="basic-addon1" placeholder="" class="form-control" value="<?=((isset($row['email_id']) and $row['email_id']!='') ? substr($row['email_id'],0,35) : '')?>" disabled/>			
														</div>
														<div class="col-md-2 pad-sm"><a href="index.php?p=verify_email&email_unique_path=<?=$reset_code?>" target="_blank">Update Email</a></div>
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
							<div class="col-md-3 pad-sm"><label class="mylabel">Password<span class="required-field">*</span></label></div>
							<div style="padding: 0px 7px;" class="col-md-4 form-size">              
								<input placeholder="password" type="Password" name="password" class="form-control" >             
							</div>
							<div style="padding: 0px 7px;" class="col-md-4 form-size">              
								<input placeholder="Confirm Password *" type="password" name="reapt_pass" class="form-control" id="pwd">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-10 col-sm-offset-3" style="padding-left: 7px;"><small style="color: #7f7f7f;">Min 9 characters with one number and one character and no spaces</small></div>
						</div>
					</div>


					<div style="border-top: 6px solid #c3c3c3; border-bottom: 6px solid #c3c3c3; padding: 11px 0px 0px; margin: 18px 0px 17px;" class="fst">
						


						<div class="form-group">
							<div class="col-md-3 pad-sm"><label class="mylabel">Security Question<span class="required-field">*</span></label></div>
							<div style="padding: 0px 7px;" class="col-md-6 form-size">
								<select class="form-control linkibox_select" name="security_question" onchange="show_answer(this.value);">
									<option value="">Select a question...</option>
									<?php
									foreach($securiy_questions as $list){
										$sel = '';
										if(isset($row['security_question']) and $row['security_question'] == $list['id'])
											$sel = ' selected="selected"';	
										echo '<option value="'.$list['id'].'"'.$sel.'>'.$list['security_question'].'</option>';
									}	
									?>
								</select>			
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-md-3 pad-sm"><label class="mylabel">Answer<span class="required-field">*</span></label></div>
							<div style="padding: 0px 7px;" class="col-md-6 form-size">		
								<input placeholder="Answer" type="text" name="security_answer" class="form-control" value="<?=((isset($row['security_answer']) and $row['security_answer']!='') ? $row['security_answer'] : '')?>"> 			
							</div>
							
						</div>
					</div>


					<div class="fst">
						<div class="form-group" id="user_timezone">
							<div class="col-md-3 pad-sm"><label class="mylabel">Time Zone</label></div>
							<div style="padding: 0px 7px;" class="col-md-6 form-size">		
								<select class="form-control linkibox_select" name="user_timezone">
									<option value="">Please, select timezone</option>
									<?php
									$regions = array(
										'Africa' => DateTimeZone::AFRICA,
										'America' => DateTimeZone::AMERICA,
										'Australia' => DateTimeZone::AUSTRALIA,
										'Antarctica' => DateTimeZone::ANTARCTICA,
										'Aisa' => DateTimeZone::ASIA,
										'Atlantic' => DateTimeZone::ATLANTIC,
										'Europe' => DateTimeZone::EUROPE,
										'Indian' => DateTimeZone::INDIAN,
										'Pacific' => DateTimeZone::PACIFIC
									);
									foreach ($regions as $name => $mask)
									{
										$zones = DateTimeZone::listIdentifiers($mask);
										//echo '<optgroup label="'.$name.'">';
										foreach($zones as $timezone)
										{
											$time = new DateTime(NULL, new DateTimeZone($timezone));
											$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
											$sel = '';
											if(!empty($row['user_timezone']) and $row['user_timezone']==$timezone){
												$sel = ' selected="selected"';
											}
											echo '<option value="'.$timezone.'"'.$sel.'>'.$time->format('e').' UTC'.$time->format('P').' '.$ampm.'</option>';
											//.substr($timezone, strlen($name) + 1) . ' - ' . $ampm
										}
										//echo '</optgroup>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3 pad-sm"><label class="mylabel">Location<span class="required-field">*</span></label></div>
							<div style="padding: 0px 7px;" class="col-md-6 form-size">		
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
						<div class="row" id="state_block"<?=((isset($row['country']) and $row['country']=='1') ? '' : ' style="display: none;"')?> >
							<div style="padding: 0px 7px 0 14px;" class="col-md-3 col-md-offset-3 form-size">
								<div class="form-group">
									<label class="mylabel">State<span class="required-field">*</span></label>							
									<select name="state" class="form-control linkibox_select">
										<option value="">Select</option>
										<?php
										foreach($states as $state){
											$sel = '';
											if(isset($row['state']) and $row['state'] == $state['id'])
												$sel = ' selected="selected"';	
											echo '<option value="'.$state['id'].'"'.$sel.'>'.$state['state_name'].'</option>';
										}	
										?>
									</select>
								</div>
							</div>
							<div style="padding-left: 7px;" class="col-md-3 form-size">
								<div class="form-group">							
									<label class="mylabel">Zip Code<span class="required-field">*</span></label>							
									<input type="text" name="zip_code" class="form-control onlynumbers" value="<?=((isset($row['zip_code']) and $row['zip_code']!='') ? $row['zip_code'] : '')?>" maxlength="10">						
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3 pad-sm"><label class="mylabel">Subscribe<span class="required-field">*</span></label></div>
							<div style="padding: 0px 7px;" class="col-md-2 form-size">		
								<select class="form-control linkibox_select" name="subscribe">
									<option value="">Select ...</option>
									<?php
									$subscribe = array('No','Yes');
									foreach($subscribe as $index=>$val){
										$sel = '';
										if(isset($row['subscribe']) and $row['subscribe'] == $index)
											$sel = ' selected="selected"';

										echo '<option value="'.$index.'"'.$sel.'>'.$val.'</option>';
									}	
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-3"></div>
							<div class="col-md-8" style="padding-left: 7px;">

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
					
				</div>
				<div class="submit_btn text-right">
					<button type="submit" class="orange-btn" id="send_register">Update ></button>		
				</div>	
			</div>
		</div>
	</div>		
	</form>
</div>
</div>
</div>
</div>
<div class="blue-border"></div>
</section>


<style>
.lft {
    padding-left: 0;
}
.fst {
background-color: #fff;
margin-bottom: 1px;}
.personal_account_register {
background: #fff none repeat scroll 0 0;
padding: 1px;
}

#public-bag .advertise {color: #fff;background-color: #004080;border-color: none;border-radius: 0px;
font-weight: 600;margin-top: 30px;padding: 5px 5px 5px 5px;}
.a {font-weight: 500;}
@media only screen and (max-width: 500px) {
.rgt .table .table-responsive {min-height: .01%;overflow-x: 0px;}
.containt-area {padding-top: 30px;padding-bottom: 30px;}
.table-responsive {min-height: .01%;overflow-x: 0px auto;}
.left h2 a {font-size: 22px;}                  
}
.submit_btn {
    margin: 17px 0;
}
.lft .welcome-name {
    margin-bottom: 13px;
}
.left-links p{
	margin:0px;
}
</style>


		<script>
		function show_answer(val){
			if(val != 0)
				$('input[name="security_answer"]').val('');

		}

		</script>
		<?php  }    ?>
