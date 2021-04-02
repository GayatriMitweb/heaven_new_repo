<?php include_once('app_functions.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Online Booking</title>

	<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500" rel="stylesheet">

	<!--========*****Header Stylsheets*****========-->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-labelauty.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo BASE_URL ?>css/menu-style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/btn-style.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo BASE_URL ?>css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>css/vi.alert.css">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>css/select2.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/admin.php">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.datetimepicker.css">
    

	<!--========*****Header Scripts*****========-->
    <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.mCustomScrollbar.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery-labelauty.js"></script>
    <script src="<?php echo BASE_URL ?>js/vi.alert.js"></script>
    <script src="<?php echo BASE_URL ?>js/select2.min.js"></script> 
    <script src="<?php echo BASE_URL ?>js/app/validation.js"></script> 
    <script src="<?php echo BASE_URL ?>js/app/data_reflect.js"></script>   
    <script src="<?php echo BASE_URL ?>js/jquery.datetimepicker.full.js"></script>  


</head>
<body>
<input type="hidden" id="base_url" name="base_url" value="<?= BASE_URL ?>">



<div class="app_header main_block">
	<!--========*****Topbar*****========-->
	<?php include "admin_topbar.php"; ?>   
</div>

<div class="sidebar_wrap">
	<!--========*****sidebar*****========-->
	<?php include "admin_sidebar.php"; ?>
</div>

<div class="app_content_wrap">
