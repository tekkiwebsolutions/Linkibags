<?php
include('../config/web-config.php');
include('../config/DB.class.php');
include('../classes/common.class.php');
include('../classes/user.class.php');
$co = new userClass();
$co->__construct();



$c = setcookie( "FirstTimer", 1, strtotime( '+1 year' ) );
$cc = $_COOKIE["FirstTimer"];
echo json_encode(array('success'=>$cc));		
exit();	

	// if(isset($_POST['uuid']) and $_POST['uuid']!=''){
	// 	$uuid =  $_POST['uuid'];
    //     $co->query_update('profile', array('disclaimer'=>('1')), array('id'=>$uuid), 'uid=:id');
    //     echo json_encode(array('success'=>1));		
    //     exit();						
    //                 		}
			

?>
