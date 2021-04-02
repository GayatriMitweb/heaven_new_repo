<?php

include "../../../../model/model.php";
$vendor_id = $_POST['vendor_id'];
$sq_vendor = mysql_fetch_assoc(mysql_query("select * from visa_vendor where vendor_id='$vendor_id'"));
$sq_vendor_login = mysql_fetch_assoc(mysql_query("select * from vendor_login where username='$sq_vendor[vendor_name]' and password='$sq_vendor[mobile_no]' and vendor_type='Visa'"));

?>
<form id="frm_update">
<input type="hidden" id="vendor_id" name="vendor_id" value="<?= $vendor_id ?>">
<input type="hidden" id="vendor_login_id" name="vendor_login_id" value="<?= $sq_vendor_login['login_id'] ?>">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Visa Supplier information</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
             <select id="cmb_city_id1" name="cmb_city_id1" style="width:100%" title="City Name">
                <?php $sq_city = mysql_fetch_assoc(mysql_query("select city_name, city_id from city_master where city_id='$sq_vendor[city_id]'")); ?>
                <option value="<?php echo $sq_city['city_id'] ?>"><?php echo $sq_city['city_name'] ?></option>
                <?php get_cities_dropdown(); ?>
            </select>
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="vendor_name1" name="vendor_name1" placeholder="Company Name" title="Company Name" value="<?= $sq_vendor['vendor_name'] ?>">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="mobile_no1" name="mobile_no1" placeholder="Mobile No" title="Mobile No" value="<?= $sq_vendor['mobile_no'] ?>">
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" value="<?= $sq_vendor['landline_no'] ?>" id="landline_no1" name="landline_no1" placeholder="Landline Number" title="Landline Number">
          </div>             
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="email_id1" name="email_id1" placeholder="e.g.abc@gmail.com" title="Email ID" value="<?= $sq_vendor['email_id'] ?>">
          </div>  
           <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" class="form-control" value="<?= $sq_vendor['contact_person_name'] ?>" id="contact_person_name1" name="contact_person_name1" placeholder="Contact Person Name" title="Contact Person Name">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" id="immergency_contact_no1" name="immergency_contact_no1" value="<?= $sq_vendor['immergency_contact_no'] ?>" placeholder="Emergency Contact No" title="Emergency Contact No" class="form-control"> 
          </div>   
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <textarea id="address1" name="address1" placeholder="Address" title="Address" rows="1"><?= $sq_vendor['address'] ?></textarea>
          </div>     
        </div>
        <div class="row">
          <div class="col-sm-3 col-xs-6 mg_bt_10">
            <select name="cust_state1" id="cust_state1" title="Select State" style="width:100%">
              <?php $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_vendor[state_id]'"));
              ?>
              <option value="<?= $sq_vendor['state_id'] ?>"><?= $sq_state['state_name'] ?></option>
              <?php get_states_dropdown() ?>
            </select>
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="country1" name="country1" placeholder="Country" value="<?= $sq_vendor['country'] ?> " title="Country" class="form-control">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="website1" name="website1" placeholder="Website" value="<?= $sq_vendor['website'] ?>" class="form-control" title="Website">
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" name="bank_name1" id="bank_name1" class="bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?= $sq_vendor['bank_name']?>">
          </div> 
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="account_no1" id="account_no1" placeholder="Account No" title="Account No" value="<?= $sq_vendor['account_no']?>">
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="branch1" id="branch1" placeholder="Branch" title="Branch" value="<?= $sq_vendor['branch']?>">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="ifsc_code1" id="ifsc_code1" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" value="<?= $sq_vendor['ifsc_code']?>"> 
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="opening_balance1" name="opening_balance1" placeholder="Opening Balance" title="Opening Balance" value="<?= $sq_vendor['opening_balance'] ?>">
          </div>
        </div>
        <div class="row">   
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select name="side1" id="side1" title="Select side">
             <option value="<?= $sq_vendor['side'] ?>"><?= $sq_vendor['side'] ?></option>
              <option value="">*Select Side</option>
              <option value="Credit">Credit</option>
              <option value="Debit">Debit</option>
            </select>
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="service_tax_no1" id="service_tax_no1" placeholder="Tax No" title="Tax No" style="text-transform: uppercase" value="<?= strtoupper($sq_vendor['service_tax_no']) ?>">
          </div> 
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
            <button class="btn btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
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
$('#cmb_city_id1').select2({minimumInputLength: 1});

$(function(){
$('#frm_update').validate({
  rules:{
          vendor_name1 : { required : true },
          mobile_no1 : { required : true },
          email_id1 : { required : true, email:true },
          address1 : { required : true }, 
          cmb_city_id1 : { required : true },
          contact_person_name1:{ required:true },
          opening_balance1 : { required : true, number: true }, 
          country1 : { required : true }, 
          cust_state1 : { required : true }, 
          side1 : { required : true },
  },
  submitHandler:function(form){
      var vendor_id = $('#vendor_id').val();
      var vendor_login_id = $('#vendor_login_id').val();
      var vendor_name = $('#vendor_name1').val();
      var mobile_no = $('#mobile_no1').val();
      var email_id = $('#email_id1').val();
      var address = $('#address1').val();
      var landline_no = $('#landline_no1').val();
      var contact_person_name = $('#contact_person_name1').val();
      var cmb_city_id1 = $('#cmb_city_id1').val(); 
      var immergency_contact_no = $('#immergency_contact_no1').val();
      var country = $("#country1").val();
      var website = $("#website1").val();
      var bank_name = $("#bank_name1").val();
      var account_no = $("#account_no1").val();
      var branch = $("#branch1").val();
      var ifsc_code = $("#ifsc_code1").val();
      var opening_balance = $('#opening_balance1').val(); 
      var active_flag = $('#active_flag1').val(); 
      var service_tax_no1 = $('#service_tax_no1').val(); 
      var state = $('#cust_state1').val();
      var side = $('#side1').val();

      $('#btn_update').button('loading');
      var base_url = $('#base_url').val();
      $.ajax({
        type: 'post',
        url: base_url+'controller/visa_passport_ticket/visa/vendor/vendor_update.php',
        data:{ vendor_id : vendor_id, vendor_login_id : vendor_login_id, vendor_name : vendor_name, mobile_no : mobile_no, landline_no : landline_no, email_id : email_id, contact_person_name : contact_person_name, immergency_contact_no : immergency_contact_no, cmb_city_id1 : cmb_city_id1, address : address, country :country, website :website, opening_balance : opening_balance, bank_name : bank_name, account_no : account_no, branch : branch, ifsc_code : ifsc_code, active_flag : active_flag, service_tax_no1 :service_tax_no1, state : state, side : side },
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