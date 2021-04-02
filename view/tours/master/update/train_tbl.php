<div class="row mg_bt_10">
    <div class="col-md-12 text-right text_center_xs">        
        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_group_tour_save_dynamic_train_update')"><i class="fa fa-plus"></i></button>
    </div>
</div>

<div class="row mg_bt_10">
    <div class="col-md-12">
        <div class="table-responsive">
        <table id="tbl_group_tour_save_dynamic_train_update" name="tbl_group_tour_save_dynamic_train_update" class="table table-bordered no-marg pd_bt_51">

        	<?php 
        	$sq_train_count = mysql_num_rows(mysql_query("select * from group_train_entries where tour_id='$tour_id'"));
        	if($sq_train_count==0){
        		?>
				<tr>
	                <td><input class="css-checkbox" id="chk_train1" type="checkbox"><label class="css-label" for="chk_train1"> <label></td>
	                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
	                <td class="col-md-4"><select id="train_from_location1" onchange="validate_location('train_from_location1','train_to_location1')" name="train_from_location1" class="app_select2 form-control"  style="width: 100% !important;">
			                <option value="">From</option>
			                <?php 
			                    $sq_city = mysql_query("select * from city_master");
			                    while($row_city = mysql_fetch_assoc($sq_city))
			                    {
			                     ?>
			                        <option value="<?php echo $row_city['city_name'] ?>"><?php echo $row_city['city_name'] ?></option>
			                     <?php   
			                    }    
			                ?>
			            </select>
	                </td>
	                 <td class="col-md-4"><select id="train_to_location1" onchange="validate_location('train_to_location1','train_from_location1')" name="train_to_location1" class="app_select2 form-control"  style="width: 100% !important;">
		                <option value="">To</option>
		                <?php 
		                    $sq_city = mysql_query("select * from city_master");
		                    while($row_city = mysql_fetch_assoc($sq_city))
		                    {
		                     ?>
		                        <option value="<?php echo $row_city['city_name'] ?>"><?php echo $row_city['city_name'] ?></option>
		                     <?php   
		                    }    
		                ?>
		            </select></td>
		            <td class="col-md-4"><select name="train_class" id="train_class1" title="Class">
				            	<option value="">Class</option>
				            	<?php get_train_class_dropdown(); ?>
		            </select></td>
	            </tr>      
        		<?php
        	}
        	else{
        		$count = 0;
        		$sq_q_train = mysql_query("select * from group_train_entries where tour_id='$tour_id'");
        		while($row_q_train = mysql_fetch_assoc($sq_q_train)){
        			$count++;
        			?>
					<tr>
		                <td><input class="css-checkbox" id="chk_train<?= $count ?>_1" type="checkbox" checked disabled><label class="css-label" for="chk_train<?= $count ?>_1"> <label></td>
		                <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
		                <td class="col-md-4"><select id="train_from_location<?= $count ?>_1" onchange="validate_location('train_from_location<?= $count ?>_1','train_to_location<?= $count ?>_1')"  class="app_select2 form-control" name="train_from_location" style="width: 100% !important;">
									<option value="<?= $row_q_train['from_location'] ?>"><?= $row_q_train['from_location'] ?></option>
				                	<?php
				                    $sq_city = mysql_query("select * from city_master");
				                    while($row_city = mysql_fetch_assoc($sq_city))
				                    {
				                     ?>
				                        <option value="<?php echo $row_city['city_name'] ?>"><?php echo $row_city['city_name'] ?></option>
				                     <?php   
				                    }    
				                ?>
				            </select>
		                </td>
		                 <td class="col-md-4"><select id="train_to_location<?= $count ?>_1" onchange="validate_location('train_to_location<?= $count ?>_1' , 'train_from_location<?= $count ?>_1')" class="app_select2 form-control" name="train_to_location" style="width: 100% !important;">
		                 	    <option value="<?= $row_q_train['to_location'] ?>"><?= $row_q_train['to_location'] ?></option>	
			                <?php 
			                    $sq_city = mysql_query("select * from city_master");
			                    while($row_city = mysql_fetch_assoc($sq_city))
			                    {
			                     ?>
			                        <option value="<?php echo $row_city['city_name'] ?>"><?php echo $row_city['city_name'] ?></option>
			                     <?php   
			                    }    
			                ?>
			            </select></td>
			            <td class="col-md-4"><select name="train_class" id="train_class1" title="Class">
			            	<option value="<?= $row_q_train['class'] ?>"><?= $row_q_train['class'] ?></option>
			            	<?php get_train_class_dropdown(); ?>
			            </select></td>
			            <td class="hidden"><input type="text" value="<?= $row_q_train['id'] ?>"></td>
		            </tr>          
        			<?php
        		}
        	}
        	?>
                                  
        </table>
        </div>
    </div>
</div> 