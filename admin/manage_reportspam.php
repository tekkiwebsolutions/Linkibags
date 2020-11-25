<?php
$breadcrumb = 'Report Spam Management';
$title = '<i class="fa fa-table"></i> Manage spam reports';
$item_per_page = 30;

if(isset($_GET['changeid']) and isset($_GET['status'])) {
	$co->query_update('donot_recieve_mails', array('status'=>$_GET['status']), array('id'=>$_GET['changeid']), 'id=:id');
	echo '<script type="text/javascript">window.location.href="main.php?p=manage_reportspam"</script>';
	exit();
}

$sql = "SELECT * from donot_recieve_mails WHERE id>0";

$cond_arr = array();
if(isset($_GET['save'])){
	if(isset($_GET['name_search']) and $_GET['name_search']!=''){
		$sql .= " AND email_id LIKE :key";
		$cond_arr['key'] = "%".$_GET['name_search']."%";
	}
}
$sql .= " ORDER BY id DESC";

$this_page = "p=manage_reportspam";				

$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), $cond_arr);
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}	
			
?>
<form method="GET" class="form-horizontal">
	<input type="hidden" name="p" value="manage_reportspam"/>
	<div class="form-group">
		<div class="col-sm-4">
			<input type="text" name="name_search" class="form-control" value="<?=(isset($_GET['name_search']) ? $_GET['name_search'] : '')?>" placeholder="Search email address"/>
		</div>
		<div class="col-sm-4">
			<button type="submit"  name="save" class="btn btn-primary">Send</button>
		</div>
	</div>
</form>
<div>    
    <table class="table table-hover table-striped">
		<thead>
			<tr>
				<th>Id</th><th>Email</th><th>Reported On</th><th>Blocked?</th><th>Actions</th>
			</tr>
		</thead>
	   <tbody>
			<?php
			foreach($rows as $row){								
			?>
			<tr>
				<td><?=$row['id']?></td>
				<td><?=$row['email_id']?></td>
				<td><?=date('j F, Y',$row['created_on'])?></td>
				<td><?=($row['status']==1 ? 'Yes' : 'No')?></td>
				<td> 
					<a class="btn btn-xs<?=($row['status']==1 ? ' btn-success' : ' btn-danger')?>" data-toggle="modal" role="button" href="#myModal<?=$row['id']?>"><?=($row['status']==1 ? 'Un-Blocked' : 'Blocked')?></a>
					<div id="myModal<?=$row['id']?>" class="modal fade in">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h3 id="myModalLabel3"><?=($row['status']==1 ? 'Un-Blocked' : 'Blocked')?> Email</h3>
								</div>
								<div class="modal-body">
									<p>Are you sure!</p>
								</div>
								<div class="modal-footer">
									<div class="btn-group">
										<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
										<a href="main.php?p=manage_reportspam&amp;changeid=<?=$row['id']?>&status=<?=($row['status']==1 ? 0 : 1)?>"><button class="btn btn-info"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>
									</div>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dalog -->
					</div><!-- /.modal --> 
				</td>
			</tr>
			
			<?php } ?>
		</tbody>
	</table>
	<nav class="text-center">
		<ul class="pagination"><?=$co->getPagingLinks($sql, $cond_arr, $item_per_page, $this_page)?></ul>
	</nav>								
</div>