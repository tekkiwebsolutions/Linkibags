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
      $co->page_title = "My Links | LinkiBag";     
      $current = $co->getcurrentuser_profile();    
      $cid = -2;
      if(isset($_GET['cid']) and $_GET['cid']!='')          
         $cid = $_GET['cid'];
      $char = '';
      if(isset($_GET['char']) and $_GET['char']!='')          
         $char = $_GET['char'];
      
      if(!(isset($_GET['date_by']) or isset($_GET['msg_by']) or isset($_GET['url_by']) or isset($_GET['shared_by'])))
         $_SESSION['list_shared_links_by_admin'] = $co->list_shared_links_by_admin($cid);        
            
      $views=true;                  
      if(isset($_GET['views']) and $_GET['views']!=''){ 
         $item_per_page = $_GET['views'];       
      }else{            
         $item_per_page = 10;       
      }           
      $this_page='p=atoz_mylinks';    
      
      
         $urlposts_retrun = $co->get_mylinksatoz_urlposts($current['uid'],$item_per_page, $this_page, $cid, $char);        
         $urlposts = $urlposts_retrun['row'];
         $total_record = $urlposts_retrun['row_count'];
  

         $data[] = array();
         
         $show_all_category_of_current_user = $co->fetch_all_array("SELECT * FROM `category` WHERE uid=:id",array('id'=>$current['uid']));
         
         $page_links = $urlposts_retrun['page_links'];  
         $page_link_new = $urlposts_retrun['page_link_new'];    
         if(count($urlposts)<1)              
            $no_record_found = "No Record Found";
         //}      
         if(isset($_GET['views']) and $_GET['views']!=''){
               $this_page .= '&views='.$_GET['views'];         
         }        
             
         $total_urls = $co->users_count_url($current['uid']);     
         $total_friends = $co->users_count_friend($current['uid']);     
         $total_friends_url = $co->users_count_shared_url($current['uid']);    
         
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
                  $default_folder_name = 'My Links';  
            }
         }else{
            $default_folder_name = 'My Links';  
         }
         ?>
<section class="dashboard-page">
   <div class="container bread-crumb top-line">
      <div class="col-md-12">
         <p><a href="index.php">Home</a></p> 
      </div>
   </div>
   <div class="containt-area" id="dashboard_new">
      <div class="container">
         <div class="col-md-3 my_lnk_left">      
            <?php include('dashboard_sidebar.php'); ?>    
         </div>
         <div class="containt-area-dash col-md-9 my_lnk_right">
         <div>     
         <!-- Tab panes -->        
         <div class="tab-content">
            <form name="dash_form" method="post" id="share_urls_from_dash" action="index.php?p=atoz_mylinks&ajax=ajax_submit">
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
                           <span style="display: inline-block; padding-top: 6px;position: relative;" class="text-red" ><i class="fa fa-heart red_ico"></i> <?=$default_folder_name?> 
                           </span> &nbsp;&nbsp;&nbsp;&nbsp;
                           <!-- <a style="margin: 0px 5px;" class="btn button-grey pull-right" href="javascript: void(0);" onclick="multiple_load_share_link_form('print_pdf');"><i class="fa fa-print" aria-hidden="true"></i>Print Pdf</a>-->
                           
                           <a class="share btn button-grey pull-right" href="javascript: void(0);" onclick="multiple_load_share_link_form('share');"><i class="fa fa-share-alt" aria-hidden="true"></i> Share</a>
						         <a style="margin: 0px 10px;" class="btn button-grey pull-right" href="javascript: void(0);" onclick="create_linkibook()"><i class="fa fa-pencil"></i> Create a Book</a>
                        </div>
                        <div class="col-md-6 col-xs-12 text-right">
                           <div class="input-group dashboard-search" style="border-color: rgb(127, 127, 127) !important;">
                              <input type="text" class="form-control input-sm" placeholder="Search" onkeypress="handle_not_submit(event);" name="url" id="url" value="<?=isset($_GET['url']) ? $_GET['url'] : ''?>">
                              <div class="input-group-btn">
                                 <button class="btn btn-default btn-sm" type="button" id="url_submit" onclick="search_form();"><i class="fa fa-search"></i></button>
                              </div>
                           </div>
                           <a style="margin: 0px 10px;" class="btn button-grey" href="index.php?p=linkibook">My Linki Books</a>
						         <a class="classic_view" title="Classic View" href="index.php?p=mylinks">Classic View</a>
					
                        </div>
                     </div>
                  </div>
                  <div class="mail-dashboard atoz_mylinks">
                     <div class="table table-responsive margin-none">
                        <ul class="head_border_block az_nav">
                           <?php
                           $chars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                           foreach ($chars as $chr) {
                              echo '<li><a href="index.php?p=atoz_mylinks&char='.$chr.'"'.($char==$chr ? ' class="active"' : '').'>'.$chr.'</a></li>';
                           }
                           ?>
                        </ul>
						
						<table class="border_block table table-design margin-none" id="all_records">
                           <tbody>
                               <tr>
                                   <td>
                                        <div class="dropdown dropdown-design">
                           <div style='margin: 0; padding: 0;' class="btn btn-default dropdown-toggle"><label style='margin: 0; padding: 0;'><input type="checkbox" name="check" id="checkAll" value=""/> Select All</label</div>
                        </div>
                                   </td>
                               </tr>
                              <?php               
                                 $i=1;                                
                                 if(isset($_GET['page'])){         
                                    $i = ($item_per_page * ($_GET['page']-1))+1;                  
                                 }                               
                                 //echo $no_record_found;   
                                 
                                 $j = 1;
                                 //print_r($urlposts);
                                 foreach($urlposts as $urlpost){                                         
                                    
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
                                 <td class="width35">
                                  <span<?=(($urlpost['sponsored_link'] == 1) ? ' class="sponsored_url"' : '')?>><input type="checkbox" class="<?=(($urlpost['share_type_change'] == 1) ? 'urls_shared2' : 'urls_shared')?>"<?=$url_disabled?> name="share_url[]" value="<?=$urlpost['shared_url_id']?>"></span> &nbsp; <a data-toggle="tooltip" title="<?=$title_msg?>" href="index.php?p=scan_url&id=<?=$urlpost['shared_url_id']?>&url=<?=urlencode($urlpost['url_value'])?>" target="_blank"><?=(strlen($urlpost['url_value']) > 25) ? substr($urlpost['url_value'],0,25) : $urlpost['url_value']?><span style="display: none;"><?=$urlpost['url_value']?></span></a>
                                    <?php /*<span class="visit-icon"><a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>" data-toggle="tooltip" title="<?=(($user_friend_class == ' text-grey') ? 'Not for share' : 'I may share this link with selected users')?>"><i class="fa fa-circle<?=$user_friend_class?>"></i></a></span>*/ ?>
                                   
                                    <!-- Modal -->
                                    <div class="modal fade" id="succ_<?=$urlpost['shared_url_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                       <div class="modal-dialog modal-sm">
                                          <div class="modal-content">
                                             <div class="modal-header modal-header-success">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4>You are about to leave LinkiBag</h4>
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
                                 <td class="width65"><a href="index.php?p=view_link&id=<?=$urlpost['shared_url_id']?>"><?=((strlen($urlpost['url_desc']) > 25) ? substr($urlpost['url_desc'],0,25) : $urlpost['url_desc'])?></a></td>
                              </tr>
                              <?php } ?>
                              <?php
								  if($i == 1){
									 if(isset($_GET['cid']) and $_GET['cid'] > 0)
										echo '<td colspan="4">This folder is empty.</td>';
									 else
										echo '<td colspan="4">No, record found.</td>';    
								  }   
                              ?>
                             
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <?php 
					$total_page_count = (ceil($total_record / $item_per_page)); 
					if($total_page_count == 0)
					   
					   $total_page_count = 1;
			   
						if($total_page_count >0){	
							$prev_link ='';
							if(isset($_GET['page'])){
								if($_GET['page'] > 1 ){
									$p_link = $_GET['page'] - 1;
									$prev_link = 'index.php?page='.$p_link.'&p=atoz_mylinks';
								}else{
									$prev_link = 'index.php?p=atoz_mylinks';
								}
							}
							if(isset($_GET['page']) and $_GET['page'] > 1){
								$next_link ='';
								if($total_page_count > $_GET['page']){
									
									$n_link = $_GET['page'] + 1;
									$next_link = 'index.php?page='.$n_link.'&p=atoz_mylinks';
								
								}else{
									$next_link = 'index.php?page='.$_GET['page'].'&p=atoz_mylinks';
								}
							}else{
								 $next_link = 'index.php?page=2&p=atoz_mylinks';
							}
						}	  
			    ?>
				<div class="row">
					<div class="col-md-11 col-xs-12">
					<?php if($total_page_count >1){ ?>
						<div class="arrow_icons">
							<?php 
							if(!isset($_GET['page'])){
								if($_GET['p'] == "atoz_mylinks"){
									$_GET['page']='';
								}
							}
							if($_GET['page'] > 1){ ?>
								<a class="pull-left" title="Previous" href="<?=$prev_link?>"><<</a>
							<?php } ?>
							<?php if($total_page_count != $_GET['page']){ ?>
							<a class="pull-right" title="Next" href="<?=$next_link?>">>></a>
							<?php } ?>
						</div> 
						<?php } ?>
					</div>
					<div class="col-md-1 col-xs-12"><div class="row"><small>Page <?=isset($_GET['page']) ? $_GET['page'] : 1?> of <?=$total_page_count?></small></div></div>
				</div>	
        </div>
		
        </div>
               <div class="bottom-nav-link table-design margin-none">
                  <div class="bottom-nav-link-main">
                     <div  style="padding: 0px;" class="col-md-7">
               
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