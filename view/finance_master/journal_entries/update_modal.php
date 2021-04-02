<?php
include "../../../model/model.php";

$entry_id = $_POST['entry_id'];

$sq_journal = mysql_fetch_assoc(mysql_query("select * from journal_entry_master where entry_id='$entry_id'"));
?>
<form id="frm_update">
<input type="hidden" id="entry_id" name="entry_id" value="<?= $entry_id ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update journal Entry</h4>
      </div>
      <div class="modal-body">
          <div class="panel panel-default panel-body app_panel_style feildset-panel">
             <legend>Account Debited</legend>    
                <div class="row"> <div class="col-md-12"> <div class="table-responsive">
                  <table id="tbl_debited" name="tbl_debited" class="table table-hover no-marg border_0">
                  <?php
                       $count = 1; 
                       $debit_query = mysql_query("select * from journal_entry_accounts where entry_id='$sq_journal[entry_id]' and type='Debit'");
                        while($row_debit = mysql_fetch_assoc($debit_query)){
                  ?>
                          <tr>
                              <td class="col-md-1"><input id="chk_debit<?= $count ?>" type="checkbox" checked disabled></td>
                              <td class="col-md-2"><input maxlength="15" value="<?= $count ?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                              <td class="col-md-6"><select name="ledger_id<?= $count ?>" id="ledger_id<?= $count ?>" title="Ledger" class="app_select2" style="width:100%" disabled>    
                                    <?php
                                    $sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_debit[ledger_id]'"));
                                    ?>
                                      <option value="<?= $sq_ledger['ledger_id'] ?>"><?= $sq_ledger['ledger_name'] ?></option>
                                  </select>
                              </td>
                              <td class="col-md-3"><input type="text" id="amount<?= $count ?>" name="amount<?= $count ?>" placeholder="*Debit Amount" title="Debit Amount" onchange="validate_balance(this.id)" value="<?= ($row_debit['amount']) ?>"></td>
                              <td class="hidden"><input type="hidden" id="old_amount<?= $count ?>" name="old_amount<?= $count ?>" placeholder="*Debit Amount" title="Debit Amount" value="<?= ($row_debit['amount']) ?>"></td>
                              <td class="hidden"><input type="text" name="entry_id" value="<?= ($row_debit['acc_id']) ?>"></td>
                          </tr>    
                    <?php $count++; } ?>                       
                  </table> 
                </div> </div> </div>
          </div>

          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
             <legend>Account Credited</legend>   
                <div class="row"> <div class="col-md-12"> <div class="table-responsive">
                  <table id="tbl_credited" name="tbl_credited" class="table table-hover no-marg border_0">
                  <?php
                       $count = 1; 
                       $credit_query = mysql_query("select * from journal_entry_accounts where entry_id='$sq_journal[entry_id]' and type='Credit'");
                        while($row_credit = mysql_fetch_assoc($credit_query)){
                  ?>
                      <tr>
                          <td class="col-md-1"><input id="chk_credit<?= $count ?>" type="checkbox" checked disabled></td>
                          <td class="col-md-2"><input maxlength="15" value="<?= $count ?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                          <td class="col-md-6"><select name="ledger_id<?= $count ?>" id="ledger_id<?= $count ?>" title="Ledger" class="app_select2" style="width:100%" disabled>                     
                          <?php
                              $sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_credit[ledger_id]'"));
                              ?>
                                <option value="<?= $sq_ledger['ledger_id'] ?>"><?= $sq_ledger['ledger_name'] ?></option>
                              </select>
                          </td>
                          <td class="col-md-3"><input type="text" id="amount<?= $count ?>" onchange="validate_balance(this.id)"  name="amount<?= $count ?>" placeholder="*Credit Amount" title="Credit Amount" value="<?= ($row_credit['amount']) ?>"></td>
                          <td class="hidden"><input type="hidden" id="old_amount<?= $count ?>" name="old_amount<?= $count ?>" placeholder="*Credit Amount" title="Credit Amount" value="<?= ($row_credit['amount']) ?>"></td>
                          <td class="hidden"><input type="text" name="entry_id" value="<?= ($row_credit['acc_id']) ?>"></td>
                      </tr>    
                    <?php $count++; } ?>                              
                  </table> 
                </div> </div> </div>
              </div>
          <div class="row">
            <div class="col-md-3">
              <input type="text" id="entry_date" name="entry_date" title="Entry Date" value="<?= get_date_user($sq_journal['entry_date']) ?>" readonly>
            </div>
            <div class="col-md-9">
              <TEXTAREA id="narration" name="narration" onchange="validate_specialChar(this.id);" placeholder="*Narration" title="Narration" rows="2"><?= $sq_journal['narration'] ?></TEXTAREA> 
            </div>
          </div>

          <div class="row mg_tp_20 text-center">
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

$('#frm_update').validate({
    rules:{
            narration : { required : true },          
    },
    submitHandler:function(form){

        var error_msg = "";
        var entry_id = $('#entry_id').val();
        var entry_date = $('#entry_date').val();
        var narration = $('#narration').val();

        //Debited Account
        var debit_ledger_id_arr = new Array();
        var debit_ledger_amt_arr = new Array();
        var debit_old_amt_arr = new Array();
        var entry_id_arr1 = new Array();
        var total_debit = 0;
        var total_old_debit = 0;

        var table = document.getElementById("tbl_debited");
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++)
        {
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked)
          {  
              var ledger_id = row.cells[2].childNodes[0].value;
              var amount = row.cells[3].childNodes[0].value;
              var old_amount = row.cells[4].childNodes[0].value;
              var entry_id1 = row.cells[5].childNodes[0].value;

              if(ledger_id==""){ error_msg +="Debit Ledger is required in row : "+(i+1)+"<br>"; }
              if(amount==""){ error_msg +="Debit Amount is required in row : "+(i+1)+"<br>"; }

              total_debit = parseFloat(total_debit)  + parseFloat(amount);
              total_old_debit = parseFloat(total_old_debit)  + parseFloat(old_amount);

              debit_ledger_id_arr.push(ledger_id);
              debit_ledger_amt_arr.push(amount);
              debit_old_amt_arr.push(old_amount);
              entry_id_arr1.push(entry_id1);
          }

         }

        //Credited Account
        var credit_ledger_id_arr = new Array();
        var credit_ledger_amt_arr = new Array();
        var credit_old_amt_arr = new Array();
        var entry_id_arr2 = new Array();
        var total_credit = 0;
        var total_old_credit = 0;

        var table = document.getElementById("tbl_credited");
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++)
        {
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked)
          {  
              var ledger_id = row.cells[2].childNodes[0].value;
              var amount = row.cells[3].childNodes[0].value;
              var old_amount = row.cells[4].childNodes[0].value;
              var entry_id2 = row.cells[5].childNodes[0].value;

              if(ledger_id==""){ error_msg +="Credit Ledger is required in row : "+(i+1)+"<br>"; }
              if(amount==""){ error_msg +="Credit Amount is required in row : "+(i+1)+"<br>"; }

              total_credit = parseFloat(total_credit) + parseFloat(amount);
              total_old_credit = parseFloat(total_old_credit)  + parseFloat(old_amount);
              credit_ledger_id_arr.push(ledger_id);
              credit_ledger_amt_arr.push(amount);
              credit_old_amt_arr.push(old_amount);
              entry_id_arr2.push(entry_id2);
          }

         }

        //Validation
        if(parseFloat(total_debit) != parseFloat(total_credit)){ error_msg = "Can not update amount else make it 0"; }  
        
        if(parseFloat(total_debit) != parseFloat(total_old_debit) && parseFloat(total_debit) != '0'){
          error_msg = "Can not update amount else make it 0";
        }
        if(parseFloat(total_credit) != parseFloat(total_old_credit) && parseFloat(total_credit) != '0'){
          error_msg = "Can not update amount else make it 0";
        }
          if(error_msg!=""){
            error_msg_alert(error_msg);
            return false;
          }
        
         

        $('#btn_update').button('loading');

        $.ajax({
          type:'post',
          url:base_url()+'controller/finance_master/journal_entry/journal_master_update.php',
          data:{ entry_id : entry_id, entry_date : entry_date, narration : narration, debit_ledger_id_arr : debit_ledger_id_arr,debit_ledger_amt_arr : debit_ledger_amt_arr,credit_ledger_id_arr : credit_ledger_id_arr,credit_ledger_amt_arr : credit_ledger_amt_arr,debit_old_amt_arr : debit_old_amt_arr,credit_old_amt_arr : credit_old_amt_arr,entry_id_arr1 : entry_id_arr1,entry_id_arr2 : entry_id_arr2  },
          success:function(result){
              $('#btn_update').button('reset');
              var msg = result.split('--');
              msg_alert(result);
              if(msg[0]!="error"){
                $('#update_modal').modal('hide');
                list_reflect();
              }
          }
        });



    }
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>