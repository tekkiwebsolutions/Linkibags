	<?php



		function page_content(){

		global $co, $msg;

		$co->page_title = "Terms of Use | LinkiBag";
		$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>8));
		$img = $co->query_first("SELECT * FROM page_imgs WHERE entity_id=:id ORDER BY RAND()", array('id'=>8));

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

				<div class="container main-container" style="margin-top: 0px;">

					<div class="row">

						<div class="col-md-12 about-block page-new" data-wow-delay="0.3s">
							<div class="terms-page">
							<?=$page['page_body']?>
							</div>
   
						</div>

					</div>

				</div>
		<div class="blue-border"></div>
	</section>

	

	<?php

	}

?>	