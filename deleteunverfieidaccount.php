<?php
include('config/web-config.php');
include('config/DB.class.php');
include('classes/common.class.php');
include('classes/user.class.php');
$co = new userClass();
$co->__construct();

$tim = time() - (2.5 * 60 * 60);

$co->query_delete('users', array('verified'=>0, 'created'=>$tim),'verified=:verified and created<:created');
?>