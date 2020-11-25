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
	$co->page_title = "Find Urls | Linkibag";     
 	$current = $co->getcurrentuser_profile();
	if(!($current['role'] == 2 OR $current['role'] == 3))
		exit();
  	
	$item_per_page = 10;      	
	      	
	$this_page='p=search-urls';      

	$total_urls = $co->users_count_url($current['uid']);  	
	$total_friends = $co->users_count_friend($current['uid']);  	
	$total_friends_url = $co->users_count_shared_url($current['uid']); 
	
	if(isset($_GET['search_url']) and $_GET['url'] != ''){
		if(!isset($_POST['subs_account_type'])){
			$co->setmessage("error", "Please choose account type");
			$success=false;
		}
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
	      
		if(isset($_GET['views']) and $_GET['views']!=''){
			$this_page .= '&views='.$_GET['views'];      	
		}      			
	}	

	
		
		?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
				<div class="col-md-7">      
					<p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Find Any URLs</a></p>    
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
										<div class="tab-content-box">
											<div class="search-user">
															<div class="input-group">
																<div class="input-group-btn">
																	<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
																</div>
																<h3 class="f_title">Find Any URLs</h3>
															</div>
														</div>
											<?php
											if(isset($_GET['url']) and trim($_GET['url'])==''){
												echo '<div class="alert alert-danger"><p>Please enter atleast one word to search our database.</p></div>';
											}
											?>
											<div class="mail-dashboard folder-dash-data" id="search_friends">
												<div id="all_records" class="search_friends_main">
													<h3 class="light-green-color">Keyword Search</h3>
													<form class="sign_up_page_form" method="get" id="register_form" action="">
														<input type="hidden" name="p" value="search-urls">
													   <div class="col-md-12 text-left wow fadeInUp templatemo-box">
															<div class="row">
																 <div class="personal_account_register">
																	<div class="form-group">
																		<div class="col-md-4 pad-sm"><label class="mylabel">Search database of LinkiBag URLs</label></div>
																	   
																		<div style="padding: 0px 7px;" class="col-md-4"><input placeholder="URL Address" type="text" name="url" class="form-control" id="url" value="<?=((isset($_GET['url']) and $_GET['url']!='') ? $_GET['url'] : '')?>" />
																		</div>
																		<div class="col-md-4">            
																			<button type="submit" class="orange-btn green-bg" id="find_btn" name="search_url">Find</button>		
																		</div>
																	</div>
																	
																</div>
															</div>															
														</div>		
													</form>
												</div>

														
											</div>
											
											
										</div>    
					  
									</div>
									<?php if((isset($_GET['url']) and $_GET['url'] != '' and isset($urlposts) and count($urlposts) > 0)){ ?>		
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
															<table class="table table-design" id="all_records">
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
														
													</div>	
												</div>		
										
										
										</form>
									</div> 
									<?php }else if(isset($_GET['url']) and $_GET['url'] != '' and !(isset($urlposts) and count($urlposts) > 0)){
										echo '<div class="alert alert-info"><p>No, record found in our database.</p></div>';
										
									} ?>
									
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
			
			#search_friends .personal_account_register {
				background: #fff none repeat scroll 0 0;
			}
			#search_friends h3 {
				line-height: 30px;
				margin: 0;
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
		jQuery('#share-link-button').click(function () {
			jQuery('#add_group_and_cat_form').css('display','block');
			jQuery('.modal-header').html('<h4>Add New Group </h4><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>');
			
		});
		</script>
				
		<?php  }      ?>