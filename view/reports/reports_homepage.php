<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='reports/reports_homepage.php'"));
$branch_status = $sq['branch_status'];

?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<?= begin_panel('Tour Reports',95) ?> <span style="font-size: 15px;font-weight: 400;color: #006d6d;margin-left: 15px;" id="span_report_name"></span>

<div class="report_menu main_block">
    <div class="row">
      <div class="col-xs-12">
        <nav class="navbar navbar-default">
          <div class="container-fluid">
          <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <!-- Menu start -->
              <ul class="nav navbar-nav">

                <!-- Single Menu start -->
                <li class="dropdown">
                  <a href="#">Tour Summary <span class="caret"></span></a>
                  <ul class="dropdown_menu no-pad">
                    <li><span onclick="show_report_reflect('Complete Tour Summary')">Complete Tour Summary</span></li>
                    <li><span onclick="show_report_reflect('Airline Supplier Balance')">Airline Supplier Balance</span></li>
                    <li><span onclick="show_report_reflect('Visa Supplier Balance')">Visa Supplier Balance</span></li>
                  </ul>
                </li>
                <!-- Single Menu end -->

                <!-- Single Menu start -->
                <li class="dropdown">
                  <a href="#">Group Tour <span class="caret"></span></a>
                  <ul class="dropdown_menu no-pad">
                    <li><span onclick="show_report_reflect('Passenger Details')">Passenger Details</span></li>
                    <li><span onclick="show_report_reflect('Room Allocation')">Room Allocation</span></li>
                    <li><span onclick="show_report_reflect('Payment Collection')">Payment Collection</span></li>
                    <li><span onclick="show_report_reflect('Complete Tour Cancel/Refund')">Complete Tour Cancel/Refund</span></li>
                    <li><span onclick="show_report_reflect('Traveller Cancel/Refund')">Traveller Cancel/Refund</span></li>
                    <li><span onclick="show_report_reflect('Itinerary And Gift')">Itinerary And Gift</span></li>
                    <li><span onclick="show_report_reflect('Repeater Tourist')">Repeater Tourist</span></li>
                    <li><span onclick="show_report_reflect('Tour Tickets')">Tour Tickets</span></li>
                  </ul>
                </li>
                <!-- Single Menu end -->
                
                <!-- Single Menu start -->
                <li class="dropdown">
                  <a href="#">Package Tour <span class="caret"></span></a>
                  <ul class="dropdown_menu no-pad">
                    <li><span onclick="show_report_reflect('Passenger Report')">Passenger Report</span></li>
                    <li><span onclick="show_report_reflect('Tour Refund')">Tour Refund</span></li>
                    <li><span onclick="show_report_reflect('Travel Tickets')">Travel Tickets</span></li>
                  </ul>
                </li>
                <!-- Single Menu end -->

              </ul>
            </div>
           </div>
        </nav>
       </div>
    </div>
</div>
    <!-- Main Menu End -->
    <div class="col-xs-12 mg_tp_20">
        <div id="div_report_content" class="main_block">
        </div>
    </div>

</div>
<?= end_panel() ?>
<script src="js/adnary.js"></script>

<script type="text/javascript">
$(function() {
    $("a").on("click", function() {
        if ($(this).parent('li').attr('class')=="dropdown active") {
          $("li.active").removeClass("active");
        }
        else{
          $("li.active").removeClass("active");
          $(this).parent('li').addClass("active");
        }
    });
});

$(function() {
    $("span").on("click", function() {
        $("li.active").removeClass("active");
        $(this).closest('li.dropdown').addClass("active");
    });
});


function show_report_reflect(report_name){
    $('#span_report_name').html(report_name);

    //Tour Report
    if(report_name=="Complete Tour Summary"){ url = 'filters/common_reports_filters.php'; } 
    if(report_name=="Airline Supplier Balance"){ url = 'reports_content/group_tour/display_airline_summary_report/supplier_complete_summary_report.php'; } 
    if(report_name=="Visa Supplier Balance"){ url = 'reports_content/group_tour/visa_supplier_balance/visa_topup_balance_display.php'; }

    //Group Report
    if(report_name=="Passenger Details"){ url = 'reports_content/group_tour/passanger_details_report/index.php'; }
    if(report_name=="Room Allocation"){ url = 'reports_content/group_tour/room_allocation_report/index.php'; }
    if(report_name=="Payment Collection"){ url = 'reports_content/group_tour/total_collection_report/index.php'; }
    if(report_name=="Complete Tour Cancel/Refund"){ url = 'reports_content/group_tour/refund_tour_cancelation_report/index.php'; }
    if(report_name=="Traveller Cancel/Refund"){ url = 'reports_content/group_tour/refund_cancelled_traveler_report/index.php'; }
    if(report_name=="Itinerary And Gift"){ url = 'reports_content/group_tour/adnary_and_gift_handover_report/index.php'; }
    if(report_name=="Repeater Tourist"){ url = 'reports_content/group_tour/repeater_tourist_report/index.php'; }
    if(report_name=="Tour Tickets"){ url = 'reports_content/group_tour/booking_tickets/index.php'; }

    //FIT Report
    if(report_name=="Passenger Report"){ url = 'reports_content/package_tour/tourwise_report/index.php'; }
    if(report_name=="Tour Refund"){ url = 'reports_content/package_tour/refund_report/index.php'; }
    if(report_name=="Travel Tickets"){ url = 'reports_content/package_tour/booking_tickets/index.php'; }

    $.post(url,{}, function(data){
        $(".dropdown_menu").addClass('hidden');
        $("li.active").removeClass("active");
        $('#div_report_content').html(data);
        setTimeout(
          function(){
            $(".dropdown_menu").removeClass('hidden'); 
          }, 500); 
    });
}
show_report_reflect('Complete Tour Summary');

</script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php');
?>