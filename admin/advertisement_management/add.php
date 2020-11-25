<?php

if(isset($_POST['save']) && $_POST['save']=="Save"){	

	$success=true;
	$password=$_POST['password'];
	
	if($_POST['name'] == ''){			
		$co->setmessage("error", "Please enter name");
		$success=false;
	}
	if($_POST['username'] == ''){			
		$co->setmessage("error", "Please enter username");
		$success=false;
	}



	
	
	if(isset($_POST['password']) and $_POST['password']!=''){
		$password =  strlen($_POST['password']);
		if ($password<8){
			$co->setmessage("error", "password is not a valid at least 8 of the characters");
			$success=false;
		}
		$containsLetter  = preg_match('/[a-zA-Z]/', $_POST['password']);
		$containsDigit   = preg_match('/\d/', $_POST['password']);
		//$containswhitespace = preg_match('/ /', $_POST['password']);

		if (!$containsLetter or !$containsDigit) {
			$co->setmessage("error", "password must contain at least one letter and one number and no spaces");
			$success=false;
		}	
	}


	if ($success == true) {
		$new_val = array();
		$new_val['uid'] = '0';
		
		$new_val['name'] = $_POST['name'];
		$new_val['username'] = $_POST['username'];
		$new_val['password'] = md5($_POST['password']);

    	//$expire_datetime = time() + (15000 * 24 * 60 * 60);

		$new_val['category']=serialize($_POST['assign_category']);
		$new_val['state'] =serialize($_POST['assign_state']);
		$new_val['zipcode'] =serialize($_POST['assign_zipcode']);
		
		$new_val['status'] = $_POST['status'];	
		$new_val['created'] = time();	
		$new_val['updated'] = time();	
		$ads_id = $co->query_insert('admin_advertisement', $new_val);
		unset($new_val);
		$co->setmessage("status", "Advertisement created successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=advertisement_management/manage"</script>';
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
						Advertisement Management
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                
                
<div class="row">
	<div class="col-lg-12">


		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-table"></i> Add</h3>
		</div>
		<div class="panel-body">
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
			    <div class="form-group row">
					<label class="col-sm-2 control-label">Name *</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="name" maxlength="350" value="">
					</div>
				</div>	
				
				<div class="form-group row">
					<label class="col-sm-2 control-label">Username *</label>
					<div class="col-sm-8">
						<input type="text" class="form-control " autocomplete="off" name="username" maxlength="50" value="">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 control-label">Password *</label>
					<div class="col-sm-8">
						<input type="password" class="form-control"  name="password" maxlength="50" value="">
					</div>
				</div>	

				<div class="form-group">
					<label class="col-sm-2 control-label">Category *</label>
					<div class="col-sm-8">
						<select name="assign_category[]" multiple="multiple" class="form-control">
					<?php
					$categories = $co->show_all_category();
					
					foreach($categories as $cat){
						if(isset($row['url_cat']) and $row['url_cat'] == $cat['cid']){
							echo '<option value="'.$cat['cid'].'" selected="selected">'.$cat['cname'].'</option>';
						}else{
							echo '<option value="'.$cat['cid'].'">'.$cat['cname'].'</option>';
						}
					?>
						
					<?php } ?>	
						</select>	
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-sm-2 control-label">State *</label>
					<div class="col-sm-8">
						<select name="assign_state[]" multiple="multiple" class="form-control">
					<?php
					$states = $co->fetch_all_array("select id,state_name from states ORDER BY id ASC", array());	
		
					
					foreach($states as $st){
						if(isset($row['state']) and $row['state'] == $st['id']){
							echo '<option value="'.$st['id'].'" selected="selected">'.$st['state_name'].'</option>';
						}else{
							echo '<option value="'.$st['id'].'">'.$st['state_name'].'</option>';
						}
					?>
						
					<?php } ?>	
						</select>	
					</div>
				</div>	

				<div class="form-group row">
					<label class="col-sm-2 control-label">Zip *</label>
					<div class="col-sm-8">
						<select name="assign_zipcode[]" multiple="multiple" class="form-control">
						<?php
					$zip = $co->fetch_all_array("select distinct zip_code from profile ORDER BY zip_code ASC", array());	
		
					
					foreach($zip as $zt){
						
							echo '<option value="'.$zt['zip_code'].'">'.$zt['zip_code'].'</option>';
						}
					?>	
						</select>	
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label">Status</label>
					<div class="col-sm-8">
						<input type="radio" name="status"  value="1" checked> Active
						<input type="radio" name="status"  value="0"> Non Active						
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