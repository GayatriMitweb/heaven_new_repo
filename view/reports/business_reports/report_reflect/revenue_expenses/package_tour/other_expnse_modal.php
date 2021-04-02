<?php 
include_once "../../../../../../model/model.php";
$booking_id = $_POST['booking_id'];
?>
 
<div class="modal fade" id="other_p_expense_modal" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
    		<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title text-left" id="myModalLabel">Other Expense</h4>
	        </div>
      		<div class="modal-body profile_box_padding">   	      		
				<input type="hidden" id="booking_id" value="<?= $booking_id ?>"> 
	      		<div class="row"> 
	      			<div class="col-md-6">
	      				<input type="text" name="purchase_name" id="purchase_name" placeholder="Other Expense" class="form-control" title="Other Expense" required>
	      			</div>
		      		<div class="col-md-6">
		      			<input type="text" name="purchase_amount1" id="purchase_amount1" placeholder="Amount" class="form-control" title="Amount" onchange="number_validate(this.id)" required>
		      		</div>
		      	</div>
				<div class="row text-center mg_tp_20">
		      		<div class="col-md-12">
						<button class="btn btn-success btn-sm" onclick="save_tour_estimate_expense()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
					</div>
		      	</div>
	    	</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#other_p_expense_modal').modal('show');

	function save_tour_estimate_expense()
	{
		var base_url = $('#base_url').val();
		var purchase_amount = $('#purchase_amount1').val();
		var purchase_name = $('#purchase_name').val();
		var booking_id = $('#booking_id').val();
		if(purchase_amount == ''){
			error_msg_alert("Purchase Amount required!");
			return false;			
		}
		$.ajax({
			type:'post',
			url: base_url+'controller/tour_estimate/package_tour_estimate_expense_save.php',
			data:{ purchase_amount : purchase_amount,booking_id : booking_id,purchase_name : purchase_name},
			success:function(result){
				$('#other_p_expense_modal').modal('hide');
				
				$(document.body).removeClass("modal-open");
				$(".modal-backdrop").remove();

				msg_alert(result);
				package_tour_expense_save_reflect();
			}
		});
	}
</script>