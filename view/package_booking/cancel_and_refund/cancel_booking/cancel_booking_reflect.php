<?php
include "../../../../model/model.php";
$booking_id = $_POST['booking_id'];
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12 mg_tp_10">
		<input type="checkbox" id="check_all" name="check_all" onClick="select_all_check(this.id,'traveler_names')">&nbsp;&nbsp;&nbsp;<span style="text-transform: initial;">Check All</span>
	</div>
</div>
<div class="row"> <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
<div class="table-responsive">	
	<table class="table table-bordered table-hover">
		<thead>
			<tr class="table-heading-row">
				<th>S_No.</th>
				<th>Guest_Name</th>
				<th>Cancel</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$disabled_count= 0;
			$sq_traveler = mysql_query("select * from package_travelers_details where booking_id='$booking_id'");
			while($row_traveler = mysql_fetch_assoc($sq_traveler)){
				$status = $row_traveler['status'];
				if($status=='Cancel'){
					$disable = "disabled"; 
					$row_state = "danger"; 
					$chk_state = "checked";
					++$disabled_count;
				} 
				else{ 
					$disable = ""; 
					$row_state = "";
					$chk_state = "";
				}
				?>
				<tr class="<?= $row_state ?>">

					<td><?= ++$count ?></td>

					<td><?= $row_traveler['first_name'].' '.$row_traveler['last_name'] ?></td>

					<td>

						<input type="checkbox" class="traveler_names" name="traveler_names" value="<?= $row_traveler['traveler_id'] ?>" <?= $disable ?> <?= $chk_state ?>>

					</td>

				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>
</div> </div>



<div class="row text-center">
	<input type="hidden" name="pass_count" id="pass_count" value="<?= $count ?>">
	<input type="hidden" id="disabled_count" name="disabled_count" value="<?= $disabled_count ?>">
	<div class="col-xs-12">
		<button class="btn btn-sm btn-danger ico_left" id="Cancle_btn" onclick="cancel_traveler_booking()"><i class="fa fa-ban"></i>&nbsp;&nbsp;Cancel Booking</button>
	</div>
</div>	
<div class="row mg_tp_10 text-center">
	<div class="note"><span style="color: red;line-height: 35px;" data-original-title="" title=""><?=  $cancel_feild_note ?></span></div>
</div>



<?php 

$cancel_count = mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$booking_id' and status='Cancel'"));

if($cancel_count>0){

	include_once('refund_estimate_update.php'); 	

}

?>



<script>

	$("input[type='checkbox']").labelauty({ label: false, maximum_width: "20px" });

	function cancel_traveler_booking()

	{

		var base_url = $('#base_url').val();

		var booking_id = $('#booking_id').val();



		var traveler_id_arr = new Array();

		$('input[name="traveler_names"]').each(function(){

			if($(this).is(':checked')){

				traveler_id_arr.push($(this).val());	

			}

		});


		//Validaion to select complete tour cancellation 
		var pass_count = $('#pass_count').val();
		var disabled_count = $('#disabled_count').val();
		var len = $('input[name="traveler_names"]:checked').length;
		 
		if(len!=pass_count){
			error_msg_alert('Please select all guest for cancellations.');
			 $('#Cancle_btn').button('reset');
		}
		else if(pass_count == disabled_count){
			error_msg_alert('All the Passengers have been already cancelled');
		}
		else
		{
			$('#Cancle_btn').button('loading');
			$('#vi_confirm_box').vi_confirm_box({

				callback: function(data1){

							if(data1=="yes"){



								$.ajax({

									type:'post',

									url: base_url+'controller/package_tour/cancel_and_refund/cancel_booking.php',

									data: { traveler_id_arr : traveler_id_arr, booking_id : booking_id },

									success:function(result){

										msg_alert(result);			
										 $('#Cancle_btn').button('reset');
										cancel_booking_reflect();

									}

									

								});

								

							}else{
								$('#Cancle_btn').button('reset');
							}

				}

			});

		}
	}

</script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>