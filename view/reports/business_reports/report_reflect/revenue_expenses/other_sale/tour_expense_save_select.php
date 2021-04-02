<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6">
			<select style="width:100%" id="sale_type" name="sale_type" class="form-control" title="Select Sale" onchange="tour_expense_save_reflect();get_widget();"> 
		    	<option value="Visa">Visa</option>     
		    	<option value="Flight Ticket">Flight</option>
		    	<option value="Train Ticket">Train</option>
		    	<option value="Hotel">Hotel</option>     
		    	<option value="Bus">Bus</option>
		    	<option value="Car Rental">Car Rental</option>
		    	<option value="Passport">Passport</option>
		    	<option value="Forex">Forex</option>
		    	<option value="Excursion">Activity</option>
		    	<option value="Miscellaneous">Miscellaneous</option>		    	
		    </select>
		</div>
		<div class="col-md-9 col-sm-12 text-right">
			<button class="btn btn-excel btn-sm mg_bt_10_sm_xs" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		</div>
	</div>

</div>
<div id="div_other_tour_reflect" class="main_block mg_tp_10"></div>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="other_report" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<script>
$('#sale_type').select2();
	function excel_report(){
		var sale_type = $('#sale_type').val();
		var base_url = $('#base_url').val();
		if(sale_type==""){
			error_msg_alert("Select Sale Type");
			return false;
		}
		window.location = base_url+'view/reports/business_reports/report_reflect/revenue_expenses/other_sale/excel_report.php?sale_type='+sale_type;
	}
	var column = [
	{ title : "S_No."},
	{ title:"Booking_ID", className:"text-center"},
	{ title : "Booking_date"},
	{ title : "User_Name"},
	{ title : "Sale_amount"},
	{ title : "Supplier_type"},
	{ title : "Supplier_name"},
	{ title : "Purchase_amount"},
	{ title : "Profit/Loss(%)"}	
];

	function tour_expense_save_reflect(){
		var sale_type = $('#sale_type').val();
		var base_url = $('#base_url').val();

		if(sale_type==""){
			error_msg_alert("Select Sale");
			return false;
		}

		$.post(base_url+'view/reports/business_reports/report_reflect/revenue_expenses/other_sale/get_sale_purchase_summary.php', { sale_type : sale_type }, function(data){
			pagination_load(data, column, true, false, 20, 'other_report');
		});
	}
	tour_expense_save_reflect('Visa');
	
	function get_widget(){
		var sale_type = $('#sale_type').val();
		var base_url = $('#base_url').val();

		if(sale_type==""){
			error_msg_alert("Select Sale");
			return false;
		}

		$.post(base_url+'view/reports/business_reports/report_reflect/revenue_expenses/other_sale/tour_expense_save_reflect.php', { sale_type : sale_type }, function(data){
			$('#div_other_tour_reflect').html(data);
		});
	}
	get_widget('Visa');
</script>

