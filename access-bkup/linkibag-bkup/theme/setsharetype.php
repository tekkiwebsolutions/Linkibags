<?php
function page_content(){
	$a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
$a2=array("e"=>"red","z"=>"pink","f"=>"green","g"=>"blue");

$result=array_diff($a2,$a1);
print_r($result);
	/*
	global $co, $msg;

	$co->page_title = "About us | LinkiBag";
	$rows = $co->fetch_all_array("SELECT shared_url_id,url_id FROM user_shared_urls", array());
	$i=0;
	foreach($rows as $row){
		$i++;
		$url = $co->query_first("SELECT * FROM user_urls where url_id=:id", array('id'=>$row['url_id']));
		$new_val = array();
		$new_val['share_type_change'] = $url['share_type'];
		$new_val['public_cat_change'] = $url['public_cat'];
		if($url['share_type'] == 3 or $url['public_cat'] > 8){
			$new_val['add_to_search_page_change'] = 1;
			$new_val['search_page_status_change'] = 0;
		}
		
		$co->query_update('user_shared_urls', $new_val, array('id'=>$row['shared_url_id']), 'shared_url_id=:id');
		unset($new_val);
	}
	echo ' total records - '.$i;
	*/
}

?>	