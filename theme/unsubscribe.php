<?php    
function page_content(){      
	global $co, $msg;      	     	
	$co->page_title = "Unsubscribe | LinkiBag";         	
	$this_page='p=unsubscribe';  

	if(isset($_GET['email'])){
		$new_val = array();
		$new_val['mail_id'] = $_GET['email'];
		$new_val['status'] = 0;
		$new_val['created'] = time();
		$new_val['updated'] = time();
		$co->query_insert('unsubscribe', $new_val);
		unset($new_val); 	
	}
?>
		<section class="unsubscribe-page">   
			<div class="containt-area unsubscribe">  
				<div class="container"> 
				  <h2>You Unsubscribe from all messages sent via LinkiBag by any LinkiBag users and from LinkiBag invitations</h2>
				  <br>
					  <a href="index.php">Go To Homepage</a>
				</div>
			</div>	
		</section>
<style>
.unsubscribe-page {
    padding: 90px 0px;
    text-align: center;
}
.unsubscribe h2 {
    color: #31496a;
    line-height: 45px;
}
.unsubscribe a {
    font-size: 15px;
    color: #000;
    font-weight: bold;
    border: 1px solid #2d4f68;
    padding: 9px 30px;
}
</style>
<?php  }      ?>
