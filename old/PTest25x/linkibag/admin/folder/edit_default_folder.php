<?php
$breadcrumb = 'Folder Management';
$title = '<i class="fa fa-table"></i> Edit Default Folder Information';
if(isset($_POST['save'])){	
	$_POST['cname'] = trim($_POST['cname']);
	$_POST['cname'] = strip_tags($_POST['cname']);

	
	$success=true;

	if($_POST['cname']==""){
		$co->setmessage("error", "Please enter folder");
		$success=false;
	}
	if(!isset($_POST['status'])){
		$co->setmessage("error", "Please select show public");
		$success=false;
	}
	if(!isset($_POST['trending_cat'])){

		$co->setmessage("error", "Please choose trending folder");

		$success=false;

	}
	 
	if ($success == true) {
		$up = array();
		$up['cname'] = $_POST['cname'];
		$up['status'] = $_POST['status'];
		$up['trending_cat'] = $_POST['trending_cat'];
		$up['updated_time'] = time();

		if(isset($_FILES['image']['name']) and $_FILES['image']['name'] !=''){
			$imgs_arr = $co->uploadimage($_FILES['image'],'default_folder' , 'yes', 800, 600);
			$up['image_thumbnails'] = $imgs_arr['img_thumbnails'];			
			$imgs_arr = unserialize($imgs_arr['img_thumbnails']);					
			$up['image'] = $imgs_arr['thumbnail'];

		}
		
		$co->query_update('category', $up, array('id'=>$_POST['id']), 'cid=:id');
		unset($up);
		$co->setmessage("status", "Folder updated successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=folder/manage_default_folder"</script>';
		exit();
	}
}


if(isset($_GET['id'])){
	$row = $co->query_first("SELECT * from category WHERE cid=:id",array('id'=>$_GET['id']));
	if($row['cid']){
?>
			<form class="form-horizontal" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?=$row['cid']?>" />
				<div class="form-group">
					<label class="col-sm-2 control-label">Folder Name *</label>                            
					<div class="col-sm-10">
					<input type="text" class="form-control" name="cname" maxlength="50" value="<?=(isset($row['cname']) ? $row['cname'] : '')?>"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Show Public</label>
					<div class="col-sm-8">
						<input type="radio" name="status"  value="1" <?php if (isset($row['status']) and $row['status'] == 1) { echo 'checked';} ?>> Yes
						<input type="radio" name="status"  value="0" <?php if (isset($row['status']) and $row['status'] == 0) { echo 'checked';} ?>> No
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Trending Folder *</label>
					<div class="col-sm-8">
						<input type="radio" name="trending_cat" value="1" <?php if (isset($row['trending_cat']) and $row['trending_cat'] == 1) { echo 'checked';} ?> /> Yes 
						<input type="radio" name="trending_cat" value="0" <?php if (isset($row['trending_cat']) and $row['trending_cat'] == 0) { echo 'checked';} ?> /> No
					</div>				
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Upload Photo</label>					
					<div class="col-sm-10">
						<?php 
						if(isset($row['image']) and $row['image']!=""){
							echo '<img src="../'.$row['image'].'" alt="" title="" style="width: 100px;" />';
						}
						?>
						<input type="file" name="image"/>
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
