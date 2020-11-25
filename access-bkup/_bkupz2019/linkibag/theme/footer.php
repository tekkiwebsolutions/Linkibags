<!-- start footer -->	
<div id="dialog_error" title="Error"></div>
<div id="dialog_confirm" title="Confirmation"></div>
<div id="dialog_success" title="Success"></div>
 
	<div class="copyright-bar">		LinkiBag Inc. © <?php echo date("Y"); ?></div>
		<section id="footer">
			<a href="#GoTop" class="gotoplink">
			<i class="fa fa-angle-up up fa-3x" aria-hidden="true"></i>
			</a>
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-3 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<div class="footer-box">
							<h2>LinkiBag.com</h2>
							<ul>
								<li><a href="index.php?p=about_us">About Us</a></li>
								<li><a href="index.php?p=terms-of-use">Terms of Use</a></li>
								<li><a href="index.php?p=prices">Prices</a></li>								
							</ul>		
						</div>
					</div>
					<div style="padding-right:0px;" class="col-md-3 col-sm-3 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<div class="footer-box">
							<h2>Solutions</h2>
							<ul>		
							<li><a href="index.php?p=free-personal-accounts">Free Personal Accounts </a></li>
							<li><a href="index.php?p=business-accounts">Business Accounts</a></li>
							<li><a href="index.php?p=institutional-accounts">Institutional Accounts (discounted rates)</a></li>
							<li><a href="index.php?p=linki-drops-accounts">LinkiDrops Accounts </a></li>
							</ul>		
						</div>
					</div>
					<div class="col-md-3 col-sm-3 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<div class="footer-box">
							<h2>Learn More</h2>
							<ul>
								<li><a href="index.php?p=how-it-works">How It works</a></li>	
								<li><a href="index.php?p=faq">User FAQs</a></li>
							</ul>		
						</div>
					</div>
					<div class="col-md-3 col-sm-3 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<div class="footer-box">
							<h2>Contact Us</h2>
							<ul>
								<li><a href="index.php?p=contact-us">General Inquiries</a></li>
								<li><a href="index.php?p=public_cat_links_search">Search LinkiBag</a></li>
								<li><a href="index.php?p=view-share">View Share</a></li>
							</ul>		
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
		
		
		<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
		
		<script src="<?=WEB_ROOT?>/theme/js/bootstrap.min.js"></script>
		<script src="<?=WEB_ROOT?>/theme/js/chosen.jquery.js" type="text/javascript"></script>
		<script src="<?=WEB_ROOT?>/theme/js/wow.min.js"></script>
		<script src="<?=WEB_ROOT?>/theme/js/jquery-validation/dist/jquery.validate.js"></script>
		<script src="<?=WEB_ROOT?>/theme/js/jquery-validation/dist/additional-methods.js"></script>
		<script src="<?=WEB_ROOT?>/theme/js/jquery.tooltip.js"></script>
		<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		
		<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
		
	<!-- Modal -->
		
		
		<!-- Modal -->	
		
<?php if(!isset($_SESSION["accept"]) and !isset($_GET['p'])) { ?>
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

<?php } ?>


<input type="hidden" name="default_page" value="<?=(isset($_GET['p']) ? $_GET['p'] : '')?>"/>

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
		.dialog_success{
            background:#B9CD6D !important;
            border: medium none !important;
            color: #FFFFFF !important;
            font-weight: bold !important;
         }
		.dialog_confirm{
            background:#FF9D5B !important;
            border: medium none !important;
            color: #FFFFFF !important;
            font-weight: bold !important;
         }	
	   
	  
         .ui-widget-header,.ui-state-default, ui-button{
            background:#FF4F4F;
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
		background: #d7d7d7 none repeat scroll 0 0 !important;
		color: #7f7f7f !important;
	}
</style>
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
				window.location.href="index.php?p=dashboard&cid="+cid;
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
		
		// Bind the keyup event to the search box input
		chosen6.find('input').on('keyup', function(e)
		{
			// if we hit Enter and the results list is empty (no matches) add the option
			if (e.which == 13 && chosen6.find('li.no-results').length > 0)
			{
				var option = $("<option>").val(this.value).text(this.value);
				if($("#add_user_to_share :selected").length < 3 ){
					// add the new option
					select6.append(option);
					// automatically select it
					select6.find(option).prop('selected', true);
					// trigger the update
					select6.trigger("chosen:updated");
				}
			}
		});
		$("#add_user_to_share").bind("chosen:maxselected", function () {  });
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
		"hiddenRecaptcha": {
			required: function() {
				if(grecaptcha.getResponse() == '') {
					return true;
				} else { return false; }
			}
		},
		
		terms_and_conditions: {

			required:true,

		},
		
		state: {

			required:true,

		},
		
		zip_code: {

			required:true,

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
			remote: "Minimum of 8 characters with one number and one uppercase letter.",

		},
		reapt_pass: {

			required: "Please confirm your password",
			equalTo: "Confirm password must be same with password.",

		},
		"hiddenRecaptcha": {
			required: "Captcha is required",
		},
		terms_and_conditions: {

			required: "click selection box to indicate that you have read and agree to the terms",
			 

		},
		
		state: {

			required: "Please choose state",
			 

		},
		zip_code: {

			required: "Please enter zip code",
			 

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

</script>


		
	</body>
</html>