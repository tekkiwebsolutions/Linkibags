

        
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script> 
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <script type= "text/javascript" src = "js/countries3.js"></script>
    <script type="text/javascript" src="data-tables/DT_bootstrap.js"></script>
    <script  type="text/javascript" src="js/jquery.multiFieldExtender.js" type="text/javascript"></script>
	<script  type="text/javascript" src="js/jquery.plugin.js"></script>
	<script   type="text/javascript" src="js/jquery.datepick.js"></script>
	<script src="js/jquery-ui.js"></script>
	
    <script type="text/javascript">
    $(document).ready(function() {			

			// initiate layout and plugins

$(".multifield").EnableMultiField();

// Sortable rows
$(".sorted_table").sortable({ opacity: 0.6, cursor: 'move', update: function() {
	var order = $(this).sortable("serialize") + '&action=updateRecordsListings';
	$.post("sort_this_category.php", order, function(theResponse){		
		alert('Positions Saved');
	});
}
});		
	</script>
	<script>
	$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

function showDate(date) {
	alert('The date chosen is ' + date);
}

function show_states(val){
	if(val == 230){
		$('#state_block').show();	
	}else{
		$('#state_block').hide();	
	}	
		
}
function show_time_period(val){
	if(val == 2 || val == 3){
		$('#time_block').show();	
	}else{
		$('#time_block').hide();	
	}	
		
}

function return_edit_img_div(i){
	var div_html = '<li id="photo-upload-edit-'+i+'" class="col-sm-3 text-center upload_photo_block_edit"><div class="photos_ad_preview" id="img_edit_preview_'+i+'" style="display:none"><span><i class="fa fa-remove" id="remove_img_e_'+i+'" onclick="remove_img_onfly_edit('+i+')"></i></span><img src="" id="up_img_edit_'+i+'" style="width: 100%; height: 100%" /></div><div class="img_text_link photos_Ad" id="img_edit_link_'+i+'" onclick="edit_ad_photo('+i+')"><span class="main_photo"><a href="#"><i class="fa fa-plus"></i></a></span></div><input type="file" name="ads_img[]" class="upload_field_edit" id="upload_edit_field_'+i+'" style="display:none" /></li>';
	return div_html;
}
function remove_img_onfly_edit(hit_id){
	var img_no = hit_id;
	
	if($("li.upload_photo_block_edit").length == 8){
		var last_li_id = $("#upload_img_edit_div li:eq(7)").attr('id');
		if(last_li_id.length > 19){
			var li_no = last_li_id.substr(18, 2);
		}else{
			var li_no = last_li_id.substr(18, 1);
		}
		var img_src = $('#up_img_'+li_no).attr('src');
		
		if(img_src!=''){
			li_no = parseInt(li_no) + parseInt(1);		
			var div8_html = return_upload_img_div(li_no);			
			$('#upload_img_edit_div').append(div8_html);
		}
		$('#photo-upload-edit-'+img_no).remove();
	}else if($("li.upload_photo_block_edit").length == 1){
		var div1_html = return_upload_img_div(1);
		$('#photo-upload-edit-'+img_no).remove();
		$('#upload_img_edit_div').append(div1_html);
	}else{
		$('#photo-upload-edit-'+img_no).remove();
	}
}
function edit_ad_photo(hit_id){
	var img_no = hit_id;
	
	$("#upload_edit_field_"+img_no).trigger('click');
	
	$(".upload_field_edit").change(function(){
		var div_id = this.id;
		if(div_id.length > 19){
			var img_no = div_id.substr(18, 2);
		}else{
			var img_no = div_id.substr(18, 1);
		}
		
		readURL_edit(this, img_no);
		var new_img_no = parseInt(img_no)+parseInt(1);
		if($("li.upload_photo_block_edit").length < 8){
			var $myDiv = $('#photo-upload-edit-'+new_img_no);
			if ( !$myDiv.length){
				var div_html = return_edit_img_div(new_img_no);
				$('#upload_img_edit_div').append(div_html);   
			}
		}
	});
	
}	
$(function() {
	$( ".date_picker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "-100:+0",
	});
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
	
	
	$(".onlystringnumber").keydown(function (e) {
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
		var inp = String.fromCharCode(e.keyCode);
		if (/[a-zA-Z0-9-_ ]/.test(inp) != false)
			e.preventDefault();
	});
	
	
});


	</script>

</body>

</html>
