<?php
$sq_tab3 = mysql_query("select * from hotel_blackdated_tarrif where pricing_id='$pricing_id'");
$sq_count3 = mysql_num_rows(mysql_query("select * from hotel_blackdated_tarrif where pricing_id='$pricing_id'"));
?>
<form id="frm_tab3">
<input type="hidden" value='<?=$sq_count3 ?>' id="sq_count3" name="sq_count3" />
<div class="app_panel"> 
<!--=======Header panel======-->
    <div class="app_panel_head mg_bt_20">
      <div class="container">
          <h2 class="pull-left"></h2>
          <div class="pull-right header_btn">
            <button>
                <a title="Next">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </button>
          </div>
      </div>
    </div>
    <!--=======Header panel end======-->
    <div class="container">
    <h5 class="booking-section-heading main_block text-center">Black-Dated Rates</h5>
    <input type="hidden" value='<?=$sq_count3 ?>' id="tab3_count" name="tab3_count" />
		<?php if($sq_count3 == 0){ ?>
    <div class="row mg_bt_10">
      <div class="col-md-12 text-right text_center_xs">
        <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_hotel_tarrif3','3')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
        <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('table_hotel_tarrif3','3')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
      </div>
    </div>
		<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table id="table_hotel_tarrif3" name="table_hotel_tarrif" class="table table-bordered no-marg pd_bt_51" style="min-width:1500px">
					<tr>
        			<td><input class="css-checkbox" id="chk_ticket3" type="checkbox"><label class="css-label" for="chk_ticket3"> </label></td>
              <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" /></td>
              <td><select name="room_cat1" id="room_cat1" style="width:145px;" title="Room Category" class="form-control app_select2"><?php get_room_category_dropdown(); ?></select></td>
              <td><input type="text" id="m_occupancy" name="m_occupancy" placeholder="*Max Occupancy" title="Max Occupancy" onchange="validate_balance(this.id)" style="width: 130px;"/></td>           
              <td><input type="text" id="from_date1" class="form-control" name="from_date1" placeholder="Valid From" title="Valid From" value="<?= date('d-m-Y') ?>" onchange="get_to_date(this.id,'to_date1')" style="width: 120px;" /></td>
              <td><input type="text" id="to_date1" class="form-control" name="to_date1" placeholder="Valid To " title="Valid To" onchange="validate_issueDate('from_date1' ,'to_date1')" value="<?= date('d-m-Y') ?>" style="width: 120px;" /></td>
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
            $('#room_cat1').select2();
            </script>
				</table>
			</div>
		</div>
		</div>
		<?php }
		else{ ?>
		<div class="row mg_bt_10">
			<div class="col-md-12 text-right text_center_xs">
				<button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_hotel_tarrif_update')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
			</div>
		</div>
		<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
			<table id="table_hotel_tarrif_update" name="table_hotel_tarrif_update" class="table table-bordered no-marg pd_bt_51" style="min-width:1500px">
			<?php
				$count = 1;
				while($row_tab3 = mysql_fetch_assoc($sq_tab3)){ ?>
					<tr>
						    <td><input class="css-checkbox" id="chk_ticket1<?= $count ?>-u" type="checkbox" checked><label class="css-label" for="chk_ticket3"> </label></td>
                <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                <td><select name="room_cat1<?= $count ?>-u" id="room_cat1<?= $count ?>-u" style="width:145px;" title="Room Category" class="form-control app_select2">
            <option value='<?= $row_tab3['room_category']?>'><?= $row_tab3['room_category']?></option>
                        <?php get_room_category_dropdown(); ?>
                    </select></td>
                <td><input type="text" id="m_occupancy" name="m_occupancy" placeholder="*Max Occupancy" title="Max Occupancy" onchange="validate_balance(this.id)" style="width: 130px;" value='<?= $row_tab3['max_occupancy'] ?>'/></td>           
                <td><input type="text" id="from_date1<?= $count ?>-u" class="form-control" name="from_date1<?= $count ?>-u" placeholder="Valid From" title="Valid From" style="width: 120px;" value='<?= get_date_user($row_tab3['from_date']) ?>' onchange="get_to_date(this.id,'to_date1<?= $count ?>-u')" /></td>
                <td><input type="text" id="to_date1<?= $count ?>-u" class="form-control" name="to_date1<?= $count ?>-u" placeholder="Valid To " title="Valid To" onchange="validate_issueDate('from_date1<?= $count ?>-u' ,'to_date1<?= $count ?>-u')" value='<?= get_date_user($row_tab3['to_date']) ?>' style="width: 120px;" /></td>
                <td style='display:none;'><input type="text" id="single_bed" name="single_bed" placeholder="Single Bed" title="Single Bed" onchange="validate_balance(this.id)" /></td>
                <td><input type="text" id="double_bed" name="double_bed" placeholder="Room Cost" title="Room Cost"  onchange="validate_balance(this.id)" style="width: 120px;" value='<?= $row_tab3['double_bed'] ?>'/></td>
                <td style='display:none;'><input type="text" id="triple_bed" name="triple_bed" placeholder="Triple Bed" title="Triple Bed"  onchange="validate_balance(this.id)" /></td>
                <td><input type="text" id="cwbed" name="cwbed" placeholder="Child With Bed" title="Child With Bed"  onchange="validate_balance(this.id)" style="width: 120px;" value='<?= $row_tab3['child_with_bed'] ?>' /></td>
                <td><input type="text" id="cwobed" name="cwobed" placeholder="Child Without Bed" title="Child Without Bed"  onchange="validate_balance(this.id)" style="width: 137px;" value='<?= $row_tab3['child_without_bed'] ?>' /></td>
                <td style='display:none;'><input type="text" id="first_child" name="first_child" placeholder="First Child" title="First Child"  onchange="validate_balance(this.id)" /></td>
                <td style='display:none;'><input type="text" id="second_child" name="second_child" placeholder="Second Child" title="Second Child"  onchange="validate_balance(this.id)" /></td>
                <td><input type="text" id="with_bed" name="with_bed" placeholder="Extra Bed" title="Extra Bed"  onchange="validate_balance(this.id)" style="width: 120px;" value='<?= $row_tab3['extra_bed'] ?>' /></td>
                <td style='display:none;'><input type="text" id="queen" name="queen" placeholder="Queen Bed" title="Queen Bed"  onchange="validate_balance(this.id)" /></td>
                <td style='display:none;'><input type="text" id="king" name="king" placeholder="King Bed" title="King Bed"  onchange="validate_balance(this.id)" /></td>
                <td style='display:none;'><input type="text" id="quad_bed" name="quad_bed" placeholder="Quad Bed" title="Quad Bed"  onchange="validate_balance(this.id)" /></td>
                <td style='display:none;'><input type="text" id="twin" name="twin" placeholder="Twin Bed" title="Twin Bed"  onchange="validate_balance(this.id)"/></td>
                <td><input type="text" id="markup_per" name="markup_per" placeholder="Markup(%)" title="Markup(%)"  onchange="validate_balance(this.id)" style="width: 120px;" value='<?= $row_tab3['markup_per'] ?>' /></td>
                <td><input type="text" id="flat_markup" name="flat_markup" placeholder="Flat Markup" title="Flat Markup"  onchange="validate_balance(this.id)" style="width: 120px;" value='<?= $row_tab3['markup'] ?>' /></td>
                <td><select name="meal_plan" id="meal_plan" style="width: 110px" class="form-control app_select2" title="Meal Plan">
                <?php if($row_tab3['meal_plan'] != ''){?> <option value='<?= $row_tab3['meal_plan'] ?>'><?= $row_tab3['meal_plan']?></option><?php }?>
                <?php get_mealplan_dropdown(); ?></td>
                <td><input type="hidden" id="entry_id" name="entry_id" value='<?= $row_tab3['entry_id'] ?>' /></td>
            </tr>
						<script>
							$('#to_date1<?= $count ?>-u,#from_date1<?= $count ?>-u').datetimepicker({ timepicker:false, format:'d-m-Y' });
              $('#room_cat1<?= $count ?>-u').select2();
						</script>
			<?php $count++; } ?>
			</table>
			</div>
		</div>
		</div>
		<?php } ?>
		<div class="row text-center mg_tp_20 mg_bt_150">
			<div class="col-xs-12">
				<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp Previous</button>
				&nbsp;&nbsp;
				<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
			</div>
		</div>

</form>
<?= end_panel() ?>

<script>
$('#to_date1,#from_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });

function switch_to_tab2(){ 
	$('#tab2_head').removeClass('active');
	$('#tab1_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab1').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
 }

$('#frm_tab3').validate({
	rules:{

	},
	submitHandler:function(form){
  var base_url = $('#base_url').val();
  var sq_count3 = $('#sq_count3').val();
  var table_id = (sq_count3==0)?'table_hotel_tarrif3':'table_hotel_tarrif_update';
  var table = document.getElementById(table_id);
	var rowCount = table.rows.length;

    for(var i=0; i<rowCount; i++){
      var row = table.rows[i];           

      if(row.cells[0].childNodes[0].checked){
        var room_cat = row.cells[2].childNodes[0].value;
		var max_ooc = row.cells[3].childNodes[0].value;
		var from_date = row.cells[4].childNodes[0].value;
		var to_date = row.cells[5].childNodes[0].value;
        if(room_cat==''){
          error_msg_alert('Select Room Category in Row-'+(i+1));
          return false;
        }
		if(max_ooc==''){
			error_msg_alert('Enter Max occupancy in Row-'+(i+1));
			return false;
		}
        if(from_date==''){
          error_msg_alert('Select Valid From Date in Row-'+(i+1));
          return false;
        }
        if(to_date==''){
          error_msg_alert('Select Valid To Date in Row-'+(i+1));
          return false;
        }
      }
    }
	
	$('#tab2_head').addClass('done');
  $('#tab3_head').addClass('active');
  $('.bk_tab').removeClass('active');
  $('#tab3').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}
});
</script>