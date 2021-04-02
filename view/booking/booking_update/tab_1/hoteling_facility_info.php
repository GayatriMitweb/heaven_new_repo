<?php
$sq_total_mem = mysql_num_rows(mysql_query("select traveler_id from travelers_details where traveler_group_id='$traveler_group_id'"));
?>
<h5 class="booking-section-heading main_block">Accommodation Details</h5>

<div class="row text-center mg_bt_20">
    
    <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10_xs">
        <label>Total Passenger</label>
        <input type="text" id="txt_stay_total_seats" name="txt_stay_total_seats" title="Total Passenger" value="<?php echo $sq_total_mem ?>" readonly/>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
        <label>Single Bed Room</label>
        <select id="txt_single_bed_room" title="Single Bed Room" onchange="payment_details_reflected_data('tbl_member_dynamic_row')" name="txt_single_bed_room">
        <option value="<?php echo $tourwise_details['s_single_bed_room'] ?>"><?php echo $tourwise_details['s_single_bed_room'] ?></option>
            <?php 
            for($i=0; $i<=20; $i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
        </select>  
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
        <label>Double Bed Room</label>
        <select id="txt_double_bed_room" name="txt_double_bed_room" title="Double Bed Room">
            <option value="<?php echo $tourwise_details['s_double_bed_room'] ?>"><?php echo $tourwise_details['s_double_bed_room'] ?></option>
            <?php 
            for($i=0; $i<=20; $i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
        </select>  
    </div>

    <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10_xs">
        <label>Extra Bed</label>
        <select id="txt_extra_bed" name="txt_extra_bed"  title="Extra Bed" onchange="payment_details_reflected_data('tbl_member_dynamic_row')">
            <option value="<?php echo $tourwise_details['s_extra_bed'] ?>"><?php echo $tourwise_details['s_extra_bed'] ?></option>
            <?php 
            for($i=0; $i<=20; $i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
        </select>             
    </div>           

    <div class="col-md-2 col-sm-6 col-xs-12">
        <label>On floor</label>
        <select id="txt_on_floor" name="txt_on_floor" title="On floor" onchange="payment_details_reflected_data('tbl_member_dynamic_row')">
            <option value="<?php echo $tourwise_details['s_on_floor'] ?>"><?php echo $tourwise_details['s_on_floor'] ?></option>
            <?php 
            for($i=0; $i<=20; $i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
        </select>             
    </div>   


</div>

<script src="../js/tab_1_hoteling_facility.js"></script>