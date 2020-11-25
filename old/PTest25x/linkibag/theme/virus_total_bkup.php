<?php
function page_content(){
global $co, $msg;
$co->page_title = "Web Resources Library | LinkiBag";
$current = $co->getcurrentuser_profile();  	

$ch = curl_init();

$timeout = 0; // set to zero for no timeout	

$myHITurl = "https://www.virustotal.com/vtapi/v2/url/report?apikey=8e6a84d54bc1d473138d806c2b7946b96f28d82d2b8c489a94c62c690235feda&resource=youtube.com";

curl_setopt ($ch, CURLOPT_URL, $myHITurl);

curl_setopt ($ch, CURLOPT_HEADER, 0);

curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

$file_contents = curl_exec($ch);

$curl_error = curl_errno($ch);

curl_close($ch);

//dump output of api if you want during test

//echo "$file_contents";

// lets extract data from output for display to user and for updating databse

$file_contents = (json_decode($file_contents, true));

print_r ($file_contents);
	   
?>


<?php
   }
   
   ?>

