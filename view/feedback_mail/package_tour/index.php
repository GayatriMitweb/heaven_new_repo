<?php
include "../../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3">
				<select id="booking_id" name="booking_id" style="width:100%"> 
	                <option value="">File Number</option>
	                <?php 
	                    $sq_booking = mysql_query("select booking_id from package_tour_booking_master order by booking_id desc");
	                    while($row_booking = mysql_fetch_assoc($sq_booking))
	                    {
	                        $sq_traveler = mysql_query("select m_honorific, first_name, last_name from package_travelers_details where booking_id='$row_booking[booking_id]' and status!='Cancel'");
	                        while($row_traveler = mysql_fetch_assoc($sq_traveler))
	                        {
	                         ?>
	                         <option value="<?php echo $row_booking['booking_id'] ?>"><?php echo "File No-".$row_booking['booking_id']."-".$row_traveler['m_honorific']." ".$row_traveler['first_name']." ".$row_traveler['last_name']; ?></option>
	                         <?php    
	                        }    
	                    }    
	                 ?>
	            </select>
			</div>
			<div class="col-md-3">
      		   <input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date" style="width:100%" class="form-control">
	      	</div>
	        <div class="col-md-3">
	          <input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date" style="width:100%" class="form-control">
	        </div>
	        <div class="col-md-3">
	          <button class="btn btn-info ico_right"  onclick="bookings_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
	        </div>
		</div>
	</div>
		
	<div id="div_bookings_reflect" class="main_block"></div>

</div>

<script>
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
	$('#booking_id').select2();
	function bookings_reflect()
	{
		var booking_id = $('#booking_id').val();
		var from_date = $('#from_date_filter').val();
		var to_date = $('to_date_filter').val();
		 
		$.post('package_tour/bookings_reflect.php', { booking_id : booking_id, from_date : from_date , to_date : to_date }, function(data){
			$('#div_bookings_reflect').html(data);
		});
	}
	bookings_reflect();
</script>