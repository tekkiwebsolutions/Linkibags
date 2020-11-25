/*
	*	Original script by: Shafiul Azam
	*	ishafiul@gmail.com
	*	Version 3.0
	*	Modified by: Luigi Balzano

	*	Description:
	*	Inserts Countries and/or States as Dropdown List
	*	How to Use:

		In Head section:
		<script type= "text/javascript" src = "countries.js"></script>
		In Body Section:
		Select Types:   <select onchange="print_state('sub_type',this.selectedIndex);" id="types" name ="types"></select>
		<br />
		City/District/State: <select name ="sub_type" id ="sub_type"></select>
		<script language="javascript">print_types("types");</script>	

	*
	*	License: OpenSource, Permission for modificatin Granted, KEEP AUTHOR INFORMATION INTACT
	*	Aurthor's Website: http://shafiul.progmaatic.com
	*
*/
var country_arr = new Array("Residential","Residential Income","Farm and Ranch","Lots and Land","Commercial / Ind.","Business Opportunity","Commercial Lease","Residential Lease");

var s_a = new Array();
s_a[0]="";
s_a[1]="Single Family|Mobile Home|Condo-PUD|HUD|Manufactured Home";
s_a[2]="2 homes on 1 Lot|Duplex|3 Units|4 Units|5 - 10 Units|11 Plus|Other";
s_a[3]="Row Crop|Permanent Crop|Field Crop|Nursery|Nursery|Sheep|Poultry|General Agriculture|Other";
s_a[4]="Lot|Acreage|Agricultural|";
s_a[5]="Commercial|	Industrial";
s_a[6]="";
s_a[7]="Office|	Wholesale|Retail|Manufacturing";
s_a[8]="Single Family|Mobile Home|Condo-PUD|Apartment|Manufactured Home|Room";



function print_types(types_id){

	// given the id of the <select> tag as function argument, it inserts <option> tags
	/*var option_str = document.getElementById(country_id);
	option_str.length=0;
	option_str.options[0] = new Option('Select','');
	option_str.selectedIndex = 0;
	for (var i=0; i<country_arr.length; i++) {
		option_str.options[option_str.length] = new Option(country_arr[i],country_arr[i]);
	}
*/
}

function print_state(state_id, state_index){
	var option_str = document.getElementById(state_id);
	option_str.length=0;	// Fixed by Julian Woods
	option_str.options[0] = new Option('Select','');
	option_str.selectedIndex = 0;
	var state_arr = s_a[state_index].split("|");
	for (var i=0; i<state_arr.length; i++) {
		option_str.options[option_str.length] = new Option(state_arr[i],state_arr[i]);
	}
}
