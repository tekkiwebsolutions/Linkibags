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
	$co->page_title = "Search for friend| LinkiBag";
	$current = $co->getcurrentuser_profile();
	$this_page='p=profile_search';
	if(isset($_GET['friend_search']))
		$this_page.='&friend_search='.$_GET['friend_search'];
	
	$item_per_page = 12;
	
?>
<section id="public-bag">
	<div class="container-fluid bread-crumb top-line">
		<div class="col-md-7">
			<p><a href="index.php">Home</a> > <a href="index.php?p=profile_search&friend_search=<?=(isset($_GET['friend_search']) ? $_GET['friend_search'] : '')?>">Profile search</a></p>
		</div>
	</div>
		
	<div class="containt-area">	
		<div class="container">
			<div class="containt-area-dash">
				<div class="card">
					<div class="profile_search_form_block">
						<form method="get">
							<input type="hidden" name="p" value="profile_search" />
							<div class="input-group col-sm-4 pull-right">
								<input type="text" name="friend_search" class="form-control" value="<?=((isset($_GET['friend_search'])) ? $_GET['friend_search'] : '')?>" placeholder="Search People" />
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit">Go!</button>
								</span>
							</div>
							<div class="clearfix"></div>
						</form>										
					</div>
					<div class="clearfix"></div>
					<div class="row profile_search_list">
						
						<?php
						$page_links='';
						if(isset($_GET['friend_search']) and $_GET['friend_search']!=''){
							if(isset($current['uid']))
								$current_uid = $current['uid'];
							else
								$current_uid = 0;
							$search_friends_lists = $co->search_for_friend_request($_GET['friend_search'],$item_per_page, $this_page, $current_uid);
							$row_count = $search_friends_lists['row_count'];
							$search_friend_lists = $search_friends_lists['row'];
							$page_links = $search_friends_lists['page_links'];
							if(count($search_friend_lists)>0){
							?>
							<p><?=$row_count?> result found for "<?=$_GET['friend_search']?>"</p>
						<ul class="tvc-lists url-GET-comment">
							<?php
							foreach($search_friend_lists as $search_friend_list){
								$num_urls = $co->users_count_url($search_friend_list['uid']);
								$num_friends = $co->users_count_friend($search_friend_list['uid']);
							?>
								<li class="media profile_single_list">
									<!--
									<div class="pull-left">
										<a class="tvh-user" href="">
											<img alt="" src="http://byrushan.com/projects/ma/1-5-2/angular/img/profile-pics/5.jpg" class="img-responsive">
										</a>
									</div>
									-->
									<div class="media-body">
										<div class="person_name">
											<h4><a href="index.php?p=profile&id=<?=$search_friend_list['uid']?>">
												<?=$search_friend_list['first_name']?> <?=$search_friend_list['last_name']?>
											</a></h4>
											<div class="pad-hor profile-avatar-name-sal">
											<h5 class="small-title"><i class="fa fa-lightbulb-o"></i> Salutation</h5>
											<small><?=$search_friend_list['salutation']?></small>
											</div>
										</div>
										<div class="person_links_main_box">
										<div class="person_links">
											<a class="person_links_btn" href="index.php?p=profile&id=<?=$search_friend_list['uid']?>"><i class="fa fa-link"></i> <?=$num_urls?></a>
											<a class="person_links_btn" href="index.php?p=profile&id=<?=$search_friend_list['uid']?>"><i class="fa fa-users"></i> <?=$num_friends?></a>
										</div>
										<form method="post" id="user_profile<?=$search_friend_list['uid']?>" action="index.php?p=profile_search&ajax=ajax_submit" onsubmit="javascript: return submit_profile(<?=$search_friend_list['uid']?>);">
										<input type="hidden" name="form_id" value="send_friend_request"/>
										<input type="hidden" name="id" value="<?=$search_friend_list['uid']?>"/>
											<div class="person_links_footer">
												<?php
												$check_for_pending_friend_request = $co->check_for_pending_friend_request($current['uid'], $search_friend_list['uid'],0);
												$become_friends = $co->check_for_pending_friend_request($current['uid'], $search_friend_list['uid'],1);
												if(!$check_for_pending_friend_request){
													if(!$become_friends){
												?>
														<button type="submit" id="send_profile_<?=$search_friend_list['uid']?>" class="btn btn-success custom-linikibag-btn">Add Friend </button>
														
												<?php	
													}else{
													
														echo '<button type="submit" class="btn btn-success custom-linikibag-btn" disabled>Friend</button>';
													}
													
												?>
											
												
												<?php 
												
												}else{
													
													echo '<button type="submit" id="send_profile_'.$search_friend_list['uid'].'" class="btn btn-success custom-linikibag-btn" disabled>Pending Request </button>';

												}?>
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
							<ul class="pagination"><?=$page_links?></ul>
						</nav>
							<?php
							}else{
								echo 'We could not find any result for this search';
							}
						}else{
							echo 'No record found. Please search for any people then you will see a list of user';
						}
						?>							
					</div>
					<div class="clearfix"></div>
				</div>			
			</div>
		</div>
	</div>
</section>
<?php
}
?>
