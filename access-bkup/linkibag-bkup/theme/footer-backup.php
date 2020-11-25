<!-- start footer -->	
<div id="dialog_error" title="Error"></div>
<div id="dialog_confirm" title="Confirmation"></div>
<div id="dialog_success" title="Success"></div>
 
	<div class="copyright-bar">	<a style="float: left; color: rgb(195, 195, 195);" href="index.php?p=pages&id=8">Terms of Use</a> <span style="float: left; margin-left: 7px;">|</span> <a style="float: left; color: rgb(195, 195, 195); margin-left: 7px;" href="index.php?p=pages&id=9">Privacy Policy</a>	LinkiBag Inc. © <?php echo date("Y"); ?></div>
		<section id="footer">
			<a href="#GoTop" class="gotoplink">
				<i class="fa fa-angle-up up fa-3x" aria-hidden="true"></i>
			</a>
			<div class="container">
				<div class="row">
					<div style="padding-right:0px;" class="col-md-6 col-sm-6 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<div class="footer-box">
							<h2>Solutions</h2>
							<ul>		
								<li><a href="index.php?p=free-personal-accounts">Free Accounts </a></li>
								<li><a href="index.php?p=contact-us">Advertise with LinkiBag</a></li>
							</ul>	
							<div class="contact-btn-form-footer">
								<a class="btn btn-default" href="index.php?p=contact-us">Let’s get in touch</a>								
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<div class="footer-box">
							<h2>LinkiBag.com</h2>
							<ul>
								<li><a href="index.php?p=how-it-works">How it works</a></li>
								<li><a href="index.php?p=faq">User FAQs</a></li>
								<li><a href="index.php?p=about_us">About Us</a></li>
								<?php /*<li><a href="index.php?p=terms-of-use">Terms of Use</a></li>
								<li><a href="javascript: open_popup_pages('8');">Terms of Use</a></li>*/ ?>
								<li><a href="index.php?p=pages&id=8">Terms of Use</a></li>
								<li><a href="index.php?p=pages&id=9">Privacy Policy</a></li>
							</ul>
							<div class="newsletter-form-footer">	
								<div id="newsletter_messages_out" style="width: 68%;"></div>
								<form method="post" class="form-horizontal" id="newsletter_form" action="index.php?ajax=ajax_submit" onsubmit="javascript: return add_newletter();">
									<input type="hidden" name="form_id" value="newsletter_us">
									<fieldset>
										<!-- Text input-->
										<div class="form-group">
										  <label class="col-md-5 col-xs-12 control-label">JOIN OUR NEWSLETTER</label>  
										  <div class="col-md-7 col-xs-11">
										  <input class="form-control input-md" type="email" id="subscribe_email" name="email_id" placeholder="Email Address" onkeyup="subscribe_emails();">
										  <button type="submit" class="btn btn-default" id="newsletter_submit"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
										  </div>
										</div>
									</fieldset>
								</form>					
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

			<h4>Edit Url </h4>

			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

		</div>

		<div class="modal-body">

				

		</div>

	</div>

  </div>

</div>


<a data-toggle="modal" data-target="#share-link-form" id="share-link-button" style="display:none" href="#">Share Url</a>

<div class="modal fade" id="share-link-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

  <div class="modal-dialog">

	<div style="display: inline-block; width: 100%;" class="modal-content">

		<div class="modal-header">

			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel">Share Selected links</h4>

		</div>

		<div class="modal-body-2">

		</div>
		

	</div>

  </div>

</div>

<style>
.ui-widget {
    font-family: arial ! important;
}
table{
	table-layout: fixed;
}
table td{
	word-wrap: break-word;
}	 
.sharing-links-success-panel-widget .ui-widget-header {
    background: #ff7f27 none repeat scroll 0 0 !important;
    border-radius: 0 !important;
}
.sharing-links-success-panel-widget {
    border: 3px solid #ff7f27 !important;
    border-radius: 0 !important;
    max-width: 440px !important;
    padding: 0 !important;
    width: auto !important;
}
.sharing-links-success-panel-widget .ui-widget-header .ui-dialog-title {
    font-family: arial;
}
.sharing-links-success-panel-widget .ui-dialog-content {
    padding: 13px !important;
}
.sharing-links-success-panel .btn {
    font-family: arial;
    font-weight: bold !important;
    margin: 0 !important;
}
.modal-content .linki-btn {
	background: #c3c3c3 none repeat scroll 0 0 !important;
	color: #646464 !important;
	border-bottom: 0px solid #5A7E7B !important;
}
.theme-modal-header .modal-header h4 {
    /*color: #646464 !important;*/
    color: #fff !important;
}
.unrecommend{
	color: #c3c3c3; 
}
.fa-heart-o{
	color: #c3c3c3; 	
}
</style>
<style>
.captcha-chat-success{
	color: darkgreen;	
}
.captcha-chat-wrong{
	color: rgb(150, 0, 0);	
}

p.wrong {
    display: none;
}

p.wrong.shake {
    display: block;
}

p.wrong.shake {
    animation: shake .4s cubic-bezier(.36, .07, .19, .97) both;
    transform: translate3d(0, 0, 0);
    backface-visibility: hidden;
    perspective: 1000px;
}

@keyframes shake {
    10%,
    90% {
        transform: translate3d(-1px, 0, 0);
    }
    20%,
    80% {
        transform: translate3d(1px, 0, 0);
    }
    30%,
    50%,
    70% {
        transform: translate3d(-2px, 0, 0);
    }
    40%,
    60% {
        transform: translate3d(2px, 0, 0);
    }
}

.controls img {
    height: 20px;
}
</style>

		<!-- end footer -->
		<script type="text/javascript">
		$(document).ready(function() {
			$('#media').each(function(){
				$(this).carousel({
					pause: true,
					interval: false
				});
			});
		});​
		</script>
		
		<input type="hidden" id="WEB_ROOT" name="WEB_ROOT" value="<?=WEB_ROOT?>"/>
		<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
		
		<script src="<?=WEB_ROOT?>/theme/js/bootstrap.min.js"></script>
		<script src="<?=WEB_ROOT?>/theme/js/chosen.jquery.js" type="text/javascript"></script>
		<script src="<?=WEB_ROOT?>/theme/js/wow.min.js"></script>
		<script src="<?=WEB_ROOT?>/theme/js/jquery-validation/dist/jquery.validate.js"></script>
		<script src="<?=WEB_ROOT?>/theme/js/jquery-validation/dist/additional-methods.js"></script>
		<script src="<?=WEB_ROOT?>/theme/js/jquery.tooltip.js"></script>
		<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		
		<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

		<!-- recaptch code-->
		<?php /*
	    <div class="captcha-chat">
	        <div class="captcha-container media">
	            <div class="media-body">
	                <p class="security">Security Check:</p>                
	            </div>
	            <div id="captcha">
	                <div class="controls">
	                    <input class="user-text btn-common" placeholder="Type here" type="text" />
	                    <button class="validate btn-common">
	                        <!-- this image should be converted into inline svg -->
	                        <img src="images/enter_icon.png" alt="submit icon">
	                    </button>
	                    <button class="refresh btn-common">
	                        <!-- this image should be converted into inline svg -->
	                        <img src="images/refresh_icon.png" alt="refresh icon">
	                    </button>
	                </div>
	            </div>
	            <p class="wrong info">Wrong!, please try again.</p>
	        </div>
	    </div>*/ ?>

		
	    <script src="<?=WEB_ROOT?>/theme/js/client_captcha.js" defer></script>
	    <script>
	    document.addEventListener("DOMContentLoaded", function() {
	        document.body.scrollTop; //force css repaint to ensure cssom is ready

	        var timeout; //global timout variable that holds reference to timer

	        var captcha = new $.Captcha({
	            onFailure: function() {

	                $(".captcha-chat-wrong").show({
	                    duration: 30,
	                    done: function() {
	                        var that = this;
	                        clearTimeout(timeout);
	                        $(this).removeClass("shake");
	                        $(this).css("animation");
	                        //Browser Reflow(repaint?): hacky way to ensure removal of css properties after removeclass
	                        $(this).addClass("shake");
	                        var time = parseFloat($(this).css("animation-duration")) * 1000;
	                        timeout = setTimeout(function() {
	                            $(that).removeClass("shake");
	                        }, time);
	                    }
	                });
	                
	            },

	            onSuccess: function() {
	                alert("CORRECT!!!");
	               
	            }
	        });

	        captcha.generate();
	    });
	    </script>


		<!-- end code -->
		
	<!-- Modal -->
		
		
		<!-- Modal -->	
		
<?php /*if(!isset($_SESSION["accept"]) and !isset($_GET['p'])) { ?>
  <div class="modal fade" id="myModalopen" role="dialog" style="top: 25px; padding-top: 15px;">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
			<div class="feedback-button2">
				<div class="col-md-2">
					<div class="alert card profie-basic-ino dashboard-profile-links feedback-btn">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<div class="main-profile-user">          
							<div class="profile-avatar-name">             
								<div class="feed-btn">                
							      <a href="index.php?p=contact-us&amp;type_of_inquiry=send_feedback"><b>Send feedback</b></a>             
								</div>           
							</div>          
						</div>        
					</div>
				</div>
			</div>
		
		<div class="modal-header">
          
          <h4 class="modal-title">You are about to visit the alpha version of LinkiBag Portal. Please read our <a href="Term-of-use.pdf" target="_blank" style="text-decoration: underline;">Terms of use</a> carefully before you use this website. </h4>
        </div>
        <p class="model-block">The alpha phase of the release life cycle is the first phase of software testing. This is an initial development version that was released to help improve the software and fix bugs that may still be present in the software. It is expected that the alpha version of the software or website will be incomplete and may be buggy. The product or service may undergo extended changes or updates before the next version is released. Use of the alpha version may provide the company with feedback from test users. This version may not contain all features that are planned for the final version and may have a feature freeze for blocks that will be added to the software later.<br><br>

		By clicking "I Accept," you confirm that you are at least 18 years of age, have read the terms and conditions of the website, and have read the terms of use for the alpha version of this website. You confirm that you understand them and that you agree to be bound by them (you accept them). By clicking "I Accept," you also confirm that you will be using the alpha version of LinkiBag Portal and that we are not responsible for entries that are lost, late, misaddressed, or misdirected due to technical or any non-technical failures; errors or data loss of any kind; lost or unavailable internet connections; failed or incomplete, garbled, or deleted computer or network transmissions; an inability to access the website or online service; or any other technical error or malfunction.
Use of this website is subject to the Terms and Conditions for using the alpha version of the website and subject to the Website Terms and Conditions. These Terms and Conditions constitute a legally binding agreement between you and the company regarding the use of the service.<br><br>

		If you do not agree with all the terms of these Terms and Conditions, click the "Exit" button next to the text that reads "I am over 18 years old and I have read, understand, and accepted the Terms and Conditions." Do not click the "I Accept" button and do not attempt to use or continue using any of the services.<br><br>I am over 18 years old and I have read, understand, and accepted this agreement and Website <a href="Term-of-use.pdf" target="_blank" style="text-decoration: underline;">Terms of Use</a> and I accept and agree to terms and conditions of both. 
</p>
		<div class="modal-footer ">
			<div class="pull-left">
			<form name="form" method="post">
				<!--<a type="button" id="accept" class="btn btn-success">I Accept</a>-->
				<input type="submit" id="accept" name="accept" class="btn btn-success open-model" value="Accept" />
				<a type="button" id="exit_btn" class="btn btn-danger">Exit</a>
			</form>
			</div>
	    </div>
		
		
      </div>
      
    </div>
  </div>
<script>
$(document).ready(function(){
    $("#myModalopen").modal({backdrop: "static"});
});
</script>

<?php } */ ?>


<input type="hidden" name="default_page" value="<?=(isset($_GET['p']) ? $_GET['p'] : '')?>"/>
<input type="hidden" id="captcha_pattern" value=""/>	

<script type="text/javascript">
    document.getElementById("exit_btn").onclick = function () {
        location.href = "http://www.google.com";
    };
</script>
<script type="text/javascript">
    document.getElementById("accept").onclick = function () {
        location.href = "index.php";
    };
</script>

		<script>
         
		 $(function() {
            $( "#dialog_error" ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            });
			
			
			$( "#dialog_success" ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            });
			
			$( ".ui-dialog-title" ).html( "LinkiBag" );		
			/*
			var window_height = $(window).height();
			var window_width = $(window).width();
			var dailog_height = $(this).height();
			var dailog_width = $(this).width();
			var margin_top = (window_height-dailog_height)/2;
			var margin_left = (window_width-dailog_width)/2;

			$("#dialog_error").css("margin-top", margin_top);
			$("#dialog_error").css("margin-left", margin_left);
			*/
			//$('#dialog_success').dialog('option', 'position', 'center');

         });
		 
	 
		 
		/*function dialog_confirms(type=0, id=0, cid=0){
			$( "#dialog_confirm" ).dialog({
			   autoOpen: false, 
			   modal: true,
			   buttons: {
					"Confirm" : function() {
						//alert("You have confirmed!"); 
						if(type === 'move_to_cat'){
							move_to_category_multiple(true);
						}
						else if(type === 'move_to'){
							move_to_category_multiple(true);
						}
						$(this).dialog("close");
					},
					"Cancel" : function() {
						$(this).dialog("close");
						
					}
			   },
			   
			   
			});
		}
		 */
		 $(".onlynumbers").keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) ||
				 // Allow: Ctrl+C
				(e.keyCode == 67 && e.ctrlKey === true) ||
				 // Allow: Ctrl+X
				(e.keyCode == 88 && e.ctrlKey === true) ||
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		 
		 
      </script>
	  
	  <script src="<?=WEB_ROOT?>/theme/js/custom.js"></script>
	  
      <!-- CSS -->
      <style>
      /*
      	.ui-dialog.ui-widget.ui-widget-content{
      		top : 220px !important;

		}*/
		.dialog_success{
            /*background:#B9CD6D !important;*/
            background: #ff7f27 !important;
            border: medium none !important;
            color: #FFFFFF !important;
            font-weight: bold !important;
         }
		.dialog_confirm{
            background:#ff7f27 !important;
            border: medium none !important;
            color: #FFFFFF !important;
			font-family: arial;
            font-weight: bold !important;
         }	
	   
	  
         .ui-widget-header,.ui-state-default, ui-button{
            /*background:#FF4F4F;*/
            background:#ff7f27;
            border: medium none !important;
            color: #FFFFFF;
            font-weight: bold;
         }
		 
		 .ui-widget-content {
			border: medium none;
		 }
		 
		.ui-dialog .ui-dialog-buttonpane {
		background-image: none;
		border-width: 1px 0 0;
		margin-top: 0px;
		padding: 0;
		text-align: left;
		}
		.ui-dialog-buttonset .ui-button {
			background: #c3c3c3 none repeat scroll 0 0 !important;
			border: medium none;
			border-radius: 2px;
			color: #646464 !important;
	}
	.ui-dialog-buttonset {
		background: #eeeeee none repeat scroll 0 0;
		text-align: center;
	}
	.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset {
		float: none !important;
	}
	.ui-widget-content {
		background: #ffffff none repeat scroll 0 0 !important;
		color: #7f7f7f !important;
	}
	.ui-dialog-content.ui-widget-content {
		color: #2a2a2a !important;
		font-family: arial;
		font-size: 17px;
		font-weight: bold;
	}
.ui-datepicker .ui-datepicker-header {
    position: relative;
    padding: .2em 0;
    background: #999;
}
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {
    color: #999;
    padding: 0 5px;
}
input#user_birthday {
    background: #fff;
}
</style>

<?php
if(isset($_SESSION['dialog_success'])){
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#dialog_success").html('<?=$_SESSION['dialog_success']?>');
	$("#dialog_success").dialog( "open" );
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
});
</script>
<?php
	unset($_SESSION['dialog_success']);
}
?>
      <!-- Javascript -->
	<script>
		function fiter_with_folder(cid){
			if(cid==""){
				window.location.href="index.php?p=shared-links";
			}else{
				window.location.href="index.php?p=shared-links&cid="+cid;
			}
		}
		function fiter_with_folder_dashboard(cid){
			if(cid==""){
				window.location.href="index.php?p=dashboard";
			}else{
				if(cid=='0'){
					window.location.href="index.php?p=dashboard&cid="+cid+"&trash=1";
				}else{
					window.location.href="index.php?p=dashboard&cid="+cid;
				}
			}
		}
	</script>
	
	<script>
		function fiter_with_group(group_id){
			if(group_id==""){
				window.location.href="index.php?p=linkifriends";
			}else{
				window.location.href="index.php?p=linkifriends&gid="+group_id;
			}
		}
	</script>
		
	<script>
		var select5, chosen5;

		// cache the select element as we'll be using it a few times
		select5 = $("#add_urls");

		// init the chosen plugin
		select5.chosen({max_selected_options: 1, no_results_text: 'Press Enter to add new entry:' });
		
		// get the chosen object
		chosen5 = $('#add_urls_chosen');
		
		// Bind the keyup event to the search box input
		/*chosen5.find('input').on('keyup', function(e)
		{
			// if we hit Enter and the results list is empty (no matches) add the option
			if (e.which == 13 && chosen5.find('li.no-results').length > 0)
			{
				var option = $("<option>").val(this.value).text(this.value);
				if($("#add_urls :selected").length < 3 ){
					// add the new option
					select5.append(option);
					// automatically select it
					select5.find(option).prop('selected', true);
					// trigger the update
					select5.trigger("chosen:updated");
				}
			}
		});*/
		$("#add_urls").bind("chosen:maxselected", function () {  });
	</script>
	
	<script>
		var select6, chosen6;

		// cache the select element as we'll be using it a few times
		select6 = $("#add_user_to_share");

		// init the chosen plugin
		select6.chosen({max_selected_options: 100, no_results_text: 'Press Enter to add new entry:' });
		
		// get the chosen object
		chosen6 = $('#add_user_to_share_chosen');
		
		var enterednewemail = [];
		
		// Bind the keyup event to the search box input
		chosen6.find('input').on('keyup', function(e)
		{
			// if we hit Enter and the results list is empty (no matches) add the option
			if (e.which == 13 && chosen6.find('li.no-results').length > 0)
			{
				var option = $("<option>").val(this.value).text(this.value);
				enterednewemail.push(this.value);
				
				if($("#add_user_to_share :selected").length < 3 ){
					// add the new option
					select6.append(option);
					// automatically select it
					select6.find(option).prop('selected', true);
					// trigger the update
					select6.trigger("chosen:updated");
					update_chosen_section();
				}
			}
		});
		$("#add_user_to_share").bind("chosen:maxselected", function () {  });
		
		
		function update_chosen_section(){
			$("li.search-choice").each(function(n) {
				if(enterednewemail.indexOf( $(this).find("span").text() ) >= 0 ){
					$(this).addClass("addednew");
				}
			});
		}
	</script>
	
	
	
	
	<script>
		var select4, chosen4;

		// cache the select element as we'll be using it a few times
		select4 = $("#add_new_groups");

		// init the chosen plugin
		select4.chosen({max_selected_options: 25, no_results_text: 'Press Enter to add new entry:' });
		
		// get the chosen object
		chosen4 = $('#add_new_groups_chosen');
		
		// Bind the keyup event to the search box input
		/*chosen4.find('input').on('keyup', function(e)
		{
			// if we hit Enter and the results list is empty (no matches) add the option
			if (e.which == 13 && chosen4.find('li.no-results').length > 0)
			{
				var option = $("<option>").val(this.value).text(this.value);
				if($("#add_new_groups :selected").length < 3 ){
					// add the new option
					select4.append(option);
					// automatically select it
					select4.find(option).prop('selected', true);
					// trigger the update
					select4.trigger("chosen:updated");
				}
			}
		});*/
		$("#add_new_groups").bind("chosen:maxselected", function () {  });
	</script>
	<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
	
	$("#checkAll").change(function () {
		$(".urls_shared:checkbox").prop('checked', $(this).prop("checked"));
		$(".grouping:checkbox").prop('checked', $(this).prop("checked"));
		$('#trash').removeAttr('checked');
	});

	
	$("#disable_share_id").change(function () {
		if($(this).prop("checked") == true){
			//$(this).attr("disabled","disabled");		
			$('#copy-code').css('opacity','0.5');
			$('#disable_share_id_msg').text('Share ID is disabled');			
		}else{
			$('#copy-code').css('opacity','1');	
			$('#disable_share_id_msg').text('Share ID is activated');			
		}
	});
	

	function debounce(func, wait, immediate) {
		var timeout;
		return function() {
			var context = this, args = arguments;
			var later = function() {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	};
	function recaptchaCallback() {
		var response = grecaptcha.getResponse(),
			$button = jQuery(".#send_register");
		jQuery("#hidden-grecaptcha").val(response);
		console.log(jQuery("#register_form").valid());
		if (jQuery("#register_form").valid()) {
			$button.attr("disabled", false);
		}
		else {
			$button.attr("disabled", "disabled");
		}
	}
	function recaptchaExpired() {
		var $button = jQuery(".#send_register");
		jQuery("#hidden-grecaptcha").val("");
		var $button = jQuery(".#send_register");
		if (jQuery("#register_form").valid()) {
			$button.attr("disabled", false);
		}
		else {
			$button.attr("disabled", "disabled");
		}
	}

	function limitText(limitField, limitNum) {
		if (limitField.value.length > limitNum) {
			limitField.value = limitField.value.substring(0, limitNum);
		}
		var remaining_char = limitNum - limitField.value.length;
		$('#textareamaxlimit').html('<span class="text-danger">'+remaining_char+' more</span>');
	}
	/*$( "#user_birthday" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: "<?=(date('Y')-100)?>:<?=date('Y')?>"
    });*/
	
	$("#register_form").validate({
	ignore: ":hidden:not(#hiddenRecaptcha)",
	rules: {

		salutation: {

			required:true,

		},

		first_name: {

			required:true,

		},
		
		last_name: {

			required:true,

		},
		
		country: {

			required:true,

		},	
		
		email_id: {

			required:true,
			email: true,
			remote: {
				url: 'ajax/check_valid_email_exist.php',
				type: "post",
			},
			

		},
		"password": {

			required:true,
			remote: {
				url: 'ajax/check_valid_password.php',
				type: "post",
			},

		},
		reapt_pass: {

			required:true,
			equalTo: "#password",

		},

		/*captcha_val: {
			required: true,
			equalTo: "#captcha_pattern",			
		},*/
		

		
		terms_and_conditions: {

			required:true,

		},
		
		state: {

			required:true,

		},
		
		zip_code: {

			required:true,

		},
		
		"hiddenRecaptcha": {
			required: function() {
				if(grecaptcha.getResponse() == '') {
					return true;
				} else { return false; }
			}
		},
		
		

	},

	messages: {

		salutation: {

			required: 'Please select salutation.',

		},

		first_name: {

			required: "Please enter your first name",

		},
		last_name: {

			required: "Please enter your last name",

		},
		country: {

			required: "Please select your country",

		},
		
		email_id: {

			required: "Please enter your email",
			email: "Please enter valid email address",
			remote: "The email address you have entered is already registered.",

		},
		"password": {

			required: "Please create your password",
			remote: "",

		},
		reapt_pass: {

			required: "Please confirm your password",
			equalTo: "Confirm password must be same with password.",

		},
		/*captcha_val: {

			required: "Captcha is required",
			equalTo: "Wrong!, please try again.",

		},*/
		terms_and_conditions: {

			required: "click selection box to indicate that you have read and agree to the terms",
			 

		},
		
		state: {

			required: "Please choose state",
			 

		},
		zip_code: {

			required: "Please enter zip code",
			 

		},
		
		"hiddenRecaptcha": {
			required: "Captcha is required",
		},
		

	},
	 /*errorPlacement: function (error, element) {
		if (element.attr("type") == "checkbox") {
			error.insertAfter($(element).parents('div').prev($('.question')));
		} else {
			element.before(error);
		}
	}*/
    	

	/*
	errorPlacement: function(error, element){
        
		// name attrib of the field
		var n = element.attr("name");
		if (n == "email_id")
			element.attr("placeholder", "Please enter your first name");
		else if (n == "sign_me_for_email_filter")
			element.attr("placeholder", "Please enter your last name");	
   
	}
	*/
	
	/*errorPlacement: function(error, element) {
		error.appendTo('#errordiv');
	}*/

	});	


$("#contact_us_form").validate({
	ignore: ":hidden:not(#hiddenRecaptcha)",
	rules: {

		phone: {

			required:true,

		},

		first_name: {

			required:true,

		},
		
		last_name: {

			required:true,

		},
		
		type_of_inquiry: {

			required:true,

		},
		
		email_id: {

			required:true,

		},
		"your_msg": {

			required:true,

		},		
		"hiddenRecaptcha": {
			required: function() {
				if(grecaptcha.getResponse() == '') {
					return true;
				} else { return false; }
			}
		},
		
	},

	messages: {

		phone: {

			required: 'Please enter your phone number',

		},

		first_name: {

			required: "Please enter your first name",

		},
		last_name: {

			required: "Please enter your last name",

		},
		type_of_inquiry: {

			required: "Please select type of inquiry",

		},
		email_id: {

			required: "Please enter your email address",

		},
		"your_msg": {

			required: "Please enter your message",

		},
		
		"hiddenRecaptcha": {
			required: "Captcha is required",
		},
	},
	
});	

$("#register_outside_linkibag_service_form").validate({
	rules: {

		email_id: {

			required:true,

		},
		
		country: {

			required:true,

		},
		
	},

	messages: {

		email_id: {

			required: "Please enter email address",
			 

		},
		country: {

			required: "Please select country",
			 

		},
		
		

	},
	 
});	


function open_popup_pages(id){		
   window.open("CompanyPages.php?id="+id,"mywindow","width=1000,height=800");	
}

</script>


		
	</body>
</html>