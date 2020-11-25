<?php
if(isset($_POST['del_yes']) && $_POST['del_yes']=="yes"){
	if(isset($_GET['delid'])){
		$co->query_delete('user_urls', array('id'=>$_GET['delid']),'uid=:id');
		$co->query_delete('users', array('id'=>$_GET['delid']),'uid=:id');
		$co->query_delete('profile', array('id'=>$_GET['delid']),'profile_id=:id');
		$co->setmessage("error", "User has been successfully deleted");
		echo '<script type="text/javascript">window.location.href="main.php?p=user_management/manage"</script>';
		exit();
	}
}elseif(isset($_POST['del_no']) && $_POST['del_no']=="no"){
	echo '<script type="text/javascript">window.location.href="main.php?p=user_management/manage"</script>';
}
$msg = $co->theme_messages();

if(isset($msg)){ echo $msg; }


if(isset($_GET['delid'])){	

	$row = $co->query_first("SELECT u.*, p.* from profile p, users u WHERE u.uid=p.uid and u.uid=:id",array('id'=>$_GET['delid']));
	if(isset($row['uid'])){
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
								<h3> Are you sure you want to delete user <?=$row['first_name']?> with ID - <?=$row['uid']?> ?</h3>
								<ul>
									<li>It will delete user profile.</li>
									<li>It will delete all URLs shared by this user.</li>
									<li>It will delete all groups for user friendship created by this user.</li>
								</ul>
							</div>
							
							<div class="panel-body">
								<form method="post" enctype="multipart/form-data" class="form-horizontal">

									<input type="hidden" name="id" value="<?=$row['uid']?>" />
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