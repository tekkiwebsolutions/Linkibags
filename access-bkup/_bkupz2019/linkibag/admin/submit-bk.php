<?php
$co = new commonClass();
$co->__construct();

if($_SERVER['REQUEST_METHOD']=='POST')

{

	$postdata = $_POST;
	//print_r($postdata);

	if(isset($_POST['form_id']) and $_POST['form_id']=="password_change"){
		$new_val = array();
		$new_val['password'] = $postdata['password'];

		$new_val['decrypt_pass'] = md5($postdata['password']);
		$co->query_update('admin', $new_val, array('id'=>1), 'uid=:id');
			unset($new_val);
		$co->setmessage("status", "Password updated successfully");

	}

}

?>