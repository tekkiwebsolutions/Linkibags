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

		$co->page_title = "Categories | LinkiBag";
		$current = $co->getcurrentuser_profile();  
		
		$admin_cats = $co->fetch_all_array("SELECT * from category WHERE uid='0' ORDER BY cid desc", array());
		$result = $co->query_first("SELECT * from interested_category WHERE uid=:uid ORDER BY interested_cat desc", array('uid'=>$current['uid']));
		
		$i = 0;
		/*
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
		*/		
			


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
							
							<?php /*
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
							*/ ?>	

							<div class="row">
								<div class="col-md-12">									
									<ul class="multiple-images">
										<?php
										if(isset($admin_cats) and count($admin_cats) > 0){
											foreach($admin_cats as $list){
												$i++;
											echo '
									 			<li onclick="checked_category('.$list['cid'].');">
									 				<input type="checkbox" id="cats_'.$list['cid'].'" name="cats[]" value="'.$list['cid'].'" style="display: none;">'.$list['cname'].' 
									 				<span>'.$list['cname'].'</span>
									 				<img alt="'.$list['cname'].'" src="'.$list['image'].'" />
									 			</li>
									 		';	

									 		}
										}													
										?>	
									</ul>										
								</div>
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

<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
<!--<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>-->
<script >// item selection
$('li').click(function () {
  $(this).toggleClass('selected');
  if ($('li.selected').length == 0)
    $('.select').removeClass('selected');
  else
    $('.select').addClass('selected');
  counter();
});

// all item selection
$('.select').click(function () {
  if ($('li.selected').length == 0) {
    $('li').addClass('selected');
    $('.select').addClass('selected');
  }
  else {
    $('li').removeClass('selected');
    $('.select').removeClass('selected');
  }
  counter();
});

// number of selected items
function counter() {
  if ($('li.selected').length > 0)
    $('.send').addClass('selected');
  else
    $('.send').removeClass('selected');
  $('.send').attr('data-counter',$('li.selected').length);
}

function checked_category(catval){
	if($('#cats_'+catval+':checked').val() > '0'){
		$('#cats_'+catval).prop('checked', false); 		
	}else{				
		$('#cats_'+catval).prop('checked', true); 
		
	}	
	
}
//# sourceURL=pen.js
</script>
	
<style>

.multiple-images span {
	z-index: 2;
    color: #fff;
    position: absolute;
    top: 29%;
    right: 37%;
    font-size: 14px;
    text-align: center;
    word-wrap: break-word;
}
ul.multiple-images {
  position: relative;
  padding: 0;
  list-style: none;
  text-align: center;
  text-transform: uppercase;
  font-weight: 900;
  font-size: 20px;
  line-height: 40px;
  color: #555;
  list-style-type: none;
}

.multiple-images h1 {
  position: absolute;
  margin: 0;
  padding: 0;
  width: 710px;
  height: 45px;
  line-height: 45px;
  text-align: center;
  font-size: 1em;
  z-index: -1;
}

.multiple-images img {
  position: absolute;
  margin: auto;
  top: 0; left: 0; bottom: 0; right: 0;
  width: 100%;
  height: 100%;
  border-radius: 1px;
  box-shadow: 0 0 0 4px #fff;
  cursor: pointer;
  animation:        unselected 0.3s cubic-bezier(0.250, 0.100, 0.250, 1.000);
  -o-animation:     unselected 0.3s cubic-bezier(0.250, 0.100, 0.250, 1.000);
  -ms-animation:    unselected 0.3s cubic-bezier(0.250, 0.100, 0.250, 1.000);
  -moz-animation:   unselected 0.3s cubic-bezier(0.250, 0.100, 0.250, 1.000);
  -webkit-animation: unselected 0.3s cubic-bezier(0.250, 0.100, 0.250, 1.000);
}

@keyframes unselected {
  0% { box-shadow: 0 0 0 4px #00c09e; }
  50% { transform: scale(0.5); opacity: 0.8; box-shadow: 0 0 0 4px #fff; }
  80%,100% { width: 100%; height: 100%; box-shadow: 0 0 0 4px #fff; }
}
@-o-keyframes unselected {
  0% { box-shadow: 0 0 0 4px #00c09e; }
  50% { -o-transform: scale(0.5); opacity: 0.8; box-shadow: 0 0 0 4px #fff; }
  80%,100% { width: 100%; height: 100%; box-shadow: 0 0 0 4px #fff; }
}
@-ms-keyframes unselected {
  0% { box-shadow: 0 0 0 4px #00c09e; }
  50% { width: 45%; height: 45%; opacity: 0.8; box-shadow: 0 0 0 4px #fff; }
  80%,100% { width: 100%; height: 100%; box-shadow: 0 0 0 4px #fff; }
}
@-moz-transition unselected {
  0% { box-shadow: 0 0 0 4px #00c09e; }
  50% { -moz-transform: scale(0.5); opacity: 0.8; box-shadow: 0 0 0 4px #fff; }
  80%,100% { width: 100%; height: 100%; box-shadow: 0 0 0 4px #fff; }
}
@-webkit-keyframes unselected {
  0% { box-shadow: 0 0 0 4px #00c09e; }
  50% { -webkit-transform: scale(0.5); opacity: 0.8; box-shadow: 0 0 0 4px #fff; }
  80%,100% { width: 100%; height: 100%; box-shadow: 0 0 0 4px #fff; }
}


.multiple-images li {
  position: relative;
    margin: 8px;
    width: 170px;
    height: 90px;
    float: left;
    border: 5px solid #FF7F27;
    border-radius: 7px;
}

.multiple-images li:before {
  content: "\2714";
  display: block;
  position: absolute;
  margin: auto;
  top: -39px; left: 142px; 
  width: 40px;
  height: 40px;
  line-height: 40px;
  background:  #00c09e;
  border-radius: 50px;
  color: #fff;
  text-align: center;
  font-size: 16px;
  z-index: 10;
  opacity: 0;
  transition:         0.3s linear;
  -o-transition:      0.3s linear;
  -ms-transition:     0.3s linear;
  -moz-transition:    0.3s linear;
  -webkit-transition: 0.3s linear;
  -o-user-select:      none;
  -moz-user-select:    none;
  -webkit-user-select: none;
  cursor: pointer;
}

.multiple-images li.selected:before {
  opacity: 1;
}

/* img selection */

.multiple-images li.selected img {
  box-shadow: 0 0 0 4px #00c09e;
  animation:        selected 0.3s cubic-bezier(0.250, 0.100, 0.250, 1.000);
  -o-animation:     selected 0.3s cubic-bezier(0.250, 0.100, 0.250, 1.000);
  -ms-animation:    selected 0.3s cubic-bezier(0.250, 0.100, 0.250, 1.000);
  -moz-animation:   selected 0.3s cubic-bezier(0.250, 0.100, 0.250, 1.000);
  -webkit-animation: selected 0.3s cubic-bezier(0.250, 0.100, 0.250, 1.000);
}

@keyframes selected {
  0% { border-color: #fff; }
  50% { transform: scale(0.5); opacity: 0.8; box-shadow: 0 0 0 4px #00c09e; }
  80%,100% { width: 100%; height: 100%; box-shadow: 0 0 0 4px #00c09e; }
}
@-o-keyframes selected {
  0% { box-shadow: 0 0 0 4px #fff; }
  50% { -o-transform: scale(0.5); opacity: 0.8; box-shadow: 0 0 0 4px #00c09e; }
  80%,100% { width: 100%; height: 100%; box-shadow: 0 0 0 4px #00c09e; }
}
@-ms-keyframes selected {
  0% { box-shadow: 0 0 0 4px #fff; }
  50% { width: 45%; height: 45%; opacity: 0.8; box-shadow: 0 0 0 4px #00c09e; }
  80%,100% { width: 100%; height: 100%; box-shadow: 0 0 0 4px #00c09e; }
}
@-moz-transition selected {
  0% { box-shadow: 0 0 0 4px #fff; }
  50% { -moz-transform: scale(0.5); opacity: 0.8; box-shadow: 0 0 0 4px #00c09e; }
  80%,100% { width: 100%; height: 100%; box-shadow: 0 0 0 4px #00c09e; }
}
@-webkit-keyframes selected {
  0% { box-shadow: 0 0 0 4px #fff; }
  50% { -webkit-transform: scale(0.5); opacity: 0.8; box-shadow: 0 0 0 4px #00c09e; }
  80%,100% { width: 100%; height: 100%; box-shadow: 0 0 0 4px #00c09e; }
}

/* button */

.multiple-images button {
  height: 45px;
  margin: 0 7px;
  padding: 5px 0;
  font-weight: 700;
  font-size: 15px;
  letter-spacing: 2px;
  color: #fff;
  border: 0;
  border-radius: 2px;
  text-transform: uppercase;
  outline: 0;
}

.multiple-images button.select {
  float: left;
  background: #435a6b;
  cursor: pointer;
  width: 150px;
}

.multiple-images button.select:before, button.select:after {
  position: absolute;
  display: block;
  content:  'select all';
  width: 150px;
  text-align: center;
  transition:         0.1s linear;
  -o-transition:      0.1s linear;
  -ms-transition:     0.1s linear;
  -moz-transition:    0.1s linear;
  -webkit-transition: 0.1s linear;
}

.multiple-images button.select:after {
  content:  'unselect';
  margin-top: 20px;
  opacity: 0;
}

.multiple-images button.select.selected:before {
  transform:         translate(0,-38px);
  -o-transform:      translate(0,-38px);
  -ms-transform:     translate(0,-38px);
  -moz-transform:    translate(0,-38px);
  -webkit-transform: translate(0,-38px);
  opacity: 0;
}

.multiple-images button.select.selected:after {
  transform:         translate(0,-38px);
  -o-transform:      translate(0,-38px);
  -ms-transform:     translate(0,-38px);
  -moz-transform:    translate(0,-38px);
  -webkit-transform: translate(0,-38px);
  opacity: 1;
}

.multiple-images button.send {
  float: right;
  background: #aaa;
  padding: 0px 15px;
  transition:         0.3s linear;
  -o-transition:      0.3s linear;
  -ms-transition:     0.3s linear;
  -moz-transition:    0.3s linear;
  -webkit-transition: 0.3s linear;
}

.multiple-images button.send.selected {
  background: #00c09e;
  cursor: pointer;
}

.multiple-images button.send:after {
  position: absolute;
  content:  attr(data-counter);
  padding: 5px 8px;
  margin: -29px 0 0 0px;
  line-height: 100%;
  border: 2px #fff solid;
  border-radius: 60px;
  background: #00c09e;
  transition:         0.1s linear;
  -o-transition:      0.1s linear;
  -ms-transition:     0.1s linear;
  -moz-transition:    0.1s linear;
  -webkit-transition: 0.1s linear;
  opacity: 0;
}

.multiple-images button.send.selected:after {
  opacity: 1;
}</style>
	<?php

	}

?>	