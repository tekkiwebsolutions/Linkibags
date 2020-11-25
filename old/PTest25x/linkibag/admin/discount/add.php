<?php

if(isset($_POST['save']) && $_POST['save']=="Save"){	

	$_POST['coupon_code'] = strip_tags($_POST['coupon_code']);
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
	//check if no error
	if($success==true){			
		$new_val = array();
		$new_val['coupon_code'] = $_POST['coupon_code'];
		$new_val['coupon_discount'] = $_POST['coupon_discount'];
		$new_val['status'] = $_POST['status'];
		$new_val['created_date'] = date('Y-m-d');
		$new_val['created_time'] = time();
		$new_val['updated_time'] = time();
		$user_id = $co->query_insert('coupon_disount', $new_val);
		unset($new_val);
		$co->setmessage("status", "Coupon created successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=discount/manage"</script>';
		exit();
		
	}	
}

$msg = $co->theme_messages();

if(isset($msg)){ echo $msg; }

?>
	<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
						<?=WSNAME?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php?p=dashboard">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Coupon Code
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                
<div class="row">
	<div class="col-lg-12">


		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-table"></i> Add Coupon Code</h3>
		</div>
		<div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-sm-2 control-label">Coupon Code *</label>                            
				<div class="col-sm-10">
				<input type="text" class="form-control" name="coupon_code" maxlength="50" value="<?=(isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '')?>"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Discount (In percentage)*</label>                            
				<div class="col-sm-10">
				<input type="number" class="form-control" name="coupon_discount" maxlength="5" value="<?=(isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '')?>"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Active</label>
				<div class="col-sm-8">
					<input type="radio" name="status"  value="1" <?php if ((isset($_POST['status']) and $_POST['status'] == 1) OR !isset($_POST['status'])) { echo 'checked';} ?>> Yes
					<input type="radio" name="status"  value="0" <?php if (isset($_POST['status']) and $_POST['status'] == 0) { echo 'checked';} ?>> No
					
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4 col-sm-offset-2">
					 <button type="submit"  name="save" value="Save" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</form>  
                                
        </div>
       </div>
	</div>
   </div>
          <!-- /.row -->
</div>
            <!-- /.container-fluid -->

</div>