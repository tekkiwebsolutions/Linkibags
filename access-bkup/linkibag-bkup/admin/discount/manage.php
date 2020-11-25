<?php
$breadcrumb = 'Discount Management';
$title = '<i class="fa fa-table"></i> Manage Discount';
$item_per_page = 12;
if(isset($_GET['delid']))

{

	$co->query_delete('coupon_disount', array('id'=>$_GET['delid']),'discount_id=:id');
	
	$co->setmessage("error", "Coupon has been successfully deleted");
	echo '<script type="text/javascript">window.location.href="main.php?p=discount/manage"</script>';
	exit();
}


$sql = "SELECT * from coupon_disount WHERE discount_id>'0' ORDER BY discount_id desc";
$this_page = "p=discount/manage";				

$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), array());
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}


	
?>
					
                                <div class="table-responsive">									<div class="col-sm-12 text-right">										<a href="main.php?p=discount/add" class="btn btn-info"><i class="fa fa-plus"></i>Add New</a>											</div>
                                    <table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Sr no.</th><th>Coupon Code</th><th>Discount(In percentage)</th><th>Active</th><th>Created On</th><th>Actions</th>
											</tr>
										</thead>
									   <tbody>
										
											<?php
											$status = array('No','Yes');
											foreach($rows as $row){
														
											?>
											<tr>
												<td><?=$i?></td>
												<td><?=$row['coupon_code']?></td>
												<td><?=$row['coupon_discount']?></td>
												<td><?=$status[$row['status']]?></td>
												<td><?=date('j F, Y',$row['created_time']);?></td>                                      
												<td> 
													<a href="main.php?p=discount/edit&amp;id=<?=$row['discount_id']?>" class="btn btn-xs btn-primary"> <i class="fa fa-fw fa-edit"></i> Edit</a>
													<a class="btn btn-xs btn-danger" data-toggle="modal" role="button" href="#myModal<?=$row['discount_id']?>">
													<i class="fa fa-fw fa-trash"></i> Delete</a>
													<div id="myModal<?=$row['discount_id']?>" class="modal fade in">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h3 id="myModalLabel3">Deleting Coupon</h3>
																</div>
																<div class="modal-body">
																	<p>Are you sure!</p>
																</div>
																<div class="modal-footer">
																	<div class="btn-group">
																			<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
																			<a href="main.php?p=discount/manage&amp;delid=<?=$row['discount_id']?>"><button class="btn btn-info"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>
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
										<ul class="pagination"><?=$co->getPagingLinks($sql, array(), $item_per_page, $this_page)?></ul>
									</nav>
                                </div>