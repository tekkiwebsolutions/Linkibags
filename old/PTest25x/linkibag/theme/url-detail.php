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
  
  
  	$co->page_title = "URL detail | Linkibag";
  
  
  	$current = $co->getcurrentuser_profile();
  
  
  	$categories = $co->show_all_category();
  
  
  	$all_urlposts_comments = $co->show_all_urlposts_comments($_GET['id']);	
  
  
  	if(isset($_GET['id']) and $_GET['id']!=''){
  
  
  		$urlpost = $co->show_urlpost_for_comment($_GET['id']);
  
  
  		$time_ago = $co->time_elapsed_string($urlpost['created_time']);	
  
  
  	
  
  
  ?>
<section id="url-detail">
  <div class="container-fluid bread-crumb top-line">
    <div class="col-md-7">
      <p><a href="index.php">Home</a><a href="index.php?p=dashboard"> > Dashboard</a></p>
    </div>
  </div>
  <div class="containt-area">
    <div class="container">
      <div>
        <div class="col-md-8">
          <div class="card url-detail-cardd">
            <div class="recent-url-posts">
              <?php
                $row_cat = $co->get_single_category($urlpost['url_cat']);	
                
                
                ?>
              <a href="<?=$urlpost['url_value']?>" target="_blank"><i class="fa fa-link"></i> <?=$urlpost['url_value']?></a>
              <?php
                if(isset($urlpost['uid']) and $urlpost['uid'] == $current['uid'])
                
                
                	echo '<small><a href="#" onclick="load_edit_form('.$urlpost['url_id'].')">Edit</a></small>';
                
                
                ?>
              <span><?=$time_ago?></span><br/>
              <a class="url-category" href="index.php?p=dashboard&id=<?=$urlpost['url_cat']?>"><?=$row_cat['cname']?></a>
              <p><?=$urlpost['url_desc']?></p>
              <div class="dashboard-btn-bottom separate-comment">
                <ul>
                  <li><a class="btn" href="index.php?p=url-detail&id=<?=$urlpost['url_id']?>"><i class="fa fa-comment"></i></a></li>
                  <li><a class="btn" href="#"><i class="fa fa-edit"></i></a></li>
                  <li><a class="btn" href="#"><i class="fa fa-share-alt"></i></a></li>
                  <li><a class="btn" href="#"><i class="fa fa-eye"></i></a></li>
                  <li><a class="btn" href="#"><i class="fa fa-trash-o"></i></a></li>
                </ul>
              </div>
            </div>
            <div class="comeent-box-main">
              <form class="row" method="post" id="add_url_comment_form" action="index.php?p=url-detail&ajax=ajax_submit" onsubmit="javascript: return add_url_comment();">
                <div id="url-comment-messages-out"></div>
                <input type="hidden" name="form_id" value="add_url_comment"/>
                <input type="hidden" name="id" value="<?=$urlpost['url_id']?>"/>
                <input type="hidden" name="uid" value="<?=$current['uid']?>"/>
                <div class="col-md-10">
                  <div style="margin: 0px;" class="form-group">
                    <textarea name="url_comment" class="form-control" placeholder="Your Comment *" value="" maxlength="255"></textarea>				
                  </div>
                </div>
                <div style="padding: 0px;" class="col-md-2">
                  <button type="submit" class="btn btn-default linki-btn" id="send_add_url_comment">Comment</button>
                </div>
              </form>
            </div>
            <ul class="tvc-lists url-post-comment">
              <?php
                foreach($all_urlposts_comments as $all_urlposts_comment){
                
                
                	$time_ago = $co->time_elapsed_string($all_urlposts_comment['comment_created']);	
                
                
                
                
                
                ?>
              <li class="media">
                <div class="pull-left">
                  <a class="tvh-user" href="">
                  <img alt="" src="http://byrushan.com/projects/ma/1-5-2/angular/img/profile-pics/5.jpg" class="img-responsive">
                  </a>
                </div>
                <div class="media-body">
                  <strong class="d-block"><a href=""><?=$all_urlposts_comment['first_name']?></a></strong>
                  <small class="c-gray"><i class="fa fa-clock-o"></i> <?=$time_ago?></small>
                  <div class="m-t-10"><?=$all_urlposts_comment['comment']?></div>
                </div>
              </li>
              <?php } ?>	
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card profile-basic-info" style="display: inline-block; padding: 10px;">
            <h5 class="small-title"><i class="fa fa-chain" style="font-size: 11px;"></i> Shared Links</h5>
            <div class="friends-shared-link">
              <ul>
                <li>
                  <h4><a target="_blank" href="http://www.markup.com"><i class="fa fa-link"></i> http://www.markup.com</a></h4>
                  <small><a href="index.php?p=dashboard&amp;id=7" class="url-category">professional</a></small>
                </li>
                <li>
                  <h4><a target="_blank" href="http://www.markup.com"><i class="fa fa-link"></i> https://www.hostelhound-new.com</a></h4>
                  <small><a href="index.php?p=dashboard&amp;id=7" class="url-category">professional</a></small>
                </li>
                <li>
                  <h4><a target="_blank" href="http://www.markup.com"><i class="fa fa-link"></i> http://www.markup.com</a></h4>
                  <small><a href="index.php?p=dashboard&amp;id=7" class="url-category">professional</a></small>
                </li>
                <li>
                  <h4><a target="_blank" href="http://www.markup.com"><i class="fa fa-link"></i> http://www.markup.com</a></h4>
                  <small><a href="index.php?p=dashboard&amp;id=7" class="url-category">professional</a></small>
                </li>
              </ul>
            </div>
            <!-- /.list-group -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<a data-toggle="modal" data-target="#edit-url-form" id="edit-url-button" style="display:none" href="#">Edit</a>
<div class="modal fade" id="edit-url-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<?php
  }
  
  
  }
  
  
  ?>
