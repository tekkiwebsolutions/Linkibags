<?php  
function page_access(){	
	global $co, $msg;      	
	$user_login = $co->is_userlogin();      	
	          
}      
function page_content(){      
	global $co, $msg;      	
	$no_record_found='';      	
	$co->page_title = "Dashboard | Linkibag";     
 		      	
	$this_page='p=dashboard'; 
	$email = '';
	$selectedcountry = 1;
	if(isset($_GET['email'])) {
		$email = $_GET['email'];
	}
	if(isset($_GET['country'])) {
		$selectedcountry = $_GET['country'];
	}
	$linkibag_service_countries = $co->query_first("SELECT * from linkibag_service_countries WHERE service_id=:id",array('id'=>1));
?>
		<section id="free_singup" class="light-bg">
		<div id="free_singup_main" class="container">
			<div class="col-md-offset-3 col-md-7">
			<p></p>
				<div class="light-panel">
					<div class="light-panel-header text-left">
						<h4 style="font-weight: 500;"><span style="color: #8c8c8c;"><?=$linkibag_service_countries['outside_service_text']?></span></h4>
					</div>
					<div class="light-panel-body">
						<form method="post" id="register_outside_linkibag_service_form" action="index.php?p=outside-linkibag-service-area&ajax=ajax_submit" onsubmit="javascript: return submit_outside_service_area();" novalidate="novalidate">
							<input type="hidden" name="form_id" value="register_other_country"/>

			               <div class="text-left wow fadeInUp templatemo-box">
			                  <div class="homepage-login-form">
			                     <div>
									<div id="messagesout"></div>
									<div class="form-group row">
										<label class="mylabel col-md-4">Email: <span class="required-field"> *</span></label>
										<div class="col-md-8">
											<input placeholder="Your-email@mail.com" type="email" name="email_id" aria-describedby="basic-addon1" class="form-control error" id="signup_email_id" value="<?=$email?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="mylabel col-md-4">Country: <span class="required-field">*</span></label>
										<div class="col-md-8">
										<select class="form-control linkibox_select" name="country" onchange="country_change(this.value);">
											<option value="">Select Country</option>
											<?php
											$countries = $co->fetch_all_array("select id,country_name from countries ORDER BY country_name ASC", array());
											foreach($countries as $country){
												$sel = '';
												if($selectedcountry == $country['id'])
													$sel = ' selected="selected"';

												echo '<option value="'.$country['id'].'"'.$sel.'>'.$country['country_name'].'</option>';
											}	
											?>
										</select>
										</div>
									</div>
									<div class="form-group col-sm-offset-4 col-sm-4">
										<button type="submit" class="orange-btn btn-block" id="send_register">Send</button>
									</div>
								</div>
							</div>		
						</div>			
					</form>			
				</div>						
			</div>
		</div>
	</div>
</section>	


<script type="text/javascript">
	
function submit_outside_service_area(){	
	if($('#register_outside_linkibag_service_form').valid()){
		var formdata = new FormData($('	#register_outside_linkibag_service_form')[0]);
		$('#send_register').html('Checking');
		$('#send_register').attr('disabled', 'disabled');
		$.ajax({
			type: "POST",
			url: $('#register_outside_linkibag_service_form').attr('action'),
			data: formdata,
			cache: false,
			contentType: false,
			processData: false,
			success: function(res2) {
				res2 = JSON.parse(res2);
				//alert(res2);	
				if(res2.success === true){
					$("#dialog_success").html(res2.msg);
					$("#dialog_success" ).dialog( "open" );
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
					
				}else if(res2.success === false){
					$("#dialog_error").html(res2.msg);
					$( "#dialog_error" ).dialog( "open" );					
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_error" );
				}

				$('#send_register').html('Send');
				$('#send_register').removeAttr('disabled');
				
			}
		});
	}
	return false;
}	

</script>								
<script type="text/javascript">
		function country_change(countryval){
			//alert(countryval);
			if (countryval != "") {
			<?php
			$service_countries = unserialize($linkibag_service_countries['allowed_counties']);
			$country_cond = '';
			foreach($service_countries as $servicecountry) {
				if($country_cond != '')
					$country_cond .= ' || ';
				$country_cond .= 'countryval == '.$servicecountry;
			}
			?>
				if(<?=$country_cond?>) {
					var email = $('#signup_email_id').val();
					window.location.href='index.php?free_singup=1&email='+email+'&country='+countryval;
				}
			}
		}
	</script>		
					
		<?php  }      ?>