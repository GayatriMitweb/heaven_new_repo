<tr>
    <td><input class="css-checkbox" id="chk_exc<?= $offset ?>1" type="checkbox" onchange="excursion_amount_calculate('exc_date<?= $offset ?>-1');calculate_exc_expense('tbl_dynamic_exc_booking')" checked><label class="css-label" for="chk_visa<?= $offset ?>1"> <label></td>
    <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
    <td><input type="text" style="width:200px" id="exc_date-<?= $offset ?>1" name="exc_date-<?= $offset ?>1" placeholder="Activity Date & Time" title="Activity Date & Time" class="app_datetimepicker" value="<?= date('d-m-Y H:i:s') ?>" style="width:110px" onchange="get_excursion_amount();"></td>
    <td><select id="city_name-<?= $offset ?>1" class="form-control city_name_exc" name="city_name-" title="City Name" onchange="get_excursion_list(this.id);" style="width:150px">
        </select>
    </td>
    <td><select id="excursion-<?= $offset ?>1" class="app_select2 form-control" title="Activity Name" name="excursion-<?= $offset ?>1" onchange="get_excursion_amount();" style="width:155px">
        <option value="">*Activity Name</option>                                      
    </select></td>
    <td><select name="transfer_option-<?= $offset ?>1" id="transfer_option-<?= $offset ?>1" data-toggle="tooltip" class="form-contrl app_select2" title="Transfer Option" style="width:150px" onchange="get_excursion_amount();">
        <option value="">*Transfer Option</option>
        <option value="Without Transfer">Without Transfer</option>
        <option value="Sharing Transfer">Sharing Transfer</option>
        <option value="Private Transfer">Private Transfer</option>
        <option value="SIC">SIC</option>
        </select></td>
    <td><input type="text" id="total_adult-<?= $offset ?>1" name="total_adult-<?= $offset ?>1" placeholder="*Total Adult" title="Total Adult" onchange="excursion_amount_calculate(this.id);calculate_exc_expense('tbl_dynamic_exc_booking');validate_balance(this.id);get_auto_values('balance_date','exc_issue_amount','payment_mode','service_charge','markup','save','true','service_charge');" style="width:110px"></td>
    <td><input type="text" id="total_children-<?= $offset ?>1" name="total_children-<?= $offset ?>1" placeholder="*Total Child" title="Total Child" onchange="excursion_amount_calculate(this.id);calculate_exc_expense('tbl_dynamic_exc_booking');validate_balance(this.id);get_auto_values('balance_date','exc_issue_amount','payment_mode','service_charge','markup','save','true','service_charge');" style="width:110px"></td>
    <td><input type="text" id="adult_cost-<?= $offset ?>1" name="adult_cost-<?= $offset ?>1" placeholder="Adult Cost" title="Adult Cost" onchange="excursion_amount_calculate(this.id);calculate_exc_expense('tbl_dynamic_exc_booking');validate_balance(this.id)" style="width:110px"></td>
    <td><input type="text" id="child_cost-<?= $offset ?>1" name="child_cost-<?= $offset ?>1" placeholder="Child Cost" title="Child Cost" onchange="excursion_amount_calculate(this.id);calculate_exc_expense('tbl_dynamic_exc_booking');validate_balance(this.id)" style="width:110px"></td>
    <td><input type="text" id="total_amount-<?= $offset ?>1" name="total_amount-<?= $offset ?>1" placeholder="Total Amount" title="Excursion Amount" onchange="validate_balance(this.id)" style="width:110px"></td>
</tr>

<script>
    city_lzloading('.city_name_exc');
    $('#exc_date-<?= $offset ?>1').datetimepicker({ format:'d-m-Y H:i' });
</script>