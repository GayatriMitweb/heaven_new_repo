//================================Group tour start==============================================//
function tours_overview_reflect(){
  var tour_id = $('#dash_tour_overview_tour_id').val();	  
  $.post('admin/group_tour/tours_overview.php', { tour_id : tour_id }, function(data){
  	$('.dash_tour_overview_body').html(data);
  });	
}
tours_overview_reflect();

function booking_weekly_monthly_report()
{
  var tour_id = $('#weekly_monthly_tour_id').val();	  
  $.post('admin/group_tour/booking_weekly_monthly.php', { tour_id : tour_id }, function(data){
  	$('.booking_weekly_monthly_report_body').html(data);
  });
}
booking_weekly_monthly_report();

function group_tour_file_no_wise()
{
  var tourwise_id = $('#tourwise_id').val();	  
  $.post('admin/group_tour/file_no_wise.php', { tourwise_id : tourwise_id }, function(data){
  	$('.dash_group_tour_file_no .body').html(data);
  });
}
group_tour_file_no_wise();

function package_tour_file_no_wise()
{
  var booking_id = $('#booking_id').val();	  
  $.post('admin/package_tour/file_no_wise.php', { booking_id : booking_id }, function(data){
  	$('.dash_package_tour_file_no .body').html(data);
  });
}
package_tour_file_no_wise();

function monthly_expense_and_revenue()
{
  var date = $('#monthly_expnse_and_revenue_date').val();	  
  $.post('admin/monthly_expense_and_revenue.php', { date : date }, function(data){
  	$('.dash_monthly_expense_and_revenue_body').html(data);
  });
}
monthly_expense_and_revenue();
//================================Group tour end==============================================//

//================================Package tour start==============================================//
function package_tour_monthly_weekly_report()
{
  var package_tour_montly_weekly_select = $('#package_tour_montly_weekly_select').val();	  
  $.post('admin/package_tour/monthly_weekly_tours.php', { package_tour_montly_weekly_select : package_tour_montly_weekly_select }, function(data){
  	$('.package_tour_monthly_weekly_bookings .body').html(data);
  });
}
package_tour_monthly_weekly_report();
//================================Package tour end==============================================//


$('#monthly_expnse_and_revenue_date').datetimepicker( { timepicker:false, format:'M-Y' } );

$('#dash_tour_overview_tour_id, #weekly_monthly_tour_id, #tourwise_id, #booking_id').select2();

(function($){
    $(window).on("load",function(){
        $(".dash_latest_events .body, .booking_weekly_monthly_report .body, .dash_upcoming_birthdays .body, .dash_followups .body, .dash_tour_overview_parent, .dash_latest_events, .package_tour_upcoming_tours .body, .package_tour_monthly_weekly_bookings .body").mCustomScrollbar();
    });
})(jQuery);