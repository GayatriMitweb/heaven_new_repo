<?php 
include "../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
 <input type="hidden" id="whatsapp_switch"  value="<?= $whatsapp_switch ?>" >
<div class="row text-right mg_bt_20">
	<div class="col-xs-12">
	    <button class="btn btn-excel btn-sm mg_bt_10_sm_xs" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		<button class="btn btn-info btn-sm ico_left mg_bt_10_sm_xs" data-toggle="modal" data-target="#visa_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Miscellaneous</button>
	</div>
</div>

<?php include_once('save_modal.php'); ?>
<div class="app_panel_content Filter-panel">
	<div class="row">
			<input type="hidden" id="emp_id" name="emp_id" class="form-control">
			<input type="hidden" id="branch_status" name="branch_status" class="form-control">
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
				<input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" title="From Date"  onchange="get_to_date(this.id,'to_date');">
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
				<input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" title="To Date" onchange="validate_validDate('from_date','to_date')">
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 form-group">
				<button class="btn btn-sm btn-info ico_right" onclick="visa_customer_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
			</div>
	</div>
</div>
<hr>
<div id="div_visa_customer_list_reflect" class="main_block loader_parent">
<div class="table-responsive mg_tp_10">
        <table id="misc_book" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="div_visa_update_content"></div>
<div id="div_visa_content_display"></div>
<div id="div_show_msg"></div>
<script src="js/calculation.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
	$('#customer_id_filter, #visa_id_filter, #cust_type_filter').select2();
	$('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
	dynamic_customer_load('','');
	var columns = [
		{ title : "S_No"},
		{ title : "Miscellaneous_ID"},
		{ title : "Customer_Name"},
		{ title : "Mobile"},
		{ title : "Total_Pax"},
		{ title : "Amount", className : "info"},
		{ title : "Cncl_Amount", className : "danger"},
		{ title : "Total", className : "success"},
		{ title : "Created_by"},
		{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", className : "text-center"}
	];

	function business_rule_load(){
		get_auto_values('balance_date','visa_issue_amount','payment_mode','service_charge','markup','save','true','service_charge');
	}
	function visa_customer_list_reflect()
	{
		$('#div_visa_customer_list_reflect').append('<div class="loader"></div>');
		var customer_id = $('#customer_id_filter').val()
		var misc_id = $('#visa_id_filter').val()
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();
		

		$.post('home/visa_list_reflect.php', { customer_id : customer_id, misc_id : misc_id, from_date : from_date, to_date : to_date, cust_type : cust_type, company_name : company_name , branch_status : branch_status}, function(data){
			// $('#div_visa_customer_list_reflect').html(data);
			pagination_load(data,columns,true,true,10,'misc_book');
			$('.loader').remove();
		});
	}
	visa_customer_list_reflect();

	function visa_update_modal(misc_id)
	{
		var branch_status = $('#branch_status').val();
		$.post('home/update_modal.php', { misc_id : misc_id, branch_status : branch_status }, function(data){
			$('#div_visa_update_content').html(data);
		});
	}	

	function calculate_total_amount(offset=''){

		var visa_issue_amount = $('#visa_issue_amount'+offset).val();
		var service_charge = $('#service_charge'+offset).val();
		var markup = $('#markup'+offset).val();
		var service_tax_subtotal = $('#service_tax_subtotal'+offset).val();
		var service_tax_markup = $('#service_tax_markup'+offset).val();

		if(visa_issue_amount==""){ visa_issue_amount = 0; }
		if(service_charge==""){ service_charge = 0; }
		if(markup==""){ markup = 0; }

		visa_issue_amount = ($('#basic_show'+offset).html() == '&nbsp;') ? visa_issue_amount : parseFloat($('#basic_show'+offset).text().split(' : ')[1]);
		service_charge = ($('#service_show'+offset).html() == '&nbsp;') ? service_charge : parseFloat($('#service_show'+offset).text().split(' : ')[1]);
		markup = ($('#markup_show'+offset).html() == '&nbsp;') ? markup : parseFloat($('#markup_show'+offset).text().split(' : ')[1]);
	
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
		//console.log(service_tax_subtotal+ "TEst")
		var total_amount = parseFloat(visa_issue_amount) + parseFloat(service_charge) + parseFloat(service_tax_amount) + parseFloat(markup) + parseFloat(markupservice_tax_amount);
		console.log(visa_issue_amount, service_charge, service_tax_amount, markup, markupservice_tax_amount);
		
		total_amount = total_amount.toFixed(2);
		var roundoff = Math.round(total_amount)-total_amount;
  		$('#roundoff'+offset).val(roundoff.toFixed(2));

		$('#visa_total_cost'+offset).val(parseFloat(total_amount)+parseFloat(roundoff));

	}
	
	function customer_info_load(offset='')
	{
	 var customer_id = $('#customer_id'+offset).val();

	 var base_url = $('#base_url').val();
		if(customer_id==0 && customer_id != ''){
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
			if(customer_id != ''){
				$('#new_cust_div').addClass('hidden');
				$('#cust_details').removeClass('hidden');
				$.ajax({
					type:'post',
					url:base_url+'view/load_data/customer_info_load.php',
					data:{ customer_id : customer_id},
					success:function(result){
						result = JSON.parse(result);
						$('#mobile_no'+offset).val(result.contact_no);
						$('#email_id'+offset).val(result.email_id);
						if(result.company_name != ''){
							$('#company_name'+offset).removeClass('hidden');
							$('#company_name'+offset).val(result.company_name);	
						}
						else
						{
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
	  	$.post('home/company_name_load.php', { cust_type : cust_type, branch_status : branch_status }, function(data){
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

	function adolescence_reflect(id) 
	{
	  var dateString1=$("#"+id).val();

	  var today = new Date(); 
	  var birthDate = php_to_js_date_converter(dateString1);
	  var age = today.getFullYear() - birthDate.getFullYear();
	  var m = today.getMonth() - birthDate.getMonth();
	  var d= today.getDate() - birthDate.getDate();
	  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
	    age--;
	  } 

      var millisecondsPerDay = 1000 * 60 * 60 * 24;
	  var millisBetween = today.getTime() - birthDate.getTime();
	  var days = millisBetween / millisecondsPerDay;

	  var count=id.substr(10);
	  var adl = "";
	  var no_days = Math.floor(days);
	  
	  if(no_days<=730 && no_days>0){ adl = "Infant"; }
	  if(no_days>730 && no_days<=4383){ adl = "Children"; }
	  if(no_days>4383){ adl = "Adult"; } 

	  $('#adolescence'+count).val(adl);
  
	}
	function visa_display_modal(misc_id)
	{
		
		$.post('home/view/index.php', { misc_id : misc_id}, function(data){
			$('#div_visa_content_display').html(data);
		});
	}
	function excel_report()
	{
		var customer_id = $('#customer_id_filter').val()
		var misc_id = $('#visa_id_filter').val()
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();
		
		window.location = 'home/excel_report.php?customer_id='+customer_id+'&misc_id='+misc_id+'&from_date='+from_date+'&to_date='+to_date+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
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

	function copy_details(){
	if(document.getElementById("copy_details1").checked){
		var customer_id = $('#customer_id').val();
		var base_url = $('#base_url').val();
		
		if(customer_id == 0){			
			var first_name = $('#cust_first_name').val();
			var middle_name = $('#cust_middle_name').val();
			var last_name = $('#cust_last_name').val();
			var birthdate = $('#cust_birth_date').val();

			if(typeof first_name === 'undefined'){ first_name = '';}
			if(typeof middle_name === 'undefined'){ middle_name = '';}
			if(typeof last_name === 'undefined'){ last_name = '';}
			if(typeof birthdate === 'undefined'){ birthdate = '';}

			var table = document.getElementById("tbl_dynamic_miscellaneous");
			var rowCount = table.rows.length;
			for(var i=0; i<1; i++)
			{
				var row = table.rows[i];
				if(row.cells[0].childNodes[0].checked)
				{
					row.cells[2].childNodes[0].value = first_name;
					row.cells[3].childNodes[0].value = middle_name;
					row.cells[4].childNodes[0].value = last_name;
					row.cells[5].childNodes[0].value = birthdate;
  					adolescence_reflect('birth_date1');
				}
			}
		}
		else{
				$.ajax({
				type:'post',
				url:base_url+'view/load_data/customer_info_load.php',
				data:{customer_id : customer_id},
				success:function(result){
					result = JSON.parse(result);
					var table = document.getElementById("tbl_dynamic_miscellaneous");
					var rowCount = table.rows.length;
					for(var i=0; i<1; i++)
					{
						var row = table.rows[i];
						if(row.cells[0].childNodes[0].checked)
						{
							row.cells[2].childNodes[0].value = result.first_name;
							row.cells[3].childNodes[0].value = result.middle_name;
							row.cells[4].childNodes[0].value = result.last_name;
							row.cells[5].childNodes[0].value = result.birth_date;
							adolescence_reflect('birth_date1');
						}
					}
				}
				});
		}
	}
	else{
		var table = document.getElementById("tbl_dynamic_miscellaneous");
		var rowCount = table.rows.length;
		for(var i=0; i<rowCount; i++)
		{
			var row = table.rows[i];
			if(row.cells[0].childNodes[0].checked)
			{
				row.cells[2].childNodes[0].value = '';
				row.cells[3].childNodes[0].value = '';
				row.cells[4].childNodes[0].value = '';
				row.cells[5].childNodes[0].value = '';
				row.cells[6].childNodes[0].value = '';
			}
		}
	}
}
function whatsapp_send(emp_id, customer_id, booking_date, base_url){
	$.post(base_url+'controller/miscellaneous/whatsapp_send.php',{emp_id:emp_id,booking_date:booking_date ,customer_id:customer_id,booking_date:booking_date}, function(data){
		window.open(data);
		// console.log(data);
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
