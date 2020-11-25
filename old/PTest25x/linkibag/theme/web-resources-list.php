

<?php
   function page_content(){
   global $co, $msg;
   $co->page_title = "Web Resources Library | LinkiBag";
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
            <h2>Web Resources Library: Use-a-Link, Share-a-Link</h2>
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
                  <div class="col-md-8"><a href="index.php?p=web-resources-list-single&id=<?=$list['cid']?>">View</a> | <a href="#">Add</a></div>
               </div>
				<?php } 
				}
				?>
               
            </div>
            <br>
            <p class="text-light-gray">Recommend new topic and add your link.</p>
            <br>
            <p class="text-blue">Thanks you for sharing and recommending <br>web resources using LinkiBag</p>
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

