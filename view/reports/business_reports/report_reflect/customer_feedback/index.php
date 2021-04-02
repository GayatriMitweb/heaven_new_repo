<?php
include "../../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$sq_total = mysql_num_rows(mysql_query("select * from customer_feedback_master"));

$sq_stars = mysql_fetch_assoc(mysql_query("select sum(trip_overall) as sum from customer_feedback_master "));

$avg_stars = ($sq_stars['sum']/ $sq_total);

$sq_feedback = mysql_num_rows(mysql_query("select * from customer_feedback_master where travel_again='Yes'"));
$travel_again_per = ($sq_feedback/$sq_total)*100;

$sq_feed = mysql_num_rows(mysql_query("select * from customer_feedback_master where hotel_recommend='Yes'"));
$recommend_others = ($sq_feed/$sq_total)* 100;

$sq_factor = mysql_fetch_assoc(mysql_query("select travel_agencies, count(travel_agencies) as max from customer_feedback_master group by travel_agencies order by max desc limit 1"));

$sq_sales = mysql_num_rows(mysql_query("select * from customer_feedback_master where sales_team='none_of_these'"));
$sales_team = ($sq_sales/$sq_total)* 100;

$sq_req = mysql_num_rows(mysql_query("select * from customer_feedback_master where vehicles_requested ='Unacceptable' or vehicles_requested='Poor' "));

$sq_pick = mysql_num_rows(mysql_query("select * from customer_feedback_master where  pickup_time='Unacceptable' or pickup_time='Poor' "));

$sq_cond = mysql_num_rows(mysql_query("select * from customer_feedback_master where vehicles_condition='Unacceptable' or vehicles_condition='Poor'"));

$sq_dri = mysql_num_rows(mysql_query("select * from customer_feedback_master where  driver_info='Unacceptable' or driver_info='Poor'"));

$sq_ticket = mysql_num_rows(mysql_query("select * from customer_feedback_master where   ticket_info='Unacceptable' or ticket_info='Poor'"));

$total_travel = $sq_req + $sq_pick + $sq_cond + $sq_dri + $sq_ticket;

$per_travel = ($total_travel/($sq_total*5))*100;

$sq_hotel_req = mysql_num_rows(mysql_query("select * from customer_feedback_master where hotel_request='No'"));

$sq_hotel_clean = mysql_num_rows(mysql_query("select * from customer_feedback_master where hotel_clean='No'"));

$sq_hotel_quality = mysql_num_rows(mysql_query("select * from customer_feedback_master where   hotel_quality='Unacceptable' or hotel_quality='Poor'"));

$total_acc = $sq_hotel_clean + $sq_hotel_req + $sq_hotel_quality;

$per_acc = ($total_acc/($sq_total*3))*100;

$sq_siteseen = mysql_num_rows(mysql_query("select * from customer_feedback_master where siteseen='No'"));

$sq_siteseen_time = mysql_num_rows(mysql_query("select * from customer_feedback_master where siteseen_time='No'"));

$sq_tour_guide = mysql_num_rows(mysql_query("select * from customer_feedback_master where   tour_guide='Unacceptable' or tour_guide='Poor'"));

$total_site = $sq_siteseen + $sq_siteseen_time + $sq_tour_guide;

$per_site = ($total_site/($sq_total*3))*100;
 

?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
 <div class="main_block">

    <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
      <div class="widget_parent-bg-img bg-purple mg_bt_10_sm_xs">
        <div class="widget_parent">
            <div class="row"><div class="col-md-12">
               <div class="widget-badge mg_tp_10">
                    <div class="label label-warning"><?= number_format($avg_stars,2) ?></div>&nbsp;&nbsp;
                    <label>Average Feedbacks</label>
                </div> 
            </div></div>
            <div class="row"> <div class="col-md-12">
                <div class="progress mg_bt_0">
                  <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= $avg_stars ?>%"></div>
                </div>
            </div></div>
        </div>
      </div>
   </div>

    <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
      <div class="widget_parent-bg-img bg-purple mg_bt_10_sm_xs">
        <div class="widget_parent">
            <div class="row"><div class="col-md-12">
               <div class="widget-badge mg_tp_10">
                    <div class="label label-warning"><?= number_format($travel_again_per,2) ?></div>&nbsp;&nbsp;
                    <label>Love To Travel Again</label>
                </div> 
            </div></div>
            <div class="row"> <div class="col-md-12">
                <div class="progress mg_bt_0">
                  <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= $travel_again_per ?>%"></div>
                </div>
            </div></div>
        </div>
      </div>
   </div>

    <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
      <div class="widget_parent-bg-img bg-purple mg_bt_10_sm_xs">
        <div class="widget_parent">
            <div class="row"><div class="col-md-12">
               <div class="widget-badge mg_tp_10">
                    <div class="label label-warning"><?= number_format($recommend_others,2) ?></div>&nbsp;&nbsp;
                    <label>Recommand To Others</label>
                </div> 
            </div></div>
            <div class="row"> <div class="col-md-12">
                <div class="progress mg_bt_0">
                  <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= $recommend_others ?>%"></div>
                </div>
            </div></div>
        </div>
      </div>
   </div>


</div>

 <div class="main_block mg_bt_10">

    <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
      <div class="widget_parent-bg-img bg-red mg_bt_10_sm_xs">
        <div class="widget_parent">
            <div class="row"><div class="col-md-12">
               <div class="widget-badge mg_tp_10">
                    <div class="label label-warning"><?= number_format($sales_team,2) ?></div>&nbsp;&nbsp;
                    <label>Negative Sales Team Feedback</label>
                </div> 
            </div></div>
            <div class="row"> <div class="col-md-12">
                <div class="progress mg_bt_0">
                  <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= $sales_team ?>%"></div>
                </div>
            </div></div>
        </div>
      </div>
   </div>

    <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
      <div class="widget_parent-bg-img bg-red mg_bt_10_sm_xs">
        <div class="widget_parent">
            <div class="row"><div class="col-md-12">
               <div class="widget-badge mg_tp_10">
                    <div class="label label-warning"><?= number_format($per_travel,2) ?></div>&nbsp;&nbsp;
                    <label>Dislikes Travel Services</label>
                </div> 
            </div></div>
            <div class="row"> <div class="col-md-12">
                <div class="progress mg_bt_0">
                  <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= $per_travel ?>%"></div>
                </div>
            </div></div>
        </div>
      </div>
   </div>

    <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
      <div class="widget_parent-bg-img bg-red mg_bt_10_sm_xs">
        <div class="widget_parent">
            <div class="row"><div class="col-md-12">
               <div class="widget-badge mg_tp_10">
                    <div class="label label-warning"><?= number_format($per_acc,2) ?></div>&nbsp;&nbsp;
                    <label>Dislikes Accommodation Services</label>
                </div> 
            </div></div>
            <div class="row"> <div class="col-md-12">
                <div class="progress mg_bt_0">
                  <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= $per_acc ?>%"></div>
                </div>
            </div></div>
        </div>
      </div>
   </div>

</div>
 

  <div class="app_panel mg_bt_20">
  <div class="app_panel_content Filter-panel">
    <div class="row">
      <div class="col-md-3">
          <select name="booking_type" id="booking_type" title="Booking Type" onchange="customer_bookings_reflect(this.value)">
                  <option value="">Booking Type</option>
                  <option value="Group Booking">Group Booking</option>
                  <option value="Package Booking">Package Booking</option>
              </select>
          </div>
      <div class="col-md-3">
        <select name="booking_id" id="booking_id" class="form-control" title="Select Booking" style="width:100%" >
          <option value="">Booking ID</option>
        </select>
      </div>
      <div class="col-md-3 col-sm-4 mg_bt_10_sm_xs">
        <select name="customer_id" id="customer_id" class="customer_dropdown" title="Customer Name" style="width:100%" >
            <?php get_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
          </select>
      </div>
      <div class="col-md-3">
        <button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Submit&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
      </div>
    </div>
  </div>
</div>

<div class="row main_block"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="group_tour_report" class="table table-hover" style="width:100%">         
</table>
</div></div></div>
<div id="div_view" class="main_block"></div>

<script>
$('#customer_id').select2();
$( "#from_date, #to_date" ).datetimepicker({ timepicker:false, format:'d-m-Y' });   
function customer_bookings_reflect(booking_type){
    $.post('report_reflect/customer_feedback/booking_reflect.php', { booking_type : booking_type}, function(data){
      $('#booking_id').html(data);
    }); 
  } 
var column = [
{ title : "S_No."},
{ title : "Customer_Name"},
{ title : "Booking_ID"},
{ title : "Tour_Type"},
{ title : "Tour_Date"},
{ title : "View"}	
];    
function list_reflect()
{
  $('#div_list').append('<div class="loader"></div>');
  var customer_id = $('#customer_id').val();
  var booking_type = $("#booking_type").val();  
  var booking_id = $("#booking_id").val(); 
  var branch_status = $('#branch_status').val();
  $.get( "report_reflect/customer_feedback/list_reflect.php" , { customer_id : customer_id, booking_type : booking_type, booking_id : booking_id, branch_status : branch_status } , function ( data ) {

    pagination_load(data, column, true, false, 20, 'group_tour_report');
  } ) ; 
}
list_reflect();
function view_modal(feedback_id){
        $.post('report_reflect/customer_feedback/view/index.php', { feedback_id : feedback_id }, function(data){
            $('#div_view').html(data);
        }); 
    }

</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>