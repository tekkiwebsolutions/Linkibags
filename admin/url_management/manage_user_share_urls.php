<?php
$breadcrumb = 'User Share URL Management';
$title = '<i class="fa fa-table"></i> Manage User Share URL';
$item_per_page = 12;
if(isset($_GET['delid']))

{

	$co->query_delete('user_urls', array('id'=>$_GET['delid']),'url_id=:id');
	
	$co->setmessage("error", "Url has been successfully deleted");
	echo '<script type="text/javascript">window.location.href="main.php?p=url_management/manage_user_share_urls"</script>';
	exit();
}
$sql = "SELECT url.*,p.first_name,p.last_name,us.like_status,us.recommend_link,us.shared_url_id,u.email_id from user_urls url, profile p, `user_shared_urls` us, `users` u WHERE u.uid=us.uid and us.url_id=url.url_id and url.uid=us.uid and p.uid=url.uid and url.status='1' and us.shared_to>'0' and us.recommend_link=1";
$cond_arr = array();

if(isset($_GET['save'])){
	if(isset($_GET['name_search']) and $_GET['name_search']!=''){
		$sql .= " and (url.url_title like :name OR url.url_desc like :name2 OR url.url_value like :name3 OR p.first_name like :name5)";
		$cond_arr['name'] = '%'.$_GET['name_search'].'%';
		$cond_arr['name2'] = '%'.$_GET['name_search'].'%';
		$cond_arr['name4'] = '%'.$_GET['name_search'].'%';
		$cond_arr['name5'] = '%'.$_GET['name_search'].'%';
		
	}
	if(isset($_GET['status_type']) and $_GET['status_type'] == 'Liked'){
		$sql .= " and us.like_status='1'";
	}else if(isset($_GET['status_type']) and $_GET['status_type'] == 'Unliked'){
		$sql .= " and us.like_status='2'";
	}else if(isset($_GET['status_type']) and $_GET['status_type'] == 'Recommended'){
		$sql .= " and us.recommend_link='1'";
	}else if(isset($_GET['status_type']) and $_GET['status_type'] == 'Unrecommended'){
		$sql .= " and us.recommend_link='2'";
	}

	if(isset($_GET['date_start']) and $_GET['date_start']!='' and isset($_GET['date_end']) and $_GET['date_end']!=''){
		$sql .= " and us.shared_time>=:date and us.shared_time<=:date2";
		$cond_arr['date'] = strtotime($_GET['date_start'].' 00:00:00');
		$cond_arr['date2'] = strtotime($_GET['date_end'].' 23:59:59');
	}elseif(isset($_GET['date_start']) and $_GET['date_start']!=''){
		$sql .= " and us.shared_time>=:date";
		$cond_arr['date'] = strtotime($_GET['date_start'].' 00:00:00');
	}else if(isset($_GET['date_end']) and $_GET['date_end']!=''){
		$sql .= " and us.shared_time<=:date2";
		$cond_arr['date2'] = strtotime($_GET['date_end'].' 23:59:59');
	}
	
	
}
	$sql .= " GROUP BY us.url_id ORDER BY us.shared_url_id DESC";



$this_page = "p=url_management/manage_user_share_urls";				

$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), $cond_arr);
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}
		
?>								<form class="form-horizontal" enctype="multipart/form-data" method="GET">									
									<input type="hidden" value="url_management/manage_user_share_urls" name="p">									
									<div class="form-group">										
										<div class="col-sm-3">											
											<input type="text" placeholder="Search with keywards" value="<?=isset($_GET['name_search']) ? $_GET['name_search'] : ''?>" class="form-control" name="name_search">										
										</div>
										<div class="col-sm-3">											
											<select name="status_type" class="form-control">
												<option value="">Select Status</option>
												<?php
												$status_typ = array('Pending','Approved');
												foreach ($status_typ as $name) {
													$sel = '';
													if(isset($_GET['status_type']) and $_GET['status_type'] == $name)
														$sel = ' selected="selected"';
													echo '<option value="'.$name.'"'.$sel.'>'.$name.' URLs</option>';
												}
												?>
											</select>	
										</div>
										<div class="col-sm-3">											
										<input type="text" placeholder="From date" value="<?=isset($_GET['date_start']) ? $_GET['date_start'] : ''?>" class="form-control default_date_picker" name="date_start">										
										</div>
										<div class="col-sm-3">											
										<input type="text" placeholder="To date" value="<?=isset($_GET['date_end']) ? $_GET['date_end'] : ''?>" class="form-control default_date_picker" name="date_end">										
										</div>
										<div class="col-sm-3">												
											<button class="btn btn-primary" name="save" type="submit">Filter</button>											
										</div>	
																	
									</div>								
								</form>
								
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Sr no.</th><th>Create By</th><th>Url</th><th>Category</th><th>Public Bag<br />Status</th><th>Created On</th><th>Actions</th>
											</tr>
										</thead>
									   <tbody>
										
											<?php
											$acc_type = array('','Personal','Business','Education');	
											$links = array('Pending','Approved');	
											$links_type = array('No','Yes','No');	
											foreach($rows as $row){
												$created_by = '';
												if($row['first_name'] != '' )
													$created_by .= $row['first_name'];
												if($row['last_name'] != '' )
													$created_by .= ' '.$row['last_name'];
												$created_by .= '<br />'.$row['email_id'];
												
												$cat = '';
												if($row['approved_public_cat'] > 0){
													$public_cat = $co->query_first("SELECT cname FROM `user_public_category` WHERE cid=:cid", array('cid'=>$row['approved_public_cat']));
													if(isset($public_cat['cname'])){
														$cat = $public_cat['cname'];
													}else{
														$cat = 'N/A';
													}
												}else{
													$cat = 'N/A';
												}
											?>
											<tr>
												<td><?=$i?></td>
												<td><?=$created_by?></td>
												<td><?=$row['url_title'].'<br />'.$row['url_value']?></td>
												<td><?=$cat?></td>
												<td><?=($links[$row['approved_public']])?></td>
												<td><?=date('j F, Y',strtotime($row['created_date']));?></td>                                      
												<td> 
													<a href="main.php?p=url_management/edit_user_share_urls&amp;id=<?=$row['url_id'];?>" class="btn btn-xs btn-primary"> <i class="fa fa-fw fa-edit"></i> Edit</a>
												</td>
											</tr>
											
											 <?php $i++; } ?>
										</tbody>
									</table>
									<nav class="text-center">
										<ul class="pagination"><?=$co->getPagingLinks($sql, $cond_arr, $item_per_page, $this_page)?></ul>
									</nav>
                                </div>