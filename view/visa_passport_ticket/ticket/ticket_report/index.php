<?php
include "../../../../model/model.php";
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$branch_status = $_POST['branch_status'];
?>
<div class="row mg_bt_20">
	<div class="col-md-12 text-right">
		<button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 mg_bt_10">
			        <select name="cust_type_filter" id="cust_type_filter"  style="width:100%" onchange="dynamic_customer_load(this.value,'company_filter');company_name_reflect();" title="Customer Type">
			            <?php get_customer_type_dropdown(); ?>
			        </select>
		</div>
	    <div id="company_div" class="hidden">
		</div>
		<div class="col-md-3 mg_bt_10" id="customer_div">    
	    </div> 
		<div class="col-md-3 mg_bt_10">
			<select name="ticket_id_filter" id="ticket_id_filter" style="width:100%" title="Booking ID">
		        <option value="">Booking ID</option>
		         <?php  $query = "select * from ticket_master where 1 ";
		        include "../../../../model/app_settings/branchwise_filteration.php";
		        $query .= " order by ticket_id desc ";
		        $sq_ticket = mysql_query($query);
		        while($row_ticket = mysql_fetch_assoc($sq_ticket)){

		        	$date = $row_ticket['created_at'];
                      $yr = explode("-", $date);
                      $year =$yr[0];
		          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
		          ?>
		          <option value="<?= $row_ticket['ticket_id'] ?>"><?= get_ticket_booking_id($row_ticket['ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
		          <?php
		        }
		        ?>
		    </select>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-center">
			<button class="btn btn-sm btn-info ico_right" onclick="ticket_report_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>

<div id="div_ticket_report_list" class="main_block loader_parent"></div>

<script>
	$('#customer_id_filter, #ticket_id_filter,#cust_type_filter').select2();
	dynamic_customer_load('','');
	function ticket_report_list_reflect()
	{
		$('#div_ticket_report_list').append('<div class="loader"></div>');
		var customer_id = $('#customer_id_filter').val();
		var ticket_id = $('#ticket_id_filter').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();
		$.post('ticket_report/ticket_report_list_reflect.php', { customer_id : customer_id, ticket_id : ticket_id , cust_type : cust_type, company_name : company_name , branch_status : branch_status }, function(data){
			$('#div_ticket_report_list').html(data);
		});
	}
	ticket_report_list_reflect();
	function excel_report()
	{
		var customer_id = $('#customer_id_filter').val()
		var ticket_id = $('#ticket_id_filter').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();
		window.location = 'ticket_report/excel_report.php?customer_id='+customer_id+'&ticket_id='+ticket_id+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
	}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>