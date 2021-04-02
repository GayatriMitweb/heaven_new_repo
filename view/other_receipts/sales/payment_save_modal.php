<?php
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='other_receipts/index.php'"));
$branch_status = $sq['branch_status'];
$role = $_SESSION['role'];
?>
<form id="frm_sale_payment_save1">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<input type="hidden" id="emp_id" name="emp_id" value="<?= $emp_id ?>" >
<div class="modal fade" id="s_payment_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="margin-top:20px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Receipt</h4>
      </div>
      <div class="modal-body">

            <div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
            <legend>Receipt For</legend>

              <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <select id="cust_id_s" name="cust_id_s" style="width:100%" title="Customer" class="form-control" onchange="get_customer_outstanding(this.id,'div_payment_for')">
                      <?php get_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
                  </select>
                </div>
              </div>
            </div>
            <div id="div_payment_for"></div>

            <div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
            <legend>Receipt Details</legend>
          
              <div class="row mg_bt_10">                      
                <div class="col-md-4">
                  <input type="text" id="payment_date" name="payment_date" class="form-control" placeholder="*Date" title="Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
                </div>
                <div class="col-md-4">
                  <select name="payment_mode" id="payment_mode" class="form-control" title="Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id');get_identifier_block('identifier','payment_mode','credit_card_details','credit_charges');get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges')">
                  <?php get_payment_mode_dropdown(); ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" id="payment_amount" name="payment_amount" class="form-control" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name');get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges');">
                </div>
              </div>
              <div class="row mg_bt_10">
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <input class="hidden form-control" type="text" id="credit_charges" name="credit_charges" title="Credit card charges" disabled>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <select class="hidden form-control" id="identifier" onchange="get_credit_card_data('identifier','payment_mode','credit_card_details')" title="Identifier(4 digit)" required
                  ><option value=''>*Select Identifier</option></select>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <input class="hidden form-control" type="text" id="credit_card_details" name="credit_card_details" title="Credit card details" disabled>
                </div>
              </div>
              <div class="row mg_bt_10">
                <div class="col-md-4">
                  <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled>
                </div>
                <div class="col-md-4">
                  <input type="text" id="transaction_id" name="transaction_id" onchange="validate_balance(this.id)" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" disabled>
                </div>
                <div class="col-md-4">
                  <select name="bank_id" id="bank_id" title="Debitor Bank" class="form-control" disabled>
                    <?php get_bank_dropdown('Debitor Bank'); ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-9 col-sm-9">
                  <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note">Note : Please make sure Date, Amount, mode, Debitor bank entered properly.</span>
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
$('#cust_id_s').select2();
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
function pay_amount_nullify(advance_amount,advance_nullify)
{
  var advance_amount = $('#'+advance_amount).val();
  var advance_nullify = $('#'+advance_nullify).val();

  if(parseFloat(advance_amount) < parseFloat(advance_nullify)){ error_msg_alert("Amount to be nullify should not be more than advance amount"); return false; }
}

$(function(){
  $('#frm_sale_payment_save1').validate({
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
              var count = 0;
              var customer_id = $('#cust_id_s').val();
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
              var credit_note_amount =  $('#credit_note_amount').val();
              var credit_charges = $('#credit_charges').val();
              var credit_card_details = $('#credit_card_details').val();
              
              // Jquery check undefined value
              if(typeof advance_nullify === "undefined") { advance_nullify = '0'; }
              if(typeof advance_amount === "undefined") { advance_amount = '0'; }
              if(typeof credit_note_amount === '') { credit_note_amount = '0'; }
              if(advance_nullify == "") { advance_nullify = '0'; }

              if(parseFloat(credit_note_amount) < parseFloat(payment_amount)){ error_msg_alert("Low Credit note balance"); return false; }

              //Amount Validations
              if(parseFloat(total_purchase) == '0') { error_msg_alert("Atleast one booking is required!");
                    return false; }

              if(parseFloat(total_purchase) < parseFloat(advance_nullify)){ error_msg_alert("Amount to be nullify should be less or equal to the Total Purchase"); return false; }

              if(parseFloat(advance_amount) < parseFloat(advance_nullify)){ error_msg_alert("Amount to be nullify should not be more than Advance amount"); return false; }

              var total_payment_amount = parseFloat(payment_amount) + parseFloat(advance_nullify);

			        var payment_amount_arr = new Array();
              var purchase_type_arr = new Array();
              var purchase_id_arr = new Array();
              
              var temp_payment = parseFloat(payment_amount) + parseFloat(advance_nullify);

              var table = document.getElementById("tbl_list_sales");

              var rowCount = table.rows.length;
              for(var i=0; i<rowCount; i++)
              {
                var row = table.rows[i];               
                  if(row.cells[4].childNodes[0].checked){
                    var purchase_amount = row.cells[3].childNodes[0].value;   
                    var purchase_type = row.cells[1].childNodes[0].value;
                    var purchase_id = row.cells[2].childNodes[0].value;
                    
                    // Payment is equal to the purchase amount
                    if(parseFloat(temp_payment) == parseFloat(purchase_amount))  {    

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
                        url: base_url+'controller/tour_estimate/other_income/sales_payment_save.php',
                        data:{ customer_id : customer_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, branch_admin_id : branch_admin_id , emp_id : emp_id, advance_nullify : advance_nullify, total_payment_amount : total_payment_amount, total_purchase : total_purchase, payment_amount_arr : payment_amount_arr,purchase_type_arr : purchase_type_arr, purchase_id_arr : purchase_id_arr,credit_charges:credit_charges,credit_card_details:credit_card_details},
                        success: function(result){
                        $('#payment_save').button('reset');

                          var msg = result.split('-');
                          if(msg[0]=='error'){
                            msg_alert(result);
                          }
                          else{
                            reset_form('frm_sale_payment_save1'); 
                            msg_alert(result);
                            $('#s_payment_save_modal').modal('hide'); 
                          }
                          
                        }
                      });
                    }
                    else{
                      $('#payment_save').button('reset'); 
                    }
                  }

                });}
              });
                


      }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
