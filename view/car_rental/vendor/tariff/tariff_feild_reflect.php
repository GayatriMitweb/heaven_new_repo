<?php
include "../../../../model/model.php";
$tour_type = $_POST['tour_type'];

if($tour_type=="Local"){
?>
<div class="panel panel-default panel-body app_panel_style">
    <div class="row mg_bt_10">
        <div class="col-md-12 text-right text_center_xs">
            <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_car_rental_vehicle_local','1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
            <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_dynamic_car_rental_vehicle_local','1')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
        </div>
    </div>    

    <div class="row"><div class="col-md-12"><div class="table-responsive">
    <table id="tbl_dynamic_car_rental_vehicle_local" name="tbl_dynamic_car_rental_vehicle_local" class="table table-bordered" style="width: 965px;">
        <tr>
            <td><input class="css-checkbox" id="chk_vehicle1" type="checkbox" checked><label class="css-label" for="chk_vehicle1"> <label></td>
            <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select name="vehicle_name1" id="vehicle_name1" data-toggle="tooltip" title="Vehicle Name" class="form-control app_select2">
                <option value="">*Select Vehicle</option>
                <?php
                    $sql = mysql_query("select * from b2b_transfer_master");
                    while($row = mysql_fetch_assoc($sql)){ 
                    ?>
                        <option value="<?= $row['vehicle_name']?>"><?= $row['vehicle_name']?></option>
                <?php }  ?>
            </select></td>
            <td class="hidden"><input type="text" id="seating_capacity" name="seating_capacity" placeholder="Seating Capacity" data-toggle="tooltip" title="Seating Capacity" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="total_hrs" name="total_hrs" data-toggle="tooltip" placeholder="Total Hrs" title="Total Hrs" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="total_km" name="total_km" data-toggle="tooltip" placeholder="Total KM" title="Total KM" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="extra_hrs_rate" name="extra_hrs_rate" data-toggle="tooltip" placeholder="Extra hrs Rate" title="Extra Hrs Rate" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="extra_km" name="extra_km" data-toggle="tooltip" placeholder="Extra KM Rate" title="Extra KM Rate" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="rate" name="rate" data-toggle="tooltip" placeholder="Rate" title="Rate" class="form-control" onchange="validate_balance(this.id)"/></td>
           
        </tr>                                
    </table>
    </div>
    </div>
    </div>
</div>
<?php }else{?>

<div class="panel panel-default panel-body app_panel_style">
   
    <div class="row mg_bt_10">
            <div class="col-md-12 text-right text_center_xs">
                <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_car_rental_vehicle_out','1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_dynamic_car_rental_vehicle_out','1')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
            </div>
    </div>    

    <div class="row"><div class="col-md-12"><div class="table-responsive">
    <table id="tbl_dynamic_car_rental_vehicle_out" name="tbl_dynamic_car_rental_vehicle_out" class="table table-bordered" style="width: 2000px;">
        <tr>
            <td><input class="css-checkbox" id="chk_vehicle1" type="checkbox" checked><label class="css-label" for="chk_vehicle1"> <label></td>
            <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select name="vehicle_name1" id="vehicle_name1" data-toggle="tooltip" title="Vehicle Name" class="form-control app_select2">
                <option value="">*Select Vehicle</option>
                <?php
                    $sql = mysql_query("select * from b2b_transfer_master");
                    while($row = mysql_fetch_assoc($sql)){ 
                    ?>
                        <option value="<?= $row['vehicle_name']?>"><?= $row['vehicle_name']?></option>
                <?php }  ?>
            </select></td>
            <td class="hidden"><input type="text" id="seating_capacity" name="seating_capacity" placeholder="Seating Capacity" data-toggle="tooltip" title="Seating Capacity" class="form-control" /></td>
            <td><input type="text" id="route" name="route" placeholder="Route" data-toggle="tooltip" title="Route" class="form-control" /></td>
            <td><input type="text" id="total_days" name="total_days" placeholder="Total Days" data-toggle="tooltip" title="Total Days" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="total_km" name="total_km" data-toggle="tooltip" placeholder="Total KM" title="Total KM" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="rate" name="rate" data-toggle="tooltip" placeholder="Rate" title="Rate" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="extra_hrs_rate" name="extra_hrs_rate" data-toggle="tooltip" placeholder="Extra Hrs Rate" title="Extra hrs Rate" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="extra_km" name="extra_km" data-toggle="tooltip" placeholder="Extra KM Rate" title="Extra KM Rate" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="driver_allowance" name="driver_allowance" data-toggle="tooltip" placeholder="Driver Allowance per day" title="Driver Allowance per day" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="permit_charges" name="permit_charges" data-toggle="tooltip" placeholder="Permit Charges" title="Permit Charges" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="toll_parking" name="toll_parking" data-toggle="tooltip" placeholder="Toll Parking" title="Toll Parking" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="state_entry_pass" name="state_entry_pass" data-toggle="tooltip" placeholder="State Entry Pass" title="State Entry Pass" class="form-control" onchange="validate_balance(this.id)"/></td>
            <td><input type="text" id="other_charges" name="other_charges" data-toggle="tooltip" placeholder="Other Charges" title="Other Charges" class="form-control" onchange="validate_balance(this.id)"/></td>
        </tr>                                
    </table>
    </div>
    </div>
    </div>
</div>
<?php } ?>
<script>
$("#state,#vehicle_name1").select2();
</script>