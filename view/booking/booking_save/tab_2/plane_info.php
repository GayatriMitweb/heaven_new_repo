<div class="row">
    <div class="col-sm-10 col-xs-12 col-sm-push-2 text-right">
        <button type="button" class="btn btn-info btn-sm ico_left mg_bt_10_sm_xs" onClick="addRow('tbl_plane_travel_details_dynamic_row');event_airport('tbl_plane_travel_details_dynamic_row',3,4)"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
        <button type="button" class="btn btn-danger btn-sm ico_left mg_bt_10_sm_xs" onClick="deleteRow('tbl_plane_travel_details_dynamic_row'); calculate_plane_expense('tbl_plane_travel_details_dynamic_row')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>  

        <!--  Code to uploadf button -->
        <div class="div-upload mg_bt_10_sm_xs" id="div_upload_button">
            <div id="plane_upload" class="upload-button"><span>Ticket</span></div><span id="plane_status" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="txt_plane_upload_dir" name="txt_plane_upload_dir">
        </div>    
    </div>
    <div class="col-sm-2 col-xs-12 col-sm-pull-10 mg_bt_10_sm_xs">
        <input type="checkbox" class="css-checkbox" id="chk_plane_select_all" onchange="select_all('tbl_plane_travel_details_dynamic_row',this.id); calculate_plane_expense('tbl_plane_travel_details_dynamic_row')" checked>&nbsp;&nbsp;
        <label for="chk_plane_select_all" class="">Select All</label>
    </div>
</div>

 <div class="row mg_tp_20"> <div class="col-xs-12"> <div class="table-responsive">       
       
    <table id="tbl_plane_travel_details_dynamic_row" name="tbl_plane_travel_details_dynamic_row" class="table table-bordered table-hover pd_bt_51 no-marg">
        <tr>
            <td class="col-md-1"><input class="css-checkbox" id="check-btn-plane-1" type="checkbox" onchange="calculate_plane_expense('tbl_plane_travel_details_dynamic_row')" ></td>

            <td class="col-md-1"><input maxlength="15" type="text" id="txt_plane_sr" name="txt_plane_sr" value="1" placeholder="Sr.No." disabled /></td>

            <td><input type="text" id="txt_plane_date-1" name="txt_plane_date-1" placeholder="*Departure Date and Time" Title="Departure Date and Time" value="<?= date('d-m-Y H:i:s') ?>"  onchange="get_to_datetime(this.id,'txt_arravl-1');validate_travelingDates(this.id);" style="width:136px"></td>

            <td><input type="text" name="from_sector-1" id="from_sector-1" style="width:300px" placeholder="From Sector" title="From Sector">
			</td>
			<td><input type="text" name="to_sector-1" id="to_sector-1" style="width:300px" placeholder="To Sector" title="To Sector">
			</td> 
            <td><select id="txt_plane_company-1" name="txt_plane_company-1" class="app_select2" style="width:150px" title="Airline Name">
                <option value="">*Airline Name</option>
                <?php get_airline_name_dropdown(); ?>
            </select></td>
            <td><input type="text" id="txt_plane_seats-1" name="txt_plane_seats-1" title="Total Seats"  placeholder="Total Seats"  maxlength="2" onchange="validate_balance(this.id);" style="width:100px" /></td>
            <td><input type="text" id="txt_plane_amount-1" name="txt_plane_amount-1"  class="text-right" placeholder="*Amount" title="Amount" onchange="calculate_plane_expense('tbl_plane_travel_details_dynamic_row');number_validate(this.id)" style="width:120px"/></td>
            <td><input type="text" id="txt_arravl-1" name="txt_arravl-1" class="app_datetimepicker" placeholder="Arrival Date & Time" title="Arrival Date & Time" onchange="validate_travelingDates(this.id);" value="<?= date('d-m-Y') ?>" style="width:136px"></td>
            <td><input type="hidden" id="from_city-1"> </td>
			<td><input type="hidden" id="to_city-1"></td>

        </tr>
    </table>

</div> </div> </div>
      
    <div class="row mg_tp_20 hidden">
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Subtotal</label>
            <input type="text" id="txt_plane_expense" name="txt_plane_expense" title="Sub Total" class="text-right" value="0.00" readonly />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Service Charge</label>
            <input type="text" id="txt_plane_service_charge" name="txt_plane_service_charge"  class="text-right" value="0.00" title="Service Charge" onchange="validate_balance(this.id); calculate_total_plane_expense()" />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax</label>
            <select name="plane_taxation_id" id="plane_taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'plane_service_tax', 'calculate_total_plane_expense');">
                
            </select>
            <input type="hidden" id="plane_service_tax" name="plane_service_tax" value="0">            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax Amount</label>
            <input type="text" id="plane_service_tax_subtotal" name="plane_service_tax_subtotal" placeholder="0.00" title="Tax Amount" readonly>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Total</label>
            <input type="text" id="txt_plane_total_expense" title="Total" name="txt_plane_total_expense"  class="text-right amount_feild_highlight" value="0.00" readonly/>
        </div>
    </div>
    <script>
        event_airport('tbl_plane_travel_details_dynamic_row',3,4);
    </script>