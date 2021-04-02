<?php 
include "../../../../../model/model.php";
$branch_status = $_POST['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
?>
<input type="hidden" id="unique_timestamp" name="unique_timestamp" value="<?= md5(time()) ?>">
<input type="hidden" id="flight_sc" name="flight_sc">
<input type="hidden" id="flight_markup" name="flight_markup">
<input type="hidden" id="flight_taxes" name="flight_taxes">
<input type="hidden" id="flight_markup_taxes" name="flight_markup_taxes">
<input type="hidden" id="flight_tds" name="flight_tds">

<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>" >
<div class="modal fade" id="ticket_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" style="width:96%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Ticket</h4>
      </div>
      <div class="modal-body">

      	<section id="sec_ticket_save" name="frm_ticket_save">

      		<div>

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Customer Details</a></li>
			    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Flight Ticket</a></li>
			    <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">Receipt</a></li>
			    <li role="presentation"><a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab">Advance Receipt</a></li>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content" style="padding:20px 10px;">
			    <div role="tabpanel" class="tab-pane active" id="tab1">
			    	<?php  include_once('tab1.php'); ?>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab2">
			    	<?php  include_once('tab2.php'); ?>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab3">
			    	<?php  include_once('tab3.php'); ?>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab4">
			    	<?php  include_once('tab4.php'); ?>
			    </div>
			  </div>

			</div>       
	        

        </section>
      </div>  
    </div>
  </div>
</div>


<script>
$('#customer_id').select2();
$('#ticket_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#payment_date, #due_date, #birth_date1,#booking_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#ticket_save_modal').modal({backdrop: 'static', keyboard: false});
function business_rule_load(){
		get_auto_values('booking_date','basic_cost','payment_mode','service_charge','markup','save','true','basic','discount');
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

			var table = document.getElementById("tbl_dynamic_ticket_master");
			var rowCount = table.rows.length;
			for(var i=0; i<rowCount; i++)
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
				var table = document.getElementById("tbl_dynamic_ticket_master");
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
		var table = document.getElementById("tbl_dynamic_ticket_master");
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
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>