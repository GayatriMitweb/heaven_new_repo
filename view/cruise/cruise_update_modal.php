<?php

include "../../model/model.php";
$cruise_id = $_POST['cruise_id'];
$sq_cruise_info = mysql_fetch_assoc(mysql_query("select * from cruise_master where cruise_id='$cruise_id'"));
$sq_vendor_login = mysql_fetch_assoc(mysql_query("select * from vendor_login where username='$sq_cruise_info[company_name]' and password='$sq_cruise_info[mobile_no]' and vendor_type='Cruise Vendor'"));

$role = $_SESSION['role'];
$value = '';
if($role!='Admin' && $role!="Branch Admin"){ $value="readonly"; }
$mobile_no = $encrypt_decrypt->fnDecrypt($sq_cruise_info['mobile_no'], $secret_key);
$email_id = $encrypt_decrypt->fnDecrypt($sq_cruise_info['email_id'], $secret_key);
?>

<div class="modal fade" id="cruise_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Cruise Supplier Information</h4>
      </div>
      <div class="modal-body">
        <form id="frm_cruise_update">
        <div class="panel panel-default panel-body app_panel_style feildset-panel">
            <legend>Cruise Supplier Information</legend>
          
              <input type="hidden" id="cruise_id" name="cruise_id" value="<?= $cruise_id ?>">
              <input type="hidden" id="vendor_login_id" name="vendor_login_id" value="<?= $sq_vendor_login['login_id'] ?>">
              <div class="row">
                  <div class="col-md-3 col-sm-6 mg_bt_10">
                     <select id="cmb_city_id1" name="cmb_city_id1" style="width:100%" title="City Name">
                        <?php $sq_city = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$sq_cruise_info[city_id]'")); ?>
                        <option value="<?php echo $sq_city['city_id']; ?>" selected="selected"><?php echo $sq_city['city_name']; ?></option>
                    </select>
                  </div>
                  <div class="col-md-3 col-sm-6 mg_bt_10">
                      <input type="text" class="form-control" value="<?= $sq_cruise_info['company_name'] ?>" id="company_name1" name="company_name1" onchange="validate_spaces(this.id);" placeholder="Company Name" title="Company Name">    
                  </div>
                  <div class="col-md-3 col-sm-6 mg_bt_10">
                      <input type="text" class="form-control" value="<?= $mobile_no ?>" id="mobile_no1" name="mobile_no1" placeholder="Mobile Number" onchange="mobile_validate(this.id);" title="Mobile Number">
                  </div>
                  <div class="col-md-3 col-sm-6 mg_bt_10">
                      <input type="text" class="form-control" value="<?= $sq_cruise_info['landline_no'] ?>" onchange="mobile_validate(this.id);" id="landline_no1" name="landline_no1" placeholder="Landline Number" title="Landline Number">
                  </div>                 
              </div>

              <div class="row">                  
                  <div class="col-md-3 col-sm-6 mg_bt_10">
                      <input type="text" class="form-control" value="<?= $email_id ?>" id="email_id1" name="email_id1"  placeholder="Email ID" title="Email ID">
                  </div>
                  <div class="col-md-3 col-sm-6 mg_bt_10">
                      <input type="text" class="form-control" value="<?= $sq_cruise_info['contact_person_name'] ?>" id="contact_person_name1" name="contact_person_name1" placeholder="Contact Person Name" title="Contact Person Name">
                  </div>
                  <div class="col-md-3 col-sm-6 mg_bt_10">
                      <input type="text" id="immergency_contact_no1" name="immergency_contact_no1" value="<?= $sq_cruise_info['immergency_contact_no'] ?>" onchange="mobile_validate(this.id);" placeholder="Emergency Contact No" title="Emergency Contact No" class="form-control"> 
                  </div>
                  <div class="col-md-3 col-sm-6 mg_bt_10">
                      <textarea type="text" id="cruise_address1" name="cruise_address1" class="form-control" placeholder="Company Address" onchange="validate_address(this.id);" rows="1"  title="Company Address"><?= $sq_cruise_info['cruise_address'] ?></textarea>
                  </div>
              </div>
            <div class="row">
              <div class="col-sm-3 col-xs-6 mg_bt_10">
                <select name="state1" id="state1" title="Select State" style="width: 100%" required>
                  <?php if($sq_cruise_info['state']!='0'){
                  $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cruise_info[state]'"));
                  ?>
                  <option value="<?= $sq_cruise_info['state'] ?>"><?= $sq_state['state_name'] ?></option>
                <?php } ?>
                  <?php get_states_dropdown() ?>
                </select>
              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">
                <input type="text" id="country1" name="country1" class="form-control" placeholder="Country" value="<?= $sq_cruise_info['country'] ?>" title="Country" >
            </div>
            <div class="col-md-3 col-sm-6 mg_bt_10">
                <textarea id="website1" name="website1" placeholder="Website" title="Website" class="form-control" rows="1"><?= $sq_cruise_info['website'] ?></textarea>
            </div> 
            </div>                
        </div>
        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
            <legend>Bank Information</legend>
        <div class="row">
            <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="bank_name1" id="bank_name1" class="bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?= $sq_cruise_info['bank_name']?>">
            </div>
           <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="account_name1" id="account_name1" placeholder="A/c Name" title="A/c Name" value="<?= $sq_cruise_info['account_name']?>">
            </div> 
           <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="account_no1" id="account_no1" placeholder="A/c No"  onchange="validate_accountNo(this.id);" title="A/c No" value="<?= $sq_cruise_info['account_no']?>">
            </div> 
            <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="branch1" id="branch1"  onchange="validate_branch(this.id);" placeholder="Branch" title="Branch" value="<?= $sq_cruise_info['branch']?>">
            </div>
        </div>  
        <div class="row">

          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="ifsc_code1" id="ifsc_code1" onchange="validate_IFSC(this.id);" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" value="<?= $sq_cruise_info['ifsc_code']?>">
          </div>
           <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="service_tax_no1" id="service_tax_no1" onchange="validate_alphanumeric(this.id)" placeholder="Tax No" title="Tax No" value="<?= strtoupper($sq_cruise_info['service_tax_no'])?>" style="text-transform: uppercase;">
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
             <input type="text" id="supp_pan" name="supp_pan" onchange="validate_alphanumeric(this.id)" value="<?= $sq_cruise_info['pan_no']?>" placeholder="PAN/TAN No" title="PAN/TAN No" style="text-transform: uppercase;">
          </div> 
           <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="hidden" id="opening_balance1" name="opening_balance1" class="form-control" placeholder="Opening Balance" title="Opening Balance" value="<?= $sq_cruise_info['opening_balance'] ?>" <?= $value ?>  onchange="validate_balance(this.id)">
          </div> 
          <div class="col-sm-3 mg_bt_10">
            <input type="hidden" id="as_of_date1" name="as_of_date1" placeholder="*As of Date" title="As of Date" value="<?= get_date_user($sq_cruise_info['as_of_date']) ?>">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select class="hidden" name="side1" id="side1" title="Select side" disabled>
              <option value="<?= $sq_cruise_info['side']?>"><?= $sq_cruise_info['side']?></option>
              <option value="">*Select Side</option>
              <option value="Credit">Credit</option>
              <option value="Debit">Debit</option>
            </select>
          </div> 
        </div>
      </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <select name="active_flag1" id="active_flag1" title="Status" class="form-control">
                <option value="<?= $sq_cruise_info['active_flag'] ?>"><?= $sq_cruise_info['active_flag'] ?></option>
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
      </form>
      </div>      
    </div>
  </div>
</div>

<script>

$('#cruise_update_modal').modal('show');
$('#state1').select2();
$('#as_of_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
city_lzloading('#cmb_city_id1');
$(function(){
  $('#frm_cruise_update').validate({
    rules:{

            company_name1:{ required:true },
            cmb_city_id1:{ required:true },  
            side1 : { required : true },
			      as_of_date1 : { required : true },
    },

    submitHandler:function(form){
        var cruise_id = $('#cruise_id').val();
        var vendor_login_id = $('#vendor_login_id').val();
        var company_name = $('#company_name1').val();
        var mobile_no = $('#mobile_no1').val();
        var landline_no = $('#landline_no1').val();
        var email_id = $('#email_id1').val();
        var contact_person_name = $('#contact_person_name1').val();
        var cmb_city_id1 = $('#cmb_city_id1').val();        
        var cruise_address = $('#cruise_address1').val();
        var immergency_contact_no = $('#immergency_contact_no1').val();
        var country = $("#country1").val();
        var website = $("#website1").val();
        var bank_name = $("#bank_name1").val();
         var account_name = $("#account_name1").val();
        var account_no = $("#account_no1").val();
        var branch = $("#branch1").val();
        var ifsc_code = $("#ifsc_code1").val();
        var opening_balance = $('#opening_balance1').val();
        var active_flag = $('#active_flag1').val();
        var service_tax_no1 = $('#service_tax_no1').val();
        var state = $('#state1').val();
        var side = $('#side1').val();
        var supp_pan = $('#supp_pan').val();
        var as_of_date = $('#as_of_date1').val();
        var add = validate_address('cruise_address1');
        if(!add){
          error_msg_alert('More than 155 characters are not allowed.');
          return false;
        }
        var base_url = $('#base_url').val();
        $('#btn_update').button('loading');    

               $.post( 
               base_url+"controller/cruise/cruise_update.php",
               { cruise_id : cruise_id, vendor_login_id : vendor_login_id, company_name : company_name, mobile_no : mobile_no, landline_no : landline_no, email_id : email_id, contact_person_name : contact_person_name, immergency_contact_no : immergency_contact_no, cmb_city_id1 : cmb_city_id1, cruise_address : cruise_address, country :country, website :website,  opening_balance : opening_balance, active_flag : active_flag,service_tax_no1:service_tax_no1,state : state, bank_name : bank_name, account_no:account_no, branch : branch, ifsc_code:ifsc_code,side :side,account_name : account_name ,supp_pan : supp_pan,as_of_date : as_of_date},

               function(data) {                  
                  msg_alert(data);
                  $('#cruise_update_modal').modal('hide');
                  $('#cruise_update_modal').on('hidden.bs.modal', function(){
                    cruise_list_reflect();
                  });
                     $('#btn_update').button('reset');   
               });  
    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>