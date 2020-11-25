<?php

if(isset($_POST['save']) && $_POST['save']=="Save"){	

	$_POST['cname'] = strip_tags($_POST['cname']);
	$success=true;
	if($_POST['cname']==""){
		$co->setmessage("error", "Please enter category");
		$success=false;
	}
	if(!isset($_POST['trending_cat'])){

		$co->setmessage("error", "Please choose trending category");

		$success=false;

	}
	//check if no error
	if($success==true){			
		$new_val = array();
		$new_val['cname'] = $_POST['cname'];
		$new_val['status'] = $_POST['status'];
		$new_val['in_list'] = 1;
		$new_val['uid'] = 0;
		$new_val['trending_cat'] = $_POST['trending_cat'];
		$new_val['created_time'] = time();
		$user_id = $co->query_insert('category', $new_val);
		unset($new_val);
		$co->setmessage("status", "Ulr category  created successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=category_management/manage"</script>';
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
                                <i class="fa fa-table"></i> Url
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                
<div class="row">
	<div class="col-lg-12">


		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-table"></i> Add Url</h3>
		</div>
		<div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-sm-2 control-label">Category Name *</label>                            
				<div class="col-sm-10">
				<input type="text" class="form-control" name="cname" maxlength="50" value="<?=(isset($_POST['cname']) ? $_POST['cname'] : '')?>"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Show Public</label>
				<div class="col-sm-8">
					<input type="radio" name="status"  value="1" <?php if (isset($_POST['status']) and $_POST['status'] == 1) { echo 'checked';} ?>> Yes
					<input type="radio" name="status"  value="0" <?php if (isset($_POST['status']) and $_POST['status'] == 0) { echo 'checked';} ?>> No
					
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Trending Category *</label>
				<div class="col-sm-8">
					<input type="radio" name="trending_cat" value="1" /> Yes 
					<input type="radio" name="trending_cat" value="0" checked="checked" /> No
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