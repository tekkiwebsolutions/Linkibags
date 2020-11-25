<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Special Offers | LinkiBag";
?>
<section id="public-bag">
	<div class="container bread-crumb top-line" style="margin: auto;">
		<div class="col-md-7">
			<p><a href="index.php">Home </a>> <a href="index.php?p=business-account">Special Offers </a></p>
		</div>
	</div>
	<div class="container faq-page">	
		<div class="row">
				<div class="col-md-offset-1 col-md-10">					<div class="offer-top-header">							<form method="get" action="/" class="form-inline pull-right" >							<small><a href="">How to unsubscribe?</a></small><br>							<input name="loc" class="span5" type="text"  placeholder="">							<button type="submit" class="btn btn-sm btn-gray"> Sign up </button>							</form>							<div class="pull-right" style="color: rgb(0, 64, 128); font-family: open sans; font-weight: 500; margin: 24px 10px 0px 0px;">Sign up to receive LinkiBag coupons via email: </div>					</div>				<div class="offer-box">				<div class="col-md-5">					<img style="margin: 31px 0px 0px;" src="images/offer.jpg" class="img-responsive"/>					</div>				<div class="col-md-7">				<div class="offer-right">					 <div class="save-now-btn">SAVE NOW </div>						<div class="offer-right-text">						Sign up for one year institutional account and get: <br><br>                                          						- 10% off for 100 plus accounts<br>						- 20% off for 200 plus accounts<br>						- 30% off for 300 pIus accounts<br>						</div>						<div class="offer-right-code">Use promo code: <span class="color-red">Summer2016</span></div>						</div>											</div>				</div>						</div>
				
			</form>		
		</div>		
	</div>
</section>
<?php
}
?>