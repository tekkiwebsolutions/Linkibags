<?php

	function page_content(){

	global $co, $msg;

	$co->page_title = "Site Map | LinkiBag";
	$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>11));
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

<urlset xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">;

<url>
<loc>https://www.linkibag.com/</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>1.00</priority>
</url>
<url>
<loc>https://www.linkibag.com/index.php?home_link=1</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.linkibag.com/learn-more</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.80</priority>
</url>
<url>
<loc>
https://www.linkibag.com/contact-us?id=Reported_Bug
</loc>
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.linkibag.com/login</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.linkibag.com/free-personal-accounts</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.linkibag.com/contact-us</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.linkibag.com/how-it-works</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.linkibag.com/faq</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.linkibag.com/about-us</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.linkibag.com/index.php?</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.64</priority>
</url>
<url>
<loc>
https://www.linkibag.com/index.php?p=linki-drops-accounts
</loc>
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.64</priority>
</url>
<url>
<loc>
https://www.linkibag.com/index.php?p=free-personal-accounts
</loc>
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.64</priority>
</url>
<url>
<loc>https://www.linkibag.com/index.php?p=contact-us</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.64</priority>
</url>
<url>
<loc>https://www.linkibag.com/index.php</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.64</priority>
</url>
<url>
<loc>https://www.linkibag.com/index.php?p=faq</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.64</priority>
</url>
<url>
<loc>https://www.linkibag.com/index.php?p=login</loc>;
<lastmod>2014-10-07T10:10:10+00:00</lastmod>
<priority>0.64</priority>
</url>
</urlset>
	
	</div>
	</div>
</div>
<div class="blue-border"></div>
</section>

	

	<?php

	}

?>	