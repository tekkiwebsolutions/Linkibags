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
	$co->page_title = "Find URLs | LinkiBag";     
 	$current = $co->getcurrentuser_profile();  	
	$item_per_page = 10;      	
	      	
	$this_page='p=search-urls';      

	$total_urls = $co->users_count_url($current['uid']);  	
	$total_friends = $co->users_count_friend($current['uid']);  	
	$total_friends_url = $co->users_count_shared_url($current['uid']);      
		
	$urlposts = array();
	
	if(isset($_GET['key']) and trim($_GET['key'])!=''){
		$sql = "SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,us.* FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and ur.url_title LIKE '%".$_GET['key']."%' and ur.url_value LIKE '%".$_GET['key']."%' and ur.url_desc LIKE '%".$_GET['key']."%'";
		$cond = array();
		if(isset($_GET['shared_by']) and $_GET['shared_by'] == 'asc')
			$sql .= " ORDER BY u.email_id ASC";			
		elseif(isset($_GET['shared_by']) and $_GET['shared_by'] == 'desc')			
			$sql .= " ORDER BY u.email_id DESC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_desc ASC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_desc DESC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_value ASC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_value DESC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'asc')			
			$sql .= " ORDER BY ur.created_date ASC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'desc')			
			$sql .= " ORDER BY ur.created_date DESC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'asc')			
			$sql .= " ORDER BY ur.created_date ASC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'desc')			
			$sql .= " ORDER BY ur.created_date DESC";				
		else					
			$sql .= " ORDER BY us.shared_url_id DESC";				
		$urlposts = $co->fetch_all_array($sql, $cond);		
		$row_count = count($row);
	}	
		?>
		<section class="dashboard-page">  
			<p><br></p> 
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
													<h3 style="margin: 0px 0px 18px;" class="f_title"><i class="fa fa-search"></i> Find Any URLs</h3>
												</div>
											</div>
											
											<div id="messagesout"></div> 
											<div class="mail-dashboard folder-dash-data" id="search_friends">
												<div style="border: 2px solid #ff8000;" id="all_records" class="search_friends_main">
													<h3 class="light-green-color">Keyword Search</h3>
													<form class="sign_up_page_form" method="get">
														  
													   <input type="hidden" name="p" value="search-urls"/>          
							        
													   <div class="col-md-12 text-left wow fadeInUp templatemo-box">
															<div class="row">
																 <div class="personal_account_register">
																	<div class="form-group">
																		<div class="col-md-4 pad-sm"><label class="mylabel">Search database of LinkiBag URLs</label></div>
																	   
																		<div style="padding: 0px 7px;" class="col-md-4">
																			<input type="text" name="key" class="form-control" id="pwd" value="<?=((isset($_GET['key']) and $_GET['key']!='') ? $_GET['key'] : '')?>" />
																		</div>
																		<div class="col-md-4">            
																			<button type="submit" class="orange-btn green-bg" id="find_btn">Find</button>		
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
						</div>	
						<?php
						if(isset($_GET['key']) and trim($_GET['key'])==''){
							echo '<p>Please enter atleast one word to search our database</p>';
						}elseif(isset($_GET['key'])){
						?>
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
															<div class="btn btn-default dropdown-toggle"><input type="checkbox" name="check" id="checkAll" value=""/>Select All <a href="index.php?p=search-urls<?=$url_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
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
															<div class="btn btn-default dropdown-toggle">Shared By <a href="index.php?p=search-urls<?=$shared_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
															
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
															<div class="btn btn-default dropdown-toggle">Message <a href="index.php?p=search-urls<?=$shared_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
															
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
															<div class="btn btn-default dropdown-toggle">Date <a href="index.php?p=search-urls<?=$date_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
															
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
																	<td style="width:32%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="<?=$urlpost['shared_url_id']?>"></span> &nbsp; <a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>"><?=((strlen($urlpost['url_value']) > 42) ? substr($urlpost['url_value'], 0, 42).'...' : $urlpost['url_value'])?></a>
																	
										
																	<a href="#succ_<?=$urlpost['shared_url_id']?>" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Visit Website"  class="visit-icon"><i class="fa fa-arrow-circle-right"></i></a>
																	
																	<!-- Modal -->
													<div class="modal fade" id="succ_<?=$urlpost['shared_url_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header modal-header-success">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																	<h4>You are about to leave LinkiBag</h4>
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
																	<td class="unbold-text" style="width:28%"><?=((strlen($urlpost['url_desc']) > 30) ? substr($urlpost['url_desc'], 0, 30).'...' : $urlpost['url_desc'])?></td>
																	<td style="width:15%"><?=date('d/m/Y', $urlpost['shared_time'])?>   <?=date('h:i a', $urlpost['shared_time'])?></td>
																</tr>
															<?php } ?>
															
														</tbody>
													</table>
												
											</div>
								<?php } ?>
					</div>
				</div>
			</div>
		</section>
		
		
			
			

		
		
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
			
			
		</style>
		<script>
		jQuery('#share-link-button').click(function () {
			jQuery('#add_group_and_cat_form').css('display','block');
			jQuery('.modal-header').html('<h4>Add New Group </h4><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>');
			
		});
		</script>
				
		<?php  }      ?>