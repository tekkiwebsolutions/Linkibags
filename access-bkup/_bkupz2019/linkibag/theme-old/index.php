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
}
function page_content(){
	global $co;
	$co->page_title="Welcome to the linkbag";
	
	$editor_web_pick = $co->editor_web_pick();
	$you_tube_links = $co->fetch_all_array("select * from user_urls where uid>'0' and you_tube_link='1' ORDER BY RAND() LIMIT 1",array());
	$public_bag_links = $co->fetch_all_array("select * from user_urls where uid>'0' and public_bag_link='1' ORDER BY url_id DESC LIMIT 5",array());
	$trending_cats = $co->query_first("select * from category where uid='0' and trending_cat='1' ORDER BY cid DESC",array());
	//$trending_bag_links = $co->fetch_all_array("select * from user_urls where uid>'0' and public_bag_link='1' ORDER BY RAND() LIMIT 5",array());
	
	
?>	<!-- end navigation -->
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
      <div style="transform: none; left: 0px; right: 0px; top: 30px; text-shadow: none ! important;" class="hero container">
         <div class="col-md-6">
		<hgroup>
			<h1>ALWAYS FREE * <a class="btn btn-hero btn-lg" href="index.php?p=free-personal-accounts"role="button" style="margin: 0px 0px 5px; float: right; text-transform: none; font-weight: 600;">Free Signup ></a> </h1>
			<h2>Save your links with LinkiBag and share them with your classmates, friends and family.</h2>
			<h3 style="font-weight: 200; font-size: 18px; margin-top: 40px;">* FREE INDIVIDUAL ACCOUNTS</h3>
        </hgroup>
		</div>
		 <div class="col-md-6">
		 </div>
		
      </div>
    </div>
	<div style="background: rgb(57, 117, 83) none repeat scroll 0% 0%;" class="item slides ">
      <div class="slide-1"></div>
      <div style="text-shadow: none; transform: none; right: 0px; top: 70px; left: 60px;" class="hero container">
         <div class="col-md-4">
		 </div>
		<div class="col-md-8">
		<hgroup>
			<h1>Store and share web sources with your class</h1>
			<h2>Teacher-to-student solutions:<br>
			Share your web links with your classroom.</h2>
			<a style="font-weight: 600;" class="btn btn-hero btn-lg" role="button" href="index.php?p=institutional-accounts">Read More ></a>
        </hgroup>
		</div>
      </div>
    </div>
    <div style="background-color: rgb(232, 216, 139);" class="item slides">
      <div class="slide-2"></div>
      <div style="text-shadow: none; transform: none; left: 0px; right: 0px; top: 16px ! important;" class="hero hero-slider container">
         <div class="col-md-5">
		 </div>
		<div class="col-md-7">
		<hgroup style="min-height: 350px;" class="last-slide">
<h1 style="text-shadow: none; color: rgb(78, 78, 78); font-size: 31px;">Access Where you need it</h1>
<h2 style="color: rgb(127, 127, 127); text-shadow: none;">Save links for future reference. Share links with associates, business partners and customers.</h2>
<a style="font-weight: 600; margin-top: 48px;" class="btn btn-hero btn-lg" role="button" href="index.php?p=business-accounts">Read More</a>
</hgroup>
		</div>
      </div>
    </div>
   
  </div> 
</div>
		
		
		<!-- start divider -->
		<section id="divider">
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
		<section class="public-bag-index" id="public-bag">
			<div class="container text-center top-margin">
				<div class="row">
					<div class="col-md-12 text-left wow fadeInUp templatemo-box web-links-title-bag" data-wow-delay="0.3s">
						<div class="section-title-blue"><h2>Now Trending: 
						
						
						<?php
					/*echo '<div class="link-list-trending"><img src="images/trending-hand.jpg" class="img-responsive" alt="home img"><h1><a href="javascript: void(0)">Share with the World</a></h1>
							<h4>Select the option ‘add to public bag’ to send your link to be included here.</h4></div>';					*/
							
					if(isset($trending_cats['cid']) and $trending_cats['cid'] > 0){
							
						echo '<a href="#" target="_blank">'.$trending_cats['cname'].'</a>';						
							
					}
					
						?>
						
						
						</h2></div>
						
						<div class="row">
							<div class="link-list-trending"><img style="margin: 8px 12px 0px 0px; height: 44px ! important;" src="images/trending-hand.png" class="img-responsive link_png" alt="home img">
								<h1 style="font-size: 18px; color: rgb(255, 127, 39);">Share With the World</h1>
								<h4>Select the option ‘add to public bag’ to send your link to be included here.</h4>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</section>
		<!-- end divider -->
		
		
		
		
		<!-- start divider -->
		<section id="web-share">
			<div class="container">
				<div class="row">
					<div class="video-section">
						
						<div class="col-md-5" data-wow-delay="0.3s">
							<div class="section-title-blue"><h2 class="link-section">Video Pick of the Week <a class="fa fa-chevron-right"></a></h2></div>
							<?php
							if(isset($you_tube_links) and count($you_tube_links) > 0){
								foreach($you_tube_links as $list){
								
							?>
							<div class="row">
								<div class="share-link-icon col-md-1" style="padding-right: 0px;">							
								<a href="#"><img class="img-responsive" alt="share" src="images/share-icon.jpg"></a>							</div>
								<div class="share-link-icon col-md-11">
								<iframe width="100%" height="315" src="<?=$list['url_value']?>" frameborder="0" allowfullscreen></iframe>
								</div>
							</div>
							<?php
								}
							}else{	
						?>
						<div class="row">
								<div class="share-link-icon col-md-1" style="padding-right: 0px;">							<a href="#"><img class="img-responsive" alt="share" src="images/share-icon.jpg"></a>							</div>
								<div class="share-link-icon col-md-11">
								<iframe width="100%" height="315" src="https://www.youtube.com/embed/IsZxiIAYc9E" frameborder="0" allowfullscreen></iframe>
								</div>
						</div>
						<?php } ?>	
						</div>
						
						<div class="col-md-6 pull-right" data-wow-delay="0.3s">
							<div class="carousel slide media-carousel" id="media" data-interval="false">
							<div class="section-title-blue">
							<h2 class="link-section">Link Pick of the Week 
								<a class="fa fa-chevron-right" data-slide="next" href="#media" style="text-decoration: none;"></a>
								<a class="fa fa-chevron-left" data-slide="prev" href="#media" style="text-decoration: none; margin: 0px 6px;"></a>
							</h2></div>
							<div class="row">
								<div class="share-link-icon col-md-1" style="padding-right: 0px;">
									<a href="#"><img class="img-responsive" alt="share" src="images/share-icon.jpg"></a>
								</div>
								<div class="share-link-icon col-md-11">
								
								
								<div class="carousel-inner">
									<?php
									$i=0;
									$j=0;
									if(isset($public_bag_links) and count($public_bag_links) > 0){
										foreach($public_bag_links as $list){
											$i++;
											$j++;
											$class = '';
											if($i == 1)
												$class='active';
											if($j == 1){
												$j=-1;
												echo '<div class="item '.$class.'">';
											}
											echo '<h4><a href="'.$list['url_value'].'" target="_blank">'.$list['url_value'].'</a></h4>
											<p>'.$list['url_desc'].'</p>';
											
											if($j == 0)
												echo '</div>';						
										}	
									}else{
										echo '<h4><a href="#">http://www.recode.net</a></h4>
										<p>Get the latest independent tech news, reviews and analysis from 
										Re/code with the most informed and respected journalists in technology and media.</p>';						
									}
									?>
								</div>
								</div>	
								
								</div>
							</div>
							
						</div>
						
					</div>
				</div>
			</div>
		</section>
	<?php
		}

	?>		<!-- end divider -->
		

	