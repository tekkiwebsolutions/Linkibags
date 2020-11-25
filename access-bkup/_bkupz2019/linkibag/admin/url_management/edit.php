<?php
//echo $co->youtube_id_from_url('http://youtu.be/NLqAF9hrVbY');
/*$dailymotionurl = 'http://www.dailymotion.com/video/x4yyy3z';
		preg_match('#<object[^>]+>.+?http://www.dailymotion.com/swf/video/([A-Za-z0-9]+).+?</object>#s', $dailymotionurl, $matches);
		
        // Dailymotion url
        if(!isset($matches[1])) {
            preg_match('#http://www.dailymotion.com/video/([A-Za-z0-9]+)#s', $dailymotionurl, $matches);
        }

        // Dailymotion iframe
        if(!isset($matches[1])) {
            preg_match('#http://www.dailymotion.com/embed/video/([A-Za-z0-9]+)#s', $dailymotionurl, $matches);
        }
 //echo ($id =  $matches[1]);

 echo ($dailymotion_id = $co->video_id_from_url('http://www.dailymotion.com/video/x4yyy3z', 'dailymotion'));
 */
$breadcrumb = 'Url Management';
$title = '<i class="fa fa-table"></i> Edit Url Information';
if(isset($_POST['save'])){	
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
			if (filter_var($url, FILTER_VALIDATE_URL) === false) {
				$co->setmessage("error", "Please enter valid url");
				$success=false;
			}
		}
	
		if($_POST['url_desc']==""){
			$co->setmessage("error", "Please enter description");
			$success=false;
		}
		
		if(!isset($_POST['url_cat'])){
			$co->setmessage("error", "Please select category");
			$success=false;
		}

		if(!isset($_POST['public_bag_link'])){			
			$co->setmessage("error", "Please choose public bag link");			
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
		/*	
		if(!isset($_POST['trending_link'])){	
			$co->setmessage("error", "Please choose trending link");			
			$success=false;		
		}		
		if(!isset($_POST['you_tube_link'])){		
			$co->setmessage("error", "Please choose Youtube link");			
			$success=false;		
		}*/
 
		if ($success == true) {
			$up = array();
			$up['url_title'] = $_POST['url_title'];
			$up['url_value'] = $_POST['url_value'];
			$up['url_desc'] = $_POST['url_desc'];
			$up['url_cat'] = $_POST['url_cat'];
			//$up['editor_web_link'] = $_POST['editor_web_link'];					
			$up['public_bag_link'] = $_POST['public_bag_link'];						
			//$up['trending_link'] = $_POST['trending_link'];		
			//$up['you_tube_link'] = $_POST['you_tube_link'];
			
			/*
			$video_link_id = '';
			$video_web = '';
			$is_video_link = 0;
			$video_embed_code = '';
			if($youtube_id = $co->video_id_from_url($url, 'youtube')){
				$video_link_id = $youtube_id;		
				$video_web = 'youtube';		
				$is_video_link = 1;
				$video_embed_code = 'https://www.youtube.com/embed/'.$youtube_id;				
			}else if($dailymotion_id = $co->video_id_from_url($url, 'dailymotion')){
				$video_link_id = $dailymotion_id;		
				$video_web = 'dailymotion';		
				$is_video_link = 1;		
				$video_embed_code = 'https://www.dailymotion.com/embed/'.$video_link_id;				
			}
			
			$up['is_video_link'] = $is_video_link;
			$up['video_id'] = $video_link_id;
			$up['video_web'] = $video_web;
			$up['video_embed_code'] = $video_embed_code;
			*/	
			
			
			$up['updated_time'] = time();
			$up['is_video_link'] = $_POST['is_video_link'];
			$up['pick_week_link'] = $_POST['pick_week_link'];
			
			if(isset($_POST['is_video_link']) and $_POST['is_video_link'] == 1){	
				$up['video_week'] = $_POST['video_week'];
				$up['video_web'] = $_POST['video_web'];
				$up['video_id'] = $_POST['video_id'];
				$up['video_embed_code'] = $_POST['video_embed_code'];
				$up['video_updated'] = time();
			}else{
				$up['video_week'] = '';
				$up['video_web'] = '';
				$up['video_id'] = '';
				$up['video_embed_code'] = "";
				$up['video_updated'] = "";
			}	
			
			$co->query_update('user_urls', $up, array('id'=>$_POST['id']), 'url_id=:id');
			unset($up);
			$co->setmessage("status", "Url updated successfully");
			if(isset($_POST['is_video_link']) and $_POST['is_video_link'] == 1)
				echo '<script type="text/javascript">window.location.href="main.php?p=url_management/manage_video_links"</script>';
			else
				echo '<script type="text/javascript">window.location.href="main.php?p=url_management/manage"</script>';
			exit();
		}
}


if(isset($_GET['id'])){
	$row = $co->query_first("SELECT url.*, c.* from category c, user_urls url WHERE url.url_cat=c.cid and url.url_id=:id",array('id'=>$_GET['id']));
	if($row['url_id']){
?>
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				<input type="hidden" name="id" value="<?=$row['url_id']?>" />
				<div class="form-group">
					<label class="col-sm-2 control-label">Url Title *</label>
					<div class="col-sm-8">
						<input type="text" name="url_title" class="form-control" value="<?php echo $row['url_title']; ?>" /> 
					</div>	
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Url Value *</label>
					<div class="col-sm-8">
						<input type="text" name="url_value" class="form-control" value="<?php echo $row['url_value']; ?>" /> 
					</div>				
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Description *</label>
					<div class="col-sm-8">
						<textarea name="url_desc" maxlength="300" class="form-control"><?php echo $row['url_desc']; ?></textarea> 
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Category *</label>
					<div class="col-sm-8">
						<select name="url_cat" class="form-control">
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
				<?php
				/*
				<div class="form-group">
					<label class="col-sm-2 control-label">Web Editor Pick *</label>
					<div class="col-sm-8">
						<input type="radio" name="editor_web_link" value="0"<?php echo ($row['editor_web_link']==0 ? ' checked="checked"' : ''); ?> /> No 
						<input type="radio" name="editor_web_link" value="1"<?php echo ($row['editor_web_link']==1 ? ' checked="checked"' : ''); ?> /> Yes
					</div>				
				</div>
				*/
				?>	
				<div class="form-group">					
					<label class="col-sm-2 control-label">Public Bag Links *</label>					
					<div class="col-sm-8">						
						<input type="radio" name="public_bag_link" value="0"<?php echo ($row['public_bag_link']==0 ? ' checked="checked"' : ''); ?> /> No 						
						<input type="radio" name="public_bag_link" value="1"<?php echo ($row['public_bag_link']==1 ? ' checked="checked"' : ''); ?> /> Yes					
					</div>	
				</div>	
				
				<div class="form-group">					
					<label class="col-sm-2 control-label">Pick week Link *</label>					
					<div class="col-sm-8">						
						<input type="radio" name="pick_week_link" value="0"<?php echo (($row['pick_week_link']==0 or !isset($row['pick_week_link']))? ' checked="checked"' : ''); ?> /> No 						
						<input type="radio" name="pick_week_link" value="1"<?php echo ($row['pick_week_link']==1 ? ' checked="checked"' : ''); ?> /> Yes					
					</div>	
				</div>
				
				<?php
				/*
				<div class="form-group">
					<label class="col-sm-2 control-label">Trending Links *</label>					
					<div class="col-sm-8">						
						<input type="radio" name="trending_link" value="0"<?php echo ($row['trending_link']==0 ? ' checked="checked"' : ''); ?> /> No 						
						<input type="radio" name="trending_link" value="1"<?php echo ($row['trending_link']==1 ? ' checked="checked"' : ''); ?> /> Yes					
					</div>					
				</div>				
				<div class="form-group">					
					<label class="col-sm-2 control-label">You Tube Links *</label>					
					<div class="col-sm-8">						
						<input type="radio" name="you_tube_link" value="0"<?php echo ($row['you_tube_link']==0 ? ' checked="checked"' : ''); ?> /> No 						
						<input type="radio" name="you_tube_link" value="1"<?php echo ($row['you_tube_link']==1 ? ' checked="checked"' : ''); ?> /> Yes					
					</div>	
				</div>
				*/?>
				<div class="form-group">					
					<label class="col-sm-2 control-label">Video Link *</label>					
					<div class="col-sm-8">						
						<input type="radio" onclick="show_block('#','#video_links_yes');" name="is_video_link" value="0"<?php echo ($row['is_video_link']==0 ? ' checked="checked"' : ''); ?> /> No 						
						<input type="radio" onclick="show_block('#video_links_yes','#');" name="is_video_link" value="1"<?php echo ($row['is_video_link']==1 ? ' checked="checked"' : ''); ?> /> Yes					
					</div>	
				</div>
				<div id="video_links_yes"<?=((isset($row['is_video_link']) and $row['is_video_link']==1) ? '' : ' style="display:none;"') ?>>
					<div class="form-group">
						<label class="col-sm-2 control-label">Video Id *</label>
						<div class="col-sm-8">
							<input type="text" name="video_id" class="form-control" value="<?php echo $row['video_id']; ?>" /> 
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
								if(isset($row['video_web']) and $row['video_web'] == $list['web_id']){
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
							<textarea name="video_embed_code" maxlength="300" class="form-control"><?php echo $row['video_embed_code']; ?></textarea> 
						</div>
					</div>
					<div class="form-group">					
						<label class="col-sm-2 control-label">Video Of the Week *</label>					
						<div class="col-sm-8">						
							<input type="radio" name="video_week" value="0"<?php echo ($row['video_week']==0 ? ' checked="checked"' : ''); ?> /> No 						
							<input type="radio" name="video_week" value="1"<?php echo ($row['video_week']==1 ? ' checked="checked"' : ''); ?> /> Yes					
						</div>	
					</div>
				
				</div>
				
				
				
				<div class="form-group">
				<div class="col-sm-4 col-sm-offset-2">
					<button type="submit"  name="save" value="Save" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</form>
			
			<script>
			function show_block(show_div, hide_div){
				$(show_div).show();
				$(hide_div).hide();	
	
			}
			
			</script>
			
    <?php
	}else{
		exit();
	}
}
	?>
