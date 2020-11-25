<?php
include('config/web-config.php');
include('config/DB.class.php');
include('classes/common.class.php');
include('classes/user.class.php');
$co = new userClass();
$co->__construct();

$page = $co->query_first("SELECT * FROM pages WHERE page_id=:id ", array('id'=>$_GET['id']));
$img = $co->query_first("SELECT * FROM page_imgs WHERE entity_id=:id ORDER BY RAND()", array('id'=>$_GET['id']));

?>			

<!DOCTYPE html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
		<title><?=$page['title']?> | LinkiBag</title>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="">
		<meta name="description" content="">

		<link type="image/x-icon" href="images/favicon.png" rel="shortcut icon">

		<!-- animate css -->
		<link rel="stylesheet" href="https://www.linkibag.com/theme/css/animate-stop.min.css">
		<!-- bootstrap css -->
		<link rel="stylesheet" href="https://www.linkibag.com/theme/css/bootstrap.min.css">
		<!-- font-awesome -->
		<link rel="stylesheet" href="https://www.linkibag.com/theme/css/font-awesome.min.css">
		<!-- dialogues-->

		<!-- google font -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700,800' rel='stylesheet' type='text/css'><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

		<!-- custom css -->
		<link rel="stylesheet" href="https://www.linkibag.com/theme/css/linkibag.css">
		<link rel="stylesheet" href="https://www.linkibag.com/theme/css/mobile.css">
		<link rel="stylesheet" href="https://www.linkibag.com/theme/css/chosen.css" />


		<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2'></script>
	</head>
	<body>
		<section id="public-bag">
					<div class="container bread-crumb top-line about-top" style="margin: auto;">

						<div class="col-md-7">

							
							<h4 class="text-orange"><?=$page['title']?></h4>

						</div>

						<div class="col-md-4">

							<span class="other-acc-type"></span>

						</div>

					</div>

					<div class="container main-container" style="margin-top: 0px;">

						<div class="row">

							<div class="col-md-12 about-block page-new" data-wow-delay="0.3s">
								<div class="terms-page">
								<?=$page['page_body']?>
								</div>
	   
							</div>

						</div>

					</div>
			<div class="blue-border"></div>
		</section>
<style type="text/css">
	#public-bag .text-orange {
    	color: #ff7f27;
	}

</style>

	</body>
</html>


	

	