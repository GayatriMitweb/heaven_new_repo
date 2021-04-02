<?php 
include "../../../../model/model.php";
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="whatsapp_switch"  value="<?= $whatsapp_switch ?>" >
<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm mg_bt_10" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		<button class="btn btn-info btn-sm ico_left mg_bt_10" onclick="save_modal()" id="flight_btn"><i class="fa fa-plus"></i>&nbsp;&nbsp;Ticket</button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
		        <select name="cust_type_filter" id="cust_type_filter"  class="form-control" onchange="dynamic_customer_load(this.value,'company_filter');company_name_reflect();" title="Customer Type">
		            <?php get_customer_type_dropdown(); ?>
                    
		        </select>
	    </div>
	    <div id="company_div" class="hidden">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10" id="customer_div">    
	    </div> 
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="train_ticket_id_filter" id="train_ticket_id_filter" title="Booking ID" style="width:100%">
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
			<input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'to_date');">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" title="To Date" onchange="validate_validDate('from_date','to_date')">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<button class="btn btn-sm btn-info ico_right" onclick="train_ticket_customer_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>


<div id="div_train_ticket_customer_list_reflect" class="main_block">
<div class="table-responsive mg_tp_10">
        <table id="train_book" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="div_train_ticket_modal"></div>
<div id="div_train_ticket_view_modal"></div>

<script>
	$('#customer_id_filter, #train_ticket_id_filter,#cust_type_filter').select2();
	$('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
	dynamic_customer_load('','');
	var columns = [
		{ title : "S_No"},
		{ title : "Booking_ID"},
		{ title : "Customer_Name"},
		{ title : "Mobile"},
		{ title : "Train_No"},
		{ title : "Trip_Type"},
		{ title : "Amount", className : "info"},
		{ title : "Cncl_Amount", className : "danger"},
		{ title : "Total", className : "success"},
		{ title : "Created_by"},
		{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", className : "text-center"}
	];
	function train_ticket_customer_list_reflect()
	{
		var customer_id = $('#customer_id_filter').val()
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var train_ticket_id = $('#train_ticket_id_filter').val();
		var branch_status = $('#branch_status').val();

		$.post('home/ticket_list_reflect.php', { customer_id : customer_id, from_date : from_date, to_date : to_date , cust_type : cust_type, company_name : company_name, train_ticket_id : train_ticket_id, branch_status : branch_status  }, function(data){
			// $('#div_train_ticket_customer_list_reflect').html(data);
			pagination_load(data,columns,true,true,10,'train_book');
			
		});
	}
	train_ticket_customer_list_reflect();

	function train_ticket_update_modal(train_ticket_id)
	{
		var branch_status = $('#branch_status').val();
		$.post('home/update/index.php', { train_ticket_id : train_ticket_id , branch_status : branch_status}, function(data){
			$('#div_train_ticket_modal').html(data);
		});
	}

	function train_ticket_view_modal(train_ticket_id)
	{
		$.post('home/view/index.php', { train_ticket_id : train_ticket_id }, function(data){
			$('#div_train_ticket_view_modal').html(data);
		});
	}

	function save_modal()
	{
		var branch_status = $('#branch_status').val();
		$('#flight_btn').button('loading');
		$.post('home/save/index.php', {branch_status : branch_status}, function(data){
			$('#flight_btn').button('reset');
			$('#div_train_ticket_modal').html(data);
		});
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
	company_name_reflect();
	function calculate_total_amount()
	{
		var basic_fair = $('#basic_fair').val();
		var service_charge = $('#service_charge').val();
		var delivery_charges = $('#delivery_charges').val();
		var gst_on = $('#gst_on').val();
		var taxation_id = $('#taxation_id').val();
		var service_tax = $('#service_tax').val();
		var service_tax_subtotal = $('#service_tax_subtotal').val();
		var net_total = $('#net_total').val();		

		if(basic_fair==""){ basic_fair=0; }
		if(service_charge==""){ service_charge=0; }
		if(delivery_charges==""){ delivery_charges=0; }
		if(gst_on==""){ gst_on=0; }
		if(taxation_id==""){ taxation_id=0; }
		if(service_tax==""){ service_tax=0; }
		if(service_tax_subtotal==""){ service_tax_subtotal=0; }
		if(net_total==""){ net_total=0; }

		
		var service_tax_amount = 0;
		if(parseFloat(service_tax_subtotal) !== 0.00 && (service_tax_subtotal) !== ''){

		var service_tax_subtotal1 = service_tax_subtotal.split(",");
		for(var i=0;i<service_tax_subtotal1.length;i++){
			var service_tax = service_tax_subtotal1[i].split(':');
			service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
		}
		}

	basic_fair = ($('#basic_show').html() == '&nbsp;') ? basic_fair : parseFloat($('#basic_show').text().split(' : ')[1]);
    service_charge = ($('#service_show').html() == '&nbsp;') ? service_charge : parseFloat($('#service_show').text().split(' : ')[1]);
    markup = ($('#markup_show').html() == '&nbsp;') ? markup : parseFloat($('#markup_show').text().split(' : ')[1]);
	discount =($('#discount_show').html() == '&nbsp;') ? discount : parseFloat($('#discount_show').text().split(' : ')[1]); 
	
    var total_amount = parseFloat(basic_fair) + parseFloat(service_tax_amount) + parseFloat(service_charge) + parseFloat(delivery_charges);
    var total=total_amount.toFixed(2);
    var roundoff = Math.round(total)-total;
    $('#roundoff').val(roundoff.toFixed(2));
    $('#net_total').val(parseFloat(total)+parseFloat(roundoff));

			// net_total = parseFloat(basic_fair) + parseFloat(service_charge) + parseFloat(delivery_charges) + parseFloat(service_tax_amount);
		// net_total = net_total.toFixed(2);
		// $('#net_total').val(net_total);
	}




	function adolescence_reflect(id) 
	{
	  var dateString1=$("#"+id).val();

	  var today = new Date(); 
	  var birthDate = php_to_js_date_converter(dateString1);
	  var age = today.getFullYear() - birthDate.getFullYear();
	  var m = today.getMonth() - birthDate.getMonth();
	  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
	    age--;
	  } 

	  var count=id.substr(10);

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
	function excel_report()
		{
			var customer_id = $('#customer_id_filter').val();
			var train_ticket_id = $('#train_ticket_id_filter').val();
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			var cust_type = $('#cust_type_filter').val();
			var company_name = $('#company_filter').val();
			var branch_status = $('#branch_status').val();

			window.location = 'home/excel_report.php?customer_id='+customer_id+'&train_ticket_id='+train_ticket_id+'&from_date='+from_date+'&to_date='+to_date+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
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

			var table = document.getElementById("tbl_dynamic_train_ticket_master");
			var rowCount = table.rows.length;
			for(var i=0; i<rowCount; i++)
			{
				var row = table.rows[i];
				if(row.cells[0].childNodes[0].checked)
				{
					row.cells[3].childNodes[0].value = first_name;
					row.cells[4].childNodes[0].value = middle_name;
					row.cells[5].childNodes[0].value = last_name;
					row.cells[6].childNodes[0].value = birthdate;
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
				var table = document.getElementById("tbl_dynamic_train_ticket_master");
				var rowCount = table.rows.length;
				for(var i=0; i<rowCount; i++)
				{
					var row = table.rows[i];
					if(row.cells[0].childNodes[0].checked)
					{
						row.cells[3].childNodes[0].value = result.first_name;
						row.cells[4].childNodes[0].value = result.middle_name;
						row.cells[5].childNodes[0].value = result.last_name;
						row.cells[6].childNodes[0].value = result.birth_date;
  						adolescence_reflect('birth_date1');
					}
				}
			}
			});	
		}
	}
	else{
		var table = document.getElementById("tbl_dynamic_train_ticket_master");
		var rowCount = table.rows.length;
		for(var i=0; i<rowCount; i++)
		{
			var row = table.rows[i];
			if(row.cells[0].childNodes[0].checked)
			{
				row.cells[3].childNodes[0].value = '';
				row.cells[4].childNodes[0].value = '';
				row.cells[5].childNodes[0].value = '';
				row.cells[6].childNodes[0].value = '';
				row.cells[7].childNodes[0].value = '';
			}
		}
	}
}

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>