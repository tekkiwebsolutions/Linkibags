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
	$co->page_title = "Find Friends | Linkibag";     
 	$current = $co->getcurrentuser_profile();  	
	$item_per_page = 10;      	
	      	
	$this_page='p=search_friends';      

	$total_urls = $co->users_count_url($current['uid']);  	
	$total_friends = $co->users_count_friend($current['uid']);  	
	$total_friends_url = $co->users_count_shared_url($current['uid']);      
		
		?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
				<div class="col-md-7">      
					<p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Connect</a></p>    
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
																<h3 class="f_title">Connect</h3>
															</div>
														</div>
											
											<div id="messagesout"></div> 
											<div class="mail-dashboard folder-dash-data" id="search_friends">
												<div id="all_records" class="search_friends_main">
													<h3 class="light-green-color">Member Search</h3>
													<form class="sign_up_page_form" method="post" id="register_form" action="index.php?p=personal-account&ajax=ajax_submit" onsubmit="javascript: return send_friend_request(this, 'yes');">
														  
													   <input type="hidden" name="form_id" value="send_friend_request"/>          
							        
													   <div class="col-md-12 text-left wow fadeInUp templatemo-box">
															<div class="row">
																 <div class="personal_account_register">
																	<div class="form-group">
																		<div class="col-md-4 pad-sm"><label class="mylabel">Search database of LinkiBag users.</label></div>
																	   
																		<div style="padding: 0px 7px;" class="col-md-4"><input placeholder="Email Address" type="text" name="email_id" class="form-control" id="pwd" value="<?=((isset($_POST['email_id']) and $_POST['email_id']!='') ? $_POST['email_id'] : '')?>" />
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

												<div id="all_records" class="search_friends_main">
													<h3>Send an invitation to someone you know to join LinkiBag. Your invitee will get an email with your invitation to join.</h3>
													<form class="sign_up_page_form" method="post" id="search_form2" action="index.php?p=personal-account&ajax=ajax_submit" onsubmit="javascript: return send_friend_request(this, 'no');">   
													    <input type="hidden" name="form_id" value="send_friend_request"/>           
														<div class="col-md-12 text-left wow fadeInUp templatemo-box">
															<div class="row">
																 <div class="personal_account_register">
																	<div class="form-group">
																		<div class="col-md-4 pad-sm"><label class="mylabel">Invite someone you know.</label></div>
																	   
																		<div style="padding: 0px 7px;" class="col-md-4"><textarea placeholder="Email Address. You can type up to five email addresses separated by commas." type="text" name="email_ids" class="form-control" id="pwd"><?=((isset($_POST['email_id']) and $_POST['email_id']!='') ? $_POST['email_id'] : '')?></textarea>
																		</div>
																		<div class="col-md-4">            
																			<button type="submit" class="orange-btn blue-bg" id="send_register">Send Invitations</button>		
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
			
			
		</style>
		<script>
		jQuery('#share-link-button').click(function () {
			jQuery('#add_group_and_cat_form').css('display','block');
			jQuery('.modal-header').html('<h4>Add New Group </h4><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>');
			
		});
		</script>
				
		<?php  }      ?>