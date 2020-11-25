<?php
$current_date = date('Y-m-d', time());
$commercial_ads = $co->query_first("select * from admin_ads WHERE uid='0' and status=1 and expiration_date>=:date ORDER BY RAND()", array('date'=>$current_date));

?>
<?php /* <div class="welcome-name"><h2>Hi, <?php echo $current['first_name']?></h2></div> */ ?>

<div class="row">
<div class="sidebar-user-widget">
<a href="index.php?p=edit-profile">	<img class="img-responsive" alt="logo" src="<?=((isset($current['profile_photo']) and $current['profile_photo']!='') ? $current['profile_photo'] : 'images/user-pic.png')?>"></a>
	<Strong><?php
	if($current['first_name']=='')
	{
	     $arr = explode("@", $current['email_id'], 2);
      $name = $arr[0];
	}else{
	    $name= $current['first_name'].' '.$current['last_name'];
	}
	
	 echo $name;
	
	
	?><br/>
		<a href="#" style="pointer-events: none; text-decoration: none; word-break: break-all;">
		<?=(!empty($current['company_name']) ? $current['company_name'] : '')?>
		</a>
	</strong>
</div>
</div>

<div id="dash-sidebar" class="left-side-bar sidebar-welcome-name">
<div class="profile-nav-links-new dsktop-menu">
	<a class="btn orang-bg btn-block" href="index.php?p=dashboard"><img style="vertical-align: text-top;" src="images/white-icon.png" alt="bag Icon"> Inbag</a>
	<a class="btn blue-bg btn-block" href="index.php?p=add_url"><i class="fa fa-check"></i> Add Links</a>
	<a class="btn green-bg btn-block" href="index.php?p=linkifriends"><i class="fa fa-users"></i> LinkiFriends</a>
	<a class="my_links btn light-brown-bg btn-block" href="index.php?p=mylinks"><i class="fa fa-heart"></i> My Links</a>
	<a class="btn dark-gray-bg btn-block" href="index.php?p=linkibook"><i class="fa fa-pencil"></i> LinkiBooks</a>

	<?php /* ?>
	<?php if($current['role'] == 2 OR $current['role'] == 3){ ?>
	<a class="btn orang-bg btn-block" href="index.php?p=search-urls"><i class="fa fa-search"></i> Search URLs</a>
	<?php } ?>
	<a class="btn blue-bg btn-block" href="index.php?p=close-account"><i class="fa fa-lock"></i> Close Account</a>
	<?php */ ?>
</div>
<div class="mobile_menu">
	<div class="dropdown">
		  <button class="btn button-grey menu-btn" type="button" id="linkiMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu</button>
		<div class="dropdown-menu" aria-labelledby="linkiMenuButton">
			<div class="profile-nav-links-new">
			<a class="btn orang-bg btn-block" href="index.php?p=dashboard"><img style="vertical-align: text-top;" src="images/white-icon.png" alt="bag Icon"> Inbag</a>
			<a class="btn blue-bg btn-block" href="index.php?p=add_url"><i class="fa fa-check"></i> Add Links</a>
			<a class="btn green-bg btn-block" href="index.php?p=linkifriends"><i class="fa fa-users"></i> LinkiFriends</a>
			<a class="btn light-brown-bg btn-block" href="index.php?p=search_friends"><i class="fa fa-chain"></i> Invites</a>
			<a class="btn dark-gray-bg btn-block" href="logout.php"><i class="fa fa-sign-out"></i> Sign Out</a>
			</div>
		</div>
	</div>
</div>
<div class="alert card profile-basic-info dashboard-profile-links">
	<div class="main-profile-user">
		<div class="profile-avatar-name">
			<div class="profile-nav-links text-center">
				<ul>
					<li>
						<?php
						/*<a data-toggle="tooltip" title="New inbag messages" class="list-group-item" href="index.php?p=shared-links"><i class="fa orang-bg"><img style="vertical-align: text-top;" src="images/white-icon.png" alt="New inbag messages"></i><span class="badge" id="new_linkibag_message"><?=$total_friends_url?></span></a>*/
						?>
						<a data-toggle="tooltip" title="New <?=isset($default_folder_name) ? $default_folder_name : 'inbag'?> messages" class="list-group-item" href="index.php?p=dashboard"><i class="fa orang-bg"><img style="vertical-align: text-top;" src="images/white-icon.png" alt="New inbag messages"></i><span class="badge new_linkibag_message"><?=$total_friends_url?></span></a>
					</li>
					<li>
						<a data-toggle="tooltip" title="New connect requests" class="list-group-item" href="index.php?p=linkifriends&fstatus=1"><i class="fa fa-users green-bg"></i><span class="badge" id="new_linkibag_friends_side"><?=$total_friends?></span></a>
					</li>
					<li>
						<?php /* <a data-toggle="tooltip" title="Pending invites" class="list-group-item" href="index.php?p=dashboard&only_current=1"><i class="fa fa-link light-brown-bg"></i><span class="badge"><?=$total_urls?></span></a>  */ ?>
						<?php /*
						<a data-toggle="tooltip" title="Pending requests" class="list-group-item" href="index.php?p=mylinkifriends"><i class="fa fa-link light-brown-bg"></i><span class="badge"><?=$total_urls?></span></a>
						*/
						?>
						<a data-toggle="tooltip" title="Pending requests" class="list-group-item" href="index.php?p=linkifriends&fstatus=0"><i class="fa fa-link light-green-bg"></i><span class="badge" id="sidebar_pending_req_count"><?=$total_urls?></span></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php
//for business and educational accounts only

?>
<div style="display: none;" class="services-block-sidebar<?=(($current['role'] == 2 or $current['role'] == 3) ? '' : ' non-paid-mamber')?>">
	<h4 class="text-blue">Premium Services</h4>
	<ul class="linkibag-list">
		<li><a href="index.php?p=web-resources-list">LinkiBooks</a></li>
		<li><a href="index.php?p=member_search">Members Search</a></li>
		<li><a href="#">Share and Search Within Your Organization</a></li>
	</ul>
</div>
<?php
//for personal or free accounts
if(isset($commercial_ads['photo_path']) and $commercial_ads['photo_path'] != '' and $current['role'] == 1){
?>
<div class="mid_block ads-left-sidebar">
	<span class="pull-right add-link">
		<!-- Sponsored
		<a href="<?=$commercial_ads['img_url']?>" target="_blank" id="show">
	<img src="images/cancel.jpg" /></a> -->
</span>
	<img src="<?=$commercial_ads['photo_path']?>" style="float: none;" class="img-responsive"><!--/.list-group-->	<div class="text-center"><a class="add-link" href="index.php?p=contact-us">Place your add here</a></div>
</div>
<?php
	}
?>

<!-- <div class="sidebar-search">
	<form action="index.php" method="get">
		<input type="hidden" name="p" value="link-search" />
		<label>Search</label>
		<input type="text" class="form-control input-sm" name="url" />
	</form>
</div> -->



</div>
<!--<a href="index.php?p=contact-us">Contact Us</a>-->

<style>
.ads-left-sidebar {
    position: relative;
}
.left-sidebar-ad {
    background: #086aa7 none repeat scroll 0 0;
    position: absolute;
    text-align: center;
    top: 0;
    width: 100%;
}
.ads-left-sidebar #show {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    padding: 0;
    position: absolute;
    right: 4px;
}
</style>
