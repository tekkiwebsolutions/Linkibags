<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Welcome | LinkiBag"; 
	$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>12));
	$current = $co->getcurrentuser_profile(); ?>
	
<link href="https://fonts.googleapis.com/css2?family=Nothing+You+Could+Do&display=swap" rel="stylesheet">
<style>
span.sign_txt {
    font-family: 'Nothing You Could Do', cursive;
    font-size: 20px;
    font-weight: 600;
    margin-top: 10px;
    display: inline-block;
}
.about_left img {
    width: 150px;
    margin-bottom: 40px;
}   
.about_left p {
	font-family: arial;
	font-weight: 600;
	color:#5f5f5f !important;
	font-size:15px;
	width: 80%;line-height: 1.3;
	margin: 0;
}
.about_left .welcome_author {
    margin-top: 20px;
}
.about_right img {
    width: 150px !important;
    height: auto !important;float: left;
	border-radius: 10px;
}
.about_right h4 {
    float: left;
    margin-left: 50px;
    margin-top: 75px;
}
.about_right .about_right_txt {
    display: inline-block;
    width: 100%;
    margin-top: 20px;
   text-align: justify !important;
}
.about_right .about_right_txt p {
	width: 70%;
    font-size: 13px;
    color: #000;
    font-family: arial;
    font-weight: 600;
    line-height: 1.8;
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
			<div class="col-md-4 about_left">
				<img src="../images/email-logo/linkibag-logo.png">
				<!--<p >I hope this product would exist twenty year ago when I started teaching and during my dissertation research. -->
				<!--We build Linkibag to be the best place to keep your links. Please enjoy your free account.</p>-->
				<p>
					"It was my dream to have this product during my dissertation research and years of teaching. We built it to be the best place to keep your
					links and to meet your personal, business, teaching and research need. I hope you will &nbsp; enjoy it." 
				</p>
				
				<p style="margin-top: 5px;">Dr. Feliks Kravets</p>
				<!--<div class='welcome_author'>
					<strong>Dr. Feliks Kravets, CEO and Founder of LinkiBag Inc.</strong>
				</div>-->
			</div>
			<div class="col-md-8 about-block page-new about_right" data-wow-delay="0.3s">
				<?=$page['page_body']?>						
			</div>
		</div>
	</div>
	<div class="blue-border"></div>
</section>
<?php } ?>	