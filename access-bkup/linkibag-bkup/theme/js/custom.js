function printPageArea(areaID){
    /*var printContent = $(areaID).html();*/
    var WEB_ROOT = $("#WEB_ROOT").val();
    var serialize_value = $('#shared_urls_serialize').val();
    window.open(WEB_ROOT+'/links_print/index.php?'+serialize_value,'_blank');
    var printContent = document.getElementById(areaID);
    var WinPrint = window.open('', '', 'width=900,height=650');
    WinPrint.document.write('<html><head>');
	WinPrint.document.write('<link rel="stylesheet" href="http://www.linkibag.net/PTest25x/linkibag/theme/css/bootstrap.min.css">');
	WinPrint.document.write('<link rel="stylesheet" href="http://www.linkibag.net/PTest25x/linkibag/theme/css/linkibag.css">');
	WinPrint.document.write('</head><body onload="print();close();">');
	WinPrint.document.write('<table>');
	WinPrint.document.write(printContent.innerHTML);
	WinPrint.document.write('</table></body></html>');
    WinPrint.document.close();
    WinPrint.focus();
    
}

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
			$('#show_upload_photo').show();
            $('#show_upload_photo').attr('src', e.target.result);
        }
		
        reader.readAsDataURL(input.files[0]);
    }
}

$("#upload_photo").change(function(){
    readURL(this);
});


function show_public_cat(val){
	if(val == 3){
		$('#public_cat_block').show();
	}else{
		$('#public_cat_block').hide();
	}
	
	
}




function handle_not_submit(e){
	if(e.keyCode === 13){
		e.preventDefault(); // Ensure it is only this code that rusn

		//alert("Enter was pressed was presses");
	}
}



function search_form(){
	$("#share_urls_from_dash").removeAttr('method');
	$('#share_urls_from_dash').attr('method', 'GET');
	$('#hidden_elements').html('');
	$('input[name="page"]').remove();
	$("#share_urls_from_dash").submit();
}



$(document).ready(function(){
	$('#password').keyup(function(){
		var str=$('#password').val();
		console.log(str);
		var upper_text= new RegExp('[A-Z]');
		var lower_text= new RegExp('[a-z]');
		var number_check=new RegExp('[0-9]');

		var flag='T';

		if(str.match(upper_text)){
			$('#d12').html("<i class='fa fa-check' style='color: #AAAAAA'></i>  Include one uppercase letter");
			$('#d12').css("color", "#AAAAAA");
		}else{
			$('#d12').css("color", "#DDDDDD");
			$('#d12').html("<i class='fa fa-check' style='color: #DDDDDD'></i> Include one uppercase letter");
			flag='F';
		}

		if(str.match(lower_text)){
			$('#d13').html("<i class='fa fa-check' style='color: #AAAAAA'></i> Include a lowercase letter");
			$('#d13').css("color", "#AAAAAA");
		}else{
			$('#d13').css("color", "#DDDDDD");
			$('#d13').html("<i class='fa fa-check' style='color: #DDDDDD'></i> Include a lowercase letter");
			flag='F';
		}

		if(str.match(number_check)){
			$('#d15').html("<i class='fa fa-check' style='color: #AAAAAA'></i> Include a number");
			$('#d15').css("color", "#AAAAAA");
		}else{
			$('#d15').css("color", "#DDDDDD");
			$('#d15').html("<i class='fa fa-check' style='color: #DDDDDD'></i> Include a number");
			flag='F';
		}

		if(str.length>7){
			$('#d16').html("<i class='fa fa-check' style='color: #AAAAAA'></i> Include at least 8 characters");
			$('#d16').css("color", "#AAAAAA");
		}else{
			$('#d16').css("color", "#DDDDDD");
			$('#d16').html("<i class='fa fa-check' style='color: #DDDDDD'></i> Include at least 8 characters");
			flag='F';
		}

		if(flag=='T'){
			$("#d1").fadeOut();
			$('#display_box').css("color","#AAAAAA");
			$('#display_box').html("<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> "+str);
		}else{
			$("#d1").show();
			$('#display_box').css("color","#DDDDDD");
			$('#display_box').html("<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> "+str);
		}
	});

	$('#password').focus(function(){
		$("#d1").show();
	});
	
	$('#checkboxshow').change(function(){ 
		if($('input[name="show_password"]:checked').val() == 1){
			$('input[name="password"]').attr('type', 'text');
		}else{
			$('input[name="password"]').attr('type', 'password');
		}	
		
	});	
	
	$('.default').keyup(function(event){ 
		var keyCode = (event.keyCode ? event.keyCode : event.which);   
		if (keyCode == 13) {
		
		//var he = $("ul.chosen-choices li:first").html();	
		//alert(he);
		$( "ul.chosen-choices li:nth-last-child(2)" ).addClass( "active" );
		var email_id = $( "ul.chosen-choices li:nth-last-child(2) span" ).html();
		$( "#add_group_and_cat_form" ).prepend('<input type="hidden" name="groups_members[]" value="'+email_id+'"/>');
		//$('#chosen-choices ul').each(function() {
			//console.log($(this).find('li:first').text());
			//alert(1);
		//});
			//$('#startSearch').trigger('click');
			//alert(123);
			//$( "#chosen-choices li" ).first().addClass( "active" );
			//$( ".search-choice" ).addClass( "active" );
			//alert($( ".search-choice" ).html());
		}
		//var val = $('#chosen-choices').find('.search-choice').html();
		//var val = $('#chosen-choices li.search-choice:last-child').html();
		
		//alert(val);
	});
	$('#add_user_to_share_chosen .chosen-results').click(function(){ 
		var email_id = $( "ul.chosen-choices li:nth-last-child(2) span" ).html();
		$( "#add_group_and_cat_form" ).prepend('<input type="hidden" name="groups_members[]" value="'+email_id+'"/>');
	});
	
	

    $("#hide").click(function(){
        $(".left-sidebar-ad").hide();
    });
    $("#show").click(function(){
        $(".left-sidebar-ad").show();
    });
	$('input[name="subs_account_type"]').click(function(){
		$('input[name="subs_account_type_business_account"]').removeAttr('checked');
		$('input[name="subs_account_type_institutional_account"]').removeAttr('checked');
		//$( 'input[name="subs_account_type"]' ).each(function() {
			var acc_type = $(this).val();			
			if(acc_type === '1'){
				//$('input[name="subs_account_type_'+acc_type+'"]').removeAttr('checked');
				$("#pay_now").attr('disabled', 'true');
				$("#payment_paypal").hide();
			}else{
				$("#payment_paypal").show();
				$("#pay_now").removeAttr('disabled');
				//$('input[name="subs_account_type_'+acc_type+'"]').attr('checked', 'checked');
			}
			
		//});
		
        
    });
	$('#subs_account_type').change(function(){
		var coupon_discount = $('input[name="coupon_discount"]').val();
		var d = new Date(new Date().setFullYear(new Date().getFullYear() + 1));	
		var datestring = d.getMonth()  + "/" + d.getDate() + "/" + d.getFullYear();
	
		var acc_type = $(this).val();
		var account_due = 0;
		if(acc_type === '1'){
			$("#pay_now_block").css('opacity', '0.5');
			$("#pay_now").attr('disabled', 'true');
			$(".pay_now").attr('disabled', 'true');
			$(".pay_now").css('opacity', '0.5');
			$("#payment_paypal").attr('disabled', 'true');
			$("#account_due").html('$0.00');
			$("#next_renewal_date").html('2/29/2019');
		}else{
			if(acc_type === '2'){
				coupon_discount = Math.round(parseFloat((parseFloat(coupon_discount) * parseFloat(97.49))/parseFloat(100)));
				account_due = parseFloat(97.49 - coupon_discount);
				account_due = '$'+account_due;
			}else if(acc_type === '3'){
				coupon_discount = Math.round(parseFloat((parseFloat(coupon_discount) * parseFloat(47.99))/parseFloat(100)));
				account_due = parseFloat(47.99 - coupon_discount);
				account_due = '$'+account_due;
			}		
			$("#payment_paypal").removeAttr('disabled');
			$('input[name="paygate"]').attr('checked','checked');
			$("#pay_now").removeAttr('disabled');
			$(".pay_now").removeAttr('disabled');
			$(".pay_now").css('opacity', '1');
			$("#pay_now_block").css('opacity', '1');
			$("#account_due").html(account_due);
			$("#next_renewal_date").html(datestring);
		}
			
		
		
        
    });
	
	var default_page = $('input[name="default_page"]').val();
	/*
	// commented by jimmy on 30/07/2018
	if(default_page === 'dashboard' || default_page === 'shared-links'){
		$("#all_records tr td:first-child a").click(function(e){

			//var val = $("#all_records tr td a:first").text();
			//var val = $(this).text();
			var WEB_ROOT = $("#WEB_ROOT").val();
			var val = $(this).text();
			if(val == '')
				val = $(this).parent().prev().text();
			
			var local_link = $(this).attr('href');
			//var ht = $("#confirmation_links").html();
			//alert(local_link)
			e.preventDefault();
			var n = val.indexOf('http://');
			var m = val.indexOf('https://');
			if(n < 0 && m < 0){
				val = 'http://'+val;
			}

			var shared_url_id = $(this).prev('span').find('.urls_shared').val();			
			if(shared_url_id === undefined){
				var shared_url_id = $(this).prev('span').find('.urls_shared2').val();
			}
		
			
			$("#dialog_confirm").html('You are about to leave LinkiBag. <br /><br />You will be visiting <p style="margin: 12px 0px;line-height: 22px;color: #ff6d0d;"><a target="_blank" style="color: #ff6d0d;" href='+val+'>'+val+'</a></p> Be advised that not visiting unknown websites is an important safety practice.It is recommended to scan a URL before visiting it. <br/> For more tips on safety please visit <a href="http://linkibag.net/PTest25x/linkibag/index.php" style="color: #004080;">LinkiBag Portal</a> <p style="border-top: 1px solid #c3c3c3;margin: 11px 0 0;padding-bottom: 4px;padding-top: 10px;"><a href='+val+' target="_blank" style="color: #2a2a2a;">Would you like to continue and visit this site?</a></p>');
			$("#dialog_confirm" ).dialog({
			autoOpen: false, 
			modal: true,
			buttons: {
				"Yes" : function() {
					window.open(WEB_ROOT+'/index.php?p=scan_url&id='+shared_url_id+'&url='+encodeURIComponent(val), '_blank');
					//window.location.href='http://www.'+val;
					//window.location.href="local_link";
					//alert('1');
					$(this).dialog("close");
				 },
				 "No" : function() {
					//window.location.href=local_link;
					//window.location.href="local_link";
					$(this).dialog("close");
				 },
			},	 
			
			});
			$("#dialog_confirm").dialog( "open" );
			//$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_confirm" );
			$(".ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-front.ui-dialog-buttons.ui-draggable.ui-resizable").addClass( "visiting-site-modal" );
			$( ".ui-dialog-title" ).html( "LinkiBag" );	
			
		});
		
	}
	*/
	
	// for successful messages all are opened in dialogs
	if($("div").hasClass( "alert-success" ) && $("div").hasClass( "alert" )){
		$(".alert.alert-success").hide();
		var success_text = $(".alert.alert-success").html();
		$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
		$("#dialog_success").html(success_text);	
		$("#dialog_success" ).dialog( "open" );	
		$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
	}
	
	//$("div").find( ".alert .alert-success" ).html();
	
	
	
});

function type_of_inquiery(new_acc, show_id, hide_id, ext_acc='#show'){
	$(show_id).show();	
	$(hide_id).hide();	
	$(new_acc).hide();	
	$(ext_acc).hide();	
}	
	$(document).ready(function(){	$(".show_hide").show();		$('.show_hide').click(function(){	$(".slidingDiv").slideToggle();	});});
$(window).load(function(){
    $('.preloader').fadeOut(1000); // set duration in brackets    
});


$('.carousel_main').carousel_main({
interval: 10000
});

$(function() {
    new WOW().init();
    $('.templatemo-nav').singlePageNav({
    	offset: 70
    });

    /* Hide mobile menu after clicking on a link
    -----------------------------------------------*/
    $('.navbar-collapse a').click(function(){
        $(".navbar-collapse").collapse('hide');
    });
})

function error_dialogues(msg){
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_error" );
	$("#dialog_error").html(msg);	
	$( "#dialog_error" ).dialog( "open" );
	
}	

function submit_register(){	
	if($('#register_form').valid()){
		var formdata = new FormData($('	#register_form')[0]);
		$('#send_register').html('Checking');
		$('#send_register').attr('disabled', 'disabled');
		$.ajax({
			type: "POST",
			url: $('#register_form').attr('action'),
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
					if(res2.redirect_to){
						setTimeout(function(){
						window.location.href=res2.redirect_to;
						}, 2000);	
					}
					
					$('input[name="email_id"]').val('');
					$('input[name="password"]').val('');
					$('input[name="terms_and_conditions"]').removeAttr('checked');
					$('input[name="sign_me_for_email_filter"]').removeAttr('checked');
				}else if(res2.success === false){
					$("#dialog_error").html(res2.msg);
					$( "#dialog_error" ).dialog( "open" );					
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_error" );
				}

				//document.location.href="#messagesout";
				//$('#messagesout').html(res2);
				$('#send_register').html('Finished >');
				$('#send_register').removeAttr('disabled');
				/*$('html, body').animate({
					scrollTop: $("#register_form").offset().top
				}, 2000);
				*/
			}
		});
	}
	return false;
}

function add_multiple_users(){	
	$("#addmultipleusers_msgs").html('');
	var formdata = new FormData($('#addmultipleusers_form')[0]);
	$('#addmultipleusers_form .okbtn').html('Uploading..');
	$('#addmultipleusers_form .okbtn').attr('disabled', 'disabled');
	$.ajax({
		type: "POST",
		url: $('#addmultipleusers_form').attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			console.log('Response: '+res2);
			resjson = JSON.parse(res2);
			console.log(resjson.msg);
			if(resjson.res === 'success'){
				$('#addmultipleusers .close').trigger('click');
				$('#add_user_to_share').html(resjson.emails);
				$("#add_user_to_share").trigger("chosen:updated");
				$("#dialog_success").html(resjson.msg);
				$("#dialog_success" ).dialog( "open" );
				$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
			}else{	
				$("#addmultipleusers_msgs").html(resjson.msg);
				$('#addmultipleusers_form .okbtn').html('OK');
				$('#addmultipleusers_form .okbtn').removeAttr('disabled');
			}
		}
	});
	return false;
}

function submit_edit_profile(){	
	var formdata = new FormData($('#edit_profile_form')[0]);
	$('#send_register').html('Updating..');
	$('#send_register').attr('disabled', 'disabled');
	$.ajax({
		type: "POST",
		url: $('#edit_profile_form').attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			if(res2 === 'success'){
				window.location.reload();
			}else{	
				//$('#messagesout').html(res2);
				
				$("#dialog_error").html(res2);
				$("#dialog_error div").removeAttr( "class" );		
				$( "#dialog_error" ).dialog( "open" );
			}	
			
			
			
			$('#send_register').html('Update');
			$('#send_register').removeAttr('disabled');
			/*$('html, body').animate({
				scrollTop: $("#edit_profile_form").offset().top
			}, 2000);*/
			
		}
	});
	return false;
}
function ajax_login(){
	var formdata = new FormData($('#login_form')[0]);
	$('#send_login').html('Log in');
	$('#send_login').attr('disabled', 'disabled');
	$.ajax({
		type: "POST",
		url: $('#login_form').attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			$('#login_messages_out').html(res2);
			$('#send_login').html('Log in');
			$('#send_login').removeAttr('disabled');
		}
	});
	return false;
}

function add_url(){
	var formdata = new FormData($('#url_form')[0]);
	var btntext = $('#send_url').text();
	$('#send_url').html('working...');
	$('#send_url').attr('disabled', 'disabled');
	var sel_folder = $('#move_to_cat :selected').val();
	var cid = '';
	if(sel_folder != '-2'){
		cid = '&cid='+sel_folder;
	}
	$.ajax({
		type: "POST",
		url: $('#url_form').attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			//alert(res2);
			//$('#messages_out').html(res2);
			$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_error" );
			//res2=res2.replace('div', "");	
			//res2=res2.replace('ul', "");
			//res2=res2.replace('.alert-danger ul li', "");
			var n = res2.indexOf('Please');
			var n2 = res2.indexOf('Your');
			var n3 = res2.indexOf('invalid');
			var n4 = res2.indexOf('incorrect');
			//alert(n)
			if(n > 0 || n2 > 0 || n3 > 0 || n4 > 0){
				$("#dialog_error").html(res2);
				$("#dialog_error div").removeAttr( "class" );		
				$( "#dialog_error" ).dialog( "open" );
			}else{
				window.location.href="index.php?p=dashboard"+cid;
			}	
			$('#send_url').html(btntext);
			$('#send_url').removeAttr('disabled');
			
		}
	});
	return false;
}

function add_url_multiple(){
	var formdata = new FormData($('#url_form')[0]);
	var get_html = $('#send_url').html();
	$('#send_url').html('wait...');
	$('#send_url').attr('disabled', 'disabled');
	$.ajax({
		type: "POST",
		url: $('#url_form').attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			res2 = JSON.parse(res2);
			//alert(res2);	
			if(typeof res2.success !== 'undefined' && res2.success === true){
				if(typeof res2.msg !== 'undefined' && res2.msg !== ''){
					$("#dialog_success").html(res2.msg);
					$("#dialog_success" ).dialog( "open" );
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
				}	
				if(typeof res2.redirect_to !== 'undefined' && res2.redirect_to !== ''){
					setTimeout(function(){
						window.location.href=res2.redirect_to;
					}, 2000);					
				}					
			}else if(typeof res2.success !== 'undefined' && res2.success === false){
				if(typeof res2.msg !== 'undefined' && res2.msg !== ''){
					$("#dialog_error").html(res2.msg);
					$( "#dialog_error" ).dialog( "open" );					
				}	
			}
			
			$('#send_url').html(get_html);
			$('#send_url').removeAttr('disabled');
			
		}
	});
	return false;
}

function subscribe_emails(){
	$("#subscribe_email").css('color','');
				
}
function add_newletter(){
	var formdata = new FormData($('#newsletter_form')[0]);
	$('#newsletter_submit').html('sending...');
	$('#newsletter_submit').attr('disabled', 'disabled');
	$.ajax({
		type: "POST",
		url: $('#newsletter_form').attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			res2 = JSON.parse(res2);
			if(res2.success === true){
				$("#subscribe_email").css('color','#AAAAAA');
				$("#subscribe_email").val(res2.msg);
				//$("#dialog_success").html(res2.msg);
				//$("#dialog_success" ).dialog( "open" );
				//$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
			}else if(res2.success === false){
				$("#subscribe_email").css('color','#DDDDDD');
				$("#subscribe_email").val(res2.msg);
					//$("#dialog_error").html(res2.msg);
					//$( "#dialog_error" ).dialog( "open" );					
			}
			//alert(res2);
			//$('#newsletter_messages_out').html(res2);	
			$('#newsletter_submit').html('<i class="fa fa-angle-right" aria-hidden="true"></i>');
			$('#newsletter_submit').removeAttr('disabled');
			
		}
	});
	return false;
}

function load_edit_form(id){
	$('#edit-url-button').trigger('click');
	$('#edit-url-form .modal-body').html('Loading form');
	$.ajax({
		type: "POST",
		url: 'edit-url.php',
		data: { id: id, 'ajax': 'ajax-page'},
		success: function(res2) {
			$('#edit-url-form .modal-body').html(res2);
		}
	});
	return false;
}



function load_share_link_form(id){
	$('#share-link-button').trigger('click');
	$('#share-link-form .modal-body-2').html('Loading form');
	$.ajax({
		type: "POST",
		url: 'share-link.php',
		data: { id: id, 'ajax': 'ajax-page'},
		success: function(res2) {
			$('#share-link-form .modal-body-2').html(res2);
		}
	});
	return false;
}
function multiple_load_share(){
	//alert('1')
	$('#multiple_share_button').trigger('click');
}	

function multiple_load_share_link_form(type){
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	if(jQuery('input:checkbox[class=urls_shared]:checked').length > 0){
		var formdata = new FormData($('#share_urls_from_dash')[0]);
		if(type === 'share'){
			formdata.append('share','1');
			//var formdata = $('#share_urls_from_dash').serialize();
			$("#dialog_confirm").html("You are about to share selected link(s)?");
		}else if(type === 'mark_as_unread'){
			$("#dialog_confirm").html("You are about to unread link(s)?");
			formdata.append('mark_as_unread','1');
		}else if(type === 'mark_as_del'){
			formdata.append('mark_as_del','1');
			$("#dialog_confirm").html("Are you sure you want to delete selected link(s)?");
		}else if(type === 'print_pdf'){
			formdata.append('mark_as_print','1');
			$("#dialog_confirm").html("You are about to print selected link(s)?");
		}else if(type === 'Like'){
			formdata.append('mark_as_like','1');
			$("#dialog_confirm").html("You are about to Like selected link(s)?");
		}else if(type === 'Unlike'){
			formdata.append('mark_as_unlike','1');
			$("#dialog_confirm").html("You are about to Unlike selected link(s)?");
		}else if(type === 'Recommend'){
			formdata.append('mark_as_recommend','1');
			$("#dialog_confirm").html("You are about to Recommend selected link(s)?");
		}else if(type === 'Unrecommend'){
			formdata.append('mark_as_unrecommend','1');
			$("#dialog_confirm").html("You are about to Unrecommend selected link(s)?");
		}



		$( "#dialog_confirm" ).dialog({
			autoOpen: false, 
			modal: true,
			buttons: {
				"Yes" : function() {
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_confirm" );
					if(type === 'share'){
						//$('#share-link-button').trigger('click');
						//$('#share-link-form .modal-body-2').html('Loading form');
					}
					$.ajax({
						type: "POST",
						url: $('#share_urls_from_dash').attr('action'),
						data: formdata,
						cache: false,
						contentType: false,
						processData: false,
						success: function(res2){
							//alert(res2);
							//console.log(res2);
							if(type === 'share'){
								$('#share-link-form .modal-body-2').html(res2);
							}else if(type === 'print_pdf'){
								//for redirect
								$('#share-link-form .modal-body-2').html(res2);
							}else if(type === 'mark_as_unread'){
								//alert(res2);
								res2 = JSON.parse(res2);
								jQuery.each(res2.share_url, function(index, value) {
									jQuery('#url_'+value).removeClass('read');
									jQuery('#url_'+value).addClass('unread');
									jQuery('#url_'+value +' .visited').html('New');
								});
								$("#dialog_success").html('Successfully Link(s) unread');	
								$("#dialog_success" ).dialog( "open" );	
								$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
								$(".urls_shared").removeAttr( "checked" );	
								$("#new_linkibag_message").html(res2.total_unread);
							}else if(type === 'Like'){
								//alert(res2);
								res2 = JSON.parse(res2);
								$("#dialog_success").html('Successfully Link(s) liked');	
								$("#dialog_success" ).dialog( "open" );	
								$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
								$(".urls_shared").removeAttr( "checked" );	
								$("#total_like_urls").html(res2.total_like);
								$("#total_unlike_urls").html(res2.total_unlike);
							}else if(type === 'Unlike'){
								//alert(res2);
								res2 = JSON.parse(res2);
								$("#dialog_success").html('Successfully Link(s) unliked');	
								$("#dialog_success" ).dialog( "open" );	
								$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
								$(".urls_shared").removeAttr( "checked" );	
								$("#total_like_urls").html(res2.total_like);
								$("#total_unlike_urls").html(res2.total_unlike);
							}else if(type === 'Recommend'){
								//alert(res2);
								res2 = JSON.parse(res2);
								$("#dialog_success").html('Successfully Link(s) recommended');	
								$("#dialog_success" ).dialog( "open" );	
								$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
								$(".urls_shared").removeAttr( "checked" );	
								$("#total_recommend_urls").html(res2.total_recommend);
								$("#total_unrecommend_urls").html(res2.total_unrecommend);
							}else if(type === 'Unrecommend'){
								//alert(res2);
								res2 = JSON.parse(res2);
								$("#dialog_success").html('Successfully Link(s) unrecommended');	
								$("#dialog_success" ).dialog( "open" );	
								$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
								$(".urls_shared").removeAttr( "checked" );	
								$("#total_recommend_urls").html(res2.total_recommend);
								$("#total_unrecommend_urls").html(res2.total_unrecommend);
							}else if(type === 'mark_as_del'){
								//alert(res2)
								res2 = JSON.parse(res2);
								//jQuery.each(res2, function(index, value) {
								//	jQuery('#url_'+value).html('');
								//});
								//new code
								jQuery('#checkAll').removeAttr('checked');
								//jQuery('#all_records tbody').html('');
								//jQuery('#all_records tbody').append(res2.new_row);
								if(res2.page_link_option){
									$("#link_new_paging li:last").remove();
								}	
								jQuery.each(res2.del_row, function(index, value) {
									jQuery('#url_'+value).remove();
								});
								//end new code
								$("#dialog_success").html('Successfully Link(s) deleted');	
								$("#dialog_success" ).dialog( "open" );	
								$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
								$(".new_linkibag_message").html(res2.total_new_row);
							}
								
						}
					});
					
					$(this).dialog("close");
				},
				"No" : function() {
					$(this).dialog("close");
					
				}
		   },
		   
		   
		});
		if(type === 'share'){
			$.ajax({
				type: "POST",
				url: $('#share_urls_from_dash').attr('action'),
				data: formdata,
				cache: false,
				contentType: false,
				processData: false,
				success: function(res2){
					if(type === 'share'){
						$('#share-link-form .modal-body-2').html(res2);
					}
				}
			});
		}else{
			$("#dialog_confirm").dialog( "open" );
			$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_confirm" );
			$( ".ui-dialog-title" ).html( "LinkiBag" );		
		}
	}else{
		var alert_msg = '' ;
		if(type === 'share'){
			alert_msg = ' share';
		}else if(type === 'mark_as_unread'){
			alert_msg = ' unread';	
		}else if(type === 'mark_as_del'){
			alert_msg = ' delete';	
		}else if(type === 'print_pdf'){
			alert_msg = ' print pdf file';	
		}else if(type === 'Like'){
			alert_msg = ' Like';	
		}else if(type === 'Unlike'){
			alert_msg = ' Unlike';	
		}else if(type === 'Recommend'){
			alert_msg = ' Recommend';	
		}else if(type === 'Unrecommend'){
			alert_msg = ' Unrecommend';	
		}
		$("#dialog_error").html("Please select the link(s) you would like to"+alert_msg);	
		$( "#dialog_error" ).dialog( "open" );	
		
	}	
	
	return false;
}

function create_linkibook(){
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	if(jQuery('input:checkbox[class=urls_shared]:checked').length > 0){
		var url = 'index.php?p=create_linkibook';
		jQuery('input:checkbox[class=urls_shared]:checked').each(function () {
			url += '&url[]='+$(this).val();
	    });
	    window.location.href = url;
	}else{
		$("#dialog_error").html("Please select the link(s) you would like to add to LinkiBook");	
		$( "#dialog_error" ).dialog( "open" );
	}	
	
	return false;
}

function multiple_linkibook_delete(){
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	if(jQuery('input:checkbox[class=urls_shared]:checked').length > 0){
		var url = 'form_id=delete_linkibook';
		jQuery('input:checkbox[class=urls_shared]:checked').each(function () {
			url += '&book%5B%5D='+$(this).val();
	    });

	    $("#dialog_confirm").html("You are about to delete selected LinkiBook?");

	    $( "#dialog_confirm" ).dialog({
		   	autoOpen: false, 
		  	modal: true,
		   	buttons: {
				"Yes" : function() {
					$('#mainloading').show();
				    $.ajax({
						type: "POST",
						url: 'index.php?p=linkibook',
						data: url,
						success: function(res2){
							if(res2 === 'success'){
								window.location.href = 'index.php?p=linkibook';
							}else{
								$("#dialog_error").html(res2);
								$("#dialog_error").dialog("open");
							}
						}
					});
				},
				"No" : function() {
					$(this).dialog("close");
					
				}
		   	},   
		});
		$("#dialog_confirm").dialog( "open" );

	}else{
		$("#dialog_error").html("Please select the linkibook(s) you would like to delete");
		$("#dialog_error").dialog("open");
	}	
	
	return false;
}

function multiple_linkibook_share(){
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	if(jQuery('input:checkbox[class=urls_shared]:checked').length > 0){
		var url = 'p=share-linkibook';
		jQuery('input:checkbox[class=urls_shared]:checked').each(function () {
			url += '&book%5B%5D='+$(this).val();
	    });

	    $("#dialog_confirm").html("You are about to share selected LinkiBook?");

	    $( "#dialog_confirm" ).dialog({
		   	autoOpen: false, 
		  	modal: true,
		   	buttons: {
				"Yes" : function() {
					window.location.href= "index.php?"+url;
				},
				"No" : function() {
					$(this).dialog("close");
					
				}
		   	},   
		});
		$("#dialog_confirm").dialog( "open" );

	}else{
		$("#dialog_error").html("Please select the linkibook(s) you would like to share");
		$("#dialog_error").dialog("open");
	}	
	
	return false;
}

function share_linkibook(val){
	
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_error" );
	
	var formdata = new FormData($('#share_form_'+val)[0]);
	$('#send_share_link').html('Sharing...');
	$('#send_share_link').attr('disabled', 'disabled');
	console.log($('#share_form_'+val).attr('action'));
	console.log($('#share_form_'+val).serialize());
	$.ajax({
		type: "POST",
		url: $('#share_form_'+val).attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			console.log(res2);
			res2 = JSON.parse(res2);
			
			$('#url-shared-messages-out_'+val).html('');
			if(res2.success === true){
				$(".urls_shared").removeAttr( "checked" );
				$("#dialog_success").html(res2.msg);
				$("#dialog_success" ).dialog( "open" );
				$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
				$(".ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-front.ui-dialog-buttons.ui-draggable.ui-resizable").addClass( "sharing-links-success-panel-widget-new" );				
				$(".ui-dialog-buttonpane.ui-widget-content.ui-helper-clearfix").remove();
				$("#table_serialize_for_print").html(res2.table_serialize_for_print);				
				//window.location.href = "index.php?p=dashboard";
			}else if(res2.success === false){
				 //$('#url-shared-messages-out_'+val).html(res2.msg);
					$("#dialog_error").html(res2.msg);
					$("#dialog_error div").removeAttr( "class" );		
					$( "#dialog_error" ).dialog( "open" );
					
			}
			$('#send_share_link_'+val).html('Share');
			$('#send_share_link_'+val).removeAttr('disabled', 'disabled');	
			
		}
	});
	return false;
}

function load_edit_frm(id, typ){
	//$('.add-new-gp').html('');
	$('#add_groups_and_cat #model_body2').html('');
	$('#edit_new_folder').trigger('click');
	$('#edit_groups_and_cat #model_body2').html('Loading form');
	$.ajax({
		type: "POST",
		url: 'edit_groups_and_cat.php',
		data: { id: id, 'type': typ},
		success: function(res2) {
			//alert(res2);
			$('#edit_groups_and_cat #model_body2').html(res2);
		}
	});
	return false;
}

function empty_links(cid,trash,type='category'){
	$("#dialog_success").html('');
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	if(type === 'category'){
		$("#dialog_confirm").html("You are about to empty this folder? All link(s) of this folder will go to trash folder.");
	}else if(type === 'group'){
		$("#dialog_confirm").html("You are about to empty this group? All friends will go to ungrouped folder.");
	}	
	$( "#dialog_confirm" ).dialog({
	   autoOpen: false, 
	   modal: true,
	   buttons: {
			"Yes" : function() {
				$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_confirm" );
				$('#empty_confirm_'+cid).html('0');
				$('#empty_total_'+cid).html('0');
				var trashed = $('#empty_'+cid).html();
				var trashe = $('#empty_0').html();
				$('#empty_'+cid).html('0');
				$.ajax({
					type: "POST",
					url: 'ajax/empty_links.php',
					data: { id: cid, 'ajax': 1, trash: trash, type: type},
					success: function(res2) {
						//alert(res2);
						if(type === 'category'){
							trashe = parseInt(trashe) + parseInt(trashed);
							$('#empty_0').html(trashe);
						}
						$("#dialog_success").html(res2);	
						$( "#dialog_success" ).dialog( "open" );	
						$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
						//alert(res2);
						
					}
				});
				
				$(this).dialog("close");
			},
			"No" : function() {
				$(this).dialog("close");
				
			}
	   },
	   
	   
	});
	$("#dialog_confirm").dialog( "open" );
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_confirm" );
	$( ".ui-dialog-title" ).html( "LinkiBag" );	
	return false;
		
}

function load_add_frm(typ,page){
	if(typ == 'public_category'){
		$('#add_groups_and_cat .modal-header h4').html('Add New Category');
	}else{
		$('#add_groups_and_cat .modal-header h4').html('Add New Folder');
	}
	$('#edit_groups_and_cat #model_body2').html('');
	$('#add_new_folder').trigger('click');
	$('#add_groups_and_cat #model_body').html('Loading form');
	$.ajax({
		type: "POST",
		url: 'add_groups_and_cat.php',
		data: {'type': typ, 'ajax': 1, 'page': page},
		success: function(res2) {
			$('#add_groups_and_cat #model_body').html(res2);
		}
	});
	return false;
}

function invite_friend_again(submitform){

	if(jQuery('input:checkbox[class=urls_shared]:checked').length > 0){
		var invite_disabled = [];
		var confirmed_requests = [];
		$("input[class='invite_disabled']").each(function () {
	        invite_disabled.push( $(this).val() );
	    });
	    $("input[class='confirmed_requests']").each(function () {
	        confirmed_requests.push( $(this).val() );
	    });

	    console.log(invite_disabled);
	    console.log(confirmed_requests);

	    var errormsg = '';
	    $("input[class=urls_shared]:checked").each(function () {
	        if(jQuery.inArray($(this).val(), invite_disabled) !== -1){
	        	errormsg = 'You can send up to 3 invites only to the same email address';
	        }
	        if(jQuery.inArray($(this).val(), confirmed_requests) !== -1){
	        	errormsg = 'You can only invite user who are not friends yet!';
	        }
	    });

	    if(errormsg != ''){
	    	$("#dialog_error").html(errormsg);
			$("#dialog_error").dialog( "open" );
	    }else{
	    	$("#dialog_confirm").html("You can send up to 3 invites to the same email address. Would you like to invite selected user again?");
			
			$("#dialog_confirm").dialog({
				autoOpen: false, 
				modal: true,
				buttons: {
					"OK" : function() {
						$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_confirm" );
						var formdata = new FormData($(submitform)[0]);
						formdata.append('form_id','invite_friend_again');
						console.log('Submitting form');
						console.log(formdata);
						console.log($(submitform).attr('action'));
						$('#mainloading').show();
						$('#mainloading_wording').html('Submitting...');
						$.ajax({
							type: "POST",
							url: $(submitform).attr('action'),
							data: formdata,
							cache: false,
							contentType: false,
							processData: false,
							success: function(res2){
								res2 = JSON.parse(res2);				
								if(res2.success){
									$(".urls_shared").removeAttr( "checked" );		
									window.location.reload();
								}else if(res2.error){
									$('#mainloading').hide();
									$("#dialog_error").html(res2.error);
									$("#dialog_error").dialog( "open" );
								}
							}
						});			
						$(this).dialog("close");
					},
					"Cancel" : function() {
						$(this).dialog("close");
						
					}
				},
			});
			$("#dialog_confirm").dialog( "open" );
			$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_confirm" );
			$( ".ui-dialog-title" ).html( "LinkiBag" );
	    }
	}else{
		$("#dialog_error").html("Please select the request(s) you would like to invite");
		$( "#dialog_error" ).dialog( "open" );
	}
	
}

function delete_pending_request(submitform){

	if(jQuery('input:checkbox[class=urls_shared]:checked').length > 0){
		$("#dialog_confirm").html("Are you sure you want to delete selected invite(s)?");
		
		$("#dialog_confirm").dialog({
			autoOpen: false, 
			modal: true,
			buttons: {
				"OK" : function() {
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_confirm" );
					var formdata = new FormData($(submitform)[0]);
					formdata.append('form_id','delete_pending_request');
					$('#mainloading').show();
					$('#mainloading_wording').html('Submitting...');
					$.ajax({
						type: "POST",
						url: $(submitform).attr('action'),
						data: formdata,
						cache: false,
						contentType: false,
						processData: false,
						success: function(res2){
							res2 = JSON.parse(res2);				
							if(res2.success){
								jQuery.each(res2.del_row, function(index, value) {
									jQuery('#all_records tbody #url_'+value).remove();
								});
								var num_pending_invite = jQuery('#new_linkibag_friends').html();
								var new_pending_count = parseInt(num_pending_invite) - parseInt(res2.del_row_count);
								
								jQuery('#new_linkibag_friends, #sidebar_pending_req_count').html(new_pending_count);
								$('#mainloading').hide();
							}else if(res2.error){
								$('#mainloading').hide();
								$("#dialog_error").html(res2.error);
								$("#dialog_error").dialog( "open" );
							}
						}
					});			
					$(this).dialog("close");
				},
				"Cancel" : function() {
					$(this).dialog("close");
					
				}
			},
		});
		$("#dialog_confirm").dialog( "open" );
		$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_confirm" );
		$( ".ui-dialog-title" ).html( "LinkiBag" );
	}else{
		$("#dialog_error").html("Please select the request(s) you would like to delete");
		$( "#dialog_error" ).dialog( "open" );
	}
	
}

function move_to_category_multiple(submitform, type='category', unfriend='0', mark_as_unread='0', del='0'){
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	if(jQuery('input:checkbox[class=urls_shared]:checked').length > 0){
		var cat = $('#move_to_cat').val();
		var formdata = new FormData($(submitform)[0]);
		var group_delete = 0;
		if(type === 'category'){
			//$("#dialog_confirm").html("You are about to move link(s) to this category?");
			formdata.append('cat',cat);
			formdata.append('form_id','move_to_cat_multiple');
			formdata.append('type',type);
			formdata.append('unfriend',unfriend);
			formdata.append('group_delete',group_delete);
			formdata.append('mark_as_unread',mark_as_unread);
			$.ajax({
				type: "POST",
				url: $(submitform).attr('action'),
				data: formdata,
				cache: false,
				contentType: false,
				processData: false,
				success: function(res2){
					//alert(res2);
					res2 = JSON.parse(res2);				
					if(res2.msg){
						$(".urls_shared").removeAttr( "checked" );		
						$("#dialog_success").html(res2.msg_content);
						if(type === 'category'){
							if(cat === '0'){
								setTimeout(function(){
									window.location.href="index.php?p=dashboard&trash=1&cid="+cat;
								}, 3000);
							}else{
								setTimeout(function(){
									window.location.href="index.php?p=dashboard&cid="+cat;
								}, 3000);
							}									
						}else if(type === 'group'){
							jQuery('#remove_friend_list_block').html('');
							if(unfriend === '0'){
								// window.location.href="index.php?p=linkifriends&gid="+cat;
							}	
						}	
						$( "#dialog_success" ).dialog( "open" );	
						$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
						if(typeof res2.new_row !== 'undefined' && res2.new_row !== ''){
							jQuery('#all_records tbody').html('');
							jQuery('#all_records tbody').append(res2.new_row);
						}

						if(mark_as_unread === '1'){
							jQuery.each(res2.share_url, function(index, value) {
								jQuery('#url_'+value).removeClass('read');
								jQuery('#url_'+value).addClass('unread');
								jQuery('#url_'+value +' .visited').html('New');
							});
							$("#dialog_success").html(res2.msg_content);	
							$("#dialog_success" ).dialog( "open" );	
							$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
							$(".urls_shared").removeAttr( "checked" );	
							$("#new_linkibag_friends").html(res2.total_unread);
						}
						//alert("Successfully Moved !");
					}else if(res2.error){
						//alert(res2.error);
					}
				}
			});
			return false;
					
		}else if(type === 'group'){
			if(unfriend === '1'){
				$("#dialog_confirm").html("You are about to do unfriends?");
			}else if(mark_as_unread === '1'){
				$("#dialog_confirm").html("You are about to do unread?");
			}else if(del === '-1'){
				cat = -2;
				group_delete = 1;
				$("#dialog_confirm").html("Selected group member(s) will be removed from a group?");
			}else{	
				$("#dialog_confirm").html("You are about to move selected friend(s) to another group.");
			}	
		}else if(type === 'group-pendinginvite'){
			type = 'group';
			if(unfriend === '1'){
				$("#dialog_confirm").html("You are about to do unfriends?");
			}else if(mark_as_unread === '1'){
				$("#dialog_confirm").html("You are about to do unread?");
			}else if(del === '-1'){
				cat = -2;
				group_delete = 1;
				$("#dialog_confirm").html("Selected group member(s) will be removed from a group?");
			}else{	
				$("#dialog_confirm").html("You are about to move selected invite(s) to another group.");
			}	
		}
		$("#dialog_confirm").dialog({
			autoOpen: false, 
			modal: true,
			buttons: {
				"OK" : function() {
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_confirm" );
					formdata.append('cat',cat);
					formdata.append('form_id','move_to_cat_multiple');
					formdata.append('type',type);
					formdata.append('unfriend',unfriend);
					formdata.append('group_delete',group_delete);
					formdata.append('mark_as_unread',mark_as_unread);
					$('#mainloading').show();
					$('#mainloading_wording').html('Submitting...');
					$.ajax({
						type: "POST",
						url: $(submitform).attr('action'),
						data: formdata,
						cache: false,
						contentType: false,
						processData: false,
						success: function(res2){
							res2 = JSON.parse(res2);				
							if(res2.msg){
								$(".urls_shared").removeAttr( "checked" );
								if(res2.reloadme == 1){
									window.location.reload();
								}else{
									$('#mainloading').hide();
								}
								if(res2.msg_content!='NOT_SHOW'){
									$("#dialog_success").html(res2.msg_content);
									$( "#dialog_success" ).dialog( "open" );	
									$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
								}
								
								if(type === 'category'){
									if(cat === '0'){
										window.location.href="index.php?p=dashboard&trash=1&cid="+cat;
									}else{
										window.location.href="index.php?p=dashboard&cid="+cat;
									}									
								}else if(type === 'group'){
									jQuery('#remove_friend_list_block').html('');
									if(unfriend === '0'){
										// window.location.href="index.php?p=linkifriends&gid="+cat;
									}	
								}	
								
								if(typeof res2.new_row !== 'undefined' && res2.new_row !== ''){
									jQuery('#all_records tbody').html('');
									jQuery('#all_records tbody').append(res2.new_row);
								}

								if(mark_as_unread === '1'){
									jQuery.each(res2.share_url, function(index, value) {
										jQuery('#url_'+value).removeClass('read');
										jQuery('#url_'+value).addClass('unread');
										jQuery('#url_'+value +' .visited').html('New');
									});
									$("#dialog_success").html(res2.msg_content);	
									$("#dialog_success" ).dialog( "open" );	
									$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
									$(".urls_shared").removeAttr( "checked" );	
									$("#new_linkibag_friends").html(res2.total_unread);
								}
								//alert("Successfully Moved !");
							}else if(res2.error){
								//alert(res2.error);
							}
						}
					});
					$(this).dialog("close");
				},
				"Cancel" : function() {
					$(this).dialog("close");
					
				}
			},
		});
		$("#dialog_confirm").dialog( "open" );
		$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_confirm" );
		$( ".ui-dialog-title" ).html( "LinkiBag" );	
		//var x = confirm("Are you sure you want to move category");
	}else{
		if(type === 'category'){
			$("#dialog_error").html("Please select the link(s) you would like to move");	
		}else if(type === 'group'){
			if(unfriend === '1'){
				$("#dialog_error").html("Select the friends you would like to do unfriend");	
			}else if(mark_as_unread === '1'){
				$("#dialog_error").html("Select the requests you would like to unread");	
			}else if(del === '-1'){
				/*$("#dialog_error").html("Select the friends you would like to delete");	*/
				$("#dialog_error").html("No items have been selected from the list.Please select at least one group member and try again.");	
			}else{
				/*$("#dialog_error").html("Select the friends you would like to move");*/		
				$("#dialog_error").html("No items have been selected from the list.Please select at least one group member and try again.");		
			}	
		}	
		$( "#dialog_error" ).dialog( "open" );	
		
	}		
	return false;
}	

function move_to_category(id, user_id, typ, cat){
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	if(typ === 'move_cat'){
		//$("#dialog_confirm").html("You are about to move this link(s) to this category?");
		$.ajax({
			type: "POST",
			url: 'ajax/move_to_cat.php',
			data: {'id': id, 'cat': cat, 'user_id': user_id, 'type': typ},
			success: function(res2){
				//alert(res2);
				res2 = JSON.parse(res2);
				if(res2.msg){
					$("#dialog_success").html('Link successfully moved !');
					$("#dialog_success").dialog( "open" );
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
				}else if(res2.del){
					$("#dialog_success").html('Link successfully deleted !');
					$("#dialog_success").dialog( "open" );
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
					setTimeout(function(){
						window.location.href="index.php?p=dashboard";
					}, 2000);
					
				}
				$('#view_link_load_img').css('display','none');	

			}
		});
		return false;
	}else if(typ === 'del'){
		$("#dialog_confirm").html("You are about to delete this? This cant not be Undo.");
		
	}
	$( "#dialog_confirm" ).dialog({
	   autoOpen: false, 
	   modal: true,
	   buttons: {
			"Confirm" : function() {
				$('#view_link_load_img').css('display','block');
				$.ajax({
					type: "POST",
					url: 'ajax/move_to_cat.php',
					data: {'id': id, 'cat': cat, 'user_id': user_id, 'type': typ},
					success: function(res2){
						//alert(res2);
						res2 = JSON.parse(res2);
						if(res2.msg){
							$("#dialog_success").html('Link successfully moved !');
							$("#dialog_success").dialog( "open" );
							$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
						}else if(res2.del){
							$("#dialog_success").html('Link successfully deleted !');
							$("#dialog_success").dialog( "open" );
							$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
							setTimeout(function(){
								window.location.href="index.php?p=dashboard";
							}, 2000);
							
						}
						$('#view_link_load_img').css('display','none');	

					}
				});
				$(this).dialog("close");
				
			},
			"Cancel" : function() {
				$(this).dialog("close");
				
			}
	   },
	   
	   
	});
	$("#dialog_confirm").dialog( "open" );
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_confirm" );
	$( ".ui-dialog-title" ).html( "LinkiBag" );	
	return false;
	
}


function mylinks_move_to_category_multiple(submitform, type='category', unfriend='0', mark_as_unread='0', del='0'){
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	if(jQuery('input:checkbox[class=urls_shared]:checked').length > 0){
		var cat = $('#move_to_cat').val();
		var formdata = new FormData($(submitform)[0]);
		var group_delete = 0;
		if(type === 'category'){
			//$("#dialog_confirm").html("You are about to move link(s) to this category?");
			formdata.append('cat',cat);
			formdata.append('form_id','move_to_cat_multiple');
			formdata.append('type',type);
			formdata.append('unfriend',unfriend);
			formdata.append('group_delete',group_delete);
			formdata.append('mark_as_unread',mark_as_unread);
			$.ajax({
				type: "POST",
				url: $(submitform).attr('action'),
				data: formdata,
				cache: false,
				contentType: false,
				processData: false,
				success: function(res2){
					//alert(res2);
					res2 = JSON.parse(res2);				
					if(res2.msg){
						$(".urls_shared").removeAttr( "checked" );		
						$("#dialog_success").html(res2.msg_content);
						if(type === 'category'){
							if(cat === '0'){
								setTimeout(function(){
									window.location.href="index.php?p=mylinks&trash=1&cid="+cat;
								}, 3000);
							}else{
								setTimeout(function(){
									window.location.href="index.php?p=mylinks&cid="+cat;
								}, 3000);
							}									
						}else if(type === 'group'){
							jQuery('#remove_friend_list_block').html('');
							if(unfriend === '0'){
								// window.location.href="index.php?p=linkifriends&gid="+cat;
							}	
						}	
						$( "#dialog_success" ).dialog( "open" );	
						$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
						if(typeof res2.new_row !== 'undefined' && res2.new_row !== ''){
							jQuery('#all_records tbody').html('');
							jQuery('#all_records tbody').append(res2.new_row);
						}

						if(mark_as_unread === '1'){
							jQuery.each(res2.share_url, function(index, value) {
								jQuery('#url_'+value).removeClass('read');
								jQuery('#url_'+value).addClass('unread');
								jQuery('#url_'+value +' .visited').html('New');
							});
							$("#dialog_success").html(res2.msg_content);	
							$("#dialog_success" ).dialog( "open" );	
							$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
							$(".urls_shared").removeAttr( "checked" );	
							$("#new_linkibag_friends").html(res2.total_unread);
						}
						//alert("Successfully Moved !");
					}else if(res2.error){
						//alert(res2.error);
					}
				}
			});
			return false;
					
		}else if(type === 'group'){
			if(unfriend === '1'){
				$("#dialog_confirm").html("You are about to do unfriends?");
			}else if(mark_as_unread === '1'){
				$("#dialog_confirm").html("You are about to do unread?");
			}else if(del === '-1'){
				cat = -2;
				group_delete = 1;
				$("#dialog_confirm").html("Selected group member(s) will be removed from a group?");
			}else{	
				$("#dialog_confirm").html("You are about to move selected friend(s) to another group.");
			}	
		}else if(type === 'group-pendinginvite'){
			type = 'group';
			if(unfriend === '1'){
				$("#dialog_confirm").html("You are about to do unfriends?");
			}else if(mark_as_unread === '1'){
				$("#dialog_confirm").html("You are about to do unread?");
			}else if(del === '-1'){
				cat = -2;
				group_delete = 1;
				$("#dialog_confirm").html("Selected group member(s) will be removed from a group?");
			}else{	
				$("#dialog_confirm").html("You are about to move selected invite(s) to another group.");
			}	
		}
		$("#dialog_confirm").dialog({
			autoOpen: false, 
			modal: true,
			buttons: {
				"OK" : function() {
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_confirm" );
					formdata.append('cat',cat);
					formdata.append('form_id','move_to_cat_multiple');
					formdata.append('type',type);
					formdata.append('unfriend',unfriend);
					formdata.append('group_delete',group_delete);
					formdata.append('mark_as_unread',mark_as_unread);
					$('#mainloading').show();
					$('#mainloading_wording').html('Submitting...');
					$.ajax({
						type: "POST",
						url: $(submitform).attr('action'),
						data: formdata,
						cache: false,
						contentType: false,
						processData: false,
						success: function(res2){
							res2 = JSON.parse(res2);				
							if(res2.msg){
								$(".urls_shared").removeAttr( "checked" );
								if(res2.reloadme == 1){
									window.location.reload();
								}else{
									$('#mainloading').hide();
								}
								if(res2.msg_content!='NOT_SHOW'){
									$("#dialog_success").html(res2.msg_content);
									$( "#dialog_success" ).dialog( "open" );	
									$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
								}
								
								if(type === 'category'){
									if(cat === '0'){
										window.location.href="index.php?p=mylinks&trash=1&cid="+cat;
									}else{
										window.location.href="index.php?p=mylinks&cid="+cat;
									}									
								}else if(type === 'group'){
									jQuery('#remove_friend_list_block').html('');
									if(unfriend === '0'){
										// window.location.href="index.php?p=linkifriends&gid="+cat;
									}	
								}	
								
								if(typeof res2.new_row !== 'undefined' && res2.new_row !== ''){
									jQuery('#all_records tbody').html('');
									jQuery('#all_records tbody').append(res2.new_row);
								}

								if(mark_as_unread === '1'){
									jQuery.each(res2.share_url, function(index, value) {
										jQuery('#url_'+value).removeClass('read');
										jQuery('#url_'+value).addClass('unread');
										jQuery('#url_'+value +' .visited').html('New');
									});
									$("#dialog_success").html(res2.msg_content);	
									$("#dialog_success" ).dialog( "open" );	
									$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
									$(".urls_shared").removeAttr( "checked" );	
									$("#new_linkibag_friends").html(res2.total_unread);
								}
								//alert("Successfully Moved !");
							}else if(res2.error){
								//alert(res2.error);
							}
						}
					});
					$(this).dialog("close");
				},
				"Cancel" : function() {
					$(this).dialog("close");
					
				}
			},
		});
		$("#dialog_confirm").dialog( "open" );
		$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_confirm" );
		$( ".ui-dialog-title" ).html( "LinkiBag" );	
		//var x = confirm("Are you sure you want to move category");
	}else{
		if(type === 'category'){
			$("#dialog_error").html("Please select the link(s) you would like to move");	
		}else if(type === 'group'){
			if(unfriend === '1'){
				$("#dialog_error").html("Select the friends you would like to do unfriend");	
			}else if(mark_as_unread === '1'){
				$("#dialog_error").html("Select the requests you would like to unread");	
			}else if(del === '-1'){
				/*$("#dialog_error").html("Select the friends you would like to delete");	*/
				$("#dialog_error").html("No items have been selected from the list.Please select at least one group member and try again.");	
			}else{
				/*$("#dialog_error").html("Select the friends you would like to move");*/		
				$("#dialog_error").html("No items have been selected from the list.Please select at least one group member and try again.");		
			}	
		}	
		$( "#dialog_error" ).dialog( "open" );	
		
	}		
	return false;
}	

function mylinks_move_to_category(id, user_id, typ, cat){
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	if(typ === 'move_cat'){
		//$("#dialog_confirm").html("You are about to move this link(s) to this category?");
		$.ajax({
			type: "POST",
			url: 'ajax/move_to_cat.php',
			data: {'id': id, 'cat': cat, 'user_id': user_id, 'type': typ},
			success: function(res2){
				//alert(res2);
				res2 = JSON.parse(res2);
				if(res2.msg){
					$("#dialog_success").html('Link successfully moved !');
					$("#dialog_success").dialog( "open" );
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
				}else if(res2.del){
					$("#dialog_success").html('Link successfully deleted !');
					$("#dialog_success").dialog( "open" );
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
					setTimeout(function(){
						window.location.href="index.php?p=mylinks";
					}, 2000);
					
				}
				$('#view_link_load_img').css('display','none');	

			}
		});
		return false;
	}else if(typ === 'del'){
		$("#dialog_confirm").html("You are about to delete this? This cant not be Undo.");
		
	}
	$( "#dialog_confirm" ).dialog({
	   autoOpen: false, 
	   modal: true,
	   buttons: {
			"Confirm" : function() {
				$('#view_link_load_img').css('display','block');
				$.ajax({
					type: "POST",
					url: 'ajax/move_to_cat.php',
					data: {'id': id, 'cat': cat, 'user_id': user_id, 'type': typ},
					success: function(res2){
						//alert(res2);
						res2 = JSON.parse(res2);
						if(res2.msg){
							$("#dialog_success").html('Link successfully moved !');
							$("#dialog_success").dialog( "open" );
							$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
						}else if(res2.del){
							$("#dialog_success").html('Link successfully deleted !');
							$("#dialog_success").dialog( "open" );
							$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
							setTimeout(function(){
								window.location.href="index.php?p=mylinks";
							}, 2000);
							
						}
						$('#view_link_load_img').css('display','none');	

					}
				});
				$(this).dialog("close");
				
			},
			"Cancel" : function() {
				$(this).dialog("close");
				
			}
	   },
	   
	   
	});
	$("#dialog_confirm").dialog( "open" );
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_confirm" );
	$( ".ui-dialog-title" ).html( "LinkiBag" );	
	return false;
	
}

function url_clears(){
	$('#url_form')[0].reset();
	var btntext = $('#url_clear').text();
	$('#url_clear').html('Clearing...');
	setTimeout(function(){
		$('#url_clear').html(btntext);
	}, 500);
	
	
}

function share_msg_back(){
	$('.sharemsgtext').show();
	$('#save_btn').show();
	$('.sharemsgemptytext').hide();
	$('#back_btn_share_msg').hide();
	$('#continue_btn_share_msg').hide();
}

function share_msg_continue(){
	$('#confirmemptymsg').val(1);
	$('#save_btn').trigger( "click" )
}

function add_new_group(submitform){
	var item_per_page = jQuery('input[name=item_per_page]').val();
	var this_page = jQuery('input[name=this_page]').val();
	/*$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_error" );*/
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_error" );
	var formdata = new FormData($(submitform)[0]);
	var form_id = $('#updated_post_id').val();
	formdata.append('item_per_page',item_per_page);
	formdata.append('this_page',this_page);
	$('#save_btn').html('Working ...');
	$.ajax({
		type: "POST",
		url: $(submitform).attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2){	
			//alert(res2);
			res2 = JSON.parse(res2);
			if(res2.sharingemptymsg){
				$('.sharemsgtext').hide();
				$('#save_btn').hide();
				$('.sharemsgemptytext').show();
				$('#back_btn_share_msg').show();
				$('#continue_btn_share_msg').show();
				$('#save_btn').html('Continue');
				return false;
			}
			
			if(res2.id > 0){
				jQuery('#record_'+res2.id).html(res2.new_row);
				$('#edit_groups_and_cat').modal('toggle');				
				/*setTimeout(function(){
					$('#edit_groups_and_cat').modal('toggle');				
					}, 1000);	*/
			}else{
				if(res2.success === true){
					if(res2.option){
						$('#move_to_cat').html(res2.option)
						/*var sel_val = $('#move_to_cat :selected').val();
						$('#move_to_cat option[value=' + sel_val + ']').remove();
						$('#move_to_cat option:first').after(res2.option);*/
					}else if(res2.public_cat_option){
						$('#move_to_public_cat').html(res2.public_cat_option);
						/*var sel_val = $('#move_to_public_cat :selected').val();
						$('#move_to_public_cat option[value=' + sel_val + ']').remove();
						$('#move_to_public_cat option:first').after(res2.public_cat_option);*/
					}else{	
						//jQuery('#all_records tbody').prepend(res2.new_row);

						var rowCount = $('#all_records tr').length;
						if(this_page === 'p=mylinkifriends'){
							jQuery("#all_records tr").slice(1).remove();	
							jQuery('#all_records tr:eq(0)').after(res2.new_row);	
						}else{
							jQuery("#all_records tr").slice(2).remove();	
							jQuery('#all_records tr:eq(1)').after(res2.new_row);	
						}
						/*
						if(rowCount === 11){
							if(res2.this_page === 'p=linkifriends'){
								jQuery('#all_records tr:first').after(res2.new_row);	
								jQuery('#all_records tr:last').remove();
							}else{
								jQuery("#all_records tr").slice(2).remove();		
								jQuery('#all_records tr:eq(0)').after(res2.new_row);
							}	
						}else{
							if(res2.this_page === 'p=linkifriends'){
								jQuery('#all_records tr:first').after(res2.new_row);	
							}else{

								jQuery("#all_records tr").slice(2).remove();	
								jQuery('#all_records tr:eq(1)').after(res2.new_row);	
							}
							
						}
						*/	
						
					}
				}
				if(form_id > '0')
					$('#edit_groups_and_cat').modal('toggle');
				else 
					$('#add_groups_and_cat').modal('toggle');
				
				/*setTimeout(function(){
				$('#add_groups_and_cat').modal('toggle');
			}, 1000);	*/
			}
			
			
			if(res2.success === true){
				/*$("#dialog_success").html(res2.msg);
				$("#dialog_success" ).dialog( "open" );
				$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );*/	
				$("#link_new_paging").append(res2.page_link_option);
				
			}else if(res2.success === false){	
				$("#dialog_error").html(res2.msg);
				$( "#dialog_error" ).dialog( "open" );
				$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_error" );
			}	
			
			$('#add_group_and_cat_form')[0].reset();
			$('#save_btn').html('Save changes');

		}
	});
	return false;
}

function del_new_group(page){
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_error" );
	if(jQuery('input:checkbox[class=grouping]:checked').length > 0){
		var total_pages = jQuery('#link_new_paging li:last a').html();	
		var item_per_page = jQuery('input[name=item_per_page]').val();
		var this_page = jQuery('input[name=this_page]').val();		
		var formdata = new FormData($('#manage_groups_and_cat_form')[0]);
		if(page === 'group'){
			formdata.append('form_id','del_group');
			$("#dialog_confirm").html("Are you sure you want to delete selected group(s)?");
		}else if(page === 'category'){
			formdata.append('form_id','del_category');
			$("#dialog_confirm").html("You are deleting folder(s) that may contain link(s). These link(s) will also be deleted. Are you sure you want to delete them?");
		}
		formdata.append('total_pages',total_pages);
		formdata.append('item_per_page',item_per_page);
		formdata.append('this_page',this_page);	
		$("#dialog_confirm" ).dialog({
		autoOpen: false, 
		modal: true,
		buttons: {
			"Yes" : function() {
				$.ajax({
				type: "POST",
				url: $('#manage_groups_and_cat_form').attr('action'),
				data: formdata,
				cache: false,
				contentType: false,
				processData: false,
				success: function(res2){
					//alert(res2);
					res2 = JSON.parse(res2);				
					//alert(res2);
					jQuery.each(res2.del_row, function(index, value) {
						jQuery('#all_records tbody #record_'+value).remove();
					});
					//$("#link_new_paging li:last").remove();
					//jQuery('#all_records tbody').html('');
					//jQuery("").insertAfter($( "#all_records tr:first"));
					//jQuery('#all_records tr:first').after.html('');
					/*if(res2.success === true){
						if(page === 'group'){
							jQuery('#all_records tr:gt(1)').remove();
							jQuery(res2.new_row).insertAfter($( "#all_records tr:first"));
						}else if(page === 'category'){
							jQuery('#all_records tr:gt(1)').remove();
							jQuery(res2.new_row).insertAfter($( "#all_records tr:eq(1)"));						
						}	
						$("#link_new_paging li:last").remove();
					}*/
					
					$("#dialog_success").html(res2.msg);
					$( "#dialog_success" ).dialog( "open" );
					$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
				}
			});
			$(this).dialog("close");
				
			},
			"No" : function() {
				$(this).dialog("close");
				
			}
	   },
	   
	   
		});
		$("#dialog_confirm").dialog( "open" );
		$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_confirm" );
		$( ".ui-dialog-title" ).html( "LinkiBag" );	
	
	}else{
		if(page === 'group'){
			$("#dialog_error").html("Please select the groups you would like to delete");
			//alert("please select atleast one group");
		}else if(page === 'category'){
			//alert("please select atleast one category");
			$("#dialog_error").html("Please select the folders you would like to delete");	
		}	
		$( "#dialog_error" ).dialog( "open" );
	}	
	return false;
}

function link_friend_with_group(){
	var formdata = new FormData($('#add_frient_to_group_form')[0]);
	formdata.append('form_id','link_friend_with_group');
	$('#add_grops_btn').html('Loading form');
	$.ajax({
		type: "POST",
		url: $('#add_frient_to_group_form').attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2){
			//alert(res2);

		}
	});
	return false;
}


function edit_url(){
	var formdata = new FormData($('#edit_url_form')[0]);
	$('#send_edit_url').html('sending...');
	$('#send_edit_url').attr('disabled', 'disabled');
	$.ajax({
		type: "POST",
		url: $('#edit_url_form').attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			$('#url-edit-messages-out').html(res2);
			$('#send_edit_url').html('Submit');
			$('#send_edit_url').removeAttr('disabled');
			
		}
	});
	return false;
}
function add_url_comment(){
	var formdata = new FormData($('#add_url_comment_form')[0]);
	$('#send_add_url_comment').html('Comment...');
	$('#send_add_url_comment').attr('disabled', 'disabled');
	$.ajax({
		type: "POST",
		url: $('#add_url_comment_form').attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			$('#url-comment-messages-out').html(res2);
			$('#send_add_url_comment').html('Comment');
			$('#send_add_url_comment').removeAttr('disabled');
			
		}
	});
	return false;
}
function contact_us(){
	if($('#contact_us_form').valid()){
		var formdata = new FormData($('#contact_us_form')[0]);
		$('#send_contact_us').html('Submit..');
		$('#send_contact_us').attr('disabled', 'disabled');
		$.ajax({
			type: "POST",
			url: $('#contact_us_form').attr('action'),
			data: formdata,
			cache: false,
			contentType: false,
			processData: false,
			success: function(res2) {
				document.location.href="#contact_us_form";
				$('#messages-out').html(res2);
				$('#send_contact_us').html('Submit');
				$('#send_contact_us').removeAttr('disabled');
				
			}
		});
	}	
	return false;
}


function ShowHideDiv() {
	document.getElementById('url-body').style.display = "block";
	document.getElementById('url-header').style.display = "none";
	document.getElementById('messages-out').style.display = "none";
}
function ShowHideCancel() {
	document.getElementById('url-body').style.display = "none";
	document.getElementById('url-header').style.display = "block";
	document.getElementById('messages-out').style.display = "none";
}
function ShowHideSubmit() {
	document.getElementById('messages-out').style.display = "block";
}

function add_as_friend(email,form_btn){
	$('#loading_add_as_friend').show();
	$(form_btn).attr('disabled', 'disabled');
	var btn = $(form_btn+' span').text();
	$(form_btn+' span').html('Processing...');	
	$.ajax({
		type: "POST",
		url: "index.php",
		data: {form_id : 'send_friend_request', in_db : 'no', email_ids : email, description : 'I would like to invite you'},
		success: function(res2) {			
			var sucess = res2.indexOf('trueQWERTYYRRR');			
			if(sucess > -1){
				res2 = res2.substring(16);
				$('#view_link_request_id').val(res2);
				$(form_btn).removeAttr('disabled');
				$(form_btn+' span').html(btn);
				$('#loading_add_as_friend').hide();
				$('#add_friend_list_block').hide();
				$('#remove_friend_list_block').show();
			}	
			
			
		}
	});
	return false;
}

function remove_as_friend(email,form_btn){
	$('#loading_remove_as_friend').show();
	$(form_btn).attr('disabled', 'disabled');
	var btn = $(form_btn+' span').text();
	$(form_btn+' span').html('Processing...');	
	var request_id = $('#view_link_request_id').val();
	$.ajax({
		type: "POST",
		url: "index.php",
		data: {form_id : 'remove_friend_request', email_ids : email, request_ids : request_id},
		success: function(res2) {
			if(res2 === 'true'){				
				$('#view_link_request_id').val('0');
				$(form_btn).removeAttr('disabled');
				$(form_btn+' span').html(btn);
				$('#loading_remove_as_friend').hide();
				$('#add_friend_list_block').show();
				$('#remove_friend_list_block').hide();
			}	
			
			
		}
	});
	return false;
}

function send_friend_request(submitform, in_db){
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_error" );
	$('#invite_in_db').hide();
	$('#find_btn').show();
	var formdata = new FormData($(submitform)[0]);
	if(in_db === 'yes'){
		formdata.append('in_db',in_db);
		$('#find_btn').html('Sending...');
		$('#find_btn').attr('disabled', 'disabled');
		$('#invite_in_db').html('Sending...');
		$('#invite_in_db').attr('disabled', 'disabled');
	}else if(in_db === 'no'){
		formdata.append('in_db',in_db);
		$('#send_register').html('Sending...');
		$('#send_register').attr('disabled', 'disabled');
	}
	$.ajax({
		type: "POST",
		url: $(submitform).attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			//alert(res2);
			var sucess = res2.indexOf('trueQWERTYYRRR');
			if(sucess > -1){
				$(submitform)[0].reset();
				//$('#messagesout').html('<div class="alert alert-success">Success! Friend request has been sent to given Email address.</div>');
				/*$("#dialog_success").html('Friend request has been sent to given Email address.');*/
				/*$("#dialog_success").html("Thank you for your invite! We will check our records and will send your invite, if user is not part of LinkiBag yet.");*/
				$("#dialog_success").html("Your invitation sent successfully!");
				$("#dialog_success" ).dialog( "open" );
				$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );		
			}else{				
				if(res2 === 'This is not a LinkiBag user, You can invite it'){
					//$('#messagesout').html('<div class="alert alert-info">Success! This is not a LinkiBag user, You can invite it.</div>');
					$('#invite_in_db').show();
					$('#find_btn').hide();
				}else{
					//$('#messagesout').html(res2);	
					$("#dialog_error").html(res2);
					$("#dialog_error div").removeAttr( "class" );		
					$( "#dialog_error" ).dialog( "open" );
				
				}
				
				var n = res2.indexOf('Please');
				//alert(n)
				if(n > -1){
					$("#dialog_error").html(res2);
					$("#dialog_error div").removeAttr( "class" );		
					$( "#dialog_error" ).dialog( "open" );
				}
				
			}	
			$('#find_btn').removeAttr('disabled');
			$('#find_btn').html('Find');
			$('#invite_in_db').removeAttr('disabled');
			$('#invite_in_db').html('Invite');
			$('#send_register').removeAttr('disabled');
			$('#send_register').html('Invite');
		}
	});
	return false;
}

function action_on_friend_request(uid){
	var formdata = new FormData($('#act_on_friend_request_'+uid)[0]);
	$.ajax({
		type: "POST",
		url: $('#act_on_friend_request_'+uid).attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			res2 = JSON.parse(res2);
			alert('Your friend request has been accepted');
			$('#wait_request_badge').html(res2.total_waiting);
			$('#friend_badge').html(res2.total_friend);
			$('#act_on_friend_request_'+uid).remove();
			$('#wait_block_'+uid).appendTo('#contacts ul.tvc-lists')
		}
	});
	return false;
}

function decline_friend_request(uid){
	var formdata = $('#act_on_friend_request_'+uid).serialize()+"&decline=yes";
	$.ajax({
		type: "POST",
		url: $('#act_on_friend_request_'+uid).attr('action'),
		data: formdata,
		success: function(res2) {
			
			res2 = JSON.parse(res2);
			alert('You declined the friend request');
			$('#wait_request_badge').html(res2.total_waiting);
			$('#friend_badge').html(res2.total_friend);
			$('#wait_block_'+uid).remove();
		}
	});
	return false;
}

function cancel_friend_request(id){
	$.ajax({
		type: "POST",
		url: 'index.php?p=friend',
		data: { form_id : "cancel_friend_request", id : id},
		success: function(res2) { 
			res2 = JSON.parse(res2);
			$('#pending_request_badge').html(res2.total_pending);
			$('#request_block_'+id).remove();
		}
	});
	return false;
}

function share_links(val){
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_error" );
	var formdata = new FormData($('#share_form_'+val)[0]);
	$('#send_share_link').html('Sharing...');
	$('#send_share_link').attr('disabled', 'disabled');
	$.ajax({
		type: "POST",
		url: $('#share_form_'+val).attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			//alert(res2);
			res2 = JSON.parse(res2);
			if(res2.success === true){
				$(".urls_shared").removeAttr( "checked" );	
				$('#share-link-form').modal('toggle');	
				$("#dialog_success").html(res2.msg);
				$("#dialog_success" ).dialog( "open" );
				$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );	
			}else if(res2.success === false){
				$('#url-shared-messages-out_'+val).html(res2.msg);
			}
			$('#send_share_link_'+val).html('Share with friend');
			$('#send_share_link_'+val).removeAttr('disabled', 'disabled');	
			/*if(res2.msg){
				$('#url-shared-messages-out_'+val).html(res2.msg);
				$('#send_share_link').html('Share with friend');
				$('#send_share_link').removeAttr('disabled', 'disabled');
			}else{
				$('#share-link-form').modal('hide');
				alert('Link successfully shared with selected friends');
			}*/
		}
	});
	return false;
}

function print_pdf_urls(){
	var WEB_ROOT = $("#WEB_ROOT").val();
	var htmls = $('#print_link').html();
	$('#print_link').html('Saving...');
	$('#print_link').attr('disabled', 'disabled');
	$.ajax({
		type: "POST",
		url: "index.php",
		data: {form_id : 'share_links', mark_as_print : '1'},
		success: function(res2) {
			var pdf_urls = WEB_ROOT+'/links_print/index.php?';
			res2 = pdf_urls+res2
			window.open(res2,'_blank');
			//$('#print_msg').html(res2);
			$('#print_link').html(htmls);
			$('#print_link').removeAttr('disabled', 'disabled');	
			
		}
	});
	return false;
}

function share_links_new(val){
	
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_error" );
	
	var formdata = new FormData($('#share_form_'+val)[0]);
	$('#send_share_link').html('Sharing...');
	$('#send_share_link').attr('disabled', 'disabled');
	$.ajax({
		type: "POST",
		url: $('#share_form_'+val).attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			//alert(res2);
			//console.log(res2);
			res2 = JSON.parse(res2);
			$('#url-shared-messages-out_'+val).html('');
			if(res2.success === true){
				$(".urls_shared").removeAttr( "checked" );
				$("#dialog_success").html(res2.msg);
				$("#dialog_success" ).dialog( "open" );
				$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
				$(".ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-front.ui-dialog-buttons.ui-draggable.ui-resizable").addClass( "sharing-links-success-panel-widget-new" );				
				$(".ui-dialog-buttonpane.ui-widget-content.ui-helper-clearfix").remove();
				if(res2.group_options_update){
					$("#friend_group").html(res2.group_options_update);
				}
				$("#shared_urls_serialize").val(res2.shared_urls_serialize);
				$("#table_serialize_for_print").html(res2.table_serialize_for_print);				
				//window.location.href = "index.php?p=dashboard";
			}else if(res2.success === false){
				 //$('#url-shared-messages-out_'+val).html(res2.msg);
					$("#dialog_error").html(res2.msg);
					$("#dialog_error div").removeAttr( "class" );		
					$( "#dialog_error" ).dialog( "open" );
					
			}
			$('#send_share_link_'+val).html('Share');
			$('#send_share_link_'+val).removeAttr('disabled', 'disabled');	
			
		}
	});
	return false;
}

function mark_as_unread(uid){
	var formdata = new FormData($('#act_on_friend_request_')[0]);
	$.ajax({
		type: "POST",
		url: $('#act_on_friend_request_'+uid).attr('action'),
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res2) {
			res2 = JSON.parse(res2);
			alert('Your friend request has been accepted');
			$('#wait_request_badge').html(res2.total_waiting);
			$('#friend_badge').html(res2.total_friend);
			$('#act_on_friend_request_'+uid).remove();
			$('#wait_block_'+uid).appendTo('#contacts ul.tvc-lists')
		}
	});
	return false;
}

function show_states(val){
	if(val == 1){
		$('#state_block').show();	
	}else{
		$('#state_block').hide();	
	}	
		
}	

function show_block(show_div, hide_div){
	$(show_div).show();
	$(hide_div).hide();	
	
}

function get_friends_of_groups(val){
	//$("#add_user_to_share option:selected").removeAttr("selected");
	if($('input[name="save_as_group"]').prop('checked') == true){
		$('input[name="save_as_group"]').removeAttr('checked');
	}
	if($('input[name="update_as_group"]').prop('checked') == true){
		$('input[name="update_as_group"]').removeAttr('checked');
	}	
	if(val > '0'){
		$('#save_as_existing_gp_block').show();
		$('#save_as_new_gp_block').hide();
		var gpname = $('#friend_group option[value="'+val+'"]').text();
		$('#existing_grp_name').val(gpname);
		$('#multiple_user_gid').val(val);
	}else{
		$('#save_as_new_gp_block').show();
		$('#save_as_existing_gp_block').hide();
		$('#multiple_user_gid').val(0);
	}


	$.ajax({
		type: "POST",
		url: 'ajax/get_friends_of_groups.php',
		data: { group: val, 'ajax': 1},
		success: function(res2) {
			//alert(res2);
			//console.log(res2);
			res2 = JSON.parse(res2);
			$("#add_user_to_share option:selected").removeAttr("selected");
			$.each( res2.select_val, function( key, value ) {
				$('#add_user_to_share option[value="'+value+'"]').attr('selected', 'selected');
			});
			
			$("#add_user_to_share").trigger("chosen:updated");
			
		}
	});
	
}

function add_new_group_with_friends(){
	if($('input[name="save_as_group"]').prop('checked') == true){
		$(".save_as_group_bloc").show();
		$('input[name="group_name"]').attr('required', 'required'); 
		$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
		//$("#dialog_success").html('After share Links ALL list of email addresses entered above Share with text box are atttched to new group which is definde by you in below text box.');
		//$( "#dialog_success" ).dialog( "open" );
		//$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").addClass( "dialog_success" );
	}else{
		$(".save_as_group_bloc").hide();
		$('input[name="group_name"]').removeAttr('required'); 
	}	
}

function update_existing_group_with_friends(){
	if($('input[name="update_as_group"]').prop('checked') == true){
		$("#update_as_group_block").show();
		$('input[name="group_name_updated"]').attr('required', 'required'); 
		$(".ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix").removeClass( "dialog_success" );
	}else{
		$("#update_as_group_block").hide();
		$('input[name="group_name_updated"]').removeAttr('required'); 
	}	
}	




