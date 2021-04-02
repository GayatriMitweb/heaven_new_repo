<?php
include "../../../model/model.php";
$login_id = $_SESSION['login_id'];
?>
<form id="frm_save">
<div class="modal fade" id="save_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Financial Year</h4>
      </div>
      <div class="modal-body">
        
        <input type="hidden" id="login_id1" name="login_id" class="form-control" value="<?= $login_id ?>">
    		<div class="row mg_bt_10">
          <div class="col-md-6 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="from_date" name="from_date" class="form-control" placeholder="*From Date" title="From Date" value="<?= date('d-m-Y') ?>">
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="to_date" name="to_date" class="form-control" placeholder="*To Date" title="To Date" value="<?= date('d-m-Y') ?>">
          </div>
          <div class="col-sm-4">
            <select name="active_flag" id="active_flag" title="Status" class="hidden">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="row mg_tp_10 text-center">
          <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>  
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>

<script>
$('#save_modal').modal('show');
$('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$(function(){
  $('#frm_save').validate({
    rules:{
          from_date : { required : true },
          to_date : { required : true },
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var active_flag = $('#active_flag').val();
        var login_id = $('#login_id1').val();
 
        $('#btn_save').button('loading');

        $.post(
               base_url+"controller/finance_master/financial_year/financial_year_save.php",
               { from_date : from_date, to_date : to_date, active_flag : active_flag},
               function(data) {
                  $('#btn_save').button('reset');
                  var msg = data.split('--');
                  if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                  }else{
                    msg_alert(data);
                    $('#save_modal').modal('hide');  
                    $('#save_modal').on('hidden.bs.modal', function(){
                      list_reflect();
                    });
                  }
                  
        });
        $.post(base_url+'controller/login/user_logout.php', { login_id : login_id }, function(data){
              if(data=="valid"){
                setTimeout(function(){ msg_alert('Financial Year added, Please Login again!'); },  60000);
                window.location.href = base_url+"index.php";
              }
        });

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>