<?php
include "../../../../model/model.php";
?> 
<form id="frm_car_rental_vendor_save" class="no-marg">
<div class="modal fade" id="vendor_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Car Supplier Details</h4>
      </div>
      <div class="modal-body">
      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">
        <legend>Car Supplier Information</legend>
        <div class="row">
          <div class="col-sm-3 col-sm-6 mg_bt_10">
                <select id="cmb_city_id" name="cmb_city_id" class="city_master_dropdown" style="width:100%" title="Select City Name">
                </select>
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="vendor_name" class="form-control" onchange="validate_spaces(this.id);" name="vendor_name" placeholder="*Company Name" title="Company Name">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="mobile_no" class="form-control"  onchange="mobile_validate(this.id);" name="mobile_no" placeholder="Mobile No" title="Mobile No">
          </div>          
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="landline_no" class="form-control"  onchange="mobile_validate(this.id);" name="landline_no" placeholder="Landline No" title="Landline No">
          </div>                    
        </div>
        <div class="row">
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="email_id" class="form-control" name="email_id" placeholder="Email ID" title="Email ID">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="contact_person_name" class="form-control" name="contact_person_name" placeholder="Contact Person Name" title="Contact Person Name">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="immergency_contact_no" class="form-control"  onchange="mobile_validate(this.id);" name="immergency_contact_no" placeholder="Emergency Contact No" title="Emergency Contact No">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <textarea name="address" id="address" class="form-control" title="Address" onchange="validate_address(this.id)" placeholder="Address" rows="1"></textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3 col-xs-6 mg_bt_10">
            <select name="state" id="state" title="Select State" style="width:100%" required>
              <?php get_states_dropdown() ?>
            </select>
          </div> 
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="country" class="form-control" name="country" placeholder="Country" title="Country">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="website" name="website" placeholder="Website" title="Website">
          </div>
        </div>
      </div>
      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
      <legend>Bank Information</legend> 
        <div class="row">
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="bank_name" class="bank_suggest"  name="bank_name" placeholder="Bank Name" title="Bank Name" >
          </div>
           <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="account_name" class="form-control" name="account_name" placeholder="A/c Name" title="A/c Name" >
          </div> 
           <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="account_no" class="form-control" onchange="validate_accountNo(this.id);" name="account_no" placeholder="A/c No" title="A/c No" >
          </div> 
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="branch" class="form-control" onchange="validate_branch(this.id);" name="branch" placeholder="Branch" title="Branch">
          </div>  
        </div>  
        <div class="row"> 
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="ifsc_code" class="form-control"onchange="validate_IFSC(this.id);" name="ifsc_code" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" style="text-transform: uppercase;">
          </div>
           <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" name="service_tax_no" class="form-control" id="service_tax_no" placeholder="Tax No" title="Tax No" onchange="validate_alphanumeric(this.id)" style="text-transform: uppercase;">
          </div>
            <div class="col-md-3 col-sm-6 mg_bt_10">
             <input type="text" id="supp_pan" name="supp_pan" onchange="validate_alphanumeric(this.id);" placeholder="PAN/TAN No" title="PAN/TAN No" style="text-transform: uppercase;">
            </div> 
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="hidden" id="opening_balance" class="form-control" name="opening_balance" placeholder="Opening Balance" title="Opening Balance" value="0" onchange="validate_balance(this.id)">
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
            <div class="col-sm-3 col-sm-6 mg_bt_10">
              <select name="active_flag" id="active_flag" title="Status" class="form-control hidden" style="width: 100%;">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
               </select>
             </div>
        </div>
      </div>

        <div class="row hidden"><div class="col-md-12"><div class="table-responsive">
            <table id="tbl_dynamic_car_rental_vehicle" name="tbl_dynamic_car_rental_vehicle" class="table table-bordered " style="width: 965px;">
                <tr>

                    <td><input class="css-checkbox" id="chk_vehicle1" type="checkbox" checked><label class="css-label" for="chk_vehicle1"> <label></td>

                    <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>

                    <td><input type="text" id="vehicle_name1" name="vehicle_name1" onchange="validate_spaces(this.id);"  placeholder="*Vehicle Name" title="Vehicle Name" class="form-control"/></td>

                    <td><input type="text" id="vehicle_no1" name="vehicle_no" onchange="validate_spaces(this.id);"  placeholder="Vehicle No" title="Vehicle No" class="form-control" style="text-transform: uppercase;"/></td>

                    <td><select id="vehicle_type1" name="vehicle_type" title="Vehicle Type">
                          <option value="AC">AC</option>
                          <option value="Non AC">Non AC</option>
                    </select></td>

                    <td><input type="text" id="vehicle_driver_name1" onchange="fname_validate(this.id);" name="vehicle_driver_name" placeholder="Driver Name" title="Driver Name" class="form-control"/></td>

                    <td><input type="text" id="vehicle_mobile_no1" name="vehicle_mobile_no" placeholder="Mobile No" title="Mobile No" class="form-control" onchange="mobile_validate(this.id);"/></td>

                    <td><input type="text" id="vehicle_year_of_purchase1" name="vehicle_year_of_purchase" placeholder="Purchase Year" title="Purchase Year" class="form-control" onchange="validate_year(this.id);"/></td>

                    <td><input type="text" id="vehicle_rate1" name="vehicle_rate" placeholder="Rate KM" title="Rate KM" class="form-control" onchange="validate_balance(this.id);"/></td>

                </tr>                                

            </table>

        </div></div></div>
       </div>

        <div class="row text-center mg_tp_20 mg_bt_20">
          <div class="col-md-12">
              <button id="btn_vendor_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
          </div>
        </div>

      </div>     

    </div>

  </div>

</div>

</form>

<script>
$('#vendor_save_modal').modal('show');
$(document).ready(function() {
$("#state").select2();
$('#as_of_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#cmb_city_id').select2({minimumInputLength: 1});
city_lzloading('#cmb_city_id');
});

$(function(){
  $('#frm_car_rental_vendor_save').validate({
      rules:{
              cmb_city_id : { required: true },
              vendor_name: { required: true },
              side : { required : true },
			        as_of_date : { required : true },
              
      },
      submitHandler:function(form){
              var vendor_name = $('#vendor_name').val();
              var mobile_no = $('#mobile_no').val();
              var address = $('#address').val();
              var opening_balance = $('#opening_balance').val();
              var active_flag = $('#active_flag').val();
              var service_tax_no = $('#service_tax_no').val();
              var email_id = $('#email_id').val();
              var country = $("#country").val();
              var website = $("#website").val();
              var bank_name = $("#bank_name").val();
              var branch = $("#branch").val();
              var ifsc_code = $("#ifsc_code").val();
               var account_name = $("#account_name").val();
              var account_no = $("#account_no").val();
              var contact_person_name = $("#contact_person_name").val();
              var immergency_contact_no =$("#immergency_contact_no").val();
              var landline_no = $("#landline_no").val();
              var city_id =$("#cmb_city_id").val();
              var state = $("#state").val();
              var side = $('#side').val();
              var supp_pan = $('#supp_pan').val();
              var as_of_date = $('#as_of_date').val();

              var add = validate_address('address');
              if(!add){
                error_msg_alert('More than 155 characters are not allowed.');
                return false;
              }

              var vehicle_no_arr = new Array();
              var vehicle_model_arr = new Array();
              var vehicle_name_arr = new Array();
              var vehicle_driver_name_arr = new Array();
              var vehicle_mobile_no_arr = new Array();
              var vehicle_year_of_purchase_arr = new Array();
              var vehicle_rate_arr = new Array();
              var vehicle_type_arr = new Array();

              var count = 0;
              var table = document.getElementById("tbl_dynamic_car_rental_vehicle");
              var rowCount = table.rows.length;
              for(var i=0; i<rowCount; i++)
              {
                var row = table.rows[i];
                if(row.cells[0].childNodes[0].checked == true)
                {
                  count++;
                  var vehicle_name = row.cells[2].childNodes[0].value;
                  var vehicle_no = row.cells[3].childNodes[0].value;
                  var vehicle_type = row.cells[4].childNodes[0].value;
                  var vehicle_driver_name = row.cells[5].childNodes[0].value;
                  var vehicle_mobile_no = row.cells[6].childNodes[0].value;
                  var vehicle_year_of_purchase = row.cells[7].childNodes[0].value;
                  var vehicle_rate = row.cells[8].childNodes[0].value;

                  // var msg = "";
                  // if(vehicle_name==""){ msg +="> Enter vehicle name in row "+(i+1)+"<br>"; }
                  // if(vehicle_type==""){ msg +="> Enter vehicle type  in row "+(i+1)+"<br>"; }

                  // if(msg!=""){ error_msg_alert(msg); return false; }
                  
                  vehicle_name_arr.push(vehicle_name);
                  vehicle_no_arr.push(vehicle_no);
                  vehicle_driver_name_arr.push(vehicle_driver_name);
                  vehicle_mobile_no_arr.push(vehicle_mobile_no);
                  vehicle_year_of_purchase_arr.push(vehicle_year_of_purchase);
                  vehicle_rate_arr.push(vehicle_rate);
                  vehicle_type_arr.push(vehicle_type);
                }
              }

              // if(count==0){
              //   error_msg_alert("Enter at least one vehicle details.");
              //   return false;
              // }

              var base_url = $('#base_url').val();
              $('#btn_vendor_save').button('loading');

              $.ajax({
                type:'post',
                url: base_url+'controller/car_rental/vendor/vendor_save.php',
                data:{ city_id: city_id, vendor_name : vendor_name, mobile_no : mobile_no, landline_no : landline_no, address  : address, contact_person_name :contact_person_name, immergency_contact_no:immergency_contact_no,country : country, website : website, bank_name : bank_name, account_no : account_no, branch : branch, ifsc_code : ifsc_code, opening_balance : opening_balance, active_flag : active_flag, vehicle_name_arr : vehicle_name_arr, vehicle_no_arr : vehicle_no_arr, vehicle_driver_name_arr : vehicle_driver_name_arr, vehicle_mobile_no_arr : vehicle_mobile_no_arr, vehicle_year_of_purchase_arr : vehicle_year_of_purchase_arr, vehicle_rate_arr : vehicle_rate_arr, vehicle_type_arr : vehicle_type_arr,service_tax_no:service_tax_no, email_id : email_id, state : state,side:side,account_name : account_name , supp_pan : supp_pan,as_of_date : as_of_date},
                success:function(result){
                  msg_alert(result);
                  $('#vendor_save_modal').modal('hide');
                  vendor_list_reflect();
                  reset_form('frm_car_rental_vendor_save');
                  $('#btn_vendor_save').button('reset');
                },
                error:function(result){
                  console.log(result.responseText);
                }
              });

      }

  });

});

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>