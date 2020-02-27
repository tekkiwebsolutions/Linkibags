<?php
$breadcrumb = 'Allow Country Management';
$title = '<i class="fa fa-table"></i> Update Allow Country Information';
if(isset($_POST['save'])){	
	$success=true;
	
	if ($success == true) {
		$up = array();
		$up['outside_service_text'] = $_POST['outside_service_text'];
		$up['allowed_counties'] = serialize($_POST['allowed_counties']);
		$co->query_update('linkibag_service_countries', $up, array('id'=>1), 'service_id=:id');
		unset($up);
		$co->setmessage("status", "Allow Country Information updated successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=service_countries_setting"</script>';
		exit();
	}
}


$row = $co->query_first("SELECT * from linkibag_service_countries WHERE service_id=:id",array('id'=>1));
if(isset($row['service_id'])){

$allowed_counties = array();
if(@unserialize($row['allowed_counties'])) {
	$allowed_counties = unserialize($row['allowed_counties']);
}
?>
			<form class="form-horizontal" method="post">
				<div class="form-group">
					<label class="col-sm-2 control-label">Country Selection</label>                            
					<div class="col-sm-10">
						<select class="form-control" name="allowed_counties[]" multiple="multiple">
						<?php
						$countries = $co->fetch_all_array("select id,country_name from countries ORDER BY id ASC", array());

						foreach($countries as $country){
							$sel = '';
							if(in_array($country['id'], $allowed_counties))
								$sel = ' selected="selected"';

							echo '<option value="'.$country['id'].'"'.$sel.'>'.$country['country_name'].'</option>';
						}	
						?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Outside Service Page Text</label>                            
					<div class="col-sm-10">
					<textarea class="form-control" name="outside_service_text"><?=(isset($row['outside_service_text']) ? $row['outside_service_text'] : '')?></textarea>
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
