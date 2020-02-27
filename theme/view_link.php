<?php  
function page_access(){	
	global $co, $msg;      	
	$user_login = $co->is_userlogin();      	
	if(!$user_login){   
		echo '<script language="javascript">window.location="index.php";</script>';      		
		exit();      
	}          
}      
function page_content(){      
	global $co, $msg;      	
	$no_record_found='';      	
	$co->page_title = "View Link | Linkibag";     
 	$current = $co->getcurrentuser_profile();  	
	$user_profile_info = $co->call_profile($current['uid']);  
	$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');  	
	$user_public_categories = $co->fetch_all_array("select * from user_public_category WHERE status='1'",array()); 
	
	$views=true;      	      	
	if(isset($_GET['views']) and $_GET['views']!=''){ 
		$item_per_page = $_GET['views'];      	
	}else{      		
		$item_per_page = 10;      	
	}	      	
	$this_page='p=view_link';      
	$categories = $co->show_all_category();      
	if(isset($_GET['id']) and $_GET['id']!=''){      		
		$this_page='p=dashboard&id='.$_GET['id'];
		
		$row = $co->query_first("SELECT ur.share_type,ur.public_cat,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,us.shared_url_id,us.shared_time,us.shared_to,us.url_cat,us.share_type_change,us.like_status,us.recommend_link FROM user_urls ur, user_shared_urls us LEFT JOIN `users` u ON u.uid=us.uid WHERE ur.url_id=us.url_id and (us.shared_to=:uid OR us.sponsored_link='1') and us.shared_url_id=:id ORDER BY us.shared_url_id DESC", array('uid'=>$current['uid'], 'id'=>$_GET['id']));

		$check_shared_by_is_user_friend = $co->query_first("SELECT `ur`.friend_id, `fr`.request_id FROM `friends_request` fr INNER JOIN `user_friends` ur ON `ur`.request_id=`fr`.request_id WHERE fr.request_email=:email and `fr`.status='1' and `ur`.status='1' and (`fr`.request_by=:uid OR `fr`.request_to=:uid2) and fr.request_email!=:email2",array('uid'=>$current['uid'],'uid2'=>$current['uid'],'email'=>$row['email_id'],'email2'=>$current['email_id']));
		if(!(isset($check_shared_by_is_user_friend['request_id']) and $check_shared_by_is_user_friend['request_id'] > 0)){
			$check_shared_by_is_user_friend = $co->query_first("SELECT `ur`.friend_id, `fr`.request_id FROM `friends_request` fr INNER JOIN `user_friends` ur ON `ur`.request_id=`fr`.request_id WHERE fr.request_email=:email and `fr`.status='0' and `ur`.status='0' and (`fr`.request_by=:uid OR `fr`.request_to=:uid2) and fr.request_email!=:email2",array('uid'=>$current['uid'],'uid2'=>$current['uid'],'email'=>$row['email_id'],'email2'=>$current['email_id']));
		}

		
		$show_all_category_of_current_user = $co->fetch_all_array("SELECT * FROM `category` WHERE uid=:id",array('id'=>$current['uid']));
		
		
		$next_link = $co->query_first("SELECT us.shared_url_id  FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:uid and us.shared_url_id <:id ORDER BY us.shared_url_id DESC", array('id'=>$row['shared_url_id'],'uid'=>$current['uid']));
		
		$prev_link = $co->query_first("SELECT us.shared_url_id  FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:uid and us.shared_url_id >:id ORDER BY us.shared_url_id ASC", array('id'=>$row['shared_url_id'],'uid'=>$current['uid']));
		
		$urlposts_retrun = $co->get_urlposts_by_category($_GET['id'],$current['uid'],$item_per_page, $this_page);      		
		$urlposts = $urlposts_retrun['row'];      		
		$page_links = $urlposts_retrun['page_links'];      		
		if(count($urlposts)<1)      			
			$no_record_found="No Record Found";      	
	}else{	
		$urlposts_retrun = $co->get_all_urlposts($current['uid'],$item_per_page, $this_page);      	
		$urlposts = $urlposts_retrun['row'];      		
		$page_links = $urlposts_retrun['page_links'];  
		$total_pages = $urlposts_retrun['paging2'];  
		$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');	
	}      
		if(isset($_GET['views']) and $_GET['views']!=''){
      		$this_page .= '&views='.$_GET['views'];      	
		}      	
			  	
		   
		//print_r($urlposts);
		//echo count($urlposts);
		if($row['shared_url_id'] > 0){
			$co->query("UPDATE `user_shared_urls` SET `num_of_visits` = `num_of_visits` + 1 WHERE `shared_url_id` = '".$row['shared_url_id']."'");
			
			$co->query_update('user_shared_urls', array('read_status'=>1), array('id'=>$row['shared_url_id']), 'shared_url_id=:id');
			
			$total_urls = $co->users_count_url($current['uid']);  	
			$total_friends = $co->users_count_friend($current['uid']);  	
			$total_friends_url = $co->users_count_shared_url($current['uid']);   
		?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
				<div class="col-md-7">      
					<p><a href="index.php">Home </a><a href="index.php?p=dashboard"> > Link Details</a></p>    
				</div> 
				<div class="col-md-5 text-right">
					<!--<div class="dropdown dropdown-bg-none top-user-drop pull-right">
						<a data-toggle="dropdown" class="btn dropdown-toggle pull-right" aria-expanded="false"><?php//$current['email_id']?> <li class="caret"></li></a>
						<ul class="dropdown-menu">
							<li><a href="index.php?p=dashboard"><i aria-hidden="true" class="fa fa-tachometer"></i> Dashboard</a></li>
							<li><a href="index.php?p=friends"><i aria-hidden="true" class="fa fa-list"></i> Friend List</a></li>
							<li><a href="index.php?p=edit-profile"><i aria-hidden="true" class="fa fa-pencil"></i> Edit Profile</a></li>						
							<li><a href="logout.php"><i aria-hidden="true" class="fa fa-sign-out"></i> Logout</a></li>
						</ul>
					</div>-->
				</div>
			</div>  
			<div class="containt-area" id="dashboard_new">  
				<div class="container"> 
					<div class="col-md-3">      
						<?php include "dashboard_sidebar.php" ?>
					</div>	
					<div class="containt-area-dash col-md-9">      
						<div class="view-link-page">
							<div class="user-name-dash" style="margin: 0 0 8px !important">
								<span style="display: inline-block; padding-top: 6px;position: relative;" class="text-orang" href="index.php?p=add_url">Link Details</span>
							</div>
							<div class="gray-box">
								<form id="update_url_form" onsubmit="javascript: return submit_update_urls('');" class="view-link-form light-form-control row" action="index.php?p=view_link&id=<?=$row['shared_url_id']?>&ajax=ajax_submit">
									<input type="hidden" name="page" value="<?=isset($_GET['page']) ? $_GET['page'] : '1'?>"/>
									<input type="hidden" name="item_per_page" value="<?=$item_per_page?>"/>
									<input type="hidden" name="this_page" value="<?=$this_page?>"/>

									<input type="hidden" name="form_id" value="url_submission_update_only_share_type"/>
									<input type="hidden" name="id" value="<?=$row['shared_url_id']?>"/>
									
									<fieldset>
									<!-- Text input-->
									<div class="form-group">
									  <div class="col-md-4">
									  	<label class="col-md-12 control-label">URL:</label>  
									  </div>	
									  <div class="col-md-6">
									  	<a target="_blank" href="index.php?p=scan_url&id=<?=$row['shared_url_id']?>&url=<?=urlencode($row['url_value'])?>" class="form-control input-md link-color"><?=$row['url_value']?></a>
									  </div>
									  
									  <div class="col-md-2">
									  	<?php if($row['email_id'] != ''){ ?>
										<a href="javascript: like_user_urls('<?=$row['shared_url_id']?>');" id="like_url_btn" data-toggle="tooltip" title="<?=(($row['like_status'] == '1') ? 'Like' : 'Unlike')?>"><i class="fa<?=(($row['like_status'] == '1') ? ' fa-heart' : ' fa-heart-o')?>" aria-hidden="true"></i></a>	
									  	<a href="javascript: recommend_user_urls('<?=$row['shared_url_id']?>');" id="recommend_url_btn" data-toggle="tooltip" title="<?=(($row['recommend_link'] == '1') ? 'Recommend' : 'Unrecommend')?>"><i class="fa fa-arrow-up<?=(($row['recommend_link'] == '1') ? ' recommend' : ' unrecommend')?>" aria-hidden="true"></i></a>	
										<?php } ?>
									  </div>
									</div>
									
									<!-- Text input-->
									<div class="form-group">
									  <div class="col-md-4">
									  		<label class="col-md-12 control-label">Shared by:</label>  
									  </div>	
									  <div class="col-md-6">
									  	<input name="shared" value="<?=($row['email_id'] == '') ? 'Sponsored' : $row['email_id']?>" class="form-control input-md" required="" type="text" readonly>
									  </div>
									  	
									  	<input type="hidden" id="view_link_request_id" name="request_id" value="<?=isset($check_shared_by_is_user_friend['request_id']) ? $check_shared_by_is_user_friend['request_id'] : '0'?>" />

									  	<div id="remove_friend_list_block"<?=((isset($check_shared_by_is_user_friend['request_id']) and $check_shared_by_is_user_friend['request_id'] > 0) ? '' : ' style="display: none;"')?>>																		
										  	<div class="col-md-2">
										 	 	<button type="button" class="btn btn-danger linki-btn" onclick="remove_as_friend('<?=$row['email_id']?>','#remove_to_friends')" id="remove_to_friends"><span>Unfriend</span>&nbsp; <i class="fa fa-spinner fa-spin" id="loading_remove_as_friend" style="display: none;"></i></button>
										  	</div>
										</div>
										<?php
										$add_to_friends = true;
										if((isset($check_shared_by_is_user_friend['request_id']) and $check_shared_by_is_user_friend['request_id'] > 0) OR ($row['email_id'] != '' and $current['email_id'] == $row['email_id']) OR empty($row['email_id'])){
											$add_to_friends = false;
										}
										if($add_to_friends == true){
										?>									  
								  		<div id="add_friend_list_block">
								  			<div class="col-md-2">
										 	 	<button type="button" style="padding: 4px 8px;" class="btn btn-danger linki-btn" onclick="add_as_friend('<?=$row['email_id']?>','#add_to_friends')" id="add_to_friends"><span>Add to Friends</span>&nbsp; <i class="fa fa-spinner fa-spin" id="loading_add_as_friend" style="display: none;"></i></button>
										  	</div>
										</div>
									  <?php } ?>
									</div>
									
									<!-- Text input-->
									<div class="form-group">
									   <div class="col-md-4">
									  		<label class="col-md-12 control-label">Received:</label>  
									  </div>		
									  <div class="col-md-6">
									  <input name="received" value="<?=date('d/m/Y', $row['shared_time'])?>  <?=date('h:i a', $row['shared_time'])?>" class="form-control input-md" required="" type="text" readonly>
									  </div>
									  <div><a href="index.php?p=edit-profile#user_timezone"><i class="fa fa-clock-o"></i></a></div>
									</div>
									
									<!-- Textarea -->
									<div class="form-group">
									  <div class="col-md-4">
									  		<label class="col-md-12 control-label" for="textarea">Description:</label>
									  </div>
									  <div class="col-md-6">                     
										<textarea rows="6" class="form-control" name="description" readonly><?=((strlen($row['url_desc']) > 50) ? substr($row['url_desc'], 0, 500).'...' : $row['url_desc'])?></textarea>
									  </div>
									</div>

									<!-- Select Basic -->
									<div class="form-group">
									  <div class="col-md-4">
									  	  <label class="col-md-12 control-label">Move to:</label>	
									  </div>	
									  <div class="col-md-5">
										<select name="move" class="form-control" id="move_to_cat" onchange="move_to_category('<?=$row['shared_url_id']?>', '<?=$row['shared_to']?>', 'move_cat', this.value);">
											<option value="">Select</option>
											<option value="-2"<?=(($row['url_cat'] == '-2') ? ' selected="selected"' : '')?>>Inbag</option>
											<option value="0"<?=(($row['url_cat'] == '0') ? ' selected="selected"' : '')?>>Trash</option>
										<?php
										foreach($show_all_category_of_current_user as $list){
											$sel = '';
											if(isset($list['cid']) and $list['cid'] == $row['url_cat'])
												$sel = ' selected="selected"';
										?>
										  
										  <option value="<?=$list['cid']?>"<?=$sel?>><?=$list['cname']?></option>
										<?php
										}
										?>										
										</select>
										<small class="pull-right gray-color-text" style="display: none;">Select Folder</small>
									  </div>
									  <div class="col-md-5" style="display: none;">
										<img src="./images/loading_icon.gif" id="view_link_load_img" style="display: none;"></img><a class="text-info" href="#" onclick="load_add_frm('category', 'view_link');">Add new Folder</a>
									  </div>
									</div>
									
									<div class="form-group">
										<div class="col-md-4">
											<label class="col-md-12 control-label">Share Type:</label>  
										</div>
										<!--
										for instutional account only 4 options and we changed label
										for other accounts only 3 option are used													
										-->
										<div class="col-md-5">
											<?php
											$sel_4th = '';
											if($row['share_type_change'] == 4)
												$sel_4th = ' selected="selected"'; 
												
											?>
											<select name="share_type" id="share_type" class="form-control" onchange="share_type_change(this.value);show_public_cat(this.value);";>
												<option value="1"<?=(($row['share_type_change'] == 1) ? ' selected="selected"' : '')?>>Not for share</option>
												<option value="2"<?=(($row['share_type_change'] == 2) ? ' selected="selected"' : '')?>>I may share this link with selected users</option>
												<?php /*
												<option value="1"<?=(($row['share_type_change'] == 1) ? ' selected="selected"' : '')?>><?=(($current['role'] == 3) ? 'Not Shared' : 'This link is not for share')?></option>
												<option value="2"<?=(($row['share_type_change'] == 2) ? ' selected="selected"' : '')?>><?=(($current['role'] == 3) ? 'I will share this link with selected users' : 'I may share this link')?> </option>
												<?php if($current['role'] == 3){ ?> 
												<option value="3"<?=(($row['share_type_change'] == 3) ? ' selected="selected"' : '')?>><?=(($current['role'] == 3) ? 'Make this link visible and searchable by public via LinkiBag app and website' : 'Add this link to LinkiBag search')?></option>
												<?=(($current['role'] == 3) ? '<option value="4"'.$sel_4th.'>make this link visible and searchable by users from my educational institution</option>' : '')?>
											<?php } ?>
											*/ ?>
											</select>
										</div>
										<div class="col-md-1" style="padding: 0px;" id="share_type_redcircle">
											<?php 
											if($row['share_type_change'] == 1)
											{
												echo '<a href="javascript:void(0);" data-toggle="tooltip" title="Not for share"><i class="fa fa-circle text-greys"></i></a>';
											} 
											else
											{ 
												echo '<a href="javascript:void(0);" data-toggle="tooltip" title="I may share this link with selected users"><i class="fa fa-circle text-success"></i></a>';
											}	
											?>	
										</div>														
									</div>
									
									<div class="form-group" id="public_cat_block"<?=((isset($row['share_type_change']) and $row['share_type_change'] == 3) ? '' : ' style="display:none;"')?>>
										<div class="col-md-4">										
											<label class="col-md-12 control-label">Category:</label>  		
										</div>						
										<div class="col-md-5">	
											<select name="public_cat" id="move_to_public_cat" class="form-control">
												<?php															
												if(isset($user_public_categories) and count($user_public_categories) > 0){
													foreach($user_public_categories as $cat){
														$sel = '';
														if($row['public_cat'] == $cat['cid'])
															$sel = ' selected="selected"';
														echo '<option value="'.$cat['cid'].'"'.$sel.'>'.$cat['cname'].'</option>';
													}
												}	
													
												?>
											</select>
										</div>	
											
									</div>
									

									<!-- Button -->
									<div class="form-group" style="margin-top: 35px;">
									  <div class="col-md-10 text-right">
										<?php
										if($prev_link['shared_url_id'] > 0){
										?>
										<a class="btn btn-danger linki-btn" onclick="submit_update_urls('index.php?p=view_link&id=<?=$prev_link['shared_url_id']?>')" href="javascript: void(0)">Previous</a>
										<?php } ?>
										
										<!--<button class="btn btn-success linki-btn" type="submit" id="send_url" onclick="ShowHideSubmit()">Add to my LinkiBag</button>-->
										<button type="submit" onclick="ShowHideSubmit()" class="btn btn-default linki-btn" id="update_url_btn" style="display: none;">Update</button>

										<a class="btn btn-success linki-btn" onclick="move_to_category('<?=$row['shared_url_id']?>', '<?=$row['shared_to']?>','del', '0')">Delete</a>
										<?php
										if($next_link['shared_url_id'] > 0){
										?>
										<a class="btn btn-danger linki-btn" onclick="submit_update_urls('index.php?p=view_link&id=<?=$next_link['shared_url_id']?>')" href="javascript: void(0)">Next</a>
										<?php } ?>
									  </div>
									</div>

									</fieldset>
									</form>

							</div>
						</div>
					</div>    
					  
				</div>
			</div>	
		</section>
		
		<a class="btn btn-info orang-bg" href="#" data-toggle="modal" data-target="#add_groups_and_cat" id="add_new_folder" style="display:none;">Add New Folder</a>
		<div class="modal fade" id="add_groups_and_cat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

		  <div class="modal-dialog modal-sm">

			<div class="modal-content add-new-gp">

				<div class="modal-header">

					<h4>Add New Folder</h4>

					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

				</div>
				<div id="model_body">
					
					
				</div>
			</div>

		  </div>

		</div>	
		<style>
			.text-greys{
				color: #DBDBDB;
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
			.gray-box {
			    border: 2px solid #e6bc81;
			    padding: 20px;
			    border-radius: 2px;
			}
			.fa-heart{
		      color: red;
		   	}
		   	.recommend{
		      color: red;
		   }
			
		</style>

		<script type="text/javascript">
			function share_type_change(val){
				if(val === '1')
				{
					$('#share_type_redcircle').html('<a href="javascript void(0);" data-toggle="tooltip" title="Not for share"><i class="fa fa-circle text-greys"></i></a>');
				}
				else
				{
					$('#share_type_redcircle').html('<a href="javascript void(0);" data-toggle="tooltip" title="I may share this link with selected users"><i class="fa fa-circle text-success"></i></a>');
				}	
				$('#update_url_btn').show();
			}

			function submit_update_urls(redirecturl){	
				var formdata = new FormData($('#update_url_form')[0]);
				$('#update_url_btn').html('Updating...');
				$('#update_url_btn').attr('disabled', 'disabled');
				$.ajax({
					type: "POST",
					url: $('#update_url_form').attr('action'),
					data: formdata,
					cache: false,
					contentType: false,
					processData: false,
					success: function(res2) {
						res2 = JSON.parse(res2);
						//alert(res2);
						if(res2.success === true){
							if(redirecturl!=''){
								window.location.href = redirecturl;
							}else{
								$("#dialog_success").html(res2.msg);
								$("#dialog_success" ).dialog( "open" );
								$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
							}
						}else if(res2.success === false){
							$("#dialog_error").html(res2.msg);
							$( "#dialog_error" ).dialog( "open" );					
							$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_error" );
						}

						$('#update_url_btn').html('Update');
						$('#update_url_btn').removeAttr('disabled');
						
					}
				});
				
				return false;
			}

			function like_user_urls(shared_url_id){
				$.ajax({
		            type: "POST",
		            url: 'ajax/like_urls.php',
		            data: {'like_url':'1','shared_url_id':shared_url_id},
		            success: function(res2){                                 
		               	if(res2 === '1'){
		               		$("#like_url_btn").html('<i class="fa fa-heart" aria-hidden="true"></i>');		
		               		$("#like_url_btn").attr('title','Like');		
		               	}else{
		               		$("#like_url_btn").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
		               		$("#like_url_btn").attr('title','Unlike');		
		               	}
		            }
		        });
			}
			function recommend_user_urls(shared_url_id){
				$.ajax({
		            type: "POST",
		            url: 'ajax/recommend_urls.php',
		            data: {'recommend_url':'1','shared_url_id':shared_url_id},
		            success: function(res2){                                 
		               	if(res2 === '1'){
		               		$("#recommend_url_btn").html('<i class="fa fa-arrow-up recommend" aria-hidden="true"></i>');		
		               		$("#recommend_url_btn").attr('title','Recommend');		
		               	}else{
		               		$("#recommend_url_btn").html('<i class="fa fa-arrow-up unrecommend" aria-hidden="true"></i>');
		               		$("#recommend_url_btn").attr('title','Unrecommend');		
		               	}
		            }
		        });
			}

		</script>
				
		<?php }
		}      ?>