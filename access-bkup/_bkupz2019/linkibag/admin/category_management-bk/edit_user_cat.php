<?php
$breadcrumb = 'Category Management';
$title = '<i class="fa fa-table"></i> Edit Category Information';
if(isset($_POST['save'])){	
	$_POST['cname'] = trim($_POST['cname']);
	$_POST['cname'] = strip_tags($_POST['cname']);

	
	$success=true;

	if($_POST['cname']==""){
		$co->setmessage("error", "Please enter category");
		$success=false;
	}
	if(!isset($_POST['status'])){
		$co->setmessage("error", "Please select show public");
		$success=false;
	}
	 
	if ($success == true) {
		$up = array();
		$up['cname'] = $_POST['cname'];
		$up['status'] = $_POST['status'];
		$up['updated_time'] = time();
		
		$co->query_update('category', $up, array('id'=>$_POST['id']), 'cid=:id');
		unset($up);
		$co->setmessage("status", "Category updated successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=category_management/manage_user_category"</script>';
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
					<label class="col-sm-2 control-label">Category Name *</label>                            
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
