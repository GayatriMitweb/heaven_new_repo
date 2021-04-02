<?php include "model/model.php"; ?>
<?php
if(isset($_SESSION['username'])){ session_destroy(); } 
global $app_version;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>

  <link rel="icon" href="<?= $circle_logo_url ?>" type="image/gif" sizes="16x16">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500" rel="stylesheet">
  
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/vi.alert.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/login.php">

  <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/vi.alert.js"></script>

</head>
<body>

<form id="frm_login">
  <div class="main_block login_screen">
    <div class="login_wrap">
      
      <div class="logo-wrap"> <img src="<?= $circle_logo_url ?>" /> </div>
      <h3>Login to your account</h3>

      <div class="login_wrap_inner">
        <div class="row">
          <div class="col-md-12">
            <input class="form-control" id="txt_username" name="txt_username" type="text" maxlength="30" placeholder="Username" autofocus> 
          </div>
        </div><br>
        <div class="row">
          <div class="col-md-10">
            <input class="form-control" id="txt_password" name="txt_password" type="password" maxlength="30" placeholder="Password"/>    
          </div>
          <div class="col-md-2">
            <a onclick="show_password('txt_password')" target="_BLANK" class="btn app_btn" title="View Password"><i class="fa fa-eye"></i></a>
          </div>
        </div><br>

        <div class="row text-center">
          <div class="col-sm-7 col-xs-12">
            <select name="financial_year_id" id="financial_year_id" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Financial Year">
              <?php get_financial_year_dropdown(false); ?>
            </select>
          </div>
          <div class="col-sm-5 col-xs-12 mg_tp_10_sm_xs">
            <button class="app_btn" id='sign_in'><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Sign In</button>
          </div>
        </div>
      </div>
      
      <div id="site_alert"></div>
    </div>
  </div>
</form>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
  $(function(){
      $('#frm_login').validate({
        submitHandler:function(){
          var username = $('#txt_username').val();
          var password = $('#txt_password').val();
          var financial_year_id = $('#financial_year_id').val();
          $("#site_alert").empty();
          if(username==""){
            $('#site_alert').vialert({ type:'error', title:'Error', message:'Username is required' });
            return false;
          }
          if(password==""){
            $('#site_alert').vialert({ type:'error', title:'Error', message:'Password is required' });
            return false;
          }
          if(financial_year_id==""){
            $('#site_alert').vialert({ type:'error', title:'Error', message:'Financial year is required' });
            return false;
          }

          $('#sign_in').button('loading');

          $.post('controller/login/login_verify.php', { username : username, password : password, financial_year_id : financial_year_id }, function(data){
            if(data=="valid")
              {        
                localStorage.setItem("reminder", true);
                window.location.href = "view/dashboard/dashboard_main.php";
              } 
              else
              {    
                $('.app_btn').button('reset');  
                $('#site_alert').vialert({ type:'error', title:'Error', message:data });
              }
          });
        }
      });
  });
</script>
  
</body>
</html>
