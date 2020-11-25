<?php
include('../config/web-config.php');
include('../config/DB.class.php');
include('../classes/common.class.php');
include('../classes/user.class.php');
$co = new userClass();
$co->__construct();

if (!empty($_POST) ) {
	$table_column_name = array('u.uid', 'p.first_name', 'p.last_name', 'u.email_id', 'u.role', 'u.status', 'u.verified', 'u.created', 'u.last_login_time', 'u.uid');
    /* Useful $_POST Variables coming from the plugin */
    $draw = $_POST["draw"];//counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTbles
    $orderByColumnIndex  = $_POST['order'][0]['column'];// index of the sorting column (0 index based - i.e. 0 is the first record)
    $orderBy = $table_column_name[$orderByColumnIndex];//Get name of the sorting column from its index
    $orderType = $_POST['order'][0]['dir']; // ASC or DESC
    $start  = $_POST["start"];//Paging first record indicator.
    $length = $_POST['length'];//Number of records that the table can display in the current draw
    /* END of POST variables */
	$sql = "select COUNT(u.uid) as total_rows from users u, profile p where u.uid=p.uid";
	$data = $co->query_first($sql,array());
    
	$recordsTotal = $data['total_rows'];

    /* SEARCH CASE : Filtered data */
    if(!empty($_POST['search']['value'])){

        /* WHERE Clause for searching */
		for($i=0 ; $i<count($_POST['columns']);$i++){
            $column = $table_column_name[$i];//we get the name of each column using its index from POST request
			$where[]="$column like '%".$_POST['search']['value']."%'";
        }
        $where = implode(" OR " , $where);// id like '%searchValue%' or name like '%searchValue%' ....
        /* End WHERE */

       
		$sql = "select COUNT(u.uid) as total_rows from users u, profile p where u.uid=p.uid and (".$where.")";
		$data = $co->query_first($sql,array());
		$recordsFiltered = $data['total_rows'];//Count of search result
		
        /* SQL Query for search with limit and orderBy clauses*/
        $sql = "select * from users u, profile p where u.uid=p.uid and (".$where.") ORDER BY ".$orderBy." ".$orderType." limit ".$start.", ".$length;
        $data = $co->fetch_all_array($sql,array());
		
    }
    /* END SEARCH */
    else {
        $sql = "select u.uid, p.first_name, p.last_name, u.email_id, u.role, u.status, u.verified, u.created, u.last_login_time from users u, profile p where u.uid=p.uid ORDER BY ".$orderBy." ".$orderType." limit ".$start.", ".$length;
		$data = $co->fetch_all_array($sql,array());

        $recordsFiltered = $recordsTotal;
    }
	
	$acc_type = array('','Personal','Business','Education');
	$status = array('Blocked','Active');
    $verified_status = array('No','Yes');
	$data2 = array();
	foreach($data as $row){
		$data2[] = array('uid'=>'<input type="checkbox" class="del_users" onclick="show_del_users();" name="del_users[]" value="'.$row['uid'].'">&nbsp;'.$row['uid'],'first_name'=>$row['first_name'],'last_name'=>$row['last_name'],'email_id'=>$row['email_id'],'role'=>$acc_type[$row['role']],'status'=>$status[$row['status']],'verified'=>$verified_status[$row['verified']],'created'=>date('j F, Y',$row['created']),'last_login_time'=>date('j F, Y',$row['last_login_time']),'edit'=>'<a href="main.php?p=user_management/edit&amp;id='.$row['uid'].'" class="btn btn-xs btn-primary"> <i class="fa fa-fw fa-edit"></i> Edit</a>
													<a class="btn btn-xs btn-danger del_links" href="main.php?p=user_management/delete_info&amp;delid[]='.$row['uid'].'"><i class="fa fa-fw fa-edit"></i> Delete</a>');
		
	}
	$data = $data2;	

    /* Response to client before JSON encoding */
    $response = array(
        "draw" => intval($draw),
        "recordsTotal" => $recordsTotal,
        "recordsFiltered" => $recordsFiltered,
        "data" => $data
    );
	
    echo json_encode($response);
	exit();

} else {
    echo "NO POST Query from DataTable";
}
?>
