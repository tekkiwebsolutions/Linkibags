<?php

if(isset($_GET['id'])){
	$linkibook = $co->query_first("SELECT * FROM `linkibooks` WHERE id=:id", array('id'=>$_GET['id']));
	$linkiurls = $co->fetch_all_array("SELECT * FROM `linkibook_urls` WHERE linkibook_id=:id", array('id'=>$_GET['id']));

	$title = $linkibook['book_title'];
	$subtitle = $linkibook['book_subtitle'];
	$linkibook_table = '';
	foreach ($linkiurls as $url) {
		$urlpost = $co->query_first("SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,us.*  FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_url_id=:urlid",array('urlid'=>$url['url_id']));
		$linkibook_table .= '<tr><td><a href="#">'.$urlpost['url_value'].'</a>
                           <p>'.$urlpost['url_desc'].'</p>'.(!empty($url['url_title']) ? '<p>'.$url['url_title'].'</p>' : '').(!empty($url['url_subtitle']) ? '<p>'.$url['url_subtitle'].'</p>' : '').'</td></tr>';
	}
}else{
	$title = $_GET['book_title'];
	$subtitle = $_GET['book_subtitle'];
	$linkibook_table = '';
	foreach ($_GET['url'] as $url) {
		$urlpost = $co->query_first("SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,us.*  FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_url_id=:urlid",array('urlid'=>$url));
		$subtitle_textbox = 'subtitle_'.$url;
		$text_textbox = 'text_'.$url;
		$linkibook_table .= '<tr><td><a href="#">'.$urlpost['url_value'].'</a>
                           <p>'.$urlpost['url_desc'].'</p>'.(!empty($_GET[$text_textbox]) ? '<p>'.$_GET[$text_textbox].'</p>' : '').(!empty($_GET[$subtitle_textbox]) ? '<p>'.$_GET[$subtitle_textbox].'</p>' : '').'</td></tr>';
	}
}

?>



	<div class="header-top">

		<img src="../images/email-logo/linkibag-logo.png" />

	</div>

	
<div class="pdf-body">

		<div style="margin-left:55px;margin-bottom:12px;color:#31496a;">
			<h1><?=$title?></h1>
			<h3><?=$subtitle?></h3>
		</div>
		
		<table id="all_records_serialize">
			<?=$linkibook_table?>
		</table>

	</div>

<style>

.header-top{
	text-align: center;
	padding: 15px;
	/*background: #31496a;*/
	font-family: arial;
	margin-bottom: 20px;
}
h1.pdf-title{
	text-align: left;
	font-weight:bold;
	color:#31496a;
	font-family: arial;
	font-size: 24px;
	line-height: 34px;	
	font-weight: 400;
}
h2.pdf-subtitle {
	font-size: 16px;
	line-height: 20px;	
	font-weight: 400;
}
.pdf-body table{
	/*table-layout:auto !important;
	margin: auto;*/
	margin-left: 50px;
	font-family: arial;

}
.pdf-body table th, .pdf-body table td{
	padding: 6px 6px;
	font-size: 14px;
	font-family: arial;
	text-align: left;
}
.pdf-body a{
	color: #31496a;
	font-family: arial;
	text-decoration: none;
}
.pdf-body a:hover{
	background-color: #fff;
	color: #fff;
}
.pdf-body thead tr th{
	background: #31496a none repeat scroll 0 0;
	color: #fff;
}
.second_row {
    background: #dbdbdb none repeat scroll 0 0;
}
</style>
