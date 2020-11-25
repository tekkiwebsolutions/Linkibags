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
   $co->page_title = "Linkibook | LinkiBag";     
   $current = $co->getcurrentuser_profile();    
  
   $total_urls = $co->users_count_url($current['uid']);     
	$total_friends = $co->users_count_friend($current['uid']);     
	$total_friends_url = $co->users_count_shared_url($current['uid']);  
	$total_unliked_urls = $co->users_count_shared_url($current['uid'],'unlike');  
	$total_liked_urls = $co->users_count_shared_url($current['uid'],'like');   
	$total_unrecommend_urls = $co->users_count_shared_url($current['uid'],'unrecommend');  
	$total_recommend_urls = $co->users_count_shared_url($current['uid'],'recommend');   
	$default_folder_name = 'LinkiBook';  
         
?>
<style>
#linkbook_form .third_filds p {
    word-wrap: break-word;
}
</style>
<section class="dashboard-page">
   <div class="container bread-crumb top-line">
      <div class="col-md-12">
         <p><a href="index.php">Home</a></p> 
      </div>
   </div>
   <div class="containt-area " id="dashboard_new">
      <div class="container">
         <div class="col-md-3 my_lnk_left">      
            <?php include('dashboard_sidebar.php'); ?>    
         </div>
         <div class="containt-area-dash col-md-9 my_lnk_right">
         <div>     
         <!-- Tab panes -->        
         <div class="tab-content">
               <div class="tab-content-box">
                  <div style="display:none;"><?=isset($msg) ? $msg : ''?></div>
                  <div style="margin-bottom: 11px;" class="user-name-dash">
                     <div class="row">
                        <div class="col-md-7 col-xs-12 btns_linkibook">
                           <span style="display: inline-block; padding-top: 6px;position: relative;" class="text-blue" >
                           <!-- <img style="vertical-align: middle;margin-bottom: 4px;" src="<?=WEB_ROOT?>images/book_ico.png" alt="bag Icon">  -->
                           <?=$default_folder_name?> 
                           </span>
                           <a class="btn button-grey pull-right" href="javascript: void(0);" onclick="preview_linkibook()"> Preview</a>
                            <a class="btn button-grey pull-right finish_btn" href="javascript: void(0);" onclick="preview_linkibook()"> Finish</a>
                        </div>
						<div class="col-md-5 col-xs-12">
							<div class="pull-right">
							   <a class="btn button-grey" href="javascript: void(0);" onclick="save_linkibook()"> Save</a>
							   <a class="btn button-grey my_book_save" href="index.php?p=linkibook"> My Books</a>
							</div>
						</div>
                     </div>
                  </div>
                  <div class="mail-dashboard">
                    <div class="create_book_form">
					 <form name="linkbook_form" method="post" id="linkbook_form" onsubmit="javascript: return false;" action="index.php?p=create_linkibook">
						<fieldset>
						<div class="first_filds">
   						<div class="row">
   						   <div class="form-group">
   						      <label class="col-md-2 control-label margin-bm " for="title">Title</label>  
   						      <div class="col-md-10">
   							     <input id="title" name="book_title" type="text" placeholder="Title" class="form-control input-md margin-bm" required="required" />
   						      </div>
   						   </div>
   						</div>
						</div>
						
						<div class="sec_filds">
						   <div class="row">
						      <div class="form-group">
							      <label class="col-md-2 control-label" for="sub_title">Sub Title</label>  
							      <div class="col-md-10">
								      <input id="sub_title" name="book_subtitle" type="text" placeholder="Sub Title" class="form-control input-md" required="required" /><br>
							      </div>
							   </div>
						   </div>
                  </div>

                  <?php
                  $link_urls = '';
                  foreach($_GET['url'] as $share_urls){  
                     $urlpost = $co->query_first("SELECT ur.url_id,ur.url_title,ur.url_value,ur.url_desc,u.email_id,us.*  FROM `user_urls` ur, `user_shared_urls` us LEFT JOIN `users` u ON u.uid=us.uid WHERE ur.url_id=us.url_id and us.shared_url_id=:urlid",array('urlid'=>$share_urls));
                  ?>
                  <div class="row">
                     <div class="col-md-10 col-sm-offset-2">
                        <div class="form-group insert_checkbox">
                           <label class="col-md-2 control-label control-label-cb">Insert</label>
                           <div class="col-md-4">
                              <label class="checkbox-inline" for="url_subtitle_<?=$share_urls?>">
                                 <input type="checkbox" name="url_subtitle_<?=$share_urls?>" id="url_subtitle_<?=$share_urls?>" onchange="show_subtitle(<?=$share_urls?>)"> Sub Title</label>
                              <label class="checkbox-inline" for="url_text_<?=$share_urls?>">
                                 <input type="checkbox" name="url_text_<?=$share_urls?>" id="url_text_<?=$share_urls?>" onchange="show_text(<?=$share_urls?>)"> Messages</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="third_filds">
                          <div class="col-md-2">
                             <input class="pull-right" type="checkbox" checked="checked"  name="add_url[]" value="<?=$share_urls?>">
                          </div>
                          <div class="col-md-10">
                           <a href="#"><?=$urlpost['url_value']?></a>
                           <p><?=$urlpost['url_desc']?></p>
                           <div id="subtitle_value_<?=$share_urls?>" style="display: none">
                              <input name="subtitle_<?=$share_urls?>" type="text" placeholder="Sub Title" class="form-control input-md"><br>
                           </div>
                           <div id="text_value_<?=$share_urls?>" style="display: none">
                              <input name="text_<?=$share_urls?>" type="text" placeholder="Text" class="form-control input-md">
                           </div>
                          </div>
                        </div>
                     </div>
                  </div>

                  <?php
                  }
                  ?>
						</fieldset>
					 </form>
					</div>
                  </div>
               </div>
			   
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
<script>

   function show_subtitle(id) {
      $('#subtitle_value_'+id).toggle();
   }

   function show_text(id) {
      $('#text_value_'+id).toggle();
   }

   function preview_linkibook() {
      formdata = $('#linkbook_form').serialize()+'&form_id=preview_linkibook';
      $.ajax({
         type: "POST",
         url: $('#linkbook_form').attr('action'),
         data: formdata,
         success: function(res2){
            var res = JSON.parse(res2);
            if(res.error) {
               $("#dialog_error").html(res.error);  
               $("#dialog_error").dialog( "open" );
            }else{
               window.open(res.weblink, '_blank')
            }
         }
      });
   }

   function save_linkibook() {
      formdata = $('#linkbook_form').serialize()+'&form_id=create_linkibook';
      $.ajax({
         type: "POST",
         url: $('#linkbook_form').attr('action'),
         data: formdata,
         success: function(res2){
            console.log(res2);
            var res = JSON.parse(res2);
            if(res.error) {
               $("#dialog_error").html(res.error);  
               $("#dialog_error").dialog( "open" );
            }else{
               window.location.href= res.weblink;             
            }
         }
      });
   }
   
</script>      
<?php  }      ?>