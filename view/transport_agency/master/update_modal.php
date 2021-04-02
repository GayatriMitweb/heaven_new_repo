<?php

include "../../../model/model.php";

$transport_agency_id = $_POST['transport_agency_id'];
$sq_transport_agency = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$transport_agency_id'"));
$sq_vendor_login = mysql_fetch_assoc(mysql_query("select * from vendor_login where username='$sq_transport_agency[transport_agency_name]' and password='$sq_transport_agency[mobile_no]' and vendor_type='Transport Vendor'"));

$role = $_SESSION['role'];
$value = '';
if($role!='Admin' && $role!="Branch Admin"){ $value="readonly"; }

$mobile_no = $encrypt_decrypt->fnDecrypt($sq_transport_agency['mobile_no'], $secret_key);
$email_id = $encrypt_decrypt->fnDecrypt($sq_transport_agency['email_id'], $secret_key);
?>

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Transporter Information</h4>
      </div>
      <div class="modal-body">
		<form id="frm_transport_agency_update">
    <div class="panel panel-default panel-body app_panel_style feildset-panel">
    <legend>Transporter Information</legend>
		<input type="hidden" id="txt_transport_agency_id" name="txt_transport_agency_id" value="<?php echo $transport_agency_id ?>">
    <input type="hidden" id="vendor_login_id" name="vendor_login_id" value="<?= $sq_vendor_login['login_id'] ?>">
		  <div class="row">
		    <div class="col-md-3 col-sm-6 mg_bt_10">
		      <select id="cmb_city_id" name="cmb_city_id" style="width:100%" class="form-control" title="City Name">
		          <?php $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_transport_agency[city_id]'")); ?>
		          <option value="<?php echo $sq_transport_agency['city_id'] ?>" selected="selected"><?php echo $sq_city['city_name'] ?></option>
		      </select>
		    </div>
		    <div class="col-md-3 col-sm-6 mg_bt_10">
		      <input type="text" class="form-control"  id="txt_transport_agency_name" name="txt_transport_agency_name" placeholder="Transporter Name"  onchange="validate_spaces(this.id);"  Title="Transporter Name" value="<?php echo $sq_transport_agency['transport_agency_name'] ?>">                 
        </div>
		    <div class="col-md-3 col-sm-6 mg_bt_10">
		      <input type="text" class="form-control"  onchange="mobile_validate(this.id);" id="txt_mobile_no" name="txt_mobile_no" placeholder="Mobile Number" title="Mobile Number" value="<?php echo $mobile_no ?>">
		    </div>	
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" class="form-control"  onchange="mobile_validate(this.id);" id="txt_landline_no" name="txt_landline_no" placeholder="Landline Number" title="Landline Number" value="<?php echo $sq_transport_agency['landline_no'] ?>">
        </div> 
      </div>    
      <div class="row">   
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" class="form-control"  id="txt_email_id" name="txt_email_id"  placeholder="Email ID" title="Email ID" value="<?php echo $email_id ?>">
        </div>  
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" class="form-control" id="txt_contact_person_name" name="txt_contact_person_name" placeholder="Contact Person Name" title="Contact Person Name"  value="<?php echo $sq_transport_agency['contact_person_name'] ?>">
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" class="form-control"  onchange="mobile_validate(this.id);" id="immergency_contact_no" name="immergency_contact_no" placeholder="Emergency Contact No" title="Emergency Contact No" value="<?php echo $sq_transport_agency['immergency_contact_no'] ?>">
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <textarea id="txt_transport_agency_address" onchange="validate_address(this.id)" name="txt_transport_agency_address" class="form-control" placeholder="Address" title="Address" rows="1"><?php echo $sq_transport_agency['transport_agency_address'] ?></textarea>
        </div>     
      </div>
		  <div class="row">  
        <div class="col-sm-3 col-xs-6 mg_bt_10">
            <select name="cust_state1" id="cust_state1" title="Select State" style="width:100%" required>
              <?php if($sq_transport_agency['state_id']!='0'){ 
              $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_transport_agency[state_id]'"));
              ?>
              <option value="<?= $sq_transport_agency['state_id'] ?>"><?= $sq_state['state_name'] ?></option>
            <?php } 
            get_states_dropdown() ?>
            </select>
        </div>
       <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" class="form-control" id="country" name="country" placeholder="Country" title="Country" value="<?php echo $sq_transport_agency['country'] ?>">
        </div>     		    
         <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" id="website" name="website" placeholder="Website" title="Website" value="<?php echo $sq_transport_agency['website'] ?>">
         </div>
      </div>
    </div>
    <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
    <legend>Bank Information</legend>
      <div class="row"> 
        <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" id="bank_name" name="bank_name" class="bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?php echo $sq_transport_agency['bank_name'] ?>" >
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
           <input type="text" id="account_name" name="account_name" placeholder="A/c Name" title="A/c Name" value="<?php echo $sq_transport_agency['account_name'] ?>">
        </div> 
        <div class="col-md-3 col-sm-6 mg_bt_10">
           <input type="text" id="account_no" name="account_no" onchange="validate_accountNo(this.id);"  placeholder="A/c No" title="A/c No" value="<?php echo $sq_transport_agency['account_no'] ?>">
        </div>               
        <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" id="branch" name="branch" onchange="validate_branch(this.id);" placeholder="Branch" title="Branch" value="<?php echo $sq_transport_agency['branch'] ?>">
        </div>
      </div>
      <div class="row"> 
        <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="ifsc_code" id="ifsc_code" onchange="validate_IFSC(this.id)" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" value="<?= $sq_transport_agency['ifsc_code']?>" style="text-transform: uppercase;">
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
            <input type="text" name="service_tax_no" id="service_tax_no" placeholder="Tax No" title="Tax No"  onchange="validate_alphanumeric(this.id)" value="<?= strtoupper($sq_transport_agency['service_tax_no'])?>" style="text-transform: uppercase;">
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
             <input type="text" id="supp_pan" name="supp_pan" onchange="validate_alphanumeric(this.id)" value="<?= $sq_transport_agency['pan_no']?>"" placeholder="PAN/TAN No" title="PAN/TAN No" style="text-transform: uppercase;">
        </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="hidden" id="opening_balance" name="opening_balance" placeholder="Opening Balance" title="Opening Balance" value="<?php echo $sq_transport_agency['opening_balance'] ?>" <?= $value ?>  onchange="validate_balance(this.id)">
          </div>
          <div class="col-sm-3 mg_bt_10">
            <input type="hidden" id="as_of_date1" name="as_of_date1" placeholder="*As of Date" title="As of Date" value="<?= get_date_user($sq_transport_agency['as_of_date']) ?>">
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <select class="hidden" name="side1" id="side1" title="Select side" disabled>
              <option value="<?php echo $sq_transport_agency['side'] ?>"><?php echo $sq_transport_agency['side'] ?></option>
              <option value="">*Select Side</option>
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
          <option value="<?= $sq_transport_agency['active_flag'] ?>"><?= $sq_transport_agency['active_flag'] ?></option>
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
$('#update_modal').modal('show');
$('#cust_state1').select2();
$('#as_of_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
city_lzloading('#cmb_city_id');
///////////////////////***Transport Agency Master Update start*********//////////////
$(function(){
  $('#frm_transport_agency_update').validate({
    rules:{
            cmb_city_id : { required : true },
            txt_transport_agency_name : { required : true },
            side1 : { required : true },
            as_of_date1 : { required : true },
    },

    submitHandler:function(form){
        var base_url = $("#base_url").val();
        var transport_agency_id = $("#txt_transport_agency_id").val();
        var vendor_login_id = $('#vendor_login_id').val();
        var city_id = $("#cmb_city_id").val();
        var immergency_contact_no = $("#immergency_contact_no").val();
        var country = $("#country").val();
        var website = $("#website").val();
        var bank_name = $("#bank_name").val();
        var account_name = $("#account_name").val();
        var account_no = $("#account_no").val();
        var ifsc_code = $("#ifsc_code").val();
        var branch =$("#branch").val();
        var transport_agency_name = $("#txt_transport_agency_name").val();
        var mobile_no = $("#txt_mobile_no").val();
        var landline_no = $("#txt_landline_no").val();
        var email_id = $("#txt_email_id").val();
        var contact_person_name = $("#txt_contact_person_name").val();
        var transport_agency_address = $("#txt_transport_agency_address").val();
        var opening_balance = $("#opening_balance").val();
        var gl_id = $('#gl_id').val();
        var active_flag = $('#active_flag').val();
        var service_tax_no = $('#service_tax_no').val();
        var state = $('#cust_state1').val();
        var side = $('#side1').val();
        var supp_pan = $('#supp_pan').val();
        var as_of_date = $('#as_of_date1').val();

        var add = validate_address('txt_transport_agency_address');
        if(!add){
          error_msg_alert('More than 155 characters are not allowed.');
          return false;
        }
        $('#btn_update').button('loading');

        $.post( 

               base_url+"controller/group_tour/transport_agency/transport_agency_master_update_c.php",

               {  transport_agency_id : transport_agency_id, vendor_login_id : vendor_login_id, city_id : city_id, transport_agency_name : transport_agency_name, mobile_no : mobile_no, landline_no :landline_no, email_id : email_id, contact_person_name : contact_person_name, immergency_contact_no : immergency_contact_no, transport_agency_address : transport_agency_address,country : country, website : website, opening_balance : opening_balance, active_flag : active_flag, service_tax_no : service_tax_no, bank_name : bank_name ,account_no : account_no, branch : branch,ifsc_code : ifsc_code, state : state,side : side ,account_name : account_name, supp_pan : supp_pan,as_of_date : as_of_date},
               function(data) {  
                    msg_alert(data);  
                    $('#update_modal').modal('hide');                   
                    $('#update_modal').on('hidden.bs.modal', function(){
                      list_reflect();
                    });
                     $('#btn_update').button('reset');    
               });
    }

  });

});

///////////////////////***Transport Agency Master Update end*********//////////////

</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>