<?php
include_once('../../../../model/model.php');
include_once('../../layouts/admin_header.php');
$today = date('Y-m-d');
?>
<!--////////////****************************Actual Form content start*********************************/////////-->
<div class="app_panel_head main_block mg_bt_10" style="border-bottom: 1px solid #dddddd8f;">
    <h2 class="pull-left">Sightseeing Attractions</h2>
</div>
<div class="tour-info-wrap-new main_block">
    <div class="profile_box main_block">
        <?php 
        $sq_det = mysql_query("select * from fourth_coming_attraction_master where status!='Disabled' and valid_date>='$today'");
        while($row_det = mysql_fetch_assoc($sq_det))
        {
        ?>
            <div class="col-xs-12">
                <div class="main_block bg_light">
                    <div class="col-md-8 col-xs-12"><h5><?php echo $row_det['title'] ?></h5></div>
                    <div class="col-md-4 col-xs-12"><h5><i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i> Dated :  <?php echo date("d-m-Y", strtotime($row_det['created_at'])); ?></h5></div>
                </div>
                <div class="panel panel-default panel-body app_panel_style main_block">
                    <p><?php echo $row_det['description'] ?></p>
                </div>
            </div>
        <?php   
        }    
        ?>
    </div>
</div>
<?= end_panel() ?>
<!--/////////*****************************Actual Form content end********************************/////////////-->
<?php 
include_once('../../layouts/admin_footer.php');
?>