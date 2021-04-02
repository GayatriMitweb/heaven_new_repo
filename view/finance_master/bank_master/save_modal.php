<?php
include "../../../model/model.php";
?>
<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Bank Account</h4>
      </div>
      <div class="modal-body">
        
		<div class="row">
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="bank_name" name="bank_name" class="bank_suggest" placeholder="*Bank Name" title="Bank Name">
			</div>
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="account_no" name="account_no" onchange="validate_accountNo(this.id);" placeholder="*A/c No" title="A/c No">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="ifsc_code" name="ifsc_code" onchange="validate_IFSC(this.id);" placeholder="IFSC Code" title="IFSC Code" style="text-transform: uppercase;">
			</div>
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="swift_code" name="swift_code" onchange="validate_IFSC(this.id);" placeholder="Swift Code" title="Swift Code" style="text-transform: uppercase;">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 mg_bt_10">
				<select name="account_type" id="account_type" title="Account Type">
					<option value="">Account Type</option>
					<option value="Savings">Savings</option>
					<option value="Current">Current</option>
				</select>
			</div>					
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="branch_name" name="branch_name" onchange="validate_branch(this.id)" placeholder="*Branch Name" title="Branch Name">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="address" name="address" onchange="validate_address(this.id)" placeholder="Address" title="Address">
			</div>
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="mobile_no" name="mobile_no" onchange="mobile_validate(this.id)" placeholder="Mobile No" title="Mobile No">
			</div>	
		</div>
		<div class="row">
			<div class="col-sm-6 mg_bt_10">
				<input type="hidden" id="opening_balance" name="opening_balance" placeholder="Opening Balance" title="Opening Balance"  onchange="validate_balance(this.id)">
			</div>
			<div class="col-sm-6 mg_bt_10">
				<input type="hidden" id="as_of_date" name="as_of_date" placeholder="*As of Date" title="As of Date">
			</div>
			<div class="col-sm-6 mg_bt_10">
				<select name="active_flag" id="active_flag" title="Status" class="hidden">
					<option value="Active">Active</option>
					<option value="Inactive">Inactive</option>
				</select>
			</div>
		</div>
		<div class="row text-center mg_tp_20">
          <div class="col-md-12">
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
$('#as_of_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$(function(){
  $('#frm_save').validate({
    rules:{
			bank_name :{ required : true },
			account_no :{ required : true },
			branch_name : { required : true },
			as_of_date : { required : true },
		},
    submitHandler:function(form){

        var base_url = $('#base_url').val();
         
		var bank_name = $('#bank_name').val();
		var branch_name = $('#branch_name').val();
		var address = $('#address').val();
		var account_no = $('#account_no').val();
		var ifsc_code = $('#ifsc_code').val();
		var swift_code = $('#swift_code').val();
		var account_type = $('#account_type').val();
		var mobile_no = $('#mobile_no').val();
		var opening_balance = $('#opening_balance').val();
		var as_of_date = $('#as_of_date').val();
		var active_flag = $('#active_flag').val();
		var add = validate_address('address');
		if(!add){
		error_msg_alert('More than 155 characters are not allowed.');
		return false;
		}
		$('#btn_save').button('loading');
		$.post(
					base_url+"controller/finance_master/bank_master/bank_master_save.php",
					{ bank_name : bank_name, branch_name : branch_name, address : address, account_no : account_no, ifsc_code : ifsc_code, swift_code : swift_code, account_type : account_type, mobile_no : mobile_no, opening_balance : opening_balance, active_flag : active_flag,as_of_date :as_of_date },
					function(data) {
						$('#btn_save').button('reset');
						var msg = data.split('--');
						if(msg[0]=="error"){
							error_msg_alert(msg[1]);
						}else{
							msg_alert(data);
							$('#save_modal').modal('hide');
							$('#save_modal').on('hidden.bs.modal', function(){
								list_reflect();
							});
						}
		});
    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>