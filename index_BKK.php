<?php
include('config/web-config.php');
include('config/DB.class.php');
include('classes/common.class.php');
include('classes/user.class.php');
$co = new userClass();
$co->__construct();

$include = 'yes';
$submit_file = 'submit/submit.php';
if(file_exists($submit_file)){
	include($submit_file);
}
$msg = $co->theme_messages();
if(isset($_GET['ajax']) and $_GET['ajax']=='ajax_submit'){
	echo $msg;
	exit();
}
if(isset($_GET['p'])){
	$page = 'theme/'.$_GET['p'].'.php';	
	$body_class='page-'.$_GET['p'];
	if(!file_exists($page)){
		$page="theme/404.php";
		$body_class='theme-404';
	}
}
else{
	$page = 'theme/index.php';
	$body_class='page-index';
}
include($page);
if(function_exists('page_access')){
	page_access();
}



ob_start();
page_content();
$content = ob_get_contents();
ob_end_clean();
$title = $co->page_title;

include("theme/header.php");
echo $content;
include("theme/footer.php");
?>

