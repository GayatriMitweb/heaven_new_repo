<?php
include "../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$branch_status = $_POST['branch_status'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$query = "select * from miscellaneous_master where 1";
include "../../../model/app_settings/branchwise_filteration.php";
$query .= " order by misc_id desc";
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>"/>
<input type="hidden" id="whatsapp_switch"  value="<?= $whatsapp_switch ?>" >
<div class="row text-right mg_bt_20">
	<div class="col-md-12">
	    <button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#visa_payment_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Receipt</button>
	</div>
</div>
<?php include_once('save_payment_modal.php'); ?>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
		        <select name="cust_type_filter" id="cust_type_filter" style="width:100%" onchange="dynamic_customer_load(this.value,'company_filter'); company_name_reflect();" title="Customer Type">
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
			<select name="payment_mode_filter" id="payment_mode_filter" class="form-control" title="Mode">
				<?php get_payment_mode_dropdown(); ?>
			</select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 hidden">
			<select name="financial_year_id_filter" id="financial_year_id_filter" title="Financial Year">
				<?php get_financial_year_dropdown(); ?>
			</select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="payment_from_date_filter" name="payment_from_date_filter" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'payment_to_date_filter');">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="payment_to_date_filter" name="payment_to_date_filter" placeholder="To Date" title="To Date" onchange="validate_validDate('payment_from_date_filter','payment_to_date_filter')">
		</div>
	</div>
	<div class="row text-center mg_tp_10">
		<div class="col-xs-12">
			<button class="btn btn-sm btn-info ico_right" onclick="visa_payment_list_reflect();bank_receipt();">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>

<div id="div_visa_payment_list" class="main_block loader_parent mg_tp_10">
<div class="table-responsive">
        <table id="misc_r_book" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="div_visa_payment_update"></div>
<div id="receipt_data"></div>

<script>
	$('#payment_from_date_filter, #payment_to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
	$('#customer_id_filter, #visa_id_filter,#cust_type_filter').select2();
	dynamic_customer_load('','');
	var columns = [
		{ title : "S_No"},
		{ title : " "},
		{ title : "misc_ID"},
		{ title : "Customer_Name"},
		{ title : "Receipt_Date"},
		{ title : "Mode"},
		{ title : "Branch_Name"},
		{ title : "Amount", className : "success"},
		{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", className : "text-center"},
	];
	function visa_payment_list_reflect()
	{
		$('#div_visa_payment_list').append('<div class="loader"></div>');
		var customer_id = $('#customer_id_filter').val();
		var misc_id = $('#visa_id_filter').val();
		var payment_mode = $('#payment_mode_filter').val();
		var financial_year_id = $('#financial_year_id_filter').val();
		var payment_from_date = $('#payment_from_date_filter').val();
		var payment_to_date = $('#payment_to_date_filter').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();
		$.post('payment/visa_payment_list_reflect.php', { customer_id : customer_id, misc_id : misc_id, payment_mode : payment_mode, financial_year_id : financial_year_id, payment_from_date : payment_from_date, payment_to_date : payment_to_date, cust_type : cust_type, company_name : company_name, branch_status : branch_status  }, function(data){
			// $('#div_visa_payment_list').html(data);
			pagination_load(data,columns,true,true,10,'misc_r_book');
			$('.loader').remove();
		});
	}
	visa_payment_list_reflect();

	function visa_payment_update_modal(payment_id)
	{	
		var branch_status = $('#branch_status').val();
		$.post('payment/visa_payment_update_modal.php', { payment_id : payment_id, branch_status : branch_status  }, function(data){
			$('#div_visa_payment_update').html(data);
		});
	}
	function excel_report()
	{
		var customer_id = $('#customer_id_filter').val()
		var misc_id = $('#visa_id_filter').val()
		var from_date = $('#payment_from_date_filter').val();
		var to_date = $('#payment_to_date_filter').val();
		var payment_mode = $('#payment_mode_filter').val();
		var financial_year_id = $('#financial_year_id_filter').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();

		window.location = 'payment/excel_report.php?customer_id='+customer_id+'&misc_id='+misc_id+'&from_date='+from_date+'&to_date='+to_date+'&payment_mode='+payment_mode+'&financial_year_id='+financial_year_id+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
	}
	function bank_receipt(){
			var payment_mode = $('#payment_mode_filter').val();
			var base_url = $('#base_url').val();
			$.post(base_url+'view/hotels/booking/payment/bank_receipt_generate.php',{payment_mode : payment_mode}, function(data){
				$('#receipt_data').html(data);
			});
		}
		function whatsapp_send_r(booking_id, payment_amount, base_url){
		$.post(base_url+'controller/miscellaneous/receipt_whatsapp_send.php',{booking_id:booking_id, payment_amount:payment_amount}, function(data){
		window.open(data);
	});
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