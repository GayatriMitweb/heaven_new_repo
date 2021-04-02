<div class="row mg_bt_10">
    <div class="col-md-12 text-right text_center_xs">
        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_dynamic_cruise_update')"><i class="fa fa-plus"></i></button>
    </div>
</div>

<div class="row mg_bt_10">
    <div class="col-md-12">
        <div class="table-responsive">
        <table id="tbl_dynamic_cruise_update" name="tbl_dynamic_cruise_update" class="table table-bordered no-marg">

        	<?php 
        	$sq_cruise_count = mysql_num_rows(mysql_query("select * from group_cruise_entries where tour_id='$tour_id'"));
        	if($sq_cruise_count=='0'){
                $offset = "_u";
        		?>
				<tr>
		                <td><input class="css-checkbox" id="chk_cruise1" type="checkbox"><label class="css-label" for="chk_cruise1"><label></td>
		                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
			            <td class="col-md-6"><input type="text" id="route<?= $offset ?>" name="route<?= $offset ?>" placeholder="Route" onchange="validate_specialChar(this.id);" title="Route"></td>
			            <td class="col-md-6"><input type="text" id="cabin<?= $offset ?>" name="cabin<?= $offset ?>" placeholder="Cabin" onchange="validate_specialChar(this.id);" title="Cabin"></td>
		        </tr>     
        		<?php

        	}
        	else{
        		$count = 0;
        		$sq_q_cruise = mysql_query("select * from group_cruise_entries where tour_id='$tour_id'");
        		while($row_q_cruise = mysql_fetch_assoc($sq_q_cruise)){
        			$count++;
        			?>
					<tr>
		                <td><input class="css-checkbox" id="chk_cruise<?= $count ?>_1" type="checkbox" checked disabled><label class="css-label" for="chk_cruise1"><label></td>
		                <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
			            <td class="col-md-6"><input type="text" id="route<?= $count ?>_1" name="route<?= $count ?>_1" placeholder="Route" title="Route" onchange="validate_specialChar(this.id)" value="<?php echo ($row_q_cruise['route']); ?>"></td>
			            <td class="col-md-6"><input type="text" id="cabin<?= $count ?>_1" name="cabin<?= $count ?>_1" placeholder="Cabin" title="Cabin" onchange="validate_specialChar(this.id)" value="<?php echo ($row_q_cruise['cabin']); ?>"></td>
			            <td><input type="hidden" id="entry_id" name="entry_id" value="<?php echo ($row_q_cruise['id']); ?>"></td>
		            </tr>            
        			<?php
        		}
        	}
        	?>
                                  
        </table>
        </div>
    </div>
</div> 