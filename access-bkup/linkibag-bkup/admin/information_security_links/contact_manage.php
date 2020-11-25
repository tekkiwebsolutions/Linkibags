<?php
$breadcrumb = 'Contact Us Detail';
$title = '<i class="fa fa-table"></i> Manage Contact Us Detail';
$item_per_page = 12;

if(isset($_GET['delid']))

{

	$co->query_delete('contact_info', array('id'=>$_GET['delid']),'contact_info_id=:id');
	
	$co->setmessage("error", "Record has been successfully deleted");
	echo '<script type="text/javascript">window.location.href="main.php?p=information_security_links/contact_manage"</script>';
	exit();
}



$this_page = "p=information_security_links/contact_manage";				

$sql = "SELECT * from contact_info WHERE contact_info_id>'0'";

$cond_arr = array();
if(isset($_GET['save'])){
	if(isset($_GET['inquiry_search']) and $_GET['inquiry_search']!=''){
		$sql .= " AND inquiry_about=:type";
		$cond_arr['type'] = "".$_GET['inquiry_search']."";
	}
}
$sql .= " ORDER BY contact_info_id DESC";



$rows = $co->fetch_all_array($co->getPagingQuery($sql, $item_per_page), $cond_arr);
$i=1;
if(isset($_GET['page'])){
	$i = ($item_per_page * ($_GET['page']-1))+1;
}


	
?>
								
                                <div class="table-responsive">
									<form method="GET" enctype="multipart/form-data" class="form-horizontal">
										<input type="hidden" name="p" value="information_security_links/contact_manage"/>
										<div class="form-group">
											<div class="col-sm-4">
												<select name="inquiry_search" class="form-control">
													<option value="">Filter with inquiry type</option>			
													<?php
													$enquiry_type = array('Account Upgrades','New Account','Existing Account','Partnerships','Information Security Product Listing','General Inquiries');						
													foreach($enquiry_type as $list){											
														if(isset($_GET['inquiry_search']) and $_GET['inquiry_search']!='' and $_GET['inquiry_search']==$list){
															echo '<option value="'.$list.'" selected="selected">'.$list.'</option>';                          
														}else{	
															echo '<option value="'.$list.'">'.$list.'</option>';
														}
														
													}
													?>
												
												</select>
											</div>
										</div>	
										<div class="form-group">
										 <div class="col-sm-4">
											<button type="submit"  name="save" class="btn btn-primary">Send</button>
											</div>
										</div>
									</form>
									
								
                                    <table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Sr no.</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Inquiry Type</th><th>Other Information</th><th>Message</th><th>Company Name</th><th>Date</th><th>Status</th><!--<th>Actions</th>-->
											</tr>
										</thead>
									   <tbody>
										
											<?php
											if(isset($rows) and count($rows) > 0){	
												$links = array('Non Active','Active');																			
												foreach($rows as $row){
													$other_info = 'N/A';	
													if($row['general_inquiry_type'] != '')
														$other_info = $row['general_inquiry_type'];
													else if($row['existing_acc_type'] != '' or $row['exitsting_acc_no'] != '')
														$other_info = $row['existing_acc_type'].', '.$row['exitsting_acc_no'];
													else if($row['product_listing_type'] != '')
														$other_info = $row['product_listing_type'];
														
												?>
												<tr>
													<td><?=$i?></td>																							
													<td><?=$row['first_name']?></td>
													<td><?=$row['last_name']?></td>
													<td><?=$row['email_id']?></td>
													<td><?=$row['phone']?></td>												
													<td><?=$row['inquiry_about']?></td>
													<td><?=$other_info?></td>
													<td><?=substr($row['message'],0,100)?>..</td>
													<td><?=$row['company_name']?></td>
													<td><?=date('j F, Y',$row['created']);?></td>												
													<td><?=$links[$row['status']]?></td>
																						
													<td> 
														
														<a style="display: none;" class="btn btn-xs btn-danger" data-toggle="modal" role="button" href="#myModal<?=$row['contact_info_id']?>">
														<i class="fa fa-fw fa-trash"></i> Delete</a>
														<div id="myModal<?=$row['contact_info_id']?>" class="modal fade in">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																		<h3 id="myModalLabel3">Deleting Record</h3>
																	</div>
																	<div class="modal-body">
																		<p>Are you sure!</p>
																	</div>
																	<div class="modal-footer">
																		<div class="btn-group">
																				<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
																				<a href="main.php?p=information_security_links/contact_manage&amp;delid=<?=$row['contact_info_id']?>"><button class="btn btn-info"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>
																		</div>
																	</div>
																</div><!-- /.modal-content -->
															</div><!-- /.modal-dalog -->
														</div><!-- /.modal -->  
													</td>
												</tr>
												
												 <?php $i++; 
												 }
											}else{
												echo '<td colspan="12">No, record found</td>';	
											}	
											 
											 ?>
										</tbody>
									</table>
									<nav class="text-center">
										<ul class="pagination"><?=$co->getPagingLinks($sql, $cond_arr, $item_per_page, $this_page)?></ul>
									</nav>
                                </div>