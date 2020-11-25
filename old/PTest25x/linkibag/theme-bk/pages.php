<?php
function page_content(){
global $co, $msg;


$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>$_GET['id']));
$img = $co->query_first("SELECT * FROM page_imgs WHERE entity_id=:id ORDER BY RAND()", array('id'=>$_GET['id']));

$co->page_title = ucfirst($page['title'])." | LinkiBag";
?>	

	<section id="public-bag">
				<div class="container bread-crumb top-line about-top" style="margin: auto;">

					<div class="col-md-7">

						<p><a href="index.php">Home</a> > <?=ucfirst($page['title'])?></p>
						<h4><?=ucfirst($page['title'])?></h4>
						<h4 style="color: #414141;font-size: 13px;margin: 0;">Last updated: <?=date('M d, Y', $page['updated'])?></h4>

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
	<style type="text/css">
		.bread-crumb, .bread-crumb a {
		    text-transform: none !important; 
		}
	</style>
	

	<?php

	}

?>	