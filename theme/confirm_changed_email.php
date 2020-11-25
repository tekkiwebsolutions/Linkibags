<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Request New Password | LinkiBag";
?>

<?php
if($_SERVER['REQUEST_METHOD']=='POST')

{
		
}

?>

<div class="container">
	<div class="row">
		<br /><br />
		<div class="col-md-5 col-md-offset-4 forget-pass">
			<div id="login"> 
				
					
				<form action="index.php?p=forget-pass" method="post" class="login_frm">
					<input type="hidden" name="form_id" value="forget_password" />
					<h2>Forget Password</h2>

					<?php if(isset($msg)) { echo $msg; }?>
				
					<div class="form-group">
						<input class="form-control" type="text" value="<?=(isset($_POST['email_adr']) ? $_POST['email_adr'] : '')?>" placeholder="Email Address *" name="email_adr"/>
					</div>
					<div class="form-group">
						<input class="btn btn-default linki-btn col-md-12" type="submit" id="" name="login" value="Submit">
					</div>
					<br /><br />
				</form><!-- /form -->
				
				
			</div> 
		</div>
	</div>
</div>
<?php } ?>