<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id= $_SESSION['emp_id'];
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Transfer</h4>
      </div>
      <div class="modal-body">            
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select id="from_bank_id" name="from_bank_id" style="width:100%" title="Creditor Bank" class="form-control">
                    <?php get_bank_dropdown(); ?>
                </select>
              </div>
               <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select id="to_bank_id" name="to_bank_id" style="width:100%" title="Debitor Bank" class="form-control">
                    <?php get_bank_dropdown('Debitor Bank'); ?>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_date" name="payment_date" class="form-control" placeholder="*Transaction Date" title="Transaction Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_amount" name="payment_amount" placeholder="*Amount" class="form-control" title="Amount" onchange="validate_balance(this.id);">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="f_name" name="f_name" onchange="fname_validate(this.id)" placeholder="Favouring Name" class="form-control" title="Favouring Name" >
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="ins_no" name="ins_no" placeholder="*Instrument Number" onchange="validate_spaces(this.id); validate_specialChar(this.id);" title="Instrument Number" class="form-control" >
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="ins_date" name="ins_date" placeholder="*Instrument Date" title="Instrument Date" onchange="get_lapse_date('trans_type','ins_date')" class="form-control" value="<?= date('d-m-Y') ?>">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select id="trans_type" name="trans_type" style="width:100%" title="Transaction Type" class="form-control" onchange="get_lapse_date(this.id,'ins_date')">
                  <option value="">*Transaction Type</option>
                  <option value="Cheque">Cheque</option>
                  <option value="DD">DD</option>
                  <option value="Credit Card">Credit Card</option>
                  <option value="IMPS">IMPS</option>
                  <option value="NEFT">NEFT</option>
                  <option value="RTGS">RTGS</option>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="lapse_date" name="lapse_date" placeholder="Lapse Date" title="Lapse Date" class="form-control" readonly >
              </div>
          </div>
          <div class="row">              
              <div class="col-md-12 col-sm-9">
               <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= 'Please make sure Date, Amount, Debitor bank,Creditor bank,Transaction type entered properly.' ?></span>
             </div>
            </div>

            <div class="row text-center mg_tp_20">
              <div class="col-xs-12">
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
$('#payment_date,#ins_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#from_bank_id,#to_bank_id').select2();

$('#frm_save').validate({
  rules:{
          from_bank_id : { required: true },
          to_bank_id : { required: true },
          trans_type : { required: true },
          payment_amount : { required: true, number: true },
          payment_date : { required: true },
          ins_no : { required: true },
          ins_date : { required: true },
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();

    var from_bank_id = $('#from_bank_id').val();
    var to_bank_id = $('#to_bank_id').val();
    var payment_amount = $('#payment_amount').val();
    var payment_date = $('#payment_date').val();
    var f_name = $('#f_name').val();
    var trans_type = $('#trans_type').val();
    var ins_no = $('#ins_no').val();
    var ins_date = $('#ins_date').val();
    var lapse_date = $('#lapse_date').val();
    var branch_admin_id = $('#branch_admin_id1').val();
    var emp_id = $('#emp_id').val();
    $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
      if(data !== 'valid'){
        error_msg_alert("The Transaction date does not match between selected Financial year.");
        return false;
      }
      else{

          $('#btn_save').button('loading');

          $.ajax({
            type:'post',
            url:base_url+'controller/bank_vouchers/bank_transfer_save.php',
            data: { from_bank_id : from_bank_id,to_bank_id : to_bank_id, payment_amount : payment_amount, payment_date : payment_date,f_name : f_name,trans_type : trans_type,ins_no : ins_no,ins_date : ins_date,lapse_date : lapse_date, branch_admin_id : branch_admin_id,emp_id : emp_id },
            success:function(result){        
              msg_alert(result);
              var msg = result.split('--');
              if(msg[0]!="error"){
                $('#save_modal').modal('hide');
                list_reflect();
              }
            }
          });
      }
    });

  }
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>