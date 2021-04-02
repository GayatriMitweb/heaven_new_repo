 <?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='reports/reports_homepage.php'"));
$branch_status = $sq['branch_status'];

?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<?= begin_panel('Business Reports',96) ?> <span style="font-size: 15px;font-weight: 400;color: #006d6d;margin-left: 15px;" id="span_report_name"></span>

<div class="report_menu main_block">
    <div class="row">
      <div class="col-xs-12">
        <nav class="navbar navbar-default">
          <div class="container-fluid">
          <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <!-- Menu start -->
              <ul class="nav navbar-nav">
              <li class="dropdown">
                  <a href="#">Business Reports <span class="caret"></span></a>
                  <ul class="dropdown_menu no-pad">

                  <li class="dropdown_two">
                    <span onclick="show_sub_menu('sub_menu_1')">Gross Sale</span>
	                    <ul class="dropdown_menu_two" id="sub_menu_1">
                          <li><span onclick="show_report_reflect('Gross sale summary')">Summary</span></li>
	                        <li><span onclick="show_report_reflect('Gross sale details')">Details</span></li>
                      </ul>
                    </li>
                    <!-- <li><span onclick="show_report_reflect('Group Tour')">Gross Sale</span></li> -->
                    <li><span onclick="show_report_reflect('Refund Gross')">Refund Gross</span></li>
                    <li><span onclick="show_report_reflect('Sale Net')">Sale Net</span></li>
                    <li><span onclick="show_report_reflect('Debit Possition')">Debit Possition</span></li>
                    <li><span onclick="show_report_reflect('Consolidated Report')">Consolidated Report</span></li>
                   
                    <li><span onclick="show_report_reflect('Comparative Hotels')">Comparative Hotels</span></li>
                    <li><span onclick="show_report_reflect('Comparative Income')">Comparative Income</span></li>
                    <li><span onclick="show_report_reflect('Comparative Liabilities')">Comparative Liabilities</span></li>
                    <li><span onclick="show_report_reflect('Comparative Misc.')">Comparative Misc.</span></li>
                  </ul>
                </li>
                <!-- Single Menu start -->
                <li class="dropdown">
                  <a href="#">Revenue & Expenses <span class="caret"></span></a>
                  <ul class="dropdown_menu no-pad">
                    <li><span onclick="show_report_reflect('Group Tour')">Group Tour</span></li>
                    <li><span onclick="show_report_reflect('Package Tour')">Package Tour</span></li>
                    <li><span onclick="show_report_reflect('Other Sale')">Other Sale</span></li>
                  </ul>
                </li>
                <!-- Single Menu end -->

                
                <!-- Single Menu start -->
                <li class="dropdown">
                  <a href="#">Sales Forecast <span class="caret"></span></a>
                  <ul class="dropdown_menu no-pad">
                    <li><span onclick="show_report_reflect('Sales Projection')">Sales Forecast</span></li>
                    <li><span onclick="show_report_reflect('Budgeted Vs. Actuals')">Budgeted Vs. Actuals</span></li>
                    <li><span onclick="show_report_reflect('Root Cause Analysis')">Root Cause Analysis</span></li>
                  </ul>
                </li>
                <!-- Single Menu end -->

                <!-- Single Menu start -->
                <li onclick="show_report_reflect('Customer Feedback')"><a href="#">Customer Feedback</a></li>
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
 <script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script src="../js/adnary.js"></script>

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
function show_sub_menu(sub_menu_id){
	$('.dropdown_menu_two').slideUp('slow');
	$('.dropdown_menu_three').slideUp('slow');
	if($('#'+sub_menu_id).css('display') == 'none')
	{
		$('#'+sub_menu_id).slideDown('slow'); 
	}
	else{
		$('#'+sub_menu_id).slideUp('slow'); 
	}
}
function show_report_reflect(report_name){
    $('#span_report_name').html(report_name);

    //Revenue & Expense
    if(report_name=="Group Tour"){ url = 'report_reflect/revenue_expenses/group_tour/tour_expense_save_select.php?branch_status=<?= $branch_status ?>'; }
    if(report_name=="Package Tour"){ url = 'report_reflect/revenue_expenses/package_tour/package_tour_expense_select.php?branch_status=<?= $branch_status ?>'; }
    if(report_name=="Other Sale"){ url = 'report_reflect/revenue_expenses/other_sale/tour_expense_save_select.php?branch_status=<?= $branch_status ?>'; }

    if(report_name=="Sales Projection"){ url = 'report_reflect/sales_projection/projection/index.php?branch_status=<?= $branch_status ?>'; }
    if(report_name=="Budgeted Vs. Actuals"){ url = 'report_reflect/sales_projection/budget/index.php?branch_status=<?= $branch_status ?>'; }
    if(report_name=="Root Cause Analysis"){ url = 'report_reflect/sales_projection/analysis/index.php?branch_status=<?= $branch_status ?>'; }

    if(report_name=="Customer Feedback"){ url = 'report_reflect/customer_feedback/index.php?branch_status=<?= $branch_status ?>'; }
 
    if(report_name =="Gross sale summary"){ url = 'report_reflect/gross_sale/gross_sale_summary/index.php'}
    if(report_name =="Gross sale details"){ url = 'report_reflect/gross_sale/gross_sale_detailed/index.php'}
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
show_report_reflect('Group Tour');

</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php');
?>