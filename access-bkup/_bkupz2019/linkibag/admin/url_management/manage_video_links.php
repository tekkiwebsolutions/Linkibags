<?php
$breadcrumb = 'Video Url Management';
$title = '<i class="fa fa-table"></i> Manage video Url';
$item_per_page = 12;
if(isset($_GET['delid']))

{

	$co->query_delete('user_urls', array('id'=>$_GET['delid']),'url_id=:id');
	
	$co->setmessage("error", "Url has been successfully deleted");
	echo '<script type="text/javascript">window.location.href="main.php?p=url_management/manage_video_links"</script>';
	exit();
}
$sql = "SELECT url.url_title,url.uid,url.url_value,url.url_desc,url.public_bag_link,url.created_date,url.url_id, c.cname,p.first_name,p.last_name from user_urls url LEFT JOIN profile p ON p.uid=url.uid LEFT JOIN category c ON c.cid=url.url_cat WHERE url.is_video_link='1'";
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
		$cond_arr['date2'] = date('Y-m-d', strtotime($_GET['date_end']));
	}
	
}
	$sql .= " ORDER BY url_id DESC";



$this_page = "p=url_management/manage";				

$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), $cond_arr);
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}
		
?>								
								
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Sr no.</th><th>Url Title</th><th>Name</th><th>Url Value</th><th>Url Description</th><th>Url Category</th><th>Public Bag Link</th><!--<th>Trending Link</th><th>Youtube Link</th>--><th>Created On</th><th>Actions</th>
											</tr>
										</thead>
									   <tbody>
										
											<?php
											$acc_type = array('','Personal','Business','Education');	
											$links = array('No','Yes');
											
											foreach($rows as $row){
												$edit_link ='main.php?p=url_management/edit&amp;id='.$row['url_id'];
												if(isset($row['uid']) and $row['uid'] == 0)
													$edit_link ='main.php?p=admin_url_management/edit&amp;id='.$row['url_id'];	
											?>
											<tr>
												<td><?=$i?></td>
												<td><?=$row['url_title']?></td>
												<td><?=((isset($row['first_name']) and $row['first_name'] != '' )? $row['first_name'] : 'N/A')?> <?=((isset($row['first_name']) and $row['last_name'] != '' )? $row['last_name'] : 'N/A')?></td>
												<td><?=$row['url_value']?></td>
												<td><?=substr($row['url_desc'],0,25)?></td>
												<td><?=$row['cname']?></td>
												<td><?=$links[$row['public_bag_link']]?></td>
												<?php/*<td><?=$links[$row['trending_link']]?></td>
												<td><?=$links[$row['you_tube_link']]?></td>*/?>

												<td><?=date('j F, Y',strtotime($row['created_date']));?></td>                                      
												<td> 
													<a href="<?=$edit_link?>" class="btn btn-xs btn-primary"> <i class="fa fa-fw fa-edit"></i> Edit</a>
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
																			<a href="main.php?p=url_management/manage_video_links&amp;delid=<?=$row['url_id']?>"><button class="btn btn-info"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>
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