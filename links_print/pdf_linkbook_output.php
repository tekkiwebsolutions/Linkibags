<?php

if(isset($_GET['id'])){
	$linkibook = $co->query_first("SELECT * FROM `linkibooks` WHERE id=:id", array('id'=>$_GET['id']));
	$linkiurls = $co->fetch_all_array("SELECT * FROM `linkibook_urls` WHERE linkibook_id=:id", array('id'=>$_GET['id']));

	$title = $linkibook['book_title'];
	$subtitle = $linkibook['book_subtitle'];
	$linkibook_table = '';
    
	foreach ($linkiurls as $url) {
		$urlpost = $co->query_first("SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,ur.created_date,us.*  FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_url_id=:urlid",array('urlid'=>$url['url_id']));
		$linkibook_table .= '<tr><td>'.$x.' <a href="#">'.$urlpost['url_value'].'</a>
                           <p>'.wordwrap($urlpost['url_desc'], 60, "\n", true).'</p>'.(!empty($url['url_title']) ? '<p>'.$url['url_title'].'</p>' : '').(!empty($url['url_subtitle']) ? '<p>'.$url['url_subtitle'].'</p>' : '').'</td></tr>';
	}
}else{
	$title = $_GET['book_title'];
	$subtitle = $_GET['book_subtitle'];
	$linkibook_table = '';
	$i=0;
	foreach ($_GET['url'] as $url) {
	    $i++;
		$urlpost = $co->query_first("SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,ur.created_date,us.*  FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_url_id=:urlid",array('urlid'=>$url));
		$subtitle_textbox = 'subtitle_'.$url;
		$text_textbox = 'text_'.$url;
		$linkibook_table .= '<tr><td>'.$i.'. <a href="#">'.$urlpost['url_value'].'</a>
                           <p>'.wordwrap($urlpost['url_desc'], 60, "\n", true).'</p>'.(!empty($_GET[$text_textbox]) ? '<p>'.$_GET[$text_textbox].'</p>' : '').(!empty($_GET[$subtitle_textbox]) ? '<p>'.$_GET[$subtitle_textbox].'</p>' : '').'</td></tr>';
	}
}



?>

 <style>
     
     @page {
    @bottom-left {
        content: string('');
    }
}
 </style>

<div class='container'>
    <div class='roww'>
            <div class="top_powered" style='margin-left:10px'>
     <!--      <img src="../images/email-logo/small_logo.jpg" />-->
	    <!--<span class='date_public' style=" margin-bottom: 5px;">Published on <?php echo date('m/d/Y',strtotime($urlpost['created_date']))?></span>-->
</div>
   <div class='content_area' >
      <h2><?=$title?></h2>
       <h5><?=$subtitle?></h5>
   </div> 
<div class='bottom_txt'>
    <img src='../images/email-logo/bag_logo.png'>
    <p>Powered by LinkiBag.com</p>
   
</div>
<!--<div class='bottom_title'>-->
<!--    <p>Page - 1</p>-->
<!--      <div class='right_title'><h2><?=$title?></h2>-->
<!--       <h5><?=$subtitle?></h5>-->
<!--       </div>-->
<!--   </div> -->
	
</div>
</div>
<div class='container'>
<div class='roww'>
<div class='content_area' style="margin-bottom:80px;">
    
 	<table id="all_records_serialize" style="text-align:center;letter-spacing: 2px;">
 	  <!--  <tr>-->
 	  <!--  <td><h6>I. Information Security</h6></td>-->
 	  <!--  </tr>-->
 	  <!--  <tr>-->
 	  <!--      <td>1. <a href='https://www.google.com' target=_blank>https://www.google.com </a>-->
 	  <!--      <p>Worldwide search engines providing free information search, email and many other services. I recommend to visit this website.</p> </td>-->
 	  <!--  </tr>-->
 	  <!--<tr>-->
 	  <!--      <td>2. <a href='https://www.google.com' target=_blank>https://www.google.com </a>-->
 	  <!--      <p>Worldwide search engines providing free information search, email and many other services. I recommend to visit this website.</p> </td>-->
 	  <!--  </tr>-->
 	  <!--  <tr>-->
 	  <!--      <td>3. <a href='https://www.google.com' target=_blank>https://www.google.com </a>-->
 	  <!--      <p>Worldwide search engines providing free information search, email and many other services. I recommend to visit this website.</p> </td>-->
 	  <!--  </tr>-->
 	  <!--  <tr>-->
 	  <!--      <td>4. <a href='https://www.google.com' target=_blank>https://www.google.com </a>-->
 	  <!--      <p>Worldwide search engines providing free information search, email and many other services. I recommend to visit this website.</p> </td>-->
 	  <!--  </tr>-->
 	  <!--  <tr>-->
 	  <!--      <td>-->
    <!--      <p style='width: auto;-->
    <!--font-size: 12px;-->
    <!--font-weight: 100;float:left;-->
    <!--font-family: arial;-->
    <!--margin: 0px;-->
    <!--color: #5f5f5f;'>My New Book wrote is from October 20, 2020 </p></td>-->
    <!-- <td><p style='width: 100px;-->
    <!--font-size: 12px;position: relative;-->
    <!--float:right;-->
    <!--font-weight: 100;-->
    <!--font-family: arial;position: absolute;-->
    <!--right: 0;-->
    <!--top: -14px;-->
    <!--margin: 0px;-->
    <!--color: #5f5f5f;'>Page - 1</p>-->
 	  <!--      </td>-->
 	  <!--  </tr>-->
 	  <!--  <tr>-->
 	  <!--  <td><h6>II. More Information Security</h6></td>-->
 	  <!--  </tr>-->
 	  <!--  <tr>-->
 	  <!--      <td>1. <a href='https://www.google.com' target=_blank>https://www.google.com</a>-->
 	  <!--      <p>Worldwide search engines providing free information search, email and many other services. I recommend to visit this website. </p></td>-->
 	  <!--  </tr>-->
 	  <!--   <tr>-->
 	  <!--      <td>2. <a href='https://astronomy.com' target=_blank>https://astronomy.com</a>-->
 	  <!--      <p>Latest UFO news. This is crazy. Read it guys. Let us discuss it in todays class. I recommend to visit this website and keep checking news from this portal. It is a great place to visit Daily.</p></td>-->
 	  <!--  </tr>-->
 	  <!--  <tr>-->
 	  <!--      <td>3. <a href='#' target=_blank> https://www.google.com </a>-->
 	  <!--      <p>Worldwide search engines providing free information search, email and many other services. I recommend to visit this website.</p></td>-->
 	  <!--  </tr>-->
 	  <!--  <tr>-->
 	  <!--      <td>4. <a href='https://astronomy.com/news/2020/10/reports-of-rising-ufo-sightingsare-greatly-exaggerated' target=_blank>https://astronomy.com/news </a>-->
 	  <!--      <p>Latest UFO news. This is crazy. Read it guys. Let us discuss it in today's class. I recommend to visit this website and keep checking news from this portal. It is a great place to visit Daily.</p></td>-->
 	  <!--  </tr>-->
 	  <!--  <tr>-->
 	  <!--      <td>-->
    <!--      <p style='width: auto;-->
    <!--font-size: 12px;-->
    <!--font-weight: 100;float:left;-->
    <!--font-family: arial;-->
    <!--margin: 0px;-->
    <!--color: #5f5f5f;'>My New Book wrote is from October 20, 2020 </p></td>-->
    <!-- <td><p style='width: 100px;-->
    <!--font-size: 12px;position: relative;-->
    <!--float:right;-->
    <!--font-weight: 100;-->
    <!--font-family: arial;position: absolute;-->
    <!--right: 0px;-->
    <!--top: -14px;-->
    <!--margin: 0px;-->
    <!--color: #5f5f5f;'>Page - 2</p>-->
 	  <!--      </td>-->
 	  <!--  </tr>-->
      <tr>
 	    <td><h6>I. Information Security</h6></td>
 	    </tr>
 	  
			<?=$linkibook_table?>
			
		</table>
		

</div>
<!--<div class='bottom_title' style='display:none !important'>-->
<!--    <p style='display:none !important;font-size: 0;'>Page - 3</p>-->
      <!--<div class='right_title'><h2><?=$title?></h2>-->
      <!-- <h5><?=$subtitle?></h5>-->
      <!-- </div>-->
<!--      <div class='right_title'>-->
          <!--<h5>My New Book wrote is from October 20, 2020 </h5>-->
<!--      </div>-->
<!--   </div>-->
</div>
  </div>  
<style>

    
.content_area h6 {
    font-family: arial;
    text-align: center;
    color: #000;
    line-height: 1.2;
    font-size: 18px;
    text-transform: capitalize;
    letter-spacing: 0.5px;
}

#all_records_serialize tr td{
text-align:left;position:relative;height:75px;
    vertical-align: middle; width:550px;
}
#all_records_serialize tr td h6{
margin-top: 0;
    padding-top: 0;
}
#all_records_serialize tr td a{font-size:15px;}
#all_records_serialize tr td p{font-size:15px;font-weight:bold;margin-top:5px;margin-left:12px;line-height:1.4;}
.bottom_txt img {
    width: 45px;position:relative;left:80px;
}
.bottom_title{position:relative;padding-top:5px;}
.bottom_title .right_title {
    position: absolute;
    left: 0;
    top: 15px;
}
.bottom_title .right_title h2, .bottom_title .right_title h5{
    width: auto;
    font-size: 12px;font-weight:100;
    font-family: arial;margin:0px;
    color: #9e9e9e;
}
.bottom_title p {
    position: absolute;
    right: 0;
    top: 0;
}
.bottom_title p{
    font-size: 12px;
    font-family: arial;
    color: #9e9e9e;
    }
.bottom_txt p {
       width: auto;
    font-size: 14px;
    font-family: arial;
    color: #9e9e9e;
    text-align: center;
    font-weight: bold;
}
.bottom_txt {
    text-align: center;
    padding-top:470px
}
.powered_img_div {
    display: inline-block;
    width: 100%;margin-left: -2.5px;
}
span.date_public {
      width: auto;
    font-size: 12px;
    font-family: arial;
    color: #9e9e9e;
    position: relative;
    left: 155px;
    display: table
}
.content_area{
    margin: 20px auto;
    float: none;
    width: 100%;
    position: relative;
}
.content_area ul li{
    list-style: none;
    margin-bottom: 20px;
}
.content_area ul{
padding-left: 20%;
}
.content_area ul li a {
    text-decoration: none;
    font-size: 18px;
}
.content_area ul li span {
    font-size: 15px;
    font-family: arial;
    color: #31496a;
    font-weight: bold;
    display: inline-block;
    width: 100%;
    margin-top: 5px;
}
.roww {
   width:50%;
    margin: 30px auto;
    position:relative;
left: 60px;
}
.content_area h5 {
 font-size: 20px;
    font-family: arial;
    width: 100%;
    display: inline-block;
    font-weight: bold;
    margin: 0;
    text-align: center;
    margin-top: 50px;
    color: #3c3c3c;
}
.content_area h2 {
    font-family: arial;
   text-align:center;
    color: #31496a;
    line-height: 1.4;font-size:28px;text-transform:capitalize;
    letter-spacing: 0.5px;margin-top:250px;
}
.container {
    width: 1170px;
    margin: 0 auto;
}
   
</style>

<!--	<div class="header-top">-->

	

<!--	</div>-->

	
<!--<div class="pdf-body">-->

<!--		<div style="margin-left:55px;margin-bottom:12px;color:#31496a;">-->
<!--			<h1><?=$title?></h1>-->
<!--			<h3><?=$subtitle?></h3>-->
<!--		</div>-->
		
<!--		<table id="all_records_serialize">-->
<!--			<?=$linkibook_table?>-->
<!--		</table>-->

<!--	</div>-->
<!--	<div class="footer_powered">-->
<!-- <span class="footer_powered_txt"> Powered By:</span> -->
<!--  <img src="../images/email-logo/linkibag-logo.png" />-->
<!--</div>-->


	
<style>
#all_records_serialize{
    position: relative;
    left: 0px
}

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
    text-align:center;
	font-size: 16px;
	line-height: 20px;	
	font-weight: 400;
}
.pdf-body table{
	/*table-layout:auto !important;
	margin: auto;*/
	margin-left: 0px;
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
