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
	$co->page_title = "Shared Links | Linkibag";     
 	$current = $co->getcurrentuser_profile();  	
	$user_profile_info = $co->call_profile($current['uid']);  
	$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');  	    
	$views=true;      	      	
	if(isset($_GET['views']) and $_GET['views']!=''){ 
		$item_per_page = $_GET['views'];      	
	}else{      		
		$item_per_page = 10;      	
	}	      	
	$this_page='p=shared-links';      
	$categories = $co->show_all_category();      
	/*if(isset($_GET['id']) and $_GET['id']!=''){      		
		$this_page='p=dashboard&id='.$_GET['id'];      		
		$urlposts_retrun = $co->get_urlposts_by_category($_GET['id'],$current['uid'],$item_per_page, $this_page);      		
		$urlposts = $urlposts_retrun['row'];      		
		$page_links = $urlposts_retrun['page_links'];      		
		if(count($urlposts)<1)      			
			$no_record_found = "No Record Found";      	
	}else{*/	
	$cid = 0;
	if(isset($_GET['cid']) and $_GET['cid']!='')      		
		$cid = $_GET['cid'];
	
		$urlposts_retrun = $co->get_all_urlposts($current['uid'],$item_per_page, $this_page, $cid);      	
		$urlposts = $urlposts_retrun['row'];
		$data[] = array();
		
		$show_all_category_of_current_user = $co->fetch_all_array("SELECT * FROM `category` WHERE uid=:id",array('id'=>$current['uid']));
	
		$page_links = $urlposts_retrun['page_links'];  
		$page_link_new = $urlposts_retrun['page_link_new'];  
		$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');	
		if(count($urlposts)<1)      			
			$no_record_found = "No Record Found";
	//}      
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
		
		//print_r($urlposts);
		//echo count($urlposts);
		?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
				<div class="col-md-7">      
					<p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Share Links</a></p>    
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
							<?php /*<ul class="nav nav-tabs" role="tablist">         
								<li role="presentation" class="active"><a href="index.php?p=dashboard">My Links</a></li>         
								<li role="presentation"><a href="index.php?p=shared-links">Share Links</a></li>          
								<li class="pull-right">            
									<div class="nav-tabs-filters">              
										<div class="dropdown">                
											<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Views&nbsp;<span class="caret"></span></button>                
											<ul class="dropdown-menu pull-right">                  
												<li><a href="index.php?p=dashboard&views=10">10</a></li>
												<li><a href="index.php?p=dashboard&views=25">25</a></li>                  
												<li><a href="index.php?p=dashboard&views=50">50</a></li>                  
												<li><a href="index.php?p=dashboard&views=100">100</a></li>                  
												<li><a href="index.php?p=dashboard">All</a></li>                
											</ul>             
										</div>             
										<div class="dropdown">              
											<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Filter by Category                 &nbsp;<span class="caret"></span></button>                
											<ul class="dropdown-menu pull-right">                  
												<li><a href="index.php?p=dashboard">All Categories</a></li>                 
											<?php                    
											foreach($categories as $category){
											?>	                  
												<li><a href="index.php?p=dashboard&id=<?=$category['cid']?>"><?=$category['cname']?></a></li>                 
											<?php } ?>    
											</ul>             
										</div>        
									</div>          
								</li>        
							</ul> */?>       
							<!-- Tab panes -->        
							<div class="tab-content"> 
								<form name="dash_form" method="post" id="share_urls_from_dash" action="index.php?p=dashboard&ajax=ajax_submit">
									<input type="hidden" name="form_id" value="multiple_shared">
									<input type="hidden" name="page" value="<?=isset($_GET['page']) ? $_GET['page'] : '1'?>"/>
									<input type="hidden" name="item_per_page" value="<?=$item_per_page?>"/>
									<input type="hidden" name="this_page" value="<?=$this_page?>"/>
									<?=isset($_GET['only_current']) ? '' : '<input type="hidden" name="only_current" value="0"/>'?>
									<?=isset($_GET['cid']) ? '' : '<input type="hidden" name="cid" value="0"/>'?>
									
									<?php
									if(isset($_GET)){											
										foreach($_GET as $k=>$v){	
											echo '<input type="hidden" name="'.$k.'" value="'.$v.'"/>';
										}	
									}		
									?>
										<div class="tab-content-box">
											<div style="margin-bottom: 11px; margin-top: -7px;" class="user-name-dash">
												<div class="row">
													<div class="col-md-6">
														<a class="text-gray" onclick="multiple_load_share_link_form('share');" href="#"> 
														<i class="fa fa-share"></i> Share Selected Links</a>
													</div>
													<div class="col-md-6 text-right">
													<span class="bottom-nav-link">
													<a class="btn btn-default dark-gray-bg" href="index.php?p=linkibags">My Folders</a>
													
													<div class="dropdown border-bg-btn" style="display: inline;">	
														<select style="text-align: left;" name="filter" class="btn btn-default dropdown-toggle filter"  onchange="fiter_with_folder(this.value)">
																<option value="">Select Folder</option>
																<?php
																foreach($show_all_category_of_current_user as $list){
																	$sel = '';
																if(isset($list['cid']) and $list['cid'] == $cid)
														            $sel = ' selected="selected"';
																?>
																<option value="<?=$list['cid']?>"<?=$sel?>>
																 <?=$list['cname']?></option>
																<?php
																}
																?>										
														</select>
													</div>
													</span>
													</div>
												</div>
											</div>
											
												<ul class="head-design table-design">
													<li style="width:32%">
														<?php
														$url_by = '&url_by=asc';
														$arrow_direction = 'fa fa-caret-down';
														if(isset($_GET['url_by']) and $_GET['url_by'] == 'asc'){
															$url_by = '&url_by=desc';
															$arrow_direction = 'fa fa-caret-up';
														}elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'desc'){
															$url_by = '&url_by=asc';
															$arrow_direction = 'fa fa-caret-down';
														}
														$cname = 'Select All';
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
															<div class="btn btn-default dropdown-toggle"><input type="checkbox" name="check" id="checkAll" value=""/>Select All <a href="index.php?p=shared-links<?=$url_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
														</div>	
													</li>
													<li style="width:25%">
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
															<div class="btn btn-default dropdown-toggle">Shared By <a href="index.php?p=shared-links<?=$shared_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
															
														</div>	
													</li>
													<li style="width:28%">
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
															<div class="btn btn-default dropdown-toggle">Message <a href="index.php?p=shared-links<?=$shared_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
															
														</div>	
													</li>
													<li style="width:15%">
														<?php
														$date_by = '&date_by=asc';
															$arrow_direction = 'fa fa-caret-down';
															if(isset($_GET['date_by']) and $_GET['date_by'] == 'asc'){
																$date_by = '&date_by=desc';
																$arrow_direction = 'fa fa-caret-up';
															}elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'desc'){
																$date_by = '&date_by=asc';
																$arrow_direction = 'fa fa-caret-down';
															}
														?>
														<div class="dropdown dropdown-design">
															<div class="btn btn-default dropdown-toggle">Date <a href="index.php?p=shared-links<?=$date_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
															
														</div>	
													</li>
												</ul>
											
											<div class="mail-dashboard">
												
													<table class="border_block table table-design" id="all_records">
														<tbody>
															<?php               
															$i=1;                                
															if(isset($_GET['page'])){         
																$i = ($item_per_page * ($_GET['page']-1))+1;                  
															}                               
															echo $no_record_found;   
															$j = 1;
															foreach($urlposts as $urlpost){	
															
																//$time_ago = $co->time_elapsed_string($urlpost['shared_time']);	        
																//$row_cat = $co->get_single_category($urlpost['url_cat']);           
																//$tatal_comments = $co->count_total_comments($urlpost['shared_url_id']);           
																//$co->url_listing_outout($urlpost, $time_ago, $row_cat, $tatal_comments, $current);            
																$i++; 
																if($j == 1){	
																								
															?>
															
																<tr class="first_row<?=$urlpost['num_of_visits'] > 0 ? ' read' : ' unread'?>" id="url_<?=$urlpost['shared_url_id']?>">
																	<td style="width:32%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="<?=$urlpost['shared_url_id']?>"></span> &nbsp; <a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>"><?=((strlen($urlpost['url_value']) > 42) ? substr($urlpost['url_value'], 0, 42).'...' : $urlpost['url_value'])?></a>
																	
																	<a href="#succs_<?=$urlpost['shared_url_id']?>" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Visit Website"  class="visit-icon"><i class="fa fa-arrow-circle-right"></i></a>
																	
																	<div class="modal fade" id="succs_<?=$urlpost['shared_url_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header modal-header-success">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																	<h4>You are about to leave Linkibag</h4>
																</div>
																<div class="modal-body">
																	<p>You will be visiting:</p>
																	<h5><?=$urlpost['url_value']?></h5>
																	<div class="text-center reduct">  
																	<span class="bottom-nav">					
																		<a class="btn btn-default btn-success" href="<?=$urlpost['url_value']?>" target="_blank">Continue</a>
																		<a class="btn btn-default btn-danger" class="close" data-dismiss="modal" aria-hidden="true">Cancel</a>
																	</span>
																	</div>
																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
																	
																	</td>
																	<td style="width:25%"><?=$urlpost['email_id']?></td>
																	<td style="width:28%"><?=((strlen($urlpost['url_desc']) > 30) ? substr($urlpost['url_desc'], 0, 30).'...' : $urlpost['url_desc'])?></td>
																	<td style="width:15%"><?=date('d/m/Y', $urlpost['shared_time'])?>   <?=date('h:i a', $urlpost['shared_time'])?></td>
											
																</tr>
																<?php
																$j++;
																}else{
																?>
																
																<tr class="second_row<?=$urlpost['num_of_visits'] > 0 ? ' read' : ' unread'?>" id="url_<?=$urlpost['shared_url_id']?>">
																	<td><span><input type="checkbox" name="share_url[]" class="urls_shared" value="<?=$urlpost['shared_url_id']?>"></span> &nbsp; <a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>"><?=((strlen($urlpost['url_value']) > 42) ? substr($urlpost['url_value'], 0, 42).'...' : $urlpost['url_value'])?></a>
																	<a href="#succs_<?=$urlpost['shared_url_id']?>" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Visit Website"  class="visit-icon"><i class="fa fa-arrow-circle-right"></i></a>
																	
													<div class="modal fade" id="succs_<?=$urlpost['shared_url_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header modal-header-success">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																	<h4>You are about to leave Linkibag</h4>
																</div>
																<div class="modal-body">
																	<p>You will be visiting:</p>
																	<h5><?=$urlpost['url_value']?></h5>
																	<div class="text-center reduct">  
																	<span class="bottom-nav">					
																		<a class="btn btn-default btn-success" href="<?=$urlpost['url_value']?>" target="_blank">Continue</a>
																		<a class="btn btn-default btn-danger" class="close" data-dismiss="modal" aria-hidden="true">Cancel</a>
																	</span>
																	</div>
																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
																	
																	</td>
																	<td><?=$urlpost['email_id']?></td>
																	<td><?=((strlen($urlpost['url_desc']) > 30) ? substr($urlpost['url_desc'], 0, 30).'...' : $urlpost['url_desc'])?></td>
																	<td><?=date('d/m/Y', $urlpost['shared_time'])?>   <?=date('h:i a', $urlpost['shared_time'])?></td>
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
												<?php
												if(isset($list_shared_links_by_admin) and count($list_shared_links_by_admin) > 0){
												?>
												<table class="border_block table table-design sponsored-table">
													<tbody>
														<?php 

														foreach($list_shared_links_by_admin as $list_shared_links_by_admn){
															$time_ago = $co->time_elapsed_string($list_shared_links_by_admn['created_time']);	
														?>
															<tr>
																<td style="width:32%"><span><input type="checkbox" name="check" value=""></span> &nbsp; <?=$list_shared_links_by_admn['url_value']?></td>
																<td style="width:25%">Admin</td>
																<td style="width:28%"><?=((isset($list_shared_links_by_admn['url_desc']) and $list_shared_links_by_admn['url_desc'] != '') ? substr($list_shared_links_by_admn['url_desc'] , 0, 20) : 'Sponsored')?>...</td>
																<td style="width:15%"><?=date('d/m/Y', $list_shared_links_by_admn['created_time'])?>   <?=date('h:i:sa', $list_shared_links_by_admn['created_time'])?></td>
															</tr>
															<?php
															}
															?>
													</tbody>
												</table>
												<?php } ?>
											</div>	
										</div>		
								
								
									<div class="bottom-nav-link table-design">                
										<div class="bottom-nav-link-main">
											<div  style="padding: 0px;" class="col-md-5">  
												<a class="btn btn-default dark-gray-bg" href="#" onclick="move_to_category_multiple();">Move to</a>                 
												
												<div class="dropdown border-bg-btn" style="display: inline;">												
												<select style="text-align: left;" name="move" class="move_to_cat_w btn btn-default dropdown-toggle" id="move_to_cat">
													<option value="">Select Folder</option>
													<option value="0">Trash</option>
													<?php
													foreach($show_all_category_of_current_user as $list){
														$sel = '';
														//if(isset($list['cid']) and $list['cid'] == $row['url_cat'])
														//	$sel = ' selected="selected"';
													?>
													  
													  <option value="<?=$list['cid']?>"<?=$sel?>><?=$list['cname']?></option>
													<?php
												}
											?>										
												</select>
												</div>
											</div>
											<div class="col-md-5 text-right">
											
												<a class="btn btn-default dark-gray-bg" href="index.php?p=linkibags">My Folders</a>
												
												<a class="btn btn-default dark-gray-bg" onclick="multiple_load_share_link_form('mark_as_unread');" href="#">Mark as unread</a>                 
												<a class="btn btn-default dark-gray-bg" onclick="multiple_load_share_link_form('mark_as_del');" href="#">Delete</a>                 
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