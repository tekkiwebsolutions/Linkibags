<?php

define('WSNAME','Linkibag');
define('WSTAGLINE','');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=WSNAME?> | Admin</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/jquery.datepick.css" rel="stylesheet">
	<link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,300italic,300,600,700,700italic,600italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="data-tables/DT_bootstrap.css" />		<link href="css/jquery-ui.css" rel="stylesheet">
	<link rel="stylesheet" href="../theme/css/chosen.css" />
	<link href="css/dataTables.min.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php?p=dashboard"><img class="img-responsive" src="main-logo.jpg" alt="logo"></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
            	<li><a style="color: rgb(255, 255, 255) ! important; font-size: 16px;" href="main.php?p=popup_setting">Home Popup</a></li>
            	<li><a style="color: rgb(255, 255, 255) ! important; font-size: 16px;" href="main.php?p=service_countries_setting">Service Countries</a></li>
                <li class="dropdown">
                    <a style="color: rgb(255, 255, 255) ! important; font-size: 16px;" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="ion-person"></i> <?=$_SESSION['admin_website']?><b class="caret"></b></a>
                    <ul style="min-width: 191px;" class="dropdown-menu">
                        <li>
                            <a href="main.php?p=adminpassword"><i class="fa fa-fw fa-gear"></i> Change Password</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
				<?php
				$user_nav_link = 'off';
				$ad_nav_link = 'off';
				$farmtalk_tags_nav_link = 'off';
				$topic_nav_link = 'off';
				$banner_nav_link = 'off';
				$state_nav_link = 'off';
				$city_nav_link = 'off';
				$faq_nav_link = 'off';
				$blog_nav_link = 'off';
				$page_nav_link = 'off';
				$info_security_link = 'off';
				$coupon_discount_link = 'off';
				$folder_nav_link = 'off';
				
				if(isset($_GET['p'])){
					$getparr = explode('/', $_GET['p']);
					if(in_array('user_management', $getparr)){
						$user_nav_link = 'on';
					}
					if(in_array('url_management', $getparr)){
						$ad_nav_link = 'on';
					}
					if(in_array('page_management', $getparr)){
						$page_nav_link = 'on';
					}
					if(in_array('admin_url_management', $getparr)){
						$farmtalk_tags_nav_link = 'on';
					}
					if(in_array('topic_management', $getparr)){
						$topic_nav_link = 'on';
					}
					if(in_array('category_management', $getparr)){
						$banner_nav_link = 'on';
					}
					if(in_array('state', $getparr)){
						$state_nav_link = 'on';
					}
					if(in_array('city', $getparr)){
						$city_nav_link = 'on';
					}
					if(in_array('faq', $getparr)){
						$faq_nav_link = 'on';
					}
					if(in_array('blog', $getparr)){
						$blog_nav_link = 'on';
					}
					if(in_array('information_security_links', $getparr)){
						$info_security_link = 'on';
					}
					if(in_array('discount', $getparr)){
						$coupon_discount_link = 'on';
					}
					if(in_array('folder', $getparr)){
						$folder_nav_link = 'on';
					}
					
					
				}
				?>
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="main.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
					<li>
						
                        <a href="javascript:;" data-toggle="collapse" data-target="#user_link"><i class="fa fa-fw ion-person-stalker"></i> User management<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="user_link" class="collapse demo<?=($user_nav_link=='on' ? ' in' : '')?>">
                            <!--
							<li>
                                <a href="main.php?p=user_management/add">Add New</a>
                            </li>-->
							<?php 
							//$p='user_management/manage';
							//$active = 'classs="active"';
							?>
                            <li>
                                <a href="main.php?p=user_management/manage" class="active">Manage</a>
                            </li>
							
                        </ul>
                    </li>
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#ad_manage_link"><i class="fa fa-link"></i> Url Management<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="ad_manage_link" class="collapse demo<?=($ad_nav_link=='on' ? ' in' : '')?>">
                        	<li>
                                <a href="main.php?p=url_management/manage_user_share_urls">Manage Share URL</a>
                            </li>
                            <li>
                                <a href="main.php?p=url_management/manage">Manage</a>
                            </li>
							<li>
                                <a href="main.php?p=url_management/manage_video_links">Manage Video Links</a>
                            </li>
							<li>
                                <a href="main.php?p=url_management/manage_user_pending_urls">Manage Pending Links</a>
                            </li>
							
                        </ul>
                    </li>
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#farmtalk_tag_link"><i class="fa fa-link"></i> Admin Url Management<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="farmtalk_tag_link" class="collapse demo<?=($farmtalk_tags_nav_link=='on' ? ' in' : '')?>">        
							<li>
								<a href="main.php?p=admin_url_management/add">Add</a>
							</li>
							<li>
								<a href="main.php?p=admin_url_management/manage">Manage</a>
							</li>
                        </ul>
                    </li>
					
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#banner_manage_link"><i class="fa fa-list"></i> Category management<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="banner_manage_link" class="collapse demo<?=($banner_nav_link=='on' ? ' in' : '')?>">							
							<li>
								<a href=" main.php?p=category_management/manage_public_category">Manage public category</a>
							</li> 
							
                        </ul>
                    </li>
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#folder_manage_link"><i class="fa fa-list"></i> Folder management<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="folder_manage_link" class="collapse demo<?=($folder_nav_link=='on' ? ' in' : '')?>">							
							<li>
								<a href=" main.php?p=folder/manage">Manage user folder</a>
							</li> 
							<li>
								<a href=" main.php?p=folder/manage_default_folder">Manage default folder</a>
							</li> 
							<li>
								<a href=" main.php?p=folder/recommend_default_folder_msg">Recommend folder MSG</a>
							</li> 
                        </ul>
                    </li>
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#info_security_link_manage_link"><i class="fa fa-list"></i> Info Security Links management<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="info_security_link_manage_link" class="collapse demo<?=($info_security_link=='on' ? ' in' : '')?>">							
							<li>
                                <a href="main.php?p=information_security_links/add">Add</a>
                            </li>
							<li>
								<a href=" main.php?p=information_security_links/manage">Manage</a>
							</li>															
							
                        </ul>
                    </li>
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#coupondiscount_link"><i class="fa fa-list"></i> Coupon management<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="coupondiscount_link" class="collapse demo<?=($coupon_discount_link=='on' ? ' in' : '')?>">							
							<li>
                                <a href="main.php?p=discount/add">Add</a>
                            </li>
							<li>
								<a href=" main.php?p=discount/manage">Manage</a>
							</li>															
							
                        </ul>
                    </li>
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#ads_manage_link"><i class="fa fa-fw fa-picture-o"></i> Advertise management<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="ads_manage_link" class="collapse demo<?=($banner_nav_link=='on' ? ' in' : '')?>">							
							<li>
                                <a href="main.php?p=ads_management/add">Add</a>
                            </li>
							<li>
								<a href=" main.php?p=ads_management/manage">Manage</a>
							</li> 
                        </ul>
                    </li>
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#page_manage_link"><i class="fa fa-file-text-o"></i> Page management<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="page_manage_link" class="collapse demo<?=($page_nav_link=='on' ? ' in' : '')?>">
							<li>
								<a href=" main.php?p=page_management/manage">Manage</a>
							</li> 
                        </ul>
                    </li>
					<li>
						<a href=" main.php?p=information_security_links/contact_manage"><i class="fa fa-info-circle"></i> Contact Submission Detail</a>
					</li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>