<?php
include "../../../model/model.php";

$bank_id = $_POST['bank_id'];
$sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$bank_id'"));

$role = $_SESSION['role'];
$value = '';
if($role!='Admin' && $role!="Branch Admin"){ $value="readonly"; }

?>
<form id="frm_update">
<input type="hidden" id="bank_id" name="bank_id" value="<?= $bank_id ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Bank</h4>
      </div>
      <div class="modal-body">
        
		<div class="row">
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="bank_name" name="bank_name" placeholder="*Bank Name" title="Bank Name" value="<?= $sq_bank['bank_name'] ?>">
			</div>
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="account_no" name="account_no" placeholder="*A/c No" title="A/c No" onchange="validate_accountNo(this.id);" value="<?= $sq_bank['account_no'] ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="ifsc_code" onchange="validate_IFSC(this.id);" name="ifsc_code" placeholder="IFSC Code" title="IFSC Code" value="<?= $sq_bank['ifsc_code'] ?>">
			</div>
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="swift_code" name="swift_code" placeholder="Swift Code" onchange="validate_IFSC(this.id);" title="Swift Code" value="<?= $sq_bank['swift_code'] ?>">
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-6 mg_bt_10">
				<select name="account_type" id="account_type" title="Account Type">
					<?php if($sq_bank['account_type']!=''){ ?>
					<option value="<?= $sq_bank['account_type'] ?>"><?= $sq_bank['account_type'] ?></option>
					<option value="">Account Type</option>
					<option value="Savings">Savings</option>
					<option value="Current">Current</option>
				<?php 
				}else{ 
				?>
				<option value="">Account Type</option>
					<option value="Savings">Savings</option>
					<option value="Current">Current</option>
				<?php } ?>
				</select>
			</div>			
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="branch_name" name="branch_name" onchange="validate_branch(this.id)" placeholder="*Branch Name" title="Branch Name" value="<?= $sq_bank['branch_name'] ?>">
			</div>			
		</div>
		<div class="row">
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="address" name="address" placeholder="Address" title="Address" onchange="validate_address(this.id)" value="<?= $sq_bank['address'] ?>">
			</div>
			<div class="col-sm-6 mg_bt_10">
				<input type="text" id="mobile_no" onchange="mobile_validate(this.id)" name="mobile_no" placeholder="Mobile No" title="Mobile No" value="<?= $sq_bank['mobile_no'] ?>">
			</div>			
		</div>
		<div class="row">
			<div class="col-sm-6">
				<select name="active_flag" id="active_flag" title="Status">
					<option value="<?= $sq_bank['active_flag'] ?>"><?= $sq_bank['active_flag'] ?></option>
					<option value="Active">Active</option>
					<option value="Inactive">Inactive</option>
				</select>
			</div>
			<div class="col-sm-6 mg_bt_10">
				<input type="hidden" id="opening_balance" name="opening_balance" placeholder="Opening Balance" title="Opening Balance" value="<?= $sq_bank['opening_balance'] ?>" <?= $value ?>  onchange="validate_balance(this.id)">
			</div>
			<div class="col-sm-6 mg_bt_10">
				<input type="hidden" id="as_of_date1" name="as_of_date1" placeholder="*As of Date" title="As of Date" value="<?= get_date_user($sq_bank['as_of_date']) ?>">
			</div>
	    </div>			
		<div class="row text-center mg_tp_20">
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
$('#as_of_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });

$(function(){
  $('#frm_update').validate({
    rules:{
			bank_name :{ required : true },
			account_no :{ required : true },
			branch_name : { required : true },
			as_of_date1 : { required : true },
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();
         
		var bank_id = $('#bank_id').val();
		var bank_name = $('#bank_name').val();
		var branch_name = $('#branch_name').val();
		var address = $('#address').val();
		var account_no = $('#account_no').val();
		var ifsc_code = $('#ifsc_code').val();
		var swift_code = $('#swift_code').val();
		var account_type = $('#account_type').val();
		var mobile_no = $('#mobile_no').val();
		var opening_balance = $('#opening_balance').val();
		var as_of_date = $('#as_of_date1').val();
		var active_flag = $('#active_flag').val();
		var add = validate_address('address');
		if(!add){
		error_msg_alert('More than 155 characters are not allowed.');
		return false;
		}
		$('#btn_update').button('loading');

        $.post( 
               base_url+"controller/finance_master/bank_master/bank_master_update.php",
               { bank_id : bank_id, bank_name : bank_name, branch_name : branch_name, address : address, account_no : account_no, ifsc_code : ifsc_code, swift_code : swift_code, account_type : account_type, mobile_no : mobile_no, opening_balance : opening_balance, active_flag : active_flag,as_of_date :as_of_date },
               function(data) {
                  $('#btn_update').button('reset');
                  var msg = data.split('--');
                  if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                  }else{
                    msg_alert(data);
                    $('#update_modal').modal('hide');  
                    $('#update_modal').on('hidden.bs.modal', function(){
                      list_reflect();
                    });
                  }
                  
        });  

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>