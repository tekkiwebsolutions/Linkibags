<?php
$breadcrumb = 'Ads Management';
$title = '<i class="fa fa-table"></i> Manage Ads';
$item_per_page = 12;

if(isset($_GET['delid']))

{

	$co->query_delete('admin_ads', array('id'=>$_GET['delid']),'aid=:id');
	
	$co->setmessage("error", "Ads has been successfully deleted");
	echo '<script type="text/javascript">window.location.href="main.php?p=ads_management/manage"</script>';
	exit();
}


$sql = "SELECT * from admin_ads WHERE uid='0' ORDER BY aid desc";
$this_page = "p=ads_management/manage";				


$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), array());
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}


	
?>
								
                                <div class="table-responsive">									<div class="col-sm-12 text-right">										<a href="main.php?p=ads_management/add" class="btn btn-info"><i class="fa fa-plus"></i>Add New</a>											</div>
                                    <table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Sr no.</th><th>Img</th><th>Number of clicks</th><th>Status</th><th>Created On</th><th>Expired Date</th><th>Actions</th>
											</tr>
										</thead>
									   <tbody>
										
											<?php
											$status = array('Non active','active');	
											foreach($rows as $row){							
											?>
											<tr>
												<td><?=$i?></td>
												<td><img src="../<?=$row['photo_path']?>" style="width:100px; height: 60px;"/></td>																								<td><?=$row['num_of_clicks']?></td>
												<td><?=$status[$row['status']]?></td>												
												<td><?=date('j F, Y',$row['updated']);?></td>												<td><?=date('j F, Y', strtotime($row['expiration_date']));?></td>	
												<td> 
													<a href="main.php?p=ads_management/edit&amp;id=<?=$row['aid']?>" class="btn btn-xs btn-primary"> <i class="fa fa-fw fa-edit"></i> Edit</a>
													<a class="btn btn-xs btn-danger" data-toggle="modal" role="button" href="#myModal<?=$row['aid']?>">
													<i class="fa fa-fw fa-trash"></i> Delete</a>
													<div id="myModal<?=$row['aid']?>" class="modal fade in">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h3 id="myModalLabel3">Deleting Ads</h3>
																</div>
																<div class="modal-body">
																	<p>Are you sure!</p>
																</div>
																<div class="modal-footer">
																	<div class="btn-group">
																			<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
																			<a href="main.php?p=ads_management/manage&amp;delid=<?=$row['aid']?>"><button class="btn btn-info"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>
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