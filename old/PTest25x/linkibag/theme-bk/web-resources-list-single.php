<?php
function page_content(){
global $co, $msg;
$co->page_title = "Web Resources Library | LinkiBag";
$current = $co->getcurrentuser_profile();  	
if(!(isset($_GET['id'])))
   exit();
$category = $co->query_first("SELECT * FROM user_public_category WHERE status='1' and cid=:id",array('id'=>$_GET['id'])); 
$nextcategory = $co->query_first("SELECT * FROM user_public_category WHERE status='1' and cid>:id ORDER BY cid ASC",array('id'=>$_GET['id'])); 
$prevcategory = $co->query_first("SELECT * FROM user_public_category WHERE status='1' and cid<:id ORDER BY cid DESC",array('id'=>$_GET['id'])); 

$user_public_categories = $co->fetch_all_array("select * from user_public_category where status='1'",array()); 
   
$user_public_category_link = $co->fetch_all_array("SELECT us.uid,p.first_name,us.shared_time,us.shared_url_id,c.created_time,c.cname,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id FROM `user_urls` ur, users u, user_shared_urls us, user_public_category c, profile p WHERE p.uid=u.uid and us.uid=u.uid and ur.url_id=us.url_id and us.url_cat=ur.url_cat and ur.approved_public_cat=c.cid and ur.approved_public='1' and c.status='1' and ur.approved_public_cat=:id ORDER BY us.shared_url_id DESC",array('id'=>$_GET['id'])); 

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

		
<div class="container bread-crumb res-bread-crumb">
   <div class="col-md-12">
   		<div class="col-md-4 col-xs-12 pull-left">
			<p><a href="index.php">Home</a> &gt; <a href="index.php?p=web-resources-list">Web Resources</a></p>
		</div>	
		<div class="col-md-8 col-xs-12 next-back-btn ">
			<?php if(isset($nextcategory['cid']) and $nextcategory['cid'] > 0){ ?>
				<a href="index.php?p=web-resources-list-single&id=<?=$nextcategory['cid']?>" class="nxt-btn">Next Category > </a>
		<?php } ?>
		<?php if(isset($prevcategory['cid']) and $prevcategory['cid'] > 0){ ?>
				<a href="index.php?p=web-resources-list-single&id=<?=$prevcategory['cid']?>" class="bck-btn"> < Back </a>
		<?php } ?>
			
			
		</div>	
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
				<div class="col-md-3 col-xs-12 rec-profile">
					<div class="img-block">
					<?php 
					if($category['photo'] != '' and file_exists($category['photo'])){ 
						echo '<img src="'.$category['photo'].'" alt="'.$category['cname'].'" class="img-responsive">';
					}else{
						echo '<img src="images/noimage.jpg" alt="'.$category['cname'].'" class="img-responsive">';
					} 
					?>
					</div><br>
					<p><b>Signup and start sharing today.</b></p><br/>
					<a class="btn orange-bg" href="index.php?#free_singup">Free Signup</a><br>
					<a class="com-link faq_link" href="index.php?#free_singup">Free individual account signup</a>
				</div>
				<div class="col-md-9 col-xs-12">
	         <div class="web-resources-list">
	            <h2 style="display: none;">My LinkiBook &nbsp;&nbsp;&nbsp;
						  <a style="vertical-align: text-top;" class="btn button-grey" onclick="multiple_load_share_link_form('print_pdf');" href="#"><i class="fa fa-print" aria-hidden="true"></i> View and pdf</a></h2>
	            <div class="web-resources-list-links web-resources-list-links-single" style="display: none;">
					<div class="row">
	                  <div class="col-md-3">
	                  <h3>
	                     <input type="checkbox" name="check" id="checkAll" value=""/>&nbsp; 
	                     <select name="public_cat" id="move_to_public_cat" class="technology-select-area">
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
						    <div class="col-md-4">
							<div class="alert alert-warning alert-dismissible alert-section" role="alert">
						  <button type="button" class="close close-section" data-dismiss="alert" aria-label="Close" style="/*! border: 1px solid #000; *//*! border-radius: 21px; *//*! font-size: 15px; */"><span aria-hidden="true">×</span></button>
						  The system will print and share the comments when you print or share your links.</div>
						</div>
								
						<div class="col-md-3">
							<div class="alert alert-warning alert-dismissible alert-section" role="alert">
						  <button type="button" class="close close-section" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Notes will NOT be printed or shared.</div>
						</div>

						<div class="col-md-2">
							<div class="alert alert-warning alert-dismissible alert-section" role="alert">
						  <button type="button" class="close close-section" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						  Select dates to be printed.</div>
							</div>
						</div>
					</div>
					<div class="web-resources-list-links-single-inner">
					  <div class="col-md-12" style="display: none;">
						<div class="web-resources-list-links-single-header">
							<div class="col-md-4 padding-none">
								<p style="display: none;"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="<?=$list['shared_url_id']?>"></span> &nbsp; Select all links from this category</p>
							</div>
							<div class="col-md-4">
								<p>Comments (This comment will be printed when you print
								it and will be shared when you share your link)</p>
							</div>
							<div class="col-md-3">
								<p>Notes<br>(Notes will be printed or shared)</p>
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
					
					<h3><?=ucfirst($category['cname'])?></h3>
					<p style="display: none;">To recommend us additional link or category use</p>
					<?php
					if(isset($user_public_category_link) and count($user_public_category_link) > 0){
						$i = 1;
						foreach($user_public_category_link as $list){
							if (!preg_match("~^(?:f|ht)tps?://~i", $list['url_value'])) {
								$list['url_value'] = "http://" . $list['url_value'];
							}
							$chk_already_comment = $co->query_first("SELECT * from `user_public_category_comments` WHERE uid=:uid and url_id=:id", array('id'=>$list['url_id'], 'uid'=>$current['uid']));

					?>
	               <div class="web-resources-list-links-single-body" id="record_<?=$list['shared_url_id']?>">
	                  <div class="col-md-12 row">
						<div class="row web-resources-list-row-2">
							<div class="col-md-9">
								<p class="text-gray" style="margin-left: -15px !important;"><span style="display: none;"><input type="checkbox" class="urls_shared" name="share_url[]" value="<?=$list['shared_url_id']?>"></span><strong><?=$i?>.</strong> <a href="<?=$list['url_value']?>" target="_blank" style="font-size: 15px;"><?=$list['url_value']?></a></p>
							
							
								<p style="font-size: 15px; margin: 5px 0px !important">
								<?php if(isset($current['uid']) and $current['uid'] == $list['uid']){ ?>	
								<a href="#" onclick="load_edit_frm('<?=$list['shared_url_id']?>', 'web_resource_list_links_comment')"><i class="fa fa-pencil"></i></a>
								<?php 
									} 

								if(isset($chk_already_comment['comment']) and $chk_already_comment['comment'] != ''){
									echo $chk_already_comment['comment'];
								}else{
								 	echo $list['url_desc'];
								}	
								?>
								</p>
							</div>
							<div class="col-md-3" style="display: none;">
								<p>
								<?php if(isset($current['uid']) and $current['uid'] == $list['uid']){ ?>	
								<a href="#" onclick="load_edit_frm('<?=$list['shared_url_id']?>', 'web_resource_list_links_notes')"><i class="fa fa-pencil"></i></a>
								<?php 
								} 

								if(isset($chk_already_comment['notes']) and $chk_already_comment['notes'] != ''){
									echo $chk_already_comment['notes'];
								}

								?>
								</p>
							</div>
							<div class="col-md-1 padding-none" style="display: none;">
								<p><?=date('m/d/Y', $list['shared_time'])?></p>
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
	        </div>
	        <!--
	           <br>	           
	            <p class="text-light-gray">Recommend new topic and add your link.</p>
	            <p class="text-blue">Thanks you for sharing and recommending <br>web resources using LinkiBag</p>
	            <br>
	        -->
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

					<h4><?=$category['cname']?> </h4>

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

					<h4><?=$category['cname']?> </h4>

					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

				</div>
				<div id="model_body2">
					
					
				</div>	
		
			</div>

		  </div>

		</div>
		<style>
			.next-back-btn a{
				font-size: 17px;
				color: #414141;
				font-weight: 600;
				float: right;
				margin: 0 15px;
			}	
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

