

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
   	$co->page_title = "Friends | Linkibag";     
   	$current = $co->getcurrentuser_profile(); 	
   	$item_per_page = 10; 	
   	$this_page='p=linkifriends'; 
   	$fgroup = 'no';
   	if(isset($_GET['gid']))
   		$fgroup = $_GET['gid'];
   	$lists_of_all_friend = $co->list_all_friends_of_current_user($current['uid'], 'all', $item_per_page, $this_page, $fgroup);
   	$show_all_gps_of_current_user = $co->fetch_all_array("SELECT * FROM `groups` WHERE uid=:id",array('id'=>$current['uid'])); 
   	$lists_of_all_friends = $lists_of_all_friend['row'];  
   	$page_link_new = $lists_of_all_friend['page_link_new'];  
   	if(count($lists_of_all_friends)<1)      			
   		$no_record_found = "No Record Found";
   	$total_urls = $co->users_count_url($current['uid']);  	
   	$total_friends = $co->users_count_friend($current['uid']);  	
   	$total_friends_url = $co->users_count_shared_url($current['uid']);   
   	?>
<section class="dashboard-page">
   <div class="containt-area" id="dashboard_new">
      <div class="container">
         <div class="row">
            <div class="col-md-3 left-side">
               <h4>Hello, and Welcome!</h4>
               <button type="button" class="btn">Important Notice</button>
               <p>This page is only Available during a limited period of 
                  time. To save for these future use <a href="#" style="color: #a08f8f; "><u style="font-size: 15px;s">sign up</u></a> for your free 
                  personal LinkiBag account and start saving important links in your LinkiBag.
               </p>
               <button type="button" class="btn" style="background-color: #ff7f27;margin-top: 2px;">Free Sign Up</button>
            </div>
            <div class="containt-area-dash col-md-9" style="margin-top: -5px;">
               <!-- Tab panes -->        
               <div class="tab-content">
                  <form name="dash_form" method="post" id="share_urls_from_dash" action="index.php?p=dashboard&ajax=ajax_submit">
                     <input type="hidden" name="form_id" value="multiple_shared">
                     <input type="hidden" name="p" value="linkifriends">
                     <div class="tab-content-box">
                        <div class="user-name-dash">
                           <div class="row">
                              <div class="col-md-4 id">
                                 <h5> Share ID: <span style="background-color: #c3c3c3;font-size: 20px;
                                    color: #4d4d4d;padding: 3px 23px 3px 8px;">23205323</span></h5>
                              </div>
                              <div class="col-md-6 share">
                                 <p>Share with you by thisisfeliks@gmail.com on 4/21/2017 7:57am </br>
                                    This page will expire in <span style="color:#ff7f27">29 minutes</span> 
                                 </p>
                              </div>
                              <div class="col-md-2 print-btn">
                                 <div class="bottom-nav-link top-nav-link print">
                                    <a class="btn btn-default dark-gray-bg" href="index.php?p=mylinkifriends">Print</a>
                                    <div class="dropdown border-bg-btn" style="display: inline;">															
                                    </div>
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
                              <div class="btn btn-default dropdown-toggle link">Link <a href="index.php?p=linkifriends&order_by[first_name]=<?=$url_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
                           </div>
                        </li>
                        <li style="width:60%">
                           <div class="dropdown dropdown-design">
                              <div class="btn btn-default dropdown-toggle msg">Message <a href="index.php?p=linkifriends&order_by[last_name]=<?=$url_by?>"><i class="<?=$arrow_direction?>"></i></a></div>
                           </div>
                        </li>
                     </ul>
                     <div class="view-share-table-main">
                        <table class="border_block table table-design">
                           <tbody>
								<?php               
								$i=1;                                
								if(isset($_GET['page'])){         
									$i = ($item_per_page * ($_GET['page']-1))+1;                  
								}                               
								echo $no_record_found;   
								$j = 1;
								$urlposts = $co->fetch_all_array("SELECT * FROM `user_shared_urls` us, `user_urls` uu WHERE us.url_id=uu.url_id and email_id=:email_id and share_number=:share_number ",array('email_id'=>$_GET['email_id'],'share_number '=>$_GET['share_number']));
								
								foreach($urlposts as $urlpost){	  
									$i++; 
									if($j == 1){	
																	
								?>
									<tr class="first_row<?=$urlpost['num_of_visits'] > 0 ? ' read' : ' unread'?>" id="url_<?=$urlpost['shared_url_id']?>">
										<td style="width:30%"><a href="<?=$urlpost['url_value']?>" target="_blank"><?=$urlpost['url_value']?></a></td>
										<td style="width:70%">
											<p><?=$urlpost['url_desc']?></p>
										</td>
			
									</tr>
									<?php
									$j++;
									}else{
									?>
									<tr class="second_row<?=$urlpost['num_of_visits'] > 0 ? ' read' : ' unread'?>" id="url_<?=$urlpost['shared_url_id']?>">
										<td style="width:30%"><a href="<?=$urlpost['url_value']?>" target="_blank"><?=$urlpost['url_value']?></a></td>
										<td style="width:70%">
											<p><?=$urlpost['url_desc']?></p>
										</td>
									</tr>
									<?php 
									$j = 1;
									}
									}	
									?>
									
							</tbody>
                        </table>
                        <!--
                           <nav class="text-center">                
                           	<ul class="pagination"><?php //$page_links?></ul>              
                           </nav>-->
                     </div>
               </div>
               <div class="clearfix"></div>
               <div class="text-right"><a class="btn btn-default dark-gray-bg" onclick="move_to_category_multiple('#share_urls_from_dash','group','1');" href="#">Close</a></div>
            </div>
            </form>
         </div>
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
   .left-side h4 {color: #002d59;padding-top: 45px;font-size: 17px;}
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
<?php  }      ?>

