<?php 
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/train_ticket/index.php'"));
$branch_status_r = $sq['branch_status'];
?>
<input type="hidden" id="branch_status_r" name="branch_status_r" value="<?= $branch_status_r ?>" >
<div class="row mg_bt_20">
	<div class="col-md-12 text-right">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
		        <select name="cust_type_filter" id="cust_type_filter" class="form-control" onchange="dynamic_customer_load(this.value,'company_filter');company_name_reflect();" title="Customer Type">
		            <?php get_customer_type_dropdown(); ?>
		            
		            
		            
                    
		        </select>
	    </div>
	    <div  id="company_div" class="hidden">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10" id="customer_div">    
	    </div> 
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
				<select name="train_ticket_id_filter" id="train_ticket_id_filter" style="width: 100%;" title="Booking ID">
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
				<input type="text" id="from_date_filter" name="from_date_filter" class="form-control" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'to_date_filter');">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
				<input type="text" id="to_date_filter" name="to_date_filter" class="form-control" placeholder="To Date" title="To Date" onchange="validate_validDate('from_date_filter','to_date_filter')">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="booker_id_filter" id="booker_id_filter" title="User Name" style="width: 100%" onchange="emp_branch_reflect()">
		        <?php  get_user_dropdown($role, $branch_admin_id, $branch_status_r,$emp_id) ?>
		    </select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="branch_id_filter" id="branch_id_filter" title="Branch Name" style="width: 100%">
		         <option value="">Select Branch</option>
		    </select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
				<button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>


<div id="div_list_reflect" class="main_block">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="train_tour_report" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<div id="div_train_ticket_update_content"></div>
<div id="div_ticket_content_display"></div>

<script>
	$('#customer_id_filter, #train_ticket_id_filter,#cust_type_filter,#booker_id_filter,#branch_id_filter').select2();
	$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
	dynamic_customer_load('','');

	var column = [
	{ title : "S_No."},
	{ title:"Booking_ID", className:"text-center"},
	{ title : "Customer_Name"},
	{ title : "Contact"},
	{ title : "EMAIL_ID"},
	{ title : "Total_Guest"},
	{ title : "Trip_type"},
	{ title : "Booking_Date"},
	{ title : "View"},
	{ title : "Basic_amount&nbsp;&nbsp;&nbsp;", className : "info"},
	{ title : "service_charge&nbsp;&nbsp;&nbsp;", className : "info"},
	{ title : "delievery_charge&nbsp;&nbsp;&nbsp;", className : "info"},
	{ title : "Tax", className:"info text-right"},
	{ title : "Credit_Card_Charges", className:"info text-right"},
	{ title : "Sale", className:"info text-right"},
	{ title : "Cancel", className:"danger text-right"},
	{ title : "Total", className:"info text-right"},
	{ title : "Paid", className:"success text-right"},
	{ title : "View"},
	{ title : "outstanding_balance", className:"warning text-right"},
	{ title : "due_date"},
	{ title : "Purchase"},
	{ title : "Purchased_From"},
	{ title : "Branch"},
	{ title : "Booked_By"},
	{ title : "Invoice" },
];
	function list_reflect()
	{
		var customer_id = $('#customer_id_filter').val();
		var train_ticket_id = $('#train_ticket_id_filter').val();
		var from_date = $('#from_date_filter').val();
		var to_date = $('#to_date_filter').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var booker_id = $('#booker_id_filter').val();
		var branch_id = $('#branch_id_filter').val();
		var base_url = $('#base_url').val();
		var branch_status_r = $('#branch_status_r').val();
		$.post(base_url+'view/visa_passport_ticket/train_ticket/payment_status/list_reflect.php', { train_ticket_id : train_ticket_id, customer_id : customer_id, from_date : from_date, to_date : to_date, cust_type : cust_type, company_name : company_name,booker_id:booker_id,branch_id : branch_id , branch_status : branch_status_r  }, function(data){
			// $('#div_list_reflect').html(data);
			pagination_load(data, column, true, true, 20, 'train_tour_report');
			$('.loader').remove();
		});
	}
	function excel_report()
		{
			var customer_id = $('#customer_id_filter').val();
			var train_ticket_id = $('#train_ticket_id_filter').val();
			var payment_from_date = $('#from_date_filter').val();
			var payment_to_date = $('#to_date_filter').val();
			var cust_type = $('#cust_type_filter').val();
			var company_name = $('#company_filter').val();
		    var booker_id = $('#booker_id_filter').val();
		    var branch_id = $('#branch_id_filter').val();
		    var base_url = $('#base_url').val();
			var branch_status_r = $('#branch_status_r').val(); 
			window.location = base_url+'view/visa_passport_ticket/train_ticket/payment_status/excel_report.php?customer_id='+customer_id+'&train_ticket_id='+train_ticket_id+'&payment_from_date='+payment_from_date+'&payment_to_date='+payment_to_date+'&cust_type='+cust_type+'&company_name='+company_name+'&booker_id='+booker_id+'&branch_id='+branch_id+'&branch_status='+branch_status_r;
		}
	list_reflect();

	function company_name_reflect()
	{  
		var cust_type = $('#cust_type_filter').val();
		var base_url = $('#base_url').val();
		var branch_status_r = $('#branch_status_r').val();
	  	$.post(base_url+'view/visa_passport_ticket/train_ticket/home/company_name_load.php', { cust_type : cust_type, branch_status : branch_status_r }, function(data){
	  		if(cust_type=='Corporate'){
		  		$('#company_div').addClass('company_class');	
		    }
		    else
		    {
		    	$('#company_div').removeClass('company_class');		
		    }
	    	$('#company_div').html(data);
	    });
	}
	company_name_reflect();
		//*******************Get Dynamic Customer Name Dropdown**********************//
	function dynamic_customer_load(cust_type, company_name)
	{
	  var cust_type = $('#cust_type_filter').val();
	  var company_name = $('#company_filter').val();
	  var base_url = $('#base_url').val();
	  var branch_status_r = $('#branch_status_r').val();
	    $.get(base_url+"view/visa_passport_ticket/train_ticket/home/get_customer_dropdown.php", { cust_type : cust_type , company_name : company_name, branch_status : branch_status_r}, function(data){
	    $('#customer_div').html(data);
	  });   
	}
	function train_ticket_id_dropdown_load(customer_id_filter, train_ticket_id_filter)
	{
		var customer_id = $('#'+customer_id_filter).val();
		var base_url = $('#base_url').val();

		$.post(base_url+'view/visa_passport_ticket/train_ticket/ticket_id_dropdown_load.php', { customer_id : customer_id }, function(data){
			$('#'+train_ticket_id_filter).html(data);
		});
	}

function ticket_view_modal(ticket_id)
  {
    var base_url = $('#base_url').val();
    $.post(base_url+'view/visa_passport_ticket/train_ticket/payment_status/view/index.php', { train_ticket_id : ticket_id }, function(data){
      $('#div_ticket_content_display').html(data);
    });
  }
function supplier_view_modal(ticket_id,year)
{
	var base_url = $('#base_url').val();
	$.post(base_url+'view/visa_passport_ticket/train_ticket/payment_status/view/supplier_view_modal.php', { train_ticket_id : ticket_id, year : year}, function(data){
	  $('#div_ticket_content_display').html(data);
	});
}
function payment_view_modal(ticket_id)
{	
	var base_url = $('#base_url').val();
	$.post(base_url+'view/visa_passport_ticket/train_ticket/payment_status/view/payment_view_modal.php', { train_ticket_id : ticket_id }, function(data){
      $('#div_ticket_content_display').html(data);
    });
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>