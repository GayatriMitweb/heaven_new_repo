<form id="frm_tab_2">
<div class="app_panel"> 



 <!--=======Header panel======-->
    <div class="app_panel_head mg_bt_20">
      <div class="container">
          <h2 class="pull-left">Travelling Information</h2>
          <div class="pull-right header_btn">
            <button>
                <a>
                    <i class="fa fa-arrow-right"></i>
                </a>
            </button>
          </div>
          <div class="pull-right header_btn">
            <button type="button" onclick="back_to_tab_1()">
                <a>
                    <i class="fa fa-arrow-left"></i>
                </a>
            </button>
          </div>
      </div>
    </div> 

  <!--=======Header panel end======-->


 
    <div class="app_panel_content no-pad">
        <div class="container">
            <div class="panel panel-default panel-body main_block bg_light mg_bt_10">
                <legend>Train Details</legend>
                <div class="bg_white main_block panel-body panel panel-default">
                    <?php
                    $train_info_count = mysql_num_rows(mysql_query("select * from package_train_master where booking_id='$booking_id'"));
                    if($train_info_count==0)
                    {
                        include_once('../booking_save/tab_2/train_info.php');
                    }
                    else{
                        include_once('train_info.php');
                    }
                    ?>
                </div>
            </div>
            <div class="panel panel-default panel-body main_block bg_light mg_bt_10">
                <legend>Flight Details</legend>
                <div class="bg_white main_block panel-body panel panel-default">
                    <?php
                    $train_info_count = mysql_num_rows(mysql_query("select * from package_plane_master where booking_id='$booking_id'"));
                    if($train_info_count==0)
                    {
                        include_once('../booking_save/tab_2/plane_info.php');
                    }
                    else{?>
                    <?php  include_once('plane_info.php'); } ?>
                </div>
            </div>
            <div class="panel panel-default panel-body main_block bg_light mg_bt_10">
                <legend>Cruise Details</legend>
                <div class="bg_white main_block panel-body panel panel-default">
                    <?php 
                    $cruise_info_count = mysql_num_rows(mysql_query("select * from package_cruise_master where booking_id='$booking_id'"));
                    if($cruise_info_count==0)
                    {
                        include_once('../booking_save/tab_2/cruise_info.php');
                    }
                    else{
                        include_once('cruise_info.php');
                    }
                    ?>
                </div>
            </div>
            <div class="panel panel-default panel-body main_block bg_light mg_bt_10">
                <div class="row text-center">
                    <div class="col-md-12 text-center">
                        <label>Total Travel Expense</label>
                    </div>
                    <div class="col-md-2 col-md-offset-5">
                        <input type="text" id="txt_travel_total_expense" class="amount_feild_highlight text-right" name="txt_travel_total_expense" title="Total Travel Expense" readonly value="<?php echo $sq_booking_info['total_travel_expense'] ?>" />
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default main_block bg_light pad_8 text-center mg_tp_10 mg_bt_150">
            <div class="text-center">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-info ico_left" type="button" onclick="back_to_tab_1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-sm btn-info ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
                </div>
            </div>
        </div>

<?= end_panel() ?>
</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script src="../js/tab_2_calculations.js"></script>
<script src="../js/tab_2.js"></script>