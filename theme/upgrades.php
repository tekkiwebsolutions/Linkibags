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
	$co->page_title = "Upgrades | LinkiBag";     
 	$current = $co->getcurrentuser_profile();  	
	$user_profile_info = $co->call_profile($current['uid']);  
		      	
	$this_page='p=upgrades';      
		
?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
				<div class="col-md-7">      
					<p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Upgrades</a></p>    
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
						<?php include('dashboard_sidebar.php'); ?>    
					</div>	
					<div class="containt-area-dash col-md-9">      
						<div>        
							      
							<!-- Tab panes -->        
							<div class="tab-content"> 
								Coming Soon
							</div> 
							
									
						</div>    
					</div>    
					  
				</div>
			</div>
	
		</section>
		<style>
.share-btns .btn-default {
    background: #c3c3c3 none repeat scroll 0 0;
    color: #3a3a3a;
}
.share-btns {
    display: inline-block;
    margin: 11px 0;
    width: 100%;
}
.share-btns .btn-primary {
    background: #597794 none repeat scroll 0 0;
}
.share-btns .btn {
    border: medium none;
    border-radius: 0;
}
</style>

		
					
		<?php  }      ?>