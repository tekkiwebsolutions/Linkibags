<?php
$status = '-1, 0, 1';
$title = '<i class="fa fa-table"></i> Manage Your Links';

if(isset($_GET['status'])){
	if($_GET['status']=='pending') {
		$status = '0';
		$title = '<i class="fa fa-table"></i> Manage Pending Links';
	}elseif($_GET['status']=='approved') {
		$status = '1';
		$title = '<i class="fa fa-table"></i> Manage Approved Links';
	}elseif($_GET['status']=='declined') {
		$status = '-1';
		$title = '<i class="fa fa-table"></i> Manage Declined Links';
	}
}

$item_per_page = 12;

if(isset($_COOKIE['advertiser_uid']) && isset($_COOKIE['advertiser_website']) && $_COOKIE['admin_website']=="Linkibag advertiser")
{
	$adid = $_COOKIE['advertiser_uid'];
}
elseif(isset($_SESSION['advertiser_uid']) && isset($_SESSION['advertiser_website']) && $_SESSION['advertiser_website']=="Linkibag advertiser")
{			
	$adid = $_SESSION['advertiser_uid'];
}else{
	echo '<script type="text/javascript">window.location.href="logout.php"</script>';
	exit();
}

$category = $co->fetch_all_array("SELECT * FROM category ", array());

$select_status='';
if(isset($_POST['select_status']))
{
	$select_status=$_POST['select_status'];
}
$sql = " SELECT * from admin_ads WHERE adid=:adid ";
$cond_arr = array();
$cond_arr['adid'] = $adid;
if(isset($_POST['select_status'])){
	
	$sql .= " and status IN (:status) ";
	$cond_arr['status'] = $_POST['select_status'];
}

$sql .=" ORDER BY aid desc";

$this_page = "p=ads_management/manage";				


$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), $cond_arr);
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}

	
?>
<div class="table-responsive">									
                                    <table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>No</th><th>Category</th><th>Number of Users</th>
											</tr>
										</thead>
									   <tbody>
										
											<?php
										$j=1;
											foreach($category as $c){
												$cat = $c['cid'];
$countUser = $co->query_first("SELECT COUNT(adid) as total FROM admin_advertisement WHERE category REGEXP :cat and status=:status", array('cat'=>$cat, 'status'=>1));

											?>
											<tr>
												<td><?=$j?></td>
												<td><?=$c['cname']?></td>												
												<td><?=$countUser['total'] ?></td>												
												
											</tr>
											
											 <?php $j++; } ?>
										</tbody>
									</table>
									
                                </div>
<hr>
								<form method="POST" enctype="multipart/form-data" class="form-horizontal">
<input type="hidden" name="p" value="user_management/manage"/>
<div class="form-group">
	<div class="col-sm-4">
		<select name="select_status" class="form-control"  >
		<option value="1">Approved</option>
		<option <?php if( $select_status=='1') { ?> selected="selected" <?php } ?> value="1">All</option>
		<option <?php if( $select_status=='0') { ?> selected="selected" <?php } ?>  value="0">Pending</option>
		<option <?php if( $select_status=='-1') { ?> selected="selected" <?php } ?>  value="-1">Expired</option>
	</select>
	</div>
	<div class="col-sm-4">
		<button type="submit"  name="save" class="btn btn-primary">Send</button>
	</div>
</div>
</form>						
                                <div class="table-responsive">									
                                    <table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>No</th><th>Link</th><th>Subject</th><th>Status</th>
											</tr>
										</thead>
									   <tbody>
										
											<?php
													
											foreach($rows as $row){							
											?>
											<tr>
												<td><?=$i?></td>
												<td><?=$row['img_url']?></td>												
												<td><?=substr($row['title'],0,35).'...';?></td>							
												<td><?php if($row['status']==-1){echo 'Expired';}
												if($row['status']==1){echo 'Active';}
												if($row['status']==0){echo 'Pending';}?></td>	
											</tr>
											
											 <?php $i++; } ?>
										</tbody>
									</table>
									<nav class="text-center">
										<ul class="pagination"><?=$co->getPagingLinks($sql, array('adid'=>$adid), $item_per_page, $this_page)?></ul>
									</nav>
                                </div>