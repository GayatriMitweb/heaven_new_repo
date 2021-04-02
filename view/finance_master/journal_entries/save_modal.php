<?php
include_once("../../../model/model.php");
?>

<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Journal Entry</h4>
      </div>
      <div class="modal-body">  
  		<div class="panel panel-default panel-body app_panel_style feildset-panel">
  	     <legend>Account Debited</legend>	           
  	        <div class="row mg_bt_10"> <div class="col-md-12 text-right">
  	            <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_debited')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
  	            <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_debited')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
  	        </div> </div>		 
  	        <div class="row"> <div class="col-md-12"> <div class="table-responsive">
  	          <table id="tbl_debited" name="tbl_debited" class="table table-hover no-marg border_0 pd_bt_51">
  	              <tr>
  	                  <td class="col-md-1"><input id="chk_debit1" type="checkbox" checked></td>
  	                  <td class="col-md-2"><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
  	                  <td class="col-md-6"><select name="ledger_id1" id="ledger_id1" title="Ledger" class="app_select2" style="width:100%">                        	
  	                        <option value="">Select Ledger</option>
  	                        <?php
  	                        $sq_ledger = mysql_query("select * from ledger_master");
  	                        	while($row_ledger = mysql_fetch_assoc($sq_ledger)){
  	                        ?>
  	                        	<option value="<?= $row_ledger['ledger_id'] ?>"><?= $row_ledger['ledger_name'] ?></option>
  	                        <?php } ?>
  	                      </select>
  	                  </td>
  	                  <td class="col-md-3"><input type="text" id="amount" name="amount" placeholder="*Debit Amount" title="Debit Amount" onchange="validate_balance(this.id)"></td>
  	              </tr>                                
  	          </table> 
  	        </div> </div> </div>
  		</div>

  		<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
  	     <legend>Account Credited</legend>	 
  			<div class="row mg_bt_10"> <div class="col-md-12 text-right">
  	            <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_credited')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
  	            <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_credited')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
  	        </div> </div>

  	        <div class="row"> <div class="col-md-12"> <div class="table-responsive">
  	          <table id="tbl_credited" name="tbl_credited" class="table table-hover no-marg border_0 pd_bt_51">
  	              <tr>
  	                  <td class="col-md-1"><input id="chk_credit1" type="checkbox" checked></td>
  	                  <td class="col-md-2"><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
  	                  <td class="col-md-6"><select name="ledger_id2" id="ledger_id2" title="Ledger" class="app_select2" style="width:100%">                        	
  	                        <option value="">Select Ledger</option>
  	                        <?php
  	                        $sq_ledger = mysql_query("select * from ledger_master");
  	                        	while($row_ledger = mysql_fetch_assoc($sq_ledger)){
  	                        ?>
  	                        	<option value="<?= $row_ledger['ledger_id'] ?>"><?= $row_ledger['ledger_name'] ?></option>
  	                        <?php } ?>
  	                      </select>
  	                  </td>
  	                  <td class="col-md-3"><input type="text" id="amount" name="amount" placeholder="*Credit Amount" title="Credit Amount" onchange="validate_balance(this.id)"></td>
  	              </tr>                                
  	          </table> 
  	        </div> </div> </div>
          </div>
		<div class="row">
			<div class="col-md-3">
				<input type="text" id="entry_date" name="entry_date" placeholder="*Entry Date" title="Entry Date" value="<?= date('d-m-Y') ?>" onchange="check_valid_date(this.id)">
			</div>
			<div class="col-md-9">
				<TEXTAREA id="narration" name="narration" onchange="validate_specialChar(this.id);" placeholder="*Narration" title="Narration" rows="2"></TEXTAREA> 
			</div>
		</div>
        <div class="row mg_tp_10">
          <div class="col-md-12 text-center">
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
$('#ledger_id1,#ledger_id2').select2();
$('#entry_date').datetimepicker({timepicker:false, format:'d-m-Y'});

$('#frm_save').validate({
	 rules:{
            entry_date : { required : true },
            narration : { required : true },
     },
    submitHandler:function(form){

      var error_msg = "";
      var base_url = $('#base_url').val();
    	var entry_date = $('#entry_date').val();
    	var narration = $('#narration').val();

        //Debited Account
        var debit_ledger_id_arr = new Array();
        var debit_ledger_amt_arr = new Array();
        var total_debit = 0;

        var table = document.getElementById("tbl_debited");
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){
              var ledger_id = row.cells[2].childNodes[0].value;
              var amount = row.cells[3].childNodes[0].value;

              if(ledger_id==""){ error_msg_alert("Debit Ledger is required in row : "+(i+1)+"<br>"); return false; }
              if(amount==""){ error_msg_alert("Debit Amount is required in row : "+(i+1)+"<br>"); return false; }

              total_debit = parseFloat(total_debit)  + parseFloat(amount);
              debit_ledger_id_arr.push(ledger_id);
              debit_ledger_amt_arr.push(amount);
          }
        }
        if(debit_ledger_id_arr.length == 0){
          error_msg_alert("Select atleast one Debited account!");
          return false;
        }
        //Credited Account
        var credit_ledger_id_arr = new Array();
        var credit_ledger_amt_arr = new Array();
        var total_credit = 0;

        var table = document.getElementById("tbl_credited");
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){
              var ledger_id = row.cells[2].childNodes[0].value;
              var amount = row.cells[3].childNodes[0].value;

              if(ledger_id==""){ error_msg_alert("Credit Ledger is required in row : "+(i+1)+"<br>"); return false; }
              if(amount==""){ error_msg_alert("Credit Amount is required in row : "+(i+1)+"<br>"); return false; }

              total_credit = parseFloat(total_credit) + parseFloat(amount);
              credit_ledger_id_arr.push(ledger_id);
              credit_ledger_amt_arr.push(amount);
          }
        }
        if(credit_ledger_id_arr.length == 0){
          error_msg_alert("Select atleast one Credited account!");
          return false;
        }

      //Validation
      if(parseFloat(total_debit) != parseFloat(total_credit)){ error_msg_alert("Debit amount doesn't equal to Credit amount"); return false; }  

      $('#btn_save').button('loading');
      $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: entry_date }, function(data){
      if(data !== 'valid'){
        error_msg_alert("The Entry Date does not match between selected Financial year.");
        $('#btn_save').button('reset');
        return false;
      }
      else{
        $.ajax({
          type:'post',
          url:base_url+'controller/finance_master/journal_entry/journal_master_save.php',
          data:{  entry_date : entry_date, narration : narration, debit_ledger_id_arr : debit_ledger_id_arr,debit_ledger_amt_arr : debit_ledger_amt_arr,credit_ledger_id_arr : credit_ledger_id_arr,credit_ledger_amt_arr : credit_ledger_amt_arr },
          success:function(result){
              $('#btn_save').button('reset');
              var msg = result.split('--');
              msg_alert(result);
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

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>