<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
        <table id="tbl_package_hotel_master" name="tbl_package_hotel_master" class="table mg_bt_0 table-bordered mg_bt_10">

        	<?php 
        	$sq_hotel_count = mysql_num_rows(mysql_query("select * from group_tour_hotel_entries where tour_id='$sq_quotation[tour_group_id]'"));
        	if($sq_hotel_count==0){
        		?>
				<tr>
					<td><input class="css-checkbox" id="chk_dest1" type="checkbox" disabled checked><label class="css-label" for="chk_dest1" checked> <label></td>
					<td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled />
					</td>
					<td><input id="city_name" name="city_name1" class="form-control" style="width:100%" title="City Name" readonly> 
					</td>
					<td><input id="hotel_name" name="hotel_name1" style="width:100%" title="Hotel Name" class="form-control" readonly>
					</td>
					<td><input type="text" id="hotel_type" name="hotel_type1" placeholder="*Hotel Type" class="form-control" title="Hotel Type" readonly></td>
					<td><input type="text" id="hotel_tota_days1"  name="hotel_tota_days1" placeholder="*Total Night" class="form-control" title="Total Night" readonly></td></td>
                </tr>           
        		<?php
        	}
        	else{
        		$count = 0;
        		$sq_q_hotel = mysql_query("select * from group_tour_hotel_entries where tour_id='$sq_quotation[tour_group_id]'");
        		while($row_q_hotel = mysql_fetch_assoc($sq_q_hotel))
        		{
        			$city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id = ".$row_q_hotel['city_id']));
                    $hotel = mysql_fetch_assoc(mysql_query("select hotel_name from hotel_master where hotel_id = ".$row_q_hotel['hotel_id']));
        			$count++;
        			?>
					<tr>
						<td><input class="css-checkbox" id="chk_dest1<?= $count ?>" type="checkbox" disabled checked><label      class="css-label" for="chk_dest1" checked> <label></td>
						<td><input maxlength="15" value="<?= $count ?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled />
						</td>
						<td><input id="city_name<?= $count ?>" name="city_name1" class="form-control" style="width:100%" title="City Name" value="<?= $city['city_name']?>" readonly> 
						</td>
						<td><input id="hotel_name<?= $count ?>" name="hotel_name1" style="width:100%" title="Hotel Name" class="form-control" value="<?= $hotel['hotel_name']?>" readonly>
						</td>
						<td><input type="text" id="hotel_type<?= $count ?>" name="hotel_type1" placeholder="*Hotel Type" class="form-control" title="Hotel Type" value="<?= $row_q_hotel['hotel_type']?>" readonly></td>
						<td><input type="text" id="hotel_tota_days1<?= $count ?>"  name="hotel_tota_days1" placeholder="*Total Night" class="form-control" title="Total Night" value="<?= $row_q_hotel['total_nights']?>" readonly></td></td>
                	</tr>          
        			<?php
        		}
        	}
        	?>                                  
        </table>
        </div>
    </div>
</div> 



         