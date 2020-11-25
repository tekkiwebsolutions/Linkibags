<?php

		function page_content(){

		global $co, $msg;

		$co->page_title = "How it Works | LinkiBag";
		$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>5));
		$current = $co->getcurrentuser_profile();

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
						$img = $co->query_first("SELECT * FROM page_imgs WHERE entity_id=:id ORDER BY RAND()", array('id'=>5));
						echo '<img class="margin-bottom img-responsive" src="' . $img['img_original'] . '" border="0" />';
						?>
			
</div>
			<div class="col-md-8 about-block how-it-work-page" data-wow-delay="0.3s">
			<h2 class="page-title-account">Three Steps to Get Your FREE LinkiBag</h2>
			<?=$page['page_body']?>
			<?php if(!(isset($current['uid']) and $current['uid'] > 0)){ ?>
			<div class="page-btns"><a class="btn orange-bg" href="index.php?#free_singup">Free Signup</a><br>
			<small>Free individual account signup</small>
			</div>
			<?php } ?>
			<div class="page-btns how-it-work-page-footer">
				<p><span>Business Solutions:</span> <a href="index.php?p=business-accounts">Commercial</a> and <a href="index.php?p=institutional-accounts">Institutional</a> Accounts | <a href="index.php?p=linki-drops-accounts">LinkiDrops</a> Account</p>

			</div>
			
			</div>
		</div>
		</div>
		<div class="blue-border"></div>
	</section>

	

	<?php

	}

?>	