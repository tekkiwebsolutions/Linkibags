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
	//$this_page='p=profile_search';
	//if(isset($_GET['friend_search']))
	//	$this_page.='&friend_search='.$_GET['friend_search'];
	
	//$item_per_page = 12;
	
?>
<section id="public-bag">
	<div class="container-fluid bread-crumb top-line">
		<div class="col-md-7">
			<p><a href="index.php">Home</a> > <a href="index.php?p=requests">Requests</a></p>
		</div>
	</div>
		
	<div class="containt-area">	
		<div class="container">
			<div class="containt-area-dash">
				<div class="card">
					<div class="profile_search_form_block">
						
					</div>
					<div class="clearfix"></div>
					<div class="row profile_search_list">
						
						<?php
					
							$all_friend_requests = $co->show_all_friend_requests($current['uid'],0);
							if(count($all_friend_requests)>0){
							?>
							
						<ul class="tvc-lists url-GET-comment">
							<?php
							foreach($all_friend_requests as $all_friend_request){
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
											<h4><a href="index.php?p=profile&id=<?=$all_friend_request['uid']?>">
												<?=$all_friend_request['first_name']?> <?=$all_friend_request['last_name']?>
											</a></h4>
											<div class="pad-hor profile-avatar-name-sal">
											<h5 class="small-title"><i class="fa fa-lightbulb-o"></i> Salutation</h5>
											<small><?=$all_friend_request['salutation']?></small>
											</div>
										</div>
										<div class="person_links_main_box">
										
										<form method="post" id="act_on_friend_request_<?=$all_friend_request['user_friend_id']?>" onsubmit="javascript:return false;" action="index.php?p=requests">
											<input type="hidden" name="form_id" value="act_on_friend_request"/>
											<input type="hidden" name="id" value="<?=$all_friend_request['request_to']?>"/>
											<input type="hidden" name="user_id" value="<?=$all_friend_request['user_friend_id']?>"/>
											<div class="person_links_footer">
												<?php
												//$check_if_any_friend_request = $co->check_if_any_friend_request($current['uid'], $search_friend_list['uid']);
												//if(!$check_if_any_friend_request){
												?>
											
												<button type="submit" id="acc_request_<?=$all_friend_request['user_friend_id']?>" class="btn btn-success custom-linikibag-btn" onclick="action_on_friend_request(<?=$all_friend_request['user_friend_id']?>)">Accept</button>
												<a class="btn btn-danger custom-linikibag-btn" id="dec_request_<?=$all_friend_request['user_friend_id']?>" href="javascript:void(0)" onclick="decline_friend_request(<?=$all_friend_request['user_friend_id']?>)">Declined</a>
												<?php 
												//}else{
												//	echo '<button class="btn btn-success custom-linikibag-btn" disabled>Pending Request </button>';

												//}?>
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
							<ul class="pagination"><?php //$page_links?></ul>
						</nav>
							<?php
							}else{
								echo 'No friend request yet';
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
