<?php

include "../../model/model.php";

?>

<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Other Supplier  Details</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-default panel-body app_panel_style feildset-panel">
        <legend>Other Supplier Information</legend>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select id="cmb_city_id" name="cmb_city_id" class="city_master_dropdown" style="width:100%" title="Select City Name">
            </select>
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="vendor_name" id="vendor_name" title="Company Name" placeholder="*Company Name"  onchange="validate_spaces(this.id);">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="profession" id="profession" title="Supplier Occupation" placeholder="Occupation">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="mobile_no" id="mobile_no" onchange="mobile_validate(this.id);" title="Mobile No" placeholder="Mobile No">
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" id="landline_no" name="landline_no" onchange="mobile_validate(this.id);" placeholder="Landline Number" title="Landline Number">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" id="contact_person_name" name="contact_person_name" placeholder="Contact Person Name" title="Contact Person Name">
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="immergency_contact_no" name="immergency_contact_no" placeholder="Emergency Contact No" onchange="mobile_validate(this.id);" title="Emergency Contact No">
          </div>  
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <textarea id="address" name="address" title="Address" placeholder="Address" onchange="validate_address(this.id)" rows="1"></textarea>
          </div>
        </div>
        <div class="row">
           <div class="col-sm-3 col-xs-6 mg_bt_10">
            <select name="state" id="state" title="Select State" style="width:100%" required>
              <?php get_states_dropdown() ?>
            </select>
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="email_id" id="email_id" title="Email ID" placeholder="Email ID">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="country" name="country" placeholder="Country" title="Country">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" id="website" name="website" placeholder="Website" title="Website">
          </div>
        </div>
      </div>
       <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
        <legend>Bank Information</legend>
        <div class="row">
           <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="bank_name" id="bank_name" placeholder="Bank Name" title="Bank Name" class="bank_suggest">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="account_name" id="account_name" placeholder="A/c Name" title="A/c Name">
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="account_no" id="account_no" onchange="validate_accountNo(this.id);" placeholder="A/c No" title="A/c No">
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" name="branch" id="branch" placeholder="Branch" title="Branch" onchange="validate_branch(this.id);">
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="ifsc_code" id="ifsc_code" onchange="validate_IFSC(this.id);" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" style="text-transform: uppercase;">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="service_tax_no" id="service_tax_no" onchange="validate_alphanumeric(this.id)" placeholder="Tax No" title="Tax No" style="text-transform: uppercase;">
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" id="supp_pan" name="supp_pan" onchange="validate_alphanumeric(this.id)" placeholder="PAN/TAN No" title="PAN/TAN No" style="text-transform: uppercase;">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="hidden" id="opening_balance" name="opening_balance" placeholder="Opening Balance" onchange="validate_balance(this.id)" title="Opening Balance" value="0.00">
          </div>    
						<div class="col-sm-3 mg_bt_10">
							<input type="hidden" id="as_of_date" name="as_of_date" placeholder="*As of Date" title="As of Date">
						</div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select class="hidden" name="side" id="side" title="Select side">
              <option value="Credit">Credit</option>
              <option value="Debit">Debit</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6">
            <select name="active_flag" id="active_flag" title="Status" class="hidden">
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
      </div>      
    </div>
  </div>
</div>
</form>

<script>
$('#save_modal').modal('show');
$('#state').select2();
city_lzloading('#cmb_city_id');
$('#as_of_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$(function(){
  $('#frm_save').validate({
    rules:{
            vendor_name:{ required:true },
            cmb_city_id : { required: true },
            active_flag:{ required:true }, 
            side : { required : true },
			as_of_date : { required : true },
    },
    submitHandler:function(form){
         
        var vendor_name = $('#vendor_name').val(); 
        var cmb_city_id = $('#cmb_city_id').val();      
        var profession = $('#profession').val();   
        var service_tax_no = $('#service_tax_no').val();    
        var mobile_no = $('#mobile_no').val(); 
        var landline_no = $('#landline_no').val();
        var contact_person_name = $("#contact_person_name").val();
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
        var state = $('#state').val();   
        var side = $('#side').val(); 
        var supp_pan = $('#supp_pan').val();
        var as_of_date = $('#as_of_date').val();
        var add = validate_address('address');
        if(!add){
          error_msg_alert('More than 155 characters are not allowed.');
          return false;
        }
        $('#btn_save').button('loading');
        $.post( 
               base_url()+"controller/other_vendors/vendor_save.php",
               { vendor_name : vendor_name, profession : profession, service_tax_no : service_tax_no, mobile_no : mobile_no, landline_no : landline_no,contact_person_name : contact_person_name, immergency_contact_no :  immergency_contact_no, cmb_city_id : cmb_city_id, country : country, website : website, address : address, email_id : email_id, address : address, opening_balance : opening_balance, active_flag : active_flag, bank_name : bank_name, account_no : account_no, branch : branch, ifsc_code : ifsc_code , state : state,side :side,account_name : account_name, supp_pan : supp_pan,as_of_date : as_of_date },
               function(data) {                  
                  msg_alert(data);
                  $('#btn_save').button('reset');
                  $('#save_modal').modal('hide');
                  list_reflect();
               });  

    }
  });
});

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>