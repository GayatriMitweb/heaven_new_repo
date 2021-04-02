<?php include "../../model/model.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Upload Travelers Tickets</title>

	<link rel="stylesheet" href="../../css/font-awesome-4.3.0/css/font-awesome.min.css">
	
	<script type="text/javascript" src="../../js/jquery-1.3.2.js" ></script>
	<script type="text/javascript" src="../../js/ajaxupload.3.5.js" ></script> 
	<script src="../../js/ajax.js"></script>

	<style>
	#traveler_ticket_upload_btn{background: #2289c4; width: 120px; color: #fff; padding: 10px; border-radius: 3px; cursor: pointer; float: left; margin-top:35px; }
	#traveler_id { float: left; border-radius: 3px; border: 1px solid #ddd; margin-left: 70px; margin-right: 50px; width:200px; }
	fieldset { border: 1px solid #ddd;  margin-right: -8px;  margin-left: 20px; margin-top: 20px;  padding: 10px; }
	table{ border-collapse: collapse; margin:10px;	margin-left:10px }
	table td{ border: 1px solid #ddd; padding: 10px 13px; }
	.download-btn { padding: 7px 10px;  border: 1px solid #2289c4;  color: #fff; background: #2289c4; border-radius: 3px; text-decoration: initial; font-size: 14px; }
	.delete-btn { padding: 7px 10px;  border: 1px solid #CE3E3E;  color: #fff; background: #CE3E3E; border-radius: 3px; text-decoration: initial; font-size: 14px; }
	.header { text-align: center;  background: #2289c4; color: #fff; }
	</style> 
</head>
<body>

<?php 
$booking_id = $_GET['booking_id'];
$sq_booking = mysql_fetch_assoc( mysql_query("select traveler_group_id from tourwise_traveler_details where id='$booking_id'") );
$traveler_group_id = $sq_booking['traveler_group_id'];

?>
<input type="hidden" id="txt_tourwise_traveler_id" name="txt_tourwise_traveler_id" value="<?php echo $booking_id; ?>">

<fieldset class="header"> Upload And Download Tickets </fieldset>	

<fieldset>
<legend>Upload Ticket</legend>

	<select name="traveler_id" id="traveler_id" multiple size="5">
		<?php 
			$sq_traveler = mysql_query("select * from travelers_details where traveler_group_id='$traveler_group_id' and status!='Cancel' and traveler_id not in ( select traveler_id from travelers_tickets_entries where tourwise_traveler_id='$booking_id' )");
			while($row_traveler = mysql_fetch_assoc($sq_traveler))
			{
			?>
			<option value="<?php echo $row_traveler['traveler_id']; ?>"><?php echo $row_traveler['first_name'].' '.$row_traveler['last_name']; ?></option>
			<?php	
			}
		?>
	</select>

	<div class="div-upload" id="div_traveler_ticket_upload_btn">
	    <div id="traveler_ticket_upload_btn" class="upload-button"><span><i class="fa fa-upload"></i>&nbsp;&nbsp;Upload Ticket</span></div><span id="traveler_ticket_upload_status" ></span>
	    <ul id="files" ></ul>
	    <input type="hidden" id="txt_traveler_ticket_upload_url" name="txt_traveler_ticket_upload_url">
	</div> 

</fieldset>

<fieldset>
<legend>Download Ticket</legend>
	
	<table>
		<tr>
			<td>Sr. No</td>
			<td>Traveler Name</td>
			<td>Download Ticket</td>
			<td>Delete Ticket</td>
		</tr>
		<?php 
		$count = 0;
		$sq_ticket = mysql_query("select * from travelers_tickets_master where tourwise_traveler_id='$booking_id'");
		while($row_ticket = mysql_fetch_assoc($sq_ticket))
		{
			$ticket_id = $row_ticket['ticket_id'];
			$ticket_url = preg_replace('/(\/+)/','/',$row_ticket['ticket_url']);                
			$sq_ticket_entries_count = mysql_num_rows( mysql_query("select * from travelers_tickets_entries where ticket_id='$ticket_id'") );
			?>
			<?php
			$fisrt_time = true;
			$sq_ticket_entries = mysql_query("select * from travelers_tickets_entries where ticket_id='$ticket_id'");
			while($row_ticket_entries = mysql_fetch_assoc($sq_ticket_entries))
			{
				$traveler_id = $row_ticket_entries['traveler_id'];
				$sq_traveler_det = mysql_fetch_assoc(mysql_query("select m_honorific, first_name, last_name from travelers_details where traveler_id='$traveler_id'"));
				$traveler_name = $sq_traveler_det['m_honorific'].' '.$sq_traveler_det['first_name'].' '.$sq_traveler_det['last_name'];
				$count++;
			?>
			<tr>
				<td><?php echo $count; ?></td>	
				<td><?php echo $traveler_name; ?></td>
			<?php	
				if($fisrt_time==true) { $fisrt_time = false;	
					?>
					<td rowspan="<?php echo $sq_ticket_entries_count; ?>" style="text-align:center"> <a class="download-btn" href="<?php echo $ticket_url; ?>" download><i class="fa fa-download"></i>&nbsp;&nbsp;Ticket</a> </td>
					<td rowspan="<?php echo $sq_ticket_entries_count; ?>" style="text-align:center">
						<a class="delete-btn" href="" onclick="ticket_for_traveler_delete(<?php echo $ticket_id; ?>)"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</a>
					</td>
					<?php
				}
				?>
				</tr>
				<?php	
			}	

			
			?>	
			<?php
		}	
		?>
	</table>

</fieldset>






<script>

$(function(){  
    var type = "travel"; 
    var btnUpload=$('#traveler_ticket_upload_btn');
    var status=$('#traveler_ticket_upload_status');
    new AjaxUpload(btnUpload, {
      action: 'tickets_for_booking_upload_file.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

      	var travelers_arr = $('#traveler_id').val();
      	if(travelers_arr==null) { alert('Please select travelers names'); return false; }
      	var confirm_state = confirm("Are you sure you want to upload this ticket ?");
      	if(confirm_state==false){ return false; }	
        
         if (! (ext && /^(jpg|png|jpeg|gif|pdf)$/.test(ext))){          
          status.text('Only JPG, PNG or GIF files are allowed');         
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        
        status.text('');
        
        if(response==="error"){          
          alert("File is not uploaded.");           
          
        } else{        	
        	status.text('');
        	var ticket_url = response;        	
        	tickets_for_booking_upload(ticket_url);
          
        }
      }
    });
    
  });

</script>
</body>
</html>