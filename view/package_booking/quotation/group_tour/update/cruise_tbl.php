<div class="row">
    <div class="col-xs-12 text-right mg_bt_10_sm_xs">
        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_dynamic_cruise_quotation_update')"><i class="fa fa-plus"></i></button>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
        <table id="tbl_dynamic_cruise_quotation_update" name="tbl_dynamic_cruise_quotation_update" class="table mg_bt_0 table-bordered mg_bt_10">

        	<?php 
        	$sq_cruise_count = mysql_num_rows(mysql_query("select * from group_tour_quotation_cruise_entries where quotation_id='$quotation_id'"));
        	if($sq_cruise_count==0){
        		?>
				<tr>
	                <td><input class="css-checkbox" id="chk_tour_group" type="checkbox"><label class="css-label" for="chk_cruise1"><label></td>
	                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
		            <td><input type="text" id="cruise_departure_date" name="cruise_departure_date" placeholder="Departure Date and Time" title="Departure Date and Time" class="app_datetimepicker" value="<?= date('d-m-Y H:i:s') ?>" onchange="get_to_datetime(this.id,'cruise_arrival_date')"></td>
		            <td><input type="text" id="cruise_arrival_date" name="cruise_arrival_date" placeholder="Arrival Date and Time" title="Arrival Date and Time" class="app_datetimepicker" value="<?= date('d-m-Y H:i:s') ?>"></td>
		            <td><input type="text" id="route" name="route" onchange="validate_spaces(this.id);" placeholder="Route" title="Route"></td>
		            <td><input type="text" id="cabin" name="cabin" onchange="validate_spaces(this.id);" placeholder="Cabin" title="Cabin"></td>
		            <td><select id="sharing" name="sharing" style="width:100%;" title="Sharing">
		            		<option value="">Sharing</option>
		            		<option value="Single">Single</option>
		            		<option value="Double">Double</option>
		            		<option value="Triple Quad">Triple Quad</option>
		                </select></td>		               
		        <script>
	            	$('#cruise_departure_date, #cruise_arrival_date').datetimepicker({format:'d-m-Y H:i:s' });
	            </script>
	            </tr>           
        		<?php
        	}
        	else{
        		$count = 0;
        		$sq_q_cruise = mysql_query("select * from group_tour_quotation_cruise_entries where quotation_id='$quotation_id'");
        		while($row_q_cruise = mysql_fetch_assoc($sq_q_cruise))
        		{
        			$count++;
        			?>
					<tr>
		                <td><input class="css-checkbox" id="chk_tour_group<?= $count ?>_1" type="checkbox" checked disabled><label class="css-label" for="chk_tour_group<?= $count ?>_1"> <label></td>
		                <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>		              
			            <td><input type="text" id="cruise_departure_date<?= $count ?>_u" name="cruise_departure_date<?= $count ?>_u" placeholder="Departure Date and Time" title="Departure Date and Time" class="app_datetimepicker" value="<?= get_datetime_user($row_q_cruise['dept_datetime']) ?>" onchange="get_to_datetime(this.id,'cruise_arrival_date<?= $count ?>_u')"></td>
			            <td><input type="text" id="cruise_arrival_date<?= $count ?>_u" name="cruise_arrival_date<?= $count ?>_u" placeholder="Arrival Date and Time" title="Arrival Date and Time" class="app_datetimepicker" value="<?= get_datetime_user($row_q_cruise['arrival_datetime']) ?>"></td>
			            <td><input type="text" id="route<?= $count ?>_u" onchange="validate_spaces(this.id);" name="route<?= $count ?>_u" placeholder="Route" title="Route" value="<?= $row_q_cruise['route'] ?>"></td>
			            <td><input type="text" id="cabin<?= $count ?>_u" onchange="validate_spaces(this.id);" name="cabin<?= $count ?>_u" placeholder="Cabin" title="Cabin" value="<?= $row_q_cruise['cabin'] ?>"></td>
			            <td><select id="sharing<?= $count ?>_u" name="sharing<?= $count ?>_u" style="width:100%;" title="Sharing">
				<?php if($row_q_cruise['sharing']!='') { ?><option value="<?= $row_q_cruise['sharing'] ?>"><?= $row_q_cruise['sharing'] ?></option><?php }?>
			            		<option value="">Sharing</option>
			            		<option value="Single">Single</option>
			            		<option value="Double">Double</option>
			            		<option value="Triple Quad">Triple Quad</option>
			                </select></td>
			            <td class="hidden"><input type="text" value="<?= $row_q_cruise['id'] ?>"></td>
		            </tr>          
		            <script>
		            	$('#cruise_arrival_date<?= $count ?>_u, #cruise_departure_date<?= $count ?>_u').datetimepicker({ format:'d-m-Y H:i:s' });
		            </script>
        			<?php
        		}
        	}
        	?>                                  
        </table>
        </div>
    </div>
</div> 