<?php
include('config/web-config.php');
include('config/DB.class.php');
include('classes/common.class.php');
include('classes/user.class.php');
$co = new userClass();
$co->__construct();

if(!$co->is_userlogin()){
	header("location:index.php");
}else{
	$current = $co->getcurrentuser_profile();
}
//print_r ($current);
if (empty($_GET['action'])) $_GET['action'] = 'process';  

require_once('paypal.class.php');  // include the class file
$pay_object = new paypal_class();             // initiate an instance of the class
$pay_object->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
//$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url            
// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
// if there is not action variable, set the default action of 'process'

switch ($_GET['action']) {
    
	case 'cancel':       // Order was canceled...	
		echo '<script language="javascript">window.location="index.php";</script>';		
		break;      

	case 'ipn':          // Paypal is calling page for IPN validation...
		if ($pay_object->validate_ipn()) {
  
			$subject = 'Instant Payment Notification - Recieved Payment immigration';
			$to = 'dalvir4u@gmail.com';    //  your email
			$body =  "An instant payment notification was successfully recieved\n";
			$body .= "from ".$pay_object->ipn_data['payer_email']." on ".date('m/d/Y');
			$body .= " at ".date('g:i A')."\n\nDetails:\n";         
			foreach ($p1->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
			mail($to, $subject, $body);
		}
		break;
	
	case 'success':      // Order was successful...
		//echo 'invoice : '.$_POST['invoice'];
		$payment = $co->query_first("SELECT * FROM `user_subscriptions` WHERE subs_uid=:uid ORDER BY subs_id DESC", array('uid'=>$current['uid']));
		if(isset($payment['subs_id']) and $payment['subs_id'] > 0){
			$new_val = array();
			$new_val['uid'] = $current['uid'];
			$new_val['payment_by'] = $current['uid'];
			$new_val['payment_type'] = 'subscription';
			//$new_val['trans_id'] = '';
			//$new_val['gateway_return'] = '';
			//$new_val['created'] = time();	
			$new_val['total_pay'] = $payment['subs_amt'];
			$new_val['status'] = 1;
			$pay_id = $co->query_insert('user_payments', $new_val);
			unset($new_val);
			$co->query_update('user_subscriptions', array('subs_payment_id'=>$pay_id), array('id'=>$payment['subs_id']), 'subs_id=:id');
			unset($_SESSION['coupon_code']);
			unset($_SESSION['coupon_discount']);
		}	
		/*
		$payment = $co->query_first("SELECT * FROM `payments` WHERE payment_id=:invoice", array('invoice'=>$_POST['invoice']));
		if(isset($payment['payment_id']) and $payment['payment_id']==$_POST['invoice']){
			$pay_items = $co->fetch_all_array("SELECT * FROM `payment_item` WHERE payment_id=:invoice", array('invoice'=>$payment['payment_id']));
			foreach($pay_items as $pay_item){
				$up_val = array();			
				$up_val['pay_id'] = $payment['payment_id'];
				$co->query_update('form_submitted', $up_val, array('id'=>$pay_item['item_name']), 'form_id=:id');
				unset($up_val);			
			}
			
			$co->setmessage("status", "You successfully transferred funds.");
			echo '<script language="javascript">window.location="index.php?p=account";</script>';
			unset($new_val);
		}*/
		
		$co->setmessage("status", "You successfully transferred funds.");		
		echo '<script language="javascript">window.location="index.php?p=renew";</script>';
	break;

}

?>