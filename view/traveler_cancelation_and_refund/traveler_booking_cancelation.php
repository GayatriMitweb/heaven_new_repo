<?php

include "../../model/model.php";

require_once('../../classes/tour_booked_seats.php');


$tourwise_id = $_POST['cmb_tourwise_traveler_id'];


$sq_tourwise = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id = '$tourwise_id'"));

$traveler_group_id = $sq_tourwise['traveler_group_id'];

$cancel_count = mysql_num_rows(mysql_query("select * from travelers_details where traveler_group_id='$traveler_group_id' and status='Cancel'"));

$sq_total_tour_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from payment_master where tourwise_traveler_id='$tourwise_id' and payment_for='tour' "));

$sq_total_travel_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from payment_master where tourwise_traveler_id='$tourwise_id'  "));

?>

<!-- //begin_panel('Group Booking Cancellation',66); -->

                            

<input type="hidden" id="txt_tourwise_id" name="txt_tourwise_id" value="<?php echo $tourwise_id ?>">

<div class="row">

    <div class="col-md-4">


    </div>

</div>


<div class="panel panel-default panel-body mg_bt_0 mg_tp_20">


<div class="row">
	<div class="col-md-10 col-md-offset-1 mg_bt_10 col-xs-12">
		<input type="checkbox" id="check_all" name="check_all" onClick="select_all_check(this.id,'traveler_names')">&nbsp;&nbsp;&nbsp;<label for="check_all"><span style="text-transform: initial;">Check All</span></label>
	</div>
</div>


    <div class="row col-md-10 col-md-offset-1 mg_bt_10 col-xs-12">

        <div class="table-responsive">

        <h3 class="editor_title">Cancel Booking</h3>
        <table class="table table-bordered table-hover no-marg" id="tbl_traveler_cancel">

            <thead>

                <tr class="cancelation-table-title table-heading-row">

                    <th>S_No.</th>

                    <th>First_Name</th>

                    <th>Last_Name</th>

                    <th>Mobile</th>

                    <th>Cancel_Guest</th>

                </tr>    

            <thead> 

            <tbody>

                <?php

                $sq_travler_personal_info = mysql_fetch_assoc(mysql_query("select * from traveler_personal_info where tourwise_traveler_id='$tourwise_id'"));
                 $sq_travler_personal_info_count = mysql_num_rows(mysql_query("select * from travelers_details where traveler_group_id='$traveler_group_id'"));


                 $counter = 1;
                 $disabled_count= 0;
                 $sq = mysql_query("select * from travelers_details where traveler_group_id='$traveler_group_id'");

                 while($row = mysql_fetch_assoc($sq))

                 {

                    if($row['status']=="Cancel")

                    {

                       $status = "disabled"; 

                    }    

                    else

                    {

                        $status = "";

                    }    
                ?>
                    
                    <tr <?php
                    if($status=="disabled"){
                        $color = "danger";
                        $disabled_count++; 
                        $checked = "checked" ;
                    }
                    else{
                        $color = "";
                        $checked = "";
                    }
                    
                    echo "class=".$color;?>>

                        <td><?php echo $counter ?></td>

                        <td style="text-align:left;"><?php echo $row['first_name'] ?></td>

                        <td style="text-align:left;"><?php echo $row['last_name'] ?></td>

                        <td><?php echo $sq_travler_personal_info['mobile_no'] ?></td>

                        <td><input type="checkbox" class="traveler_names" value="<?php echo $row['traveler_id'] ?>" id="<?php echo "chk_traveler_member_id".$counter ?>" <?= $checked ?> name="chk_traveler_member_id" <?php echo $status ?>> <label for="<?php echo "chk_traveler_member_id".$counter ?>" class="css-label"></label></td>

                    </tr>

                <?php  

                    $counter++; 

                 }   

                ?>             

            </tbody>

        </table>

        </div>

    </div>

    <div class="row col-md-12 col-xs-12 text-center">
        <input type="hidden" id="pass_count" name="pass_count" value="<?= $sq_travler_personal_info_count ?>">
        <input type="hidden" id="disabled_count" name="disabled_count" value="<?= $disabled_count ?>">
        <button class="btn btn-danger btn-sm ico_left" id="btn_cancel_booking" onclick="cancel_traveler_booking()"><i class="fa fa-ban"></i>&nbsp;&nbsp;CANCEL BOOKING(S)</button>
        <div class="note mg_tp_10"><span style="color: red;line-height: 35px;" data-original-title="" title=""><?= $cancel_feild_note ?></span></div>
    </div>

</div>
<div id="div_cancel_group"></div>
<script src="js/cancel_booking.js"></script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script>
if(<?= $cancel_count ?> > 0){
    content_reflect();
}
</script>
