<?php include "../../../../../model/model.php";

 ?>
<div class="app_panel_content Filter-panel mg_bt_10">
    
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
          <select id="tour_id_filter" name="tour_id_filter" onchange="tour_group_dynamic_reflect1(this.id,'group_id_filter');" style="width:100%" title="Tour Name" class="form-control"> 
              <option value="">Tour Name</option>
              <?php
                  $sq=mysql_query("select tour_id,tour_name from tour_master where active_flag='Active' order by tour_name");
                  while($row=mysql_fetch_assoc($sq))
                  {
                    echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                  }    
              ?>
          </select>
        </div>
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
          <select class="form-control" id="group_id_filter" name="group_id_filter"  title="Tour Group" onchange="traveler_member_reflect();"> 
              <option value="">Tour Group</option>        
          </select>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12 form-group">
          <button class="btn btn-sm btn-info ico_right" onclick="collection_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
      </div>
</div>
<div id="div_list" class="main_block mg_tp_20">
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="gtc_tour_report" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<script>
  $('#tour_id_filter').select2();
  var column = [
	{ title: "S_No." },
	{ title: "Passenger_name" },
	{ title: "cheque_no/id" },
	{ title: "bank_Name" },
	{ title: "Refund_Mode" },
	{ title: "Refund_Amount", className: "success" }
];
	function collection_reflect(){
		var tour_id = $('#tour_id_filter').val();
    var group_id = $('#group_id_filter').val();
		$.post('reports_content/group_tour/refund_cancelled_traveler_report/refund_cancelled_traveler_report_filter.php', {tour_id : tour_id,group_id : group_id}, function(data){
      pagination_load(data, column, true, true, 20, 'gtc_tour_report');
	});
	}
  collection_reflect();

   function tour_group_dynamic_reflect1(id, goup_id)
{
  var base_url = $('#base_url').val();
  var tour_id=document.getElementById(id).value;  

  $.get(base_url+"view/reports/reports_content/group_tour/refund_tour_cancelation_report/tour_group_reflect.php", { tour_id : tour_id }, function(data){
      $('#'+goup_id).html(data);
  });
}
</script>