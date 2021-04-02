<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Performance Ratings',94) ?>
 <div class="app_panel_content Filter-panel">
  <div class="row">
    <div class="col-md-3 col-sm-6 mg_bt_10_xs col-md-offset-3">
      <select name="year_filter" style="width: 100%" id="year_filter" title="Year" onchange="list_reflect();">
        <option value="">Year</option>
        <?php 
        for($year_count=2018; $year_count<2099; $year_count++){
          ?>
          <option value="<?= $year_count ?>"><?= $year_count ?></option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>
</div>

<div id="div_list" class="main_block"></div>
<div id="div_modal"></div>
 
<script>
 $('#year_filter').select2();
function list_reflect()
{
  var year = $('#year_filter').val();
	$.post('list_reflect.php',{ year : year}, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();
  
</script>
<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>