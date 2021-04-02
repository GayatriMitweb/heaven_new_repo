<div class="row">
    <div class="col-sm-10 col-xs-12 col-sm-push-2 text-right">
        <button type="button" class="btn btn-info btn-sm ico_left mg_bt_10_sm_xs" onClick="addRow('tbl_dynamic_cruise_package_booking')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
        <button type="button" class="btn btn-danger btn-sm ico_left mg_bt_10_sm_xs" onClick="deleteRow('tbl_dynamic_cruise_package_booking'); calculate_cruise_expense('tbl_dynamic_cruise_package_booking')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>  

        <!-- Code to upload button -->
        <div class="div-upload mg_bt_10_sm_xs" id="div_upload_button">
            <div id="cruise_upload" class="upload-button"><span>Ticket</span></div><span id="cruise_status" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="txt_cruise_upload_dir" name="txt_cruise_upload_dir">
        </div>   
    </div>
    <div class="col-sm-2 col-xs-12 col-sm-pull-10 mg_bt_10_sm_xs">
        <input type="checkbox" class="css-checkbox" id="chk_cruise_select_all" onchange="select_all('tbl_dynamic_cruise_package_booking',this.id); calculate_cruise_expense('tbl_dynamic_cruise_package_booking')" checked>&nbsp;&nbsp;
        <label for="chk_cruise_select_all">Select All</label>
    </div>
</div>  

<div class="row mg_bt_30"> <div class="col-xs-12"> <div class="table-responsive">
    
    <table id="tbl_dynamic_cruise_package_booking" name="tbl_dynamic_cruise_package_booking" class="table table-bordered table-hover mg_bt_30 no-marg-sm">
        <tr>
            <td><input class="css-checkbox" id="chk_cruise1" type="checkbox" onchange="calculate_cruise_expense('tbl_dynamic_cruise_package_booking')"><label class="css-label" for="chk_cruise1"><label></td>
            <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><input type="text" id="cruise_departure_date" name="cruise_departure_date" placeholder="Departure Date & Time" title="Departure Date & Time" class="app_datetimepicker" value="<?= date('d-m-Y H:i:s') ?>" onchange="get_to_datetime(this.id,'cruise_arrival_date');validate_travelingDates(this.id);" style="width:136px"></td>
            <td><input type="text" id="cruise_arrival_date" name="cruise_arrival_date" placeholder="Arrival Date & Time" title="Arrival Date & Time" class="app_datetimepicker" value="<?= date('d-m-Y H:i:s') ?>" style="width:136px" onchange="validate_travelingDates(this.id);"></td>
            <td><input type="text" id="route" name="route" onchange="validate_specialChar(this.id);" placeholder="*Route" title="Route" style="width:136px"></td>
            <td><input type="text" id="cabin" onchange="validate_specialChar(this.id);" name="cabin" placeholder="*Cabin" title="Cabin" style="width:136px"></td>
            <td><select id="sharing" name="sharing" style="width:100px;" title="Sharing">
                    <option value="">Sharing</option>
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Triple Quad">Triple Quad</option>
                </select></td>
            <td><input type="text" id="txt_cruise_total_seat1" name="txt_cruise_total_seat1" placeholder="Total Seats" title="Total Seats" maxlength="3" onchange="validate_balance(this.id);" style="width:100px" /></td>

            <td><input type="text" id="txt_cruise_amount1" name="txt_cruise_amount1" placeholder="*Amount" title="Amount" style="width:136px" onchange="calculate_cruise_expense('tbl_dynamic_cruise_package_booking');validate_balance(this.id);"  style="width:120px"/></td>
        </tr>
    </table>

</div> </div> </div>                    
                        
    <div class="row hidden">
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Subtotal</label>
            <input type="text" id="txt_cruise_expense" name="txt_cruise_expense"  title="Subtotal" class="text-right" value="0.00" readonly />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Service Charge</label>
            <input type="text" id="txt_cruise_service_charge" name="txt_cruise_service_charge"  class="text-right" value="0.00" title="Service Charge" onchange="number_validate(this.id); calculate_total_cruise_expense()" />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax</label>
            <select name="cruise_taxation_id" id="cruise_taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'cruise_service_tax', 'calculate_total_cruise_expense');">
               
            </select>
            <input type="hidden" name="cruise_service_tax" id="cruise_service_tax" value="0">            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax Amount</label>
            <input type="text" id="cruise_service_tax_subtotal" name="cruise_service_tax_subtotal" placeholder="0.00" title="Tax Amount" readonly>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12">
            <label>Total</label>
            <input type="text" id="txt_cruise_total_expense" name="txt_cruise_total_expense"  title="Total" class="text-right amount_feild_highlight" value="0.00" readonly />            
        </div>
    </div>
    
<script type="text/javascript">
    $('#cruise_departure_date,#cruise_arrival_date').datetimepicker({ format:'d-m-Y H:i:s' });
</script>