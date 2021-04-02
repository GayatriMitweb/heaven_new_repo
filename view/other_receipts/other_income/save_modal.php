<?php
include "../../../model/model.php";
?>
<form id="frm_save">

<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Income</h4>
      </div>
      <div class="modal-body">
            
      <div class="panel panel-default panel-body app_panel_style feildset-panel">
          <legend>Description</legend>
          <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <select name="income_type_id" id="income_type_id" title="Income Type" class="form-control" style="width:100%">
                <option value="">*Income Type</option>
                <?php 
                $sq_expense = mysql_query("select * from ledger_master where group_sub_id in ('63','41','86','52','5','50','6')");
                while($row_expense = mysql_fetch_assoc($sq_expense)){
                  ?>
                  <option value="<?= $row_expense['ledger_id'] ?>"><?= $row_expense['ledger_name'] ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="r_from" name="r_from" placeholder="*Receipt From" title="Receipt From">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="sub_total" name="sub_total" placeholder="*Basic Amount" title="Basic Amount" onchange="validate_balance(this.id);total_fun();">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="service_tax_subtotal" name="service_tax_subtotal" placeholder="Tax Amount" title="Tax Amount" onchange="validate_balance(this.id);total_fun();">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="tds" name="tds" placeholder="TDS" title="TDS" onchange="total_fun();validate_balance(this.id)">
            </div>            
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" name="total_fee" id="total_fee" class="amount_feild_highlight text-right" placeholder="*Net Total" title="Net Total" readonly>
             </div>                        
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" name="booking_date" id="booking_date" placeholder="Receipt Date" value="<?= date('d-m-Y') ?>" title="Receipt Date" onchange="check_valid_date(this.id)">
            </div>          
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" name="cust_pan_no" id="cust_pan_no" onchange="validate_specialChar(this.id)" placeholder="PAN No/TAN No" title="PAN No/TAN No" style="text-transform: uppercase;">
             </div>    
            <div class="col-md-12 col-sm-6 col-xs-12 mg_bt_10">
              <textarea name="particular" id="particular" rows="1" placeholder="*Narration" title="Narration"></textarea>
            </div>
          </div>
      </div>
      <div class="panel panel-default panel-body app_panel_style feildset-panel">
        <legend>Receipt Details</legend>          
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_amount" name="payment_amount" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name','bank_id')">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_date" name="payment_date" placeholder="*Date" title="Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select name="payment_mode" id="payment_mode" class="form-control" title="Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
                  <?php get_payment_mode_dropdown(); ?>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="transaction_id" name="transaction_id" onchange="validate_balance(this.id)" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" disabled>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select name="bank_id" id="bank_id" title="Select Bank" disabled>
                  <?php get_bank_dropdown(); ?>
                </select>
              </div>
            </div>
               <div class="col-md-12 col-sm-9 no-pad mg_bt_20">
                 <span style="color: red;line-height: 35px;" class="note" data-original-title="" title="">Note : Please make sure Date, Amount,mode, Debitor bank entered properly.</span>
               </div>   
        </div>
        <div class="row text-center mg_tp_20">
          <div class="col-xs-12">
            <button class="btn btn-sm btn-success" id="income_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>

</form>

<script>
$('#save_modal').modal('show');
$('#income_type_id').select2();
$('#payment_date,#booking_date').datetimepicker({ timepicker:false, format:'d-m-Y' });


function total_fun()
{ 
    var service_tax = $('#service_tax').val();
    var service_tax_subtotal = $('#service_tax_subtotal').val();   
    var sub_total = $('#sub_total').val();   
    var tds = $('#tds').val();

    if(sub_total==""){ sub_total = 0; }
    if(service_tax_subtotal==""){ service_tax_subtotal = 0; }
    if(tds==""){ tds = 0; }
    
    var total_amount = parseFloat(sub_total) + parseFloat(service_tax_subtotal) - parseFloat(tds);
    var total=total_amount.toFixed(2);
    $('#total_fee').val(total);
}

$('#frm_save').validate({
  rules:{
          income_type_id : { required: true },
          r_from : { required: true },
          sub_total : { required: true },
          payment_amount : { required: true, number: true },
          payment_date : { required: true },
          payment_mode :{ required : true },
          bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
          transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
          bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
          particular : { required: true },
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();

    var income_type_id = $('#income_type_id').val();
    var r_from = $('#r_from').val();
    var sub_total = $('#sub_total').val();
    var service_tax_subtotal = $('#service_tax_subtotal').val();
    var tds = $('#tds').val();
    var net_total = $('#total_fee').val();
    var particular = $('#particular').val();
    var booking_date = $('#booking_date').val();
    var payment_amount = $('#payment_amount').val();
    var payment_date = $('#payment_date').val();
    var payment_mode = $('#payment_mode').val();
    var bank_name = $('#bank_name').val();
    var transaction_id = $('#transaction_id').val();
    var bank_id = $('#bank_id').val();    
    var cust_pan_no = $('#cust_pan_no').val();    
    var branch_admin_id = $('#branch_admin_id1').val(); 
    if(parseInt(payment_amount) === 0){
      error_msg_alert("Payment amount should not be 0!"); return false;
    }
    //Validation for booking and payment date in login financial year
    var check_date1 = $('#booking_date').val();
    $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
      if(data !== 'valid'){
        error_msg_alert("The Receipt date does not match between selected Financial year.");
        return false;
      }else{
        var payment_date = $('#payment_date').val();
        $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
        if(data !== 'valid'){
          error_msg_alert("The Payment date does not match between selected Financial year.");
          return false;
        }
        else{
          $('#income_save').button('loading');
          $.ajax({
            type:'post',
            url:base_url+'controller/tour_estimate/other_income/income_save.php',
            data: { income_type_id : income_type_id,r_from : r_from, sub_total : sub_total, service_tax_subtotal : service_tax_subtotal, tds : tds, net_total : net_total, particular : particular, booking_date : booking_date, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, cust_pan_no : cust_pan_no,branch_admin_id : branch_admin_id},
            success:function(result){
              msg_alert(result);
              $('#income_save').button('reset');
              var msg = result.split('--');
              if(msg[0]!="error"){
                reset_form('frm_save');
                $('#save_modal').modal('hide');
                income_list_reflect();
              }
            }
          });
        }
      });
    }
  });

  }
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>