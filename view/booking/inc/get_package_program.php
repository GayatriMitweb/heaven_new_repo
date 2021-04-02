<?php
include "../../../../model/model.php";
$package_id = $_POST['package_id'];
$count = 1;
$sq_package = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$package_id'"));
$sq_tours = mysql_query("select * from custom_package_program where package_id = '$package_id'");
?>
<h5 class="booking-section-heading main_block">Tour Itinerary Details</h5>
<div class="app_panel_content Filter-panel">
      <div class="row mg_bt_10">
        <div class="col-xs-12 text-right text_center_xs">
            <button type="button" class="btn btn-excel btn-sm" onClick="addRow('package_program_list')"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('package_program_list')"><i class="fa fa-trash"></i></button>
        </div>
      </div>
      <div class="row">
          <div class="col-md-12 col-sm-6 col-xs-12 mg_bt_10">
          <table style="width:100%" id="package_program_list" name="package_program_list" class="table mg_bt_0 table-bordered">
              <tbody>
              <?php while($row_tours = mysql_fetch_assoc($sq_tours)){?>
                <tr>
                <td width="27px;" style="padding-right: 10px !important;"><input class="css-checkbox mg_bt_10 labelauty" id="chk_program1" type="checkbox" checked style="display: none;"><label for="chk_program1"><span class="labelauty-unchecked-image"></span><span class="labelauty-checked-image"></span></label></td>
                <td width="50px;"><input maxlength="15" value="<?= $count?>" type="text" name="username" placeholder="Sr. No." class="form-control mg_bt_10" disabled=""></td>
                <td class="col-md-3 no-pad" style="padding-left: 5px !important;"><input type="text" id="special_attaraction<?= $count?>" onchange="validate_spaces(this.id);validate_spattration(this.id);" name="special_attaraction" class="form-control mg_bt_10" placeholder="Special Attraction" title="Special Attraction" value="<?= $row_tours['attraction']?>"></td>
                <td class="col-md-5 no-pad" style="padding-left: 5px !important;"><textarea id="day_program<?= $count?>" name="day_program" class="form-control mg_bt_10" title="" rows="3" placeholder="*Day-wise Program" onchange="validate_spaces(this.id);validate_dayprogram(this.id);" title="Day-wise Program"><?= $row_tours['day_wise_program']?></textarea></td>
                <td class="col-md-2 no-pad" style="padding-left: 5px !important;"><input type="text" id="overnight_stay<?= $count?>" name="overnight_stay" onchange="validate_spaces(this.id);validate_onstay(this.id);" class="form-control mg_bt_10" placeholder="Overnight Stay" title="Overnight Stay" value="<?= $row_tours['stay']?>"></td>
                <td class="col-md-2 no-pad" style="padding-left: 5px !important;"><select id="meal_plan<?= $count?>" title="" name="meal_plan" class="form-control mg_bt_10" data-original-title="Meal Plan">
                        |<?php if($row_tours['meal_plan'] !=''){ ?>
                          <option value="<?= $row_tours['meal_plan']?>"><?= $row_tours['meal_plan']?></option>
                        <?php } ?>
                        <?php get_mealplan_dropdown(); ?>
                        </select></td>
                </tr>
              <?php $count++; } ?>
              </tbody>
          </table>
          </div>
      </div>
      <div class="row mg_tp_20">
        <div class="col-md-6">
          <legend>Inclusions</legend>
          <textarea class="feature_editor" name="incl" id="incl" style="width:100% !important" rows="8"><?= $sq_package['inclusions']?></textarea>
        </div>
        <div class="col-md-6">
          <legend>Exclusions</legend>
          <textarea class="feature_editor" name="excl" id="excl" style="width:100% !important" rows="8"><?= $sq_package['exclusions']?></textarea>
        </div>
      </div>
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>