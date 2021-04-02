<?php

include "../../../model/model.php";

?>

<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Transporter Details</h4>
      </div>
      <div class="modal-body">
			<form id="frm_transport_agency_save">
      <div class="panel panel-default panel-body app_panel_style feildset-panel">
        <legend>Transporter Information</legend>
			  <div class="row">
			    <div class="col-md-3 col-sm-6 mg_bt_10">
			      <select id="cmb_city_id" name="cmb_city_id" style="width:100%" class="form-control city_master_dropdown" title="Select City Name">
			      </select>
			    </div>
			    <div class="col-md-3 col-sm-6 mg_bt_10">
			      <input type="text" class="form-control" onchange="validate_spaces(this.id);"  id="txt_transport_agency_name" title="Transporter Name" name="txt_transport_agency_name" placeholder="*Transporter name">                               
			    </div>  
			    <div class="col-md-3 col-sm-6 mg_bt_10">
			      <input type="text" class="form-control" onchange="mobile_validate(this.id);"  id="txt_mobile_no" name="txt_mobile_no" title="Mobile Number" placeholder="Mobile Number">
			    </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" onchange="mobile_validate(this.id);"  id="txt_landline_no" title="Landline No" name="txt_landline_no" placeholder="Landline Number">
          </div>	                  
			  </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control"  id="txt_email_id" name="txt_email_id"  placeholder="Email ID" title="Email ID">
          </div>    
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" id="txt_contact_person_name" title="Contact Person" name="txt_contact_person_name" placeholder="Contact Person">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" class="form-control" onchange="mobile_validate(this.id);" title="Emergency Contact No" id="immergency_contact_no" name="immergency_contact_no" placeholder="Emergency Contact No">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <textarea id="txt_transport_agency_address" onchange="validate_address(this.id)" name="txt_transport_agency_address" class="form-control" placeholder="Address" title="Address" rows="1"></textarea>
          </div> 
        </div>    
        
        <div class="row">
           <div class="col-sm-3 col-xs-6 mg_bt_10">
                  <select name="state" id="state" title="Select State" style="width:100%" required>
                    <?php get_states_dropdown() ?>
                  </select>
            </div>  
         <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="country" id="country" placeholder="Country" title="Country">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="website" id="website" placeholder="Website" title="Website">
          </div>
        </div>
      </div>

      <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
       <legend>Bank Information</legend>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="bank_name" id="bank_name" placeholder="Bank Name" title="Bank Name" class="bank_suggest" >
          </div>        
           <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="account_name" id="account_name" placeholder="A/c Name" title="A/c Name">
          </div> 
           <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="account_no" id="account_no" onchange="validate_accountNo(this.id);" placeholder="A/c No" title="A/c No">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="branch" id="branch"  onchange="validate_branch(this.id);" placeholder="Branch" title="Branch">
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="ifsc_code" id="ifsc_code" onchange="validate_IFSC(this.id)" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" style="text-transform: uppercase;">
          </div>
           <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="service_tax_no" id="service_tax_no" onchange="validate_alphanumeric(this.id)" placeholder="Tax No" title="Tax No" style="text-transform: uppercase;">
          </div>
           <div class="col-md-3 col-sm-6 mg_bt_10">
             <input type="text" id="supp_pan" name="supp_pan" onchange="validate_alphanumeric(this.id)"  placeholder="PAN/TAN No" title="PAN/TAN No" style="text-transform: uppercase;">
          </div> 
         <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="hidden" id="opening_balance" name="opening_balance" placeholder="Opening Balance" title="Opening Balance" value="0.00"  onchange="validate_balance(this.id)">
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
          <div class="col-md-3 col-sm-6 mg_bt_10">
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
			</form>
      </div>      
    </div>
  </div>
</div>

<script>
$('#save_modal').modal('show');
$('#state').select2();
$('#as_of_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
city_lzloading('#cmb_city_id');
///////////////////////***Transport Agency Master save start*********//////////////
$(function(){
  $('#frm_transport_agency_save').validate({
    rules:{
            cmb_city_id : { required : true },
            txt_transport_agency_name : { required : true },
            as_of_date: { required : true },
    },

    submitHandler:function(form){
        var base_url = $("#base_url").val();
        var city_id = $("#cmb_city_id").val();
        var transport_agency_name = $("#txt_transport_agency_name").val();
        var mobile_no = $("#txt_mobile_no").val();
        var landline_no = $("#txt_landline_no").val();
        var email_id = $("#txt_email_id").val();
        var contact_person_name = $("#txt_contact_person_name").val();
        var transport_agency_address = $("#txt_transport_agency_address").val();  
        var immergency_contact_no = $("#immergency_contact_no").val();
        var country = $("#country").val();
        var website = $("#website").val();
        var opening_balance = $('#opening_balance').val(); 
        var active_flag = $('#active_flag').val();
        var service_tax_no = $('#service_tax_no').val(); 
        var bank_name = $("#bank_name").val();
        var account_name = $("#account_name").val();
        var account_no = $("#account_no").val();
        var branch = $("#branch").val();
        var ifsc_code = $("#ifsc_code").val();
        var state = $('#state').val();
        var side = $('#side').val();
        var supp_pan = $('#supp_pan').val();
        var as_of_date = $('#as_of_date').val();

        var add = validate_address('txt_transport_agency_address');
        if(!add){
          error_msg_alert('More than 155 characters are not allowed.');
          return false;
        }
        $('#btn_save').button('loading');
        $.post( 

               base_url+"controller/group_tour/transport_agency/transport_agency_master_c.php",

               {  city_id : city_id, transport_agency_name : transport_agency_name, mobile_no : mobile_no, landline_no :landline_no, email_id : email_id, contact_person_name : contact_person_name, immergency_contact_no : immergency_contact_no, transport_agency_address : transport_agency_address, country : country, website : website, opening_balance : opening_balance, active_flag : active_flag, service_tax_no : service_tax_no, bank_name : bank_name, account_no: account_no,branch : branch,ifsc_code : ifsc_code, state : state,side : side,account_name : account_name,supp_pan : supp_pan,as_of_date : as_of_date},

               function(data) {  
                      msg_alert(data); 
                      $('#save_modal').modal('hide');
                      $('#save_modal').on('hidden.bs.modal', function(){
                        list_reflect();
                      });
                      $('#btn_save').button('reset');                      
               });
    }

  });

});

///////////////////////***Transport Agency Master save end*********//////////////

</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>