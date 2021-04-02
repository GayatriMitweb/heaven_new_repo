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
            <legend>Payment For</legend>

              <div class="row">          
                  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                    <select name="supplier_type2" id="supplier_type2" title="Supplier Type" onchange="supplier_expenses_load(this.value, 'div_expenses_load')" class="form-control" style="width: 100%;">
                      <option value="">*Supplier Type</option>
                      <?php 
                      $sq_expense = mysql_query("select * from other_vendors order by vendor_name");
                      while($row_expense = mysql_fetch_assoc($sq_expense)){
                        ?>
                        <option value="<?= $row_expense['vendor_id'] ?>"><?= $row_expense['vendor_name'] ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                <div id="div_expenses_load"></div>
              </div>
            </div>
            <div id="div_payment_for"></div>

            <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
            <legend>Payment Particulars</legend>
          
              <div class="row mg_bt_20">                      
                <div class="col-md-4">
                  <input type="text" id="payment_date" name="payment_date" class="form-control" placeholder="Date" title="Payment Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
                </div>  
                <div class="col-md-4">
                  <input type="text" id="payment_amount" name="payment_amount" class="form-control" placeholder="*Payment Amount" title="Payment Amount" onchange="validate_balance(this.id);">
                </div>             
                <div class="col-md-4">
                  <select name="payment_mode" id="payment_mode" class="form-control" title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
                   <?php get_payment_mode_dropdown(); ?>
                  </select>
                </div>
              </div>
              <div class="row mg_bt_10">
                <div class="col-md-4">
                  <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="*Bank Name" title="Bank Name" disabled>
                </div>
                <div class="col-md-4">
                  <input type="text" id="transaction_id" name="transaction_id" onchange="validate_balance(this.id);" class="form-control" placeholder="*Cheque No/ID" title="Cheque No/ID" disabled>
                </div>
                 <div class="col-md-4">
                  <select name="bank_id" id="bank_id" title="Debitor Bank" disabled>
                    <?php get_bank_dropdown('*Debitor Bank'); ?>
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
$('#supplier_type2').select2();
$('#payment_date').datetimepicker({timepicker:false, format:'d-m-Y'});

function payment_evidance_upload()
{ 
    var btnUpload=$('#payment_evidence_upload');
    $(btnUpload).find('span').text('Payment Evidence');
    $('#payment_evidence_url').val('');
    
    new AjaxUpload(btnUpload, {
      action: 'payment/upload_payment_evidence.php',
      name: 'uploadfile',
      onSubmit: function(file, ext)
      {  
        if (! (ext && /^(jpg|png|jpeg|pdf)$/.test(ext))){ 
         error_msg_alert('Only JPG, PNG or GIF or pdf files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        if(response==="error"){
          error_msg_alert("File is not uploaded.");
          $(btnUpload).find('span').text('Upload Again');
        }else
        { 
          $(btnUpload).find('span').text('Uploaded');
          $('#payment_evidence_url').val(response);
        }
      }
    });
}
payment_evidance_upload();

function supplier_expenses_load(supplier_id, for_id)
{
  var base_url = $('#base_url').val();
  $.post(base_url+'view/other_expense/supplier_expenses_load.php', { supplier_id : supplier_id }, function(data){
    $('#'+for_id).html(data);  
  });
}
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
              supplier_type2: { required: true },
              payment_amount : { required: true, number:true },
              payment_date : { required: true },
              payment_mode : { required : true },
              bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
              transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
              bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
      },
      submitHandler:function(form){

				var supplier_type = $('#supplier_type2').val();
				var payment_date = $('#payment_date').val();
				var payment_amount = $('#payment_amount').val();
				var payment_mode = $('#payment_mode').val();
				var bank_name = $('#bank_name').val();
				var transaction_id = $('#transaction_id').val();
				var bank_id = $('#bank_id').val();
				var payment_evidence_url = $('#payment_evidence_url').val();
				var branch_admin_id = $('#branch_admin_id').val();
				var emp_id = $('#emp_id').val();

        var total_purchase = $('#total_purchase').val();
        //Amount Validations
        if(parseFloat(total_purchase) == '0.00') { error_msg_alert("Atleast one booking is required!");
              return false; }

        if(parseFloat(total_purchase) < parseFloat(payment_amount)){ error_msg_alert("Payment Amount should be less or equal to the Total Purchase"); return false; }
			  
			  var payment_amount_arr = new Array();
        var purchase_type_arr = new Array();
        var purchase_id_arr = new Array();
        var expense_arr = new Array();
        
        var temp_payment = parseFloat(payment_amount);
        var table = document.getElementById("tbl_supplier_expense");
                      
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++)
        {
            var row = table.rows[i];
            if(row.cells[4].childNodes[0].checked){
                var purchase_amount = row.cells[3].childNodes[0].value;
                var purchase_type = row.cells[2].childNodes[0].value;
                var purchase_id = row.cells[1].childNodes[0].value;
                var expense_id = row.cells[5].childNodes[0].value;
                // Payment is equal to the purchase amount
                if(parseFloat(temp_payment) == parseFloat(purchase_amount)){

                  var temp_payment =  parseFloat(temp_payment) - parseFloat(purchase_amount);
                  payment_amount_arr.push(purchase_amount);
                  purchase_type_arr.push(purchase_type);
                  purchase_id_arr.push(purchase_id);
                  expense_arr.push(expense_id);
                }  
                // Payment is less than purchase amount   
                else if(parseFloat(temp_payment) < parseFloat(purchase_amount)){

                  var temp_payment1 =  parseFloat(purchase_amount) - parseFloat(temp_payment);
                  payment_amount_arr.push(temp_payment);     
                  purchase_type_arr.push(purchase_type);
                  purchase_id_arr.push(purchase_id);
                  expense_arr.push(expense_id);
                  temp_payment = 0;
                } 
                // Payment is greater than purchase amount	
                else{
                  var temp_payment =  parseFloat(temp_payment) - parseFloat(purchase_amount);
                  payment_amount_arr.push(purchase_amount);
                  purchase_type_arr.push(purchase_type);
                  purchase_id_arr.push(purchase_id);
                  expense_arr.push(expense_id);
                }
            }
          }

            var base_url = $('#base_url').val();            
            var payment_date = $('#payment_date').val();

            $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
            if(data !== 'valid'){
              error_msg_alert("The Payment date does not match between selected Financial year.");
              return false;
            }
            else{
              $('#payment_save').button('loading');
              $("#vi_confirm_box").vi_confirm_box({

              callback: function(result){

                if(result=="yes"){
                  $.ajax({
                    type: 'post',
                    url: base_url+'controller/other_expense/expense_payment_save.php',
                    data:{ supplier_type : supplier_type, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, payment_evidence_url :payment_evidence_url, branch_admin_id : branch_admin_id , emp_id : emp_id,total_purchase : total_purchase, payment_amount_arr : payment_amount_arr, purchase_type_arr : purchase_type_arr, purchase_id_arr : purchase_id_arr,expense_arr:expense_arr},
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
