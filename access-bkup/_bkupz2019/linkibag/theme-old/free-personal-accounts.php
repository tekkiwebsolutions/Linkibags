	<?php



		function page_content(){

		global $co, $msg;

		$co->page_title = "FREE Personal Accounts | LinkiBag";
		$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>1));

?>	

	<section id="public-bag">
				<div class="container bread-crumb top-line about-top" style="margin: auto;">

					<div class="col-md-7">

						<p><a href="index.php">Home</a> > <?=$page['title']?></p>

					</div>

					<div class="col-md-4">

						<span class="other-acc-type"></span>

					</div>

				</div>

				<div class="container main-container">

					<div class="row">

						<div class="col-md-4 text-left wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						
						<?php
$img = $co->query_first("SELECT * FROM page_imgs WHERE entity_id=:id ORDER BY RAND()", array('id'=>1));
echo '<img class="margin-bottom" src="' . $img['img_original'] . '" border="0" />';
?>
			<div class="image-blow-text">Try us risk free. Start with a <span class="orange-color">FREE</span> <span class="orange-blue"><a class="orange-blue" href="index.php?p=personal-account">Personal Account</a></span> today.</div>
</div>
			<div class="col-md-8 about-block page-new" data-wow-delay="0.3s">
				<div class="row">	
					<div class="col-md-5">	
					<h2 class="page-title-account"><?=$page['title']?></h2>
					<div class="sub-title-inner-heading"><span class="color-gray">> Find </span><span class="orange-blue"><a class="orange-blue" href="index.php?p=faq">answers to Frequently Asked Questions</a></span></div>				
					</div>			
					<div class="col-md-7">	
						<ul class="sub-page-listing-links">		
							<li class="active"><a href="index.php?p=free-personal-accounts">FREE Personal Accounts </a></li>
							<li><a href="index.php?p=business-accounts">Business Accounts </a></li>
							<li><a href="index.php?p=institutional-accounts">Institutional Accounts (discounted rates)</a></li>	
							<li><a href="index.php?p=linki-drops-accounts">LinkiDrops Accounts </a></li>		
						</ul>			
					</div>			
				</div>	
			<div class="page-btns"><a class="btn orange-bg" href="index.php?p=personal-account">Free Signup</a></div>
			<?=$page['page_body']?>							
			</div>
		</div>
		</div>
		<div class="blue-border"></div>
	</section>

	

	<?php

	}

?>	