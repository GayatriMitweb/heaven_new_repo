<form id="frm_tab2_u">
<div class="app_panel"> 
<!--=======Header panel======-->
    <div class="app_panel_head mg_bt_20">
      <div class="container">
          <h2 class="pull-left"></h2>
          <div class="pull-right header_btn">
            <button>
                <a>
                    <i class="fa fa-arrow-right"></i>
                </a>
            </button>
          </div>
      </div>
    </div> 
<!--=======Header panel end======-->

    <div class="container">

	<div class="row">
		<div class="col-md-3 col-sm-4 col-xs-12">
		<?php $sq_pacakge = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id='$sq_quotation[package_id]'")) ?>
			<input type="text" value="<?= $sq_pacakge['package_name'] ?>" readonly>
			<input type="hidden" value="<?= $sq_pacakge['dest_id'] ?>" id='dest_name'>
			<input type="hidden" value="<?= $package_id ?>" id='img_package_id'>
			<input type='hidden' id='pckg_daywise_url' name='pckg_daywise_url'/>
   		</div>	
   	</div>
	<div class="row">
   		<div class="col-md-12 col-sm-8 col-xs-12 no-pad">
			<div class="col-md-12 app_accordion">
			    <div class="panel-group main_block" id="accordion" role="tablist" aria-multiselectable="true">
	                <div class="panel-body">
	                    <div class="col-md-12 no-pad" id="div_list1">
	                    <div class="row mg_bt_10">
	                      <div class="col-xs-12 text-right text_center_xs">
	                          <button type="button" class="btn btn-excel btn-sm" onClick="addRow('dynamic_table_list_update')"><i class="fa fa-plus"></i></button>
	                      </div>
	                    </div>  
                    	<div class="table-responsive">
	                    <table style="width:100%" id="dynamic_table_list_update" name="dynamic_table_list_update" class="table table-bordered table-hover table-striped no-marg pd_bt_51 mg_bt_0">
	                    	<h3 class="editor_title">Tour Itinerary</h3>
	                        <?php
		                      $offset = 0; 
		                      $sq_program = mysql_query("select * from package_quotation_program where quotation_id = '$quotation_id'");
		                      while($row_program = mysql_fetch_assoc($sq_program)){
		                      	$offset ++; 
		                      ?>
		                        <tr>
			                          <td style="width: 50px;"><input class="css-checkbox mg_bt_10" id="chk_program<?= $offset ?>" type="checkbox" checked ><label class="css-label" for="chk_program<?= $offset ?>"> </label></td>
			                          <td style="width: 50px;" class="hidden"><input maxlength="15" value="<?= $offset ?>" type="text" name="username" placeholder="Sr. No." class="form-control mg_bt_10" disabled /></td>
			                          <td style="width: 100px;"><input type="text" id="special_attaraction<?php echo $offset; ?>-u" onchange="validate_spaces(this.id);validate_spattration(this.id);" name="special_attaraction" class="form-control mg_bt_10" placeholder="Special Attraction" title="Special Attraction" style='width:220px' value="<?php echo $row_program['attraction']; ?>"></td>
			                          <td style="width: 100px;max-width: 594px;overflow: hidden;"><textarea id="day_program<?php echo $offset; ?>-u" name="day_program" class="form-control mg_bt_10" title="Day-wise Program" rows="3" placeholder="*Day-wise Program" onchange="validate_spaces(this.id);validate_dayprogram(this.id);" style='width:400px' value="<?php echo $row_program['day_wise_program']; ?>"><?php echo $row_program['day_wise_program']; ?></textarea></td>
			                          <td class='col-md-2 no-pad' style='width:100px'><input type="text" id="overnight_stay<?php echo $offset; ?>-u" name="overnight_stay" onchange="validate_spaces(this.id);validate_onstay(this.id);" class="form-control mg_bt_10" placeholder="Overnight Stay" title="Overnight Stay"  value="<?php echo $row_program['stay']; ?>" style='width:170px'></td>
			                          <td><select id="meal_plan<?php echo $offset; ?>" title="Meal Plan" name="meal_plan" class="form-control mg_bt_10" style='width: 90px'>
			                                  <option value="<?php echo $row_program['meal_plan']; ?>"><?php echo $row_program['meal_plan']; ?></option>
			                                  <?php get_mealplan_dropdown(); ?>
			                                     </select></td>
												 
									   <td class='col-md-1 pad_8'><button type="button" class="btn btn-info btn-iti btn-sm" title="Add Itinerary" onClick="add_itinerary('dest_name','special_attaraction<?php echo $offset; ?>-u','day_program<?php echo $offset; ?>-u','overnight_stay<?php echo $offset; ?>-u','Day-<?=$offset?>')"><i class="fa fa-plus"></i></button>
                          			  </td>
			                          <td style="width: 100px;"><input type="hidden" name="package_id_n" value="<?php echo $row_program['id']; ?>"></td>
			                    </tr>
						      <?php } ?>
							</table>
							</div>  
							<div class="row mg_tp_20">
								<div class="col-md-6">
								  <h3 class="editor_title">Inclusions</h3>
								  <textarea style="form-control" class="feature_editor" id="inclusions1" name="inclusions1" placeholder="Inclusions" title="Inclusions" rows="4"><?php echo $sq_quotation['inclusions']; ?></textarea>
								</div>
								<div class="col-md-6">
								  <h3 class="editor_title">Exclusions</h3>
								  <textarea style="form-control" class="feature_editor" id="exclusions1" name="exclusions1" placeholder="Exclusions" title="Exclusions" rows="4"><?php echo $sq_quotation['exclusions']; ?></textarea>
								</div>                
							</div>                    
		                </div>    
		            	</div>
		    	</div>
        	</div>
    	</div>
	</div>
	<div class="row text-center mg_tp_20">
		<div class="col-xs-12">
			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp Previous</button>
			&nbsp;&nbsp;
			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</form>
<?= end_panel(); ?>
<script>
function switch_to_tab1(){
	
	$('#tab2_head').removeClass('active');
	$('#tab1_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab1').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200); }

$('#frm_tab2_u').validate({

	rules:{		
	},

	submitHandler:function(form){
		var base_url = $('#base_url').val();
		var checked_programe_arr = new Array();
		var attraction_arr = new Array();
		var program_arr = new Array();
		var stay_arr = new Array();
		var meal_plan_arr = new Array();
		var package_p_id_arr = new Array();
		var day_count_arr = new Array();
		var count = 0;

		var table = document.getElementById("dynamic_table_list_update");
		var rowCount = table.rows.length;	
		for(var i=0; i<rowCount; i++){
			var row = table.rows[i];
			var checked_programe = row.cells[0].childNodes[0].checked;
			var attraction = row.cells[2].childNodes[0].value;
			var program = row.cells[3].childNodes[0].value;
			var stay = row.cells[4].childNodes[0].value;         
			var meal_plan = row.cells[5].childNodes[0].value;  
			var package_id1 = row.cells[7].childNodes[0].value;
			if(checked_programe){
				count++;
				if(program==""){
					error_msg_alert('Daywise program is mandatory in row'+(i+1));
					return false;
				}

				var flag1 = validate_spattration(row.cells[2].childNodes[0].id);
				var flag2 = validate_dayprogram(row.cells[3].childNodes[0].id);
				var flag3 = validate_onstay(row.cells[4].childNodes[0].id);         
				if(!flag1 || !flag2 || !flag3){
					return false;
				}
			}
			
			checked_programe_arr.push(checked_programe);
			attraction_arr.push(attraction);
			program_arr.push(program);
			stay_arr.push(stay);
			meal_plan_arr.push(meal_plan);
			package_p_id_arr.push(package_id1);
		}
		day_count_arr.push(count);

		var dest_id = $('#dest_name').val();
		var package_id = $('#img_package_id').val();
		var package_id_arr = [package_id];

		$.ajax({
		type:'post',
		url: '../../inc/get_packages_days.php',
		data: { dest_id : dest_id,day_count_arr : day_count_arr,package_id_arr : package_id_arr},
			success: function(result){
				$('#daywise_image_select').html(result);
			},
			error:function(result){
				console.log(result.responseText);
			}
		});
		
		$('#tab2_head').addClass('done');
		$('#tab_daywise_head').addClass('active');
		$('.bk_tab').removeClass('active');
		$('#tab_daywise').addClass('active');
		$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
	}
});	
</script>