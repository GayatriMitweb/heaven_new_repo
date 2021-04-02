<?php
include "../../../../model/model.php";
?>

<div class="app_panel_content Filter-panel">
    <div class="row">
        <div class="col-md-4 col-sm-4 mg_bt_10_xs">
            <select style="width:100%;" class="form-control" id="cmb_tour_name" name="cmb_tour_name" onchange="cancelled_tour_groups_reflect(this.id);" title="Tour Name"> 
                <option value="">Tour Name </option>
                <?php
                    $sq=mysql_query("select tour_id,tour_name from tour_master order by tour_name");
                    while($row=mysql_fetch_assoc($sq))
                    {
                      echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                    }    
                ?>
            </select>
        </div>
        <div class="col-md-4 col-sm-4 mg_bt_10_xs">
            <select class="form-control" id="cmb_tour_group" name="cmb_tour_group" onchange="canceled_travelers_reflect();" title="Tour Date"> 
                <option value="">Tour Date</option>        
            </select>
        </div>
        <div class="col-md-4 col-sm-4">
            <select class="form-control" id="cmb_traveler_group_id" name="cmb_traveler_group_id" onchange="refund_cancelled_tour_group_traveler_reflect();" title="Booking ID"> 
                <option value="">Booking ID</option>        
            </select>
        </div>
    </div>
</div>

<div id="div_traveler_refund_details" class="main_block"></div>   
<script type="text/javascript">
    $('#cmb_traveler_group_id').select2();
</script>
<script src="<?= BASE_URL?>/view/tour_cancelation_and_refund/js/refund_cancelled_tour.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
