<?php
$breadcrumb = 'Discount Management';
$title = '<i class="fa fa-table"></i> Edit Coupon Discount Information';
if(isset($_POST['save'])){	
	$$_POST['coupon_code'] = strip_tags($_POST['coupon_code']);
	$success=true;
	if($_POST['coupon_code']==""){
		$co->setmessage("error", "Please enter coupon code");
		$success=false;
	}
	if($_POST['coupon_discount']==""){
		$co->setmessage("error", "Please enter discount");
		$success=false;
	}
	if(!isset($_POST['status'])){

		$co->setmessage("error", "Please choose status");

		$success=false;

	}
	 
	if ($success == true) {
		$up = array();
		$up['coupon_code'] = $_POST['coupon_code'];
		$up['coupon_discount'] = $_POST['coupon_discount'];
		$up['status'] = $_POST['status'];
		$up['created_date'] = date('Y-m-d');
		$up['created_time'] = time();
		$up['updated_time'] = time();
		
		$co->query_update('coupon_disount', $up, array('id'=>$_POST['id']), 'discount_id=:id');
		unset($up);
		$co->setmessage("status", "Coupon updated successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=discount/manage"</script>';
		exit();
	}
}


if(isset($_GET['id'])){
	$row = $co->query_first("SELECT * from coupon_disount WHERE discount_id=:id",array('id'=>$_GET['id']));
	if($row['discount_id']){
?>
			<form class="form-horizontal" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?=$row['discount_id']?>" />
				<div class="form-group">
					<label class="col-sm-2 control-label">Coupon Code *</label>                            
					<div class="col-sm-10">
					<input type="text" class="form-control" name="coupon_code" maxlength="50" value="<?=(isset($row['coupon_code']) ? $row['coupon_code'] : '')?>"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Discount (In percentage)*</label>                            
					<div class="col-sm-10">
					<input type="number" class="form-control" name="coupon_discount" maxlength="5" value="<?=(isset($row['coupon_discount']) ? $row['coupon_discount'] : '')?>"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Active *</label>
					<div class="col-sm-8">
						<input type="radio" name="status" value="1" <?php if (isset($row['status']) and $row['status'] == 1) { echo 'checked';} ?> /> Yes 
						<input type="radio" name="status" value="0" <?php if (isset($row['status']) and $row['status'] == 0) { echo 'checked';} ?> /> No
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
