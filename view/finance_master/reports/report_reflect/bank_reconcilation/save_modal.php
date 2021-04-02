<?php
include "../../../../../model/model.php";
$branch_admin_id = $_POST['branch_admin_id'];
?>
<form id="bank_frm_save">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="modal fade" id="bank_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Bank Reconciliation</h4>
      </div>
      <div class="modal-body">
          <div class="row mg_bt_20">
            <div class="col-md-4 col-sm-6">
              <select id="bank_id" name="bank_id" title="Select Bank" style="width: 100%;" onchange="get_bank_info(this.id);cal_reconcl_amount();">
                <option value="">Select Bank</option>
                <?php $query = mysql_query("Select * from bank_master where 1 ");
                while($row_query = mysql_fetch_assoc($query)){ ?>
                  <option value="<?= $row_query['bank_id'] ?>"><?= $row_query['bank_name'].'('.$row_query['branch_name'].')' ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div id="pending_cheque_div">
            
          </div>
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
          <legend>Bank Debits</legend>            
              <div class="row mg_bt_10"> <div class="col-md-12 text-right">
                  <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_bank_debited')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                  <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_bank_debited')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
              </div> </div>    
              <div class="row"> <div class="col-md-12"> <div class="table-responsive">
                <table id="tbl_bank_debited" name="tbl_bank_debited" class="table table-hover no-marg">
                    <tr>
                        <td><input id="chk_b_debit1" type="checkbox" checked onchange="cal_bank_dc_amount('tbl_bank_debited','total_d_amount');"></td>
                        <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                        <td class="col-md-3"><input type="text" id="debit_date1" class="app_datepicker" name="date" placeholder="<?= date('d-m-Y') ?>" title="Date">
                        </td>
                        <td class="col-md-6"><input type="text" id="debit_for" name="debit_for" onchange="validate_spaces(this.id);validate_specialChar(this.id);" placeholder="Bank Debits For" title="Bank Debits For">
                        </td>
                        <td class="col-md-3"><input type="text" id="amount" name="amount" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id);cal_bank_dc_amount('tbl_bank_debited','total_d_amount')"></td>
                    </tr>                                
                </table> 
              </div> </div> </div>
              <div class="row mg_tp_10">
                <div class="col-md-3 col-md-offset-9 col-sm-6">
                  <input type="text" id="total_d_amount" style="font-weight: bold;" name="total_d_amount" class="form-control" value="0.00" class="text-right" readonly>  
                </div>
              </div>
          </div>

          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
          <legend>Bank Credits</legend>   
            <div class="row mg_bt_10"> <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_bank_credited')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                    <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_bank_credited')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
            </div> </div>
            <div class="row"> <div class="col-md-12"> <div class="table-responsive">
              <table id="tbl_bank_credited" name="tbl_bank_credited" class="table table-hover no-marg">
                  <tr>
                      <td><input id="chk_b_credit1" type="checkbox" checked  onchange="cal_bank_dc_amount('tbl_bank_credited','total_c_amount');"></td>
                      <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                      <td class="col-md-3"><input type="text" id="credit_date1"  class="app_datepicker" name="date" placeholder="<?= date('d-m-Y') ?>" title="Date">
                      </td>
                      <td class="col-md-6"><input type="text" id="credit_for" onchange="validate_spaces(this.id);validate_specialChar(this.id);" name="credit_for" placeholder="Bank Credits For" title="Bank Credits For">
                      </td>
                      <td class="col-md-3"><input type="text" id="amount" name="amount" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id);cal_bank_dc_amount('tbl_bank_credited','total_c_amount')"></td>
                  </tr>                                
              </table> 
            </div> </div> </div>
              <div class="row mg_tp_10">
                <div class="col-md-3 col-md-offset-9 col-sm-6">
                  <input type="text" id="total_c_amount" style="font-weight: bold;" name="total_c_amount" class="form-control" value="0.00" class="text-right" readonly>  
                </div>
              </div>
          </div>
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">  
            <div class="row">
              <div class="col-sm-4">
                   <label><b>Reconciliation Amount</b></label>
              </div>
              <div class="col-sm-3">
                   <input type="text" id="reconcl_amount" name="reconcl_amount" value="0" title="Reconciliation Amount" readonly>
              </div>
            </div>
            <div class="row mg_tp_10">
              <div class="col-sm-4">
                <label><b>Balance as per Bank Books</b></label>
              </div>
              <div class="col-sm-3">
                <input type="text" id="txt_bank_book" onchange="validate_balance(this.id)" name="txt_bank_book" placeholder="0.00" onchange="cal_reconcl_amount();" title="Balance as per Bank Books">
              </div>
            </div>
            <div class="row mg_tp_10">
              <div class="col-sm-4">
                <label><b>Difference after Reconciliation</b></label>
              </div>
              <div class="col-sm-3 mg_bt_10_sm_xs">
                <input type="text" id="txt_rec_diff" name="txt_rec_diff" value="0.00" title="Difference after Reconciliation" readonly>
              </div>
            </div>
          </div>      
          <div class="row text-center mg_bt_10">
            <div class="col-md-12">
              <button id="btn_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
            </div>
          </div>
        </div>   
    </div>
  </div>
</div>

</form>

<script>

$('#bank_save_modal').modal('show');
$('#bank_id').select2();
$('#debit_date1,#credit_date1').datetimepicker({ timepicker:false, format:'d-m-Y' }); 
function get_cash_ledger_amount()
{
  var branch_admin_id = $('#branch_admin_id1').val();
  $.post('report_reflect/cash_reconcilation/get_cash_ledger_amount.php',{ branch_admin_id : branch_admin_id }, function(data){
    $('#txt_system_cash').val(data);
  });
}
get_cash_ledger_amount();
$('#bank_frm_save').validate({
    rules:{
            txt_bank_book : { required : true },
            txt_system_bank : { required : true },
    },

    submitHandler:function(){
        var branch_admin_id = $('#branch_admin_id1').val();
        var bank_id = $('#bank_id').val();
        var bank_book_amount = $('#txt_bank_book').val();
        var system_bank_amount = $('#txt_system_bank').val();
        var reconcl_amount = $('#reconcl_amount').val();
        var diff_amount = $('#txt_rec_diff').val();        
         
        //Cheque Deposited  
        var depos_date_arr = new Array();
        var depos_chq_arr = new Array();
        var depos_sale_arr = new Array();
        var depos_saleid_arr = new Array();
        var depos_amount_arr = new Array();
        var total_depos = 0;
        //Check if exist 
        if($('#tbl_rec_list').length)
        {
          var table = document.getElementById("tbl_rec_list");
          var rowCount = table.rows.length;
          for(var i=0; i<rowCount; i++)
          {
              var row = table.rows[i];
              if(typeof row.cells[1].childNodes[0].value != 'undefined'){ var date = row.cells[1].childNodes[0].value; }
              if(typeof row.cells[2].childNodes[0].value != 'undefined'){ var cheque_no = row.cells[2].childNodes[0].value; }
              if(typeof row.cells[3].childNodes[0].value != 'undefined'){ var sale = row.cells[3].childNodes[0].value; }
              if(typeof row.cells[4].childNodes[0].value != 'undefined'){ var sale_id = row.cells[4].childNodes[0].value; }
              if(typeof row.cells[5].childNodes[0].value != 'undefined'){ var amount = row.cells[5].childNodes[0].value; }                                      
              
              if(typeof row.cells[1].childNodes[0].value != 'undefined'){ depos_date_arr.push(date); }
              if(typeof row.cells[2].childNodes[0].value != 'undefined'){ depos_chq_arr.push(cheque_no); }
              if(typeof row.cells[3].childNodes[0].value != 'undefined'){ depos_sale_arr.push(sale); }
              if(typeof row.cells[4].childNodes[0].value != 'undefined'){ depos_saleid_arr.push(sale_id); }
              if(typeof row.cells[5].childNodes[0].value != 'undefined'){ depos_amount_arr.push(amount); 
               total_depos = parseFloat(total_depos) + parseFloat(amount); }
           }
        }
        //Cheque Payment 
        var pay_date_arr = new Array();
        var pay_chq_arr = new Array();
        var pay_sale_arr = new Array();
        var pay_saleid_arr = new Array();
        var pay_amount_arr = new Array();
        var total_pay = 0;
        //Check if exist 
        if($('#tbl_payment_list').length)
        {
          var table = document.getElementById("tbl_payment_list");
          var rowCount = table.rows.length;
          for(var i=0; i<rowCount; i++)
          {
            var row = table.rows[i];
            if(typeof row.cells[1].childNodes[0].value != 'undefined'){var date = row.cells[1].childNodes[0].value; }
            if(typeof row.cells[2].childNodes[0].value != 'undefined'){var cheque_no = row.cells[2].childNodes[0].value; }
            if(typeof row.cells[3].childNodes[0].value != 'undefined'){var sale = row.cells[3].childNodes[0].value; }
            if(typeof row.cells[4].childNodes[0].value != 'undefined'){var sale_id = row.cells[4].childNodes[0].value; }
            if(typeof row.cells[5].childNodes[0].value != 'undefined'){var amount = row.cells[5].childNodes[0].value; }
            
            if(typeof row.cells[1].childNodes[0].value != 'undefined'){ pay_date_arr.push(date); } 
            if(typeof row.cells[2].childNodes[0].value != 'undefined'){ pay_chq_arr.push(cheque_no); } 
            if(typeof row.cells[3].childNodes[0].value != 'undefined'){ pay_sale_arr.push(sale); }
            if(typeof row.cells[4].childNodes[0].value != 'undefined'){ pay_saleid_arr.push(sale_id); }
            if(typeof row.cells[5].childNodes[0].value != 'undefined'){ pay_amount_arr.push(amount); 
              total_pay = parseFloat(total_pay) + parseFloat(amount); }
           }
         }

        //Bank Debited
        var debit_date_arr = new Array();
        var debit_for_arr = new Array();
        var debit_amount_arr = new Array();
        var total_debit = 0;

        var table = document.getElementById("tbl_bank_debited");
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++)
        {
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked)
          {  
              var date = row.cells[2].childNodes[0].value;
              var debit_for = row.cells[3].childNodes[0].value;
              var amount = row.cells[4].childNodes[0].value;

              if(date==""){ error_msg_alert("Bank Debit Date is required in row : "+(i+1)+"<br>"); return false;}
              if(debit_for==""){ error_msg_alert("Bank Debit For is required in row : "+(i+1)+"<br>"); return false; }
              if(amount==""){ error_msg_alert("Bank Debit Amount is required in row : "+(i+1)+"<br>"); return false;}

              total_debit = parseFloat(total_debit) + parseFloat(amount);
              debit_date_arr.push(date);
              debit_for_arr.push(debit_for);
              debit_amount_arr.push(amount);
          }

         }

        //Bank Credited
        var credit_date_arr = new Array();
        var credit_for_arr = new Array();
        var credit_amount_arr = new Array();
        var total_credit = 0;

        var table = document.getElementById("tbl_bank_credited");
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++)
        {
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked)
          {  
              var date = row.cells[2].childNodes[0].value;
              var credit_for = row.cells[3].childNodes[0].value;
              var amount = row.cells[4].childNodes[0].value;

              if(date==""){ error_msg_alert("Bank Credit Date is required in row : "+(i+1)+"<br>"); return false;}
              if(credit_for==""){ error_msg_alert("Bank Credit For is required in row : "+(i+1)+"<br>"); return false;}
              if(amount==""){ error_msg_alert("Bank Credit Amount is required in row : "+(i+1)+"<br>"); return false;}

              total_credit = parseFloat(total_credit) + parseFloat(amount);
              credit_date_arr.push(date);
              credit_for_arr.push(credit_for);
              credit_amount_arr.push(amount);
          }

         }
 
            $('#btn_save').button('loading');

            $.ajax({

              type: 'post',

              url: base_url()+'controller/finance_master/reports/bank_reconciliation/recl_master_save.php',

              data:{ branch_admin_id : branch_admin_id, bank_id : bank_id,  bank_book_amount : bank_book_amount, system_bank_amount : system_bank_amount, reconcl_amount : reconcl_amount , diff_amount : diff_amount ,  debit_date_arr : debit_date_arr , debit_for_arr : debit_for_arr, debit_amount_arr : debit_amount_arr,total_debit : total_debit,credit_date_arr : credit_date_arr,credit_for_arr : credit_for_arr,credit_amount_arr : credit_amount_arr,total_credit : total_credit,depos_date_arr : depos_date_arr,depos_chq_arr : depos_chq_arr, depos_sale_arr : depos_sale_arr,depos_saleid_arr : depos_saleid_arr,depos_amount_arr : depos_amount_arr,total_depos : total_depos,pay_date_arr : pay_date_arr,pay_chq_arr : pay_chq_arr,pay_sale_arr : pay_sale_arr, pay_saleid_arr : pay_saleid_arr,pay_amount_arr : pay_amount_arr,total_pay : total_pay },

              success: function(result){
                $('#btn_save').button('reset');
                msg_alert(result);
                $('#bank_save_modal').modal('hide');
                report_reflect();
              }

            });
    }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>