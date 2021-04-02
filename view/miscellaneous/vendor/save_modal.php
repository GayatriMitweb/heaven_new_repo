<?php
include "../../../../model/model.php";
?>

<div class="modal fade" id="save_modal_1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Visa Details</h4>
      </div>
      <div class="modal-body">
       <form id="frm_save" class="no-marg">
       <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">
        <legend>Visa Supplier Information</legend>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select id="cmb_city_id" name="cmb_city_id" class="city_master_dropdown" style="width:100%" title="Select City Name">
              <?php get_cities_dropdown(); ?>
            </select>
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="vendor_name" class="form-control" name="vendor_name" onchange="validate_spaces(this.id);" placeholder="*Company Name" title="Company Name">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="mobile_no" class="form-control" name="mobile_no" placeholder="*Mobile No" onchange="mobile_validate(this.id);" title="Mobile No">
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" onchange="mobile_validate(this.id);" id="landline_no" name="landline_no" placeholder="Landline Number" title="Landline Number">
          </div>         
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" id="email_id" name="email_id" placeholder="*Email ID" title="Email ID" >
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" id="contact_person_name" name="contact_person_name" placeholder="Contact Person Name" title="Contact Person Name">
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="immergency_contact_no" name="immergency_contact_no" onchange="mobile_validate(this.id);" placeholder="Emergency Contact No" title="Emergency Contact No" class="form-control">
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
          <textarea id="address" class="form-control" name="address" placeholder="Address" onchange="validate_address(this.id)" title="Address" rows="1"></textarea>
        </div>         
      </div>
      <div class="row">
         <div class="col-sm-3 col-xs-6 mg_bt_10_xs">
            <select name="state" id="state" title="Select State" style="width:100%">
              <?php get_states_dropdown() ?>
            </select>
          </div> 
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
          <input type="text" id="country" name="country" class="form-control" placeholder="Country" title="Country">
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
          <input type="text" id="website" name="website" class="form-control" placeholder="Website" title="Website">
        </div>
        </div> 
      </div>

      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
       <legend>Bank Information</legend>
      <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" title="Bank Name" class="bank_suggest" >
        </div>
         <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="account_name" id="account_name" placeholder="A/c Name" class="form-control" title="A/c Name">
        </div> 
         <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="account_no" id="account_no" onchange="validate_accountNo(this.id);" placeholder="A/c No" class="form-control" title="A/c No">
        </div> 
        <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="branch" id="branch" class="form-control" placeholder="Branch" onchange="validate_branch(this.id);" title="Branch">
        </div>
      </div>
      <div class="row"> 
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
          <input type="text" name="ifsc_code" id="ifsc_code" onchange="validate_IFSC(this.id);" class="form-control" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" style="text-transform: uppercase;">
        </div>
         <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <input type="text" id="opening_balance" name="opening_balance" class="form-control" placeholder="Opening Balance" title="Opening Balance" value="0"  onchange="validate_balance(this.id);">
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="side" id="side" title="Select side">
              <option value="">*Select Side</option>
              <option value="Credit">Credit</option>
              <option value="Debit">Debit</option>
            </select>
          </div> 
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <input type="text" name="service_tax_no" id="service_tax_no" class="form-control" onchange="validate_alphanumeric(this.id);" placeholder="Tax No" title="Tax No"   style="text-transform: uppercase;">
        </div>
      </div>
      <div class="row">
         <div class="col-md-3 col-sm-6 mg_bt_10">
             <input type="text" id="supp_pan" name="supp_pan" onchange="validate_alphanumeric(this.id)" placeholder="PAN/TAN No" title="PAN/TAN No"  style="text-transform: uppercase;">
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="active_flag" class="form-control hidden" id="active_flag" title="Status" style="width: 100%;">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div> 
      </div>
    </div>
      <div class="row text-center mg_tp_20">
          <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
          </div>
        </div>  
        </form>
      </div>      
    </div>
  </div>
</div>
<script>
$('#save_modal_1').modal('show');
$('#cmb_city_id,#state').select2();
$(function(){
$('#frm_save').validate({
  rules:{
          vendor_name : { required : true },
          cmb_city_id : { required: true },
          side : { required : true },
          mobile_no : { required : true },
          email_id : { required : true },
         
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
      var account_name = $("#account_name").val();
      var account_no = $("#account_no").val();
      var ifsc_code = $("#ifsc_code").val();
      var email_id = $('#email_id').val();
      var address = $('#address').val();
      var opening_balance = $('#opening_balance').val();
      var active_flag = $('#active_flag').val();
      var service_tax_no = $('#service_tax_no').val();
      var state = $('#state').val();
      var side = $('#side').val();
      var supp_pan = $('#supp_pan').val();

      $('#btn_save').button('loading');
      var base_url = $('#base_url').val();
      $.ajax({
        type: 'post',
        url: base_url+'controller/visa_passport_ticket/visa/vendor/vendor_save.php',
        data:{ vendor_name : vendor_name, mobile_no : mobile_no, email_id : email_id, landline_no : landline_no,contact_person_name : contact_person_name, immergency_contact_no : immergency_contact_no, cmb_city_id : cmb_city_id,country : country, website : website, address : address,  opening_balance : opening_balance, active_flag : active_flag,service_tax_no : service_tax_no, bank_name : bank_name, account_no : account_no, branch : branch, ifsc_code : ifsc_code, state : state, side : side, account_name : account_name,supp_pan : supp_pan},
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