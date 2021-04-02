<?php
include "../../model/model.php";
$dest_id = $_POST['dest_id'];
$sq_itinerary_c = mysql_num_rows(mysql_query("select * from itinerary_master where dest_id='$dest_id'"));
if($sq_itinerary_c >0){
?>
    <div class="col-md-12 col-sm-6 col-xs-12 mg_bt_10">
    <table style="width:100%" id="default_program_list" name="default_program_list" class="table mg_bt_0 table-bordered">
        <tbody>
        <?php
        $count = 0;
        $sq_itinerary = mysql_query("select * from itinerary_master where dest_id='$dest_id'");
        while($row_itinerary = mysql_fetch_assoc($sq_itinerary)){
            $count++;
            ?>
            <tr>
            <td width="27px;" style="padding-right: 10px !important;"><input class="css-checkbox labelauty" id="chk_programd<?=$count?>" type="checkbox" style="display: none;"><label for="chk_programd1<?=$count?>"><span class="labelauty-unchecked-image"></span><span class="labelauty-checked-image"></span></label></td>
            <td width="20px;"><input maxlength="15" value="<?=$count?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled=""></td>
            <td class="col-md-3 no-pad" style="padding-left: 5px !important;"><input type="text" id="special_attaraction" onchange="validate_spaces(this.id);validate_spattration(this.id);" name="special_attaraction" class="form-control" placeholder="*Special Attraction" title="Special Attraction" value="<?=$row_itinerary['special_attraction']?>"></td>
            <td class="col-md-5 no-pad" style="padding-left: 5px !important;"><textarea id="day_program" name="day_program" class="form-control" title="" rows="3" placeholder="*Day-wise Program" onchange="validate_spaces(this.id);validate_dayprogram(this.id);" title="Day-wise Program"><?=$row_itinerary['daywise_program']?></textarea></td>
            <td class="col-md-2 no-pad" style="padding-left: 5px !important;"><input type="text" id="overnight_stay" name="overnight_stay" onchange="validate_spaces(this.id);validate_onstay(this.id);" class="form-control" placeholder="*Overnight Stay" title="Overnight Stay" value="<?=$row_itinerary['overnight_stay']?>"></td>
            <td class="hidden"><input type="text" id="entry_id" name="entry_id" class="form-control" value="<?=$row_itinerary['entry_id']?>"></td>
            </tr>
            <?php
        } ?>
        </tbody>
    </table>
<?php }
else{
    if($dest_id != '' || $dest_id != 0){ ?>
    <div class="col-md-12 col-sm-6 col-xs-12 mg_tp_10">
    <?php echo '<h4 class="no-pad">Itinerary not added for this destination! <a href="'.BASE_URL.'view/other_masters/index.php" target="_blank" title="Add Itinerary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Itinerary</a></h4> '; ?>
    </div>
<?php } ?>
<div class="col-md-12 col-sm-6 col-xs-12 mg_tp_10"></div>
<?php }?>
<input type="hidden" id="sq_itinerary_c1" value="<?=$sq_itinerary_c?>"/>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>