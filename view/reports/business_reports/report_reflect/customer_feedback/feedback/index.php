<?php
include "../../../../../../model/model.php";
?>

	<div class="app_panel">
	  <div class="app_panel_head">
	      <h2 class="pull-left">Customer Feedback</h2>
	      <div class="pull-right header_btn">
	        <button title="Help">
	          <a href="http://itourscloud.com/User-Manual/" target="_blank" title="Manual">
	            <i class="fa fa-info" aria-hidden="true"></i>
	          </a>
	        </button>
	      </div>
		</div>
	<div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3 col-sm-4 mg_bt_10_sm_xs">
				<select name="customer_id" id="customer_id" class="customer_dropdown" title="Customer Name" style="width:100%" onchange="list_reflect()">
		          <?php get_customer_dropdown(); ?>
		        </select>
			</div>
			<div class="col-md-3 col-sm-4 mg_bt_10_sm_xs">
			    <input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" onchange="list_reflect()">
			</div>
			<div class="col-md-3 col-sm-4 mg_bt_10_sm_xs">
			    <input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" onchange="list_reflect()">
			</div>	
		</div>
	</div>
<div class="app_panel_content">
	<div class="row">
		<div class="col-md-12">
		<div id="div_list" class="main_block"></div>
		</div>
	</div>
</div>

<script>
$('#customer_id').select2();
$( "#from_date, #to_date" ).datetimepicker({ timepicker:false, format:'d-m-Y' });        
function list_reflect()
{
  var customer_id = $('#customer_id').val();
  var from_date = $("#from_date").val();  
  var to_date = $("#to_date").val(); 

  $.get( "list_reflect.php" , { customer_id : customer_id, from_date : from_date, to_date : to_date } , function ( data ) {
        $ ("#div_list").html( data ) ;
  } ) ; 
}
list_reflect();
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>