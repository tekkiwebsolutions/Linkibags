<?php
$breadcrumb = 'View Subscribed Users';
$title = '<i class="fa fa-table"></i> View Subscribed Users';
$item_per_page = 12;

$advertiser = $co->getcurrent_admin();

$sql = "SELECT u.*, p.* from profile p, users u WHERE u.uid=p.uid";
$cond_arr = array();
if(isset($categories)) {
	$sql .= " and u.uid IN (SELECT DISTINCT(uid) FROM interested_category WHERE cat IN (:cats))";
	$cond_arr['cats'] = $categories;
}
if(isset($states)){
	$sql .= " and p.state IN (:states)";
	$cond_arr['states'] = $states;
}
if(@unserialize($advertiser['zipcode'])) {
	$sql .= " and p.zip_code IN (:zip_codes)";
	$cond_arr['zip_codes'] = implode(', ', unserialize($advertiser['zipcode']));
}
if(isset($_GET['save'])){
	if(isset($_GET['name_search']) and $_GET['name_search']!=''){
		$sql .= " AND (p.first_name LIKE :name OR u.email_id LIKE :name2)";
		$cond_arr['name'] = "%".$_GET['name_search']."%";
		$cond_arr['name2'] = "%".$_GET['name_search']."%";
	}
}
$sql .= " ORDER BY u.uid DESC";

$this_page = "p=user_management/manage";				

$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), $cond_arr);
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}	
			
?>
<form method="GET" enctype="multipart/form-data" class="form-horizontal">
	<input type="hidden" name="p" value="user_management/manage"/>
	<div class="form-group">
		<div class="col-sm-4">
			<input type="text" name="name_search" class="form-control" value="<?=(isset($_GET['name_search']) ? $_GET['name_search'] : '')?>" placeholder="Search with keywards"/>
		</div>
		<div class="col-sm-4">
			<button type="submit"  name="save" class="btn btn-primary">Send</button>
		</div>
	</div>
</form>

</div>
<div>
<table class="table table-hover table-striped">
	<thead>
		<tr>
			<th>Email</th><th>Account Type</th><th>Status</th><th>Created On</th><th>Last Login</th>
		</tr>
	</thead>
   <tbody>
	
		<?php
		$acc_type = array('','Personal','Business','Education');
		$status = array('Blocked','Active');	
		foreach($rows as $row){
		$s = $row['email_id'];
		$firstPart = strtok( $s, '@' );
		$allTheRest = strtok( '' ); 							
		?>
		<tr>
		
			<td><?='**@'.$allTheRest?></td>
			<td><?=$acc_type[$row['role']]?></td>
			<td><?=$status[$row['status']]?></td>
			<td><?=date('j F, Y',$row['created']);?></td>              
			<td><?=date('j F, Y',$row['last_login_time']);?></td>
		</tr>
		
		 <?php $i++; } ?>
	</tbody>
</table>
<nav class="text-center" style="display: none;">
	<ul class="pagination"><?=$co->getPagingLinks($sql, $cond_arr, $item_per_page, $this_page)?></ul>
</nav>								

</div>