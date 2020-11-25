<?php 
session_start();
if (substr($_SERVER['HTTP_HOST'], 0, 4) != 'www.') {
    header('Location: http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://www.' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    exit;
}

$msg='';
if (isset($_POST['login_submit'])){
	if ($_POST['name']=='LInk25' and $_POST['password']=='LB2016X'){	
		$_SESSION['access_use_pass'] = 1;
		$link_start = 'linkibag/index.php';											
		$link_end = '';	
		if(isset($_GET) and count($_GET) > 0){																
			foreach($_GET as $k=>$v){	
				
				if($k == 'p')
					$link_start .= '?'.$k.'='.$v;											
				else
					$link_end .= '&'.$k.'='.$v;
				
			}	
		}
		
		echo '<script>window.location.href="'.$link_start.$link_end.'"</script>';
		exit();
	}else{
		$msg = '<div class="alert alert-danger">Invalid username/password</div>';
	}
}
?>

<html>
<head>
<title>Welcome To Linkibag</title>
<link rel="stylesheet" href="http://linkibag.com/linkibag/theme/css/bootstrap.min.css">
<link rel="stylesheet" href="http://linkibag.com/linkibag/theme/css/linkibag.css">
	
	<script src="http://linkibag.com/linkibag/theme/js/jquery.js"></script>
	<script src="http://linkibag.com/linkibag/theme/js/bootstrap.min.js"></script>
	<script src="http://linkibag.com/linkibag/theme/js/custom.js"></script>
	<script src="https://www.google.com/recaptcha/api.js"></script>
	<script src="http://www.linkibag.net/PTest25x/linkibag//theme/js/bootstrap.min.js"></script>
	<script src="http://www.linkibag.net/PTest25x/linkibag//theme/js/chosen.jquery.js" type="text/javascript"></script>
	<script src="http://www.linkibag.net/PTest25x/linkibag//theme/js/wow.min.js"></script>
	<script src="http://www.linkibag.net/PTest25x/linkibag//theme/js/jquery-validation/dist/jquery.validate.js"></script>
	<script src="http://www.linkibag.net/PTest25x/linkibag//theme/js/jquery-validation/dist/additional-methods.js"></script>
	


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
						<form autocomplete="off" method="post" action="" role="form" id="register_form">	
							<?php
							if(isset($_GET)){											
										foreach($_GET as $k=>$v){	
											echo '<input type="hidden" name="'.$k.'" value="'.$v.'"/>';
										}	
									}
									?>
								<div class="form-group text-right">           
									<div class="col-md-4 text-left"><label>User Name:</label></div>
									<div class="col-md-8"><input type="type" class="simple-border" name="name"></div>
								</div>                  
								<div class="form-group text-right">    
									<div class="col-md-4 text-left"><label>Password:</label></div>
									<div class="col-md-8"><input type="password" class="simple-border" name="password"></div>
								</div>
								<div class="form-group">
									<div class="col-md-8">
										<div class="g-recaptcha" data-sitekey="6LfW_ScTAAAAAO2MRn6I180IrAb0HJa9cpaN3mI2"></div>
										<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
									</div>											
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


<script type="text/javascript">
		function recaptchaCallback() {
			var response = grecaptcha.getResponse(),
				$button = jQuery(".#send_register");
			jQuery("#hidden-grecaptcha").val(response);
			console.log(jQuery("#register_form").valid());
			if (jQuery("#register_form").valid()) {
				$button.attr("disabled", false);
			}
			else {
				$button.attr("disabled", "disabled");
			}
		}
		function recaptchaExpired() {
			var $button = jQuery(".#send_register");
			jQuery("#hidden-grecaptcha").val("");
			var $button = jQuery(".#send_register");
			if (jQuery("#register_form").valid()) {
				$button.attr("disabled", false);
			}
			else {
				$button.attr("disabled", "disabled");
			}
		}

		$("#register_form").validate({
			ignore: ":hidden:not(#hiddenRecaptcha)",
			rules: {

				name: {

					required:true,

				},
				
				password: {

					required:true,

				},
				
				"hiddenRecaptcha": {
					required: function() {
						if(grecaptcha.getResponse() == '') {
							return true;
						} else { return false; }
					}
				},
				
				

			},

			messages: {

				name: {

					required: "Please enter name",
					 

				},
				password: {

					required: "Please enter password",
					 

				},
				
				"hiddenRecaptcha": {
					required: "Captcha is required",
				},
				

			},
			 
		});	
	</script>
</body>
</html>