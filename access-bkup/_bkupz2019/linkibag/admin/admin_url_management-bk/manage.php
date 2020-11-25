<?php
$breadcrumb = 'Url Management';
$title = '<i class="fa fa-table"></i> Manage Url';
$item_per_page = 12;

if(isset($_GET['delid']))

{

	$co->query_delete('user_urls', array('id'=>$_GET['delid']),'url_id=:id');
	
	$co->setmessage("error", "Url has been successfully deleted");
	echo '<script type="text/javascript">window.location.href="main.php?p=admin_url_management/manage"</script>';
	exit();
}



$this_page = "p=admin_url_management/manage";				

//$sql = "SELECT url.*, c.* from category c, user_urls url WHERE url.url_cat=c.cid AND url.uid=:id ORDER BY url_id DESC";
$sql = "SELECT * from user_urls url LEFT JOIN category c ON c.cid=url.url_cat WHERE url.uid=:id ORDER BY url_id DESC";


$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), array('id'=>0));
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}


	
?>
								
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Sr no.</th><th>Url Title</th><th>Url Value</th><th>Url Description</th><th>Url Category</th><th>Created On</th><th>Actions</th>
											</tr>
										</thead>
									   <tbody>
										
											<?php
											$acc_type = array('','Personal','Business','Education');												
											foreach($rows as $row){							
											?>
											<tr>
												<td><?=$i?></td>
												<td><?=$row['url_title']?></td>
												<td><?=$row['url_value']?></td>
												<td><?=substr($row['url_desc'],0,25)?></td>
												<td><?=$row['cname']?></td>
												<td><?=date('j F, Y',$row['created_time']);?></td>                                     
												<td> 
													<a href="main.php?p=admin_url_management/edit&amp;id=<?=$row['url_id']?>" class="btn btn-xs btn-primary"> <i class="fa fa-fw fa-edit"></i> Edit</a>
													<a class="btn btn-xs btn-danger" data-toggle="modal" role="button" href="#myModal<?=$row['url_id']?>">
													<i class="fa fa-fw fa-trash"></i> Delete</a>
													<div id="myModal<?=$row['url_id']?>" class="modal fade in">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h3 id="myModalLabel3">Deleting url</h3>
																</div>
																<div class="modal-body">
																	<p>Are you sure!</p>
																</div>
																<div class="modal-footer">
																	<div class="btn-group">
																			<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
																			<a href="main.php?p=admin_url_management/manage&amp;delid=<?=$row['url_id']?>"><button class="btn btn-info"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>
																	</div>
																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dalog -->
													</div><!-- /.modal -->  
												</td>
											</tr>
											
											 <?php $i++; } ?>
										</tbody>
									</table>
									<nav class="text-center">
										<ul class="pagination"><?=$co->getPagingLinks($sql, array('id'=>0), $item_per_page, $this_page)?></ul>
									</nav>
                                </div>