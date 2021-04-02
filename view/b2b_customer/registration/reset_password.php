<?php
include "../../../model/model.php";
$email = $_GET['email'];
$username = $_GET['username'];
$agent_code = $_GET['agent_code'];
$email = base64_decode($email);
$username = base64_decode($username);
$agent_code = base64_decode($agent_code);
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
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/vi.alert.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">
            
	<link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
    <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
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
</head>
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
		   <h4 class="modal-title" id="myModalLabel">Reset your password!</h4>
	  </div>
      <div class="modal-body" style='padding:10px !important;'>
        <section id="sec_ticket_save" name="">	
        <form id="frm_tab1">
        <input type='hidden' id='email' value='<?= $email ?>'/>
        <input type='hidden' id='agent_code' value='<?= $agent_code ?>'/>
        <input type='hidden' id='username' value='<?= $username ?>'/>
            <div class="row">
                <div class="col-md-12 col-sm-6">
                    <input class="form-control" type="password" id="new_password" name="new_password" placeholder="*New Password" title="*Please Enter New Password" required  /> 
                </div>
                <div class="col-md-12 col-sm-6 mg_tp_10">
                    <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="*Confirm Password" title="*Please Enter Confirm Password" required/>
                </div>
            </div>
            <div class="row text-center mg_tp_10">
                <div class="col-xs-12">
                    <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
                </div>
            </div>
        </form>
        </section>
      </div>  
    </div>
  </div>
</div>
<div id="site_alert"></div>
<script>
$('#save_modal').modal('show');$('#frm_tab1').validate({
	rules:{
          
	},
	submitHandler:function(form){
        
        var email = $('#email').val();
        var username = $('#username').val();
        var agent_code = $('#agent_code').val();
        var new_password = $('#new_password').val();
        var confirm_password = $('#confirm_password').val();
        if(confirm_password !== new_password){
            error_msg_alert('Password does not match!'); return false;
        }

        $('#btn_save').button('loading');
        $.ajax({
        type:'post',
        url: '../../../controller/b2b_customer/login/reset_password.php',
        data:{ username : username, agent_code : agent_code, new_password : new_password,email:email},
        success: function(message){
            $('#btn_save').button('reset');
            success_msg_alert(message);
            $('#save_modal').modal('hide');
            setInterval(() => {
                window.location.replace('../../../Tours_B2B/login.php');
            },1000);
        }
        });
    }
});
</script>
 
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>