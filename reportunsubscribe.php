<?php
include('config/web-config.php');
include('config/DB.class.php');
include('classes/common.class.php');
include('classes/user.class.php');
$co = new userClass();
$co->__construct();

if($co->is_userlogin()){
	header("location:index.php?p=account_settings");
}elseif(isset($_GET['email'])){
	if($co->is_emailExists($_GET['email'])){
		$checkemail = $co->query_first("SELECT * FROM `unsubscribe` WHERE mail_id=:email", array('email'=>$_GET['email']));
		if(!isset($checkemail['us_id'])){
			$tim = time();
			$co->query_insert('unsubscribe', array('mail_id'=>$_GET['email'], 'status'=>1, 'created'=>$tim));
		}
	}
}
?>
<script type="text/javascript">
	alert("You will no longer receive any email notifications from LinkiBag or it's users.");
	window.close();
</script>