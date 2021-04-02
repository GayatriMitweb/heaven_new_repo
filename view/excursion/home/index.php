<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$role_id = $_SESSION['role_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='package_booking/service_voucher/hotel_voucher/index.php'"));
$branch_status = $sq['branch_status'];
?>
 <input type="hidden" id="whatsapp_switch"  value="<?= $whatsapp_switch ?>" >
<div class="row text-right mg_bt_20">
	<div class="col-xs-12">
	    <button class="btn btn-excel btn-sm mg_bt_10_sm_xs" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		<button class="btn btn-info btn-sm ico_left mg_bt_10_sm_xs" data-toggle="modal" data-target="#exc_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Activity</button>
	</div>
</div>
<?php include_once('save_modal.php'); ?>
<div class="app_panel_content Filter-panel">
	<div class="row">
			<input type="hidden" id="emp_id" name="emp_id" class="form-control">
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			        <select name="cust_type_filter" style="width:100%" id="cust_type_filter" onchange="dynamic_customer_load(this.value,'company_filter');company_name_reflect();" title="Customer Type">
			        <?php get_customer_type_dropdown(); ?>
			        </select>
		    </div>
		    <div id="company_div" class="hidden">
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10" id="customer_div">    
		    </div> 
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
				<select name="exc_id_filter" id="exc_id_filter" style="width:100%" title="Booking ID">
			        <?php  get_excursion_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id); ?>
				</select>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
				<input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'to_date');">
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
				<input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" title="To Date" onchange="validate_validDate('from_date','to_date')">
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 form-group">
				<button class="btn btn-sm btn-info ico_right" onclick="exc_customer_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
			</div>
	</div>
</div>
<hr>
<div id="div_exc_customer_list_reflect" class="main_block">
<div class="table-responsive mg_tp_10">
        <table id="exc_book" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="div_exc_update_content"></div>
<div id="div_exc_content_display"></div>
<div id="div_show_msg"></div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
	$('#customer_id_filter, #exc_id_filter, #cust_type_filter').select2();
	$('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
	dynamic_customer_load('','');
	var columns = [
		{ title : "S_No"},
		{ title : "booking_id"},
		{ title : "Customer_Name"},
		{ title : "Mobile"},
		{ title : "Amount", className : "info"},
		{ title : "Cncl_Amount", className : "danger"},
		{ title : "Total", className : "success"},
		{ title : "Created_by"},
		{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", className : "text-center"}
	];
	function exc_customer_list_reflect()
	{
		var customer_id = $('#customer_id_filter').val()
		var exc_id = $('#exc_id_filter').val()
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();

		$.post('home/exc_list_reflect.php', { customer_id : customer_id, exc_id : exc_id, from_date : from_date, to_date : to_date, cust_type : cust_type, company_name : company_name, branch_status : branch_status }, function(data){
			//$('#div_exc_customer_list_reflect').html(data);
			pagination_load(data,columns,true,true,10,'exc_book');
			$('.loader').remove();
		});
	}
	exc_customer_list_reflect();
	function business_rule_load(){
		get_auto_values('balance_date','exc_issue_amount','payment_mode','service_charge','markup','save','true','service_charge');
	}
	function exc_update_modal(exc_id)
	{
		var branch_status = $('#branch_status').val();
		$.post('home/update_modal.php', { exc_id : exc_id, branch_status : branch_status }, function(data){
			$('#div_exc_update_content').html(data);
		});
	}	

	function calculate_total_amount(offset=''){

		var exc_issue_amount = $('#exc_issue_amount'+offset).val();
		var service_charge = $('#service_charge'+offset).val();
		var markup = $('#markup'+offset).val();
		var service_tax_subtotal = $('#service_tax_subtotal'+offset).val();
		var service_tax_markup = $('#service_tax_markup'+offset).val();
	
		if(exc_issue_amount==""){ exc_issue_amount = 0; }
	if(service_charge==""){ service_charge = 0; }
	if(markup==""){ markup = 0; }

	exc_issue_amount = ($('#basic_show'+offset).html() == '&nbsp;') ? exc_issue_amount : parseFloat($('#basic_show'+offset).text().split(' : ')[1]);
	service_charge = ($('#service_show'+offset).html() == '&nbsp;') ? service_charge : parseFloat($('#service_show'+offset).text().split(' : ')[1]);
	markup = ($('#markup_show'+offset).html() == '&nbsp;') ? markup : parseFloat($('#markup_show'+offset).text().split(' : ')[1]);

		if(exc_issue_amount==""){ exc_issue_amount = 0; }
		if(service_charge==""){ service_charge = 0; }


		var service_tax_amount = 0;
		if(parseFloat(service_tax_subtotal) !== 0.00 && (service_tax_subtotal) !== ''){
			var service_tax_subtotal1 = service_tax_subtotal.split(",");
			for(var i=0;i<service_tax_subtotal1.length;i++){
				var service_tax = service_tax_subtotal1[i].split(':');
				service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
			}
		}
	
		var markupservice_tax_amount = 0;
		if(parseFloat(service_tax_markup) !== 0.00 && (service_tax_markup) !== ""){
			var service_tax_markup1 = service_tax_markup.split(",");
			for(var i=0;i<service_tax_markup1.length;i++){
				var service_tax = service_tax_markup1[i].split(':');
				markupservice_tax_amount = parseFloat(markupservice_tax_amount) + parseFloat(service_tax[2]);
			}
		}
		service_tax_subtotal = Math.round(service_tax_amount);
		var total_amount = parseFloat(exc_issue_amount) + parseFloat(service_charge) + parseFloat(service_tax_amount) + parseFloat(markupservice_tax_amount) + parseFloat(markup);

		total_amount = total_amount.toFixed(2);
		var roundoff = Math.round(total_amount)-total_amount;
  $('#roundoff'+offset).val(roundoff.toFixed(2));
  $('#exc_total_cost'+offset).val(parseFloat(total_amount)+parseFloat(roundoff));
		

	}
	
	function customer_info_load(offset='')
	{
	 var customer_id = $('#customer_id'+offset).val();
	 var base_url = $('#base_url').val();
	if(customer_id==0 && customer_id!=''){
		$('#cust_details').addClass('hidden');
	    $('#new_cust_div').removeClass('hidden');

		$.ajax({
		type:'post',
		url:base_url+'view/load_data/new_customer_info.php',
		data:{},
		success:function(result){
			 
			$('#new_cust_div').html(result);
		}
	});
	}
	else{
		if(customer_id!=''){

			$('#new_cust_div').addClass('hidden');
			$('#cust_details').removeClass('hidden');
			$.ajax({
			type:'post',
			url:base_url+'view/load_data/customer_info_load.php',
			data:{ customer_id : customer_id },
			success:function(result){
				result = JSON.parse(result);
				$('#mobile_no'+offset).val(result.contact_no);
				$('#email_id'+offset).val(result.email_id);
				if(result.company_name != ''){
					$('#company_name'+offset).removeClass('hidden');
					$('#company_name'+offset).val(result.company_name);	
				}
				else{
					$('#company_name'+offset).addClass('hidden');
				}		
				if(result.payment_amount != '' || result.payment_amount != '0'){
					$('#credit_amount'+offset).removeClass('hidden');
					$('#credit_amount'+offset).val(result.payment_amount);	
					if(result.company_name != ''){
						$('#credit_amount'+offset).addClass('mg_tp_10');}
					else{
						$('#credit_amount'+offset).removeClass('mg_tp_10');
						$('#credit_amount'+offset).addClass('mg_bt_10');
					}
				}
				else{
					$('#credit_amount'+offset).addClass('hidden');
				}

			}
			});
		}
	}
}

	function company_name_reflect()
	{  
		var cust_type = $('#cust_type_filter').val();
		var branch_status = $('#branch_status').val();
	  	$.post('home/company_name_load.php', { cust_type : cust_type, branch_status : branch_status}, function(data){
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
	// company_name_reflect();

	function exc_display_modal(exc_id)
	{
		$.post('home/view/index.php', { exc_id : exc_id }, function(data){
			$('#div_exc_content_display').html(data);
		});
	}
	function excel_report()
	{
		var customer_id = $('#customer_id_filter').val()
		var exc_id = $('#exc_id_filter').val()
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();
		
		window.location = 'home/excel_report.php?customer_id='+customer_id+'&exc_id='+exc_id+'&from_date='+from_date+'&to_date='+to_date+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
	}
	//*******************Get Dynamic Customer Name Dropdown**********************//
	function dynamic_customer_load(cust_type, company_name)
	{
	  var cust_type = $('#cust_type_filter').val();
	  var company_name = $('#company_filter').val();
	  var branch_status = $('#branch_status').val();
	    $.get("home/get_customer_dropdown.php", { cust_type : cust_type , company_name : company_name, branch_status : branch_status}, function(data){
	    $('#customer_div').html(data);
	  });   
	}
	function whatsapp_send(emp_id, customer_id, booking_date, base_url){
		$.post(base_url+'controller/excursion/whatsapp_send.php',{emp_id:emp_id,booking_date:booking_date ,customer_id:customer_id,booking_date:booking_date}, function(data){
			window.open(data);
		});
	}
	function voucher_display(booking_id){
		var base_url = $('#base_url').val();
		
		var booking_type = 'excursion';
		var url1 = base_url+'model/app_settings/print_html/voucher_html/excursion_voucher.php?booking_id='+booking_id+'&booking_type='+booking_type;
		loadOtherPage(url1);
	}
</script>
