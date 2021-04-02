<?php include "../../../../model/model.php";
$quotation_id = $_POST['quotation_id'];
?>
<input type="hidden" id="login_id" name="login_id" value="<?= $login_id ?>">
<div class="modal fade" id="send_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send Quotation</h4>
      </div>
      <div class="modal-body">
      
          <div class="row mg_tp_10 justify-content-md-center">
              <div class="col-md-8 col-sm-6 mg_bt_10">
                  <input type="text" name="email_id"  class="form-control" onchange="validate_email(this.id)" title="Backoffice Email ID" placeholder="*Backoffice Email ID" id="email_id">
              </div> 
              <div class="col-md-4">
                <button class="btn btn-success" onclick="quotation_email_send_backoffice(<?= $quotation_id ?>)" id="btn_form_send"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</button>
              </div>         
          </div>
          <div class="row text-center mg_tp_20">
             
            </div>
      
      </div>
</div>
</div>
</div>
</div>
<script>
    $('#send_modal').modal('show');
function quotation_email_send_backoffice(quotation_id)
{
	var base_url = $('#base_url').val();
	var email_id = $('#email_id').val();

	if(email_id == ''){
		error_msg_alert("Enter Backoffice Email please!"); return false;
	}
	$('#btn_form_send').button('loading');
	$.ajax({
			type:'post',
			url: base_url+'controller/package_tour/quotation/group_tour/quotation_email_send_backoffice.php',
			data:{ quotation_id : quotation_id , email_id : email_id},
			success: function(message){
                msg_alert(message);
                $('#btn_form_send').button('reset');        
                $('#send_modal').modal('hide');         	
                }  
		});

}
</script>
