<?php
include "../../../../../../model/model.php";
$role = $_SESSION['role'];
$from_date = $_SESSION['from_date'] ;
$to_date = $_SESSION['to_date'];
 
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
	<div class="app_panel">
	<div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3 col-sm-4 mg_bt_10_sm_xs">
			    <input type="text" id="from_date" name="from_date" class="form-control" placeholder="*From Date" title="From Date">
			</div>
			<div class="col-md-3 col-sm-4 mg_bt_10_sm_xs">
			    <input type="text" id="to_date" name="to_date" class="form-control" placeholder="*To Date" title="To Date">
			</div>		
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
				<button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
			</div>
		</div>
	</div>
<div class="app_panel_content">
	<div class="row">
		<div class="col-md-12">
		<div id="div_list" class="main_block loader_parent"></div>
		</div>
	</div>
</div>

<script>
$('#customer_id').select2();
$( "#from_date, #to_date" ).datetimepicker({ timepicker:false, format:'d-m-Y' });        
function list_reflect()
{
  $('#div_report').append('<div class="loader"></div>');
  var from_date = $("#from_date").val();  
  var to_date = $("#to_date").val(); 
  var branch_status = $('#branch_status').val();

  if(from_date == ''){ error_msg_alert("Select From date"); return false; }
  if(to_date == ''){ error_msg_alert("Select To date"); return false; }

  $.get( "report_reflect/sales_projection/budget/list_reflect.php" , { from_date : from_date, to_date : to_date, branch_status : branch_status } , function ( data ) {
        $ ("#div_list").html( data ) ;
  } ) ; 
}
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>