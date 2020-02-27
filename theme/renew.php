<?php  
   function page_access(){	
   	global $co, $msg;      	
   	$user_login = $co->is_userlogin();      	
   	if(!$user_login){   
   		echo '<script language="javascript">window.location="index.php";</script>';      		
   		exit();      
   	}          
   }      
   function page_content(){      
   	global $co, $msg; 

   	exit();
   	     	
   	$no_record_found='';      	
   	$co->page_title = "My Account | Linkibag";     
    	$current = $co->getcurrentuser_profile();  	
   	$user_profile_info = $co->call_profile($current['uid']);  	    	      	
   	$this_page='p=renew';      
   	?>

	<section class="sign_up_main_page" id="public-bag">

	<div class="container bread-crumb top-line">
      <div class="col-md-12">
         <p><a href="index.php">Home</a> &gt; Upgrade </p>
      </div>
   </div>
   
  
		
		<div class="containt-area">
			<div class="container">
					<?php
					include('account_setting_sidebar.php');
					?>		


					<div class="col-md-9 col-xs-12 col-sm-12 rgt" style="float: right;">
					
						<div class="user-name-dash">
							<span class="text-blue" style="font-weight: normal;"> Account Management</span>
						</div>
					
						<div class="table"> 
							<table class="table">

<thead>
								<tr style="background-color: #bebebe;">
									<th colspan="1"></th>
									<th colspan="1"></th>
									<th colspan="1"></th>
									<th colspan="1"></th>
									<th colspan="1"></th>
								</tr>
</thead>
								<thead>
									<tr class="table-head">
										<th>Date</th>
										<th>Account Type</th>
										<th>Renewal Date</th>
										<th>Status</th>
										<th>Amount Due</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$results = $co->fetch_all_array("select * from subscription s, user_subscriptions us, user_payments p WHERE p.payment_id=us.subs_payment_id and us.subs_uid=p.uid and us.subs_uid=:uid and us.subs_package=s.subscription_id",array('uid'=>$current['uid']));
								if(isset($results) and count($results) > 0){
									$j = 1;
									foreach($results as $list){
										if($j == 1){
											$grey_stripe = '';
											$j++;
										}else{
											$grey_stripe = ' style="background-color: #bebebe;"';
											$j = 1;
										}	
								?>
								   <tr<?=$grey_stripe?>>
									  <td><?=date('m/d/Y', strtotime($list['subs_start_date']))?></td>
									  <td><?=$list['package_name']?></td>
									  <td><?=date('m/d/Y', strtotime($list['subs_end_date']))?></td>
									  <td><?=($list['payment_id'] > 0) ? 'Success' : 'Pending'?></td>
									  <td>$ <?=round($list['subs_amt'],2)?></td>
								   </tr>
								<?php
										
									}
									
								}else{	
								?>	
									<tr<?=$grey_stripe?>>
										<td>2/29/2017</td>
										<td>free</td>
										<td>2/29/2018</td>
										<td>Success</td>
										<td>$ 0.00</td>
									</tr>
								<?php  } ?>

							</table>
						</div>
					</div>
				</div>
			</section>

			
			<section class="public-bag" style="padding-bottom: 65px;">
				<div class="container">
					<div class="col-md-2 col-xs-12 col-sm-12">
							<div class="row">
						<div class="bdr">
							<?php if(isset($_SESSION['coupon_discount'])){ ?>
							<p>Your coupon code is activated as <?=$_SESSION['coupon_code']?>
								<br/> your coupon discount is <?=$_SESSION['coupon_discount']?> %
							</p>
							<?php } ?>
							<p>Have a coupon?</p>
							<form method="POST">
							<input type="hidden" name="form_id" value="get_coupon_discount">
							<input type="text" class="form-control" id="coupon_code" placeholder="Coupon Code" value="<?=isset($_POST['coupon_code']) ? $_POST['coupon_code'] : ''?>" name="coupon_code">
							<button type="submit" class="btn submit">Submit</button>
							</form>
							<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
							
						</div> 
                        </div> 
                        </div>


						<div class="col-md-1  col-xs-12 col-sm-12"> </div>
						
						<form action="" method="post">
							<input type="hidden" name="form_id" value="add_subscription">
							<input type="hidden" name="coupon_discount" value="<?=isset($_SESSION['coupon_discount']) ? $_SESSION['coupon_discount'] : '0'?>">
							<input type="hidden" value="agreed" name="terms">
							<div class="col-md-2 col-xs-12 col-sm-12 buttons">
								<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
								<button type="button" class="btn-first pay_now"<?=((isset($_POST['subs_account_type']) and $_POST['subs_account_type'] != '1') ? '' : ' style="opacity: 0.5;"')?>> Continue with</button>


								<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
								<a href="index.php?p=close-account" class="btn btn-scnd">Close Account</a>



								<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
								<!--<button type="button" class="btn-three">Delete Account</button>-->
								<a href="index.php?p=delete-account" class="btn btn-three">Delete Account</a>
							</div>

							<div class="col-md-3  col-xs-12 col-sm-12 free-account">
									
								<select class="select" name="subs_account_type" id="subs_account_type">
									<?php
									$records = $co->fetch_all_array("select * from subscription",array());
									foreach($records as $list){
										$sel = '';
										if(isset($_POST['subs_account_type']) and $_POST['subs_account_type'] == $list['subscription_id'])
											$sel = ' selected="selected"';
									?>
										
									
									<option value="<?=$list['subscription_id']?>"<?=$sel?>  style="width=100%;"><?=$list['package_name']?></option>
									<?php } ?>
								</select>

								<p>Closing account will allow you to re-open it again within one year.</p>
								<p><a href="#">Deleted accounts can not be reinstead</a></p>
							</div>
						
							<div id="pay_now_block"<?=((isset($_POST['subs_account_type']) and $_POST['subs_account_type'] != '1') ? '' : ' style="opacity: 0.5;"')?>>
								<div class="col-md-4  col-xs-12 col-sm-12 bttns">
									<div class="col-md-12">
										<div class="row">
										<!--<img class="img-responsive" src="images/image.jpg">
										<input type="radio" name="paygate" value="paypal_basic" onchange="change_pay_type()">-->
										<div style="overflow: hidden;<?=((isset($_POST['subs_account_type']) and $_POST['subs_account_type'] != '1') ? '' : ' opacity: 0.5;')?> " class="form-group" id="payment_paypal">	
											<div class="paymentwrapmain">
																					 
													<div class="paymentwrap">
														<div class="btn-group paymentbtngroup btn-group-justified" data-toggle="buttons" style="display: block">
															<label class="btn paymentmethod">
																<div class="method paypal_basic"></div>
																<input type="radio" name="paygate" value="paypal_basic" onchange="change_pay_type()">
															</label>
														</div>        
													</div>
													
			
																
												
											</div>
										</div>
										
										
									</div>
									</div>
									<div class="col-md-6 col-xs-12 col-sm-12 Purchase">
										<p>Account due: </p>
										<p>Next renewal date:</p>
										<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
										<button type="submit" class="Purchase-btn" id="pay_now"<?=((isset($_POST['subs_account_type']) and $_POST['subs_account_type'] > 1) ? '' : ' disabled')?>>Purchase</button>

									</div>
									<div class="col-md-6  col-xs-12 col-sm-12 Cancel">
										<p id="account_due">$0.00</p>
										<p id="next_renewal_date">2/29/2019</p>
										<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
										<button type="button" class="btn">Cancel</button>

									</div>

								</div>
							</div>	
							</div>	
						</form>
					</section>



					<style> 
					/*.rgt h5 {color: grey;}*/
                     .lft {padding-left: 0;}
                     #public-bag .advertise {color: #fff;background-color: #004080;border-color: none;border-radius: 0px;
                     font-weight: 600;margin-top: 30px;padding: 5px 5px 5px 5px;}
                     .containt-area {padding-bottom: 30px;}
					.bttns img {padding-bottom: 12px;padding-top: 0px;}
					.buttons .btn-three {background-color: #FCFCFC;color: #337ab7;padding: 5px 19px 5px 27px;border-radius: 0px;font-weight: 500;
						border: 1px solid #363535;}
						.buttons .btn-scnd {background-color: #FCFCFC;color: #717171;padding: 5px 19px 5px 22px;margin-bottom: 7px;border-radius: 0px;
							border: 1px solid #363535;font-weight: 600;}
							.bttns .Purchase-btn {background-color: #FF7F27;color: #fff;padding: 2px 26px 2px 26px;border-radius: 0px;font-weight: 600;
								border: 1px solid #FF7F27;}
								.Cancel .btn {color: #7d7c7c;background-color: #fff;border-radius: 0px;font-weight: 500;border: 3px solid #ddd;
									padding: 2px 38px 2px 21px;}
								.lft ul li {padding-left: 0px;}
								.table .thead th {padding-top: 5px;padding-bottom: 5px;}
								.table .thead th tr {padding-top: 5px;padding-bottom: 5px;}
								.buttons .btn-scnd {margin-bottom: 15px;}
								.bdr {border: 1px solid #928f8f;padding: 10px 20px 10px 20px;}
								.bdr .form-control {border: 1px solid #31496a;border-radius: 0px;}
								.bdr p {color: #FF7F27;}
							    .rgt .table .table-head .tr .th {border-right: 1px solid black;}


/*								.table-head tr {border-right: 2px solid #838d9b;}
								.table .thead .tr .td {border-right: 2px solid #31496a;}*/

								.public-bag ul li {display: inline;padding-left: 5px;}
								.public-bag .ul .li .strong {display: inline; padding-left: 0px;} 
								/*	.lft .btn-primary {color: #fff; background-color: #31496a; border-color: #31496a;margin-top: 40px; margin-bottom: 5px;}*/
								.public-bag .submit {padding: 2px 31px 2px 23px;margin-top: 5px;background-color: #FF7F27;color: #fff;margin-bottom: 5px;border-radius: 0px;}					
								.buttons .btn-first {background-color: #FF7F27;color: #fff;padding: 5px 22px 5px 22px;margin-bottom: 15px;border-radius: 0px;
									font-weight: 600;border: 1px solid #FF7F27;}
									.free-account .select {width: 100%;border: 1px solid black;margin-bottom: 15px;padding: 5px 10px 5px 1px;color: grey;font-weight: 600;margin-bottom: 10px;}
									.public-bag {padding-top: 18px;padding-bottom: 15px;}
									/*	.lt .end .btn {background-color: #FF7F27;color: #fff;}*/
									.public-bag h5 {color: #004080;font-weight: 500;font-size: 16px;margin-top: 0px;}
									.btn-primary {color: #fff;background-color: #337ab7;border-color: #2e6da4;border-radius: 0px;font-weight: 600;}
									.btn-primary .btn-scnd {color: #6c6a6a;background-color: #fff;border-color: #6b6a6a;border-radius: 0px;font-weight: 600;
										padding: 6px 18px 6px 18px;font-size: 12px;}
										.public-bag .Advertise {color: #fff;background-color: #31496a;border-color: none;border-radius: 0px;
											font-weight: 600;margin-top: 90px;padding: 5px 5px 5px 5px;}
											@media only screen and (max-width: 500px) {
												.public-bag .lft {text-align: center;}
												.rgt .table .table-responsive {min-height: .01%;overflow-x: 0px;}

												.table-responsive {min-height: .01%;overflow-x: 0px auto;}
												.left h2 a {font-size: 22px;}                  

											}


											.left-links p { margin: 0px;}
											.lft .welcome-name {margin-bottom: 13px;}
											
											
											
			.paymentwrap .paymentbtngroup .paymentmethod {
				padding: 24px;
				box-shadow: none;
				position: relative;
			}
			.paymentwrap .paymentbtngroup .paymentmethod.active {
				outline: none !important;
			}
			.paymentwrap .paymentbtngroup .paymentmethod.active .method {
				border-color: #84b9ff;
				outline: none !important;
				box-shadow: 0 0px 3px 0 #7b7b7b;
			}
			.paymentwrap .paymentbtngroup .paymentmethod .method {
				position: absolute;
				right: 3px;
				top: 3px;
				bottom: 3px;
				left: 3px;
				background-repeat: no-repeat;
				border: 2px solid transparent;
				transition: all 0.5s;
			}
			
			.paymentwrap .paymentbtngroup .paymentmethod .method.paypal_basic {
				background-image: url("http://linkibag.net/PTest25x/linkibag/images/image.jpg");
			}
			
											</style>


											<?php

										}

										?>	


