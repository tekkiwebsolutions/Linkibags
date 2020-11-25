<?php
$breadcrumb = 'Term Popup Management';
$title = '<i class="fa fa-table"></i> Update Term Popup Information';
if(isset($_POST['save'])){	
	$success=true;
	if($_POST['msg']==""){
		$co->setmessage("error", "Please enter message");
		$success=false;
	}
	if(!isset($_POST['popup_show'])){
		$co->setmessage("error", "Please select status");
		$success=false;
	}
	
	if ($success == true) {
		$up = array();
		$up['popup_msg'] = $_POST['msg'];
		$up['popup_show'] = $_POST['popup_show'];
		$up['popup_updated'] = time();
		
		$co->query_update('popup_setting', $up, array('id'=>1), 'popup_id=:id');
		unset($up);
		$co->setmessage("status", "Term popup updated successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=popup_setting"</script>';
		exit();
	}
}


$row = $co->query_first("SELECT * from popup_setting WHERE popup_id=:id",array('id'=>1));
if(isset($row['popup_id'])){
?>
			<form class="form-horizontal" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?=$row['popup_id']?>" />
				<div class="form-group">
					<label class="col-sm-2 control-label">Message</label>                            
					<div class="col-sm-10">
					<textarea class="form-control" name="msg"><?=(isset($row['popup_msg']) ? $row['popup_msg'] : '')?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Status</label>
					<div class="col-sm-8">
						<input type="radio" name="popup_show"  value="1" <?php if (isset($row['popup_show']) and $row['popup_show'] == 1) { echo 'checked';} ?>> Show
						<input type="radio" name="popup_show"  value="0" <?php if (isset($row['popup_show']) and $row['popup_show'] == 0) { echo 'checked';} ?>> Hide
						
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-4 col-sm-offset-2">
						 <button type="submit"  name="save" value="Save" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</form>
    <?php
}
	?>
