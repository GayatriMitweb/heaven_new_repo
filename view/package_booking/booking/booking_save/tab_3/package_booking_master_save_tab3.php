<form id="frm_tab_3">

<div class="app_panel"> 
     <!--=======Header panel======-->
        <div class="app_panel_head">
            <div class="container">
              <h2 class="pull-left"></h2>
              <div class="pull-right header_btn">
                <button>
                    <a>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </button>
              </div>
              <div class="pull-right header_btn">
                <button type="button" onclick="back_to_tab_2()">
                    <a>
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </button>
              </div>
            </div>
        </div> 

  <!--=======Header panel end======-->


    <div class=""> 
        <div class="container">
        <h5 class="booking-section-heading main_block">Accommodation details</h5>
        <?php include("hotel_table_row.php"); ?>

        <h5 class="booking-section-heading main_block">Transport Details</h5>
        <?php include("transport_table_row.php"); ?>

        <h5 class="booking-section-heading main_block">Activity Details</h5>
        <?php include("excursion_table_row.php"); ?>

<div class="panel panel-default main_block bg_light pad_8 text-center mg_bt_150">
    <div class="text-center">
        <div class="col-md-12">
            <button class="btn btn-sm btn-info ico_left" type="button" onclick="back_to_tab_2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-sm btn-info ico_right" onclick="calculate_train_expense('tbl_train_travel_details_dynamic_row');calculate_cruise_expense('tbl_dynamic_cruise_package_booking');calculate_plane_expense('tbl_plane_travel_details_dynamic_row')">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
        </div>
    </div>
</div>
<div id="div_modal_content"></div>
</form>
<?= end_panel() ?>
<script src="../js/tab_3.js"></script> 
<script type="text/javascript">
    function disabled_transport_details(id)
    {
        var id = $('#transport_agency_id').val();
        if(id!='N/A')
        {
           $("#vehicle_name1").prop({disabled:'', value:''});
            $('#txt_tsp_from_date').prop({disabled:'', value:''});
            $("#txt_tsp_to_date").prop({disabled:'', value:''});
            $('#txt_tsp_total_amount').prop({disabled:'', value:''});
        }
        else
        {
            $("#vehicle_name1").prop({disabled:'disabled',value:''});
            $('#txt_tsp_from_date').prop({disabled:'disabled', value:''});
            $("#txt_tsp_to_date").prop({disabled:'disabled', value:''}); 
            $('#txt_tsp_total_amount').prop({disabled:'disabled', value:''});
        }
    }

</script>
