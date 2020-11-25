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
	$co->page_title = "LinkiFriends | Linkibag";     
 	$current = $co->getcurrentuser_profile();  	
	$user_profile_info = $co->call_profile($current['uid']);  
	
	    		
	$item_per_page = 10;      	
	      	
	$this_page='p=mylinkifriends';      
	$fgroup = 0;
	if(isset($_GET['gid']) and $_GET['gid'] > 0)
		$fgroup = $_GET['gid'];
	
	//$lists_of_all_friends = $co->list_all_friends_of_current_user($current['uid'],1, $item_per_page, $this_page, $fgroup);	
	$groups_retrun = $co->get_all_groups_of_current_user($current['uid'],$item_per_page, $this_page);      	
	$groups = $groups_retrun['row'];      		
	$page_links = $groups_retrun['page_links'];  
	//$total_pages = $groups_retrun['paging2'];  
	$page_link_new = $groups_retrun['page_link_new'];
	     
	$total_urls = $co->users_count_url($current['uid']);  	
	$total_friends = $co->users_count_friend($current['uid']);  	
	$total_friends_url = $co->users_count_shared_url($current['uid']);      
		
		?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
				<div class="col-md-7">      
					<p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Groups</a></p>    
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
						<div style="margin-top: 36px;" class="folder-dash-main">        
							       
							<!-- Tab panes -->        
							<div class="tab-content"> 
								<form method="post" class="form-horizontal" id="manage_groups_and_cat_form" action="index.php?p=linkifriends&ajax=ajax_submit" onsubmit="javascript: return false;">
									<input type="hidden" name="page" value="<?=isset($_GET['page']) ? $_GET['page'] : '1'?>"/>
									<input type="hidden" name="item_per_page" value="<?=$item_per_page?>"/>
									<input type="hidden" name="this_page" value="<?=$this_page?>"/>
										<div class="tab-content-box">
											<ul class="head-design table-design folder-dash-filters">
												<li style="width:70%">
													<div class="dropdown dropdown-design">
													<!--<div class="btn btn-default dropdown-toggle"><input type="checkbox" value="" id="checkAll" name="check"> Groups <a href="#"><i class="fa fa-caret-down"></i></a></div>-->
													<div class="btn btn-default dropdown-toggle"><input type="checkbox" value="" id="checkAll" name="check"> Select All <a href="#"></a></div>
													</div>	
												</li>
												<li style="width:15%">
													<div class="dropdown dropdown-design">
													<div style="padding-left:0px;" class="btn btn-default dropdown-toggle text-center">Confirmed <a href="#"><i class="fa fa-caret-down"></i></a></div>
													</div>	
												</li>
												<li style="width:15%">
													<div class="dropdown dropdown-design">
													<div class="btn btn-default dropdown-toggle text-center">Total <a href="#"><i class="fa fa-caret-down"></i></a></div>
													</div>	
												</li>
											</ul>
											
											<div class="mail-dashboard folder-dash-data">
												<table class="border_block table table-design" id="all_records">
													<tbody>
													<?php
														$total_confirm_friends_in_gp = $co->query_first("select COUNT(friend_id) as total from user_friends where uid=:uid and fgroup=:group and status=1",array('group'=>0,'uid'=>$current['uid'])); 
														$total_friends_in_gp = $co->query_first("select COUNT(friend_id) as total from user_friends where uid=:uid and fgroup=0",array('uid'=>$current['uid'])); 
														
														$empty_link = 'empty_links2(0,1);';	
														if($total_friends_in_gp['total'] == 0)
															$empty_link= "error_dialogues('There is no links in this group')";
													?>
														<tr class="second_row text-bold" id="record_0">
															<td style="width:50%"><span><input type="checkbox" value="0" disabled name="groups[]"></span> &nbsp; <a href="index.php?p=linkifriends&gid=0">Ungrouped</a> <span>&nbsp; </span></td>
															<td style="width:20%"><a class="btn btn-sm" href="#" onclick="<?=$empty_link?>" disabled>Empty</a></td>
															<td class="text-center un-bold" style="width:15%"><?=$total_confirm_friends_in_gp['total']?></td>
															<td class="text-center un-bold" style="width:15%" id="empty_0"><?=$total_friends_in_gp['total']?></td>
														</tr>
														
													<?php               
															$i=1;                                
															if(isset($_GET['page'])){         
																$i = ($item_per_page * ($_GET['page']-1))+1;                  
															}                               
															echo $no_record_found;   
															$j = 1;
															//print_r($groups);
															foreach($groups as $group){																
																$time_ago = $co->time_elapsed_string($group['created']);
																
																$empty_link = 'empty_links('.$group['group_id'].',0,\'group\');';	
																if($group['confirmed'] == 0)
																	$empty_link= "error_dialogues('There is no friends in this group')";				
																		
																
																$i++; 
																if($j == 1){	
													?>			
													
														<tr class="first_row" id="record_<?=$group['group_id']?>">
															<td style="width:50%"><span><input type="checkbox" class="grouping" value="<?=$group['group_id']?>" name="groups[]"></span> &nbsp; <a href="index.php?p=linkifriends&gid=<?=$group['group_id']?>"><?=$group['group_name']?></a> <span>&nbsp; <a href="#" onclick="load_edit_frm('<?=$group['group_id']?>', 'group')"><i class="fa fa-pencil"></i></a></span></td>
															<td style="width:20%"><a class="btn btn-sm" href="#" onclick="<?=$empty_link?>">Empty</a></td>
															<td class="text-center un-bold" style="width:15%" id="empty_<?=$group['group_id']?>"><?=$group['confirmed']?></td>
															<td class="text-center un-bold" style="width:15%"><?=$group['total_friend']?></td>
														</tr>
														<?php
																$j++;
																}else{
																?>
														<tr class="second_row text-bold" id="record_<?=$group['group_id']?>">
															<td style="width:50%"><span><input type="checkbox" class="grouping" value="<?=$group['group_id']?>" name="groups[]"></span> &nbsp; <a href="index.php?p=linkifriends&gid=<?=$group['group_id']?>"><?=$group['group_name']?></a><span>&nbsp; <a href="#" onclick="load_edit_frm('<?=$group['group_id']?>', 'group')"><i class="fa fa-pencil"></i></a></span></td>
															<td style="width:20%"><a class="btn btn-sm" href="#" onclick="<?=$empty_link?>">Empty</a></td>
															<td class="text-center un-bold" style="width:15%" id="empty_<?=$group['group_id']?>"><?=$group['confirmed']?></td>
															<td class="text-center un-bold" style="width:15%"><?=$group['total_friend']?></td>
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
									<a class="btn btn-info green-bg" href="#" onclick="load_add_frm('group','0')">Add New Group</a>
									<a class="btn btn-info dark-gray-bg" href="#" onclick="del_new_group('group');">Delete</a>
									</div>
									<div style="width: auto; margin: 0px ! important;" class="col-md-3 pull-right">  										
										<?=$page_link_new?>                 
									</div>	
								</div>
							</div>
									
						</div>
					</div>    
					  
				</div>
			</div>	
		</section>
		
		
		<a class="btn btn-info green-bg" href="#" data-toggle="modal" data-target="#add_groups_and_cat" id="add_new_folder" style="display:none;">Add New Folder</a>
		<div class="modal fade" id="add_groups_and_cat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

		  <div class="modal-dialog modal-sm">

			<div class="modal-content">

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
			jQuery('.modal-header').html('<h4>Add New Group </h4><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>');
			
		});
		</script>
				
		<?php  }      ?>