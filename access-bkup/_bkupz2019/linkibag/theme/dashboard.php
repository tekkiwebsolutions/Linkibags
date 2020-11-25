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
	$co->page_title = "Dashboard | Linkibag";     
 	$current = $co->getcurrentuser_profile();  	
	if(!(isset($_GET['date_by']) or isset($_GET['msg_by']) or isset($_GET['url_by']) or isset($_GET['shared_by'])))
		$_SESSION['list_shared_links_by_admin'] = $co->list_shared_links_by_admin('0');  	    
	
	//$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');  	    
	

	
	$views=true;      	      	
	if(isset($_GET['views']) and $_GET['views']!=''){ 
		$item_per_page = $_GET['views'];      	
	}else{      		
		$item_per_page = 10;      	
	}	      	
	$this_page='p=dashboard';      
	$categories = $co->show_all_category();      
	/*if(isset($_GET['id']) and $_GET['id']!=''){      		
		$this_page='p=dashboard&id='.$_GET['id'];      		
		$urlposts_retrun = $co->get_urlposts_by_category($_GET['id'],$current['uid'],$item_per_page, $this_page);      		
		$urlposts = $urlposts_retrun['row'];      		
		$page_links = $urlposts_retrun['page_links'];      		
		if(count($urlposts)<1)      			
			$no_record_found = "No Record Found";      	
	}else{*/	
	$cid = -2;
	if(isset($_GET['cid']) and $_GET['cid']!='')      		
		$cid = $_GET['cid'];
	
	$only_current = '0';
	if(isset($_GET['only_current']) and $_GET['only_current']!='')      		
		$only_current = 1;
	
	
		$urlposts_retrun = $co->get_all_urlposts($current['uid'],$item_per_page, $this_page, $cid, $only_current);      	
		$urlposts = $urlposts_retrun['row'];
		$total_record = $urlposts_retrun['row_count'];
		
		$data[] = array();
		
		$show_all_category_of_current_user = $co->fetch_all_array("SELECT * FROM `category` WHERE uid=:id",array('id'=>$current['uid']));
		
		$page_links = $urlposts_retrun['page_links'];  
		$page_link_new = $urlposts_retrun['page_link_new'];  
		//$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');	
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
				<div class="col-md-12">      
					<p><a href="index.php">Home</a></p>
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
									<div id="hidden_elements">
										<input type="hidden" name="form_id" value="multiple_shared">
										<input type="hidden" name="page" value="<?=isset($_GET['page']) ? $_GET['page'] : '1'?>"/>
										<input type="hidden" name="item_per_page" value="<?=$item_per_page?>"/>
										<input type="hidden" name="this_page" value="<?=$this_page?>"/>
										<?=isset($_GET['only_current']) ? '' : '<input type="hidden" name="only_current" value="0"/>'?>
										<?=isset($_GET['cid']) ? '' : '<input type="hidden" name="cid" value="0"/>'?>
										
									</div>
									<?php
									if(isset($_GET)){											
										foreach($_GET as $k=>$v){	
											echo '<input type="hidden" name="'.$k.'" value="'.$v.'"/>';
										}	
									}		
									?>
									
										<div class="tab-content-box">
											<div style="display:none;"><?=isset($msg) ? $msg : ''?></div>
											<div style="margin-bottom: 11px;" class="user-name-dash">
												<div class="row">
													<div class="col-md-6">
														<span style="display: inline-block; padding-top: 6px;" class="text-orang" ><img style="vertical-align: text-top;" src="images/orang-icon.png" alt="bag Icon"> Inbag <span class="badge round-red-badge" id="new_linkibag_message"><?=$total_friends_url?></span></span> 
														
														<!-- <a style="margin: 0px 5px;" class="btn button-grey pull-right" onclick="multiple_load_share_link_form('print_pdf');" href="#"><i class="fa fa-print" aria-hidden="true"></i>Print Pdf</a>-->
														
														<a style="margin: 0px 5px;" class="btn button-grey pull-right" href="index.php?p=linkibags">My Folders</a>
														
														<a class="btn button-grey pull-right" onclick="multiple_load_share_link_form('share');" href="#"><i class="fa fa-share-alt" aria-hidden="true"></i> Share</a>
													</div>
													<div class="col-md-6 text-right">
														<div class="input-group dashboard-search">
															<input type="text" class="form-control input-sm" placeholder="Search" onkeypress="handle_not_submit(event);" name="url" id="url" value="<?=isset($_GET['url']) ? $_GET['url'] : ''?>">
															<div class="input-group-btn">
																<button class="btn btn-default btn-sm" type="button" id="url_submit" onclick="search_form();"><i class="fa fa-search"></i></button>
															</div>
														</div>
														
														<span class="bottom-nav-link">
														<a class="btn btn-default dark-gray-bg" href="index.php?p=linkibags">Go to</a>
														
														<div class="dropdown border-bg-btn" style="display: inline;">	
															<select style="text-align: left;" name="filter" class="btn btn-default dropdown-toggle filter"  onchange="fiter_with_folder_dashboard(this.value)">
																	<option value="-2">Inbag</option>
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
														$page = '';
														if(isset($_GET['page']))
															$page = $_GET['page'];
														$url_by = '&url_by=asc';
														$arrow_direction = 'fa fa-caret-down';
														if(isset($_GET['url_by']) and $_GET['url_by'] == 'asc'){
															$url_by = '&url_by=desc';
															$arrow_direction = 'fa fa-caret-up';
														}elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'desc'){
															$url_by = '&url_by=asc';
															$arrow_direction = 'fa fa-caret-down';
														}
														$cname = 'updated';
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
															<div class="btn btn-default dropdown-toggle"><input type="checkbox" name="check" id="checkAll" value=""/>Link <a href="index.php?p=dashboard<?=$url_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
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
															<div class="btn btn-default dropdown-toggle">Shared By <a href="index.php?p=dashboard<?=$shared_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
															
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
															<div class="btn btn-default dropdown-toggle">Message <a href="index.php?p=dashboard<?=$shared_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
															
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
															<div class="btn btn-default dropdown-toggle">Date / Time <a href="index.php?p=dashboard<?=$date_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
															
														</div>	
													</li>
												</ul>
											
											<div class="mail-dashboard">
												   <div class="table table-responsive">
													<table class="border_block table table-design margin-none" id="all_records">
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
																$class_name = '';
																$i++; 
																if($j == 1){
																	$class_name = 'first_row';
																
																$j++;
																}else{
																	$class_name = 'second_row';
																
																$j = 1;
																}
																
																?>
																<tr class="<?=$class_name?> <?=$urlpost['num_of_visits'] > 0 ? ' read' : ' unread'?>" id="url_<?=$urlpost['shared_url_id']?>">
																	<td style="width:32%"><span><input type="checkbox" class="<?=(($urlpost['share_type'] == 1) ? '' : 'urls_shared')?>"<?=(($urlpost['share_type'] == 1) ? ' disabled="disabled"' : '')?> name="share_url[]" value="<?=$urlpost['shared_url_id']?>"></span> &nbsp; <a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>"><?=((strlen($urlpost['url_value']) > 42) ? substr($urlpost['url_value'], 0, 42).'...' : $urlpost['url_value'])?></a>
																	<span class="visit-icon"><a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>"><i class="fa fa-arrow-circle-right text-orange"></i></a></span>
																	<!-- Modal -->
													<div class="modal fade" id="succ_<?=$urlpost['shared_url_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
																	<!-- Modal -->
																	
																	
																	
																	</td>
																	<td style="width:25%"><?=$urlpost['email_id']?></td>
																	<td style="width:28%; text-decoration: underline;"><a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>"><?=((strlen($urlpost['url_desc']) > 30) ? substr($urlpost['url_desc'], 0, 30).'...' : $urlpost['url_desc'])?></a></td>
																	<td style="width:15%"><?=date('d/m/Y', $urlpost['shared_time'])?>   <?=date('h:i a', $urlpost['shared_time'])?></td>
																</tr>
															<?php } ?>
															
														</tbody>
													</table>
													</div>
												<!--
												<nav class="text-center">                
													<ul class="pagination"><?php //$page_links?></ul>              
												</nav>-->
												<?php
												if(isset($_SESSION['list_shared_links_by_admin']) and count($_SESSION['list_shared_links_by_admin']) > 0 ){
													$list_shared_links_by_admin = $_SESSION['list_shared_links_by_admin'];
												?>
												
												<div class="text-right">
												<a style="color: #484848; font-size: 12px;" href="index.php?p=renew">Sponsored <img src="images/cancel.jpg"></a>
												</div>
												

												 <div class="table table-responsive">
												<table class="border_block table table-design sponsored-table margin-none">
													<tbody>
														<?php 

														foreach($list_shared_links_by_admin as $list_shared_links_by_admn){
															$time_ago = $co->time_elapsed_string($list_shared_links_by_admn['created_time']);	
															if (!preg_match("~^(?:f|ht)tps?://~i", $list_shared_links_by_admn['url_value'])) {
																$list_shared_links_by_admn['url_value'] = "http://" . $list_shared_links_by_admn['url_value'];
															}
														?>
															<tr style="position: relative;">
																<td style="width:32%"><!--<span><input type="checkbox" name="check" value=""></span>--> &nbsp; <a target="_blank" href="<?=$list_shared_links_by_admn['url_value']?>"><?=$list_shared_links_by_admn['url_value']?></a></td>
																<td style="width:25%">Sponsored</td>
																<td style="width:28%"><?=((isset($list_shared_links_by_admn['url_desc']) and $list_shared_links_by_admn['url_desc'] != '') ? substr($list_shared_links_by_admn['url_desc'] , 0, 20) : 'Sponsored')?>...</td>
																<td style="width:15%" class="text-right"><?=date('d/m/Y', $list_shared_links_by_admn['created_time'])?>   <?=date('h:ia', $list_shared_links_by_admn['created_time'])?>
																</td>
															</tr>
															<?php
															}
															?>
													</tbody>
												</table>
												</div>
												<div class="text-right"><small>Page <?=isset($_GET['page']) ? $_GET['page'] : 1?> of <?=(ceil($total_record / $item_per_page))?></small></div>
												<?php 
												//unset($_SESSION['list_shared_links_by_admin']);
												} 
												?>
											</div>	
										</div>		
								
								
									<div class="bottom-nav-link table-design">                
										<div class="bottom-nav-link-main">
											<div  style="padding: 0px;" class="col-md-5">  
												<a class="btn btn-default dark-gray-bg" href="#" onclick="move_to_category_multiple('#share_urls_from_dash');">Move to</a>                 
								
												<div class="dropdown border-bg-btn" style="display: inline;">												
												<select style="text-align: left;" name="move" class="move_to_cat_w btn btn-default dropdown-toggle" id="move_to_cat">
													<option value="-2">Inbag</option>
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
												<a class="btn btn-default dark-gray-bg" onclick="multiple_load_share_link_form('mark_as_unread');" href="#">Unread</a>
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
.bread-crumb p, .bread-crumb p a {
    color: #acacac;
    font-size: 12px;
}
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

<script>
function handle_not_submit(e){
	if(e.keyCode === 13){
		e.preventDefault(); // Ensure it is only this code that rusn

		//alert("Enter was pressed was presses");
	}
}



function search_form(){
	$("#share_urls_from_dash").removeAttr('method');
	$('#share_urls_from_dash').attr('method', 'GET');
	$('#hidden_elements').html('');
	$("#share_urls_from_dash").submit();
}



</script>		
					
		<?php  }      ?>