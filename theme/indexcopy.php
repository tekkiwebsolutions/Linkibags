<?php
function page_access(){
	global $co, $msg;
	$user_login = $co->is_userlogin();
	if(!(isset($_GET['home_link']) and $_GET['home_link'] == 1)){
		if($user_login){
			echo '<script language="javascript">window.location="index.php?p=dashboard";</script>';
			exit();
		}
	}
	if(!isset($_COOKIE['updated_term_popup'])) {
		$co->showtermpopup = true;
		setcookie("updated_term_popup", 'loaded', (time()+(60*60*24*30)));
	}

	// if(!isset($_COOKIE['firstTimeOpen'])) {
	// 	setcookie("firstTimeOpen", 'reOpened', (time()+(1800)));
	// }	


// $_SESSION['somevariable'] = 'somevalue';

// if(parse_url($_SERVER["HTTP_REFERER"], PHP_URL_HOST) != $_SERVER["SERVER_NAME"]){
//     session_unset("somevariable");
// }

}
function page_content(){
	global $co, $msg;
	$co->page_title="Welcome to the linkbag";

	$editor_web_pick = $co->editor_web_pick();
	$you_tube_links = $co->fetch_all_array("select * from `user_urls` where `is_video_link`='1' and `video_week`='1' ORDER BY RAND() LIMIT 1",array());
	//$public_bag_links = $co->fetch_all_array("select * from user_urls where uid>'0' and public_bag_link='1' and pick_week_link='1' ORDER BY url_id DESC LIMIT 5",array());
	$current_date = date('Y-m-d');
	$free_security_links = $co->fetch_all_array("select * from info_security_links where uid='0' and status='1' and :current_date BETWEEN  info_security_start_date and info_security_end_date and info_security_type='0' ORDER BY info_security_link_id DESC LIMIT 10",array('current_date'=>$current_date));
	$paid_security_links = $co->fetch_all_array("select * from info_security_links where uid='0' and status='1' and :current_date BETWEEN  info_security_start_date and info_security_end_date and info_security_type='1' ORDER BY info_security_link_id DESC LIMIT 10",array('current_date'=>$current_date));

	$trending_cats = $co->query_first("select * from category where trending_cat='1' ORDER BY cid DESC",array());
	//$trending_bag_links = $co->fetch_all_array("select * from user_urls where uid>'0' and public_bag_link='1' ORDER BY RAND() LIMIT 5",array());

	$countries = $co->fetch_all_array("select id,country_name from countries ORDER BY id ASC", array());
	$states = $co->fetch_all_array("select id,state_name,code from states ORDER BY id ASC", array());

	$term_popup = $co->query_first("select * from popup_setting where popup_id='1'",array());

	$service_country = $co->query_first("SELECT * from linkibag_service_countries WHERE service_id=:id",array('id'=>1));

	$user_login = $co->is_userlogin();
?>
<?php if($term_popup['popup_show']==1) {

	if(isset($co->showtermpopup)) {
?>
<a data-toggle="modal" data-target="#updated_term_popup" id="updated_term_popup_btn" style="display:none" href="#">Show Term popup</a>

<div class="modal fade" id="updated_term_popup" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-body">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<?=$term_popup['popup_msg']?>
		</div>
	</div>
  </div>
</div>
<script type="text/javascript">
$(window).load(function(){
	var username = document.cookie
	var n = username.includes("alredy_user");
	if (n !== true) {
		$('#updated_term_popup_btn').trigger('click');
	}
}); 
</script>
<?php 
	}
}
?>
<script type="text/javascript">
<?php
if(isset($_GET['free_signup'])) {
	echo "
$(window).load(function(){	
	$('html, body').animate({
        scrollTop: $('#free_signup').offset().top
    }, 2000);
});
	";
}
?>
</script>
	<!-- end navigation -->
		<div class="carousel fade-carousel slide carousel_main" data-ride="carousel" data-interval="4000" id="bs-carousel">
  <!-- Overlay -->  <ol class="carousel-indicators linkibag-dot">
    <li data-target="#bs-carousel" data-slide-to="0" class="active"></li>
    <li data-target="#bs-carousel" data-slide-to="1"></li>
    <li data-target="#bs-carousel" data-slide-to="2"></li>
  </ol>
  <a class="left carousel-control" href="#bs-carousel" data-slide="prev"><img src="images/arrow-left.png"></a><a class="right carousel-control" href="#bs-carousel" data-slide="next"><img src="images/arrow-right.png"></a>
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
     <div class="item slides active">
      <div class="slide-3"></div>
      <div style="transform: none; left: 0px; right: 0px; top: 30px; text-shadow: none ! important;" class="hero container slider-one">
         <div class="col-md-6">
		<hgroup>
			<h1 style="overflow: hidden;"><a class="orange-btn" href="<?=WEB_ROOT?>free-personal-accounts"role="button" style="margin: 0px 0px 5px; float: right; text-transform: none; font-weight: 600;">Free Sign up ></a> </h1>
			<h2>Save your links with LinkiBag and share them with your classmates, friends and family.</h2>
			<h3 style="font-weight: 200; font-size: 18px; margin-top: 40px; display: none;">* FREE PERSONAL ACCOUNTS</h3>
        </hgroup>
		</div>
		 <div class="col-md-6">
		 </div>

      </div>
    </div>
	<div style="background: rgb(57, 117, 83) none repeat scroll 0% 0%;" class="item slides ">
      <div class="slide-1"></div>
      <div style="text-shadow: none; transform: none; right: 0px; top: 70px; left: 60px;" class="hero container slider-two">
         <div class="col-md-4 hidden-xs">
		 </div>
		<div class="col-md-8 col-xs-12">
		<hgroup>
			<h1>Store and share web sources with your class</h1>
			<h2>Teacher-to-student solutions:<br>
			Share your web links with your classroom.</h2><br/>
			<a style="font-weight: 600;" class="orange-btn" role="button" href="<?=WEB_ROOT?>free-personal-accounts">Free Sign up ></a>
			<h3 style="font-weight: 200; font-size: 18px; margin-top: 22px; display: none;">* FREE PROFESSIONAL ACCOUNT</h3>
        </hgroup>
		</div>
      </div>
    </div>
    <div style="background-color: rgb(232, 216, 139);" class="item slides">
      <div class="slide-2"></div>
      <div style="text-shadow: none; transform: none; left: 0px; right: 0px; top: 16px;" class="hero hero-slider container slider-three">
         <div class="col-md-5">
		 </div>
		<div class="col-md-7">
		<hgroup style="min-height: 350px;" class="last-slide">
<h1 class="access_title" style="text-shadow: none; color: rgb(78, 78, 78); font-size: 31px;">Access Where you need it</h1>
<h2 style="color: rgb(127, 127, 127); text-shadow: none;">Save links for future reference. Share links with associates, business partners and customers.</h2>
<a style="font-weight: 600; margin-top: 48px;" class="orange-btn access_btn" role="button" href="<?=WEB_ROOT?>free-personal-accounts">Free Sign up ></a>
<h3 style="font-weight: 200; color: #737373; font-size: 18px; margin-top: 22px; display: none;">* FREE PROFESSIONAL ACCOUNT</h3>
</hgroup>
		</div>
      </div>
    </div>

  </div>
</div>
		<!-- start divider -->
		<section style="border: medium none;" id="divider">
			<a href="#GoTop" class="gotoplink">
			<i class="fa fa-angle-up up fa-3x" aria-hidden="true"></i>
			</a>
			<div class="container text-center">
			<h1>Store, access and share links with your students,<br> friends and business associates</h1>
				<div class="row">
					<div class="col-md-4 col-sm-4  wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<div class="text-center box-bg-round"><img src="images/icon-1.png" class="img-responsive" alt="home img"></div>
						<h3 class="text-uppercase">FREE for personal use</h3>
						<p>Save and share links with your<br> friends, family, classmates.</p>
					</div>
					<div class="col-md-4 col-sm-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<div class="text-center box-bg-round"><img src="images/icon-2.png" class="img-responsive" alt="home img"></div>
						<h3 class="text-uppercase">Faculty</h3>
						<p>Save links for future use. Share selected <br> links with your students and colleagues. Great for dissertation  and other research projects. </p>
					</div>
					<div class="col-md-4 col-sm-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<div class="text-center box-bg-round"><img src="images/icon-3.png" class="img-responsive" alt="home img"></div>
						<h3 class="text-uppercase">Business</h3>
						<p>Save links for internal use and to<br> share with partners and associates. </p>
					</div>
				</div>
			</div>
		</section>
		<!-- end divider -->

		<!-- start divider -->
		<!--<section style="padding: 100px 0px 120px !important;background: #e9e9e2 none repeat scroll 0 0;" class="pack-your-links-section" id="start-signup">-->
		<!--	<a href="#GoTop" class="gotoplink">-->
		<!--	<i class="fa fa-angle-up up fa-3x" aria-hidden="true"></i>-->
		<!--	</a>-->
		<!--	 <div class="container text-center">-->
		<!--		<div class="row">-->
		<!--			<div class="link-list-trending">-->
		<!--				<h2 class="bold-title" style="color: rgb(49, 73, 106) ! important; padding-bottom: 18px ! important; word-spacing: 3px;">PACK YOUR LINKS<span class="tm">TM</span> TO GO</h2>-->
		<!--				<h3 style="color: rgb(127, 127, 127); padding-bottom: 37px; font-weight: 100;">Get your FREE account now and start saving links instantly.</h3>-->
		<!--				<a class="orange-btn" href="#free_signup">Sign up > </a>-->
		<!--			</div>-->
		<!--		</div>-->
		<!--	</div>-->
		<!--</section>-->
		<!-- end divider -->
		
		<!-- how its works start-->
		<section id='how_work_start'>
		    <h2>LinkiBag.com: How it works...</h2>
		    <iframe id= 'myiFrame' width="690" height="388" src="https://www.youtube.com/embed/XK1dS4hMUMA" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		<div class='video_two'>
		    <div class='video_left_panel'><p><strong>Video 2 -</strong><a href='https://www.youtube.com/watch?v=0GoHJuGUWBI' target=_blank>Learn more about LinkiBag</a></p></div>
		    <div class='video_right_panel'><p><a href='https://www.youtube.com/channel/UCp2hsP62INPQ3n4CVOYlvqQ' target=_blank>Click here</a>to subscribe to LinkiBag on YouTube.</p></div>
		</div>
		<div class='shot_div'>
		    <h2>It's Free. Give it a shot.</h2>
		    <a href=''>Free Sign Up</a>
		    <p>Trying to keep too many things under control? Drop your links into your LinkiBag and keep them with you wherever you go.</p>
		</div>
		</section>
		<!-- how its works end -->
		

		<!-- Web Resources Library -->
		<section id='customer_testimonial'>
		    <h2>LinkiBag Customer Testimonials</h2>
		    <ul>
		        <li>
		            <img src='https://www.linkibag.com/files/page_imgs/original/testi_1.png'>
		        <div class='testi_detail'>
		            <p>I Study English in the USA and  I am using LikinBag to save my Weblinks.</p>
		            <strong>Ceci</strong>
		        </div>
		        </li>
		        <li>
		            <img src='https://www.linkibag.com/files/page_imgs/original/testi_4.png'>
		        <div class='testi_detail'>
		            <p>I trust LinkiBag to keep my links.</p>
		            <strong>Tommy</strong>
		        </div>
		        </li>
		        <li>
		            <img src='https://www.linkibag.com/files/page_imgs/original/testi_2.png'>
		        <div class='testi_detail'>
		            <p>As a Teacher an educator working from home during pandemic I enjoy using LinkiBag.</p>
		            <strong>George E.</strong>
		        </div>
		        </li>
		        <li>
		            <img src='https://www.linkibag.com/files/page_imgs/original/testi_3.png'>
		        <div class='testi_detail'>
		            <p>I use LinkiBag to share my links with my students and fellow professors it's a great tool which I use as a teacher and for my personal needs.</p>
		            <strong>Matt S.</strong>
		        </div>
		        </li>
		    </ul>
		    
		</section>
		<!-- end Web Resources Library -->
		
		<!-- Testimonial section start-->
		<section id='testimonial_home'>
		    <div class='media_bottom_icons'>
		        <h2 style="text-align: center;">As Seen On</h2>
			    <ul>
			        <li><a target=_blank href='https://www.marketwatch.com/press-release/linkibag-is-the-best-place-to-keep-your-links-save-it-and-share-it-on-the-fly-2020-10-15'><img src='https://www.linkibag.com/files/page_imgs/original/market.png'></a></li>
			        <li><a target=_blank href='https://finance.yahoo.com/news/linkibag-best-place-keep-links-162300371.html?guccounter=1'><img src='https://www.linkibag.com/files/page_imgs/original/yahoo.png'></a></li>
			        <li><a target=_blank href='http://www.digitaljournal.com/pr/4837656'><img src='https://www.linkibag.com/files/page_imgs/original/digital_jou.png'></a></li>
			         <li><a target=_blank href='https://www.globenewswire.com/news-release/2020/10/15/2109438/0/en/LinkiBag-Is-The-Best-Place-To-Keep-Your-Links-Save-It-And-Share-It-On-The-Fly.html'><img src='https://www.linkibag.com/files/page_imgs/original/intrado.png'></a></li>
                    <li><a target=_blank href='https://digitalunicornmag.com/du-digital-tools-review/'><img src='https://www.linkibag.com/files/page_imgs/original/digital.png'></a></li>
                      <li><a target=_blank href='javascript:void(0)'></a></li>
                      <li><a target=_blank href='javascript:void(0)'><img src='https://www.linkibag.com/files/page_imgs/original/american.png'></a></li>
                    <li><a target=_blank href='javascript:void(0)'><img src='https://www.linkibag.com/files/page_imgs/original/one_world.png'></a></li>
                    <li><a target=_blank href='javascript:void(0)'><img src='https://www.linkibag.com/files/page_imgs/original/seeker.png'></a></li>
                 </ul>
			    
			</div>
		</section>
		<!--Testimonial section end-->

		<!-- start divider -->
		
		<?php /*
		<section class="public-bag-index share_block" id="public-bag">
			<a href="#GoTop" class="gotoplink">
			<i class="fa fa-angle-up up fa-3x" aria-hidden="true"></i>
			</a>
			<div class="container text-center top-margin">
				<div class="row">
					<div class="col-md-12 text-left wow fadeInUp templatemo-box web-links-title-bag" data-wow-delay="0.3s">
						<!--<div class="section-title-blue"><h2>Now Trending:
						<?php
					/*echo '<div class="link-list-trending"><img src="images/trending-hand.jpg" class="img-responsive" alt="home img"><h1><a href="javascript: void(0)">Share with the World</a></h1>
							<h4>Select the option ‘add to public bag’ to send your link to be included here.</h4></div>';					*/

					//if(isset($trending_cats['cid']) and $trending_cats['cid'] > 0){

						//echo '<a href="#" target="_blank">'.$trending_cats['cname'].'</a>';

					//}
						?>
						<?php /*
						</h2></div>-->
						<div class="row">
							<div class="col-md-12 row">
								<img style="margin: 8px 12px 0px 0px; height: 44px ! important;" src="images/trending-hand.png" class="img-responsive link_png" alt="home img">
								<h1 style="font-size: 20px; color: #004040;">Inspiration for information security </h1>
								<h4>Learn more about information security</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		*/ ?>

		<!-- end divider -->

		<?php /* 
		<section id="web-share" class="share_block">
			<div class="container">
				<div class="row">
					<div class="video-section">

						<div class="col-md-6" data-wow-delay="0.3s">
							<div class="carousel slide media-carousel" id="media" data-interval="false">
							<div class="section-title-blue">
							<h2 class="link-section color_chnge">Free Products
								<a class="fa fa-chevron-right" data-slide="next" href="#media" style="text-decoration: none;"></a>
								<a class="fa fa-chevron-left" data-slide="prev" href="#media" style="text-decoration: none; margin: 0px 6px;"></a>
							</h2>
							</div>
							<div class="">
								<div class="share-link-icon col-md-1" style="padding-right: 0px;">
									<a href="#"><img class="img-responsive" alt="share" src="images/share-icon.png"></a>
								</div>
								<div class="share-link-icon col-md-11">
								<div class="carousel-inner">
									<?php
									$i=0;
									if(isset($free_security_links) and count($free_security_links) > 0){
										foreach($free_security_links as $list){
											$i++;
											$class = '';
											if($i == 1)
												$class='active';

											echo '<div class="item '.$class.'">';

										$http = 'http';

										$https = 'https';


										if((strpos($list['info_security_url_value'],$http) === false) or (strpos($list['info_security_url_value'],$https) === false)) {

											$link = 'http://'.$list['info_security_url_value'];

										}else{
											$link = $list['info_security_url_value'];

										}

										echo '<a href="'.$link.'" target="_blank"><img class="img-responsive" alt="share" src="'.$list['info_security_photo'].'"></a>';


												echo '</div>';
										}
									}else{
										echo '<a href="#"><img class="img-responsive" alt="share" src="images/slide.png"></a>';
									}
									?>

								</div>
								<span class="slider-text"><a href="index.php?p=contact-us&type_of_inquiry=free_products">Recommend</a> another Free Information Security product or service to be listed here.</span>
								</div>
								</div>
							</div>

						</div>

						<div class="col-md-6" data-wow-delay="0.3s">
							<div class="carousel slide media-carousel" id="media-two" data-interval="false">
							<div class="section-title-blue">
							<h2 class="link-section color_chnge">Products with free trial versions
								<a class="fa fa-chevron-right" data-slide="next" href="#media-two" style="text-decoration: none;"></a>
								<a class="fa fa-chevron-left" data-slide="prev" href="#media-two" style="text-decoration: none; margin: 0px 6px;"></a>
							</h2>
							</div>
							<div class="">
								<div class="share-link-icon col-md-1" style="padding-right: 0px;">
									<a href="#"><img class="img-responsive" alt="share" src="images/share-icon.png"></a>
								</div>
								<div class="share-link-icon col-md-11">
								<div class="carousel-inner">
									<?php
									$i=0;
									if(isset($paid_security_links) and count($paid_security_links) > 0){
										foreach($paid_security_links as $list){
											$i++;

											$class = '';
											if($i == 1)
												$class='active';

										$http = 'http';

										$https = 'https';


										if((strpos($list['info_security_url_value'],$http) === false) or (strpos($list['info_security_url_value'],$https) === false)) {

											$link = 'http://'.$list['info_security_url_value'];

										}else{

											$link = $list['info_security_url_value'];

										}


											echo '<div class="item '.$class.'">';

											echo '<a href="'.$link.'" target="_blank"><img class="img-responsive" alt="share" src="'.$list['info_security_photo'].'"></a>';


											echo '</div>';
										}
									}else{
										echo '<a href="#"><img class="img-responsive" alt="share" src="images/slide.png"></a>';
									}
									?>
								</div>
								<span class="slider-text"><a href="index.php?p=contact-us&type_of_inquiry=free_trial_products">Adversite</a> your information Security product or service here. </span>
								</div>
								</div>
							</div>

						</div>
						</div>
					</div>
				</div>
		</section> */ ?>

		<?php if(!$user_login){ ?>
		
		
	
		
		
	<section id="free_signup" class="light-bg">
		<div id="free_singup_main" class="container">
			<div class="col-md-offset-3 col-md-6">
			<p></p>
				<div class="light-panel">
					<div class="light-panel-header text-center">
						<h1>LET’S GET STARTED<br><span class="text-orange">Sign up for a Free Account</span></h1>
					</div>
					<div class="light-panel-body">
						  <form method="post" id="register_form" action="index.php?ajax=ajax_submit" onsubmit="javascript: return submit_register();">
				<input type="hidden" name="form_id" value="register"/>
				<input type="hidden" name="role" value="personal"/>				
				<?php
				if(isset($_GET['request_id']) and $_GET['request_id'] > 0 and isset($_GET['request_code']) and $_GET['request_code'] != '' and isset($_GET['accept']) and $_GET['accept'] != ''){
					$chk_request_data = $co->query_first("select fr.* from friends_request fr where fr.request_id=:id and fr.request_code=:code", array('id'=>$_GET['request_id'], 'code'=>$_GET['request_code']));
						
					echo '<input type="hidden" name="request_id" value="'.$_GET['request_id'].'"/>
						<input type="hidden" name="request_code" value="'.$_GET['request_code'].'"/>
						<input type="hidden" name="accept" value="'.$_GET['accept'].'"/>

						';
				}

				if(isset($_POST['email_id']) and $_POST['email_id']!=''){
					$post_email_id = $_POST['email_id'];	
					$post_email_readonly = '';
				}else if(isset($_GET['email']) and $_GET['email']!=''){
					$post_email_id = $_GET['email'];		
					$post_email_readonly = '';
				}else if(isset($chk_request_data['request_email']) and $chk_request_data['request_email']!=''){
					$post_email_id = $chk_request_data['request_email'];		
					$post_email_readonly = ' readonly="true"';
				}else{
					$post_email_id = '';		
					$post_email_readonly = '';
				}	

				if(isset($row['country']))
					$post_country = $row['country'];
				else if(isset($_GET['country']))
					$post_country = $_GET['country'];
				else
					$post_country = '';
			
				?>

               <div class="text-left wow fadeInUp templatemo-box">
                  <div class="homepage-login-form">
                     <div>
						<?=isset($msg) ? $msg : '' ?>
						<div id="messagesout"></div>
						<div id="uname_response" ></div>
						<div class="row">
							<div class="col-md-8 col-md-offset-4">
								<a id="singup_forget_link" class="pull-right" href="javascript: void(0)" style="display: none; color: #960404" onclick="forget_password_submit('signup_email_id', 'singup_forget_link')">Forgot my password</a>
								<span id="forget_password_msg"></span>
							</div>
						</div>
						<div class="row" style="margin-bottom: 10px;">
							<label class="mylabel col-md-4">Email: <span class="required-field"> *</span></label>
							<div class="col-md-8">
							<input placeholder="you@mail.com" type="email" name="email_id" aria-describedby="basic-addon1" id="signup_email_id" class="form-control" value="<?=$post_email_id?>" <?=$post_email_readonly?> onblur="check_signupemail_message()" />
							</div>
						</div>
						<div class="row">
							<div class="show_pass col-md-11 text-right">
								<input id="checkboxshow" type="checkbox" name="show_password" value="1">
								<label for="checkboxshow" class="question" id="show_password"> Show password</label>
							</div>
						</div>
						<div class="form-group row">
							<label class="mylabel col-md-4">Password: <span class="required-field">*</span></label>
							<div class="col-md-7">
								<input placeholder="Create Password" type="password" name="password" id="password" class="form-control" >
								<ul  id="d1" class="list-group">
									<li class="list-group-item" id="d12"><i class='fa fa-check' style="color: #999999"></i> Include one  uppercase letter</li>
									<li class="list-group-item" id="d13"><i class='fa fa-check' style="color: #999999"></i> Include a lowercase letter</li>
									<li class="list-group-item" id="d15"><i class='fa fa-check' style="color: #999999"></i> Include a number</li>
									<li class="list-group-item" id="d16"><i class='fa fa-check' style="color: #999999"></i> Include at least 8 characters</li>
								</ul>
							</div>
							<div class="col-md-1 tooltip-none">
								<span style="color: #fff !important; position: absolute; right: 0; top: 6px;">
								<a tabindex="-1"  data-toggle="tooltip" title="Minimum of 8 characters with one number, one lowercase letter and one uppercase letter." href="javascript: void();" style="#444 ! important;">?</a></span>
							</div>
						</div>
						<div class="form-group row">
							<label class="mylabel col-md-4">Confirm Password: <span class="required-field">*</span></label>
							<div class="col-md-7">
								<input placeholder="Confirm Password" type="password" name="reapt_pass" class="form-control" >
							</div>
						</div>
						<div class="form-group row">
							<label class="mylabel col-md-4">Country: <span class="required-field">*</span></label>
							<div class="col-md-8">
							<select class="form-control linkibox_select" name="country" onchange="country_change(this.value);">
								<option value="">Select Country</option>
								<?php
								$countries = $co->fetch_all_array("select id,country_name from countries ORDER BY id ASC", array());
								foreach($countries as $country){
									$sel = '';
									if($country['id'] == $post_country)
										$sel = ' selected="selected"';	

									echo '<option value="'.$country['id'].'"'.$sel.'>'.$country['country_name'].'</option>';
								}	
								?>
							</select>
							</div>
						</div>
						<div class="form-group row" id="state_zipcode_block"<?=($post_country==1 ? '' : ' style="display: none"')?>>
							<label class="mylabel col-md-4">State: <span class="required-field">*</span></label>
							<div class="col-md-3">
								<select name="state" class="form-control linkibox_select">
									<option value="">Select</option>
									<?php
									foreach($states as $state){
										$sel = '';
										if(isset($_POST['state']) and $_POST['state'] == $state['id'])
											$sel = ' selected="selected"';
										echo '<option value="'.$state['id'].'"'.$sel.'>'.$state['code'].'</option>';
									}
									?>
								</select>
							</div>
							<label class="mylabel col-md-2" style="padding-right: 0;">Zip Code: <span class="required-field">*</span></label>
							<div class="col-md-3">
								<input type="text" name="zip_code" class="form-control onlynumbers" maxlength="5">
							</div>
						</div>
						<!--<div class="form-group row">
							<label class="mylabel col-md-4">Date Of Birth: <span class="required-field">*</span></label>
							<div class="col-md-8">
								<input type="text" class="form-control" placeholder="Select DOB" name="dob" id="user_birthday" readonly />
							</div>
						</div>-->
										<div class="form-group row">
											<div class="col-md-8 col-md-offset-4">
												<div class="g-recaptcha" data-sitekey="6LcvQfIUAAAAADmpuC1uXGhW_OPaRyxM_TqKHOVN"></div>
												<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
											</div>
										<!--<div id="captcha">
											<div class="controls">											                  
											  <input type="text" name="captcha_val" class="user-text btn-common" id="captcha_val" placeholder="Type here" />
												<button class="validate btn-common" type="button" id="validate_captcha_btn">
													<img src="images/enter_icon.png" alt="submit icon">
												</button>
												<button class="refresh btn-common" type="button" id="refresh_captch_btn">
													<img src="images/refresh_icon.png" alt="refresh icon">
												</button>
											</div>
										</div>
										<label class="error" for="captcha_val"></label>-->	
										</div>	
									<div style="padding: 0 0 0 19px;" class="form-group row">
										<div class="col-md-8 col-md-offset-4">
										<span style="margin: 0px; padding: 0px;" class="errordiv" style="overflow: hidden;">
											<div  style="margin-top: 0px;" class=" linki-chckboxbox ">
												
												<label for="checkbox1" class="question" style="color: #414141 !important; font-weight:300!important">
												<input id="checkbox1" type="checkbox" name="terms_and_conditions" value="1">	<!--<span class="required-field">*</span>-->
												&nbsp;&nbsp;	I have read, understand and agree to the   <a href="<?=WEB_ROOT?>page/policy" style="font-weight: 600" target="_blank">Privacy Policy </a> and <a href="<?=WEB_ROOT?>page/terms" style="font-weight: 600" target="_blank"> Terms of Use.</a>
											</div>
											<label class="error" for="terms_and_conditions"></label>
										</span>

										
										<div style="margin-top: 0px; " class=" linki-chckboxbox ">
											<input id="checkbox3" type="checkbox" name="sign_me_for_email_filter" value="1">
											<label for="checkbox3" style="color: #414141 !important;font-weight:300!important">
											&nbsp;&nbsp;	Sign me up for LinkiBag Newsletter.
											</label>
										</div>
										<label for="sign_me_for_email_filter" class="error"></label>
										</div>
									</div>		
						<div class="form-group col-sm-5 col-sm-offset-4">
							<button type="submit" class="orange-btn btn-block" id="send_register">Create Account</button>
						</div>										
						
					</div>
				  </div>
               </div>
            </form>	
					</div>
				</div>
			</div>
		</div>
	</section>
	<style type="text/css">
		.checkbox label::before {
		    width: 12px;
		    height: 11px;
		}
		label.error[for="password"] {
		    display: none !important;
		}
		#updated_term_popup .modal-body a {
			text-decoration: underline;
		}
		.show_pass {
			text-align: right;
		}
		.show_pass label {
			font-size: 14px;
			font-weight: normal;
		}
	</style>
	
	<script type="text/javascript">

		function country_change(countryval){
			//alert(countryval);
			if(countryval == 1) {
				$('#state_zipcode_block').show();
			} else {
				$('#state_zipcode_block').hide();
			}

			if (countryval != "") {
			<?php
			$service_countries = unserialize($service_country['allowed_counties']);
			$country_cond = '';
			foreach($service_countries as $servicecountry) {
				if($country_cond != '')
					$country_cond .= ' && ';
				$country_cond .= 'countryval != '.$servicecountry;
			}
			?>
				if(<?=$country_cond?>) {
					var email = $('#signup_email_id').val();
					window.location.href='index.php?p=outside-linkibag-service-area&email='+email+'&country='+countryval;
				}
			}

		}
	</script>
	<?php
	}
	}
	?>		<!-- end divider -->
