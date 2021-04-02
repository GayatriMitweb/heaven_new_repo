<div class="row">
    <div class="col-xs-12 text-right mg_bt_20_sm_xs">
        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_tour_quotation_dynamic_hotel_update');city_lzloading('.city_name1');"><i class="fa fa-plus"></i></button>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
        <table id="tbl_package_tour_quotation_dynamic_hotel_update" name="tbl_package_tour_quotation_dynamic_hotel_update" class="table table-bordered pd_bt_51">
            <?php 
            $sq_hotel_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_hotel_entries where quotation_id='$quotation_id'"));
            if($sq_hotel_count==0){
                $sq_package = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$package_id'"));
                $package_name = $sq_package['package_name'];
                ?>
                <tr>
                    <td><input class="css-checkbox" id="chk_hotel1" type="checkbox" checked readonly><label class="css-label" for="chk_hotel1" > <label></td>
                    <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                    <td><select id="city_name1" name="city_name1" onchange="hotel_name_list_load(this.id);" class="city_name1 city_master_dropdown" style="width:100%" title="Select City Name">
                          </select></td>
                    <td><select id="hotel_name-1" name="hotel_name-1" onchange="hotel_type_load(this.id);get_hotel_cost();" style="width:160px" title="Select Hotel Name">
                        <option value="">Hotel Name</option>
                        </select></td>
                    <td><select name="room_cat-1" id="room_cat-1" style="width:145px;" title="Room Category" class="form-control app_select2" onchange="get_hotel_cost();"><?php get_room_category_dropdown(); ?></select></td>
                    <td><input type="text" style="width:150px;" class="app_datepicker" id="check_in-1" name="check_in-1" placeholder="Check-In Date" title="Check-In Date"  onchange="get_auto_to_date(this.id);get_hotel_cost();"></td>
                    <td><input type="text" style="width:150px;" class="app_datepicker" id="check_out-1" name="check_out-1" placeholder="Check-Out Date" title="Check-Out Date" onchange="calculate_total_nights(this.id);validate_validDates(this.id);get_hotel_cost();"></td>
                    <td><input type="text" id="hotel_type-1" name="hotel_type-1" placeholder="Hotel Type" title="Hotel Type" style="width:150px" readonly></td>
                    <td class="hidden"><input type="text" id="hotel_stay_days-1" title="Total Nights" name="hotel_stay_days-1" placeholder="Total Nights" onchange="validate_balance(this.id);" style="display:none;"></td>
                    <td><input type="text" id="no_of_rooms-1" title="Total Rooms" name="no_of_rooms-1" placeholder="Total Rooms" onchange="validate_balance(this.id);get_hotel_cost();" style="width:110px"></td>
                    <td><input type="text" id="extra_bed-1" name="extra_bed-1" title="Extra Bed" placeholder="Extra Bed" onchange="validate_balance(this.id);get_hotel_cost();" style="width:100px"></td>
                    <td><input type="text" id="package_name1" name="package_name1" placeholder="Package Name" title="Package Name" style="width:200px" readonly></td>  
                    <td class="hidden"><input type="text" id="hotel_cost1" name="hotel_cost1" placeholder="Hotel Cost" title="Hotel Cost" style="display: none" onchange="validate_balance(this.id)"></td> 
                    <td class="hidden"><input type="text" id="package_id1" name="package_id1" placeholder="Package ID" title="Package ID" style="display:none;"></td> 
                    <td class="hidden"><input type="text" id="extra_bed_cost-1" name="extra_bed_cost-1" placeholder="Extra bed cost" title="Extra bed cost"  style="display: none" onchange="validate_balance(this.id)"></td> 
                    <td class="hidden"><input type="text"/></td>    
                </tr>
                <?php
            }
            else{
                $count = 0;
                $sq_q_hotel = mysql_query("select * from package_tour_quotation_hotel_entries where quotation_id='$quotation_id' and package_id = '$sq_quotation[package_id]'");
                while($row_q_hotel = mysql_fetch_assoc($sq_q_hotel)){

                    $count++;
                    $sq_package = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$row_q_hotel[package_id]'"));
                    $package_id = $sq_package['package_name'];
                    $sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_q_hotel[city_name]'"));
                    $sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$row_q_hotel[hotel_name]'"));
                    ?>
                    <tr>
                        <td><input class="css-checkbox" id="chk_hotel<?= $count ?>_1" type="checkbox" checked><label class="css-label" for="chk_hotel1"> <label></td>
                        <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                        <td><select id="city_name1<?= $count ?>" name="city_name1<?= $count ?>" class="city_name1" onchange="hotel_name_list_load(this.id);" class="city_master_dropdown" style="width:100%" title="Select City Name">

                                <option value="<?php echo $sq_city['city_id']; ?>"><?php echo $sq_city['city_name']; ?></option>
                                </select></td>
                        <td><select id="hotel_name-<?= $count ?>" name="hotel_name-<?= $count ?>" onchange="hotel_type_load(this.id);get_hotel_cost();" style="width:160px" title="Select Hotel Name">
                            <option value="<?php echo $sq_hotel['hotel_id']; ?>"><?php echo $sq_hotel['hotel_name']; ?></option>
                            <option value="">Hotel Name</option>
                            </select></td>
                        <td><select name="room_cat-<?= $count ?>" id="room_cat-<?= $count ?>" style="width:145px;" onchange="get_hotel_cost();" title="Room Category" class="form-control app_select2">
                            <option value="<?php echo $row_q_hotel['room_category']; ?>"><?php echo $row_q_hotel['room_category']; ?></option>
                            <?php get_room_category_dropdown(); ?></select></td>
                        <td><input type="text" style="width:150px;" class="app_datepicker form-control" id="check_in-<?= $count ?>" name="check_in-<?= $count ?>" value="<?= get_date_user($row_q_hotel['check_in']) ?>" placeholder="Check-In Date" title="Check-In Date" onchange="get_auto_to_date(this.id);get_hotel_cost();"></td>
                        <td><input type="text" style="width:150px;" class="app_datepicker form-control" id="check_out-<?= $count ?>" name="check_out-<?= $count ?>"  value="<?= get_date_user($row_q_hotel['check_out']) ?>"placeholder="Check-Out Date" title="Check-Out Date" onchange="calculate_total_nights(this.id);validate_validDates(this.id);get_hotel_cost();"></td>
                        <td><input type="text" id="hotel_type-<?= $count ?>" name="hotel_type-<?= $count ?>" placeholder="Hotel Type" value="<?= $row_q_hotel['hotel_type'] ?>" style="width:150px;" title="Hotel Type" readonly></td>
                        <td class="hidden"><input type="text" id="hotel_stay_days-<?= $count ?>" name="hotel_stay_days-<?= $count ?>" placeholder="*Total Nights"  value="<?= $row_q_hotel['total_days'] ?>" onchange="validate_balance(this.id);" title="Total Nights"></td>
                        <td><input type="text" id="no_of_rooms-<?= $count ?>" value="<?= $row_q_hotel['total_rooms'] ?>" title="No.Of Rooms" name="no_of_rooms-<?= $count ?>" onchange="validate_balance(this.id);get_hotel_cost();" placeholder="No.Of Rooms" style="width:110px;"></td>
                        <td><input type="text" id="extra_bed-<?= $count ?>" onchange="validate_balance(this.id);get_hotel_cost();" name="extra_bed-<?= $count ?>" title="Extra Bed"  value="<?= $row_q_hotel['extra_bed'] ?>" style="width:110px;"></td>
                        <td class="hidden"><input type="text" id="package_name-<?= $count ?>" name="package_name-<?= $count ?>" placeholder="Package Name" title="Package Name" value="<?= $package_id ?>" style="display: none" style="width:200px;" readonly></td>   
                        <td class="hidden"><input type="text" id="hotel_cost-<?= $count ?>" name="hotel_cost-<?= $count ?>"  value="<?= $row_q_hotel['hotel_cost'] ?>" onchange="validate_balance(this.id);" placeholder="Hotel Cost" style="display: none" title="Hotel Cost"></td> 
                        <td class="hidden"><input type="text" id="package_id-<?= $count ?>" name="package_id-<?= $count ?>" placeholder="Package ID" title="Package ID"  value="<?= $row_q_hotel['package_id'] ?>" style="display: none"></td> 
                        <td class="hidden"><input type="text" id="extra_bed_cost-<?= $count ?>" onchange="validate_balance(this.id);" style="display: none" name="extra_bed_cost-<?= $count ?>" placeholder="Extra bed cost" title="Extra bed cost"  value="<?= $row_q_hotel['extra_bed_cost'] ?>"></td> 
                        <td class="hidden"><input type="text" value="<?= $row_q_hotel['id'] ?>"></td>    
                    </tr>
                    <script>
                    $('#check_in-<?= $count ?>, #check_out-<?= $count ?>').datetimepicker({ format:'d-m-Y',timepicker:false });
                    </script>
                    <?php
                }
            }
            ?>
        </table>
        </div>
    </div>
</div>
<script>
$('#check_in-1, #check_out-1').datetimepicker({ format:'d-m-Y',timepicker:false });
$(document).ready(function(){
    city_lzloading('.city_name1');
});
</script>