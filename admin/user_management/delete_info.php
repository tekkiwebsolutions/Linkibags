<?php
if(isset($_POST['del_yes']) && $_POST['del_yes']=="yes"){
	if(isset($_POST['delid']) and count($_POST['delid']) > 0){
		foreach($_POST['delid'] as $del_id){
			$co->query_delete('user_urls', array('id'=>$del_id),'uid=:id');
			$co->query_delete('users', array('id'=>$del_id),'uid=:id');
			$co->query_delete('profile', array('id'=>$del_id),'profile_id=:id');
			$co->setmessage("error", "User has been successfully deleted");
		}	
		echo '<script type="text/javascript">window.location.href="main.php?p=user_management/manage"</script>';
		exit();
	}
}elseif(isset($_POST['del_no']) && $_POST['del_no']=="no"){
	echo '<script type="text/javascript">window.location.href="main.php?p=user_management/manage"</script>';
}
$msg = $co->theme_messages();

if(isset($msg)){ echo $msg; }


if(isset($_GET['delid']) and count($_GET['delid']) > 0){
	$del_data = array();
	$user_name = array();	
	foreach($_GET['delid'] as $list){
		$row = $co->query_first("SELECT u.uid, p.first_name from profile p, users u WHERE u.uid=p.uid and u.uid=:id",array('id'=>$list));
		$del_data[] = $row;
		$user_name[] = $row['first_name'].'(ID='.$row['uid'].')';
	}
	if(isset($del_data)){
?>
	<div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?=WSNAME?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php?p=dashboard">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Users info
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<div class="row">
                    <div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-table"></i> Delete User</h3>
							</div>
							<div class="panel-body">
								<h3 style="word-wrap: break-word;"> Are you sure you want to delete users <?=implode(',',$user_name)?>  ?</h3>
								<ul>
									<li>It will delete user profile.</li>
									<li>It will delete all URLs shared by this user.</li>
									<li>It will delete all groups for user friendship created by this user.</li>
								</ul>
							</div>
							
							<div class="panel-body">
								<form method="post" enctype="multipart/form-data" class="form-horizontal">
									<?php
									foreach($del_data as $list){
										echo '<input type="hidden" name="delid[]" value="'.$list['uid'].'" />';
									}
									?>									
									<div class="form-group">
										<div class="col-sm-12"><span style="border: 1px solid #ccc; padding: 2px 10px;"><strong>Action can not be undo</strong></span></div>
									</div>
									<div class="form-group">
										<div class="col-sm-4">
											<button type="submit"  name="del_yes" value="yes" class="btn btn-success">Yes</button>&nbsp;&nbsp;&nbsp;
											<button type="submit"  name="del_no" value="no" class="btn btn-primary">No</button>
										</div>
										
									</div>									
								
								</form>
							</div>
						</div>
					</div>
				</div>					<!-- /.row -->
			</div>
	<!-- /.container-fluid -->
			
	<?php
	}else{
		exit();
	}
}
	?>

	</div>