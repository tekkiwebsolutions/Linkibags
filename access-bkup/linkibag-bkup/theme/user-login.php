<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Login | Linkibag";
?>

<?php
if($_SERVER['REQUEST_METHOD']=='POST')

{
		
}

?>
<style>
nav, .top-nav, #footer, .copyright-bar {
    display: none;
}
.simple-border {
	border: 1px solid #7f7f7f;
	padding: 0 9px;
	width: 100%;
}
.form-group {
    margin-bottom: 15px;
    overflow: hidden;
}
label {
    color: #000;
    font-family: Verdana;
    font-size: 12px;
}
.login-main-user {
    margin-top: 188px;
    overflow: hidden;
}
</style>

<div class="container">
	<div class="row">
		<div class="login-main-user">
			
			<div class="col-md-4 col-md-offset-4 login-page-right">
				<form autocomplete="off" method="post" action="javascript:;" role="form">	
						<div class="form-group text-right">           
							<div class="col-md-4"><label>User Name:</label></div>
							<div class="col-md-8"><input type="type" class="simple-border" name="name"></div>
						</div>                  
						<div class="form-group text-right">    
							<div class="col-md-4"><label>Password:</label></div>
							<div class="col-md-8"><input type="password" class="simple-border" name="password"></div>
						</div>					
						<div class="text-right">  
							<div class="col-md-12"><input type="submit" value="Log in"></div>
						</div>       
				</form>
			</div>
		</div>
	</div>
</div>
<?php } ?>