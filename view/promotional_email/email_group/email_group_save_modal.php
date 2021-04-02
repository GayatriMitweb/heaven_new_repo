<div class="modal fade" id="email_group_save_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Email ID Group</h4>
      </div>
      <div class="modal-body">

		<form id="frm_email_group_save">

      	<div class="row">
      		<div class="col-md-6">
      			<input type="text" id="email_group_name" onchange="validate_specialChar(this.id)" name="email_group_name" placeholder="*Email ID Group Name" title="Email ID Group Name">
      		</div>
      		<div class="col-md-6">
      			<button class="btn btn-sm btn-success" id="save_loading"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
      		</div>
      	</div>

      	</form>
        
      </div>      
    </div>
  </div>
</div>

<script>
$(function(){
  $('#frm_email_group_save').validate({
    rules:{ 
        email_group_name : { required:true }
    },
    submitHandler:function(form){

      var email_group_name = $('#email_group_name').val();
      var base_url = $('#base_url').val();

      $('#save_loading').button('loading');
      
      $.ajax({
        type:'post',
        url:base_url+'controller/promotional_email/email_group/email_group_save.php',
        data: { email_group_name : email_group_name },
        success:function(result){
          msg_alert(result);
          reset_form('frm_email_group_save');
          email_group_list_reflect();
          $('#save_loading').button('reset');
          $('#email_group_save_modal').modal('hide');
        }
      });

    }
  });
});
</script>