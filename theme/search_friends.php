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
	$co->page_title = "Find Friends | LinkiBag";     
 	$current = $co->getcurrentuser_profile();  	
	$item_per_page = 10;      	
	      	
	$this_page='p=search_friends';      

	$total_urls = $co->users_count_url($current['uid']);  	
	$total_friends = $co->users_count_friend($current['uid']);  	
	$total_friends_url = $co->users_count_shared_url($current['uid']);      
		
		?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
			<div class="col-md-12">      
				<p><a href="index.php">Home</a> &gt; Connect</p>
			</div> 
			</div>
			<div class="containt-area" id="dashboard_new">  
				<div class="container"> 
					<div class="col-md-3 my_lnk_left">      
						<?php include('dashboard_sidebar.php'); ?>      
					</div>	
					<div class="containt-area-dash col-md-9 my_lnk_right">      
						<div class="folder-dash-main">        
							       
							<!-- Tab panes -->        
							<div class="tab-content"> 
										<div class="tab-content-box">
											<div class="search-user text-right">
												<h3 style="color: rgb(128, 64, 64) !important;font-size: 16px;margin: 9px 0 0 0;" class="light-green-color pull-left"><i class="fa fa-chain fa-fw" aria-hidden="true"></i> Invites</h3>
												<div class="input-group" style="display: none;">
													<div class="services-block-sidebar<?=(($current['role'] == 2 or $current['role'] == 3) ? '' : ' non-paid-mamber')?>">
													<h4 class="text-blue">Premium Services</h4>
													</div>
												</div>
												<div class="input-group pull-right">
													<a href="index.php?p=linkifriends&fstatus=0" class="btn button-grey" style="margin: 0px 0px 9px;">Pending Invites</a>
												</div>
												<div class="clearfix"></div>
											</div>
											
											<?php
											/*
											<div class="search-user">
												<div class="input-group">
													<h3 style="margin: 0px 0px 18px;" class="f_title"><i class="fa fa-chain"></i> Connect <span class="badge round-red-badge"><?=$total_urls?></span></h3>
													
													
												</div>
												<div class="input-group">
													
													<a href="index.php?p=linkifriends&gid=" class="btn button-grey pull-right">Pending Requests</a>
													
												</div>
											</div>
											*/
											
											?>
											<div id="messagesout"></div> 
											<div class="mail-dashboard folder-dash-data" id="search_friends">
												<div style="border: 3px solid #ff8000;" id="all_records" class="search_friends_main">
													<form class="sign_up_page_form" method="post" id="search_form2" action="index.php?p=personal-account&ajax=ajax_submit" onsubmit="javascript: return send_friend_request(this, 'no');">   
														<div class="row">
															<div class="col-md-10">
																<h3 style="color: rgb(128, 64, 64) ! important;" class="light-green-color">Invite more friends to join</h3>
															</div>
															<div class="col-md-2 text-right">
																<button type="submit" class="orange-btn light-brown-bg" id="send_register">Invite</button>		
															</div>
														</div>
													    <input type="hidden" name="form_id" value="send_friend_request"/>           
														<div class="col-md-12 text-left wow fadeInUp templatemo-box">
															<div class="row">
																 <div class="personal_account_register">
																	<div class="form-group">
																		<div class="col-md-4 pad-sm"><label class="mylabel">Send email to someone you know</label></div>
																	    <div style="padding: 0px 7px;" class="col-md-6">
																			<textarea placeholder="Enter up to 5 email addresses separated by comma" type="text" name="email_ids" class="form-control" id="pwd"><?=((isset($_POST['email_id']) and $_POST['email_id']!='') ? $_POST['email_id'] : '')?></textarea>
																		</div>
																			
																		<div class="col-md-2"></div>
																		
																	</div>
																	<div class="form-group">
																		<div class="col-md-4 text-right"><label class="mylabel">Subject</label></div>
																	    <div style="padding: 0px 7px;" class="col-md-6">            
																			<textarea type="text" class="form-control" id="name" name="names" placeholder="Connect with me on LinkiBag.com"></textarea>
																		</div>
																		<div class="col-md-2"></div>
																	</div>
																	<div class="form-group">
																	   
																		<div class="col-md-4 text-right"><label class="mylabel">Write something </label></div>
																	 	<div style="padding: 0px 7px;" class="col-md-6">
																		<textarea placeholder="I thought you may be interested to join me on LinkiBag. Create your free account today to get connected." type="text" name="description" class="form-control inviteFrienddesc"  ></textarea>
																		<small>Min 25 characters</small>
																		</div>
																		<div class="col-md-4">            
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
			.sign_up_page_form .form-control { 
				max-width: 100% !important; 
			}
			.sign_up_page_form .inviteFrienddesc{
				min-height: 60px !important;
				height: auto !important;
			}
		</style>
		<script>
		jQuery('#share-link-button').click(function () {
			jQuery('#add_group_and_cat_form').css('display','block');
			jQuery('.modal-header').html('<h4>Add New Group </h4><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>');
			
		});
		</script>
				
		<?php  }      ?>