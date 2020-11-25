<?php
$breadcrumb = '';
$title = '';
$advertiser = $co->getcurrent_admin();
if(@unserialize($advertiser['category'])) {
	$categories = implode(',', unserialize($advertiser['category']));
	$category = $co->fetch_all_array("SELECT * FROM category WHERE cid IN (:categories)", array('categories'=>$categories));
}

if(@unserialize($advertiser['state'])) {
	$states = implode(',', unserialize($advertiser['state']));
	$state = $co->query_first("SELECT GROUP_CONCAT(state_name) as allstates FROM states WHERE id IN (:states)", array('states'=>$states));
}

$user_sql = "SELECT u.*, p.* from profile p, users u WHERE u.uid=p.uid";
$user_total_sql = "SELECT COUNT(u.uid) as total from profile p, users u WHERE u.uid=p.uid";
$user_cond = array();
if(isset($categories)) {
	$user_sql .= " and u.uid IN (SELECT DISTINCT(uid) FROM interested_category WHERE cat IN (:cats))";
	$user_total_sql .= " and u.uid IN (SELECT DISTINCT(uid) FROM interested_category WHERE cat IN (:cats))";
	$user_cond['cats'] = $categories;
}
if(isset($states)){
	$user_sql .= " and p.state IN (:states)";
	$user_total_sql .= " and p.state IN (:states)";
	$user_cond['states'] = $states;
}
if(@unserialize($advertiser['zipcode'])) {
	$user_sql .= " and p.zip_code IN (:zip_codes)";
	$user_total_sql .= " and p.zip_code IN (:zip_codes)";
	$user_cond['zip_codes'] = implode(', ', unserialize($advertiser['zipcode']));
}
$total_users = $co->query_first($user_total_sql, $user_cond);

$user_sql .= " ORDER BY u.uid DESC LIMIT 5";

$all_users = $co->fetch_all_array($user_sql, $user_cond);

$all_links = $co->fetch_all_array("SELECT * FROM admin_ads WHERE adid=:adid ORDER BY aid DESC LIMIT 5", array('adid'=>$advertiser['adid']));


$pending_links = $co->query_first("SELECT COUNT(adid) as total FROM admin_ads WHERE adid=:adid and status=:status", array('adid'=>$advertiser['adid'], 'status'=>0));
$approved_links = $co->query_first("SELECT COUNT(adid) as total FROM admin_ads WHERE adid=:adid and status=:status", array('adid'=>$advertiser['adid'], 'status'=>1));
$declined_links = $co->query_first("SELECT COUNT(adid) as total FROM admin_ads WHERE adid=:adid and status=:status", array('adid'=>$advertiser['adid'], 'status'=>-1));
?>
<!-- 
<section class="dashboard-page">
	<div class="dashboard-row-one">
	<div class="row">
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="ion-person-stalker fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge"><?=$total_users['total']?></div>
							<div>User Registered</div>
						</div>
					</div>
				</div>
				<a href="main.php?p=user_management/manage">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-green">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="ion-network fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge"><?=$pending_links['total']?></div>
							<div>Total Pending Links</div>
						</div>
					</div>
				</div>
				<a href="main.php?p=ads_management/manage&status=pending">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-yellow">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="ion-ios-people fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge"><?=$approved_links['total']?></div>
							<div>Total Approved Links</div>
						</div>
					</div>
				</div>
				<a href="main.php?p=ads_management/manage&status=approved">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-red">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="ion-ios-world fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge"><?=$declined_links['total']?></div>
							<div>Total Declined Links</div>
						</div>
					</div>
				</div>
				<a href="main.php?p=ads_management/manage&status=declined">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
	</div>
	</div>
	<div class="dashboard-row-scound">	
	<div class="row">
	<div class="col-lg-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="ion-person-stalker fa-fw"></i> Subscribe Detail </h3>
			</div>
			<div class="panel-body">
				<div class="list-group user-registered">
					<p>You are subscribe with following:</p>
					<strong>Interested in Category:</strong>
					<?php
					if(isset($category)) {
						echo '<ul>';
						foreach ($category as $c) {
							echo '<li>'.$c['cname'].'</li>';
						}
						echo '</ul>';
					}else {
						echo '<br /> not yet defined!';
					}
					?>

					<strong>User's Locations:</strong>
					<?php
					if(isset($state)) {
						echo '<br />States: '.$state['allstates'];
					}
					if(@unserialize($advertiser['zipcode'])) {
						echo '<br />Zipcodes: '.implode(', ', unserialize($advertiser['zipcode']));
					}
					?>

				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="panel panel-green">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa fa-link fa-fw"></i> All Uploaded URLs <a href="main.php?p=ads_management/manage"> View All <i class="fa fa-arrow-circle-right"></i></a></h3>
			</div>
			<div class="panel-body">
				<div class="list-group user-registered">
					<?php
					if(count($all_links)>0){
    					foreach ($all_links as $link) {
    						$status = 'Declined';
    						if($link['status']==1){
    							$status = 'Approved';
    						}elseif($link['status']==0){
    							$status = 'Pending';
    						}
    
    						echo '
    						<span class="list-group-item">
    							'.$link['title'].' <small>'.$status.'</small><br>
    							<a href="javascript: void(0)" class="created-on">Expired on '.date('j F, Y',strtotime($link['expiration_date'])).'</a>
    						</span>
    						';
    					}
					}else{
					    echo 'no data yet!';
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="panel panel-yellow">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="ion-ios-people fa-fw"></i> Users <a href="main.php?p=user_management/manage"> View All <i class="fa fa-arrow-circle-right"></i></a></h3>
			</div>
			<div class="panel-body">
				<div class="list-group user-registered online-users">
					<?php
					if(count($all_users)>0){
    					foreach ($all_users as $u) {
    						$status = 'Declined';
    						if($link['status']==1){
    							$status = 'Approved';
    						}elseif($link['status']==0){
    							$status = 'Pending';
    						}
    
    						echo '
    						<a class="list-group-item" href="#">
    							<span class="badge"><i class="ion-university"></i></span>
    							<div class="badge-name">'.substr($u['first_name'], 0, 1).'</div>
    							'.$u['first_name'].' '.$u['last_name'].'<br>
    							<small class="created-on"><b>Created On</b> : '.date('j F, Y',$u['created']).'</small>
    						</a>
    						';
    					}
					}else{
					    echo 'no data yet!';
					}
					?>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	
</section> -->