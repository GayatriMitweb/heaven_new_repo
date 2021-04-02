<?php
include_once("../../../model/model.php");
$entry_id = $_POST['entry_id'];
$type = $_POST['type'];
?>
<input type="hidden" id="modal_type" name="modal_type">
<div class="modal fade" id="taxes_save_modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Tax Rule</h4>
      </div>
      <div class="modal-body">
        <form id="frm_tax_rules_save">
          <div class="row mg_bt_10">
          <?php if($type != "rule_master"){ ?>
              <input type="hidden" id="tentry_id" value="<?= $entry_id ?>"/>
          <?php }else{ ?>
            <div class="col-md-3 col-sm-6">
                <select name="tentry_id" id="tentry_id" title="Select Tax" data-toggle="tooltip" onchange="t_list_reflect()" style="width:100%" class='form-control'>
                    <option value="">Select Tax</option>
                    <?php 
                    $sq = mysql_query("select * from tax_master where status!='Inactive'");
                    while($row_taxes = mysql_fetch_assoc($sq))
                    {
                        $rate = ($row_taxes['rate_in'] == "Percentage") ? $row_taxes['rate'].'(%)': $row_taxes['rate'];
                        $string = $row_taxes['name'].'-'.$rate;
                    ?>
                    <option value="<?= $row_taxes['entry_id']?>"><?= $string ?></option>
                    <?php } ?>
                </select>
            </div>
            <?php } ?>
          </div>
          <div class="row mg_bt_10"> 
              <div class="col-md-3">
                  <input type="text" placeholder="*Name" title="Name" id="name"  class="form-control" required />
              </div>
              <div class="col-md-3">
                  <select name="validity" id="validity" data-toggle="tooltip" class="form-control" title="*Validity" onchange="check_validity(this.id);" required>
                      <option value="">*Validity</option>
                      <option value="Period">Period</option>
                      <option value="Permanent">Permanent</option>
                  </select>
              </div>
              <div class="col-md-3">
                  <input type="text" placeholder="From Date" title="From Date" id="from_date"  class="form-control" onchange="get_to_date(this.id,'to_date')" />
              </div>
              <div class="col-md-3">
                  <input type="text" placeholder="To Date" title="To Date" id="to_date"  class="form-control" onchange="validate_validDate('from_date','to_date')" />
              </div>
          </div>
          <div class="row"> 
              <div class="col-md-3">
                  <select name="ledger" id="ledger" data-toggle="tooltip" class="form-control" title="*Select Ledger" style="width:100%" required>
                      <option value="">*Select Ledger</option>
                      <?php
                      $sq_group = mysql_query("select subgroup_id,subgroup_name from subgroup_master");
                      while($row_group = mysql_fetch_assoc($sq_group)){ ?>
                      <optgroup value="<?= $row_group['subgroup_id'] ?>" label="<?= $row_group['subgroup_name'] ?>">
                      <?php
                      $query = mysql_query("select ledger_id,ledger_name from ledger_master where group_sub_id='$row_group[subgroup_id]'");
                      while($row_ledger = mysql_fetch_assoc($query)){
                        ?>
                          <option value="<?= $row_ledger['ledger_id'] ?>"><?= $row_ledger['ledger_name'] ?></option>
                      <?php } ?>
                      </optgroup>
                      <?php } ?>
                  </select>
              </div>
              <div class="col-md-3">
                  <select name="travel_type" id="travel_type" data-toggle="tooltip" class="form-control" title="Travel Type" style="width:100%" required>
                      <option value="">*Travel Type</option>
                      <option value="All">All</option>
                      <option value="Group Tour">Group Tour</option>
                      <option value="Package Tour">Package Tour</option>
                      <option value="Hotel">Hotel</option>
                      <option value="Flight">Flight</option>
                      <option value="Train">Train</option>
                      <option value="Visa">Visa</option>
                      <option value="Bus">Bus</option>
                      <option value="Car Rental">Car Rental</option>
                      <option value="Activity">Activity</option>
                      <option value="Miscellaneous">Miscellaneous</option>
                      <option value="Forex">Forex</option>
                      <option value="Passport">Passport</option>
                  </select>
              </div>
              <div class="col-md-3">
                  <select name="calc_mode" id="calc_mode" data-toggle="tooltip" class="form-control" onchange="target_amount_change(this.id,'save');inclusive_checker();" title="Calculation Mode" required>
                      <option value="">*Calculation Mode</option>
                      <option value="Inclusive">Inclusive</option>
                      <option value="Exclusive">Exclusive</option>
                  </select>
              </div>
              <div class="col-md-3">
                  <select name="target_amount" id="target_amount" data-toggle="tooltip" class="form-control" title="Target Amount" required>
                      <option value="">*Target Amount</option>
                      <option value="Service Charge">Service Charge</option>
                      <option value="Basic">Basic</option>
                      <option value="Total">Total</option>
                      <option value="Commission">Commission</option>
                      <option value="Markup">Markup</option>
                      <option value="Discount">Discount</option>
                  </select>
              </div>
          </div>
          <div class="row mg_tp_20">
            <div class="col-md-3">
              <input type="checkbox" id="applicable" name="applicable" autocomplete="off" data-original-title="" title="" aria-hidden="true" class="labelauty" style="display: none;" onclick="inclusive_checker();">
              <label for="app_purchase">
                <span class="labelauty-unchecked-image"></span>
                <span class="labelauty-checked-image"></span>
              </label>
              <label for="app_purchase">Applicable on Purchase</label>
            </div>
          </div>
          <div class="row mg_tp_20"> <div class="col-md-12 text-right">
              <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_taxe_rule_conditions')" title="Add row" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
              <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_taxe_rule_conditions')" title="Delete row" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
          </div></div>

          <div class="row"> <div class="col-md-12"> <div class="table-responsive">
            <legend class="no-pad">Conditions</legend>
            <table id="tbl_taxe_rule_conditions" name="tbl_taxe_rule_conditions" class="table table-bordered pd_bt_51">
                <tr>
                    <td style="width:5%"><input id="chk_tax1" type="checkbox" checked></td>
                    <td style="width:5%"><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                    <td style="width:25%"><select name="condition" id="condition" data-toggle="tooltip" class="form-control app_select2" title="Condition" style="width:100%" onchange="values_load(this.id);">
                    <?php echo get_tax_conditions(); ?>
                        </select>
                    </td>
                    <td style="width:10%"><select name="for" id="for" data-toggle="tooltip" class="form-control" title="For">
                          <option value="">For</option>
                          <option value=">=">>=</option>
                          <option value=">">></option>
                          <option value="<"><</option><option value="<="><=</option>
                          <option value="!=">!=</option>
                          <option value="==">==</option>
                        </select>
                    </td>
                    <td style="width:25%"><select name="value" id="value" data-toggle="tooltip" class="form-control app_select2" title="Value" style="width:100%">
                          <option value="">Select Value</option>
                        </select>
                    </td>
                    <td style="width:10%"><input type="text" title="Currency" id="currency" class="form-control" style="display:none" disabled/></td>
                    <td style="width:20%"><input type="number" placeholder="Amount" title="Amount" id="amount" class="form-control" style="display:none" /></td>
                </tr>                                
            </table>
          </div> </div> </div>
        
          <div class="row mg_tp_20">
            <div class="col-md-12 text-center">
              <button class="btn btn-sm btn-success" id="btn_taxrules_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
            </div>
          </div>
        </form>
      </div>      
    </div>
  </div>
</div>

<script>
$('#taxes_save_modal').modal('show');
$('#travel_type,#ledger').select2();
$('#condition,#value').select2();
$('#from_date,#to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
if('<?= $type ?>' == "rule_master"){
  $('#tentry_id').select2();
}
$(function(){

$('#frm_tax_rules_save').validate({
  rules:{
      name : { required : true },
      validity : { required : true },
      ledger : { required : true},
      travel_type : { required : true},
      calc_mode : { required : true},
      target_amount : { required : true},
      tentry_id : { required : true},
  },
  submitHandler:function(form){
      var base_url = $('#base_url').val();
      var entry_id = $('#tentry_id').val();
      var name = $('#name').val();
      var validity = $('#validity').val();
      var from_date = '';
      var to_date = '';
      if(validity === "Period"){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if(from_date == ''){ error_msg_alert('Select valid from date!'); return false; }
        if(to_date == ''){ error_msg_alert('Select valid to date!'); return false; }
      }
      var applicableOn = ($('input[name=\'applicable\']:checked').val() == 'on') ? 1 : 0 ;
      var ledger = $('#ledger').val();
      var travel_type = $('#travel_type').val();
      var calc_mode = $('#calc_mode').val();
      var target_amount = $('#target_amount').val();
      
      inclusive_checker();
      var cond_arr = [];
      var table = document.getElementById("tbl_taxe_rule_conditions");
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++){
        var row = table.rows[i];
        if(row.cells[0].childNodes[0].checked){

          var condition = row.cells[2].childNodes[0].value;	
          var for1 = row.cells[3].childNodes[0].value;
          var value = row.cells[4].childNodes[0].value;		
          var currency = row.cells[5].childNodes[0].value;
          var amount = row.cells[6].childNodes[0].value;

          if(condition === ''){ error_msg_alert('Select condition at row'+(i+1)); return false; }
          if(for1 === ''){ error_msg_alert('Select for at row'+(i+1)); return false; }
          
          if(parseInt(condition) === 1 || parseInt(condition) === 2 || parseInt(condition) === 3 || parseInt(condition) === 10 || parseInt(condition) === 8 || parseInt(condition) === 9 || parseInt(condition) === 13 || parseInt(condition)=== 14 || parseInt(condition) === 16 || parseInt(condition) === 1 || parseInt(condition) === 5 || parseInt(condition) === 6 || parseInt(condition) === 12 || parseInt(condition) === 7){

            if(value === ''){ error_msg_alert('Select value at row'+(i+1)); return false; }
          }
          if(condition === "4" || condition === "15") {
            if(currency === ''){ error_msg_alert('Select currency at row'+(i+1)); return false; }
            if(amount === ''){ error_msg_alert('Select amount at row'+(i+1)); return false; }
          }
          cond_arr.push({
            'condition':condition,
            'for1':for1,
            'value':value,
            'currency':currency,
            'amount':amount
          });
        }
      }
      if(cond_arr.length === 0){ error_msg_alert('Atleast add one condition!'); return false;}

      $('#btn_taxrules_save').button('loading');
      
      $.ajax({
        type: 'post',
        url: base_url+'controller/business_rules/taxes_rules/save.php',
        data:{ entry_id : entry_id, name : name, validity : validity, from_date : from_date, to_date : to_date, ledger : ledger, travel_type : travel_type, calc_mode : calc_mode, target_amount : target_amount, cond_arr : cond_arr, applicableOn : applicableOn},
        success: function(result){

          var error_arr = result.split('--');
          if(error_arr[0]=="error"){
            error_msg_alert(result);
            return false;
          }
          else{
            success_msg_alert(result);
            $('#taxes_save_modal').modal('hide');
            update_cache();
            if('<?= $type ?>' == "rule_master")
            t_list_reflect();
            else
            list_reflect();
          }
        }
      });
  }
});

});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>