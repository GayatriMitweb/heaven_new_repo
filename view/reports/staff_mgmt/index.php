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
<?= begin_panel('HR Reports',97) ?> <span style="font-size: 15px;font-weight: 400;color: #006d6d;margin-left: 15px;" id="span_report_name"></span>
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
                <li onclick="show_report_reflect('Daily Activities')"><a href="#">Daily Activities</a></li>
                <li onclick="show_report_reflect('User Attendance')"><a href="#">User Attendance</a></li>
                <li onclick="show_report_reflect('User Salary')"><a href="#">User Salary</a></li>
                <li onclick="show_report_reflect('User Performance')"><a href="#">User Performance</a></li>
                <li onclick="show_report_reflect('Followup Update')"><a href="#">Followup Update</a></li>
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

<script src="js/reports.js"></script>
<script src="js/reports_filters.js"></script>
<script src="js/adnary.js"></script>

<script type="text/javascript">
function show_sub_menu(sub_menu_id){
    $('.dropdown_menu_two').slideUp();
    $('#'+sub_menu_id).slideDown(); 
}

function show_report_reflect(report_name){
    $('#span_report_name').html(report_name);

    //Revenue & Expense
    if(report_name=="Daily Activities"){ url = 'report_reflect/daily_activity_report/index.php?branch_status=<?= $branch_status ?>'; }
    if(report_name=="User Attendance"){ url = 'report_reflect/emp_attendance/index.php?branch_status=<?= $branch_status ?>'; }
    if(report_name=="User Salary"){ url = 'report_reflect/emp_salary/index.php?branch_status=<?= $branch_status ?>'; }
    if(report_name=="User Performance"){ url = 'report_reflect/emp_performance/index.php?branch_status=<?= $branch_status ?>'; }
    if(report_name=="Followup Update"){ url = 'report_reflect/followup_update/index.php?branch_status=<?= $branch_status ?>'; }

    $.post(url,{}, function(data){
        $('#div_report_content').html(data);
    });
}
show_report_reflect('Daily Activities');

</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php');
?>