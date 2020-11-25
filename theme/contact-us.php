<?php
   function page_content(){
   	global $co, $msg;
   	$co->page_title = "Contact us | LinkiBag";
   $current = $co->getcurrentuser_profile(); 
   ?>
   
	<section class="light-bg">
		<div class="container">
			<div class="col-md-5" id='get_in_touch_id'>
				<div class="light-panel">
					<div class="light-panel-header text-center">
						<h1>GET IN TOUCH</h1>
					</div>
					<div class='get_in_touch_detail'>
					    <h4>Get In Touch</h4>
					    <div class='col-md-12'>
					        <div class='col-md-6'><b>General Inquiries:</b></div>
					        <div class='col-md-6'><p>questions@linkibag.com</p></div>
					    </div>
					    <div class='col-md-12'>
					        <div class='col-md-6'><b>Customer Support:</b></div>
					        <div class='col-md-6'><p>info@linkibag.com</p></div>
					    </div>
					    <div class='col-md-12'>
					        <div class='col-md-6'><b>IT Support:</b></div>
					        <div class='col-md-6'><p>itsupport@linkibag.com</p></div>
					    </div>
					    <div class='col-md-12'>
					        <div class='col-md-6'><b>Media</b></div>
					        <div class='col-md-6'><p>pr@linkibag.com</p></div>
					    </div>
					   <div class='col-md-12'>
					        <div class='col-md-6'><b>Investors:</b></div>
					        <div class='col-md-6'><p>investors@linkibag.com</p></div>
					    </div>
					    <div class='col-md-12'>
					        <div class='col-md-6'><b>Advertisers:</b></div>
					        <div class='col-md-6'><p>advertise@linkibag.com</p></div>
					    </div>
					  <span>We are glad you are here and look forward to hear from you!</span>  
					</div>
				</div>
			</div>
		</div>
	</section>

	
   


<script type="text/javascript">
	function change_enquiries(val){
		if(val == 'New Account'){
			type_of_inquiery('#general_enquiry','#new_acc','#existing_acc','#product_listing_type');
		}else if(val == 'Account Upgrades'){
			type_of_inquiery('#general_enquiry','#new_acc','#existing_acc','#product_listing_type');
		}else if(val == 'Partnerships'){
			type_of_inquiery('#existing_acc','#new_acc','#general_enquiry','#product_listing_type');
		}else if(val == 'General Inquiries'){
			type_of_inquiery('#product_listing_type','#general_enquiry','#existing_acc');
		}
	}

</script>

<?php
   }
   ?>

