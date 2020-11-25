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
	$co->page_title = "Shared LinkBooks | LinkiBag";     
 	$current = $co->getcurrentuser_profile();  	  

	$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');  	    
	$item_per_page = 12;      	
	$this_page='p=share-linkibook';     
	
	$lists_of_all_friends = $co->fetch_all_array("SELECT DISTINCT(IFNULL(u.email_id, r.request_email)) as email_id FROM user_friends uf INNER JOIN friends_request r ON r.request_id=uf.request_id LEFT JOIN users u ON u.uid=uf.fid WHERE uf.uid=:uid",array('uid'=>$current['uid']));

	$_SESSION["share_number"] = $co->generate_sharenumber();
	
	
	$total_urls = $co->users_count_url($current['uid']);  	
	$total_friends = $co->users_count_friend($current['uid']);  	
	$total_friends_url = $co->users_count_shared_url($current['uid']);  
	
	$groups = $co->fetch_all_array("select * from groups where uid IN (:id) ORDER BY group_id DESC",array('id'=>$current['uid'])); 
	
	if(!(isset($_GET['book']) and count($_GET['book']) > 0))
		exit();
	
	$table_body = '';
	$i=1;                                
	if(isset($_GET['page'])){         
		$i = ($item_per_page * ($_GET['page']-1))+1;                  
	}                               
	$j = 1;
	$arr = '';
	$link_urls = '';
	foreach($_GET['book'] as $share_book){	
		$urlpost = $co->query_first("SELECT *  FROM `linkibooks` WHERE id=:id",array('id'=>$share_book));
		
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
		<input type="hidden" name="book[]" value="'.$urlpost['id'].'" />
		<tr class="'.$class_name.' read" id="record_'.$urlpost['id'].'">
			<td style="width:50%"><a target="_blank" href="links_print/index.php?preview_linkibook=1&id='.$urlpost['id'].' " >'.$urlpost['book_title'].'</a></td>
			<td style="width:50%; text-decoration: underline;">';
			$table_body .= $urlpost['book_subtitle'].'		
			</td>
		</tr>';
	}	
?>
		<section class="dashboard-page sharing-links-page"> 
			<div class="container bread-crumb top-line">    
			<div class="col-md-12">      
				<p><a href="index.php">Home</a> &gt; Share LinkBooks</p>
			</div> 
			</div>
			
			<div class="containt-area" id="dashboard_new">  
				<div class="container"> 
					<div class="col-md-3 my_lnk_left">      
						<?php include('dashboard_sidebar.php'); 
						?>    

					</div>	
					<div class=" containt-area-dash col-md-9 my_lnk_right">
						<div class="row">
							<div class="col-md-8">
								
								<div class="text-orang user-name-dash">Share</div>
							
								<div class="tab-content"> 
								<div id="table_serialize_for_print" style="display: none;"></div>	
								<form onsubmit="javascript: return share_linkibook(1);" action="index.php?p=dashboard&amp;ajax=ajax_submit" id="share_form_1" class="form-horizontal edit_url_form-design" method="post">
									<div id="url-shared-messages-out_1"></div>
									<input type="hidden" value="share_linkibook" name="form_id">
									
									<div class="tab-content-box">
									<?=isset($msg) ? $msg : ''?>
									<ul class="head-design table-design">
										<li style="width:50%">
											<div class="dropdown dropdown-design">
												<div class="btn btn-default dropdown-toggle">LinkiBook</div>
											</div>	
										</li>
										<li style="width:50%">
											<div class="dropdown dropdown-design">
												<div class="btn btn-default dropdown-toggle">Message</div>
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
								<h1 class="text-orang" style="line-height: 25px; margin: 0px 0px 13px;">Share with</h1>
								<div id="demochk"></div>
								<div class="row" style="margin-bottom: 2px">
									<div class="col-md-5" style="padding-right: 5px;">
										<a class="btn button-grey" href="javascript: void(0)" style="padding:4px 12px; width: 100%" data-toggle="modal" data-target="#addmultipleusers">Add Users</a>
									</div>
									<div class="col-md-7" style="padding-left: 5px;">
										<select name="friend_group" id="friend_group" class="form-control" onchange="get_friends_of_groups(this.value)" style="border-radius: 0px; border: 1px solid rgb(127, 127, 127); box-shadow: none !important; height: auto; padding: 4px 7px;">
											<option value="">Select Group</option>
											<?php
											foreach($groups as $list){
											echo '<option value="'.$list['group_id'].'">'.$list['group_name'].'</option>';
											}	
											?>
										</select>
									</div>
								</div>
								
								<!--  onclick="change_link_color(event);" onchange="change_link_color(event);" onkeydown="change_link_color(event);" -->
								
								 <select name="shared_user[]" class="form-control" id="add_user_to_share" multiple onchange="update_chosen_section()">
									<?php
									foreach($lists_of_all_friends as $list){
										echo '<option value="'.$list['email_id'].'">'.$list['email_id'].'</option>';
									}
									?>
								</select>
							
								<div id="save_as_new_gp_block">
									<input type="checkbox" name="save_as_group" onclick="add_new_group_with_friends()" value="1"/> <span class="text-small-gray">Save as new group</span>
									
									<div id="save_as_group_block" class="form-group"<?=((isset($_POST['save_as_group']) and $_POST['save_as_group'] == 1) ? '' : ' style="display: none;"')?>>
										<div>          
											<label class="">Group name<span class="required-field">*</span></label>
											<input type="text" name="group_name" placeholder="New Group Name" class="form-control" value="" maxlength="25"/>
										</div>
									</div>
								</div>
								<div id="save_as_existing_gp_block" style="display: none;">
									<input type="checkbox" name="update_as_group" onclick="update_existing_group_with_friends()" value="1"/> <span class="text-small-gray">Update existing group</span>
									
									<div id="update_as_group_block" class="form-group"<?=((isset($_POST['update_as_group']) and $_POST['update_as_group'] == 1) ? '' : ' style="display: none;"')?>>
										<div>          
											<label class="">Group name <span class="required-field">*</span></label>
											<input type="text" id="existing_grp_name" name="group_name_updated" placeholder="New Group Name" class="form-control" value="" maxlength="25"/>
										</div>
									</div>
								</div>	
								
								<p class="text-theme">You are about to send this LinkiBook to your own eamil address <?php echo count($_GET['book']);?> LinkiBook(s)</p>
								 
								 <!--<a class="text-theme" href="#"><u>Select from my LinkiFriends</u></a>-->
								 <div class="clearfix"></div>
								 <div class="shared-links-right-sidebar-btns">
								    <?php //echo $arr; ?>
									<button type="submit" id="send_share_link_1" class="btn orang-bg pull-left"><i class="fa fa-share" aria-hidden="true"></i> Share</button>
									<a type="button" href="index.php?p=linkibook" class="btn button-grey pull-right">Cancel</a>
									
								 </div>
								<div class="clearfix"></div> 
								<?php
								/*
								?>
								 <p class="text-theme">LinkiBag users will receive your links via their lnbag. Non LinkiBag users will have 30 minutes to access shared by you links before this page will expire.</p>
								 
								 <p class="text-small-gray">Users can also use code below within next 30 min to access your links:</p>
							
								<div id="copy-code" class="copy-cod"><?=$_SESSION["share_number"]?></div>
								<button type="button" class="copy-text" data-clipboard-action="copy" data-clipboard-target="#copy-code">Copy</button>
								<div class="clearfix"></div>
									<input type="checkbox" id="disable_share_id" name="disable_share_id" value="1"/> <span class="text-theme" id="disable_share_id_msg">Disable Share ID</span>
								<?php
								*/
								?>
							</form>		
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


<div class="modal fade" id="addmultipleusers" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content theme-modal-header">
         <div class="modal-header">
            <h4>Add Users</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
         </div>
         <div id="model_body">
            <div class="col-sm-12"><div id="addmultipleusers_msgs"></div></div>
            <form method="post" class="form-horizontal" id="addmultipleusers_form" action="index.php?p=linkifriends&ajax=ajax_submit" onsubmit="javascript: return add_multiple_users(this);" enctype="multipart/form-data">
               <input type="hidden" name="form_id" value="add_multiple_users"/>
               <input type="hidden" name="gid" id="multiple_user_gid" value=""/>
               <div class="modal-body-group">               
                  <div class="form-group">
                     <div class="col-sm-10 col-md-offset-1">        
                        <label class="">Upload<span class="required-field">*</span></label>
                        <input type="file" name="userfile" required/>
                        <small>Upload list of emails in doc, docx, txt, rtf format, seperated by comma to add additional users</small>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-default linki-btn okbtn">OK</button>
                  <button type="button" class="btn btn-default linki-btn" data-dismiss="modal" style="margin-left: 38px;">Cancel</button>
               </div>
            </form>
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
.search-choice.addednew span {
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