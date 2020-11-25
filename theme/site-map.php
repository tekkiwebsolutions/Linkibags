<?php

	function page_content(){

	global $co, $msg;

	$co->page_title = "Site Map | LinkiBag";
	$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>10));
	$current = $co->getcurrentuser_profile();

?>	

<section id="public-bag">
				<div class="container bread-crumb top-line about-top" style="margin: auto;">

					<div class="col-md-6">

						<p><a href="index.php">Home</a> > <?=$page['title']?></p>

					</div>

					<div class="col-md-4">
					
						</br><!--<a class="com-link" href="index.php?p=prices">Compare Plans</a>-->

						<span class="other-acc-type"></span>

					</div>

				</div>

<div class="container main-container">
	<div class="row">

	<div class="col-md-12 about-block page-new" data-wow-delay="0.3s">
		<div class="row">	
			
			<div class="col-md-2">	</div>	<div class="col-md-5">	
		
			<h2 class="page-title-account"><?=$page['title']?></h2>
				<ul style="  list-style-type: none;    font-size: 14px;
    font-weight: bold;
    ;;"> <li><a  style="color: #5f5f5f !important" href="<?=WEB_ROOT?>how-it-works">How It Works</a></li> 			
    <li><a style="color: #5f5f5f !important" href="<?=WEB_ROOT?>sign-up">Create your free account </a></li> 	
    <li><a  style="color: #5f5f5f !important" href="<?=WEB_ROOT?>contact-us">Advertise with LinkiBag</a></li> 		
    <li><a  style="color: #5f5f5f !important" href="<?=WEB_ROOT?>learn-more">Learn more</a></li> 			
    <li><a  style="color: #5f5f5f !important" href="<?=WEB_ROOT?>faq">User FAQs</a></li>
<li><a style="color: #5f5f5f !important" href="<?=WEB_ROOT?>free-personal-accounts">About Free Accounts</a></li>
	</ul>	</div>
			<!--<?=$page['page_body']?>-->
		<div class="col-md-5">	
		
			
				<ul style="  list-style-type: none;    font-size: 14px;
    font-weight: bold;
    ;;">
				   <br>  <br> 		  <li><a  style="color: #5f5f5f !important" href="<?=WEB_ROOT?>login">Login</a></li> 
				     
	<li><a style="color: #5f5f5f !important"  href="<?=WEB_ROOT?>?p=linki-drops-accounts">LinkiDrop Account (advertise with us) </a></li> 	
	<li><a  style="color: #5f5f5f !important" href="<?=WEB_ROOT?>page/terms">Terms of Use</a></li>
	
 				<li><a  style="color: #5f5f5f !important" href="<?=WEB_ROOT?>page/policy">Privacy Policy</a></li> 														
 				<li><a  style="color: #5f5f5f !important" href="<?=WEB_ROOT?>contact-us">Contact Us</a></li>
<li style="color: #ccc !important" >Site Map</li>

	</ul></div>
		</div>	
	

	
			<!--<?=$page['page_body']?>-->
		
		</div>
	
	</div>
	</div>
</div>
<div class="blue-border"></div>
</section>

	

	<?php

	}

?>	