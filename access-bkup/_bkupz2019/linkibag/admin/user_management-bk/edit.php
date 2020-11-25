<?php

$breadcrumb = 'User Management';

$title = '<i class="fa fa-table"></i> Edit User Information';

if(isset($_POST['save'])){	

		$_POST['salutation'] = trim($_POST['salutation']);

		$_POST['salutation'] = trim($_POST['salutation']);
		$_POST['salutation'] = strip_tags($_POST['salutation']);
		
		$_POST['email_id'] = trim($_POST['email_id']);
		$_POST['email_id'] = strip_tags($_POST['email_id']);
		
		$_POST['pass'] = trim($_POST['pass']);
		$_POST['pass'] = strip_tags($_POST['pass']);
		
		$_POST['first_name'] = trim($_POST['first_name']);
		$_POST['first_name'] = strip_tags($_POST['first_name']);
		
		$_POST['last_name'] = trim($_POST['last_name']);
		$_POST['last_name'] = strip_tags($_POST['last_name']);
		
		
		$success=true;



		if($_POST['salutation']==""){
			$co->setmessage("error", "Please enter salutation");
			$success=false;
		}
		if($_POST['first_name']==""){
			$co->setmessage("error", "Please enter first name");
			$success=false;
		}
		if($_POST['last_name']==""){
			$co->setmessage("error", "Please enter last name");
			$success=false;
		}
		if(!isset($_POST['country']) or (isset($_POST['country']) and $_POST['country'] == '')){
			$co->setmessage("error", "Please choose country");
			$success=false;
		}
		if(isset($_POST['country']) and $_POST['country'] == 230){
			if(!isset($_POST['state']) or (isset($_POST['state']) and $_POST['state'] == '')){
				$co->setmessage("error", "Please choose state");
				$success=false;
			}
			if($_POST['zip_code'] == ''){
				$co->setmessage("error", "Please enter zip code");
				$success=false;
			}
		}	
		//check if email_id empty
		if($_POST['email_id']==""){
			$co->setmessage("error", "Please enter email");
			$success=false;
		}

		if(isset($_POST['email_id']) and $_POST['email_id']!=''){
			$email =  $_POST['email_id'];
			$find = stripos($email, '@');
			$domain_name = substr($_POST['email_id'], $find);
			$domain_name_array = array('@hotmail.com', '@yahoo.com', '@gmail.com', '@Hotmail.com', '@Yahoo.com', '@Gmail.com');
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$co->setmessage("error", "$email is not a valid email address");
				$success=false;
			}elseif(!in_array($domain_name, $domain_name_array)){
				$co->setmessage("error", " LinkiBag did not recognize your email vendor as a public email provider from our list");
				$success=false;
			}elseif($co->is_userExists_edit($email, $_POST['id'])){
				$co->setmessage("error", "$email is already existed");
				$success=false;
			}
			
		}

		if($_POST['pass']==""){
			$co->setmessage("error", "Please enter password");
			$success=false;
		}
		
		
		if(isset($_POST['pass']) and $_POST['pass']!=''){
			$password =  strlen($_POST['pass']);
			if ($password<8){
				$co->setmessage("error", "password is not a valid at least 8 of the characters");
				$success=false;
			}
			$containsLetter  = preg_match('/[a-zA-Z]/', $_POST['pass']);
			$containsDigit   = preg_match('/\d/', $_POST['pass']);
			//$containswhitespace = preg_match('/ /', $_POST['password']);

			if (!$containsLetter or !$containsDigit) {
				$co->setmessage("error", "password must contain at least one letter and one number and no spaces");
				$success=false;
			}	
		}
		
		

		if(!isset($_POST['role'])){

			$co->setmessage("error", "Please select account type");

			$success=false;

		}
		if(isset($_POST['role']) and $_POST['role'] != 1){

			if($_POST['start_date'] == ''){

				$co->setmessage("error", "Please enter start date");

				$success=false;

			}
			if($_POST['end_date'] == ''){

				$co->setmessage("error", "Please enter end date");

				$success=false;

			}

		}
		if(!isset($_POST['status'])){

			$co->setmessage("error", "Please choose status");

			$success=false;

		}
		 

		if ($success == true) {

			$up = array();

			$up['email_id'] = $_POST['email_id'];

			$up['pass'] = $_POST['pass'];

			$up['decrypt_pass'] = md5($_POST['pass']);

			$up['role'] = $_POST['role'];

			$up['status'] = $_POST['status'];

			$up['updated'] = time();

			

			$co->query_update('users', $up, array('id'=>$_POST['id']), 'uid=:id');

			unset($up);

			

			$up['first_name'] = $_POST['first_name'];

			$up['last_name'] = $_POST['last_name'];

			$up['salutation'] = $_POST['salutation'];
			
			$up['country'] = $_POST['country'];
			
			$up['state'] = $_POST['state'];
			
			$up['zip_code'] = $_POST['zip_code'];

			$up['start_date'] = date('Y-m-d', strtotime($_POST['start_date']));
			
			$up['end_date'] = date('Y-m-d', strtotime($_POST['end_date']));

			$co->query_update('profile', $up, array('id'=>$_POST['id']), 'profile_id=:id');

			unset($up);

			$co->setmessage("status", "Users updated successfully");

			echo '<script type="text/javascript">window.location.href="main.php?p=user_management/manage"</script>';

			exit();

		}

}





if(isset($_GET['id'])){

	$row = $co->query_first("SELECT u.*, p.* from profile p, users u WHERE u.uid=p.uid and u.uid=:id",array('id'=>$_GET['id']));

	if($row['uid']){
	$countries = $co->fetch_all_array("select id,country_name from countries ORDER BY id ASC", array());
	$states = $co->fetch_all_array("select id,state_name from states ORDER BY id ASC", array());	
		

?>
			<div style="overflow: hidden">	
					<div class="col-sm-2 text-right"><strong style="padding: 0px 12px 0px 0px;">Membership Start</strong></div>
					<div style="padding: 0px;" class="col-sm-2"><strong style="font-weight: 400;">: <?=date('j F, Y', $row['created'])?></strong></div>
					<div style="overflow: hidden; width: 100%; height: 15px;"></div>
					<div class="col-sm-2 text-right"><strong style="padding: 0px 12px 0px 0px;">Last Login</strong> </div>
					<div style="padding: 0px;" class="col-sm-2"><strong style="font-weight: 400;">: <?=date('j F, Y', $row['last_login_time'])?></strong></div>	 				
			</div>	
			<br/>
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				
				<input type="hidden" name="id" value="<?=$row['uid']?>" />
				
				<div class="form-group">

					<label class="col-sm-2 control-label">Salutation</label>

					<div class="col-sm-8">

						<select class="form-control linkibox_select" name="salutation">
							<?php
							$salutation = array('mr'=>'Mr.', 'ms'=>'Ms.', 'mrs'=>'Mrs.', 'dr'=>'Dr.');
							
                             foreach($salutation as $sal_val=>$sal_name){
								$sel = '';
								if(isset($row['salutation']) and $row['salutation'] == $sal_val)
									$sel = ' selected="selected"';	
								echo '<option value="'.$sal_val.'"'.$sel.'>'.$sal_name.'</option>';
							}
							?>
                           </select>

					</div>

				</div>
				<div class="form-group">

					<label class="col-sm-2 control-label">First Name</label>

					<div class="col-sm-8">

						<input type="text" name="first_name" class="form-control" value="<?php echo $row['first_name']; ?>" /> 

					</div>	

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Last Name</label>

					<div class="col-sm-8">

						<input type="text" name="last_name" class="form-control" value="<?php echo $row['last_name']; ?>" /> 

					</div>				

				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Country<span class="required-field">*</span></label>
					<div class="col-sm-8">	
						<select class="form-control" name="country" onchange="show_states(this.value)">
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
				<div id="state_block"<?=((isset($row['country']) and $row['country'] == 230) ? '' : ' style="display: none;"')?>>
					<div class="form-group">
						<label class="col-sm-2 control-label">State<span class="required-field">*</span></label>
						<div class="col-sm-4">	
							<select name="state" class="form-control">
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
					<div class="form-group">
						<label class="col-sm-2 control-label">Zip Code<span class="required-field">*</span></label>
						<div class="col-sm-4">	
							<input type="text" name="zip_code" class="form-control" value="<?php echo $row['zip_code']; ?>">
						</div>	
					</div>
				</div>			
				
				<div class="form-group">

					<label class="col-sm-2 control-label">Email</label>

					<div class="col-sm-8">

						<input type="text" name="email_id" class="form-control" value="<?php echo $row['email_id']; ?>" /> 

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Password</label>

					<div class="col-sm-8">

						<input type="password" name="pass" class="form-control" value="<?php echo $row['pass']; ?>" /> 

					</div>

				</div>

				

				<div class="form-group">

					<label class="col-sm-2 control-label">Account Type</label>

					<div class="col-sm-8">

						<input type="radio" name="role"  onclick="show_time_period(this.value)" value="1" <?php if ($row['role'] == 1) { echo 'checked';} ?>> Personal

						<input type="radio" name="role"  onclick="show_time_period(this.value)" value="2" <?php if ($row['role'] == 2) { echo 'checked';} ?>> Business

						<input type="radio" name="role"  onclick="show_time_period(this.value)" value="3" <?php if ($row['role'] == 3) { echo 'checked';} ?>> Education

					</div>

				</div>
				<div class="form-group" id="time_block"<?=((isset($row['role']) and $row['role'] !=1 ) ? '' : ' style="display: none;"')?>>
					<div class="form-group">

						<label class="col-sm-2 control-label">Start Date</label>

						<div class="col-sm-8">

							<input type="text" name="start_date" class="form-control date_picker" value="<?=($row['start_date'] != '0000-00-00' ? date('m/d/Y', strtotime($row['start_date'])) : '')?>" /> 

						</div>

					</div>
					<div class="form-group">

						<label class="col-sm-2 control-label">End Date</label>

						<div class="col-sm-8">

							<input type="text" name="end_date" class="form-control date_picker" value="<?=($row['end_date'] != '0000-00-00' ? date('m/d/Y', strtotime($row['end_date'])) : '')?>" /> 

						</div>

					</div>
				</div>
				<div class="form-group">

					<label class="col-sm-2 control-label">Status</label>

					<div class="col-sm-8">

						<input type="radio" name="status"  value="1" checked /> Active

						<input type="radio" name="status"  value="0" <?php if ($row['status'] == 0) { echo 'checked';} ?> /> Blocked

					</div>

				</div>	

				<!--<div class="form-group">

					<label class="col-sm-2 control-label">Account</label>

					<div class="col-sm-8">

						<input type="text" name="account" class="form-control" value="<?php echo $row['account']; ?>" /> 

					</div>

				</div>	-->

				<div class="form-group">

				 <div class="col-sm-4 col-sm-offset-2">

					<button type="submit"  name="save" value="Save" class="btn btn-primary">Save changes</button>

					</div>

				</div>

			</form>

            <?php

			}

			}

			?>

