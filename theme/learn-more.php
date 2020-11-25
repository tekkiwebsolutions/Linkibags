<?php
function page_content(){
	global $co, $msg;
	$co->page_title = "Learn More | LinkiBag";
?>

<?php
if($_SERVER['REQUEST_METHOD']=='POST')

{
		
}

?>

<div class="container">
	<div class="row">
		<div class="login-main">
			<div class="col-md-5 login-page-left">	
			<!-- Welcome to LinkiBag-->
				<h1>Video Library</h1>	
			   <strong> Video 1.- <a target="_blank" href="https://www.youtube.com/watch?v=0GoHJuGUWBI">Learn more about LinkiBag.</a></strong>
			      </br>
			     <strong>   Video 2.- <a target="_blank" href="https://www.youtube.com/watch?v=XK1dS4hMUMA">LinkiBag: how it works.</a> </strong> 
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
			</div>
			<div class="col-md-7 login-page-right">
				<div> 
					<iframe style="width: 100%;" width="560" height="315" src="https://www.youtube.com/embed/0GoHJuGUWBI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div> 
			</div>
		</div>
	</div>
</div>
<?php } ?>