<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Bus Seat Arrangment') ?>
        
<form id="frm_bus_seating_arrangment_select">
<div class="panel panel-default panel-body mg_bt_10">
    <div class="row text-center">
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
            <select class="form-control" id="cmb_bus_id" name="cmb_bus_id" required>
                <option value="">Select Bus Name</option>
                <?php
                $sq_bus_det = mysql_query("select bus_id, bus_name from bus_master");    
                while($row_bus_det = mysql_fetch_assoc($sq_bus_det))
                {
                 ?>
                 <option value="<?php echo $row_bus_det['bus_id'] ?>"><?php echo $row_bus_det['bus_name'] ?></option>
                 <?php   
                }    
                ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
            <select class="form-control" id="cmb_tour_name" name="cmb_tour_name" onchange="tour_group_reflect(this.id);" required> 
                <option value=""> Select Tour Name </option>
                <?php
                    $sq=mysql_query("select tour_id,tour_name from tour_master");
                    while($row=mysql_fetch_assoc($sq))
                    {
                      echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                    }    
                ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select class="form-control" id="cmb_tour_group" name="cmb_tour_group" required>
                <option value=""> Select Tour Group </option>        
            </select> 
        </div>
        <div class="col-md-3 text-left text_center_xs">
            <button class="btn btn-info ico_right" onclick="bus_seat_arrangement_content_reflect()">Submit&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button> 
        </div>
    </div>
</div>
</form>        

<div class="row" id="bus_seat_arrangment_content"></div>  

<?= end_panel() ?>


<script src="js/bus_seating_arrangment.js"></script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?> 