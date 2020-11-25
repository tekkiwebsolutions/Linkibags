
<?php
   function page_content(){
   global $co, $msg;
   $user_login = $co->is_userlogin();   
   $co->page_title = "Link Exchange Library | LinkiBag";
   $user_public_category = $co->fetch_all_array("select * from user_public_category where status='1'",array()); 
   ?>
<div class="container bread-crumb">
   <div class="col-md-12">
      <p></p>
   </div>
</div>
<section>
   <div class="container">
      <div class="row">
		<div class="col-md-12">
         <div class="web-resources-list">
            <h2>Link Exchange Library: Use a Link, Share a Link</h2>
            <div class="web-resources-list-links">
				<?php
				if(isset($user_public_category) and count($user_public_category) > 0){
					foreach($user_public_category as $list){
				?>
               <div class="row">
                  <div class="col-md-4">
                     <h3>
                     <?=ucfirst($list['cname'])?>
                     <h3>
                  </div>
               <div class="col-md-8"><?php if($user_login){ ?><a class="btn dark-gray-bg btn-block" style="width:30% !important; color:#fff !important;" target="_blank" href="<?=WEB_ROOT?>web-resources-list-single/<?=$list['cid']?>">View</a>  <?php } ?></div>
               </div>
				<?php } 
				}
				?>
               
            </div>
            <br>
            <p class="text-light-gray">Recommend new topic and add your link.</p>
            <br>
            <p class="text-blue">Thanks you for sharing and recommending <br>Link Exchange using LinkiBag</p>
            <br>
         </div>
      </div>
	  </div>
   </div>
   <div class="blue-border"></div>
</section>
<?php
   }
   
   ?>

