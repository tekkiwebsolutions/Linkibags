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


	$co->page_title = "Request Response | Linkibag";


	$current = $co->getcurrentuser_profile();
	
	if(isset($_GET['id']) and $_GET['id'] > 0){
		$row = $co->query_first("SELECT fr.*,p.first_name, p.last_name from friends_request fr, profile p, user_friends ur WHERE fr.request_id=:id AND fr.request_to=:uid AND ur.request_id=fr.request_id AND p.uid=fr.request_by",array('uid'=>$current['uid'], 'id'=>$_GET['id']));	
		if(isset($row['request_id']) and $row['request_id'] > 0 and $row['request_to'] == $current['uid']){
			$co->query("UPDATE `user_friends` SET `num_of_visits` = `num_of_visits` + 1 WHERE `request_id` = '".$row['request_id']."'");
			$co->query_update('user_friends', array('read_status'=>1), array('id'=>$row['request_id']), 'request_id=:id');	
			$reset_code	= $row['request_code'];
			$request_id	= $row['request_id'];
		}else{
			exit();
		}
	}
	
	$verified_link = 'index.php?p=friend_request&request_id='.$request_id.'&request_code='.$reset_code;
	
?>

<section class="sign_up_main_page" id="public-bag">
   <div class="container bread-crumb top-line" style="margin: auto;">
      <div class="col-md-12">
         <p><a href="index.php">Home</a> > Request Response </p>
      </div>
   </div>	
   <div class="containt-area">
      <div class="container">
		<div class="row">
			<div class="col-md-offset-3  col-md-6">
            <form class="sign_up_page_form" method="post">
               <div id="messagesout"></div>  
				<?php if(isset($msg)) { echo $msg; }?>
               <input type="hidden" name="form_id" value="close_account"/>                 
               <div class="col-md-12 text-left wow fadeInUp templatemo-box">
                  <div class="row">
                     <div class="personal_account_register" style="background: #eeeeee none repeat">
						<div class="form-group">
							<h3 style="margin-bottom: 22px;">You are about to <?=$row['first_name']?> <?=$row['last_name']?> request.</h3>
							<small style="color: #7f7f7f;">Select Accept to be acceped friend request.</small>
							<small style="color: #7f7f7f;">Select No to be declined Friend Request.</small>
						</div>
					 </div>
                     <div class="submit_btn row text-center">
						<div class="col-md-12">            
							<a class="btn btn-success" href="<?=$verified_link?>&accept=yes">Accept</a>
							<a class="btn btn-danger" href="<?=$verified_link?>&accept=no">No</a>
						</div>
					</div>	
                  </div>
               </div>
            </form>
         </div>
		 </div>
      </div>
      <div class="blue-border"></div>
   </div>
</section>
<?php  }    ?>
