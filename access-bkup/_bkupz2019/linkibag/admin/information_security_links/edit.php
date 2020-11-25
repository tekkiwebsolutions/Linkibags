<?php
$breadcrumb = 'Admin Information Security Links Management';
$title = '<i class="fa fa-table"></i> Edit Link Information';
if(isset($_POST['save'])){	
	$_POST['info_security_notes'] = trim($_POST['info_security_notes']);
	$_POST['info_security_notes'] = strip_tags($_POST['info_security_notes']);
	
	$_POST['info_security_txt'] = trim($_POST['info_security_txt']);
	$_POST['info_security_txt'] = strip_tags($_POST['info_security_txt']);

	$_POST['info_security_company_name'] = trim($_POST['info_security_company_name']);
	$_POST['info_security_company_name'] = strip_tags($_POST['info_security_company_name']);

	$success=true;

	if($_POST['info_security_txt']==""){
		$co->setmessage("error", "Please enter text");
		$success=false;
	}
	
	if($_POST['info_security_company_name']==""){
		$co->setmessage("error", "Please enter company name");
		$success=false;
	}
	
	if($_POST['info_security_url_value']==""){
		$co->setmessage("error", "Please enter url value");
		$success=false;
	}else{			
		$url = 	$_POST['info_security_url_value'];
		/*if (filter_var($url, FILTER_VALIDATE_URL) === false) {
			$co->setmessage("error", "Please enter valid url");
			$success=false;
		}*/
		$pattern_1 = "/(?:http|https)?(?:\:\/\/)?(?:www.)?(([A-Za-z0-9-]+\.)*[A-Za-z0-9-]+\.[A-Za-z]+)(?:\/.*)?/im";
		if(!preg_match($pattern_1, $url)){			
			$co->setmessage("error", "Please enter valid url");
			$success=false;
		}
	}

	if($_POST['info_security_notes']==""){
		$co->setmessage("error", "Please enter note");
		$success=false;
	}
	
	
	if($_POST['info_security_start_date']==""){
		$co->setmessage("error", "Please enter start date");
		$success=false;
	}
	if($_POST['info_security_end_date']==""){
		$co->setmessage("error", "Please enter end date");
		$success=false;
	}
	

	if(!isset($_POST['info_security_type'])){			
		$co->setmessage("error", "Please choose types of link");			
		$success=false;		
	}
	if(!isset($_POST['status'])){			
		$co->setmessage("error", "Please choose status");			
		$success=false;		
	}
 
		if ($success == true) {
			$up = array();
			$up['info_security_txt'] = $_POST['info_security_txt'];
			$up['info_security_company_name'] = $_POST['info_security_company_name'];
			$up['info_security_url_value'] = $_POST['info_security_url_value'];
			$up['info_security_notes'] = $_POST['info_security_notes'];
			$up['info_security_type'] = $_POST['info_security_type'];
			$up['status'] = $_POST['status'];
			
			if(isset($_FILES['info_security_photo']['tmp_name']) and $_FILES['info_security_photo']['tmp_name']!=""){			

				$folder = './files/info_security_links/';

				$dest_path = $co->chk_filename('../'.$folder, $_FILES['info_security_photo']['name']);

				$co->uploadimage($_FILES['info_security_photo'], $dest_path, 'no', 1921, 287);

				$up['info_security_photo'] = substr($dest_path, 5);	
				
			}
			
			$up['created_time'] = time();	
			$up['updated_time'] = time();	
			$up['info_security_start_date'] = date('Y-m-d', strtotime($_POST['info_security_start_date']));	
			$up['info_security_end_date'] = date('Y-m-d', strtotime($_POST['info_security_end_date']));
			
			$co->query_update('info_security_links', $up, array('id'=>$_POST['id']), 'info_security_link_id=:id');
			unset($up);
			$co->setmessage("status", "Link updated successfully");
			
			echo '<script type="text/javascript">window.location.href="main.php?p=information_security_links/manage"</script>';
			exit();
		}
}


if(isset($_GET['id'])){
	$row = $co->query_first("SELECT * from info_security_links WHERE info_security_link_id=:id",array('id'=>$_GET['id']));
	if($row['info_security_link_id']){
?>
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				<input type="hidden" name="id" value="<?=$row['info_security_link_id']?>" />
				<div class="form-group row">
					<label class="col-sm-2 control-label">Text *</label>
					<div class="col-sm-8">
						<input type="text" name="info_security_txt" class="form-control" value="<?=(isset($row['info_security_txt']) ? $row['info_security_txt'] : '')?>" /> 
					</div>	
				</div>
				<div class="form-group row">
					<label class="col-sm-2 control-label">Company Name *</label>
					<div class="col-sm-8">
						<input type="text" name="info_security_company_name" class="form-control" value="<?=(isset($row['info_security_company_name']) ? $row['info_security_company_name'] : '')?>" /> 
					</div>	
				</div>
				<div class="form-group row">
					<label class="col-sm-2 control-label">Url Value *</label>
					<div class="col-sm-8">
						<input type="text" name="info_security_url_value" class="form-control" value="<?=(isset($row['info_security_url_value']) ? $row['info_security_url_value'] : '')?>" /> 
					</div>				
				</div>
				<div class="form-group row">
					<label class="col-sm-2 control-label">Notes *</label>
					<div class="col-sm-8">
						<textarea name="info_security_notes" maxlength="300" class="form-control"><?=(isset($row['info_security_notes']) ? $row['info_security_notes'] : '')?></textarea> 
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 control-label">Start Date *</label>
					<div class="col-sm-8">
						<input type="text" name="info_security_start_date" id="dt1" class="form-control date_picker" value="<?=(isset($row['info_security_start_date']) ? date('m/d/Y', strtotime($row['info_security_start_date'])) : '')?>" /> 
					</div>	
				</div>
				<div class="form-group row">
					<label class="col-sm-2 control-label">End Date *</label>
					<div class="col-sm-8">
						<input type="text" name="info_security_end_date" id="dt2" class="form-control date_picker" value="<?=(isset($row['info_security_end_date']) ? date('m/d/Y', strtotime($row['info_security_end_date'])) : '')?>" /> 
					</div>	
				</div>
				
				<div class="form-group row">
					<label class="col-sm-2 control-label">Type *</label>
					<div class="col-sm-8">
						<input type="radio" name="info_security_type" value="0"<?php echo (((isset($row['info_security_type']) and $row['info_security_type']==0)) ? ' checked="checked"' : ''); ?>/> Free 
						<input type="radio" name="info_security_type" value="1"<?php echo (((isset($row['info_security_type']) and $row['info_security_type']==1)) ? ' checked="checked"' : ''); ?> /> Paid
					</div>				
				</div>
				<div class="form-group row">
					<label class="col-sm-2 control-label">Upload Photo </label>
					<div class="col-sm-8">
						<img id="show_upload_photo" src="../<?=$row['info_security_photo']?>" style="width:100px; height: 60px;"/>
						<input type="file" name="info_security_photo" id="upload_photo" /> 
					</div>	
				</div>
				<div class="form-group">					
					<label class="col-sm-2 control-label">Status *</label>					
					<div class="col-sm-8">						
						<input type="radio" name="status" value="0"<?php echo (((isset($row['status']) and $row['status']==0)) ? ' checked="checked"' : ''); ?> /> Non Active 						
						<input type="radio" name="status" value="1"<?php echo ((isset($row['status']) and $row['status']==1) ? ' checked="checked"' : ''); ?> /> Active					
					</div>	
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
