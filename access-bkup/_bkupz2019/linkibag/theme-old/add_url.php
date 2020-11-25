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
	$this_page='p=dashboard';      
	$categories = $co->fetch_all_array("select * from category where uid IN (:id, 0) ORDER BY cid DESC",array('id'=>$current['uid']));      
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
				<div class="col-md-7">      
					<p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Add URL</a></p>    
				</div> 
				<div class="col-md-5 text-right">
					<!--<div class="dropdown dropdown-bg-none top-user-drop pull-right">
						<a data-toggle="dropdown" class="btn dropdown-toggle pull-right" aria-expanded="false">thisisfeliks@gmail.com <li class="caret"></li></a>
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
						<?php include('dashboard_sidebar.php'); ?>      
					</div>
					<div class="containt-area-dash col-md-9"> 
							<div class="user-name-dash">
								<a class="text-blue" href="index.php?p=add_url"><i class="fa fa-check"></i> Add New Links</a>
							</div>
							<div class="tab-content card save_new_url"> 
								<div class="tab-content-box col-sm-10 box-class">
									<div id="url-body" class="save-new-url-form col-md-12">
										<div id="messages_out"></div>
										<form method="post" id="url_form" action="index.php?p=add_url&ajax=ajax_submit" onsubmit="javascript: return add_url();">
											<input type="hidden" name="form_id" value="url_submission"/>
											<input type="hidden" name="id" value="<?=$current['uid']?>"/>
												<div class="form-group">
													<div class="col-md-3">
														<label class="mylabel">URL:</label>  
													</div>
													<div class="col-sm-9">	
														<input type="text" name="url_value" class="form-control" placeholder="http://www.sample.com" value="" maxlength="255"/>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-3">
														<label class="mylabel">Description:</label>  
													</div>
													<div class="col-sm-9">	
														<textarea placeholder="Description goes here." name="url_desc" class="form-control url-desc" value="" maxlength="255"></textarea>
													</div>	
												</div>
												<div class="form-group">
													<div class="col-md-3">
														<label class="mylabel">Select Folder:</label>  
													</div>
													<div class="col-sm-6">	
														<select name="url_cat" id="move_to_cat" class="form-control">
															<option value="">Select Category</option>
															<?php
															foreach($categories as $cat){
															echo '<option value="'.$cat['cid'].'">'.$cat['cname'].'</option>';
															}	
															?>
														</select>
													</div>	
													<div class="col-sm-3">
														<a class="text-info" href="#" onclick="load_add_frm('category', 'view_link');"><small>Add New Folder</small></a>
													</div>
												</div>
												<div class="col-sm-7 col-sm-offset-4 text-right">
													<button type="submit" onclick="ShowHideSubmit()" class="btn btn-default linki-btn" id="send_url">Add to my LinkiBag</button>
													<button type="button" onclick="url_clears()" class="btn btn-default linki-btn" id="url_clear">Clear</button>
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

			<div class="modal-content add-new-gp">

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
			
			
		</style>
				
		<?php  }      ?>