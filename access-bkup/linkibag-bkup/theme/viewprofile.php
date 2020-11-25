<?php  
   function page_access(){	
   	global $co, $msg;      	
   	$user_login = $co->is_userlogin();      	
            
   }      
   function page_content(){      
		global $co, $msg;      	
		$no_record_found='';      	
		$co->page_title = "Account Settings | Linkibag";     
		$current = $co->getcurrentuser_profile();  	
		$this_page='p=viewprofile';      

		$shareddata = $co->query_first("SELECT p.*, u.* FROM users u, profile p WHERE u.uid=:id AND u.uid=p.uid AND u.paid_users_generate_links!=:emp",array('id'=>$_GET['id'],'emp'=> "" ));
	
 ?>

	<section class="sign_up_main_page" id="public-bag">	
		<div class="container bread-crumb top-line">
		  <div class="col-md-12">
			 <p><a href="index.php">Home</a> &gt; <?=$shareddata['first_name']?> Profile </p>
		  </div>
		</div>
		<div class="containt-area">
			<div class="container">
				<div class="col-md-9">
					<div class="account-setting-header">
						<h3><?=$shareddata['first_name']?></h3>
					</div>
				</div>
			</div>
		</div>
	</section><!-- /.modal --> 

	<style>
	/*.setting .account-setting .linkibag a {line-height: 3;}
	.setting .account-setting .generate a {line-height: 3;}
	.setting .account-setting .Site-links a {line-height: 3;}*/
     .lft {padding-left: 0;}
     #public-bag .advertise {color: #fff;background-color: #004080;border-color: none;border-radius: 0px;
     font-weight: 600;margin-top: 30px;padding: 5px 5px 5px 5px;}
     .containt-area {padding-bottom: 30px;}
	.lft ul li {padding-left: 0px;}
	.Home .lft {text-align: center;}
	.lft h5 {color: grey;}
	
	.account p {padding-top: 31px;padding-left: 34px;color: #31496a;}
	.Home ul li {display: inline;padding-left: 5px;}
	.Home .ul .li .strong {display: inline; padding-left: 0px;} 
	.center .Advertise {color: #fff;background-color: #31496a;border-color: #31496a;border-radius: 0px;
		font-weight: 600;margin-top: 14px;padding: 5px 5px 5px 5px;margin-left: -10px;}
		.linkibag a {line-height: 3;}
		.generate p {color: #465d96;}
		.linkibag p {color: grey;}
		/* */
		.generate a {line-height: 3;}
		.Home {padding-top: 17px;}
		/*.generate {width: 45.667%;}*/
		/*		.generate {width: 15.667%;}*/
		.Site-links a {line-height: 3;}
		.center {margin-bottom: 163px;}
		.setting .Site-links h5 {text-align: center;}
		/*	.settings {float: right;padding-top: 22px;width: 79%;}*/
		.settings h5 {float: left;color: #31496a;}
		.setting {border: 1px solid #FF7F27;float: right;margin-right: 3px;}
		.Site-links {width: 41.333%;}
	/*.Home .strong ul {padding-left: 0px;}
	.Home {padding-bottom: 80px;}
	.Home ul li {padding-left: 6px;display: inline;font-weight: 500;}
	.Home .btn-Advertise  {color: #fff;background-color: #31496a;border-color: #31496a;border-radius: 0px;*/
		font-weight: 600;margin-top: 90px;padding: 5px 5px 5px 5px;}
		/*.Home h5 {color: #004080;}
		.Home strong ul li a {padding-left: 0px;}*/
		/*	.account-setting {border: 1px solid #FF7F27;}*/
		.generate a {color: grey;}
		.Site-links a {color: grey;}
		@media only screen and (max-width: 500px) {
			.settings {margin-top: 13px;
				margin: 36px;}
			}
					@media only screen and (max-width: 1024px) {
			.settings {left: 0px;}
			.account p {padding-left: 18px;}
			}
			@media only screen and (max-width: 320px){
            .settings {width: 81%;}
			}
			.left-links p {margin: 0px;}
			.lft .welcome-name {margin-bottom: 13px;}
			/*
			.settings {
				border-top: 2px solid #FF7F27 ;
				padding: 31px;
				float: left;
			}
			*/

			.settings {
				border-top: 2px solid #ccc ;
				border-bottom: 2px solid #ccc ;
				padding: 15px 0px;
			}
			.account-setting-header > h3{
				margin: 0;
			    font-size: 15px;
			    font-weight: 600;
			    color: #465d96;
			}
			.account-setting-header > p{
				color: red;
			}
			u {
				text-decoration: none;
			}
			.completed_on {
			    margin-left: 32px;
			    margin-top: 33px;
			    color: grey;
			    text-decoration: underline;
			}
	</style>
<?php } ?>	


