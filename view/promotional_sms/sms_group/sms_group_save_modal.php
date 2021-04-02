 
<div class="modal fade" id="sms_group_save_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New SMS Group</h4>
      </div>
      <div class="modal-body">

		<form id="frm_sms_group_save">

      	<div class="row">
      		<div class="col-md-6">
      			<input type="text" id="sms_group_name" name="sms_group_name" onchange="validate_spaces(this.id); validate_specialChar(this.id);" placeholder="*SMS Group Name" title="SMS Group Name">
      		</div>
      		<div class="col-md-6">
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
  $('#frm_sms_group_save').validate({
    rules:{ 
        sms_group_name : { required:true }
    },
    submitHandler:function(form){

      var sms_group_name = $('#sms_group_name').val();
      var base_url = $('#base_url').val();

      $.ajax({
        type:'post',
        url:base_url+'controller/promotional_sms/sms_group/sms_group_save.php',
        data: { sms_group_name : sms_group_name },
        success:function(result){
          msg_alert(result);
          reset_form('frm_sms_group_save');
          sms_group_list_reflect();
          $('#sms_group_save_modal').modal('hide');
        }
      });

    }
  });
});
</script>