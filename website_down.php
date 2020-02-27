<?php
$file = 'colorstrade123.com/';
	if (!preg_match("~^(?:f|ht)tps?://~i", $file)) {
		$file = "http://" . $file;
		echo 'jimmy';
	}			
	echo $file;
	$file_headers = @get_headers($file);
	print_r ($file_headers);
	if(strpos($file_headers[0],'200')===false) {
	    echo 'false';
	}
	else {
	    echo 'true';
	}

?>