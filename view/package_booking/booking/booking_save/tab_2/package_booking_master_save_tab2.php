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
            <div class="panel panel-default panel-body bg_light mg_bt_20">
                <legend>Train Details</legend>
                <div class="bg_white main_block panel-body panel panel-default">
                    <?php include_once('train_info.php') ?>
                </div>
            </div>
            <div class="panel panel-default panel-body bg_light mg_bt_20">
                <legend>Flight Details</legend>
                <div class="bg_white main_block panel-body panel panel-default">
                    <?php include_once('plane_info.php') ?>
                </div>
            </div>
            <div class="panel panel-default panel-body bg_light mg_bt_20">
                <legend>Cruise Details</legend>
                <div class="bg_white main_block panel-body panel panel-default">
                    <?php include_once('cruise_info.php') ?>
                </div>
            </div>

            <div class="panel panel-default panel-body bg_light mg_bt_20">
                <div class="row text-center">
                    <div class="col-xs-12 text-center">
                         <label>Total Travel Expense</label>
                    </div>
                    <div class="col-md-2 col-md-offset-5 col-sm-4 col-sm-offset-4 col-xs-12">
                        <input type="text" id="txt_travel_total_expense" class="amount_feild_highlight text-right" name="txt_travel_total_expense" disabled />
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default main_block bg_light pad_8 text-center mg_bt_150">
            <div class="text-center">
                <div class="col-xs-12">
                    <button class="btn btn-sm btn-info ico_left" type="button" onclick="back_to_tab_1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-sm btn-info ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
                </div>
            </div>
        </div>

<?= end_panel() ?>
</form>
<script type="text/javascript">
    $('#txt_arravl1,#txt_depart1').datetimepicker({ format:'d-m-Y H:i:s' });
</script>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script src="../js/tab_2_calculations.js"></script>
<script src="../js/tab_2.js"></script>