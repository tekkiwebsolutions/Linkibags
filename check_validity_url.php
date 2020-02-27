<?php
include('config/web-config.php');
include('config/DB.class.php');
include('classes/common.class.php');
include('classes/user.class.php');
$co = new userClass();
$co->__construct();

if($co->url_valid('https://www.yandex.ru/')){
	echo 'Url valid';
}else{
	echo 'Url invalid';
}

echo '<hr>';

$file_headers = @get_headers('https://www.yandex.ru/');
print_r($file_headers);

echo '<hr>';

if($co->urlExists('https://www.mi.com/in/mi-a1/')){
	echo 'Url valid';
}else{
	echo 'Url invalid';
}


