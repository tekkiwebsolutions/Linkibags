<?php
$breadcrumb = 'Category Management';
$title = '<i class="fa fa-table"></i> Manage Category';
$item_per_page = 12;


$sql = "SELECT * from category WHERE uid='0' ORDER BY cid desc";
$this_page = "p=category_management/manage";				

$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), array());
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}


	
?>
					
                                <div class="table-responsive">									<div class="col-sm-12 text-right">										<a href="main.php?p=category_management/add" class="btn btn-info"><i class="fa fa-plus"></i>Add New</a>											</div>
                                    <table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Sr no.</th><th>Category</th><th>Trending Category</th><th>Show Public</th><th>Created On</th><th>Actions</th>
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
												<td><?=$status[$row['status']]?></td>
												<td><?=date('j F, Y',$row['created_time']);?></td>                                      
												<td> 
													<a href="main.php?p=category_management/edit&amp;id=<?=$row['cid']?>" class="btn btn-xs btn-primary"> <i class="fa fa-fw fa-edit"></i> Edit</a>
													<a class="btn btn-xs btn-danger" href="main.php?p=category_management/delete_info&amp;delid=<?=$row['cid']?>"><i class="fa fa-fw fa-edit"></i> Delete</a> 

												</td>
											</tr>
											
											 <?php $i++; } ?>
										</tbody>
									</table>
									<nav class="text-center">
										<ul class="pagination"><?=$co->getPagingLinks($sql, array(), $item_per_page, $this_page)?></ul>
									</nav>
                                </div>