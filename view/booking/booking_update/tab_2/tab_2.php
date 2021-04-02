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
                        <button type="button" onclick="switch_to_tab_1()">
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
            <div class="panel panel-default panel-body main_block bg_light">
                <legend>Train Details</legend>
                <div class="bg_white main_block panel-body panel panel-default">
                    <?php include_once('train_info.php'); ?>
                </div>
            </div>

            <div class="panel panel-default panel-body main_block bg_light">
                <legend>Flight Details</legend>
                <div class="bg_white main_block panel-body panel panel-default">
                    <?php include_once('plane_info.php'); ?>
                </div>
            </div> 
            <div class="panel panel-default panel-body main_block bg_light">
                <legend>Cruise Details</legend>
                <div class="bg_white main_block panel-body panel panel-default">
                    <?php include_once('cruise_info.php'); ?>
                </div>
            </div>     

            <div class="panel panel-default panel-body main_block bg_light pad_8 text-center">
                <div class="row">
                    <div class="col-md-5 col-sm-6 col-xs-12 text-right text_center_xs"><label>Total Travel Expense</label></div>
                    <div class="col-md-2 col-sm-4 col-xs-12"><input type="text" id="txt_travel_total_expense" class="amount_feild_highlight text-right" name="txt_travel_total_expense" title="Total Travel Expense" value="<?php echo $tourwise_details['total_travel_expense'] ?>" readonly /></div>
                </div>
            </div>
        </div>

        <div class="panel panel-default main_block bg_light pad_8 text-center mg_bt_0">
            <button type="button" onclick="switch_to_tab_1()" class="btn btn-sm btn-info ico_left"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button> &nbsp;&nbsp;
            <button class="btn btn-sm btn-info ico_right" onclick="calculate_cruise_expense('tbl_dynamic_cruise_package_booking')">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
        </div>

<?= end_panel() ?>
</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script src="../js/tab_2.js"></script>
<script src="../js/tab_2_calculations.js"></script>


<script>

</script>