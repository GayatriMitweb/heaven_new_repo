<div class="row mg_bt_10">
    <div class="col-md-12 text-right text_center_xs">
        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_hotel_master_dynamic_update');city_lzloading('select[name^=city_name]')"><i class="fa fa-plus"></i></button>
    </div>
</div>

<div class="row mg_bt_10">
    <div class="col-md-12">
        <div class="table-responsive">
        <table id="tbl_package_hotel_master_dynamic_update" name="tbl_package_hotel_master_dynamic_update" class="table table-bordered no-marg pd_bt_51">
			<?php 
			$sq_plane_count = mysql_num_rows(mysql_query("select * from group_tour_hotel_entries where tour_id='$tour_id'"));
			if($sq_plane_count==0){
				?>
                <tr>
                    <td><input class="css-checkbox" id="chk_dest1" type="checkbox"><label class="css-label" for="chk_dest1"> <label></td>
					<td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
					<td><select id="city_name" name="city_name1" onchange="hotel_name_list_load(this.id);" class="city_master_dropdown app_select2" style="width:100%" title="Select City Name">
					</select></td>
					<td><select id="hotel_name" name="hotel_name1" onchange="hotel_type_load(this.id);" style="width:100%" title="Select Hotel Name">
					<option value="">*Hotel Name</option>
					</select></td>
					<td><input type="text" id="hotel_type" name="hotel_type1" placeholder="*Hotel Type" title="Hotel Type" readonly></td>
					<td><input type="text" id="hotel_tota_days1" onchange="validate_balance(this.id)" name="hotel_tota_days1" placeholder="*Total Night" title="Total Night"></td></td>
                </tr>
				<?php
			}
			else{
				$offset = "_d";
				$count = 0;
				$sq_q_hotel = mysql_query("select * from group_tour_hotel_entries where tour_id='$tour_id'");
				while($row_q_hotel = mysql_fetch_assoc($sq_q_hotel)){
					$count++;
					
					?>
                    <tr>
                        <td><input class="css-checkbox" id="chk_dest<?= $offset.$count?>_d" type="checkbox" disabled checked><label class="css-label" for="chk_dest<?= $offset.$count?>_d"> <label></td>
                        <td><input maxlength="15" value="<?= $count ?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                        <td><select id="city_name<?= $offset.$count?>_d" name="city_name1" onchange="hotel_name_list_load(this.id);" class="city_master_dropdown app_select2" style="width:100%" title="Select City Name">
                        <?php $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_q_hotel[city_id]'")); ?>
                        <option value="<?php echo $row_q_hotel['city_id'] ?>"><?php echo $sq_city['city_name'] ?></option>
                        </select></td>
                        <td><select id="hotel_name<?= $offset.$count?>_d" name="hotel_name1<?= $offset.$count?>_d" onchange="hotel_type_load(this.id);" style="width:100%" title="Select Hotel Name">
                        <?php $sq_hotel = mysql_fetch_assoc(mysql_query("select hotel_name from hotel_master where hotel_id='$row_q_hotel[hotel_id]'")); ?>
                        <option value="<?php echo $row_q_hotel['hotel_id'] ?>"><?php echo $sq_hotel['hotel_name'] ?></option>
                        </select></td>
                        <td><input type="text" id="hotel_type<?= $offset.$count?>_d" name="hotel_type1<?= $offset.$count?>_d" placeholder="*Hotel Type" title="Hotel Type" value="<?php echo $row_q_hotel['hotel_type'] ?>" readonly></td>
                        <td><input type="text" id="hotel_tota_days1<?= $offset.$count?>_d" onchange="validate_balance(this.id)" name="hotel_tota_days1<?= $offset.$count?>_d" placeholder="*Total Night" title="Total Night" value="<?php echo $row_q_hotel['total_nights'] ?>" ></td></td>
                        <td><input type="hidden" id="hotel_entry_id" name="hotel_entry_id" value="<?php echo ($row_q_hotel['id']); ?>"></td>
                    </tr>
					
					<?php
				}
			}
			?>                                            
        </table>
        </div>
    </div>
</div> 
<script>
city_lzloading('select[name^="city_name"]');
</script>