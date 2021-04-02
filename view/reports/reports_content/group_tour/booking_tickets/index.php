<?php include "../../../../../model/model.php"; ?>
<div class="app_panel_content Filter-panel mg_bt_10">
    <div class="col-md-3 col-sm-3 mg_bt_10_xs">
            <select style="width:100%;" class="form-control" id="cmb_tour_name" name="cmb_tour_name" onchange="cancelled_tour_groups_reflect1(this.id);" title="Tour Name"> 
                <option value="">Tour Name </option>
                <?php
                    $sq=mysql_query("select tour_id,tour_name from tour_master order by tour_name");
                    while($row=mysql_fetch_assoc($sq))
                    {
                      echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                    }    
                ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-3 mg_bt_10_xs">
            <select class="form-control" id="cmb_tour_group" name="cmb_tour_group" onchange="canceled_travelers_reflect1();" title="Tour Date"> 
                <option value="">Tour Date</option>        
            </select>
        </div>
        <div class="col-md-3 col-sm-3">
            <select class="form-control" id="cmb_traveler_group_id" name="cmb_traveler_group_id" onchange="refund_cancelled_tour_group_traveler_reflect();" title="Booking ID"> 
                <option value="">Booking ID</option>        
            </select>
        </div>
    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
        <button class="btn btn-sm btn-info ico_right" onclick="tour_group_dynamic_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
      </div>
</div>
<div id="div_list" class="main_block mg_tp_20">
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="gtc_tour_report" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<script>
  $('#cmb_tour_name,#cmb_tour_group,#cmb_traveler_group_id').select2();
</script>
<script type="text/javascript">
 var column = [
	{ title: "S_No." },
	{ title: "Tour_name" },
	{ title: "tour_date" },
	{ title: "booking_id" },
	{ title: "train_ticket" },
  { title: "flight_ticket"},
  { title: "cruise_ticket"}
];
function tour_group_dynamic_reflect()
{

  var tour_id = $('#cmb_tour_name').val();
  var booking_id = $('#cmb_traveler_group_id').val();
  var group_id = $('#cmb_tour_group').val();
 
    $.post('reports_content/group_tour/booking_tickets/booking_ticket_report_filter.php', { tour_id : tour_id, booking_id : booking_id, group_id : group_id}, function(data){
      pagination_load(data, column, true, false, 20, 'gtc_tour_report');
    });
}
tour_group_dynamic_reflect();

function cancelled_tour_groups_reflect1(id)
{
  var tour_id=$('#'+id).val();

  $.get('reports_content/group_tour/booking_tickets/cancelled_tour_groups_reflect.php', { tour_id : tour_id }, function(data){
    $('#cmb_tour_group').html(data);
  }); 

}
function canceled_travelers_reflect1()
{
  var tour_id = document.getElementById("cmb_tour_name").value;
  var tour_group_id = document.getElementById("cmb_tour_group").value;
 
  $.get( "reports_content/group_tour/booking_tickets/cancelled_traveler_reflect.php" , { tour_id : tour_id, tour_group_id : tour_group_id } , function ( data ) {
                $ ("#cmb_traveler_group_id").html( data ) ;
          } ) ; 
}
</script>