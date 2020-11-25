<?php
function page_access(){
	global $co, $msg;
	$user_login = $co->is_userlogin();
	//if(!$user_login){
	//	echo '<script language="javascript">window.location="index.php";</script>';
	//	exit();
	//}

}
function page_content(){
	global $co, $msg;
	$no_record_found='';
	$co->page_title = "Profile | LinkiBag";
	$current = $co->getcurrentuser_profile();	
	if(!isset($_GET['id'])){
		echo '<script language="javascript">window.location="index.php?p=dashboard";</script>';
		exit();
	}
	$searched_people_profile = $co->get_searched_people_profile($_GET['id']);
	if(isset($searched_people_profile['uid']) and $searched_people_profile['uid']!=''){
	
		if(isset($_GET['views']) and $_GET['views']!=''){
			$item_per_page = $_GET['views'];
		}else{
			$item_per_page = 10;
		}
		$this_page='p=profile&id='.$searched_people_profile['uid'];
		$categories = $co->show_all_category();
		if(isset($_GET['cid']) and $_GET['cid']!=''){
			$this_page='p=profile&id='.$searched_people_profile['uid'].'&cid='.$_GET['cid'];
			$urlposts_retrun = $co->get_urlposts_by_category($_GET['cid'],$searched_people_profile['uid'],$item_per_page, $this_page);
			$urlposts = $urlposts_retrun['row'];
			$page_links = $urlposts_retrun['page_links'];
		}else{
			$urlposts_retrun = $co->get_all_urlposts($searched_people_profile['uid'],$item_per_page, $this_page);
			$urlposts = $urlposts_retrun['row'];
			$page_links = $urlposts_retrun['page_links'];
		}

		if(isset($_GET['views']) and $_GET['views']!=''){

			$this_page .= '&views='.$_GET['views'];

		}

	if(count($urlposts)<1)
		$no_record_found="No Record Found";
		
	$total_urls = $co->users_count_url($searched_people_profile['uid']);
	$total_friends = $co->users_count_friend($searched_people_profile['uid']);
	$total_friends_url = $co->users_count_shared_url($searched_people_profile['uid']);
	$account_type = '';
	if($searched_people_profile['role']==1)
		$account_type = 'Personal';
	else if($searched_people_profile['role']==2)
		$account_type = 'Business';
	else if($searched_people_profile['role']==3)
		$account_type = 'Education';
?>

<section id="public-bag">
	<div class="container-fluid bread-crumb top-line">
		<div class="col-md-7">
			<p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Profile</a></p>
		</div>
	</div>
	
	<div class="containt-area">
		
	
		<div class="container">
		
		<div class="col-md-3">
		<div id="sidebar">
		<div class="card profile-basic-info" style="display: inline-block; padding: 10px;">
		<!--<img alt="" src="http://byrushan.com/projects/ma/1-5-2/angular/img/profile-pics/5.jpg" class="img-responsive">-->
		<div class="main-profile-user">

          <div class="profile-avatar-name">
            <h2><?=$searched_people_profile['first_name']?> 
			<!--<small class="online-user"><i aria-hidden="true" class="fa fa-circle"></i> Online</small>--></h2>
			<!--<p class="text-sm">smait@gmail.com</p>-->
		  </div> <!-- /.profile-avatar -->
		  
		  <div class="req-btns">
		  
		  	
				
				<?php
					$check_for_pending_friend_request = $co->check_for_pending_friend_request($current['uid'], $_GET['id'],0);
					$become_friends = $co->check_for_pending_friend_request($current['uid'], $_GET['id'],1);
					if(!$check_for_pending_friend_request){
						if(!$become_friends){
					?>
				<form method="post" id="user_profile<?=$_GET['id']?>" action="index.php?p=profile_search&ajax=ajax_submit" onsubmit="javascript: return submit_profile(<?=$_GET['id']?>);">
				<input type="hidden" name="form_id" value="send_friend_request"/>
				<input type="hidden" name="id" value="<?=$_GET['id']?>"/>
					<div class="form-group">
						<button type="submit" id="send_profile_<?=$_GET['id']?>" class="btn btn-success custom-linikibag-btn">Add Friend </button>
					</div>
						<?php	
						
						}else{
						
							echo '<div class="form-group">
								<button type="submit" class="btn btn-success custom-linikibag-btn" disabled>Friend</button>
							</div>';
						}
						
						?>
				</form>	
					<?php 
					}else{
						echo '<div class="form-group">
								<button type="submit" class="btn btn-success custom-linikibag-btn" disabled>Pending Request</button>
							</div>';	
					?>
					<!--
						<form method="post" id="act_on_friend_request_<?php //$check_for_pending_friend_request['user_friend_id']?>" onsubmit="javascript:return false;" action="index.php?p=requests">
							<input type="hidden" name="form_id" value="act_on_friend_request"/>
							<input type="hidden" name="id" value="<?php //$current['uid']?>"/>
							<input type="hidden" name="user_id" value="<?php //$check_for_pending_friend_request['user_friend_id']?>"/>
							<div class="form-group">
								<button type="submit" id="acc_request_<?php //$check_for_pending_friend_request['user_friend_id']?>" class="btn btn-success custom-linikibag-btn" onclick="action_on_friend_request(<?php //$check_for_pending_friend_request['user_friend_id']?>)">Accept</button>
								<a class="btn btn-danger custom-linikibag-btn" href="#">Declined</a>
								
							</div>
							
						</form>	
					-->
					
						
					<?php	
					}
					?>
					
					
		  </div>
		  
		  <div class="pad-hor profile-avatar-name-sal">
			<h5 class="small-title"><i class="fa fa-lightbulb-o"></i> Salutation</h5>
			<small><?=$searched_people_profile['salutation']?></small>
		  </div>
		  
		  
		</div>
		</div>
		<div class="card profile-basic-info" style="display: inline-block; padding: 10px;">	
		  <h5 class="small-title"><i class="fa fa-globe"></i> Intro</h5>
		  <div class="list-group info-list-profile">  
			<ul>
			<li>
			<a class="list-group-item" href="javascript:;">
              <i class="fa fa-users"></i> &nbsp;&nbsp;Friends
              <span class="badge"><?=$total_friends?></span>
            </a>
			</li>
			<li>
			<a class="list-group-item" href="javascript:;">
              <i class="fa fa-ioxhost"></i> &nbsp;&nbsp;Account Type
			  <span class="badge back-tr"><?=$account_type?></span>
            </a>
			</li>
			<li>
			<a class="list-group-item" href="javascript:;">
              <i class="fa fa-paperclip"></i> &nbsp;&nbsp;Total Urls Posted
			  <span class="badge"><?=$total_urls?></span>
            </a>
			</li>
			<li>
			<a class="list-group-item" href="javascript:;">
              <i class="fa fa-chain"></i> &nbsp;&nbsp;Total Urls shared
              <span class="badge"><?=$total_friends_url?></span>
            </a>
			</li>
			</ul>			
			</div> <!-- /.list-group -->
		</div>
		<div class="card profile-basic-info" style="display: inline-block; padding: 10px;">	
		<h5 class="small-title"><i class="fa fa-search" style="font-size: 11px;"></i> Find Friends</h5>
		<div class="find-friends-home">  
			<form id="custom-search-form" class="form-search form-horizontal">
				<input type="hidden" name="p" value="profile_search" />
                <div class="input-append">
                    <input type="text" name="friend_search" required="required" class="search-query form-control" placeholder="Find Friends">
                    <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                </div>
            </form>		
		</div> <!-- /.list-group -->
		</div>
		</div>
		</div>			

			<div class="col-md-9 containt-area-dash">

				<div class="card">
					<ul class="nav nav-tabs" role="tablist">
						<li class="pull-right">
						<div class="nav-tabs-filters">

					

							<div class="dropdown">

								<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Views

								&nbsp;<span class="caret"></span></button>

								<ul class="dropdown-menu pull-right">

									<li><a href="index.php?p=dashboard&views=10">10</a></li>

									<li><a href="index.php?p=dashboard&views=25">25</a></li>

									<li><a href="#">50</a></li>

									<li><a href="#">100</a></li>

									<li><a href="#">All</a></li>

								</ul>

							</div>

						

							<div class="dropdown">

								<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Filter by Category 

								&nbsp;<span class="caret"></span></button>

								<ul class="dropdown-menu pull-right">

									<li><a href="index.php?p=profile&id=<?=$searched_people_profile['uid']?>">All Categories</a></li>	

									<?php 

									foreach($categories as $category){ 

									?>	

									<li><a href="index.php?p=profile&id=<?=$searched_people_profile['uid']?>&cid=<?=$category['cid']?>"><?=$category['cname']?></a></li>

									<?php } ?>

								</ul>

							</div>

						

				</div>

</li>

</ul>



<!-- Tab panes -->

<div class="tab-content">

	<div role="tabpanel" class="tab-pane active" id="my-links">

		<div class="recent-url-posts-main">

				

				<?php

					$i=1;

					if(isset($_GET['page'])){

						$i = ($item_per_page * ($_GET['page']-1))+1;

					}

					echo $no_record_found;

					foreach($urlposts as $urlpost){	

						$time_ago = $co->time_elapsed_string($urlpost['created_time']);	

						$row_cat = $co->get_single_category($urlpost['url_cat']);

						$tatal_comments = $co->count_total_comments($urlpost['url_id']);

				?>

				<div class="recent-url-posts">	

					<a href="index.php?p=url-detail&id=<?=$urlpost['url_id']?>"><i class="fa fa-link"></i> <?=$urlpost['url_value']?></a>

					

					

					<span>
						<div class="dashboard-btn-bottom btn-none edit-btns">
						<ul>
							

							

						</ul>
						</div>
					
					<div class="time-post"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$time_ago?></div></span><br/>

					<a class="url-category" href="&"><?=$row_cat['cname']?></a>

					

					<p><?=substr($urlpost['url_desc'],0,200)?></p>

					<div class="dashboard-btn-bottom separate-comment">
						
						
						<ul>
							<li><a style="color: rgb(255, 255, 255) ! important;" data-toggle="tooltip" title="View Comments" class="btn my-small-btn" href="index.php?p=url-detail&id=<?=$urlpost['url_id']?>"><i class="fa fa-comment"></i>  <b><?=$tatal_comments['total_comments']?></b> Comments</a></li>

							
							<!--<li><a class="btn" href="#"><i class="fa fa-share-alt"></i></a></li>-->

							<li><a style="color: rgb(255, 255, 255) ! important;" data-toggle="tooltip" title="Visit Website" class="btn my-small-btn org-bg" href="<?=$urlpost['url_value']?>" target="_blank"><i class="fa fa-eye"></i> Visit Website</a></li>

							

						</ul>
						
						

						<form method="post">

							<input type="hidden" name="form_id" value="delete_url_post"/>

							<input type="hidden" name="delid" value="<?=$urlpost['url_id']?>"/>

							<div id="myModal<?=$urlpost['url_id']?>" class="modal fade in">

								<div class="modal-dialog">

									<div class="modal-content">

										<div class="modal-header">

											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

											<h3 id="myModalLabel3">Deleting URL Post</h3>

										</div>

										<div class="modal-body">

											<p>Are you sure!</p>

										</div>

										<div class="modal-footer">

											<div class="btn-group">

													<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>

													<button class="btn btn-info" type="submit" name="save"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>

											</div>

										</div>

									</div><!-- /.modal-content -->

								</div><!-- /.modal-dalog -->

							</div>

						</form>	

						<ul style="display:none;">

							<li><a class="btn" href="index.php?p=url-detail&id=<?=$urlpost['url_id']?>"><i class="fa fa-comment"></i>view Comment</a></li>

							<li><a class="btn" href="#"><i class="fa fa-edit"></i>Edit</a></li>

							<li><a class="btn" href="#"><i class="fa fa-share-alt"></i>Share</a></li>

							<li><a class="btn" href="#"><i class="fa fa-eye"></i>Visit</a></li>

							<li><a class="btn" href="#"><i class="fa fa-trash-o"></i>delete</a>

							<a href="#" data-toggle="tooltip" title="Title Here">Hyperlink Text</a>

							</li>

						</ul>

					</div>

					

					

				</div>	

				<?php

				$i++; }	

				?>

				<nav class="text-center">

					<ul class="pagination"><?=$page_links?></ul>

				</nav>

			</div>

	</div>

	<div role="tabpanel" class="tab-pane" id="shate">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>

	</div>

</div>	
</section>

	
	


<?php
}else{
	exit();
}
}
?>