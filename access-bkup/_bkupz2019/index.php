<?php
session_start();
$msg='';
if (isset($_POST['login_submit'])){
	if ($_POST['name']=='LInk25' and $_POST['password']=='LB2016X'){
		$_SESSION['access_use_pass'] = 1;
		echo '<script>window.location.href="http://linkibag.com/linkibag/"</script>';
		exit();
	}else{
		$msg = '<div class="alert alert-danger">Invalid username/password</div>';
	}
}
?>

<html>
<head>
<title>Login - Welcome To Linkibag</title>
<link rel="stylesheet" href="http://linkibag.com/linkibag/theme/css/bootstrap.min.css">
<link rel="stylesheet" href="http://linkibag.com/linkibag/theme/css/linkibag.css">
	
	<script src="http://linkibag.com/linkibag/theme/js/jquery.js"></script>
	<script src="http://linkibag.com/linkibag/theme/js/bootstrap.min.js"></script>
	<script src="http://linkibag.com/linkibag/theme/js/custom.js"></script>
<style>
nav, .top-nav, #footer, .copyright-bar {
    display: none;
}
.simple-border {
    border: 1px solid #7f7f7f;
    padding: 4px 6px;
    width: 100%;
}
.form-group {
    margin-bottom: 15px;
    overflow: hidden;
}
label {
	color: #000;
	font-family: open sans;
	font-size: 13px;
	margin: 3px 0 0;
}
.login-main-user {
    margin-top: 188px;
    overflow: hidden;
}
.alert-error {
    color: red;
    font-family: open sans;
}
.slidingDiv .alert {
    border-radius: 2px;
    font-family: open sans;
    margin: 17px 15px;
}
</style>	
</head>
<body>
<div class="container">
	<div class="row">
		<div style="margin-top: 68px;" class="login-main-user">
			<div class="col-md-4 col-md-offset-4 login-page-right">
				<div style="position: relative;" class="right-btn-user text-center">
					<div style="display: block ! important;" class="slidingDiv"<?php if (isset($_POST['login_submit'])){ echo ' style="display: block;"'; }else{  echo ' style="display: none;"';  } ?>>
						<?=$msg?>
						<form autocomplete="off" method="post" action="" role="form">	
								<div class="form-group text-right">           
									<div class="col-md-4 text-left"><label>User Name:</label></div>
									<div class="col-md-8"><input type="type" class="simple-border" name="name"></div>
								</div>                  
								<div class="form-group text-right">    
									<div class="col-md-4 text-left"><label>Password:</label></div>
									<div class="col-md-8"><input type="password" class="simple-border" name="password"></div>
								</div>					
								<div class="text-right">  
									<div class="col-md-12"><input type="submit" value="Log in" name="login_submit" style="background: rgb(255, 127, 39) none repeat scroll 0% 0%; border: medium none; color: rgb(255, 255, 255); font-family: open sans; font-weight: bold; font-size: 12px; text-transform: uppercase; padding: 5px 17px;"></div>
								</div>       
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>