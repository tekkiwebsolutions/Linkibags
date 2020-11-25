<?php
include('../config/web-config.php');
include('../config/DB.class.php');
include('classes/common.class.php');
$co = new commonClass();
$co->__construct();

if($co->is_adminlogin()){ header("location:main.php"); }



$username = "";

$pwd = "";	

$errormsg = "";

$msg = "";

if($_SERVER['REQUEST_METHOD']=='POST')

{

	$username = trim($_POST['user']);

	$pwd = $_POST['pass'];

	if($username=='' && $pwd=='') {
		$co->setmessage("error", "Please enter username and password!");
	} else if(!isset($_POST['g-recaptcha-response'])) {
		$co->setmessage("error", "Please validate Captcha unset");
		$success=false;
	} elseif(empty($_POST['g-recaptcha-response'])) {
		$co->setmessage("error", "Please validate Captcha empty");
		$success=false;
	} else if(isset($_POST['g-recaptcha-response'])) {
        $responseData = $co->validate_gresponse($_POST['g-recaptcha-response']);
        if(!$responseData->success) {
            $co->setmessage("error", "Please validate Captcha nosuccess");
			$success=false;
        }else{
        	if($co->adminlogin($username,$pwd)) {
        		echo '<script language="javascript">window.location="main.php";</script>';
        		exit();
        	}else{
        		$co->setmessage("error", "You have entered invalid login detail, Please try again.");
        	}
        }
   	} 

	$msg = $co->theme_messages();

}

?>

<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->

<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- BEGIN HEAD -->

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Advertiser Login</title>

<link rel="shortcut icon" href="favicon.ico" />

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/sb-admin.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,300italic,300,600,700,700italic,600italic' rel='stylesheet' type='text/css'>
	<script src="https://www.google.com/recaptcha/api.js"></script>

</head>



<body style=" background:rgb(104, 145, 162); height: 100%;
    background-repeat: no-repeat; " class="login">
<div class="container">
        <div class="card card-container col-md-4 col-md-offset-4">
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form action="login.php" method="post" class="form-signin">
              <h3 class="form-title" style="text-align: center; text-transform: uppercase; font-size: 25px; font-weight: 100;">Login to your account</h3>

			<div class="alert alert-error hide">

				<button class="close" data-dismiss="alert"></button>

				<span>Enter any username and passowrd.</span>

			</div>

            <?php if(isset($msg)) { echo $msg; }?>
				
				<input id="inputEmail" class="form-control" type="text" placeholder="Username" name="user"/>
				<input id="inputPassword" class="form-control" type="password" placeholder="Password" name="pass"/>
				<div style="margin-top: 5px;" class="g-recaptcha" data-sitekey="6LcvQfIUAAAAADmpuC1uXGhW_OPaRyxM_TqKHOVN"></div>
				<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" value="1"/> Remember me
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit"><i class="fa fa-log-in"></i> Log in</button>
            </form><!-- /form -->
        </div><!-- /card-container -->
		<div class="copyright">

		    <?=date('Y');?> &copy; Admin Dashboard.

	    </div>
    </div><!-- /container -->

    
  	

</body>

</html>

