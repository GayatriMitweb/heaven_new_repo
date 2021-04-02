<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='finance_master/reports/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Account Reports',98) ?> <span style="font-size: 15px;font-weight: 400;color: #006d6d;margin-left: 15px;" id="span_report_name"></span>

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
                      <a href="#">Financial <span class="caret"></span></a>
                      <ul class="dropdown_menu no-pad">
                        <li><span onclick="show_report_reflect('Profit & Loss')">Profit & Loss</span></li>
                        <li><span onclick="show_report_reflect('Balance Sheet')">Balance Sheet</span></li>
                        <li><span onclick="show_report_reflect('Cash Flow Projections')">Cash Flow Projections</span></li>
                        <li><span onclick="show_report_reflect('Trial Balance')">Trial Balance</span></li>
                      </ul>
                    </li>
                    <!-- Single Menu end -->

                    <!-- Single Menu start -->
                    <li class="dropdown">
                        <a href="#">Taxation <span class="caret"></span></a>
                        <ul class="dropdown_menu no-pad">
                      		<!-- Sub Menu dropdown Start -->
	                        <li class="dropdown_two">
	                          <span onclick="show_sub_menu('sub_menu_1')">Tax Reports</span>
	                          <ul class="dropdown_menu_two" id="sub_menu_1">
	                            <li><span onclick="show_report_reflect('ITC Report')">ITC Report</span></li>
	                            <li><span onclick="show_report_reflect('Tax on Sales')">Tax on Sales</span></li>
	                            <li class="dropdown_three">
	                            	<span onclick="show_third_level_menu('third_level_menu_1')">Tax on Cancellation</span>
	                            	<ul class="dropdown_menu_three" id="third_level_menu_1">
			                           <li><span onclick="show_report_reflect('Tax on Sale Cancel')">Tax on Sale Cancel</span></li>
			                           <li><span onclick="show_report_reflect('Tax on Purchase Cancel')">Tax on Purchase Cancel</span></li>
			                        </ul>
	                            </li>
	                          </ul>
	                        </li>
	                        <!-- Sub Menu dropdown End -->
	                        <!-- Sub Menu dropdown Start -->
	                        <li class="dropdown_two">
	                          <span onclick="show_sub_menu('sub_menu_2')">TDS Reports</span>
	                          <ul class="dropdown_menu_two" id="sub_menu_2">
	                            <li><span onclick="show_report_reflect('TDS Receivable')">TDS Receivable</span></li>
	                            <li><span onclick="show_report_reflect('TDS Payable')">TDS Payable</span></li>
	                          </ul>
	                        </li>
	                        <!-- Sub Menu dropdown End -->
	                        <!-- Sub Menu dropdown Start -->
	                        <li class="dropdown_two">
	                          <span onclick="show_sub_menu('sub_menu_3')">Labour Law Taxes</span>
	                          <ul class="dropdown_menu_two" id="sub_menu_3">
	                            <li><span onclick="show_report_reflect('Provident Fund Payable')">Provident Fund Payable</span></li>
	                            <li><span onclick="show_report_reflect('ESIC Payable')">ESIC Payable</span></li>
	                            <li><span onclick="show_report_reflect('PT Payable')">PT Payable</span></li>
	                            <li><span onclick="show_report_reflect('Other Compliances')">Other Compliances</span></li>
	                          </ul>
	                        </li>
	                        <!-- Sub Menu dropdown End -->
	                        <!-- Sub Menu dropdown Start -->
	                        <!-- <li class="dropdown_two">
	                          <span onclick="show_sub_menu('sub_menu_4')">VAT Reports</span>
	                          <ul class="dropdown_menu_two" id="sub_menu_4">
	                            <li><span onclick="show_report_reflect('VAT Receivable')">VAT Receivable</span></li>
	                            <li><span onclick="show_report_reflect('VAT Payable')">VAT Payable</span></li>
	                          </ul>
	                        </li> -->
	                        <!-- Sub Menu dropdown End -->
                        </ul>
                    </li>
                    <!-- Single Menu End -->

					<!-- Single Menu start -->
                    <li class="dropdown">
                      <a href="#">Statistics <span class="caret"></span></a>
                      <ul class="dropdown_menu no-pad">
                        <li><span onclick="show_report_reflect('Ratio Analysis')">Ratio Analysis</span></li>
                        <li><span onclick="show_report_reflect('Receivables Ageing')">Receivables Ageing</span></li>
                        <li><span onclick="show_report_reflect('Payables Ageing')">Payables Ageing</span></li>
                        <!-- Sub Menu dropdown Start -->
                        <li class="dropdown_two">
                          <span onclick="show_sub_menu('sub_menu_5')">Exception Report</span>
                          <ul class="dropdown_menu_two" id="sub_menu_5">
                            <li><span onclick="show_report_reflect('Negative Ledgers')">Negative Ledgers</span></li>
                            <li><span onclick="show_report_reflect('Overdue Receivables')">Overdue Receivables</span></li>
                            <li><span onclick="show_report_reflect('Overdue Payables')">Overdue Payables</span></li>
                          </ul>
                        </li>
                        <!-- Sub Menu dropdown End -->
                      </ul>
                    </li>
                    <!-- Single Menu end -->

					<!-- Single Menu start -->
                    <li class="dropdown">
                      <a href="#">Registers <span class="caret"></span></a>
                      <ul class="dropdown_menu no-pad">
                        <li><span onclick="show_report_reflect('Day Book')">Day Book</span></li>
                        <li><span onclick="show_report_reflect('Sales Register')">Sales Register</span></li>
                        <li><span onclick="show_report_reflect('Purchase Register')">Purchase Register</span></li>
                        <li><span onclick="show_report_reflect('Debit Note')">Debit Note</span></li>
                        <li><span onclick="show_report_reflect('Credit Note')">Credit Note</span></li>
                        <li><span onclick="show_report_reflect('List of Accounts')">List of Accounts</span></li>
                        <li><span onclick="show_report_reflect('Fixed Asset Register')">Fixed Asset Register</span></li>
                        <li><span onclick="show_report_reflect('Bank Book')">Bank Book</span></li>
                        <li><span onclick="show_report_reflect('Cash Book')">Cash Book</span></li>
                      </ul>
                    </li>
                    <!-- Single Menu end -->

                    <!-- Single Menu start -->
                    <li class="dropdown">
                      <a href="#">Reconciliation <span class="caret"></span></a>
                      <ul class="dropdown_menu no-pad">
                        <li><span onclick="show_report_reflect('Cash Reconciliation')">Cash Reconciliation</span></li>
                        <li><span onclick="show_report_reflect('Bank Reconciliation')">Bank Reconciliation</span></li>
                      </ul>
                    </li>
                    <!-- Single Menu end -->

                  </ul>
                  <!-- Menu End -->
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
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
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>

<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>

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

function show_third_level_menu(thrid_level_menu_id){
	$('#'+thrid_level_menu_id).slideToggle('slow'); 
}

function show_report_reflect(report_name){
	$('#span_report_name').html(report_name);
	//Finance Reports
	if(report_name=="Balance Sheet"){ url = 'balance_sheet/index.php'; }
	if(report_name=="Profit & Loss"){ url = 'profit_and_loss/index.php'; }
	if(report_name=="Cash Flow Projections"){ url = 'cash_flow/index.php'; }
	if(report_name=="Trial Balance"){ url = 'trail_balance/index.php'; }

	//Taxation Reports
	if(report_name=="ITC Report"){ url = 'taxation_reports/itc_report/index.php?branch_status=<?= $branch_status ?>'; }
  	if(report_name=="Tax on Sales"){ url = 'taxation_reports/gst_sale/index.php?branch_status=<?= $branch_status ?>'; }
  	
  	if(report_name=="Tax on Sale Cancel"){ url = 'taxation_reports/gst_cancel/sale/index.php?branch_status=<?= $branch_status ?>'; }
  	if(report_name=="Tax on Purchase Cancel"){ url = 'taxation_reports/gst_cancel/purchase/index.php?branch_status=<?= $branch_status ?>'; }

	if(report_name=="TDS Receivable"){ url = 'taxation_reports/tds_report/index.php'; }
	if(report_name=="TDS Payable"){ url = 'taxation_reports/tds_payable_report/index.php';}

  	if(report_name=="Provident Fund Payable"){ url = 'taxation_reports/pro_fund_pay/index.php?branch_status=<?= $branch_status ?>'; }
  	if(report_name=="ESIC Payable"){ url = 'taxation_reports/esic_pay/index.php?branch_status=<?= $branch_status ?>'; }
  	if(report_name=="PT Payable"){ url = 'taxation_reports/pt_pay/index.php?branch_status=<?= $branch_status ?>'; }
  	if(report_name=="Other Compliances"){ url = 'taxation_reports/other_comp/index.php?branch_status=<?= $branch_status ?>'; }

  	if(report_name=="VAT Receivable"){ url = 'taxation_reports/vat_receivable_report/index.php'; }
	if(report_name=="VAT Payable"){ url = 'taxation_reports/vat_payable_report/index.php';}

  	//Statistics Reports
  	if(report_name=="Ratio Analysis"){ url = 'ratio_analysis/index.php?branch_status=<?= $branch_status ?>'; }
  	if(report_name=="Receivables Ageing"){ url = 'receivables_ageing/index.php?branch_status=<?= $branch_status ?>'; }
  	if(report_name=="Payables Ageing"){ url = 'payable_ageing/index.php?branch_status=<?= $branch_status ?>'; }
	
	if(report_name=="Negative Ledgers"){ url = 'exception_report/negative_ledgers/index.php'; }
	if(report_name=="Overdue Receivables"){ url = 'exception_report/overdue_receivables/index.php'; }
	if(report_name=="Overdue Payables"){ url = 'exception_report/overdue_payables/index.php'; }

	//Registers
	if(report_name=="Day Book"){ url = 'day_book/index.php?branch_status=<?= $branch_status ?>'; }
  	if(report_name=="Sales Register"){ url = 'sales_register/index.php?branch_status=<?= $branch_status ?>'; }
  	if(report_name=="Purchase Register"){ url = 'purchase_register/index.php?branch_status=<?= $branch_status ?>'; }
    if(report_name=="Debit Note"){ url = 'debit_note/index.php?branch_status=<?= $branch_status ?>'; }
    if(report_name=="Credit Note"){ url = 'credit_note/index.php?branch_status=<?= $branch_status ?>'; }
  	if(report_name=="List of Accounts"){ url = 'list_of_account/index.php?branch_status=<?= $branch_status ?>'; }
    if(report_name=="Bank Book"){ url = 'bank_book/index.php?branch_status=<?= $branch_status ?>'; }
    if(report_name=="Cash Book"){ url = 'cash_book/index.php?branch_status=<?= $branch_status ?>'; }

  	//Others
  	if(report_name=="Bank Reconciliation"){ url = 'bank_reconcilation/index.php'; }
  	if(report_name=="Cash Reconciliation"){ url = 'cash_reconcilation/index.php'; }
  	if(report_name=="Fixed Asset Register"){ url = 'far/index.php'; }

	$.post('report_reflect/'+url,{}, function(data){
        $(".dropdown_menu").addClass('hidden');
        $("li.active").removeClass("active");
		    $('#div_report_content').html(data);
        setTimeout(
          function(){
            $(".dropdown_menu").removeClass('hidden'); 
          }, 500);
	});
}
show_report_reflect('Profit & Loss');

</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>