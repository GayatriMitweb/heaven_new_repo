<tr>
    <td ><input id="chk_hotel<?= $prefix ?>_1" type="checkbox" onchange="get_auto_values('booking_date','sub_total','payment_mode','service_charge','markup','save')" checked ></td>
    <td><input maxlength="15" type="text" name="username"  value="1" placeholder="Sr. No." disabled/></td>
    <td style="width:104px"><select id="city_id<?= $prefix ?>1" name="city_id<?= $prefix ?>1" title="City" onchange="hotel_name_list_load(this.id);" class="city_id" style="width:100%">
    </select>
    </td>    
    <td style="width:130px"><select id="hotel_id1" name="hotel_id1" title="Hotel" onchange="get_auto_values('booking_date','sub_total','payment_mode','service_charge','markup','save','true','service_charge','discount');">
            <option value="">*Select Hotel</option>
        </select>
    </td>
    <td><input type="text" style="width:150px;" class="app_datetimepicker" id="check_in<?= $prefix ?>1" name="check_in<?= $prefix ?>1" placeholder="Check-In Date Time" title="Check-In Date Time" value="<?= date('d-m-Y H:i:s')?>" onchange="get_to_datetime(this.id,'check_out<?= $prefix ?>1')"></td>
    <td><input type="text" style="width:150px;" class="app_datetimepicker" id="check_out<?= $prefix ?>1" name="check_out<?= $prefix ?>1" placeholder="Check-Out Date Time" title="Check-Out Date Time" value="<?= date('d-m-Y H:i:s')?>"></td>
    <td><input type="text" id="no_of_nights<?= $prefix ?>1" name="no_of_nights<?= $prefix ?>1" placeholder="*No Of Nights" title="No Of Nights" onchange="get_auto_values('booking_date','sub_total','payment_mode','service_charge','markup','save','true','service_charge','discount');validate_balance(this.id)"></td>
    <td><input type="text" id="rooms<?= $prefix ?>1" name="rooms<?= $prefix ?>1" placeholder="*No Of Rooms" title="No Of Rooms" onchange="get_auto_values('booking_date','sub_total','payment_mode','service_charge','markup','save','true','service_charge','discount');validate_balance(this.id)"></td>
    <td style="width:129px"><select name="room_type<?= $prefix ?>1" id="room_type<?= $prefix ?>1" title="Room Type">
        <option value="">Room Type</option>
        <option value="AC">AC</option>
        <option value="Non AC">Non AC</option>
    </select></td>
    <td style="width:115px"><select name="category<?= $prefix ?>1" id="category<?= $prefix ?>1" title="Category">
        <?php echo get_room_category_dropdown(); ?>   
    </select></td>
    <td style="width:185px"><select name="accomodation_type<?= $prefix ?>1" id="accomodation_type<?= $prefix ?>1" title="Accommodation Type">
            <option value="">Accommodation Type</option>
            <option value="Twin Sharing">Twin Sharing</option>
            <option value="Single Adult">Single Adult</option>
            <option value="Triple Sharing">Triple Sharing</option>
            <option value="Quadruple Sharing">Quadruple Sharing</option>
    </select></td>
    <td><input type="text" id="extra_beds<?= $prefix ?>1" name="extra_beds<?= $prefix ?>1" placeholder="*Extra Beds" title="Extra Beds" onchange="validate_balance(this.id)"></td>
    <td style="width:120px"><select title="Meal Plan" id="meal_plan<?= $prefix ?>1" name="meal_plan<?= $prefix ?>1" title="Meal Plan" Placeholder="Meal Plan">
            <?php get_mealplan_dropdown(); ?>
    </select></td>
    <td><input type="text" id="conf_no<?= $prefix ?>1" name="conf_no<?= $prefix ?>1" placeholder="Confirmation No." title="Confirmation No."></td>
</tr>