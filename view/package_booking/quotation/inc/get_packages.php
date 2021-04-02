<?php
include "../../../../model/model.php";
$dest_id = $_POST['dest_id'];
$count = 1;
$offset =1;
$sq_tours = mysql_query("select * from custom_package_master where dest_id = '$dest_id' and status!='Inactive'");
?>
<div class="col-md-12 app_accordion">
  <div class="panel-group main_block" id="accordion" role="tablist" aria-multiselectable="true">
      <?php 
      $table_count =0;
      while($row_tours = mysql_fetch_assoc($sq_tours)){
       ?>
       <div class="package_selector">
          <input type="checkbox" value="<?php echo $row_tours['package_id']; ?>" id="<?php echo $row_tours['package_id']; ?>" name="custom_package" />
       </div>
        <div class="accordion_content package_content mg_bt_10">
          <div class="panel panel-default main_block">
              <div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
                  <div class="Normal collapsed main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?= $count; ?>" aria-expanded="false" aria-controls="collapse_<?= $count; ?>" id="collapsed_<?= $count?>">                  
                    <div class="col-md-12"><span><em style="margin-left: 15px;"><?php echo $row_tours['package_name'] .' ('. $row_tours['total_days'].'D/'.$row_tours['total_nights'].'N )' ?></em></span></div>
                  </div>
              </div>
              <div id="collapse_<?= $count?>" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading_<?= $count?>">
                <div class="panel-body">
                  <div class="col-md-12 no-pad" id="div_list1">
                    <div class="row mg_bt_10">
                      <div class="col-xs-12 text-right text_center_xs">
                          <button type="button" class="btn btn-excel btn-sm" onClick="addRow('dynamic_table_list_p_<?= $row_tours['package_id'] ?>','<?= $row_tours['package_id'] ?>')"><i class="fa fa-plus"></i></button>
                          <button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('dynamic_table_list_p_<?= $row_tours['package_id'] ?>')"><i class="fa fa-trash"></i></button>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table style="width: 100%" id="dynamic_table_list_p_<?= $row_tours['package_id'] ?>" name="dynamic_table_list_p_<?= $row_tours['package_id'] ?>" class="table table-bordered table-hover table-striped no-marg pd_bt_51 mg_bt_0">
                      <legend>Tour Itinerary</legend>
                      <?php
                      $offset1 = 0; 
                      $sq_program = mysql_query("select * from custom_package_program where package_id='$row_tours[package_id]'");
                      while($row_program = mysql_fetch_assoc($sq_program)){
                      	$offset1 ++; 
                      ?>
                      <tr>
                          <td style="width: 50px;"><input class="css-checkbox mg_bt_10" id="chk_program<?= $offset ?>" type="checkbox" checked><label class="css-label" for="chk_program<?= $offset ?>"> <label></td>
                          <td style="width: 50px;" class="hidden"><input maxlength="15" value="<?= $offset1 ?>" type="text" name="username" placeholder="Sr. No." class="form-control mg_bt_10" disabled /></td>
                          <td style="width: 100px;"><input type="text" id="special_attaraction<?php echo $offset; ?>" onchange="validate_spaces(this.id);validate_spattration(this.id);" name="special_attaraction" class="form-control mg_bt_10" placeholder="Special Attraction" title="Special Attraction"  value="<?php echo $row_program['attraction']; ?>" style='width:220px'></td>
                          <td style="max-width: 594px;overflow: hidden;width:100px"><textarea id="day_program<?php echo $offset; ?>" name="day_program" class="form-control mg_bt_10" title="Day-wise Program" rows="3" placeholder="*Day-wise Program" onchange="validate_spaces(this.id);validate_dayprogram(this.id);" style='width:400px' value="<?php echo $row_program['day_wise_program']; ?>"><?php echo $row_program['day_wise_program']; ?></textarea></td>
                          <td style="width: 100px;"><input type="text" id="overnight_stay<?php echo $offset; ?>" name="overnight_stay" onchange="validate_spaces(this.id);validate_onstay(this.id);" class="form-control mg_bt_10" placeholder="Overnight Stay" title="Overnight Stay"  value="<?php echo $row_program['stay']; ?>" style='width:170px'></td>
                          <td><select id="meal_plan<?php echo $offset; ?>" title="Meal Plan" name="meal_plan" class="form-control mg_bt_10" style='width: 90px'>
                              <?php if($row_program['meal_plan']!=''){ ?><option value="<?php echo $row_program['meal_plan']; ?>"><?php echo $row_program['meal_plan']; ?></option>
                              <?php } ?>
                              <?php get_mealplan_dropdown(); ?>
                          </select></td>
                          <td class='col-md-1 pad_8'><button type="button" class="btn btn-info btn-iti btn-sm" title="Add Itinerary" onClick="add_itinerary('dest_name','special_attaraction<?php echo $offset; ?>','day_program<?php echo $offset; ?>','overnight_stay<?php echo $offset; ?>','Day-<?=$offset1?>')"><i class="fa fa-plus"></i></button>
                          </td>
                          <td style="width: 100px;"><input style="display:none" type="text" name="package_id_n" value="<?php echo $row_tours['package_id']; ?>"></td>
                        </tr>
                    <?php $offset++;
                    } ?>
                  </table>
                  </div>
                  <div class="row mg_tp_20">
                    <div class="col-md-6">
                      <legend>Inclusions</legend>
                    </div>
                    <div class="col-md-6">
                      <legend>Exclusions</legend>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table style="width:100%" class="no-marg" id="dynamic_table_incl<?= $row_tours['package_id'] ?>" name="dynamic_table_incl<?= $row_tours['package_id'] ?>">
                        <tr>
                          <td class="col-md-6"><textarea class="feature_editor" id="inclusions<?= $row_tours['package_id'] ?>" name="inclusions" placeholder="Inclusions" title="Inclusions" rows="4"><?php echo $row_tours['inclusions']; ?></textarea></td>
                          <td class="col-md-6"><textarea class="feature_editor" id="exclusions<?= $row_tours['package_id'] ?>" name="exclusions" placeholder="Exclusions" title="Exclusions" rows="4"><?php echo $row_tours['exclusions']; ?></textarea></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php 
        $count++; 
        $table_count++;
        $_SESSION['id'] = $row_tours['package_id'];
      } ?>
</div>
</div>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>