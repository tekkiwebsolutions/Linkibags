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
   	$co->page_title = "LinkiFriends | Linkibag";     
    	$current = $co->getcurrentuser_profile();  	
   	$user_profile_info = $co->call_profile($current['uid']);  
   	
   	    		
   	$item_per_page = 10;      	
   	      	
   	$this_page='p=mylinkifriends';      
   	$fgroup = 0;
   	if(isset($_GET['gid']) and $_GET['gid'] > 0)
   		$fgroup = $_GET['gid'];
   	
   	//$lists_of_all_friends = $co->list_all_friends_of_current_user($current['uid'],1, $item_per_page, $this_page, $fgroup);	
   	$groups_retrun = $co->get_all_groups_of_current_user($current['uid'],$item_per_page, $this_page);    	
   	$groups = $groups_retrun['row'];      		
   	$page_links = $groups_retrun['page_links'];  
   	//$total_pages = $groups_retrun['paging2'];  
   	$page_link_new = $groups_retrun['page_link_new'];
   	     
   	$total_urls = $co->users_count_url($current['uid']); 
   	$total_friends = $co->users_count_friend($current['uid']);  	
   	$total_friends_url = $co->users_count_shared_url($current['uid']);
   
   
   	$i=1;                                
   	if(isset($_GET['page'])){         
   		$i = ($item_per_page * ($_GET['page']-1))+1;                  
   	}                               
   	  
   	$j = 1;
   	$tbody = '';
   	if(isset($groups) and count($groups) > 0){
   		foreach($groups as $group){														
   			$empty_link = 'empty_links('.$group['group_id'].',0,\'group\');';	
   			if($group['confirmed'] == 0)
   				$empty_link= "error_dialogues('There is no friends in this group')";																
   
   			$i++;
   				
   			if($j == 1){
   				$class_name = 'first_row';
   				$j++;
   			}else{
   				$class_name = 'second_row text-bold';
   				$j = 1;
   			}
   
   			if((isset($_GET['order_by_custom']))){
   				$groups_for_sort[] = array('confirmed'=>$group['confirmed'],'total_friend'=>$group['total_friend'],'group_id'=>$group['group_id'],'group_name'=>$group['group_name']);
   			}else{
   				$tbody .= '	
   					<tr class="'.$class_name.'" id="record_'.$group['group_id'].'">
   						<td style="width:50%"><span><input type="checkbox"'.($group['defaults']==1 ? ' disabled' : ' class="grouping"').' value="'.$group['group_id'].'" name="groups[]"></span> &nbsp; <a href="index.php?p=linkifriends&gid='.$group['group_id'].'">'.$group['group_name'].'</a> <span>&nbsp; <a href="javascript: void(0);" onclick="load_edit_frm('.$group['group_id'].', \'group\')"><i class="fa fa-pencil"></i></a></span></td>
   						<td style="width:20%"><a class="btn btn-sm" href="javascript: void(0);" onclick="'.$empty_link.'">Empty</a></td>
   						<td class="text-center un-bold" style="width:15%" id="empty_confirm_'.$group['group_id'].'">'.$group['confirmed'].'</td>
   						<td class="text-center un-bold" style="width:15%" id="empty_total_'.$group['group_id'].'">'.$group['total_friend'].'</td>
   					</tr>';
   
   			}
   
   			
   
   
   		}
   
   		/* sorting */
   		if(isset($groups_for_sort) and count($groups_for_sort) > 0){
   			$j = 1;
   			foreach($groups_for_sort as $re){
   				$gp_total_friend_sort[] = $re['total_friend'];	
   				$gp_confirmed_sort[] = $re['confirmed'];																																	
   			}
   
   			if((isset($_GET['order_by_custom']) and array_key_exists("friend_total",$_GET['order_by_custom']) and in_array('asc', $_GET['order_by_custom']))){
   				array_multisort($gp_total_friend_sort, SORT_ASC, $groups_for_sort);
   			}else if((isset($_GET['order_by_custom']) and array_key_exists("friend_total",$_GET['order_by_custom']) and in_array('desc', $_GET['order_by_custom']))){
   				array_multisort($gp_total_friend_sort, SORT_DESC, $groups_for_sort);
   			}else if((isset($_GET['order_by_custom']) and array_key_exists("friend_confirmed",$_GET['order_by_custom']) and in_array('asc', $_GET['order_by_custom']))){
   				array_multisort($gp_confirmed_sort, SORT_ASC, $groups_for_sort);
   			}else if((isset($_GET['order_by_custom']) and array_key_exists("friend_confirmed",$_GET['order_by_custom']) and in_array('desc', $_GET['order_by_custom']))){
   				array_multisort($gp_confirmed_sort, SORT_DESC, $groups_for_sort);
   			}
   
   			foreach($groups_for_sort as $grp){
   				/*$time_ago = $co->time_elapsed_string($fol['created_time']);*/				
   				$empty_link = 'empty_links('.$grp['group_id'].',0,\'group\');';	
   				if($grp['confirmed'] == 0)
   					$empty_link= "error_dialogues('There is no friends in this group')";														
   
   				if($j == 1){
   					$class_name = 'first_row';
   					$j++;
   				}else{
   					$class_name = 'second_row text-bold';
   					$j = 1;
   				}
   
   				$tbody .= '	
   					<tr class="'.$class_name.'" id="record_'.$grp['group_id'].'">
   						<td style="width:50%"><span><input type="checkbox"'.($grp['defaults']==1 ? ' disabled' : ' class="grouping"').' value="'.$grp['group_id'].'" name="groups[]"></span> &nbsp; <a href="index.php?p=linkifriends&gid='.$grp['group_id'].'">'.$grp['group_name'].'</a> <span>&nbsp; <a href="javascript: void(0);" onclick="load_edit_frm('.$grp['group_id'].', \'group\')"><i class="fa fa-pencil"></i></a></span></td>
   						<td style="width:20%"><a class="btn btn-sm" href="javascript: void(0);" onclick="'.$empty_link.'">Empty</a></td>
   						<td class="text-center un-bold" style="width:15%" id="empty_confirm_'.$grp['group_id'].'">'.$grp['confirmed'].'</td>
   						<td class="text-center un-bold" style="width:15%" id="empty_total_'.$grp['group_id'].'">'.$grp['total_friend'].'</td>
   					</tr>';
   			}
   		}	
   		/*end sorting */
   	}else{
   		//$tbody .= '<td colspan="3">No, record found</td>';
   	}      
   		
   		?>
<section class="dashboard-page">
   <div class="container bread-crumb top-line">
      <div class="col-md-7">
         <p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Groups</a></p>
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
         <div class="containt-area-dash col-md-9">
            <div style="" class="folder-dash-main">
               <div class="row">
                  <div class="col-sm-4">
                     <h4 class="text-green user-name-dash">My Groups</h4>
                  </div>
                  <div class="col-sm-8">
                     <a class="btn button-grey" href="javascript: void(0);" onclick="load_add_frm('group','0')" style="margin: -7px 0px 9px;" >Add New Group</a>
                  </div>
               </div>
               <div class="clearfix"></div>
               <!-- Tab panes -->        
               <div class="tab-content">
                  <form method="post" class="form-horizontal" id="manage_groups_and_cat_form" action="index.php?p=linkifriends&ajax=ajax_submit" onsubmit="javascript: return false;">
                     <input type="hidden" name="page" value="<?=isset($_GET['page']) ? $_GET['page'] : '1'?>"/>
                     <input type="hidden" name="item_per_page" value="<?=$item_per_page?>"/>
                     <input type="hidden" name="this_page" value="<?=$this_page?>"/>
                     <div class="tab-content-box">
                       
						
                        <div class="mail-dashboard folder-dash-data">
						<?php
                              $get_page_by = isset($_GET['page']) ? '&page='.$_GET['page'] : '';
                              $grp_by = 'asc';
                              $selec_all_grp_by = 'asc';
                              $arrow_direction = 'fa fa-caret-down';
                              if(isset($_GET['order_by_custom']) and in_array('asc', $_GET['order_by_custom'])){
                              	$grp_by = 'desc';
                              	$arrow_direction = 'fa fa-caret-up';
                              }elseif(isset($_GET['order_by_custom']) and in_array('desc', $_GET['order_by_custom'])){
                              	$grp_by = 'asc';
                              	$arrow_direction = 'fa fa-caret-down';
                              }
                              
                              if(isset($_GET['order_by']) and in_array('asc', $_GET['order_by'])){
                              	$selec_all_grp_by = 'desc';
                              	$arrow_direction = 'fa fa-caret-up';
                              }elseif(isset($_GET['order_by']) and in_array('desc', $_GET['order_by'])){
                              	$selec_all_grp_by = 'asc';
                              	$arrow_direction = 'fa fa-caret-down';
                              }
                              
                              $url_by = 'asc';
                              $arrow_direction = 'fa fa-caret-down';
                              if(isset($_GET['order_by']) and in_array('asc', $_GET['order_by'])){
                              	$url_by = 'desc';
                              	$arrow_direction = 'fa fa-caret-up';
                              }elseif(isset($_GET['order_by']) and in_array('desc', $_GET['order_by'])){
                              	$url_by = 'asc';
                              	$arrow_direction = 'fa fa-caret-down';
                              }
                           ?>
							<table class="table head_border_block border-color">
								<tbody>
									<tr>
										<td style="width:70%">
										  <div class="dropdown dropdown-design">
											 <!--<div class="btn btn-default dropdown-toggle"><input type="checkbox" value="" id="checkAll" name="check"> Groups <a href="#"><i class="fa fa-caret-down"></i></a></div>-->
											 <div class="btn btn-default dropdown-toggle"><input type="checkbox" value="" id="checkAll" name="check"> Select All <a href="index.php?p=mylinkifriends&order_by[group_id]=<?=$selec_all_grp_by.$get_page_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("group_id",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
										  </div>
									   </td>
									   <td style="width:15%">
										  <div class="dropdown dropdown-design">
											 <div style="padding-left:0px;" class="btn btn-default dropdown-toggle text-center">Confirmed <a href="index.php?p=mylinkifriends&order_by_custom[friend_confirmed]=<?=$grp_by.$get_page_by?>"><i class="<?=((isset($_GET['order_by_custom']) and array_key_exists("group_id",$_GET['order_by_custom']) and in_array('asc', $_GET['order_by_custom'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
										  </div>
									   </td>
									    <td style="width:15%">
										  <div class="dropdown dropdown-design">
											 <div class="btn btn-default dropdown-toggle text-center">Total <a href="index.php?p=mylinkifriends&order_by_custom[friend_total]=<?=$grp_by.$get_page_by?>"><i class="<?=((isset($_GET['order_by_custom']) and array_key_exists("created",$_GET['order_by_custom']) and in_array('asc', $_GET['order_by_custom'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
										  </div>
									   </td>
									</tr>
								</tbody>												
							</table>
                           <table class="border_block table table-design" id="all_records">
                              <tbody>
                                 <?php
                                    //$total_confirm_friends_in_gp = $co->query_first("select COUNT(friend_id) as total from user_friends where uid=:uid and fgroup=:group and status=1",array('group'=>0,'uid'=>$current['uid'])); 
                                    //$total_friends_in_gp = $co->query_first("select COUNT(friend_id) as total from user_friends where uid=:uid and fgroup=0",array('uid'=>$current['uid'])); 
                                    
                                    //$total_confirm_friends_in_gp = $co->query_first("select COUNT(friend_id) as total from user_friends where uid=:uid and fgroup=:group and status=1",array('group'=>0,'uid'=>$current['uid'])); 
                                    //$total_friends_in_gp = $co->query_first("select COUNT(friend_id) as total from user_friends where uid>'0' and fid>'0' and ((uid=:uid and status='1') OR (fid=:fid and status='0'))",array('uid'=>$current['uid'],'fid'=>$current['uid']));
                                    /*$total_friends_in_gp = $co->fetch_all_array("select `uf`.fid from `user_friends` uf JOIN friends_request fr ON uf.request_id=fr.request_id where `uf`.uid=:uid and `uf`.status>='0' and `uf`.status<'2' GROUP BY fr.request_email",array('uid'=>$current['uid']));
                                    $total_friends_in_gp_arr = array_column($total_friends_in_gp, 'fid');
                                    
                                    $total_friendscommitted_in_gp = $co->fetch_all_array("select `gf`.email_id from `groups_friends` gf where `gf`.uid=:uid GROUP BY `gf`.email_id",array('uid'=>$current['uid']));
                                    $total_friendscommitted_in_gp_arr = array_column($total_friendscommitted_in_gp, 'email_id');
                                    $resultarr=array_diff($total_friends_in_gp_arr,$total_friendscommitted_in_gp_arr);
                                    $total_friends_in_gp['total'] = count($resultarr);
                                    // for total confirmed in ungrouped
                                    $total_confirmfriends_in_gp = $co->fetch_all_array("select `uf`.fid from `user_friends` uf JOIN friends_request fr ON uf.request_id=fr.request_id where `uf`.uid=:uid and `uf`.status='1' GROUP BY fr.request_email",array('uid'=>$current['uid']));
                                    $total_confirmfriends_in_gp_arr = array_column($total_confirmfriends_in_gp, 'fid');
                                    
                                    $total_confirmfriendscommitted_in_gp = $co->fetch_all_array("select `gf`.email_id from `groups_friends` gf, `user_friends` uf where `gf`.uid=:uid and `uf`.fid=`gf`.email_id and `uf`.status='1' GROUP BY `gf`.email_id",array('uid'=>$current['uid']));
                                    $total_confrimfriendscommitted_in_gp_arr = array_column($total_confirmfriendscommitted_in_gp, 'email_id');
                                    $confirmresultarr=array_diff($total_confirmfriends_in_gp_arr,$total_confrimfriendscommitted_in_gp_arr);
                                    $total_confirm_friends_in_gp['total'] = count($confirmresultarr);*/
                                    

                                    //$total_friends_in_any_gp = $co->query_first("SELECT COUNT(gf.groups_friends_id) as total FROM groups_friends gf, groups g WHERE g.uid=gf.uid and gf.groups=g.group_id and g.uid=:uid",array('uid'=>$current['uid']));
                                    //$total_confirm_friends_in_gp['total'] = $total_friends_in_gp['total'] - $total_friends_in_any_gp['total'];	
                                    //$total_confirm_friends_in_gp['total'] = $total_friends_in_gp['total'];
                                    
                                    //$total_confirm_friends_in_gp = $co->query_first("select COUNT(friend_id) as total from user_friends where uid=:uid and status=1",array('uid'=>$current['uid']));	
                                    
                                    $ungrouped_confirmedfriend = $co->count_friends_of_current_user($current['uid'], 1, 0);
                                    $ungrouped_totalfriend = $co->count_friends_of_current_user($current['uid'], 'no', 0);
                                    $empty_link = 'empty_links2(0,1);';	
                                    if(isset($total_friends_in_gp['total']) and $total_friends_in_gp['total'] == 0)
                                    	$empty_link= "error_dialogues('There is no links in this group')";



                                    ?>
                                 <tr class="second_row text-bold" id="record_0">
                                    <td style="width:50%"><span><input type="checkbox" value="0" disabled name="groups[]"></span> &nbsp; <a href="index.php?p=linkifriends&gid=0">Ungrouped</a> <span>&nbsp; </span></td>
                                    <td style="width:20%"><a class="btn btn-sm" href="javascript: void(0);" onclick="<?=$empty_link?>" disabled>Empty</a></td>
                                    <td class="text-center un-bold" style="width:15%"><?=$ungrouped_confirmedfriend?></td>
                                    <td class="text-center un-bold" style="width:15%" id="empty_0"><?=$ungrouped_totalfriend?></td>
                                 </tr>
                                 <?php               
                                    echo $tbody;
                                    ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="bottom-nav-link table-design">
                  <div class="bottom-nav-link-main">
                     <div class="row">
                        <div class="col-sm-4 col-sm-offset-4">
                           <a class="btn btn-info dark-gray-bg" href="javascript: void(0);" onclick="del_new_group('group');">Delete</a>
                        </div>
                        <div class="col-sm-4">
                           <div style="width: auto; margin: 0px ! important;" class="col-md-3 pull-right">                                
                              <?=$page_link_new?>                 
                           </div>
                        </div>
                     </div>                     
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<a class="btn btn-info green-bg" href="#" data-toggle="modal" data-target="#add_groups_and_cat" id="add_new_folder" style="display:none;">Add New Folder</a>
<div class="modal fade" id="add_groups_and_cat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content theme-modal-header">
         <div class="modal-header">
            <h4>Add New Group </h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
         </div>
         <div id="model_body">
         </div>
      </div>
   </div>
</div>
<a class="btn btn-info green-bg" href="#" data-toggle="modal" data-target="#edit_groups_and_cat" id="edit_new_folder" style="display:none;">Edit New Folder</a>
<div class="modal fade" id="edit_groups_and_cat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content theme-modal-header">
         <div class="modal-header">
            <h4>Edit Group </h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
         </div>
         <div id="model_body2">
         </div>
      </div>
   </div>
</div>
<style>	
	.border-color {
		border: 3px solid #008080;
	}
   .select-friends-form .chosen-choices, .select-friends-form .chosen-drop {
   width: 100%;
   }
   .select-friends-form .chosen-container {
   width: 100% !important;
   }
   .modal-body-group {
   padding: 13px 20px;
   }
   /* new style by jimmy on 23/07/18 */
   .modal-content{
      font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif !important;
   }
   .theme-modal-header .modal-header {
      border-radius: 10px; 
   }  
   .theme-modal-header .modal-header h4 {
       color: #fff !important;
   }
   label {
       color: #31496a !important;
   }
   .linki-btn {
        background: #c3c3c3 none repeat scroll 0 0 !important;
       border: medium none;
       color: #646464 !important;
       border-radius: 2px !important;
       font-size: 1em !important;
       font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif !important;
   }
   /* end new style by jimmy on 23/07/18 */
</style>
<script>
   jQuery('#share-link-button').click(function () {
   	jQuery('#add_group_and_cat_form').css('display','block');
   	jQuery('.modal-header').html('<h4>Add New Group </h4><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>');
   	
   });
</script>
<?php  }      ?>