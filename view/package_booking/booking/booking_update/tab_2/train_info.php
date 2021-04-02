<div class="row mg_bt_10">
    <div class="col-xs-12 text-right">
        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_train_travel_details_dynamic_row')" title="Add row"><i class="fa fa-plus"></i></button>
        <!-- Code to upload button -->
        <div class="div-upload" id="div_upload_button">
            <div id="package_train_upload" class="upload-button"><span>Ticket</span></div><span id="package_train_status" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="txt_train_upload_dir" name="txt_train_upload_dir" value="<?= $sq_booking_info['train_upload_ticket'] ?>">
        </div>  
    </div>
</div>  

<div class="row mg_bt_30"> <div class="col-xs-12"> <div class="table-responsive">

    <table id="tbl_train_travel_details_dynamic_row" name="tbl_train_travel_details_dynamic_row" class="table table-bordered table-hover pd_bt_51 no-marg" style="width: 1400px;">
    <?php
        $count_t = 0;
        $sq_train_details = mysql_query("select * from package_train_master where booking_id='$booking_id'");
        while($row_train_details = mysql_fetch_assoc($sq_train_details))
        {                            
            $count_t++;
    ?>
        <tr>

            <td><input id="<?php echo 'check-btn-train-'.$count_t.'t' ?>" type="checkbox" onchange="calculate_train_expense('tbl_train_travel_details_dynamic_row',true)" checked disabled ></td>

            <td><input maxlength="15" type="text" id="tr_train_sr_no" name="tr_train_sr_no" placeholder="Sr.No." value="<?= $count_t ?>" disabled/></td>

            <td><input type="text" id="<?php echo 'txt_train_date'.$count_t.'t' ?>" name="<?php echo 'txt_train_date'.$count_t.'t' ?>" class="app_datetimepicker" onchange="validate_pastDate(this.id)" placeholder="Departure Date & Time" title="Departure Date & Time" value="<?php echo date("d-m-Y H:i:s", strtotime($row_train_details['date'])) ?>"/></td>

            <td><select id="txt_train_from_location<?= $count_t ?>t" onchange="validate_location('txt_train_from_location<?= $count_t ?>t' , 'txt_train_to_location<?= $count_t ?>t');" name="txt_train_from_location<?= $count_t ?>t" class="app_select2" style="width:120px">
                <option value="<?php echo $row_train_details['from_location'] ?>"><?php echo $row_train_details['from_location'] ?></option>
                <?php 
                    $sq_city = mysql_query("select city_name from city_master");
                    while($row_city = mysql_fetch_assoc($sq_city))
                    {
                     ?>
                        <option value="<?php echo $row_city['city_name']; ?>"><?php echo $row_city['city_name']; ?></option>
                     <?php   
                    }    
                ?>
            </select></td>
            <td><select id="txt_train_to_location<?= $count_t ?>t"  onchange="validate_location('txt_train_to_location<?= $count_t ?>t' , 'txt_train_from_location<?= $count_t ?>t');" name="txt_train_to_location<?= $count_t ?>t" class="app_select2" style="width:120px">
                <option value="<?php echo $row_train_details['to_location'] ?>"><?php echo $row_train_details['to_location'] ?></option>
                <?php 
                    $sq_city = mysql_query("select city_name from city_master");
                    while($row_city = mysql_fetch_assoc($sq_city))
                    {
                     ?>
                        <option value="<?php echo $row_city['city_name']; ?>"><?php echo $row_city['city_name']; ?></option>
                     <?php   
                    }    
                ?>
            </select></td>

            <td style="width: 130px;"><input type="text" onchange="validate_specialChar(this.id);" id="<?php echo 'txt_train_no'.$count_t.'t' ?>" name="<?php echo 'txt_train_no'.$count_t.'t' ?>" placeholder="Train Name & No" title="Train Name & No" value="<?php echo $row_train_details['train_no'] ?>"/></td>

            <td style="width: 30px;"><input type="text" id="<?php echo 'txt_train_total_seat'.$count_t.'t' ?>" name="<?php echo 'txt_train_total_seat'.$count_t.'t' ?>" placeholder="Total Seats" title="Total Seats" maxlength="2" onchange="validate_balance(this.id);" onchange="calculate_service_charge_seat(this.id);" value="<?php echo $row_train_details['seats'] ?>"/></td>

            <td style="width: 130px;"><input type="text" id="<?php echo 'txt_train_amount'.$count_t.'t' ?>" name="<?php echo 'txt_train_amount'.$count_t.'t' ?>" placeholder="Amount"  title="Amount" onchange="validate_balance(this.id);calculate_train_expense('tbl_train_travel_details_dynamic_row',true);" value="<?php echo $row_train_details['amount'] ?>" /></td>

            <td><select id="<?php echo 'cmb_train_class'.$count_t.'t' ?>" title="class" name="<?php echo 'cmb_train_class'.$count_t.'t' ?>"> 
                    <?php if($row_train_details['train_class']!=''){ ?>
                    <option  value="<?php echo $row_train_details['train_class'] ?>" selected><?php echo $row_train_details['train_class'] ?></option>
                     <?php get_train_class_dropdown();
                     } get_train_class_dropdown();
                      ?>
                </select>
            </td>

            <td style="width:108px"><select id="<?php echo 'cmb_train_priority'.$count_t.'t' ?>" title="priority" name="<?php echo 'cmb_train_priority'.$count_t.'t' ?>" onchange="calculate_service_charge(this.id);"> 
                <?php if($row_train_details['train_priority']!=''){ ?>
                    <option  value="<?php echo $row_train_details['train_priority'] ?>" selected><?php echo $row_train_details['train_priority'] ?></option>
                    <option value="general"> General </option>
                    <option value="tatkal"> Tatkal </option>
                    <option value="self"> Self </option>
                <?php }else{?>
                    <option value=""> Priority </option>
                    <option value="general"> General </option>
                    <option value="tatkal"> Tatkal </option>
                    <option value="self"> Self </option>
                    <?php }?>
                </select>
            </td>

            <td><input type="hidden" value="<?php echo $row_train_details['train_id'] ?>"></td>

        </tr>

        <script>
        $('#txt_train_from_location<?= $count_t ?>t, #txt_train_to_location<?= $count_t ?>t').select2();
        </script>

    <?php
        }
    ?>
    </table>
    <input type = "hidden" id="txt_train_date_generate" value="<?php echo $count_t ?>">
</div>  </div> </div>   
<!-- check businessrule after removing hidden from below -->
    <div class="row hidden">
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Subtotal</label>
            <input type="text" id="txt_train_expense" name="txt_train_expense"  class="text-right" value="<?php echo $sq_booking_info['train_expense'] ?>" placeholder="Subtotal" title="Subtotal" disabled />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Service Charge</label>
            <input type="text" id="txt_train_service_charge" name="txt_train_service_charge"  class="text-right" value="<?php echo $sq_booking_info['train_service_charge'] ?>" placeholder="Service Charge" Title="Service Charge" onchange="validate_balance(this.id); calculate_total_train_expense()" />            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax</label>
            <select name="train_taxation_id" id="train_taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'train_service_tax', 'calculate_total_train_expense');">
                
            </select>
            <input type="hidden" id="train_service_tax" name="train_service_tax" value="<?= $sq_booking_info['train_service_tax'] ?>">            
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Tax Amount</label>
            <input type="text" id="train_service_tax_subtotal" name="train_service_tax_subtotal" value="<?= $sq_booking_info['train_service_tax_subtotal'] ?>" placeholder="Tax Amount" title="Tax Amount" disabled>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
            <label>Total</label>
            <input type="text" id="txt_train_total_expense" name="txt_train_total_expense" placeholder="Total Expense" title="Total Expense" class="text-right amount_feild_highlight" value="<?php echo $sq_booking_info['total_train_expense'] ?>" disabled />            
        </div>
    </div>

<script>
function generating_train_date()
{
    var count = $("#txt_train_date_generate").val();
    for(var i=0; i<=count; i++)
    {
        $( "#txt_train_date"+i+'t').datetimepicker({ format: "d-m-Y H:i:s"  });
    }             
}
generating_train_date();
</script>