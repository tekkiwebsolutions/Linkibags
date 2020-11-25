<?php
date_default_timezone_set("EST");
class commonClass extends DB
{
	protected $self = array();
	
	public function __get( /*string*/ $name = null ) 
	{
		return $this->self[$name];
	}
	function generate_verifycode($length = 8, $uid){
	  	$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
				'0123456789!()_[]{}|';
	
	  	$str = 'verify';
	  	$max = strlen($chars) - 1;
	
	  	for ($i=0; $i < $length; $i++)
			$str .= $chars[rand(0, $max)];
		$str .= $uid;
	  	$max = strlen($chars) - 1;
	
	  	for ($i=0; $i < $length; $i++)
			$str .= $chars[rand(0, $max)];
			
		$check_path = $this->query_first("SELECT * FROM `users` WHERE verify_code='$str'", array());
		if(isset($check_path['uid']) and $check_path['uid']>0)
			$this->generate_verifycode(8, $uid);
	
	  	return $str;
	}
	function setmessage($type="status", $message = NULL)
	{
		if ($message) {
			if (!isset($_SESSION['messages'][$type])) {
			  $_SESSION['messages'][$type] = array();
			}		
			if (!in_array($message, $_SESSION['messages'][$type])) {
			  $_SESSION['messages'][$type][] = $message;
			}
		}		
		// Messages not set when DB connection fails.
		return isset($_SESSION['messages']) ? $_SESSION['messages'] : NULL;
	}
	function getmessage($type = NULL, $clear_queue = TRUE)
	{
		if ($messages = $this->setmessage()) {
			if ($type) {
				if ($clear_queue) {
					unset($_SESSION['messages'][$type]);
			  	}
			  	if (isset($messages[$type])) {
					return array($type => $messages[$type]);
			  	}
			}
			else {
				if ($clear_queue) {
					unset($_SESSION['messages']);
				}
			  	return $messages;
			}
		}
		return array();
	}
	function theme_messages() {
	  $output = '';
	
	  $status_heading = array(
		'status' => 'alert-success', 
		'error' => 'alert-danger', 
		'warning' => 'alert-warning',
	  );
	  foreach ($this->getmessage() as $type => $messages) {
		$output .= "<div class=\"alert $status_heading[$type]\">\n
		";
		if (count($messages) > 1) {
		  $output .= " <ul>\n";
		  foreach ($messages as $message) {
			$output .= '  <li>' . $message . "</li>\n";
		  }
		  $output .= " </ul>\n";
		}
		else {
		  $output .= $messages[0];
		}
		
		$output .= "</div>\n";
	  }
	  return $output;
	}
	function adminlogin($username, $pwd, $remember=0)
	{
		$username = strip_tags($username);
		$pwd = strip_tags($pwd);
		$sql = "SELECT * FROM `admin` WHERE `username`= :user and `decrypt_pass` = :pass LIMIT 1";
		$pwd = md5($pwd);		
		$row= $this->row($sql, array("user"=>$username, "pass"=>$pwd));
		
		if(isset($row['uid']) and $row['uid']>0)
		{
			if($remember==1){
				setcookie('admin_uid', $row['uid'], strtotime('+1 days'));
				setcookie('admin_website', 'Linkibag admin', strtotime('+1 days'));
			}else{
				$_SESSION['admin_uid'] = $row['uid'];
				$_SESSION['admin_website'] = 'Linkibag admin';
			}
			return true;
		}else{
			return false;
		}
	}
	function user_reset_password($username){
		$sql = "SELECT * FROM `users` WHERE `username`= :user and status=:status and verified=:verified LIMIT 1";
		$row= $this->row($sql, array("user"=>$username, "status"=>1, "verified"=>1));
		
		if(isset($row['uid']) and $row['uid']>0)
		{
			$up_user = array();
			$reset_code = $this->generate_password(35);
			$up_user['reset_code'] = $reset_code;
			$up_user['reset_request'] = 1;
			$up_user['reset_time'] = time();
			$this->query_update('users', $up_user, array('uid'=>$row['uid']), 'uid=:uid');
			unset($up_user);
			$to = $row['username'];
			$subject = 'Password request at '.SITE_NAME;
			$verified_link = WEB_ROOT.'index.php?p=change_pass&user='.$row['uid'].'&pv='.$reset_code;
			$message = '
Dear<br /><br />
<p>Hello, You are requesting for password at '.SITE_NAME.'. <br />
You can update your password by clicking this link or copying and pasting it to your browser:</p> 
'.$verified_link.'<br /><br />

Cheers<br />
Team '.SITE_NAME;
			$from = ' Linkibag.com';
			$this->send_email($to, $subject, $message, $from);
			return true;
		}else{
			return false;
		}
	}
	function is_emailExists($em)
	{
		$sql = "SELECT * FROM `admin` WHERE `username`= :user";
		$row= $this->row($sql, array("user"=>$em));
		
		if(isset($row['uid']) and $row['uid']>0){
			return true;
		}else{
			return false;
		}
	}
	function is_emailExists_edit($em, $id)
	{
		$sql = "SELECT * FROM `admin` WHERE `username`= :user AND uid != :uid";
		$row= $this->row($sql, array("user"=>$em, "uid"=>$id));
		
		if(isset($row['uid']) and $row['uid']>0){
			return true;
		}else{
			return false;
		}
	}
	function is_adminlogin()
	{
		if(isset($_COOKIE['admin_uid']) && isset($_COOKIE['admin_website']) && $_COOKIE['admin_website']=="Linkibag admin")
		{
			return true;
		}
		elseif(isset($_SESSION['admin_uid']) && isset($_SESSION['admin_website']) && $_SESSION['admin_website']=="Linkibag admin")
		{			
			return true;
		}
		else
		{
			return false;
		}
	}
	function getcurrent_admin()
	{
		if(isset($_COOKIE['admin_uid']) && isset($_COOKIE['admin_website']) && $_COOKIE['admin_website']=="Linkibag admin")
		{
			$sql = "SELECT * FROM `admin` WHERE uid= :user";
			$row= $this->row($sql, array("user"=>$_COOKIE['admin_uid']));
			return $row;
		}
		elseif(isset($_SESSION['admin_uid']) && isset($_SESSION['admin_website']) && $_SESSION['admin_website']=="Linkibag admin")
		{			
			$sql = "SELECT * FROM `admin` WHERE uid= :user";
			$row= $this->row($sql, array("user"=>$_SESSION['admin_uid']));
			return $row;
		}
		else
		{
			return false;
		}
	}
	
	function generate_password($length = 8){
	  	$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
				'0123456789-=~!@#$%^&*_+/[]{}\|';
	
	  	$str = '';
	  	$max = strlen($chars) - 1;
	
	  	for ($i=0; $i < $length; $i++)
			$str .= $chars[rand(0, $max)];
	
	  	return $str;
	}
	function send_email($to, $subject, $msg)
	{
		// To send HTML mail, the Content-type header must be set
		$from = 'info@mwsdemo.in';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		// Additional headers
		$headers .= 'From: '. $from . "\r\n";
		
		// Mail it
		mail($to, $subject, $msg, $headers);
		
		$this->save_email_alert($to, $subject, $msg);
	}
	function save_email_alert($to, $subject, $msg){
		$chk_user = $this->query_first("SELECT * FROM `users` WHERE `email_id`=:em", array('em'=>$to));
		if(isset($chk_user['uid']) and $chk_user['uid']>0){
			$new_alert = array();
			$new_alert['uid'] = $chk_user['uid'];
			$new_alert['from_email'] = $to;
			$new_alert['subject'] = $subject;
			$new_alert['matter'] = $msg;
			$new_alert['created'] = time();
			$this->query_insert('email_alert', $new_alert);
			unset($new_alert);
		}
	}
	function getPagingQuery($sql, $itemPerPage = 10)
	{
		if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
		$page = (int)$_GET['page'];
		} else {
		$page = 1;
		}
	
		// start fetching from this row number
		$offset = ($page - 1) * $itemPerPage;
		
		return $sql . " LIMIT $offset, $itemPerPage";
	}
	function getPagingLinks($sql, $data, $itemPerPage = 10, $strGet = '')
	{
		$result = $this->fetch_all_array($sql, $data);
		$pagingLink = '';
		//$totalResults = mysql_num_rows($result);
		$totalResults = count($this->column($sql,$data));
		//echo count($result);
		//print_r($totalResults);
		$totalPages = ceil($totalResults / $itemPerPage);

		// how many link pages to show
		$numLinks = 10;


		// create the paging links only if we have more than one page of results
		if ($totalPages > 1) {

		$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ;
		$self = 'main.php';

		if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
		$pageNumber = (int)$_GET['page'];
		} else {
		$pageNumber = 1;
		}

		// print 'previous' link only if we're not
		// on page one
		if ($pageNumber > 1) {
		$page = $pageNumber - 1;
		if ($page > 1) {
		$prev = "<li><a href=\"$self?page=$page&$strGet\">Prev</a></li>";
		} else {
		$prev = "<li><a href=\"$self?page=$page&$strGet\">Prev</a></li>";
		}

		$first = "<li><a href=\"$self?page=1&$strGet\">First</a></li>";
		} else {
		$prev = ''; // we're on page one, don't show 'previous' link
		$first = ''; // nor 'first page' link
		}

		// print 'next' link only if we're not
		// on the last page
		if ($pageNumber < $totalPages) {
		$page = $pageNumber + 1;
		$next = "<li><a href=\"$self?page=$page&$strGet\">Next</a></li>";
		$last = "<li><a href=\"$self?page=$totalPages&$strGet\">Last</a></li>";
		} else {
		$next = ''; // we're on the last page, don't show 'next' link
		$last = ''; // nor 'last page' link
		}

		$start = $pageNumber - ($pageNumber % $numLinks) + 1;
		$end = $start + $numLinks - 1;

		$end = min($totalPages, $end);

		$pagingLink = array();
		for($page = $start; $page <= $end; $page++) {
		if ($page == $pageNumber) {
		$pagingLink[] = "<li class=\"active\"><a href=\"$self?page=$page&$strGet\">$page</a></li>"; // no need to create a link to current page
		} else {
		if ($page == 1) {
		$pagingLink[] = "<li><a href=\"$self?page=$page&$strGet\">$page</a></li>";
		} else {
		$pagingLink[] = "<li><a href=\"$self?page=$page&$strGet\">$page</a></li>";
		}
		}

		}

		$pagingLink = implode(' ', $pagingLink);

		// return the page navigation link
		$pagingLink = $first . $prev . $pagingLink . $next . $last;
		}

		return $pagingLink;
	}
	
	
	function resize_crop_image($filein,$fileout,$imagethumbsize_w,$imagethumbsize_h)
	{
		// Get new dimensions"255","255","255"
		$red="255";
		$green="255";
		$blue="255";
		$percent = 1;	
		list($width, $height) = getimagesize($filein);
		$new_width = $width * $percent;
		$new_height = $height * $percent;
		if(preg_match("/.jpg/i", "$filein"))
  		{
  		    $format = 'image/jpeg';
  		}
  		if (preg_match("/.gif/i", "$filein"))
  		{
  		    $format = 'image/gif';
  		}
  		if(preg_match("/.png/i", "$filein"))
  		{
  		    $format = 'image/png';
  		}
 
	      	switch($format)
      		{
      		    case 'image/jpeg':
      		    	$image = imagecreatefromjpeg($filein);
      		    	break;
      		    case 'image/gif';
      		    	$image = imagecreatefromgif($filein);
      		    	break;
      		    case 'image/png':
      		    	$image = imagecreatefrompng($filein);
      		    	break;
      		}
		$width = $imagethumbsize_w ;
		$height = $imagethumbsize_h ;
		list($width_orig, $height_orig) = getimagesize($filein);
		if ($width_orig < $height_orig) {
 			$height = ($imagethumbsize_w / $width_orig) * $height_orig;
		} else {
   			$width = ($imagethumbsize_h / $height_orig) * $width_orig;
		}
		if ($width < $imagethumbsize_w)
		//if the width is smaller than supplied thumbnail size
		{
    			$width = $imagethumbsize_w;
    			$height = ($imagethumbsize_w/ $width_orig) * $height_orig;;
		}
		if ($height < $imagethumbsize_h)
		//if the height is smaller than supplied thumbnail size
		{
    			$height = $imagethumbsize_h;
    			$width = ($imagethumbsize_h / $height_orig) * $width_orig;
		}
		$thumb = imagecreatetruecolor($width , $height); 
		$bgcolor = imagecolorallocate($thumb, $red, $green, $blue);  
		ImageFilledRectangle($thumb, 0, 0, $width, $height, $bgcolor);

		imagefilledrectangle($thumb, 0, 0, $width, $height, $bgcolor);
		imagealphablending($thumb, true);
		imagecopyresampled($thumb, $image, 0, 0, 0, 0,$width, $height, $width_orig, $height_orig);
		$thumb2 = imagecreatetruecolor($imagethumbsize_w , $imagethumbsize_h);
		// true color for best quality
		$bgcolor = imagecolorallocate($thumb2, $red, $green, $blue);

		ImageFilledRectangle($thumb2, 0, 0,$imagethumbsize_w , $imagethumbsize_h , $bgcolor);
		
		imagefilledrectangle($thumb2, 0, 0,$imagethumbsize_w , $imagethumbsize_h , $bgcolor);
		imagealphablending($thumb2, true);
		$w1 =($width/2) - ($imagethumbsize_w/2);
		$h1 = ($height/2) - ($imagethumbsize_h/2);
		imagecopyresampled($thumb2, $thumb, 0,0, 0, 0,$imagethumbsize_w , $imagethumbsize_h ,$imagethumbsize_w, $imagethumbsize_h);
		// Output
		//header('Content-type: image/gif');
		//imagegif($thumb); //output to browser first image when testing
		//if ($fileout !="")
		
		//imagegif($thumb2, $fileout); //write to file
		//header('Content-type: image/gif');
		//imagegif($thumb2); //output to browser
		//echo '<br>Thumb2 : '.$thumb2.'<br>';
		//chmod($fileout,0777);
		switch($format)
		{
			case 'image/jpeg':
				imagejpeg($thumb2,$fileout);
				break;
			case 'image/gif';
				imagegif($thumb2,$fileout);
				break;
			case 'image/png':
				imagepng($thumb2,$fileout);
				break;
		}

	}
	
	function resize_exact_image($filein,$fileout,$imagethumbsize_w,$imagethumbsize_h)
	{
		// Get new dimensions"255","255","255"
		$red="255";
		$green="255";
		$blue="255";
		if(preg_match("/.jpg/i", "$filein"))
  		{
  		    $format = 'image/jpeg';
  		}
  		if (preg_match("/.gif/i", "$filein"))
  		{
  		    $format = 'image/gif';
  		}
  		if(preg_match("/.png/i", "$filein"))
  		{
  		    $format = 'image/png';
  		}
 
		switch($format)
		{
			case 'image/jpeg':
				$image = imagecreatefromjpeg($filein);
				break;
			case 'image/gif';
				$image = imagecreatefromgif($filein);
				break;
			case 'image/png':
				$image = imagecreatefrompng($filein);
				break;
		}
		$width = $imagethumbsize_w ;
		$height = $imagethumbsize_h ;
		list($width_orig, $height_orig) = getimagesize($filein);
		if ($width_orig < $height_orig) {
			$height = ($imagethumbsize_w / $width_orig) * $height_orig;
			if($height > $imagethumbsize_h){
				$height = $imagethumbsize_h;
				$width = ($imagethumbsize_h / $height_orig) * $width_orig;
			}
		} else {
			$width = ($imagethumbsize_h / $height_orig) * $width_orig;
			if($width > $imagethumbsize_w){
				$width = $imagethumbsize_w;
				$height = ($imagethumbsize_w / $width_orig) * $height_orig;
			}
		}
		
		$dst_x = 0;
		$dst_y = 0;
		if($width < $imagethumbsize_w){
			$dst_x = ceil(($imagethumbsize_w-$width)/2);
		}	
		if($height < $imagethumbsize_h){
			$dst_y = ceil(($imagethumbsize_w-$height)/2);
		}
		
		
		$thumb2 = imagecreatetruecolor($imagethumbsize_w , $imagethumbsize_h);
		$white = imagecolorallocate($thumb2, 255, 255, 255);
		imagefill($thumb2, 0, 0, $white);
		imagecopyresampled($thumb2, $image, $dst_x, $dst_y, 0, 0, $width, $height , $width_orig, $height_orig);
		// Output
		//header('Content-type: image/gif');
		//imagegif($thumb); //output to browser first image when testing
		//if ($fileout !="")
		
		//imagegif($thumb2, $fileout); //write to file
		//header('Content-type: image/gif');
		//imagegif($thumb2); //output to browser
		//echo '<br>Thumb2 : '.$thumb2.'<br>';
		//chmod($fileout,0777);
		switch($format)
		{
			case 'image/jpeg':
				imagejpeg($thumb2,$fileout);
				break;
			case 'image/gif';
				imagegif($thumb2,$fileout);
				break;
			case 'image/png':
				imagepng($thumb2,$fileout);
				break;
		}

	}
	
	function resize_image($filein,$fileout,$imagethumbsize_w,$imagethumbsize_h)
	{
		// Get new dimensions"255","255","255"
		$red="255";
		$green="255";
		$blue="255";
		if(preg_match("/.jpg/i", "$filein"))
  		{
  		    $format = 'image/jpeg';
  		}
  		if (preg_match("/.gif/i", "$filein"))
  		{
  		    $format = 'image/gif';
  		}
  		if(preg_match("/.png/i", "$filein"))
  		{
  		    $format = 'image/png';
  		}
 
	      	switch($format)
      		{
      		    case 'image/jpeg':
      		    	$image = imagecreatefromjpeg($filein);
      		    	break;
      		    case 'image/gif':
      		    	$image = imagecreatefromgif($filein);
      		    	break;
      		    case 'image/png':
      		    	$image = imagecreatefrompng($filein);
      		    	break;
      		}
		$width = $imagethumbsize_w ;
		$height = $imagethumbsize_h ;
		list($width_orig, $height_orig) = getimagesize($filein);
		if ($width_orig < $height_orig) {
 			$height = ($imagethumbsize_w / $width_orig) * $height_orig;
		} else {
   			$width = ($imagethumbsize_h / $height_orig) * $width_orig;
		}
		if ($width < $imagethumbsize_w)
		//if the width is smaller than supplied thumbnail size
		{
    			$width = $imagethumbsize_w;
    			$height = ($imagethumbsize_w/ $width_orig) * $height_orig;;
		}
		if ($height < $imagethumbsize_h)
		//if the height is smaller than supplied thumbnail size
		{
    			$height = $imagethumbsize_h;
    			$width = ($imagethumbsize_h / $height_orig) * $width_orig;
		}
		$thumb2 = imagecreatetruecolor($width , $height);
		imagealphablending( $thumb2, false );
		imagesavealpha( $thumb2, true );
		imagecopyresampled($thumb2, $image, 0 ,0, 0, 0, $width, $height , $width_orig, $height_orig);
		// Output
		//header('Content-type: image/gif');
		//imagegif($thumb); //output to browser first image when testing
		//if ($fileout !="")
		
		//imagegif($thumb2, $fileout); //write to file
		//header('Content-type: image/gif');
		//imagegif($thumb2); //output to browser
		//echo '<br>Thumb2 : '.$thumb2.'<br>';
		//chmod($fileout,0777);
		switch($format)
		{
			case 'image/jpeg':
				imagejpeg($thumb2,$fileout, 100);
				break;
			case 'image/gif';
				imagegif($thumb2,$fileout);
				break;
			case 'image/png':
				imagepng($thumb2,$fileout,9);
				break;
		}

	}
	/*
	function uploadimage($photos_uploaded, $dest_path, $resize='yes', $width, $height)
	{
		// List of our known photo types
    		$known_photo_types = array(
                        		'image/pjpeg' => 'jpg',
                        		'image/jpeg' => 'jpg',
                        		'image/gif' => 'gif',
                        		'image/bmp' => 'bmp',
                        		'image/x-png' => 'png',
								'image/png' => 'png'
                    	);
   
    		// GD Function List
    		$gd_function_suffix = array(
                        		'image/pjpeg' => 'JPEG',
                        		'image/jpeg' => 'JPEG',
                        		'image/gif' => 'GIF',
                        		'image/bmp' => 'WBMP',
                        		'image/x-png' => 'PNG'
								
                    	);

    		if(!array_key_exists($photos_uploaded['type'], $known_photo_types))
    		{
        			return false;
    		}
    		else
    		{
				move_uploaded_file($photos_uploaded["tmp_name"], $dest_path);
				if($resize=='yes'){
					$this->resize_image($dest_path,$dest_path,$width,$height);
				}
				return true;
    		}    
	}
	*/

		function uploadimage($photos_uploaded, $entity_field, $resize='yes', $width, $height)



	{

		$images_thumbnails = array();

		// List of our known photo types



    		$known_photo_types = array(



                        		'image/pjpeg' => 'jpg',



                        		'image/jpeg' => 'jpg',



                        		'image/gif' => 'gif',



                        		'image/bmp' => 'bmp',



                        		'image/x-png' => 'png',



								'image/png' => 'png'



                    	);



   



    		// GD Function List



    		$gd_function_suffix = array(



                        		'image/pjpeg' => 'JPEG',



                        		'image/jpeg' => 'JPEG',



                        		'image/gif' => 'GIF',



                        		'image/bmp' => 'WBMP',



                        		'image/x-png' => 'PNG'



								



                    	);







    		if(!array_key_exists($photos_uploaded['type'], $known_photo_types))



    		{



        			return false;



    		}



    		else



    		{



    			if(file_exists('../files/')){

    				if(!file_exists('../files/'.$entity_field)){

	    				

    					mkdir('../files/'.$entity_field);



						mkdir('../files/'.$entity_field.'');	



					}

					$directory_path = '../files/'.$entity_field;

					$substring_required = 'yes';	

    			}else{

					if(!file_exists('files/'.$entity_field)){



    					mkdir('files/'.$entity_field);



						mkdir('files/'.$entity_field.'');



    				}

    				$directory_path = 'files/'.$entity_field;	    				

    				$substring_required = 'no';

    			}	



    			

				$thumb_val = array();



    			$original_path = $this->chk_filename($directory_path.'/', $photos_uploaded['name']);



				move_uploaded_file($photos_uploaded["tmp_name"], $original_path);



				if($substring_required == 'no')

					$thumb_val['original'] = $original_path;

				else

					$thumb_val['original'] = substr($original_path, 3);


				return $thumb_val['original'];

				

				/*$this->resize_image($dest_path,$dest_path,$width,$height);*/



					$thumbnails = $this->image_thumbnails();



					if(count($thumbnails)>0){



						foreach($thumbnails as $thumbnail){



							if(!file_exists($directory_path.'/'.$thumbnail['name']))



								mkdir($directory_path.'/'.$thumbnail['name']);



								



							$dest_path = $this->chk_filename($directory_path.'/'.$thumbnail['name'].'/', $photos_uploaded['name']);



							if($thumbnail['style']=='resize'){



								$this->resize_image($original_path,$dest_path,$thumbnail['width'],$thumbnail['height']);



							}elseif($thumbnail['style']=='resize_exact'){



								$this->resize_exact_image($original_path,$dest_path,$thumbnail['width'],$thumbnail['height']);



							}elseif($thumbnail['style']=='resize_crop'){



								$this->resize_crop_image($original_path,$dest_path,$thumbnail['width'],$thumbnail['height']);



							}



							if($substring_required == 'no')

								$thumb_val[$thumbnail['name']] = $dest_path;

							else

								$thumb_val[$thumbnail['name']] = substr($dest_path, 3);



						}



						$images_thumbnails['img_thumbnails'] = serialize($thumb_val);



					}



				



				return $images_thumbnails;



    		}    



	}
	function uploadfile($file_uploaded, $dest_path)
	{
		// List of our known photo types
    		$known_file_types = array(
							'image/pjpeg' => 'jpg',
							'image/jpeg' => 'jpg',
							'image/gif' => 'gif',
							'image/bmp' => 'bmp',
							'image/x-png' => 'png',
							'image/png' => 'png',
							'application/msword' => 'doc',
							'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'doc',
							'application/pdf' => 'pdf',
							'application/mspowerpoint' => 'ppt',
							'application/powerpoint' => 'ppt',
							'application/x-mspowerpoint' => 'pptx',
							'application/excel' => 'xls',
							'application/x-excel' => 'xlsx',
							'application/x-msexcel' => 'xlsx',
							'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xls',							
                    	);
			$known_file_ext = array('doc'=>'doc', 'docx'=>'doc', 'pdf'=>'pdf', 'ppt'=>'ppt', 'pptx'=>'pptx', 'xls'=>'xls', 'xlsx'=>'xlsx', 'jpg'=>'jpg', 'png'=>'png', 'bmp'=>'bmp', 'gif'=>'gif', 'html'=>'html', 'htm'=>'htm');
			$path_parts = pathinfo($file_uploaded['name']);
			if(!array_key_exists($path_parts['extension'], $known_file_ext))
			{
				$this->setmessage("error", "DOC, PDF, PPT, XLS, IMAGE file can only be uploaded");
				return false;
			}
			else
			{
				move_uploaded_file($file_uploaded["tmp_name"], $dest_path);
				return true;
			}
	}
	
	function image_thumbnails(){
		$arr = array(array('name'=>'thumbnail', 'width'=>187, 'height'=>122, 'style'=>'resize_exact'),
			array('name'=>'medium', 'width'=>600, 'height'=>600, 'style'=>'resize_exact'),
			array('name'=>'premium_image', 'width'=>800, 'height'=>450, 'style'=>'resize_exact')
		);
		return $arr;
	}
	
	function upload_multiple_images($photos, $title, $desc, $entity_id, $entity_field, $img_id){
		// List of our known photo types
		$known_photo_types = array(
							'image/pjpeg' => 'jpg',
							'image/jpeg' => 'jpg',
							'image/gif' => 'gif',
							'image/bmp' => 'bmp',
							'image/x-png' => 'png',
							'image/png' => 'png'
					);
		$n = 0;
		$total_imgs = count($img_id);
		if(!file_exists('../files/'.$entity_field)){
			mkdir('../files/'.$entity_field);
			mkdir('../files/'.$entity_field.'/original');
		}
		for($i=0;$i<$total_imgs;$i++){
			if($img_id[$i]==0){
				if($photos["tmp_name"][$n]!=""){
					if(array_key_exists($photos['type'][$n], $known_photo_types)){
						//upload original file
						$original_path = $this->chk_filename('../files/'.$entity_field.'/original/', $photos['name'][$n]);
						move_uploaded_file($photos["tmp_name"][$n], $original_path);
						//set variable to insert into DB	
						$new_val = array();
						$new_val['entity_id'] = $entity_id;
						$new_val['entity_field'] = $entity_field;
						$new_val['img_name'] = $photos['name'][$n];
						if(isset($title[$i]))
							$new_val['img_title'] = $title[$i];
						if(isset($desc[$i]))
							$new_val['img_desc'] = $desc[$i];
						$new_val['img_original'] = substr($original_path, 3);
						$new_val['img_delta'] = $i;
						
						//generate thumbnail and make one array to store all thumbnails to db
						$thumbnails = $this->image_thumbnails();
						if(count($thumbnails)>0){
							$thumb_val = array();
							foreach($thumbnails as $thumbnail){
								if(!file_exists('../files/'.$entity_field.'/'.$thumbnail['name']))
									mkdir('../files/'.$entity_field.'/'.$thumbnail['name']);
									
								$dest_path = $this->chk_filename('../files/'.$entity_field.'/'.$thumbnail['name'].'/', $photos['name'][$n]);
								if($thumbnail['style']=='resize'){
									$this->resize_image($original_path,$dest_path,$thumbnail['width'],$thumbnail['height']);
								}elseif($thumbnail['style']=='resize_exact'){
									$this->resize_exact_image($original_path,$dest_path,$thumbnail['width'],$thumbnail['height']);
								}elseif($thumbnail['style']=='resize_crop'){
									$this->resize_crop_image($original_path,$dest_path,$thumbnail['width'],$thumbnail['height']);
								}
								$thumb_val[$thumbnail['name']] = substr($dest_path, 3);
							}
							$new_val['img_thumbnails'] = serialize($thumb_val);
						}
						$this->query_insert($entity_field, $new_val);
						unset($new_val);
					}
					$n++;
				}
			}
			elseif($img_id[$i]>0){
				$up_val = array();
				if(isset($title[$i]))
					$up_val['img_title'] = $title[$i];
				if(isset($desc[$i]))
					$up_val['img_desc'] = $desc[$i];
				$up_val['img_delta'] = $i;
				$this->query_update($entity_field, $up_val, array('id'=>$img_id[$i]), 'img_id=:id');
				unset($up_val);
			}
		}
	}
	
	function chk_filename($folder, $file_name, $num = 0){		
		if($num>0){
			$filename = pathinfo($file_name, PATHINFO_FILENAME).'-'.($num-1).'.'.pathinfo($file_name, PATHINFO_EXTENSION);
		}else{
			$filename = $file_name;
		}
		if(file_exists($folder.$filename)){
			$filename = pathinfo($file_name, PATHINFO_FILENAME).'-'.$num.'.'.pathinfo($file_name, PATHINFO_EXTENSION);
			if(file_exists($folder.$filename)){
				$filepath = $this->chk_filename($folder, $file_name, ($num+1));			
			}else{
				$filepath = $folder.$filename;
			}
		}else{
			$filepath = $folder.$filename;
		}
		return $filepath;
	}
	
	function load_user($uid){
		$sql = "SELECT * FROM `users` u 		
		LEFT JOIN `profile` p ON p.uid=u.uid 
		WHERE u.uid= :user";
		$row= $this->row($sql, array("user"=>$uid));
		return $row;		
	}
	
	function mail_format($type, $var){
		$mail_content = array();
		switch($type){
			case 'status_change_mail':				
				$mail_content['subject'] = 'Your ad status changed at Linkibag.com';
				$mail_content['matter'] = 'Hello, <br /><br />Your following ad status has been changed to '.$var['new_status_text'].' by admin of linkibag.com<br /><br />Title: '.$var['title'].'<br /><br />Thanks<br />Linkibag Team';
				return $mail_content;
				break;
			case 'farmtalk_status_change_mail':				
				$mail_content['subject'] = 'Your topic status changed at Linkibag.com';
				$mail_content['matter'] = 'Hello, <br /><br />Your following topic status has been changed to '.$var['new_status_text'].' by admin of linkibag.com<br /><br />Title: '.$var['title'].'<br /><br />Thanks<br />Linkibag Team';
				return $mail_content;
				break;
			case 'banner_status_change_mail':				
				$mail_content['subject'] = 'Your Banner Ad status changed at Linkibag.com';
				$mail_content['matter'] = 'Hello, <br /><br />Your Banner status has been changed to '.$var['new_status_text'].' by admin of linkibag.com<br /><br />Thanks<br />Linkibag Team';
				return $mail_content;
				break;
		}
	}
		
	function show_all_category(){

		$sql = "SELECT * FROM `category`";

		$row = $this->fetch_all_array($sql, array());

		return $row;

	}
	function is_userExists_edit($u, $id)


	{


		$sql = "SELECT * FROM `users` WHERE `email_id`= :user AND uid != :uid";


		$row= $this->row($sql, array("user"=>$u, "uid"=>$id));


		


		if(isset($row['uid']) and $row['uid']>0){


			return true;


		}else{


			return false;


		}


	}


	function is_mobileExists_edit($u, $id)


	{


		$sql = "SELECT * FROM `users` WHERE `mobile`= :user AND uid != :uid";


		$row= $this->row($sql, array("user"=>$u, "uid"=>$id));


		


		if(isset($row['uid']) and $row['uid']>0){


			return true;


		}else{


			return false;


		}


	}
		
}

?>