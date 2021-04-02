<div class="row mg_bt_10" >
    <div class="col-md-4 col-sm-6">
        <input type="checkbox" id="chk_train_select_all" onchange="select_all('tbl_train_travel_details_dynamic_row',this.id);  calculate_train_expense('tbl_train_travel_details_dynamic_row',true)" >&nbsp;&nbsp;<label for="chk_train_select_all">Select All</label>
    </div>
    <div class="col-md-8 col-sm-6 text-right">
        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_train_travel_details_dynamic_row');city_lzloading('.train_from','*From',true);city_lzloading('.train_to','*To',true);" title="Add Row"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('tbl_train_travel_details_dynamic_row');calculate_train_expense('tbl_train_travel_details_dynamic_row',true);" title="Delete Row"><i class="fa fa-trash"></i></button>
        <div class="div-upload" id="div_upload_button">
            <div id="package_train_upload" class="upload-button"><span>Ticket</span></div><span id="package_train_status" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="txt_train_upload_dir" name="txt_train_upload_dir">
        </div>  
    </div>
</div>    

<div class="row mg_bt_30"> <div class="col-xs-12"> <div class="table-responsive">

    <table id="tbl_train_travel_details_dynamic_row" name="tbl_train_travel_details_dynamic_row" class="table table-bordered table-hover table-striped pd_bt_51 no-marg" style="width: 1400px;">
        <tr>
            <td><input id="check-btn-train-1" type="checkbox" onchange="calculate_train_expense('tbl_train_travel_details_dynamic_row',true)" ></td>
            <td><input maxlength="15" type="text" id="tr_train_sr_no" name="tr_train_sr_no" value="1" placeholder="Sr.No." disabled/></td>
            <td><input type="text" id="txt_train_date1" name="txt_train_date1" onchange="validate_pastDate(this.id)" placeholder="*Departure Date & Time" title="*Departure Date & Time" value="<?= Date('d-m-Y')?>" /></td>
            <td><select id="txt_train_from_location1" name="txt_train_from_location1" class="train_from" style="width:150px" title="From Location" onchange="validate_location('txt_train_from_location1' , 'txt_train_to_location1');">
            </select></td>
            <td><select id="txt_train_to_location1" name="txt_train_to_location1" onchange="validate_location('txt_train_to_location1' , 'txt_train_from_location1')" class="train_to" style="width:150px" title="To Location">
            </select></td>
            <td style="width: 130px;"><input type="text" id="txt_train_no1" onchange="validate_specialChar(this.id);" name="txt_train_no1" placeholder="Train Name & No" Title="Train Name & No"/></td>

            <td style="width: 30px;"><input type="text" id="txt_train_total_seat1" name="txt_train_total_seat1" placeholder="Total Seats" title="Total Seats" maxlength="3" onchange="validate_balance(this.id);" /></td>

            <td style="width: 130px;"><input type="text" id="txt_train_amount1" name="txt_train_amount1" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id);" onkeyup=" calculate_train_expense('tbl_train_travel_details_dynamic_row',true);" /></td>

            <td><select id="cmb_train_class1" name="cmb_train_class1" title="Class" style="width: 83px"> 
                    <option value="" selected>Class</option>
                    <?php get_train_class_dropdown(); ?>
                </select>
            </td>
            <td><select id="cmb_train_priority1" name="cmb_train_priority1" title="Priority" style="width: 93px"> 
                    <option value="" selected>Priority</option>
                    <option value="general"> General </option>
                    <option value="tatkal"> Tatkal </option>
                    <option value="self"> Self </option>
                </select>
            </td>
        </tr>
    </table>

</div>  </div> </div>   
<script>
$(document).ready(function(){
    city_lzloading('.train_from','*From',true);
    city_lzloading('.train_to','*To',true);
});    
</script>
<!-- check businessrule after removing hidden from below -->
    <div class="row hidden">
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Subtotal</label>
            <input type="text" id="txt_train_expense" name="txt_train_expense" title="Subtotal" placeholder="Subtotal" class="text-right" value="0.00" disabled />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Service Charge</label>
            <input type="text" id="txt_train_service_charge" name="txt_train_service_charge"  class="text-right" value="0.00" onchange="validate_balance(this.id); calculate_total_train_expense()" placeholder="Service Charge" title="Service Charge"/> 
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax</label>
            <select name="train_taxation_id" id="train_taxation_id" title="Tax" placeholder="Tax" onchange="generic_tax_reflect(this.id, 'train_service_tax', 'calculate_total_train_expense');">
            </select>
            <input type="hidden" id="train_service_tax" name="train_service_tax" value="0">            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax Amount</label>
            <input type="text" id="train_service_tax_subtotal" name="train_service_tax_subtotal" placeholder="Tax Amount" title="Tax Amount" disabled>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12">
            <label>Total</label>
            <input type="text" id="txt_train_total_expense" name="txt_train_total_expense" placeholder="Total" title="Total" class="text-right amount_feild_highlight" value="0.00" disabled />            
        </div>
    </div>
    <script>
        city_lzloading('#txt_train_from_location1', "*To",true);
        city_lzloading('#txt_train_to_location1', "*From",true);
    </script>