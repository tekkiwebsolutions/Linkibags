<?php
if(!isset($include))
	exit();
	$user_login = $co->is_userlogin();
	$current = $co->getcurrentuser_profile();
	$profile = $co->call_profile($current['uid']);
	$categories = $co->show_all_category();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
		<title><?=$title?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="">
		<meta name="description" content="">
		
		<link type="image/x-icon" href="images/favicon.png" rel="shortcut icon">

		<!-- animate css -->
		<link rel="stylesheet" href="<?=WEB_ROOT?>/theme/css/animate-stop.min.css">
		<!-- bootstrap css -->
		<link rel="stylesheet" href="<?=WEB_ROOT?>/theme/css/bootstrap.min.css">
		<!-- font-awesome -->
		<link rel="stylesheet" href="<?=WEB_ROOT?>/theme/css/font-awesome.min.css">
		<!-- dialogues-->
		
		<!-- google font -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700,800' rel='stylesheet' type='text/css'><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

		<!-- custom css -->
		<link rel="stylesheet" href="<?=WEB_ROOT?>/theme/css/linkibag.css">
		<link rel="stylesheet" href="<?=WEB_ROOT?>/theme/css/mobile.css">
		<link rel="stylesheet" href="<?=WEB_ROOT?>/theme/css/chosen.css" />
		
		
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2'></script>


<script type="text/javascript">
	  $(function() {
            var offset = $("#sidebar").offset();
            var topPadding = 15;
            $(window).scroll(function() {
                if ($(window).scrollTop() > offset.top) {
                    $("#sidebar").stop().animate({
                        marginTop: $(window).scrollTop() - offset.top + topPadding
                    });
                } else {
                    $("#sidebar").stop().animate({
                        marginTop: 0
                    });
                };
            });
        });
</script>
<script type="text/javascript">
	$(function () {
    /* BOOTSNIPP FULLSCREEN FIX */
    if (window.location == window.parent.location) {
        $('#back-to-bootsnipp').removeClass('hide');
    }
    
    
    $('[data-toggle="tooltip"]').tooltip();
    
    $('#fullscreen').on('click', function(event) {
        event.preventDefault();
        window.parent.location = "http://bootsnipp.com/iframe/4l0k2";
    });
    $('a[href="#cant-do-all-the-work-for-you"]').on('click', function(event) {
        event.preventDefault();
        $('#cant-do-all-the-work-for-you').modal('show');
    })
    
    $('[data-command="toggle-search"]').on('click', function(event) {
        event.preventDefault();
        $(this).toggleClass('hide-search');
        
        if ($(this).hasClass('hide-search')) {        
            $('.c-search').closest('.row').slideUp(100);
        }else{   
            $('.c-search').closest('.row').slideDown(100);
        }
    })
    
    $('#contact-list').searchable({
        searchField: '#contact-list-search',
        selector: 'li',
        childSelector: '.col-xs-12',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    })
});
</script>		
<script src="https://www.google.com/recaptcha/api.js"></script>
	</head>
	<body>
	
	
	
		<!-- 
		<div class="preloader">
			<div class="sk-spinner sk-spinner-rotating-plane"></div>
    	 </div> -->
		<!-- end preloader -->
	
		<div class="top-nav">
			<div class="container">
				<div class="col-md-12 text-right">
					<a href="index.php?p=terms-of-use">Terms of Use</a>
				</div>	
			</div>
		</div>
		
		<!-- start navigation -->
		<nav id="mynav" class="navbar navbar-default templatemo-nav" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
					</button>
					<a href="index.php?home_link=1" class="navbar-brand"><img class="img-responsive" alt="logo" src="images/main-logo.jpg"></a>
					
				</div>
				

				<div class="navbar-collapse collapse" id="navbar-main">
					<ul class="nav navbar-nav" <?php if($user_login){ ?> style="float: right;" <?php } ?>>
					<li><a style="color:#c3c3c3;" class="how-it-works" href="index.php?p=how-it-works">How It Works</a></li>
					<li>
		
							<span class="profile-name how-it-works"></span>
						
					</li>
					<?php if($user_login){ ?>
					<!--<li class="save-new-link"><a data-toggle="modal" data-target="#add-url-form" href="#"><i class="fa fa-link"></i> Save New URL</a></li>-->
					<?php } ?>
					
					<?php 
					if($user_login){ 
					?>	
					<li>
						<div class="dropdown dropdown-design">
							<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">My Account &nbsp;
							&nbsp;<li class="caret"></li></button>
							<ul class="dropdown-menu pull-right">
								<li><a href="index.php?p=contact-us"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Upgrade  |  Renew</a></li>
								<li><a href="index.php?p=linkifriends"><i class="fa fa-list" aria-hidden="true"></i> Friend List</a></li>
								<li><a href="index.php?p=edit-profile"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</a></li>						
								<li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
							</ul>
						</div>
					</li> 
					<?php } ?>	
					
					</ul>
					<?php if(!$user_login){ ?>
					
					<div style="position: relative;" class="right-btn-user text-right pull-right">
						<a class="btn bg-white" style="padding: 3px 42px;" href="index.php?p=login" >Log In</a>
						<a class="btn bg-orange" href="index.php?p=personal-account">Free Sign up</a>
						
					</div>
					
					<?php  } ?>
					
					
				</div>
			</div>
		</nav>
		