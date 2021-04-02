<?php
include "../../../../../model/model.php";
$branch_admin_id = $_POST['branch_admin_id'];
?>
<form id="cash_frm_save">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="modal fade" id="cash_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cash Reconciliation</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-4 mg_bt_10_xs">
              <span class="main_block" data-original-title="" title="">
              <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
              <label>Date of Reconciliation : </label> </span>
              <input type="text" id="txt_date" name="txt_date" value="<?= date('d-m-Y') ?>" readonly class="form-control valid" data-original-title="Date of Reconciliation" aria-invalid="false">
            </div> 
            <div class="col-md-4 col-sm-6 mg_bt_10_xs">
              <span class="main_block">
                <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                <label>Cash as per system : </label> </span>
              <input type="text" id="txt_system_cash" name="txt_system_cash" title="Cash as per system" readonly>
            </div>
          </div>
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">  
          <div class="row">            
            <div class="col-md-4 col-sm-6 mg_bt_10_xs">
              <span class="main_block">
                <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                <label>Cash as per till : </label> </span>
              <input type="text" id="txt_till_cash" name="txt_till_cash" title="Cash as per tills" readonly>
            </div>
          </div>
          <div class="row text-center mg_tp_20">
            <div class="col-md-12 no-pad">
              <table class="table table-hover" id="tbl_denom_list" style="margin: 0 !important;">
                <thead>
                  <tr class="table-heading-row">
                    <th>Denominations</th>
                    <th>Numbers</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td><input type="text" id="denom_1" name="denom_1" value="2000" class="text-right" readonly></td>
                      <td><input type="text" id="number_1" name="number_1" class="text-right" onchange="validate_balance(this.id);cal_denomination_amount('1');"></td>
                      <td><input type="text" id="amount_1" name="amount_1" class="text-right" readonly></td>
                    </tr>
                    <tr>
                      <td><input type="text" id="denom_2" name="denom_2" value="1000" class="text-right" readonly></td>
                      <td><input type="text" id="number_2" name="number_2" class="text-right" onchange="validate_balance(this.id);cal_denomination_amount('2');"></td>
                      <td><input type="text" id="amount_2" name="amount_2" class="text-right" readonly></td>
                      
                    </tr>
                    <tr>
                      <td><input type="text" id="denom_3" name="denom_3" value="500" class="text-right" readonly></td>
                      <td><input type="text" id="number_3" name="number_3" class="text-right" onchange="validate_balance(this.id);cal_denomination_amount('3');"></td>
                      <td><input type="text" id="amount_3" name="amount_3" class="text-right" readonly></td>
                    
                    </tr>
                    <tr>
                      <td><input type="text" id="denom_4" name="denom_4" value="200" class="text-right" readonly></td>
                      <td><input type="text" id="number_4" name="number_4" class="text-right" onchange="validate_balance(this.id);cal_denomination_amount('4');"></td>
                      <td><input type="text" id="amount_4" name="amount_4" class="text-right" readonly></td>
                     
                    </tr>
                    <tr>
                       <td><input type="text" id="denom_5" name="denom_5" value="100" class="text-right" readonly></td>
                      <td><input type="text" id="number_5" name="number_5" class="text-right" onchange="cal_denomination_amount('5');"></td>
                      <td><input type="text" id="amount_5" name="amount_5" class="text-right" readonly></td>
                    </tr>
                    <tr>
                      <td><input type="text" id="denom_6" name="denom_6" value="50" class="text-right" readonly></td>
                      <td><input type="text" id="number_6" name="number_6" class="text-right" onchange="validate_balance(this.id);cal_denomination_amount('6');"></td>
                      <td><input type="text" id="amount_6" name="amount_6" class="text-right" readonly></td>
                    </tr>
                    <tr>
                      <td><input type="text" id="denom_7" name="denom_7" class="text-right" value="20" readonly></td>
                      <td><input type="text" id="number_7" name="number_7" class="text-right" onchange="validate_balance(this.id);cal_denomination_amount('7');"></td>
                      <td><input type="text" id="amount_7" name="amount_7" class="text-right" readonly></td>
                    </tr>
                    <tr>
                      <td><input type="text" id="denom_8" name="denom_8" class="text-right" value="10" readonly></td>
                      <td><input type="text" id="number_8" name="number_8" class="text-right" onchange="validate_balance(this.id);cal_denomination_amount('8');"></td>
                      <td><input type="text" id="amount_8" name="amount_8" class="text-right" readonly></td>
                    </tr>
                    <tr>
                      <td><input type="text" id="denom_9" name="denom_9" value="5" class="text-right" readonly></td>
                      <td><input type="text" id="number_9" name="number_9" class="text-right" onchange="validate_balance(this.id);cal_denomination_amount('9');"></td>
                      <td><input type="text" id="amount_9" name="amount_9" class="text-right" readonly></td>
                    </tr>
                    <tr>
                      <td><input type="text" id="denom_10" name="denom_10" value="2" class="text-right" readonly></td>
                      <td><input type="text" id="number_10" name="number_10" class="text-right" onchange="validate_balance(this.id);cal_denomination_amount('10');"></td>
                      <td><input type="text" id="amount_10" name="amount_10" class="text-right" readonly></td>
                    </tr>
                    <tr>
                      <td><input type="text" id="denom_11" name="denom_11" value="1" class="text-right" readonly></td>
                      <td><input type="text" id="number_11" name="number_11" class="text-right" onchange="validate_balance(this.id);cal_denomination_amount('11');"></td>
                      <td><input type="text" id="amount_11" name="amount_11" class="text-right" readonly></td>
                    </tr>                   
                </tbody>
              </table>  
            </div> 
            </div>
            </div>
            <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">  
              <div class="row">
                <div class="col-sm-4 mg_bt_10">
                     <label><b>Difference prior to Reconciliation</b></label>
                </div>
                <div class="col-sm-3 mg_bt_10">
                     <input type="text" id="txt_diff" name="txt_diff" value="0" title="Difference prior to Reconciliation" readonly>
                </div>
                <div class="col-sm-4 mg_bt_10">
                     <em id="reconc_result" style="color: red;"></em>
                </div>
              </div>
            </div>
            <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">            
              <legend>Reconciliation</legend>
              <div class="row mg_tp_10">
                <div class="col-sm-6 mg_bt_10_sm_xs">
                <input type="text" id="reason1" value="Amount of entries pending in the system" readonly />
                </div>
                <div class="col-sm-4 mg_bt_10_sm_xs">
                  <input type="text" id="reason_amount1" name="reason_amount1" placeholder="Ex.500" title="Amount" onchange="validate_balance(this.id);cal_reconcil_amount();">
                </div>
              </div>
              <div class="row mg_tp_10">
                <div class="col-sm-6 mg_bt_10_sm_xs">
                  <input type="text" id="reason2" value="Amount of entries passed excessively in the system" readonly/>
                </div>
                <div class="col-sm-4 mg_bt_10_sm_xs">
                  <input type="text" id="reason_amount2" name="reason_amount2" placeholder="Ex.500" title="Amount" onchange="validate_balance(this.id);cal_reconcil_amount();">
                </div>
              </div>
              <div class="row mg_tp_10">
                <div class="col-sm-6 mg_bt_10_sm_xs">
                 <input type="text" id="reason3" value="Cash Deposited in Bank and yet to be recorded" readonly/>
                </div>
                <div class="col-sm-4 mg_bt_10_sm_xs">
                  <input type="text" id="reason_amount3" name="reason_amount3" placeholder="Ex.500" title="Amount" onchange="validate_balance(this.id);cal_reconcil_amount();">
                </div>
              </div>
              <div class="row mg_tp_10">
                <div class="col-sm-6 mg_bt_10_sm_xs">
                 <input type="text" id="reason4" value="Cash withdrawn from bank and yet to be recorded" readonly/>
                </div>
                <div class="col-sm-4 mg_bt_10_sm_xs">
                  <input type="text" id="reason_amount4" name="reason_amount4" placeholder="Ex.500" title="Amount" onchange="validate_balance(this.id);cal_reconcil_amount();">
                </div>
              </div>
              <div class="row mg_tp_10">
                <div class="col-sm-6 mg_bt_10_sm_xs">
                 <textarea id="reason5" name="reason5" onchange="validate_spaces(this.id)" placeholder="Any other Remarks(if positive)"></textarea>
                </div>
                <div class="col-sm-4 mg_bt_10_sm_xs">
                  <input type="text" id="reason_amount5" name="reason_amount5" placeholder="Ex.500" title="Amount" onchange="validate_balance(this.id);cal_reconcil_amount();">
                </div>
              </div>
              <div class="row mg_tp_10">
                <div class="col-sm-6 mg_bt_10_sm_xs">
                 <textarea id="reason6" name="reason6"  onchange="validate_spaces(this.id)" placeholder="Any other Remarks(if negative)"></textarea>
                </div>
                <div class="col-sm-4 mg_bt_10_sm_xs">
                  <input type="text" id="reason_amount6" name="reason_amount6" placeholder="Ex.500" title="Amount" onchange="validate_balance(this.id);cal_reconcil_amount();">
                </div>
              </div>
            </div>
            <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">  
               <div class="row mg_tp_10">
                <div class="col-sm-6 mg_bt_10_sm_xs">
               <p><b>Reconciliation Amount</b></p>
              </div>
                <div class="col-sm-4 mg_bt_10_sm_xs">
                  <input type="text" id="txt_rec_amt" name="txt_rec_amt" placeholder="0.00" title="Amount" readonly>
                </div>
              </div>
               <div class="row mg_tp_10">
                <div class="col-sm-6 mg_bt_10_sm_xs">
               <p><b>Difference after Reconciliation</b></p>
              </div>
                <div class="col-sm-4 mg_bt_10_sm_xs">
                  <input type="text" id="txt_rec_diff" name="txt_rec_diff" placeholder="0.00" title="Amount" readonly>
                </div>
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

$('#cash_save_modal').modal('show');
$('#emp_id_filter, #year_filter').select2();

function get_cash_ledger_amount()
{
  var branch_admin_id = $('#branch_admin_id1').val();
  $.post('report_reflect/cash_reconcilation/get_cash_ledger_amount.php',{ branch_admin_id : branch_admin_id }, function(data){
    $('#txt_system_cash').val(data);
  });
}
get_cash_ledger_amount();
$('#cash_frm_save').validate({
    rules:{
            system_cash : { required : true },
    },

    submitHandler:function(){
        var branch_admin_id = $('#branch_admin_id1').val();
        var date = $('#txt_date').val();
        var system_cash = $('#txt_system_cash').val();
        var till_cash = $('#txt_till_cash').val();
        var diff_prior = $('#txt_diff').val();
        var reconcl_amount = $('#txt_rec_amt').val();
        var diff_reconcl = $('#txt_rec_diff').val();

        //Denomination table
        var denom_amount_arr = new Array();
        var numbers_arr = new Array();
        var total_amount_arr = new Array();
        for(var i=1;i<=11;i++){
          var numbers = $('#number_'+i).val();
          if(numbers != '')
          {
              var denom_amount = $('#denom_'+i).val();
              var numbers = $('#number_'+i).val();
              var total_amount = $('#amount_'+i).val();
              
              denom_amount_arr.push(denom_amount);
              numbers_arr.push(numbers);
              total_amount_arr.push(total_amount);            
            }      
          }

        //Reasons(6)
        var reason_amount_arr = new Array();
        var reason_arr = new Array();
        for(var j=1 ;j<=6;j++)
        {
          var reason_amount = $('#reason_amount'+j).val();
          if(reason_amount != '')
          {
            var reason = $('#reason'+j).val();
            var reason_amount = $('#reason_amount'+j).val();

            reason_arr.push(reason);
            reason_amount_arr.push(reason_amount);        
          }      
        }
 
            $('#btn_save').button('loading');

            $.ajax({

              type: 'post',

              url: base_url()+'controller/finance_master/reports/cash_reconciliation/recl_master_save.php',

              data:{ branch_admin_id : branch_admin_id, date : date,  system_cash : system_cash, till_cash : till_cash, diff_prior : diff_prior, reconcl_amount : reconcl_amount , diff_reconcl : diff_reconcl ,  denom_amount_arr : denom_amount_arr , numbers_arr : numbers_arr, total_amount_arr : total_amount_arr,reason_arr : reason_arr,reason_amount_arr : reason_amount_arr },

              success: function(result){
                $('#btn_save').button('reset');
                msg_alert(result);
                $('#cash_save_modal').modal('hide');
                report_reflect();
              }

            });



    }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>