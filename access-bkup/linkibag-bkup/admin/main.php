<?php
include('../config/web-config.php');
include('../config/DB.class.php');
include('classes/common.class.php');
include('submit.php');
$co = new commonClass();
$co->__construct();

if(!$co->is_adminlogin()){ header("location:index.php"); }

include('header.php');

if(isset($_GET['p'])){
	$page = $_GET['p'].'.php';
	if(!file_exists($page)){
		$page="notfound.php";
	}
}else{
	$page = 'dashboard.php';
}

$this_page = '';
if(isset($_GET)){	
	$val_pos = 0;
	foreach($_GET as $k=>$v){
		if($val_pos>0)
			$this_page .= '&';
		if($k=='page')
			continue;
		if(is_array($v)){
			$e_no = 0;
			foreach($v as $a){
				if($e_no > 0)
					$this_page .= '&';
				$this_page .= $k.'[]='.$a;
				$e_no++;
			}
		}else{
			$this_page .= $k.'='.$v;
		}
		$val_pos++;
	}
}

ob_start();
include($page);
$content = ob_get_contents();
ob_end_clean();
$msg = $co->theme_messages();
if(isset($breadcrumb)){
?>
<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"><?=WSNAME?></h1>
				<ol class="breadcrumb">
					<li>
						<i class="fa fa-dashboard"></i>  <a href="index.php?p=dashboard">Dashboard</a>
					</li>
					<li class="active">
						<i class="fa fa-table"></i> <?php echo $breadcrumb; ?> 
					</li>
				</ol>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $title; ?></h3>
					</div>				
					<div class="panel-body">
						<?php if(isset($msg)){ echo $msg; } ?>
						<?php echo $content; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	
<?php
}else{
	if(isset($msg)){ echo $msg; }
	include($page);	
}
include('footer.php');
?>