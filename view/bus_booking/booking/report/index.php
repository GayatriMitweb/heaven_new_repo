<?php

include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>

<div class="row mg_bt_20">

	<div class="col-xs-12 text-right">

		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>

	</div>

</div>



<div class="app_panel_content Filter-panel">

	<div class="row">

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

		        <select name="cust_type_filter" id="cust_type_filter" style="width:100%" onchange="dynamic_customer_load(this.value,'company_filter');company_name_reflect();" title="Customer Type">

		            <?php get_customer_type_dropdown(); ?>
		            
		            
					
                    

		        </select>

	    </div>

	    <div  id="company_div" class="hidden">

		</div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10" id="customer_div">    

	    </div> 

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<select name="booking_id_filter" id="booking_id_filter" style="width:100%" title="Booking ID">

		        	<?php   get_bus_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id) ?>

		    </select>

		</div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

				<input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date">

		</div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date">

		</div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>

</div>





<div id="div_modal"></div>

<div id="div_content" class="main_block"></div>



<script>

$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#customer_id_filter, #booking_id_filter,#cust_type_filter').select2();

dynamic_customer_load('','');

function list_reflect()

{

	var customer_id = $('#customer_id_filter').val();

	var booking_id = $('#booking_id_filter').val();

	var from_date = $('#from_date_filter').val();

	var to_date = $('#to_date_filter').val();

	var cust_type = $('#cust_type_filter').val();

	var company_name = $('#company_filter').val();

	var branch_status = $('#branch_status').val();
 

	$.post('report/list_reflect.php', { customer_id : customer_id, booking_id : booking_id, from_date : from_date, to_date : to_date, cust_type : cust_type, company_name : company_name , branch_status : branch_status  }, function(data){

		$('#div_content').html(data);

	});

}

function excel_report()

	{

		var customer_id = $('#customer_id_filter').val();

		var booking_id = $('#booking_id_filter').val();

		var from_date = $('#from_date_filter').val();

		var to_date = $('#to_date_filter').val();

		var cust_type = $('#cust_type_filter').val();

		var company_name = $('#company_filter').val();

		var branch_status = $('#branch_status').val();

		window.location = 'report/excel_report.php?customer_id='+customer_id+'&booking_id='+booking_id+'&from_date='+from_date+'&to_date='+to_date+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;

	}

list_reflect();



</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>