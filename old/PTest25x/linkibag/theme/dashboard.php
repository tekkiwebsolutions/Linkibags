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
      $co->page_title = "Dashboard | Linkibag";     
      $current = $co->getcurrentuser_profile();    
      $cid = -2;
      if(isset($_GET['cid']) and $_GET['cid']!='')          
         $cid = $_GET['cid'];
      
      if(!(isset($_GET['date_by']) or isset($_GET['msg_by']) or isset($_GET['url_by']) or isset($_GET['shared_by'])))
         $_SESSION['list_shared_links_by_admin'] = $co->list_shared_links_by_admin($cid);        
      

           
      $views=true;                  
      if(isset($_GET['views']) and $_GET['views']!=''){ 
         $item_per_page = $_GET['views'];       
      }else{            
         $item_per_page = 10;       
      }           
      $this_page='p=dashboard';      
      
      $only_current = '0';
      if(isset($_GET['only_current']) and $_GET['only_current']!='')          
         $only_current = 1;
      
      
         $urlposts_retrun = $co->get_all_urlposts($current['uid'],$item_per_page, $this_page, $cid, $only_current);        
         $urlposts = $urlposts_retrun['row'];
         $total_record = $urlposts_retrun['row_count'];
         $one_nonfriend_exist = $urlposts_retrun['non_friend_url_count'];
   
         $sponsoredposts_retrun = $co->get_all_urlposts($current['uid'],$item_per_page, $this_page, $cid, $only_current, 1);   
			 if(isset($sponsoredposts_retrun['row']) and count($sponsoredposts_retrun['row'])>0){
				$sponsoredposts = $sponsoredposts_retrun['row'];
				$urlposts = array_merge($urlposts, $sponsoredposts);
			 }     

         $data[] = array();
         
         $show_all_category_of_current_user = $co->fetch_all_array("SELECT * FROM `category` WHERE uid=:id",array('id'=>$current['uid']));
         
         $page_links = $urlposts_retrun['page_links'];  
         $page_link_new = $urlposts_retrun['page_link_new'];  
         //$list_shared_links_by_admin = $co->list_shared_links_by_admin('0');   
         if(count($urlposts)<1)              
            $no_record_found = "No Record Found";
      //}      
         if(isset($_GET['views']) and $_GET['views']!=''){
               $this_page .= '&views='.$_GET['views'];         
         }        
         /*       
         if(isset($_GET['delid'])){                
         $co->query_delete('user_urls', array('id'=>$_GET['delid']),'url_id=:id');                 
         $co->setmessage("error", "URL post has been successfully deleted");           
         echo '<script type="text/javascript">window.location.href="index.php?p=dashboard"</script>';       
         exit();        
         }        
         */       
         $total_urls = $co->users_count_url($current['uid']);     
         $total_friends = $co->users_count_friend($current['uid']);     
         $total_friends_url = $co->users_count_shared_url($current['uid']);  
         $total_unliked_urls = $co->users_count_shared_url($current['uid'],'unlike');  
         $total_liked_urls = $co->users_count_shared_url($current['uid'],'like');   
         $total_unrecommend_urls = $co->users_count_shared_url($current['uid'],'unrecommend');  
         $total_recommend_urls = $co->users_count_shared_url($current['uid'],'recommend');   
         
         //print_r($urlposts);
         //echo count($urlposts);
   
         if(isset($_GET['cid'])){
            $default_folder_name = $co->query_first("SELECT * FROM `category` WHERE uid=:uid and cid=:cid",array('uid'=>$current['uid'],'cid'=>$_GET['cid']));
            if(isset($default_folder_name['cname']) and $default_folder_name['cname'] != ''){
               $default_folder_name = $default_folder_name['cname'];
            }else{
               if($_GET['cid'] == 0 and $_GET['trash'] == 1)
                  $default_folder_name = 'Trash';  
               else     
                  $default_folder_name = 'Inbag';  
            }
         }else{
            $default_folder_name = 'Inbag';  
         }
         ?>
<section class="dashboard-page">
   <div class="container bread-crumb top-line">
      <div class="col-md-12">
         <p><a href="index.php">Home</a></p>
		 
		 
      </div>
   </div>
   <div class="containt-area mylinks_page" id="dashboard_new">
      <div class="container">
         <div class="col-md-3">      
            <?php include('dashboard_sidebar.php'); ?>    
         </div>
         <div class="containt-area-dash col-md-9">
				
				<?php if(!isset($_SESSION["a_deleted_text"])){ ?>
					<div class="padding-none">
                  <!--<label class="pull-right donotshowmessagebox" onclick="automatically_d()"><input type="checkbox" name="closemsg"> Do not show this message again</label> -->
                  <div class="clearfix"></div>
						<div class="alert alert-text dashboard-profile-links">
							<button type="button" onclick="automatically_d()" id="donotshowmessage" class="close" data-dismiss="alert">×</button>
							<div class="main-profile-user">
								<div class="border-text">
								  <p> All messages older than 30 days will be automatically deleted from your Inbag folder. Not to lose your links save them in My Links folder.</p>
								</div>
							</div>
						</div>
					</div>
				<?php }?>
            <div>
               <?php /*<ul class="nav nav-tabs" role="tablist">         
                  <li role="presentation" class="active"><a href="index.php?p=dashboard">My Links</a></li>         
                  <li role="presentation"><a href="index.php?p=shared-links">Share Links</a></li>          
                  <li class="pull-right">            
                     <div class="nav-tabs-filters">              
                        <div class="dropdown">                
                           <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Views&nbsp;<span class="caret"></span></button>                
                           <ul class="dropdown-menu pull-right">                  
                              <li><a href="index.php?p=dashboard&views=10">10</a></li>
                              <li><a href="index.php?p=dashboard&views=25">25</a></li>                  
                              <li><a href="index.php?p=dashboard&views=50">50</a></li>                  
                              <li><a href="index.php?p=dashboard&views=100">100</a></li>                  
                              <li><a href="index.php?p=dashboard">All</a></li>                
                           </ul>             
                        </div>             
                        <div class="dropdown">              
                           <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Filter by Category                 &nbsp;<span class="caret"></span></button>                
                           <ul class="dropdown-menu pull-right">                  
                              <li><a href="index.php?p=dashboard">All Categories</a></li>                 
                           <?php                    
                     foreach($categories as $category){
                     ?>                   
               <li><a href="index.php?p=dashboard&id=<?=$category['cid']?>"><?=$category['cname']?></a></li>
               <?php } ?>    
               </ul>             
            </div>
         </div>
         </li>        
         </ul> */?>       
         <!-- Tab panes -->        
         <div class="tab-content">
            <form name="dash_form" method="post" id="share_urls_from_dash" action="index.php?p=dashboard&ajax=ajax_submit">
               <div id="hidden_elements">
                  <input type="hidden" name="form_id" value="multiple_shared">
                  <input type="hidden" name="item_per_page" value="<?=$item_per_page?>"/>
                  <input type="hidden" name="this_page" value="<?=$this_page?>"/>
                  <input type="hidden" name="page" value="<?=isset($_GET['page']) ? $_GET['page'] : '1'?>"/>
                  <input type="hidden" name="cid" value="<?=$cid?>"/>
                  <input type="hidden" name="only_current" value="<?=$only_current?>"/>
               </div>
               <?php
                  if(isset($_GET)){                               
                     foreach($_GET as $k=>$v){
                        if($k != 'page' AND $k != 'cid' AND $k != 'only_current')   
                           echo '<input type="hidden" name="'.$k.'" value="'.$v.'"/>';
                     }  
                  }
                ?>
               <div class="tab-content-box">
                  <div style="display:none;"><?=isset($msg) ? $msg : ''?></div>
                  <div style="margin-bottom: 11px;" class="user-name-dash">
                     <div class="row">
                        <div class="col-md-6 col-xs-12">
                           <span style="display: inline-block; padding-top: 6px;position: relative;" class="text-orang" ><img style="vertical-align: text-top;" src="images/orang-icon.png" alt="bag Icon"> <?=$default_folder_name?> 
                           <?php if($total_friends_url > 0){ ?>
                           <span class="badge<?=($total_friends_url>0 ? ' round-red-badge' : '')?>" id="new_linkibag_message"><?=$total_friends_url?></span>
                        <?php } ?>
                           </span> &nbsp;&nbsp;&nbsp;&nbsp;
                           <span style="display: none;"><a href="javascript: void(0);" onclick="multiple_load_share_link_form('Unlike');" data-toggle="tooltip" title="Unlike"><i class="fa fa-heart-o" aria-hidden="true"><span class="badge round-unlike-badge" id="total_unlike_urls"><?=$total_unliked_urls?></span></i></a></span>&nbsp;&nbsp;

                           <span style="display: none;"><a href="javascript: void(0);" onclick="multiple_load_share_link_form('Like');" data-toggle="tooltip" title="Like"><i class="fa fa-heart" aria-hidden="true"></i><span class="badge round-like-badge"
                           id="total_like_urls"><?=$total_liked_urls?></span></a></span>
                           &nbsp;&nbsp;&nbsp;&nbsp;
                           <span style="display: none;"><a href="javascript: void(0);" onclick="multiple_load_share_link_form('Unrecommend');" data-toggle="tooltip" title="Unrecommend"><i class="fa fa-arrow-up unrecommend" aria-hidden="true"><span class="badge round-unrecommend-badge" id="total_unrecommend_urls"><?=$total_unrecommend_urls?></span></i></a></span>&nbsp;&nbsp;

                           <span style="display: none;"><a href="javascript: void(0);" onclick="multiple_load_share_link_form('Recommend');" data-toggle="tooltip" title="Recommend"><i class="fa fa-arrow-up recommend" aria-hidden="true"></i><span class="badge round-recommend-badge"
                           id="total_recommend_urls"><?=$total_recommend_urls?></span></a></span>
                   
                        </div>
						
						 <div class="col-md-6 col-xs-12 text-right">
						   <a class="share btn button-grey" href="javascript: void(0);" onclick="multiple_load_share_link_form('share');"><i class="fa fa-share-alt" aria-hidden="true"></i> Share</a>
                           <div class="input-group dashboard-search mylinks-search" style="border-color: rgb(127, 127, 127) !important;">
                              <input type="text" class="form-control input-sm" placeholder="Search" onkeypress="handle_not_submit(event);" name="url" id="url" value="<?=isset($_GET['url']) ? $_GET['url'] : ''?>">
                              <div class="input-group-btn">
                                 <button class="btn btn-default btn-sm" type="button" id="url_submit" onclick="search_form();"><i class="fa fa-search"></i></button>
                              </div>
                           </div>
                        </div>
						
						
                     
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
                     </div>
                  </div>
                  <div class="mail-dashboard">
                     <div class="table table-responsive margin-none">
                        <table class="table head_border_block">
						<tbody>
						<tr>
							<td class="width32">
								<?php
								   $page = '';
								   if(isset($_GET['page']))
									  $page = $_GET['page'];
								   $url_by = '&url_by=asc';
								   $arrow_direction = 'fa fa-caret-down';
								   if(isset($_GET['url_by']) and $_GET['url_by'] == 'asc'){
									  $url_by = '&url_by=desc';
									  $arrow_direction = 'fa fa-caret-up';
								   }elseif(isset($_GET['url_by']) and $_GET['url_by'] == 'desc'){
									  $url_by = '&url_by=asc';
									  $arrow_direction = 'fa fa-caret-down';
								   }
								   $cname = 'updated';
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
								   <div class="btn btn-default dropdown-toggle"><input type="checkbox" name="check" id="checkAll" value=""/>Link <a href="index.php?p=dashboard<?=$url_by?>"><i class="<?=$arrow_direction?>"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
								</div>
							</td>
							<td class="width28">
								<?php
								   $shared_by = '&msg_by=asc';
								   $arrow_direction = 'fa fa-caret-down';
								   
								   if(isset($_GET['msg_by']) and $_GET['msg_by'] == 'asc'){
									  $shared_by = '&msg_by=desc';
									  $arrow_direction = 'fa fa-caret-up';
								   }elseif(isset($_GET['msg_by']) and $_GET['msg_by'] == 'desc'){
									  $shared_by = '&msg_by=asc';
									  $arrow_direction = 'fa fa-caret-down';
								   }  
								   ?>
								<div class="dropdown dropdown-design">
								   <div class="btn btn-default dropdown-toggle">Message <a href="index.php?p=dashboard<?=$shared_by?>"><i class="<?=$arrow_direction?>"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
								</div>
							</td>
							<td class="width25">
								<?php
								   $shared_by = '&shared_by=asc';
									  $arrow_direction = 'fa fa-caret-down';
									  if(isset($_GET['shared_by']) and $_GET['shared_by'] == 'asc'){
										 $shared_by = '&shared_by=desc';
										 $arrow_direction = 'fa fa-caret-up';
									  }elseif(isset($_GET['shared_by']) and $_GET['shared_by'] == 'desc'){
										 $shared_by = '&shared_by=asc';
										 $arrow_direction = 'fa fa-caret-down';
									  }
								?>
								<div class="dropdown dropdown-design">
								   <div class="btn btn-default dropdown-toggle">Shared By <a href="index.php?p=dashboard<?=$shared_by?>"><i class="<?=$arrow_direction?>"></i></a>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
								</div>
							</td>
							<td class="width15"> 
								<?php
								   $date_by = '&date_by=asc';
									  $arrow_direction = 'fa fa-caret-down';
									  if(isset($_GET['date_by']) and $_GET['date_by'] == 'asc'){
										 $date_by = '&date_by=desc';
										 $arrow_direction = 'fa fa-caret-up';
									  }elseif(isset($_GET['date_by']) and $_GET['date_by'] == 'desc'){
										 $date_by = '&date_by=asc';
										 $arrow_direction = 'fa fa-caret-down';
									  }
								?>
								<div class="dropdown dropdown-design">
								   <div class="btn btn-default dropdown-toggle">Date / Time <a href="index.php?p=dashboard<?=$date_by?>"><i class="<?=$arrow_direction?>"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
								</div>
							</td>
						</tr>
						</tbody>
						</table>
						
						<table class="border_block table table-design margin-none" id="all_records">
                           <tbody>
                              <?php               
                                 $i=1;                                
                                 if(isset($_GET['page'])){         
                                    $i = ($item_per_page * ($_GET['page']-1))+1;                  
                                 }                               
                                 //echo $no_record_found;   
                                 
                                 $j = 1;
                                 //print_r($urlposts);
                                 foreach($urlposts as $urlpost){                                         
                                    /*$check_shared_by_is_user_friend = $co->query_first("SELECT ur.*,u.email_id FROM user_friends ur JOIN friends_request fr ON ur.request_id=fr.request_id LEFT JOIN profile p ON ur.fid=p.uid LEFT JOIN users u ON ur.fid=u.uid WHERE u.email_id=:email and ur.friend_id>'0' AND ((ur.uid=:id and fr.request_to=:id2 and ur.status<'1') OR (ur.uid=:id3 and ur.status>'0' and ur.status<'2')) and ur.status=:status",array('id'=>$current['uid'],'status'=>1,'id2'=>$current['uid'],'id3'=>$current['uid'],'email'=>$urlpost['email_id']));*/
                                 
                                    //print_r($check_shared_by_is_user_friend);
                                    $url_disabled = '';
                                    $title_msg = '';
                                    if($urlpost['share_type_change'] == 1)
                                    {
                                       $user_friend_class3 = ' text-grey';
                                    }
                                    else
                                    {
                                       $user_friend_class3 = ' text-success';
                                    }   
                                    if($urlpost['share_type_change'] == 1){
                                       $url_disabled = ' disabled';
                                       $title_msg = ' This link is not for share.';
                                    }
                                    $show_friend_class = '';
                                    if(isset($urlpost['friendstatus']) and $urlpost['friendstatus'] == 1){
                                       if($urlpost['share_type_change'] == 2){
                                          $url_disabled = '';
                                          $title_msg = " Added by someone from your friend's list";
                                       }else if($urlpost['share_type_change'] == 1){
                                          $url_disabled = ' disabled';
                                          $title_msg = ' This link is not for share.';
                                       }else if($urlpost['share_type_change'] == 3){
                                          $url_disabled = '';
                                          $title_msg = " Added this link to LinkiBag search";
                                       }  
                                       $user_friend_class = ' text-orange';
                                       $show_friend_class = ' user_friends';
                                    }else{
                                       if($urlpost['email_id'] != '' and $urlpost['email_id'] != $current['email_id']){
                                          $one_nonfriend_exist++;
                                          $url_disabled = ' disabled';
                                          $title_msg = " Shared by someone who is not in your friend's yet";
                                          $user_friend_class = ' text-grey';
                                          $show_friend_class = ' user_nonfriends';  
                                       }else{
                                          if($urlpost['sponsored_link'] == 1){
                                             $url_disabled = '';
                                             $title_msg = " Sponsored";
                                          }else{
                                             if($urlpost['share_type_change'] == 2){
                                                $url_disabled = '';
                                                $title_msg = " Added by you";
                                             }else if($urlpost['share_type_change'] == 1){
                                                $url_disabled = ' disabled';
                                                $title_msg = ' This link is not for share.';
                                             }else if($urlpost['share_type_change'] == 3){
                                                $url_disabled = '';
                                                $title_msg = " Added this link to LinkiBag search";
                                             }
                                          }   
                                          $show_friend_class = ' userself_links';   
                                          $user_friend_class = ' text-success';                                                              
                                       }
                                 
                                    }
                               
                                    //$time_ago = $co->time_elapsed_string($urlpost['shared_time']);          
                                    //$row_cat = $co->get_single_category($urlpost['url_cat']);           
                                    //$tatal_comments = $co->count_total_comments($urlpost['shared_url_id']);           
                                    //$co->url_listing_outout($urlpost, $time_ago, $row_cat, $tatal_comments, $current);  
                                    $class_name = '';
                                    $i++; 
                                    if($j == 1){
                                       $class_name = 'first_row';
                                    
                                    $j++;
                                    }else{
                                       $class_name = 'second_row';
                                    
                                    $j = 1;
                                    }
                                  
                                    ?>
                              <tr class="<?=$class_name.$show_friend_class?><?=$urlpost['num_of_visits'] > 0 ? ' read' : ' unread'?>" id="url_<?=$urlpost['shared_url_id']?>">
                                 <td class="width32">
                                    <span<?=(($urlpost['sponsored_link'] == 1) ? ' class="sponsored_url"' : '')?>><input type="checkbox" class="<?=(($urlpost['share_type_change'] == 1) ? 'urls_shared2' : 'urls_shared')?>"<?=$url_disabled?> name="share_url[]" value="<?=$urlpost['shared_url_id']?>"></span> &nbsp; <a data-toggle="tooltip" title="<?=$title_msg?>" href="index.php?p=scan_url&id=<?=$urlpost['shared_url_id']?>&url=<?=urlencode($urlpost['url_value'])?>" target="_blank"><?=(strlen($urlpost['url_value']) > 35) ? substr($urlpost['url_value'],0,35) : $urlpost['url_value']?><span style="display: none;"><?=$urlpost['url_value']?></span></a>
                                    <?php /*<span class="visit-icon"><a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>" data-toggle="tooltip" title="<?=(($user_friend_class == ' text-grey') ? 'Not for share' : 'I may share this link with selected users')?>"><i class="fa fa-circle<?=$user_friend_class?>"></i></a></span>*/ ?>
                                    <span class="visit-icon"><a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>" data-toggle="tooltip" title="<?=(($user_friend_class3 == ' text-grey') ? 'Not for share' : 'I may share this link with selected users')?>"><i class="fa fa-circle<?=$user_friend_class3?>"></i></a></span>
                                    <!-- Modal -->
                                    <div class="modal fade" id="succ_<?=$urlpost['shared_url_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                       <div class="modal-dialog modal-sm">
                                          <div class="modal-content">
                                             <div class="modal-header modal-header-success">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4>You are about to leave Linkibag</h4>
                                             </div>
                                             <div class="modal-body">
                                                <p>You will be visiting:</p>
                                                <h5><?=$urlpost['url_value']?></h5>
                                                <div class="text-center reduct">  
                                                   <span class="bottom-nav">              
                                                   <a class="btn btn-default btn-success" href="<?=$urlpost['url_value']?>" target="_blank">Continue</a>
                                                   <a class="btn btn-default btn-danger" class="close" data-dismiss="modal" aria-hidden="true">Cancel</a>
                                                   </span>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- /.modal-content -->
                                       </div>
                                       <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                    <!-- Modal -->
                                 </td>
                                 <td class="width28"><a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>"><?=((strlen($urlpost['url_desc']) > 35) ? substr($urlpost['url_desc'],0,35) : $urlpost['url_desc'])?><span style="display: none;"><?=$urlpost['url_desc']?></span></a></td>
                                 <td class="width25"><a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>"><?=($urlpost['email_id'] == '') ? 'Sponsored' : $urlpost['email_id']?></a></td>
                                 <td class="width15"><?=date('m/d/Y', $urlpost['shared_time'])?>   <?=date('h:i a', $urlpost['shared_time'])?></td>
                              </tr>
                              <?php } ?>
                              <?php
                               if($i == 1){
                                 if(isset($_GET['cid']) and $_GET['cid'] > 0)
                                    echo '<td colspan="4">This folder is empty.</td>';
                                 else
                                    echo '<td colspan="4">No, record found.</td>';    
                              }
                              /*
                              if(isset($_SESSION['list_shared_links_by_admin']) and count($_SESSION['list_shared_links_by_admin']) > 0 ){
                           
                                 $list_shared_links_by_admin = $_SESSION['list_shared_links_by_admin'];

                                 foreach($list_shared_links_by_admin as $list_shared_links_by_admn){
                                    $time_ago = $co->time_elapsed_string($list_shared_links_by_admn['created_time']);   
                                    if (!preg_match("~^(?:f|ht)tps?://~i", $list_shared_links_by_admn['url_value'])) {
                                       $list_shared_links_by_admn['url_value'] = "http://" . $list_shared_links_by_admn['url_value'];
                                    }
                                 ?>
                              <tr style="position: relative;">
                                 <td style="width:32%">
                                    <!--<span><input type="checkbox" name="check" value=""></span>--> &nbsp; <a target="_blank" href="<?=$list_shared_links_by_admn['url_value']?>"><?=$list_shared_links_by_admn['url_value']?></a><span class="visit-icon"><a href="<?=$list_shared_links_by_admn['url_value']?>"><i class="fa fa-circle text-success"></i></a></span>
                                 </td>
                                 <td style="width:28%"><?=((isset($list_shared_links_by_admn['url_desc']) and $list_shared_links_by_admn['url_desc'] != '') ? substr($list_shared_links_by_admn['url_desc'] , 0, 20) : 'Sponsored')?>...</td>
                                 <td style="width:25%">Sponsored</td>
                                 <td style="width:15%;padding-left: 0px;" class="text-right"><?=date('m/d/Y', $list_shared_links_by_admn['created_time'])?>   <?=date('h:ia', $list_shared_links_by_admn['created_time'])?>
                                 </td>
                              </tr>
                              <?php
                                 }
                              }*/   
                              ?>
                              <?php /*
                              <?php if($one_nonfriend_exist>0){ ?>
                              <tr>
                                 <td colspan="4" align="left" style="padding-right: 162px;">
                                    <p><input type="checkbox" id="display_all_messages_from_friends_btn" value="1" onclick="display_all_messages_from_friends('#share_urls_from_dash');"<?=($current['hide_nonfriend_msg']==1 ? ' checked="checked"' : '')?>>&nbsp;<span id="count_only_hidden_messages"><?=($current['hide_nonfriend_msg']==1 ? 'Displaying only messages from friends ('.$one_nonfriend_exist.' hidden messages)' : 'Display only messages from friends')?></span></p>
                                 </td>
                              </tr>
                              <?php } ?>
                              */ ?>
                           </tbody>
                        </table>
                     </div>
						<?php if($one_nonfriend_exist>0){ ?>
							<p><input type="checkbox" id="display_all_messages_from_friends_btn" value="1" onclick="display_all_messages_from_friends('#share_urls_from_dash');"<?=($current['hide_nonfriend_msg']==1 ? ' checked="checked"' : '')?>>&nbsp;<span id="count_only_hidden_messages"><?=($current['hide_nonfriend_msg']==1 ? 'Displaying only messages from friends ('.$one_nonfriend_exist.' hidden messages)' : 'Display only messages from friends')?></span></p>
						<?php } ?>
                     <!--
                        <nav class="text-center">                
                           <ul class="pagination"><?php //$page_links?></ul>              
                        </nav>-->
                     <?php
                        if(isset($_SESSION['list_shared_links_by_admin']) and count($_SESSION['list_shared_links_by_admin']) > 0 ){
                           
                           $list_shared_links_by_admin = $_SESSION['list_shared_links_by_admin'];
                        ?>
                     <div class="text-right" style="display: none;">
                        <a style="color: #484848; font-size: 12px;" href="index.php?p=renew">Sponsored <img src="images/cancel.jpg"></a>
                     </div>
                     <div class="table table-responsive margin-none" style="display: none;">
                        <table class="border_block table table-design sponsored-table margin-none">
                           <tbody>
                              <?php 
                                 foreach($list_shared_links_by_admin as $list_shared_links_by_admn){
                                    $time_ago = $co->time_elapsed_string($list_shared_links_by_admn['created_time']);   
                                    if (!preg_match("~^(?:f|ht)tps?://~i", $list_shared_links_by_admn['url_value'])) {
                                       $list_shared_links_by_admn['url_value'] = "http://" . $list_shared_links_by_admn['url_value'];
                                    }
                                 ?>
                              <tr style="position: relative;">
                                 <td style="width:32%">
                                    <!--<span><input type="checkbox" name="check" value=""></span>--> &nbsp; <a target="_blank" href="<?=$list_shared_links_by_admn['url_value']?>"><?=$list_shared_links_by_admn['url_value']?></a><span class="visit-icon"><a href="<?=$list_shared_links_by_admn['url_value']?>"><i class="fa fa-circle text-success"></i></a></span>
                                 </td>
                                 <td style="width:28%"><?=((isset($list_shared_links_by_admn['url_desc']) and $list_shared_links_by_admn['url_desc'] != '') ? $list_shared_links_by_admn['url_desc'] : 'Sponsored')?></td>
                                 <td style="width:25%">Sponsored</td>
                                 <td style="width:15%;padding-left: 0px;" class="text-right"><?=date('m/d/Y', $list_shared_links_by_admn['created_time'])?>   <?=date('h:ia', $list_shared_links_by_admn['created_time'])?>
                                 </td>
                              </tr>
                              <?php
                                 }
                                 ?>
                           </tbody>
                        </table>
                     </div>
                     <?php 
                        $total_page_count = (ceil($total_record / $item_per_page)); 
                        if($total_page_count == 0)
                           $total_page_count = 1;
                     ?>
						<div class="row">
						    <?php 
								if($total_page_count >0){
								$prev_link ='';									
								if(isset($_GET['page']) and $_GET['page'] > 1){
									if($_GET['p'] =='dashboard'){
										$prev_link = 'index.php?p=dashboard';
									}else{
										$prev_link = $_GET['page'] - 1;
									}
								}
								$next_link ='';
								if($_GET['p'] =='dashboard'){
									$next_link = 'index.php?page=2&p=dashboard';
								}else{
									$next_link = $_GET['page'] + 1;
								}
							?>
							<div class="col-md-11 col-xs-12">
								<div class="arrow_icons">
									<?php if($total_page_count >1){ ?>
										<?php 
									    $_GET['page']='';
										if($_GET['page'] == 1){ ?>
											<a class="pull-left" title="Previous" href="<?=$prev_link?>"><<</a>
										<?php } ?>
										<?php if($total_page_count != $_GET['page']){ ?>
											 <a class="pull-right" title="Next" href="<?=$next_link?>">>></a>
										<?php } ?>
									<?php } ?>
								</div> 
							</div>
							<?php } ?>
							<div class="col-md-1 col-xs-12">
								<div class="row">
									<small>Page <?=isset($_GET['page']) ? $_GET['page'] : 1?> of <?=$total_page_count?></small>
								</div>
							</div>
						</div>
					 <?php 
                        //unset($_SESSION['list_shared_links_by_admin']);
                        } 
                        ?>
                  </div>
               </div>
               <?php 
                  $total_page_count = (ceil($total_record / $item_per_page)); 
                  if($total_page_count == 0)
                     $total_page_count = 1;
                  
				  
				  
				  if(isset($_GET['page']) and $_GET['page'] > 1){
					
					if($total_page_count > $_GET['page']){
						$next_page = $_GET['page']+1;
					    $next ='index.php?page='.$next_page.'&p=dashboard';
					}else{
						$next ='index.php?page='.$_GET['page'].'&p=dashboard';
					}   
                  ?>
				  
				  <div class="row">
					<div class="col-md-11 col-xs-12">
						<div class="arrow_icons">
							   <a class="pull-left" title="Previous" href="index.php?page=<?=$_GET['page']-1?>&p=dashboard"><<</a>
								<?php if($total_page_count != $_GET['page']){ ?>
									<a class="pull-right" title="Next" href="<?=$next?>">>></a>
								<?php }?>
						</div> 
					</div>
					<div class="col-md-1 col-xs-12"><div class="row"><small>Page <?=isset($_GET['page']) ? $_GET['page'] : 1?> of <?=$total_page_count?></small></div></div>
				</div>
               <?php } ?>
               <div class="bottom-nav-link table-design margin-none">
                  <div class="bottom-nav-link-main">
                     <div  style="padding: 0px;" class="col-md-7">
                       
                        <a class="share-footer btn button-grey" href="javascript: void(0);" onclick="multiple_load_share_link_form('share');"><i class="fa fa-share-alt" aria-hidden="true"></i> Share</a>
                        &nbsp;
                        <a class="btn btn-default dark-gray-bg" href="javascript: void(0);" onclick="multiple_load_share_link_form('mark_as_unread');">Unread</a>&nbsp;
                        <a class="btn btn-default dark-gray-bg" href="javascript: void(0);" onclick="multiple_load_share_link_form('mark_as_del');">Delete</a>                 
                     </div>
                     
                     <div style="width: auto; margin: 0px ! important;" class="col-md-3 pull-right">                                
                        <?=$page_link_new?>                 
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
   </div>
   </div>
</section>
<style>
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
   .text-grey{
	   color: grey;
   }
   .text-success{
       color: green;
   }
   .round-like-badge {
      background: #ff0000 none repeat scroll 0 0;
      font-size: 11px;
      height: 17px;
      line-height: 16px;
      min-width: 17px;
      padding: 0 4px;
      position: absolute;
      top: -7px;
      left: 131px;
   }
   .round-unlike-badge {
      background: #ff0000 none repeat scroll 0 0;
      font-size: 11px;
      height: 17px;
      line-height: 16px;
      min-width: 17px;
      padding: 0 4px;
      position: absolute;
      top: -17px;
      right: -2px;
   }
   .fa-heart{
      color: red;
   }
   .recommend{
      color: red;
   }
   .round-recommend-badge {
      background: #ff0000 none repeat scroll 0 0;
      font-size: 11px;
      height: 17px;
      line-height: 16px;
      min-width: 17px;
      padding: 0 4px;
      position: absolute;
      top: -7px;
      left: 184px;
   }
   .round-unrecommend-badge {
      background: #ff0000 none repeat scroll 0 0;
      font-size: 11px;
      height: 17px;
      line-height: 16px;
      min-width: 17px;
      padding: 0 4px;
      position: absolute;
      top: -17px;
      right: -2px;
   }
</style>
<script>
   /*
   $("#div2").hover(function () {
        $(this).append($('<span class="tst"> HOVERING!!!!! </span>'));
       setTimeout(function(){
         $('.tst').remove(); 
      }, 1000);
    });*/

   $('table tr td:first-child, table tr td:second-child').hover(function(){
      var httext = $(this).find('a span').text();
      var slen = httext.length;
      if(slen < '35')
      {
         return;
      }   
      $(this).append($('<span class="tst"> '+ httext + '</span>'));
      }, function(){
         $('.tst').remove(); 
      });


   function handle_not_submit(e){
      if(e.keyCode === 13){
         e.preventDefault(); // Ensure it is only this code that rusn
   
         //alert("Enter was pressed was presses");
      }
   }
   
   
   
   function search_form(){
      $("#share_urls_from_dash").removeAttr('method');
      $('#share_urls_from_dash').attr('method', 'GET');
      $('#hidden_elements').html('');
      $("#share_urls_from_dash").submit();
   }
   
   function display_all_messages_from_friends(submitform){
      $(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
      $('#display_all_messages_from_friends_btn').attr('disabled', 'disabled');
      if($('#display_all_messages_from_friends_btn').prop('checked') == true){
         $("#count_only_hidden_messages").text('Displaying only messages from friends...');
         $.ajax({
            type: "POST",
            url: 'ajax/nonfriend_msg_action.php',
            data: {hidenonfriend:1},
            cache: false,
            contentType: false,
            processData: false,
            success: function(res2){                                 
               location.reload();
            }
         });
            /*$("#dialog_confirm").html('Would you like to Delete messages from users who are not your friends yet? If yes please move them to Trash, if no, just filter to show links from Friends.');
               $("#dialog_confirm" ).dialog({
                  autoOpen: false, 
                  modal: true,
                  buttons: {
                     "Yes" : function() {
                        if($("#all_records tbody .user_nonfriends").length){
                           $("#all_records tbody .user_nonfriends .urls_shared").removeAttr("disabled");
                           $("#all_records tbody .user_nonfriends .urls_shared").prop("checked", true);
                           var formdata = new FormData($(submitform)[0]);
                           formdata.append('cat','0');
                           formdata.append('form_id','move_to_cat_multiple');
                           formdata.append('type','category');
                           $.ajax({
                              type: "POST",
                              url: $(submitform).attr('action'),
                              data: formdata,
                              cache: false,
                              contentType: false,
                              processData: false,
                              success: function(res2){                                 
                                 res2 = JSON.parse(res2);            
                                 if(res2.msg){
                                    $(".urls_shared").removeAttr( "checked" );      
                                    $("#dialog_success").html(res2.msg_content);                                  
                                    window.location.href="index.php?p=dashboard&cid=0&trash=1";
                                       
                                    $( "#dialog_success" ).dialog( "open" );  
                                    $(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
                                    
                                    $("#all_records tbody .user_nonfriends .urls_shared").attr("disabled", "disabled"); 
                                    
                                 }else if(res2.error){
                                    $("#dialog_error").html(res2.error);
                                    $( "#dialog_error" ).dialog( "open" );
                                 }
                              }
                           });                        
                        }else{
                           $("#dialog_error").html("There are no Link(s) which are shared by someone who are not in your friend's list yet?");
                           $( "#dialog_error" ).dialog( "open" );                   
                           $("#display_all_messages_from_friends_btn").prop("checked", false);
                        }
                        $(this).dialog("close");   
                      },
                      "No" : function() {
                        if($("#all_records tbody .user_friends").length){
                           var total_user_friends = $("#all_records tbody .user_friends").length;
                           var total_record = <?=$total_record?>;
                           var hidden_messages = parseInt(total_record) - parseInt(total_user_friends);
                           $("#count_only_hidden_messages").text('Displaying only messages from friends ('+hidden_messages+' hidden messages)');
                           $("#all_records tbody .user_nonfriends").hide();
                           $("#all_records tbody .userself_links").hide(); 
                        }else{                              
                           $("#dialog_error").html('There are no Link(s) which are shared by your friends.');
                           $( "#dialog_error" ).dialog( "open" );                   
                           $("#display_all_messages_from_friends_btn").prop("checked", false);
                        }
                                    
                        $(this).dialog("close");
                      },
                  },  
               
               });
               $("#dialog_confirm").dialog( "open" );
               $(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_confirm" );
               $( ".ui-dialog-title" ).html( "LinkiBag" );  */
               
            
      }else{
         $("#count_only_hidden_messages").text('Displaying all messages...');
         $.ajax({
            type: "POST",
            url: 'ajax/nonfriend_msg_action.php',
            data: {hidenonfriend:0},
            cache: false,
            contentType: false,
            processData: false,
            success: function(res2){                                 
               location.reload();
            }
         });
      }
            
      
      
   }
   
   
</script>      
<?php  }      ?>