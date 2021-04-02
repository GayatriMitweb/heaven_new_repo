<?php 
include "../../../../../model/model.php";
?>
<input type="hidden" id="unique_timestamp" name="unique_timestamp" value="<?= md5(time()) ?>">
<input type="hidden" id="flight_sc" name="flight_sc">
<input type="hidden" id="flight_markup" name="flight_markup">
<input type="hidden" id="flight_taxes" name="flight_taxes">
<input type="hidden" id="flight_markup_taxes" name="flight_markup_taxes">
<input type="hidden" id="flight_tds" name="flight_tds">

<div class="modal fade" id="pnr_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" style="width:90%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">PNR Invoice</h4>
      </div>
      <div class="modal-body">

      	<section id="sec_pnr_invoice" name="frm_pnr_invoice">

      		<div>

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			  	<li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Select GDS PNR</a></li>
			    <li role="presentation" ><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Customer Details</a></li>
			    <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">Flight Ticket</a></li>
			    <li role="presentation"><a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab">Receipt</a></li>
			    <li role="presentation"><a href="#tab5" aria-controls="tab5" role="tab" data-toggle="tab">Advance Receipt</a></li>
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
			    <div role="tabpanel" class="tab-pane" id="tab5">
			    	<?php  include_once('tab5.php'); ?>
			    </div>
			  </div>

			</div>       
	        

        </section>
      </div>  
    </div>
  </div>
</div>


<script>
$('#pnr_modal').modal({backdrop: 'static', keyboard: false});
$('#customer_id').select2();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>