<?php
if(isset($_POST['del_yes']) && $_POST['del_yes']=="yes"){
	if(isset($_GET['delid'])){
		$co->query_delete('user_urls', array('id'=>$_GET['delid']),'url_cat=:id');
		$co->query_delete('category', array('id'=>$_GET['delid']),'cid=:id');
		$co->setmessage("error", "Category has been successfully deleted");
		echo '<script type="text/javascript">window.location.href="main.php?p=category_management/manage_user_category"</script>';
		exit();
	}
}elseif(isset($_POST['del_no']) && $_POST['del_no']=="no"){
	echo '<script type="text/javascript">window.location.href="main.php?p=category_management/manage_user_category"</script>';
}
$msg = $co->theme_messages();

if(isset($msg)){ echo $msg; }


if(isset($_GET['delid'])){	

	$row = $co->query_first("SELECT * from category WHERE cid=:id",array('id'=>$_GET['delid']));
	if(isset($row['cid'])){
		$total_shared_cat = $co->query_first("SELECT count(url_cat) as total_cat from user_urls WHERE url_cat=:id",array('id'=>$row['cid']));
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
                                <i class="fa fa-table"></i> Category info
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
								<h3> Are you sure you want to delete category(<?=$row['cname']?>) - ID(<?=$row['cid']?>) ?</h3>
								<ul>
									<li>It will delete (<?=$total_shared_cat['total_cat']?>) URLs shared by this Category.</li>
									
								</ul>
							</div>
							
							<div class="panel-body">
								<form method="post" enctype="multipart/form-data" class="form-horizontal">

									<input type="hidden" name="id" value="<?=$row['cid']?>" />
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