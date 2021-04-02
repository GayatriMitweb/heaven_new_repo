<?php
include "../../../../model/model.php";
?>

<div class="modal fade" id="save_modal_1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Visa Details</h4>
      </div>
      <div class="modal-body">
        <form id="frm_save" class="no-marg">
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select id="cmb_city_id" name="cmb_city_id" class="city_master_dropdown" style="width:100%" title="Select City Name">
              <?php get_cities_dropdown(); ?>
            </select>
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="vendor_name" class="form-control" name="vendor_name" placeholder="*Company Name" title="Company Name">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="mobile_no" class="form-control" name="mobile_no" placeholder="*Mobile No" title="Mobile No">
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" id="landline_no" name="landline_no" placeholder="Landline Number" title="Landline Number">
          </div>         
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" id="email_id" name="email_id" placeholder="*Email ID" title="Email ID">
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" id="contact_person_name" name="contact_person_name" placeholder="*Contact Person Name" title="Contact Person Name">
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="immergency_contact_no" name="immergency_contact_no" placeholder="Emergency Contact No" title="Emergency Contact No" class="form-control">
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
          <textarea id="address" class="form-control" name="address" placeholder="*Address" title="Address" rows="1"></textarea>
        </div>         
      </div>
      <div class="row">
         <div class="col-sm-3 col-xs-6 mg_bt_10">
            <select name="state" id="state" title="Select State" style="width:100%">
              <?php get_states_dropdown() ?>
            </select>
          </div> 
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" id="country" name="country" class="form-control" placeholder="*Country" title="Country">
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" id="website" name="website" class="form-control" placeholder="Website" title="Website">
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" title="Bank Name" class="bank_suggest" >
        </div> 
      </div>
      <div class="row">
         <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="account_no" id="account_no" placeholder="Account No" class="form-control" title="Account No">
        </div> 
        <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="branch" id="branch" class="form-control" placeholder="Branch" title="Branch">
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" name="ifsc_code" id="ifsc_code" class="form-control" placeholder="IFSC/Swift Code" title="IFSC/Swift Code">
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" id="opening_balance" name="opening_balance" class="form-control" placeholder="Opening Balance" title="Opening Balance" value="0">
        </div>
      </div>
      <div class="row">   
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select name="side" id="side" title="Select side">
              <option value="">*Select Side</option>
              <option value="Credit">Credit</option>
              <option value="Debit">Debit</option>
            </select>
          </div> 
        <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="service_tax_no" id="service_tax_no" class="form-control" placeholder="Tax No" title="Tax No" style="text-transform: uppercase">
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
            <select name="active_flag" class="form-control hidden" id="active_flag" title="Status" style="width: 100%;">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
        </div> 
      </div>
      <div class="row text-center mg_tp_20">
          <div class="col-md-12">
            <button class="btn btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
          </div>
        </div>  
        </form>
      </div>      
    </div>
  </div>
</div>
<script>
$('#save_modal_1').modal('show');
$('#state').select2();
$('#cmb_city_id').select2({minimumInputLength: 1});

$(function(){
$('#frm_save').validate({
  rules:{
          vendor_name : { required : true },
          cmb_city_id : { required: true },
          mobile_no : { required : true },
          email_id : { required : true, email:true },
          landline_no : { number:true},
          address : { required : true }, 
          contact_person_name : { required : true },        
          opening_balance : { required : true, number: true },  
          country:{ required : true },
          state : { required : true },
          side : { required : true },

  },

  submitHandler:function(form){
      var vendor_name = $('#vendor_name').val();
      var contact_person_name = $('#contact_person_name').val();    
      var cmb_city_id = $('#cmb_city_id').val();
      var mobile_no = $('#mobile_no').val();
      var landline_no = $('#landline_no').val();
      var immergency_contact_no = $("#immergency_contact_no").val();
      var country = $("#country").val();
      var website = $("#website").val();
      var bank_name = $("#bank_name").val();
      var branch = $("#branch").val();
      var account_no = $("#account_no").val();
      var ifsc_code = $("#ifsc_code").val();
      var email_id = $('#email_id').val();
      var address = $('#address').val();
      var opening_balance = $('#opening_balance').val();
      var active_flag = $('#active_flag').val();
      var service_tax_no = $('#service_tax_no').val();
      var state = $('#state').val();
      var side = $('#side').val();

      $('#btn_save').button('loading');
      var base_url = $('#base_url').val();
      $.ajax({
        type: 'post',
        url: base_url+'controller/visa_passport_ticket/visa/vendor/vendor_save.php',
        data:{ vendor_name : vendor_name, mobile_no : mobile_no, email_id : email_id, landline_no : landline_no,contact_person_name : contact_person_name, immergency_contact_no : immergency_contact_no, cmb_city_id : cmb_city_id,country : country, website : website, address : address,  opening_balance : opening_balance, active_flag : active_flag,service_tax_no : service_tax_no, bank_name : bank_name, account_no : account_no, branch : branch, ifsc_code : ifsc_code, state : state, side : side},
        success: function(result){
          $('#btn_save').button('reset');
          var msg = result.split('-');
          if(msg[0]=='error'){
            msg_alert(result);
          }
          else{
            msg_alert(result);
            reset_form('frm_save');
            $('#save_modal_1').modal('hide');  
            list_reflect();
          }
        }
      });
  }

});
});

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>