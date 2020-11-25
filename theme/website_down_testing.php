<?php  
function page_access(){	
	global $co, $msg;      	
	$user_login = $co->is_userlogin();      	
	if(!$user_login){   
		echo '<script language="javascript">window.location="index.php";</script>';      		
		exit();      
	}          
}      
function page_content(){      
	global $co, $msg;      	
	$no_record_found='';      	
	$co->page_title = "Find Friends | LinkiBag";     
 	$current = $co->getcurrentuser_profile();  	
	
	/*
	$file = 'https://www.snapdeal.com/page/about-us';
	$file_headers = @get_headers($file);
	print_r ($file_headers);
	if(!$file_headers || $file_headers[0] != 'HTTP/1.0 200 OK') {
	    echo 'false';
	}
	else {
	    echo 'true';
	}
	*/
		$body = '';
		$result = $co->fetch_all_array("select url_value from user_urls ORDER BY url_id DESC LIMIT 0, 2",array());
		foreach($result as $list){
			if (!preg_match("~^(?:f|ht)tps?://~i", $list['url_value'])) {
				$list['url_value'] = "http://" . $list['url_value'];
			}
			$file = $list['url_value'];
			$file_headers = @get_headers($file);
			//print_r ($file_headers);
			if(!$file_headers || $file_headers[0] != 'HTTP/1.0 200 OK') {
			    $wrong_url = ' style="color: red;"';
			}
			else {
			    $wrong_url = '';
			}
			$body .= '<tr'.$wrong_url.'><td>'.$list['url_value'].'</td></tr>'; 

		}
		$body2 = '';
		/*
		$result = $co->fetch_all_array("select url_value from user_urls ORDER BY url_id DESC LIMIT 10, 10",array());
		foreach($result as $list){
			if (!preg_match("~^(?:f|ht)tps?://~i", $list['url_value'])) {
				$list['url_value'] = "http://" . $list['url_value'];
			}
			$file = $list['url_value'];
			$file_headers = @get_headers($file);
			//print_r ($file_headers);
			if(!$file_headers || $file_headers[0] != 'HTTP/1.0 200 OK') {
			    $wrong_url = ' style="color: red;"';
			}
			else {
			    $wrong_url = '';
			}
			$body2 .= '<tr'.$wrong_url.'><td>'.$list['url_value'].'</td></tr>'; 

		}
		*/
		
	      	
?>


		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<table class="table table-bordered">
						<thead>
							<tr>
								<td>URL</td>
							</tr>	
						</thead>
						<tbody>
							<?=$body?>
						</tbody>		
					</table>	
				</div>
				<div class="col-md-6">
					<?php
					/*
					<table class="table table-bordered">
						<thead>
							<tr>
								<td>URL</td>
							</tr>	
						</thead>
						<tbody>
							<?=$body2?>
						</tbody>		
					</table>	
					*/ ?>
				</div>
				
			</div>
			
		</div>
	



<?php		  } ?>      
