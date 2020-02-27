<?php


include('config/web-config.php');


include('config/DB.class.php');


include('classes/common.class.php');


include('classes/user.class.php');


$co = new userClass();


$co->__construct();





$include = 'yes';
$user_login = $co->is_userlogin();  
if($user_login){
	$current = $co->getcurrentuser_profile();
	if(!isset($_POST['ajax']) and !isset($_POST['type']))
	exit();
}	




	

$groups_members =  array();
if(isset($_POST['groups_members']))
	$groups_members = $_POST['groups_members'];
$co->edit_groups_and_cat($current['uid'], '0', $_POST['type'], 'add',$_POST['page'],$groups_members);


?>


