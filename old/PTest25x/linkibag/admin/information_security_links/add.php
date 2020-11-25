<?php

if(isset($_POST['save']) && $_POST['save']=="Save"){	

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
		
		$new_val = array();
		$new_val['info_security_txt'] = $_POST['info_security_txt'];
		$new_val['info_security_company_name'] = $_POST['info_security_company_name'];
		$new_val['info_security_url_value'] = $_POST['info_security_url_value'];
		$new_val['uid'] = 0;
		$new_val['info_security_notes'] = $_POST['info_security_notes'];
		$new_val['info_security_type'] = $_POST['info_security_type'];
		$new_val['status'] = $_POST['status'];
		
		if(isset($_FILES['info_security_photo']['tmp_name']) and $_FILES['info_security_photo']['tmp_name']!=""){			

			$folder = './files/info_security_links/';

			$dest_path = $co->chk_filename('../'.$folder, $_FILES['info_security_photo']['name']);

			$co->uploadimage($_FILES['info_security_photo'], $dest_path, 'no', 1921, 287);

			$new_val['info_security_photo'] = substr($dest_path, 5);	
			
		}
		
		$new_val['created_time'] = time();	
		$new_val['updated_time'] = time();	
		$new_val['info_security_start_date'] = date('Y-m-d', strtotime($_POST['info_security_start_date']));	
		$new_val['info_security_end_date'] = date('Y-m-d', strtotime($_POST['info_security_end_date']));	
		$link_id = $co->query_insert('info_security_links', $new_val);
		unset($new_val);
	
		$co->setmessage("status", "Link created successfully");
			
		echo '<script type="text/javascript">window.location.href="main.php?p=information_security_links/manage"</script>';
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
                                <i class="fa fa-table"></i> Links
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                
<div class="row">
	<div class="col-lg-12">


		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-table"></i> Add Information Security Links</h3>
		</div>
		<div class="panel-body">
        <form method="post" enctype="multipart/form-data" class="form-horizontal">
			<div class="form-group row">
				<label class="col-sm-2 control-label">Text *</label>
				<div class="col-sm-8">
					<input type="text" name="info_security_txt" class="form-control" value="<?=(isset($_POST['info_security_txt']) ? $_POST['info_security_txt'] : '')?>" /> 
				</div>	
			</div>
			<div class="form-group row">
				<label class="col-sm-2 control-label">Company Name *</label>
				<div class="col-sm-8">
					<input type="text" name="info_security_company_name" class="form-control" value="<?=(isset($_POST['info_security_company_name']) ? $_POST['info_security_company_name'] : '')?>" /> 
				</div>	
			</div>
			<div class="form-group row">
				<label class="col-sm-2 control-label">Url Value *</label>
				<div class="col-sm-8">
					<input type="text" name="info_security_url_value" class="form-control" value="<?=(isset($_POST['info_security_url_value']) ? $_POST['info_security_url_value'] : '')?>" /> 
				</div>				
			</div>
			<div class="form-group row">
				<label class="col-sm-2 control-label">Notes *</label>
				<div class="col-sm-8">
					<textarea name="info_security_notes" maxlength="300" class="form-control"><?=(isset($_POST['info_security_notes']) ? $_POST['info_security_notes'] : '')?></textarea> 
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 control-label">Start Date *</label>
				<div class="col-sm-8">
					<input type="text" name="info_security_start_date" id="dt1" class="form-control date_picker" value="<?=(isset($_POST['info_security_start_date']) ? $_POST['info_security_start_date'] : '')?>" /> 
				</div>	
			</div>
			<div class="form-group row">
				<label class="col-sm-2 control-label">End Date *</label>
				<div class="col-sm-8">
					<input type="text" name="info_security_end_date" id="dt2" class="form-control date_picker" value="<?=(isset($_POST['info_security_end_date']) ? $_POST['info_security_end_date'] : '')?>" /> 
				</div>	
			</div>
			
			<div class="form-group row">
				<label class="col-sm-2 control-label">Type *</label>
				<div class="col-sm-8">
					<input type="radio" name="info_security_type" value="0" checked="checked" /> Free 
					<input type="radio" name="info_security_type" value="1" /> Paid
				</div>				
			</div>
			<div class="form-group row">
				<label class="col-sm-2 control-label">Upload Photo *</label>
				<div class="col-sm-8">
					<img id="show_upload_photo" src="" style="width:100px; height: 60px; display: none;"/>
					<input type="file" name="info_security_photo" id="upload_photo" required /> 
				</div>	
			</div>
			<div class="form-group">					
				<label class="col-sm-2 control-label">Status *</label>					
				<div class="col-sm-8">						
					<input type="radio" name="status" value="0"<?php echo (((isset($_POST['status']) and $_POST['status']==0)) ? ' checked="checked"' : ''); ?> /> Non Active 						
					<input type="radio" name="status" value="1"<?php echo (((isset($_POST['status']) and $_POST['status']==1) or !isset($_POST['status'])) ? ' checked="checked"' : ''); ?> /> Active					
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

<script>
function show_block(show_div, hide_div){
	$(show_div).show();
	$(hide_div).hide();	

}
			
</script>