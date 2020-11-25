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
	if(!isset($_POST['pick_week_link'])){			
		$co->setmessage("error", "Please choose link pick of the week");			
		$success=false;		
	}
	if(!isset($_POST['is_video_link'])){			
		$co->setmessage("error", "Please choose video link");			
		$success=false;		
	}
	if(isset($_POST['is_video_link']) and $_POST['is_video_link'] == 1){
		if(!isset($_POST['video_week'])){			
			$co->setmessage("error", "Please choose video of the week");			
			$success=false;		
		}
		if($_POST['video_id']==""){
			$co->setmessage("error", "Please enter video id");
			$success=false;
		}
		if($_POST['video_web']==""){
			$co->setmessage("error", "Please choose video web type");
			$success=false;
		}
		if($_POST['video_embed_code']==""){
			$co->setmessage("error", "Please enter video embed code");
			$success=false;
		}
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
				
				
				$new_val['is_video_link'] = $_POST['is_video_link'];
				$new_val['pick_week_link'] = $_POST['pick_week_link'];
				if(isset($_POST['is_video_link']) and $_POST['is_video_link'] == 1){	
					$new_val['video_week'] = $_POST['video_week'];
					$new_val['video_web'] = $_POST['video_web'];
					$new_val['video_id'] = $_POST['video_id'];
					$new_val['video_embed_code'] = $_POST['video_embed_code'];
					$new_val['video_updated'] = time();
				}else{
					$new_val['video_week'] = '';
					$new_val['video_web'] = '';
					$new_val['video_id'] = '';
					$new_val['video_embed_code'] = "";
					$new_val['video_updated'] = "";
				}
				
				$new_val['created_time'] = time();	
				$new_val['created_date'] = date('Y-m-d');	
				$user_id = $co->query_insert('user_urls', $new_val);
				unset($new_val);
			}	
		}	
		$co->setmessage("status", "Url created successfully");
		
		if(isset($_POST['is_video_link']) and $_POST['is_video_link'] == 1)
			echo '<script type="text/javascript">window.location.href="main.php?p=url_management/manage_video_links"</script>';
		else 	
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
				<label class="col-sm-2 control-label">Pick week Link *</label>					
				<div class="col-sm-8">						
					<input type="radio" name="pick_week_link" value="0"<?php echo (((isset($_POST['pick_week_link']) and $_POST['pick_week_link']==0) or !isset($_POST['pick_week_link'])) ? ' checked="checked"' : ''); ?> /> No 						
					<input type="radio" name="pick_week_link" value="1"<?php echo ((isset($_POST['pick_week_link']) and $_POST['pick_week_link']==1) ? ' checked="checked"' : ''); ?> /> Yes					
				</div>	
			</div>
			<div class="form-group">					
				<label class="col-sm-2 control-label">Video Link *</label>					
				<div class="col-sm-8">						
					<input type="radio" onclick="show_block('#','#video_links_yes');" name="is_video_link" value="0"<?php echo (((isset($_POST['is_video_link']) and $_POST['is_video_link']==0) OR !isset($_POST['is_video_link'])) ? ' checked="checked"' : ''); ?> /> No 						
					<input type="radio" onclick="show_block('#video_links_yes','#');" name="is_video_link" value="1"<?php echo ((isset($_POST['is_video_link']) and $_POST['is_video_link']==1) ? ' checked="checked"' : ''); ?> /> Yes					
				</div>	
			</div>
			<div id="video_links_yes"<?=((isset($_POST['is_video_link']) and $_POST['is_video_link']==1) ? '' : ' style="display:none;"') ?>>
				<div class="form-group">
					<label class="col-sm-2 control-label">Video Id *</label>
					<div class="col-sm-8">
						<input type="text" name="video_id" class="form-control" value="<?=(isset($_POST['video_id']) ? $_POST['video_id'] : '')?>" /> 
					</div>				
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Video webs *</label>
					<div class="col-sm-8">
						<select name="video_web" class="form-control">
							<option value="">Select Web</option>
						<?php
						$video_webs = $co->fetch_all_array("select * from video_webs", array());
						
						foreach($video_webs as $list){
							if(isset($_POST['video_web']) and $_POST['video_web'] == $list['web_id']){
								echo '<option value="'.$cat['web_id'].'" selected="selected">'.$list['web_name'].'</option>';
							}else{
								echo '<option value="'.$list['web_id'].'">'.$list['web_name'].'</option>';
							}
						?>
							
						<?php } ?>	
						</select>	
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Video Embed Code *</label>
					<div class="col-sm-8">
						<textarea name="video_embed_code" maxlength="300" class="form-control"><?=(isset($_POST['video_embed_code']) ? $_POST['video_embed_code'] : '')?></textarea> 
					</div>
				</div>
				<div class="form-group">					
					<label class="col-sm-2 control-label">Video Of the Week *</label>					
					<div class="col-sm-8">						
						<input type="radio" name="video_week" value="0"<?php echo (((isset($_POST['video_week']) and $_POST['video_week']==0) or !isset($_POST['video_week'])) ? ' checked="checked"' : ''); ?> /> No 						
						<input type="radio" name="video_week" value="1"<?php echo ((isset($_POST['video_week']) and $_POST['video_week']==1) ? ' checked="checked"' : ''); ?> /> Yes					
					</div>	
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