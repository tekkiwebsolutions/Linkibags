<?php
   function page_access(){
   	global $co, $msg;

   }
   function page_content(){
   	global $co, $msg;
   	$no_record_found='';
   	$co->page_title = "View Share | Linkibag";
   	$current = $co->getcurrentuser_profile();
   	$item_per_page = 10;
   	//$this_page='p=view-share';
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
          $this_page .= $k.'='.urlencode($v);
        }
        $val_pos++;
      }
    }



	if(isset($_GET['share_to']) and isset($_GET['share_no']) and $_GET['share_to'] != '' and $_GET['share_no'] != ''){
    if($_GET['share_to'] == 'from_entered_id'){
      $sql = "select * from users u, user_shared_urls us where us.share_number=:share_no and u.uid=us.uid ORDER BY shared_url_id DESC";

    }else{
      $sql = "select * from users u, user_shared_urls us where us.shared_to=:share_to and us.share_number=:share_no and u.uid=us.uid ORDER BY shared_url_id DESC";
      $cond['share_to'] = $_GET['share_to'];
    }

    $cond['share_no'] = $_GET['share_no'];

		$chk_exp = $co->query_first("$sql",$cond);


		//$chk_exp = $co->query_first("SELECT * FROM `user_shared_urls` WHERE shared_to=:email_id and share_number=:share_no ORDER BY shared_url_id DESC",array('email_id'=>$_GET['share_to'],'share_no'=>$_GET['share_no']));

  // $to_time = strtotime("2008-12-13 10:42:00");
  //$from_time = strtotime("2008-12-13 10:21:00");
  //echo round(abs($to_time - $from_time) / 60,2). " minute";

		$tim = time();

    //echo 'Current time : '.$tim.', Shared expire time'.($chk_exp['shared_time']+1800);
    if(isset($chk_exp['shared_time']) and $chk_exp['shared_time'] != ''){
      $time_left = $chk_exp['shared_time'] + 1800;


      if(isset($chk_exp['activate_share_id']) and $chk_exp['activate_share_id'] == '0'){
        $expired_msg = '<p>Your Share ID is disabled. Please try again.</p>';

      }else if($time_left < $tim){
        //exit();
        /*$expired_msg = '<div class="alert alert-danger"><p>This page is only Available during a limited period of
                    time.To save for these future use <a href="index.php#free_singup" style="color: #a08f8f; "><u style="font-size: 15px;s">sign up</u></a> for your free personal linkibag account and start saving important links in your LInkibag.</p></div>';*/
        /*$expired_msg = '<p>This Share ID is exired now and it was only available for limited period of time.</p>';*/
        $expired_msg = '<p>Your Share ID is invalid. Please try again.</p>';


      }

      $shared_time = date("m/d/Y h:ia T", $chk_exp['shared_time']);
      $shared_user = $chk_exp['email_id'];

      $to_time = date('Y-m-d h:i:s', $time_left);
      $from_time = date('Y-m-d h:i:s', $tim);
      $to_time = strtotime($to_time);
      $from_time = strtotime($from_time);
      //echo round(abs($to_time - $from_time) / 60,2). " minute";
    }else{
      /*$expired_msg = '<p>Look like you entered a wrong Share ID, Please enter correct Share ID to view shared links.</p>';*/
      $expired_msg = '<p>Your Share ID is invalid. Please try again.</p>';
    }

	}

   	?>
<section>
<div class="dashboard-page">
   <div class="containt-area">
      <div class="container">
         <div class="row">
            <form method="post" id="url_form" action="index.php?p=view-share&ajax=ajax_submit" onsubmit="javascript: return add_url_multiple();">
                <input type="hidden" name="form_id" value="url_submission_multiple"/>
              <div class="col-md-3 left-side">
                 <h4>Hello, and Welcome! </h4>
                 <?php if(!isset($expired_msg)){ ?>
                 <button type="button" class="btn">Important Notice</button>

                 <p>This page is only Available during a limited period of
                    time.
                    <?php
                    if(!(isset($current['uid']))){
                   ?>
                    To save for these future use <a href="index.php#free_singup" style="color: #a08f8f; "><u style="font-size: 15px;s">sign up</u></a> for your free
                    personal linkibag account and start saving important links in your LInkibag.
                    <?php } ?>
                 </p>
                 <?php
                    if(!(isset($current['uid']))){
                   ?>
                 <!--<a href="index.php#free_singup" class="btn" style="background-color: #ff7f27;margin-top: 2px;">Free Sign Up</a>-->
                 <button type="submit" style="background-color: #ff7f27;margin-top: 2px;" class="btn" onclick="ShowHideSubmit()" id="send_url">Free Sign Up</button>
                          
                 <?php } 
               }
                 ?>

              </div>
              <div class="containt-area-dash col-md-9">
                 <!-- Tab panes -->
                 <?php

                  if(isset($_GET['share_no']) and $_GET['share_no']!='' and !(isset($expired_msg))){
                  ?>
                 <div class="tab-content">   
                       <div class="tab-content-box">
                          <div class="user-name-dash">
                             <div class="row">
                                <div class="col-md-4 id">
                                   <h5> Share ID: <span style="background-color: #c3c3c3;font-size: 20px;
                                      color: #4d4d4d;padding: 3px 23px 3px 8px;"><?=(isset($_GET['share_no']) ? $_GET['share_no'] : '###')?></span></h5>
                                </div>

                                <div class="col-md-6 share">
                                   <p>Share with you by <?=$shared_user?> on <?=$shared_time?>&nbsp;
                                      This page will expire in <span style="color:#ff7f27" id="left_time"><?=round(abs($to_time - $from_time) / 60,0)?></span> minutes
                                   </p>
                                </div>
                                <div class="col-md-2 print-btn">
                                   <div class="bottom-nav-link top-nav-link print">

  									<a class="btn btn-default dark-gray-bg" href="#" onclick="myPrintpage('#view-shared-link-print')">Print</a>
  							<div class="dropdown border-bg-btn" style="display: inline;"></div>
                                   </div>
                                </div>

                             </div>
                          </div>
                       </div>
                       <ul class="head-design table-design">
                          <li style="width:40%">
                             <?php
                                $url_by = 'asc';
                                $arrow_direction = 'fa fa-caret-down';
                                if(isset($_GET['order_by']) and in_array('asc', $_GET['order_by'])){
                                	$url_by = 'desc';
                                	$arrow_direction = 'fa fa-caret-up';
                                }elseif(isset($_GET['order_by']) and in_array('desc', $_GET['order_by'])){
                                	$url_by = 'asc';
                                	$arrow_direction = 'fa fa-caret-down';
                                }
                                $cname = 'inbox';
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
                                <div class="btn btn-default dropdown-toggle link">Link <a href="index.php?p=view-share&share_to=<?=(isset($_GET['share_to']) ? urlencode($_GET['share_to']) : '')?>&share_no=<?=(isset($_GET['share_no']) ? urlencode($_GET['share_no']) : '')?>&order_by[url_value]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("url_value",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                             </div>
                          </li>
                          <li style="width:60%">
                             <div class="dropdown dropdown-design">

                                <div class="btn btn-default dropdown-toggle msg">Message <?php /*<?=(isset($time_left) ? date('M j, Y h:i:sa' , $time_left-1800).'&nbsp;'.date('T') : date('M j, Y h:i:s'))?>*/?><a href="index.php?p=view-share&share_to=<?=(isset($_GET['share_to']) ? urlencode($_GET['share_to']) : '')?>&share_no=<?=(isset($_GET['share_no']) ? urlencode($_GET['share_no']) : '')?>&order_by[url_desc]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("url_desc",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                             </div>
                          </li>
                       </ul>
                       <div class="view-share-table-main">
                          <table class="border_block table table-design">
                             <tbody id="view-shared-link-print">
  								<?php
  								$i=1;
  								if(isset($_GET['page'])){
  									$i = ($item_per_page * ($_GET['page']-1))+1;
  								}
  								echo $no_record_found;
  								$j = 1;


  								if(isset($_GET['share_to']) and isset($_GET['share_no']) and $_GET['share_to'] != '' and $_GET['share_no'] != ''){



  								/*$exist_user = $co->query_first("select uid from users where email_id=:user",array('user'=>$_GET['share_to']));

  								if(isset($exist_user['uid']) and $exist_user['uid'] != ''){
  									$shared_email = $exist_user['uid'];
  								}else{
  									$shared_email = $_GET['share_to'];
  								}
  								*/
                      if(!(isset($expired_msg))){
                          if($_GET['share_to'] == 'from_entered_id'){
                            $sql = "SELECT * FROM `user_shared_urls` us, `user_urls` uu WHERE us.url_id=uu.url_id and us.share_number=:share_no";
                            if(isset($_GET['order_by'])){
                              $sql .= " GROUP BY us.url_id";
                              $sql .= $co->set_links_order_by($_GET['order_by']);
                            }
                            else
                              $sql .= " GROUP BY us.url_id DESC";

                          }else{
                            $sql = "SELECT * FROM `user_shared_urls` us, `user_urls` uu WHERE us.url_id=uu.url_id and us.shared_to=:share_to and us.share_number=:share_no";
                            if(isset($_GET['order_by']))
                              $sql .= $co->set_links_order_by($_GET['order_by']);
                            else
                              $sql .= " ORDER BY us.shared_url_id DESC";
                            $cond['share_to'] = $_GET['share_to'];
                          }




                          $cond['share_no'] = $_GET['share_no'];

      								    $urlposts = $co->fetch_all_array($sql,$cond);
                      }
                  }

  									if(isset($urlposts) and count($urlposts) > 0){
  										foreach($urlposts as $urlpost){
                          if (!preg_match("~^(?:f|ht)tps?://~i", $urlpost['url_value'])) {
                              $urlpost['url_value'] = "http://" . $urlpost['url_value'];
                            }
  												$i++;
  												if($j == 1){
                            $class_name = ' first_row';
                          
                          $j++;
                          }else{
                            $class_name = ' second_row';
                          
                          $j = 1;
                          }

                          if($urlpost['url_msg'] != '')
                            $url_message = ((strlen($urlpost['url_msg']) > 100) ? substr($urlpost['url_msg'], 0, 100).'...' : $urlpost['url_msg']);
                          else    
                            $url_message = ((strlen($urlpost['url_desc']) > 50) ? substr($urlpost['url_desc'], 0, 50).'...' : $urlpost['url_desc']);
  											?>
  											<tr class="first_row<?=$class_name.$urlpost['num_of_visits'] > 0 ? ' read' : ' unread'?>" id="url_<?=$urlpost['shared_url_id']?>">
  												<td style="width:40%">
                            <span><input type="checkbox" class="urls_shared" name="url_value[]" value="<?=$urlpost['shared_url_id']?>"></span> &nbsp;
  													<a href="<?=$urlpost['url_value']?>" target="_blank"><?=$urlpost['url_value']?></a>
  												</td>
  												<td style="width:60%">
  													<p><?=$url_message?></p>
  												</td>
  											</tr>
  											<?php
  											
  										}
  									}else{
  										echo '<td colspan="2">'.(isset($expired_msg) ? $expired_msg : '<div class="alert alert-danger"><p>Please enter your Share ID above in search box and click on view button to see all the links shared with you.</p></div>').'</td>';
  									}

  								?>
  							</tbody>
                          </table>
                          <?php if(isset($current['uid']) and $current['uid'] > 0){ ?>
                          <button type="submit" class="orange-btn light-brown-bg" onclick="ShowHideSubmit()" id="send_url">Add to my LinkiBag</button>
                          <?php } ?>
                       </div>
                 </div>
                 <?php } ?>
                 <div class="clearfix"></div>
                    <div class="text-right">
  					         <a class="btn button-grey pull-right" href="index.php">Close</a>
  			           </div>
                    <div class="clearfix"></div><p><br></p>
              </div>
          </form>   
         </div>
         
        <?php if(!(isset($_GET['share_no']) and $_GET['share_no']!='' and !(isset($expired_msg)))){ ?>
<p></p>
          
		  <?php
		  if(isset($expired_msg)){
			/*echo '<div class="alert alert-danger">'.$expired_msg.'</div>'; */
                  
		  }else{
			echo '<div class="alert alert-danger"><p>Please enter your Share ID above in search box and click on view button to see all the links shared with you.</p></div>';
		  }
		  ?>
		  
      <?php if(isset($expired_msg)){ ?>
      <div>        
        <div class="col-md-5">
		<h4 style="margin: 20px 0 40px;">View Shared Links</h4>
          <div id="error_msgs" style="color: #a94442;"><?php echo $expired_msg;?></div>
        <form style="padding: 0px;" class="navbar-form top-search-bar" role="search" method="get">
            <input name="p" value="view-share" type="hidden">
            <input name="share_to" value="from_entered_id" type="hidden">
                <div class="input-group">
                    <input class="form-control" style="border: 2px solid #ff7f27 !important;border-radius: 1px;box-shadow: none !important;" maxlength="7" id="share_no" placeholder="Share ID" name="share_no" value="<?=((isset($_GET['share_to']) and isset($_GET['share_no']) and $_GET['share_to'] == 'from_entered_id' and $_GET['share_no'] != '') ? $_GET['share_no'] : '')?>" type="text">
                    <div class="input-group-btn">
                        <button type="submit" class="orange-btn light-brown-bg">Finished</button>
                    </div>
                </div>
              </br>
                <label style="font-weight: 500;">Enter Share ID</label>
        </form>
         </div>
          </div>
         <div class="col-md-7"></div>
         <div class="col-md-12">
            <p style="font-weight: bold; margin: 35px 0 0; font-size: 15px;">Please note:</p>
            <p style="margin-bottom: 35px;">This page is only available during next 30 minutes and will expire.To save viewed links for <br/> your future use sign up for your <a href="index.php?p=free-personal-accounts">Free Account</a> and start saving links with LinkiBag today.</p>
          </div>
        <?php } 
      }
        ?>

      </div>
   </div>
   </div>
   </div>
   </div>
</section>
<style>
  
    
    
   .id h5 {color: #ff7f27;font-size: 18px;font-weight: 600;}
   .share p {line-height: 1.6em;color: #4d4d4d;}
   .print-btn .dark-gray-bg {padding: 6px 29px 6px 29px;}
   .head-design {border: 3px solid #c3c3c3;}
   .mail-dashboard {border: 2px solid #7f7f7f;}
   .dark-gray-bg {background: #DBDBDB none repeat scroll 0 0 !important;color: #515151 !important;}
   .text-right .dark-gray-bg {background: #DBDBDB none repeat scroll 0 0 !important;color: #515151 !important;
   padding: 5px 29px 5px 29px;margin-top: 13px;font-size: 17px;border-radius: 0px;font-weight: 600;}
   .left-side h4 {color: #002d59;padding-top: 0px;font-size: 17px;}
   .left-side p {color: #a08f8f;font-weight: 600;}
   .left-side .btn {background-color: #8b8b8b;border-radius: 0px;font-weight: 800;color: #fff;padding: 5px 20px 5px 20px;
   margin: 33px 0px 17px 0;font-size: 16px;}
   .print {float: right;}
   .user-name-dash {padding: 39px 0 13px 0;}
   .msg {font-weight: 600;}
   .table-design .dropdown-design .btn-default {font-weight: 600;}
   .border_block {border: 1px solid #7f7f7f;font-weight: 800;}
   .tbody .tr .td .a {font-size: 16px;font-weight: 500;}
   .linki-friends-search-top{
   margin: 0 !important;
   width: 25% !important;
   }
   .linki-friends-search-top .dashboard-search{
   border: medium none;
   width: 100%;
   }
   .linki-friends-search-top .dashboard-search .form-control {
   padding: 0 0 0 8px;
   }
   .bottom-nav-link-main #move_to_cat {
   background-position: right 4px center;
   padding: 5px 21px 5px 2px;
   }
   .bread-crumb p, .bread-crumb p a {
   color: #acacac;
   font-size: 12px;
   }
   .share-btns .btn-default {
   background: #c3c3c3 none repeat scroll 0 0;
   color: #3a3a3a;
   }
   .share-btns {
   display: inline-block;
   margin: 11px 0;
   width: 100%;
   }
   .share-btns .btn-primary {
   background: #597794 none repeat scroll 0 0;
   }
   .share-btns .btn {
   border: medium none;
   border-radius: 0;
   }
   .user-name-dash .btn-grey {color: #565353;background-color: #d7d7d7;border-color: #d7d7d7;font-weight: 600;padding: 6px 12px;border-radius: 0px;}
</style>
<script>
function myPrintpage(elem){
    Popup($(elem).html());
}

function Popup(data){
    var mywindow = window.open('', 'new div', 'height=400,width=600');
    mywindow.document.write('<html><head><title>my div</title>');
    mywindow.document.write('<link rel="stylesheet" href="http://www.linkibag.net/PTest25x/linkibag/theme/css/bootstrap.min.css" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<table class="table table-bordered"><thead><tr><th>Link</th><th>Message</th></tr></thead><tbody>'+data+'</tbody></table>');
    mywindow.document.write('</body></html>');

    mywindow.print();
    mywindow.close();

    return true;
}
</script>

<script type="text/javascript">
var timeoutHandle;
function countdown(minutes) {
    var seconds = 60;
    var mins = minutes
    function tick() {
        var counter = document.getElementById("left_time");
        var current_minutes = mins-1
        seconds--;
        counter.innerHTML =
        current_minutes.toString() + ":" + (seconds < 10 ? "0" : "") + String(seconds);
        if( seconds > 0 ) {
            timeoutHandle=setTimeout(tick, 1000);
        } else {

            if(mins > 1){

               // countdown(mins-1);   never reach “00″ issue solved:Contributed by Victor Streithorst
               setTimeout(function () { countdown(mins - 1); }, 1000);

            }
        }
    }
    tick();
}
<?php
 $min = round(abs($to_time - $from_time) / 60,0);
 if($min >0){
?>
countdown(<?=$min?>);
<?php } ?>
</script>

<?php  }      ?>
