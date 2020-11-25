<?php
$breadcrumb = 'Advertisement Management';
$title = '<i class="fa fa-table"></i> Edit Advertisement Information';
if(isset($_POST['save'])){		$success = true;
	/*if(!isset($_FILES['photo_path']['tmp_name']) or $_FILES['photo_path']['tmp_name'] == ""){					$co->setmessage("error", "Please upload image");		$success=false;	}*/	
	if(!isset($_POST['status'])){
		$co->setmessage("error", "Please choose status");		
		$success=false;	
	}	
	if(isset($_POST['password']) and $_POST['password']!=''){
		$password =  strlen($_POST['password']);
		if ($password<8){
			$co->setmessage("error", "password is not a valid at least 8 of the characters");
			$success=false;
		}
		$containsLetter  = preg_match('/[a-zA-Z]/', $_POST['password']);
		$containsDigit   = preg_match('/\d/', $_POST['password']);
		//$containswhitespace = preg_match('/ /', $_POST['password']);

		if (!$containsLetter or !$containsDigit) {
			$co->setmessage("error", "password must contain at least one letter and one number and no spaces");
			$success=false;
		}	
	}
	if ($success == true) {
		$up = array();
		$up['uid'] = '0';	
	
		$up['name'] = $_POST['name'];
		$up['username'] = $_POST['username'];	
		$up['category']=serialize($_POST['assign_category']);
		$up['state'] =serialize($_POST['assign_state']);
		$up['zipcode'] =serialize($_POST['assign_zipcode']);
		if(isset($_POST['password']) and $_POST['password']!=''){		
		$up['password'] = md5($_POST['password']);	
		}	
		$up['created'] = time();		
		$up['updated'] = time();	
		$co->query_update('admin_advertisement', $up, array('id'=>$_POST['id']), 'adid=:id');
		unset($up);
		$co->setmessage("status", "Advertisement updated successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=advertisement_management/manage"</script>';
		exit();
	}
}


if(isset($_GET['id'])){
	$row = $co->query_first("SELECT * from admin_advertisement WHERE adid=:id",array('id'=>$_GET['id']));
	if($row['adid'] > 0){

		$assign_categories = array();
if(@unserialize($row['category'])) {
	$assign_categories = unserialize($row['category']);
}

$assign_states = array();
if(@unserialize($row['state'])) {
	$assign_states = unserialize($row['state']);
}

$assign_zip = array();
if(@unserialize($row['zipcode'])) {
	$assign_zip = unserialize($row['zipcode']);
}
?>
<form method="post" enctype="multipart/form-data" class="form-horizontal">
		<input type="hidden" name="id" value="<?=$row['adid']?>" />
		<div class="form-group row">		
			<label class="col-sm-2 control-label">Name *</label>			
			<div class="col-sm-8">						
				<input type="text" class="form-control" name="name" maxlength="50" value="<?=$row['name']?>">	
			</div>	
		</div>	
					
		<div class="form-group row">	
			<label class="col-sm-2 control-label">Username *</label>	
			<div class="col-sm-8">				
				<input type="text" class="form-control " name="username" maxlength="50" autocomplete="off" value="<?=$row['username']?>">			
			</div>				
		</div>				
		<div class="form-group row">		
			<label class="col-sm-2 control-label">Password </label>			
				<div class="col-sm-8">						
					<input type="password" class="form-control" name="password" maxlength="50" value="">	
				<p>
				<i><small>(Please add password if you want to update or set empty if don't want to change)</small></i>
				</p>
				</div>	
		</div>	

		<div class="form-group">
					<label class="col-sm-2 control-label">Category *</label>
					<div class="col-sm-8">
						<select name="assign_category[]" multiple="multiple" class="form-control">
					<?php
					$categories = $co->show_all_category();
					
					foreach($categories as $cat){

							$sel = '';
							if(in_array($cat['cid'], $assign_categories))
								$sel = ' selected="selected"';

							echo '<option value="'.$cat['cid'].'"'.$sel.'>'.$cat['cname'].'</option>';
						
					?>
						
					<?php } ?>	
						</select>	
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-sm-2 control-label">State *</label>
					<div class="col-sm-8">
						<select name="assign_state[]" multiple="multiple" class="form-control">
					<?php
					$states = $co->fetch_all_array("select id,state_name from states ORDER BY id ASC", array());	
		
					
					foreach($states as $st){
						$sel = '';
						if(in_array($st['id'], $assign_states))
							$sel = ' selected="selected"';

						echo '<option value="'.$st['id'].'"'.$sel.'>'.$st['state_name'].'</option>';
					
				
					?>
						
					<?php } ?>	
						</select>	
					</div>
				</div>	

				<div class="form-group row">
					<label class="col-sm-2 control-label">Zip *</label>
					<div class="col-sm-8">
						<select name="assign_zipcode[]" multiple="multiple" class="form-control">
					<?php
					$zip = $co->fetch_all_array("select distinct zip_code from profile ORDER BY zip_code ASC", array());	
		
					foreach($zip as $zt){
						$sel = '';
						if(in_array($zt['zip_code'], $assign_zip))
							$sel = ' selected="selected"';

						echo '<option value="'.$zt['zip_code'].'"'.$sel.'>'.$zt['zip_code'].'</option>';
					
				
					?>
						
					<?php } ?>		
						</select>	
					</div>
				</div>	


		<div class="form-group">		
			<label class="col-sm-2 control-label">Status</label>	
			<div class="col-sm-8">					
			<input type="radio" name="status"  value="1" <?php if (isset($row['status']) and $row['status'] == 1) { echo 'checked';} ?>> Active		
			<input type="radio" name="status"  value="0" <?php if (isset($row['status']) and $row['status'] == 0) { echo 'checked';} ?>> Non Active							
		</div>			
	</div>
	<div class="form-group">
		<div class="col-sm-4 col-sm-offset-2">
			<button type="submit"  name="save" value="Save" class="btn btn-primary">Save changes</button>
		</div>
	</div>
</form> 
    <?php
	}else{
		exit();
	}
}
	?>
