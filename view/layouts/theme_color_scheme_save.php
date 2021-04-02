<?php 
include_once('../../model/model.php');

global $theme_color, $theme_color_dark, $theme_color_2, $topbar_color, $sidebar_color;

?>
<form id="frm_color_scheme">
<div class="modal fade" id="app_color_scheme_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select Your Color Scheme</h4>
      </div>
      <div class="modal-body">

        <div class="hidden">
          <input type="color" id="theme_color_dark" name="theme_color_dark" value="<?= $theme_color_dark ?>">
          <input type="color" id="theme_color_2" name="theme_color_2" value="<?= $theme_color_2 ?>">
          <input type="color" id="sidebar_color" name="sidebar_color" value="<?= $sidebar_color ?>">
          <input type="color" id="topbar_color" name="topbar_color" value="<?= $topbar_color ?>">
        </div>

        <div class="panel panel-default panel-body pad_8 mg_bt_10 text-center">

          <div class="row text-center">
            <div class="col-md-12">
              <label for="">Theme Color</label>
              <input type="color" id="theme_color" name="theme_color" value="<?= $theme_color ?>">
            </div>              
          </div>

        </div>  

        <div class="panel panel-default panel-body pad_8 text-center">
            <button class="btn btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Color Scheme</button> &nbsp;&nbsp;
            <button type="button" onclick="reset_app_color_scheme()" class="btn btn-info btn-sm ico_left" id="btn_reset"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Reset Color Scheme</button>
        </div>
   
      </div>     
    </div>
  </div>
</div>
</form>

<script>
  $('#app_color_scheme_modal').modal('show');
  $(function(){
    $('#frm_color_scheme').validate({
      rules:{
              theme_color : { required :true },
              theme_color_dark : { required :true },
              theme_color_2 : { required :true },
              sidebar_color : { required :true },
              topbar_color : { required :true },
      },
      submitHandler:function(data){
          var base_url = $('#base_url').val();
          var theme_color = $('#theme_color').val();
          var theme_color_dark = $('#theme_color_dark').val();
          var theme_color_2 = $('#theme_color_2').val();
          var sidebar_color = $('#sidebar_color').val();
          var topbar_color = $('#topbar_color').val();

          $("#btn_save").button('loading');
          $.ajax({
            url: base_url+'controller/app_settings/app_color_scheme_save.php',
            type:'post',
            data:$('#frm_color_scheme').serialize(),
            success:function(result){
              $('#btn_save').button('reset');
              msg_alert(result);
            },
            error:function(result){
              error_msg_alert(result);
              //console.log(result);
            }
          });
      }
    });
  });
  function reset_app_color_scheme()
  {
    var base_url = $('#base_url').val();
    $("#btn_reset").button('loading');
    $.ajax({
            url: base_url+'controller/app_settings/app_color_scheme_reset.php',
            type:'post',
            data:{},
            success:function(result){
              $('#btn_reset').button('reset');
              msg_alert(result);
            },
            error:function(result){
              //console.log(result);
              error_msg_alert(result);
            }
          });
  }
</script>