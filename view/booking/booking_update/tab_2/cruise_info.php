<?php 
$sq_cruise_details_count = mysql_num_rows(mysql_query("select * from group_cruise_master where booking_id='$tourwise_id'"));
if($sq_cruise_details_count==0){
	include_once('../booking_save/tab_2/cruise_info.php');
}
else{
?>

<div class="row mg_bt_30">
    <div class="col-xs-12 text-right">
         <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_cruise_package_booking')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
        <!-- Code to upload button -->
        <div class="div-upload" id="div_upload_button">
            <div id="cruise_upload" class="upload-button"><span>Ticket</span></div><span id="cruise_status" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="txt_cruise_upload_dir" name="txt_cruise_upload_dir" value="<?= $tourwise_details['cruise_upload_ticket'] ?>">
        </div>   
    </div>
</div>  

<div class="row"> <div class="col-xs-12"> <div class="table-responsive">

<table id="tbl_dynamic_cruise_package_booking" name="tbl_dynamic_cruise_package_booking" class="table table-bordered table-hover bg_white">

<?php
$count_t = 0;
$sq_cruise_details = mysql_query("select * from group_cruise_master where booking_id='$tourwise_id'");
while($row_cruise_details = mysql_fetch_assoc($sq_cruise_details))
{                            
    $count_t++;
?>

<tr>

	<td><input id="chk_cruise1<?php echo $count_t.'t' ?>" type="checkbox" onchange="calculate_cruise_expense('tbl_dynamic_cruise_package_booking')" checked disabled ></td>

	<td><input maxlength="15" type="text" id="tr_cruise_sr_no" name="tr_cruise_sr_no" placeholder="Sr.No." value="<?= $count_t ?>" disabled/></td>
    <td><input type="text" id="cruise_departure_date<?= $count_t ?>t" name="cruise_departure_date<?= $count_t ?>t" placeholder="Departure Date & Time" title="Departure Date & Time" class="app_datetimepicker" value="<?= get_datetime_user($row_cruise_details['dept_datetime']) ?>" onchange="get_to_datetime(this.id,'cruise_arrival_date<?= $count_t ?>t');validate_travelingDates(this.id);" style="width:136px"></td>
    <td><input type="text" id="cruise_arrival_date<?= $count_t ?>t" name="cruise_arrival_date<?= $count_t ?>t" placeholder="Arrival Date & Time" title="Arrival Date & Time" class="app_datetimepicker" value="<?= get_datetime_user($row_cruise_details['arrival_datetime']) ?>" style="width:136px" onchange="validate_travelingDates(this.id);"></td>
    <td><input type="text" id="route<?= $count_t ?>t" onchange="validate_specialChar(this.id);" name="route<?= $count_t ?>t" placeholder="Route" title="Route" value="<?= ($row_cruise_details['route']) ?>" style="width:136px"></td>
    <td><input type="text" id="cabin<?= $count_t ?>t" name="cabin<?= $count_t ?>t" onchange="validate_specialChar(this.id);" placeholder="Cabin" title="Cabin" value="<?= ($row_cruise_details['cabin']) ?>"></td>
    <td><select id="sharing<?= $count_t ?>t" name="sharing<?= $count_t ?>t" style="width:100px;" title="Sharing">
<?php if($row_cruise_details['sharing']!='') { ?><option value="<?= ($row_cruise_details['sharing']) ?>"><?= ($row_cruise_details['sharing']) ?></option><?php }  ?>
            <option value="">Sharing</option>
            <option value="Single">Single</option>
            <option value="Double">Double</option>
            <option value="Triple Quad">Triple Quad</option>
        </select></td>
    <td><input type="text" id="txt_cruise_total_seat1<?= $count_t ?>t" name="txt_cruise_total_seat1<?= $count_t ?>t" placeholder="Total Seats" title="Total Seats" maxlength="3" value="<?= $row_cruise_details['seats'] ?>" onchange="validate_balance(this.id);" style="width:100px" /></td>

    <td><input type="text" id="txt_cruise_amount1<?= $count_t ?>t" name="txt_cruise_amount1<?= $count_t ?>t" placeholder="*Amount" title="Amount" onchange="calculate_cruise_expense('tbl_dynamic_cruise_package_booking');validate_balance(this.id);" value="<?= $row_cruise_details['amount'] ?>"  style="width:120px"/></td>
	<td><input type="hidden" value="<?php echo $row_cruise_details['cruise_id'] ?>"></td>

</tr>

<script>
	$('#cruise_arrival_date<?= $count_t ?>t, #cruise_departure_date<?= $count_t ?>t').datetimepicker({ format : 'd-m-Y H:i:s'});
</script>
<?php   
}    
?>


</table>
<input type = "hidden" id="txt_cruise_date_generate" value="<?php echo $count_t ?>">

</div> </div> </div>                    
                    
    <div class="row mg_tp_20 hidden">
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Subtotal</label>
            <input type="text" id="txt_cruise_expense" name="txt_cruise_expense"  title="Subtotal" class="text-right" value="<?php echo $tourwise_details['cruise_expense'] ?>" readonly />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Service Charge</label>
            <input type="text" id="txt_cruise_service_charge" name="txt_cruise_service_charge" title="Service Charge" class="text-right" value="<?php echo $tourwise_details['cruise_service_charge'] ?>" onchange="number_validate(this.id); calculate_total_cruise_expense()" />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
        	<label>Tax</label>
            <select name="cruise_taxation_id" id="cruise_taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'cruise_service_tax', 'calculate_total_cruise_expense');">
               
            </select>
            <input type="hidden" id="cruise_service_tax" name="cruise_service_tax" value="<?= $tourwise_details['cruise_service_tax'] ?>">            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
        	<label>Tax Amount</label>
        	<input type="text" id="cruise_service_tax_subtotal" name="cruise_service_tax_subtotal" value="<?= $tourwise_details['cruise_service_tax_subtotal'] ?>" placeholder="0.00" title="Tax Amount" readonly>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12">
            <label>Total</label>
            <input class="amount_feild_highlight text-right" type="text" id="txt_cruise_total_expense" name="txt_cruise_total_expense" title="Total" value="<?php echo $tourwise_details['total_cruise_expense'] ?>" readonly />            
        </div>
    </div>
<?php	
}
?>
