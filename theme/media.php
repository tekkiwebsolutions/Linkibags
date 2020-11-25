	<?php

		function page_content(){

		global $co, $msg;

		$co->page_title = "Media | LinkiBag";
		$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>13));
		$current = $co->getcurrentuser_profile();
	

?>
<link href="https://fonts.googleapis.com/css2?family=Nothing+You+Could+Do&display=swap" rel="stylesheet">

<div class="container">
	<div class="row">
		<div class="login-main" id='media_page_content'>
			<div class="col-md-5 login-page-left">	
				<h1>Media</h1>
                        Contact information for media inquries from members of the press.
                        </br>
                        pr@LinkiBag.com	
                        
                        <br>
                        <br>
                        <h1>Press-Releases</h1>
                       
                        October 12, 2020  <a target="_blank" href="https://www.linkibag.com/files/LinkiBagPress-Release1.pdf"> LinkiBag. A Revolutionary Solution of saving and sharing links on the fly, goes live with Beta Version.</a>
				<div class="page-btns">		
					<!--<a class="btn orange-bg" href="index.php?#free_signup">Free Signup</a>	-->
					<!--<br><small style="color: rgb(255, 127, 39);">Free individual account signup</small>	-->
				</div>					
			
			</div>
			<div class="col-md-7 login-page-right">
			      <h1>Video Library</h1>
			      Video 1.- <a target="_blank" href="https://www.youtube.com/watch?v=XK1dS4hMUMA">Learn more about LinkiBag.</a>
			      </br>
			      Video 2.- <a target="_blank" href="https://www.youtube.com/watch?v=0GoHJuGUWBI">LinkiBag: how it works.</a>
			      <br><br>
			      Trying to keep too many things under control? Drop your links into your LinkiBag and keep them with you wherever you go.</p>	
				<div class="page-btns">		
					<!--<a class="btn orange-bg" href="index.php?#free_signup">Free Signup</a>	-->
					<!--<br><small style="color: rgb(255, 127, 39);">Free individual account signup</small>	-->
				</div>					
				<h3>Advertise with LinkiBag</h3>	
				<div class="login-page-links">	
					<a href="index.php?p=linki-drops-accounts">LinkiDrop Account</a>	
				</div>	
				<div> 
					</div> 
			</div>
		</div>
	</div>
</div>      

	

	<?php

	}

?>	