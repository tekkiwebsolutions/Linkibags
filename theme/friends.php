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

	$co->page_title = "Dashboard | LinkiBag";

	$current = $co->getcurrentuser_profile();
	$user_profile_info = $co->call_profile($current['uid']);
	$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');
	
	$total_urls = $co->users_count_url($current['uid']);
	$total_friends = $co->users_count_friend($current['uid']);
	$total_friends_url = $co->users_count_shared_url($current['uid']);

	//$item_per_page = 2;	

	//$this_page='p=friends';

	$categories = $co->show_all_category();

	$friends = $co->list_all_friends_of_current_user_with_paging($current['uid']);


	//$page_links = $all_friends['page_links'];
	
	$all_awaited_request = $co->list_all_awaited_of_current_user_with_paging($current['uid']);
	
	$all_sent_request = $co->list_all_sent_requests_by_current_user_with_paging($current['uid']);


	//$awaited_request_page_links = $all_awaited_requests['page_links'];

	/*

	if(isset($_GET['delid'])){



		$co->query_delete('user_urls', array('id'=>$_GET['delid']),'url_id=:id');



		$co->setmessage("error", "URL post has been successfully deleted");

		echo '<script type="text/javascript">window.location.href="index.php?p=dashboard"</script>';

		exit();

	}

	*/

?>

<section id="public-bag">

	<div class="container-fluid bread-crumb top-line">

		<div class="col-md-7">

			<p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Dashboard</a></p>

		</div>

	</div>

	<div class="containt-area">	

		

		<div class="container">

			<div class="containt-area-dash col-md-9">			

						

			

<div class="card">

<ul class="nav nav-tabs" role="tablist">

<li role="presentation" class="active"><a href="#contacts" aria-controls="contacts" role="tab" data-toggle="tab">Contacts (<span id="friend_badge"><?=count($friends)?></span>)</a></li>

<li role="presentation"><a href="#awaited_request" aria-controls="awaited_request" role="tab" data-toggle="tab">Waiting Your Approval  (<span id="wait_request_badge"><?=count($all_awaited_request)?></span>)</a></li>

<li role="presentation"><a href="#sent_requests" aria-controls="sent_requests" role="tab" data-toggle="tab">Pending Sent Requests (<span id="pending_request_badge"><?=count($all_sent_request)?></span>)</a></li>


</ul>



<!-- Tab panes -->

<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="contacts">
			<div class="row profile_search_list">
				<ul class="tvc-lists url-GET-comment">
					<?php
					foreach($friends as $friend){
					?>
						<li class="media profile_single_list">
							<div class="media-body">
								<div class="person_name">
									<h4><a href="index.php?p=profile&id=<?=$friend['uid']?>">
										<?=$friend['first_name']?> <?=$friend['last_name']?>
									</a></h4>
									<div class="pad-hor profile-avatar-name-sal">
									<h5 class="small-title"><i class="fa fa-lightbulb-o"></i> Salutation</h5>
									<small><?=$friend['salutation']?></small>
									</div>
								</div>
								<div class="person_links_main_box">
								
								
								</div>
							</div>
						</li>
					<?php
					}	
					?>
				</ul>
				<div class="clearfix"></div>
				<nav class="text-center">
					<ul class="pagination"><?php //$page_links?></ul>
				</nav>		
			</div>				
		</div>

		<div role="tabpanel" class="tab-pane" id="awaited_request">
			<div class="row profile_search_list">
				<ul class="tvc-lists url-GET-comment">
					<?php
					foreach($all_awaited_request as $awaited_request){
					?>
						<li class="media profile_single_list" id="wait_block_<?=$awaited_request['user_friend_id']?>">
							<div class="media-body">
								<div class="person_name">
									<h4><a href="index.php?p=profile&id=<?=$awaited_request['uid']?>">
										<?=$awaited_request['first_name']?> <?=$awaited_request['last_name']?>
									</a></h4>
									<div class="pad-hor profile-avatar-name-sal">
									<h5 class="small-title"><i class="fa fa-lightbulb-o"></i> Salutation</h5>
									<small><?=$awaited_request['salutation']?></small>
									</div>
								</div>
								<div class="person_links_main_box">										
									<form method="post" id="act_on_friend_request_<?=$awaited_request['user_friend_id']?>" onsubmit="javascript:return false;" action="index.php?p=requests">
										<input type="hidden" name="form_id" value="act_on_friend_request"/>
										<input type="hidden" name="id" value="<?=$awaited_request['request_to']?>"/>
										<input type="hidden" name="user_id" value="<?=$awaited_request['user_friend_id']?>"/>
										<div class="person_links_footer">											
											<button type="submit" id="acc_request_<?=$awaited_request['user_friend_id']?>" class="btn btn-success custom-linikibag-btn" onclick="action_on_friend_request(<?=$awaited_request['user_friend_id']?>)">Accept</button>
											<a class="btn btn-danger custom-linikibag-btn" id="dec_request_<?=$awaited_request['user_friend_id']?>" href="javascript:void(0)" onclick="decline_friend_request(<?=$awaited_request['user_friend_id']?>)">Declined</a>
										</div>										
									</form>									
								</div>
							</div>
						</li>
					<?php
					}	
					?>
				</ul>
				<div class="clearfix"></div>
				<nav class="text-center">
					<ul class="pagination"><?php //$awaited_request_page_links?></ul>
				</nav>		
			</div>				
		</div>
		<div role="tabpanel" class="tab-pane" id="sent_requests">
			<div class="row profile_search_list">
				<ul class="tvc-lists url-GET-comment">
					<?php
					foreach($all_sent_request as $sent_request){
					?>
						<li class="media profile_single_list" id="request_block_<?=$sent_request['user_friend_id']?>">
							<div class="media-body">
								<div class="person_name">
									<h4><a href="index.php?p=profile&id=<?=$sent_request['uid']?>">
										<?=$sent_request['first_name']?> <?=$sent_request['last_name']?>
									</a></h4>
									<div class="pad-hor profile-avatar-name-sal">
									<h5 class="small-title"><i class="fa fa-lightbulb-o"></i> Salutation</h5>
									<small><?=$sent_request['salutation']?></small>
									</div>
								</div>
								<div class="person_links_main_box">										
									<div class="person_links_footer">
										<a class="btn btn-danger custom-linikibag-btn" href="javascript:void(0)" onclick="cancel_friend_request(<?=$sent_request['user_friend_id']?>)">Cancel Request</a>
									</div>
								</div>
							</div>
						</li>
					<?php
					}	
					?>
				</ul>
				<div class="clearfix"></div>
				<nav class="text-center">
					<ul class="pagination"><?php //$awaited_request_page_links?></ul>
				</nav>		
			</div>				
		</div>
		
	</div>
</div>

			

			

			

			

			

		</div>
		
		
		<div class="col-md-3">
		<div id="dash-sidebar">
		<div class="card profile-basic-info" style="display: inline-block; padding: 10px;">
		<!--<img alt="" src="http://byrushan.com/projects/ma/1-5-2/angular/img/profile-pics/5.jpg" class="img-responsive">-->
		<div class="main-profile-user">
          <div class="profile-avatar-name">
            	<div class="profile-nav-links">
				<ul>
					<li>
						<a data-toggle="tooltip" title="Friends" class="list-group-item" href="index.php?p=friends">
						  <i class="fa fa-users"></i>
						  <span class="badge"><?=$total_friends?></span>
						</a>
					</li>
					<li>
						<a data-toggle="tooltip" title="Total Urls Posted" class="list-group-item" href="javascript:;">
						  <i class="fa fa-paperclip"></i>
						  <span class="badge"><?=$total_urls?></span>
						</a>
					</li>
					<li>
						<a data-toggle="tooltip" title="Total Urls shared" class="list-group-item" href="javascript:;">
						  <i class="fa fa-chain"></i>
						  <span class="badge"><?=$total_friends_url?></span>
						</a>
					</li>
				</ul>
				</div>
		  </div> <!-- /.profile-avatar -->
		  
		 
		  
		  <div class="pad-hor profile-avatar-name-sal">
			<h5 class="small-title"><i class="fa fa-lightbulb-o"></i> Salutation</h5>
			<small><?=$user_profile_info['salutation']?></small>
		  </div>
		  
		  
		</div>
		</div>
		<div class="card profile-basic-info" style="display: inline-block; padding: 10px;">	
		<h5 class="small-title"><i class="fa fa-search" style="font-size: 11px;"></i> Find Friends</h5>
		<div class="find-friends-home">  
			<form class="form-search form-horizontal" method="get">
				<input type="hidden" name="p" value="profile_search" />
                <div class="input-append">
                    <input type="text" name="friend_search" required="required" class="search-query form-control" placeholder="Find Friends">
                    <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                </div>
            </form>		
		</div> <!-- /.list-group -->
		</div>
		
		<div class="card profile-basic-info" style="display: inline-block; padding: 10px;">	
		<h5 class="small-title"><i class="fa fa-chain" style="font-size: 11px;"></i> Shared Links</h5>
		<div class="friends-shared-link">  
			<ul>
			<?php 
			foreach($list_shared_links_by_admin as $list_shared_links_by_admn){
			?>
				<li>
				<h4><a target="_blank" href="<?=$list_shared_links_by_admn['url_value']?>"><i class="fa fa-link"></i><?=$list_shared_links_by_admn['url_value']?></a></h4>
				<small><a href="index.php?p=dashboard&amp;id=7" class="url-category"><?=$list_shared_links_by_admn['cname']?></a></small>
				</li>
			<?php } ?>	
			</ul>		
		</div> <!-- /.list-group -->
		</div>
		</div>
		</div>	

	</div>

</section>







<?php

}

?>