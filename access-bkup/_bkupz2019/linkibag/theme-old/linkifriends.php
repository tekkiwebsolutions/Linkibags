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
	$co->page_title = "Friends | Linkibag";     
 	$current = $co->getcurrentuser_profile(); 
	$item_per_page = 10; 	
	$this_page='p=linkifriends'; 
	$fgroup = 'no';
	if(isset($_GET['gid']))
		$fgroup = $_GET['gid'];
	$lists_of_all_friend = $co->list_all_friends_of_current_user($current['uid'], 'all', $item_per_page, $this_page, $fgroup);
	
	$show_all_gps_of_current_user = $co->fetch_all_array("SELECT * FROM `groups` WHERE uid=:id",array('id'=>$current['uid'])); 
	
	$lists_of_all_friends = $lists_of_all_friend['row'];  
	$page_link_new = $lists_of_all_friend['page_link_new'];  
	
		if(count($lists_of_all_friends)<1)      			
			$no_record_found = "No Record Found";
      
		$total_urls = $co->users_count_url($current['uid']);  	
		$total_friends = $co->users_count_friend($current['uid']);  	
		$total_friends_url = $co->users_count_shared_url($current['uid']);   
		
		?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
				<div class="col-md-7">      
					<p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Friends</a></p>    
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
						<div>        
							      
							<!-- Tab panes -->        
							<div class="tab-content"> 
								<form name="dash_form" method="post" id="share_urls_from_dash" action="index.php?p=dashboard&ajax=ajax_submit">
									<input type="hidden" name="form_id" value="multiple_shared">
										<div class="tab-content-box">
											
											
											<div style="margin-bottom: 11px; margin-top: -7px;" class="user-name-dash">
												<div class="row">
													<div class="col-md-6">
													
														<div class="search-user">
															<div class="input-group">
																<div class="input-group-btn">
																	<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
																</div>
																<h3 class="f_title"><a class="frnd_srch" href="index.php?p=search_friends" data-toggle="tooltip" data-placement="top" title="Search for friends on LinkiBag database">Find Friends</a></h3>
															</div>
														</div>
													
													</div>
													<div class="col-md-6 text-right">
														<div class="bottom-nav-link top-nav-link">
														<a class="btn btn-default dark-gray-bg" href="index.php?p=mylinkifriends">My Groups</a>
														<div class="dropdown border-bg-btn" style="display: inline;">
														<select style="text-align: left;" name="filter" class="move_to_cat_w btn btn-default dropdown-toggle" onchange="fiter_with_group(this.value)">
															<option value="">Select Group</option>
															
															<?php
															foreach($show_all_gps_of_current_user as $list){
																$sel = '';
																if(isset($list['group_id']) and $list['group_id'] == $fgroup)
																$sel = ' selected="selected"';
															?>
															  
															  <option value="<?=$list['group_id']?>"<?=$sel?>><?=$list['group_name']?></option>
															<?php
														}
														?>										
														</select>
														</div>
														</div>
													</div>
												</div>
											</div>
											
											
											<ul class="head-design table-design">
													<li style="width:60%">
														<?php
														$url_by = '&url_by=asc';
														$arrow_direction = 'fa fa-caret-down';
														if(isset($_GET['url_by']) and $_GET['url_by'] == 'asc'){
															$shared_by = '&url_by=desc';
															$arrow_direction = 'fa fa-caret-up';
														}elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'desc'){
															$shared_by = '&url_by=asc';
															$arrow_direction = 'fa fa-caret-down';
														}
														$cname = 'inbox';
														if(isset($_GET['cid'])){
															if($_GET['cid'] == 0 and $_GET['trash'] == 1){
																$cname = 'Trash';
															}else if($_GET['cid'] > 0){
																$cat_info = $co->query_first("SELECT cname FROM `category` WHERE cid=:id",array('id'=>$_GET['cid']));
																$cname = $cat_info['cname'];
															}	
														}	
														?>
														<div class="dropdown dropdown-design">
															<div class="btn btn-default dropdown-toggle"><input type="checkbox" name="check" id="checkAll" value=""/>Select All</div>
														</div>	
													</li>
													<li style="width:20%">
													<?php
													$shared_by = '&shared_by=asc';
														$arrow_direction = 'fa fa-caret-down';
														if(isset($_GET['shared_by']) and $_GET['shared_by'] == 'asc'){
															$shared_by = '&shared_by=desc';
															$arrow_direction = 'fa fa-caret-up';
														}elseif(isset($_GET['shared_by']) and $_GET['shared_by'] == 'desc'){
															$shared_by = '&shared_by=asc';
															$arrow_direction = 'fa fa-caret-down';
														}
													?>
														<div class="dropdown dropdown-design">
															<div class="btn btn-default dropdown-toggle">Profile Details <a href="index.php?p=linkifriends#"></a></div>
															
														</div>	
													</li>
													<li style="width:20%">
														<?php
														$shared_by = '&msg_by=asc';
														$arrow_direction = 'fa fa-caret-down';
														if(isset($_GET['msg_by']) and $_GET['msg_by'] == 'asc'){
															$shared_by = '&msg_by=desc';
															$arrow_direction = 'fa fa-caret-up';
														}elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'desc'){
															$shared_by = '&msg_by=asc';
															$arrow_direction = 'fa fa-caret-down';
														}	
														?>
														<div class="dropdown dropdown-design">
															<div class="btn btn-default dropdown-toggle">Friends Since</div>
															
														</div>	
													</li>
													
												</ul>
											
											<div class="mail-dashboard">
												
													<table class="border_block table table-design">
														<tbody>
															<?php               
															$i=1;                                
															if(isset($_GET['page'])){         
																$i = ($item_per_page * ($_GET['page']-1))+1;                  
															}                               
															echo $no_record_found;   
															$j = 1;
															
															foreach($lists_of_all_friends as $list){	
																
																$i++; 
																if($j == 1){	
																								
															?>
															
																<tr class="first_row<?=$list['status'] > 0 ? ' read' : ' unread'?>" id="url_<?=$list['friend_id']?>">
																	<td style="width:60%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="<?=$list['friend_id']?>"></span> &nbsp; <a href="#"><?=(($list['request_to']>0) ? $list['email_id'] : $list['request_email'])?></a></td>
																	<td style="width:20%">
																	<?php
																	if($list['request_to']>0){
																	?>
																		<a href="#success_<?=$list['friend_id']?>" data-toggle="modal">View Profile</a>
																	<?php
																	}else{
																		echo '&nbsp;';
																	}
																	?>
																	<!-- Modal -->
																	<div class="modal fade" id="success_<?=$list['friend_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																		<div class="modal-dialog modal-sm">
																			<div class="modal-content">
																				<div class="modal-header modal-header-success">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																					<h4>Profile Info</h4>
																				</div>
																				<div class="modal-body">
																					<h4><?=$list['first_name']?> &nbsp; <?=$list['last_name']?></h4>
																					<p><i class="fa fa-fw fa-envelope"></i> <strong>Email</strong> : <?=$list['email_id']?></p>
																					<p><i class="fa fa-fw fa-clock-o"></i> <strong>Joined</strong> : <?=date('Y-m-d', $list['created'])?></p>
																				</div>
																			</div><!-- /.modal-content -->
																		</div><!-- /.modal-dialog -->
																	</div><!-- /.modal -->
																	<!-- Modal -->
																																	
																	
																	</td>
																	<td style="width:20%"><?=$list['date']?></td>
																	
																</tr>
																<?php
																$j++;
																}else{
																?>
																<tr class="second_row<?=$list['status'] > 0 ? ' read' : ' unread'?>" id="url_<?=$list['friend_id']?>">
																	<td style="width:60%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="<?=$list['friend_id']?>"></span> &nbsp; <a href="#"><?=(($list['request_to']>0) ? $list['email_id'] : $list['request_email'])?></a></td>
																	<td style="width:20%">
																	<?php
																	if($list['request_to']>0){
																	?>
																		<a href="#success_<?=$list['friend_id']?>" data-toggle="modal">View Profile</a>
																	<?php
																	}else{
																		echo '&nbsp;';
																	}
																	?>
																	
																	
																	<!-- Modal -->
																	<div class="modal fade" id="success_<?=$list['friend_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																		<div class="modal-dialog modal-sm">
																			<div class="modal-content">
																				<div class="modal-header modal-header-success">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																					<h4>Profile Info</h4>
																				</div>
																				<div class="modal-body">
																					<h4><?=$list['first_name']?> &nbsp; <?=$list['last_name']?></h4>
																					<p><i class="fa fa-fw fa-envelope"></i> <strong>Email</strong> : <?=$list['email_id']?></p>
																					<p><i class="fa fa-fw fa-clock-o"></i> <strong>Joined</strong> : <?=date('Y-m-d', $list['created'])?></p>
																				</div>
																			</div><!-- /.modal-content -->
																		</div><!-- /.modal-dialog -->
																	</div><!-- /.modal -->
																	<!-- Modal -->
																	
																	</td>
																	<td style="width:20%"><?=$list['date']?></td>
																</tr>
																<?php
																$j = 1;
																}
															}	
																?>
																
														</tbody>
													</table>
												<!--
												<nav class="text-center">                
													<ul class="pagination"><?php //$page_links?></ul>              
												</nav>-->
												
											</div>	
										</div>		
								
								
									<div class="bottom-nav-link table-design">                
										<div class="bottom-nav-link-main">
											<div  style="padding: 0px;" class="col-md-5">  
												<a class="btn btn-default dark-gray-bg" href="#" onclick="move_to_category_multiple('#share_urls_from_dash','group');">Move to</a>                 
												
												<div class="dropdown border-bg-btn" style="display: inline;">
														
												<select style="text-align: left;" name="move" class="move_to_cat_w btn btn-default dropdown-toggle" id="move_to_cat">
													<option value="">Select Group</option>
													<option value="0">Ungrouped</option>
													<?php
													foreach($show_all_gps_of_current_user as $list){
														$sel = '';
														//if(isset($list['cid']) and $list['cid'] == $row['url_cat'])
														//	$sel = ' selected="selected"';
													?>
													  
													  <option value="<?=$list['group_id']?>"<?=$sel?>><?=$list['group_name']?></option>
													<?php
												}
											?>										
												</select>
												</div>
											</div>
											<div class="col-md-5 text-right">  										
												<a class="btn btn-default dark-gray-bg" href="index.php?p=mylinkifriends">My Groups</a>
												
												<a class="btn btn-default dark-gray-bg" onclick="move_to_category_multiple('#share_urls_from_dash','group','1');" href="#">Unfriend</a>                 
												                 
											</div>	
											
											<div style="width: auto; margin: 0px ! important;" class="col-md-3 pull-right">  										
												<?=$page_link_new?>                 
											</div>	
										</div>
									</div>
								</form>
							</div> 
							
									
						</div>    
					</div>    
					  
				</div>
			</div>	
		</section>
		<style>
.share-btns .btn-default {
    background: #c3c3c3 none repeat scroll 0 0;
    color: #3a3a3a;
}
.share-btns {
    display: inline-block;
    margin: 11px 0;
    width: 100%;
}
.share-btns .btn-primary {
    background: #597794 none repeat scroll 0 0;
}
.share-btns .btn {
    border: medium none;
    border-radius: 0;
}
</style>

		
					
		<?php  }      ?>