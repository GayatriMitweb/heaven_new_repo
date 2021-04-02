<div class="row mg_bt_10" >
    <div class="col-md-4 col-sm-6">
        <input type="checkbox" id="chk_cruise_select_all" onchange="select_all('tbl_dynamic_cruise_package_booking',this.id);  calculate_cruise_expense('tbl_dynamic_cruise_package_booking',true)">&nbsp;&nbsp;<label for="chk_cruise_select_all">Select All</label>
    </div>
    <div class="col-md-8 col-sm-6 text-right">
        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_dynamic_cruise_package_booking')" title="Add Row"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('tbl_dynamic_cruise_package_booking'); calculate_cruise_expense('tbl_dynamic_cruise_package_booking',true)" title="Delete Row"><i class="fa fa-trash"></i></button>

        <div class="div-upload" id="div_upload_button">
            <div id="package_cruise_upload" class="upload-button"><span>Ticket</span></div><span id="package_cruise_status" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="txt_cruise_upload_dir" name="txt_cruise_upload_dir">
        </div>  
    </div>
</div>    

<div class="row"> <div class="col-xs-12"> <div class="table-responsive">

    <table id="tbl_dynamic_cruise_package_booking" name="tbl_dynamic_cruise_package_booking" class="table table-bordered mg_bt_30">
        <tr>
            <td><input class="css-checkbox" id="chk_cruise1" type="checkbox" onchange="calculate_cruise_expense('tbl_dynamic_cruise_package_booking',true)" ><label class="css-label" for="chk_cruise1"><label></td>
            <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><input type="text" id="cruise_departure_date" onchange="get_to_datetime(this.id, 'cruise_arrival_date');validate_transportDate('cruise_departure_date' , 'cruise_arrival_date')" name="cruise_departure_date" placeholder="Departure Date & Time" title="Departure Date & Time" class="app_datetimepicker" value="<?= date('d-m-Y H:i:s') ?>"></td>
            <td><input type="text" id="cruise_arrival_date" onchange="validate_arrivalDate('cruise_departure_date' , 'cruise_arrival_date')" name="cruise_arrival_date" placeholder="Arrival Date & Time" title="Arrival Date & Time" class="app_datetimepicker" value="<?= date('d-m-Y H:i:s') ?>"></td>
            <td><input type="text" id="route" name="route" placeholder="*Route" onchange="validate_specialChar(this.id); " title="Route"></td>
            <td><input type="text" id="cabin" name="cabin" placeholder="*Cabin" onchange="validate_specialChar(this.id); " title="Cabin"></td>
            <td class="col-md-2"><select id="sharing" name="sharing" style="width:100%;" title="Sharing">
                    <option value="">Sharing</option>
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Triple Quad">Triple Quad</option>
                </select></td>
            <td class="col-md-1"><input type="text" id="txt_cruise_total_seat1" name="txt_cruise_total_seat1" placeholder="Total Seats" title="Total Seats" maxlength="3" onchange="validate_balance(this.id);" /></td>

            <td style="width: 130px;"><input type="text" id="txt_cruise_amount1" name="txt_cruise_amount1" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id); calculate_cruise_expense('tbl_dynamic_cruise_package_booking',true);" /></td>
        </tr>
    </table>

</div>  </div> </div>   
<!-- check businessrule after removing hidden from below -->
    <div class="row hidden">
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Subtotal</label>
            <input type="text" id="txt_cruise_expense" name="txt_cruise_expense" title="Subtotal" placeholder="Subtotal" class="text-right" value="0.00" disabled />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Service Charge</label>
            <input type="text" id="txt_cruise_service_charge" name="txt_cruise_service_charge"  class="text-right" value="0.00" onchange="validate_balance(this.id); calculate_total_cruise_expense()" placeholder="Service Charge" title="Service Charge"/>            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax</label>
            <select name="cruise_taxation_id" id="cruise_taxation_id" title="Tax" placeholder="Tax" onchange="generic_tax_reflect(this.id, 'cruise_service_tax', 'calculate_total_cruise_expense');">
            </select>
            <input type="hidden" id="cruise_service_tax" name="cruise_service_tax" value="0">            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax Amount</label>
            <input type="text" id="cruise_service_tax_subtotal" name="cruise_service_tax_subtotal" placeholder="Tax Amount" title="Tax Amount" disabled>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12">
            <label>Total</label>
            <input type="text" id="txt_cruise_total_expense" name="txt_cruise_total_expense" placeholder="Total" title="Total" class="text-right amount_feild_highlight" value="0.00" disabled />            
        </div>
    </div>

<script type="text/javascript">
    $('#cruise_departure_date, #cruise_arrival_date').datetimepicker({ format:'d-m-Y H:i:s' });
</script>