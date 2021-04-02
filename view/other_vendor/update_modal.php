<?php

include "../../model/model.php";

$vendor_id = $_POST['vendor_id'];
$sq_vendor = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$vendor_id'"));
$sq_vendor_login = mysql_fetch_assoc(mysql_query("select * from vendor_login where username='$sq_vendor[vendor_name]' and password='$sq_vendor[mobile_no]' and vendor_type='Other Vendor'"));

$role = $_SESSION['role'];
$value = '';
if($role!='Admin' && $role!="Branch Admin"){ $value="readonly"; }
$mobile_no = $encrypt_decrypt->fnDecrypt($sq_vendor['mobile_no'], $secret_key);
$email_id = $encrypt_decrypt->fnDecrypt($sq_vendor['email_id'], $secret_key);

?>
<form id="frm_update">
<input type="hidden" name="vendor_id" id="vendor_id" value="<?= $vendor_id ?>">
<input type="hidden" id="vendor_login_id" name="vendor_login_id" value="<?= $sq_vendor_login['login_id'] ?>">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Other Supplier Information</h4>
      </div>
      <div class="modal-body">
         <div class="panel panel-default panel-body app_panel_style feildset-panel">
        <legend>Other Supplier Information</legend>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select id="cmb_city_id1" name="cmb_city_id1" style="width:100%" title="City Name">
                  <?php $sq_city = mysql_fetch_assoc(mysql_query("select city_name,city_id from city_master where city_id='$sq_vendor[city_id]'")); ?>
                  <option value="<?php echo $sq_city['city_id'] ?>" selected="selected"><?php echo $sq_city['city_name'] ?></option>
            </select>
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="vendor_name" id="vendor_name" onchange="validate_spaces(this.id);" title="Company Name" placeholder="*Company Name" value="<?= $sq_vendor['vendor_name'] ?>">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="profession" id="profession" title="Supplier Occupation" placeholder="Occupation" value="<?= $sq_vendor['profession'] ?>">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="mobile_no" id="mobile_no" title="Mobile No" placeholder="Mobile No" onchange="mobile_validate(this.id);" value="<?= $mobile_no ?>">
          </div>  
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" onchange="mobile_validate(this.id);" value="<?= $sq_vendor['landline_no'] ?>" id="landline_no1" name="landline_no1" placeholder="Landline Number" title="Landline Number">
          </div>
           <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" class="form-control" value="<?= $sq_vendor['contact_person_name'] ?>" id="contact_person_name1" name="contact_person_name1" placeholder="Contact Person Name" title="Contact Person Name">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" id="immergency_contact_no1" name="immergency_contact_no1" onchange="mobile_validate(this.id);" value="<?= $sq_vendor['immergency_contact_no'] ?>" placeholder="Emergency Contact No" title="Emergency Contact No" class="form-control"> 
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <textarea id="address" name="address" onchange="validate_address(this.id)" title="Address" placeholder="Address" rows="1"><?= $sq_vendor['address'] ?></textarea>
          </div>  
        </div>
        <div class="row">
          <div class="col-sm-3 col-xs-6 mg_bt_10">
            <select name="cust_state1" id="cust_state1" title="Select State" style="width:100%" required>
              <?php if($sq_vendor['state_id']!='0'){
               $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_vendor[state_id]'"));
              
              ?>
              <option value="<?= $sq_vendor['state_id'] ?>"><?= $sq_state['state_name'] ?></option>
            <?php } ?>
              <?php get_states_dropdown() ?>
            </select>
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="email_id" id="email_id" title="Email ID" placeholder="Email ID" value="<?= $email_id ?>">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="country1" name="country1" placeholder="Country" value="<?= $sq_vendor['country'] ?>" title="Country" class="form-control">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="website1" name="website1" placeholder="Website" value="<?= $sq_vendor['website'] ?>" class="form-control" title="Website">
          </div>
        </div>
      </div>
       <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
        <legend>Bank Information</legend>
        <div class="row">
            <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="bank_name1" id="bank_name1" class="bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?= $sq_vendor['bank_name']?>">
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="account_name1" id="account_name1" placeholder="A/c Name" title="A/c Name" value="<?= $sq_vendor['account_name']?>">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="account_no1" id="account_no1" onchange="validate_accountNo(this.id);" placeholder="A/c No" title="A/c No" value="<?= $sq_vendor['account_no']?>">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="branch1" id="branch1" placeholder="Branch" title="Branch" onchange="validate_branch(this.id);" value="<?= $sq_vendor['branch']?>">
          </div>
       
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="ifsc_code1" onchange="validate_IFSC(this.id);" id="ifsc_code1" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" value="<?= $sq_vendor['ifsc_code']?>" style="text-transform: uppercase;"> 
          </div>
           <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="service_tax_no1" onchange="validate_alphanumeric(this.id);" id="service_tax_no1" placeholder="Tax No" title="Tax No"  value="<?= strtoupper($sq_vendor['service_tax_no']) ?>" style="text-transform: uppercase;">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
             <input type="text" id="supp_pan" name="supp_pan" onchange="validate_alphanumeric(this.id)" value="<?= $sq_vendor['pan_no']?>" placeholder="PAN/TAN No" title="PAN/TAN No" style="text-transform: uppercase;">
            </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="hidden" id="opening_balance" name="opening_balance" onchange="validate_balance(this.id);" placeholder="Opening Balance" title="Opening Balance" value="<?= $sq_vendor['opening_balance'] ?>" <?= $value ?> >
          </div>    
						<div class="col-sm-3 mg_bt_10">
							<input type="hidden" id="as_of_date1" name="as_of_date1" placeholder="*As of Date" title="As of Date" value="<?= get_date_user($sq_vendor['as_of_date']) ?>">
						</div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select class="hidden" name="side1" id="side1" title="Select side" disabled>
              <option value="<?= $sq_vendor['side'] ?>"><?= $sq_vendor['side'] ?></option>
              <option value="Credit">Credit</option>
              <option value="Debit">Debit</option>
            </select>
          </div>
        </div>
        <div class="row"> 
        </div>
      </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select name="active_flag" id="active_flag" title="Status">
                  <option value="<?= $sq_vendor['active_flag'] ?>"><?= $sq_vendor['active_flag'] ?></option>
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
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
$('#cust_state1').select2();
$('#as_of_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
city_lzloading('#cmb_city_id1');
$(function(){
  $('#frm_update').validate({
    rules:{
            vendor_name:{ required:true },
            cmb_city_id1:{ required:true },
            active_flag:{ required:true }, 
            side1 : { required : true },
			as_of_date1 : { required : true },
    },
    submitHandler:function(form){
        var vendor_id = $('#vendor_id').val(); 
        var vendor_login_id = $('#vendor_login_id').val();      
        var vendor_name = $('#vendor_name').val();       
        var profession = $('#profession').val();   
        var service_tax_no = $('#service_tax_no1').val();    
        var mobile_no = $('#mobile_no').val();       
        var email_id = $('#email_id').val();
        var landline_no = $('#landline_no1').val();
        var contact_person_name = $('#contact_person_name1').val();
        var cmb_city_id1 = $('#cmb_city_id1').val(); 
        var immergency_contact_no = $('#immergency_contact_no1').val();
        var country = $("#country1").val();
        var website = $("#website1").val();
        var bank_name = $("#bank_name1").val();
        var account_name = $("#account_name1").val();
        var account_no = $("#account_no1").val();
        var branch = $("#branch1").val();
        var ifsc_code = $("#ifsc_code1").val();       
        var address = $('#address').val();       
        var opening_balance = $('#opening_balance').val();       
        var active_flag = $('#active_flag').val();       
        var gl_id = $('#gl_id').val();   
        var state_id = $('#cust_state1').val();   
        var side = $('#side1').val(); 
        var supp_pan = $('#supp_pan').val();    
        var as_of_date = $('#as_of_date1').val();
        var add = validate_address('address');
        if(!add){
          error_msg_alert('More than 155 characters are not allowed.');
          return false;
        }
        $('#btn_update').button('loading');
        $.post( 
               base_url()+"controller/other_vendors/vendor_update.php",
               { vendor_id : vendor_id, vendor_login_id : vendor_login_id, vendor_name : vendor_name, profession : profession, service_tax_no : service_tax_no, mobile_no : mobile_no, landline_no : landline_no, email_id : email_id, contact_person_name : contact_person_name, immergency_contact_no : immergency_contact_no, cmb_city_id1 : cmb_city_id1, address : address, country :country, website :website, opening_balance : opening_balance, bank_name : bank_name, account_no : account_no, branch : branch, ifsc_code : ifsc_code, active_flag : active_flag, gl_id : gl_id, state_id : state_id,side : side,account_name : account_name ,supp_pan : supp_pan,as_of_date : as_of_date},
               function(data) {                  
                  msg_alert(data);
                  $('#btn_update').button('reset');
                  $('#update_modal').modal('hide');
                  list_reflect();
               });  
    }
  });
});
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>