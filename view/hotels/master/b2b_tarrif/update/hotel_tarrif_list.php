
        <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
        <td><select name="room_cat" id="room_cat" style="width:145px;" title="Room Category" class="form-control app_select2"><?php get_room_category_dropdown(); ?></select></td>
        <td><input type="text" id="m_occupancy" name="m_occupancy" placeholder="*Max Occupancy" title="Max Occupancy" onchange="validate_balance(this.id)" style="width: 130px;"/></td>           
        <td><input type="text" id="from_date" class="form-control" name="from_date" placeholder="Valid From" title="Valid From" value="<?= date('d-m-Y') ?>" onchange="get_to_date(this.id,'to_date')" style="width: 120px;" /></td>
        <td><input type="text" id="to_date" class="form-control" name="to_date" placeholder="Valid To " title="Valid To" onchange="validate_issueDate('from_date' ,'to_date')" value="<?= date('d-m-Y') ?>" style="width: 120px;" /></td>
        <td style='display:none;'><input type="text" id="single_bed" name="single_bed" placeholder="Single Bed" title="Single Bed" onchange="validate_balance(this.id)" /></td>
        <td><input type="text" id="double_bed" name="double_bed" placeholder="Room Cost" title="Room Cost"  onchange="validate_balance(this.id)" style="width: 120px;"/></td>
        <td style='display:none;'><input type="text" id="triple_bed" name="triple_bed" placeholder="Triple Bed" title="Triple Bed"  onchange="validate_balance(this.id)" /></td>
        <td><input type="text" id="cwbed" name="cwbed" placeholder="Child With Bed" title="Child With Bed"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
        <td><input type="text" id="cwobed" name="cwobed" placeholder="Child Without Bed" title="Child Without Bed"  onchange="validate_balance(this.id)" style="width: 137px;" /></td>
        <td style='display:none;'><input type="text" id="first_child" name="first_child" placeholder="First Child" title="First Child"  onchange="validate_balance(this.id)" /></td>
        <td style='display:none;'><input type="text" id="second_child" name="second_child" placeholder="Second Child" title="Second Child"  onchange="validate_balance(this.id)" /></td>
        <td><input type="text" id="with_bed" name="with_bed" placeholder="Extra Bed" title="Extra Bed"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
        <td style='display:none;'><input type="text" id="queen" name="queen" placeholder="Queen Bed" title="Queen Bed"  onchange="validate_balance(this.id)" /></td>
        <td style='display:none;'><input type="text" id="king" name="king" placeholder="King Bed" title="King Bed"  onchange="validate_balance(this.id)" /></td>
        <td style='display:none;'><input type="text" id="quad_bed" name="quad_bed" placeholder="Quad Bed" title="Quad Bed"  onchange="validate_balance(this.id)" /></td>
        <td style='display:none;'><input type="text" id="twin" name="twin" placeholder="Twin Bed" title="Twin Bed"  onchange="validate_balance(this.id)"/></td>
        <td><input type="text" id="markup_per" name="markup_per" placeholder="Markup(%)" title="Markup(%)"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
        <td><input type="text" id="flat_markup" name="flat_markup" placeholder="Flat Markup" title="Flat Markup"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
        <td><select name="meal_plan" id="meal_plan" style="width: 110px" class="form-control app_select2" title="Meal Plan">
        <?php get_mealplan_dropdown(); ?></td>
        <td><input type="hidden" id="entry_id" name="entry_id" /></td>
</tr>
<script>
$('#room_cat').select2();
</script>