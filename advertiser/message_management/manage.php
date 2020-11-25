<?php
$status = '-1, 0, 1';
$title = '<i class="fa fa-envelope"></i> Manage Your Messages';

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


$select_status='';
if(isset($_POST['select_status']))
{
	$select_status=$_POST['select_status'];
}
$sql = " SELECT * from advertiser_messages ORDER BY mid desc ";


$this_page = "p=message_management/manage";				


$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), array());
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}

	
?>
				
                                <div class="table-responsive">									
                                    <table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>No</th><th>Title</th><th>Desctiption</th><th>Status</th>
											</tr>
										</thead>
									   <tbody>
										
											<?php
													
											foreach($rows as $row){							
											?>
											<tr>
												<td><?=$i?></td>		
												<td><?=substr($row['title'],0,25).'...';?></td>											
												<td><?=substr($row['description'],0,35).'...';?></td>							
												<td><?php if($row['status']==1){echo 'Read';}
											
												if($row['status']==0){echo 'Pending';}?></td>	
											</tr>
											
											 <?php $i++; } ?>
										</tbody>
									</table>
									<nav class="text-center">
										<ul class="pagination"><?=$co->getPagingLinks($sql, array('uid'=>$adid), $item_per_page, $this_page)?></ul>
									</nav>
                                </div>