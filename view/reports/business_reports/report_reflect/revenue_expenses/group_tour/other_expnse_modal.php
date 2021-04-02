<?php 
include_once "../../../../../../model/model.php";
$tour_id = $_POST['tour_id'];
$tour_group_id = $_POST['tour_group_id'];
?>
 
<div class="modal fade" id="other_expense_modal_s" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
    		<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title text-left" id="myModalLabel">Other Expense</h4>
	        </div>
      		<div class="modal-body profile_box_padding">   	      		
				<input type="hidden" id="tour_id" value="<?= $tour_id ?>">
				<input type="hidden" id="tour_group_id" value="<?= $tour_group_id ?>">  
	      		<div class="row"> 
	      			<div class="col-md-6">
	      				<input type="text" name="purchase_name" id="purchase_name" placeholder="Other Expense" class="form-control" title="Other Expense" required>
	      			</div>
		      		<div class="col-md-6">
		      			<input type="text" name="purchase_amount" id="purchase_amount" placeholder="Amount" class="form-control" title="Amount" onchange="number_validate(this.id)" required>
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
	$('#other_expense_modal_s').modal('show');

	function save_tour_estimate_expense()
	{
		var base_url = $('#base_url').val();
		var purchase_amount = $('#purchase_amount').val();
		var purchase_name = $('#purchase_name').val();
		var tour_id = $('#tour_id').val();
		var tour_group_id = $('#tour_group_id').val();
		if(purchase_amount == ''){
			error_msg_alert("Purchase Amount required!");
			return false;			
		}
		$.ajax({
			type:'post',
			url: base_url+'controller/tour_estimate/group_tour_estimate_expense_save.php',
			data:{ purchase_amount : purchase_amount,tour_id : tour_id, tour_group_id : tour_group_id, purchase_name : purchase_name},
			success:function(result){
				$('#other_expense_modal_s').modal('hide');
				
				$(document.body).removeClass("modal-open");
				$(".modal-backdrop").remove();

				msg_alert(result);
				group_tour_expense_save_reflect();
				group_tour_widget();
			}
		});
	}
</script>