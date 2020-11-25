<?php
	function page_content(){
	global $co, $msg;
	$co->page_title = "Prices | LinkiBag";
	$current = $co->getcurrentuser_profile();
?>	
<div class="container bread-crumb">

					<div class="col-md-12">

						<p><a href="index.php">Home</a> &gt; Prices</p>

					</div>

				</div>
	<section>
				<div class="container">

					<div class="row">

						<div class="col-md-12 about-block page-new" data-wow-delay="0.3s">
						 <div class="prices-title"><div class="pull-left"><span class="text-blue">Prices</span></div>

<div class="pull-right"> <span class="text-blue">Advertise</span> <span class="text-orang"> with LinkiBag</span></div></div>
						<div class="clearfix"></div>
							<div class="prices-page-main">
							<h3 style="display:none;" class="display-show-mobile text-center">Account Features and Benefits</h3>
		  <div class="col-sm-3 col-md-3">
			<div class="plan plan-first-list display-none-mobile">
				<div class="head">
					<h2>Account Features and Benefits</h2>
				</div>  
				<ul class="item-list">
                   <li>FREE personal use</li>
                   <li>Commercial use</li>
                   <li>Works with your business email account</li>
                   <li>Advertisement Free</li>
				   <li>Institutional Discount</li>
				</ul>
			</div>
          </div>
		  <div class="col-sm-3 col-md-3 text-center">
			<div class="plan">
				<div class="head">
					<h2 style="color:#ff7f27;">FREE</h2>
				</div>  
				<ul class="item-list">
                   <li><div style="display:none;" class="display-show-mobile">FREE Personal Use</div><img src="images/yes-icon.png"/></li>
                   <li><div style="display:none;" class="display-show-mobile">Commercial Use</div><img src="images/no-icon.png"/></li>
				   <li><div style="display:none;" class="display-show-mobile">Works with Your Business Email Account</div><img src="images/no-icon.png"/></li>
				   <li><div style="display:none;" class="display-show-mobile">Advertisement Free</div><img src="images/no-icon.png"/></li>
				   <li><div style="display:none;" class="display-show-mobile">Institutional Discount</div><img src="images/no-icon.png"/></li>
				</ul>
			</div>
			<div class="plan-footer text-center">
				<p>Free for personal use</p>
			</div>
			
          </div>
		  <div class="col-sm-3 col-md-3 text-center">
			<div class="plan">
				<div class="head">
					<h2>Business</h2>
				</div>  
				<ul class="item-list">
                   <li><div style="display:none;" class="display-show-mobile">FREE personal use</div><img src="images/no-icon.png"/></li>
                   <li><div style="display:none;" class="display-show-mobile">Commercial use</div><img src="images/yes-icon.png"/></li>
				   <li><div style="display:none;" class="display-show-mobile">Works with your business email account</div><img src="images/yes-icon.png"/></li>
				   <li><div style="display:none;" class="display-show-mobile">Advertisement Free</div><img src="images/yes-icon.png"/></li>
				   <li><div style="display:none;" class="display-show-mobile">Institutional Discount</div><img src="images/no-icon.png"/></li>
				</ul>
			</div>
			<div class="plan-footer text-center">
				<p>$97.49 per year</p>
			</div>
          </div>
		  <div class="col-sm-3 col-md-3 text-center">
			<div class="plan last-plan-box">
				<div class="head">
					<h2>Institutional</h2>
				</div>  
				<ul class="item-list">
                   <li><div style="display:none;" class="display-show-mobile">FREE personal use</div><img src="images/no-icon.png"/></li>
                   <li><div style="display:none;" class="display-show-mobile">Commercial use</div><img src="images/yes-icon.png"/></li>
				   <li><div style="display:none;" class="display-show-mobile">Works with your business email account</div><img src="images/yes-icon.png"/></li>
				   <li><div style="display:none;" class="display-show-mobile">Advertisement Free</div><img src="images/yes-icon.png"/></li>
				   <li><div style="display:none;" class="display-show-mobile">Institutional Discount</div><img src="images/yes-icon.png"/></li>
				</ul>
			</div>
			<div class="plan-footer text-center">
				<p>$47.49 per year</p>
			</div>
          </div>
		  
		  <div class="price-footer">
			  <div class="col-sm-6 col-md-6 text-right">
			  		<?php if(!(isset($current['uid']) and $current['uid'] > 0)){ ?>
					<a class="btn orange-bg" href="index.php?#free_singup">Free Sign up</a><br>
					<?php } ?>
			  </div>
			  <div class="col-sm-6 col-md-6 text-left">
			  <p>Business and Institutional upgrades will be available upon completion of
	your registration. <?php if(!(isset($current['uid']) and $current['uid'] > 0)){ ?> Select <a href="index.php?#free_singup">Free Sign up</a> to continue. <?php } ?></p>
			  </div>
		  </div>
		  
		
							</div>
						</div>

					</div>

				</div>
				
				
				
				
				
				
				
	<!-- start divider -->
	<section id="start-signup">
		 <div class="container text-center">
			<div class="row">
					<h2 class="bold-title" style="color: #004080; padding-bottom: 18px ! important; word-spacing: 3px;">PACK YOUR LINKS<span class="tm">TM</span> TO GO</h2>
					<h3 style="color: rgb(127, 127, 127); padding-bottom: 37px; font-weight: 100;">Get your FREE account now and start saving links instantly.</h3>
					<?php if(!(isset($current['uid']) and $current['uid'] > 0)){ ?>
					<a class="btn bg-orange" href="index.php?#free_singup">Sign up</a>
					<?php } ?>
					<p style="color: rgb(0, 40, 81); margin-top: 54px; font-weight: 400;">The option to upgrade to a paid plan will be located under ‘My Account’</p>
					<p class="text-center"><a class="text-orange" href="index.php?p=institutional-accounts"><b><u>View Pricing Information</u></b></a></p>
			</div>
		</div>
	</section>
	<!-- end divider -->
				
				
				
				
				
				
				
		<div class="blue-border"></div>
	</section>

	

	<?php

	}

?>	