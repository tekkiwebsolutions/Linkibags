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


	$co->page_title = "Delete My Account | Linkibag";


	$current = $co->getcurrentuser_profile();
	$row = $co->query_first("SELECT p.*, u.* FROM users u, profile p WHERE u.uid=:id AND u.uid=p.uid",array('id'=>$current['uid']));		
	if(isset($_POST['confirm_yes'])){
		$tim = time();
		$co->query_update('users', array('status'=>-2,'deleted_account'=>$tim), array('id'=>$current['uid']), 'uid=:id');			
		$co->setmessage("status", "Your account has been deleted successfully");			
		echo '<script type="text/javascript">window.location.href="logout.php"</script>';			
		exit();	
	}else if(isset($_POST['confirm_no'])){		
		echo '<script type="text/javascript">window.location.href="index.php?p=dashboard"</script>';		
		exit();	
	}
	
?>

<section class="sign_up_main_page" id="public-bag">
   <div class="container bread-crumb top-line" style="margin: auto;">
      <div class="col-md-12">
         <p><a href="index.php?p=dashboard">Home</a> > Delete My Account </p>
      </div>
   </div>	
   <div class="containt-area">
      <div class="container">
		<div class="row">
			<div class="col-md-offset-3  col-md-6">
            <form class="sign_up_page_form" method="post">
               <div id="messagesout"></div>  
				<?php if(isset($msg)) { echo $msg; }?>
               <input type="hidden" name="form_id" value="delete_account"/>                 
               <div class="col-md-12 text-left wow fadeInUp templatemo-box">
                  <div class="row">
                     <div class="personal_account_register" style="background: #eeeeee none repeat">
						<div class="form-group">
							<h3 style="margin-bottom: 22px;">Are you sure you would like to delete your LinkiBag account?</h3>
							<small style="color: #7f7f7f;">Select yes to permanently delete all account. We will not be able to restore your account if confirmed. Select no to go back to your account.</small>
						</div>
					 </div>
                     <div class="submit_btn row text-center">
						<div class="col-md-12">            
							<button type="submit" class="orange-btn" name="confirm_yes">Yes</button>
							<button type="submit" class="orange-btn" name="confirm_no">No</button>
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
