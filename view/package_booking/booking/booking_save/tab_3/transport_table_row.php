<div class="row" style="margin-top: 5px"> <div class="col-md-12 text-right">
    <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_transport_infomration');destinationLoading('select[name^=pickup_from]', 'Pickup Location');
        destinationLoading('select[name^=drop_to]', 'Drop-off Location');"><i class="fa fa-plus"></i></button>
    <button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('tbl_package_transport_infomration')"><i class="fa fa-trash"></i></button>
</div> </div>
<div class="row main_block">
    <div class="col-xs-12"> 
        <div class="table-responsive">
            <table id="tbl_package_transport_infomration" class="table table-bordered table-hover table-striped" style="width: 100%;">
                <tr>
                    <td><input id="check-btn-tr-acm-1" type="checkbox" ></td>
                    <td><input maxlength="15" type="text" name="username"  value="1" placeholder="Sr. No." disabled/></td>
                    <td><select name="vehicle_name1" id="vehicle_name1" title="Vehicle Name" style="width:250px">
                        <option value="">Select Vehicle</option>
                            <?php
                            $sq_transport_buses = mysql_query("select * from b2b_transfer_master order by vehicle_name asc");
                            while($row_transport_bus = mysql_fetch_assoc($sq_transport_buses)){
                            ?>
                            <option value="<?= $row_transport_bus['entry_id'] ?>"><?= $row_transport_bus['vehicle_name'] ?></option>
                            <?php } ?>
                        </select></td>
                    <td><input type="text" id="txt_tsp_from_date" name="txt_tsp_from_date" placeholder="Start Date" title="Start Date" style="width:170px;" ></td>
                    <td><select name="pickup_from" id="pickup_from" data-toggle="tooltip" style="width:250px;" title="Pickup Location" class="form-control app_select2">
                    </select></td>
                    <td><select name="drop_to" id="drop_to" style="width:250px;" data-toggle="tooltip" title="Drop-off Location" class="form-control app_select2">
                        </select></td>
                    <td><input type="text" id="no_vehicles" name="no_vehicles" placeholder="No.Of vehicles" title="No.Of vehicles" style="width:150px"></td>
                </tr>
        </table>
        </div>
    </div>
</div>