	<?php



		function page_content(){

		global $co, $msg;

		$co->page_title = "About us | LinkiBag";
		$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>4));
		$current = $co->getcurrentuser_profile();
	

?>	

	<section>
				<div class="container bread-crumb top-line about-top" style="margin: auto;">

					<div class="col-md-7">

						<p><a href="index.php">Home</a> > <?=$page['title']?></p>

					</div>

					<div class="col-md-4">

						<span class="other-acc-type"></span>

					</div>

				</div>

				<div style="margin-top: 10px;" class="container main-container">

					<div class="row">
						<div class="col-md-12">
							<h4 class="text-orange">About Us</h4>
						</div>

						<div class="col-md-4 text-left wow fadeInUp templatemo-box" data-wow-delay="0.3s">

<?php
$img = $co->query_first("SELECT * FROM page_imgs WHERE entity_id=:id ORDER BY RAND()", array('id'=>4));
echo '<img class="margin-bottom" src="' . $img['img_original'] . '" border="0" />';
?>
							
							<?php if(!(isset($current['uid']) and $current['uid'] > 0)){ ?>
							<div class="image-blow-text">
							Try us risk free. Signup for your <span class="orange-blue"><a class="orange-blue" href="index.php?#free_singup">Free Account </a></span>today.
						</div>
							<?php } ?>
						</div>
						<div class="col-md-8 about-block page-new" data-wow-delay="0.3s">
							<?=$page['page_body']?>						<br />							<p>Read more about LinkiBag Services  </p>							<ul class="listing-links">								<li><a href="index.php?p=free-personal-accounts">Free Personal Accounts </a></li>								<li><a href="index.php?p=business-accounts">Free Professional Account </a></li>
							<li><a href="index.php?p=linki-drops-accounts">LinkiDrops Account (advertise your business)</a></li>							</ul>
							<div class="page-btns" style="margin-top: 21px;">
						<a class="btn orange-bg" href="index.php?#free_singup">Free Sign up ></a>
					</div>
						</div>

					</div>

				</div>
		<div class="blue-border"></div>
	</section>

	

	<?php

	}

?>	