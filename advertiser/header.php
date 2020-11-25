<?php

define('WSNAME','LinkiBag');
define('WSTAGLINE','');
$advertiser = $co->getcurrent_admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=WSNAME?> | Advertiser</title>
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
             <li class="dropdown">
                    <a style="color: rgb(255, 255, 255) ! important; font-size: 16px;" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="ion-person"></i> <?=$advertiser['name']?> <b class="caret"></b></a>
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
				
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="main.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="main.php?p=user_management/manage" class="active"><i class="fa fa-fw fa-users"></i> View Users</a>
                    </li>
                    <li>
                        <a href="main.php?p=ads_management/add"><i class="fa fa-fw fa-link"></i> Add New URL</a>
                    </li>
					<li>
						<a href="main.php?p=ads_management/manage"><i class="fa fa-fw fa-link"></i>  Links</a>
					</li> 
				<li>
						<a href="main.php?p=message_management/manage"><i class="fa fa-fw fa-envelope"></i> Messages</a>
					</li> 
					<!-- 	<li>
						<a href="main.php?p=ads_management/manage&status=approved"><i class="fa fa-fw fa-link"></i> View Approved Links</a>
					</li> 
					<li>
						<a href="main.php?p=ads_management/manage&status=declined"><i class="fa fa-fw fa-link"></i> View Declined Links</a>
					</li> -->
					
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>