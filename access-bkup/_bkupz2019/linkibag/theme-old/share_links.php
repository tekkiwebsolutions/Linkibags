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
	$co->page_title = "Share | Linkibag";     
 	$current = $co->getcurrentuser_profile();  	
	$user_profile_info = $co->call_profile($current['uid']);  
	$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');  	    
	$show_all_category_of_current_user = $co->fetch_all_array("SELECT * FROM `category` WHERE uid=:id",array('id'=>$current['uid']));  		
	$item_per_page = 10;      	
	      	
	$this_page='p=share_links';      
	$categories = $co->show_all_category();      
	
	$urls_body = '';
	$arr = '';
	if(isset($_GET['url']) and count($_GET['url'])>0){
		foreach($_GET['url'] as $share_urls){
			$urlpost = $co->query_first("SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,us.*  FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id and us.shared_url_id=:urlid",array('id'=>$current['uid'],'urlid'=>$share_urls));
			$arr .= '<input type="hidden" name="urls[]" value="'.$urlpost['shared_url_id'].'"/>' ; 
			$parsed = parse_url($urlpost['url_value']);
			if (empty($parsed['scheme'])) {
				$urlpost['url_value'] = 'http://' . ltrim($urlpost['url_value'], '/');
			}
			$urls_body .= '<tr class="first_row unread" id=url_"'.$urlpost['shared_url_id'].'">
								<td> &nbsp; <a href="index.php?p=view_link&id='.$urlpost['shared_url_id'].'" target="_blank">'.((strlen($urlpost['url_value']) > 20) ? substr($urlpost['url_value'], 0, 20).'...' : $urlpost['url_value']).'</a></td>
								<td><a href="'.$urlpost['url_value'].'" target="_blank">Visit Link</a></td>								
						</tr>
			
			
					';
	
		}
	}	
	$lists_of_all_friend = $co->list_all_friends_of_current_user($current['uid'],1, $item_per_page, $this_page, 'no');
	
	
	$lists_of_all_friends = $lists_of_all_friend['row'];  
	$page_link_new = $lists_of_all_friend['page_link_new'];  
		      	
		  	
		$total_urls = $co->users_count_url($current['uid']);  	
		$total_friends = $co->users_count_friend($current['uid']);  	
		$total_friends_url = $co->users_count_shared_url($current['uid']);   
		
		//print_r($urlposts);
		//echo count($urlposts);
		?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
				<div class="col-md-7">      
					<p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Share Links</a></p>    
				</div> 
				<div class="col-md-5 text-right">
		
				</div>
			</div>  
			<div class="containt-area" id="dashboard_new">  
				<div class="container"> 
					<div class="col-md-3">      
						<?php include('dashboard_sidebar.php'); ?>    
					</div>	
					<div class="containt-area-dash col-md-9">      
						<div>        
							       
							<div class="tab-content"> 
								<form onsubmit="javascript: return share_links_new(1);" action="index.php?p=dashboard&amp;ajax=ajax_submit" id="share_form_1" class="form-horizontal edit_url_form-design" method="post">
									<div id="url-shared-messages-out_1"></div>
									<input type="hidden" value="share_links" name="form_id">
										<div class="tab-content-box">
											<div style="margin-bottom: 11px; margin-top: -7px;" class="user-name-dash">
												<div class="row">
													<div class="col-md-6"><b style="float: left; padding: 4px 0px 0px;">Welcome <?=$current['first_name']?> <?=$current['last_name']?></b></div>
													<div class="col-md-6 text-right"><span class="bottom-nav-link"><button type="submit" id="send_share_link_1" class="btn btn-default orang-bg "><i class="fa fa-share"></i> Share</button></span></div>
												</div>
											</div>
											
											<div class="mail-dashboard">
												
													<table class="border_block table table-design">
													<?=$arr?>
														<tbody>
															<?=$urls_body?>
																
														</tbody>
													</table>
												<!--
												<nav class="text-center">                
													<ul class="pagination"><?php //$page_links?></ul>              
												</nav>-->
												
											</div>
											
												<ul class="head-design table-design">
													<li style="width:40%">
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
														<div class="dropdown dropdown-design message">
															<div class="btn btn-default dropdown-toggle"><input type="checkbox" name="check" id="checkAll" value=""/>Select All</div>
														</div>	
													</li>
													<li style="width:40%">
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
															<div class="btn btn-default dropdown-toggle" style="padding-left:0px;">Profile Details</div>
															
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
															<div class="btn btn-default dropdown-toggle">Last time contacted</div>
															
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
															
																//$time_ago = $co->time_elapsed_string($urlpost['shared_time']);	        
																//$row_cat = $co->get_single_category($urlpost['url_cat']);           
																//$tatal_comments = $co->count_total_comments($urlpost['shared_url_id']);           
																//$co->url_listing_outout($urlpost, $time_ago, $row_cat, $tatal_comments, $current);            
																$i++; 
																if($j == 1){	
																								
															?>
															
																<tr class="first_row<?=$list['uid'] > 0 ? ' read' : ' unread'?>" id="url_<?=$list['uid']?>">
																	<td style="width:30%"><span><input type="checkbox" class="urls_shared" name="shared_user[]" value="<?=$list['fid']?>"></span> &nbsp; <a href="index.php?p=view_link&id=<?=$list['uid']?>"><?=$list['email_id']?></a></td>
																	<td style="width:40%"><a href="#success_<?=$list['friend_id']?>" data-toggle="modal">View Profile</a>
																	
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
																					<p><i class="fa fa-fw fa-clock-o"></i> <strong>Joining</strong> : <?=date('Y-m-d', $list['created'])?></p>
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
																<tr class="second_row<?=$list['uid'] > 0 ? ' read' : ' unread'?>" id="url_<?=$list['uid']?>">
																	<td style="width:40%"><span><input type="checkbox" class="urls_shared" name="shared_user[]" value="<?=$list['fid']?>"></span> &nbsp; <a href="index.php?p=view_link&id=<?=$list['uid']?>"><?=$list['email_id']?></a></td>
																	<td style="width:40%"><a href="#success_<?=$list['friend_id']?>" data-toggle="modal">View Profile</a>
																	
																	
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
																					<p><i class="fa fa-fw fa-clock-o"></i> <strong>Joining</strong> : <?=date('Y-m-d', $list['created'])?></p>
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