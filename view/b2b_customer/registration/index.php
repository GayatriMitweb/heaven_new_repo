<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
?>
<head>

	<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500" rel="stylesheet">

    <!--========*****Header Stylsheets*****========-->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/select2.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.datetimepicker.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.wysiwyg.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/owl.carousel.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-labelauty.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/menu-style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/btn-style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/dynforms.vi.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/admin.php">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/vi.alert.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">
            
	<link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
    <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery-ui.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.mCustomScrollbar.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.datetimepicker.full.js"></script> 
    <script src="<?php echo BASE_URL ?>js/jquery.wysiwyg.js"></script> 
    <script src="<?php echo BASE_URL ?>js/script.js"></script>
    <script src="<?php echo BASE_URL ?>js/select2.full.js"></script> 
    <script src="<?php echo BASE_URL ?>js/owl.carousel.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery-labelauty.js"></script>
    <script src="<?php echo BASE_URL ?>js/responsive-tabs.js"></script>
    <script src="<?php echo BASE_URL ?>js/dynforms.vi.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/vi.alert.js"></script>
    <script src="<?php echo BASE_URL ?>js/app/data_reflect.js"></script>
    <script src="<?php echo BASE_URL ?>js/app/validation.js"></script> 
    <script src="<?php echo BASE_URL ?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap-tagsinput.min.js"></script>  

</head>
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document" style="width:65%">
    <div class="modal-content">
      <div class="modal-header">
		   
	  	<h4 class="modal-title" id="myModalLabel">Registration Form</h4>
		  </div>
      <div class="modal-body" style='padding:10px !important;'>
        <section id="sec_ticket_save" name="">	
		<?php  include_once('tab1.php'); ?>
		</section>
      </div>  
    </div>
  </div>
</div>
<div id="site_alert"></div>

<script>
$('#save_modal').modal('show');
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>