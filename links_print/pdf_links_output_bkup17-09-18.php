<?php
$i=1;  
$j=1;  
$tim = time();
$url_value_text = '';
$url_desc_text = '';
$share_number = '';
$share_by = '';
$time_exp = time();
foreach($_GET['url'] as $share_urls){	
	$urlpost = $co->query_first("SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,us.*  FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_url_id=:urlid",array('urlid'=>$share_urls));
	
	$share_number = $urlpost['share_number'];
	$time_exp = $urlpost['shared_time'];
	$share_by = $urlpost['email_id'];
	$parsed = parse_url($urlpost['url_value']);
	if (empty($parsed['scheme'])) {
		$urlpost['url_value'] = 'http://' . ltrim($urlpost['url_value'], '/');
	}
	
	
	/*$url_value_text .= '
		<a href="'.$urlpost['url_value'].'" target="_blank">'.((strlen($urlpost['url_value']) > 20) ? substr($urlpost['url_value'], 0, 30).'...' : $urlpost['url_value']).'</a> <br/>';*/
	$url_value_text .= 
		((strlen($urlpost['url_value']) > 20) ? substr($urlpost['url_value'], 0, 30).'...' : $urlpost['url_value']).'<br/>';		
	$url_desc_text .= ((strlen($urlpost['url_desc']) > 30) ? substr($urlpost['url_desc'], 0, 30).'...' : $urlpost['url_desc']).'<br/>';	
		
}


?>



	<div class="header-top">

		<img src="../images/main-logo.jpg" />

	</div>

	
<div class="pdf-body">


		<div style="margin-left:55px;margin-bottom:12px;"><h1 class="pdf-title">Link Share Report</h1></div>
		
		<table id="all_records_serialize">
			<tr>
				<td>
					Date/time:
				</td>
				<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
				<td>
					<?=date("m/d/Y h:ia T", $time_exp)?>			
				</td>			
			</tr>
			<tr>
				<td>
					Link(s):
				</td>
				<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
				<td>
					<?=$url_value_text?>			
				</td>			
			</tr>
			<tr>
				<td>
					Message:
				</td>
				<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
				<td>
					<?=$url_desc_text?>			
				</td>			
			</tr>
			<tr>
				<td>
					Share ID:
				</td>
				<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
				<td>
					<?=$share_number?>			
				</td>			
			</tr>
			<tr>
				<td>
					Expiring:
				</td>
				<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
				<td>
					<?=date('M d, Y h:ia T', ($time_exp + 1800))?>			
				</td>			
			</tr>			
			<tr>
				<td>
					Shared By:
				</td>
				<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
				<td>
					<?=$share_by?>			
				</td>			
			</tr>
		</table>



	
	</div>

<style>

.header-top{
	text-align: center;
	padding: 15px;
	background: #31496a;
	font-family: arial;
	margin-bottom: 20px;
}
.pdf-title{
	text-align: left;
	/*color: #31496a;*/
	color: #000;
	font-family: arial;
	font-size: 15px;
	margin-bottom: 20px;	
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
}
.pdf-body thead tr th{
	background: #31496a none repeat scroll 0 0;
	color: #fff;
}
.second_row {
    background: #dbdbdb none repeat scroll 0 0;
}
</style>
