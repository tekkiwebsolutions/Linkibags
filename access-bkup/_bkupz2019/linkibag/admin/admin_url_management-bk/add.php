<?php

if(isset($_POST['save']) && $_POST['save']=="Save"){	

	$_POST['url_title'] = trim($_POST['url_title']);
	$_POST['url_title'] = strip_tags($_POST['url_title']);
	
	$_POST['url_value'] = trim($_POST['url_value']);
	$_POST['url_value'] = strip_tags($_POST['url_value']);

	$_POST['url_desc'] = trim($_POST['url_desc']);
	$_POST['url_desc'] = strip_tags($_POST['url_desc']);

	$success=true;

	if($_POST['url_title']==""){
		$co->setmessage("error", "Please enter title");
		$success=false;
	}

	if($_POST['url_value']==""){
		$co->setmessage("error", "Please enter value");
		$success=false;
	}else{			
		$url = 	$_POST['url_value'];
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

	if($_POST['url_desc']==""){
		$co->setmessage("error", "Please enter description");
		$success=false;
	}
	
	if(!(isset($_POST['url_cat']) and count($_POST['url_cat']) > 0)){
		$co->setmessage("error", "Please select category");
		$success=false;
	}

	if ($success == true) {
		if(isset($_POST['url_cat']) and count($_POST['url_cat']) > 0){
			foreach($_POST['url_cat'] as $cat){
				$new_val = array();
				$new_val['url_title'] = $_POST['url_title'];
				$new_val['url_value'] = $_POST['url_value'];
				$new_val['url_desc'] = $_POST['url_desc'];
				$new_val['uid'] = 0;
				$new_val['url_cat'] = $cat;
				$new_val['editor_web_link'] = $_POST['editor_web_link'];
				$new_val['created_time'] = time();	
				$new_val['created_date'] = date('Y-m-d');	
				$user_id = $co->query_insert('user_urls', $new_val);
				unset($new_val);
			}	
		}	
		$co->setmessage("status", "Url created successfully");
		echo '<script type="text/javascript">window.location.href="main.php?p=admin_url_management/manage"</script>';
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
        <form method="post" enctype="multipart/form-data" class="form-horizontal">
			<div class="form-group row">
				<label class="col-sm-2 control-label">Url Title *</label>
				<div class="col-sm-8">
					<input type="text" name="url_title" class="form-control" value="<?=(isset($_POST['url_title']) ? $_POST['url_title'] : '')?>" /> 
				</div>	
			</div>
			<div class="form-group row">
				<label class="col-sm-2 control-label">Url Value *</label>
				<div class="col-sm-8">
					<input type="text" name="url_value" class="form-control" value="<?=(isset($_POST['url_value']) ? $_POST['url_value'] : '')?>" /> 
				</div>				
			</div>
			<div class="form-group row">
				<label class="col-sm-2 control-label">Description *</label>
				<div class="col-sm-8">
					<textarea name="url_desc" maxlength="300" class="form-control"><?=(isset($_POST['url_desc']) ? $_POST['url_desc'] : '')?></textarea> 
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-2 control-label">Category *</label>
				<div class="col-sm-8">
					<select name="url_cat[]" class="form-control" id="add_urls" multiple>
					<option value="">Select here</option>
				<?php
				$categories = $co->show_all_category();
				
				foreach($categories as $cat){
						echo '<option value="'.$cat['cid'].'">'.$cat['cname'].'</option>';
				}
				?>
					
					</select>	
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 control-label">Web Editor Pick *</label>
				<div class="col-sm-8">
					<input type="radio" name="editor_web_link" value="0" checked="checked" /> No 
					<input type="radio" name="editor_web_link" value="1" /> Yes
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