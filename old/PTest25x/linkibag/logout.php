<?php
include('config/web-config.php');
include('config/DB.class.php');
include('classes/common.class.php');
$co = new commonClass();
$co->__construct();
if(isset($_COOKIE['uid']) && isset($_COOKIE['website']) && $_COOKIE['website']=="Linkibag"){
	$up_user = array();
	$up_user['is_user_login'] = 0;
	$co->query_update('users', $up_user, array('uid'=>$_COOKIE['uid']), 'uid=:uid');
}elseif(isset($_SESSION['uid']) && isset($_SESSION['website']) && $_SESSION['website']=="Linkibag"){			
	$up_user = array();
	$up_user['is_user_login'] = 0;
	$co->query_update('users', $up_user, array('uid'=>$_SESSION['uid']), 'uid=:uid');
}
setcookie('uid', '', time()-172800);
setcookie('website', '', time()-172800);
unset($_SESSION['uid']);
unset($_SESSION['website']);	
unset($_SESSION['num_of_times']);
unset($_SESSION['num_of_times_group']);
echo '<script type="text/javascript">window.location.href="index.php"</script>';
?> 