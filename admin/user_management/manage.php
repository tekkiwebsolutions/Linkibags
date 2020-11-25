<?php
$breadcrumb = 'User Management';
$title = '<i class="fa fa-table"></i> Manage User';
$item_per_page = 12;
$sql = "SELECT u.*, p.* from profile p, users u WHERE u.uid=p.uid";

$sqlUpdateName = "SELECT p.profile_id, p.first_name, u.email_id
FROM users u,  profile p
WHERE u.uid=p.uid AND p.first_name=''" ;
$dataUpdateName = $co->fetch_all_array($sqlUpdateName,array()); 
//echo count($dataUpdateName);
foreach($dataUpdateName as $rowUserUp){
	$firstNameMake = explode('@', $rowUserUp['email_id']);	
	$up_profile = array();
	$up_profile['first_name'] = $firstNameMake[0];	 
	$co->query_update('profile', $up_profile, array('profile_id'=>$rowUserUp['profile_id']), 'profile_id=:profile_id');
	unset($up_profile); 	 					
} 

$cond_arr = array();

if(isset($_GET['save'])){
	if(isset($_GET['name_search']) and $_GET['name_search']!=''){
		$sql .= " AND (p.first_name LIKE :name OR u.email_id LIKE :name2)";
		$cond_arr['name'] = "%".$_GET['name_search']."%";
		$cond_arr['name2'] = "%".$_GET['name_search']."%";
	}
	
	if(isset($_GET['acc_search']) and $_GET['acc_search']!=''){
		$sql .= " and u.role=:role";
		$cond_arr['role'] = $_GET['acc_search'];
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
<form method="GET" enctype="multipart/form-data" class="form-horizontal" style="display: none;">
	<input type="hidden" name="p" value="user_management/manage"/>
	<div class="form-group">
		<div class="col-sm-4">
			<input type="text" name="name_search" class="form-control" value="<?=(isset($_GET['name_search']) ? $_GET['name_search'] : '')?>" placeholder="Search with keywards"/>
		</div>
		<div class="col-sm-4">
			<select name="acc_search" class="form-control">
				<option value="">Filter with account type</option>			
				<?php
				$acc_type = array('','Personal','Business','Education');						
				for($j=1;$j<=3;$j++){											
					if(isset($_GET['acc_search']) and $_GET['acc_search']!='' and $_GET['acc_search']==$j){
						echo '<option value="'.$j.'" selected="selected">'.$acc_type[$j].'</option>';                          
					}else{	
						echo '<option value="'.$j.'">'.$acc_type[$j].'</option>';
					} 
				}
				?> 
			</select>
		</div>
		<div class="form-group">
			<div class="col-sm-4">
				<button type="submit"  name="save" class="btn btn-primary">Send</button>
			</div>
		</div>
	</div>
</form>
<div>
<table class="table table-hover table-striped" id="manage_users">
	<thead>
		<tr>
			<th>User Id</th>
			<th>First Name</th>
			<th>Last Name</th>												
			<th>Email</th>
			<th>State</th>
			<th>Zip Code</th>
			<th>Account Type</th>
			<th>Status</th>
			<th>Verified</th>
			<th>Created On</th>
			<th>Last Login</th>
			<th>Subscribed Newsletter</th>
			<th>Actions</th>
		</tr>
	</thead>
	
   <tbody>
   <input type="checkbox" id="checkAll" value="0">&nbsp; Select ALL
	
		<?php
		/*
		$acc_type = array('','Personal','Business','Education');
		$status = array('Blocked','Active');	
		foreach($rows as $row){
										
		?>
		<tr>
			<td><?=$row['uid']?></td>
			<td><?=$row['first_name']?></td>
			<td><?=$row['last_name']?></td>
			<td><?=$row['email_id']?></td>
			<td><?=$acc_type[$row['role']]?></td>
			<td><?=$status[$row['status']]?></td>
			<td><?=date('j F, Y',$row['created']);?></td>              
			<td><?=date('j F, Y',$row['last_login_time']);?></td>                                       	
			<td> 
				<a href="main.php?p=user_management/edit&amp;id=<?=$row['uid']?>" class="btn btn-xs btn-primary"> <i class="fa fa-fw fa-edit"></i> Edit</a>
				<a class="btn btn-xs btn-danger" href="main.php?p=user_management/delete_info&amp;delid=<?=$row['uid']?>"><i class="fa fa-fw fa-edit"></i> Delete</a> 
			</td>
		</tr>
		
		 <?php $i++; } */?>
	</tbody>
</table>
<nav class="text-center" style="display: none;">
	<ul class="pagination"><?=$co->getPagingLinks($sql, $cond_arr, $item_per_page, $this_page)?></ul>
</nav>								
</div>