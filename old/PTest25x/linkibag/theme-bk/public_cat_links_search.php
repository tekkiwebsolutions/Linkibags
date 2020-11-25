		<?php

		function page_content(){

			global $co, $msg;

			$co->page_title = "Search | LinkiBag";
			$current = $co->getcurrentuser_profile();  	 	    
		
			$item_per_page = 10;      	
						
			$this_page='p=public_cat_links_search';      
			$results = $co->get_all_urlposts((isset($current['uid']) ? $current['uid'] : '0'), $item_per_page, $this_page, 0, 0);
			//print_r ($results);
			$result = $results['row'];      		
			$page_link_new = $results['page_link_new'];	
			
			if(isset($current['uid']))
				$show_all_category_of_current_user = $co->fetch_all_array("SELECT * FROM `category` WHERE uid=:id ORDER BY cid DESC LIMIT 5",array('id'=>$current['uid']));
			else
				$show_all_category_of_current_user = $co->fetch_all_array("SELECT * FROM `category` WHERE uid=:id ORDER BY cid DESC LIMIT 5",array('id'=>0));
			$search_results = '';
			$cat_name = 'N/A';	
			if(isset($result) and count($result) > 0){
				foreach($result as $list){
					$cat_name = $list['cname'];
					if (!preg_match("~^(?:f|ht)tps?://~i", $list['url_value'])) {
						$list['url_value'] = "http://" . $list['url_value'];
					}
				$search_results .=	
					'
					<div class="search-results">
						<div class="row">
							<div class="col-md-3 col-xs-12">
								<div class="search-web-link">               
									<a href="'.$list['url_value'].'" target="_blank">'.$list['url_value'].'</a>
								</div>	
							</div>	
							<div class="col-md-9 col-xs-12">
								<div class="search-web-dis">  
									<p>'.substr($list['url_desc'], 0, 10).' <a href="index.php?p=linkibags"> '.$list['cname'].' ...</a> '.substr($list['url_desc'], 10).'</p>
								</div>
							</div>
						</div>
					</div>
					';
			
				}
			}	
				
			 

			?>	

	<section class="search-box-page">
		<div class="container">
			<div class="row">	

				<div class="col-md-12 col-xs-12">
					<div class="search-categories">
						<?php
						if(isset($show_all_category_of_current_user) and count($show_all_category_of_current_user) > 0){
							foreach($show_all_category_of_current_user as $list)
						
						?>
						<a href="index.php?p=linkibags"><?=$list['cname']?></a>
						
						<?php }else{ ?>
							<a href="index.php?p=dashboard">Public category search Link</a>
						<?php } ?>
					</div>
				</div>
				<div class="col-md-6 col-md-offset-3">
					<div class="search-box-page text-center">
						<h2>
							<a href="#"><?=isset($current['email_id']) ? $current['email_id'] : 'Search for Category'?></a> 
							<sup>
								<small> 
								<span>
									<a href="#">
										<?=isset($current['email_id']) ? '<a href="index.php?p=edit-profile">Edit</a>' : ''?>
									</a>	
								</span>
								</small>
							</sup>
						</h2>
						<form method="get" id="search_cat">
							<input type="hidden" name="p" value="public_cat_links_search"/>
							<input type="text" class="form-control" id="cat" name="cat" value="<?=isset($_GET['cat']) ? $_GET['cat'] : ''?>">
							<button type="submit" class="btn blue-bg">LinkiBag Search</button>
						</form>
					</div>
				</div>
				
				<div class="col-md-12 col-xs-12">
					<div class="search-active-categories">
						<p>Category: <span><?=$cat_name?></span></p>
					</div>
				</div>
				
				<div class="col-md-12 col-xs-12">
				<?php
				echo $search_results;
				?>
				</div>
			</div>
		</div>
	</section>		
				
				
				
<style>
.search-categories a {
    border-bottom: 1px solid;
    color: #7f7f7f;
    margin: 0 22px 0 0;
}
.search-box-page input {
    border: 1px solid #7f7f7f !important;
    border-radius: 0;
    box-shadow: none !important;
    color: #004080;
    font-size: 17px;
    height: auto;
    margin: 40px 0 27px;
    padding: 6px 15px;
}
.search-box-page .btn {
    background: #31496a none repeat scroll 0 0;
    border-radius: 0;
    color: #fff !important;
    font-size: 17px;
    font-weight: bold;
    padding: 3px 34px;
}
.search-box-page h2 a {
    color: #ff7f27 !important;
    font-weight: normal;
}
.search-box-page h2 {
    margin: -4px 0 0;
}
.search-box-page h2 sup a {
    border-bottom: 1px solid;
    color: #7f7f7f !important;
}

.search-results a, .search-results p {
    color: #7f7f7f;
    font-size: 18px;
}
.search-web-link a {
    border-bottom: 1px solid;
}
.search-web-dis a {
    color: #004080;
}
.search-results {
    margin: 0 0 20px;
}
.search-active-categories p {
    color: #7f7f7f;
    font-size: 18px;
}
.search-active-categories {
    margin: 0 0 39px;
}

</style>
						
						<?php

					}

					?>	


					