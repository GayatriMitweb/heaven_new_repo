<?php 
$sq_plane_details_count = mysql_num_rows(mysql_query("select * from plane_master where tourwise_traveler_id='$tourwise_id'"));
if($sq_plane_details_count==0)
{
	include_once('../booking_save/tab_2/plane_info.php');
}else{
?>
<div class="row">

    <div class="col-xs-12 text-right">
        <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_plane_travel_details_dynamic_row');event_airport('tbl_plane_travel_details_dynamic_row',3,4)"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>   
        <!--  Code to uploadf button -->
        <div class="div-upload" id="div_upload_button">
            <div id="plane_upload" class="upload-button"><span>Ticket</span></div><span id="plane_status" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="txt_plane_upload_dir" name="txt_plane_upload_dir" value="<?= $tourwise_details['plane_upload_ticket'] ?>">
        </div> 
    </div>
</div>

<div class="row mg_tp_20"> <div class="col-xs-12"> <div class="table-responsive">       
<table id="tbl_plane_travel_details_dynamic_row" name="tbl_plane_travel_details_dynamic_row" class="table table-bordered table-hover no-marg pd_bt_51">

<?php
$count_p = 0;
$sq_plane_details = mysql_query("select * from plane_master where tourwise_traveler_id='$tourwise_id'");
while($row_plane_details = mysql_fetch_assoc($sq_plane_details)){
$count_p++;
$sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id=".$row_plane_details['from_city']));
$sq_city2 = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id=".$row_plane_details['to_city']));
?>
<tr>

	<td ><input id="<?php echo 'check-btn-plane-'.$count_p.'p' ?>" type="checkbox" onchange="calculate_plane_expense('tbl_plane_travel_details_dynamic_row')" checked disabled ></td>

	<td><input maxlength="15" type="text" id="" name="username" value="<?php echo $count_p ?>" placeholder="Sr.No."/></td>

	<td><input type="text" id="<?php echo 'txt_plane_date-'.$count_p.'p' ?>" name="<?php echo 'txt_plane_date-'.$count_p.'p' ?>" placeholder="Departure Date & Time" title="Departure Date & Time" value="<?php echo date("d-m-Y H:i:s", strtotime($row_plane_details['date'])) ?>" class="app_datetimepicker" onchange="get_to_datetime(this.id,'txt_arravl<?= $count_p?>p');validate_travelingDates(this.id);" style="width:136px"/></td>
    <td><input type="text" name="from_sector-1" id="from_sector-<?= $count_p ?>p" placeholder="From Sector" title="From Sector" style="width: 250px;" value="<?php echo ($sq_city['city_name']) ? $sq_city['city_name']." - ".$row_plane_details['from_location'] : ''; ?>">
	</td>
	<td><input type="text" name="to_sector-1" id="to_sector-<?= $count_p ?>p" placeholder="To Sector" title="To Sector" style="width: 250px;" value="<?php echo ($sq_city2['city_name']) ? $sq_city2['city_name']." - ".$row_plane_details['to_location'] : ''; ?>">
	</td>
    <td><select id="<?php echo 'txt_plane_company-'.$count_p.'p' ?>" title="Airline Name" name="<?php echo 'txt_plane_company-'.$count_p.'p' ?>" class="app_select2" style="width:150px">
        <?php 
           $sq_airline = mysql_fetch_assoc(mysql_query("select * from airline_master where airline_id='$row_plane_details[company]'"));
        ?>
        <option value="<?= $sq_airline['airline_id'] ?>"><?= $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')' ?></option>
        <?php get_airline_name_dropdown(); ?>
    </select></td>
	<td><input type="text" id="<?php echo 'txt_plane_seats-'.$count_p.'p' ?>" name="<?php echo 'txt_plane_seats-'.$count_p.'p' ?>" placeholder="Total Seats" title="Total Seats" maxlength="2"   value="<?php echo $row_plane_details['seats'] ?>" style="width:100px"/></td>

	<td><input type="text" id="<?php echo 'txt_plane_amount-'.$count_p.'p' ?>" name="<?php echo 'txt_plane_amount-'.$count_p.'p' ?>" placeholder="Amount" title="Amount" onchange="calculate_plane_expense('tbl_plane_travel_details_dynamic_row');validate_balance(this.id)"   value="<?php echo $row_plane_details['amount'] ?>" style="width:120px"/></td>
    
    <td><input type="text" id="<?php echo 'txt_arravl'.$count_p.'p' ?>" name="<?php echo 'txt_arravl-'.$count_p.'p' ?>" placeholder="Arrival date & time" title="Arrival date & time" class="app_datetimepicker" value="<?php echo date("d-m-Y H:i:s", strtotime($row_plane_details['arraval_time'])) ?>" style="width:136" onchange="validate_travelingDates(this.id);"/></td>

    <td><input type="hidden" id="from_city-<?= $count_p ?>p" value="<?= $row_plane_details['from_city'] ?>"></td>
	<td><input type="hidden" id="to_city-<?= $count ?>p" value="<?= $row_plane_details['to_city'] ?>"></td>
	
    <td><input type="hidden" value="<?php echo $row_plane_details['plane_id'] ?>"></td>

</tr>

<script>
   
    $("#txt_arravl"+<?= $count_p ?>+'p').datetimepicker({ format: "d-m-Y H:i:s"  });
    $("#txt_plane_date-"+<?= $count_p ?>+'p').datetimepicker({ format: "d-m-Y H:i:s"  });
	//$('#txt_plane_from_location<?= $count_p ?>p, #txt_plane_to_location<?= $count_p ?>p').select2();
    $('#txt_plane_company-<?= $count_p ?>p').select2();
    event_airport('tbl_plane_travel_details_dynamic_row',3,4);
</script>
<?php
}
?>

</table>
<input type = "hidden" id="txt_plane_date_generate" value="<?php echo $count_p ?>">

</div> </div> </div>
      
    <div class="row mg_tp_20 hidden">
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Subtotal</label>
            <input type="text" id="txt_plane_expense" name="txt_plane_expense" class="text-right" value="<?php echo $tourwise_details['plane_expense'] ?>" readonly />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Service Charge</label>
            <input type="text" id="txt_plane_service_charge" name="txt_plane_service_charge"  class="text-right" title="Service Charge" value="<?php echo $tourwise_details['plane_service_charge'] ?>" onchange="number_validate(this.id); calculate_total_plane_expense()" />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax</label>
            <select name="plane_taxation_id" id="plane_taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'plane_service_tax', 'calculate_total_plane_expense');">

                
            </select>
            <input type="hidden" id="plane_service_tax" name="plane_service_tax" value="<?= $tourwise_details['plane_service_tax'] ?>">            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax Amount</label>
            <input type="text" id="plane_service_tax_subtotal" name="plane_service_tax_subtotal" value="<?= $tourwise_details['plane_service_tax_subtotal'] ?>" title="Tax Amount" placeholder="0.00" title="Tax Amount" readonly>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12">
            <label>Total</label>
            <input type="text" id="txt_plane_total_expense" class="amount_feild_highlight text-right" name="txt_plane_total_expense" value="<?php echo $tourwise_details['total_plane_expense'] ?>" title="Total" readonly />
        </div>
    </div>    
<?php	
}
?>

<script>
function generating_plane_date()
{
    var count = $("#txt_plane_date_generate").val();
    for(var i=0; i<=count; i++)
    {
        $( "#txt_plane_date"+i+'p').datetimepicker({ format: "d-m-Y H:i:s"  });
        $( "#txt_arravl"+i+'p').datetimepicker({ format: "d-m-Y H:i:s"  });
    }             
}
generating_plane_date();
</script>