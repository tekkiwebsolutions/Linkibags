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
	$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');  	    
	$item_per_page = 12;      	
	$this_page='p=shared-links-new';     
	
	$lists_of_all_friend = $co->list_all_friends_of_current_user($current['uid'], 1, $item_per_page, $this_page, 'no');
	$lists_of_all_friends = $lists_of_all_friend['row'];
	

	$_SESSION["share_number"] = $co->generate_sharenumber();
	
	
	$total_urls = $co->users_count_url($current['uid']);  	
	$total_friends = $co->users_count_friend($current['uid']);  	
	$total_friends_url = $co->users_count_shared_url($current['uid']);  
	
	$groups = $co->fetch_all_array("select * from groups where uid IN (:id, 0) ORDER BY group_id DESC",array('id'=>$current['uid'])); 
	
	if(!(isset($_GET['url']) and count($_GET['url']) > 0))
		exit();
	
	$table_body = '';
	$i=1;                                
	if(isset($_GET['page'])){         
		$i = ($item_per_page * ($_GET['page']-1))+1;                  
	}                               
	$j = 1;
	$arr = '';
	$link_urls = '';
	foreach($_GET['url'] as $share_urls){	
		$urlpost = $co->query_first("SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,us.*  FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_url_id=:urlid",array('urlid'=>$share_urls));
		$url_value[] = array('url_value'=>$urlpost['url_value'], 'shared_url_id'=>$urlpost['url_value'], 'url_desc'=>$urlpost['url_desc'], 'num_of_visits'=>$urlpost['num_of_visits']);
		$arr .= '<input type="hidden" name="urls[]" value="'.$urlpost['shared_url_id'].'"/>' ; 
		$link_urls .= 'url[]='.$urlpost['shared_url_id'].'&';
		$parsed = parse_url($urlpost['url_value']);
		if (empty($parsed['scheme'])) {
			$urlpost['url_value'] = 'http://' . ltrim($urlpost['url_value'], '/');
		}
		
		$class_name = '';
		$i++; 
		if($j == 1){
			$class_name = 'first_row';
		
		$j++;
		}else{
			$class_name = 'second_row';
		
		$j = 1;
		}
		if(!(isset($_GET['order_by']))){
			$table_body .= '
			<tr class="'.$class_name.' '.($urlpost['num_of_visits'] > 0 ? ' read' : ' unread').'" id="url_'.$urlpost['shared_url_id'].'">
				<td style="width:45%">
					<a href="index.php?p=view_link&id='.$urlpost['shared_url_id'].'" target="_blank">'.((strlen($urlpost['url_value']) > 20) ? substr($urlpost['url_value'], 0, 20).'...' : $urlpost['url_value']).'</a>
				</td>
				<td style="width:45%; text-decoration: underline;">
					'.((strlen($urlpost['url_desc']) > 30) ? substr($urlpost['url_desc'], 0, 30).'...' : $urlpost['url_desc']).'
				</td>
				<td style="width:10%">
					<a href="index.php?p=view_link&id='.$urlpost['shared_url_id'].'" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				</td>	
			</tr>';
		}	
	 }
	if((isset($_GET['order_by']))){
		foreach($url_value as $re){
			$url_values_sort[] = $re['url_value'];
			$url_desc_sort[] = $re['url_desc'];
		}
		if((isset($_GET['order_by']) and array_key_exists("url_value",$_GET['order_by']) and in_array('asc', $_GET['order_by']))){
			array_multisort($url_values_sort, SORT_ASC, $url_value);
		}else if((isset($_GET['order_by']) and array_key_exists("url_value",$_GET['order_by']) and in_array('desc', $_GET['order_by']))){
			array_multisort($url_values_sort, SORT_DESC, $url_value);
		}else if((isset($_GET['order_by']) and array_key_exists("url_desc",$_GET['order_by']) and in_array('asc', $_GET['order_by']))){
			array_multisort($url_desc_sort, SORT_ASC, $url_value);
		}else if((isset($_GET['order_by']) and array_key_exists("url_desc",$_GET['order_by']) and in_array('desc', $_GET['order_by']))){
			array_multisort($url_desc_sort, SORT_DESC, $url_value);
		}
			
		foreach($url_value as $urlpost){
			$class_name = '';
			$i++; 
			if($j == 1){
				$class_name = 'first_row';
			
			$j++;
			}else{
				$class_name = 'second_row';
			
			$j = 1;
			}
		
			$table_body .= '
			<tr class="'.$class_name.' '.($urlpost['num_of_visits'] > 0 ? ' read' : ' unread').'" id="url_'.$urlpost['shared_url_id'].'">
				<td style="width:45%">
					<a href="index.php?p=view_link&id='.$urlpost['shared_url_id'].'" target="_blank">'.((strlen($urlpost['url_value']) > 20) ? substr($urlpost['url_value'], 0, 20).'...' : $urlpost['url_value']).'</a>
				</td>
				<td style="width:45%; text-decoration: underline;">
					'.((strlen($urlpost['url_desc']) > 30) ? substr($urlpost['url_desc'], 0, 30).'...' : $urlpost['url_desc']).'
				</td>
				<td style="width:10%">
					<a href="index.php?p=view_link&id='.$urlpost['shared_url_id'].'" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				</td>	
			</tr>';
		}	
	}
	
	 
		
?>
		<section class="dashboard-page sharing-links-page"> 
			<div class="container bread-crumb top-line">    
			<div class="col-md-12">      
				<p><a href="index.php">Home</a> &gt; Share Links</p>
			</div> 
			</div>
			
			<div class="containt-area" id="dashboard_new">  
				<div class="container"> 
					<div class="col-md-3">      
						<?php include('dashboard_sidebar.php'); ?>      
					</div>	
					<div class="containt-area-dash col-md-9">
						<div class="row">
							<div class="col-md-8">
								
								<div class="text-orang user-name-dash">Sharing links</div>
							
								<div class="tab-content"> 
								<form onsubmit="javascript: return share_links_new(1);" action="index.php?p=dashboard&amp;ajax=ajax_submit" id="share_form_1" class="form-horizontal edit_url_form-design" method="post">
									<div id="url-shared-messages-out_1"></div>
									<input type="hidden" value="share_links" name="form_id">
									<input name="page" value="1" type="hidden">
									<input name="item_per_page" value="10" type="hidden">
									<input name="this_page" value="p=share_links_new" type="hidden">
									<?php
									/*
									if(isset($_GET)){											
										foreach($_GET as $k=>$v){	
											echo '<input type="hidden" name="'.$k.'" value="'.$v.'"/>';
										}	
									}
									*/	
									?>
									<div class="tab-content-box">
											<?=isset($msg) ? $msg : ''?>
												<ul class="head-design table-design">
													<?php
													$url_by = 'asc';
													$arrow_direction = 'fa fa-caret-down';
													if(isset($_GET['order_by']) and in_array('asc', $_GET['order_by'])){
														$url_by = 'desc';
														$arrow_direction = 'fa fa-caret-up';
													}elseif(isset($_GET['order_by']) and in_array('desc', $_GET['order_by'])){
														$url_by = 'asc';
														$arrow_direction = 'fa fa-caret-down';
													}
													
													?>
														
													<li style="width:45%">
														
														<div class="dropdown dropdown-design">
															<div class="btn btn-default dropdown-toggle">Link <a href="index.php?p=shared-links-new&<?=$link_urls?>&order_by[url_value]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("url_value",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
														</div>	
													</li>
													
													<li style="width:45%">
														
														<div class="dropdown dropdown-design">
															<div class="btn btn-default dropdown-toggle">Message <a href="index.php?p=shared-links-new&<?=$link_urls?>&order_by[url_desc]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("url_desc",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
															
														</div>	
													</li>
													<li style="width:10%">
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
															<div style="margin-right: 0px; margin-left: 0px;" class="btn btn-default dropdown-toggle">Edit</div>
														</div>	
													</li>
												</ul>
											<div class="mail-dashboard">
											<table class="border_block table table-design" id="all_records">
												<tbody>
													<?php               
													
													
													echo $table_body;
													?>
												</tbody>
												</table>
											</div>	
										</div>		
					
							</div> 		
							</div>
							<div class="col-md-4">
								<div class="shared-links-right-sidebar">
								<h1 class="text-orang" style="float: left; line-height: 25px; margin: 0px 0px 13px;">Share with</h1>
								
								<select name="friend_group" id="friend_group" class="form-control" onchange="get_friends_of_groups(this.value)" style="float: right; border-radius: 0px; width: 66%; border: 1px solid rgb(127, 127, 127); box-shadow: none !important; height: auto; padding: 4px 7px;">
									<option value="">Select Folder</option>
									<?php
									foreach($groups as $list){
									echo '<option value="'.$list['group_id'].'">'.$list['group_name'].'</option>';
									}	
									?>
								</select>
								
								
								 <select name="shared_user[]" class="form-control" id="add_user_to_share" multiple onclick="change_link_color(event);" onchange="change_link_color(event);" onkeydown="change_link_color(event);">
									<?php
									foreach($lists_of_all_friends as $list){
										echo '<option value="'.$list['email_id'].'">'.$list['email_id'].'</option>';
									}
									?>
								</select>
							
								<input type="checkbox" name="save_as_group" onclick="add_new_group_with_friends()" value="1"/> <span class="text-small-gray">Save as new group</span>
								
								<div id="save_as_group_block" class="form-group"<?=((isset($_POST['save_as_group']) and $_POST['save_as_group'] == 1) ? '' : ' style="display: none;"')?>>
									<div>          
										<label class="">Folder name<span class="required-field">*</span></label>
										<input type="text" name="group_name" placeholder="New Folder Name" class="form-control" value="" maxlength="25"/>
									</div>
								</div>
								
								<p class="text-theme">You are about to share <?php echo count($_GET['url']);?> links</p>
								 
								 <?php /* ?>
								 <textarea placeholder="To share links type email address or LinkiBag user name of users you want to share links with." class="form-control email-control" name="shared_user" required>
								 
								 <?php foreach(
								 $lists_of_all_friends as $list
								 ){echo''.$list['email_id'].',';} ?>
								 
								 
								 </textarea>
								 <?php */ ?>
								 
								 <!--<a class="text-theme" href="#"><u>Select from my LinkiFriends</u></a>-->
								 <div class="clearfix"></div>
								 <div class="shared-links-right-sidebar-btns">
								    <?php echo $arr; ?>
									<button type="submit" id="send_share_link_1" class="btn orang-bg pull-left"><i class="fa fa-share" aria-hidden="true"></i> Share</button>
									<a type="button" href="index.php?p=dashboard" class="btn button-grey pull-right">Cancel</a>
								 </div>
								<div class="clearfix"></div> 
								 <p class="text-theme">LinkiBag users will receive your links via their lnbag. Non LinkiBag users will have 30 minutes to access shared by you links before this page will expire.</p>
								 
								 <p class="text-small-gray">Users can also use code below within next 30 min to access your links:</p>
							</form>
							<div id="copy-code" class="copy-cod"><?=$_SESSION["share_number"]?></div>
							<button class="copy-text" data-clipboard-action="copy" data-clipboard-target="#copy-code">Copy</button>
							<script>
								var clipboard = new Clipboard('.copy-text');

								clipboard.on('success', function(e) {
									console.log(e);
								});

								clipboard.on('error', function(e) {
									console.log(e);
								});
							</script>
						</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="containt-area shared-links-new">  
				<div class="container"> 
					
					<div class="col-md-11 col-md-offset-1"></div>
					<div class="col-md-1"></div>
					<div class="containt-area-dash col-md-7">  
						<div>              
								
						</div>    
					</div>    
					<div class="col-md-3">      
						
					</div>
					<div class="col-md-1"></div>
				</div>
			</div>
	
		</section>
		
		<?php
		/*
		<!-- Add new Folders-->
		
		<a class="btn btn-info orang-bg" href="#" data-toggle="modal" data-target="#add_groups_and_cat" id="add_new_folder" style="display:none;">Add New Folder</a>
		<div class="modal fade" id="add_groups_and_cat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

		  <div class="modal-dialog modal-sm">

			<div class="modal-content add-new-gp">

				<div class="modal-header">

					<h4>Add New Folder </h4>

					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

				</div>
				<div id="model_body">
					<form method="post" class="form-horizontal" id="add_group_and_cat_form" action="index.php?p=shared-links-new&ajax=ajax_submit" onsubmit="javascript: return add_new_group(this);">
				
					<input type="hidden" name="form_id" value="add_groups"/>
					
					
					<div class="modal-body-group">					
						<div class="form-group">
							<div class="col-md-12">          
								<label class="">Folder name<span class="required-field">*</span></label>
								<input type="text" name="group_name" placeholder="New Folder Name" class="form-control" value="" maxlength="25" required/>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-default linki-btn" id="save_btn">Continue</button>
					</div>
				</form>
					
				</div>
			</div>

		  </div>

		</div>
		
		*/
		?>
		
		
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
		
#copy-code {
    background: #c3c3c3 none repeat scroll 0 0;
    color: #004080;
    font-size: 19px;
    margin: auto;
    padding: 7px 0;
    text-align: center;
    width: 100%;
}

.copy-text {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    color: #004080;
    float: right;
    font-weight: bold;
}
.head-design {
	border: 3px solid #c3c3c3;
	margin-bottom: 10px;
}
.table-design .dropdown-design .btn-default {
    padding: 1px 11px;
}		
.chosen-choices {
    border: 1px solid #7f7f7f !important;
    border-radius: 0;
    box-shadow: none !important;
    font-size: 12px;
    min-height: 95px !important;
	background: transparent none repeat scroll 0 0 !important;
}
.search-choice {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0 !important;
    border: medium none !important;
    margin: 0 !important;
	box-shadow: none !important;
}
.share-with-control {
    border: 3px solid #ff8000;
    border-radius: 0;
    box-shadow: none !important;
    color: #ff8000;
	line-height: 16px;
}
.text-theme {
    color: #004080;
    font-size: 12px;
    font-weight: 700;
}
.text-small-gray{
	color: rgb(127, 127, 127);
	font-size: 12px;
	font-weight: 700;
}
.chosen-container-multi .chosen-choices li.search-choice {
	color: #7f7f7f;
}
.btn-code {
    background: #c3c3c3 none repeat scroll 0 0;
    color: #004080;
    display: block;
    font-size: 20px;
    text-align: center;
    width: 100%;
}
.shared-links-right-sidebar-btns .orang-bg {
    border-radius: 0;
    color: #fff;
    font-weight: 600;
}
.shared-links-right-sidebar-btns {
    margin: 13px 0;
    overflow: hidden;
}
.shared-links-new {
    padding: 38px 0;
}
.search-choice.active span {
    color: #ff8000;
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
<?php } ?>