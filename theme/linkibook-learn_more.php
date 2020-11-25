<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Learn More | LinkiBag";
?>

<?php
if($_SERVER['REQUEST_METHOD']=='POST'){ }

?>
<style>
#linkiBooks{
	width: 100%;
    float: left;
	margin: 30px 0;
}
ul#linkiBooks li{
	width: 40%;
	float: left;
	margin-right: 10px;
}
.login-page-right{
	border: 1px solid #7f7f7f; 
}
.rightTitle{
	font-weight: bold;
    text-align: center;
    width: 95%;
    margin: 20px;
    font-size: 20px;
}
.login-page-right div {
    color: #7f7f7f;
}
.login-page-right p {
    font-size: 14px;
    font-weight: bold;
	margin-bottom: 18px;
}
</style>
<div class="container">
	<div class="row">
		<div class="login-main">
			<div class="col-md-5 login-page-left">	
			<!-- Welcome to LinkiBag-->
				<h1>
					<img src="https://www.linkibag.com/files/page_imgs/original/main_logo_l.png" style="width: 25px;margin-right: 5px;float: left;">
					Welcome to LinkiBooks
				</h1>	
				<span style="font-size: 12px;">Trying to keep too many things under control? Drop your links into your LinkiBag and create your LinkiBook to share with anyone on the web.</span>	
				<ul class="listing-links" id='linkiBooks'>	 
					<li>
						<a target="_blank" href="https://www.youtube.com/watch?v=XK1dS4hMUMA">
							<img src='https://www.linkibag.com/files/page_imgs/original/howLinkiBagWork.png'>						
							<span style="color: #7f7f7f;font-size: 13px;">How LinkiBag.com works</span>
						</a>
					</li> 
					<li>
						<a target="_blank" href="https://www.youtube.com/watch?v=0GoHJuGUWBI">
							<img src='https://www.linkibag.com/files/page_imgs/original/learnMoreLinkibag.png'>
							<span style="color: #7f7f7f;font-size: 13px;">Learn more about LinkiBag</span>
						</a>
					</li>
				</ul> 
				<a href="<?=WEB_ROOT?>learn-more">
					<h3>Learn more about LinkiBag Services</h3>	
				</a>
				<a href="<?=WEB_ROOT?>sign-up">
					<span>Free Account Advertise with LinkiDrops</span>
				</a>
			</div>
			<div class="col-md-7 login-page-right">
				<div class="rightTitle" >Registration is Free and as Easy as 1-2-3</div>
				<div> 
					<p>1. Create your free LinkiBag account</p>
					<p>2. Add your links</p>
					<p>3. Create your LinkiBook</p>
					<p>4. Share it with your friends, students, staff or anyone on the web</p>
				</div>  
				<div style="margin: 20px;">
					<a class="btn bg-orange" href="<?=WEB_ROOT?>sign-up">Free Sign Up</a>
					<a href="<?=WEB_ROOT?>sign-up">
						<div style="color:#FF7F27;margin-top: 5px;" >Create Your Free account</div>
					</a>
				</div> 
			</div>
		</div>
	</div>
</div>
<?php } ?>