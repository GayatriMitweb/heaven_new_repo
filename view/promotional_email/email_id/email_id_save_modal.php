<div class="modal fade" id="email_id_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Email ID</h4>
      </div>
      <div class="modal-body">

		<form id="frm_email_id_save">

      	<div class="row">
      		<div class="col-md-6">
      			<input type="text" id="email_id1" name="email_id1" class="form-control" placeholder="*Email ID" title="Email ID">
      		</div>
      		<div class="col-md-6">
      			<button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
      		</div>
      	</div>

      	</form>
        
      </div>      
    </div>
  </div>
</div>

<script>
$(function(){
  $('#frm_email_id_save').validate({
    rules:{ 
        email_id1 : { required:true }
    },
    submitHandler:function(form){

      var email_id1 = $('#email_id1').val();
      var base_url = $('#base_url').val();
      $('#btn_save').button('loading');
      $.ajax({
        type:'post',
        url:base_url+'controller/promotional_email/email_id/email_id_save.php',
        data: { email_id : email_id1 },
        success:function(result){
          msg_alert(result);
          $('#btn_save').button('reset');
          reset_form('frm_email_id_save');
          email_id_list_reflect();
          $('#email_id_save_modal').modal('hide');
        }
      });

    }
  });
});
</script>