<?php 
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status']; 
?>
<form id="frm_tab1">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="customer_id" id="customer_id" class="customer_dropdown" title="Customer Name" style="width:100%" onchange="customer_info_load();" disabled>
				<?php 
				$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_ticket[customer_id]'"));
				if($sq_customer['type']=='Corporate'){
				?>
					<option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['company_name'] ?></option>
				<?php }  else{ ?>
					<option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
				<?php } ?>
				<?php get_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
			</select>
			<script>
				customer_info_load();
			</script>
		</div>	
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="mobile_no" name="mobile_no" placeholder="Mobile No" title="Mobile No" readonly>
	    </div>
	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="email_id" name="email_id" placeholder="Email ID" title="Email ID" readonly>
	    </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
          <input type="text" id="company_name" class="hidden" name="company_name" title="Company Name" placeholder="Company Name" title="Company Name" readonly>
        </div>
	</div>
	<div class="row">
	    <div class="col-md-3 col-sm-6 col-xs-12">
	      <select name="tour_type" id="tour_type" title="Travelling Type">
	      	<option value="<?= $sq_ticket['tour_type'] ?>"><?= $sq_ticket['tour_type'] ?></option>
	      	<option value="">Travelling Type</option>
	      	<option value="Domestic">Domestic</option>
	      	<option value="International">International</option>
	      </select>
	    </div>	        		                			        		        	        		
	</div>
	<div class="row mg_tp_10">
      <div class="col-md-4">
        <input id="reissue_check" name="reissue_check" type="checkbox" <?= ($sq_ticket['ticket_reissue']) ? "checked" : "" ?>  disabled>
        &nbsp;&nbsp;<label for="reissue_check">Reissue Ticket</label>
      </div>
    </div>
	<hr>      		        	
	<div class="panel panel-default panel-body app_panel_style feildset-panel">
         <legend>Quotation Details</legend>
          <div class="row">
            <div class="col-md-4">
			<?php
				$customer_name = mysql_fetch_assoc(mysql_query("SELECT * FROM `flight_quotation_master` WHERE quotation_id = ".$sq_ticket['quotation_id']));
			?>
			<select name="quotation_id" id="quotation_id" style="width:100%" class="form-control" disabled>
			<?php
				if($sq_ticket['quotation_id'] == ''){
			?>
				<option>Quotation Not selected</option>
			<?php
			}
			?>
			<option value="<?= $sq_ticket['quotation_id'] ?>"><?= get_quotation_id($sq_ticket['quotation_id'] )." ".$customer_name['customer_name'] ?></option>
			</select>
              </div>
          </div>
        </div>
	<h3 class="editor_title">Passenger Details</h3>
	<div class="panel panel-default panel-body app_panel_style">
		<div class="row mg_bt_10">
			<div class="col-sm-6 col-xs-12 mg_bt_10_xs">
		    </div>
		    <div class="col-sm-6 col-xs-12 text-right">
		        <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_ticket_master')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
		    </div>
		</div>    

		<div class="row">
		    <div class="col-xs-12">
		        <div class="table-responsive">
		        <?php $offset = "_u"; ?>
		        <table id="tbl_dynamic_ticket_master" name="tbl_dynamic_ticket_master" class="table no-marg">
		           <?php include_once('ticket_master_tbl.php'); ?>                        
		        </table>
		        </div>
		    </div>
		</div>
	</div>   
	
	<div class="row text-center mg_pt_20">
		<div class="col-xs-12">
			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</form>

<script>
$('#frm_tab1').validate({
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
        var table = document.getElementById("tbl_dynamic_ticket_master");
        var rowCount = table.rows.length;
        
        for(var i=0; i<rowCount; i++)
        {
          var row = table.rows[i];
           
          if(row.cells[0].childNodes[0].checked)
          {

			  var first_name = row.cells[2].childNodes[0].value;
			  var middle_name = row.cells[3].childNodes[0].value;
			  var last_name = row.cells[4].childNodes[0].value;
			//   var birth_date = row.cells[5].childNodes[0].value;
			  var adolescence = row.cells[6].childNodes[0].value;
			  var ticket_no = row.cells[7].childNodes[0].value;
			  var gds_pnr = row.cells[8].childNodes[0].value;

			  if(adolescence=="Adult"){ adults = adults+1; }
			  if(adolescence=="Child"){ childrens = childrens+1; }
			  if(adolescence=="Infant"){ infant = infant+1; }
			  if(first_name==""){ msg +="First name is required in row:"+(i+1)+"<br>"; }
			//   if(birth_date==""){ msg +="Birth date is required in row:"+(i+1)+"<br>"; }
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
		calculate_total_amount('basic_cost');

		$('a[href="#tab2"]').tab('show');

	}
});
</script>