<?php
include "../../model/model.php";
/*======******Header******=======*/

require_once('../layouts/admin_header.php');

$start_date = date('01-m-Y');
$end_date = date('t-m-Y');

$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];

$branch_status = $_POST['branch_status'];

$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='booker_incentive/booker_incentive.php'"));
$branch_status = $sq['branch_status'];
 
?>
<?= begin_panel('Incentive/Commission dashboard',84) ?>
<div class="row mg_bt_10">
	<div class="col-md-12 text-right">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>
<div class="app_panel_content Filter-panel">

	<div class="row">

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

				<select name="tour_type" id="tour_type" class="form-control" title="Tour Type" style="width: 100%;" onchange="booking_list_reflect()" title="Tour Type">
					<option value="">Tour Type</option>
					<option value="Group Tour">Group Tour</option>
					<option value="Package Tour">Package Tour</option>
				</select>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
				<select name="emp_id" id="emp_id1" onchange="booking_list_reflect()" class="form-control" style="width: 100%;" title="Select User" title="Sales User">
					<option value="">Select User</option>
					<?php 
					if($role=='B2b'){
						$sq_booker = mysql_query("select emp_id, first_name, last_name from emp_master where role_id='4' and emp_id='$emp_id' and active_flag='Active'");	
					}
					elseif($role=='Branch Admin' && $branch_status=='yes')
					{
						$sq_booker = mysql_query("select emp_id, first_name, last_name from emp_master where role_id !='1' and active_flag='Active' and branch_id='$branch_admin_id' order by first_name");
					}
					elseif($role=='Admin')
					{
						$sq_booker = mysql_query("select emp_id, first_name, last_name from emp_master where role_id !='1' and active_flag='Active' order by first_name");
					}
					while($row_booker = mysql_fetch_assoc($sq_booker)){
						?>
						<option value="<?= $row_booker['emp_id'] ?>"><?= $row_booker['first_name'].' '.$row_booker['last_name'] ?></option>
						<?php
					}
					?>
				</select>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
				<input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" title="From Date" onchange="booking_list_reflect()">

			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">

				<input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" title="To Date" onchange="booking_list_reflect()">
				<input type="hidden" name="branch_status" id="branch_status" value="<?= $branch_status?>">
			</div>

	</div>

</div>		
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	<table id="sales_incentive" class="table table-hover" style="margin: 20px 0 !important;">         
	</table>
</div></div></div>
</div>
<div id="div_booker_incentive_reflect" class="main_block loader_parent">
<div id="div_incentive_save_popup"></div>
	

</div>
<style>
.action_width{
	width : 250px;
}
</style>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
	$('#emp_id1').select2();
	$('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
	var column = [
	{ title : "S_No."},
	{ title:"User_Name", className:"text-center"},
	{ title : "Tour_Type"},
	{ title : "Booking_id"},
	{ title : "Tour_Name"},
	{ title : "Tour_Date"},
	{ title : "Booking_Date"},
	{ title : "Booking_Amount"},
	{ title : "Purchase_Amount"},
	{ title : "Profit/Loss"},
	{ title : "Incentive"},
	<?php if($role== 'Admin' || $role=='Branch Admin'){ ?>
	{ title : "&nbsp;&nbsp;&nbsp;&nbsp;Actions", className:"text-center action_width"}
	<?php } ?>
	];
	function booking_list_reflect()
	{
		$('#div_booker_incentive_reflect').append('<div class="loader"></div>');
		var tour_type = $('#tour_type').val();
		var emp_id = $('#emp_id1').val();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var branch_status = $('#branch_status').val();
		
		$.post('booking_list_reflect.php', { tour_type : tour_type, emp_id : emp_id, from_date : from_date, to_date : to_date , branch_status : branch_status}, function(data){
			pagination_load(data, column, true, true, 20, 'sales_incentive');
			$('.loader').remove();
		});
	}

	booking_list_reflect();



	function incentive_calculate(basic_amount, tds, total_id)
	{
		var basic_amount = $('#'+basic_amount).val();
		var tds = $('#'+tds).val();

		if(basic_amount==""){ basic_amount = 0; }
		if(tds==""){ tds = 0; }
		var tds = (parseFloat(basic_amount)/100)*parseFloat(tds);
		var total = parseFloat(basic_amount)-parseFloat(tds);
		var total1 = total.toFixed(2);
		
		$('#'+total_id).val(total1);
	}
	function excel_report()
	{
		var customer_id = $('#customer_id_filter').val()
		var booking_id = $('#package_id_filter').val()
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var cust_type = $('#cust_type_filter').val();
		
		var base_url = $('#base_url').val();
		var branch_status = $('#branch_status').val();
		window.location = base_url+'view/package_booking/summary/excel_report.php?customer_id='+customer_id+'&booking_id='+booking_id+'&from_date='+from_date+'&to_date='+to_date+'&cust_type='+cust_type+'&company_name='+company_name+'&booker_id='+booker_id+'&branch_id='+branch_id+'&branch_status='+branch_status;
	}
		
	function incentive_save_modal(booking_id, emp_id,purchase)
	{
		
		$.post('package_tour_incentive_save_modal.php', { booking_id : booking_id, emp_id : emp_id,purchase:purchase }, function(data){
			$('#div_incentive_save_popup').html(data);	
		});
	}
	function incentive_edit_modal(booking_id, emp_id,booking_type)
	{
		$.post('package_tour_incentive_edit_modal.php', { booking_id : booking_id, emp_id : emp_id,booking_type:booking_type }, function(data){
			$('#div_incentive_save_popup').html(data);	
		});
	}
	function add_incentive(ele, booking_id,emp_id,purchase,booking_amt){

		var base_url = $('#base_url').val();
		
		$.post('get_incentive_basic_amount.php', { booking_id : booking_id, emp_id : emp_id, purchase:purchase}, function(data){    
				var basic_amount = data;
				
				$.ajax({
					type:'post',
					url: base_url+'controller/booker_incentive/package_tour_incentive_save.php',
					data:{ booking_id : booking_id, emp_id : emp_id, basic_amount : basic_amount },
					success:function(result){
						alert(result);
					}
				});
			});
			
		
	}

$(function () {
	$("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>


<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>