<?php
$current_date = date('Y-m-d', time());
$commercial_ads = $co->query_first("select * from admin_ads WHERE uid='0' and expiration_date>=:date ORDER BY RAND()", array('date'=>$current_date));
?>

<div id="dash-sidebar" class="left-side-bar"> 
<div class="profile-nav-links-new">                
	<a class="btn orang-bg btn-block" href="index.php?p=dashboard"><i class="fa fa-chain"></i> Inbox</a>
	<a class="btn blue-bg btn-block" href="index.php?p=add_url"><i class="fa fa-check"></i> Add New Links</a>
	<a class="btn dark-gray-bg btn-block" href="index.php?p=shared-links"><i class="fa fa-share"></i> Share Links</a>
	<a class="btn green-bg btn-block" href="index.php?p=linkifriends"><i class="fa fa-users"></i> Linki Friends</a>
	<a class="btn light-brown-bg btn-block" href="index.php?p=search_friends"><i class="fa fa-search"></i> Connect</a>
</div>			

<div class="alert card profile-basic-info dashboard-profile-links">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<div class="main-profile-user">          
		<div class="profile-avatar-name">             
			<div class="profile-nav-links text-center">                
				<ul>                  
					<li>
						<a data-toggle="tooltip" title="Friends" class="list-group-item" href="index.php?p=linkifriends"><i class="fa fa-users green-bg"></i><span class="badge"><?=$total_friends?></span></a>                 
					</li>                  
					<li>                    
						<a data-toggle="tooltip" title="Total URLs Posted" class="list-group-item" href="index.php?p=dashboard&only_current=1"><i class="fa fa-paperclip dark-gray-bg"></i><span class="badge"><?=$total_urls?></span></a>                  
					</li>                  
					<li>
						<a data-toggle="tooltip" title="Total URLs shared" class="list-group-item" href="index.php?p=shared-links"><i class="fa fa-chain orang-bg"></i><span class="badge"><?=$total_friends_url?></span></a>
					</li>         
				</ul>              
			</div>           
		</div>          
	</div>        
</div> 
<div class="mid_block">
	<a class="btn btn-default btn_logout" style="margin: 0px;" href="logout.php">Sign Out &nbsp;&nbsp;<img style="width: 27px;" src="./images/sign-out.jpg"></a>
</div>
<div class="mid_block ads-left-sidebar">
	<?php
	if(isset($commercial_ads['photo_path']) and $commercial_ads['photo_path'] != ''){
		
	?>
	<button id="show" class="pull-right"><img src="images/cancel.jpg" /></button>
	<img src="<?=$commercial_ads['photo_path']?>" style="float: none; width: 100%;" class="img-responsive"><!-- /.list-group --><?php
	}
	?>
	<div style="display:none;" class="left-sidebar-ad"><a href="index.php?p=contact-us"><img src="images/ads-left.jpg" /></a></div>
</div>        
</div>  

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