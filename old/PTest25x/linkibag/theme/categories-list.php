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
		$mycats = $co->fetch_all_array("SELECT * from interested_category WHERE uid=:uid ORDER BY cat desc", array('uid'=>$current['uid']));
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
							<?php 
							if($mycats == null){
							    echo '<input name="form_id" value="interested_cats" type="hidden"> ';
							}else{
								echo '<input name="form_id" value="update_cats" type="hidden"> ';
							}
							?>
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

				<?php                    
                    if(isset($admin_cats) and count($admin_cats) > 0){
                      foreach($admin_cats as $list){
						
						$catresult = $co->query_first("SELECT * from interested_category WHERE cat=:cat and uid=:uid ORDER BY cat desc", array('cat'=>$list['cid'],'uid'=>$current['uid']));
	
                        $divclose = true;
                        $i++;
                      if($i == 1){
                        echo '<div class="row">
                                <div class="col-md-12"> 
                              ';
                      }  
                      echo '
                        <div class="col-md-2">
                          <img style="max-width: 80%;" class="img-responsive img-circle" alt="'.$list['cname'].'" src="'.$list['image'].'" /><br/>
                          <div class="text-left">
						  <input type="checkbox" class="'.$catresult['cat'].'" id="cats_'.$list['cid'].'" name="cats[]" '.($list['cid'] == $catresult['cat'] ? 'checked' : '').' value="'.$list['cid'].'">
						  &nbsp;&nbsp;&nbsp;&nbsp;<span class="cat-title">'.$list['cname'].'</span></div>                           
                        </div>
                      ';
                      if($i == 6){
                        $divclose = false;
                        echo '
                            </div>
                          </div>';
                          $i = 0;
                      }                         

                    }
                    if($divclose == true){
                      echo '
                          </div>
                        </div>';
                    }
                  }                         
                    ?>  			
   							
						<div class="categories-list-box-footer">
						<h4>Thank you for using free vesion of LinkiBag account. Feel free to update your selection at any time. Didn't find what you interested in? <a href="javascript: void(0);" onclick="show_recommend_msg_block('#recommend_msg_block');" data-toggle="tooltip" title="Click on Link below display box for recommend your message."><span style="color: #004080; font-weight: 700;">Let us know</span></a></h4>
            <div class="col-md-12 row" id="recommend_msg_block" style="display: none;">
              <div class="col-md-6 row">
                  <input type="hidden" name="recommend_click" id="recommend_click" value="1">                
                  <input placeholder="" style="border-radius:  0px;border-color: #696969;box-shadow: none !important;height: 25px;" id="recommend_category_msg" type="text" name="recommend_category_msg" class="form-control" value=""> 
              </div>
              <div class="col-md-6 row"> <a href="javascript: void(0);" onclick="recommend_category_msgs();" style="font-size: 34px; padding:  0; margin: 0 12px; color: #ff7f27;line-height: 0.8; text-decoration: none;"> > </a> </div>
            </div>  <br/>
            <div class="col-md-12 row">
                <div class="text-uppercase" id="cat_msg_trigger"><h4>
                <?php
                if(isset($_SESSION['MSG'])){
                  echo $_SESSION['MSG'];
                  unset($_SESSION['MSG']);
                }
                ?>
                </h4></div>
                
    						<div><button type="submit" name="submit" class="btn orange-bg">Finished</button></div>
    						<small>Your Preferences were last updated on <?=date('m/d/Y', $result['created'])?>.</small>
            </div>  
					</div>

							</form>
						</div>
						
						

					</div>

				</div>
		<div class="blue-border"></div>
	</section>

<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
<!--<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>-->
<script type="text/javascript">
  function show_recommend_msg_block(id){
    var recommend_click = $('#recommend_click').val();
    if(recommend_click == 1){
      $(id).show();
      $('#recommend_click').val('0');
    }else{
      $(id).hide();
      $('#recommend_click').val('1');
    }

  }
  function recommend_category_msgs(){
    var recommend_category_msg = $('#recommend_category_msg').val();
    $.ajax({
      type: "POST",
      url: 'ajax/recommend_category_msgs.php',
      data: {'recommend_category_msg':recommend_category_msg},
      success: function(res2){                                 
        $('#cat_msg_trigger').html(res2);
        $('#recommend_category_msg').val('');
      }
   }); 
  }

</script>
<?php /*
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
*/ ?>
	
<style>
.cat-title{
  font-size: 16px;
  font-weight: 600;
  color: #696969;
}    

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