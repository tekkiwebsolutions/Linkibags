<?php
$breadcrumb = 'Recommend Default Folder';
$title = '<i class="fa fa-table"></i> Recommend Default Folder';
$item_per_page = 12;


$sql = "SELECT r.*,u.email_id,p.first_name,p.last_name from `recommend_user_category_msgs` r INNER JOIN `users` u on u.uid=r.uid INNER JOIN `profile` p on p.uid=r.uid WHERE recommend_msg_id>'0' ORDER BY recommend_msg_id desc";
$this_page = "p=folder/recommend_default_folder_msg";				

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
									<th>Sr no.</th><th>User-Name</th><th>Email</th><th>Recommend Message</th><th>Date</th>
								</tr>
							</thead>
						   <tbody>
							
								<?php
								foreach($rows as $row){														
								?>
								<tr>
									<td><?=$i?></td>
									<td><?=(($row['first_name'] != '') ? $row['first_name'] : 'N/A').' '. $row['last_name']?></td>
									<td><?=$row['email_id']?></td>
									<td><?=$row['recommend_category_msg']?></td>
									<td><?=date('j F, Y',$row['recommend_category_msg_created']);?></td>                                      
								</tr>
								
								 <?php $i++; } ?>
							</tbody>
						</table>
						<nav class="text-center">
							<ul class="pagination"><?=$co->getPagingLinks($sql, array(), $item_per_page, $this_page)?></ul>
						</nav>
                    </div>