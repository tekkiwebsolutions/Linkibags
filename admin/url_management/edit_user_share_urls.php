<?php
$breadcrumb = 'Share Url Management';
$title = '<i class="fa fa-table"></i> Edit Share Url Information';
if(isset($_POST['save'])){	
		$rowpost = $co->query_first("SELECT url.*, c.*,p.first_name,p.last_name,us.*,u.email_id from category c, user_urls url, profile p, `user_shared_urls` us, `users` u WHERE us.uid=u.uid and us.url_id=url.url_id and url.uid=us.uid and p.uid=url.uid and us.url_cat=c.cid and url.status='1' and us.shared_to>'0' and us.shared_url_id=:id",array('id'=>$_POST['id']));
		if(!(isset($rowpost['shared_url_id']) and $rowpost['shared_url_id'] > 0))
			exit();

		$success=true;
		
		if(!isset($_POST['recommend_link'])){
			$co->setmessage("error", "Please select  Type");
			$success=false;
		}

		if(isset($_POST['recommend_link']) and $_POST['recommend_link'] == 1){			
			if($_POST['public_cat_change']==""){
				$co->setmessage("error", "Please select public category");
				$success=false;
			}
		}
		
		if ($success == true) {
			$up = array();
			$up['approved_public'] = $_POST['recommend_link'];
			
			if(isset($_POST['recommend_link']) and $_POST['recommend_link'] == 1){	
				$up['approved_public_cat'] = $_POST['public_cat_change'];
			}else{
				$up['approved_public_cat'] = 0;
			}
			$up['approved_public_time'] = time();
			$co->query_update('user_urls', $up, array('id'=>$_POST['id']), 'url_id=:id');
			unset($up);
			$co->setmessage("status", "Share Url updated successfully");
			
			echo '<script type="text/javascript">window.location.href="main.php?p=url_management/manage_user_share_urls"</script>';		
			exit();
		}
}


if(isset($_GET['id'])){
	$row = $co->query_first("SELECT url.*,p.first_name,p.last_name,u.email_id from user_urls url, profile p, `users` u WHERE p.uid=url.uid and p.uid=u.uid and url.status='1' and url.url_id=:id",array('id'=>$_GET['id']));
	if($row['url_id']){
		$created_by = '';
		if($row['first_name'] != '' )
			$created_by .= $row['first_name'];
		if($row['last_name'] != '' )
			$created_by .= ' '.$row['last_name'];
		$created_by .= '<br />'.$row['email_id'];
?>
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				<input type="hidden" name="id" value="<?=$row['url_id']?>" />							

				<div class="form-group">
					<label class="col-sm-2 control-label">Url Value </label>
					<div class="col-sm-8">
						<?php echo $row['url_value']; ?>
					</div>				
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Created By </label>
					<div class="col-sm-8">
						<?php echo $created_by; ?> 
					</div>	
				</div>
				<div class="form-group">					
					<label class="col-sm-2 control-label">Status *</label>					
					<div class="col-sm-8">						
						<input type="radio" name="recommend_link" onclick="show_block('#','#recommend_link_yes');" value="0"<?php echo (((isset($_POST['recommend_link']) and $_POST['recommend_link'] == 0) OR ($row['approved_public']==0)) ? ' checked="checked"' : ''); ?> /> Pending 						
						<input type="radio" name="recommend_link" onclick="show_block('#recommend_link_yes','#');" value="1"<?php echo (((isset($_POST['recommend_link']) and $_POST['recommend_link'] == 1) OR ($row['approved_public']==1)) ? ' checked="checked"' : ''); ?> /> Approved					
					</div>	
				</div>
				<div id="recommend_link_yes"<?=(((isset($_POST['recommend_link']) and $_POST['recommend_link'] == 1) OR (isset($row['approved_public']) and $row['approved_public']==1)) ? '' : ' style="display:none;"') ?>>
					<div class="form-group">
						<label class="col-sm-2 control-label">Public Category *</label>
						<div class="col-sm-8">
							<select name="public_cat_change" class="form-control">
								<option value="">Select..</option>
						<?php
						$user_public_categories = $co->fetch_all_array("select * from user_public_category where status='1'",array()); 
						
						foreach($user_public_categories as $cat){
							$sel = '';
							if(isset($_POST['public_cat_change']) and $_POST['public_cat_change'] == $cat['cid']){
								$sel = ' selected="selected"';
							}else if(isset($row['approved_public_cat']) and $row['approved_public_cat'] == $cat['cid']){
								$sel = ' selected="selected"';
							}
							echo '<option value="'.$cat['cid'].'"'.$sel.'>'.$cat['cname'].'</option>';
						?>
							
						<?php } ?>	
							</select>	
						</div>
					</div>
					<?php /*
					<div class="form-group">
						<label class="col-sm-2 control-label">Upload Photo </label>
						<div class="col-sm-8">
							<?php if($row['photo'] != '' and file_exists('../'.$row['photo'])){ ?>
							<img id="show_upload_photo" src="../<?=$row['photo']?>" style="width:100px; height: 60px;"/>
							<?php }?>
							<input type="file" name="photo" id="upload_photo"<?=($row['recommend_link'] == 1 and $row['photo'] == '') ? ' required' : ''?> /> 
						</div>	
					</div>
					*/ ?>
				</div>	
				
				<div class="form-group">
				<div class="col-sm-4 col-sm-offset-2">
					<button type="submit"  name="save" value="Save" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</form>
			
			<script>
			function show_block(show_div, hide_div){
				$(show_div).show();
				$(hide_div).hide();	
	
			}
			
			</script>
			
    <?php
	}else{
		exit();
	}
}
	?>
