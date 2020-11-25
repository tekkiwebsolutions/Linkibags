

        
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script> 
    <script src="js/bootstrap.min.js"></script>
	<script src="../theme/js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <script type= "text/javascript" src = "js/countries3.js"></script>
    <script type="text/javascript" src="data-tables/DT_bootstrap.js"></script>
    <script  type="text/javascript" src="js/jquery.multiFieldExtender.js"></script>
	<script  type="text/javascript" src="js/jquery.plugin.js"></script>
	<script   type="text/javascript" src="js/jquery.datepick.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/dataTables.min.js"></script>	
	
	<script type="text/javascript" language="javascript" src="js/dataTables.buttons.min.js"></script>   
	<script type="text/javascript" language="javascript" src="js/buttons.html5.min.js"></script> 
	<style>
		table.dataTable tbody th:last-child, table.dataTable tbody td:last-child {
		width:15% !important;
		} 
	</style>
    <script type="text/javascript">
	$(document).ready(function() {
		$(".multifield").EnableMultiField();
		$(".sorted_table").sortable({ 
			opacity: 0.6, cursor: 'move', update: function() {
				var order = $(this).sortable("serialize") + '&action=updateRecordsListings';
				$.post("sort_this_category.php", order, function(theResponse){		
					alert('Positions Saved');
				});
			}
		});	

		//$('.datatable').DataTable(); 	
				
		var usertable = $('#manage_users').DataTable({
			"columns": [
				{"data": "uid"},
				{"data": "first_name"},
				{"data": "last_name"},
				{"data": "email_id"},
				{"data": "state_name"},
				{"data": "zip_code"},
				{"data": "role"},
				{"data": "status"},
				{"data": "verified"},
				{"data": "created"},
				{"data": "last_login_time"},
				{"data": "subscribe"},
				{"data": "edit"}				
			],			
			"processing": true,
			"serverSide": true,
			"ajax": {
				url: '../ajax/users_list.php',
				type: 'POST',
			},
			stateSave: true,
			dom: 'fBrtlip', 
			buttons: [  {
				extend : 'csv',
				text: 'Export Table Data To Excel File',
				exportOptions : {
					order : 'current',  
					page : 'all',  
					columns: [ 1, 2, 3,4,5,6,7,8,9 ]
				} ,
			} ]
		});  
	});	 
	
	

	function show_del_users(){
		var link = '';
		$( "input:checkbox[class=del_users]:checked" ).each(function() {
			var val = $(this).val();
			//$(this).parents('tr').find('.del_links').attr('href','main.php?p=user_management/delete_info&delid[]='+val);
			$(this).parents('tr').find('.del_links').attr('class','btn btn-xs btn-danger del_links checked_del');
			link += '&delid[]='+val;
			$('.checked_del').attr('href','main.php?p=user_management/delete_info'+link);
		});

	}	
	
	$("#checkAll").change(function () {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
		show_del_users();
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
	var d = new Date();
	$( ".date_picker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "-0:+5",
		defaultDate: d,
		minDate: d,
		maxDate: '+1826D',
		onClose: function () {
            var dt1 = $('#dt1').datepicker('getDate');
            var dt2 = $('#dt2').datepicker('getDate');
            //check to prevent a user from entering a date below date of dt1
			if(dt1 != null && dt2 != null){
				if (dt2 < dt1) {					
					$('#dt2').datepicker('setDate', '');
					alert('End date must be greater than or equal to start date.');
					//var minDate = $('#dt2').datepicker('option', 'minDate');
					//$('#dt2').datepicker('setDate', minDate);
					
				}
			}	
        }
	});
	var d = new Date();
	$( ".default_date_picker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		defaultDate: d,
		
		
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

function remove_img(id){
			var x = confirm("Are you sure you want to remove this image?");
			if(x==true){
				$('#imgrow_'+id).remove();
				$('#deleted_images_list').append('<input type="hidden" name="del_img[]" value="'+id+'" />');
			}
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
		
		
	</script>
	<script>
		var select5, chosen5;

		// cache the select element as we'll be using it a few times
		select5 = $("#add_urls");

		// init the chosen plugin
		select5.chosen({max_selected_options: 5, no_results_text: 'Press choose category:' });
		
		// get the chosen object
		chosen5 = $('#add_urls_chosen');
		
		// Bind the keyup event to the search box input
		chosen5.find('input').on('keyup', function(e)
		{
			// if we hit Enter and the results list is empty (no matches) add the option
			if (e.which == 13 && chosen5.find('li.no-results').length > 0)
			{
				var option = $("<option>").val(this.value).text(this.value);
				if($("#add_urls :selected").length < 0 ){
					// add the new option
					select5.append(option);
					// automatically select it
					select5.find(option).prop('selected', true);
					// trigger the update
					select5.trigger("chosen:updated");
				}
			}
		});
		$("#add_urls").bind("chosen:maxselected", function () {  });
	</script>

</body>

</html>
