<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>

<?= begin_panel('Transport Information Update') ?>
                  
<form action="transport_agency_master_update.php" id="frm_transport_agency" method="POST">    
    
        <div class="row">
            <div class="col-md-3 col-sm-4 mg_bt_10_xs">
                <select id="cmb_city_id" name="cmb_city_id" style="width:100%" onchange="transport_agency_name_load(this.id)" required>
                    <option value="">Select City Name</option>
                    <?php 
                     $sq_tour_info = mysql_query("select * from city_master");
                     while($row = mysql_fetch_assoc($sq_tour_info))
                     {
                     ?>
                     <option value="<?php echo $row['city_id'] ?>"><?php echo $row['city_name'] ?></option>
                     <?php   
                     }    
                    ?>
                </select>        
            </div>
            <div class="col-md-3 col-sm-4 mg_bt_10_xs">
               <select id="cmb_transport_agency_id" name="cmb_transport_agency_id" class="form-control" required>
                    <option value="">Select Transport Agency Name</option>
                </select>    
            </div>
            <div class="col-md-3 col-sm-4">
                <button class="btn btn-info ico_right">Submit&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
            </div>
        </div>


</form>   

<?= end_panel() ?> 

<script>
$(document).ready(function() {
    $("#cmb_city_id").select2();   
});
$('#frm_transport_agency').validate();
</script>

<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>