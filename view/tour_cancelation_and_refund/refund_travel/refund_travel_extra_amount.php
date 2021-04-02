<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Refund Extra Travel Fee') ?>

<div class="panel panel-default panel-body mg_bt_10">
    
    <div class="row text-center">
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
            <select class="form-control" style="width:100%" id="cmb_tour_name" name="cmb_tour_name" onchange="tour_group_reflect(this.id);" title="Tour Name"> 
                <option value="">Tour Name</option>
                <?php
                    $sq=mysql_query("select tour_id,tour_name from tour_master");
                    while($row=mysql_fetch_assoc($sq))
                    {
                      echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                    }    
                ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
            <select class="form-control" id="cmb_tour_group" name="cmb_tour_group" onchange="traveler_group_reflect();" title="Tour Group"> 
                <option value="">Tour Date</option>        
            </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
           <select class="form-control" id="cmb_traveler_group_id" name="cmb_traveler_group_id" title="File No" style="width:100%"> 
                <option value="">File No</option>        
            </select>   
        </div>
        <div class="col-md-3 col-sm-6 text-left text_center_xs">
            <button class="btn btn-info ico_right" onclick="refund_travel_extra_amount_reflect()">Show Details&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
        </div>
    </div>

</div>

<div id="div_travel_payment_details"></div>               


<?= end_panel() ?>

<script>
    $('#cmb_traveler_group_id').select2();
</script>

<script src="../js/refund_travel.js"></script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>