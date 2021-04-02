<?php
include "../../../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
<div class="row">
	
<div class="row">
	<div class="col-md-12 col-xs-12">
	<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
		<select id="booking_id" name="booking_id" style="width:100%" title="Select Booking" onchange="refund_booking_reflect();"> 
		    <option value="">Select Booking</option>
		    <?php 
		        $sq_booking = mysql_query("select * from package_tour_booking_master order by booking_id desc");
		        while($row_booking = mysql_fetch_assoc($sq_booking)){
		            $sq_traveler = mysql_query("select m_honorific, first_name, last_name from package_travelers_details where booking_id='$row_booking[booking_id]' and status='Cancel'");
		            $date = $row_booking['booking_date'];
			         $yr = explode("-", $date);
			         $year =$yr[0];
		            while($row_traveler = mysql_fetch_assoc($sq_traveler)){
		             ?>
		             <option value="<?php echo $row_booking['booking_id'] ?>"><?php echo get_package_booking_id($row_booking['booking_id'],$year)."-".$row_traveler['m_honorific']." ".$row_traveler['first_name']." ".$row_traveler['last_name']; ?></option>
		             <?php    
		            }
		        }  
		     ?>
		</select>
	</div>
	</div>
</div>
</div>

</div>
<div id="div_cancel_booking_reflect" class="mg_tp_10"></div>
<script>
	$("#booking_id").select2();
	//$('#frm_refund_booking').validate();
	function refund_booking_reflect(){
		var booking_id = $("#booking_id").val();
		if(booking_id!=''){
			$.post('../refund/refund_booking.php', { booking_id : booking_id }, function(data){
				$('#div_cancel_booking_reflect').html(data);
			});
		}else{
			$('#div_cancel_booking_reflect').html('');
		}
	}
	// function validate_submit()
	// {
	//     var tourwise_traveler_id = $("#booking_id").val();

	//     if(tourwise_traveler_id=="")
	//     {
	//         error_msg_alert("Please select Booking ID.");
	//         return false;
	//     }
	    
	// }
</script>