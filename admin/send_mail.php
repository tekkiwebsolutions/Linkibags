<?php
$breadcrumb = 'Send Email';
$title = '<i class="fa fa-table"></i>Send Email ';
if(isset($_POST['save'])){	
	$success=true;
	
	if ($success == true) {
		$up = array();
		$title = $_POST['title'];
		$msg = $_POST['message'];
	//	$users = ($_POST['users']);
// 		 foreach($users as $key)
// 			{
// 			$keys=$key;
// 			}
			//$emails = implode(",",$users);
			$emails='';
			$countries = $co->fetch_all_array("select uid,email_id from users WHERE status=:id  ORDER BY uid ASC", array('id'=>1));

						foreach($countries as $country){
						$emails.=$country['email_id'].',';	    
						}
		
			$to = $emails;
			$subject = $title;
			$message ='<div style="margin: 0; padding: 0; min-width: 100%!important;" bgcolor="#ffffff">
                    <table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
                        <tr><td><table style="color: #3e3e3e;font-family: arial;max-width: 600px;text-align: center;width: 100%;" align="center" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td style="text-align: left; padding: 30px 0px 40px;">
                                            <img src="https://www.linkibag.com/images/email-logo/linkibag-logo.png"><br><p style="font-size: 14px !important;margin-top: 20px;"></p>
                                        </td>
                                    </tr>
            						<tr>
                                        <td>
                                            <h1 style="margin: 0;font-size: 25px">'.$title.'</h1>
            								<h2 style="font-size: 22px;font-weight: normal;padding: 11px 0px 0px;line-height: 33px;margin-top: 0px;">'.$msg.'</h2>
            							</td>
                                    </tr>
            						<tr>
                                        <td>
                                            <p style="padding: 0px 0px 4px;"><a style="color: #7F7F95 !important;font-size: 14px;" href="'.(WEB_ROOT.'about-us').'">About Linkibag</a> &nbsp; | &nbsp;  <a style="color: #7F7F95 !important;font-size: 14px;" href="'.(WEB_ROOT.'page/terms').'">Terms of Use</a> &nbsp; | &nbsp;  <a style="color: #7F7F95 !important;font-size: 14px;" href="'.(WEB_ROOT.'page/policy').'">Privacy Policy</a></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><p style="font-size: 14px !important;line-height: 25px;color: #000 !important;">
                                You are getting this email because this email address is connected to your Linkibag account.<br />Visit your <a href="'.WEB_ROOT.'index.php?p=account_settings">account page</a> to manage your settings.<br />

                                <a style="color: #004080; font-weight: bold;" href="'.WEB_ROOT.'">LinkiBag Inc.</a> 8926 N. Greenwood Ave, #220, Niles, IL 60714

                                </p>
                                           
                                        </td>
                                    </tr>
                                </table>
                        </td></tr>
                    </table>
                </div>';
			// To send HTML mail, the Content-type header must be set
		$from = '"LinkiBag" <noreply@linkibag.com>';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		// Additional headers
		$headers .= 'From: '. $from . "\r\n";
	
		
		mail($to, $subject, $message, $headers);
			
			
		//$co->send_admin_email($title,$users,$message);
		//unset($up);
		$co->setmessage("status", "Email sent successfully to ".$emails);
		echo '<script type="text/javascript">window.location.href="main.php?p=send_mail"</script>';
		exit();
	}
}


$row = $co->query_first("SELECT * from users WHERE status=:id",array('id'=>1));



?>
			<form class="form-horizontal" method="post">
			  
		
				<!--<div class="form-group">-->
				    
				<!--	<label class="col-sm-2 control-label">User Selection</label>                            -->
				<!--	<div class="col-sm-10">-->
				<!--		<select class="form-control" name="users[]" multiple="multiple">-->
						<?php
						//$countries = $co->fetch_all_array("select uid,email_id from users WHERE status=:id  ORDER BY uid ASC", array('id'=>1));-->

					//	foreach($countries as $country){-->
						

						//	echo '<option value="'.$country['email_id'].'"'.$sel.'>'.$country['email_id'].'</option>';-->
					//	}	-->
						?>
				<!--		</select>-->
				<!--	</div>-->
				<!--</div>-->
				<div class="form-group">
					<label class="col-sm-2 control-label">Title</label>                            
					<div class="col-sm-10">
					<input type="text" class="form-control " name="title">
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Message</label>                            
					<div class="col-sm-10">
					<textarea class="form-control ckeditor" name="message"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4 col-sm-offset-2">
						 <button type="submit"  name="save" value="Save" class="btn btn-primary">Send</button>
					</div>
				</div>
			</form>
    <?php

	?>
