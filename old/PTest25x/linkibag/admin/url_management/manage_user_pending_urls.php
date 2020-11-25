<?php
$breadcrumb = 'Search Page Pending Url Management';
$title = '<i class="fa fa-table"></i> Manage Pending Urls';
$item_per_page = 12;
if(isset($_GET['delid']))

{
	
	//$co->query_delete('user_urls', array('id'=>$_GET['delid']),'url_id=:id');
	//$co->query_delete('user_shared_urls', array('id'=>$_GET['delid']),'url_id=:id');
	$up['search_page_status'] = 2;
	$co->query_update('user_urls', $up, array('id'=>$_GET['delid']),'url_id=:id');
	unset($up);
	
	$co->setmessage("error", "Url has been successfully deleted");
	echo '<script type="text/javascript">window.location.href="main.php?p=url_management/manage_user_pending_urls"</script>';
	exit();
}else if(isset($_GET['approve_id'])) {
	$up['search_page_status'] = 1;
	$co->query_update('user_urls', $up, array('id'=>$_GET['approve_id']),'url_id=:id');
	unset($up);
	
	$co->setmessage("error", "Url has been successfully approved");
	echo '<script type="text/javascript">window.location.href="main.php?p=url_management/manage"</script>';
	exit();
}


$sql = "SELECT url.*, c.cname,p.first_name,p.last_name,uc.cname as public_cat_cname from category c, user_public_category uc, user_urls url, profile p WHERE p.uid=url.uid and url.url_cat=c.cid and url.search_page_status='0' and url.add_to_search_page='1' and url.public_cat=uc.cid";
$cond_arr = array();

if(isset($_GET['save'])){
	if(isset($_GET['name_search']) and $_GET['name_search']!=''){
		$sql .= " and (url.url_title like :name OR url.url_desc like :name2 OR url.url_value like :name3 OR c.cname like :name4 OR p.first_name like :name5)";
		$cond_arr['name'] = '%'.$_GET['name_search'].'%';
		$cond_arr['name2'] = '%'.$_GET['name_search'].'%';
		$cond_arr['name3'] = '%'.$_GET['name_search'].'%';
		$cond_arr['name4'] = '%'.$_GET['name_search'].'%';
		$cond_arr['name5'] = '%'.$_GET['name_search'].'%';
		
	}
	if(isset($_GET['date_start']) and $_GET['date_start']!=''){
		$sql .= " and url.created_date>=:date";
		$cond_arr['date'] = date('Y-m-d', strtotime($_GET['date_start']));
	}		
	if(isset($_GET['date_end']) and $_GET['date_end']!=''){
		$sql .= " and url.created_date<=:date2";
		$cond_arr['date2'] = date('Y-m-d 23:59:59', strtotime($_GET['date_end']));
	}
	
}
	$sql .= " ORDER BY url_id DESC";



$this_page = "p=url_management/manage_user_pending_urls";				

$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), $cond_arr);
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}
		
?>								<form class="form-horizontal" enctype="multipart/form-data" method="GET">									
									<input type="hidden" value="url_management/manage_user_pending_urls" name="p">									
									<div class="form-group">										
										<div class="col-sm-3">											
											<input type="text" placeholder="Search with keywards" value="<?=(isset($_GET['name_search']) ? $_GET['name_search'] : '')?>" class="form-control" name="name_search">										
										</div>	
										<div class="col-sm-3">											
										<input type="text" placeholder="From date" value="<?=(isset($_GET['date_start']) ? $_GET['date_start'] : '')?>" class="form-control default_date_picker" name="date_start">										
										</div>
										<div class="col-sm-3">											
										<input type="text" placeholder="To date" value="<?=(isset($_GET['date_end']) ? $_GET['date_end'] : '')?>" class="form-control default_date_picker" name="date_end">										
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
												<th>Sr no.</th><th>Url Title</th><th>Name</th><th>Url Value</th><th>Url Description</th><th>Folder</th><th>Public Category</th><th>Status</th><th>Created On</th><th>Actions</th>
											</tr>
										</thead>
									   <tbody>
										
											<?php
											$acc_type = array('','Personal','Business','Education');	
											$status = array('Pending','Approved');	
											foreach($rows as $row){																	
											?>
											<tr>
												<td><?=$i?></td>
												<td><?=$row['url_title']?></td>
												<td><?=((isset($row['first_name']) and $row['first_name'] != '' )? $row['first_name'] : 'N/A')?> <?=((isset($row['first_name']) and $row['last_name'] != '' )? $row['last_name'] : 'N/A')?></td>
												<td><?=$row['url_value']?></td>
												<td><?=substr($row['url_desc'],0,25)?></td>
												<td><?=$row['cname']?></td>
												<td><?=$row['public_cat_cname']?></td>
												<td><?=$status[$row['search_page_status']]?></td>
												
												

												<td><?=date('j F, Y',strtotime($row['created_date']));?></td>                                      
												<td> 
													<a data-toggle="modal" role="button" href="#approvemyModal<?=$row['url_id']?>" class="btn btn-xs btn-primary"> <i class="fa fa-fw fa-edit"></i> Approve</a>
													<div id="approvemyModal<?=$row['url_id']?>" class="modal fade in">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h3 id="myModalLabel3">Approve url</h3>
																</div>
																<div class="modal-body">
																	<p>Are you sure you want to approve this link! it will show in LinkiBag search page.</p>
																</div>
																<div class="modal-footer">
																	<div class="btn-group">
																			<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>&nbsp;
																			<a href="main.php?p=url_management/manage_user_pending_urls&amp;approve_id=<?=$row['url_id']?>"><button class="btn btn-info"><span class="glyphicon glyphicon-right"></span> Yes</button></a>
																	</div>
																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dalog -->
													</div><!-- /.modal --> 
													
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
																	<p>Are you sure! it will not show in LinkiBag search page.</p>
																</div>
																<div class="modal-footer">
																	<div class="btn-group">
																			<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>&nbsp;
																			<a href="main.php?p=url_management/manage_user_pending_urls&amp;delid=<?=$row['url_id']?>"><button class="btn btn-info"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>
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
										<ul class="pagination"><?=$co->getPagingLinks($sql, $cond_arr, $item_per_page, $this_page)?></ul>
									</nav>
                                </div>