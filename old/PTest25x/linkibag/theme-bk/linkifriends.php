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
   
   	if(!(isset($_GET['first_name']) or isset($_GET['last_name']) or isset($_GET['email_id']) or isset($_GET['fgroup']) or isset($_GET['date'])))
   		$_SESSION['list_shared_links_by_admin'] = $co->list_shared_links_by_admin('0');
   
   	$item_per_page = 10; 	
   	$this_page='p=linkifriends'; 
   	$fgroup = 'no';
   	if(isset($_GET['gid']))
   		$fgroup = $_GET['gid'];
   	//$fstatus = 'all';
   	$fstatus = 1;
   	if(isset($_GET['fstatus']))
   		$fstatus = $_GET['fstatus'];
   	
   	//$to_time = strtotime("2008-12-13 10:42:00");
   	//$from_time = strtotime("2008-12-13 10:21:00");
   	//echo round(abs($to_time - $from_time) / 60,2). " minute";
   
   	$lists_of_all_friend = $co->list_all_friends_of_current_user($current['uid'], $fstatus, $item_per_page, $this_page,$fgroup);
   	
   	$show_all_gps_of_current_user = $co->fetch_all_array("SELECT * FROM `groups` WHERE uid=:id ORDER BY defaults DESC",array('id'=>$current['uid'])); 
   	
   	$lists_of_all_friends = $lists_of_all_friend['row'];  
   	$page_link_new = $lists_of_all_friend['page_link_new'];  
   	
   	$total_record = $lists_of_all_friend['row_count'];
   	if(count($lists_of_all_friends)<1)      			
   		$no_record_found = "No Record Found";
   
   	$total_urls = $co->users_count_url($current['uid']);  	
   	$total_friends = $co->users_count_friend($current['uid']);  	
   	$total_friends_url = $co->users_count_shared_url($current['uid']);   
   
   	?>
<section class="dashboard-page">
   <div class="container bread-crumb top-line">
      <div class="col-md-7">
         <p>
            <a href="index.php">Home</a> > Groups<!--Linki Friends-->
         </p>
      </div>
      <div class="col-md-5 text-right">
         <!--<div class="dropdown dropdown-bg-none top-user-drop pull-right">
            <a data-toggle="dropdown" class="btn dropdown-toggle pull-right" aria-expanded="false"><?php//$current['email_id']?> <li class="caret"></li></a>
            <ul class="dropdown-menu">
            	<li><a href="index.php?p=dashboard"><i aria-hidden="true" class="fa fa-tachometer"></i> Dashboard</a></li>
            	<li><a href="index.php?p=friends"><i aria-hidden="true" class="fa fa-list"></i> Friend List</a></li>
            	<li><a href="index.php?p=edit-profile"><i aria-hidden="true" class="fa fa-pencil"></i> Edit Profile</a></li>						
            	<li><a href="logout.php"><i aria-hidden="true" class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
            </div>-->
      </div>
   </div>
   <div class="containt-area" id="dashboard_new">
      <div class="container">
         <div class="col-md-3">      
            <?php include('dashboard_sidebar.php'); ?>    
         </div>
         <div class="containt-area-dash col-md-9" style="margin-top: -5px;">
            <!-- Tab panes -->        
            <div class="tab-content">
               <form name="dash_form" method="post" id="share_urls_from_dash" action="index.php?p=dashboard&ajax=ajax_submit">
                  <input type="hidden" name="form_id" value="multiple_shared">
                  <input type="hidden" name="item_per_page" value="<?=$item_per_page?>"/>
                  <input type="hidden" name="this_page" value="<?=$this_page?>"/>
                  <?php 
                  if(isset($_GET)){											
                  	foreach($_GET as $k=>$v){	
                  		echo '<input type="hidden" name="'.$k.'" value="'.$v.'"/>';
                  	}	
                  }

                  if(isset($_GET['hide_nonfriend_msg'])){
                     $show_only_friends_urls = 'index.php?p=linkifriends';
                  }else{
                     $show_only_friends_urls = 'index.php?p=linkifriends&fstatus=1&hide_nonfriend_msg=1';
                  }   
                  if(isset($_GET['gid']))
                     $show_only_friends_urls .= '&gid='.$_GET['gid'];                                                
                     
                  ?>
                  <div class="tab-content-box">
                     <div style="display:none;"><?=isset($msg) ? $msg : ''?></div>
                     <div style="margin-top: 12px; margin-bottom: 3px;" class="user-name-dash">
                        <div class="row">
                           <?php
                              if(isset($_GET['gid'])){
                              	$default_group_name = $co->query_first("SELECT * FROM `groups` WHERE uid=:uid and group_id=:gid",array('uid'=>$current['uid'],'gid'=>$_GET['gid']));
                              	if(isset($default_group_name['group_name']) and $default_group_name['group_name'] != ''){
                              		$default_group_name = $default_group_name['group_name'];
                              	}else{
                              		$default_group_name = $co->query_first("SELECT * FROM `groups` WHERE group_id=:gid",array('gid'=>$_GET['gid']));
                              		if(isset($default_group_name['group_name']) and $default_group_name['group_name'] != ''){
                              			$default_group_name = $default_group_name['group_name'];
                              		}else{
                              			$default_group_name = 'Linki Friends';		
                              		}
                              		
                              	}
                              }else{
                              	if(isset($_GET['fstatus']) and $_GET['fstatus'] == 0)
                              		$default_group_name = 'Pending Invites';	
                              	else if(isset($_GET['fstatus']) and $_GET['fstatus'] == 1)
                              		$default_group_name = 'New Connect Requests';	
                              	else
                              		$default_group_name = 'Linki Friends';	
                              }	
                              
                              ?>
                           <div class="col-md-4">
                              <h4 class="text-green user-name-dash"><span style="position: relative;"><a href="index.php?p=mylinkifriends" style="display: none;"><i class="fa fa-chevron-left text-green"></i></a><!--&nbsp;&nbsp;<i class="fa fa-users"></i>--> <?=$default_group_name?> <span style="margin: -4px -5px 0 1px;" class="badge round-red-badge" id="new_linkibag_friends"><?=$total_record?><?php /*<?=(isset($_GET['fstatus']) and $_GET['fstatus'] == 0) ? $total_urls : $total_friends?>*/ ?></span></span>
                                 <?php if(!isset($_GET['fstatus'])) { ?>
                                 <!--<a class="btn button-grey pull-right" href="javascript: void(0)" data-toggle="modal" data-target="#addmultipleusers">Add Users</a>-->
                                 <?php } ?>
                              </h4>
                           </div>
                           <div class="col-md-8">
                              <div class="row text-right">
                                 <div class="col-md-2 text-left" style="padding-right: 0px;">
                                    <?php
                                       /*
                                       				<button type="button" class="btn button-grey">View</button>
                                       			
                                       
                                                                                      
                                       			<select style="text-align: left;width: 107px;border-radius: 0px;" name="filter" 
                                       				class="move_to_cat_w btn btn-default dropdown-toggle"
                                       				onchange="fiter_with_group(this.value)">
                                       					<option value="">All</option>										
                                       					<option value="new"<?=((isset($_GET['gid']) and $_GET['gid'] == 'new') ? ' selected="selected"' : '')?>>New</option>										
                                    <option value="friends"<?=((isset($_GET['gid']) and $_GET['gid'] == 'friends') ? ' selected="selected"' : '')?>>Friends</option>
                                    <option value="-1"<?=((isset($_GET['gid']) and $_GET['gid'] == '-1') ? ' selected="selected"' : '')?>>Blocked</option>
                                    </select>
                                    */
                                    ?>                               
                                    <a class="btn button-grey pull-right" href="index.php?p=mylinkifriends">My Groups</a>	
                                 </div>
                                 <div class="col-md-10 pull-right">
                                    <div  style="border-color: rgb(127, 127, 127) !important;" class="input-group dashboard-search">
                                       <input type="text" class="form-control input-sm" placeholder="Search" onkeypress="handle_not_submit(event);" name="url" id="url" value="<?=isset($_GET['url']) ? $_GET['url'] : ''?>">
                                       <div class="input-group-btn">
                                          <button onclick="search_form();" id="url_submit" type="button" class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
                                       </div>
                                    </div>
                                    <div class="bottom-nav-link top-nav-link">
                                       <?php if(isset($_GET['fstatus']) and $_GET['fstatus']==0){ ?>
                                          <a class="btn btn-default dark-gray-bg" href="javascript: void(0);" onclick="move_to_category_multiple('#share_urls_from_dash','group-pendinginvite');">Move to</a>
                                       <?php }else{ ?>
                                          <a class="btn btn-default dark-gray-bg" href="javascript: void(0);" onclick="move_to_category_multiple('#share_urls_from_dash','group');">Move to</a>
                                       <?php } ?>
                                                        
                                       <div class="dropdown border-bg-btn" style="display: inline;">
                                          <select style="text-align: left;" name="move" class="move_to_cat_w btn btn-default dropdown-toggle" id="move_to_cat">
                                             <?php /*
                                             <option value="-2">Spam</option>
                                             <option value="-1">Blocked</option>
                                             <option value="0">Ungrouped</option>
                                             <option value="">My Groups</option>*/ ?>
                                             <?php
                                                foreach($show_all_gps_of_current_user as $list){
                                                	$sel = '';
                                                //if(isset($list['cid']) and $list['cid'] == $row['url_cat'])
                                                //	$sel = ' selected="selected"';
                                                	?>
                                             <option value="<?=$list['group_id']?>"<?=$sel?>><?=$list['group_name']?></option>
                                             <?php
                                                }
                                                ?>										
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <ul class="head-design table-design">
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
                        /*
                           <li style="width:20%;">
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
                           <div class="btn btn-default dropdown-toggle"><input type="checkbox" name="check" id="checkAll" value=""/>First Name <a href="index.php?p=linkifriends&fstatus=<?=$fstatus?>&gid=<?=$fgroup?>&order_by[first_name]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("first_name",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                        </div>
                        </li>
                        <li style="width:20%;">
                           <div class="dropdown dropdown-design">
                              <div class="btn btn-default dropdown-toggle">Last Name <a href="index.php?p=linkifriends&fstatus=<?=$fstatus?>&gid=<?=$fgroup?>&order_by[last_name]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("last_name",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                           </div>
                        </li>
                        */ ?>
                        <?php if(isset($_GET['fstatus']) and $_GET['fstatus'] == '0'){ ?>
                        <li style="width:25%;">
                           <div class="dropdown dropdown-design">
                              <div class="btn btn-default dropdown-toggle"><input type="checkbox" name="check" id="checkAll" value=""/> Date/Time <a href="index.php?p=linkifriends&fstatus=<?=$fstatus?>&gid=<?=$fgroup?>&order_by[date_time_created]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("date_time_created",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                           </div>
                        </li>
                        <?php } ?>
                        <?php if(!isset($_GET['fstatus'])){ ?>
                        <li style="width:25%;">
                           <div class="dropdown dropdown-design">
                              <div class="btn btn-default dropdown-toggle"><input type="checkbox" name="check" id="checkAll" value=""/> Name <a href="index.php?p=linkifriends&fstatus=<?=$fstatus?>&gid=<?=$fgroup?>&order_by[date_time_created]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("date_time_created",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                           </div>
                        </li>
                        <?php } ?>
                        <li style="width:25%">
                           <div class="dropdown dropdown-design">
                              <div class="btn btn-default dropdown-toggle">Email <a href="index.php?p=linkifriends&fstatus=<?=$fstatus?>&gid=<?=$fgroup?>&order_by[email_id]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("email_id",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                           </div>
                        </li>
                        <li style="width:25%;<?=((isset($_GET['fstatus']) and $_GET['fstatus'] == '0') ? ' display: none;' : '')?>">
                           <div class="dropdown dropdown-design">
                              <div class="btn btn-default dropdown-toggle">Group (s) <a style="display:none;" href="index.php?p=linkifriends&fstatus=<?=$fstatus?>&gid=<?=$fgroup?>&order_by[fgroup]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("fgroup",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                           </div>
                        </li>
                        <?php if(isset($_GET['fstatus']) and $_GET['fstatus'] == '0'){ ?>
                        <li style="width:25%">
                           <div class="dropdown dropdown-design">
                              <div class="btn btn-default dropdown-toggle">Message <a href="index.php?p=linkifriends&fstatus=<?=$fstatus?>&gid=<?=$fgroup?>&order_by[email_id]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("email_id",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                           </div>
                        </li>
                        <li style="width:25%;">
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
                              <div class="btn btn-default dropdown-toggle">Invites <a style="display:none;" href="index.php?p=linkifriends&fstatus=<?=$fstatus?>&gid=<?=$fgroup?>&order_by[fid]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("fid",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                           </div>
                        </li>
                        <?php } ?>
                        <?php
                           /*	
                           <li style="width:20%">
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
                           <div class="btn btn-default dropdown-toggle">Profile Details <a href="index.php?p=linkifriends#"></a></div>
                        </div>
                        </li>
                        */
                        ?>
                        
                        <?php if(!isset($_GET['fstatus'])){ ?>
                        <li style="width:25%;">
                           <div class="dropdown dropdown-design">
                              <div class="btn btn-default dropdown-toggle">Friends Since <a href="index.php?p=linkifriends&fstatus=<?=$fstatus?>&gid=<?=$fgroup?>&order_by[date_time_created]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("date_time_created",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                           </div>
                        </li>
                        <?php } ?>
                     </ul>
                     <div class="mail-dashboard">
                        <table class="border_block table table-design margin-none" id="all_records">
                           <tbody>
                              <?php
                                 $rowsfriends = array();               
                                 $i=1;                                
                                 if(isset($_GET['page'])){         
                                 	$i = ($item_per_page * ($_GET['page']-1))+1;                  
                                 }                               
                                 //echo $no_record_found;   
                                 $j = 1;
                                 //print_r ($lists_of_all_friends);
                                       
                                 $one_nonfriend_exist = 0;   
                                 foreach($lists_of_all_friends as $list){
                                    if($list['status'] != 1)
                                        $one_nonfriend_exist++;     
                                    
                                 	$sql = "SELECT g.group_name FROM `groups` g, `groups_friends` gf WHERE gf.uid=:uid and g.group_id=gf.groups and (gf.email_id=:email OR gf.email_id=:request_email)";
                                 	$cond['uid'] = $current['uid'];
                                 	$cond['email'] = $list['fid'];
                                    $cond['request_email'] = $list['request_email'];
                                 	if($fgroup != 'no'){
                                       /*if($fgroup != 0){
                                    		$sql .= " and gf.groups=:gid";
                                    		$cond['gid'] = $fgroup;
                                       }else{
                                         // for ungrouped group
                                          $sql .= " and gf.groups!=:gid";
                                          $cond['gid'] = 0;
                                       } */  
                                 	}	
                                 	$groups = $co->fetch_all_array($sql,$cond);
                                    
                                    $group_names =  array('Ungrouped');
                                 	if(isset($groups) and count($groups) > 0){
                                 		$group_names = array();
                                       $grpcount = 0;
                                 		foreach($groups as $gp){
                                 			$group_names[$grpcount] = $gp['group_name'];
                                 			$grpcount++;
                                 		}
                                 	}
                                    
                                    /*if($fgroup != 0){
                                    	if(in_array('Ungrouped', $group_names) and $fgroup != 'no')
                                          continue;
                                    }else{
                                       if(!in_array('Ungrouped', $group_names) and $fgroup != 'no')
                                          continue;
                                    }*/
                                 	
                                 	$request_link = 'javascript: void(0);';
                                 	if(($list['status'] > 0)){																	
                                 		$read_status = ' read';																	
                                 	}else{
                                 		if(($list['request_to'] == $current['uid']))
                                 			$request_link = 'index.php?p=request_response&id='.$list['request_id'];
                                 		
                                 		if(($list['read_status'] == 1))
                                 			$read_status = ' read';																	
                                 		else	
                                 			$read_status = ' unread';																	
                                 	}
                                    if(($list['request_to']>0)){
                                       $request_email = $list['email_id'];
                                    }else{
                                       $request_email = $list['request_email'];
                                    }
                                    if(($list['status'] == 0)){
                                       $status = 'Pending'; 
                                    }else if(($list['status'] == 1)){
                                       $status = 'Confirmed'; 
                                    }else if(($list['status'] == 2)){
                                       $status = 'Declined'; 
                                    }else{
                                       $status = date('m/d/Y', strtotime($list['date']));
                                    }

                                    $groupstring = (implode(", ", $group_names));

                                    $group_names_sort[] = $groupstring;
                                    $friend_status_sort[] = $status;
                                    $rowsfriends[] = array('read_status'=>$read_status,'friend_id'=>$list['friend_id'],'date_time_created'=>$list['date_time_created'],'request_link'=>$request_link,'request_email'=>$request_email,'groupstext'=>$groupstring,'status'=>$status);
                                    
                                 	if(!(isset($_GET['order_by']) and (array_key_exists("fgroup",$_GET['order_by']) OR array_key_exists("fid",$_GET['order_by'])))){		
                                 	
                                    	if($j == 1){	
                                    
                                    		?>
                                 <tr class="first_row<?=$read_status?>" id="url_<?=$list['friend_id']?>">
                                    <?php
                                       $j++;
                                       }else{
                                       ?>
                                 <tr class="second_row<?=$read_status?>" id="url_<?=$list['friend_id']?>">
                                    <?php
                                       $j = 1;
                                       }
                                       
                                       ?>	
                                    <?php /*
                                       <td style="width:20%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="<?=$list['friend_id']?>"></span> &nbsp; <?=($list['first_name'] == '' ? 'N/A' : $list['first_name'])?></td>
                                    <td style="width:20%"><?=$list['last_name']?></td>
                                    */ ?>
                                    <?php if(isset($_GET['fstatus']) and $_GET['fstatus'] == '0'){ ?>
                                    <td style="width:25%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="<?=$list['friend_id']?>"></span> &nbsp;
                                       <?=date('m/d/Y', $list['date_time_created'])?>   <?=date('h:i a', $list['date_time_created'])?>
                                    </td>
                                    <?php } ?>
                                    <?php if(!isset($_GET['fstatus'])){ ?>
                                    <td style="width:25%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="<?=$list['friend_id']?>"></span> &nbsp;
                                       <?=$list['first_name'].' '.$list['last_name']?>
                                    </td>
                                    <?php } ?>
                                    <td style="width:25%"><a href="<?=$request_link?>">
                                       <?php
                                          /*if(($list['request_email'] == $current['email_id'])){
                                          	$emails = $co->query_first("SELECT email_id FROM `users` WHERE uid=:id",array('id'=>$list['uid'])); 
                                          	echo $emails['email_id'];
                                          }else*/
                                          if(($list['request_to']>0)){
                                          	echo $list['email_id'];
                                          }else{
                                          	echo $list['request_email'];
                                          }
                                          ?></a>
                                    </td>
                                    <td style="width:25%;<?=((isset($_GET['fstatus']) and $_GET['fstatus'] == '0') ? ' display: none;' : '')?>"><a href="javascript: void(0);"><?=(implode(", ", $group_names));?></a></td>
                                    <?php /*
                                       <td style="width:20%">
                                       	<?php
                                          if($list['request_to']>0){
                                          	?>
                                    <a href="#success_<?=$list['friend_id']?>" data-toggle="modal">View Profile</a>
                                    <?php
                                       }else{
                                       	echo '&nbsp;';
                                       }
                                       ?>
                                    <!-- Modal -->
                                    <div class="modal fade" id="success_<?=$list['friend_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                       <div class="modal-dialog modal-sm">
                                          <div class="modal-content">
                                             <div class="modal-header modal-header-success">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4>Profile Info</h4>
                                             </div>
                                             <div class="modal-body">
                                                <h4><?=$list['first_name']?> &nbsp; <?=$list['last_name']?></h4>
                                                <p><i class="fa fa-fw fa-envelope"></i> <strong>Email</strong> : <?=$list['email_id']?></p>
                                                <p><i class="fa fa-fw fa-clock-o"></i> <strong>Joined</strong> : <?=date('Y-m-d', $list['created'])?></p>
                                             </div>
                                          </div>
                                          <!-- /.modal-content -->
                                       </div>
                                       <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                    <!-- Modal -->
                                    </td>
                                    */ ?>
                                    <?php 
                                    if(isset($_GET['fstatus']) and $_GET['fstatus'] == '0'){ ?>
                                       <td style="width:25%">
                                          <?php if(strlen($list['description']) > 80){ ?>
                                             <a href="javascript: void(0);" data-toggle="tooltip" title="<?=$list['description']?>"><?=substr($list['description'], 0, 80)?>..</a>
                                          <?php }else{ ?>
                                             <?=$list['description']?>
                                       </td>
                                     <?php 
                                          } 
                                     ?>
                                     <td style="width:25%;">
                                       <?php
                                          $check_invite = '';
                                          if(($list['status'] == 0)){
                                             $status = 'Pending';
                                             if($list['fr_request_time1']>0){
                                                $check_invite .= '<a data-toggle="tooltip" title="Invited on '.date('F d, Y', $list['fr_request_time1']).'" href="javascript: void(0)"><i class="fa fa-envelope" style="color: #008080"></i></a>';
                                             }
                                             if($list['fr_request_time2']>0){
                                                $check_invite .= '&nbsp;<a data-toggle="tooltip" title="Invited on '.date('F d, Y', $list['fr_request_time2']).'" href="javascript: void(0)"><i class="fa fa-envelope" style="color: #ff8000"></i></a>';
                                             }
                                             if($list['fr_request_time3']>0){
                                                $check_invite .= '&nbsp;<a data-toggle="tooltip" title="Invited on '.date('F d, Y', $list['fr_request_time3']).'" href="javascript: void(0)"><i class="fa fa-envelope" style="color: #804040"></i></a>';
                                                echo '<input type="hidden" class="invite_disabled" value="'.$list['friend_id'].'" />';
                                             }
                                          }else if(($list['status'] == 1)){
                                             $status = 'Confirmed'; 
                                             echo '<input type="hidden" class="confirmed_requests" value="'.$list['friend_id'].'" />';
                                          }else if(($list['status'] == 2)){
                                             $status = 'Declined'; 
                                             if($list['fr_request_time1']>0){
                                                $check_invite .= '<a data-toggle="tooltip" title="Invites on '.date('M d, Y', $list['fr_request_time1']).'" href="javascript: void(0)"><i class="fa fa-envelope"></i></a>';
                                             }
                                             if($list['fr_request_time2']>0){
                                                $check_invite .= '&nbsp;<a data-toggle="tooltip" title="Invites on '.date('M d, Y', $list['fr_request_time2']).'" href="javascript: void(0)"><i class="fa fa-envelope"></i></a>';
                                             }
                                             if($list['fr_request_time3']>0){
                                                $check_invite .= '&nbsp;<a data-toggle="tooltip" title="Invites on '.date('M d, Y', $list['fr_request_time3']).'" href="javascript: void(0)"><i class="fa fa-envelope"></i></a>';
                                             }
                                          }else{
                                             $status = date('m/d/Y', strtotime($list['date']));
                                             $check_invite = '<i class="fa fa-envelope"></i>';
                                          }
                                          ?>
                                       <?=(($status == 'Confirmed') ? 'Friend' : $check_invite)?>
                                    </td>
                                     <?php
                                       }
                                     ?> 
                                    
                                    <?php if(!isset($_GET['fstatus'])){ ?>
                                    <td style="width:25%"><?=date('m/d/Y', $list['date_time_created'])?>   <?=date('h:i a', $list['date_time_created'])?>
                                    </td>
                                    <?php } ?>
                                 </tr>
                              <?php		
                                    
                                 }
                                $i++;
                              }
                              ?>
                              <?php /*
                              <tr>
                                 <td colspan="4" align="left" style="padding-right: 162px;">
                                    <p><input type="checkbox" id="display_all_messages_from_friends_btn" value="1" onclick="display_all_messages_from_friends('#share_urls_from_dash');"<?=((isset($_GET['hide_nonfriend_msg']) and $_GET['hide_nonfriend_msg']==1) ? ' checked="checked"' : '')?>>&nbsp;<span id="count_only_hidden_messages"><?=((isset($_GET['hide_nonfriend_msg']) and $_GET['hide_nonfriend_msg']==1) ? 'Displaying only messages from friends ('.$one_nonfriend_exist.' hidden messages)' : 'Display only messages from friends')?></span></p>
                                 </td>
                              </tr>
                              */ ?>
                              
                              <?php
                              if($i == 1){
                                 if(isset($_GET['gid']) and $_GET['gid'] > 0)
                                    echo '<td colspan="4">This group is empty.</td>';
                                 else
                                    echo '<td colspan="4">No, record found.</td>';    
                              }   
                                 

                                 if(isset($_GET['order_by']) and (array_key_exists("fgroup",$_GET['order_by']) OR array_key_exists("fid",$_GET['order_by']))){
                                    if((isset($_GET['order_by']) and array_key_exists("fgroup",$_GET['order_by']) and in_array('asc', $_GET['order_by']))){
                                       array_multisort($group_names_sort, SORT_ASC, $rowsfriends);
                                    }else if((isset($_GET['order_by']) and array_key_exists("fgroup",$_GET['order_by']) and in_array('desc', $_GET['order_by']))){
                                       array_multisort($group_names_sort, SORT_DESC, $rowsfriends);
                                    }else if((isset($_GET['order_by']) and array_key_exists("fid",$_GET['order_by']) and in_array('asc', $_GET['order_by']))){
                                       array_multisort($friend_status_sort, SORT_ASC, $rowsfriends);
                                    }else if((isset($_GET['order_by']) and array_key_exists("fid",$_GET['order_by']) and in_array('desc', $_GET['order_by']))){
                                       array_multisort($friend_status_sort, SORT_DESC, $rowsfriends);
                                    }
                                       
                                    foreach($rowsfriends as $listed){
                                          if($j == 1){   
                                             echo '<tr class="first_row'.$listed['read_status'].'" id="url_'.$listed['friend_id'].'>">';
                                             $j++;
                                          }else{
                                             echo '<tr class="second_row'.$listed['read_status'].'" id="url_'.$listed['friend_id'].'">';
                                             $j = 1;
                                          }
                                                   
                                          echo '
                                             <td style="width:25%"><span><input type="checkbox" class="urls_shared" name="share_url[]" value="'.$listed['friend_id'].'"></span> &nbsp;
                                                '.date('m/d/Y', $listed['date_time_created']).date('h:i a', $listed['date_time_created']).'
                                                </td>
                                                <td style="width:25%"><a href="'.$listed['request_link'].'">'.$listed['request_email'].'</a>
                                             </td>
                                             <td style="width:25%"><a href="javascript: void(0);">'.$listed['groupstext'].'</a></td>
                                             <td style="width:25%">'.$listed['status'].'</td>
                                          </tr>';
                                    }
                                 } 

                                 
                                
                                 ?>		
                           </tbody>
                        </table>
                        <?php
                           //sponsored links
                           if(isset($_SESSION['list_shared_links_by_admin']) and count($_SESSION['list_shared_links_by_admin']) > 0 ){
                           	$list_shared_links_by_admin = $_SESSION['list_shared_links_by_admin'];
                           ?>
                        <div class="text-right">
                           <a style="color: #484848; font-size: 12px;" href="index.php?p=renew">Sponsored <img src="images/cancel.jpg"></a>
                        </div>
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
                                    <!--<span><input type="checkbox" name="check" value=""></span>--> &nbsp; <a target="_blank" href="<?=$list_shared_links_by_admn['url_value']?>"><?=$list_shared_links_by_admn['url_value']?></a>
                                 </td>
                                 <td style="width:20%">Sponsored</td>
                                 <td style="width:28%"><?=((isset($list_shared_links_by_admn['url_desc']) and $list_shared_links_by_admn['url_desc'] != '') ? substr($list_shared_links_by_admn['url_desc'] , 0, 20) : 'Sponsored')?>...</td>
                                 <td style="width:15%" class="text-right"><?=date('m/d/Y', $list_shared_links_by_admn['created_time'])?>   <?=date('h:ia', $list_shared_links_by_admn['created_time'])?>
                                 </td>
                              </tr>
                              <?php
                                 }
                                 ?>
                           </tbody>
                        </table>
                        <?php 
                           } 
                           ?>
                        <?php 
                        $total_page_count = (ceil($total_record / $item_per_page)); 
                        if($total_page_count == 0)
                           $total_page_count = 1;
                        
                        ?>
                        <div class="text-right"><small>Page <?=isset($_GET['page']) ? $_GET['page'] : 1?> of <?=$total_page_count?></small></div>
                        <!--
                           <nav class="text-center">                
                           	<ul class="pagination"><?php //$page_links?></ul>              
                           </nav>-->
                     </div>
                  </div>
                  <div class="bottom-nav-link table-design margin-none">
                     <div class="bottom-nav-link-main">
                        <div  style="padding: 0px;" class="col-md-5">
                           <a class="btn btn-default dark-gray-bg" href="index.php?p=mylinkifriends">Go to</a>                 
                           <div class="dropdown border-bg-btn" style="display: inline;">
                              <select style="text-align: left;" name="filter" class="move_to_cat_w btn btn-default dropdown-toggle" onchange="fiter_with_group(this.value)">
                                 
                                 <?php /*
                                 <option value="">My Groups</option>
                                 <option value="-2"<?=(($fgroup == '-2') ? ' selected="selected"' : '')?>>Spam</option>
                                 <option value="-1"<?=(($fgroup == '-1') ? ' selected="selected"' : '')?>>Blocked</option>*/?>
                                 <?php
                                    foreach($show_all_gps_of_current_user as $list){
                                    	$sel = '';
                                    	if(isset($list['group_id']) and $list['group_id'] == $fgroup)
                                    		$sel = ' selected="selected"';
                                    	?>
                                 <option value="<?=$list['group_id']?>"<?=$sel?>><?=$list['group_name']?></option>
                                 <?php
                                    }
                                    ?>										
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4">  										
                           <a onclick="move_to_category_multiple('#share_urls_from_dash','group','2', '1');" class="btn btn-default dark-gray-bg" href="javascript: void(0);" style="display: none;">Unread</a>
                           <?php if(isset($_GET['fstatus']) and $_GET['fstatus']==0){ ?>
                           <a class="btn btn-default dark-gray-bg" onclick="invite_friend_again('#share_urls_from_dash','group', '0','0','-1');" href="javascript: void(0);">Invite</a>
                           <?php } ?>
                           <?php if(isset($_GET['gid']) and $_GET['gid']>0) { ?>
                           <a class="btn btn-default dark-gray-bg" onclick="move_to_category_multiple('#share_urls_from_dash','group', '0','0','-1');" href="javascript: void(0);">Delete</a>
                           <?php } ?>
                           <a class="btn btn-default dark-gray-bg" onclick="move_to_category_multiple('#share_urls_from_dash','group','1');" href="javascript: void(0);" style="display: none;">Unfriend</a>
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
   .linki-friends-search-top{
   margin: 0 !important;
   width: 25% !important;
   }
   .linki-friends-search-top .dashboard-search{
   width: 100% !important;
   }
   .linki-friends-search-top .dashboard-search .form-control {
   padding: 0 0 0 8px;
   }
   .bottom-nav-link-main #move_to_cat {
   background-position: right 4px center;
   padding: 5px 21px 5px 2px;
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
   .border-bg-btn .move_to_cat_w {font-weight: 500;}
</style>
<?php /*
<script type="text/javascript">
   function display_all_messages_from_friends(submitform){
      $(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
      $('#display_all_messages_from_friends_btn').attr('disabled', 'disabled');
      if($('#display_all_messages_from_friends_btn').prop('checked') == true){
         $("#count_only_hidden_messages").text('Displaying only messages from friends...');
         window.location.href="<?=$show_only_friends_urls?>";
         return;
         $.ajax({
            type: "POST",
            url: 'ajax/show_only_friends.php',
            data: {hidenonfriend:1},
            cache: false,
            contentType: false,
            processData: false,
            success: function(res2){                                 
               location.reload();
            }
         });
              
      }else{
         window.location.href="<?=$show_only_friends_urls?>";
         return;
         $("#count_only_hidden_messages").text('Displaying all messages...');
         $.ajax({
            type: "POST",
            url: 'ajax/show_only_friends.php',
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
*/ ?>
<?php  }      ?>