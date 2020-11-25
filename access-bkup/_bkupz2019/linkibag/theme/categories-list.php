	<?php



		function page_content(){

		global $co, $msg;

		$co->page_title = "Categories | LinkiBag";
		$current = $co->getcurrentuser_profile();  
		
		$admin_cats = $co->fetch_all_array("SELECT * from category WHERE uid='0' ORDER BY cid desc", array());
		$result = $co->query_first("SELECT * from interested_category WHERE uid=:uid ORDER BY interested_cat desc", array('uid'=>$current['uid']));
		
		$i = 0;
		$left_cats = '';
		$mid_cats = '';
		$right_cats = '';
		if(isset($admin_cats) and count($admin_cats) > 0){
			foreach($admin_cats as $list){
				$i++;
				if($i<=4){		
					$left_cats .= '<div class="checkbox-list">
						<label>
						<input type="checkbox" name="cats[]" value="'.$list['cid'].'"> - '.$list['cname'].' 
						</label>
					</div>';
		 
				}elseif($i > 4 and $i<=8){		
					$mid_cats .= '<div class="checkbox-list">
						<label>
						<input type="checkbox" name="cats[]" value="'.$list['cid'].'"> - '.$list['cname'].' 
						</label>
					</div>';
		 
				}else{
					$right_cats .= '<div class="checkbox-list">
						<label>
						<input type="checkbox" name="cats[]" value="'.$list['cid'].'"> - '.$list['cname'].' 
						</label>
					</div>';
				}
				if($i >= 12)
					$i=0;
			}
		}		
			


?>	

	<section class="categories-list-page">
			

				<div class="container">

					<div class="row">

						<div class="col-md-10 col-md-offset-1">
							<form method="post">
							<?=isset($msg) ? $msg : ''?>								
							<div id="messagesout"></div>  
							<input name="form_id" value="interested_cats" type="hidden"> 
							<div class="categories-list-box">
								<h4>LinkiBag User Interest Form</h4>
								<p>To continue with Free LinkiBag account select at least three topic categories you are interested in from the list below. To upgrade 
your account select Upgrade/Renew option under My Account in the top-right corner of your screen.</p>
							</div>
							
							
							<div class="row">
								
									<div class="col-md-4">
									<?=$left_cats?>
									</div>
									
									
									<div class="col-md-4">
									<?=$mid_cats?>
									</div>
									
									
									<div class="col-md-4">
									<?=$right_cats?>
									</div>
									<input type="submit" name="submit" value="x" style="display: none;"> 
								
							</div>		
							
							
						
						<div class="categories-list-box-footer">
						<h4>Thank you for using free vesion of LinkiBag account.</h4>
						<div><button type="submit" name="submit" class="btn orange-bg">Finished</button></div>
						<small>Your Preferences were last updated on <?=date('m/d/Y', $result['created'])?>.</small>
						</div>

							</form>
						</div>
						
						

					</div>

				</div>
		<div class="blue-border"></div>
	</section>

	

	<?php

	}

?>	