<div class="row" style="margin-top: 5px"> <div class="col-md-12 text-right">
    <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_exc_infomration')"><i class="fa fa-plus"></i></button>
    <button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('tbl_package_exc_infomration')"><i class="fa fa-trash"></i></button>
</div> </div>
<div class="row main_block">
    <div class="col-xs-12"> 
        <div class="table-responsive">
            <table id="tbl_package_exc_infomration" class="table table-bordered table-hover table-striped" style="width: 100%;">
                <tr>
                    <td><input id="check-btn-exc" type="checkbox" checked ></td>
                    <td><input maxlength="15" type="text" name="username"  value="1" placeholder="Sr. No." disabled/></td>
                    <td><select id="city_name-1" class="form-control" name="city_name-1" title="City Name" style="width:100%" onchange="get_excursion_list(this.id);">
                            <option value="">*City</option>
                            <?php 
                                $sq_city = mysql_query("select * from city_master order by city_name asc");
                                while($row_city = mysql_fetch_assoc($sq_city))
                                {
                                    ?>
                                    <option value="<?php echo $row_city['city_id'] ?>"><?php echo $row_city['city_name'] ?></option>
                                    <?php   
                                }    
                            ?>
                        </select>
                    </td>
                        <td><select id="excursion-1" class="form-control" title="Excursion Name" name="excursion-1" style="width:100%">
                        <option value="">*Excursion Name</option>
                    </select></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>