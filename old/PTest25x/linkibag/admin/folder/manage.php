<?php
$breadcrumb = 'Folder Management';
$title = '<i class="fa fa-table"></i> Manage Folder';
$item_per_page = 12;

$sql = "SELECT c.*,p.first_name,p.last_name from category c, profile p WHERE c.uid!='0' and p.uid=c.uid";
$cond_arr = array();
if(isset($_GET['save'])){
	if(isset($_GET['name_search']) and $_GET['name_search']!=''){
		$sql .= " and (c.cname like :name OR p.first_name like :name2)";
		$cond_arr['name'] = '%'.$_GET['name_search'].'%';
		$cond_arr['name2'] = '%'.$_GET['name_search'].'%';
		
	}
	if(isset($_GET['date_start']) and $_GET['date_start']!=''){
		$sql .= " and c.created_time>=:date";
		$cond_arr['date'] = strtotime($_GET['date_start']);
	}		
	if(isset($_GET['date_end']) and $_GET['date_end']!=''){
		$sql .= " and c.created_time<=:date2";
		$cond_arr['date2'] = strtotime($_GET['date_end'].' 23:59:59');
	}
	
}
	$sql .= " ORDER BY c.cid desc";




$this_page = "p=folder/manage";				

$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), $cond_arr);
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}


	
?>


								<form class="form-horizontal" enctype="multipart/form-data" method="GET">									
									<input type="hidden" value="folder/manage" name="p">									
									<div class="form-group">										
										<div class="col-sm-3">											
											<input type="text" placeholder="Search with keywards" value="<?=isset($_GET['name_search']) ? $_GET['name_search'] : ''?>" class="form-control" name="name_search">										
										</div>	
										<div class="col-sm-3">											
										<input type="text" placeholder="Enter date" value="<?=isset($_GET['date_start']) ? $_GET['date_start'] : ''?>" class="form-control default_date_picker" name="date_start">										
										</div>
										<div class="col-sm-3">											
										<input type="text" placeholder="Enter date" value="<?=isset($_GET['date_end']) ? $_GET['date_end'] : ''?>" class="form-control default_date_picker" name="date_end">										
										</div>
										<div class="col-sm-3">												
											<button class="btn btn-primary" name="save" type="submit">Send</button>											
										</div>	
									
									</div>								
								</form>

					
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Sr no.</th><th>Folder</th><th>Trending Folder</th><th>Name</th><th>Show Public<th>Created On</th><th>Actions</th>
											</tr>
										</thead>
									   <tbody>
										
											<?php
											$status = array('No','Yes');
											foreach($rows as $row){
														
											?>
											<tr>
												<td><?=$i?></td>
												<td><?=$row['cname']?></td>
												<td><?=$status[$row['trending_cat']]?></td>
												<td><?=((isset($row['first_name']) and $row['first_name'] != '' )? $row['first_name'] : 'N/A')?> <?=((isset($row['first_name']) and $row['last_name'] != '' )? $row['last_name'] : 'N/A')?></td>
												<td><?=$status[$row['status']]?></td>
												<td><?=date('j F, Y',$row['created_time']);?></td>                                      
												<td> 
													<a href="main.php?p=folder/edit&amp;id=<?=$row['cid']?>" class="btn btn-xs btn-primary"> <i class="fa fa-fw fa-edit"></i> Edit</a>
													<a class="btn btn-xs btn-danger" href="main.php?p=folder/delete_info_user&amp;delid=<?=$row['cid']?>"><i class="fa fa-fw fa-edit"></i> Delete</a> 

												</td>
											</tr>
											
											 <?php $i++; } ?>
										</tbody>
									</table>
									<nav class="text-center">
										<ul class="pagination"><?=$co->getPagingLinks($sql, $cond_arr, $item_per_page, $this_page)?></ul>
									</nav>
                                </div>