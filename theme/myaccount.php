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
   	$no_record_found='';      	
   	$co->page_title = "My Account | LinkiBag";     
    	$current = $co->getcurrentuser_profile();  	
   	$user_profile_info = $co->call_profile($current['uid']);  	    	      	
   	$this_page='p=myaccount';      
   	?>
<section class="dashboard-page upgrade-panel">
   <div class="container bread-crumb top-line">
      <div class="col-md-7">
         <p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > My Account</a></p>
      </div>
   </div>
   <div class="containt-area" id="dashboard_new">
      <div class="container">
         <div class="col-md-3">
			<div class="upgrade-main-block-left">
            <?php/* include('dashboard_sidebar.php'); */?> 
            <div class="left-box">
               <h4>Students and Faculty</h4>
               <p>
                  LinkiBag offers discounts when signing up with
                  a scholl email address.Select Institutional Account
                  to upgrade.
               </p>
            </div>
			</div>
         </div>
         <div class="col-md-9">
		 <div class="upgrade-main-block-right">
            <div class="account-head">
               <h4>My LinkiBag Account</h4>
               <p class="sub-title">Select desired account type from the list below.</p>
            </div>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="display: none;">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="PDCN879799UDA">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
				<?=isset($msg) ? $msg : ''?>
			 <form action="" method="post">
				<div class="row">
				   <div class="col-lg-9">
					  <div class="upgrade-block-left">
						 <a class="pull-right text-orange" href="#">Compare Plans</a>
						 <h5 class="text-orange">Upgrade / Renew</h5>
						
							<input type="hidden" name="form_id" value="add_subscription">
							<table class="table">
							   <tbody>
								<?php
								$records = $co->fetch_all_array("select * from subscription",array());
								foreach($records as $list){
									$i++;
									if($i == 1){
								?>
								  <tr>
									 <td><label><input name="subs_account_type" value="<?=$list['subscription_id']?>" type="radio" checked> <?=$list['package_name']?></label></td>
									 <td>Free</td>
								  </tr>
								<?php
									}else if($i == 2){
								?>	
								  <tr>
									 <td><label><input name="subs_account_type" value="<?=$list['subscription_id']?>" type="radio"<?=((isset($_POST['subs_account_type']) and $_POST['subs_account_type'] == $list['subscription_id']) ? ' checked="checked"' : '')?>> <?=$list['package_name']?></label></td>
									 <td>$97.49</td>
									 <td>Billed Annually</td>
									 <td><input name="subs_account_type_<?=$list['subscription_id']?>" value="<?=$list['subscription_id']?>" type="checkbox"<?=((isset($_POST['subs_account_type_business_account']) and $_POST['subs_account_type_business_account'] == $list['subscription_id']) ? ' checked="checked"' : '')?>> Subscribe</td>
								  </tr>
								  <?php
									}else if($i == 3){
								?>	
								  <tr>
									 <td><label><input name="subs_account_type" value="<?=$list['subscription_id']?>" type="radio"<?=((isset($_POST['subs_account_type']) and $_POST['subs_account_type'] == $list['subscription_id']) ? ' checked="checked"' : '')?>> <?=$list['package_name']?></label></td>
									 <td>$47.99</td>
									 <td>Billed Annually</td>
									 <td><input name="subs_account_type_<?=$list['subscription_id']?>" value="<?=$list['subscription_id']?>" type="checkbox"<?=((isset($_POST['subs_account_type_institutional_account']) and $_POST['subs_account_type_institutional_account'] == $list['subscription_id']) ? ' checked="checked"' : '')?>> Subscribe</td>
								  </tr>
									<?php 
									} 
								}
									?> 
									<tr>
										<td>
											<div style="overflow: hidden;<?=((isset($_POST['subs_account_type']) and $_POST['subs_account_type'] != '1') ? '' : ' display: none;')?> " class="form-group" id="payment_paypal">	
												<div class="paymentwrapmain">
																						 
														<div class="paymentwrap">
															<div class="btn-group paymentbtngroup btn-group-justified" data-toggle="buttons" style="display: block">
																<label class="btn paymentmethod active">
																	<div class="method paypal_basic"></div>
																	<input type="radio" name="paygate" value="paypal_basic" onchange="change_pay_type()">
																</label>
															</div>        
														</div>
														
				
																	
													
												</div>
											</div>
										</td>

									</tr>	
									
							   </tbody>
							</table>
						 
					  </div>
				   </div>
				   <div class="col-lg-3">
					  <div class="upgrade-block-right">
						 <h4>Doing Business with Us</h4>
						 <a class="btn btn-success green-bg" href="#">LinkiDrops Account</a>
						 <p><b>Questions?</b></p>
						 <p><b><u><a href="#">Ask us</a></u> about our commercial LinkiDrops account</b></p>
					  </div>
				   </div>
				</div>
				<div class="row">
				   <div class="col-md-6">
					  <div class="account-history-left">
						 <h5 class="text-orange">Account History</h5>
						 <table class="table">
							<thead>
							   <tr>
								  <th>Date</th>
								  <th>Account Type</th>
								  <th>Paid until</th>
							   </tr>
							</thead>
							<tbody>
							<?php
							$results = $co->fetch_all_array("select * from subscription s, user_subscriptions us, user_payments p WHERE p.payment_id=us.subs_payment_id and us.subs_uid=p.uid and us.subs_uid=:uid and us.subs_package=s.subscription_id",array('uid'=>$current['uid']));
							if(isset($results) and count($results) > 0){
								foreach($results as $list){
							?>
							   <tr>
								  <td><?=date('m/d/Y', strtotime($list['subs_start_date']))?></td>
								  <td><?=$list['package_name']?></td>
								  <td><?=date('m/d/Y', strtotime($list['subs_end_date']))?></td>
							   </tr>
							<?php
								}
							}else{	
							?>	
								 <tr>
								  <td>2/1/2017</td>
								  <td>Free Personal</td>
								  <td>No expiration date</td>
							   </tr>
							<?php  } ?>  
							</tbody>
						 </table>
					  </div>
				   </div>
				   <div class="col-md-6">
					  <div class="account-history-right">
						 <button type="submit" class="btn orang-bg btn-info btn-sm" id="pay_now"<?=((isset($_POST['subs_account_type']) and $_POST['subs_account_type'] > 1) ? '' : ' disabled')?>>pay now</button>
						 <p>
							<input name="terms" value="agreed" type="checkbox">
							By subscribing I am stating that I an at least 18 years old,that i have fully read,understood and accepted all terms and conditions listed in terms of Use document.
						 </p>
					  </div>
				   </div>
				</div>
			</form>
			</div>
         </div>
      </div>
   </div>
</section>
		<style>
			.paymentwrap .paymentbtngroup .paymentmethod {
				padding: 40px;
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
				background-position: center;
				background-repeat: no-repeat;
				border: 2px solid transparent;
				transition: all 0.5s;
			}
			
			.paymentwrap .paymentbtngroup .paymentmethod .method.paypal_basic {
				background-image: url("https://www.linkibag.com/images/paypal_basic.png");
			}
			.paymentwrap .paymentbtngroup .paymentmethod .method:hover {
				border-color: #84b9ff;
				outline: none !important;
			}
			</style>

<?php } ?>