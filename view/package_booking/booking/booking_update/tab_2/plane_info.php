 <div class="row mg_bt_10">
    <div class="col-xs-12 text-right">
        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_plane_travel_details_dynamic_row');event_airport('tbl_plane_travel_details_dynamic_row',3,4)" title="Add row"><i class="fa fa-plus"></i></button>
        <!--  Code to uploadf button -->
        <div class="div-upload" id="div_upload_button">
            <div id="package_plane_upload" class="upload-button"><span>Ticket</span></div><span id="package_plane_status" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="txt_plane_upload_dir" name="txt_plane_upload_dir" value="<?= $sq_booking_info['plane_upload_ticket'] ?>">
        </div>
    </div>
</div>   

<div class="row mg_bt_30"> <div class="col-xs-12"> <div class="table-responsive">
                        
    <table id="tbl_plane_travel_details_dynamic_row" name="tbl_plane_travel_details_dynamic_row" class="table table-bordered table-hover pd_bt_51 no-marg" style="width: 1400px;">
    <?php
     $sq_plane_info_count = mysql_num_rows(mysql_query("select * from package_plane_master where booking_id='$booking_id'"));
    if($sq_plane_info_count==0)
    { ?>
        <tr>
        <td ><input id="check-btn-plane-1" type="checkbox" onchange="calculate_plane_expense('tbl_plane_travel_details_dynamic_row',true)" checked ></td>
        <td><input maxlength="15" type="text" id="" name="username" value="1" placeholder="Sr.No." disabled/></td>

        <td><input type="text" id="txt_plane_date-1" name="txt_plane_date-1" title="Departure Date & Time" onchange="validate_transportDate('txt_plane_date-1','txt_arravl-1');get_to_datetime(this.id,'txt_arravl-1')" placeholder="Departure Date & Time"/></td>
        <td><input type="text" name="from_sector-1" id="from_sector-1" style="width:300px" placeholder="From Sector" title="From Sector">
		</td>
		<td><input type="text" name="to_sector-1" id="to_sector-1" style="width:300px" placeholder="To Sector" title="To Sector">
		</td>
        <td><select id="txt_plane_company-1" name="txt_plane_company-1" class="app_select2" style="width:150px" title="Airline Name">
            <option value="">*Airline Name</option>
              <?php get_airline_name_dropdown(); ?>
        </select></td>
        <td style="width: 30px;"><input type="text" id="txt_plane_seats-1" name="txt_plane_seats-1" placeholder="Total Seats" title="Total Seats" maxlength="2"  /></td>
        <td style="width: 130px;"><input type="text" id="txt_plane_amount-1" name="txt_plane_amount-1" placeholder="*Amount" onchange="validate_balance(this.id)" title="Amount" onchange=" calculate_plane_expense('tbl_plane_travel_details_dynamic_row',true);" /></td>
        <td><input type="text" id="txt_arravl-1" name="txt_arravl-1" class="app_datetimepicker" onchange="validate_arrivalDate('txt_plane_date-1','txt_arravl-1')" placeholder="Arrival Date & Time" title="Arrival Date & Time"></td>
        <td><input type="hidden" id="from_city-1"> </td>
		<td><input type="hidden" id="to_city-1"></td>
        </tr>
        <script type="text/javascript">
        $('#txt_plane_date-1,#txt_arravl-1').datetimepicker({ format:'d-m-Y H:i:s' });
        </script>
 <?php    }
    else{
    $offset = "_u";
    $count = 0;
    $sq_plane_details = mysql_query("select * from package_plane_master where booking_id='$booking_id'");
    while($row_plane_details = mysql_fetch_assoc($sq_plane_details))
    {                            
        $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id=".$row_plane_details['from_city']));
        $sq_city2 = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id=".$row_plane_details['to_city']));
        $count++;
    ?>

        <tr>

            <td ><input id="check-btn-plane-<?= $offset.$count ?>_d" type="checkbox" onchange="calculate_plane_expense('tbl_plane_travel_details_dynamic_row',true)" checked disabled ></td>

            <td><input maxlength="15" type="text" id="" name="username" value="<?php echo $count ?>" placeholder="Sr.No." disabled/></td>

            <td><input type="text" id="txt_plane_date-<?= $offset.$count ?>_d" name="txt_plane_date-<?= $offset.$count ?>_d ?>" placeholder="Departure Date" title="Departure Date & Time" onchange="validate_transportDate('txt_plane_date-<?= $offset.$count ?>_d' , 'txt_arravl-<?= $offset.$count ?>_d');get_to_datetime(this.id,'txt_arravl-<?= $offset.$count ?>_d')" value="<?php echo date("d-m-Y H:i", strtotime($row_plane_details['date'])) ?>" style="width: 152px;/"></td>
            <td><input type="text" name="from_sector-1" id="from_sector-<?= $offset.$count ?>_d" placeholder="From Sector" title="From Sector" style="width: 250px;" value="<?php echo ($sq_city['city_name']) ? $sq_city['city_name']." - ".$row_plane_details['from_location'] : ''; ?>">
	        </td>
	        <td><input type="text" name="to_sector-1" id="to_sector-<?= $offset.$count ?>_d" placeholder="To Sector" title="To Sector" style="width: 250px;" value="<?php echo ($sq_city2['city_name']) ? $sq_city2['city_name']." - ".$row_plane_details['to_location'] : ''; ?>">
	        </td>
            <td><select id="txt_plane_company-<?= $offset.$count ?>_d" name="txt_plane_company-<?= $offset.$count ?>_d" class="app_select2" style="width:150px">
                <?php 
                 $sq_airline = mysql_fetch_assoc(mysql_query("select * from airline_master where airline_id='$row_plane_details[company]'"));?>
                <option value="<?php echo $sq_airline['airline_id'] ?>"><?php echo $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')' ?></option>
                <?php get_airline_name_dropdown(); ?>
            </select></td>
            <td style="width: 30px;"><input type="text" id="txt_plane_seats-<?= $offset.$count ?>_d" name="txt_plane_seats-<?= $offset.$count ?>_d" placeholder="Total Seats" title="Total Seats"  maxlength="2" onchange="validate_balance(this.id);"  value="<?php echo $row_plane_details['seats'] ?>"/></td>
            <td style="width: 130px;"><input type="text" id="txt_plane_amount-<?= $offset.$count ?>_d" name="txt_plane_amount-<?= $offset.$count ?>_d" placeholder="Amount" title="Amount" onchange="validate_balance(this.id);calculate_plane_expense('tbl_plane_travel_details_dynamic_row',true);"  value="<?php echo $row_plane_details['amount'] ?>"/></td>
            <td><input type="text" id="txt_arravl-<?= $offset.$count ?>_d" name="txt_arravl-<?= $offset.$count ?>_d" placeholder="Arrival date & time" title="Arrival date & time" onchange="validate_arrivalDate('txt_plane_date-<?= $offset.$count ?>_d' , 'txt_arravl-<?= $offset.$count ?>_d')" class="app_datetimepicker" value="<?php echo date("d-m-Y H:i:s", strtotime($row_plane_details['arraval_time'])) ?>"/></td>
            <td><input type="hidden" id="from_city-<?= $offset.$count ?>_d" value="<?= $row_plane_details['from_city'] ?>"></td>
        	<td><input type="hidden" id="to_city-<?= $offset.$count ?>_d" value="<?= $row_plane_details['to_city'] ?>"></td>
            <td><input type="hidden" value="<?php echo $row_plane_details['plane_id'] ?>"></td>
        </tr>
        <script>
            $('#plane_from_location-<?= $offset.$count ?>_d,#plane_to_location-<?= $offset.$count ?>_d, #txt_plane_company-<?= $offset.$count ?>_d').select2();
            $('#txt_arravl-<?= $offset.$count ?>_d, #txt_plane_date-<?= $offset.$count ?>_d').datetimepicker({ format:'d-m-Y H:i:s' });
        </script>
    <?php }
    } ?>
    </table>
    <input type = "hidden" id="txt_plane_date_generate" value="<?php echo $count ?>">
</div>  </div> </div>
<!-- check businessrule after removing hidden from below -->
    <div class="row hidden">
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Subtotal</label>
            <input type="text" id="txt_plane_expense" name="txt_plane_expense"  class="text-right" value="<?php echo $sq_booking_info['plane_expense'] ?>" placeholder="Subtotal" title="Subtotal" disabled />
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Service Charge</label>
            <input type="text" id="txt_plane_service_charge" name="txt_plane_service_charge"  class="text-right" value="<?php echo $sq_booking_info['plane_service_charge'] ?>"placeholder="Service Charge" title="Service Charge" onchange="validate_balance(this.id); calculate_total_plane_expense()" />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax</label>
            <select name="plane_taxation_id" id="plane_taxation_id" onchange="generic_tax_reflect(this.id, 'plane_service_tax', 'calculate_total_plane_expense');">
               
            </select>
            <input type="hidden" id="plane_service_tax" name="plane_service_tax" value="<?= $sq_booking_info['plane_service_tax'] ?>">            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax Amount</label>
            <input type="text" id="plane_service_tax_subtotal" name="plane_service_tax_subtotal" value="<?= $sq_booking_info['plane_service_tax_subtotal'] ?>" title="Tax Amount" disabled>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Total</label>
            <input type="text" id="txt_plane_total_expense" name="txt_plane_total_expense" value="<?php echo $sq_booking_info['total_plane_expense'] ?>" placeholder="total expense" title="Total expense" disabled />
        </div>
    </div>    

<script>
event_airport('tbl_plane_travel_details_dynamic_row',3,4);
function generating_plane_date()
{
    var count = $("#txt_plane_date_generate").val();
    for(var i=0; i<=count; i++)
    {
        $( "#txt_plane_date-"+i).datetimepicker({ format: "d-m-Y H:i:s"  });
    }             
}
generating_plane_date();
</script>