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

	$i=1;                                
	if(isset($_GET['page'])){         
		$i = ($item_per_page * ($_GET['page']-1))+1;                  
	}                               
	echo $no_record_found;   
	$j = 1;
	$tbody = '';
	if(isset($categories) and count($categories) > 0){
		foreach($categories as $category){ 
			$total_url_in_cat = $co->query_first("select COUNT(url_id) as total from user_shared_urls where url_cat=:cat and shared_to=:uid",array('cat'=>$category['cid'],'uid'=>$current['uid'])); 
			$time_ago = $co->time_elapsed_string($category['created_time']);	        
			
			$empty_link = 'empty_links('.$category['cid'].',0);';	
			if($total_url_in_cat['total'] == 0)
				$empty_link= "error_dialogues('There is no links in this category')";																	

			$i++;
				
			if($j == 1){
				$class_name = 'first_row';
				$j++;
			}else{
				$class_name = 'second_row text-bold';
				$j = 1;
			}

			if((isset($_GET['order_by_custom']))){
				$folders[] = array('total_url_in_cat'=>$total_url_in_cat['total'],'cid'=>$category['cid'],'cname'=>$category['cname']);
			}else{
				$tbody .= '	
					<tr class="'.$class_name.'" id="record_'.$category['cid'].'">
						<td style="width:62%"><span><input type="checkbox" class="grouping" value="'.$category['cid'].'" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid='.$category['cid'].'">'.$category['cname'].'</a> <span>&nbsp; <a href="javascript: void(0);" onclick="load_edit_frm('.$category['cid'].', \'category\')"><i class="fa fa-pencil"></i></a></span></td>
						<td style="width:10%"><a class="btn btn-sm" href="javascript: void(0);" onclick="'.$empty_link.'">Empty</a></td>
						
						<td class="text-center" style="width:20%" id="empty_'.$category['cid'].'">'.$total_url_in_cat['total'].'</td>
					</tr>';

			}

			


		}

		/* sorting */
		if(isset($folders) and count($folders) > 0){
			$j = 1;
			foreach($folders as $re){
				$folder_total_sort[] = $re['total_url_in_cat'];																	
			}

			if((isset($_GET['order_by_custom']) and array_key_exists("folder_total",$_GET['order_by_custom']) and in_array('asc', $_GET['order_by_custom']))){
				array_multisort($folder_total_sort, SORT_ASC, $folders);
			}else if((isset($_GET['order_by_custom']) and array_key_exists("folder_total",$_GET['order_by_custom']) and in_array('desc', $_GET['order_by_custom']))){
				array_multisort($folder_total_sort, SORT_DESC, $folders);
			}
			foreach($folders as $fol){
				/*$time_ago = $co->time_elapsed_string($fol['created_time']);*/				
				$empty_link = 'empty_links('.$fol['cid'].',0);';	
				if($fol['total_url_in_cat'] == 0)
					$empty_link= "error_dialogues('There is no links in this category')";														
				if($j == 1){
					$class_name = 'first_row';
					$j++;
				}else{
					$class_name = 'second_row text-bold';
					$j = 1;
				}

				$tbody .= '	
					<tr class="'.$class_name.'" id="record_'.$fol['cid'].'">
						<td style="width:62%"><span><input type="checkbox" class="grouping" value="'.$fol['cid'].'" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid='.$fol['cid'].'">'.$fol['cname'].'</a> <span>&nbsp; <a href="javascript: void(0);" onclick="load_edit_frm('.$fol['cid'].', \'category\')"><i class="fa fa-pencil"></i></a></span></td>
						<td style="width:10%"><a class="btn btn-sm" href="javascript: void(0);" onclick="'.$empty_link.'">Empty</a></td>
						
						<td class="text-center" style="width:20%" id="empty_'.$fol['cid'].'">'.$fol['total_url_in_cat'].'</td>
					</tr>';
			}
		}	
		/*end sorting */
	}else{
		//$tbody .= '<td colspan="3">No, record found</td>';
	}	


?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
				<div class="col-md-7">      
					<p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Folders</a></p>    
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
										<?php
										$get_page_by = isset($_GET['page']) ? '&page='.$_GET['page'] : '';
										$folder_by = 'asc';
										$arrow_direction = 'fa fa-caret-down';
										if(isset($_GET['order_by_custom']) and in_array('asc', $_GET['order_by_custom'])){
											$folder_by = 'desc';
											$arrow_direction = 'fa fa-caret-up';
										}elseif(isset($_GET['order_by_custom']) and in_array('desc', $_GET['order_by_custom'])){
											$folder_by = 'asc';
											$arrow_direction = 'fa fa-caret-down';
										}

										?>
										<div class="tab-content-box">
											<div class="row top-folder-header">
												<div class="col-md-4 text-right folder-header-right">
													<span class="text-orang pull-left">My Folders</span>
											<!--
											<a class="btn button-grey" href="javascript: void(0);" onclick="load_add_frm('category','0')">Add New Folder</a>-->
												</div>
												<div class="col-md-4">
													<a class="btn button-grey" href="javascript: void(0);" onclick="load_add_frm('category','0');">Add New Folder</a>
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
													<div class="btn btn-default dropdown-toggle text-center">Total <a href="index.php?p=linkibags&order_by_custom[folder_total]=<?=$folder_by.$get_page_by?>"><i class="<?=((isset($_GET['order_by_custom']) and array_key_exists("folder_total",$_GET['order_by_custom']) and in_array('asc', $_GET['order_by_custom'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
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
													
													$total_url_in_catinbag = $co->query_first("select COUNT(url_id) as total from user_shared_urls where url_cat=:cat and shared_to=:uid",array('cat'=>-2,'uid'=>$current['uid'])); 
													$empty_links = 'empty_links(0,1);';	
													if($total_url_in_catinbag['total'] == 0)
														$empty_links= "error_dialogues('There is no links in this category')";
													?>
														
														<tr class="first_row text-bold" id="record_1">
															<td style="width:62%"><span><input type="checkbox" disabled value="-2" id="inbag" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid=-2">Inbag</a> <span>&nbsp; </span></td>
															<td style="width:10%"><a class="btn btn-sm" href="javascript: void(0);" onclick="<?=$empty_links?>">Empty</a></td>
															
															<td class="text-center un-bold" style="width:20%" id="empty_0"><?=$total_url_in_catinbag['total']?></td>
														</tr>
														
														<tr class="second_row text-bold" id="record_0">
															<td style="width:62%"><span><input type="checkbox" disabled value="0" id="trash" name="categories[]"></span> &nbsp; <a href="index.php?p=dashboard&cid=0&trash=1">Trash</a> <span>&nbsp; </span></td>
															<td style="width:10%"><a class="btn btn-sm" href="javascript: void(0);" onclick="<?=$empty_link?>">Empty</a></td>
															
															<td class="text-center un-bold" style="width:20%" id="empty_0"><?=$total_url_in_cat['total']?></td>
														</tr>
													
													<?php               													
														echo $tbody;
													?>


														
													</tbody>
												</table>
											</div>	
										</div>		
								</form>
							</div> 
							
							<div class="bottom-nav-link table-design">                
								<div class="bottom-nav-link-main">
									<div class="col-md-4 col-md-offset-4">
										<a class="btn btn-info dark-gray-bg" href="javascript: void(0);" onclick="del_new_group('category');">Delete</a>
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
		
		<a class="btn btn-info green-bg" href="#" data-toggle="modal" data-target="#edit_groups_and_cat" id="edit_new_folder" style="display:none;">Edit New Folder</a>
		<div class="modal fade" id="edit_groups_and_cat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

		  <div class="modal-dialog modal-sm">

			<div class="modal-content theme-modal-header">

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
			.top-folder-header {
				margin-bottom: 5px;
			}
			.top-folder-header .btn {
				font-size: 14px !important;
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
		<script>
		jQuery('#share-link-button').click(function () {
			jQuery('#add_group_and_cat_form').css('display','block');
			jQuery('.modal-header').html('<h4>Add New Category </h4><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>');
			
		});
		</script>
				
		<?php  }      ?>