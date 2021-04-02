<form id="frm_tab2">

	<div class="row">

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<select name="customer_id" id="customer_id" class="customer_dropdown" title="Select Customer Name" style="width:100%" onchange="customer_info_load();get_auto_values('booking_date','basic_cost','payment_mode','service_charge','markup','save','true','service_charge','discount');">
				<?php get_new_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
			</select>
		</div>	
		<div id="new_cust_div"></div>
	    <div id="cust_details">	  
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

          <input type="text" id="mobile_no" name="mobile_no"  placeholder="Mobile No" title="Mobile No" readonly>

        </div>

        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

          <input type="text" id="email_id" name="email_id" placeholder="Email ID" title="Email ID" readonly>

        </div>
        
        <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10">

          <input type="text" id="company_name" class="hidden" name="company_name" title="Company Name" placeholder="Company Name" title="Company Name" readonly>

        </div> 
        <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
          <input type="text" id="credit_amount" class="hidden" name="credit_amount" placeholder="Credit Note Balance" title="Credit Note Balance" readonly>
        </div>
         
      </div>
  </div>
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
	      <select name="tour_type" id="tour_type" title="Travelling Type">
	      	<option value="">*Travelling Type</option>
	      	<option value="Domestic">Domestic</option>
	      	<option value="International">International</option>
	      </select>
	    </div>
  </div>
	<hr>
	<h3 class="editor_title">Passenger Details</h3>
	<div class="panel panel-default panel-body app_panel_style">
    <div class="row text-right mg_bt_10">
        <div class="col-xs-12">
            <button type="button" class="btn btn-info btn-sm ico_left mg_bt_10_sm_xs" onClick="addRow('tbl_dynamic_ticket_master_airfile')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
        </div>
    </div>
		<div class="row">
		    <div class="col-xs-12">
		        <div class="table-responsive">
		        <?php $offset = ""; ?>
		        <table id="tbl_dynamic_ticket_master_airfile" name="tbl_dynamic_ticket_master_airfile" class="table border_0 no-marg" style="padding-bottom: 0 !important;">
		           <?php include_once('ticket_master_tbl.php'); ?>
		        </table>
		        </div>
		    </div>
		</div>
	</div>
  <div class="row text-center mg_tp_20">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>
</form>



<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>


function display_format_modal(){
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/flight_passenger_list.csv";
}
function business_rule_load(){
	get_auto_values('booking_date','basic_cost','payment_mode','service_charge','markup','save','true','service_charge','discount');;
}
function switch_to_tab1(){ $('a[href="#tab1"]').tab('show'); }
$('#frm_tab2').validate({

	rules:{

			customer_id : { required : true },

			tour_type : { required : true },

	},

	submitHandler:function(form,e){
    e.preventDefault();


        var adults = 0;

        var childrens = 0;

        var infant = 0;

		



        var msg = "";

        var table = document.getElementById("tbl_dynamic_ticket_master_airfile");

        var rowCount = table.rows.length;       

        for(var i=0; i<rowCount; i++)

        {

          var row = table.rows[i];
          if(rowCount == 1){
            if(!row.cells[0].childNodes[0].checked){
           		error_msg_alert("Atleast one passenger is required!");
           		return false;
            }
          }

          if(row.cells[0].childNodes[0].checked)
          {

			  var first_name = row.cells[2].childNodes[0].value;

			  var middle_name = row.cells[3].childNodes[0].value;

			  var last_name = row.cells[4].childNodes[0].value;

			  var adolescence = row.cells[5].childNodes[0].value;

			  var ticket_no = row.cells[6].childNodes[0].value;

			  var gds_pnr = row.cells[7].childNodes[0].value;
			  var conjunction = row.cells[8].childNodes[0].value;
				if(conjunction == ''){
					if(adolescence=="Adult"){ adults = adults+1; }

					if(adolescence=="Child"){ childrens = childrens+1; }

					if(adolescence=="Infant"){ infant = infant+1; }				
				}	  

			  if(first_name==""){ msg +="First name is required in row:"+(i+1)+"<br>"; }

			  if(adolescence==""){ msg +="Adolescence is required in row:"+(i+1)+"<br>"; }

          }      

        }



        if(msg!=""){

        	error_msg_alert(msg);

        	return false;

        }



        $('#adults').val(adults);

		$('#childrens').val(childrens);

		$('#infant').val(infant);

		calculate_total_amount('abc');


    
    $('a[href="#tab3"]').tab('show');

	}

});

</script>