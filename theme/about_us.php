	<?php



		function page_content(){

		global $co, $msg;

		$co->page_title = "About us | LinkiBag";
		$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>4));
		$current = $co->getcurrentuser_profile();
	

?>	
<style>
ul#about_video li{
	width: 40%;
}
</style>
	            <section>
				<div class="container bread-crumb top-line about-top" style="margin: auto;">

					<div class="col-md-7">

					<p><a href="<?=WEB_ROOT?>">Home</a> > <?=$page['title']?></p>

					</div>

					<div class="col-md-4">

					<span class="other-acc-type"></span>

					</div>

				</div>

				<div style="margin-top: 10px;" class="container main-container">

					<div class="row">
						<div class="col-md-5">
						<h4 class="text-orange">About Us</h4>
							<ul class="listing-links" id='about_video'>	
							<!--<li>LinkiBag.com is the bag to keep your links.</li>-->
							<!--<li><a href="learn-more">Learn more (Video)</a></li>-->
							<h2>Video Introduction</h2>
							<li><a href='https://www.youtube.com/watch?v=lgCR_ConFEo' target=_blank><img src='https://www.linkibag.com/files/page_imgs/original/into_linkibag.png'></a></li>
							<li><a href='https://www.youtube.com/watch?v=Wnsa5Q-3Xos' target=_blank><img src='https://www.linkibag.com/files/page_imgs/original/linkibag_education.png'></a></li>
							</ul>
							
						 <div class="page-btns" style="margin-top: 21px;">
						<a class="btn orange-bg" href="sign-up">Free Sign up</a>
						<ul class='listing-links links_about'>
							<li><a href="index.php?p=free-personal-accounts">Free Personal Accounts </a></li>
							<li><a href="index.php?p=linki-drops-accounts">LinkiDrops Account (advertise your business)</a></li>
						</ul>
					    </div>
					    
					    
						</div>
						
                       
							
					
						<div class="col-md-7 about-block page-new" data-wow-delay="0.3s">
							<?=$page['page_body']?>						
						
							
						</div>

					</div>

				</div>
		<div class="blue-border"></div>
	</section>

	

	<?php

	}

?>	