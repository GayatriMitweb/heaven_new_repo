<?php
include "../../../model/model.php";
?>
<div class="modal fade" id="credit_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Credit Limit</h4>
      </div>
      <div class="modal-body">
        <form id="frm_credit_save">
          <div class="row mg_bt_10">
            <div class="col-sm-3 mg_bt_10_sm_xs">
              <select name="register_id" id="register_id" title="Select Company" class='form-control' style='width:100%' required>
                  <option value="">Select Company</option>
                  <?php $sq_query = mysql_query("select register_id,company_name from b2b_registration where 1");
                  while($row_query = mysql_fetch_assoc($sq_query)){?>
                  <option value="<?= $row_query['register_id']?>"><?= $row_query['company_name'] ?></option>
                  <?php } ?>
              </select>
            </div>
            <div class="col-md-3">
              <input type="text" id="payment_date" name="payment_date" placeholder="*Entry Date" title="Entry Date" value="<?= date('d-m-Y') ?>" onchange="check_valid_date(this.id)" required>
            </div>
            <div class="col-sm-3 mg_bt_10_sm_xs">
              <select name="credit_approve" id="credit_approve" title="Select Approval Status" data-toggle="tooltip" onchange="change_fields_status(this.id)" required>
              <?php if($sq_credit['approval_status'] != ''){?>
                  <option value="<?= $sq_credit['approval_status'] ?>"><?= $sq_credit['approval_status'] ?></option>
              <?php } ?>
                  <option value="">Approval Status</option>
                  <option value="Approved">Approved</option>
                  <option value="Rejected">Rejected</option>
              </select>
            </div>
            <div class="col-sm-3 mg_bt_10_sm_xs">
              <input type="number" id="app_credit" name="app_credit" placeholder="*Credit Amount" title="Enter Credit Amount" value="<?= $sq_credit['credit_amount'] ?>" onchange="validate_balance(this.id);" required>
            </div>
          </div>
          <div class="row mg_bt_10">
            <div class="col-sm-3 mg_bt_10_sm_xs">
              <input type="number" id="payment_days" name="payment_days" placeholder="*Payment Days For Eg. 10" title="Enter Payment Days" value="<?= $sq_credit['payment_days'] ?>" required>
            </div>
            <div class="col-sm-9 mg_bt_10_sm_xs">
              <textarea id="description" name="description" rows="1" placeholder="Description"><?= $sq_credit['description'] ?></textarea>
            </div>
          </div>
          <div class="row text-center">
            <div class="col-md-12 mg_tp_10">
              <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
            </div>
          </div>
        </form> 
    </div>
  </div>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#credit_save_modal').modal('show');
$('#payment_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#register_id').select2();
  $(function(){
	$('#frm_credit_save').validate({
	  rules:{
	  },
	  submitHandler:function(form){

	  	  var register_id = $('#register_id').val();
        var payment_date = $('#payment_date').val();
	      var credit_limit = $('#app_credit').val();
        var description = $('#description').val();
        var approve_status = $('#credit_approve').val();
        var payment_days = $('#payment_days').val();
        var base_url = $('#base_url').val();
        
        $("#vi_confirm_box").vi_confirm_box({
        callback: function(result){
          if(result=="yes"){
            $('#btn_save').button('loading');            
            $.ajax({
              type: 'post',
              url: base_url+'controller/b2b_customer/credit_limit/credit_save.php',
              data:{ register_id : register_id,payment_date:payment_date, credit_limit : credit_limit,description : description,approve_status : approve_status,payment_days:payment_days},
              success: function(result){
                msg_alert(result);
                $('#credit_save_modal').modal('hide');
                $('#btn_save').button('reset');
                $('#credit_save_modal').on('hidden.bs.modal', function(){
                  customer_list_reflect();
                });
              }
            });
          }
        }
      });
	  }
	});
  });
</script>