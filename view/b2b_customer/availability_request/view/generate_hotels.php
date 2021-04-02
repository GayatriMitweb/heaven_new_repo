<?php
include '../../../../model/model.php';
$count = $_POST['i'];
?>
<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
    <legend>Select Similar Hotel Options</legend>
    <div class="row text-right mg_bt_10">
        <div class="col-xs-12">
            <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_similar_hotels<?=$count?>',<?=$count?>);city_lzloading('select[name=city_id1]')" title="Add row"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_similar_hotels<?=$count?>',<?=$count?>)" title="Delete row"><i class="fa fa-trash"></i></button>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
            <table id="tbl_similar_hotels<?=$count?>" class="table table-bordered pd_bt_51">
                <tr>
                    <td style="width:5%"><input class="css-checkbox" id="chk_hh1<?=$count?>" type="checkbox" checked><label class="css-label" for="chk_hh1<?=$count?>"> <label></td>
                    <td style="width:10%"><input maxlength="15" class="form-control text-center" type="text" name="username"  value="1" placeholder="Sr. No." disabled/></td>
                    <td><select id="city_id1<?=$count?>" name="city_id1" title="Select City" onchange="hotel_name_list_load(this.id)" class="form-control app_minselect2" style="width:100%">
                        </select>
                    </td>    
                    <td><select id="hotel_id1<?=$count?>" name="hotel_id1" title="Select Hotel" class="form-control app_select2" style="width:100%">
                            <option value="">*Select Hotel</option>
                        </select>
                    </td>
                </tr>
            </table>
            </div>
        </div>
    </div>
</div>
<script>
city_lzloading('select[name="city_id1"]');
$('#hotel_id1<?=$count?>').select2();
</script>