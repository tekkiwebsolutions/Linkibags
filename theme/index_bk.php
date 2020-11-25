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
	$states = $co->fetch_all_array("select id,state_name from states ORDER BY id ASC", array());
	
	$user_login = $co->is_userlogin();
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
		<section id="start-signup">
             <div class="container text-center">
				<div class="row">
					<div class="link-list-trending">
						<h2 class="bold-title" style="color: rgb(49, 73, 106) ! important; padding-bottom: 18px ! important; word-spacing: 3px;">PACK YOUR LINKS<span class="tm">TM</span> TO GO</h2>
						<h3 style="color: rgb(127, 127, 127); padding-bottom: 37px; font-weight: 100;">Get your FREE account now and start saving links instantly.</h3>
						<a class="btn bg-orange" href="#free_singup">Sign up</a>
					</div>
				</div>
			</div>
		</section>
		<!-- end divider -->
		
		<!-- start divider -->
		<section class="public-bag-index share_block" id="public-bag">
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
						</h2></div>-->
						<div class="row">
							<div><img style="margin: 8px 12px 0px 0px; height: 44px ! important;" src="images/trending-hand.png" class="img-responsive link_png" alt="home img">
							<h1 style="font-size: 20px; color: #004040;">Inspiration for information security </h1>
								<h4>Learn more about information security</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- end divider -->
		
		<!-- start divider -->
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
		</section>
		
		<?php if(!$user_login){ ?>
		
		<section id="free_singup">
			<div class="container text-center">
				<div class="row">
            <form method="post" id="register_form" action="index.php?ajax=ajax_submit" onsubmit="javascript: return submit_register();">  
				<input type="hidden" name="form_id" value="register"/>          
				<input type="hidden" name="role" value="personal"/>  
				<?php
				if(isset($_GET['request_id']) and $_GET['request_id'] > 0 and isset($_GET['request_code']) and $_GET['request_code'] != '' and isset($_GET['accept']) and $_GET['accept'] != ''){
					echo '<input type="hidden" name="request_id" value="'.$_GET['request_id'].'"/>
						<input type="hidden" name="request_code" value="'.$_GET['request_code'].'"/>
						<input type="hidden" name="accept" value="'.$_GET['accept'].'"/>
						
						';	
				}	
				?>
				
               <div class="col-md-12 text-left wow fadeInUp templatemo-box">
                  <div class="row">
                     <div class="personal_account_register">
						<?=isset($msg) ? $msg : '' ?>
						<div id="messagesout"></div> 
						<div class="form-title">
							<h2>Sign up for your FREE account</h2>
						</div>
						<div class="row">
							<div class="form-group">
								<div class="col-md-6">
									<div class="col-md-4 pad-sm"><label class="mylabel">Login<span class="required-field">*</span></label></div>
									<div class="col-md-8">
										<input placeholder="your-email@mail.com" type="text" name="email_id" aria-describedby="basic-addon1" placeholder="" class="form-control" value="<?=((isset($_POST['email_id']) and $_POST['email_id']!='') ? $_POST['email_id'] : '')?>" />				
									</div>
									<?php /*<div class="col-md-3">
										<label class="mylabel"></label>					
										<select name="email_domain" class="form-control linkibox_select">
										   <option value=0>Select</option>
										   <option value="gmail.com">gmail.com</option>
										   <option value="yahoo.com">yahoo.com</option>
										   <option value="hotmail.com">hotmail.com</option>
										</select>
										<!--<input type="text" name="email_domain" class="form-control" value="<?=((isset($_POST['email_domain']) and $_POST['email_domain']!='') ? $_POST['email_domain'] : '')?>" />-->					
										<span class="bootom-info"><a href="index.php?p=contact-us"><small>Suggest more</small></a></span>				
									</div> */ ?>
								</div>	
							</div>
						</div>	
						<div class="row">
							<div class="form-group">
								<div class="col-md-6">
									<div class="col-md-4 pad-sm"><label class="mylabel">Password:<span class="required-field">*</span></label></div>
									<div class="col-md-8"> 
										<div class="">
										<input placeholder="create" type="password" name="password" id="password" class="form-control" ><span style="color: #fff !important; position: absolute; right: 0; top: 6px;"><a data-toggle="tooltip" title="Minimum of 8 characters with one number, one lowercase letter and one uppercase letter." href="javascript: void();" style="color: rgb(255, 255, 255) ! important;">?</a></span> 
										</div>

												
									</div>
								</div>
								<div class="col-md-6">	
									<div class="col-md-4 pad-sm"><label class="mylabel">Confirm Password:<span class="required-field">*</span></label></div>
									<div class="col-md-8">                
										<input placeholder="confirm" type="password" name="reapt_pass" class="form-control" id="pwd">
									</div>
								</div>	 
							</div>
						</div>	
						<div class="row">
							<div class="form-group">
								<div class="col-md-6">
									<div class="col-md-4 pad-sm"><label class="mylabel">First Name<span class="required-field">*</span></label></div>
								   <div style="display: none; padding-right: 6px;" class="col-md-2">
								   <select class="form-control linkibox_select" name="salutation" >
									  <option value="mr">Mr.</option>
									  <option value="ms">Ms.</option>
									  <option value="mrs">Mrs.</option>
									  <option value="dr">Dr.</option>
								   </select>
								   </div>
									<div class="col-md-8"><input placeholder="First Name" type="text" name="first_name" class="form-control" value="<?=((isset($_POST['first_name']) and $_POST['first_name']!='') ? $_POST['first_name'] : '')?>" /></div>   
								</div>
								<div class="col-md-6">
									<div class="col-md-4 pad-sm"><label class="mylabel">Last Name<span class="required-field">*</span></label></div>
									<div class="col-md-8"><input placeholder="Last Name" type="text" name="last_name" class="form-control" value="<?=((isset($_POST['last_name']) and $_POST['last_name']!='') ? $_POST['last_name'] : '')?>" /></div>
								</div>	
							</div>
						</div>
						<div class="row">	
							<div class="form-group">
								<div class="col-md-6">
									<div class="col-md-4 pad-sm"><label class="mylabel">Country<span class="required-field">*</span></label></div>
									<div class="col-md-8">
										 <select class="form-control linkibox_select" name="country" onchange="show_states(this.value)">
											<option value="">Select Country</option>
											<?php
											foreach($countries as $country){
												$sel = '';
												if(isset($_POST['country']) and $_POST['country'] == $country['id'])
													$sel = ' selected="selected"';	
												echo '<option value="'.$country['id'].'"'.$sel.'>'.$country['country_name'].'</option>';
											}	
											?>
										</select>
									</div>
								</div>	
								<div class="col-md-6">
									<div class="col-md-4 pad-sm"><label class="mylabel">Company Or Institution Name:</label></div>
									<div class="col-md-8"><input type="text" name="account" class="form-control" value="" /></div>
								</div>	
							</div>
						</div>	
						<div class="row">
							<div id="state_block"<?=((isset($_POST['country']) and $_POST['country']==1) ? '' : ' style="display: none;"')?>>
								<div class="form-group">
									<div class="col-md-6">
										<div class="col-md-4 pad-sm"><label class="mylabel">State<span class="required-field">*</span></label></div>
										 <div class="col-md-8">
											<select name="state" class="form-control linkibox_select">
												<option value="">Select</option>
												<?php
												foreach($states as $state){
													$sel = '';
													if(isset($_POST['state']) and $_POST['state'] == $state['id'])
														$sel = ' selected="selected"';	
													echo '<option value="'.$state['id'].'"'.$sel.'>'.$state['state_name'].'</option>';
												}	
												?>
											 </select>              
										 </div>
									</div>
									<div class="col-md-6">	
										<div class="col-md-4 pad-sm">                
											<label class="mylabel">Zip Code<span class="required-field">*</span></label>	
										</div>	
										<div class="col-md-8"><input type="text" name="zip_code" class="form-control onlynumbers" maxlength="50"></div>
									</div>	
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
									<div class="col-md-4">
										<span class="required-field pull-right">*</span>
										<input type="hidden" title="Please verify this" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
										<div class="g-recaptcha" data-sitekey="6LfW_ScTAAAAAO2MRn6I180IrAb0HJa9cpaN3mI2"></div>
									</div>
								
									<div class="col-md-8">
										<span style="margin: 0px; padding: 0px;" class="errordiv" style="overflow: hidden;">
											<div class="checkbox linki-chckboxbox ">
												<input id="checkbox1" type="checkbox" name="terms_and_conditions" value="1">              
												<label for="checkbox1" class="question">
													<span class="required-field">*</span>                
													I have read and understand this agreement and I accept and agree to all of its terms and conditions.
											</div>
											<label class="error" for="terms_and_conditions"></label>
										</span>
										<div style="margin-top: 0px;" class="checkbox linki-chckboxbox ">            
											<input id="checkbox3" type="checkbox" name="sign_me_for_email_filter" value="1">            
											<label for="checkbox3">
												Sign me up for email fliers with LinkiBag promotions and discounts.           
											</label>            
										</div>
										<label for="sign_me_for_email_filter" class="error"></label>
										<button type="submit" class="orange-btn" id="send_register">Finished</button>	
										
									</div>								
									
							</div>
						</div>							
					</div>
						
                  </div>
               </div>
            </form>
				
				
				
				</div>
			</div>	
		</section>		
		
	<?php
			 }
		}
	?>		<!-- end divider -->
		

	