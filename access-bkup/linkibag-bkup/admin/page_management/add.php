<?php
$breadcrumb = 'Page Management';
$title = '<i class="fa fa-table"></i> Create New Page';

if(isset($_POST['save']) && $_POST['save']=="Save"){
	$success = true;
	if($success == true){
		$new_val['title'] = $_POST['title'];				$new_val['page_body'] = $_POST['page_body'];				$new_val['created'] = time();				$new_val['updated'] = time();				$new_val['status'] = 1;
		$page_id = $co->query_insert('pages', $new_val);
		unset($new_val);
		//package images
		$co->upload_multiple_images($_FILES['page_imgs'], array(), array(), $page_id, 'page_imgs', $_POST['img_id']);
		
		$co->setmessage("status", "New Page inserted successfully");		
	}
}
?>
        <form method="post" enctype="multipart/form-data" class="form-horizontal">            
			<div class="form-group">
				<label class="col-sm-2 control-label">Title</label>
                <div class="col-sm-8">				
					<input type="text" name="title" class="form-control" maxlength="100" />
				</div>
			</div>						<div class="form-group">				<label class="col-sm-2 control-label">Page Body</label>                <div class="col-sm-8">									<textarea name="page_body"class="form-control ckeditor "></textarea>				</div>			</div>			
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
						<tr class="multifield">
							<td>
								<input type="hidden" name="img_id[]" value="0" />
								<input type="file" name="page_imgs[]" required />
							</td>
						</tr>
					</tbody>
					</table>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-4 col-sm-offset-2">
					<button type="submit" name="save" value="Save" class="btn btn-primary">Save changes</button>
				</div>
			</div>
        </form>	
	</div>
</div>