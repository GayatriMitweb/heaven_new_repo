<div class="row mg_bt_10">
    <div class="col-xs-12 text-right">
        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_dynamic_cruise_package_booking')" title="Add row"><i class="fa fa-plus"></i></button>
        <!-- Code to upload button -->
        <div class="div-upload" id="div_upload_button">
            <div id="package_cruise_upload" class="upload-button"><span>Ticket</span></div><span id="package_cruise_status" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="txt_cruise_upload_dir" name="txt_cruise_upload_dir" value="<?= $sq_booking_info['cruise_upload_ticket'] ?>">
        </div>  
    </div>
</div>      

<div class="row mg_bt_30"> <div class="col-xs-12"> <div class="table-responsive">

    <table id="tbl_dynamic_cruise_package_booking" name="tbl_dynamic_cruise_package_booking" class="table table-bordered no-marg">
    <?php
        $count_t = 0;
        $sq_cruise_details = mysql_query("select * from package_cruise_master where booking_id='$booking_id'");
        while($row_cruise_details = mysql_fetch_assoc($sq_cruise_details)){
            $count_t++;
    ?>
        <tr>
            <td><input class="css-checkbox" id="<?php echo 'chk_cruise1-'.$count_t.'t' ?>" type="checkbox" onchange="calculate_cruise_expense('tbl_dynamic_cruise_package_booking',true)" checked disabled><label class="css-label" for="chk_cruise1"><label></td>
            <td><input maxlength="15"  value="<?= $count_t ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><input type="text" id="cruise_departure_date<?= $count_t ?>t" onchange="validate_transportDate('cruise_departure_date<?= $count_t ?>t' , 'cruise_arrival_date<?= $count_t ?>t');get_to_datetime(this.id,'cruise_arrival_date<?= $count_t ?>t')" name="cruise_departure_date<?= $count_t ?>t" placeholder="Departure Date & Time" title="Departure Date & Time" class="app_datetimepicker" value="<?php echo get_datetime_user($row_cruise_details['dept_datetime']); ?> "></td>
            <td><input type="text" id="cruise_arrival_date<?= $count_t ?>t" onchange=" validate_arrivalDate('cruise_departure_date<?= $count_t ?>t' , 'cruise_arrival_date<?= $count_t ?>t')" name="cruise_arrival_date<?= $count_t ?>t" placeholder="Arrival Date & Time" title="Arrival Date & Time" class="app_datetimepicker" value="<?php echo get_datetime_user($row_cruise_details['arrival_datetime']); ?> "></td>
            <td><input type="text" id="route<?= $count_t ?>t" name="route<?= $count_t ?>t"  onchange="validate_specialChar(this.id);"  placeholder="Route" title="Route" value="<?php echo ($row_cruise_details['route']); ?> "></td>
            <td><input type="text" id="cabin<?= $count_t ?>t" name="cabin<?= $count_t ?>t"  onchange="validate_specialChar(this.id);"  placeholder="Cabin" title="Cabin" value="<?php echo ($row_cruise_details['cabin']); ?> "></td>
            <td class="col-md-2"><select id="sharing<?= $count_t ?>t" name="sharing<?= $count_t ?>t" style="width:100%;" title="Sharing">
            <?php if($row_cruise_details['sharing']!='') { ?><option value="<?php echo ($row_cruise_details['sharing']); ?>"><?php echo ($row_cruise_details['sharing']); ?></option><?php } ?>
                    <option value="">Sharing</option>
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Triple Quad">Triple Quad</option>
                </select></td>
            <td class="col-md-1"><input type="text" id="txt_cruise_total_seat1<?= $count_t ?>t" name="txt_cruise_total_seat1<?= $count_t ?>t" placeholder="Total Seats"  value="<?php echo $row_cruise_details['seats']; ?> " title="Total Seats" maxlength="3" onchange="validate_balance(this.id);" /></td>
            <td style="width: 130px;"><input type="text" id="txt_cruise_amount1<?= $count_t ?>t" name="txt_cruise_amount1<?= $count_t ?>t" placeholder="*Amount" title="Amount" value="<?php echo ($row_cruise_details['amount']); ?> "  onchange=" calculate_cruise_expense('tbl_dynamic_cruise_package_booking',true);" /></td>
            <td><input type="hidden" value="<?php echo $row_cruise_details['cruise_id'] ?>"></td>
        </tr>
        <script type="text/javascript">
            $('#cruise_departure_date<?= $count_t ?>t,#cruise_arrival_date<?= $count_t ?>t').datetimepicker({ format: "d-m-Y H:i:s"  });
        </script>
        <?php } ?>
    </table>
</div>  </div> </div>   
<!-- check businessrule after removing hidden from below -->
    <div class="row hidden">
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Subtotal</label>
            <input type="text" id="txt_cruise_expense" name="txt_cruise_expense" title="Subtotal" placeholder="Subtotal" class="text-right"  value="<?php echo ($sq_booking_info['cruise_expense']); ?>" disabled />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Service Charge</label>
            <input type="text" id="txt_cruise_service_charge" name="txt_cruise_service_charge"  class="text-right" value="<?php echo ($sq_booking_info['cruise_service_charge']); ?>" onchange="validate_balance(this.id); calculate_total_cruise_expense()" placeholder="Service Charge" title="Service Charge"/>            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax</label>
            <select name="cruise_taxation_id" id="cruise_taxation_id" title="Tax" placeholder="Tax" onchange="generic_tax_reflect(this.id, 'cruise_service_tax', 'calculate_total_cruise_expense');">

            </select>
            <input type="hidden" id="cruise_service_tax" name="cruise_service_tax" value="<?= $sq_booking_info['cruise_service_tax'] ?>">
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax Amount</label>
            <input type="text" id="cruise_service_tax_subtotal" name="cruise_service_tax_subtotal" placeholder="Tax Amount" value="<?= $sq_booking_info['cruise_service_tax_subtotal'] ?>" title="Tax Amount" disabled>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12">
            <label>Total</label>
            <input type="text" id="txt_cruise_total_expense" name="txt_cruise_total_expense" placeholder="Total" title="Total" class="text-right amount_feild_highlight" value="<?php echo ($sq_booking_info['total_cruise_expense']); ?>" disabled />            
        </div>
    </div>
