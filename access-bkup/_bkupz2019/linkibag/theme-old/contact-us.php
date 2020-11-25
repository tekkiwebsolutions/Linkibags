<?php
  function page_content(){
  	global $co, $msg;
  	$co->page_title = "Contact us | Linkibag";
	$current = $co->getcurrentuser_profile(); 
  ?>
<section id="public-bag">
  <div class="container bread-crumb top-line about-top" style="margin: auto;">
    <div class="col-md-7">
      <p><a href="index.php">Home </a>> Contact Us</p>
    </div>
  </div>
  <div style="padding: 15px;" class="container" id="contact-us">
    <div class="row">
			<?=isset($msg) ? $msg : ''?>
      <form method="post" id="contact_us_form" action="index.php?p=contact-us&ajax=ajax_submit" onsubmit="javascript: return contact_us();">
        <input type="hidden" name="form_id" value="contact-us"/>
        <div id="messages-out"></div>
        <div class="col-md-4">
          <div class="form-title">
            <h2>Contact Us</h2>
          </div>
          <div class="form-group col-md-11 row">
            <label class="mylabel">First Name<span class="required-field">*</span></label>
            <input type="text" name="first_name" class="form-control"  />
          </div>
          <div class="form-group col-md-11 row">
            <label class="mylabel">Last Name<span class="required-field">*</span></label>
            <input type="text" name="last_name" class="form-control" id="pwd"  />
          </div>
          <div class="form-group col-md-11 row">
            <label class="mylabel">Email<span class="required-field">*</span></label>
            <input type="email" name="email_id" class="form-control" value="<?=isset($current['email_id']) ? $current['email_id'] : ''?>" />
          </div>
          <div class="form-group col-md-11 row">
            <label class="mylabel">Phone<span class="required-field">*</span></label>
            <input type="text" name="phone" class="form-control" value="" />
          </div>
          <div class="form-group col-md-11 row">
            <label class="mylabel">Company Or Institution Name<span class="required-field">*</span></label>
            <input type="text" name="company_name" class="form-control" value="" />
          </div>
          <div class="form-group margin-top-bottom">
            <div class="row">
              <div class="col-md-5">		<label class="mylabel">Type of Inquiry<span class="required-field">*</span></label>		</div>
              <div class="col-md-7">
                <div class="radio-button">
                  <div class="radio-list">				<label><input type="radio" name="type_of_inquiry" value="Existing Account" onclick="type_of_inquiery('#new_acc','#existing_acc','#general_enquiry' );"/>	Existing Account</label>				</div>
                  <div class="radio-list">				<label><input type="radio" name="type_of_inquiry" value="New Account" onclick="type_of_inquiery('#general_enquiry','#new_acc','#existing_acc');"/>	New Account</label>				</div>
                  <div class="radio-list">				<label><input type="radio" name="type_of_inquiry" value="General Inquiries" onclick="type_of_inquiery('#new_acc','#general_enquiry','#existing_acc');"/>	General Inquiries</label>				</div>
				
				  <div class="radio-list">				<label><input type="radio" name="type_of_inquiry" value="Account Upgrades" onclick="type_of_inquiery('#general_enquiry','#new_acc','#existing_acc');"/>	Account Upgrades</label>				</div>
				  
                </div>
              </div>
            </div>
          </div>
          <div class="form-group margin-top-bottom" id="general_enquiry" style="display:none;">
            <div class="row">
              <div class="col-md-5">		<label class="mylabel">General Inquiries<span class="required-field">*</span></label>		</div>
              <div class="col-md-7">
                <div class="radio-button">
                  <div class="radio-list">				<label><input type="radio" name="general_enquiry" value="Partnership Inquiry" />	Partnership Inquiry</label>				</div>
                  <div class="radio-list">				<label><input type="radio" name="general_enquiry" value="Other" />	Other</label>				</div>
                </div>
              </div>
            </div>
          </div>
          <div id="existing_acc" style="display: none;">
            <div class="form-group margin-top-bottom">
              <div class="row">
                <div class="col-md-5">			<label class="mylabel">Existing Account<span class="required-field">*</span></label>			</div>
                <div class="col-md-7">
                  <div class="radio-button">
                    <div class="radio-list">					<label><input type="radio" name="existing_account" value="Techical Support" />	Techical Support</label>					</div>
                    <div class="radio-list">					<label><input type="radio" name="existing_account" value="Billing" />	Billing</label>					</div>
                    <div class="radio-list">					<label><input type="radio" name="existing_account" value="Other" />	Other</label>					</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-5">			<label class="mylabel">Existing Account#<span class="required-field">*</span></label>			</div>
                <div class="col-md-7">
                  <div class="radio-button">					<input class="form-control" type="text" value="" name="exit_acc_no">				</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <img src="images/contact-us.jpg" class="img-responsive"/>		
          <div class="form-group margin-top-bottom">
			<label class="mylabel">Message <span class="required-field">*</span></label>
            <textarea name="your_msg" class="form-control form-control-msg"> </textarea>
            <button type="sumit" class="btn btn-default contact-btn" id="send_contact_us" >Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<?php
  }
  ?>

