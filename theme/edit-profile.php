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


	$co->page_title = "Edit Profile | LinkiBag";


	$current = $co->getcurrentuser_profile();
	$row = $co->query_first("SELECT p.*, u.* FROM users u, profile p WHERE u.uid=:id AND u.uid=p.uid",array('id'=>$current['uid']));
	//print_r($row);
	$countries = $co->fetch_all_array("select id,country_name from countries ORDER BY id ASC", array());
	$states = $co->fetch_all_array("select id,state_name from states ORDER BY id ASC", array());
	$securiy_questions1 = $co->fetch_all_array("select * from securiy_questions where id IN(1,2,3,4,5) ORDER BY RAND()", array());
	$securiy_questions2 = $co->fetch_all_array("select * from securiy_questions where id IN(6,7,8,9,10) ORDER BY RAND()", array());
	$securiy_questions3 = $co->fetch_all_array("select * from securiy_questions where id IN(11,12,13,14,15) ORDER BY RAND()", array());
	
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

					<div class="col-md-9 edit_profile_area">
						<div class="row">
							<div class="col-md-2 col-xs-12"></div> 
							<div class="col-md-8 col-xs-12">
								<div id="messagesout">
									<div class="alert alert-success" style="text-align: center; display:none;">
										Updated successfully!
									</div>
								</div>
							</div>
							<div class="col-md-2 col-xs-12"><a href="<?php echo WEB_ROOT; ?>index.php?p=dashboard">Back to Inbag</a></div> 
						</div>
					<div class="row">
						<div class="col-md-12 edit_profile_top">
							<p class="green-title" style="margin-top: 0px;">Edit Profile</p>
						</div>
						<form class="sign_up_page_form" method="post" id="edit_profile_form" action="index.php?p=edit_profile&ajax=ajax_submit" onsubmit="javascript: return submit_edit_profile();" enctype="multipart/form-data">
						
							
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
									
									

								</div>
							</div>
							<div class="col-md-8 col-xs-12">							               
									<div class="col-md-12 text-left wow fadeInUp templatemo-box">
										<div class="row">
											<div class="personal_account_register">
												<div class="fst">
												    	
													<div class="form-group">
														<div class="col-md-3 pad-sm"><label class="mylabel">Name<span class="required-field">*</span></label></div>
														<div style="padding-left: 7px" class="col-md-2 padding_remove">
															<select class="form-control linkibox_select" name="salutation">
															    <option value="">---</option>
																<option value="mr"<?=((isset($row['salutation']) and $row['salutation']=='mr') ? ' selected="selected"' : '')?>>Mr.</option>
																<option value="ms"<?=((isset($row['salutation']) and $row['salutation']=='ms') ? ' selected="selected"' : '')?>>Ms.</option>
																<option value="mrs"<?=((isset($row['salutation']) and $row['salutation']=='mrs') ? ' selected="selected"' : '')?>>Mrs.</option>
																<option value="dr"<?=((isset($row['salutation']) and $row['salutation']=='dr') ? ' selected="selected"' : '')?>>Dr.</option>
															</select>
														</div>
														<div style="padding: 0 7px;" class="col-md-3 form-size">
														<?php 
														if($row['first_name']!='') 
														{
														    $firstname= trim($row['first_name']);
														} else $firstname= '';
														?>
															<input type="text"  placeholder="First Name" name="first_name" class="form-control first_name" maxlength="50"  value="<?php echo trim($firstname)?>" />  
														</div>
														<!-- <div style="padding: 0px 7px;" class="col-md-3 form-size">
															<input type="text" name="middle_name" class="form-control" maxlength="50" id="pwd" value="<?=((isset($row['middle_name']) and $row['middle_name']!='') ? $row['middle_name'] : '')?>" />  
														</div>-->
														<div style="padding: 0px 7px;" class="col-md-3 form-size">
															<input type="text" placeholder="Last Name" name="last_name" class="form-control last_name" maxlength="50" value="<?=((isset($row['last_name']) and $row['last_name']!='') ? $row['last_name'] : '')?>" />   
														</div> 
													</div>
													<div class="form-group">
														<div class="col-md-3 pad-sm"><label class="mylabel">Company</label></div>
														<div style="padding: 0px 7px;" class="col-md-6 form-size">
															<input type="text" placeholder="Company"  name="company_name" class="form-control" maxlength="50" value="<?=((isset($row['company_name']) and $row['company_name']!='') ? $row['company_name'] : '')?>" />   
														</div>
													</div>
													<div class="form-group">
														<div class="col-md-3 pad-sm"><label class="mylabel">Login</label></div>
														<div style="padding: 0px 7px;" class="col-md-6 form-size">
															<input type="text" name="email_id" aria-describedby="basic-addon1" placeholder="" class="form-control" value="<?=((isset($row['email_id']) and $row['email_id']!='') ? substr($row['email_id'],0,35) : '')?>" disabled/>			
														</div>
														<div class="col-md-2 pad-sm"><a href="index.php?p=verify_email&email_unique_path=<?=$reset_code?>" target="_blank">Update</a></div>
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
						<!--<div style="margin-bottom: 0px;" class="form-group">-->
						<!--	<div class="col-md-3 pad-sm"><label class="mylabel">Password<span class="required-field">*</span></label></div>-->
						<!--	<div style="padding: 0px 7px;" class="col-md-3 form-size">              -->
						<!--		<input placeholder="Password *" type="Password" name="password" autocomplete="off" class="form-control password" >             -->
						<!--	</div>-->
						<!--	<div style="padding: 0px 7px;" class="col-md-3 form-size">              -->
						<!--		<input placeholder="Confirm Password *" type="password" name="reapt_pass" value="" autocomplete="off" class="form-control reapt_pass" id="pwd">-->
						<!--	</div>-->
							
						<!--	<div class="col-md-2 pad-sm"><a href="index.php?p=update_pass&email_unique_path=<?=$reset_code?>" target="_blank">Update</a></div>-->
						<!--</div>-->
						<!--<div class="form-group">-->
						<!--	<div class="col-md-10 col-sm-offset-3" style="padding-left: 7px;"><small style="color: #7f7f7f;">Min 8 characters, must contain at least one lowercase letter, one uppercase letter, one numeric digit and one special character.</small></div>-->
						<!--</div>-->
					</div>


					


					<div style="border-top: 6px solid #c3c3c3; border-bottom: 6px solid #c3c3c3; padding: 11px 0px 0px; margin: 18px 0px 17px;" class="fst">
						

                        <p>Please setup three different security question and answers below.</p>
						<div class="form-group">
							<div class="col-md-3 pad-sm"><label class="mylabel">Question One<span class="required-field">*</span></label></div>
							<div style="padding: 0px 7px;" class="col-md-9 form-size">
								<select class="form-control linkibox_select security_question" name="security_question" onchange="show_answer(this.value);">
									<option value="">Select a question...</option>
									<?php
									foreach($securiy_questions1 as $list){
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
							<div style="padding: 0px 7px;" class="col-md-9 form-size">		
								<input placeholder="Type your answer" type="text" name="security_answer" class="form-control security_answer" value="<?=((isset($row['security_answer']) and $row['security_answer']!='') ? $row['security_answer'] : '')?>"> 			
							</div>
							
						</div>
					

						<div class="form-group">
							<div class="col-md-3 pad-sm"><label class="mylabel">Question Two<span class="required-field">*</span></label></div>
							<div style="padding: 0px 7px;" class="col-md-9 form-size">
								<select class="form-control linkibox_select security_question2" name="security_question2" onchange="show_answer2(this.value);">
									<option value="">Select a question...</option>
									<?php
									foreach($securiy_questions2 as $list){
										$sel = '';
										if(isset($row['security_question2']) and $row['security_question2'] == $list['id'])
											$sel = ' selected="selected"';	
										echo '<option value="'.$list['id'].'"'.$sel.'>'.$list['security_question'].'</option>';
									}	
									?>
								</select>			
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-md-3 pad-sm"><label class="mylabel">Answer<span class="required-field">*</span></label></div>
							<div style="padding: 0px 7px;" class="col-md-9 form-size">		
								<input placeholder="Type your answer" type="text" name="security_answer2" class="form-control security_answer2" value="<?=((isset($row['security_answer2']) and $row['security_answer2']!='') ? $row['security_answer2'] : '')?>"> 			
							</div>
							
						</div>
					


						<div class="form-group">
							<div class="col-md-3 pad-sm"><label class="mylabel">Question Three<span class="required-field">*</span></label></div>
							<div style="padding: 0px 7px;" class="col-md-9 form-size">
								<select class="form-control linkibox_select security_question3" name="security_question3" onchange="show_answer3(this.value);">
									<option value="">Select a question...</option>
									<?php
									foreach($securiy_questions3 as $list){
										$sel = '';
										if(isset($row['security_question3']) and $row['security_question3'] == $list['id'])
											$sel = ' selected="selected"';	
										echo '<option value="'.$list['id'].'"'.$sel.'>'.$list['security_question'].'</option>';
									}	
									?>
								</select>			
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-md-3 pad-sm"><label class="mylabel">Answer<span class="required-field">*</span></label></div>
							<div style="padding: 0px 7px;" class="col-md-9 form-size">		
								<input placeholder="Type your answer" type="text" name="security_answer3" class="form-control security_answer3" value="<?=((isset($row['security_answer3']) and $row['security_answer3']!='') ? $row['security_answer3'] : '')?>"> 			
							</div>
							
						</div>
					</div>


					<div class="fst">
						<div class="form-group" id="user_timezone">
							
							<div class="col-md-3 pad-sm"><label class="mylabel">Time Zone</label></div>
							<div style="padding: 0px 7px;" class="col-md-9 form-size">		
								<select class="form-control linkibox_select" name="user_timezone">
								
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
									
							$regionss = array(
								'US/Samoa'             => "(UTC-11) Samoa Standard Time (ST)",
								'US/Hawaii'            => "(UTC-10) Hawaii-Aleutian Standard Time (HAT)",
								'US/Alaska'            => "(UTC-9) Alaska Standard Time (AKT)",
								'US/Pacific'           => "(UTC-8) Pacific Standard Time (PT)",
								'US/Mountain'          => "(UTC-7) Mountain Standard Time (MT)",
								'US/Central'           => "(UTC-6) Central Standard Time (CT)",
								'US/Eastern'           => "(UTC-5) Eastern Standard Time (ET)",
								'Canada/Atlantic'      => "(UTC-4) : Atlantic Standard Time (AST)",
								'US/Guam'      		   => "(UTC+10) Chamorro Standard Time (ChT)",
								'US/Wake'              => "(UTC+12) Wake Island Time Zone (WIT)"
							);
							foreach ($regionss as $key => $value)
							{
								$sel = '';
								if($row['user_timezone']!='')
								{
									if(!empty($row['user_timezone']) and $row['user_timezone']==$key){
										$sel = ' selected="selected"';
									} 
								}
								else if($key=='US/Central'){
									$sel = ' selected="selected"';
								}	
								echo '<option value="'.$key.'" '.$sel.'>'.$value.'</option>';
										
							}
							
									// foreach ($regions as $name => $mask)
									// {
									// 	$zones = DateTimeZone::listIdentifiers($mask);
									// 	//echo '<optgroup label="'.$name.'">';
									// 	foreach($zones as $timezone)
									// 	{
									// 		$time = new DateTime(NULL, new DateTimeZone($timezone));
									// 		$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
									// 		$sel = '';
									// 		if(!empty($row['user_timezone']) and $row['user_timezone']==$timezone){
									// 			$sel = ' selected="selected"';
									// 		}
									// 		echo '<option value="'.$timezone.'"'.$sel.'>'.$time->format('e').' UTC'.$time->format('P').' '.$ampm.'</option>';
									// 		//.substr($timezone, strlen($name) + 1) . ' - ' . $ampm
									// 	}
									// 	//echo '</optgroup>';
									// }
									?>
								</select>
							</div>
						</div>
					
						<div class="form-group">
							<div class="col-md-3 pad-sm"><label class="mylabel">Location<span class="required-field">*</span></label></div>
							<div style="padding: 0px 7px;" class="col-md-6 form-size">		
								<select class="form-control linkibox_select country" name="country" onchange="show_states(this.value)">
									<option value="">Select Country</option>
									<?php
									$roww = $co->query_first("SELECT * from linkibag_service_countries WHERE service_id=:id",array('id'=>1));
									$allowed_counties = array();
									if(@unserialize($roww['allowed_counties'])) {
										$allowed_counties = unserialize($roww['allowed_counties']);
									}

								


									foreach($countries as $country){

										if(in_array($country['id'], $allowed_counties)){
										$sel = '';//if($country['id']==1 || $country['id']==2){
											if(isset($row['country']) and $row['country'] == $country['id'])
											$sel = ' selected="selected"';	
										echo '<option value="'.$country['id'].'"'.$sel.'>'.$country['country_name'].'</option>';
									//}

									}
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
									<input type="text" placeholder="00000" name="zip_code" class="form-control onlynumbers" value="<?=((isset($row['zip_code']) and $row['zip_code']!='') ? $row['zip_code'] : '00000')?>" maxlength="10">						
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4 pad-sm"><label class="mylabel">Email updates turned <span class="required-field">*</span></label></div>
							
								
								
									<input class='tgl tgl-skewed' id='cb3' onChange="subscribeChange(this)" onClick="subscribeChange()" type='checkbox' name="subscribe"
									<?php
									
									 if(isset($row['subscribe']) and $row['subscribe'] == "1") {?> checked="checked" <?php } ?>>
									<label class='tgl-btn' data-tg-off='OFF' data-tg-on='ON' for='cb3'></label>
									<label class='tgl-btn' for='cb3'>
								
									</label>
									<label class="mylabel">Subscribe my email to receive offers and promotions from LinkiBag advertisers.</label>
							 <div style="padding: 0px 7px;" class="col-md-2 form-size">	
							
								<select class="form-control linkibox_select" name="subscribes">
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
							<p style="display:none" class="errorr haserror">Some information is missing or not entered. Please try again. </p>
							<div style="display:none">
							<input id="checkbox3" type="checkbox" name="sign_me_for_email_filter" value="1" <?=((isset($row['sign_me_for_email_filter']) and $row['sign_me_for_email_filter'] == '1') ? ' checked="checked"' : '')?>>            
								</div>	
						</div>

			
					</div>
					
				</div>
				<div class="submit_btn text-right">
					<button style="float:left; margin-bottom:10px;" type="submit" class="orange-btn" id="send_register">Update </button>		
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

		}	function show_answer2(val){
			if(val != 0)
				$('input[name="security_answer2"]').val('');

		}	function show_answer3(val){
			if(val != 0)
				$('input[name="security_answer3"]').val('');

		}

		</script>
		<?php  }    ?>
