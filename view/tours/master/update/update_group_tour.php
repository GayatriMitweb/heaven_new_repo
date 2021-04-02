<?php
include "../../../../model/model.php";
include_once('../../../layouts/fullwidth_app_header.php'); 
$tour_id = $_POST['tour_id'];
$tour_info = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$tour_id'"));
?>
<!-- Tab panes -->
<div class="bk_tab_head bg_light">
    <ul> 
        <li>
            <a href="javascript:void(0)" id="tab1_head" class="active">
                <span class="num" title="Tour">1<i class="fa fa-check"></i></span><br>
                <span class="text">Tour</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab2_head">
                <span class="num" title="Travelling">2<i class="fa fa-check"></i></span><br>
                <span class="text">Travelling</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab3_head">
                <span class="num" title="Daywise Images">3<i class="fa fa-check"></i></span><br>
                <span class="text">Daywise Images</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab4_head">
                <span class="num" title="Costing">4<i class="fa fa-check"></i></span><br>
                <span class="text">Costing</span>
            </a>
        </li>
    </ul>
</div>
<div class="bk_tabs">
  <div id="tab1" class="bk_tab active">
      <?php include_once("package_tab1.php"); ?>
  </div>
  <div id="tab2" class="bk_tab">
      <?php include_once("travelling_tab2.php"); ?>
  </div>
  <div id="tab3" class="bk_tab">
      <?php include_once("daywise_tab3.php"); ?>
  </div>
  <div id="tab4" class="bk_tab">
      <?php include_once("costing_tab3.php"); ?>
  </div>
</div>
<script src="../../js/master.js"></script>
<script>
$('#update_modal1').modal('show');
$('#plane_from_location1,#plane_to_location1').select2();
$('#train_from_location1,#train_to_location1').select2({minimumInputLength: 1});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<?php 
include_once('../../../layouts/fullwidth_app_footer.php');
?>