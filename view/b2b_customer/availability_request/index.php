<?php
include "../../../model/model.php";
/*=======******Header******=========*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Hotel Availability Request','') ?>
  <!--=======Header panel end======-->
  
<div class="app_panel_content">
    <div class="row">
	<div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12 mg_bt_10_xs">
				<select name="customer_id" id="customer_id" title="Select Customer" onchange="list_reflect()" style="width:100%">
					<option value="">Select Customer</option>
					<?php 
					$query = "select * from customer_master where type='B2B'";
					if($branch_status=='yes' && ($role!='Admin'||$role=='Branch Admin')){
							$query .= " and branch_admin_id = '$branch_admin_id'";
					}
					$query .= " order by customer_id desc";
					$sq_customer = mysql_query($query);
					while($row_customer = mysql_fetch_assoc($sq_customer)){
						?>
						<option value="<?= $row_customer['customer_id'] ?>"><?= $row_customer['company_name'] ?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12 mg_bt_10_xs">
				<input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date" onchange="list_reflect()">
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12 mg_bt_10_xs">
				<input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date" onchange="list_reflect()">
			</div>
		</div>
</div>

	<div id="div_list_reflect" class="main_block">
		<div class="row mg_tp_30"> <div class="col-md-12"> <div class="table-responsive">
			<table id="request_table" class="table table-hover" style="margin: 20px 0 !important;"></table>
		</div></div></div>
	</div>
	<div id="view_request"></div>
</div>
</div>
<?= end_panel() ?>

<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
$('#customer_id').select2();
$('#from_date_filter,#to_date_filter').datetimepicker({ format:'d-m-Y H:i' });
var columns = [
	{ title : "S_No"},
	{ title : "Request_DateTime"},
	{ title : "Customer"},
	{ title : "Concern_Person"},
	{ title : "Mobile_NO"},
	{ title : "Email_ID"},
	{ title : "Actions" , className:"text-center"}
]
function list_reflect(){
	$('#div_list_reflect').append('<div class="loader"></div>');
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var customer_id = $('#customer_id').val();
	$.post('list_reflect.php', { from_date : from_date, to_date : to_date, customer_id : customer_id }, function(data){
		pagination_load(data, columns, true, false, 20, 'request_table');
		$('.loader').remove();
	})
}
list_reflect();

function supplier_request(request_id,register_id,$supplier_mail){
	var base_url = $('#base_url').val();
	if($supplier_mail == 0){
		$('#mail'+request_id).button('loading');
		$.post(base_url+'controller/b2b_customer/availability_request/supplier_request.php', {request_id : request_id ,register_id:register_id}, function(data){
			success_msg_alert(data);
			$('#mail'+request_id).button('reset');
			list_reflect();
		});
	}else{
		error_msg_alert('Mail already sent to the suppliers!');
	}
}

function view_request(request_id){
	$('#edit'+request_id).button('loading');
	$.post('view/index.php', {request_id : request_id }, function(data){
		$('#view_request').html(data);
		$('#edit'+request_id).button('reset');
	});
}

function agent_response(request_id,register_id){
	var base_url = $('#base_url').val();
	$('#agentmail'+request_id).button('loading');
	$.post(base_url+'controller/b2b_customer/availability_request/agent_response.php', {request_id : request_id ,register_id:register_id}, function(data){
		var msg = data.split("--");
		if(msg[0]=='error'){
			error_msg_alert(msg[1]);
		}else{
			success_msg_alert(data);
		}
		$('#agentmail'+request_id).button('reset');
	});
}

function delete_request(request_id){
	var base_url = $('#base_url').val();
	$('#vi_confirm_box').vi_confirm_box({
        message: 'Are you sure you want to delete?',
        callback: function(data1){
            if(data1=="yes"){
				$.post(base_url+'controller/b2b_customer/availability_request/delete_request.php', {request_id : request_id }, function(data){
					var msg = data.split('--');
					if(msg[0] === "error"){
						error_msg_alert(msg[1]);
						return false;
					}else{
						msg_alert(msg[0]);
						list_reflect();
					}
				});
			}
		}
	});
}
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>