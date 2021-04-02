<?php
include "../../../../model/model.php";
$dest_id = $_POST['dest_id'];
?>
<?php if($dest_id != 0){?>
<select id="package1" name="package1" title="Select Package" class="form-control" style="width:100%"  onchange="get_package_program(this.id);"> 

<option value="">Select Package</option>
 <?php 

$sq_tours = mysql_query("select * from custom_package_master where dest_id = '$dest_id' and status!='Inactive'");

    while($row_tours = mysql_fetch_assoc($sq_tours)){ ?>

      <option value="<?php echo $row_tours['package_id']; ?>"><?php echo  $row_tours['package_name']; ?></option>

  <?php } ?>

</select>
<script>
	$('#package1').select2();
</script>
<?php }
else{ ?>
<h5 class="booking-section-heading main_block">Tour Itinerary</h5>
<div class="app_panel_content Filter-panel">
      <div class="row mg_bt_10">
        <div class="col-xs-12 text-right text_center_xs">
            <button type="button" class="btn btn-excel btn-sm" onClick="addRow('package_program_list')"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('package_program_list')"><i class="fa fa-trash"></i></button>
        </div>
      </div>
      <div class="row">
          <div class="col-md-12 col-sm-6 col-xs-12 mg_bt_10">
          <table id="package_program_list" name="package_program_list" class="table mg_bt_0 table-bordered">
              <tbody><tr>
              <td><input class="css-checkbox mg_bt_10 labelauty" id="chk_program1" type="checkbox" checked style="display: none;"><label for="chk_program1"><span class="labelauty-unchecked-image"></span><span class="labelauty-checked-image"></span></label></td>
              <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled=""></td>
              <td class="col-md-3"><input type="text" id="special_attaraction" onchange="validate_spaces(this.id);validate_spattration(this.id);" name="special_attaraction" class="form-control mg_bt_10" placeholder="Special Attraction" title="Special Attraction"></td>
              <td class="col-md-5"><textarea id="day_program" name="day_program" class="form-control mg_bt_10" title="" rows="3" placeholder="*Day-wise Program" onchange="validate_spaces(this.id);validate_dayprogram(this.id);" title="Day-wise Program"></textarea></td>
              <td class="col-md-2"><input type="text" id="overnight_stay" name="overnight_stay" onchange="validate_spaces(this.id);validate_onstay(this.id);" class="form-control mg_bt_10" placeholder="Overnight Stay" title="Overnight Stay"></td>
              <td class="col-md-2"><select id="meal_plan" title="" name="meal_plan" class="form-control mg_bt_10" data-original-title="Meal Plan">
                      <?php get_mealplan_dropdown(); ?>
                      </select></td>
              <td class='col-md-1 pad_8'><button type="button" class="btn btn-info btn-iti btn-sm" title="Add Itinerary" onClick="add_itinerary('dest_name2','special_attaraction','day_program','overnight_stay','Day-1')"><i class="fa fa-plus"></i></button>
              </td>
              <td><input style="display:none" type="text" name="package_id_n" value="4" autocomplete="off" class="form-control" data-original-title="" title=""></td>
              </tr>
              </tbody>
          </table>
          </div>
      </div>
      <div class="row mg_tp_20">
        <div class="col-md-6">
          <legend>Inclusions</legend>
          <?php
            $sq_inc = mysql_query("select * from inclusions_exclusions_master where active_flag='Active' and for_value in('Package','Both') and type='Inclusion'");
          ?>
          <textarea class="feature_editor" name="incl" id="incl" style="width:100% !important" rows="8"><?php while($row_inc = mysql_fetch_assoc($sq_inc)){
          echo $row_inc['inclusion']."<br>";
          }?></textarea>
        </div>
        <div class="col-md-6">
          <legend>Exclusions</legend>
          <?php
            $sq_inc = mysql_query("select * from inclusions_exclusions_master where active_flag='Active' and for_value in('Package','Both') and type='Exclusion'");
          ?>
          <textarea class="feature_editor" name="excl" id="excl" style="width:100% !important" rows="8"><?php while($row_inc = mysql_fetch_assoc($sq_inc)){
          echo $row_inc['inclusion']."<br>";
          }?></textarea>
        </div>
      </div>
</div>
<?php } ?>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>