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
	$co->page_title = "Linkibags | Linkibag";     
 	$current = $co->getcurrentuser_profile();  	
	//$user_profile_info = $co->call_profile($current['uid']);  
	//$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');  	    
	
	$item_per_page = 10;      	
		      	
	$this_page='p=linkibags';      
	$categories_list = $co->show_all_category_of_current_user($current['uid'],$item_per_page,$this_page);      	
	$categories = $categories_list['row'];      		
	$page_links = $categories_list['page_links'];  
	//$total_pages = $categories_list['paging2'];
	$page_link_new = $categories_list['page_link_new'];	
	$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');	
	 
			
	$total_urls = $co->users_count_url($current['uid']);  	
	$total_friends = $co->users_count_friend($current['uid']);  	
	$total_friends_url = $co->users_count_shared_url($current['uid']);      
		//print_r($urlposts);
		//echo count($urlposts);
		?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
				<div class="col-md-7">      
					<p><a href="index.php">My Account</a><a href="index.php?p=dashboard"> > Folders</a></p>    
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
						<?php include('dashboard_sidebar.php'); ?>  
					</div>	
					<div class="containt-area-dash col-md-9">      
						<div class="folder-dash-main">        
							       
							<!-- Tab panes -->        
							<div class="tab-content"> 
								<form method="post" class="form-horizontal" id="manage_groups_and_cat_form" action="index.php?p=linkibags&ajax=ajax_submit" onsubmit="javascript: return false;">
									<input type="hidden" name="page" value="<?=isset($_GET['page']) ? $_GET['page'] : '1'?>"/>
									<input type="hidden" name="item_per_page" value="<?=$item_per_page?>"/>
									<input type="hidden" name="this_page" value="<?=$this_page?>"/>
									
										<div class="tab-content-box">
											<div class="row top-folder-header">
												<div class="col-md-12 text-right folder-header-right">
													<a class="btn btn-info dark-gray-bg" href="#" href="#" onclick="load_add_frm('category','0')">Add New Folder</a>
												</div>
											</div>
											<ul style="border-color: #ff7f27;" class="head-design table-design folder-dash-filters">
												<li style="width:80%">
													<div class="dropdown dropdown-design">
													<div class="btn btn-default dropdown-toggle"><input type="checkbox" value="" id="checkAll" name="check"> Select All </div>
													</div>	
												</li>
												
												<li style="width:20%">
													<div class="dropdown dropdown-design">
													<div class="btn btn-default dropdown-toggle text-center">Total <a href="#"><i class="fa fa-caret-down"></i></a></div>
													</div>	
												</li>
											</ul>
											
											<div class="mail-dashboard folder-dash-data">
												<table class="border_block table table-design" id="all_records">
													<tbody>
													<?php
													$total_url_in_cat = $co->query_first("select COUNT(url_id) as total from user_shared_urls where url_cat=:cat and shared_to=:uid",array('cat'=>0,'uid'=>$current['uid'])); 
													$empty_link = 'empty_links(0,1);';	
													if($total_url_in_cat['total'] == 0)
														$empty_link= "error_dialogues('There is no links in this category')";
													?>
														<tr class="second_row text-bold" id="record_0">
															<td style="width:62%"><span><input type="checkbox" disabled value="0" id="trash" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid=0&trash=1">Trash</a> <span>&nbsp; </span></td>
															<td style="width:10%"><a class="btn btn-sm" href="#" onclick="<?=$empty_link?>">Empty</a></td>
															
															<td class="text-center un-bold" style="width:20%" id="empty_0"><?=$total_url_in_cat['total']?></td>
														</tr>
													
													<?php               
															$i=1;                                
															if(isset($_GET['page'])){         
																$i = ($item_per_page * ($_GET['page']-1))+1;                  
															}                               
															echo $no_record_found;   
															$j = 1;
															foreach($categories as $category){ 
																$total_url_in_cat = $co->query_first("select COUNT(url_id) as total from user_shared_urls where url_cat=:cat and shared_to=:uid",array('cat'=>$category['cid'],'uid'=>$current['uid'])); 
																$time_ago = $co->time_elapsed_string($category['created_time']);	        
																
																$empty_link = 'empty_links('.$category['cid'].',0);';	
																if($total_url_in_cat['total'] == 0)
																	$empty_link= "error_dialogues('There is no links in this category')";				
																	
																
																	
																
																$i++;
																	
																if($j == 1){
																
													?>			
													
														
														<tr class="first_row" id="record_<?=$category['cid']?>">
															<td style="width:62%"><span><input type="checkbox" class="grouping" value="<?=$category['cid']?>" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid=<?=$category['cid']?>"><?=$category['cname']?></a> <span>&nbsp; <a href="#" onclick="load_edit_frm('<?=$category['cid']?>', 'category')"><i class="fa fa-pencil"></i></a></span></td>
															<td style="width:10%"><a class="btn btn-sm" href="#" onclick="<?=$empty_link?>">Empty</a></td>
															
															<td class="text-center" style="width:20%" id="empty_<?=$category['cid']?>"><?=$total_url_in_cat['total']?></td>
														</tr>
														<?php
																$j++;
																}else{
																?>
														<tr class="second_row text-bold" id="record_<?=$category['cid']?>">
															<td style="width:62%"><span><input type="checkbox" class="grouping" value="<?=$category['cid']?>" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid=<?=$category['cid']?>"><?=$category['cname']?></a> <span>&nbsp; <a href="#" onclick="load_edit_frm('<?=$category['cid']?>', 'category')"><i class="fa fa-pencil"></i></a></span></td>
															<td style="width:10%"><a class="btn btn-sm" href="#" onclick="<?=$empty_link?>">Empty</a></td>
															
															<td class="text-center un-bold" style="width:20%" id="empty_<?=$category['cid']?>"><?=$total_url_in_cat['total']?></td>
														</tr>
														<?php
																$j = 1;
																}
															}	
																?>
														
													</tbody>
												</table>
											</div>	
										</div>		
								</form>
							</div> 
							
							<div class="bottom-nav-link table-design">                
								<div class="bottom-nav-link-main">
									<div style="width: auto; margin: 0px ! important;" class="col-md-9">
										<a class="btn btn-info dark-gray-bg" href="#" onclick="del_new_group('category');">Delete</a>
									</div>
									<div style="width: auto; margin: 0px ! important;" class="col-md-3 pull-right" id="paging_links_bottom">  										
										<?=$page_link_new?>                
									</div>	
								</div>
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
		
		<a class="btn btn-info green-bg" href="#" data-toggle="modal" data-target="#edit_groups_and_cat" id="edit_new_folder" style="display:none;">Edit New Folder</a>
		<div class="modal fade" id="edit_groups_and_cat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

		  <div class="modal-dialog modal-sm">

			<div class="modal-content">

				<div class="modal-header">

					<h4>Edit Folder </h4>

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
			
			
		</style>
		<script>
		
		jQuery('#share-link-button').click(function () {
			jQuery('#add_group_and_cat_form').css('display','block');
			jQuery('.modal-header').html('<h4>Add New Category </h4><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>');
			
		});
		</script>
				
		<?php  }      ?>