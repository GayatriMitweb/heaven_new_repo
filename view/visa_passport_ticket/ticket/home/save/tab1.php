<form id="frm_tab1">

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
    <div class="row mg_tp_10">
      <div class="col-md-4">
        <input id="copy_details1" name="copy_details1" type="checkbox" onClick="copy_details();">
        &nbsp;&nbsp;<label for="copy_details1">Passenger Details same as above</label>
      </div>
    </div>
    <div class="row mg_tp_10">
      <div class="col-md-4">
        <input id="reissue_check1" name="reissue_check1" type="checkbox" onClick="ticket_reissue();">
        &nbsp;&nbsp;<label for="reissue_check1">Reissue Ticket</label>
      </div>
    </div>
	<hr>
  <div class="panel panel-default panel-body app_panel_style feildset-panel">
         <legend>Quotation Details</legend>
          <div class="row">
            <div class="col-md-4">
            
            <select name="quotation_id" id="quotation_id" style="width:100%" onchange="get_quotation_details(this)" class="form-control">
                  <option value="">Select Quotation</option>
                  <?php
                  $query = "SELECT * FROM `flight_quotation_master`ORDER BY quotation_id DESC";
                  
                  $sq_enq = mysql_query($query);   
                  while($row_enq = mysql_fetch_assoc($sq_enq)){
                    ?>
                <option value="<?= $row_enq['quotation_id'] ?>"><?= get_quotation_id($row_enq['quotation_id'] )." ".$row_enq['customer_name'] ?></option>
                    <?php
                  }
                  ?>
              </select>
              </div>
          </div>
        </div>
	<h3 class="editor_title">Passenger Details</h3>
	<div class="panel panel-default panel-body app_panel_style">
    <div class="row text-right mg_bt_10">
        <div class="col-xs-12">
            <div class="col-md-6 text-left">
            <input type="button" class="btn btn-sm btnType" onclick="display_format_modal();" value="View CSV" autocomplete="off" data-original-title="" title="">
                <div class="div-upload  mg_bt_20" id="div_upload_button">
                    <div id="cust_csv_upload" class="upload-button1"><span>CSV</span></div>
                    <span id="cust_status" ></span>
                    <ul id="files" ></ul>
                    <input type="hidden" id="txt_cust_csv_upload_dir" name="txt_cust_csv_upload_dir">
                </div>
            </div>
            <button type="button" class="btn btn-info btn-sm ico_left mg_bt_10_sm_xs" onClick="addRow('tbl_dynamic_ticket_master');"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
            <button type="button" class="btn btn-danger btn-sm ico_left mg_bt_10_sm_xs" onClick="deleteRow('tbl_dynamic_ticket_master')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
        </div>
    </div>
		<div class="row">
		    <div class="col-xs-12">
		        <div class="table-responsive">
		        <?php $offset = ""; ?>
		        <table id="tbl_dynamic_ticket_master" name="tbl_dynamic_ticket_master" class="table border_0 no-marg" style="padding-bottom: 0 !important;">
		           <?php include_once('ticket_master_tbl.php'); ?>
		        </table>
		        </div>
		    </div>
		</div>
	</div>
  <div class="row text-center mg_tp_20">
		<div class="col-xs-12">
			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</form>



<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#quotation_id').select2();
cust_csv_upload();
function cust_csv_upload()
{   
    var type="passenger_list";
    var btnUpload=$('#cust_csv_upload');
    var status=$('#cust_status');
    new AjaxUpload(btnUpload, {
      action: 'home/save/upload_passenger_csv.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){
         if(!confirm('Do you want to import this file?')){
            return false;
          }
         if (! (ext && /^(csv)$/.test(ext))){ 
          // extension is not allowed 
          status.text('Only excel sheet files are allowed');
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        //Add uploaded file to list
        if(response==="error"){
          alert("File is not uploaded.");
        } else{
          document.getElementById("txt_cust_csv_upload_dir").value = response;
          cust_csv_save();
        }
      }
    });
}

function cust_csv_save(){
    var cust_csv_dir = document.getElementById("txt_cust_csv_upload_dir").value;
    var base_url = $('#base_url').val();
    $.ajax({
        type:'post',
        url: base_url+'controller/visa_passport_ticket/ticket/passenger_csv_save.php',
        data:{cust_csv_dir : cust_csv_dir },
        success:function(result){
            var table = document.getElementById("tbl_dynamic_ticket_master");
						var pass_arr = JSON.parse(result);
            for(var i=0; i<pass_arr.length; i++){
                var row = table.rows[i]; 
                row.cells[2].childNodes[0].value = pass_arr[i]['m_first_name'];
                row.cells[3].childNodes[0].value = pass_arr[i]['m_middle_name'];
                row.cells[4].childNodes[0].value = pass_arr[i]['m_last_name'];
                // row.cells[5].childNodes[0].value = pass_arr[i]['m_birth_date1'];
                row.cells[6].childNodes[0].value = pass_arr[i]['m_adolescence'];
                row.cells[7].childNodes[0].value = pass_arr[i]['ticket_no'];
                row.cells[8].childNodes[0].value = pass_arr[i]['gds_pnr'];
                row.cells[9].childNodes[0].value = pass_arr[i]['baggage_info'];
                row.cells[10].childNodes[0].value = pass_arr[i]['main_ticket'];

								if(i!=pass_arr.length-1){
                    if(table.rows[i+1]==undefined){
                        addRow('tbl_dynamic_ticket_master');     
                    }                   
                }
            }
        }
    });
}

function display_format_modal(){
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/flight_passenger_list.csv";
}
function business_rule_load(){
	get_auto_values('booking_date','basic_cost','payment_mode','service_charge','markup','save','true','service_charge','discount');;
}
function ticket_reissue(){
  var main_ticket = document.getElementsByName("main_ticket");

  if(main_ticket[0].getAttribute('type') == "text"){
    $('input[name="main_ticket"]').attr('type','hidden');
  }
  else {
    $('input[name="main_ticket"]').attr('type','text');
  }
}
$('#frm_tab1').validate({

	rules:{

			customer_id : { required : true },

			tour_type : { required : true },

	},

	submitHandler:function(form){



        var adults = 0;

        var childrens = 0;

        var infant = 0;

		



        var msg = "";

        var table = document.getElementById("tbl_dynamic_ticket_master");

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

			  // var birth_date = row.cells[5].childNodes[0].value;

			  var adolescence = row.cells[6].childNodes[0].value;

			  var ticket_no = row.cells[7].childNodes[0].value;

        var gds_pnr = row.cells[8].childNodes[0].value;
        var baggage_info = row.cells[9].childNodes[0].value;
        var main_ticket = row.cells[10].childNodes[0].value;



			  if(adolescence=="Adult"){ adults = adults+1; }

			  if(adolescence=="Child"){ childrens = childrens+1; }

			  if(adolescence=="Infant"){ infant = infant+1; }

		  

			  

			  if(first_name==""){ msg +="First name is required in row:"+(i+1)+"<br>"; }

			  // if(birth_date==""){ msg +="Birth date is required in row:"+(i+1)+"<br>"; }

        if(adolescence==""){ msg +="Adolescence is required in row:"+(i+1)+"<br>"; }
        if(row.cells[10].childNodes[0].getAttribute('type')=="text" && main_ticket==""){ msg +="Main Ticket Number is required in row:"+(i+1)+"<br>"; }

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



		$('a[href="#tab2"]').tab('show');



	}

});

</script>