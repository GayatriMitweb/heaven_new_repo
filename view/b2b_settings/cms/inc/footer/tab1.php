
<div class="row mg_bt_20">
    <div class="col-md-3">
        <label>Select Display Status</label>
        <select class="form-control" style="width:100%" name="display_status" id="display_status1" title="Display Status" data-toggle="tooltip">
            <?php if($col1[0]->display_status != ''){ ?>
            <option value="<?= $col1[0]->display_status ?>"><?= $col1[0]->display_status ?></option>
            <?php } ?>
            <?php if($col1[0]->display_status != 'Hide'){ ?>
                <option value="Hide">Hide</option>
            <?php } ?>
            <?php if($col1[0]->display_status != 'Show'){ ?>
                <option value="Show">Show</option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="row mg_bt_10"> <div class="col-md-8 no-pad">
    <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_hotels');city_lzloading('.city_footer')" title="Add Row"><i class="fa fa-plus"></i></button>
    <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_hotels');" title="Delete Row"><i class="fa fa-trash"></i></button>
    <div class="col-md-10 mg_tp_10"><label class="alert-danger">For saving hotels keep checkbox selected!</label></div>
</div> </div>

<div class="row"> <div class="col-md-8"> <div class="table-responsive">
<table id="tbl_hotels" name="tbl_hotels" class="table border_0 table-hover no-marg">
    <?php
    if(sizeof($col1)==0){?>
        <tr>
            <td><input id="chk_city1" type="checkbox" checked></td>
            <td><input maxlength="15" value="<?=($i+1)?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select name="city_name-1" id="city_name-1" title="Select City" onchange="hotel_names_load(this.id)" style="width:100%" class="form-control app_select2 city_footer">
                </select>
            </select></td>
            <td><select id='hotel_name-1' name='hotel_name-1' class="form-control">
                <option value="">Hotel Name</option>
            </select></td>
        </tr>
    <?php
    }else{
        for($i=0;$i<sizeof($col1[0]->hotels);$i++){
            $city_id=$col1[0]->hotels[$i]->city_id;
            $sq_city = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$city_id'"));
            $hotel_id=$col1[0]->hotels[$i]->hotel_id;
            $sq_hotel = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$hotel_id'"));
        ?>
        <tr>
            <td><input id="chk_city1<?=$i?>_u" type="checkbox" checked></td>
            <td><input maxlength="15" value="<?=($i+1)?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select name="city_name-1<?=$i?>_u" id="city_name-1<?=$i?>_u" title="Select City" onchange="hotel_names_load(this.id)" style="width:100%" class="form-control app_select2 city_footer">
                    <?php if($city_id!=''){ ?>
                    <option value="<?= $sq_city['city_id'] ?>"><?= $sq_city['city_name'] ?></option>
                    <?php } ?>
                </select>
            </select></td>
            <td><select id='hotel_name-1<?=$i?>_u' name='hotel_name-1<?=$i?>_u' class="form-control">
                <?php if($hotel_id!=''){ ?>
                <option value="<?= $sq_hotel['hotel_id'] ?>"><?= $sq_hotel['hotel_name'] ?></option>
                <?php } ?>
                <option value="">Hotel Name</option>
            </select></td>
        </tr>
        <?php } } ?>
</table>
</div> </div> </div>
<script>
    city_lzloading('.city_footer');
</script>