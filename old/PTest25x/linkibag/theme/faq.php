<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Personal FAQs | Linkibag";
	$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>7));
	$img = $co->query_first("SELECT * FROM page_imgs WHERE entity_id=:id ORDER BY RAND()", array('id'=>7));
?>
<section id="public-bag">
	<div class="container bread-crumb top-line" style="margin: auto;">
		<div class="col-md-7">
			<p><a href="index.php">Home </a>> <?=$page['title']?></p>
		</div>
	</div>
	<div class="container faq-page">	
		<div class="row">
				<div class="col-md-4">
					<img style="margin: 31px 0px 0px;" src="<?=$img['img_original']?>" class="img-responsive"/>												<div class="image-blow-text" style="width: 100%; display: inline-block; margin: 23px 0px 0px;"><span class="orange-blue">More questions?</span> <a href="index.php?p=contact-us" style="color: gray;">Contact us</a> <span class="orange-blue">at any time.</span></div>
				</div>
				<div class="col-md-8">
								
					
					<h3 class="page-title">Frequently Asked Questions</h3>
			
					<div class="faq-list">
						<?=$page['page_body']?>
					</div>
				</div>	   
				
			</form>		
		</div>		
	</div>
</section>
<?php
}
?>