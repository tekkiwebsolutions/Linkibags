<?php
$breadcrumb = 'Public Category Management';
$title = '<i class="fa fa-table"></i> Add Public Category Information';
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
		$up['cdesc'] = $_POST['cdesc'];
		$up['status'] = $_POST['status'];
		//$up['trending_cat'] = $_POST['trending_cat'];
		if(isset($_FILES['photo']['tmp_name']) and $_FILES['photo']['tmp_name']!=""){			
			$folder = './files/share_url/';
			//$dest_path = $co->chk_filename('../'.$folder, $_FILES['photo']['name']);
			$r = $co->uploadimage($_FILES['photo'], 'public_cat', 'no', 1921, 287);
			$up['photo'] = $r;
			$up['photo_thumbnail'] = $r;	 
			
		}
		$up['updated_time'] = time();
		$up['created_time'] = time();
		
		$co->query_insert('user_public_category', $up);
		unset($up);
		$co->setmessage("status", "Category inserted successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=category_management/manage_public_category"</script>';
		exit();
	}
}
?>
			<form class="form-horizontal" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label class="col-sm-2 control-label">Category Name *</label>                            
					<div class="col-sm-10">
					<input type="text" class="form-control" name="cname" maxlength="50"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Category Desc</label>                            
					<div class="col-sm-10">
					<textarea class="form-control" name="cdesc"></textarea></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Status</label>
					<div class="col-sm-8">
						<input type="radio" name="status"  value="1" checked> Approved
						<input type="radio" name="status"  value="0"> Pending
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Upload Photo </label>
					<div class="col-sm-8">
						<input type="file" name="photo" id="upload_photo" /> 
					</div>	
				</div>
				
				<div class="form-group">
					<div class="col-sm-4 col-sm-offset-2">
						 <button type="submit"  name="save" value="Save" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</form>