<?php
$breadcrumb = 'Admin Url Management';
$title = '<i class="fa fa-table"></i> Edit Url Information';
if(isset($_POST['save'])){	
	$_POST['url_title'] = trim($_POST['url_title']);
		$_POST['url_title'] = strip_tags($_POST['url_title']);
		
		$_POST['url_value'] = trim($_POST['url_value']);
		$_POST['url_value'] = strip_tags($_POST['url_value']);

		$_POST['url_desc'] = trim($_POST['url_desc']);
		$_POST['url_desc'] = strip_tags($_POST['url_desc']);

		$success=true;

		if($_POST['url_title']==""){
			$co->setmessage("error", "Please enter title");
			$success=false;
		}

		if($_POST['url_value']==""){
			$co->setmessage("error", "Please enter value");
			$success=false;
		}else{			
			$url = 	$_POST['url_value'];
			/*if (filter_var($url, FILTER_VALIDATE_URL) === false) {
				$co->setmessage("error", "Please enter valid url");
				$success=false;
			}*/			$pattern_1 = "/(?:http|https)?(?:\:\/\/)?(?:www.)?(([A-Za-z0-9-]+\.)*[A-Za-z0-9-]+\.[A-Za-z]+)(?:\/.*)?/im";			if(!preg_match($pattern_1, $url)){							$co->setmessage("error", "Please enter valid url");				$success=false;			}
		}
	
		if($_POST['url_desc']==""){
			$co->setmessage("error", "Please enter description");
			$success=false;
		}
		
		if($_POST['url_cat'] == ''){
			$co->setmessage("error", "Please select category");
			$success=false;
		}
 
		if ($success == true) {
			$up = array();
			$up['url_title'] = $_POST['url_title'];
			$up['url_value'] = $_POST['url_value'];
			$up['url_desc'] = $_POST['url_desc'];
			$up['uid'] = 0;
			$up['editor_web_link'] = $_POST['editor_web_link'];
			$up['url_cat'] = $_POST['url_cat'];
			$up['updated_time'] = time();
			
			$co->query_update('user_urls', $up, array('id'=>$_POST['id']), 'url_id=:id');
			unset($up);
			$co->setmessage("status", "Url updated successfully");
			echo '<script type="text/javascript">window.location.href="main.php?p=admin_url_management/manage"</script>';
			exit();
		}
}


if(isset($_GET['id'])){
	$row = $co->query_first("SELECT url.*, c.* from category c, user_urls url WHERE url.url_cat=c.cid and url.url_id=:id",array('id'=>$_GET['id']));
	if($row['url_id']){
?>
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				<input type="hidden" name="id" value="<?=$row['url_id']?>" />
				<div class="form-group">
					<label class="col-sm-2 control-label">Url Title *</label>
					<div class="col-sm-8">
						<input type="text" name="url_title" class="form-control" value="<?php echo $row['url_title']; ?>" /> 
					</div>	
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Url Value *</label>
					<div class="col-sm-8">
						<input type="text" name="url_value" class="form-control" value="<?php echo $row['url_value']; ?>" /> 
					</div>				
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Description *</label>
					<div class="col-sm-8">
						<textarea name="url_desc" maxlength="300" class="form-control"><?php echo $row['url_desc']; ?></textarea> 
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Category *</label>
					<div class="col-sm-8">
						<select name="url_cat" class="form-control">
					<?php
					$categories = $co->show_all_category();
					
					foreach($categories as $cat){
						if(isset($row['url_cat']) and $row['url_cat'] == $cat['cid']){
							echo '<option value="'.$cat['cid'].'" selected="selected">'.$cat['cname'].'</option>';
						}else{
							echo '<option value="'.$cat['cid'].'">'.$cat['cname'].'</option>';
						}
					?>
						
					<?php } ?>	
						</select>	
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Web Editor Pick *</label>
					<div class="col-sm-8">
						<input type="radio" name="editor_web_link" value="0"<?php echo ($row['editor_web_link']==0 ? ' checked="checked"' : ''); ?> /> No 
						<input type="radio" name="editor_web_link" value="1"<?php echo ($row['editor_web_link']==1 ? ' checked="checked"' : ''); ?> /> Yes
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
