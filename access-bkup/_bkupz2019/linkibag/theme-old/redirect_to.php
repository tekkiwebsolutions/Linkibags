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
	$co->page_title = "Redirect to".$_GET['path']." | ";     
 	$current = $co->getcurrentuser_profile();  	
	 
	if(isset($_GET['path']) and $_GET['path']!=''){  
		header("Location: ".$_GET['path']);
	
	}
	
	if(isset($_GET['id']) and $_GET['id'] > 0){ 
		$commercial_ads = $co->query_first("select aid from admin_ads WHERE aid=:id", array('id'=>$_GET['id']));
		if($commercial_ads['aid'] > 0)
			$co->query("UPDATE `admin_ads` SET `num_of_clicks` = `num_of_clicks` + 1 WHERE `aid` = '".$commercial_ads['aid']."'");
	
	}	
				
		

}      
?>