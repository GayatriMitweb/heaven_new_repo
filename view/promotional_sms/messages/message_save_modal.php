<div class="modal fade" id="sms_message_save_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New SMS message</h4>
      </div>
      <div class="modal-body">

		<form id="frm_sms_message_save">

      	<div class="row mg_bt_10">
      		<div class="col-md-12">
      			<textarea id="message" name="message" onchange="validate_spaces(this.id);" placeholder="*Message Text" title="Message Text"></textarea>
      		</div>
        </div>
        <div class="row text-center">
      		<div class="col-md-12">
      			<button class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
      		</div>
      	</div>

      	</form>
        
      </div>      
    </div>
  </div>
</div>

<script>
$(function(){
  $('#frm_sms_message_save').validate({
    rules:{ 
        message : { required:true, maxlength:160 }
    },
    submitHandler:function(form){

      var message = $('#message').val();
      var base_url = $('#base_url').val();

      $.ajax({
        type:'post',
        url:base_url+'controller/promotional_sms/messages/sms_message_save.php',
        data: { message : message },
        success:function(result){
          msg_alert(result);
          reset_form('frm_sms_message_save');
          sms_message_list_reflect();
          $('#sms_message_save_modal').modal('hide');
        }
      });

    }
  });
});
</script>