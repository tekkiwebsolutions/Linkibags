	<!-- start footer -->	
 <div id="dialog_error" title="Error"></div>
      
    
 <div id="dialog_confirm" title="Confirmation"></div>
      
 
<div id="dialog_success" title="Success"></div>
 
	<div class="copyright-bar">		LinkiBag Inc. © 2016	</div>
		<section id="footer">
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
					<div class="col-md-3 col-sm-3 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<div class="footer-box">
							<h2>Solutions</h2>
							<ul>		
							<li><a href="index.php?p=free-personal-accounts">Free Personal Accounts </a></li>					<li><a href="index.php?p=business-accounts">Business Accounts</a></li>								<li><a href="index.php?p=linki-drops-accounts">LinkiDrops Accounts </a></li>
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
      </script>
	  
	  <script src="<?=WEB_ROOT?>/theme/js/custom.js"></script>
	  
      <!-- CSS -->
      <style>
		.dialog_success{
            background:#b9cd6d !important;
            border: 1px solid #b9cd6d !important;
            color: #FFFFFF !important;
            font-weight: bold !important;
         }
		.dialog_confirm{
            background:#ff8000 !important;
            border: 1px solid #b9cd6d !important;
            color: #FFFFFF !important;
            font-weight: bold !important;
         }	
	   
	  
         .ui-widget-header,.ui-state-default, ui-button{
            background:#FF0000;
            border: 1px solid #b9cd6d;
            color: #FFFFFF;
            font-weight: bold;
         }
		 
		.ui-dialog .ui-dialog-buttonpane {
		background-image: none;
		border-width: 1px 0 0;
		margin-top: 0px;
		padding: 0;
		text-align: left;
		}
		.ui-dialog-buttonset .ui-button {
    background: #333 none repeat scroll 0 0 !important;
    border: medium none !important;
    border-radius: 2px !important;
    color: #fff !important;
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
	$("#checkAll").change(function () {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
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

		},
		"password": {

			required:true,

		},
		reapt_pass: {

			required:true,

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
		

	},

	messages: {

		salutation: {

			required: 'Please select salutation.',

		},

		first_name: {

			required: "Please enter first name.",

		},
		last_name: {

			required: "Please enter last name.",

		},
		country: {

			required: "Please select country.",

		},
		email_id: {

			required: "Please enter email name.",

		},
		"password": {

			required: "Please enter password.",

		},
		reapt_pass: {

			required: "Please enter confirm password.",

		},
		"hiddenRecaptcha": {
			required: "Captcha is required.",
		},
		terms_and_conditions: {

			required: "Please select terms and conditions.",
			 

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

	</script>

		
	</body>
</html>