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
	$co->page_title = "Add URL | Linkibag";     
 	$current = $co->getcurrentuser_profile();  	
	$user_profile_info = $co->call_profile($current['uid']);  
	$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');  	    
	$views=true;      	      	
	if(isset($_GET['views']) and $_GET['views']!=''){ 
		$item_per_page = $_GET['views'];      	
	}else{      		
		$item_per_page = 10;      	
	}	      	
	$this_page='p=add_url';      
	$categories = $co->fetch_all_array("select * from category where uid IN (:id) ORDER BY cid DESC",array('id'=>$current['uid']));    
	$user_public_categories = $co->fetch_all_array("select * from user_public_category WHERE status='1'",array()); 

	/*if(isset($_GET['id']) and $_GET['id']!=''){      		
		$this_page='p=dashboard&id='.$_GET['id'];      		
		$urlposts_retrun = $co->get_urlposts_by_category($_GET['id'],$current['uid'],$item_per_page, $this_page);      		
		$urlposts = $urlposts_retrun['row'];      		
		$page_links = $urlposts_retrun['page_links'];      		
		if(count($urlposts)<1)      			
			$no_record_found="No Record Found";      	
	}else{      		
		$urlposts_retrun = $co->get_all_urlposts($current['uid'],$item_per_page, $this_page);      	
		$urlposts = $urlposts_retrun['row'];      		
		$page_links = $urlposts_retrun['page_links'];     
	}      
		if(isset($_GET['views']) and $_GET['views']!=''){
      		$this_page .= '&views='.$_GET['views'];      	
		}      	
		/*      	
		if(isset($_GET['delid'])){            		
		$co->query_delete('user_urls', array('id'=>$_GET['delid']),'url_id=:id');            		
		$co->setmessage("error", "URL post has been successfully deleted");      		
		echo '<script type="text/javascript">window.location.href="index.php?p=dashboard"</script>';      	
		exit();      	
		}      	
		*/ 	  	
		$total_urls = $co->users_count_url($current['uid']);  	
		$total_friends = $co->users_count_friend($current['uid']);  	
		$total_friends_url = $co->users_count_shared_url($current['uid']);       
		?>
		<section class="dashboard-page"> 
			<div class="container bread-crumb top-line">    
			<div class="col-md-12">      
				<p><a href="index.php">Home</a> &gt; Add New Links</p>
			</div> 
			</div>
			<div class="containt-area" id="dashboard_new">  
				<div class="container"> 
					<div class="col-md-3">      
						<?php include('dashboard_sidebar.php'); ?>      
					</div>
					<div class="containt-area-dash col-md-9"> 
							<div class="user-name-dash row">
								<div class="col-sm-10" style="padding: 0;">
									<a class="text-blue" href="index.php?p=add_url"><i class="fa fa-check"></i> Add New Links</a>
									<a class="btn button-grey pull-right" href="index.php?p=linkibags">My Folders</a>
								</div>
								
							</div>
							<div class="tab-content card save_new_url"> 
								<div style="border: 2px solid #ff8000;" class="tab-content-box col-sm-10 box-class">
									<div id="url-body" class="save-new-url-form col-md-12">
										<div id="messages_out"></div>
										<form method="post" id="url_form" action="index.php?p=add_url&ajax=ajax_submit" onsubmit="javascript: return add_url();">
											<input type="hidden" name="form_id" value="url_submission"/>
											<input type="hidden" name="page" value="<?=isset($_GET['page']) ? $_GET['page'] : '1'?>"/>
									<input type="hidden" name="item_per_page" value="<?=$item_per_page?>"/>
									<input type="hidden" name="this_page" value="<?=$this_page?>"/>
											
												<div class="form-group">
													<div class="col-md-4">
														<label class="mylabel">URL:</label>  
													</div>
													<div class="col-sm-8">	
														<input type="text" name="url_value" class="form-control" placeholder="http://www.sample.com" value="" maxlength="255"/>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-4">
														<label class="mylabel">Description:</label>  
													</div>
													<div class="col-sm-8">	
														<textarea placeholder="Description goes here." name="url_desc" class="form-control url-desc" value="" maxlength="255"></textarea>
													</div>	
												</div>
												<div class="form-group">
													<div class="col-md-4">
														<label class="mylabel">Select Folder:</label>  
													</div>
													<div class="col-sm-5">	
														<select name="url_cat" id="move_to_cat" class="form-control">
															<option value="">Select Folder</option>
															<option value="-2" selected="selected">Inbag</option>
															<?php
															foreach($categories as $cat){
															echo '<option value="'.$cat['cid'].'">'.$cat['cname'].'</option>';
															}	
															?>
														</select>
													</div>	
													<div class="col-sm-3">
														<a class="text-info" href="javascript: load_add_frm('category', 'view_link');"><small>Add New Folder</small></a>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-4">
														<!--<label class="mylabel font-text">Sharing Preferences:</label>  -->
														<label class="mylabel">Sharing Preferences:</label>  
													</div>
													<!--
													for instutional account only 4 options and we changed label
													for other accounts only 3 option are used													
													-->
													<div class="col-sm-6">	
														<select name="share_type" id="share_type" class="form-control" onchange="show_public_cat(this.value);">
															<option value="1">Not for share</option>
															<option value="2">I may share this link with selected users</option>
															<?php /*
															<option value="1"><?=(($current['role'] == 3) ? 'Not Shared' : 'Just Me')?></option>
															<option value="2"><?=(($current['role'] == 3) ? 'I will share this link with selected users' : 'I will decide with whom to share')?> </option>
															<option value="3"><?=(($current['role'] == 3) ? 'Make this link visible and searchable by public via LinkiBag app and website' : 'Add this link to LinkiBag search')?></option>
															<?=(($current['role'] == 3) ? '<option value="4">Make this link visible and searchable by users from my educational institution</option>' : '')?>*/ ?>
															<?php /*
															<option value="1"><?=(($current['role'] == 3) ? 'Not Shared' : 'This link is not for share')?></option>
															<option value="2"><?=(($current['role'] == 3) ? 'I will share this link with selected users' : 'I may share this link')?> </option>
															<?php if($current['role'] == 3){ ?>
																<option value="3"><?=(($current['role'] == 3) ? 'Make this link visible and searchable by public via LinkiBag app and website' : 'Add this link to LinkiBag search')?></option>
																<?=(($current['role'] == 3) ? '<option value="4">Make this link visible and searchable by users from my educational institution</option>' : '')?>
														<?php } ?>
														<?php */ ?>
														</select>
													</div>														
												</div>
												<div class="form-group" id="public_cat_block"<?=((isset($_POST['share_type']) and $_POST['share_type'] == 3) ? '' : ' style="display:none;"')?>>
													<div class="col-md-4">
														<!--<label class="mylabel font-text">Select Category:</label>  -->
														<label class="mylabel">Select Category:</label>  
													</div>
													<div class="col-sm-5">	
														<select name="public_cat" id="move_to_public_cat" class="form-control">
															<?php															
															if(isset($user_public_categories) and count($user_public_categories) > 0){
																foreach($user_public_categories as $cat){
																	echo '<option value="'.$cat['cid'].'">'.$cat['cname'].'</option>';
																}
															}	
																
															?>
														</select>
													</div>	
													<div class="col-sm-3">
														<a class="text-info" href="javascript: load_add_frm('public_category', 'view_link');"><small>Recommend Category</small></a>
													</div>	
												</div>
												<div class="col-sm-7 col-sm-offset-4 text-right">
													<button type="submit" onclick="ShowHideSubmit()" class="btn btn-default linki-btn" id="send_url">Add</button>
													<button type="button" onclick="url_clears()" class="btn btn-default linki-btn" id="url_clear">Cancel</button>
												</div>
										</form>
									</div>
								</div>	
								<div class="tab-content-box-left col-sm-2">
								</div>
							</div>		
								
								        
					</div>
							
				</div>
			</div>	
		</section>
		
		<a class="btn btn-info orang-bg" href="#" data-toggle="modal" data-target="#add_groups_and_cat" id="add_new_folder" style="display:none;">Add New Folder</a>
		<div class="modal fade" id="add_groups_and_cat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

		  <div class="modal-dialog modal-sm">

			<div class="modal-content add-new-gp theme-modal-header">

				<div class="modal-header">

					<h4>Add New Folder </h4>

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
			/* new style by jimmy on 23/07/18 */
		   .modal-content{
		      font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif !important;
		   }
		   .theme-modal-header .modal-header {
		      border-radius: 10px; 
		   }  
		   .theme-modal-header .modal-header h4 {
		       color: #fff !important;
		   }
		   label {
		       color: #31496a !important;
		   }
		   .linki-btn {
		        background: #c3c3c3 none repeat scroll 0 0 !important;
		       border: medium none;
		       color: #646464 !important;
		       border-radius: 2px !important;
		       font-size: 1em !important;
		       font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif !important;
		   }
		   /* end new style by jimmy on 23/07/18 */
			
		</style>
				
		<?php  }      ?>