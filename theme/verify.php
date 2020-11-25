<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Confirm Email | LinkiBag";
	
	//if(!isset($inc))
	//	exit();
	if($co->is_userlogin()){ 
		$co->setmessage("error", "Sorry! you already login at LinkiBag, Please try to verify email to another browser Or logout this account for verify email");
		echo '<script language="javascript">window.location="index.php?p=dashboard";</script>';
		exit();
	}
	if(isset($_GET['not_requested']) && $_GET['not_requested']==1){
		$up = array();
		$up['verified'] = 1;
		$up['status'] = 0;
		$up['verified_time'] = time();
		$co->query_update('users', $up, array('id'=>$_GET['user']), 'uid=:id');
		unset($up); 				
		echo '<div class="text-center"><h1>Thank You for Confirmation.</h1><a class="btn btn-primary" href="'.WEB_ROOT.'">OK</a></div>';
	} else if(isset($_GET['user']) and isset($_GET['v'])){
		$chk_verfied = $co->query_first("SELECT email_id,pass,uid FROM `users` WHERE uid=:uid and `verify_code`=:code and verified=0", array('uid'=>$_GET['user'], 'code'=>$_GET['v']));	
		if(isset($chk_verfied['uid']) and $chk_verfied['uid']>0){
			$up = array();
			$up['verified'] = 1;
			$up['verified_time'] = time();
			$co->query_update('users', $up, array('id'=>$chk_verfied['uid']), 'uid=:id');
			unset($up);

			$inserted_rows_in_db = 0;
			$getsharedurls = $co->fetch_all_array("SELECT us.shared_url_id FROM `user_shared_urls` us INNER JOIN `user_urls` ur ON ur.url_id=us.url_id WHERE us.shared_to=:email",array('email'=>$chk_verfied['email_id']));
			if(isset($getsharedurls) and count($getsharedurls) > 0){
				foreach($getsharedurls as $geturl){
					$up = array();
					$up['shared_to'] = $chk_verfied['uid'];
					$co->query_update('user_shared_urls', $up, array('id'=>$geturl['shared_url_id']), 'shared_url_id=:id');
					unset($up);	
					$inserted_rows_in_db++;
				}
			}
			

			if($co->userlogin($chk_verfied['email_id'],$chk_verfied['pass'],'0')){
				$msg_store = "Congratulations your email address has been confirmed and your account is now activated. <br/>";

				/* for select urls from view share page*/

				if(isset($_SESSION['selected_urls_from_view_share_page']) and count($_SESSION['selected_urls_from_view_share_page']) > 0){
					$pattern_1 = "/(?:http|https)?(?:\:\/\/)?(?:www.)?(([A-Za-z0-9-]+\.)*[A-Za-z0-9-]+\.[A-Za-z]+)(?:\/.*)?/im";
					$urls = $_SESSION['selected_urls_from_view_share_page'];
					$inserted_rows_in_db = 0;
					foreach($urls as $val){
						$get_url = $co->query_first("SELECT us.*,ur.* FROM `user_shared_urls` us INNER JOIN `user_urls` ur ON ur.url_id=us.url_id WHERE us.shared_url_id=:id",array('id'=>$val));
						$url = $get_url['url_value'];
						if(!preg_match($pattern_1, $url)){			
							$msg_store .= "$url webpage is not valid URL. So it was not added to your Inbag <br/>";
							$success=false;
						}else{
							if(!preg_match("~^(?:f|ht)tps?://~i", $url)) {
								$url = "http://" . $url;
							}
							

							$url_headers = @get_headers($url);
							if(strpos($url_headers[0],'200')===false) {
							    $msg_store .= "$url webpage is not available. So it was not added to your Inbag <br/>";
								$success=false;
							}else{
								//virus total
								$ch = curl_init();

								$timeout = 0; // set to zero for no timeout	

								$myHITurl = "https://www.virustotal.com/vtapi/v2/url/report?apikey=e85cac3f3f8fe3d0dc8163c63a89b1ecfa26231aef16ab8d26f2326b62434ead&resource=".$url;

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
								//end code
								if($file_contents['response_code'] != 1){
									$msg_store .= "$url webpage has virus. So it was not added to your Inbag <br/>";
									$success=false;
								}else{
									$inserted_rows_in_db++;
									$up = array();
									$up['url_title'] = 'test';
									$up['url_value'] = $url;
									
									//$up['url_cat'] = serialize($category_id);
									//$up['url_cat'] = $get_url['url_cat'];
									$up['url_cat'] = -2;
									$up['url_desc'] = $get_url['url_desc'];
									//$up['status'] = $get_url['status'];
									$up['status'] = 1;
									//$up['share_type'] = $get_url['share_type'];
									//$up['public_cat'] = $get_url['public_cat'];
									//for pending approval
									//$up['add_to_search_page'] = $get_url['add_to_search_page'];
									//$up['search_page_status'] = $get_url['search_page_status'];
								
									$up['ip_address'] = $get_url['ip_address'];
												
									//$up['is_video_link'] = $get_url['is_video_link'];
									//$up['video_id'] = $get_url['video_id'];
									//$up['video_web'] = $get_url['video_web'];
									//$up['video_embed_code'] = $get_url['video_embed_code'];
									
									$up['uid'] = $chk_verfied['uid'];
									$up['created_time'] = time();
									$up['updated_time'] = time();
									$up['created_date'] = date('Y-m-d');
									$up['updated_date'] = date('Y-m-d');
									//$up['permalink'] = $get_url['permalink'];
									//$up['scan_id'] = $get_url['scan_id'];
									//$up['total_scans'] = $get_url['total_scans'];	

									$inserted_url = $co->query_insert('user_urls', $up);
									unset($up);


									$new_val = array();
									$new_val['uid'] = $chk_verfied['uid'];
									$new_val['shared_to'] = $chk_verfied['uid'];
									$new_val['url_id'] = $inserted_url;
									$new_val['url_cat'] = -2;
									//$new_val['url_cat'] = $up['url_cat'];
									$new_val['shared_time'] = time();
									$co->query_insert('user_shared_urls', $new_val);
									unset($new_val);
								}	
							}
						}							
					}
					
					unset($_SESSION['selected_urls_from_view_share_page']);
				}
				if($inserted_rows_in_db > 0)
						$msg_store .= "Selected URLs are added to your inbag successfully <br/>";
				/* end code*/	
				$co->setmessage("status", $msg_store);
				if(isset($_GET['request_id']) and $_GET['request_id'] > 0 and $_GET['request_code'] and $_GET['request_code'] != '' and $_GET['accept'] and $_GET['accept'] != ''){
					echo '<script language="javascript">window.location="index.php?p=friend_request&request_id='.$_GET['request_id'].'&request_code='.$_GET['request_code'].'&accept='.$_GET['accept'].'";</script>';
				}else{		
					echo '<script language="javascript">window.location="index.php?p=dashboard";</script>';
				}	
				exit();
				
			}		
		}else{ 
			echo '<div class="text-center"><h1>Thank You for Confirmation.</h1><a class="btn btn-primary" href="'.WEB_ROOT.'">OK</a></div>';
		}
	}else{
		echo '<div class="text-center"><h1>This page has expired</h1><a class="btn btn-primary" href="'.WEB_ROOT.'">OK</a></div>';
	}
	
?>

<style type="text/css">
.btn-primary {
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
}
.btn {
	display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
.text-center {
    text-align: center;
}

</style>

<?php 
	exit();
} ?>