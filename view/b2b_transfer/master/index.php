<div class="row">
<div class="col-md-12 text-right">
  <button class="btn btn-info btn-sm ico_left" onclick="service_time_modal();" data-toggle="tooltip" title="Add Pickup and Return Service timings"><i class="fa fa-plus"></i>&nbsp;&nbsp;Service Timing</button>
  <button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#master_save_modal" title="Add new Vehicle"><i class="fa fa-plus"></i>&nbsp;&nbsp;Vehicle</button>
</div>
</div>
<div id="div_list" class="main_block">
<div class="row mg_tp_20">
  <div class="table-responsive">
    <table id="tbl_list" class="table table-hover" style="width:100%;margin: 20px 0 !important;">         
    </table>
  </div>
</div>
</div>
<div id="div_edit_modal"></div>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<?php include_once('save_modal.php'); ?>
<div id="div_view_modal"></div>
<script src="js/master.js"></script>