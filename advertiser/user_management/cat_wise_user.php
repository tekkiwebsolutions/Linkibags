<?php
$breadcrumb = 'Category Wise Users';
$title = '<i class="fa fa-table"></i> Category Wise  Users';
$item_per_page = 12;

$advertiser = $co->getcurrent_admin();

$sql = "SELECT * from category";
$cond_arr = array();



$sql .= " ORDER BY u.uid DESC";

$this_page = "p=user_management/manage";				

$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), $cond_arr);
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}	
			
?>


</div>
<div>
<table class="table table-hover table-striped">
	<thead>
		<tr>
			<th>No</th><th>Category</th><th>Users</th>
		</tr>
	</thead>
   <tbody>
	
        <?php
        $i=0;
		$acc_type = array('','Personal','Business','Education');
		$status = array('Blocked','Active');	
		foreach($rows as $row){
            $i++;
			$s = $row['email_id'];
$firstPart = strtok( $s, '@' );
$allTheRest = strtok( '' ); 							
		?>
		<tr>
		
			<td><?=$i?></td>
			<td><?=$acc_type[$row['role']]?></td>
			<td><?=$status[$row['status']]?></td>
		
		</tr>
		
		 <?php $i++; } ?>
	</tbody>
</table>
<nav class="text-center" style="display: none;">
	<ul class="pagination"><?=$co->getPagingLinks($sql, $cond_arr, $item_per_page, $this_page)?></ul>
</nav>								

</div>