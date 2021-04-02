<?php

include "../../../model/model.php";

?>

<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Excursion Details</h4>
      </div>
      <div class="modal-body">
      	<div class="panel panel-default panel-body app_panel_style feildset-panel">
        <legend>Excursion Supplier Information</legend>
		<div class="row">
			<div class="col-md-3 col-sm-6 mg_bt_10">
				<select name="city_id" id="city_id" title="Select City" style="width:100%">
				</select>
			</div>
			<div class="col-md-3 col-sm-6 mg_bt_10">
				<input type="text" id="vendor_name" name="vendor_name" onchange="validate_spaces(this.id);" placeholder="*Company Name" title="Company Name">
			</div>
			<div class="col-md-3 col-sm-6 mg_bt_10">
				<input type="text" id="mobile_no" name="mobile_no" onchange="mobile_validate(this.id);" placeholder="Mobile No" title="Mobile No">
			</div>
			<div class="col-md-3 col-sm-6 mg_bt_10">
                <input type="text" class="form-control" id="landline_no" onchange="mobile_validate(this.id);" name="landline_no" placeholder=" Landline Number" title="Landline Number">
            </div> 			
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-6 mg_bt_10">
				<input type="text" id="email_id" name="email_id" placeholder="Email ID" title="Email ID">
			</div>
			<div class="col-md-3 col-sm-6 ">
                <input type="text" class="form-control" id="txt_email_id_1" name="txt_email_id_1"  placeholder="Alternative Email ID 1" title="Alternative Email ID 1" onchange="validate_email(this.id)">
            </div>
			<div class="col-md-3 col-sm-6 ">
                  <input type="text" class="form-control" id="txt_email_id_2" name="txt_email_id_2"  placeholder="Alternative Email ID 2" title="Alternative Email ID 2" onchange="validate_email(this.id)">
              </div>
			<div class="col-md-3 col-sm-6 mg_bt_10">
				<input type="text" id="concern_person_name" name="concern_person_name" placeholder="Contact Person" title="Contact Person">
			</div>
			<div class="col-md-3 col-sm-6 mg_bt_10">
               <input type="text" id="immergency_contact_no" onchange="mobile_validate(this.id);" name="immergency_contact_no" placeholder="Emergency Contact No" title="Emergency Contact No">
          	</div> 
          	<div class="col-md-3 col-sm-6 mg_bt_10">
				<textarea name="address" id="address" onchange="validate_address(this.id);" placeholder="Address" title="Address" rows="1"></textarea>
			</div>
			<div class="col-sm-3 col-xs-6 mg_bt_10">
	            <select name="state" id="state" title="Select State" style="width:100%" required>
	              <?php get_states_dropdown() ?>
	            </select>
	        </div> 
			<div class="col-md-3 col-sm-6 mg_bt_10">
              	<input type="text" id="country" name="country" placeholder="Country" title="Country">
          	</div> 			
		</div>
		<div class="row">

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
              	<input type="text" name="branch" id="branch" onchange="validate_branch(this.id);" placeholder="Branch" title="Branch">
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
             <input type="text" id="supp_pan" name="supp_pan" onchange="validate_alphanumeric(this.id);" placeholder="PAN/TAN No" title="PAN/TAN No" style="text-transform: uppercase;">
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
		<div class="row mg_tp_20 text-center">
			<div class="col-md-12">
				<button class="btn btn-sm btn-success" id="btn_save_e"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>	
			</div>    
		</div>
      </div>      
    </div>
  </div>
</div>
</form>
<script>
$('#save_modal').modal('show');
$("#state").select2();
city_lzloading('#city_id');

$('#as_of_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
today_date('as_of_date');
///////////////////////***Hotel Master Save start*********//////////////
$(function(){
  $('#frm_save').validate({
    rules:{
			vendor_name: { required : true },
			city_id: { required : true },
			active_flag : { required : true },
			side : { required : true },
			as_of_date : { required : true },
    },
    submitHandler:function(form){
	    var base_url = $("#base_url").val();
		var vendor_name = $('#vendor_name').val();
		var city_id = $('#city_id').val();
		var mobile_no = $('#mobile_no').val();
		var email_id = $('#email_id').val();
		var email_id_1 = $("#txt_email_id_1").val();
        var email_id_2 = $("#txt_email_id_2").val();
		var landline_no = $('#landline_no').val();
		var concern_person_name = $('#concern_person_name').val();
	   	var immergency_contact_no = $("#immergency_contact_no").val();
	    var country = $("#country").val();
	    var website = $("#website").val();
	    var bank_name = $("#bank_name").val();
	    var branch = $("#branch").val();
	    var account_name = $("#account_name").val();
	    var account_no = $("#account_no").val();
	    var ifsc_code = $("#ifsc_code").val();
		var opening_balance = $('#opening_balance').val();
	 	var address = $('#address').val();
	  	var active_flag = $('#active_flag').val();
	  	var service_tax_no = $('#service_tax_no').val();
	  	var state = $('#state').val();
	  	var side = $('#side').val();
	  	var supp_pan = $('#supp_pan').val();
        var as_of_date = $('#as_of_date').val();
	    var add = validate_address('address');
      if(!add){
        error_msg_alert('More than 155 characters are not allowed.');
        return false;
      }
	  $('#btn_save_e').button('loading');
      $.post( 
               base_url+"controller/site_seeing/vendor/vendor_save.php",
               { vendor_name : vendor_name, city_id : city_id, mobile_no : mobile_no, landline_no : landline_no, email_id : email_id, concern_person_name : concern_person_name, immergency_contact_no : immergency_contact_no,opening_balance : opening_balance, country : country, website : website, address : address, active_flag : active_flag, bank_name : bank_name, account_no : account_no, branch : branch, ifsc_code : ifsc_code ,service_tax_no : service_tax_no, state : state, side : side, account_name:account_name, supp_pan : supp_pan,as_of_date : as_of_date, email_id_1:email_id_1,email_id_2:email_id_2 },
	               function(data) {  
	                    var msg = data.split('--');
	                    if(msg[0]=="error"){
	                      msg_alert(data);  
	                      $('#btn_save_e').button('reset');
	                    }
	                    else{
	                      msg_alert(data);  
	                      $('#save_modal').modal('hide');
	                      $('#btn_save_e').button('reset');
	                      $('#save_modal').on('hidden.bs.modal', function(){
	                        list_reflect();
	                      });
	                    }                       

	               });

    }

  });

});

///////////////////////***Hotel Master Save ens*********//////////////

</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>