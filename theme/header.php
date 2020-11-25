<?php
if(!isset($include))
	exit();
	$user_login = $co->is_userlogin();
	$current = $co->getcurrentuser_profile();
	$profile = $co->call_profile($current['uid']);
	$categories = $co->show_all_category();
	$term_popup = $co->query_first("select * from popup_setting where popup_id='1'",array());
?>
<?php
	$_SESSION["accept"] = 1;
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
		<meta name="keywords" content="LinkiBag, LinkiBags, LInkiBook, LinkiBooks, Free, Account, Best, Share, Links, Linki-Bag, share, link, linki, Linki, Links, Web links, Instant Electronic Book Free, e-book, ebook, e-book, e-link, e-linki, linkbook, linkebook, link bag">
		<meta name="description" content=" LinkiBag - the best place to keep your links."/> 
	



		<!-- Global site tag (gtag.js) - Google Analytics -->
		

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async
		src="https://www.googletagmanager.com/gtag/js?id=UA-158171600-1"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-158171600-1');
		</script>
		<script type="application/ld+json">
		    {
				"@context" : "http://schema.org",
				"@type" : "Organization",
				"name" : "LinkiBag",
				"url" : "https://www.linkibag.com/",
				"sameAs" : [ 
					"https://www.facebook.com/linkibaglinks",
					"https://twitter.com/linkibag",
					"https://www.instagram.com/linkibag/",
					"https://www.youtube.com/channel/UCp2hsP62INPQ3n4CVOYlvqQ",
					"https://www.linkedin.com/company/linkibaginc/",
				]
			}
		</script>
		<!--<link type="image/x-icon" href="https://www.linkibag.com/images/favicon.png" rel="shortcut icon">-->
        <link rel="icon" href="https://www.linkibag.com/images/favicon.png"  type="image/x-icon" />
        
		<!-- animate css -->
		<link rel="stylesheet" href="<?=WEB_ROOT?>/theme/css/animate.min.css">
		<!-- bootstrap css -->
		<link rel="stylesheet" href="<?=WEB_ROOT?>/theme/css/bootstrap.min.css">
		<!-- font-awesome -->
		<link rel="stylesheet" href="<?=WEB_ROOT?>/theme/css/font-awesome.min.css">
		<!-- dialogues-->

		<!-- google font -->
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700,800' rel='stylesheet' type='text/css'><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

		<!-- custom css -->
		<link rel="stylesheet" href="<?=WEB_ROOT?>/theme/css/linkibag.css">
		<link rel="stylesheet" href="<?=WEB_ROOT?>/theme/css/mobile.css">
		<link rel="stylesheet" href="<?=WEB_ROOT?>/theme/css/chosen.css" />

<script type="zext/zavascript"> _linkedin_partner_id = "2439282"; window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || []; window._linkedin_data_partner_ids.push(_linkedin_partner_id); </script><script type="zext/zavascript"> (function(){var s = document.getElementsByTagName("script")[0]; var b = document.createElement("script"); b.type = "zext/zavascript";b.async = true; b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js"; s.parentNode.insertBefore(b, s);})(); </script> <noscript> <img height="1" width="1" style="display:none;" alt="" src="https://px.ads.linkedin.com/collect/?pid=2439282&fmt=gif"; /> </noscript>

<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2'></script>
<!--<script type='text/javascript' src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>-->

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

<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/be64cb8a99930e1a9965e4879/0c17ded9d885bccc2869ec228.js");</script>

	</head>
	<body onload="checkCookie()">


	<div id="mainloading" style="position: fixed; z-index: 10001; background: #fff; width: 100%; height: 100%; opacity: .9; text-align: center; display: none;">
		<img src="<?=WEB_ROOT?>linkibag-main-loading.gif">
		<div id="mainloading_wording"></div>
	</div>
	 <input type="hidden" name="profile_status" value="<?php echo $current['security_question']?>" id="profile_status" />
		<!--
		<div class="preloader">
			<div class="sk-spinner sk-spinner-rotating-plane"></div>
    	 </div> -->
		<!-- end preloader -->
        <?php if($term_popup['alpha_popup_show'] == 1) { ?>
		<div class="top-nav">
			<div class="container">
				<div style="padding-left: 0px;" class="col-md-12">
					<?php /*if(isset($_GET['p']) and $_GET['p']!="home")  {*/ ?>
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
				<h4 class="modal-title"><?=$term_popup['alpha_popup_title']?> </h4>
			</div>
			<?=$term_popup['alpha_popup_desc']?>
			<div class="modal-footer ">
				<div class="pull-left">
					<a type="button" style="color: #fff;" class="btn btn-success" data-dismiss="modal" aria-label="Close">I Accept</a>
					<a href="http://google.com" style="color: #fff;" class="btn btn-danger">Exit</a>
				</div>
			</div>
		</div>
	</div>
</div>
					<?php /*}*/ ?>
					
				</div>
			</div>
		</div>
		<?php } ?>
		
<?php if($term_popup["cookie_popup_show"] == "1") { ?>	
<!--About Cookies Pop Up-->		
<div class="modal fade" id="linkibag-cookies" role="dialog" style="top: 25px; padding-top: 15px;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="row">
				<div class="col-sm-10">
					<p class="model-block">
					<?=$term_popup["cookie_popup_msg"]?>
					</p>
				</div>
				<div class="col-sm-2">
					<button style="display:none" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<button type="button" class="btn btn-primary" data-dismiss="modal" style="opacity: 1;margin-top: 10px;float: right; margin-right: 10px">I Agree!</button>
					
				</div>
			</div>
		</div>
	</div>
</div>					
<!---->	
<?php } ?>	

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
						$free_sign_up_link = '#free_signup';
						if(isset($_GET['p']) and $_GET['p'] != '')
							$free_sign_up_link = 'index.php?#free_signup';
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
			    <div class='nav_part'>
				<div class="navbar-header col-md-2 padding-none">
					<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
					</button>
					<a href="<?=WEB_ROOT?><?=((isset($current['uid']) and $current['uid'] > 0) ? 'index.php?p=dashboard' : 'index.php?home_link=1')?>" class="navbar-brand"><img class="img-responsive" alt="logo" src="<?=WEB_ROOT?>images/main-logo.jpg"></a>
				
				</div>
				<div class="navbar-header col-md-2 padding-none">
				<span class=" bg-red" style="cursor: pointer;" onClick="openBetaPopup()">BETA</span>
				</div>
				</div>
				<div class="col-md-10 col-sm-12 after_beta_block">
			
				<?php if(isset($_SESSION["accept"])) { ?>
				
				
				<div class="col-md-2 col-sm-2 text-right padding-none">
				    <?php if($user_login and !$user_login){ ?>
					<div class="alert profie-basic-ino dashboard-profile-links feedback-btn">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<div class="main-profile-user">
							<div class="profile-avatar-name">
								<div class="feed-btn">
								    
							      <a href="<?=WEB_ROOT?>send-feedback"><b>Send feedback</b></a>
							        
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
				
				
				<div class="col-md-2 col-sm-2 padding-none xs-center">
					<a class="how-it-works" href="<?=WEB_ROOT.'learn-more'?>">Learn more</a>
				</div>
				<div class="col-md-4 col-sm-4 padding-none">
					
					<?php } ?>
			
					<ul class="nav navbar-nav">
					
					
					<?php if($user_login){ ?>
					<!--<li class="save-new-link"><a data-toggle="modal" data-target="#add-url-form" href="#"><i class="fa fa-link"></i> Save New URL</a></li>-->
					<?php } ?>

					<li>
						<?php
						/* for view share page where user enter share id and this page is only for 30 minutes
						if(isset($_GET['p']) and $_GET['p'] == 'view-share' and !(isset($_GET['share_to']) and !filter_var($_GET['share_to'], FILTER_VALIDATE_EMAIL) === false)){
						if(!(isset($_GET['share_to']) and !filter_var($_GET['share_to'], FILTER_VALIDATE_EMAIL) === false)){
						*/
						/* Show this all pages only except view share */
						
						if(!(isset($_GET['p']) and $_GET['p']=='view-share')){		
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
				
				<div class="col-md-4 col-sm-4 padding-none">
				<a href="<?=WEB_ROOT?>contact-us?id=Reported_Bug">    <span class='report_bug'>Report a Bug <i class="fa fa-bug" aria-hidden="true"></i></span></a>
				<ul class="nav navbar-nav btn_anchor" <?php if($user_login){ ?> style="float: right;" <?php } ?>>
					<?php
					if($user_login){
					?>
					<li>
						<div class="dropdown dropdown-design">
							<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">My Account &nbsp;
							&nbsp;<li class="caret"></li></button>
							<ul class="dropdown-menu pull-right">
								<!--<li><a href="index.php?p=contact-us&type_of_inquiry=account_upgrades"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Upgrade  |  Renew</a></li>-->
								<?php /*
								<li><a href="index.php?p=renew"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Upgrade  |  Renew</a></li>*/?>
								<!--<li><a href="index.php?p=linkifriends"><i class="fa fa-list" aria-hidden="true"></i> Friend List</a></li> -->
								
								<li><a href="<?=WEB_ROOT?>index.php?p=account_settings"><i class="fa fa-cog" aria-hidden="true"></i> Account Settings</a></li>
								
			
								<li><a href="<?=WEB_ROOT?>index.php?p=edit-profile"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</a></li>
								<li><a href="index.php?p=update_pass"><i class="fa fa-cog" aria-hidden="true"></i> Change Password</a></li>
								
								<?php /*
								<li><a href="index.php?p=close-account"><i class="fa fa-sign-out" aria-hidden="true"></i> Close Account</a></li>
								<li><a href="index.php?p=categories-list"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a></li>*/ ?>
								<li><a href="<?=WEB_ROOT?>logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
							</ul>
						</div>
						
					</li>
					
				
					<?php } ?>
					</ul>
					<?php if(!$user_login){
						$free_sign_up_link = '#free_signup';
						if(isset($_GET['p']) and $_GET['p'] != '')
							$free_sign_up_link = 'sign-up';
					?>
					<div style="position: relative;" class="right-btn-user text-right pull-right free_signup">
						<a class="btn bg-white"  href="<?=WEB_ROOT?>login" >Log In</a>
						<a class="btn bg-orange" href="<?=WEB_ROOT?>sign-up">Free Sign Up</a>
					
				
					</div>
					<?php  } ?>
					
				</div>
				</div>
			</div>
			</div>
			
						
		</nav>

		
		<?php 
		$term_popup = $co->query_first("select * from popup_setting where popup_id='1'",array());
	
		?>
<button style="display:none" type="button" class="disclaimer_modal" data-toggle="modal" data-target="#centralModalSuccess">
</button>

 <!-- Central Modal Medium Success -->
 <div class="modal fade" id="centralModalSuccess" tabindex="-1"  data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
   <input type="hidden" name="betaPopup" value="<?php echo $term_popup['beta_popup_show']?>" id="betaPopup" />
   <div class="modal-dialog modal-notify modal-success" role="document">
     <!--Content-->
     <div class="modal-content">
       <!--Header-->
       <div class="modal-header">
         <p class="heading lead">Beta Disclaimer</p>
       </div>

       <!--Body-->
       <div class="modal-body">
         <div class="text-center">
		 <?php 
		echo $term_popup['beta_popup_title'];
		echo $term_popup['beta_popup_desc'];
         ?>
         </div>
       </div>

       <!--Footer-->
       <div class="modal-footer justify-content-center">
         <a  onclick ="agree_disclaimer()" type="button" class="btn btn-success "> I Accept <i class="far fa-gem ml-1 text-white"></i></a>
         
         <a type="button" class="btn btn-outline-success waves-effect cancel_agreement" onclick="cancel_agreement()" >Cancel</a>
         <a type="button" class="data_dismiss" data-dismiss="modal"></a>
       </div>
     </div>
     <!--/.Content-->
   </div>
 </div>


<!-- ---------------------------------------------------- Modal for Complete profile message ------------------------------------- -->

<button style="display:none" type="button" class="complete_modal" id="completeModalSuccesss" data-toggle="modal" data-target="#completeModalSuccess">
</button>

 <!-- Central Modal Medium Success -->
<div class="modal fade" id="completeModalSuccess" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-success modal-sm" role="document" style="margin-top: 150px;">
        <!--Content-->
        <div class="modal-content" style="padding: 4px;border-radius: 5px !important;">
            <!--Header-->
            <div class="modal-header ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                <span class="heading leadui-dialog-title" style="font-size: 15px; "> Please complete your regsitration </span>
            </div>
            <!--Body-->
            <div class="modal-body">
                <div class=" ui-dialog-content ui-widget-content" style="font-size: 15px;">
                    Please complete your registration and interest forms to start using LinkiBag
                </div>
            </div>
            <!--Footer-->
            <div class="ui-dialog-buttonset" style=" padding: 9px;">
                <button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" onclick="proceed()">
                <span class="ui-button-text">Proceed <i class="far fa-gem ml-1 text-white"></i></span>
                </button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<?php  if(($_GET['p']!='edit-profile')){

 if($user_login){ 

?>
 <script type="text/javascript">
 
 	function openCompletePopup()
	{
	    	$('#completeModalSuccess').modal({backdrop: 'static', keyboard: false});
	
	}
	setTimeout(function(){ 
	  
	var profile_status = $("#profile_status").val();

		if(profile_status==0)
		{
		    openCompletePopup()
		 
		  //  console.log(9999999999999999999999943434);
        //$(".disclaimer_modal").click();
        //$('#completeModalSuccess').modal('show');
        
	//	$('#completeModalSuccess').modal({backdrop: 'static', keyboard: false});
		
		}    
	}, 15000);
</script>
<?php 
}
} ?>
  <script type="text/javascript">
var idleTime = 0;

	
    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });

	function openBetaPopup()
	{
	    //	$('#completeModalSuccess').modal({backdrop: 'static', keyboard: false});
		$('#centralModalSuccess').modal({backdrop: 'static', keyboard: false});	
	}

	function timerIncrement() {
	    console.log("Updated-----");
	     console.log(idleTime);
		idleTime = idleTime + 1;
 		<?php if($user_login){ ?>
// 			$('#centralModalSuccess').modal({backdrop: 'static', keyboard: false});
 			<?php } ?>
			
		if (idleTime > 15) { // 15 minutes
		
	$('#centralModalSuccess').modal({backdrop: 'static', keyboard: false});
			//window.location.reload();
		}
	}
</script> 
<script type="text/javascript">
	
window.addEventListener('beforeunload', function (e) { 
	document.cookie = 'mycookie=-1';
		 
		 //  alert(44);
		    // e.preventDefault(); 
            // e.returnValue = ''; 
        }); 

     

function checkFirstVisit() {

	var firstTimeOpen = document.cookie;

	var mm = firstTimeOpen.includes("reOpened");
	if (mm !== true) {
	
		$('[data-toggle="tooltip"]').tooltip();
			$('#centralModalSuccess').modal({backdrop: 'static', keyboard: false});
			document.cookie = "firstTimeOpen=reOpened";
	}



  if(document.cookie.indexOf('mycookie')==-1) {
    // cookie doesn't exist, create it now
    document.cookie = 'mycookie=1';

		$('#centralModalSuccess').modal({backdrop: 'static', keyboard: false});
  }
  else {
    // not first visit, so alert
   // alert('You refreshed!');
  }
}
function proceed() {
    
    window.location.href="https://www.linkibag.com/index.php?p=edit-profile";
    	$(".data_dismiss").click();
    
}
function agree_disclaimer() {
	
	document.cookie = "usernames=firstTimeUser";
	$('#linkibag-cookies').modal('show');
	document.cookie = "username=alredy_user";
	$(".data_dismiss").click();
	}


	function checkCookie() {
		
		var betaStatus = $("#betaPopup").val();
		
		var usernames = document.cookie;
		var username = document.cookie;
		var m = usernames.includes("firstTimeUser");
		
		
		
		if (m !== true) {
		if(betaStatus==1)
		{
		document.cookie = "firstTimeOpen=reOpened";
		//$('[data-toggle="tooltip"]').tooltip();

		$('#centralModalSuccess').modal({backdrop: 'static', keyboard: false});
		
		}else{
			var n = username.includes("alredy_user");
			if (n !== true) {

			$(window).load(function(){        
			$('#linkibag-cookies').modal('show');
			
			}); 
			document.cookie = "username=alredy_user";
		}
		}
		
		}else{
			var n = username.includes("alredy_user");
			if (n !== true) {

			$(window).load(function(){        
			$('#linkibag-cookies').modal('show');
			
			}); 
			document.cookie = "username=alredy_user";
		}
		}
		checkFirstVisit();
	}	
</script>
<style>

#linkibag-cookies {
    width: 100% !important;
    padding: 0px !important;
    margin: 0px !important;
    top: calc(100% - 100px) !important;
    z-index: 9999999999 !important;
}
#linkibag-cookies .model-block {
    font-size: 16px;
}
#linkibag-cookies .modal-dialog {
    width: 70%;
    margin-top: 100px;
}
#linkibag-cookies .modal-dialog {
	width: 100%;
	margin: 0;
	bottom: 0;
	position: absolute;
	opacity: 0.9;
}
#linkibag-cookies .modal-content, #updated_term_popup .modal-content {
    background: #ffff80;
    color: #000;
    opacity: .9;
        padding: 8px 22px;
    font-size: 17px;
}
#updated_term_popup .modal-content a, #linkibag-cookies .modal-content a {
	color:  blue;
	text-decoration: underline;
}
#linkibag-cookies .modal-content .close, #updated_term_popup .modal-content .close {
    color: #000;
    opacity: 1;
    margin-top: 10px;
    margin-right: 10px;
}
</style>
