<?php
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status']; 
$role = $_SESSION['role'];
?>
<form id="frm_vendor_payment_save1">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<input type="hidden" id="emp_id" name="emp_id" value="<?= $emp_id ?>" >
<div class="modal fade" id="v_payment_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="margin-top:20px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Payment Save</h4>
      </div>
      <div class="modal-body">

            <div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
            <legend>Select Sale</legend>

              <div class="row">
                <div class="col-md-3">
                  <select name="vendor_type" id="vendor_type" title="Supplier Type" onchange="vendor_type_data_load_p(this.value, 'div_vendor_type_content')">
                    <option value="">*Supplier Type</option>
                    <?php 
                    $sq_vendor = mysql_query("select * from vendor_type_master order by vendor_type");
                    while($row_vendor = mysql_fetch_assoc($sq_vendor)){
                      ?>
                      <option value="<?= $row_vendor['vendor_type'] ?>"><?= $row_vendor['vendor_type'] ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
                <div id="div_vendor_type_content"></div>
              </div>
            </div>

            <div id="div_payment_for"></div>

            <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
            <legend>Payment Particulars</legend>
          
              <div class="row mg_bt_20">                      
                <div class="col-md-4">
                  <input type="text" id="payment_date" name="payment_date" class="form-control" placeholder="*Date" title="Payment Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
                </div>  
                <div class="col-md-4">
                  <input type="text" id="payment_amount" name="payment_amount" class="form-control" placeholder="*Payment Amount" title="Payment Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name','bank_id')">
                </div>             
                <div class="col-md-4">
                  <select name="payment_mode" id="payment_mode" class="form-control" title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
                    <option value="">*Payment Mode</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="NEFT">NEFT</option>
                    <option value="RTGS">RTGS</option>
                    <option value="IMPS">IMPS</option>
                    <option value="DD">DD</option>
                    <option value="Online">Online</option>
                    <option value="Debit Note">Debit Note</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div>
              <div class="row mg_bt_10">
                <div class="col-md-4">
                  <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled>
                </div>
                <div class="col-md-4">
                  <input type="text" id="transaction_id" onchange="validate_balance(this.id);" name="transaction_id" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" disabled>
                </div>
                 <div class="col-md-4">
                  <select name="bank_id" id="bank_id" title="Debitor Bank" disabled>
                    <?php get_bank_dropdown('Debitor Bank'); ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="div-upload pull-left" id="div_upload_button">
                      <div id="payment_evidence_upload" class="upload-button1"><span>Payment Evidence</span></div>
                      <span id="payment_evidence_status" ></span>
                      <ul id="files" ></ul>
                      <input type="hidden" id="payment_evidence_url" name="payment_evidence_url">
                  </div>
                </div>
               <div class="col-md-9 col-sm-9 no-pad mg_bt_20">
                 <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= $txn_feild_note ?></span>
               </div>
              </div>

            </div>

            <div class="row text-center mg_tp_20">
                <div class="col-md-12">
                  <button class="btn btn-sm btn-success" id="payment_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
                </div>
            </div>    


      </div>      
    </div>
  </div>
</div>
</form>

<script>
$('#payment_date').datetimepicker({timepicker:false, format:'d-m-Y'});
function calculate_total_purchase(id,check_id,offset='')
{
    var total_amt = $('#total_purchase').val();
    var purchase_amount = $('#'+id).val();

    var total_expense = 0;
    if(total_amt == 0) { total_amt = 0; }  
    
    if($('#'+check_id).prop('checked') == true){
      total_expense=parseFloat(total_amt)+parseFloat(purchase_amount);
    }
    else{
      total_expense=parseFloat(total_amt)-parseFloat(purchase_amount);
    }
 
  $('#total_purchase').val(total_expense.toFixed(2));  
}

$(function(){
  $('#frm_vendor_payment_save1').validate({
      rules:{              
              vendor_type: { required: true },
              payment_amount : { required: true, number:true },
              payment_date : { required: true },
              payment_mode : { required : true },
              bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
              transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
              bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
      },
      submitHandler:function(form){
              var status = validate_estimate_vendor('estimate_type3','3');
              if(!status){ return false; }
              
              var vendor_type = $('#vendor_type').val();
              var vendor_type_id = get_vendor_type_id('vendor_type');
              var payment_amount = $('#payment_amount').val();
              var payment_date = $('#payment_date').val();
              var payment_mode = $('#payment_mode').val();
              var bank_name = $('#bank_name').val();
              var transaction_id = $('#transaction_id').val();
              var bank_id = $('#bank_id').val();
              var payment_evidence_url = $('#payment_evidence_url').val();
              var branch_admin_id = $('#branch_admin_id1').val();
              var emp_id = $('#emp_id').val();

              var advance_amount = $('#advance_amount').val();
              var advance_nullify = $('#advance_nullify').val();
              var total_purchase = $('#total_purchase').val();
              var debit_note_amount =  $('#debit_note_amount').val();

              // Jquery check undefined value
              if(typeof advance_nullify === "undefined") { advance_nullify = '0'; }
              if(typeof advance_amount === "undefined") { advance_amount = '0'; }
              if(typeof debit_note_amount === '') { debit_note_amount = '0'; }
              if(advance_nullify == "") { advance_nullify = '0'; }
              
              //Amount Validations
              if(parseFloat(total_purchase) == '0') { error_msg_alert("Atleast one booking is required!");
                    return false; }
              if(parseFloat(total_purchase) < parseFloat(advance_nullify)){ error_msg_alert("Amount to be nullify should be less or equal to the Total Purchase"); return false; }
              if(parseFloat(advance_amount) < parseFloat(advance_nullify)){ error_msg_alert("Amount to be nullify should not be more than Advance"); return false; }
              if(parseFloat(debit_note_amount) < parseFloat(payment_amount)){ error_msg_alert("Low Debit note balance"); return false; }
              if(parseFloat(advance_nullify)<'0'){ error_msg_alert("Amount to be nullify should be greater than 0"); return false; };

              var total_payment_amount = parseFloat(payment_amount) + parseFloat(advance_nullify);
              if(parseFloat(total_payment_amount) > parseFloat(total_purchase)){ error_msg_alert("Total Payment should not be more than Purchase"); return false; }
              
			        var payment_amount_arr = new Array();
              var purchase_type_arr = new Array();
              var purchase_id_arr = new Array();
              
              var temp_payment = parseFloat(payment_amount) + parseFloat(advance_nullify);
              
              g_validate_status = true; 
              var validate_message = "";
              var table = document.getElementById("tbl_pr_payment_list");
              var rowCount = table.rows.length;
              for(var i=0; i<rowCount-1; i++){
                var row = table.rows[i];
                var purchase_type = row.cells[1].childNodes[0].value;
                var purchase_id = row.cells[2].childNodes[0].value;
                if(i!=0){
                  var row1 = table.rows[i-1];
                  var purchase_type1 = row1.cells[1].childNodes[0].value;
                  var purchase_id1 = row1.cells[2].childNodes[0].value;
                  if((purchase_type1 == purchase_type) && (purchase_id1 == purchase_id)){
                      error_msg_alert(purchase_type1 +" repeated for Booking ID-"+purchase_id1);
                      return false;
                  }
                }
              }
              var table = document.getElementById("tbl_pr_payment_list");              
              var rowCount = table.rows.length;
              for(var i=0; i<rowCount; i++){
                var row = table.rows[i];
                if(row.cells[4].childNodes[0].checked){
                       var purchase_type = row.cells[1].childNodes[0].value;
                       var purchase_id = row.cells[2].childNodes[0].value;
                       var purchase_amount = row.cells[3].childNodes[0].value; 
                       
                       // Payment is equal to the purchase amount
                       if(parseFloat(temp_payment) == parseFloat(purchase_amount)){
                       	  var temp_payment =  parseFloat(temp_payment) - parseFloat(purchase_amount);
                       	  payment_amount_arr.push(purchase_amount);
                       	  purchase_type_arr.push(purchase_type);
                       	  purchase_id_arr.push(purchase_id);
                       }  
                       // Payment is less than purchase amount
                       else if(parseFloat(temp_payment) < parseFloat(purchase_amount)){
                       	  var temp_payment1 =  parseFloat(purchase_amount) - parseFloat(temp_payment);
                          payment_amount_arr.push(temp_payment);
                       	  purchase_type_arr.push(purchase_type);
                       	  purchase_id_arr.push(purchase_id);
                       	  temp_payment = 0;
                       } 
                       // Payment is greater than purchase amount
                       else{
                       	  var temp_payment =  parseFloat(temp_payment) - parseFloat(purchase_amount);
                       	  payment_amount_arr.push(purchase_amount);
                       	  purchase_type_arr.push(purchase_type);
                       	  purchase_id_arr.push(purchase_id);
                       }
                }
              }

              var base_url = $('#base_url').val();
              $('#payment_save').button('loading');
              $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
                if(data !== 'valid'){
                  error_msg_alert("The Payment Date does not match between selected Financial year.");
                  $('#payment_save').button('reset');
                  return false;
                }
                else{
                    $('#payment_save').button('loading');
                    $("#vi_confirm_box").vi_confirm_box({
                    callback: function(result){
                      if(result=="yes"){
                        $.ajax({
                          type: 'post',
                          url: base_url+'controller/vendor/dashboard/payment/payment_save.php',
                          data:{ vendor_type : vendor_type, vendor_type_id : vendor_type_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, payment_evidence_url :payment_evidence_url, branch_admin_id : branch_admin_id , emp_id : emp_id,advance_nullify : advance_nullify,total_payment_amount : total_payment_amount,total_purchase : total_purchase,payment_amount_arr : payment_amount_arr,purchase_type_arr : purchase_type_arr,purchase_id_arr : purchase_id_arr},
                          success: function(result){
                          $('#payment_save').button('reset');

                            var msg = result.split('-');
                            if(msg[0]=='error'){
                              msg_alert(result);
                            }
                            else{
                              msg_alert(result);
                              $('#v_payment_save_modal').modal('hide'); 
                              reset_form('frm_vendor_payment_save1'); 
                              payment_list_reflect();
                            }
                          }
                        });
                      }
                      else{
                        $('#payment_save').button('reset');
                      }
                    }
                  });
                }
              });
      }
  });
});
</script>
