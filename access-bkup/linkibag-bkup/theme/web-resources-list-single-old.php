<?php
function page_content(){
global $co, $msg;
$co->page_title = "Web Resources Library | LinkiBag";
$current = $co->getcurrentuser_profile();  	
if(!(isset($_GET['id'])))
   exit();
$category = $co->query_first("SELECT * FROM user_public_category WHERE status='1' and cid=:id",array('id'=>$_GET['id'])); 

$user_public_categories = $co->fetch_all_array("select * from user_public_category where status='1'",array()); 
   
$user_public_category_link = $co->fetch_all_array("SELECT us.uid,p.first_name,us.shared_time,us.shared_url_id,c.created_time,c.cname,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id FROM `user_urls` ur, users u, user_shared_urls us, user_public_category c, profile p WHERE p.uid=u.uid and us.uid=u.uid and ur.url_id=us.url_id and us.url_cat=ur.url_cat and ur.public_cat=c.cid and ur.status='1' and c.status='1' and c.cid=:id GROUP BY us.url_id DESC",array('id'=>$_GET['id'])); 

$this_page='p=web-resources-list-single'; 
if(isset($user_public_category_link) and count($user_public_category_link) > 0)
	$item_per_page = count($user_public_category_link); 
else
	$item_per_page = 0; 

	   
?>

<style>
	.web-resources-list-row-2, .web-resources-list-row-2 p {
    	margin: 0px !important;
	}
	.web-resources-list h2 {
    	color: #c3c3c3;
	}
</style>


<div class="container bread-crumb">
   <div class="col-md-12">
		<p><a href="index.php">Home</a> &gt; <a href="index.php?p=web-resources-list">Web Resources</a></p>
   </div>
</div>
<section>
	<form name="dash_form" method="post" id="share_urls_from_dash" action="index.php?p=web-resources-list&ajax=ajax_submit">
		<div id="hidden_elements">
			<input type="hidden" name="form_id" value="multiple_shared">
			<input type="hidden" name="page" value="<?=isset($_GET['page']) ? $_GET['page'] : '1'?>"/>
			<input type="hidden" name="item_per_page" value="<?=$item_per_page?>"/>
			<input type="hidden" name="this_page" value="<?=$this_page?>"/>
			
			
		</div>
		<?php
		if(isset($_GET)){											
			foreach($_GET as $k=>$v){	
				echo '<input type="hidden" name="'.$k.'" value="'.$v.'"/>';
			}	
		}		
		?>
	   <div class="container">
	      <div class="row">
			<div class="col-md-12">
	         <div class="web-resources-list">
	            <h2>My LinkiBook &nbsp;&nbsp;&nbsp;
						  <a style="vertical-align: text-top;" class="btn button-grey" onclick="multiple_load_share_link_form('print_pdf');" href="#"><i class="fa fa-print" aria-hidden="true"></i> View and pdf</a></h2>
	            <div class="web-resources-list-links web-resources-list-links-single">
					<div class="row">
	                  <div class="col-md-12">
	                     <h3>
	                     <input type="checkbox" name="check" id="checkAll" value=""/>&nbsp; 
	                     <select name="public_cat" id="move_to_public_cat">
							<?php															
							if(isset($user_public_categories) and count($user_public_categories) > 0){
								foreach($user_public_categories as $cat){
									$sel = '';
									if($cat['cid'] == $category['cid'])
										$sel = ' selected="selected"';
									echo '<option value="'.$cat['cid'].'"'.$sel.'>'.$cat['cname'].'</option>';
								}
							}	
								
							?>
						</select>
	                     </h3>
	                     	                     
	                    
	                  </div>
					</div>
					<div class="web-resources-list-links-single-inner">
					  <div class="col-md-12">
						<div class="web-resources-list-links-single-header">
							<div class="col-md-4 padding-none">
								<p style="display: none;"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="<?=$list['shared_url_id']?>"></span> &nbsp; Select all links from this category</p>
							</div>
							<div class="col-md-4">
								<p>Comments (This comment will be printed when you print
								it and will be shared when you share your link)</p>
							</div>
							<div class="col-md-3">
								<p>Notes<br>
(Notes will be printed or shared)</p>
							</div>
							<div class="col-md-1 padding-none">
								<p>Date Added</p>
							</div>
							<?php /*
							<div class="col-md-3">
								<p class="text-light-gray">- <?=date('d/m/Y', $list['shared_time'])?>  - by <?=ucfirst($list['first_name'])?></p>
							</div> */ ?>
						</div>
					</div>
					
					<?php
					if(isset($user_public_category_link) and count($user_public_category_link) > 0){
						foreach($user_public_category_link as $list){
							if (!preg_match("~^(?:f|ht)tps?://~i", $list['url_value'])) {
								$list['url_value'] = "http://" . $list['url_value'];
							}
					?>
	               <div class="web-resources-list-links-single-body" id="record_<?=$list['shared_url_id']?>">
	                  <div class="col-md-12">
						<div class="row web-resources-list-row-2">
							<div class="col-md-4">
								<p class="text-gray"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="<?=$list['shared_url_id']?>"></span> &nbsp; <a href="<?=$list['url_value']?>" target="_blank"><?=$list['url_value']?></a></p>
							</div>
							<div class="col-md-4">
								<p class="text-blue">
								<?php if(isset($current['uid']) and $current['uid'] == $list['uid']){ ?>	
								<a href="#" onclick="load_edit_frm('<?=$list['shared_url_id']?>', 'web_resource_list_links')"><i class="fa fa-pencil"></i></a>
								<?php } ?>

								 <?=$list['url_desc']?></p>
							</div>
							<div class="col-md-3">
								<p><i class="fa fa-pencil"></i> Cool Link</p>
							</div>
							<div class="col-md-1 padding-none">
								<p><?=date('M d, Y', $list['shared_time'])?></p>
							</div>
							<?php /*
							<div class="col-md-3">
								<p class="text-light-gray">- <?=date('d/m/Y', $list['shared_time'])?>  - by <?=ucfirst($list['first_name'])?></p>
							</div> */ ?>
						</div>
					  </div>
	               </div>
				  
				   <?php } 
					}else{
						 echo '<p class="text-light-gray">There are no links on this public category.</p>';
						
					}
					?>
					</div>
	            </div>
	           <br>	           
	            <p class="text-light-gray">Recommend new topic and add your link.</p>
	            <p class="text-blue">Thanks you for sharing and recommending <br>web resources using LinkiBag</p>
	            <br>
	         </div>
	      </div>
		  </div>
	   </div>
	   <div class="blue-border"></div>
	</form>   

</section>


<a class="btn btn-info orang-bg" href="#" data-toggle="modal" data-target="#add_groups_and_cat" id="add_new_folder" style="display:none;">Add My LinkiBook</a>
		<div class="modal fade" id="add_groups_and_cat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

		  <div class="modal-dialog modal-sm">

			<div class="modal-content add-new-gp">

				<div class="modal-header">

					<h4>Add My LinkiBook </h4>

					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

				</div>
				<div id="model_body">
					
					
				</div>
			</div>

		  </div>

		</div>		
		
		<a class="btn btn-info green-bg" href="#" data-toggle="modal" data-target="#edit_groups_and_cat" id="edit_new_folder" style="display:none;">Edit My LinkiBook</a>
		<div class="modal fade" id="edit_groups_and_cat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

		  <div class="modal-dialog modal-sm">

			<div class="modal-content">

				<div class="modal-header">

					<h4>Edit My LinkiBook </h4>

					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

				</div>
				<div id="model_body2">
					
					
				</div>	
		
			</div>

		  </div>

		</div>
		<style>	
			.select-friends-form .chosen-choices, .select-friends-form .chosen-drop {
				width: 100%;
			}
			.select-friends-form .chosen-container {
				width: 100% !important;
			}
			.modal-body-group {
				padding: 13px 20px;
			}
			.top-folder-header {
				margin-bottom: 5px;
			}
			.top-folder-header .btn {
				font-size: 14px !important;
			}	
		</style>

<?php
   }
   
   ?>

