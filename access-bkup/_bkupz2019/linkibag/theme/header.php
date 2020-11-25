<?php
if(!isset($include))
	exit();
	$user_login = $co->is_userlogin();
	$current = $co->getcurrentuser_profile();
	$profile = $co->call_profile($current['uid']);
	$categories = $co->show_all_category();
?>
<?php
	if(isset($_POST['accept'])){
		$_SESSION["accept"] = 1;
		echo '<script type="text/javascript">window.location.href="index.php";</script>';
		exit();
	}
	if(!(isset($_GET['p']) and $_GET['p'] == 'renew')){
		unset($_SESSION['coupon_code']);
		unset($_SESSION['coupon_discount']);
	}
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

<script src="<?=WEB_ROOT?>/theme/js/clipboard.min.js"></script>
	</head>
	<body>



		<!--
		<div class="preloader">
			<div class="sk-spinner sk-spinner-rotating-plane"></div>
    	 </div> -->
		<!-- end preloader -->

		<div class="top-nav">
			<div class="container">
				<div style="padding-left: 0px;" class="col-md-12">
					<?php if(isset($_GET['p']) and $_GET['p']!="home") { ?>
					<div class="aplhatopmsg pull-left" style="color: #000;">
						<span class="close" data-dismiss="aplhatopmsg" style="font-size: 16px; padding: 0px 6px; opacity: 1;">x</span>
						<strong>By using alpha version of this portal you agree on terms of use. <a href="javascript: void(0)" style="text-decoration: underline;" data-toggle="modal" data-target="#aplhamsgpopup">Read more</a>.</strong>
					</div>
<div class="modal fade" id="aplhamsgpopup" role="dialog" style="top: 25px; padding-top: 15px;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">You are using the alpha version of LinkiBag Portal. Please read our <a href="Term-of-use.pdf" style="text-decoration: underline;" target="_blank">Terms of use</a> carefully before you use this website. </h4>
			</div>
			<p class="model-block">
			The alpha phase of the release life cycle is the first phase of software testing. This is an initial development version that was released to help improve the software and fix bugs that may still be present in the software. It is expected that the alpha version of the software or website will be incomplete and may be buggy. The product or service may undergo extended changes or updates before the next version is released. Use of the alpha version may provide the company with feedback from test users. This version may not contain all features that are planned for the final version and may have a feature freeze for blocks that will be added to the software later.<br><br>
			By clicking "I Accept," you confirm that you are at least 18 years of age, have read the terms and conditions of the website, and have read the terms of use for the alpha version of this website. You confirm that you understand them and that you agree to be bound by them (you accept them). By clicking "I Accept," you also confirm that you will be using the alpha version of LinkiBag Portal and that we are not responsible for entries that are lost, late, misaddressed, or misdirected due to technical or any non-technical failures; errors or data loss of any kind; lost or unavailable internet connections; failed or incomplete, garbled, or deleted computer or network transmissions; an inability to access the website or online service; or any other technical error or malfunction.
			Use of this website is subject to the Terms and Conditions for using the alpha version of the website and subject to the Website Terms and Conditions. These Terms and Conditions constitute a legally binding agreement between you and the company regarding the use of the service.<br><br>
			If you do not agree with all the terms of these Terms and Conditions, click the "Exit" button next to the text that reads "I am over 18 years old and I have read, understand, and accepted the Terms and Conditions." Do not click the "I Accept" button and do not attempt to use or continue using any of the services.<br><br>I am over 18 years old and I have read, understand, and accepted this agreement and Website <a href="Term-of-use.pdf" style="text-decoration: underline;" target="_blank">Terms of Use</a> and I accept and agree to terms and conditions of both.
			</p>
			<div class="modal-footer ">
				<div class="pull-left">
					<a type="button" style="color: #fff;" class="btn btn-success" data-dismiss="modal" aria-label="Close">I Accept</a>
					<a href="http://google.com" style="color: #fff;" class="btn btn-danger">Exit</a>
				</div>
			</div>
		</div>
	</div>
</div>
					<?php } ?>
					<div class="pull-right"><a style="display: inline-block;" href="index.php?p=terms-of-use">Terms of Use</a></div>
				</div>
			</div>
		</div>
		<span id="GoTop"></span>
		<!-- start navigation -->
		
		<?php /*
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
				<?php if(isset($_SESSION["accept"])) { ?>
				<div class="feedback-button">
				<div class="col-md-2">
					<div class="alert profie-basic-ino dashboard-profile-links feedback-btn">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<div class="main-profile-user">
							<div class="profile-avatar-name">
								<div class="feed-btn">
							      <a href="index.php?p=contact-us&amp;type_of_inquiry=send_feedback"><b>Send feedback</b></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
				<?php } ?>
				<div class="navbar-collapse collapse" id="navbar-main">
					<ul class="nav navbar-nav" <?php if($user_login){ ?> style="float: right;" <?php } ?>>
					<li><a style="color:#c3c3c3;" class="how-it-works" href="index.php?p=how-it-works">How It Works</a></li>

					<?php if($user_login){ ?>
					<!--<li class="save-new-link"><a data-toggle="modal" data-target="#add-url-form" href="#"><i class="fa fa-link"></i> Save New URL</a></li>-->
					<?php } ?>

					<li>
						<?php
						// for view share page where user enter share id and this page is only for 30 minutes
						//if(isset($_GET['p']) and $_GET['p'] == 'view-share' and !(isset($_GET['share_to']) and !filter_var($_GET['share_to'], FILTER_VALIDATE_EMAIL) === false)){
						if(!(isset($_GET['share_to']) and !filter_var($_GET['share_to'], FILTER_VALIDATE_EMAIL) === false)){

						?>
						<form class="navbar-form top-search-bar" role="search" method="get">
							<input type="hidden" name="p" value="view-share">
							<input type="hidden" name="share_to" value="from_entered_id">
					        <div class="input-group">
					            <input class="form-control" maxlength="7" id="share_no" placeholder="Share ID" name="share_no" type="text" value="<?=((isset($_GET['share_to']) and isset($_GET['share_no']) and $_GET['share_to'] == 'from_entered_id' and $_GET['share_no'] != '') ? $_GET['share_no'] : '')?>">
					            <div class="input-group-btn">
					                <button type="submit">View</button>
					            </div>
					        </div>
        				</form>

						<?php } ?>
					</li>
					<?php
					if($user_login){
					?>
					<li>
						<div class="dropdown dropdown-design">
							<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">My Account &nbsp;
							&nbsp;<li class="caret"></li></button>
							<ul class="dropdown-menu pull-right">
								<!--<li><a href="index.php?p=contact-us&type_of_inquiry=account_upgrades"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Upgrade  |  Renew</a></li>-->
								<li><a href="index.php?p=renew"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Upgrade  |  Renew</a></li>
								<!--<li><a href="index.php?p=linkifriends"><i class="fa fa-list" aria-hidden="true"></i> Friend List</a></li> -->
								<li><a href="index.php?p=edit-profile"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</a></li>
								<li><a href="index.php?p=categories-list"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a></li>
								<li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
							</ul>
						</div>
					</li>
					<?php } ?>

					</ul>
					<?php if(!$user_login){
						$free_sign_up_link = '#free_singup';
						if(isset($_GET['p']) and $_GET['p'] != '')
							$free_sign_up_link = 'index.php?#free_singup';
					?>

					<div style="position: relative;" class="right-btn-user text-right pull-right">
						<a class="btn bg-white" style="padding: 3px 42px;" href="index.php?p=login" >Log In</a>
						<a class="btn bg-orange" href="<?=$free_sign_up_link?>">Free Sign up</a>

					</div>

					<?php  } ?>


				</div>
			</div>
		</nav>
		
		*/ ?>
		
		
		
		
		
		<!-- start navigation -->
		<nav id="mynav" class="navbar navbar-default templatemo-nav" role="navigation">
			
			<div class="container">
			<div class="navbar-linkibag-new">
				<div class="navbar-header col-md-2 padding-none">
					<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
					</button>
					<a href="index.php?home_link=1" class="navbar-brand"><img class="img-responsive" alt="logo" src="images/main-logo.jpg"></a>
				</div>
				<div class="col-md-10">
				<?php if(isset($_SESSION["accept"])) { ?>
				<div class="col-md-2 text-right padding-none">
					<div class="alert profie-basic-ino dashboard-profile-links feedback-btn">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<div class="main-profile-user">
							<div class="profile-avatar-name">
								<div class="feed-btn">
							      <a href="index.php?p=contact-us&amp;type_of_inquiry=send_feedback"><b>Send feedback</b></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-2 padding-none xs-center">
					<a style="color:#c3c3c3;" class="how-it-works" href="index.php?p=how-it-works">How It Works</a>
				</div>
				<div class="col-md-4 padding-none">
					
					<?php } ?>
			
					<ul class="nav navbar-nav">
					

					<?php if($user_login){ ?>
					<!--<li class="save-new-link"><a data-toggle="modal" data-target="#add-url-form" href="#"><i class="fa fa-link"></i> Save New URL</a></li>-->
					<?php } ?>

					<li>
						<?php
						// for view share page where user enter share id and this page is only for 30 minutes
						//if(isset($_GET['p']) and $_GET['p'] == 'view-share' and !(isset($_GET['share_to']) and !filter_var($_GET['share_to'], FILTER_VALIDATE_EMAIL) === false)){
						if(!(isset($_GET['share_to']) and !filter_var($_GET['share_to'], FILTER_VALIDATE_EMAIL) === false)){

						?>
						<form class="navbar-form top-search-bar" role="search" method="get">
							<input type="hidden" name="p" value="view-share">
							<input type="hidden" name="share_to" value="from_entered_id">
					        <div class="input-group">
					            <input class="form-control" maxlength="7" id="share_no" placeholder="Share ID" name="share_no" type="text" value="<?=((isset($_GET['share_to']) and isset($_GET['share_no']) and $_GET['share_to'] == 'from_entered_id' and $_GET['share_no'] != '') ? $_GET['share_no'] : '')?>">
					            <div class="input-group-btn">
					                <button type="submit">View</button>
					            </div>
					        </div>
        				</form>

						<?php } ?>
					</li>
					

					</ul>
					</div>
				
				<div class="col-md-4 padding-none">
				<ul class="nav navbar-nav" <?php if($user_login){ ?> style="float: right;" <?php } ?>>
					<?php
					if($user_login){
					?>
					<li>
						<div class="dropdown dropdown-design">
							<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">My Account &nbsp;
							&nbsp;<li class="caret"></li></button>
							<ul class="dropdown-menu pull-right">
								<!--<li><a href="index.php?p=contact-us&type_of_inquiry=account_upgrades"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Upgrade  |  Renew</a></li>-->
								<li><a href="index.php?p=renew"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Upgrade  |  Renew</a></li>
								<!--<li><a href="index.php?p=linkifriends"><i class="fa fa-list" aria-hidden="true"></i> Friend List</a></li> -->
								<li><a href="index.php?p=edit-profile"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</a></li>
								<li><a href="index.php?p=categories-list"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a></li>
								<li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
							</ul>
						</div>
					</li>
					<?php } ?>
					</ul>
				
					<?php if(!$user_login){
						$free_sign_up_link = '#free_singup';
						if(isset($_GET['p']) and $_GET['p'] != '')
							$free_sign_up_link = 'index.php?#free_singup';
					?>

					<div style="position: relative;" class="right-btn-user text-right pull-right">
						<a class="btn bg-white" style="padding: 3px 42px;" href="index.php?p=login" >Log In</a>
						<a class="btn bg-orange" href="<?=$free_sign_up_link?>">Free Sign up</a>

					</div>

					<?php  } ?>
				</div>
				
				
					


				
				</div>
			</div>
			</div>
		</nav>
