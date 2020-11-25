<?php
class commonClass extends DB
{
	protected $self = array();
	
	public function __get( /*string*/ $name = null ) 
	{
		return $this->self[$name];
	}

	function kv_read_word($input_file){	
	 	$kv_strip_texts = ''; 
        $kv_texts = ''; 	
		if(!$input_file || !file_exists($input_file)) return false;
		
		$zip = zip_open($input_file);
		
		if (!$zip || is_numeric($zip)) return false;
	
		while ($zip_entry = zip_read($zip)) {
			
			if (zip_entry_open($zip, $zip_entry) == FALSE) continue;
			
			if (zip_entry_name($zip_entry) != "word/document.xml") continue;

			$kv_texts .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
			
			zip_entry_close($zip_entry);
		}
	
		zip_close($zip);
		
		$kv_texts = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $kv_texts);
		$kv_texts = str_replace('</w:r></w:p>', "\r\n", $kv_texts);
		$kv_strip_texts = nl2br(strip_tags($kv_texts,""));

		return str_replace(array("<br />", "\r"), '', $kv_strip_texts);
	}

	function get_txt_content($input_file){
		$file = fopen($input_file,"r");
		return fgets($file);
	}

	function rtftotext($input_file){
		$this->text = file_get_contents($input_file);
		if (!strlen($this->text)) {
			return "BAD FILE";
		}
		// we'll try to fix up the parts of the rtf as best we can
		// clean up the file a little to simplify parsing
		$this->text=str_replace("\r",' ',$this->text); // returns
		$this->text=str_replace("\n",' ',$this->text); // new lines
		$this->text=str_replace('  ',' ',$this->text); // double spaces
		$this->text=str_replace('  ',' ',$this->text); // double spaces
		$this->text=str_replace('  ',' ',$this->text); // double spaces
		$this->text=str_replace('  ',' ',$this->text); // double spaces
		$this->text=str_replace('} {','}{',$this->text); // embedded spaces
		// skip over the heading stuff
		$this->j=strpos($this->text,'{',1); // skip ahead to the first part of the header

		$loc=1;
		$t="";

		$ansa="";
		$this->len=strlen($this->text);
		$this->getpgraph(); // skip by the first paragrap

		while($this->j < $this->len) {
			$c=substr($this->text,$this->j,1);
			if ($c=="\\") {
				// have a tag
				$this->tag=$this->gettag();
				if (strlen($this->tag)>0) {
					// process known tags
					switch ($tag) {
						case 'par':
							$ansa.="\r\n";
							break;
						// ad a list of common tags
						// parameter tags
						case 'spriority1':
						case 'fprq2':
						case 'author':
						case 'operator':
						case 'sqformat':
						case 'company':
						case 'xmlns1':
						case 'wgrffmtfilter':
						case 'pnhang':
						case 'themedata':
						case 'colorschememapping':
							$tt=$this->gettag();
							break;
						case '*':
						case 'info':
						case 'stylesheet':
						// gets to end of paragraph
							$this->j--;
							$this->getpgraph();
						default:
						// ignore the tag
					}
				}
			} else {
				$ansa.=$c;
			}
			$this->j++;
		}
		$ansa=str_replace('{','',$ansa);
		$ansa=str_replace('}','',$ansa);
		return $ansa;
	}



	function getpgraph() {
		// if the first char after a tag is { then throw out the entire paragraph
		// this has to be nested
		$nest=0;
		while(true) {
			$this->j++;
			if ($this->j>=$this->len) break;
			if (substr($this->text,$this->j,1)=='}') {
				if ($nest==0) return;
				$nest--;
			}
			if (substr($this->text,$this->j,1)=='{') {
				$nest++;
			}
		}
		return;
	}

	function gettag() {
		// gets the text following the / character or gets the param if it there
		$tag='';
		while(true) {
			$this->j++;
			if ($this->j>=$this->len) break;
			$c=substr($this->text,$this->j,1);
			if ($c==' ') break;
			if ($c==';') break;
			if ($c=='}') break;
			if ($c=="\\") {
				$this->j--;
				break;
			}
			if ($c=="{") {
				//getpgraph();
				break;
			}
			if ((($c>='0')&&($c<='9'))||(($c>='a')&&($c<='z'))||(($c>='A')&&($c<='Z'))||$c=="'"||$c=="-"||$c=="*" ){
				$tag=$tag.$c;
			} else {
				// end of tag
				$this->j--;
				break;
			}
		}
		return $tag;
	}

	function getexcel_content($filename){
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
		$data->read($filename);
		$content = '';
		for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
			for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
				$content .= $data->sheets[0]['cells'][$i][$j].',';
			}
		}
		if(!empty($content))
			$content = substr($content, 0, -1);

		return $content;
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
			
		$check_path = $this->query_first("SELECT * FROM `users` WHERE reset_code='$str' or verify_code='$str'", array());
		if(isset($check_path['uid']) and $check_path['uid']>0)
			$this->generate_verifycode(8, $uid);
	
	  	return $str;
	}

	function generate_sharenumber(){
	  	$str =  rand(1111111,9999999);
		$time = time() - 1800;
	  		
		$check_path = $this->query_first("select share_number from user_shared_urls WHERE share_number=:share_no and shared_time>=:tim ORDER BY shared_url_id DESC", array('share_no'=>$str, 'tim'=>$time));
		if(isset($check_path['share_number']) and $check_path['share_number'] != '')
			$this->generate_sharenumber();
	
	  	return $str;
	}

	function generate_path($length = 8){
	  	$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
				'0123456789!()_{}';
	
	  	$str = '';
	  	$max = strlen($chars) - 1;
	
	  	for ($i=0; $i < $length; $i++)
			$str .= $chars[rand(0, $max)];
	
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
	function generate_password($length = 8){
	  	$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
				'0123456789-=~!@#$%^&*_+/[]{}\|';
	
	  	$str = '';
	  	$max = strlen($chars) - 1;
	
	  	for ($i=0; $i < $length; $i++)
			$str .= $chars[rand(0, $max)];
	
	  	return $str;
	}
	function FileSizeConvert($bytes)
	{
	    $bytes = floatval($bytes);
	        $arBytes = array(
	            0 => array(
	                "UNIT" => "TB",
	                "VALUE" => pow(1024, 4)
	            ),
	            1 => array(
	                "UNIT" => "GB",
	                "VALUE" => pow(1024, 3)
	            ),
	            2 => array(
	                "UNIT" => "MB",
	                "VALUE" => pow(1024, 2)
	            ),
	            3 => array(
	                "UNIT" => "KB",
	                "VALUE" => 1024
	            ),
	            4 => array(
	                "UNIT" => "B",
	                "VALUE" => 1
	            ),
	        );

	    foreach($arBytes as $arItem)
	    {
	        if($bytes >= $arItem["VALUE"])
	        {
	            $result = $bytes / $arItem["VALUE"];
	            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
	            break;
	        }
	    }
	    return $result;
	}
	function send_email($to, $subject, $msg, $from1='')
	{
		// To send HTML mail, the Content-type header must be set
		//$from = 'info@linkibag.com';
		$from = '"LinkiBag" <noreply@linkibag.com>';
		
		if($from1 != ''){ $from = '"LinkiBag" '.$from1;  } 
		
		$headers = 'From: '. $from . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	    $headers .= "X-Priority: 3\r\n";
	    $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ; 
		
		$checkuser = $this->query_first("SELECT uid, donot_recieve_email, unsubscribe_mail FROM `users` WHERE `email_id`=:email", array('email'=>$to));
		$sendemail = true;
		if(isset($checkuser['uid'])) {
			$msg .= '<br /><center><a style="color: #004080; font-weight: bold;" href="'.WEB_ROOT.'index.php?p=account_settings">Report</a> as spam &nbsp; &nbsp; | &nbsp; &nbsp; <a style="color: #004080; font-weight: bold;" href="'.WEB_ROOT.'index.php?p=account_settings">Unsubscribe</a></center>';
			if($checkuser['donot_recieve_email']==1) {
				$sendemail = false;
			}
		}else {
			$msg .= '<br /><center><a style="color: #004080; font-weight: bold;" href="'.WEB_ROOT.'reportspam.php?email='.urlencode($to).'">Report</a> as spam &nbsp; &nbsp; | &nbsp; &nbsp; <a style="color: #004080; font-weight: bold;" href="'.WEB_ROOT.'reportunsubscribe.php?email='.urlencode($to).'">Unsubscribe</a></center>';
			$checkemail = $this->query_first("SELECT id, status FROM `donot_recieve_mails` WHERE `email_id`=:email", array('email'=>$to));
			if(isset($checkemail['id']) and $checkemail['status']==1) {
				$sendemail = false;
			}
			
			$checkunsubscribe = $this->query_first("SELECT us_id, status FROM `unsubscribe` WHERE `mail_id`=:email", array('email'=>$to));
			if(isset($checkunsubscribe['us_id']) and $checkunsubscribe['status']==1) {
				$sendemail = false;
			}
		}

		
		// Mail it
		if($sendemail) {
			mail($to, $subject, $msg, $headers);
		}
		
		return true;
	}
	function validate_gresponse($response){
		
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$secret = '6LcvQfIUAAAAAAo33oAQYS62Sh8Fx-yUU8HKKK-B';
		$ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret'=> $secret, 'response'=> $response)));
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $verifyResponse = curl_exec($ch);
        
        curl_close ($ch);
        
        return json_decode($verifyResponse);
	}
	function send_sms($to, $msg){
		$ch = curl_init();
		//$url = 'http://e.evinfotech.com/Api.aspx?usr=karanc&pwd=55241191&smstype=TextSMS&to='.$to.'&msg='.urlencode($msg).'&rout=Transactional&from=BEAUTI';
		$url = 'http://smsc.dhgv.in/sendsms.php?username=SFPANI&password=185252&sender=SFPANI&mobile='.$to.'&message='.urlencode($msg).'&type=1';
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// grab URL and pass it to the browser
		$con1 = curl_exec($ch);
		
		// close cURL resource, and free up system resources
		curl_close($ch);

		return $con1;
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
		if(is_array($this->column($sql,$data)) and count($this->column($sql,$data)) > 0)
			$totalResults = count($this->column($sql,$data));
		else
			$totalResults = 0;
		//echo count($result);
		//print_r($totalResults);
		$totalPages = ceil($totalResults / $itemPerPage);

		// how many link pages to show
		$numLinks = 10;


		// create the paging links only if we have more than one page of results
		if ($totalPages > 1) {

		$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ;
		$self = 'index.php';

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

		$first = "<li><a href=\"$self?page=$page&$strGet\">First</a></li>";
		} else {
		$prev = ''; // we're on page one, don't show 'previous' link
		$first = ''; // nor 'first page' link
		}

		// print 'next' link only if we're not
		// on the last page
		if ($pageNumber < $totalPages) {
		$page = $pageNumber + 1;
		$next = "<li><a href=\"$self?page=$page&$strGet\">Next</a></li>";
		$last = "<li><a href=\"$self?page=$page&$strGet\">Last</a></li>";
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
	function getPagingLinksNew($sql, $data, $itemPerPage = 10, $strGet = '')	{		
		$result = $this->fetch_all_array($sql, $data);				
		if(is_array($this->column($sql,$data)) and count($this->column($sql,$data)) > 0)
			$totalResults = count($this->column($sql,$data));		
		else
			$totalResults = 0;
		$totalPages = ceil($totalResults / $itemPerPage);		
		return $totalPages;	
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
	
	function resize_exact_image_with_propotion($filein,$fileout,$imagethumbsize_w,$imagethumbsize_h)
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
		
		$dst_x = 0;
		$dst_y = 0;
		
		list($width_orig, $height_orig) = getimagesize($filein);
		
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



						mkdir('../files/'.$entity_field.'/original');	



					}

					$directory_path = '../files/'.$entity_field;

					$substring_required = 'yes';	

    			}else{

					if(!file_exists('files/'.$entity_field)){



    					mkdir('files/'.$entity_field);



						mkdir('files/'.$entity_field.'/original');



    				}

    				$directory_path = 'files/'.$entity_field;	    				

    				$substring_required = 'no';

    			}	



    			

				$thumb_val = array();



    			$original_path = $this->chk_filename($directory_path.'/original/', $photos_uploaded['name']);



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
	
	function upload_multiple_images($photos, $entity_id, $entity_field){
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
		$total_imgs = count($photos["tmp_name"]);
		if(!file_exists('files/'.$entity_field)){
			mkdir('files/'.$entity_field);
			mkdir('files/'.$entity_field.'/original');
		}
		for($i=0;$i<$total_imgs;$i++){
			if($photos["tmp_name"][$n]!=""){
				if(array_key_exists($photos['type'][$n], $known_photo_types)){
					//upload original file
					$original_path = $this->chk_filename('files/'.$entity_field.'/original/', $photos['name'][$n]);
					move_uploaded_file($photos["tmp_name"][$n], $original_path);
					//set variable to insert into DB	
					$new_val = array();
					$new_val['entity_id'] = $entity_id;
					$new_val['entity_field'] = $entity_field;
					$new_val['img_name'] = $photos['name'][$n];
					$new_val['img_original'] = $original_path;
					$new_val['img_delta'] = $i;
					
					//generate thumbnail and make one array to store all thumbnails to db
					$thumbnails = $this->image_thumbnails();
					if(count($thumbnails)>0){
						$thumb_val = array();
						foreach($thumbnails as $thumbnail){
							if(!file_exists('files/'.$entity_field.'/'.$thumbnail['name']))
								mkdir('files/'.$entity_field.'/'.$thumbnail['name']);
								
							$dest_path = $this->chk_filename('files/'.$entity_field.'/'.$thumbnail['name'].'/', $photos['name'][$n]);
							if($thumbnail['style']=='resize'){
								$this->resize_image($original_path,$dest_path,$thumbnail['width'],$thumbnail['height']);
							}elseif($thumbnail['style']=='resize_exact'){
								$this->resize_exact_image($original_path,$dest_path,$thumbnail['width'],$thumbnail['height']);
							}elseif($thumbnail['style']=='resize_crop'){
								$this->resize_crop_image($original_path,$dest_path,$thumbnail['width'],$thumbnail['height']);
							}
							$thumb_val[$thumbnail['name']] = $dest_path;
						}
						$new_val['img_thumbnails'] = serialize($thumb_val);
					}
					$this->query_insert($entity_field, $new_val);
					unset($new_val);
				}
				$n++;
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
	
	function set_page_title($title){
		$this->page_title = $title;
	}
	function set_page_breadcrumb($arrs){
		$output = '';
		if(isset($arrs) and is_array($arrs)){
			$total = count($arrs);
			$i = 0;
			foreach($arrs as $arr){
				$i++;
				if($i == $total){
					$output .= '<li>'.$arr.'</li>';
				}else{
					$output .= '<li class="active">'.$arr.'</li>';
				}
			}
		}
		$this->page_breadcrumb = $output;
	}
	
	
	function print_menu($menu, $url_query){
		$output = '';
		foreach($menu as $m){
				if(isset($m['sub']) and $m['sub']=='yes'){
					$sub_link = '';
					$active = false;
					foreach($m['menu'] as $sub_m){
						
						$linkquery = parse_url($sub_m['url'], PHP_URL_QUERY);
						parse_str($linkquery, $link_query);
						if(count($url_query)>0 and count($link_query)>0 and $active == false){
							$active = true;
							foreach($link_query as $lk=>$lq){
								if(isset($url_query[$lk]) and $url_query[$lk]!=$lq)
									$active = false;
							}
						}
						$sub_link .= '<li><a href="'.$sub_m['url'].'">'.$sub_m['title'].'</a></li>';
					}
					$output .= '
		  <li class="sub-menu">
			  <a'.($active==true ? ' class="active"' : '').' href="javascript:;">
				  <i class="'.$m['icon'].'"></i>
				  <span>'.$m['title'].'</span>
			  </a>
			  <ul class="sub">
				'.$sub_link.'
			  </ul>
		  </li>';
				}else{
					$active = false;
					$linkquery = parse_url($m['url'], PHP_URL_QUERY);
					parse_str($linkquery, $link_query);
					if(count($url_query)>0 and count($link_query)>0 and $active == false){
						$active = true;
						foreach($link_query as $lk=>$lq){
							if(isset($url_query[$lk]) and $url_query[$lk]!=$lq)
								$active = false;
						}
					}
					$output .= '
		  <li>
			  <a'.($active==true ? ' class="active"' : '').' href="'.$m['url'].'">
				  <i class="'.$m['icon'].'"></i>
				  <span>'.$m['title'].'</span>
			  </a>
		  </li>';
				}
		  }
		  return $output;
	}
	function table_theme($header, $rows){
		$out = '<table class="table table-bordered">';
		if(count($header)>0){
			$out .= '<thead><tr>';
			foreach($header as $th){
				$out .= '<th>'.$th.'</th>';
			}
			$out .= '</tr></thead>';
		}
		$out .= '<tbody>';
		foreach($rows as $row){
			$out .= '<tr>';
			foreach($row as $cell){
			
				if(is_array($cell)){
					$out .= '<td '.(isset($cell['attributes']) ? implode(' ', $cell['attributes']) : '').'>'.$cell['data'].'</td>';
				}else{
					$out .= '<td>'.$cell.'</td>';
				}
			}
			$out .= '</tr>';
		}
		$out .= '</tbody>';
		$out .= '</table>';
		return $out;
	}
	
	function limit_words($string, $word_limit)
	{
    	$words = explode(" ",$string);
		$str = '';
		$chkstr = '';
		foreach($words as $word){			
			$chkstr .= $word.' ';
			if(strlen($chkstr)>$word_limit)
				break;
			$str .= $word.' ';
		}
    	return trim($str);
	}
	
	function mail_format_bkup($type, $var){
		$mail_content = array();
		switch($type){
			case 'new_register':
				$mail_content['subject'] = 'Account details at Linkibag';
				$mail_content['matter'] = '
				<div style="margin: auto; width: 100%; font-family: tahoma; font-size: 16px; color: rgb(34, 34, 34); line-height: 22px;" >
					<div style="text-align: center; font-weight: 600; font-size: 40px;">
					<h1>Linkibag</h1><br />
					</div>
					<p>Dear Sir/Madam,</p>
					<p  style="text-indent: 61px; text-align: justify; border-bottom: 1px solid rgb(204, 204, 204); padding: 0px 0px 17px;">
					Thank you for registering with LinkiBag Free account. To verify your account,
				all you have to do is click the link below:'.
					//Please open the link provided to complete your process.
					'</p>
					
					<a href="'.$var['verified_link'].'">'.$var['verified_link'].'</a><br /><br />
					<p>
					Your Username is :&nbsp; &nbsp; '.$var['email_id'].'<br />
					Your Password is :&nbsp; &nbsp; '.$var['password'].'<br /><br /></p>'.
					//<p>You will be able to log in at '.WEB_ROOT.' . Please Retain this email for future reference. </p>
					'
					<div style="font-weight: bold; text-align: center; padding: 0px 0px 20px;">STAY SAFE & STAY HAPPY</div>
					<p>
					<br>
					Welcome to the Linkibag.<br>
					Team Linkibag
					</p>
				</div>';
			return $mail_content;
			break;
		}	
	}
		
		
	function mail_format($type, $var){
		$mail_content = array();
		switch($type){
			case 'new_register':
				$mail_content['subject'] = 'Login information for LinkiBag.com';
				$mail_content['matter'] = '<div style="margin: 0; padding: 0; min-width: 100%!important;" bgcolor="#ffffff">
                    <table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
                        <tr><td><table style="color: #3e3e3e;font-family: arial;max-width: 600px;text-align: center;width: 100%;" align="center" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td style="text-align: left; padding: 30px 0px 40px;">
                                            <img src="https://www.linkibag.com/images/email-logo/linkibag-logo.png"><br><p style="font-size: 14px !important;margin-top: 20px;">This message was sent to '.$var['email_id'].'</p>
                                        </td>
                                    </tr>
            						<tr>
                                        <td> 
            								<h2 style="font-size: 22px;font-weight: normal;padding: 11px 0px 0px;line-height: 33px;margin-top: 0px;">You are almost done. Click on the link below to confirm your e-mail address and finish creating your LinkiBag account.</h2>
            								<a style="background: #408080 none repeat scroll 0 0;border-radius: 0px;color: #fff !important;display: inline-block;font-size: 20px;font-weight: bold;margin: 19px 0px 58px;padding: 6px 31px;text-decoration: none;width: 275px;" href="'.$var['verified_link'].'">Confirm Account</a>
                                        </td>
                                    </tr>
            						<tr>
                                        <td>
                                            <p style="padding: 0px 0px 4px;"><a style="color: #7F7F95 !important;font-size: 14px;" href="'.$this->get_bit_ly_link(WEB_ROOT.'about-us').'">About LinkiBag</a> &nbsp; | &nbsp;  <a style="color: #7F7F95 !important;font-size: 14px;" href="'.$this->get_bit_ly_link(WEB_ROOT.'page/terms').'">Terms of Use</a> &nbsp; | &nbsp;  <a style="color: #7F7F95 !important;font-size: 14px;" href="'.$this->get_bit_ly_link(WEB_ROOT.'page/policy').'">Privacy Policy</a></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
											<p style="font-size: 14px !important;line-height: 25px;color: #000 !important;">
												You are getting this email because this email address is connected to your LinkiBag account.<br />Visit your <a href="'.WEB_ROOT.'index.php?p=account_settings">account page</a> to manage your settings.<br />

												<a style="color: #004080; font-weight: bold;" href="'.WEB_ROOT.'">LinkiBag Inc.</a> 8926 N. Greenwood Ave, #220, Niles, IL 60714
											</p>
                                           
                                        </td>
                                    </tr>
                                </table>
                        </td></tr>
                    </table>
                </div>
				<center>
					<a style="color:#7F7F95!important;font-size:14px;" href="https://www.linkibag.com/contact-us" target="_other" rel="nofollow">Contact LinkiBag</a> 
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  | &nbsp; &nbsp; 
					<a style="color:#7F7F95!important;font-size:14px;" href="'.$var['verified_link'].'&not_requested=1" target="_other" rel="nofollow">I never requested it</a>
				</center>
				<br>';
			return $mail_content;
			break;
			
		}
		
	}
	
	function count_total_comments($id){
		$sql = "SELECT count(url_id) as `total_comments` FROM `comments` WHERE `url_id`=:id";
		$row = $this->query_first($sql, array('id'=>$id));
		return $row;
	}
	
	
	function show_all_category(){
		$sql = "SELECT * FROM `category`";
		$row = $this->fetch_all_array($sql, array());
		return $row;
	}
	
	
	function get_paging_link($total_pages, $this_page){
		$visit_by = '';
		if(isset($_GET['visit_by']))
			$visit_by = $_GET['visit_by'];
		$dropdown_list = '';
		$this_page = '';
		if(isset($_GET)){	
			$val_pos = 0;
			foreach($_GET as $k=>$v){
				if($k=='page')
					continue;
				if($val_pos>0){
					$this_page .= '&';
				}		
				if(is_array($v)){
					$e_no = 0;
					foreach($v as $a){
						if($e_no > 0){
							$this_page .= '&';
						}
						$this_page .= $k.'[]='.$a;
						$e_no++;
					}
				}else{
					$this_page .= $k.'='.$v;
				}
				$val_pos++;
			}
		}
		
		$show_goto_button = false;
		$show_backto_button = false;
		if(isset($_GET['page']) and $_GET['page']>0 and $_GET['page']<$total_pages){
			$show_goto_button = true;
			$gotopage = 'index.php?page='.($_GET['page']+1).'&'.$this_page;
		}else if(isset($_GET['page']) and $_GET['page']>0 and $_GET['page'] == $total_pages){
			$show_goto_button = false;
			$gotopage = '';
		}else if(!isset($_GET['page']) and $total_pages >= 2){
			$show_goto_button = true;
			$gotopage = 'index.php?page=2&'.$this_page;
		}else if($total_pages >= 0){
			$show_goto_button = true;
			$gotopage = '';
		}else{
			$gotopage = '';
		}

		if(isset($_GET['page']) and $_GET['page']>1 and $_GET['page']<=$total_pages){
			$show_backto_button = true;
			$backtopage = 'index.php?page='.($_GET['page']-1).'&'.$this_page;
		}else{
			$show_backto_button = false;
			$backtopage = '';
		}
		$goto_button_link = '<a class="btn btn-default dark-gray-bg" href="'.$gotopage.'"'.(($gotopage == '') ? ' disabled' : '').'>Go to page</a>';
		if($show_goto_button == true){
			//$goto_button_link = '<a class="btn btn-default dark-gray-bg" href="'.$gotopage.'"'.(($gotopage == '') ? ' disabled' : '').'>Go to page</a>';
			$arrownext_button_link = '&nbsp;<a class="btn btn-default dark-gray-bg" style="border:0px solid #fff!important;" href="'.$gotopage.'"'.(($gotopage == '') ? ' disabled' : '').'><i class="fa fa-chevron-right"></i></a>';
		}else{
			//$goto_button_link = '';
			$arrownext_button_link = '';
		}
		if($show_backto_button == true){
			$backto_button_link = '<a class="btn btn-default dark-gray-bg" style="margin-right:2px; display:none;" href="'.$backtopage.'"'.(($backtopage == '') ? ' disabled' : '').'>Back to page</a>';			
		}else{
			$backto_button_link = '';
			
		}


		$pages=2;
		if(isset($_GET['page']) and $_GET['page']>0)
			$pages = 1;
		for($page=$pages;$page<=$total_pages;$page++){						
			$dropdown_list .=	'<li><a href="index.php?page='.$page.'&'.$this_page.'">'.$page.'</a></li>';	
		}
		$page_link = $backto_button_link.$goto_button_link.'                 
					<span class="dropdown border-bg-btn">
					<button data-toggle="dropdown" type="button" class="btn btn-default dropdown-toggle" aria-expanded="false">'.((isset($_GET['page']) and $_GET['page'] != '') ? $_GET['page'] : '1').(($total_pages > 1) ? ' <li class="caret"></li>' : '').'</button>';
					if($dropdown_list != ''){
		$page_link .=				
					'<ul class="dropdown-menu pull-right" id="link_new_paging">
					'.
						$dropdown_list
						
					.'</ul>'.$arrownext_button_link.'
			</span>';
			}
		if($total_pages >= 0)	
			return $page_link;
		else
			return '';
	}
	
	 
	
	function show_all_category_of_current_user($id,$item_per_page,$this_page){
		$sql = "SELECT * FROM `category` WHERE uid=:id";
		$cond = array();		
		/*
		if(isset($_GET['shared_by']) and $_GET['shared_by'] == 'asc')
			$sql .= " ORDER BY u.email_id ASC";			
		elseif(isset($_GET['shared_by']) and $_GET['shared_by'] == 'desc')			
			$sql .= " ORDER BY u.email_id DESC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_desc ASC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_desc DESC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_value ASC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_value DESC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'asc')			
			$sql .= " ORDER BY ur.created_date ASC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'desc')			
			$sql .= " ORDER BY ur.created_date DESC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'asc')			
			$sql .= " ORDER BY ur.created_date ASC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'desc')			
			$sql .= " ORDER BY ur.created_date DESC";				
		else					
			$sql .= " ORDER BY cid ASC";
		*/	
		if(isset($_GET['order_by']))
			$sql .= $this->set_links_order_by($_GET['order_by']);
		else
			$sql .= " ORDER BY cid DESC";
		$row = $this->fetch_all_array($sql, array('id'=>$id));		
		$row_count = count($row);		
		$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), array('id'=>$id));
		$paging = $this->getPagingLinks($sql, array('id'=>$id), $item_per_page, $this_page);				
		//$paging2 = $this->getPagingLinksNew($sql, array('id'=>$id), $item_per_page, $this_page);	
		$page_link_new = $this->getPagingLinksNew($sql, array('id'=>$id), $item_per_page, $this_page);
		$page_link_new = $this->get_paging_link($page_link_new, $this_page);	
		return array('row'=>$row, 'page_links'=>$paging, 'row_count'=>$row_count,'page_link_new'=>$page_link_new);
	}
	
	
	
	function get_all_urlposts($id,$item_per_page,$this_page,$cid, $only_current=0,$sponsored_only=0){
		if(isset($_GET['p']) and $_GET['p'] == 'shared-links')
			$sql = "SELECT ur.share_type,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.*  FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id and us.uid=:id2 and us.url_cat='-2' and us.num_of_visits=0 and ur.status='1'";
			//$sql = "SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.*  FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id and us.uid!=:id2";
		else if(isset($_GET['p']) and $_GET['p'] == 'dashboard'){
			$nonfriend_sel = $this->query_first("SELECT hide_nonfriend_msg FROM users WHERE uid=:uid",array('uid'=>$id));
			if($sponsored_only == 1){
				$sql = "SELECT ur.share_type,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.*, uf.status as friendstatus FROM `user_urls` ur, user_shared_urls us LEFT JOIN `users` u ON us.uid=u.uid LEFT JOIN user_friends uf ON uf.uid=us.uid and uf.fid=:fid WHERE ur.url_id=us.url_id and us.shared_to IN (:id,-1) and us.sponsored_link>='0' and ur.status='1' and u.email_id is NULL";
			}else{
				$sql = "SELECT ur.share_type,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.*, uf.status as friendstatus FROM `user_urls` ur, user_shared_urls us LEFT JOIN `users` u ON us.uid=u.uid LEFT JOIN user_friends uf ON uf.uid=us.uid and uf.fid=:fid WHERE ur.url_id=us.url_id and us.shared_to IN (:id,-1) and us.sponsored_link>='0' and ur.status='1' and u.email_id!=''";
			}
			//$sql = "SELECT ur.share_type,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.*, uf.status as friendstatus  FROM `user_urls` ur, users u, user_shared_urls us LEFT JOIN user_friends uf ON uf.uid=us.uid and uf.fid=:fid WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id and ur.status='1'";
			if($nonfriend_sel['hide_nonfriend_msg']==1){
				$sql .= " and (uf.status=1 or us.uid='".$id."')";
			}
			$sql_check_nonfriend = "SELECT COUNT(us.shared_url_id) as total FROM `user_urls` ur, users u, user_shared_urls us LEFT JOIN user_friends uf ON uf.uid=us.uid and uf.fid=:fid WHERE us.uid=u.uid and ur.url_id=us.url_id and us.shared_to=:id and ur.status='1' and us.uid!=:currentuid and (uf.status is NULL or uf.status=0)";
			$nonfriend_cond = array();
			$nonfriend_cond['fid'] = $id;
			$nonfriend_cond['id'] = $id;
			$nonfriend_cond['currentuid'] = $id;
			if(isset($_GET['url']) and $_GET['url'] != ''){
				$sql .= " and (ur.url_title LIKE '%".$_GET['url']."%' or ur.url_value LIKE '%".$_GET['url']."%' or ur.url_desc LIKE '%".$_GET['url']."%' or u.email_id LIKE '%".$_GET['url']."%')";
				$sql_check_nonfriend .= " and (ur.url_title LIKE '%".$_GET['url']."%' or ur.url_value LIKE '%".$_GET['url']."%' or ur.url_desc LIKE '%".$_GET['url']."%' or u.email_id LIKE '%".$_GET['url']."%')";
			}
		}else if(isset($_GET['p']) and $_GET['p'] == 'search-urls')
			$sql = "SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.*  FROM `user_urls` ur, users u, user_shared_urls us WHERE us.uid=u.uid and ur.url_id=us.url_id and (ur.url_title LIKE '%".$_GET['url']."%' or ur.url_value LIKE '%".$_GET['url']."%' or ur.url_desc LIKE '%".$_GET['url']."%') and ur.status='1'";
		else if(isset($_GET['p']) and $_GET['p'] == 'cat_links_search'){
			$sql = "SELECT c.cname,c.cid,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.*  FROM `user_urls` ur, users u, user_shared_urls us, category c WHERE us.uid=u.uid and ur.url_id=us.url_id and us.url_cat=c.cid and ur.status='1'";
			if(isset($_GET['cat']) and $_GET['cat'] != '')
				$sql .= " and c.cname LIKE '%".$_GET['cat']."%'";
			else
				$sql .= " and c.cid=-1";
		}else if(isset($_GET['p']) and $_GET['p'] == 'public_cat_links_search'){
			$sql = "SELECT c.cname,c.cid,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.* FROM `user_urls` ur LEFT JOIN user_public_category c ON ur.public_cat=c.cid
			LEFT JOIN users u ON ur.uid=u.uid
			LEFT JOIN user_shared_urls us ON us.url_id=ur.url_id";
			
				
			$sql .= " WHERE ur.status='1' and ur.search_page_status='1' and ur.add_to_search_page='1'";
			if(isset($_GET['cat']) and $_GET['cat'] != '')
				$sql .= " and c.cname LIKE '%".$_GET['cat']."%'";
			else
				$sql .= " and c.cid=-1";
		}
		if($this_page =='p=dashboard' and isset($_GET['trash']) and $_GET['trash'] == 1){
			$sql .= " and us.url_cat=:cid";
			$sql_check_nonfriend .= " and us.url_cat=:cid";
			$nonfriend_cond['currentuid'] = $id;
		}else if(($this_page =='p=dashboard' or $this_page =='p=shared-links') and $cid > 0){
			$sql .= " and us.url_cat=:cid";
			$sql_check_nonfriend .= " and us.url_cat=:cid";
		// for inbag
		}else if(($this_page =='p=dashboard' or $this_page =='p=shared-links') and $cid == -2){
			$sql .= " and us.url_cat=:cid";
			$sql_check_nonfriend .= " and us.url_cat=:cid";
		}else{
		//	$sql .= " and us.url_cat !='0'";
			// $sql_check_nonfriend .= " and us.url_cat !='0'";
		}
		if($sponsored_only == 1){
			if(isset($_SESSION['hidesponsorurl'])){
				$sql .= " and us.shared_url_id NOT IN (".implode(',', $_SESSION['hidesponsorurl']).")";
			}
		}
		
		$cond = array();	
		if(isset($_GET['p']) and $_GET['p'] == 'dashboard'){
			$cond['fid'] = $id;
		}
		if($only_current==1){
			$sql .= " and us.uid=:id2";
			$cond['id2'] = $id;
			
			$sql_check_nonfriend .= " and us.uid=:id2";
			$nonfriend_cond['id2'] = $id;
		}
		if(isset($_GET['p']) and $_GET['p'] == 'dashboard' and !isset($_GET['cid'])) {
			$inbag_limit = time() - (30*24*60*60);
			$sql .= " and us.shared_time>=:shared_time";
			$cond['shared_time'] = $inbag_limit;
		}

		if(isset($_GET['shared_by']) and $_GET['shared_by'] == 'asc')
			$sql .= " ORDER BY u.email_id ASC";			
		elseif(isset($_GET['shared_by']) and $_GET['shared_by'] == 'desc')			
			$sql .= " ORDER BY u.email_id DESC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_desc ASC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_desc DESC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_value ASC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_value DESC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'asc')			
			$sql .= " ORDER BY ur.created_date ASC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'desc')			
			$sql .= " ORDER BY ur.created_date DESC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'asc')			
			$sql .= " ORDER BY us.num_of_visits ASC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'desc')			
			$sql .= " ORDER BY us.num_of_visits DESC";				
//		else					
//			$sql .= " ORDER BY us.sponsored_link ASC, us.shared_to DESC";
		$cond['id'] = $id;
		if(isset($_GET['p']) and $_GET['p'] == 'shared-links')
			$cond['id2'] = $id;
		if($this_page =='p=dashboard' and isset($_GET['trash']) and $_GET['trash'] == 1){
			$cond['cid'] = $cid;
			$nonfriend_cond['cid'] = $cid;
		}else if(($this_page =='p=dashboard' or $this_page =='p=shared-links') and $cid > 0){
			$cond['cid'] = $cid;	
			$nonfriend_cond['cid'] = $cid;
		}else if(($this_page =='p=dashboard' or $this_page =='p=shared-links') and $cid == -2){
			$cond['cid'] = $cid;
			$nonfriend_cond['cid'] = $cid;
		}

		if($sponsored_only == 1){
			$sponsored_limit = 3;
			if(isset($_SESSION['hidesponsor'])){
				$sponsored_limit = (3 - $_SESSION['hidesponsor']);
			}
		//	$sql .= " LIMIT ".($sponsored_limit>0 ? $sponsored_limit : 0);
			//$row = $this->fetch_all_array($sql, $cond);
			//return array('row'=>$row);
		}else{
			$non_friend_url_count = 0;
			if(isset($_GET['p']) and $_GET['p'] == 'dashboard'){
				$check_shared_by_is_user_friend = $this->query_first($sql_check_nonfriend,$nonfriend_cond);
				$non_friend_url_count = (isset($check_shared_by_is_user_friend['total']) ? $check_shared_by_is_user_friend['total'] : 0);
			}
			$row = $this->fetch_all_array($sql, $cond);		
			
			$row_count = count($row);		
			$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), $cond);
				
			$paging = $this->getPagingLinks($sql, $cond, $item_per_page, $this_page);				
			$page_link_new = $this->getPagingLinksNew($sql, $cond, $item_per_page, $this_page);
			$page_link_new = $this->get_paging_link($page_link_new, $this_page);	
			return array('row'=>$row, 'page_links'=>$paging, 'row_count'=>$row_count,'page_link_new'=>$page_link_new, 'non_friend_url_count'=>$non_friend_url_count);
		}

		/*
		echo '<div id="jimmy" style="display:none;">';
		echo $sql;
		echo '</div>';*/
		
	}
	
	
	function get_mylinks_urlposts($id,$item_per_page,$this_page,$cid, $searchurl, $searchinclude){
		
			
		$sql = "SELECT ur.share_type,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.*, uf.status as friendstatus FROM `user_urls` ur, user_shared_urls us LEFT JOIN `users` u ON us.uid=u.uid LEFT JOIN user_friends uf ON uf.uid=us.uid and uf.fid=:fid WHERE ur.url_id=us.url_id and us.shared_to IN (:id,-1) and us.sponsored_link>='0' and ur.status='1' and u.email_id!='' and us.url_cat !='0'";
		
	    $cond = array();	
    	$cond['fid'] = $id;
		
		$sql .= " and us.like_status=:like_status";
		$cond['like_status'] = 1;

		if($cid > 0){
			$sql .= " and us.url_cat=:cid";
			$cond['cid'] = $cid;
		}

		if(!empty($searchurl)){
			$sql .= " and (ur.url_title LIKE '%".$searchurl."%' or ur.url_desc LIKE '%".$searchurl."%' or ur.url_value LIKE '%".$searchurl."%')";	
		}

		$search_include_sql = array();
		if(is_array($searchinclude) and in_array('own', $searchinclude)){
			$search_include_sql[] = " ur.uid='".$id."'";
		}
		if(is_array($searchinclude) and in_array('friends', $searchinclude)){
			
			$search_include_sql[] = " friendstatus='1'";
		}
		/*if(is_array($searchinclude) and in_array('workers', $searchinclude)){
			
		}*/
		if(count($search_include_sql)>0){
			$sql .= " and (".implode(' or ', $search_include_sql).")";
		}
		
		if(isset($_GET['shared_by']) and $_GET['shared_by'] == 'asc')
			$sql .= " ORDER BY u.email_id ASC";			
		elseif(isset($_GET['shared_by']) and $_GET['shared_by'] == 'desc')			
			$sql .= " ORDER BY u.email_id DESC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_desc ASC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_desc DESC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_value ASC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_value DESC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'asc')			
			$sql .= " ORDER BY ur.created_date ASC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'desc')			
			$sql .= " ORDER BY ur.created_date DESC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'asc')			
			$sql .= " ORDER BY us.num_of_visits ASC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'desc')			
			$sql .= " ORDER BY us.num_of_visits DESC";				
		else					
			$sql .= " ORDER BY us.sponsored_link ASC, us.shared_to DESC";
		$cond['id'] = $id;
		
		$row = $this->fetch_all_array($sql, $cond);		
		$row_count = count($row);		
		$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), $cond);
		$paging = $this->getPagingLinks($sql, $cond, $item_per_page, $this_page);				
		$page_link_new = $this->getPagingLinksNew($sql, $cond, $item_per_page, $this_page);
		$page_link_new = $this->get_paging_link($page_link_new, $this_page);	
		return array('row'=>$row, 'page_links'=>$paging, 'row_count'=>$row_count,'page_link_new'=>$page_link_new);
		
	}

	function search_urlposts($id,$item_per_page,$this_page,$cid, $searchurl, $searchinclude){
		
			
		$sql = "SELECT ur.share_type,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.*, uf.status as friendstatus FROM `user_urls` ur, user_shared_urls us LEFT JOIN `users` u ON us.uid=u.uid LEFT JOIN user_friends uf ON uf.uid=us.uid and uf.fid=:fid WHERE ur.url_id=us.url_id and us.shared_to IN (:id,-1) and us.sponsored_link>='0' and ur.status='1' and u.email_id!='' and us.url_cat !='0'";
		
	    $cond = array();	
    	$cond['fid'] = $id;

		if($cid > 0){
			$sql .= " and us.url_cat=:cid";
			$cond['cid'] = $cid;
		}

		if(!empty($searchurl)){
			$sql .= " and (ur.url_title LIKE '%".$searchurl."%' or ur.url_desc LIKE '%".$searchurl."%' or ur.url_value LIKE '%".$searchurl."%')";	
		}

		$search_include_sql = array();
		if(is_array($searchinclude) and in_array('own', $searchinclude)){
			$search_include_sql[] = " ur.uid='".$id."'";
		}
		if(is_array($searchinclude) and in_array('friends', $searchinclude)){
			
			$search_include_sql[] = " uf.status='1'";
		}
		/*if(is_array($searchinclude) and in_array('workers', $searchinclude)){
			
		}*/
		if(count($search_include_sql)>0){
			$sql .= " and (".implode(' or ', $search_include_sql).")";
		}
		
		if(isset($_GET['shared_by']) and $_GET['shared_by'] == 'asc')
			$sql .= " ORDER BY u.email_id ASC";			
		elseif(isset($_GET['shared_by']) and $_GET['shared_by'] == 'desc')			
			$sql .= " ORDER BY u.email_id DESC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_desc ASC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_desc DESC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_value ASC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_value DESC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'asc')			
			$sql .= " ORDER BY ur.created_date ASC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'desc')			
			$sql .= " ORDER BY ur.created_date DESC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'asc')			
			$sql .= " ORDER BY us.num_of_visits ASC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'desc')			
			$sql .= " ORDER BY us.num_of_visits DESC";				
		else					
			$sql .= " ORDER BY us.sponsored_link ASC, us.shared_to DESC";
		$cond['id'] = $id;
		$row = $this->fetch_all_array($sql, $cond);		
		$row_count = count($row);		
		$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), $cond);
		$paging = $this->getPagingLinks($sql, $cond, $item_per_page, $this_page);				
		$page_link_new = $this->getPagingLinksNew($sql, $cond, $item_per_page, $this_page);
		$page_link_new = $this->get_paging_link($page_link_new, $this_page);	
		return array('row'=>$row, 'page_links'=>$paging, 'row_count'=>$row_count,'page_link_new'=>$page_link_new);
		
	}

	function get_mylinksatoz_urlposts($id,$item_per_page,$this_page,$cid,$char){
		
			
		$sql = "SELECT ur.share_type,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,us.num_of_visits,u.email_id,us.*, uf.status as friendstatus, REPLACE(REPLACE(REPLACE(LOWER(ur.`url_value`), 'http://', ''), 'www.', ''), 'https://', '') newurl FROM `user_urls` ur, user_shared_urls us LEFT JOIN `users` u ON us.uid=u.uid LEFT JOIN user_friends uf ON uf.uid=us.uid and uf.fid=:fid WHERE ur.url_id=us.url_id and us.shared_to IN (:id,-1) and us.sponsored_link>='0' and ur.status='1' and u.email_id!='' and us.url_cat !='0'";
		
	    $cond = array();	
    	$cond['fid'] = $id;
		
		$sql .= " and us.like_status=:like_status";
		$cond['like_status'] = 1;

		if($cid > 0){
			$sql .= " and us.url_cat=:cid";
			$cond['cid'] = $cid;
		}

		if($char!=''){
			$sql .= " HAVING newurl LIKE '".$char."%'";
		}
		
		if(isset($_GET['shared_by']) and $_GET['shared_by'] == 'asc')
			$sql .= " ORDER BY u.email_id ASC";			
		elseif(isset($_GET['shared_by']) and $_GET['shared_by'] == 'desc')			
			$sql .= " ORDER BY u.email_id DESC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_desc ASC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_desc DESC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_value ASC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_value DESC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'asc')			
			$sql .= " ORDER BY ur.created_date ASC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'desc')			
			$sql .= " ORDER BY ur.created_date DESC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'asc')			
			$sql .= " ORDER BY us.num_of_visits ASC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'desc')			
			$sql .= " ORDER BY us.num_of_visits DESC";				
		else					
			$sql .= " ORDER BY ur.url_value ASC";
		$cond['id'] = $id;
		
		$row = $this->fetch_all_array($sql, $cond);		
		$row_count = count($row);		
		$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), $cond);
		$paging = $this->getPagingLinks($sql, $cond, $item_per_page, $this_page);				
		$page_link_new = $this->getPagingLinksNew($sql, $cond, $item_per_page, $this_page);
		$page_link_new = $this->get_paging_link($page_link_new, $this_page);	
		return array('row'=>$row, 'page_links'=>$paging, 'row_count'=>$row_count,'page_link_new'=>$page_link_new);
		
	}

	function get_linkibooks($id, $key,$item_per_page,$this_page){
		$sql = "SELECT * FROM `linkibooks` WHERE uid=:uid";
		$cond = array();
		if(!empty($key)){
			$sql .= " AND (book_title LIKE '%".$key."%' OR book_subtitle LIKE '%".$key."%')";
		}	
    	$cond['uid'] = $id;
		
		if(isset($_GET['title_by']) and ($_GET['title_by']=='asc' or $_GET['title_by']=='desc'))
			$sql .= " ORDER BY book_title ".strtoupper($_GET['title_by']);			
		elseif(isset($_GET['size_by']) and ($_GET['size_by']=='asc' or $_GET['size_by']=='desc'))
			$sql .= " ORDER BY pdf_size ".strtoupper($_GET['title_by']);			
		elseif(isset($_GET['created_by']) and ($_GET['created_by']=='asc' or $_GET['created_by']=='desc'))
			$sql .= " ORDER BY created ".strtoupper($_GET['title_by']);			
		else					
			$sql .= " ORDER BY id DESC";
		
		$row = $this->fetch_all_array($sql, $cond);		
		$row_count = count($row);		
		$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), $cond);
		$paging = $this->getPagingLinks($sql, $cond, $item_per_page, $this_page);				
		$page_link_new = $this->getPagingLinksNew($sql, $cond, $item_per_page, $this_page);
		$page_link_new = $this->get_paging_link($page_link_new, $this_page);	
		return array('row'=>$row, 'page_links'=>$paging, 'row_count'=>$row_count,'page_link_new'=>$page_link_new);
		
	}
	
	function get_all_groups_of_current_user($id,$item_per_page,$this_page){		
		
		$sql = "SELECT g.*, (SELECT COUNT(DISTINCT gf.groups_friends_id) FROM groups_friends gf, friends_request fr, user_friends uf WHERE g.uid=uf.uid and uf.uid=gf.uid and gf.email_id=fr.request_to and (gf.groups=g.group_id and gf.groups IS NOT NULL) and uf.status=1 and uf.request_id=fr.request_id) as confirmed, (SELECT COUNT(DISTINCT gf.groups_friends_id) FROM groups_friends gf, friends_request fr, user_friends uf WHERE g.uid=uf.uid and uf.uid=gf.uid and gf.email_id=fr.request_to and (gf.groups=g.group_id and gf.groups IS NOT NULL) and uf.request_id=fr.request_id) as total_friend FROM `groups` g WHERE g.uid=:id";
		//$sql = "SELECT g.*, (SELECT COUNT(uf.friend_id) FROM user_friends uf WHERE uf.fgroup=g.group_id and uf.status=1) as confirmed, (SELECT COUNT(uf1.friend_id) FROM user_friends uf1 WHERE uf1.fgroup=g.group_id) as total_friend FROM `groups` g WHERE g.uid=:id";
		//$sql = "SELECT groups.*,friends_request.request_id,COUNT(friend_id) as total2 FROM groups LEFT JOIN friends_request ON groups.uid=friends_request.request_by LEFT JOIN user_friends ON groups.uid=user_friends.uid WHERE groups.uid=:id";			
		//$sql = "SELECT groups.*,COUNT(request_id) as total,COUNT(friend_id) as total2 FROM groups LEFT JOIN friends_request ON groups.uid=friends_request.request_by LEFT JOIN user_friends ON groups.uid=user_friends.uid and user_friends.fgroup=groups.group_id WHERE groups.uid=:id";			
		
		$cond = array();		
		$cond['id'] = $id;
		//$cond['ufuid'] = $id;
		/*
		if(isset($_GET['shared_by']) and $_GET['shared_by'] == 'asc')
			$sql .= " ORDER BY u.email_id ASC";			
		elseif(isset($_GET['shared_by']) and $_GET['shared_by'] == 'desc')			
			$sql .= " ORDER BY u.email_id DESC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_desc ASC";			
		elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_desc DESC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'asc')			
			$sql .= " ORDER BY ur.url_value ASC";		
		elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'desc')			
			$sql .= " ORDER BY ur.url_value DESC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'asc')			
			$sql .= " ORDER BY ur.created_date ASC";		
		elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'desc')			
			$sql .= " ORDER BY ur.created_date DESC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'asc')			
			$sql .= " ORDER BY ur.created_date ASC";		
		elseif(isset($_GET['visit_by']) and $_GET['visit_by'] == 'desc')			
			$sql .= " ORDER BY ur.created_date DESC";				
		else					
			$sql .= " ORDER BY g.group_id DESC";
		*/
		if(isset($_GET['order_by']))
			$sql .= $this->set_links_order_by($_GET['order_by']);
		else
			$sql .= " ORDER BY g.group_id DESC";
		
		$row = $this->fetch_all_array($sql, $cond);		
		$row_count = count($row);		
		$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), array('id'=>$id));
		$paging = $this->getPagingLinks($sql, array('id'=>$id), $item_per_page, $this_page);				
		//$paging2 = $this->getPagingLinksNew($sql, array('id'=>$id), $item_per_page, $this_page);
		$page_link_new = $this->getPagingLinksNew($sql, array('id'=>$id), $item_per_page, $this_page);
		$page_link_new = $this->get_paging_link($page_link_new, $this_page);		
		return array('row'=>$row, 'page_links'=>$paging, 'row_count'=>$row_count,'page_link_new'=>$page_link_new);
	}
	
	function get_single_category($id){
		$sql = "SELECT * FROM `category` WHERE cid=:id";
		$row = $this->query_first($sql, array('id'=>$id));
		return $row;
	}		
	function list_shared_links_by_admin($id){
		$row = array();
		if($id==-2){
			$sql = "SELECT * FROM `user_urls` ur, `category` c WHERE ur.uid=:id and ur.url_cat=c.cid";		
			$sql .= " ORDER BY RAND()";
			
			$row = $this->fetch_all_array($this->getPagingQuery($sql, 3), array('id'=>0));	
		}		
		return $row;	
	}
	function show_urlpost_for_comment($id){
		$sql = "SELECT * FROM `user_urls` WHERE `url_id`=:id";
		$row = $this->query_first($sql, array('id'=>$id));
		return $row;
	}
	function call_profile($id){
		$sql = "SELECT * FROM `profile` WHERE `uid`=:id";
		$row = $this->query_first($sql, array('id'=>$id));
		return $row;
	}
	function get_urlposts_by_category($id,$u,$item_per_page, $this_page){
		$sql = "SELECT * FROM `user_urls` WHERE `url_cat`=:id AND `uid`=:uid";
		$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), array('id'=>$id,'uid'=>$u));
		$paging = $this->getPagingLinks($sql, array('id'=>$id,'uid'=>$u), $item_per_page, $this_page);
		return array('row'=>$row, 'page_links'=>$paging);
	}
	function show_all_urlposts_comments($id){
		$sql = "SELECT c.*, p.first_name FROM comments c, profile p WHERE p.uid=c.uid AND c.url_id=:id ORDER BY `id` DESC";
		$row = $this->fetch_all_array($sql, array('id'=>$id));
		return $row;
	}			function get_searched_people_profile($id){		$sql = "SELECT * FROM profile p, users u WHERE u.uid=:id and u.uid=p.uid";		$row = $this->query_first($sql, array('id'=>$id));		return $row;	}		function check_already_friend_requested($uid, $id){		$sql = "SELECT * FROM user_friends WHERE request_to=:id and request_by=:uid and status=0";		$row = $this->query_first($sql, array('id'=>$id,'uid'=>$uid));		if(isset($row['user_friend_id']) and $row['user_friend_id']>0){			return true;		}else{			return false;		}	}		function check_if_any_friend_request($current_uid, $id, $status){		$sql = "SELECT * FROM user_friends WHERE request_to=:uid and request_by=:id and status=:status1";		$row = $this->query_first($sql, array('uid'=>$current_uid, 'id'=>$id, 'status1'=>$status));		if(isset($row['user_friend_id']) and $row['user_friend_id']>0){			return true;		}else{			return false;		}	}	function check_for_pending_friend_request($current_uid, $id, $status){		$sql = "SELECT * FROM user_friends WHERE ((request_by=:uid and request_to=:id) OR (request_to=:uid1 and request_by=:id1)) and status=:status1";		$row = $this->query_first($sql, array('uid'=>$current_uid, 'id'=>$id, 'uid1'=>$current_uid, 'id1'=>$id, 'status1'=>$status));		if(isset($row['user_friend_id']) and $row['user_friend_id']>0){			return $row;		}else{			return false;		}	}						function show_all_friend_requests($current_uid,$status){		$sql = "SELECT * FROM user_friends uf, profile p WHERE request_to=:id and p.uid=uf.request_by and status=:status1";		$row = $this->fetch_all_array($sql, array('id'=>$current_uid,'status1'=>$status));		return $row;	}		function get_status_when_user_accept_request($current_uid,$user_frend_id,$status){		$sql = "SELECT * FROM user_friends WHERE request_to=:id and user_friend_id=:id2 and status=:status1";		$row = $this->query_first($sql, array('id'=>$current_uid,'id2'=>$user_frend_id,'status1'=>$status));		return $row;	}		function is_user_request($current_uid,$user_frend_id,$status){		$sql = "SELECT * FROM user_friends WHERE request_by=:id and user_friend_id=:id2 and status=:status1";		$row = $this->query_first($sql, array('id'=>$current_uid,'id2'=>$user_frend_id,'status1'=>$status));		return $row;	}	function total_pending_request($current_uid){		$sql = "SELECT COUNT(user_friend_id) as total_friend FROM user_friends WHERE request_by=:id and status=:status1";		$row = $this->query_first($sql, array('id'=>$current_uid, 'status1'=>0));		return $row['total_friend'];	}		function total_waiting_request($current_uid){		$sql = "SELECT COUNT(user_friend_id) as total_friend FROM user_friends WHERE request_to=:id and status=:status1";		$row = $this->query_first($sql, array('id'=>$current_uid, 'status1'=>0));		return $row['total_friend'];	}		function search_for_friend_request($name,$item_per_page,$this_page,$current_uid=0){		$sql = "SELECT * from profile p, users u WHERE (p.first_name LIKE :name OR u.email_id LIKE :email OR u.mobile LIKE :mobile) AND p.uid=u.uid and u.uid!=:uid1 ORDER BY first_name ASC";				$row = $this->fetch_all_array($sql, array('name'=>"%".$name."%", 'email'=>"%".$name."%", 'mobile'=>"%".$name."%", 'uid1'=>$current_uid));		$row_count = count($row);				$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), array('name'=>"%".$name."%", 'email'=>"%".$name."%", 'mobile'=>"%".$name."%", 'uid1'=>$current_uid));		$paging = $this->getPagingLinks($sql, array('name'=>"%".$name."%", 'email'=>"%".$name."%", 'mobile'=>"%".$name."%", 'uid1'=>$current_uid), $item_per_page, $this_page);		return array('row'=>$row, 'page_links'=>$paging, 'row_count'=>$row_count);	}			
	function time_elapsed_string($ptime){
		$etime = time() - $ptime;

		if ($etime < 1)
		{
			return '0 seconds ago';
		}

		$a = array( 365 * 24 * 60 * 60  =>  'year',
					 30 * 24 * 60 * 60  =>  'month',
						  24 * 60 * 60  =>  'day',
							   60 * 60  =>  'hour',
									60  =>  'minute',
									 1  =>  'second'
					);
		$a_plural = array( 'year'   => 'years',
						   'month'  => 'months',
						   'day'    => 'days',
						   'hour'   => 'hours',
						   'minute' => 'minutes',
						   'second' => 'seconds'
					);

		foreach ($a as $secs => $str)
		{
			$d = $etime / $secs;
			if ($d >= 1)
			{
				$r = round($d);
				return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
			}
		}
	}
	
	function video_id_from_url($url, $type='youtube') {
		if($type == 'youtube'){
			$pattern = 
				'%^# Match any youtube URL
				(?:https?://)?  # Optional scheme. Either http or https
				(?:www\.)?      # Optional www subdomain
				(?:             # Group host alternatives
				  youtu\.be/    # Either youtu.be,
				| youtube\.com  # or youtube.com
				  (?:           # Group path alternatives
					/embed/     # Either /embed/
				  | /v/         # or /v/
				  | /watch\?v=  # or /watch\?v=
				  )             # End path alternatives.
				)               # End host alternatives.
				([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
				$%x'
				;
		}else if($type == 'dailymotion'){
			$pattern = '#<object[^>]+>.+?http://www.dailymotion.com/swf/video/([A-Za-z0-9]+).+?</object>#s';
		}	
		
		$result = preg_match($pattern, $url, $matches);
		
		if($type == 'dailymotion'){
			if(!isset($matches[1])) {
				$result = preg_match('#http://www.dailymotion.com/video/([A-Za-z0-9]+)#s', $url, $matches);
			}
		}	
		
		
		if ($result) {
			return $matches[1];
		}
		return false;
	}
	
	
	function edit_groups_and_cat($uid, $id, $type, $mode, $page){
		if($mode == 'edit'){
			$hidden_form_fields = '';
			if($type == 'group')
				$sql = "SELECT group_name,group_id FROM groups WHERE group_id=:id and uid=:uid";
			else if($type == 'category')
				$sql = "SELECT cname,cid FROM category WHERE cid=:id and uid=:uid";
			else if($type == 'web_resource_list_links_comment')
				$sql = "SELECT p.first_name,us.shared_time,us.shared_url_id,c.created_time,c.cname,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id FROM `user_urls` ur, users u, user_shared_urls us, user_public_category c, profile p WHERE p.uid=u.uid and us.uid=u.uid and ur.url_id=us.url_id and us.url_cat=ur.url_cat and ur.public_cat=c.cid and ur.status='1' and c.status='1' and us.shared_url_id=:id and us.uid=:uid";
			else if($type == 'web_resource_list_links_notes')
				$sql = "SELECT p.first_name,us.shared_time,us.shared_url_id,c.created_time,c.cname,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id FROM `user_urls` ur, users u, user_shared_urls us, user_public_category c, profile p WHERE p.uid=u.uid and us.uid=u.uid and ur.url_id=us.url_id and us.url_cat=ur.url_cat and ur.public_cat=c.cid and ur.status='1' and c.status='1' and us.shared_url_id=:id and us.uid=:uid";
			else if($type == 'add_sharing_link_url_msg')
				$sql = "SELECT p.first_name,us.shared_time,us.shared_url_id,us.url_msg,ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id FROM `user_shared_urls` us INNER JOIN `user_urls` ur ON ur.url_id=us.url_id LEFT JOIN `users` u ON u.uid=us.uid LEFT JOIN `profile` p ON p.uid=us.uid WHERE us.url_cat=ur.url_cat and us.shared_url_id=:id and us.uid IN (:uid,-1) and us.sponsored_link>=0";
			
			$result = $this->query_first($sql,array('id'=>$id, 'uid'=>$uid));
			$maxlength = 25;
			$inputtype = 'textbox';
			if(isset($result['group_id']) and $result['group_id'] > 0){
				$form_val = 'add_groups';
				$form_id = $result['group_id'];
				$count = 1;
				$form_array[] = array('label'=>'New Name','name'=>'group_name','val'=>$result['group_name']);
			}else if(isset($result['cid']) and $result['cid'] > 0){
				$form_val = 'add_category';
				$form_id = $result['cid'];
				$count = 1;
				$form_array[] = array('label'=>'New Name','name'=>'cname','val'=>$result['cname']);
			}else if(isset($result['shared_url_id']) and $result['shared_url_id'] > 0){
				if($type == 'add_sharing_link_url_msg'){
					$form_val = 'share_links';					
					if(isset($result['url_msg']) and $result['url_msg'] != '')
						$url_msg = $result['url_msg'];
					else
						$url_msg = '';
					$hidden_form_fields = '<input type="hidden" name="url_msg_edit_for_share_links" value="1"/>';
					$hidden_form_fields .= '<input type="hidden" name="confirmempty" id="confirmemptymsg" value="0"/>';
				}else{	
					$chk_already_comment = $this->query_first("SELECT * from `user_public_category_comments` WHERE uid=:uid and url_id=:id", array('id'=>$result['url_id'], 'uid'=>$uid));
					if(isset($chk_already_comment['comment_id']) and $chk_already_comment['comment_id'] > 0){
						$notes = $chk_already_comment['notes'];
						$comment = $chk_already_comment['comment'];
					}else{
						$notes = '';	
						$comment = '';	
					}
					$form_val = 'url_submission_comments';
				}	
				$form_id = $result['shared_url_id'];
				$count = 1;
				$maxlength = 1000;
				if($type == 'web_resource_list_links_notes'){
					$form_array[] = array('label'=>'Notes','name'=>'notes','val'=>$notes);
				}else if($type == 'add_sharing_link_url_msg'){
					$form_array[] = array('label'=>'Edit or delete message','name'=>'url_msg','val'=>$url_msg);
					$maxlength = 100;
					$inputtype = 'textarea';
				}else{
					$form_array[] = array('label'=>'Comments','name'=>'comment','val'=>$comment);
				}		
			}

			
			$edit_info = '
				<div id="msgs"></div>
				<form method="post" class="form-horizontal" id="add_group_and_cat_form" action="index.php?p=linkifriends&ajax=ajax_submit" onsubmit="javascript: return add_new_group(this);">
					<input type="hidden" name="form_id" value="'.$form_val.'"/>
					'.$hidden_form_fields.'
					<input type="hidden" name="id" value="'.$form_id.'" id="updated_post_id"/>	
					<div class="modal-body-group">';
						for($i=0;$i<$count;$i++){
							if($inputtype == 'textarea'){
								$edit_info .= '				
								<div class="form-group">
									<div class="col-md-12 sharemsgtext">
										<label class="">'.$form_array[$i]['label'].'</label>
										<textarea name="'.$form_array[$i]['name'].'" placeholder="Enter Input" class="form-control" onKeyDown="limitText(this,'.$maxlength.');" onKeyUp="limitText(this,'.$maxlength.');">'.$form_array[$i]['val'].'</textarea>
										<small id="textareamaxlimit">'.$maxlength.' character limit</small>
									</div>
									<div class="col-md-12 sharemsgemptytext" style="display:none">You are sharing this link without message</div>
								</div>';
							}else{
								$edit_info .= '				
								<div class="form-group">
									<div class="col-md-12">          
										<label class="">'.$form_array[$i]['label'].'<span class="required-field">*</span></label>
										<input type="text" name="'.$form_array[$i]['name'].'" placeholder="Enter Input" class="form-control" value="'.$form_array[$i]['val'].'" maxlength="'.$maxlength.'" required/>
									</div>
								</div>';
							}
						}
			$edit_info .= '											
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default linki-btn" id="back_btn_share_msg" style="display:none" onclick="share_msg_back()">Back</button>
						<button type="button" class="btn btn-default linki-btn" id="continue_btn_share_msg" style="display:none" onclick="share_msg_continue()">OK</button>
						<button type="submit" class="btn btn-default linki-btn" id="save_btn">OK</button>
						<button type="button" class="btn btn-default linki-btn" data-dismiss="modal" style="margin-left: 38px;">Cancel</button>
					</div>
				</form>
				';				
		}else if($mode == 'add'){
			if($type == 'group'){
				$name = 'group_name';
				$label = 'New Name';
				$val = '';
				$form_val = 'add_groups';
			}else if($type == 'category'){
				$name = 'cname';
				$label = 'New Name';
				$val = '';
				$form_val = 'add_category';
				
			}else if($type == 'public_category'){
				$name = 'cname';
				$label = 'Category name';
				$val = '';
				$form_val = 'add_public_category';
				
			}
			
			$view_link = '';
			if($page == 'view_link'){
				$view_link = '<input type="hidden" name="view_link" value="1"/>';
			}
			
			$edit_info = '
				<div id="msgs"></div>
				<form method="post" class="form-horizontal" id="add_group_and_cat_form" action="index.php?p=linkifriends&ajax=ajax_submit" onsubmit="javascript: return add_new_group(this);">
					'.$view_link.'
					<input type="hidden" name="form_id" value="'.$form_val.'"/>
					<div class="modal-body-group">					
						<div class="form-group">
							<div class="col-md-12">          
								<label class="">'.$label.'<span class="required-field">*</span></label>
								<input type="text" name="'.$name.'" placeholder="New Name" class="form-control" value="'.$val.'" maxlength="25" required/>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-default linki-btn" id="save_btn">OK</button>
						<button type="button" class="btn btn-default linki-btn" data-dismiss="modal" style="margin-left: 38px;">Cancel</button>
					</div>
				</form>
				';
		}	
		echo $edit_info;
	}		
	function count_friends_of_current_user($uid, $status, $fgroup){	
		$cond = array();
		$cond['id'] = $uid;
		$sql = "SELECT COUNT(DISTINCT(fr.request_email)) as total FROM user_friends ur 
		JOIN friends_request fr ON ur.request_id=fr.request_id
		LEFT JOIN profile p ON ur.fid=p.uid 
		LEFT JOIN users u ON ur.fid=u.uid";
		$sql .= " LEFT JOIN `groups_friends` gf ON gf.email_id=fr.request_to";
		$sql .= " WHERE ur.friend_id>'0' AND ur.uid=:id";

		$sql .= " and (gf.groups=:group or gf.groups IS NULL)";
		$cond['group'] = $fgroup;
		
		if($status != "no"){	
			$sql .= " and ur.status=:status";
			$cond['status'] = $status;
		}

		$row = $this->query_first($sql, $cond);		

		return (isset($row['total']) ? $row['total'] : 0);			
	}	
	function list_all_friends_of_current_user($uid, $status, $item_per_page, $this_page,$fgroup=0, $searchkey=''){	
		$cond = array();
		$cond['id'] = $uid;
		$sql = "SELECT ur.*, fr.request_email, fr.request_name, fr.description, fr.request_to, p.first_name, p.last_name, u.email_id, u.created, ur.created as date_time_created, fr.request_time as fr_request_time1, fr.request_time1 as fr_request_time2, fr.request_time2 as fr_request_time3 FROM user_friends ur 
		JOIN friends_request fr ON ur.request_id=fr.request_id
		LEFT JOIN profile p ON ur.fid=p.uid 
		LEFT JOIN users u ON ur.fid=u.uid";
		if($fgroup != 'no'){
			$sql .= " LEFT JOIN `groups_friends` gf ON gf.email_id=fr.request_to";
		}

		$sql .= " WHERE ur.friend_id>'0' AND ur.uid=:id";
		if($fgroup != 'no'){
			if($fgroup == 0){
				$sql .= " and (gf.groups=:group or gf.groups IS NULL)";
				$cond['group'] = $fgroup;
			}else{
				$sql .= " and (gf.groups=:group and gf.groups IS NOT NULL)";
				$cond['group'] = $fgroup;
			}			
		}

		if(!empty($searchkey)) {
			$sql .= " and (fr.request_email LIKE '%".$searchkey."%' or p.first_name LIKE '%".$searchkey."%' or p.last_name LIKE '%".$searchkey."%')";
		}

		if(isset($_GET['fstatus'])){	
			$sql .= " and ur.status=:status";
			$cond['status'] = $_GET['fstatus'];
		}else{
			if($status == "0"){	
				$sql .= " and ur.status=:status";
				$cond['status'] = $status;
			}
		}
		$sql .= " GROUP BY fr.request_email";	
		if(isset($_GET['order_by'])){
			$sql .= $this->set_links_order_by($_GET['order_by']);
		}
		else{
			$sql .= " ORDER BY ur.friend_id DESC";
		}

		//$sql .= " ORDER BY friend_id DESC";
		//echo $sql;
		$row = $this->fetch_all_array($sql, $cond);		

		$row_count = count($row);
		
		$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), $cond);
		$paging = $this->getPagingLinks($sql, $cond, $item_per_page, $this_page);				
		$page_link_new = $this->getPagingLinksNew($sql, $cond, $item_per_page, $this_page);
		$page_link_new = $this->get_paging_link($page_link_new, $this_page);	
		return array('row'=>$row, 'page_links'=>$paging, 'row_count'=>$row_count,'page_link_new'=>$page_link_new);
		
		
		return $row;			
	}
	function list_all_friends_of_current_user_bkup($uid, $status, $item_per_page, $this_page,$fgroup=0){	
		$cond = array();
		//$sql = "SELECT ur.*,p.*,u.* FROM user_friends ur, profile p, users u WHERE u.uid=p.uid and ur.fid=u.uid and   order by friend_id DESC";	
		//$row = $this->fetch_all_array($sql, array('id'=>$uid, 'id2'=>$uid, 'id3'=>$uid, 'id4'=>$uid));		
		$sql = "SELECT ur.*, fr.request_email, fr.request_to, p.first_name, p.last_name, u.email_id, u.created, ur.created as date_time_created FROM user_friends ur 
		JOIN friends_request fr ON ur.request_id=fr.request_id
		LEFT JOIN profile p ON ur.fid=p.uid 
		LEFT JOIN users u ON ur.fid=u.uid WHERE ur.friend_id>'0' AND ((ur.uid=:id and";
		if($status == "0"){	
			$sql .= " (fr.request_to=:id2 or fr.request_by=:id4)";
			$cond['id4'] = $uid;
		}else{
			$sql .= " fr.request_to=:id2";

		}
		$sql .= " and ur.status<'1') OR (ur.uid=:id3 and ur.status>'0' and ur.status<'2'))";
		if(isset($_GET['url']) and $_GET['url'] != '' and !is_array($_GET['url']))
			$sql .= " and (u.email_id LIKE '%".$_GET['url']."%' or p.first_name LIKE '%".$_GET['url']."%' or p.last_name LIKE '%".$_GET['url']."%')";
		
		
		$cond['id'] = $uid;
		$cond['id2'] = $uid;
		$cond['id3'] = $uid;
		
		/*if
		($fgroup != "no" and $fgroup != "new" and $fgroup != "friends"){
			$sql .= " and ur.fgroup=:gp";
			$cond['gp']=$fgroup;
		}
		*/
		if($status != "all"){
			$sql .= " and ur.status=:status";
			$cond['status']=$status;
		}
		/*
		if($fgroup == "friends"){
			$sql .= " and ur.status='1'";
		}
		*/
		if(isset($_GET['order_by'])){
			if(!(isset($_GET['p']) and $_GET['p'] == 'shared-links-new'))
				$sql .= $this->set_links_order_by($_GET['order_by']);
		}
		else{
			//if($fgroup == "new"){
				//$sql .= " ORDER BY date ASC";
			//}else	
				$sql .= " ORDER BY friend_id DESC";
		}
		//echo $sql;
		$row = $this->fetch_all_array($sql, $cond);		

		$row_count = count($row);
		
		$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), $cond);
		$paging = $this->getPagingLinks($sql, $cond, $item_per_page, $this_page);				
		$page_link_new = $this->getPagingLinksNew($sql, $cond, $item_per_page, $this_page);
		$page_link_new = $this->get_paging_link($page_link_new, $this_page);	
		return array('row'=>$row, 'page_links'=>$paging, 'row_count'=>$row_count,'page_link_new'=>$page_link_new);
		
		
		return $row;			
	}
	function set_links_order_by($gets){
		$sql = '';
		foreach($gets as $name => $val){
			if(isset($name) and $name != '' and  $val == 'asc')
				$sql = ' ORDER BY '.$name.' ASC'; 
			else if(isset($name) and $name != '' and  $val == 'desc')
				$sql = ' ORDER BY '.$name.' DESC';	

		}
		return $sql;	
	}
		
	
	function list_all_friends_of_current_user_with_paging($id){		
		$sql = "SELECT * FROM user_friends ur, profile p WHERE (request_by=:id or request_to=:id2) and status='1' and ((ur.request_to=:id3 and p.uid=ur.request_by) OR (ur.request_by=:id4 and p.uid=ur.request_to))";		
		$row = $this->fetch_all_array($sql, array('id'=>$id, 'id2'=>$id, 'id3'=>$id, 'id4'=>$id));			
		return $row;			
	}	
	function list_all_awaited_of_current_user_with_paging($uid){		
		$sql = "SELECT * FROM user_friends ur, profile p WHERE request_to=:id and status='0' and p.uid=ur.request_by";		
		$row = $this->fetch_all_array($sql, array('id'=>$uid));				
		return $row;			
	}		
	function list_all_sent_requests_by_current_user_with_paging($uid){		
		$sql = "SELECT * FROM user_friends ur, profile p WHERE request_by=:id and status='0' and p.uid=ur.request_to";		
		$row = $this->fetch_all_array($sql, array('id'=>$uid));				
		return $row;			
	}		
	function list_all_shared_links_of_current_user($id,$item_per_page,$this_page){	
		$sql = "SELECT * FROM user_shared_urls us, user_urls ur WHERE us.shared_to=:id and us.url_id=ur.url_id";				
		$row = $this->fetch_all_array($sql, array('id'=>$id));				
		$row_count = count($row);				
		$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), array('id'=>$id));		
		$paging = $this->getPagingLinks($sql, array('id'=>$id), $item_per_page, $this_page);				
		return array('row'=>$row, 'page_links'=>$paging, 'row_count'=>$row_count);	
	}		
	function get_shared_posts_by_category($id,$u,$item_per_page, $this_page){		
		$sql = "SELECT * FROM user_shared_urls us, user_urls ur WHERE ur.`url_cat`=:id AND us.shared_to=:uid and us.url_id=ur.url_id ";		
		$row = $this->fetch_all_array($this->getPagingQuery($sql, $item_per_page), array('id'=>$id,'uid'=>$u));		
		$paging = $this->getPagingLinks($sql, array('id'=>$id,'uid'=>$u), $item_per_page, $this_page);		
		return array('row'=>$row, 'page_links'=>$paging);	
	}		
	function get_share_link_popup($url_id){	
		$current_id = $this->getcurrentuser_profile();			
		$lists_of_all_friends = $this->list_all_friends_of_current_user($current_id['uid'],1);						
		$share_link_body = '		
			<form method="post" class="form-horizontal edit_url_form-design" id="share_form" action="index.php?p=dashboard&ajax=ajax_submit" onsubmit="javascript: return share_links();">			
				<div id="url-shared-messages-out"></div>			
				<input type="hidden" name="form_id" value="share_links"/>			
				<input type="hidden" name="url" value="'.$url_id.'"/>			
				<div class="row profile_search_list">													
					<ul class="tvc-lists url-GET-comment" style="display: none;">					
						<div>';		
						foreach($lists_of_all_friends as $lists_of_all_friend){			
							$share_link_body .= '								
								<li>																
									<div class="person_name">							
										<label>
											<input type="checkbox" name="shared_user[]" value="'.$lists_of_all_friend['uid'].'"/> '.$lists_of_all_friend['first_name'].' '.$lists_of_all_friend['last_name'].
										
										'</label>														
										
									</div>																			
								</li>';		
						}		
						$share_link_body .= '																		
						</div>				
					</ul>				
				</div>															
					<div class="clearfix"></div>								 			
					<div class="form-group">        				
						<div class="col-md-4">					
							<button type="submit" class="btn btn-default linki-btn" id="send_share_link" style="margin: 5px;">Share with friend</button>				
						</div>			
					</div>		
				</form>';		
				echo $share_link_body;		
	}				
			function users_count_url($uid){	
				//$sql = "SELECT COUNT(shared_url_id) as total_shared_urls FROM `user_shared_urls` WHERE shared_to=:id and uid=:id2";		
				//$sql = "SELECT COUNT(request_id) as total_pending_invites FROM `friends_request` WHERE request_by=:id and status='0'";	
				$sql = "SELECT COUNT(DISTINCT(fr.request_email)) as total_pending_invites FROM `user_friends` uf, `friends_request` fr WHERE uf.fid=:id and uf.status='0' and uf.read_status='0' and uf.request_id=fr.request_id";	
				$row = $this->query_first($sql, array('id'=>$uid));		
				//return $row['total_shared_urls'];	
				return $row['total_pending_invites'];	
			}	
			function users_count_friend($uid){
				//$sql = "SELECT COUNT(user_friend_id) as total_friend FROM `user_friends` WHERE (request_by=:id or request_to=:id2) and status='1'";
				//$sql = "SELECT COUNT('uf.friend_id') as total_friend FROM `user_friends` uf LEFT JOIN `groups_friends` gf ON gf.uid=uf.uid WHERE uf.uid=:id";
				$mainsql = "SELECT COUNT('ur.friend_id') as total_friend FROM user_friends ur 
					JOIN friends_request fr ON ur.request_id=fr.request_id
					LEFT JOIN profile p ON ur.fid=p.uid 
					LEFT JOIN users u ON ur.fid=u.uid";
				$sql = '';	
				$where = " WHERE ur.friend_id>'0' AND ((ur.uid=:id and fr.request_to=:id2 and ur.status<'1') OR (ur.uid=:id3 and ur.status>'0' and ur.status<'2') and ur.read_status='0')";
				$cond['id'] = $uid;
				$cond['id2'] = $uid;
				$cond['id3'] = $uid;
				
				$sql .= " and ur.status=:status";
				$cond['status'] = 1;
				

				if(isset($_GET['gid'])){
					$mainsql .= " INNER JOIN groups_friends gf ON gf.uid=ur.uid and gf.groups=:gid and gf.email_id=ur.fid";
					$cond['gid'] = $_GET['gid'];		
				}



				/*echo $mainsql.$where;*/

				$row = $this->query_first($mainsql.$where.$sql, $cond);		
				return $row['total_friend'];	
			}	
			function users_count_shared_url($uid,$type='read_status',$cid='-2'){
				//$sql = "SELECT COUNT(shared_url_id) as total_shared_urls FROM `user_shared_urls` WHERE shared_to=:id and uid!=:id2";		
				//$sql = "SELECT COUNT(shared_url_id) as total_shared_urls FROM `user_shared_urls` WHERE shared_to=:id and num_of_visits=0";		
				//$sql = "SELECT COUNT(shared_url_id) as total_shared_urls FROM `user_shared_urls` WHERE shared_to=:id and num_of_visits=0 and url_cat='-2'";
                 
				if(isset($_GET['cid']))
					$cid = $_GET['cid'];
				
				$sql = "SELECT COUNT(us.shared_url_id) as total_shared_urls FROM `user_urls` ur, users u, user_shared_urls us WHERE us.shared_to=u.uid and ur.url_id=us.url_id and us.shared_to=:id and us.url_cat=:cid and ur.status='1'";
				if($type == 'like')
					$sql .= " and like_status='1'";
				else if($type == 'unlike')
					$sql .= " and like_status='2'";
				else if($type == 'recommend')
					$sql .= " and recommend_link='1'";
				else if($type == 'unrecommend')
					$sql .= " and recommend_link='2'";
				else
					$sql .= " and read_status='0'";
				  
				//$row = $this->query_first($sql, array('id'=>$uid,'id2'=>$uid));		
				$row = $this->query_first($sql, array('id'=>$uid, 'cid'=>$cid));		
				return $row['total_shared_urls'];	
			}
			/*
			function search_links($current,$item_per_page,$this_page,$cid){
				$urlposts_retrun = $this->get_all_urlposts($current['uid'],$item_per_page, $this_page, $cid);      	
				$urlposts = $urlposts_retrun['row'];
				$show_all_category_of_current_user = $this->fetch_all_array("SELECT * FROM `category` WHERE uid=:id",array('id'=>$current['uid']));
			
				$page_links = $urlposts_retrun['page_links'];  
				$page_link_new = $urlposts_retrun['page_link_new'];  
				$list_shared_links_by_admin = $this->list_shared_links_by_admin('0');	
				if(count($urlposts)<1)      			
					$no_record_found = "No Record Found";
			
				if(isset($_GET['views']) and $_GET['views']!=''){
					$this_page .= '&views='.$_GET['views'];      	
				} 
				
			?>	
				<div class="tab-content"> 
								<form name="dash_form" method="post" id="share_urls_from_dash" action="index.php?p=search_links&ajax=ajax_submit">
									<input type="hidden" name="form_id" value="multiple_shared">
									<input type="hidden" name="page" value="<?=isset($_GET['page']) ? $_GET['page'] : '1'?>"/>
									<input type="hidden" name="item_per_page" value="<?=$item_per_page?>"/>
									<input type="hidden" name="this_page" value="<?=$this_page?>"/>
									<?=isset($_GET['only_current']) ? '' : '<input type="hidden" name="only_current" value="0"/>'?>
									<?=isset($_GET['cid']) ? '' : '<input type="hidden" name="cid" value="0"/>'?>
									
									<?php
									if(isset($_GET)){											
										foreach($_GET as $k=>$v){	
											echo '<input type="hidden" name="'.$k.'" value="'.$v.'"/>';
										}	
									}		
									?>
									
										<div class="tab-content-box">
											<?=isset($msg) ? $msg : ''?>
											<div style="margin-bottom: 11px; margin-top: -7px;" class="user-name-dash">
												<div class="row">
													<div class="col-md-6"><a style="display: inline-block; line-height: 13px; padding-top: 14px;" class="text-orang" href="index.php?p=dashboard"><i class="fa fa-chain"></i> Inbox</a></div>
													<div class="col-md-6 text-right">
														<span class="bottom-nav-link">
														<a class="btn btn-default dark-gray-bg" href="index.php?p=linkibags">My Folders</a>
														
														<div class="dropdown border-bg-btn" style="display: inline;">	
															<select style="text-align: left;" name="filter" class="btn btn-default dropdown-toggle filter"  onchange="fiter_with_folder_dashboard(this.value)">
																	<option value="">Inbox</option>
																	<?php
																	foreach($show_all_category_of_current_user as $list){
																		$sel = '';
																	if(isset($list['cid']) and $list['cid'] == $cid)
																		$sel = ' selected="selected"';
																	?>
																	<option value="<?=$list['cid']?>"<?=$sel?>>
																	 <?=$list['cname']?></option>
																	<?php
																	}
																	?>										
															</select>
														</div>
														</span>
													</div>
												</div>
											</div>
											
											
											
												<ul class="head-design table-design">
													<li style="width:32%">
														<?php
														$page = '';
														if(isset($_GET['page']))
															$page = $_GET['page'];
														$url_by = '&url_by=asc';
														$arrow_direction = 'fa fa-caret-down';
														if(isset($_GET['url_by']) and $_GET['url_by'] == 'asc'){
															$url_by = '&url_by=desc';
															$arrow_direction = 'fa fa-caret-up';
														}elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'desc'){
															$url_by = '&url_by=asc';
															$arrow_direction = 'fa fa-caret-down';
														}
														$cname = 'updated';
														if(isset($_GET['cid'])){
															if($_GET['cid'] == 0 and $_GET['trash'] == 1){
																$cname = 'Trash';
															}else if($_GET['cid'] > 0){
																$cat_info = $co->query_first("SELECT cname FROM `category` WHERE cid=:id",array('id'=>$_GET['cid']));
																$cname = $cat_info['cname'];
															}	
														}	
														?>
														<div class="dropdown dropdown-design">
															<div class="btn btn-default dropdown-toggle"><input type="checkbox" name="check" id="checkAll" value=""/>Select All <a href="index.php?p=dashboard<?=$url_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
														</div>	
													</li>
													<li style="width:25%">
													<?php
													$shared_by = '&shared_by=asc';
														$arrow_direction = 'fa fa-caret-down';
														if(isset($_GET['shared_by']) and $_GET['shared_by'] == 'asc'){
															$shared_by = '&shared_by=desc';
															$arrow_direction = 'fa fa-caret-up';
														}elseif(isset($_GET['shared_by']) and $_GET['shared_by'] == 'desc'){
															$shared_by = '&shared_by=asc';
															$arrow_direction = 'fa fa-caret-down';
														}
													?>
														<div class="dropdown dropdown-design">
															<div class="btn btn-default dropdown-toggle">Shared By <a href="index.php?p=dashboard<?=$shared_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
															
														</div>	
													</li>
													<li style="width:28%">
														<?php
														$shared_by = '&msg_by=asc';
														$arrow_direction = 'fa fa-caret-down';
														
														if(isset($_GET['msg_by']) and $_GET['msg_by'] == 'asc'){
															$shared_by = '&msg_by=desc';
															$arrow_direction = 'fa fa-caret-up';
														}elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'desc'){
															$shared_by = '&msg_by=asc';
															$arrow_direction = 'fa fa-caret-down';
														}	
														?>
														<div class="dropdown dropdown-design">
															<div class="btn btn-default dropdown-toggle">Message <a href="index.php?p=dashboard<?=$shared_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
															
														</div>	
													</li>
													<li style="width:15%">
														<?php
														$date_by = '&date_by=asc';
															$arrow_direction = 'fa fa-caret-down';
															if(isset($_GET['date_by']) and $_GET['date_by'] == 'asc'){
																$date_by = '&date_by=desc';
																$arrow_direction = 'fa fa-caret-up';
															}elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'desc'){
																$date_by = '&date_by=asc';
																$arrow_direction = 'fa fa-caret-down';
															}
														?>
														<div class="dropdown dropdown-design">
															<div class="btn btn-default dropdown-toggle">Date <a href="index.php?p=dashboard<?=$date_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
															
														</div>	
													</li>
												</ul>
											
											<div class="mail-dashboard">
												
													<table class="border_block table table-design" id="all_records">
														<tbody>
															<?php               
															$i=1;                                
															if(isset($_GET['page'])){         
																$i = ($item_per_page * ($_GET['page']-1))+1;                  
															}                               
															echo $no_record_found;   
															$j = 1;
															foreach($urlposts as $urlpost){	
															
																//$time_ago = $co->time_elapsed_string($urlpost['shared_time']);	        
																//$row_cat = $co->get_single_category($urlpost['url_cat']);           
																//$tatal_comments = $co->count_total_comments($urlpost['shared_url_id']);           
																//$co->url_listing_outout($urlpost, $time_ago, $row_cat, $tatal_comments, $current);  
																$class_name = '';
																$i++; 
																if($j == 1){
																	$class_name = 'first_row';
																
																$j++;
																}else{
																	$class_name = 'second_row';
																
																$j = 1;
																}
																
																?>
																<tr class="<?=$class_name?> <?=$urlpost['num_of_visits'] > 0 ? ' read' : ' unread'?>" id="url_<?=$urlpost['shared_url_id']?>">
																	<td style="width:32%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="<?=$urlpost['shared_url_id']?>"></span> &nbsp; <a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>"><?=((strlen($urlpost['url_value']) > 42) ? substr($urlpost['url_value'], 0, 42).'...' : $urlpost['url_value'])?></a>
																	
										
																	<a href="#succ_<?=$urlpost['shared_url_id']?>" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Visit Website"  class="visit-icon"><i class="fa fa-arrow-circle-right"></i></a>
																	
																	<!-- Modal -->
													<div class="modal fade" id="succ_<?=$urlpost['shared_url_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header modal-header-success">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																	<h4>You are about to leave Linkibag</h4>
																</div>
																<div class="modal-body">
																	<p>You will be visiting:</p>
																	<h5><?=$urlpost['url_value']?></h5>
																	<div class="text-center reduct">  
																	<span class="bottom-nav">					
																		<a class="btn btn-default btn-success" href="<?=$urlpost['url_value']?>" target="_blank">Continue</a>
																		<a class="btn btn-default btn-danger" class="close" data-dismiss="modal" aria-hidden="true">Cancel</a>
																	</span>
																	</div>
																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
																	<!-- Modal -->
																	
																	
																	
																	</td>
																	<td style="width:25%"><?=$urlpost['email_id']?></td>
																	<td class="unbold-text" style="width:28%"><?=((strlen($urlpost['url_desc']) > 30) ? substr($urlpost['url_desc'], 0, 30).'...' : $urlpost['url_desc'])?></td>
																	<td style="width:15%"><?=date('d/m/Y', $urlpost['shared_time'])?>   <?=date('h:i a', $urlpost['shared_time'])?></td>
																</tr>
															<?php } ?>
															
														</tbody>
													</table>
												<!--
												<nav class="text-center">                
													<ul class="pagination"><?php //$page_links?></ul>              
												</nav>-->
												<?php
												if(isset($list_shared_links_by_admin) and count($list_shared_links_by_admin) > 0){
												?>
												
												<div class="text-right">
												<a style="color: #484848; font-size: 12px;" href="index.php?p=contact-us&type_of_inquiry=account_upgrades">Sponsored <img src="images/cancel.jpg"></a>
												</div>
												
												<table class="border_block table table-design sponsored-table">
													<tbody>
														<?php 

														foreach($list_shared_links_by_admin as $list_shared_links_by_admn){
															$time_ago = $co->time_elapsed_string($list_shared_links_by_admn['created_time']);	
															if (!preg_match("~^(?:f|ht)tps?://~i", $list_shared_links_by_admn['url_value'])) {
																$list_shared_links_by_admn['url_value'] = "http://" . $list_shared_links_by_admn['url_value'];
															}
														?>
															<tr style="position: relative;">
																<td style="width:32%"><span><input type="checkbox" name="check" value=""></span> &nbsp; <a target="_blank" href="<?=$list_shared_links_by_admn['url_value']?>"><?=$list_shared_links_by_admn['url_value']?></a></td>
																<td style="width:20%">Admin</td>
																<td style="width:28%"><?=((isset($list_shared_links_by_admn['url_desc']) and $list_shared_links_by_admn['url_desc'] != '') ? substr($list_shared_links_by_admn['url_desc'] , 0, 20) : 'Sponsored')?>...</td>
																<td class="text-right" style="width:20%"><?=date('d/m/Y', $list_shared_links_by_admn['created_time'])?>   <?=date('h:ia', $list_shared_links_by_admn['created_time'])?>
																</td>
															</tr>
															<?php
															}
															?>
													</tbody>
												</table>
												<?php } ?>
											</div>	
										</div>		
								
								
									<div class="bottom-nav-link table-design">                
										<div class="bottom-nav-link-main">
											<div  style="padding: 0px;" class="col-md-5">  
												<a class="btn btn-default dark-gray-bg" href="javascript: void(0);" onclick="move_to_category_multiple('#share_urls_from_dash');">Move to</a>                 
								
												<div class="dropdown border-bg-btn" style="display: inline;">												
												<select style="text-align: left;" name="move" class="move_to_cat_w btn btn-default dropdown-toggle" id="move_to_cat">
													<option value="">Select Folder</option>
													<option value="0">Trash</option>
													<?php
													foreach($show_all_category_of_current_user as $list){
														$sel = '';
														//if(isset($list['cid']) and $list['cid'] == $row['url_cat'])
														//	$sel = ' selected="selected"';
													?>
													  
													  <option value="<?=$list['cid']?>"<?=$sel?>><?=$list['cname']?></option>
													<?php
												}
											?>										
												</select>
												</div>
											</div>
											<div class="col-md-5 text-right">  										
												<a class="btn btn-default dark-gray-bg" href="index.php?p=linkibags">My Folders</a>
												
												<a class="btn btn-default dark-gray-bg" onclick="multiple_load_share_link_form('mark_as_unread');" href="javascript: void(0);">Mark as unread</a>                 
												<a class="btn btn-default dark-gray-bg" onclick="multiple_load_share_link_form('mark_as_del');" href="javascript: void(0);">Delete</a>                 
											</div>	
											
											<div style="width: auto; margin: 0px ! important;" class="col-md-3 pull-right">  										
												<?=$page_link_new?>                 
											</div>	
										</div>
									</div>
								</form>
							</div> 
			<?php	
			}	

			*/





			
			function url_listing_outout($urlpost, $time_ago, $row_cat, $tatal_comments, $current){?><div class="recent-url-posts">						<a href="index.php?p=url-detail&id=<?=$urlpost['url_id']?>"><i class="fa fa-link"></i> <?=$urlpost['url_value']?></a>															<span>						<div class="dashboard-btn-bottom btn-none edit-btns">						<ul>														<?php if(isset($current['uid']) and $current['uid']==$urlpost['uid']){ ?>							<li><a data-toggle="tooltip" title="Edit" class="btn" href="javascript: void(0);" onclick="load_edit_form(<?=$urlpost['url_id']?>)"><i class="fa fa-edit"></i></a></li>							<li><a data-toggle="tooltip" title="Remove" class="btn" data-toggle="modal" role="button" href="#myModal<?=$urlpost['url_id']?>"><i class="fa fa-trash-o"></i></a></li>							<?php } ?>													</ul>						</div>										<div class="time-post"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$time_ago?></div></span><br/>					<a class="url-category" href="index.php?p=dashboard&id=<?=$urlpost['url_cat']?>"><?=$row_cat['cname']?></a>										<p><?=substr($urlpost['url_desc'],0,200)?></p>					<div class="dashboard-btn-bottom separate-comment">												<ul>							<li><a style="color: rgb(255, 255, 255) ! important;" data-toggle="tooltip" title="View Comments" class="btn my-small-btn" href="index.php?p=url-detail&id=<?=$urlpost['url_id']?>"><i class="fa fa-comment"></i>  <b><?=$tatal_comments['total_comments']?></b> Comments</a></li>														<!--<li><a class="btn" href="javascript: void(0);"><i class="fa fa-share-alt"></i></a></li>-->							<li><a style="color: rgb(255, 255, 255) ! important;" data-toggle="tooltip" title="Visit Website" class="btn my-small-btn org-bg" href="<?=$urlpost['url_value']?>" target="_blank"><i class="fa fa-eye"></i> Visit Website</a></li>													<li><a style="color: rgb(255, 255, 255) ! important;" data-toggle="tooltip" title="Visit Website" class="btn my-small-btn org-bg" href="javascript: void(0);" onclick="load_share_link_form(<?=$urlpost['url_id']?>)" target="_blank"><i class="fa fa-eye"></i> Share Links</a></li>													</ul>						<form method="post">							<input type="hidden" name="form_id" value="delete_url_post"/>							<input type="hidden" name="delid" value="<?=$urlpost['url_id']?>"/>							<div id="myModal<?=$urlpost['url_id']?>" class="modal fade in">								<div class="modal-dialog">									<div class="modal-content">										<div class="modal-header">											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>											<h3 id="myModalLabel3">Deleting URL Post</h3>										</div>										<div class="modal-body">											<p>Are you sure!</p>										</div>										<div class="modal-footer">											<div class="btn-group">													<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>													<button class="btn btn-info" type="submit" name="save"><span class="glyphicon glyphicon-right"></span> Confirm</button></a>											</div>										</div>									</div><!-- /.modal-content -->								</div><!-- /.modal-dalog -->							</div>						</form>												</div>														</div>	<?php		}		function editor_web_pick(){		$sql = "SELECT * FROM `user_urls` WHERE `editor_web_link`='1' ORDER BY RAND()";		$row = $this->query_first($sql, array());		return $row;	}


	function url_valid($url) {
		$file_headers = @get_headers($url);
		if ($file_headers === false) 
			return false; // when server not found
		foreach($file_headers as $header) { // parse all headers:
			// corrects $url when 301/302 redirect(s) lead(s) to 200:
			if(preg_match("/^Location: (http.+)$/",$header,$m)) 
				$url=$m[1]; 
			// grabs the last $header $code, in case of redirect(s):
			if(preg_match("/^HTTP.+\s(\d\d\d)\s/",$header,$m)) 
				$code=$m[1]; 
		} // End foreach...
		if($code==200) 
			return true; // $code 200 == all OK
		else 
			return false; // All else has failed, so this must be a bad link
	} // End function url_exists		
	public function urlExists($url) {

        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if($httpCode >= 200 && $httpCode <= 400) {
            return true;
        } else {
            return false;
        }

        curl_close($handle);
    }

    function add_multiple_frndrequest($uid, $attach_file, $file_matter, $emails_invited, $emails_cancelled) {
    	$new = array();									
		$new['uid'] = $uid;									
		$new['attach_file'] = $attach_file;
		$new['file_matter'] = $file_matter;
		$new['emails_invited'] = $emails_invited;
		$new['emails_cancelled'] = $emails_cancelled;
		$new['created'] = time();									
		$this->query_insert('additional_users_attachment', $new);
		unset($new);
    }

    function add_friend_request($request_by, $request_to, $request_code, $request_email, $description) {
    	$new = array();									
		$new['request_by'] = $request_by;									
		$new['request_to'] = $request_to;
		$new['request_code'] = $request_code;
		$new['request_email'] = trim($request_email);
		// check user is linkibag
		if(isset($result['uid']) and $result['uid'] > 0)
			$_POST['description'] = 'LinkiBag user '.$current['email_id'].' invites you to join LinkiBag. How exciting! You both are members of LinkiBag! Add '.$current['email_id'].' to your friends list today to share your links.';

		$new['description'] = $description;
		$new['status'] = 0;
		$new['request_time'] = time();									
		$request_id = $this->query_insert('friends_request', $new);
		unset($new);
		return $request_id;
    }

    function add_user_friend($request_id, $uid, $fid, $fgroup, $status) {
    	$new = array();									
		$new['request_id'] = $request_id;									
		$new['uid'] = $uid;
		$new['fid'] = $fid;
		$new['fgroup'] = $fgroup;
		$new['status'] = $status;
		$new['date'] = date('Y-m-d');
		$new['created'] = time();
		$new['updated'] = time();
		$friend_id = $this->query_insert('user_friends', $new);
		unset($new);
		return $friend_id;
    }

    function share_linkibook($shared_with, $shared_by, $shared_to, $books, $share_id, $share_number) {
    	$to = trim($shared_to);
		$subject = 'New LinkiBook shared by '.$shared_by['first_name'].' '.$shared_by['last_name'].' at Linkibag';
		$verified_links = WEB_ROOT.'/index.php?p=view-share&share_id='.$share_id.'&share_to='.urlencode($shared_to).'&share_no='.$share_number;
		$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n".'<title>Linkibag Invitation</title>'."\n".'<style type="text/css">@import url("https://fonts.googleapis.com/css?family=Lora");body{margin:0;padding:0;min-width:100%!important}.content{color:#3e3e3e;font-family:arial;max-width:600px;text-align:center;width:100%}.btn {background: #fff;border-radius: 0;color: gray;display: inline-block;font-size: 20px;font-weight: bold;margin: 0;padding: 6px 31px;text-decoration: none;width: 275px;}.btn-decline{background:#fff none repeat scroll 0 0;border-radius:0;color:gray;display:inline-block;font-size:20px;font-weight:bold;margin:16px 0 0;padding:6px 31px;text-decoration:none;width:275px}h1{font-family:arial;margin:0;font-size:26px;line-height:38px;color:#353e4f}.top-line{font-size:14px;margin-top:20px}.big{serif;color:#3e3e3e;font-size:20px;margin:38px 0 22px;line-height:30px;font-weight:bolder}.links{padding:41px 0 5px}.links a{color:#7F7F95!important;font-size:14px}.bottom-text{font-size:14px;line-height:25px;color:#000!important}.bottom-text a{text-decoration:underline!important;font-weight:600}.content p{color:#3e3e3e}.content p a{color:#3e3e3e;text-decoration:none}
</style>
'."\n".'</head>'."\n".'<body bgcolor="#ffffff">'."\n".'<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
'."\n".'<tr>'."\n".'<td>'."\n".'<table class="content" align="center" cellpadding="0" cellspacing="0" border="0">'."\n".'<tr>'."\n".'<td style="text-align:left;padding:30px 0 40px">'."\n".'<img src="https://www.linkibag.com/images/email-logo/linkibag-logo.png">'."\n".'<br>'."\n".'<p class="top-line">This message was sent by user '.$shared_by['email_id'].' via <a target="_blank" href="http://www.linkibag.com" style="text-decoration: underline;">LinkiBag.com</a><p>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<h1>Hello '.$to.'<br>'.$shared_by['first_name'].''.$shared_by['last_name'].'<br>shared some links with you using Linkibag.com </h1>'."\n".'<p class="big"><a style="text-decoration: underline;" href="'.$verified_links.'">Click Here</a> to view shared links.<br/><span style="font-size: 11px;font-weight: normal;">* You will be required to enter the code provided by sender to open shared links.</span></p>'."\n".'<a class="btn" href="'.$this->get_bit_ly_link($verified_links.'&accept=yes').'">Sign up for a free account</a>'."\n".'<a class="btn-decline" href="'.$this->get_bit_ly_link($verified_links.'&accept=no').'">I do not know this person</a>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<p class="links">'."\n".'<a href="https://www.linkibag.com/index.php?p=about_us">About Linkibag &nbsp; | &nbsp;</a>'."\n".'<a href="https://www.linkibag.com/index.php?p=pages&id=8">Terms of Use &nbsp; | &nbsp; </a>'."\n".' <a href="https://www.linkibag.com/index.php?p=pages&id=9">Privacy Policy</a>'."\n".'</p>'."\n".'<p class="bottom-text">'."\n".'<a href="#" style="color: #7F7F95!important;font-weight: normal;text-transform: capitalize !important;margin-right: 8px;text-decoration: none !important;">Unsubscribe</a> from all messages sent via LinkiBag by any LinkiBag users and from LinkiBag Inc. <br> <span style="color: #7F7F95!important;">LinkiBag Inc. 8926 N. Greenwood Ave, #220, Niles, IL 60714<span></p></td>'."\n".'</tr>'."\n".'</table>'."\n".'</td>'."\n".'</tr>'."\n".'</table>'."\n".'</body>'."\n".'</html>';				
		$from = 'info@linkibag.com';				
		$this->send_email($to, $subject, $message, $from);
    }







    function addfriend_mail_content($description, $verified_link, $to){
    	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n".'<html xmlns="http://www.w3.org/1999/xhtml">'."\n".'<head>'."\n".'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n".'<title>Confirm your account</title>'."\n".'<style type="text/css">body{margin:0;padding:0;min-width:100%!important}.content{color:#3e3e3e;font-family:arial;max-width:600px;text-align:center;width:100%}.btn{background:#d76b00 none repeat scroll 0 0;border-radius:55px;color:#fff;display:inline-block;font-size:22px;font-weight:bold;margin:32px 0;padding:12px 43px;text-decoration:none}.btn-decline{background:#ccc none repeat scroll 0 0;border-radius:55px;color:#fff;display:inline-block;font-size:22px;font-weight:bold;margin:32px 0;padding:12px 43px;text-decoration:none}h1{margin:0}.big{color:#3e3e3e;font-size:22px;margin-top:4px}.content p{color:#3e3e3e}.content p a{color:#3e3e3e;text-decoration:none}</style>'."\n".'</head>'."\n".'<body bgcolor="#ffffff">'."\n".'<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">'."\n".'<tr>'."\n".'<td>'."\n".'<table class="content" align="center" cellpadding="0" cellspacing="0" border="0">'."\n".'<tr>'."\n".'<td style="text-align:left;padding:30px 0 40px">'."\n".'<img src="https://www.linkibag.com/images/email-logo/linkibag-logo.png">'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<h1>Friend Rquest At LinkiBag.</h1>'."\n".'<p class="big">Click on link below to Accept Or Decline.</p>'."\n".'<p>'.$description.'</p>'."\n".'<a class="btn" href="'.$this->get_bit_ly_link($verified_link.'&accept=yes').'">Accept</a> <a class="btn-decline" href="'.$this->get_bit_ly_link($verified_link.'&accept=no').'">Decline</a>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<p>This message was send to '.$to.'. if you have questions or complaints, please <a href="https://www.linkibag.com/index.php?p=contact-us"><b>contact us.</b></a> We’re here to help.</p>'."\n".'</td>'."\n".'</tr>'."\n".'<tr>'."\n".'<td>'."\n".'<p><a href="https://www.linkibag.com/index.php?p=terms-of-use">Terms of Use</a> &nbsp; | &nbsp; <a href="https://www.linkibag.com/index.php?p=terms-of-use">Privacy Policy</a></p>'."\n".'</td>'."\n".'</tr>'."\n".'</table>'."\n".'</td>'."\n".'</tr>'."\n".'</table>'."\n".'</body>'."\n".'</html>';
    	return $message;
    }

    function invite_mail_content($description, $verified_link, $to){
		$user = $this->getcurrentuser_profile();		
		$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		   <head>
			  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
			  <title>Linkibag Invitation</title> 
			  <style type="text/css">@import url("https://fonts.googleapis.com/css?family=Lora");body{margin:0;padding:0;min-width:100%!important}.content{color:#3e3e3e;font-family:arial;max-width:600px;text-align:center;width:100%}.btn {background: #fff;border-radius: 0;color: gray;display: inline-block;font-size: 20px;font-weight: bold;margin: 0;padding: 6px 31px;text-decoration: none;width: 275px;
				 }.btn-decline{background:#fff none repeat scroll 0 0;border-radius:0;color:gray;display:inline-block;font-size:20px;font-weight:bold;margin:16px 0 0;padding:6px 31px;text-decoration:none;width:275px}h1{font-family:arial;margin:0;font-size:26px;line-height:38px;color:#353e4f}.top-line{font-size:14px;margin-top:20px}.big{font-family:"Lora",serif;color:#3e3e3e;font-size:20px;margin:38px 0 22px;line-height:30px;font-weight:bolder}.links{padding:41px 0 5px}.links a{color:#7F7F95!important;font-size:14px}.bottom-text{font-size:14px;line-height:25px;color:#000!important}.bottom-text a{text-decoration:underline!important;font-weight:600}.content p{color:#3e3e3e}.content p a{color:#3e3e3e;text-decoration:none}
			  </style> 
		   </head> 
		   <body bgcolor="#ffffff"> 
			  <table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0"> 
				 <tr> 
					<td> 
					   <table class="content" align="center" cellpadding="0" cellspacing="0" border="0"> 
						  <tr> 
							 <td style="text-align:left;padding:30px 0 40px">
								'."\n".'<img src="https://www.linkibag.com/images/email-logo/linkibag-logo.png">'."\n".'<br>'."\n".'
								<p class="top-line">This message was sent by user '.$to.' via <a target="_blank" href="http://www.linkibag.com" style="text-decoration: underline;">LinkiBag.com</a>
								<p> 
							 </td> 
						  </tr> 
						  <tr> 
							 <td> 
								<h1>
									Hello '.$user['email_id'].'<br>'.$user['first_name'].' '.$user['last_name'].'<br>
									invited you to join <span style="color: #9c9696;font-weight: lighter;">LinkiBag.com</span> and to connect!
								</h1> 
								<p class="big" style="color: #FF812A;">What is LinkiBag? &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp; </p>
								<div style="width:100%;float: left;margin-bottom: 4px;margin-top: -15px;">
									<span style="width: 45%;float: left;text-align: right;margin-right: 2%;">
										<img src="https://linkibag.com/files/commercial_ads/10ReasonsLinkiBag.png" style="height: 50px;">
									</span>
									<span style="width:50%;float: left;text-align: left;"> 
										<span style="width:100%;float: left;margin-top: 5px;"><a href="https://www.youtube.com/watch?v=MlZ1C5YE6Yo">10 Reasons to use LinkiBag - YouTube</a></span>
										<span style="width:100%;float: left;font-size: 12px;margin-top: 3px;">LinkiBag is the best place to keep your links.</span>
									</span>
								</div>
								<p class="big" style="color: #FF812A;">It\'s free. <a href="'.$this->get_bit_ly_link($verified_link.'&accept=yes').'" style="color: #FF812A;
    text-decoration: underline;"> Why not to try? </a> &nbsp; </p>
								
								<div style="width:100%;float: left;">
									<span style="width:50%;float: left;text-align: center;">
										Sign up for a free account
										<a href="'.$this->get_bit_ly_link($verified_link.'&accept=yes').'" style="float: left;width: 100%; margin-top: 10px;"> 
											<button style="color: #FF812A;border: 2px solid #FF812A;padding: 5px 20px;background: #fff;">Sign up Free</button>
										</a>
									</span>
									<span style="width:50%;float: left;text-align: center;">
										I will think about it
										<a href="'.$this->get_bit_ly_link($verified_link.'&accept=no').'" style="float: left;width: 100%; margin-top: 10px;"> 
											<button style="color: red;border: 2px solid red;padding: 5px 25px;background: #fff;">May be later</button>
										</a>
									</span>
								</div>						 
							 </td> 
						  </tr> 
						  <tr> 
							 <td></td> 
						  </tr>  
							<tr>  
							 <td>  
								<p class="links">'."\n".'<a href="https://www.linkibag.com/index.php?p=about_us">About Linkibag &nbsp; | &nbsp;</a>'."\n".'<a href="https://www.linkibag.com/index.php?p=pages&id=8">Terms of Use &nbsp; | &nbsp; </a>'."\n".' <a href="https://www.linkibag.com/index.php?p=pages&id=9">Privacy Policy</a>'."\n".'</p>
								'."\n".'
								<p class="bottom-text">'."\n".'<a href="#" style="color: #7F7F95!important;font-weight: normal;text-transform: capitalize !important;text-decoration: none !important;">Unsubscribe</a> from all messages sent via LinkiBag by any LinkiBag users and from LinkiBag Inc. <br> <span style="color: #7F7F95!important;">LinkiBag Inc. 8926 N. Greenwood Ave, #220, Niles, IL 60714<span></p>
							 </td>  
						  </tr>  
					   </table>  
					</td>  
				 </tr>  
			  </table>   
		   </body>  
		</html>';
		
		return $message;
    }
}
?>