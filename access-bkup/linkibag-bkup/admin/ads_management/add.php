<?php

if(isset($_POST['save']) && $_POST['save']=="Save"){	

	$success=true;

	if(!isset($_FILES['photo_path']['tmp_name']) or $_FILES['photo_path']['tmp_name'] == ""){			
		$co->setmessage("error", "Please upload image");
		$success=false;
	}
	if($_POST['img_url'] == ''){			
		$co->setmessage("error", "Please enter website link");
		$success=false;
	}else{
		/*if(filter_var($_POST['img_url'], FILTER_VALIDATE_URL) === false){			
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
		$new_val = array();
		$new_val['uid'] = '0';
		
		if(isset($_FILES['photo_path']['tmp_name']) and $_FILES['photo_path']['tmp_name']!=""){			

			$folder = './files/commercial_ads/';

			$dest_path = $co->chk_filename('../'.$folder, $_FILES['photo_path']['name']);

			$co->uploadimage($_FILES['photo_path'], $dest_path, 'no', 1921, 287);

			$new_val['photo_path'] = substr($dest_path, 5);	
			
		}
		//$expire_datetime = time() + (15000 * 24 * 60 * 60);
		
		$new_val['expiration_date'] = date('Y-m-d', strtotime($_POST['expiration_date']));
		$new_val['img_url'] = $_POST['img_url'];	
		$new_val['status'] = $_POST['status'];	
		$new_val['created'] = time();	
		$new_val['updated'] = time();	
		$ads_id = $co->query_insert('admin_ads', $new_val);
		unset($new_val);
		$co->setmessage("status", "Ads created successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=ads_management/manage"</script>';
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
                                <i class="fa fa-table"></i> Ads
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                
<div class="row">
	<div class="col-lg-12">


		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-table"></i> Add Advertisement</h3>
		</div>
		<div class="panel-body">
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				<div class="form-group row">
					<label class="col-sm-2 control-label">Upload Photo *</label>
					<div class="col-sm-8">
						<input type="file" name="photo_path" required /> 
					</div>	
				</div>
				<div class="form-group row">
					<label class="col-sm-2 control-label">Expired date *</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="expiration_date" maxlength="50" value="">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 control-label">Website URL *</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="img_url" maxlength="50" value="">
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label">Status</label>
					<div class="col-sm-8">
						<input type="radio" name="status"  value="1" <?php if (isset($row['status']) and $row['status'] == 1) { echo 'checked';} ?>> Active
						<input type="radio" name="status"  value="0" <?php if (isset($row['status']) and $row['status'] == 0) { echo 'checked';} ?>> Non Active						
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