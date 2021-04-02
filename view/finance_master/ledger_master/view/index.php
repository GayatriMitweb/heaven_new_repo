<?php 
include "../../../../model/model.php";

/*======******Header******=======*/
include_once('../../../layouts/fullwidth_app_header.php');
 
$ledger_id = $_GET['ledger_id'];
$financial_year_id = $_SESSION['financial_year_id']; 
$branch_admin_id = $_SESSION['branch_admin_id']; 

$sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$ledger_id'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Online Booking</title>	

	<?php admin_header_scripts(); ?>

</head>
 
<input type="hidden" id="base_url" name="base_url" value="<?= BASE_URL ?>">
<input type="hidden" id="ledger_id" name="ledger_id" value="<?= $ledger_id ?>">
<input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>">
<input type="hidden" id="branch_admin_id" name="branch_admin_id" value="<?= $branch_admin_id ?>">

<div class="container">
	<h5 class="booking-section-heading text-center main_block"><?= $sq_ledger['ledger_name'] ?></h5>
	<div class="main_block mg_bt_20 app_panel">
	<div class="app_panel_content Filter-panel" style="margin: 0 !important;  width: 100% !important;">
	  <div class="row">
			<div class="col-md-4">
				<input type="text" id="lfrom_date_filter" name="lfrom_date_filter" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'lto_date_filter');">
			</div>
			<div class="col-md-4">
				<input type="text" id="lto_date_filter" name="lto_date_filter" placeholder="To Date" title="To Date">
			</div>
	    <div class="col-md-3 text-left">
	          <button class="btn btn-sm btn-info ico_right"  onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
	    </div>
	  </div>
	</div>
	</div>
		<div class="row">
			<div class="col-md-2">
				<p>Include: </p>
			</div>
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-3">
						<input type="checkbox" id="chk_opnbalance" name="chk_opnbalance" onclick="list_reflect()" checked><label for="chk_opnbalance">&nbsp;&nbsp;Opening Balance</label>
					</div>
					<div class="col-md-3">
						<input type="checkbox" id="chk_trans" name="chk_trans" onclick="list_reflect()"><label for="chk_trans">&nbsp;&nbsp;Fortnightly Clubing</label>
					</div>
				</div>
			</div>
			<div class="col-md-1 text-right">
				<button class="btn btn-pdf btn-sm mg_bt_10" onclick="excel_report()" id="print_button" title="Print PDF"><i class="fa fa-print"></i></button>
			</div>
		</div>
	<div id="div_list_content">
	</div>
</div>
<div id="div_list_content1">
</div>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
$('#lfrom_date_filter, #lto_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
function getdatechunk(from_date,to_date) {

	let dateChunk = [];
	var tt = from_date.split('-');
	var d = new Date(tt[2],tt[1]-1,tt[0]);
	var tt1 = to_date.split('-');
	var d1 = new Date(tt1[2],tt1[1]-1,tt1[0]);
	
	var from_date_ms = d.getTime();
	var to_date_ms = d1.getTime();

	if(from_date_ms>to_date_ms){ //Invalid date range
		return [];
	}
	else if (from_date_ms === to_date_ms){  //Same From-To date

		var tempFromDate = from_date.split('-');
		var fortnight = (tempFromDate[0] <= 15) ? '1st' : '2nd';
		return [{
			i:1,
			fromDate:from_date,
			toDate:to_date,
			fortnight:fortnight
		}];
	}
	else{
		var chunkNo = 1;
		while(from_date_ms<=to_date_ms){

			var fDate = from_date.split('-');
			var d = new Date(fDate[2],fDate[1]-1,fDate[0]);
			var tDate = to_date.split('-');
			var d1 = new Date(tDate[2],tDate[1]-1,tDate[0]);

			if(fDate[0] <= 15){
				var day_to_add = 15 - fDate[0];
				var nextDate = parseInt(15) + '-' + (fDate[1]) + '-' + fDate[2];
			}else{
				var lastday = new Date(fDate[2], fDate[1], 0).getDate();
				var nextDate = lastday + '-' + (fDate[1]) + '-' + fDate[2];
			}
			var tempFromDate = nextDate.split('-');
			var fortnight = (tempFromDate[0] <= 15) ? '1st' : '2nd';
			dateChunk.push({
				i:chunkNo,
				fromDate:from_date,
				toDate:nextDate,
				fortnight:fortnight
			});

			tempFromDate = new Date(tempFromDate[2],tempFromDate[1]-1,tempFromDate[0]).getTime();
			if(tempFromDate>to_date_ms){
				return dateChunk;
			}
			else{
				var tomorrow = new Date(tempFromDate+ 86400000);
				var dd1 = tomorrow.getDate();
				var mm1 = tomorrow.getMonth() + 1;
				var y1 = tomorrow.getFullYear();

				tomorrow = dd1 + '-' + mm1 + '-' + y1;
				from_date = tomorrow;
				tomorrow = tomorrow.split('-');
				from_date_ms = new Date(tomorrow[2],tomorrow[1]-1,tomorrow[0]).getTime();
			}
			chunkNo++;
		} //while close
		return dateChunk;
	}
	return [];
}
function list_reflect()
{
	var from_date_filter = $('#lfrom_date_filter').val();
	var to_date_filter = $('#lto_date_filter').val();
	var ledger_id = $('#ledger_id').val();
	var base_url = $('#base_url').val();
	var financial_year_id = $('#financial_year_id').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var chk_opnbalance = $('input[name="chk_opnbalance"]:checked').length;
	var chk_trans = $('input[name="chk_trans"]:checked').length;
	var dateChunk = null;
	if(chk_trans == 1){
		if(from_date_filter == '' || to_date_filter == ''){
			document.getElementById("chk_trans").checked = true;
			error_msg_alert('Select From-To Date!'); return false;
		}
		dateChunk = getdatechunk(from_date_filter,to_date_filter);
	}
	$.post(base_url+'view/finance_master/ledger_master/view/list_reflect.php', {ledger_id : ledger_id, from_date_filter : from_date_filter , to_date_filter : to_date_filter,financial_year_id : financial_year_id,branch_admin_id : branch_admin_id,chk_opnbalance:chk_opnbalance,chk_trans:chk_trans,dateChunk:dateChunk}, function(data){
        $('#div_list_content').html(data);
        
    });
}
list_reflect();

function show_history(module_entry_id,module_name,finance_transaction_id,payment_perticular,ledger_name)
{
	var base_url = $('#base_url').val();
	$.post(base_url+'view/finance_master/ledger_master/view/display_history.php', {module_entry_id : module_entry_id, module_name : module_name , finance_transaction_id : finance_transaction_id, payment_perticular : payment_perticular,ledger_name : ledger_name}, function(data){
        $('#div_list_content1').html(data);        
    });
}

function financial_from_date_v(from_date)
{	
   var from_date = $('#'+from_date).val();
   var financial_year_id = $('#financial_year_id').val();
   var base_url = $('#base_url').val();

   $.post(base_url+'view/finance_master/ledger_master/view/date_validation.php', {from_date : from_date,financial_year_id : financial_year_id}, function(data){
  
        if(data == '0'){
        	error_msg_alert("Date should be between Financial Year"); return false; }
        else{        		

        }
    });
}
function excel_report(){
	var base_url = $('#base_url').val();
	var from_date = $('#lfrom_date_filter').val();
	var to_date = $('#lto_date_filter').val();
	var ledger_id = $('#ledger_id').val();
	var financial_year_id = $('#financial_year_id').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var chk_opnbalance = $('input[name="chk_opnbalance"]:checked').length;
	var chk_trans = $('input[name="chk_trans"]:checked').length;
	var dateChunk = null;
	if(chk_trans == 1){
		if(from_date == '' || to_date == ''){
			document.getElementById("chk_trans").checked = true;
			error_msg_alert('Select From-To Date!'); return false;
		}
		dateChunk = getdatechunk(from_date,to_date);
		dateChunk = JSON.stringify(dateChunk);
	}
	$('#print_button').button('loading');
	$.post(base_url+'view/finance_master/ledger_master/view/excel_report.php',{ from_date : from_date, to_date : to_date,ledger_id :ledger_id, financial_year_id : financial_year_id,branch_admin_id : branch_admin_id,chk_opnbalance:chk_opnbalance,chk_trans:chk_trans,dateChunk:dateChunk }, function(data){
		$('#print_button').button('reset');
		$('#div_list_content1').html(data);
	});
}
</script>
<?php
/*======******Footer******=======*/
include_once('../../../layouts/fullwidth_app_footer.php');
?>