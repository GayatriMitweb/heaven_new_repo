<?php 
include "../../../model/model.php";

$email_id_id = $_POST['email_id_id'];

$sq_email_id_info = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id='$email_id_id'"));
?>
<div class="modal fade" id="email_id_update_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Email ID</h4>
      </div>
      <div class="modal-body">

		<form id="frm_mobile_no_update">

		<input type="hidden" id="email_id_id" name="email_id_id" value="<?= $email_id_id ?>">

      	<div class="row">
      		<div class="col-md-6">
      			<input type="text" id="email_id1" name="email_id1" value="<?= $sq_email_id_info['email_id'] ?>" placeholder="Email ID" title="Email ID">
      		</div>
      		<div class="col-md-6">
      			<button class="btn btn-sm btn-success"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Update</button>
      		</div>
      	</div>

      	</form>
        
      </div>      
    </div>
  </div>
</div>

<script>
$('#email_id_update_modal').modal('show');

$(function(){
  $('#frm_mobile_no_update').validate({
    rules:{ 
        email_id1 : { required:true },
    },
    submitHandler:function(form){

      var email_id_id = $('#email_id_id').val();
      var email_id = $('#email_id1').val();
      var base_url = $('#base_url').val();

      $.ajax({
        type:'post',
        url:base_url+'controller/promotional_email/email_id/email_id_update.php',
        data: { email_id_id : email_id_id, email_id : email_id },
        success:function(result){
          msg_alert(result);
          $('#email_id_update_modal').modal('hide');
			    email_id_list_reflect(20,0);
        }
      });

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>