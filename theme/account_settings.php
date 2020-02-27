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
   	$co->page_title = "Account Settings | Linkibag";     
    $current = $co->getcurrentuser_profile();  	
   	$this_page='p=account_settings';      
	/*if($current['role'] == 1)
		exit();*/
	$get_completed_on = $co->query_first('select created from interested_category WHERE uid=:uid', array('uid'=>$current['uid']));

	if(isset($_GET['action_type']) and $_GET['action_type'] == 'generate_links'){
		$tim = time();
		$generate_links = WEB_ROOT.'index.php?p=viewprofile&id='.$current['uid'];
		$co->query_update('users', array('paid_users_generate_links'=>$generate_links,'paid_users_generate_links_created'=>$tim), array('id'=>$current['uid']), 'uid=:id');			
		//$co->setmessage("status", "Your account has been closed successfully");			
		echo '<script type="text/javascript">window.location.href="index.php?p=account_settings"</script>';					
		exit();	
	}else if(isset($_GET['action_type']) and $_GET['action_type'] == 'remove_profile'){	
		$tim = time();
		$co->query_update('users', array('remove_profile'=>$tim), array('id'=>$current['uid']), 'uid=:id');	
		echo '<script type="text/javascript">window.location.href="index.php?p=account_settings"</script>';						
		exit();	
	}else if(isset($_GET['action_type']) and $_GET['action_type'] == 'unremove_profile'){	
		$tim = 0;
		$co->query_update('users', array('remove_profile'=>$tim), array('id'=>$current['uid']), 'uid=:id');	
		echo '<script type="text/javascript">window.location.href="index.php?p=account_settings"</script>';			
		exit();
	}
	
	
   	?>

		

		<section class="sign_up_main_page" id="public-bag">	

		 <div class="container bread-crumb top-line">
      <div class="col-md-12">
         <p><a href="index.php">Home</a> &gt; Account Settings </p>
      </div>
   </div>
		
		<div class="containt-area">
			<div class="container">
					<?php
					include('account_setting_sidebar.php');
					?>		


					<div class="col-md-9">
						<div class="account-setting-header">
							<h3>Account Settings</h3>
							<p>You must complete your interest form to continue with use of your free account. <a style="text-decoration: underline; color: red;" href="index.php?p=categories-list">Complete Now</a></p>
						</div>
						<div class="settings">
							<div class="row">
								<div class="col-md-5 generate">
									<p><span><u>Complete or update your interest form </u> </span></p>
								</div>
								<div class="col-md-7 linkibag">
									<?php if(isset($get_completed_on['created']) and $get_completed_on['created'] != ''){ ?>
										<p class="completed_on">Completed on <?=date('m/d/Y', $get_completed_on['created'])?></p>
									<?php }else{ ?>
										<p><a style="color:red;float: left;padding-right: 35px; line-height:2" href="index.php?p=categories-list">Complete Now</a></p>
									<?php } ?>
									
								</div>
							</div>
							<div class="row">
								<div class="col-md-5 generate">
									<p><u><a data-toggle="modal" role="button" href="<?=((isset($current['paid_users_generate_links']) and $current['paid_users_generate_links'] != '') ? 'no_link' : '#myModal_generate_link')?>">Direct Link</a></u></p>
								</div>
								<div class="col-md-7 linkibag">
									<p style="line-height: 3em;"><u><?=((isset($current['paid_users_generate_links']) and $current['paid_users_generate_links'] != '') ? $current['paid_users_generate_links'] : 'Not created, yet')?></u></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5 generate">
									<p><u>Make my profile unsearchable for everyone</u></p>
								</div>
								<div class="col-md-7 linkibag">
									<p><input type="checkbox" id="make_search" name="make_search" value="1" onclick="make_searchable(this.value);"<?=((isset($current['remove_profile']) and strlen($current['remove_profile']) == 10) ? ' checked' : '')?>/></p>
								</div>
							</div>
							
							<div class="col-md-5 generate">
								<div class="row">
									
									 
									 				
									<?php /*
									<p><span style="color:#31496a;"><u>My Linkibag search page </u> </span>  (avilable for all paid account)</p> 			
									<?=((isset($current['paid_users_generate_links']) and $current['paid_users_generate_links'] != '') ? '<p><u>Remove my Linkibag Profie From LInkibag search</u></p>' : '')?>					
									<p><u><a href="index.php?p=categories-list">Complete your interest form</a></u></p>	*/ ?>				
								</div>
							</div>

							<div class="col-md-7 linkibag">
								
								
								

								
								<?php /*
								<p><a style="color:grey;float: left;padding-right: 35px; line-height:2" data-toggle="modal" role="button" href="#myModal_generate_link">Generate Link</a> 
									<u><?=((isset($current['paid_users_generate_links']) and $current['paid_users_generate_links'] != '') ? $current['paid_users_generate_links'] : 'Not created, yet')?></u></p> 
									<?php if(isset($current['paid_users_generate_links']) and $current['paid_users_generate_links'] != ''){ ?>
									
									<p><a style="color:grey;float: left;padding-right: 77px; line-height:2" data-toggle="modal" role="button" href="#<?=((isset($current['remove_profile']) and strlen($current['remove_profile']) == 10) ? 'myModal_unremove_linkibag_profile_search' : 'myModal_remove_linkibag_profile_search')?>">
									
									<?=((isset($current['remove_profile']) and strlen($current['remove_profile']) == 10) ? ' Undo' : 'Remove')?></a> <?=((isset($current['remove_profile']) and strlen($current['remove_profile']) == 10) ? ' Removed on '.date('m/d/Y', $current['remove_profile']) : 'Not removed, yet')?>
									</p> 
									<?php } ?>
											
									<p>Optional for paid account</p>
									*/ ?>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				
				
				
				
				
				<div id="myModal_generate_link" class="modal fade in">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3 id="myModalLabel3">Generate Profile Direct Link</h3>
							</div>
							<div class="modal-body">
								<p>Are you sure!</p>
							</div>
							<div class="modal-footer">
								<div class="btn-group">
										<button class="orange-btn" data-dismiss="modal"> Close</button>&nbsp;
										<a href="index.php?p=account_settings&action_type=generate_links"><button class="orange-btn"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>
								</div>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dalog -->
				</div><!-- /.modal --> 
				
				
				<div id="<?=((isset($current['remove_profile']) and strlen($current['remove_profile']) == 10) ? 'myModal_unremove_linkibag_profile_search' : 'myModal_remove_linkibag_profile_search')?>" class="modal fade in">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3 id="myModalLabel3"><?=((isset($current['remove_profile']) and strlen($current['remove_profile']) == 10) ? 'Unremove my Linkibag Profie From LInkibag search' : 'Remove my Linkibag Profie From LInkibag search')?></h3>
							</div>
							<div class="modal-body">
								<p>Are you sure!</p>
							</div>
							<div class="modal-footer">
								<div class="btn-group">
										<button class="orange-btn" data-dismiss="modal">Close</button>&nbsp;
										<a href="index.php?p=account_settings&action_type=<?=((isset($current['remove_profile']) and strlen($current['remove_profile']) == 10) ? 'unremove_profile' : 'remove_profile')?>"><button class="orange-btn"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>
								</div>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dalog -->
				</div><!-- /.modal --> 
				</section><!-- /.modal --> 

				<a id="searchable_profile" data-toggle="modal" role="button" href="#" style="display: none;">Searchable Profile</a>
				<script type="text/javascript">
					function make_searchable(val){
						$('#searchable_profile').attr('href','#');
						if($('#make_search').prop('checked') == true){
							$('#searchable_profile').attr('href','#myModal_remove_linkibag_profile_search');
						}else{
							$('#searchable_profile').attr('href','#myModal_unremove_linkibag_profile_search');
						}

						$('#searchable_profile').trigger("click");	
						
					}

				</script>


				<style>
	/*.setting .account-setting .linkibag a {line-height: 3;}
	.setting .account-setting .generate a {line-height: 3;}
	.setting .account-setting .Site-links a {line-height: 3;}*/
     .lft {padding-left: 0;}
     #public-bag .advertise {color: #fff;background-color: #004080;border-color: none;border-radius: 0px;
     font-weight: 600;margin-top: 30px;padding: 5px 5px 5px 5px;}
     .containt-area {padding-bottom: 30px;}
	.lft ul li {padding-left: 0px;}
	.Home .lft {text-align: center;}
	.lft h5 {color: grey;}
	
	.account p {padding-top: 31px;padding-left: 34px;color: #31496a;}
	.Home ul li {display: inline;padding-left: 5px;}
	.Home .ul .li .strong {display: inline; padding-left: 0px;} 
	.center .Advertise {color: #fff;background-color: #31496a;border-color: #31496a;border-radius: 0px;
		font-weight: 600;margin-top: 14px;padding: 5px 5px 5px 5px;margin-left: -10px;}
		.linkibag a {line-height: 3;}
		.generate p {color: #465d96;}
		.linkibag p {color: grey;}
		/* */
		.generate a {line-height: 3;}
		.Home {padding-top: 17px;}
		/*.generate {width: 45.667%;}*/
		/*		.generate {width: 15.667%;}*/
		.Site-links a {line-height: 3;}
		.center {margin-bottom: 163px;}
		.setting .Site-links h5 {text-align: center;}
		/*	.settings {float: right;padding-top: 22px;width: 79%;}*/
		.settings h5 {float: left;color: #31496a;}
		.setting {border: 1px solid #FF7F27;float: right;margin-right: 3px;}
		.Site-links {width: 41.333%;}
	/*.Home .strong ul {padding-left: 0px;}
	.Home {padding-bottom: 80px;}
	.Home ul li {padding-left: 6px;display: inline;font-weight: 500;}
	.Home .btn-Advertise  {color: #fff;background-color: #31496a;border-color: #31496a;border-radius: 0px;*/
		font-weight: 600;margin-top: 90px;padding: 5px 5px 5px 5px;}
		/*.Home h5 {color: #004080;}
		.Home strong ul li a {padding-left: 0px;}*/
		/*	.account-setting {border: 1px solid #FF7F27;}*/
		.generate a {color: grey;}
		.Site-links a {color: grey;}
		@media only screen and (max-width: 500px) {
			.settings {margin-top: 13px;
				margin: 36px;}
			}
					@media only screen and (max-width: 1024px) {
			.settings {left: 0px;}
			.account p {padding-left: 18px;}
			}
			@media only screen and (max-width: 320px){
            .settings {width: 81%;}
			}
			.left-links p {margin: 0px;}
			.lft .welcome-name {margin-bottom: 13px;}
			/*
			.settings {
				border-top: 2px solid #FF7F27 ;
				padding: 31px;
				float: left;
			}
			*/

			.settings {
				border-top: 2px solid #ccc ;
				border-bottom: 2px solid #ccc ;
				padding: 15px 0px;
			}
			.account-setting-header > h3{
				margin: 0;
			    font-size: 15px;
			    font-weight: 600;
			    color: #465d96;
			}
			.account-setting-header > p{
				color: red;
			}
			u {
				text-decoration: none;
			}
			.completed_on {
			    margin-left: 32px;
			    margin-top: 33px;
			    color: grey;
			    text-decoration: underline;
			}
			</style>



			<?php

		}

		?>	


