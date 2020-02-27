<?php

if(isset($_POST['form_id']) and $_POST['form_id']=="share_linkibook"){
	$success = true;
	$errors = '';
	if(isset($_POST['book'])) {
		if(count($_POST['book'])==0){
			$success = false;
			$errors .= "<li>Please share atleast one LinkiBook</li>";
		}
	}else{
		$success = false;
		$errors .= "<li>Please share atleast one LinkiBook</li>";
	}

	if(!empty($_POST['friend_group'])){
		if(isset($_POST['update_as_group'])){
			if(empty($_POST['group_name_updated'])){
				$success = false;
				$errors .= "<li>Please enter new group name</li>";
			}
		}
	}else{
		if(isset($_POST['save_as_group'])){
			if(empty($_POST['group_name'])){
				$success = false;
				$errors .= "<li>Please enter new group name</li>";
			}
		}
	}


	if(!isset($_POST['shared_user'])){
		$success = false;
		$errors .= "<li>Please select one or more friend to share linkibook!</li>";
	}else{
		$emails_ids = $_POST['shared_user'];
		$current = $co->getcurrentuser_profile();
		foreach($emails_ids as $email_ids){
			$chk_already_your_friend = array();
			$result = array('uid'=>0);
			$email_ids = trim($email_ids);
			$email_ids = strip_tags($email_ids);

			if(filter_var($email_ids, FILTER_VALIDATE_EMAIL) === false){
				$errors .= "<li>Please use user@gmail.com format to send your request</li>";
				$success=false;
				continue;
			}
			$result = $co->query_first("SELECT uid,remove_profile FROM `users` WHERE email_id=:id",array('id'=>$email_ids));
			if(isset($result['uid']) and $result['uid'] == $current['uid']){
				$errors .= "<li>You can not send friend request yourself</li>";
				$success=false;	
				continue;							
			}

			if(isset($result['uid']) and $result['remove_profile']!=0){
				$errors .= "<li>You can not send friend request to $email_ids.</li>";
				$success=false;
				continue;	
			}

			if($result['uid'] > 0){
				$chk_already_your_friend = $co->query_first("SELECT friend_id FROM `user_friends` WHERE uid=:id and fid=:fid and status=1",array('id'=>$current['uid'],'fid'=>$result['uid']));		
			}

			if(!(isset($chk_already_your_friend['friend_id']) and $chk_already_your_friend['friend_id'] > 0)){
				$already_send_request = $co->query_first("SELECT COUNT(request_id) as total FROM `friends_request` WHERE request_by=:uid and request_to=0 and status=0 and request_email=:uid2",array('uid'=>$current['uid'],'uid2'=>$email_ids)); 
				if(isset($already_send_request['total']) and $already_send_request['total'] == 5){
					$errors .= "<li>You can share maximum of 5 links with users who are not on your LinkiBag friends list. Connect with your friends today to continue sharing your links.<br /><br />We will not be able to share your link(s) with<br /><span class=\"text-danger\">".$email_ids."</span></li>";
					$success=false;
					continue;	
				}
			}
		}
	}

	if($success == true){
		
		$tim = time();
		$new = array('share_number'=>$_SESSION["share_number"], 'shared_by'=>$current['uid'], 'shared_to'=>serialize($emails_ids), 'book_id'=>serialize($_POST['book']), 'created'=>$tim);
		$share_id = $co->query_insert("linkibook_shared", $new);
		foreach($emails_ids as $email_ids){
			$co->share_linkibook('email', $current, $email_ids, $_POST['book'], $share_id, $_SESSION["share_number"]);
		}
		$table_serialize_for_print = '';
		echo json_encode(array('msg'=>'LinkiBook(s) shared successfully','success'=>$success,'table_serialize_for_print'=>$table_serialize_for_print));
			exit();
	}else{
		$msg ='<div class="alert alert-danger"><ul>'.$errors.'</ul></div>';
		echo json_encode(array('msg'=>$msg,'success'=>$success,'group_options_update'=>''));
		exit();
	}
	
}