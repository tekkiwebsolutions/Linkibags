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
      $co->page_title = "Shared Links | LinkiBag";     
      $current = $co->getcurrentuser_profile();      
   
      $list_shared_links_by_admin = $co->list_shared_links_by_admin('0');         
      $item_per_page = 12;       
      $this_page='p=shared-links-new';     
      
      /*$lists_of_all_friends = $co->fetch_all_array("SELECT ur.*, fr.request_email, fr.request_to, p.first_name, p.last_name, u.email_id, u.created, ur.created as date_time_created FROM user_friends ur JOIN friends_request fr ON ur.request_id=fr.request_id LEFT JOIN profile p ON ur.fid=p.uid LEFT JOIN users u ON ur.fid=u.uid WHERE ur.friend_id>'0' AND ur.uid=:id and ur.status='1' ORDER BY ur.friend_id DESC", array('id'=>$current['uid']));*/
      $lists_of_all_friends = $co->fetch_all_array("SELECT DISTINCT(IFNULL(u.email_id, r.request_email)) as email_id FROM user_friends uf INNER JOIN friends_request r ON r.request_id=uf.request_id LEFT JOIN users u ON u.uid=uf.fid WHERE uf.uid=:uid",array('uid'=>$current['uid']));
  
      $_SESSION["share_number"] = $co->generate_sharenumber();
      
      
      $total_urls = $co->users_count_url($current['uid']);     
      $total_friends = $co->users_count_friend($current['uid']);     
      $total_friends_url = $co->users_count_shared_url($current['uid']);  
      
      $groups = $co->fetch_all_array("select * from groups where uid IN (:id) ORDER BY group_id DESC",array('id'=>$current['uid'])); 
      
      if(!(isset($_GET['url']) and count($_GET['url']) > 0))
         exit();
      
      $table_body = '';
      $i=1;                                
      if(isset($_GET['page'])){         
         $i = ($item_per_page * ($_GET['page']-1))+1;                  
      }                               
      $j = 1;
      $arr = '';
      $link_urls = '';
      foreach($_GET['url'] as $share_urls){  
         $urlpost = $co->query_first("SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,us.*  FROM `user_urls` ur, `user_shared_urls` us LEFT JOIN `users` u ON u.uid=us.uid WHERE ur.url_id=us.url_id and us.shared_url_id=:urlid",array('urlid'=>$share_urls));
         $url_value[] = array('uid'=>$urlpost['uid'], 'url_value'=>$urlpost['url_value'], 'shared_url_id'=>$urlpost['shared_url_id'], 'url_desc'=>$urlpost['url_desc'], 'url_msg'=>$urlpost['url_msg'], 'num_of_visits'=>$urlpost['num_of_visits']);
         $arr .= '<input type="hidden" name="urls[]" value="'.$urlpost['shared_url_id'].'"/>' ; 
         $link_urls .= 'url[]='.$urlpost['shared_url_id'].'&';
         $parsed = parse_url($urlpost['url_value']);
         if (empty($parsed['scheme'])) {
            $urlpost['url_value'] = 'http://' . ltrim($urlpost['url_value'], '/');
         }
         
         $class_name = '';
         $i++; 
         if($j == 1){
            $class_name = 'first_row';
         
         $j++;
         }else{
            $class_name = 'second_row';
         
         $j = 1;
         }
         if(!(isset($_GET['order_by']))){
            if($urlpost['url_msg'] != '')
               $url_message = $urlpost['url_msg'];
            else     
               $url_message = $urlpost['url_desc'];
            $table_body .= '
            <tr class="'.$class_name.' '.($urlpost['num_of_visits'] > 0 ? ' read' : ' unread').'" id="record_'.$urlpost['shared_url_id'].'">
               <td style="width:45%">
                  <a href="index.php?p=scan_url&id='.$urlpost['shared_url_id'].'&url='.urlencode($urlpost['url_value']).'" target="_blank">'.$urlpost['url_value'].'</a>
               </td>
               <td style="width:45%; ">';
                  if($urlpost['uid'] != $current['uid']){
                     if($urlpost['sponsored_link'] == 1 and $urlpost['shared_to'] == -1 and $urlpost['uid'] == -1){
                        //onclick="load_edit_frm('.$urlpost['shared_url_id'].', \'add_sharing_link_url_msg\');"
                        $table_body .= $url_message;
                     }else{
                        $table_body .= $url_message;   
                     }
                  }else{
                     // onclick="load_edit_frm('.$urlpost['shared_url_id'].', \'add_sharing_link_url_msg\');"
                     $table_body .= $url_message;
                  }
                  
               $table_body .= '     
               </td>
               <td style="width:10%">';
                  /*<a href="index.php?p=scan_url&id='.$urlpost['shared_url_id'].'&url='.urlencode($urlpost['url_value']).'" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i></a>*/
               if($urlpost['uid'] == $current['uid'] OR ($urlpost['sponsored_link'] == 1 and $urlpost['shared_to'] == -1 and $urlpost['uid'] == -1)){ 
                  $table_body .= '<a href="javascript: void(0);" onclick="load_edit_frm('.$urlpost['shared_url_id'].', \'add_sharing_link_url_msg\');"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
               }
               $table_body .= '  
               </td> 
            </tr>';
         }  
       }
      if((isset($_GET['order_by']))){
         foreach($url_value as $re){
            $url_values_sort[] = $re['url_value'];
            $url_desc_sort[] = $re['url_desc'];
         }
         if((isset($_GET['order_by']) and array_key_exists("url_value",$_GET['order_by']) and in_array('asc', $_GET['order_by']))){
            array_multisort($url_values_sort, SORT_ASC, $url_value);
         }else if((isset($_GET['order_by']) and array_key_exists("url_value",$_GET['order_by']) and in_array('desc', $_GET['order_by']))){
            array_multisort($url_values_sort, SORT_DESC, $url_value);
         }else if((isset($_GET['order_by']) and array_key_exists("url_desc",$_GET['order_by']) and in_array('asc', $_GET['order_by']))){
            array_multisort($url_desc_sort, SORT_ASC, $url_value);
         }else if((isset($_GET['order_by']) and array_key_exists("url_desc",$_GET['order_by']) and in_array('desc', $_GET['order_by']))){
            array_multisort($url_desc_sort, SORT_DESC, $url_value);
         }
            
         foreach($url_value as $urlpost){
            $class_name = '';
            $i++; 
            if($j == 1){
               $class_name = 'first_row';
            
            $j++;
            }else{
               $class_name = 'second_row';
            
            $j = 1;
            }
         
            if($urlpost['url_msg'] != '')
               $url_message = $urlpost['url_msg'];
            else     
               $url_message = $urlpost['url_desc'];
   
            $table_body .= '
            <tr class="'.$class_name.' '.($urlpost['num_of_visits'] > 0 ? ' read' : ' unread').'" id="record_'.$urlpost['shared_url_id'].'">
               <td style="width:45%">
                  <a href="index.php?p=scan_url&id='.$urlpost['shared_url_id'].'&url='.urlencode($urlpost['url_value']).'" target="_blank">'.$urlpost['url_value'].'</a>
               </td>
               <td style="width:45%; text-decoration: underline;">';
                  if($urlpost['uid'] != $current['uid']){
                     if($urlpost['sponsored_link'] == 1 and $urlpost['shared_to'] == -1 and $urlpost['uid'] == -1){
                        $table_body .= '<a href="javascript: void(0);" onclick="load_edit_frm('.$urlpost['shared_url_id'].', \'add_sharing_link_url_msg\');">'.$url_message.'</a>';
                     }else{
                        $table_body .= '<a href="javascript: void(0);">'.$url_message.'</a>';
                     }                    
                  }else{
                     $table_body .= '<a href="javascript: void(0);" onclick="load_edit_frm('.$urlpost['shared_url_id'].', \'add_sharing_link_url_msg\');">'.$url_message.'</a>';
                  }
               $table_body .= '     
               </td>
               <td style="width:10%">';
                  if($urlpost['uid'] == $current['uid'] OR ($urlpost['sponsored_link'] == 1 and $urlpost['shared_to'] == -1 and $urlpost['uid'] == -1)){ 
                     $table_body .= '<a href="javascript: void(0);" onclick="load_edit_frm('.$urlpost['shared_url_id'].', \'add_sharing_link_url_msg\');"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                  }
                  $table_body .= '
               </td> 
            </tr>';
         }  
      }
      
       
         
   ?>
<section class="dashboard-page sharing-links-page">
   <div class="container bread-crumb top-line">
      <div class="col-md-12">
         <p><a href="index.php">Home</a> &gt; Share Links</p>
      </div>
   </div>
   <div class="containt-area" id="dashboard_new">
      <div class="container">
         <div class="col-md-3 my_lnk_left">      
            <?php include('dashboard_sidebar.php'); 
               ?>    
         </div>
         <div class="containt-area-dash col-md-9 my_lnk_right">
            <div class="row">
               <div class="col-md-8">
                  <div class="text-orang user-name-dash">Share</div>
                  <div class="tab-content">
                     <div id="table_serialize_for_print" style="display: none;"></div>
                     <form onsubmit="javascript: return share_links_new(1);" action="index.php?p=dashboard&amp;ajax=ajax_submit" id="share_form_1" class="form-horizontal edit_url_form-design" method="post">
                        <div id="url-shared-messages-out_1"></div>
                        <input type="hidden" value="share_links" name="form_id">
                        <input name="page" value="1" type="hidden">
                        <input name="item_per_page" value="10" type="hidden">
                        <input name="this_page" value="p=share_links_new" type="hidden">
                        <input type="hidden" id="shared_urls_serialize" name="shared_urls_serialize" value="">
                        <?php
                           /*
                           if(isset($_GET)){                               
                              foreach($_GET as $k=>$v){  
                                 echo '<input type="hidden" name="'.$k.'" value="'.$v.'"/>';
                              }  
                           }
                           */ 
                           ?>
                        <div class="tab-content-box">
                           <?=isset($msg) ? $msg : ''?>
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
                                 
                                 ?>
                              <li style="width:45%">
                                 <div class="dropdown dropdown-design">
                                    <div class="btn btn-default dropdown-toggle">Link <a href="index.php?p=shared-links-new&<?=$link_urls?>&order_by[url_value]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("url_value",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                                 </div>
                              </li>
                              <li style="width:45%">
                                 <div class="dropdown dropdown-design">
                                    <div class="btn btn-default dropdown-toggle">Message <a href="index.php?p=shared-links-new&<?=$link_urls?>&order_by[url_desc]=<?=$url_by?>"><i class="<?=((isset($_GET['order_by']) and array_key_exists("url_desc",$_GET['order_by']) and in_array('asc', $_GET['order_by'])) ? 'fa fa-caret-up' : 'fa fa-caret-down')?>"></i></a></div>
                                 </div>
                              </li>
                              <li style="width:10%">
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
                                    <div style="margin-right: 0px; margin-left: 0px;" class="btn btn-default dropdown-toggle">Edit</div>
                                 </div>
                              </li>
                           </ul>
                           <div class="mail-dashboard">
                              <table class="border_block table table-design" id="all_records">
                                 <tbody>
                                    <?php               
                                       echo $table_body;
                                       ?>
                                 </tbody>
                              </table>
                           </div>
                           <!--                                
                              <div class="sharing-links-success-panel">                   
                                 <div class="panel panel-primary">
                                    <div class="panel-heading">
                                       <h3 class="panel-title">LinkiBag
                                       <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                                       </h3>
                                    </div>
                                    <div class="panel-body">
                                       <h4>Success! Your link was emailed to the following users:</h4><br>
                                       <h4 class="text-gray">sonubhayana011@gmai.com</h4>
                                       <h4 class="text-gray">gurdeeposahan@gmai.com</h4><br>
                                       <h4>Your link also available to web users via Share ID 1397969 during next 30 minutes.</h4>
                                       <h6><small>12/24/2017 5:35pm</small>
                                       <button type="submit" class="btn orang-bg">Print</button>
                                       <button type="submit" class="btn orang-bg">Close</button>
                                       </h6>
                                    </div>
                                 </div>
                              </div>
                                                            -->   
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
               <div class="shared-links-right-sidebar">
            <div class="grouplinks" style="width:100%">
              <p><a class="btn button-grey" style="float:left;padding:4px 12px; width: 35%;text-decoration:none" href="?p=mylinkifriends">My Groups</a></p>
              <p><a class="btn button-grey" style="float:right;padding:4px 12px; width: 60%;text-decoration:none" data-toggle="modal" data-target="#addmultipleusers">Upload Email List </a></p>
            </div>


               <h1 class="text-blue" style="line-height: 25px; margin: 0px 0px 13px;">Share with</h1>
               <div id="demochk"></div>
               <div class="row" style="margin-bottom: 2px">
               <div class="col-md-5" style="padding-right: 5px;">
               <a class="btn " style="color: #f58548 !important;border-radius: 0; font-weight: bold;border: 1px solid #f17913;padding:4px 12px; width: 100%" href="javascript: void(0)" >Select Group</a>
               </div>
               <div class="col-md-7" style="padding-left: 5px;">
               <select name="friend_group" id="friend_group" class="form-control" onchange="get_friends_of_groups(this.value)" style="border-radius: 0px; border: 1px solid rgb(127, 127, 127); box-shadow: none !important; height: auto; padding: 4px 7px;">
               <option value="">Select Group</option>
               <?php
                  foreach($groups as $list){
                  echo '<option value="'.$list['group_id'].'">'.$list['group_name'].'</option>';
                  }  
                  ?>
               </select>
               </div>
               </div>
               <!--  onclick="change_link_color(event);" onchange="change_link_color(event);" onkeydown="change_link_color(event);" -->
               <select name="shared_user[]" class="form-control" id="add_user_to_share" multiple onchange="update_chosen_section()">
               <?php
                  foreach($lists_of_all_friends as $list){
                     echo '<option value="'.$list['email_id'].'">'.$list['email_id'].'</option>';
                  }
                  ?>
               </select>
               <div class="left-groupshare">
                  <div id="save_as_new_gp_block">
                  <input type="checkbox" name="save_as_group" onclick="add_new_group_with_friends()" value="1"/> <span class="text-small-gray">Save as new group</span>
                 
                  </div>
                  <div id="save_as_existing_gp_block" style="display: none;">
                  <input type="checkbox" name="update_as_group" onclick="update_existing_group_with_friends()" value="1"/> <span class="text-small-gray">Update existing group</span>
                  <div id="update_as_group_block" class="form-group"<?=((isset($_POST['update_as_group']) and $_POST['update_as_group'] == 1) ? '' : ' style="display: none;"')?>>
                  <div>          
                  <label class="">Group name <span class="required-field">*</span></label>
                  <input type="text" id="existing_grp_name" name="group_name_updated" placeholder="New Group Name" class="form-control" value="" maxlength="25"/>
                  </div>
                  </div>
                  </div>   
               </div>
               <div class="right-groupshare">
                  <a href="#" class="btn button-grey pull-right">Update</a>
               </div>
            <div class="newinputshare">
            <div id="save_as_group_block" class="save_as_group_bloc form-group"<?=((isset($_POST['save_as_group']) and $_POST['save_as_group'] == 1) ? '' : ' style="display: none;"')?>>
               <div>          
                  <label class="">Group name<span class="required-field">*</span></label>
                  <input type="text" name="group_name" placeholder="New Group Name" class="form-control" value="" maxlength="25"/>
               </div>
            </div>
            </div>
               <div class="left-newgroupshare">
               <p class="text-theme">You are about to share <?php echo count($_GET['url']);?> link(s)</p>
               </div>
            <div class="right-Newgroupshare">
               <a href="#" class="btn button-grey pull-right save_as_group_bloc "<?=((isset($_POST['save_as_group']) and $_POST['save_as_group'] == 1) ? '' : ' style="display: none;"')?>>Save</a>
            </div>




               <?php /* ?>
               <textarea placeholder="To share links type email address or LinkiBag user name of users you want to share links with." class="form-control email-control" name="shared_user" required>
               <?php foreach(
                  $lists_of_all_friends as $list
                  ){echo''.$list['email_id'].',';} ?>
               </textarea>
               <?php */ ?>
               <!--<a class="text-theme" href="#"><u>Select from my LinkiFriends</u></a>-->
               
               <div class="clearfix"></div>
               <div>
                  <div class="g-recaptcha" data-sitekey="6LcvQfIUAAAAADmpuC1uXGhW_OPaRyxM_TqKHOVN"></div>
                  <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
               </div> 
               <div class="shared-links-right-sidebar-btns">
               <?php echo $arr; ?>
               <button type="submit" id="send_share_link_1" class="btn orang-bg pull-left"><i class="fa fa-share" aria-hidden="true"></i> Share</button>
               <a type="button" href="index.php?p=dashboard" class="btn button-grey pull-right">Cancel</a>
               </div>
               <div class="clearfix"></div> 
               <p class="text-theme">LinkiBag users will receive your links via their lnbag. Non LinkiBag users will have 30 minutes to access shared by you links before this page will expire.</p>
               <p class="text-small-gray">Users can also use code below within next 30 min to access your links:</p>
               <div id="copy-code" class="copy-cod"><?=$_SESSION["share_number"]?></div>
               <button type="button" class="copy-text" data-clipboard-action="copy" data-clipboard-target="#copy-code">Copy</button>
               <input type="checkbox" id="disable_share_id" name="disable_share_id" value="1"/> <span class="text-theme" id="disable_share_id_msg">Disable Share ID</span>
               <div class="clearfix"></div>
               </form>     
               <script>
                  var clipboard = new Clipboard('.copy-text');
                  
                  clipboard.on('success', function(e) {
                     console.log(e);
                  });
                  
                  clipboard.on('error', function(e) {
                     console.log(e);
                  });
               </script>
               </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="containt-area shared-links-new">
      <div class="container">
         <div class="col-md-11 col-md-offset-1"></div>
         <div class="col-md-1"></div>
         <div class="containt-area-dash col-md-7">
            <div>              
            </div>
         </div>
         <div class="col-md-3">      
         </div>
         <div class="col-md-1"></div>
      </div>
   </div>
</section>
<a class="btn btn-info green-bg" href="#" data-toggle="modal" data-target="#edit_groups_and_cat" id="edit_new_folder" style="display:none;">Edit URL Message</a>
<div class="modal fade" id="edit_groups_and_cat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content theme-modal-header">
         <div class="modal-header">
            <h4>URL Message </h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
         </div>
         <div id="model_body2">
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="addmultipleusers" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content theme-modal-header">
         <div class="modal-header">
            <h4>Add Users</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
         </div>
         <div id="model_body">
            <div class="col-sm-12">
               <div id="addmultipleusers_msgs"></div>
            </div>
            <form method="post" class="form-horizontal" id="addmultipleusers_form" action="index.php?p=linkifriends&ajax=ajax_submit" onsubmit="javascript: return add_multiple_users(this);" enctype="multipart/form-data">
               <input type="hidden" name="form_id" value="add_multiple_users"/>
               <input type="hidden" name="gid" id="multiple_user_gid" value=""/>
               <div class="modal-body-group">
                  <div class="form-group">
                     <div class="col-sm-10 col-md-offset-1">        
                        <label class="">Upload<span class="required-field">*</span></label>
                        <input type="file" name="userfile" required/>
                        <small>Upload list of emails in doc, docx, txt, rtf format, seperated by comma to add additional users</small>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-default linki-btn okbtn">OK</button>
                  <button type="button" class="btn btn-default linki-btn" data-dismiss="modal" style="margin-left: 38px;">Cancel</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?php
   /*
   <!-- Add new Folders-->
   
   <a class="btn btn-info orang-bg" href="#" data-toggle="modal" data-target="#add_groups_and_cat" id="add_new_folder" style="display:none;">Add New Folder</a>
   <div class="modal fade" id="add_groups_and_cat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
   
     <div class="modal-dialog modal-sm">
   
      <div class="modal-content add-new-gp">
   
         <div class="modal-header">
   
            <h4>Add New Folder </h4>
   
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
   
         </div>
         <div id="model_body">
            <form method="post" class="form-horizontal" id="add_group_and_cat_form" action="index.php?p=shared-links-new&ajax=ajax_submit" onsubmit="javascript: return add_new_group(this);">
         
            <input type="hidden" name="form_id" value="add_groups"/>
            
            
            <div class="modal-body-group">               
               <div class="form-group">
                  <div class="col-md-12">          
                     <label class="">Folder name<span class="required-field">*</span></label>
                     <input type="text" name="group_name" placeholder="New Folder Name" class="form-control" value="" maxlength="25" required/>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-default linki-btn" id="save_btn">Continue</button>
            </div>
         </form>
            
         </div>
      </div>
   
     </div>
   
   </div>
   
   */
   ?>
<style>
   .select-friends-form .chosen-choices, .select-friends-form .chosen-drop {
   width: 100%;
   }
   .select-friends-form .chosen-container {
   width: 100% !important;
   }
   .modal-body-group {
   padding: 13px 20px;
   }
   #copy-code {
   background: #c3c3c3 none repeat scroll 0 0;
   color: #004080;
   font-size: 19px;
   margin: auto;
   padding: 7px 0;
   text-align: center;
   width: 100%;
   }
   .copy-text {
   background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
   border: medium none;
   color: #004080;
   float: right;
   font-weight: bold;
   }
   .head-design {
   border: 3px solid #c3c3c3;
   margin-bottom: 10px;
   }
   .table-design .dropdown-design .btn-default {
   padding: 1px 11px;
   }     
   .chosen-choices {
   border: 1px solid #7f7f7f !important;
   border-radius: 0;
   box-shadow: none !important;
   font-size: 12px;
   min-height: 95px !important;
   background: transparent none repeat scroll 0 0 !important;
   }
   .search-choice {
   background: rgba(0, 0, 0, 0) none repeat scroll 0 0 !important;
   border: medium none !important;
   margin: 0 !important;
   box-shadow: none !important;
   }
   .share-with-control {
   border: 3px solid #ff8000;
   border-radius: 0;
   box-shadow: none !important;
   color: #ff8000;
   line-height: 16px;
   }
   .text-theme {
   color: #004080;
   font-size: 12px;
   font-weight: 700;
   }
   .text-small-gray{
   color: rgb(127, 127, 127);
   font-size: 12px;
   font-weight: 700;
   }
   .chosen-container-multi .chosen-choices li.search-choice {
   color: #7f7f7f;
   }
   .btn-code {
   background: #c3c3c3 none repeat scroll 0 0;
   color: #004080;
   display: block;
   font-size: 20px;
   text-align: center;
   width: 100%;
   }
   .shared-links-right-sidebar-btns .orang-bg {
   border-radius: 0;
   color: #fff;
   font-weight: 600;
   }
   .shared-links-right-sidebar-btns {
   margin: 13px 0;
   overflow: hidden;
   }
   .shared-links-new {
   padding: 38px 0;
   }
   .search-choice.addednew span {
   color: #ff8000;
   }
</style>
<script>
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
   
   $(document).ready(function(){
      /*
      $("#friend_group").change(function(){
          console.log('hello cleikced');
      });
   
      /*$(".search-choice a").click(function (){
   
      });
   
      $( ".search-choice-close" ).each(function( index ) {
        
      });*/
   });   
   
</script>            
<?php } ?>