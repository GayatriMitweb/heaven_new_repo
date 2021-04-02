<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Upload/Download Itinerary') ?>

<div class="row text-center mg_bt_20">
  <label for="rd_upload_itinerary" class="app_dual_button active">
      <input type="radio" id="rd_upload_itinerary" name="rd_itinerary" checked  onchange="vendor_dashboard_content_reflect()">
      &nbsp;&nbsp;Upload Itinerary
  </label>
  <label for="rd_download_itinerary" class="app_dual_button">
      <input type="radio" id="rd_download_itinerary" name="rd_itinerary" onchange="vendor_dashboard_content_reflect()">
      &nbsp;&nbsp;Download Itinerary
  </label>
</div>

<div id="div_dashboard_content"></div>

<script>
function vendor_dashboard_content_reflect()
{ 
  var id = $('input[name="rd_itinerary"]:checked').attr('id');
  if(id=="rd_upload_itinerary"){
      $.post('adnary_upload_for_tour.php', {}, function(data){
        $('#div_dashboard_content').html(data);
      });
  }
  if(id=="rd_download_itinerary"){
      $.post('adnary_download_for_tour.php', {}, function(data){
        $('#div_dashboard_content').html(data);
      });
  }
   
}
vendor_dashboard_content_reflect();
</script>

<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>