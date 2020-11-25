<?php  
function page_access(){	
	global $co, $msg;      	
	$user_login = $co->is_userlogin();      	
	if(!$user_login OR !isset($_GET['url']) OR !filter_var($_GET['url'], FILTER_VALIDATE_URL)){   
		echo '<script language="javascript">window.location="index.php";</script>';      		
		exit();      
	}          
}      
function page_content(){      
	global $co, $msg;      	
	$no_record_found='';      	
	$co->page_title = "Scanning | LinkiBag";     
 	$current = $co->getcurrentuser_profile();  	
	$url_info = $co->query_first("select us.shared_url_id,us.scan_result_show from `user_urls` ur, `user_shared_urls` us where us.url_id=ur.url_id and us.shared_url_id=:urls and (us.shared_to=:uid OR us.sponsored_link='1' OR us.shared_to>'0')",array('uid'=>$current['uid'],'urls'=>$_GET['id']));
	if(!(isset($url_info['shared_url_id']) and $url_info['shared_url_id'] > 0)){
		exit();
	}	

	$co->query("UPDATE `user_shared_urls` SET `num_of_visits` = `num_of_visits` + 1 WHERE `shared_url_id` = '".$url_info['shared_url_id']."'");
			
	$co->query_update('user_shared_urls', array('read_status'=>1), array('id'=>$url_info['shared_url_id']), 'shared_url_id=:id');

	$tbody = '';
	$url = $_GET['url'];
	$ch = curl_init();
	$timeout = 0; // set to zero for no timeout	
	$myHITurl = "https://www.virustotal.com/vtapi/v2/url/report?apikey=e85cac3f3f8fe3d0dc8163c63a89b1ecfa26231aef16ab8d26f2326b62434ead&resource=".$url;
	curl_setopt ($ch, CURLOPT_URL, $myHITurl);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$file_contents = curl_exec($ch);
	$curl_error = curl_errno($ch);
	curl_close($ch);
	$file_contents = (json_decode($file_contents, true));
	//end code
	
	$j = 1;
	$clean_results = 0;
	$total_results = 0;
	if(isset($file_contents['scans']) and count($file_contents['scans']) > 0){
		foreach($file_contents['scans'] as $scan => $val){
			if($j == 1){
				$class_name = 'first_row';
			
			$j++;
			}else{
				$class_name = 'second_row';
			
			$j = 1;
			}
			$value = substr($val['result'], 0, -5);
			if($value == 'clean' OR  $value=='unrated')
				$clean_results++;	

			if($value == 'clean'){
				$text_class_name = 'text-success';
				$font_class_name = 'fa fa-check-circle';
			}else if($value=='unrated'){
				$text_class_name = 'text-grey';
				$font_class_name = 'fa fa-question-circle';
			}else{
				$text_class_name = 'text-danger';
				$font_class_name = 'fa fa-warning';
			}
			
			
			
			
			$tbody .= '	
			<tr class="'.$class_name.'" id="record_'.$scan.'">
				<td style="width:62%"><span><b>'.ucfirst($scan).'</b></span></td>
				<td style="width:62%"><span class="'.$text_class_name.'"><i class="'.$font_class_name.'" aria-hidden="true"></i> '.$val['result'].'</span></td>
			</tr>';

			$total_results++;
			
		}
	}

	$total_threat_found = $total_results - $clean_results;


?>
		<section class="dashboard-page">  
			<div class="container bread-crumb top-line">    
				<div class="col-md-7">      
					<p><a href="index.php">Home</a> > Scan URL

						<?php /*<a href="<?=$url?>"> > <b><?=strtolower($url)?></b></a> */ ?>
					</p>    
				</div> 
				<div class="col-md-5 text-right">
					
				</div>
			</div>  
			<div class="containt-area" id="dashboard_new">  
				<div class="container"> 
					<div class="containt-area-dash col-md-12">      
						<div class="folder-dash-main">        
							       
							<!-- Tab panes -->        
							<div class="tab-content"> 
								<div class="col-md-offset-2 col-md-8">
						            <form class="sign_up_page_form" method="post">
						               <div id="messagesout"></div>  
										<?php if(isset($msg)) { echo $msg; }?>
					
						               <div class="col-md-12 text-left wow fadeInUp templatemo-box" style="border:  1px solid #000; padding: 15px 40px; margin-bottom: 10px;">
						                  <div class="row">
						                  	<h3 style="margin-bottom: 10px; line-height: 25px;font-size: 22px;">You are about to leave LinkiBag. You will be visiting:</h3>
						                  	<small style="color: #ff8000;font-size: 15px;"><?=$url?></small>
						                  	<h2 style="margin-bottom: 10px; line-height: 20px; font-size: 15px;">We analyzed the URL above for viruses, worms, trojans and other kinds of malicious content.</h2>
						                     <div class="personal_account_register col-sm-4" style="background: #eeeeee none repeat; padding: 4px 30px;">
												<div class="form-group">
													<p id="scanning_txt">Scanning URL</p>
													<div id="loading_icon"><img src="images/loading_icon.gif" class="img-responsive"/></div>
												</div>
											 </div>
											 <div class="col-sm-12 row" style="margin-top: 15px;">
												 <p>
												 	<b>Scanning Results:</b>
														
														<?php
														if($total_results > 0)
															echo '<b>Total Results:</b> '.$total_results.', ';
														if($total_results > 0)
															echo '<b>Total Clean Results:</b> '.$clean_results;
														if($total_threat_found > 0)
															echo ', <b>Total Threat Found:</b> '.$total_threat_found;
														?>
												</p>
											 </div>	
						                     <div class="submit_btn row">
												<div class="col-md-12" style="margin-top: 15px;">            
													<a class="btn btn-success" style="display: none;" href="<?=$url?>" id="continue_without_scanning" disabled>Continue without Scanning</a>
													<a class="btn btn-danger" href="index.php">Back</a>
												</div>
											</div>	
						                  </div>
						               </div>
						            </form>
						         </div>
							</div>

							<div class="tab-content-box" id="scan_result" style="display: none;">
								<div class="col-md-offset-2 col-md-8">
									<h3 style="font-size: 18px;">Scan Results</h3>
									<?php /*<form name="scan_result_forms" method="post" id="scan_result_forms" action="index.php?p=scan_url&ajax=ajax_submit">
										<input type="hidden" name="form_id" value="scan_results"/>
										<input type="hidden" name="shared_url_id" value="<?=$url_info['shared_url_id']?>">
									</form>*/ ?>
									<p><input type="checkbox" name="scan_result_show" id="scan_result_show" onclick="scan_results_shows('#scan_result_forms');" value="1"<?=($current['hide_scan_fulldetail']==1 ? ' checked="checked"' : '')?> />&nbsp; Do not show the details below the next time I visit this page</p>
									<div id="scan_result_full"<?=($current['hide_scan_fulldetail']==1 ? ' style="display: none"' : '')?>>
										<ul style="border-color: #ff7f27;" class="head-design table-design folder-dash-filters">
											<li style="width:50%">
												<div class="dropdown dropdown-design">
												<div class="btn btn-default dropdown-toggle"> Detection </div>
												</div>	
											</li>
											
											<li style="width:50%">
												<div class="dropdown dropdown-design">
												<div class="btn btn-default dropdown-toggle text-center">Result </div>
												</div>	
											</li>
										</ul>
										
										<div class="mail-dashboard folder-dash-data">
											<table class="border_block table table-design" id="all_records">
												<tbody>
												<?php echo $tbody; ?>
												</tbody>
											</table>
										</div>	
									</div>
								</div>	
							</div>
							
							
									
						</div>
					</div>    
					  
				</div>
			</div>	
		</section>
		
		<style type="text/css">
			.text-grey{
				color: #e6bc81;
			}
			.personal_account_register .form-group {
			    margin: 0px;
			    overflow: hidden;
			}
		</style>
		
		<script type="text/javascript">
			setTimeout(function(){
				$('#continue_without_scanning').show();
				$('#scanning_txt').html('Scanning Completed');
				$('#scan_result').show();
				$('#loading_icon').hide();
				$('#continue_without_scanning').removeAttr('disabled');
				$('#continue_without_scanning').html('Continue...');
			}, 5000);

			function scan_results_shows(submitform){
				$('#scan_result_show').attr('disabled', 'disabled');
				$.ajax({
					type: "POST",
					url: 'ajax/scandetail_showhide.php',
					data: {hide_scan_fulldetail:0},
					cache: false,
					contentType: false,
					processData: false,
					success: function(res2){											
						if($('#scan_result_show'). prop("checked") == true){
							$('#scan_result_full').hide();
						}else{
							$('#scan_result_full').show();
						}
					}
				});
				/*var formdata = new FormData($(submitform)[0]);
				if($('#scan_result_show'). prop("checked") == true){
					formdata.append('scan_result_show','1');
				}else{
					formdata.append('scan_result_show','0');
				}	
				$.ajax({
					type: "POST",
					url: $(submitform).attr('action'),
					data: formdata,
					cache: false,
					contentType: false,
					processData: false,
					success: function(res2){											
						//alert(res2);
					}
				});*/	
			}
			
		</script>
		
				
		<?php  }      ?>