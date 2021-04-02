<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>
<div class="row text-right mg_bt_20">
	<div class="col-md-12">
		<button class="btn btn-excel" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
		        <select name="cust_type_filter" id="cust_type_filter" style="width:100%" onchange="dynamic_customer_load(this.value,'company_filter');company_name_reflect();" title="Customer Type">
		            <?php get_customer_type_dropdown(); ?>
		            
		            
					
                    

		        </select>
	    </div>
	    <div id="company_div" class="hidden">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10" id="customer_div">    
	    </div> 
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="train_ticket_id_filter" id="train_ticket_id_filter" style="width:100%" title="Booking ID">
		        <option value="">Booking ID</option>
		        <?php 
		        $query = "select * from train_ticket_master where 1 ";
		        include "../../../../model/app_settings/branchwise_filteration.php";
		        $query .= " order by train_ticket_id desc ";
		        $sq_ticket = mysql_query($query);
		        while($row_ticket = mysql_fetch_assoc($sq_ticket)){


	        	  $date = $row_ticket['created_at'];
                  $yr = explode("-", $date);
                  $year =$yr[0];
		          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
		          ?>
		          <option value="<?= $row_ticket['train_ticket_id'] ?>"><?= get_train_ticket_booking_id($row_ticket['train_ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
		          <?php
		        }
		        ?>
		    </select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" title="From Date">
		</div> 
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" title="To Date" onchange="validate_validDate('from_date','to_date');">
		</div> 
		<div class="col-md-3 col-sm-6 col-xs-12">
			<button class="btn btn-sm btn-info ico_right" onclick="train_trip_report_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>


<div id="div_train_trip_report_list" class="main_block"></div>

<script>
	$('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
	$('#customer_id_filter, #train_ticket_id_filter,#cust_type_filter').select2();
	dynamic_customer_load('','');
	function train_trip_report_list_reflect()
	{
		var customer_id = $('#customer_id_filter').val();
		var train_ticket_id = $('#train_ticket_id_filter').val();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();
		
		$.post('trip_report/trip_report_list_reflect.php', { customer_id : customer_id, train_ticket_id : train_ticket_id,from_date : from_date, to_date : to_date , cust_type : cust_type, company_name : company_name, branch_status : branch_status}, function(data){
			$('#div_train_trip_report_list').html(data);
		});
	}
	function excel_report()
		{
			var customer_id = $('#customer_id_filter').val();
			var train_ticket_id = $('#train_ticket_id_filter').val();
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			var cust_type = $('#cust_type_filter').val();
			var company_name = $('#company_filter').val();
			var branch_status = $('#branch_status').val();

			window.location = 'trip_report/excel_report.php?customer_id='+customer_id+'&train_ticket_id='+train_ticket_id+'&from_date='+from_date+'&to_date='+to_date+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
		}
	train_trip_report_list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>