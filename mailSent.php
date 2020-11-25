<?php 
$current['email_id'] ='fkravets@usa.net';
$to='navdeep.tws@gmail.com';
$current['first_name']='Felix';
$current['last_name']='Kravets';
$current['email_id']='fkravets@usa.net';
$verified_links='';
$_SESSION['share_number']='545454554'; 		
$subject="New links shared by Felix Kravets on LinkiBag";
$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n".'<title>LinkiBag Invitation</title>'."\n".'
<style type="text/css">
@import url("https://fonts.googleapis.com/css?family=Lora");body{margin:0;padding:0;min-width:100%!important}
.content p{color:#3e3e3e}
.content p a{color:#3e3e3e;text-decoration:none}
</style>
'."\n".'</head>'."\n".'<body bgcolor="#ffffff">'."\n".'
<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
'."\n".'
<tr>'."\n".'
	<td>'."\n".'
	<table style="margin: auto !important; color:#3e3e3e; font-family:arial; max-width:650px; width:100%" align="center" cellpadding="0" cellspacing="0" border="0">'."\n".'
		<tr>'."\n".'
			<td style="text-align:left;padding:30px 0 20px">'."\n".'<img src="https://linkibag.com/images/email-logo/linkibag-logo.png">'."\n".'<br>'."\n".'
				<p style="font-size:14px;margin-top:20px">
					This message was sent by user '.$current['email_id'].',
				<p>'."\n".'
			</td>'."\n".'
		</tr>'."\n".'
		<tr>'."\n".'
			<td>'."\n".'
				<h1 style="text-align:left;font-family:arial;margin:0;font-size:18px;line-height:30px;color:#353e4f">
					LinkiBag user '.$current['first_name'].' '.$current['last_name'].' ('.$current['email_id'].') would like to share some web links with you using LinkiBag share services: 
				</h1> '."\n".' 
				<p style="float: left;">
					<span style="font-size: 13px;font-weight: normal;color:#F1576E;width: 100%;float:left;border: 1px solid #F1576E;padding: 5px;"> 
						For your safety we do not recommend to view any links shared by unknown users or if you do not expect this user to share any web links with you at this time. 
					</span>
				</p> '."\n".' 
				<h1 style="text-align:left;font-family:arial;width: 100%;float: left;font-size:18px;color:#009494;">
					There are two ways to view shared links: 
				</h1>
					
					<p class="big">
						<div>
							<h1 style="text-align:left;font-family:arial;width: 100%;float: left;font-size:19px;">
								1. Click link bellow:
							</h1>
							<span style="width:100%;float:left;">
								<button style="background: #009494 none repeat scroll 0 0 !important;display: inline-block;padding: 6px 12px;margin-bottom: 0;font-size: 14px;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;touch-action: manipulation;cursor: pointer;-webkit-user-select: none;user-select: none;border: 1px solid transparent;">
									<a style="text-decoration: none;color:#fff;text-align:left;" href="'.$verified_links.'"> View Shared Links </a>
								</button> 
							</span>  
						</div>
						<br><br> 
						<span style="font-size: 13px;font-weight: bold;margin-top: 12px;float: left;">
							<h1 style="text-align:left;font-family:arial;width: 100%;float: left;font-size:19px;">
								2. Enter Share ID bellow in the Share ID box on <a href="https://www.linkibag.com/" style="color: #3e3e3e;text-decoration: none;">LinkiBag.com</a> webpage.
							</h1> 
						</span>
						<div style="font-size: 12px;font-weight: normal;float: left;"> 							 
							<input style="background: #fff none repeat scroll 0 0 !important;display: inline-block;padding: 6px 12px;margin-bottom: 0;font-size: 14px;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;touch-action: manipulation;cursor: pointer;-webkit-user-select: none;user-select: none;border: 2px solid #009494 ;color:#009494 ;text-align:left;text-align: center;width: 120px;" id="copyTarget" value="'.$_SESSION['share_number'].'" readonly > 
							<a href="https://www.linkibag.com/copy-to-clipboard.php?share-id='.$_SESSION['share_number'].'">	 
							<span style="color:#009494 ;font-size: 15px;margin-left: 10px;" id="copyButton" >Copy1</span>
							</a>
						</div> 
						<div style="font-size: 17px;font-weight: bold;margin-top: 15px;float: left;width: 100%;">
							Save shared links. Get your free LinkiBag account. Click <a style="color: #009494;" href="FUNCTION" >here</a> to register.
						</div>
					</p>'."\n".' 
			</td>'."\n".'
		</tr>'."\n".'
		<tr>'."\n".'
			<td>'."\n".'
			</td>'."\n".'
		</tr>'."\n".'
		
		<tr style="text-align: center;">'."\n".'
			<td>'."\n".'
				<p style="padding:15px 0 5px;">'."\n".'
					<a style="color:#7F7F95!important;font-size:14px;text-decoration: none;" href="https://www.linkibag.com/index.php?p=about_us">
						About LinkiBag &nbsp; | &nbsp;
					</a>'."\n".'
					<a style="color:#7F7F95!important;font-size:14px;text-decoration: none" href="https://www.linkibag.com/index.php?p=pages&id=8">
						Terms of Use &nbsp; | &nbsp; 
					</a>'."\n".' 
					<a style="color:#7F7F95!important;font-size:14px;text-decoration: none;" href="https://www.linkibag.com/index.php?p=pages&id=9">
						Privacy Policy
					</a>'."\n".'
				</p>'."\n".'
				<p style="font-size:14px;line-height:15px;color:#000!important">'."\n".'
					You are getting this email because this email address is connected to your LinkiBag account
				</p>
				<p style="font-size:14px;line-height:15px;color:#000!important">'."\n".'
					Visit your <a href="https://www.linkibag.com/index.php?p=account_settings" style="color:#000;" >account page</a> to manage your setting.
				</p>
				<p style="font-size:14px;line-height:15px;color:#000!important">'."\n".'
					<a href="https://www.linkibag.com" style="color:#000;">LinkiBag Inc.</a> 
					8926 N. Greenwood Ave, #220, Niles, IL 60714 
				</p> 
			</td>'."\n".'
		</tr>'."\n".'
	</table>'."\n".'
</td>'."\n".'
</tr>'."\n".'
</table>'."\n".'
</body>'."\n".'

</html>';

 
 
    //$from = 'info@linkibag.com';
     $from = 'info@linkibooks.com';

 

    $headers .= "Reply-To: LinkiBag <".$from.">\r\n"; 
    $headers .= "Return-Path: LinkiBag <".$from.">\r\n"; 
    $headers .= "From: ".$from." \r\n" .
    $headers .= "Organization: LinkiBag\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
    
if(mail($to, $subject, $message, $headers)){
    $send ='Send';
} else{
    $send ='Not Send';
}
echo $send;

?>