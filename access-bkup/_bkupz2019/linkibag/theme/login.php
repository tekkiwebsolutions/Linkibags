<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Login | Linkibag";
	$current = $co->getcurrentuser_profile();
	if((isset($current['uid']) and $current['uid'] > 0)){
		echo '<script type="text/javascript">window.location.href="index.php?p=dashboard"</script>';
	}	
?>

<?php
if($_SERVER['REQUEST_METHOD']=='POST')

{
		
}

?>

<div class="container">
	<div class="row">
		<div class="login-main">
			<div class="col-md-5 login-page-left">	
				<h1>Welcome to LinkiBag</h1>	
				<p>Trying to keep too many things under <br>control? Drop your links to your LinkiBag<br> and keep them with you wherever you go.</p>	
				<div class="page-btns">		
					<a class="btn orange-bg" href="index.php?#free_singup">Free Signup</a>	
					<br><small style="color: rgb(255, 127, 39);">Free individual account signup</small>	
				</div>					
				<h3>Learn more about LinkiBag Services</h3>	
				<div class="login-page-links">	
					<a href="index.php?p=business-accounts">Business Accounts</a> - <a href="index.php?p=institutional-accounts">Institutional Accounts</a> - <a href="index.php?p=linki-drops-accounts">LinkiDrops Accounts</a>	
				</div>	
			</div>
			<div class="col-md-4 col-md-offset-3 login-page-right">
			<?php if(isset($msg)){ echo $msg; } ?>
				<div class="login-form"> 
					<form autocomplete="off" id="login_form" action="index.php?ajax=ajax_submit" onsubmit="javascript: return ajax_login();" method="post" role="form">	
						<h3 class="text-center">Sign in to LinkiBag</h3>   
						<input type="hidden" name="form_id" value="login"/>
						<?php
						if(isset($_GET['request_id']) and $_GET['request_id'] > 0 and isset($_GET['request_code']) and $_GET['request_code'] != '' and isset($_GET['accept']) and $_GET['accept'] != ''){
							$result = $co->query_first("select fr.request_id,u.email_id from friends_request fr, users u where fr.request_to=u.uid and fr.request_id=:id and fr.request_code=:code and fr.status='0'", array('id'=>$_GET['request_id'], 'code'=>$_GET['request_code']));
							if(!(isset($result['request_id']) and $result['request_id'] > 0)){
								echo '<script language="javascript">window.location="index.php";</script>';      		
								exit(); 
							}	
							echo '<input type="hidden" name="request_id" value="'.$_GET['request_id'].'"/>
								<input type="hidden" name="request_code" value="'.$_GET['request_code'].'"/>
								<input type="hidden" name="accept" value="'.$_GET['accept'].'"/>
								
								';	
						}	
						?>
						<div id="login_messages_out" class="login-msg-out"></div>
						<div class="form-group text-right">           
							<input tabindex="1" type="email" placeholder="Email Address" class="form-control form-control-clean" id="email" name="email_id" value="<?=isset($result['email_id']) ? $result['email_id'] : ''?>">
							<a href="index.php?#free_singup">Free Signup</a>              
						</div>                  
						<div class="form-group text-right" style="margin-bottom: 4px;">    
							<input tabindex="2" type="password" placeholder="Password" class="form-control form-control-clean" id="key" name="password">	
						<a href="index.php?p=forget-password">Forgot Password?</a>               
						</div>					
						<div class="form-group" style="margin-bottom: 4px;">	
							<input type="checkbox" tabindex="3" class="" name="remember" id="remember">		
							<label for="remember" style="color: rgb(127, 127, 127); font-weight: 500; font-size: 12px;"> Remember me on this computer</label>	
						</div>			
						<div class="text-right">  
							<input tabindex="4" type="submit" value="Log in" class="btn btn-custom btn-blue-bg" id="btn-login">
						</div>       
					</form>
				</div> 
			</div>
		</div>
	</div>
</div>
<?php } ?>