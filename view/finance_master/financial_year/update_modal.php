<?php
include "../../../model/model.php";

$financial_year_id = $_POST['financial_year_id'];
$sq_financial_year = mysql_fetch_assoc(mysql_query("select * from financial_year where financial_year_id='$financial_year_id'"));
?>
<form id="frm_update">
<input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Financial Year</h4>
      </div>
      <div class="modal-body">
        
        <div class="row">
          <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="from_date1" name="from_date1" class="form-control" placeholder="From Date" title="From Date" value="<?= get_date_user($sq_financial_year['from_date']) ?>">
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="to_date1" name="to_date1" class="form-control" placeholder="To Date" title="To Date" value="<?= get_date_user($sq_financial_year['to_date']) ?>">
          </div>
          <div class="col-sm-4 col-sm-6 col-xs-12 mg_bt_10">
            <select name="active_flag" id="active_flag" title="Status">
              <option value="<?= $sq_financial_year['active_flag'] ?>"><?= $sq_financial_year['active_flag'] ?></option>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="row mg_tp_10 text-center">
          <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>  
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>

<script>
$('#update_modal').modal('show');
$('#from_date1, #to_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });

$(function(){
  $('#frm_update').validate({
    rules:{
          from_date1 : { required : true },
          to_date1 : { required : true },
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var financial_year_id = $('#financial_year_id').val();
        var from_date = $('#from_date1').val();
        var to_date = $('#to_date1').val();
        var active_flag = $('#active_flag').val();
 
        $('#btn_update').button('loading');

        $.post(
               base_url+"controller/finance_master/financial_year/financial_year_update.php",
               { financial_year_id : financial_year_id, from_date : from_date, to_date : to_date, active_flag : active_flag },
               function(data) {
                  $('#btn_update').button('reset');
                  var msg = data.split('--');
                  if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                  }else{
                    msg_alert(data);
                    $('#update_modal').modal('hide');  
                    $('#update_modal').on('hidden.bs.modal', function(){
                      list_reflect();
                    });
                  }
                  
        });  

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>