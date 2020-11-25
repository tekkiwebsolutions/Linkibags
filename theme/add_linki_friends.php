<?php  
function page_access(){	
	global $co, $msg;      	
	$user_login = $co->is_userlogin();      	
	if(!$user_login){   
		echo '<script language="javascript">window.location="index.php";</script>';      		
		exit();      
	}          
}      
function page_content(){      
	global $co, $msg;      	
	$no_record_found='';      	
	$co->page_title = "Dashboard | LinkiBag";     
 	$current = $co->getcurrentuser_profile();  	
	$user_profile_info = $co->call_profile($current['uid']);  
	$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');  	    
	$views=true;      	      	
	if(isset($_GET['views']) and $_GET['views']!=''){ 
		$item_per_page = $_GET['views'];      	
	}else{      		
		$item_per_page = 10;      	
	}	      	
	$this_page='p=dashboard';      
	$categories = $co->show_all_category();      
	if(isset($_GET['id']) and $_GET['id']!=''){      		
		$this_page='p=dashboard&id='.$_GET['id'];      		
		$urlposts_retrun = $co->get_urlposts_by_category($_GET['id'],$current['uid'],$item_per_page, $this_page);      		
		$urlposts = $urlposts_retrun['row'];      		
		$page_links = $urlposts_retrun['page_links'];      		
		if(count($urlposts)<1)      			
			$no_record_found="No Record Found";      	
	}else{	
		$urlposts_retrun = $co->get_all_urlposts($current['uid'],$item_per_page, $this_page);      	
		$urlposts = $urlposts_retrun['row'];      		
		$page_links = $urlposts_retrun['page_links'];  
		$total_pages = $urlposts_retrun['paging2'];  
		$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');	
	}      
		if(isset($_GET['views']) and $_GET['views']!=''){
      		$this_page .= '&views='.$_GET['views'];      	
		}      	
		/*      	
		if(isset($_GET['delid'])){            		
		$co->query_delete('user_urls', array('id'=>$_GET['delid']),'url_id=:id');            		
		$co->setmessage("error", "URL post has been successfully deleted");      		
		echo '<script type="text/javascript">window.location.href="index.php?p=dashboard"</script>';      	
		exit();      	
		}      	
		*/  	  	
		$total_urls = $co->users_count_url($current['uid']);  	
		$total_friends = $co->users_count_friend($current['uid']);  	
		$total_friends_url = $co->users_count_shared_url($current['uid']);      
		//print_r($urlposts);
		//echo count($urlposts);
		?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
				<div class="col-md-7">      
					<p><a href="index.php">Home </a><a href="index.php?p=dashboard"> > Dashboard</a></p>    
				</div> 
				<div class="col-md-5 text-right">
					<!--<div class="dropdown dropdown-bg-none top-user-drop pull-right">
						<a data-toggle="dropdown" class="btn dropdown-toggle pull-right" aria-expanded="false"><?php//$current['email_id']?> <li class="caret"></li></a>
						<ul class="dropdown-menu">
							<li><a href="index.php?p=dashboard"><i aria-hidden="true" class="fa fa-tachometer"></i> Dashboard</a></li>
							<li><a href="index.php?p=friends"><i aria-hidden="true" class="fa fa-list"></i> Friend List</a></li>
							<li><a href="index.php?p=edit-profile"><i aria-hidden="true" class="fa fa-pencil"></i> Edit Profile</a></li>						
							<li><a href="logout.php"><i aria-hidden="true" class="fa fa-sign-out"></i> Logout</a></li>
						</ul>
					</div>-->
				</div>
			</div>  
			<div class="containt-area" id="dashboard_new">  
				<div class="container"> 
					<div class="col-md-3">      
						<?php include "dashboard_sidebar.php" ?>
					</div>	
					<div class="containt-area-dash col-md-9">      
						<div class="add_linki_friends">
							<div class="user-name-dash">
								<b>Welcome mandeep singh</b>
							</div>
							<div class="gray-box green-bg">
								<h1>Add LinkiFriends</h1>
								<form action="#" method="post" name="">
								<table class="table">
								  <thead>
									<tr>
										<th width="" style="width: 2%;">
										<input id="checkAll" type="checkbox" name="check" value="">
										</th>
										<th style="width: 29%;">Email Address</th>
										<th style="width: 31%;">Name | Notes</th>
										<th style="width: 25%;">Move to</th>
										<th style="width: 8%;">Connect</th>
									</tr>
								  </thead>
								  <tbody>
									<tr>
										<td><input type="checkbox" name="check" id="checkAll" value=""/></td>
										<td><input class="form-control" type="text" name="email"/></td>
										<td><input class="form-control" type="text" name="notes"/></td>
										<td>
											<select class="form-control">
											<option>Unconfirmed</option>
											<option>2</option>
											<option>3</option>
											</select>
										</td>
										<td class="add-action"><a href="#"><img src="./images/mail-icon.jpg"></a></td>
									</tr>
									<tr>
										<td><input type="checkbox" name="check" id="checkAll" value=""/></td>
										<td><input class="form-control" type="text" name="email"/></td>
										<td><input class="form-control" type="text" name="notes"/></td>
										<td>
											<select class="form-control">
											<option>Unconfirmed</option>
											<option>2</option>
											<option>3</option>
											</select>
										</td>
										<td class="add-action"><a href="#"><img src="./images/mail-icon.jpg"></a></td>
									</tr>
									<tr>
										<td><input type="checkbox" name="check" id="checkAll" value=""/></td>
										<td><input class="form-control" type="text" name="email"/></td>
										<td><input class="form-control" type="text" name="notes"/></td>
										<td>
											<select class="form-control">
											<option>Unconfirmed</option>
											<option>2</option>
											<option>3</option>
											</select>
										</td>
										<td class="add-action"><a href="#"><img src="./images/mail-icon.jpg"></a></td>
									</tr>
									<tr>
										<td><input type="checkbox" name="check" id="checkAll" value=""/></td>
										<td><input class="form-control" type="text" name="email"/></td>
										<td><input class="form-control" type="text" name="notes"/></td>
										<td>
											<select class="form-control">
											<option>Unconfirmed</option>
											<option>2</option>
											<option>3</option>
											</select>
										</td>
										<td class="add-action"><a href="#"><img src="./images/mail-icon.jpg"></a></td>
									</tr>
									<tr>
										<td><input type="checkbox" name="check" id="checkAll" value=""/></td>
										<td><input class="form-control" type="text" name="email"/></td>
										<td><input class="form-control" type="text" name="notes"/></td>
										<td>
											<select class="form-control">
											<option>Unconfirmed</option>
											<option>2</option>
											<option>3</option>
											</select>
										</td>
										<td class="add-action"><a href="#"><img src="./images/mail-icon.jpg"></a></td>
									</tr>
									<tr>
										<td><input type="checkbox" name="check" id="checkAll" value=""/></td>
										<td><input class="form-control" type="text" name="email"/></td>
										<td><input class="form-control" type="text" name="notes"/></td>
										<td>
											<select class="form-control">
											<option>Unconfirmed</option>
											<option>2</option>
											<option>3</option>
											</select>
										</td>
										<td class="add-action"><a href="#"><img src="./images/mail-icon.jpg"></a></td>
									</tr>
									<tr>
										<td><input type="checkbox" name="check" id="checkAll" value=""/></td>
										<td><input class="form-control" type="text" name="email"/></td>
										<td><input class="form-control" type="text" name="notes"/></td>
										<td>
											<select class="form-control">
											<option>Unconfirmed</option>
											<option>2</option>
											<option>3</option>
											</select>
										</td>
										<td class="add-action"><a href="#"><img src="./images/mail-icon.jpg"></a></td>
									</tr>
									<tr>
										<td><input type="checkbox" name="check" id="checkAll" value=""/></td>
										<td><input class="form-control" type="text" name="email"/></td>
										<td><input class="form-control" type="text" name="notes"/></td>
										<td>
											<select class="form-control">
											<option>Unconfirmed</option>
											<option>2</option>
											<option>3</option>
											</select>
										</td>
										<td class="add-action"><a href="#"><img src="./images/mail-icon.jpg"></a></td>
									</tr>
									<tr>
										<td><input type="checkbox" name="check" id="checkAll" value=""/></td>
										<td><input class="form-control" type="text" name="email"/></td>
										<td><input class="form-control" type="text" name="notes"/></td>
										<td>
											<select class="form-control">
											<option>Unconfirmed</option>
											<option>2</option>
											<option>3</option>
											</select>
										</td>
										<td class="add-action"><a href="#"><img src="./images/mail-icon.jpg"></a></td>
									</tr>
									<tr>
										<td><input type="checkbox" name="check" id="checkAll" value=""/></td>
										<td><input class="form-control" type="text" name="email"/></td>
										<td><input class="form-control" type="text" name="notes"/></td>
										<td>
											<select class="form-control">
											<option>Unconfirmed</option>
											<option>2</option>
											<option>3</option>
											</select>
										</td>
										<td class="add-action"><a href="#"><img src="./images/mail-icon.jpg"></a></td>
									</tr>
									<tr>
										<td><input type="checkbox" name="check" id="checkAll" value=""/></td>
										<td><input class="form-control" type="text" name="email"/></td>
										<td><input class="form-control" type="text" name="notes"/></td>
										<td>
											<select class="form-control">
											<option>Unconfirmed</option>
											<option>2</option>
											<option>3</option>
											</select>
											<a class="blue-color-text" href="#">add a group</a>
										</td>
										<td class="add-action"><a href="#"><img src="./images/mail-icon.jpg"></a></td>
									</tr>
									<tr class="bottom-action-btns">
										<td></td>
										<td><a class="btn btn-info dark-gray-bg" href="#">Move to</a> 
											<select class="bottom-filter-control">
												<option>Trash</option>
												<option>2</option>
												<option>3</option>
											</select>
										</td>
										<td><a class="btn btn-info dark-gray-bg" href="#">Delete</a></td>
										<td><a class="btn btn-info dark-gray-bg" href="#">Go to page</a>
											<select class="bottom-filter-control">
												<option>1</option>
												<option>2</option>
												<option>3</option>
											</select>
										</td>
										<td></td>
									</tr>
								  </tbody>
								</table>
								</form>
							</div>
						</div>
					</div>    
					  
				</div>
			</div>	
		</section>
				
		<?php  }      ?>