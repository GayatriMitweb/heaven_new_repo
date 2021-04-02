
<div class="row mg_bt_20">
    <div class="col-md-3">
        <label>Select Display Status</label>
        <select class="form-control" style="width:100%" name="display_status" id="display_status3" title="Display Status" data-toggle="tooltip">
            <?php if($col3[0]->display_status != ''){ ?>
            <option value="<?= $col3[0]->display_status ?>"><?= $col3[0]->display_status ?></option>
            <?php } ?>
            <?php if($col3[0]->display_status != 'Hide'){ ?>
                <option value="Hide">Hide</option>
            <?php } ?>
            <?php if($col3[0]->display_status != 'Show'){ ?>
                <option value="Show">Show</option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="row mg_bt_10"> <div class="col-md-8 no-pad">
    <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_dest_packages')" title="Add Row"><i class="fa fa-plus"></i></button>
    <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_dest_packages');" title="Delete Row"><i class="fa fa-trash"></i></button>
    <div class="col-md-10 mg_tp_10"><label class="alert-danger">For saving hotels keep checkbox selected!</label></div>
</div> </div>

<div class="row"> <div class="col-md-8"> <div class="table-responsive">
<table id="tbl_dest_packages" name="tbl_dest_packages" class="table border_0 table-hover no-marg">
    <?php
    if(sizeof($col3)==0){?>
        <tr>
            <td><input id="chk_dest1" type="checkbox" checked></td>
            <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select name="dest_name-1" id="dest_name-1" onchange="package_dynamic_reflect(this.id)" style="width:100%" class="app_select2">
                <option value="">*Select Destination</option>
                <?php
                    $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
                    while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
                    <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
                    <?php } ?>
            </select></td>
            <td><select id="package-1" name="package-1" title="Select Package" class="form-control" style="width:100%">
                    <option value="">*Select Package</option>
                </select></td>
        </tr>
        <script>
        $('#dest_name-1').select2();
        </script>
    <?php
    }else{
        for($i=0;$i<sizeof($col3[0]->tours);$i++){
            $dest_id=$col3[0]->tours[$i]->dest_id;
            $sq_dest = mysql_fetch_assoc(mysql_query("select dest_id,dest_name from destination_master where dest_id='$dest_id'"));
            $package_id=$col3[0]->tours[$i]->package_id;
            $sq_package = mysql_fetch_assoc(mysql_query("select package_id,package_name from custom_package_master where package_id='$package_id'"));
        ?>
        <tr>
            <td><input id="chk_dest1<?=$i?>_u" type="checkbox" checked></td>
            <td><input maxlength="15" value="<?=($i+1)?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select name="dest_name-1<?=$i?>_u" id="dest_name-1<?=$i?>_u" onchange="package_dynamic_reflect(this.id)" style="width:100%" class="app_select2">
                <?php if($dest_id!='0'){?>
                    <option value="<?= $sq_dest['dest_id'] ?>"><?= $sq_dest['dest_name'] ?></option>
                <?php } ?>
                <option value="">*Select Destination</option>
                <?php
                    $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
                    while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
                    <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
                    <?php } ?>
            </select></td>
            <td><select id="package-1<?=$i?>_u" name="package-1<?=$i?>_u" title="Select Package" class="form-control" style="width:100%">
                    <?php if($package_id!='0'){?>
                        <option value="<?= $sq_package['package_id'] ?>"><?= $sq_package['package_name'] ?></option>
                    <?php } ?>
                    <option value="">*Select Package</option>
                </select></td>
        </tr>
        <script>
        $('#dest_name-1<?=$i?>_u').select2();
        </script>
        <?php } } ?>
</table>
</div> </div> </div>