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
   $co->page_title = "Link Search | Linkibag";     
   $current = $co->getcurrentuser_profile();    
   
   $total_urls = $co->users_count_url($current['uid']);     
   $total_friends = $co->users_count_friend($current['uid']);     
   $total_friends_url = $co->users_count_shared_url($current['uid']);  
?>
<section class="dashboard-page">
   <div class="container bread-crumb top-line">
      <div class="col-md-12">
         <p><a href="index.php">Home</a></p> 
      </div>
   </div>
   <div class="containt-area" id="dashboard_new">
      <div class="container">
         <div class="col-md-3">      
            <?php include('dashboard_sidebar.php'); ?>    
         </div>
         <div class="containt-area-dash col-md-9">
            <div class="link_search">
               <h3>Link Search</h3>
               <div class="search_input">
                  <form method="get">
                     <input type="hidden" name="p" value="link-search-result">
                     <input type="hidden" name="page" value="1"/>
                     <div class="row">
                        <div class="col-md-10">
                           <div class="input-group dashboard-search" style="border-color: rgb(127, 127, 127) !important;">
                              <input type="text" class="form-control input-sm" placeholder="Search" name="url" id="url" value="<?=isset($_GET['url']) ? $_GET['url'] : ''?>">
                              <div class="input-group-btn">
                                 <span class=" btn-sm"><i class="fa fa-search"></i></span>
                              </div>
                           </div>
                           <div class="row"></div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="cb-row">
                           <label class="checkbox-inline">Include:</label>
                           <label class="checkbox-inline">
                              <input type="checkbox" name="searchinclude[]" value="own">My own Links
                           </label>
                           <label class="checkbox-inline">
                              <input type="checkbox" name="searchinclude[]" value="friends">Links shared by friends
                           </label>
                           <label class="checkbox-inline">
                              <input type="checkbox" name="searchinclude[]" value="workers">Links shared by any of my co-workers
                           </label>
                        </div>
                     </div>
                     <button class="btn btn-default" type="submit">Search</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php  
}      
?>