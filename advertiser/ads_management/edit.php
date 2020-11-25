<?php
$breadcrumb = 'Ad Management';
$title = '<i class="fa fa-table"></i> Edit Ad Information';
if(isset($_COOKIE['advertiser_uid']) && isset($_COOKIE['advertiser_website']) && $_COOKIE['admin_website']=="Linkibag advertiser")
{
	$adid = $_COOKIE['advertiser_uid'];
}
elseif(isset($_SESSION['advertiser_uid']) && isset($_SESSION['advertiser_website']) && $_SESSION['advertiser_website']=="Linkibag advertiser")
{			
	$adid = $_SESSION['advertiser_uid'];
}else{
	echo '<script type="text/javascript">window.location.href="logout.php"</script>';
	exit();
}

if(isset($_POST['save'])){		$success = true;
	/*if(!isset($_FILES['photo_path']['tmp_name']) or $_FILES['photo_path']['tmp_name'] == ""){					$co->setmessage("error", "Please upload image");		$success=false;	}*/	
	if(!isset($_POST['status'])){
		$co->setmessage("error", "Please choose status");		
		$success=false;	
	}	
	if($_POST['img_url'] == ''){	
		$co->setmessage("error", "Please enter website link");		
		$success=false;	
	}else{
		/*	
		if(filter_var($_POST['img_url'], FILTER_VALIDATE_URL) === false){
			$co->setmessage("error", "Please enter valid URL");			
			$success=false;		
		}*/
		$pattern_1 = "/(?:http|https)?(?:\:\/\/)?(?:www.)?(([A-Za-z0-9-]+\.)*[A-Za-z0-9-]+\.[A-Za-z]+)(?:\/.*)?/im";
		if(!preg_match($pattern_1, $_POST['img_url'])){			
			$co->setmessage("error", "Please enter valid url");
			$success=false;
		}	
	}
	if ($success == true) {
		$up = array();
		
		if(isset($_FILES['photo_path'])){
    		$img= $co->uploadimage($_FILES['photo_path'], 'commercial_ads', 'no', 1921, 287);
    		if($img != false){
    			$up['photo_path'] = $img;
    		}
    	}
	
	
		$up['title'] = $_POST['title'];
		$up['expiration_date'] = date('Y-m-d', strtotime($_POST['expiration_date']));
		$up['status'] = 0;			
		$up['img_url'] = $_POST['img_url'];		
		$up['created'] = time();		
		$up['updated'] = time();	
		$co->query_update('admin_ads', $up, array('id'=>$_POST['id']), 'aid=:id');
		unset($up);
		$co->setmessage("status", "Ads updated successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=ads_management/manage"</script>';
		exit();
	}
}


if(isset($_GET['id'])){
	$row = $co->query_first("SELECT * from admin_ads WHERE aid=:id and adid=:adid",array('id'=>$_GET['id'], 'adid'=>$adid));
	if($row['aid'] > 0){
?>
<form method="post" enctype="multipart/form-data" class="form-horizontal">
		<input type="hidden" name="id" value="<?=$row['aid']?>" />
		<div class="form-group row">		
			<label class="col-sm-2 control-label">Title *</label>			
			<div class="col-sm-8">						
				<input type="text" class="form-control" name="title" maxlength="50" value="<?=$row['title']?>">	
			</div>	
		</div>	
		<div class="form-group row">	
			<label class="col-sm-2 control-label">Upload Photo *</label>	
			<div class="col-sm-8">				
				<input type="file" name="photo_path"  /><br/> 
				<img src="../<?=$row['photo_path']?>" style="width:100px; height: 60px;"/>					
			</div>					
		</div>				
		<div class="form-group row">	
			<label class="col-sm-2 control-label">Expired date *</label>	
			<div class="col-sm-8">				
				<input type="text" class="form-control default_date_picker" name="expiration_date" maxlength="50" autocomplete="off" value="<?=($row['expiration_date']!='' ? date('d/m/Y', strtotime($row['expiration_date'])) : '')?>">			
			</div>				
		</div>				
		<div class="form-group row">		
			<label class="col-sm-2 control-label">Website URL *</label>			
				<div class="col-sm-8">						
					<input type="text" class="form-control" name="img_url" maxlength="50" value="<?=$row['img_url']?>">	
				</div>	
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