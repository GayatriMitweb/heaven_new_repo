<?php
include "../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
    <h5 style="color: red;">Note : This is only for Group Tour (FIT/Fixed departure)</h5>
</div>
<div class="app_panel_content">
    <div class="row text_center_xs mg_tp_10">
        <div class="col-md-3 col-sm-4 text-right text_center_xs">
        </div>
        <div class="col-md-3 col-sm-4 mg_bt_10_xs">
            <select id="cmb_tour_id" name="cmb_tour_id" class="form-control">
                <option value="" selected>Tour Name</option>
                <?php
                    $count=0;
                    $sq = mysql_query("select tour_id, tour_name from tour_master where active_flag = 'Active'");
                    while($row = mysql_fetch_assoc($sq))
                    {
                ?>               
                     <option value="<?php echo $row['tour_id'] ?>"><?php echo $row['tour_name'] ?></option>                           
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-4 text_center_xs">
            <div class="div-upload pull-left" id="div_upload_button">
                <div id="adnary_upload" class="upload-button1"><span>Upload Itinerary</span></div>
                <span id="adnary_status"></span>
                <ul id="files" ></ul>
                <input type="hidden" id="txt_adnary_upload_dir" name="txt_adnary_upload_dir">
            </div>
        </div>
    </div>
</div>
 
                          


<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script src="js/adnary.js"></script>