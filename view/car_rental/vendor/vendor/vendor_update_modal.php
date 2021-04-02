<?php

include "../../../../model/model.php";
$vendor_id = $_POST['vendor_id'];
$sq_vendor = mysql_fetch_assoc(mysql_query("select * from car_rental_vendor where vendor_id='$vendor_id'"));
$sq_vendor_login = mysql_fetch_assoc(mysql_query("select * from vendor_login where username='$sq_vendor[vendor_name]' and password='$sq_vendor[mobile_no]' and vendor_type='Car Rental Vendor'"));
$mobile_no = $encrypt_decrypt->fnDecrypt($sq_vendor['mobile_no'], $secret_key);
$email_id = $encrypt_decrypt->fnDecrypt($sq_vendor['email'], $secret_key);

$role = $_SESSION['role'];
$value = '';
if($role!='Admin' && $role!="Branch Admin"){ $value="readonly"; }
?>
<form id="frm_car_rental_vendor_update">
<input type="hidden" id="vendor_id" name="vendor_id" value="<?= $vendor_id ?>">
<input type="hidden" id="vendor_login_id" name="vendor_login_id" value="<?= $sq_vendor_login['login_id'] ?>">
<div class="modal fade" id="vendor_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Car Rental information</h4>
      </div>
      <div class="modal-body">
      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">
        <legend>Car Supplier Information</legend>
        <div class="row">
          <div class="col-sm-3 col-sm-6 mg_bt_10">
                <select id="cmb_city_id1" name="cmb_city_id1" style="width:100%" title="City Name">
                    <?php $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_vendor[city_id]'")); ?>
                    <option value="<?php echo $sq_vendor['city_id'] ?>" selected="selected"><?php echo $sq_city['city_name'] ?></option>
                </select>
            </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="vendor_name1" name="vendor_name1" onchange="validate_spaces(this.id);" placeholder="Company Name" title="Company Name" value="<?= $sq_vendor['vendor_name'] ?>">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="mobile_no1"  onchange="mobile_validate(this.id);" name="mobile_no1" placeholder="Mobile No" title="Mobile No" value="<?= $mobile_no ?>">
          </div>  
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="landline_no2"  onchange="mobile_validate(this.id);" name="landline_no2" placeholder="Landline No" title="Landline No" value="<?= $sq_vendor['landline_no'] ?>" >
          </div>         
        </div>
        <div class="row">
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" name="email_id1" id="email_id1" value="<?= $email_id?>" placeholder='Email ID' title='Email ID'/>
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="contact_person_name1" name="contact_person_name1" placeholder="Contact Person Name" title="Contact Person Name" value="<?= $sq_vendor['contact_person_name'] ?>">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" name="immergency_contact_no1"  onchange="mobile_validate(this.id);" id="immergency_contact_no1" value="<?= $sq_vendor['immergency_contact_no']?>" placeholder='Emergency Contact No' title='Emergency Contact No'/>
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <textarea name="address1" id="address1" title="Address" placeholder="Address" onchange="validate_address(this.id)" rows="1"><?= $sq_vendor['address'] ?></textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3 col-xs-6 mg_bt_10">
            <select name="cust_state1" id="cust_state1" title="Select State" style="width:100%" required>
              <?php if($sq_vendor['state_id']!='0'){
                $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_vendor[state_id]'"));
              
              ?>
              <option value="<?= $sq_vendor['state_id'] ?>"><?= $sq_state['state_name'] ?></option>
            <?php } ?>
              <?php get_states_dropdown() ?>
            </select>
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="country1" name="country1" placeholder="Country" title="Country" value="<?= $sq_vendor['country'] ?>">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
             <input type="text" name="website1" id="website1" placeholder="Website" title="Website" value="<?= $sq_vendor['website']?>">
          </div>
        </div>
      </div>
      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
        <legend>Bank Information</legend> 
        <div class="row">
           <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="bank_name1" name="bank_name1" class="bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?= $sq_vendor['bank_name'] ?>">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="account_name1" name="account_name1" placeholder="A/c Name" title="A/c Name" value="<?= $sq_vendor['account_name'] ?>">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="account_no1" name="account_no1"  onchange="validate_accountNo(this.id);" placeholder="A/c No" title="A/c No" value="<?= $sq_vendor['account_no'] ?>">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
              <input type="text" id="branch1" name="branch1" onchange="validate_branch(this.id);" placeholder="Branch" title="Branch" value="<?= $sq_vendor['branch'] ?>">
          </div>
        </div> 
        <div class="row">
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" name="/Swift_code1" id="ifsc_code1" onchange="validate_IFSC(this.id);" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" value="<?= $sq_vendor['ifsc_code']?>" style="text-transform: uppercase;">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
            <input type="text" id="service_tax_no1" name="service_tax_no1"  placeholder="Tax No" title="Tax No" value="<?= strtoupper($sq_vendor['service_tax_no']) ?>" onchange="validate_alphanumeric(this.id)" style="text-transform: uppercase;">
          </div> 
          <div class="col-md-3 col-sm-6 mg_bt_10">
              <input type="text" id="supp_pan" onchange="validate_alphanumeric(this.id)" name="supp_pan" value="<?= $sq_vendor['pan_no']?>"" placeholder="PAN/TAN No" title="PAN/TAN No" style="text-transform: uppercase;">
          </div>
          <div class="col-sm-3 col-sm-6 mg_bt_10">
           <input type="hidden" id="opening_balance1" name="opening_balance1" placeholder="Opening Balance1" title="Opening Balance" value="<?= $sq_vendor['opening_balance'] ?>" <?= $value ?> onchange="validate_balance(this.id)">
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
      <div class="row mg_bt_20">
        
        <div class="col-sm-3 col-sm-6 mg_bt_10">
           <select name="active_flag1" id="active_flag1" title="Status">
              <option value="<?= $sq_vendor['active_flag'] ?>"><?= $sq_vendor['active_flag'] ?></option>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
        </div>
      </div>


         <h3 class="editor_title hidden">Vehicle Details</h3>
         <div class="panel panel-default panel-body app_panel_style hidden">
           <div class="row mg_bt_10">
                <div class="col-xs-12 text-right text_center_xs">
                  <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_car_rental_vehicle1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                </div>
             </div> 
            <div class="row"><div class="col-md-12"><div class="table-responsive">
                <table id="tbl_dynamic_car_rental_vehicle1" name="tbl_dynamic_car_rental_vehicle1" class="table table-bordered no-marg">
                  <?php 
                  $count = 0;
                  $sq_vehivle_entry = mysql_query("select * from car_rental_vendor_vehicle_entries where vendor_id='$vendor_id'");
                  while($row_vehicle_entry = mysql_fetch_assoc($sq_vehivle_entry)){
                    $count++;
                    ?>
                   <tr>
                          <td><input class="css-checkbox" id="chk_vehicle<?= $count ?>_u" type="checkbox" checked><label class="css-label" for="chk_vehicle<?= $count ?>_u"> <label></td>

                          <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>

                          <td><input type="text" id="vehicle_name<?= $count ?>_u" onchange="validate_spaces(this.id);" name="vehicle_name" placeholder="*Vehicle Name" title="Vehicle Name" class="form-control" value="<?= $row_vehicle_entry['vehicle_name'] ?>"/></td>

                          <td><input type="text" id="vehicle_no<?= $count ?>_u" name="vehicle_no" placeholder="Vehicle No" title="Vehicle No" class="form-control"  onchange="validate_spaces(this.id);" value="<?= $row_vehicle_entry['vehicle_no'] ?>" style="text-transform: uppercase;"/></td>
                          
                          <td><select id="vehicle_type<?= $count ?>_u" name="vehicle_type" title="Vehicle Type">
                              <option value="<?= $row_vehicle_entry['vehicle_type'] ?>"><?= $row_vehicle_entry['vehicle_type'] ?></option>
                              <option value="AC">AC</option>
                              <option value="Non AC">Non AC</option>
                          </select></td>

                          <td><input type="text" id="vehicle_driver_name<?= $count ?>_u" name="vehicle_driver_name" placeholder="Driver Name" title="Driver Name"  onchange="fname_validate(this.id);" class="form-control" value="<?= $row_vehicle_entry['vehicle_driver_name'] ?>" /></td>

                          <td><input type="text" id="vehicle_mobile_no<?= $count ?>_u" name="vehicle_mobile_no" placeholder="Mobile No" title="Mobile No" class="form-control"  onchange="mobile_validate(this.id);" value="<?= $row_vehicle_entry['vehicle_mobile_no'] ?>"/></td>

                          <td><input type="text" id="vehicle_year_of_purchase<?= $count ?>_u" name="vehicle_year_of_purchase" placeholder="Purchase Year" title="Purchase Year" onchange="validate_year(this.id);" class="form-control" value="<?= $row_vehicle_entry['vehicle_year_of_purchase'] ?>"/></td>

                          <td><input type="text" id="vehicle_rate<?= $count ?>_u" name="vehicle_rate" placeholder="Rate KM" title="Rate KM" class="form-control" onchange="validate_balance(this.id);" value="<?= $row_vehicle_entry['vehicle_rate'] ?>"/></td>
                          

                          <td class="hidden"><input type="text" value="<?= $row_vehicle_entry['vehicle_id'] ?>"></td>

                      </tr>       

                    <?php

                  }

                  ?>
                </table>
            </div></div></div>
         </div>

        <div class="row text-center mg_tp_20">
          <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
          </div>
        </div>     
    </div>
  </div>
</div>

</form>
<script>
$('#vendor_update_modal').modal('show');
$(document).ready(function() {
    $("#cust_state1").select2();
    $('#as_of_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
    city_lzloading('#cmb_city_id1');
});
$(function(){
  $('#frm_car_rental_vendor_update').validate({
      rules:{
              cmb_city_id: {required: true },
              vendor_name1: { required: true },
              side1 : { required : true },
			        as_of_date1 : { required : true },
      },

      submitHandler:function(form){

      		    var vendor_id = $('#vendor_id').val();
              var vendor_login_id = $('#vendor_login_id').val();
              var vendor_name = $('#vendor_name1').val();
              var mobile_no = $('#mobile_no1').val();
              var address = $('#address1').val();
              var opening_balance = $('#opening_balance1').val();
              var active_flag = $('#active_flag1').val();
              var service_tax_no1 = $('#service_tax_no1').val();
              var email_id1 = $('#email_id1').val();
              var country = $("#country1").val();
              var website = $("#website1").val();
              var bank_name = $("#bank_name1").val();
              var branch = $("#branch1").val();
              var ifsc_code = $("#ifsc_code1").val();
              var account_name = $("#account_name1").val();
              var account_no = $("#account_no1").val();
              var contact_person_name = $("#contact_person_name1").val();
              var immergency_contact_no =$("#immergency_contact_no1").val();
              var landline_no = $("#landline_no2").val();
              var city_id = $("#cmb_city_id1").val();
              var state = $("#cust_state1").val();
              var side = $('#side1').val();
              var supp_pan = $('#supp_pan').val();
              var as_of_date = $('#as_of_date1').val();
              var add = validate_address('address1');
              if(!add){
                error_msg_alert('More than 155 characters are not allowed.');
                return false;
              }
              var vehicle_name_arr = new Array(); 
              var vehicle_no_arr = new Array();
              var vehicle_driver_name_arr = new Array();
              var vehicle_mobile_no_arr = new Array();
              var vehicle_year_of_purchase_arr = new Array();
              var vehicle_rate_arr = new Array();
              var vehicle_type_arr = new Array();
              var vehicle_id_arr = new Array();
              var count = 0;
              var table = document.getElementById("tbl_dynamic_car_rental_vehicle1");
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
                  var vehicle_rate= row.cells[8].childNodes[0].value;
                  var vehicle_id = row.cells[9].childNodes[0].value;

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

                  vehicle_id_arr.push(vehicle_id);
                }  
              }
              if(count==0)
              {
                error_msg_alert("Select at least one vehicle.");
                return false;
              }
              var base_url = $('#base_url').val();
              $('#btn_update').button('loading');
              $.ajax({

                type:'post',

                url: base_url+'controller/car_rental/vendor/vendor_update.php',

                data:{ vendor_id : vendor_id, vendor_login_id : vendor_login_id, city_id : city_id, vendor_name : vendor_name, mobile_no : mobile_no, landline_no : landline_no, address : address, contact_person_name : contact_person_name, immergency_contact_no : immergency_contact_no, country : country, website : website, bank_name : bank_name, account_no : account_no, branch : branch, ifsc_code : ifsc_code, opening_balance : opening_balance, active_flag : active_flag, vehicle_name_arr : vehicle_name_arr, vehicle_no_arr : vehicle_no_arr, vehicle_type_arr : vehicle_type_arr,vehicle_driver_name_arr : vehicle_driver_name_arr, vehicle_mobile_no_arr : vehicle_mobile_no_arr, vehicle_year_of_purchase_arr : vehicle_year_of_purchase_arr, vehicle_rate_arr : vehicle_rate_arr,  vehicle_id_arr : vehicle_id_arr, service_tax_no1 : service_tax_no1, email_id1 : email_id1, state : state,side:side,account_name:account_name,supp_pan : supp_pan,as_of_date : as_of_date},

                success:function(result){
                  
                  msg_alert(result);
                  $('#vendor_update_modal').modal('hide');
                  vendor_list_reflect();
                  reset_form('frm_car_rental_vendor_update');
                  $('#btn_update').button('reset');           
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