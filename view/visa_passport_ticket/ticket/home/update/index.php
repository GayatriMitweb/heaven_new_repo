<?php 
include "../../../../../model/model.php";

$ticket_id = $_POST['ticket_id'];

$sq_ticket = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id='$ticket_id'"));
$reflections = json_decode($sq_ticket['reflections']);
?>
<input type="hidden" id="ticket_id" name="ticket_id" value="<?= $sq_ticket['ticket_id'] ?>">
<input type="hidden" id="booking_id" name="booking_id" value="<?= $booking_id ?>">
<input type="hidden" id="flight_sc" name="flight_sc" value="<?php echo $reflections[0]->flight_sc ?>">
<input type="hidden" id="flight_markup" name="flight_markup" value="<?php echo $reflections[0]->flight_markup ?>">
<input type="hidden" id="flight_taxes" name="flight_taxes" value="<?php echo $reflections[0]->flight_taxes ?>">
<input type="hidden" id="flight_markup_taxes" name="flight_markup_taxes" value="<?php echo $reflections[0]->flight_markup_taxes ?>">
<input type="hidden" id="flight_tds" name="flight_tds" value="<?php echo $reflections[0]->flight_tds ?>">
<div class="modal fade" id="ticket_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" style="width:96%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Ticket</h4>
      </div>
      <div class="modal-body">

      	<section id="sec_ticket_save" name="frm_ticket_save">

      		<div>

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Customer Details</a></li>
			    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Flight Ticket</a></li>
			    <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">Receipt</a></li>
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
$('#payment_date, #due_date, #birth_date1,#booking_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#ticket_save_modal').modal({backdrop: 'static', keyboard: false});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>