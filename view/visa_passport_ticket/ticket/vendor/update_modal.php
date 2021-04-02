<?php

include "../../../../model/model.php";
$vendor_id = $_POST['vendor_id'];
$sq_vendor = mysql_fetch_assoc(mysql_query("select * from ticket_vendor where vendor_id='$vendor_id'"));
$sq_vendor_login = mysql_fetch_assoc(mysql_query("select * from vendor_login where username='$sq_vendor[vendor_name]' and password='$sq_vendor[mobile_no]' and vendor_type='Ticket Vendor'"));

$role = $_SESSION['role'];
$value = '';
if($role!='Admin' && $role!="Branch Admin"){ $value="readonly"; }
$mobile_no = $encrypt_decrypt->fnDecrypt($sq_vendor['mobile_no'], $secret_key);
$email_id = $encrypt_decrypt->fnDecrypt($sq_vendor['email_id'], $secret_key);
?>
<form id="frm_update">
<input type="hidden" id="vendor_id" name="vendor_id" value="<?= $vendor_id ?>">
<input type="hidden" id="vendor_login_id" name="vendor_login_id" value="<?= $sq_vendor_login['login_id'] ?>">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Flight-Ticket Supplier Information</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-default panel-body app_panel_style feildset-panel">
        <legend>Ticket Supplier Information</legend>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="vendor_name1" name="vendor_name1" placeholder="Company Name" onchange="validate_spaces(this.id);" title="Company Name" value="<?= $sq_vendor['vendor_name'] ?>">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="mobile_no1" name="mobile_no1" onchange="mobile_validate(this.id);" placeholder="Mobile No" title="Mobile No" value="<?= $mobile_no ?>">
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" value="<?= $sq_vendor['landline_no'] ?>" onchange="mobile_validate(this.id);" id="landline_no1" name="landline_no1" placeholder="Landline Number" title="Landline Number">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="email_id1" name="email_id1" placeholder="Email ID" title="Email ID" value="<?= $email_id ?>">
          </div>          
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" class="form-control" value="<?= $sq_vendor['contact_person_name'] ?>" id="contact_person_name1" name="contact_person_name1" placeholder="Contact Person Name" title="Contact Person Name">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" id="immergency_contact_no1" name="immergency_contact_no1" value="<?= $sq_vendor['immergency_contact_no'] ?>" onchange="mobile_validate(this.id);" placeholder="Emergency Contact No" title="Emergency Contact No" class="form-control"> 
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <textarea id="address1" name="address1" placeholder="Address" onchange="validate_address(this.id);" title="Address" rows="1"><?= $sq_vendor['address'] ?></textarea>
          </div>   
          <div class="col-sm-3 col-xs-6 mg_bt_10">
            <select name="cust_state1" id="cust_state1" title="Select State" style="width: 100%" required>
              <?php if($sq_vendor['state_id']!='0'){
               $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_vendor[state_id]'"));
              ?>
              <option value="<?= $sq_vendor['state_id'] ?>"><?= $sq_state['state_name'] ?></option>
            <?php } ?>
              <?php get_states_dropdown() ?>
            </select>
          </div> 
                
        </div>
        <div class="row">
           <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="country1" name="country1" placeholder="Country" value="<?= $sq_vendor['country'] ?>"   class="form-control" title="Country" >
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
            <input type="text" name="account_no1" id="account_no1" placeholder="A/c No" onchange="validate_accountNo(this.id);" title="A/c No" value="<?= $sq_vendor['account_no']?>">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="branch1" id="branch1" onchange="validate_branch(this.id);" placeholder="Branch" title="Branch" value="<?= $sq_vendor['branch']?>">
          </div>
        </div>
        <div class="row"> 
           <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="ifsc_code1" id="ifsc_code1" onchange="validate_IFSC(this.id);" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" value="<?= $sq_vendor['ifsc_code']?>"> 
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="service_tax_no1" id="service_tax_no1" onchange="validate_alphanumeric(this.id)" placeholder="Tax No" title="Tax No" value="<?= strtoupper($sq_vendor['service_tax_no']) ?>">
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
             <input type="text" id="supp_pan1" onchange="validate_alphanumeric(this.id);" name="supp_pan1" value="<?= $sq_vendor['pan_no']?>"" placeholder="PAN/TAN No" title="PAN/TAN No">
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="hidden" id="opening_balance1" onchange="validate_balance(this.id)" name="opening_balance1" placeholder="Opening Balance" title="Opening Balance" value="<?= $sq_vendor['opening_balance'] ?>">
          </div> 
          <div class="col-sm-3 mg_bt_10">
            <input type="hidden" id="as_of_date1" name="as_of_date1" placeholder="*As of Date" title="As of Date" value="<?= get_date_user($sq_vendor['as_of_date']) ?>">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select class="hidden" name="side1" id="side1" title="Select side" disabled>
              <option value="<?= $sq_vendor['side'] ?>"><?= $sq_vendor['side'] ?></option>
              <option value="">*Select Side</option>
              <option value="Credit">Credit</option>
              <option value="Debit">Debit</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select name="active_flag1" id="active_flag1" title="Status">
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
$('#as_of_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#cust_state1').select2();
$(function(){
$('#frm_update').validate({
  rules:{
          vendor_name1 : { required : true },
          active_flag1 : { required : true },  
          side1 : { required : true },
			    as_of_date1 : { required : true },
  },
  submitHandler:function(form){
      var vendor_id = $('#vendor_id').val();
      var vendor_login_id = $('#vendor_login_id').val();
      var vendor_name = $('#vendor_name1').val();
      var mobile_no = $('#mobile_no1').val();
      var email_id = $('#email_id1').val();
      var landline_no = $('#landline_no1').val();
      var contact_person_name = $('#contact_person_name1').val();
      var immergency_contact_no = $('#immergency_contact_no1').val();
      var country = $("#country1").val();
      var website = $("#website1").val();
      var bank_name = $("#bank_name1").val();
      var account_name= $("#account_name1").val();
      var account_no = $("#account_no1").val();
      var branch = $("#branch1").val();
      var ifsc_code = $("#ifsc_code1").val();
      var address = $('#address1').val();
      var bank_details = $('#bank_details1').val();    
      var opening_balance = $('#opening_balance1').val();
      var active_flag = $('#active_flag1').val();
      var service_tax_no1 = $('#service_tax_no1').val();
      var state = $('#cust_state1').val();
      var side = $('#side1').val();
      var supp_pan = $('#supp_pan1').val();
      var as_of_date = $('#as_of_date1').val();
      var base_url = $('#base_url').val();
      var add = validate_address('address1');
      if(!add){
        error_msg_alert('More than 155 characters are not allowed.');
        return false;
      }
      $('#btn_update').button('loading');
      $.ajax({
        type: 'post',
        url: base_url+'controller/visa_passport_ticket/ticket/vendor/vendor_update.php',
        data:{ vendor_id : vendor_id, vendor_login_id : vendor_login_id, vendor_name : vendor_name, mobile_no : mobile_no, landline_no : landline_no, email_id : email_id, contact_person_name : contact_person_name, immergency_contact_no : immergency_contact_no, address : address, country :country, website :website, opening_balance : opening_balance, active_flag : active_flag, bank_name : bank_name, account_no : account_no, branch : branch, ifsc_code : ifsc_code, service_tax_no1:service_tax_no1, state : state, side: side,account_name:account_name,supp_pan : supp_pan,as_of_date : as_of_date },
        success: function(result){
          $('#btn_update').button('reset');
          var msg = result.split('-');
          if(msg[0]=='error'){
            msg_alert(result);
          }
          else{
            msg_alert(result);
            $('#update_modal').modal('hide');  
            $('#update_modal').on('hidden.bs.modal', function(){
              list_reflect();  
            });            
          }
        }
      });
  }
});
});

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>