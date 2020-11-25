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
	$this_page='p=dashboard';      
	$categories = $co->show_all_category();      
	if(isset($_GET['id']) and $_GET['id']!=''){      		
		$this_page='p=dashboard&id='.$_GET['id'];
		
		$row = $co->query_first("SELECT ur.share_type,ur.public_cat,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,us.shared_url_id,us.shared_time,us.shared_to,us.url_cat FROM user_urls ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:uid and us.shared_url_id=:id ORDER BY us.shared_url_id DESC", array('uid'=>$current['uid'], 'id'=>$_GET['id']));
		
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
					<p><a href="index.php">Home </a><a href="index.php?p=dashboard"> > View-link</a></p>    
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
							<div class="user-name-dash">
								<span class="text-light-gray" href="index.php?p=add_url">Link Details</span>
							</div>
							<div class="gray-box">
								<form class="view-link-form light-form-control row">
									<fieldset>
									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-2 control-label">URL:</label>  
									  <div class="col-md-8">
									  <a target="_blank" href="<?=$row['url_value']?>" class="form-control input-md link-color"><?=$row['url_value']?></a>
									  </div>
									</div>
									
									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-2 control-label">Shared by:</label>  
									  <div class="col-md-8">
									  <input name="shared" value="<?=$row['email_id']?>" class="form-control input-md" required="" type="text" readonly>
									  </div>
									</div>
									
									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-2 control-label">Received:</label>  
									  <div class="col-md-4">
									  <input name="received" value="<?=date('d/m/Y', $row['shared_time'])?>  <?=date('h:i a', $row['shared_time'])?>" class="form-control input-md" required="" type="text" readonly>
									  </div>
									</div>
									
									<!-- Textarea -->
									<div class="form-group">
									  <label class="col-md-2 control-label" for="textarea">Description:</label>
									  <div class="col-md-8">                     
										<textarea rows="6" class="form-control" name="description" readonly><?=((strlen($row['url_desc']) > 50) ? substr($row['url_desc'], 0, 500).'...' : $row['url_desc'])?></textarea>
									  </div>
									</div>

									<!-- Select Basic -->
									<div class="form-group">
									  <label class="col-md-2 control-label">Move to:</label>
									  <div class="col-md-5">
										<select name="move" class="form-control" id="move_to_cat" onchange="move_to_category('<?=$row['shared_url_id']?>', '<?=$row['shared_to']?>', 'move_cat', this.value);" disabled>
											<option value="">Select</option>
											<option value="0">Trash</option>
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
										<small class="pull-right gray-color-text">Select Folder</small>
									  </div>
									  <div class="col-md-5">
										<img src="./images/loading_icon.gif" id="view_link_load_img" style="display: none;"></img><a class="text-info" href="#" onclick="load_add_frm('category', 'view_link');">Add new Folder</a>
									  </div>
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label">Share Type:</label>  
									
										<!--
										for instutional account only 4 options and we changed label
										for other accounts only 3 option are used													
										-->
										<div class="col-sm-8">
											<?php
											$sel_4th = '';
											if($row['share_type'] == 4)
												$sel_4th = ' selected="selected"'; 
												
											?>
											<select name="share_type" id="share_type" class="form-control" disabled="disabled">
												<option value="1"<?=(($row['share_type'] == 1) ? ' selected="selected"' : '')?>><?=(($current['role'] == 3) ? 'Not Shared' : 'Just Me')?></option>
												<option value="2"<?=(($row['share_type'] == 2) ? ' selected="selected"' : '')?>><?=(($current['role'] == 3) ? 'I will share this link with selected users' : 'I will decide with whom to share')?> </option>
												<option value="3"<?=(($row['share_type'] == 3) ? ' selected="selected"' : '')?>><?=(($current['role'] == 3) ? 'Make this link visible and searchable by public via LinkiBag app and website' : 'Add this link to LinkiBag search')?></option>
												<?=(($current['role'] == 3) ? '<option value="4"'.$sel_4th.'>make this link visible and searchable by users from my educational institution</option>' : '')?>
											</select>
										</div>														
									</div>
									<div class="form-group">										
										<label class="col-md-2 control-label">Category:</label>  										
										<div class="col-sm-8">	
											<select name="public_cat" id="move_to_public_cat" class="form-control" disabled="disabled">
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
										<a class="btn btn-danger linki-btn" href="index.php?p=view_link&id=<?=$prev_link['shared_url_id']?>">Previous</a>
										<?php } ?>
										
										<!--<button class="btn btn-success linki-btn" type="submit" id="send_url" onclick="ShowHideSubmit()">Add to my LinkiBag</button>-->
										
										<a class="btn btn-success linki-btn" onclick="move_to_category('<?=$row['shared_url_id']?>', '<?=$row['shared_to']?>','del', '0')">Delete</a>
										<?php
										if($next_link['shared_url_id'] > 0){
										?>
										<a class="btn btn-danger linki-btn" href="index.php?p=view_link&id=<?=$next_link['shared_url_id']?>">Next</a>
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
			.select-friends-form .chosen-choices, .select-friends-form .chosen-drop {
				width: 100%;
			}
			.select-friends-form .chosen-container {
				width: 100% !important;
			}
			.modal-body-group {
				padding: 13px 20px;
			}
			
			
		</style>
				
		<?php }
		}      ?>