<?php
include "../../../../model/model.php";
$entry_id = $_POST['entry_id'];
$sq_vendor = mysql_fetch_assoc(mysql_query("select * from car_rental_tariff_entries where entry_id='$entry_id'"));


$role = $_SESSION['role'];
$value = '';
if($role!='Admin' && $role!="Branch Admin"){ $value="readonly"; }
?>
<form id="frm_car_rental_vendor_update">

<div class="modal fade" id="vendor_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Car Rental Tariff</h4>
      </div>
      <div class="modal-body">
      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">
      <input type="hidden" id="entry_id" name="entry_id" value="<?= $entry_id ?>">
      <input type="hidden" id="tour_type" name="tour_type" value="<?= $sq_vendor['tour_type'] ?>" />
        <?php if($sq_vendor['tour_type']=="Local"){?>
            <div class="row">
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                    <select name="local_vehicle_name" id="local_vehicle_name" data-toggle="tooltip" title="Vehicle Name" class="form-control">
                    <?php if($sq_vendor['vehicle_name']!=''){ ?>
                            <option value="<?= $sq_vendor['vehicle_name']?>"><?= $sq_vendor['vehicle_name']?></option>
                            <?php
                                $sql = mysql_query("select * from b2b_transfer_master");
                                while($row = mysql_fetch_assoc($sql)){ 
                                ?>
                                    <option value="<?= $row['vehicle_name']?>"><?= $row['vehicle_name']?></option>
                           <?php  } 
                                    }else{ ?>
                                <option value="">Select Vehicle</option>
                                <?php
                                    $sql = mysql_query("select * from b2b_transfer_master");
                                    while($row = mysql_fetch_assoc($sql)){ 
                                    ?>
                                    <option value="<?= $row['vehicle_name']?>"><?= $row['vehicle_name']?></option>
                           <?php } } ?>
                        </select>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                    <input type="text" id="local_total_hrs" name="local_total_hrs" data-toggle="tooltip" placeholder="Total Hrs" title="Total Hrs" class="form-control" value="<?= $sq_vendor['total_hrs']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                    <input type="text" id="local_total_km" name="local_total_km" data-toggle="tooltip" placeholder="Total KM" title="Total KM" class="form-control" value="<?= $sq_vendor['total_km']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                    <input type="text" id="local_extra_hrs_rate" name="local_extra_hrs_rate" data-toggle="tooltip" placeholder="Extra hrs Rate" title="Extra Hrs Rate" class="form-control" value="<?= $sq_vendor['extra_hrs_rate']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                     <input type="text" id="local_extra_km" name="local_extra_km" data-toggle="tooltip" placeholder="Extra KM Rate" title="Extra KM Rate" class="form-control" value="<?= $sq_vendor['extra_km_rate']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                     <input type="text" id="local_rate" name="local_rate" data-toggle="tooltip" placeholder="Rate" title="Rate" class="form-control" value="<?= $sq_vendor['rate']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10" >
                    <select name="local_status" id="local_status" data-toggle="tooltip" title="Status" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

            </div>
            <?php }else{ ?>
                <div class="row">
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                    <select name="vehicle_name" id="vehicle_name" data-toggle="tooltip" title="Vehicle Name" class="form-control">
                    <?php if($sq_vendor['vehicle_name']!=''){ ?>
                            <option value="<?= $sq_vendor['vehicle_name']?>"><?= $sq_vendor['vehicle_name']?></option>
                            <?php
                                $sql = mysql_query("select * from b2b_transfer_master");
                                while($row = mysql_fetch_assoc($sql)){ 
                                ?>
                                    <option value="<?= $row['vehicle_name']?>"><?= $row['vehicle_name']?></option>
                           <?php  } 
                                    }else{ ?>
                                <option value="">Select Vehicle</option>
                                <?php
                                    $sql = mysql_query("select * from b2b_transfer_master");
                                    while($row = mysql_fetch_assoc($sql)){ 
                                    ?>
                                    <option value="<?= $row['vehicle_name']?>"><?= $row['vehicle_name']?></option>
                           <?php } } ?>
                        </select>
                </div>
                
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                    <input type="text" id="extra_hrs_rate" name="extra_hrs_rate" data-toggle="tooltip" placeholder="Extra hrs Rate" title="Extra Hrs Rate" class="form-control" value="<?= $sq_vendor['extra_hrs_rate']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                     <input type="text" id="extra_km" name="extra_km" data-toggle="tooltip" placeholder="Extra KM Rate" title="Extra KM Rate" class="form-control" value="<?= $sq_vendor['extra_km_rate']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                    <input type="text" id="route" name="route" data-toggle="tooltip" placeholder="Route" title="Route" class="form-control" value="<?= $sq_vendor['route']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                    <input type="text" id="total_days" name="total_days" data-toggle="tooltip" placeholder="Total KM" title="Total KM" class="form-control" value="<?= $sq_vendor['total_days']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                    <input type="text" id="total_max_km" name="total_max_km" data-toggle="tooltip" placeholder="Total Max KM" title="Total Max KM" class="form-control" value="<?= $sq_vendor['total_max_km']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                     <input type="text" id="rate" name="rate" data-toggle="tooltip" placeholder="Rate" title="Rate" class="form-control" value="<?= $sq_vendor['rate']?>"/>
                </div>

                <div class="col-sm-3 col-sm-6 mg_bt_10">
                     <input type="text" id="driver_allowance" name="driver_allowance" data-toggle="tooltip" placeholder="Driver Allowance" title="Driver Allowance" class="form-control" value="<?= $sq_vendor['driver_allowance']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                    <input type="text" id="permit_charges" name="permit_charges" data-toggle="tooltip" placeholder="Permit Charges" title="Permit Charges" class="form-control" value="<?= $sq_vendor['permit_charges']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                    <input type="text" id="toll_parking" name="toll_parking" data-toggle="tooltip" placeholder="Toll Parking" title="Toll Parking" class="form-control" value="<?= $sq_vendor['toll_parking']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                    <input type="text" id="state_entry_pass" name="state_entry_pass" data-toggle="tooltip" placeholder="State Entry Charge" title="State Entry Charge" class="form-control" value="<?= $sq_vendor['state_entry_pass']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10">
                     <input type="text" id="other_charges" name="other_charges" data-toggle="tooltip" placeholder="Other Charges" title="Other Charges" class="form-control" value="<?= $sq_vendor['other_charges']?>"/>
                </div>
                <div class="col-sm-3 col-sm-6 mg_bt_10" >
                    <select name="status" id="status" data-toggle="tooltip" title="Status" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

            </div>
            <?php } ?>
      </div>
      </div>
      <div class="row text-center mg_bt_20">
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



$('#vendor_update_modal').modal('show');
$(document).ready(function() {
    $("#cust_state1").select2();
    $('#as_of_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
    $('#cmb_city_id1').select2({minimumInputLength: 1});
});
$(function(){
  $('#frm_car_rental_vendor_update').validate({
      rules:{
              
      },
      submitHandler:function(form){
              var tour_type = $('#tour_type').val();
      		  var entry_id = $('#entry_id').val();
              var local_vehicle_name = $('#local_vehicle_name').val();
              var local_total_hrs = $('#local_total_hrs').val();
              var local_total_km = $('#local_total_km').val();
              var local_extra_hrs_rate = $('#local_extra_hrs_rate').val();
              var local_extra_km = $('#local_extra_km').val();
              var local_rate = $('#local_rate').val();
              var local_status = $('#local_status').val();

              var vehicle_name = $('#vehicle_name').val();
              var extra_hrs_rate = $("#extra_hrs_rate").val();
              var extra_km = $("#extra_km").val();
              var route = $("#route").val();
              var total_days = $("#total_days").val();
              var total_max_km = $("#total_max_km").val();
              var rate = $("#rate").val();
              var driver_allowance = $("#driver_allowance").val();
              var permit_charges = $("#permit_charges").val();
              var toll_parking =$("#toll_parking").val();
              var state_entry_pass = $("#state_entry_pass").val();
              var other_charges = $("#other_charges").val();
              var status = $("#status").val();
              
       
             

              var base_url = $('#base_url').val();
              $('#btn_update').button('loading');
              $.ajax({ 
                type:'post',
                url: base_url+'controller/car_rental/vendor/tariff_update.php',
                data:{entry_id:entry_id,local_vehicle_name:local_vehicle_name,local_total_hrs:local_total_hrs,local_total_km:local_total_km,local_extra_hrs_rate:local_extra_hrs_rate,local_extra_km:local_extra_km,local_rate:local_rate,local_status:local_status,vehicle_name:vehicle_name,extra_hrs_rate:extra_hrs_rate,extra_km:extra_km,route:route,total_days:total_days,total_max_km:total_max_km,rate:rate,driver_allowance:driver_allowance,permit_charges:permit_charges,toll_parking:toll_parking,state_entry_pass:state_entry_pass,other_charges:other_charges,status:status,tour_type:tour_type},
                success:function(result){
                  msg_alert(result);
                  $('#vendor_update_modal').modal('hide');
                  tarrif_list_reflect();
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