<?php
include "../../../model/model.php";

$entry_id = $_POST['entry_id'];
$branch_status = $_POST['branch_status'];
$sq_bank_info = mysql_fetch_assoc(mysql_query("select * from inter_bank_transfer_master where entry_id='$entry_id'"));
?>
<input type="hidden" name="payment_old_amount" id="payment_old_amount" value="<?= $sq_bank_info['amount'] ?>">
<input type="hidden" name="entry_id" id="entry_id" value="<?= $entry_id ?>">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >

<form id="frm_update">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Bank Transfer</h4>
      </div>
      <div class="modal-body">            
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select id="from_bank_id" name="from_bank_id" style="width:100%" title="Creditor Bank" class="form-control" disabled>  
                 <?php
                    $sq_bank1 = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_bank_info[from_bank_id]'"));
                 ?>
                    <option value="<?= $sq_bank1['bank_id'] ?>"><?= $sq_bank1['bank_name'].'('.$sq_bank1['branch_name'].')' ?></option>
                </select>
              </div>
               <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select id="to_bank_id" name="to_bank_id" style="width:100%" title="Debitor Bank" class="form-control" disabled> 
                  <?php
                    $sq_bank2 = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_bank_info[to_bank_id]'"));
                  ?>
                    <option value="<?= $sq_bank2['bank_id'] ?>"><?= $sq_bank2['bank_name'].'('.$sq_bank2['branch_name'].')' ?></option>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_date" name="payment_date" class="form-control" value="<?= get_date_user($sq_bank_info['transaction_date']) ?>" placeholder="Transaction Date" title="Transaction Date" readonly>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_amount1" name="payment_amount1" placeholder="*Amount" class="form-control" title="Amount" onchange="validate_balance(this.id);" value="<?= $sq_bank_info['amount'] ?>">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="f_name" name="f_name" onchange="fname_validate(this.id);" placeholder="Favouring Name" value="<?= $sq_bank_info['favouring_name'] ?>" class="form-control" title="Favouring Name" >
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="ins_no1" name="ins_no1" onchange="validate_spaces(this.id); validate_specialChar(this.id);" placeholder="*Instrument Number" value="<?= $sq_bank_info['instrument_no'] ?>" title="Instrument Number" class="form-control" onchange="get_lapse_date('trans_type1','ins_no1','1')" required>
              </div>
            </div>
            <div class="row">
               <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="ins_date1" name="ins_date1"  placeholder="*Instrument Date" onchange="get_lapse_date('trans_type1',this.id,'1')" value="<?= get_date_user($sq_bank_info['instrument_date']) ?>" title="Instrument Date" class="form-control" >
               </div>
               <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select id="trans_type1" name="trans_type1" style="width:100%" title="Transaction Type" class="form-control" onchange="get_lapse_date(this.id,'ins_date1','1')" required>
                    <option value="<?= $sq_bank_info['transaction_type'] ?>"><?= $sq_bank_info['transaction_type'] ?></option>
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
                <input type="text" id="lapse_date1" name="lapse_date1" placeholder="Lapse Date" value="<?= get_date_user($sq_bank_info['lapse_date']) ?>" title="Lapse Date" class="form-control" readonly>
              </div>
            </div>
            <div class="row text-center mg_tp_20">
              <div class="col-xs-12">
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
$('#ins_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#frm_update').validate({
  rules:{
          trans_type : { required: true },
          payment_amount : { required: true, number: true },
          ins_no : { required: true },
          ins_date : { required: true },
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();
    var from_bank_id = $('#from_bank_id').val();
    var to_bank_id = $('#to_bank_id').val();            
    var entry_id = $('#entry_id').val()
    var payment_amount = $('#payment_amount1').val();
    var f_name = $('#f_name').val();
    var trans_type = $('#trans_type1').val();
    var ins_no = $('#ins_no1').val();
    var ins_date = $('#ins_date1').val();
    var lapse_date = $('#lapse_date1').val();
    var payment_date = $('#payment_date').val();
    var payment_old_amount = $('#payment_old_amount').val();

    if((payment_amount!='0') && (payment_old_amount != payment_amount))
     { error_msg_alert("Can not update amount else make it 0"); return false;}

    $('#btn_update').button('loading');

    $.ajax({
      type:'post',
      url:base_url+'controller/bank_vouchers/bank_transfer_update.php',
      data: { entry_id : entry_id, payment_amount : payment_amount, f_name : f_name,trans_type : trans_type,ins_no : ins_no,ins_date : ins_date,lapse_date : lapse_date,payment_old_amount : payment_old_amount,from_bank_id : from_bank_id,to_bank_id : to_bank_id,payment_date : payment_date},
      success:function(result){        
        msg_alert(result);
        var msg = result.split('--');
        if(msg[0]!="error"){
          $('#update_modal').modal('hide');
          list_reflect();
        }
      }     
    });

  }
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>