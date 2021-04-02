<?php 
$followup_status = $_POST['followup_status']; ?>
<option value="">*Type</option>
<?php if($followup_status=='Active'||$followup_status=='In-Followup'){  ?>
	<option value="Had Call-Chat">Had Call-Chat</option>
	<option value="Had Text Msg">Had Text Msg</option>
	<option value="Had Whats App Chat">Had Whats App Chat</option>		
	<option value="Phone Off">Phone Off</option>	
	<option value="Call Later">Call Later</option>	
	<option value="Call Engage">Call Engage</option>
	<option value="Quotation Sent">Quotation Sent</option>
	<option value="Revised Quotation Sent">Revised Quotation Sent</option>
	<option value="Tour Postponed">Tour Postponed</option>
	<script>
	$('#followup_stage').removeClass('hidden');
	$('#followup_date').removeClass('hidden');
	</script>
<?php } 
elseif($followup_status=='Converted'){  ?>
	<option value="Advance Received">Advance Received</option>
	<option value="Cancel & Refund">Cancel & Refund</option>
	<script>
	$('#followup_stage').addClass('hidden');
	$('#followup_date').removeClass('hidden');
	</script>
<?php } 
else{  ?>
    <option value="Booked with Others">Booked with Others</option>
	<option value="Not Interested">Not Interested</option>
	<option value="Cancelled">Cancelled</option>
	<option value="Higher pricing">Higher pricing</option>
	<option value="Out off requirements">Out off requirements</option>
	<script>
	$('#followup_stage').addClass('hidden');
	$('#followup_date').addClass('hidden');
	</script>
<?php } ?>
