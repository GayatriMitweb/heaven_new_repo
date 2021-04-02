
<div class="modal fade" id="mobile_no_save_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Mobile No</h4>
      </div>
      <div class="modal-body">

		<form id="frm_mobile_no_save">

      	<div class="row">
      		<div class="col-md-6">
      			<input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="*Mobile Number" onchange="mobile_validate(this.id);" title="Mobile Number">
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
  $('#frm_mobile_no_save').validate({
    rules:{ 
        mobile_no : { required:true }
    },
    submitHandler:function(form){

      var mobile_no = $('#mobile_no').val();
      var base_url = $('#base_url').val();

      $.ajax({
        type:'post',
        url:base_url+'controller/promotional_sms/mobile_no/mobile_no_save.php',
        data: { mobile_no : mobile_no },
        success:function(result){
          msg_alert(result);
          reset_form('frm_mobile_no_save');
          mobile_list_reflect(20,0);
          $('#mobile_no_save_modal').modal('hide');
        }
      });

    }
  });
});
</script>