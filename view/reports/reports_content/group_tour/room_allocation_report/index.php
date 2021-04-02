<?php include "../../../../../model/model.php";

 ?>
<div class="app_panel_content Filter-panel mg_bt_10">
	<!-- <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <select id="g_booking_id_filter" name="booking_id_filter" style="width:100%" title="Booking ID" class="form-control" onchange="room_reflect()"> 
	          <?php get_group_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id); ?>
	      </select>
	</div> -->
	<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
        <select id="tour_id_filter" name="tour_id_filter" onchange="tour_group_dynamic_reflect(this.id,'group_id_filter');" style="width:100%" title="Tour Name" class="form-control"> 
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
        <button class="btn btn-sm btn-info ico_right" onclick="room_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
    </div>
</div>
<div id="div_list" class="main_block mg_tp_20">
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="gr_tour_report" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<script>
    $('#tour_id_filter').select2();
    var column = [
	{ title : "S_No."},
    { title:"Tour_name"},
    { title:"Tour_date"},
    { title:"booking_id"},
    { title:"seats"},
    { title:"double_bed_room"},
	{ title : "Extra_bed"},
	{ title : "on_floor"}
];
	function room_reflect(){
		var group_id = $('#group_id_filter').val();
		var tour_id = $('#tour_id_filter').val();
		$.post('reports_content/group_tour/room_allocation_report/room_allocation_report.php', {group_id : group_id,tour_id : tour_id}, function(data){
            pagination_load(data, column, true, false, 20, 'gr_tour_report');
	});
	}
	room_reflect();
</script>