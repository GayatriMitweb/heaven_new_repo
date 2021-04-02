<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
?>
<div class="row mg_bt_20">
	<div class="col-md-12 text-right">
	   <button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
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
			<select name="visa_id_filter" id="visa_id_filter" style="width:100%" title="Booking ID">
		        <option value="">Booking ID</option>
		        <?php 
		        $query = "select * from miscellaneous_master where 1";
	            include "../../../model/app_settings/branchwise_filteration.php";
	            $query .= " order by misc_id desc";
	            $sq_visa = mysql_query($query);
		        while($row_visa = mysql_fetch_assoc($sq_visa)){

		        $date = $row_visa['created_at'];
				      $yr = explode("-", $date);
				      $year =$yr[0];
		          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_visa[customer_id]'"));
		          ?>
		          <option value="<?= $row_visa['misc_id'] ?>"><?= get_misc_booking_id($row_visa['misc_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
		          <?php
		        }
		        ?>
		    </select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" title="From Date" onchange="validate_issueDate('from_date', 'to_date')">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" title="To Date" onchange="validate_issueDate('from_date', 'to_date')">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<button class="btn btn-sm btn-info ico_right" onclick="visa_report_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>
<div id="div_visa_report_list" class="main_block loader_parent"></div>

<?php include('filter.php') ?>

<script>	
	if (typeof dynamic_customer_load === 'function') {
		dynamic_customer_load('','');
	}

	$('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
	$('#customer_id_filter, #visa_id_filter, #cust_type_filter').select2();
	function visa_report_list_reflect()
	{
		$('#div_visa_report_list').append('<div class="loader"></div>');
		var customer_id = $('#customer_id_filter').val();
		var misc_id = $('#visa_id_filter').val();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();
		$.post(base_url()+'view/miscellaneous/report/visa_report_list_reflect.php', { customer_id : customer_id, misc_id : misc_id, from_date : from_date, to_date : to_date, cust_type : cust_type, company_name : company_name, branch_status : branch_status  }, function(data){
			$('#div_visa_report_list').html(data);
		});
	}
	visa_report_list_reflect();
	
	function excel_report()
	{
		var customer_id = $('#customer_id_filter').val();
		var misc_id = $('#visa_id_filter').val();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();
		window.location = base_url()+'view/miscellaneous/report/excel_report.php?customer_id='+customer_id+'&misc_id='+misc_id+'&from_date='+from_date+'&to_date='+to_date+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
	}
	function validate_issueDate (from, to) {
	  var from_date = $('#'+from).val(); 
		var to_date = $('#'+to).val(); 

		var parts = from_date.split('-');
		var date = new Date();
		var new_month = parseInt(parts[1])-1;
		date.setFullYear(parts[2]);
		date.setDate(parts[0]);
		date.setMonth(new_month);

		var parts1 = to_date.split('-');
		var date1 = new Date();
		var new_month1 = parseInt(parts1[1])-1;
		date1.setFullYear(parts1[2]);
		date1.setDate(parts1[0]);
		date1.setMonth(new_month1);

		var one_day=1000*60*60*24;

		var from_date_ms = date.getTime();
		var to_date_ms = date1.getTime();

		if(from_date_ms>to_date_ms ){
		error_msg_alert(" From Date should be greater than To Date");
		$('#'+to).css({'border':'1px solid red'});  
			document.getElementById(to).value="";
			$('#'+to).focus();
			g_validate_status = false;
		return false;
    } 
  }
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>