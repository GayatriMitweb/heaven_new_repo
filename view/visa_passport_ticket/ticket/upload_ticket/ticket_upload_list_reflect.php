<?php
include "../../../../model/model.php";

$ticket_id = $_POST['ticket_id'];

if($ticket_id == ''){ 

?>
	<div class="panel panel-default panel-body pad_8 text-center">
		<h2>Select Booking Id first!</h2>
	</div>
<?php }
else{ 
$ticket_count = mysql_num_rows(mysql_query("select * from ticket_master_upload_entries where ticket_id='$ticket_id'"));
?>
<div class="main_block mg_tp_20 mg_bt_10">
	<div class="div-upload pull-right">
        <div id="ticket_upload_btn" class="upload-button1"><span>Ticket</span></div>
        <span id="id_proof_status" ></span>
        <ul id="files" ></ul>
        <input type="hidden" id="ticket_upload_url" name="ticket_upload_url">
    </div>
</div>

<?php 
if($ticket_count==0){
	?>
	<div class="panel panel-default panel-body pad_8 text-center">
	<h2>No ticket is uploaded for this booking!</h2>
	</div>
	<?php
}
else{
?>
<div class="row mg_tp_20"> <div class="col-xs-12 no-pad"> <div class="table-responsive">
	
<table class="table table-bordered table-hover text-center" id="flight_upload_ticket" style="margin: 20px 0 !important;">
	<thead>
		<tr class="active table-heading-row">
			<th class="text-center">S_No.</th>
			<th class="text-center">Uploaded_At</th>
			<th class="text-center">Download</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_tickets = mysql_query("select * from ticket_master_upload_entries where ticket_id='$ticket_id'");
		while($row_ticket = mysql_fetch_assoc($sq_tickets)){

			$url = $row_ticket['ticket_url'];
			$url = explode('uploads/', $url);
			$url = BASE_URL.'uploads/'.$url[1];
			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= date('d/m/Y', strtotime($row_ticket['created_at'])) ?></td>
				<td>
				<button class="btn btn-info btn-sm"><a href="<?= $url ?>" download title="Download ticket"><i class="fa fa-download"></i></a></button>
					
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

</div> </div> </div>
<?php
}
}
?>




<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
upload_ticket_attch();
function upload_ticket_attch()
{
    var btnUpload=$('#ticket_upload_btn');

    $(btnUpload).find('span').text('Ticket');
    $("#ticket_upload_url").val('');
    
    new AjaxUpload(btnUpload, {
      action: 'upload_ticket/upload_ticket.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){  

        if (! (ext && /^(jpg|png|jpeg|pdf)$/.test(ext))){ 
          error_msg_alert('Only PDF, JPG, PNG or GIF files are allowed');
          return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        if(response==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Ticket');
        } else{                    
          $("#ticket_upload_url").val(response);
          ticket_upload_url_save(response);
        }
      }
    });
}

function ticket_upload_url_save(ticket_url)
{
	$('#ticket_upload_btn').find('span').text('Uploaded');

	var ticket_id = $('#ticket_id_filter').val();

	var base_url = $('#base_url').val();
			
	$.ajax({
		type: 'post',
		url: base_url+'controller/visa_passport_ticket/ticket/ticket_upload_save.php',
		data:{ ticket_id : ticket_id, ticket_url : ticket_url },
		success: function(result){
			msg_alert(result);
			ticket_upload_list_reflect();
		}
	});


}
$('#flight_upload_ticket').dataTable({
	"pagingType": "full_numbers",
	createdRow: function(row, data, dataIndex){
       // Initialize custom control
       $("input[type='radio'], input[type='checkbox']").labelauty({ label: false, maximum_width: "20px" });
          // ... skipped ...
       }
});
</script>