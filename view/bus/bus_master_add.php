<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
require_once('../../classes/tour_booked_seats.php');
?>

<form id="frm_bust_master_save">
<?= begin_panel('New Bus') ?>
<div class="row">
<div class="col-md-10 col-md-offset-1">

    <div class="panel panel-default panel-body mg_bt_10 text-center">
        
        <div class="row mg_bt_10">
            <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
                <select class="form-control" id="txt_bus_name" name="txt_bus_name" title="Select Bus Name">
                    <option value="">Select Bus Name</option>
                    <option value="14 seater"> 14 seater </option>
                    <option value="17 seater"> 17 seater </option>
                    <option value="19 seater"> 19 seater </option>
                    <option value="27 seater"> 27 seater </option>
                    <option value="35 seater"> 35 seater </option>
                    <option value="41 seater"> 41 seater </option>
                    <option value="49 seater"> 49 seater </option>
                </select> 
            </div>
            <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
                <input type="text" class="form-control" id="txt_bus_capacity" name="txt_bus_capacity" placeholder="Bus Capacity" maxlength="3" title="Bus Capacity"/>
            </div>
            <div class="col-md-3 col-sm-12 mg_bt_10_sm_xs">
                <button class="btn btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Bus</button>
            </div>         
        </div>        
       
    </div>

</div>
</div>
<?= end_panel() ?>
</form>


<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script src="js/bus.js"></script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>