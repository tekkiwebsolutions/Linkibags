<?php
$breadcrumb = 'Advertisement Management';
$title = '<i class="fa fa-table"></i> Manage Advertisement';
$item_per_page = 12;

if(isset($_GET['delid']))

{

	$co->query_delete('admin_advertisement', array('id'=>$_GET['delid']),'adid=:id');
	
	$co->setmessage("error", "Advertisement has been successfully deleted");
	echo '<script type="text/javascript">window.location.href="main.php?p=advertisement_management/manage"</script>';
	exit();
}


$sql = "SELECT * from admin_advertisement WHERE uid='0' ORDER BY adid desc";
$this_page = "p=advertisement_management/manage";				


$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), array());
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}


	
?>
								
                                <div class="table-responsive">									<div class="col-sm-12 text-right">										<a href="main.php?p=advertisement_management/add" class="btn btn-info"><i class="fa fa-plus"></i>Add New</a>											</div>
                                    <table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Sr no.</th><th>Name</th><th>Username</th><th>Status</th><th>Created On</th><th>Actions</th>
											</tr>
										</thead>
									   <tbody>
										
											<?php
											$status = array('Non active','active');	
											foreach($rows as $row){							
											?>
											<tr>
												<td><?=$i?></td>
												<td><?=$row['name']?></td>		
												<td><?=$row['username']?></td>																								
												<td><?=$status[$row['status']]?></td>												
												<td><?=date('j F, Y',$row['updated']);?></td>										
												<td> 
													<a href="main.php?p=advertisement_management/edit&amp;id=<?=$row['adid']?>" class="btn btn-xs btn-primary"> <i class="fa fa-fw fa-edit"></i> Edit</a>
													<a class="btn btn-xs btn-danger" data-toggle="modal" role="button" href="#myModal<?=$row['adid']?>">
													<i class="fa fa-fw fa-trash"></i> Delete</a>
													<div id="myModal<?=$row['adid']?>" class="modal fade in">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h3 id="myModalLabel3">Deleting Advertisement</h3>
																</div>
																<div class="modal-body">
																	<p>Are you sure!</p>
																</div>
																<div class="modal-footer">
																	<div class="btn-group">
																			<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
																			<a href="main.php?p=advertisement_management/manage&amp;delid=<?=$row['adid']?>"><button class="btn btn-info"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>
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