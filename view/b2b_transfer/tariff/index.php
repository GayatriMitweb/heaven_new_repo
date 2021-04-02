<?php 
// include_once('../../../model/model.php');
?>
<div class="row mg_bt_20">

<div class="col-md-12 text-right">
  <button class="btn btn-info btn-sm ico_left" onclick="tariff_save_modal()" data-toggle="tooltip" title="Add new Tariff"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tariff</button>
</div>
</div>
<div class="app_panel_content Filter-panel">
  <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
          <input type="text" placeholder="From date" title="From Date" onchange="tariff_list_reflect();" class="form-control" id="from_date_filter" data-toggle="tooltip"/>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
          <input type="text" placeholder="To date" title="To Date" onchange="tariff_list_reflect();" class="form-control" id="to_date_filter" data-toggle="tooltip"/>
      </div>
  </div>
</div>
<div id="div_tariffsave_modal"></div>
<div id="div_request_list" class="main_block loader_parent">
<div class="row mg_tp_20"> <div class="table-responsive">
        <table id="b2b_tarrif_tab" class="table table-hover" style="width:100%;margin: 20px 0 !important;">         
        </table>
    </div></div></div>
</div>

<script>
$('#from_date_filter,#to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
function tariff_save_modal()
{
  	$.post('tariff/save_modal.php', {}, function(data){
      $('#div_tariffsave_modal').html(data);
    });
}
</script>

<script src="js/tariff.js"></script>