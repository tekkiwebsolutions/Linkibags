<?php
$breadcrumb = 'Information Security Links';
$title = '<i class="fa fa-table"></i> Manage Link';
$item_per_page = 12;

if(isset($_GET['delid']))

{

	$co->query_delete('info_security_links', array('id'=>$_GET['delid']),'info_security_link_id=:id');
	
	$co->setmessage("error", "Link has been successfully deleted");
	echo '<script type="text/javascript">window.location.href="main.php?p=information_security_links/manage"</script>';
	exit();
}



$this_page = "p=information_security_links/manage";				

//$sql = "SELECT url.*, c.* from category c, user_urls url WHERE url.url_cat=c.cid AND url.uid=:id ORDER BY info_security_link_id DESC";
$sql = "SELECT * from info_security_links WHERE uid=:id ORDER BY info_security_link_id DESC";


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
												<th>Sr no.</th><th>Company Name</th><th>Image</th><th>URL</th><th>Text</th><th>Posted</th><th>Removed</th><th>Notes</th><th>Display</th><th>Type</th><th>Actions</th>
											</tr>
										</thead>
									   <tbody>
										
											<?php
											$links = array('No','Yes');
											$typs = array('Free','Paid');										
											foreach($rows as $row){							
											?>
											<tr>
												<td><?=$i?></td>
												<td><?=$row['info_security_company_name']?></td>											
												<td><img src="../<?=$row['info_security_photo']?>" style="width:100px; height: 60px;"/></td>
												<td><?=$row['info_security_url_value']?></td>
												<td><?=$row['info_security_txt']?></td>
												<td><?=date('j F, Y',strtotime($row['info_security_start_date']));?></td>
												<td><?=date('j F, Y',strtotime($row['info_security_end_date']));?></td>
												<td><?=substr($row['info_security_notes'],0,25)?></td>
												<td><?=$links[$row['status']]?></td>
												<td><?=$typs[$row['info_security_type']]?></td>                                     
												<td> 
													<a href="main.php?p=information_security_links/edit&amp;id=<?=$row['info_security_link_id']?>" class="btn btn-xs btn-primary"> <i class="fa fa-fw fa-edit"></i> Edit</a>
													<a class="btn btn-xs btn-danger" data-toggle="modal" role="button" href="#myModal<?=$row['info_security_link_id']?>">
													<i class="fa fa-fw fa-trash"></i> Delete</a>
													<div id="myModal<?=$row['info_security_link_id']?>" class="modal fade in">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h3 id="myModalLabel3">Deleting Link</h3>
																</div>
																<div class="modal-body">
																	<p>Are you sure!</p>
																</div>
																<div class="modal-footer">
																	<div class="btn-group">
																			<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
																			<a href="main.php?p=information_security_links/manage&amp;delid=<?=$row['info_security_link_id']?>"><button class="btn btn-info"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>
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