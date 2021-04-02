<?php 
include "../../../model/model.php";

$email_group_id = $_POST['email_group_id'];

$sq_sms_group_info = mysql_fetch_assoc(mysql_query("select * from email_group_master where email_group_id='$email_group_id'"));
?>
<div class="modal fade" id="email_group_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Email ID Group</h4>
      </div>
      <div class="modal-body">

		<form id="frm_email_group_update">

		<input type="hidden" id="email_group_id1" name="email_group_id" value="<?= $email_group_id ?>">

      	<div class="row">
      		<div class="col-md-6">
      			<input type="text" id="email_group_name1" onchange="validate_specialChar(this.id)" name="email_group_name1" value="<?= $sq_sms_group_info['email_group_name'] ?>" placeholder="Email ID group" title="Email ID group">
      		</div>
      		<div class="col-md-6">
      			<button class="btn btn-sm btn-success" id="update_loading"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Edit</button>
      		</div>
      	</div>

      	</form>
        
      </div>      
    </div>
  </div>
</div>

<script>
$('#email_group_update_modal').modal('show');

$(function(){
  $('#frm_email_group_update').validate({
    rules:{ 
        email_group_id : { required:true },
        email_group_name1 : { required:true }
    },
    submitHandler:function(form){

      var email_group_id = $('#email_group_id1').val();
      var email_group_name = $('#email_group_name1').val();
      var base_url = $('#base_url').val();

      $('#update_loading').button('loading');
      $.ajax({
        type:'post',
        url:base_url+'controller/promotional_email/email_group/email_group_update.php',
        data: { email_group_id : email_group_id, email_group_name : email_group_name },
        success:function(result){
          msg_alert(result);
          $('#email_group_update_modal').modal('hide');
          $('#email_group_update_modal').on('hidden.bs.modal', function () {
            $('#update_loading').button('reset');
            email_group_list_reflect();
		  });
        }
      });

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>