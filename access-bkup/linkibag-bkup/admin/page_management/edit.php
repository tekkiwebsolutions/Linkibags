<?php
$breadcrumb = 'Page Management';
$title = '<i class="fa fa-table"></i> Edit Page';

if(isset($_POST['save']) && $_POST['save']=="Update"){
	$success = true;
	if($success == true){		$up = array();				$up['title'] = strip_tags($_POST['title']);				$up['updated'] = time();				$up['status'] = 1;				$up['page_body'] = $_POST['page_body'];		$co->query_update('pages', $up, array('id'=>$_POST['page_id']), 'page_id=:id');				unset($up);
		if(isset($_POST['del_img'])){
			foreach($_POST['del_img'] as $delimg){		
				$img_de = $co->query_first("SELECT * FROM `page_imgs` WHERE `img_id`='".$delimg."'");
				unlink('../'.$img_de['img_original']);
				$thumbs = unserialize($img_de['img_thumbnails']);
				foreach($thumbs as $key=>$thumb){
					unlink('../'.$thumb);
				}
				$co->query_delete('page_imgs', array('id'=>$delimg), 'img_id=:id');
			}
		}
	
		$co->upload_multiple_images($_FILES['page_imgs'], array(), array(), $_POST['page_id'], 'page_imgs', $_POST['img_id']);		
		$co->setmessage("status", "Updated successfully");
	}
	
	
}

$page=$co->query_first("SELECT * FROM `pages` WHERE `page_id`='".$_GET['id']."'", array());
$imgs=$co->fetch_all_array("SELECT * FROM `page_imgs` WHERE `entity_id`='".$_GET['id']."' and entity_field='page_imgs' ORDER BY `img_delta` ASC", array());
?>
        <form method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="page_id" value="<?=$page['page_id']?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">Title</label>
                <div class="col-sm-8">				
	                <input type="text" name="title" value="<?=$page['title']?>" class="form-control" maxlength="100" />
				</div>
			</div>						<div class="form-group">				<label class="col-sm-2 control-label">Page Body</label>                <div class="col-sm-8">									<textarea name="page_body"class="form-control ckeditor "><?=$page['page_body']?></textarea>				</div>			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Page images</label>
                <div class="col-sm-8">
					<table class="table sorted_table">
					<thead>
						<tr>
							<th>Image</th><th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($imgs as $img){
						?>
						<tr id="imgrow_<?=$img['img_id']?>">
							<td>
								<input type="hidden" name="img_id[]" value="<?=$img['img_id']?>" /> 
								<img src="../<?=$img['img_original']?>" style="width: 100px" />
							</td>
							<td>
								<input type="button" class="btn" onclick="remove_img(<?=$img['img_id']?>)" value="Remove" />
							</td>							
						</tr>
						<?php
						}
						?>
						<tr class="multifield">
							<td>
								<input type="hidden" name="img_id[]" value="0" />
								<input type="file" name="page_imgs[]" />
							</td>							
						</tr>												
					</tbody>
					</table>
					<div id="deleted_images_list"></div>					
				</div>
			</div>
            <div class="form-group">
				<div class="col-sm-4 col-sm-offset-2">
					<button type="submit" name="save" value="Update" class="btn btn-primary">Save changes</button>
				</div>
			</div>
        </form>
	</div>
</div>