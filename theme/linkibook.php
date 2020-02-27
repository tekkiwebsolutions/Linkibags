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
   $co->page_title = "Linkibook | Linkibag";     
   $current = $co->getcurrentuser_profile();    
   
   $views=true;                  
   if(isset($_GET['views']) and $_GET['views']!=''){ 
      $item_per_page = $_GET['views'];       
   }else{            
      $item_per_page = 10;       
   }           
   $this_page='p=linkibook';   
   $key = '';
   if(isset($_GET['key'])) 
      $key = $_GET['key'];  

   $linkibooks_return = $co->get_linkibooks($current['uid'], $key, $item_per_page, $this_page);   
   $linkibooks = $linkibooks_return['row'];
   $total_record = $linkibooks_return['row_count'];
   
   $page_links = $linkibooks_return['page_links'];  
   $page_link_new = $linkibooks_return['page_link_new'];    
   if(count($linkibooks)<1)              
      $no_record_found = "No Record Found";
      
   if(isset($_GET['views']) and $_GET['views']!=''){
         $this_page .= '&views='.$_GET['views'];         
   }        
       
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
   <div class="containt-area " id="dashboard_new">
      <div class="container">
         <div class="col-md-3">      
            <?php include('dashboard_sidebar.php'); ?>    
         </div>
         <div class="containt-area-dash col-md-9">
         <div>     
         <!-- Tab panes -->        
         <div class="tab-content">
               <div class="tab-content-box">
                  <div style="display:none;"><?=isset($msg) ? $msg : ''?></div>
                  <div style="margin-bottom: 11px;" class="user-name-dash">
				  
                     <div class="row">
                        <div class="col-md-5 col-xs-12">
                           <span style="display: inline-block; padding-top: 6px;position: relative;" class="text-blue" ><img style="vertical-align: middle;margin-bottom: 4px;" src="images/book_ico.png" alt="bag Icon"> LinkiBook 
                           
                           </span> &nbsp;&nbsp;&nbsp;&nbsp;
                           <a class="share btn button-grey pull-right" href="javascript: void(0);" onclick="multiple_linkibook_share();"><i class="fa fa-share-alt" aria-hidden="true"></i> Share</a>
                        </div>
                        <div class="col-md-6 col-xs-12 text-right">
                           <form method="get">
                              <input type="hidden" name="p" value="linkibook" />
                           <div class="input-group dashboard-search" style="border-color: rgb(127, 127, 127) !important;">
                              <input type="text" class="form-control input-sm" placeholder="Search" onkeypress="handle_not_submit(event);" name="key" id="key" value="<?=isset($_GET['key']) ? $_GET['key'] : ''?>">
                              <div class="input-group-btn">
                                 <button class="btn btn-default btn-sm" type="submit"><i class="fa fa-search"></i></button>
                              </div>
                           </div>
                           </form>
                            <a class="btn button-grey pull-left margin-lt" href="javascript: void(0);" onclick="multiple_linkibook_delete();">Delete</a> 
                        </div>
                     </div>
                  </div>
                  <div class="mail-dashboard">
                     <div class="table table-responsive margin-none">
                        <table class="table head_border_block">
						<tbody>
						<tr>
							<td class="width50">
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
								 ?>
								<div class="dropdown dropdown-design">
								   <div class="btn btn-default dropdown-toggle"><input type="checkbox" name="check" id="checkAll" value=""/>Title <a href="index.php?p=linkibook<?=$url_by?>"><i class="<?=$arrow_direction?>"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
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
								   <div class="btn btn-default dropdown-toggle">Size <a href="index.php?p=linkibook<?=$shared_by?>"><i class="<?=$arrow_direction?>"></i></a>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
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
								   <div class="btn btn-default dropdown-toggle">Date Created <a href="index.php?p=linkibook<?=$date_by?>"><i class="<?=$arrow_direction?>"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
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
                                 $j = 1;
                                 //print_r($urlposts);
                                 foreach($linkibooks as $linkibook){  
                                    $i++; 
                                    if($j == 1){
                                       $class_name = 'first_row';
                                       $j++;
                                    }else{
                                       $class_name = 'second_row';
                                       $j = 1;
                                    }
                                  
                                    ?>
                              <tr class="read" id="url_<?=$linkibook['id']?>">
                                 <td class="width50">
                                    <span><input type="checkbox" class="urls_shared" name="share_book[]" value="<?=$linkibook['id']?>"></span> &nbsp; <a data-toggle="tooltip" title="view" href="links_print/index.php?preview_linkibook=1&id=<?=$linkibook['id']?>" target="_blank"><?=$linkibook['book_title']?></a>
                                 </td>
                              
                                 <td class="width25"><?=($linkibook['pdf_size']>0 ? $co->FileSizeConvert($linkibook['pdf_size']) : '0')?></td>
                                 <td class="width15"><?=date('m/d/Y h:i a', $linkibook['created'])?></td>
                              </tr>
                              <?php } ?>
                              <?php
                               if($i == 1){
                                 echo '<td colspan="3">No, record found.</td>';    
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
									$prev_link = 'index.php?page='.$p_link.'&p=linkibook';
								}else{
									$prev_link = 'index.php?p=linkibook';
								}
							}
							if(isset($_GET['page']) and $_GET['page'] > 1){
								$next_link ='';
								if($total_page_count > $_GET['page']){
									
									$n_link = $_GET['page'] + 1;
									$next_link = 'index.php?page='.$n_link.'&p=linkibook';
								
								}else{
									$next_link = 'index.php?page='.$_GET['page'].'&p=linkibook';
								}
							}else{
								 $next_link = 'index.php?page=2&p=linkibook';
							}
						}	  
			    ?>
				<div class="row">
					<div class="col-md-11 col-xs-12">
					<?php if($total_page_count >1){ ?>
						<div class="arrow_icons">
							<?php 
							if(!isset($_GET['page'])){
								if($_GET['p'] == "linkibook"){
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
                     <div  style="padding: 0px;" class="col-md-7"></div>
                     
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
   
   
</script>      
<?php  }      ?>